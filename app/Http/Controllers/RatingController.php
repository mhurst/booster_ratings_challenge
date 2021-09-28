<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Reviewer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\RatingResource;
use Illuminate\Support\Facades\Mail;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showByFundraiser($id)
    {
        return RatingResource::collection(Rating::GetRatingsByFundraiser($id))
                ->additional([
                    'meta' => [
                        'success' => true,
                    ]
                ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate the name exist and is a string.        
        $validator = Validator::make($request->all(), [
            'fundraisers_id' => 'required|integer',
            'rating' => 'required|integer',
            'review' => 'required|string',
            'review_date' => 'required|date',
            'name' => 'required|string',
            'email' => 'required|email'
        ]);

        //If not return error
        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray(), 422);
        }

        //Check if reviewer exist
        $reviewer_id_exists = Reviewer::DoesReviewerExist($request->email, $request->fundraiser_id);

        if ($reviewer_id_exists) {
            $reviewer = Reviewer::where('email', '=', $request->email)->get();
            $reviewer_id = $reviewer[0]->id;

            if (!$reviewer[0]->email_verified) {
                //Validate email via email
                Reviewer::SendValidationEmail($request->email);
            }

            //If reviewer has already reviewed this fundraiser
            if (Reviewer::HasUserAlreadyReviewedFundraiser($reviewer_id, $request->fundraisers_id)) {
                return response()->json(['error' => 'This reviewer has already reviewed this fundraiser'], 422);
            }
        } else {
            $reviewer = Reviewer::Create([
                'name' => $request->name,
                'email' => $request->email
            ]);

            $reviewer_id = $reviewer->id;

            //Validate email via email
            Reviewer::SendValidationEmail($request->email);
        }

        Rating::Create([
            'fundraisers_id' => $request->fundraisers_id,
            'reviewer_id' => $reviewer_id,
            'rating' => $request->rating,
            'review' => $request->review,
            'review_date' => $request->review_date,
        ]);

        return response()->json(['status' => 'success'], 200);
    }
}
