<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyMail;

class Reviewer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email'];

    /**
     * Get the ratings for a reviewer.
     */
    public function comments()
    {
        return $this->hasMany(Reviewer::class);
    }

    public static function DoesReviewerExist($email)
    {
        //Get user id
        $user_id = Reviewer::where('email', '=', $email)->exists();

        if ($user_id) {
            return $user_id;
        }

        return false;
    }

    public static function CheckIfReviewerIsValidated($email) {
        if (!$user_id = self::DoesReviewerExist($email)) {
            return false;
        }

        if (Reviewer::where([['email_verified', '=', 1], ['id', '=', $user_id]])->exists()) {
            return true;
        }

        return false;
    }

    public static function SendValidationEmail($email)
    {
        Mail::to($email)->send(new VerifyMail($email));
    }

    public function checkVerification($token, $email)
    {
        if (Reviewer::where([['email', '=', $email],
                ['verification_token','=', $token]])->exists()) {
            
            Reviewer::where('email', '=', $email)->update(["verification_token" => '']);

            Reviewer::where('email', '=', $email)->update(["email_verified" => true]);

            $message = 'Success! Your review is now visible.';

            return $message;
        }

        $message = 'Something went wrong.';

        return $message;

    }
}
