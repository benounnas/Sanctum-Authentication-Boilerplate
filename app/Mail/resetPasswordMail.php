<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class resetPasswordMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected string $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function build()
    {
        return $this->markdown('emails.reset-password')->with([
            'token'=> $this->token
        ]);
    }
}
