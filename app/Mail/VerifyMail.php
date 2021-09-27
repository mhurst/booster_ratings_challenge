<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyMail extends Mailable
{
    use Queueable, SerializesModels;

    private $verify_token; 

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $n = 64;
        $this->verify_token = bin2hex(random_bytes($n));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('verify_email');
    }
}
