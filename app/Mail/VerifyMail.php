<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Reviewer;

class VerifyMail extends Mailable
{
    use Queueable, SerializesModels;

    private $verify_token;
    private $id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $n = 64;
        $this->verify_token = bin2hex(random_bytes($n));
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->upDateUserVerificationToken();

        return $this->view('verify_email', ["token" => $this->verify_token, "email" => $this->email]);
    }

    public function upDateUserVerificationToken()
    {
        $reviewer = Reviewer::where('email', '=', $this->email)->update(["verification_token" => $this->verify_token]);
    }
}
