<?php

namespace App\Mail;

use App\Post;
use App\Vote;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Upvoted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->user = Auth()->user()->username;
        $this->title = $post->title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.upvoted')
                    ->with([
                        'user' => $this->user,
                        'title' => $this->title
                    ]);
    }
}
