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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($postsmail)
    {
        $this->postsmail = $postsmail;

    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->markdown('emails.postmail') ->attach(public_path('storage/files/san.pdf'), [
            'as' => 'san.pdf',
            'mime' => 'application/pdf',
        ])->attach(public_path('storage/files/pos1t.xlsx'));
    }
}
