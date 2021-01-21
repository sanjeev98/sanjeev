<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendUserPostMail extends Mailable
{
    use Queueable, SerializesModels;

    public $posts;
    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($posts, $message)
    {
        $this->posts = $posts;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->markdown('emails.send_user_post_mail') ->attach(public_path('storage/files/san.pdf'), [
            'as' => 'san.pdf',
            'mime' => 'application/pdf',
        ])->attach(public_path('storage/files/pos1t.xlsx'));
    }
}
