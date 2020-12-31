<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostMail extends Mailable
{
    use Queueable, SerializesModels;

    public $postsmail;
    public $message;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($postsmail,$message)
    {
        $this->postsmail = $postsmail;
        $this->message = $message;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.postmail');
    }
}
