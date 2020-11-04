<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserLoginMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $session_id;

    /**
     * Create a new message instance.
     *
     * @param $email
     * @param $session_id
     */
    public function __construct($email, $session_id)
    {
        $this->email = $email;
        $this->session_id = $session_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.user_login')
            ->subject('Sign in activity');
    }
}
