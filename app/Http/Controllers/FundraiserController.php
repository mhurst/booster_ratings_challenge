<?php

namespace App\Http\Controllers;

use App\Models\Fundraiser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\FundraiserResource;

class FundraiserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //todo sorting is not right in some way or another.
        return FundraiserResource::collection(Fundraiser::GetFundraisersWithAvgRating())
                ->additional([
                    'meta' => [
                        'success' => true,
                    ]
                ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate the name exist and is a string.        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        //If not return error
        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray(), 422);
        }

        //If fundraiser already exist by name,. return error

        if (Fundraiser::where('name', '=', $request->name)->exists()) {
            return response()->json(['error' => 'Fundraiser already exist'], 422);
        }

        //If all else is good,. process the insert
        Fundraiser::Create([
            'name' => $request->name
        ]);

        return response()->json(['status' => 'success'], 200);

    }
}
