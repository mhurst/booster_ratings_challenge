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
        $reviewer_id = Reviewer::DoesReviewerExist($request->email, $request->fundraiser_id);

        if ($reviewer_id) {
            //If reviewer has already reviewed this fundraiser
            if (Rating::HasUserAlreadyReviewedFundraiser($reviewer_id, $request->fundraiser_id)) {
                return response()->json(['error' => 'This reviewer has already reviewed this fundraiser'], 422);
            }
        }
        

        //Check if email has been validated
        if (!Reviewer::CheckIfReviewerIsValidated($request->email)) {
            return response()->json(['error' => 'This reviewer needs to be validated'], 422);
        }

        //todo email system not sending, being blocked by google,. fix.
        //Validate email via email

         //Reviewer::SendValidationEmail();

        //If all else is good,. process the insert
        if (!$reviewer_id) {
            $reviewer = Reviewer::Create([
                'name' => $request->name,
                'email' => $request->email
            ]);

            $reviewer_id = $reviewer->id;
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
