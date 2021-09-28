<?php

namespace App\Http\Controllers;

use App\Models\Reviewer;
use Illuminate\Http\Request;

class ReviewerController extends Controller
{
    public function verifyToken($token, $email)
    {
        $reviewer = new Reviewer();
        $message = $reviewer->checkVerification($token, $email);

        return view('verifyuser', ['message' => $message]);
    }
}
