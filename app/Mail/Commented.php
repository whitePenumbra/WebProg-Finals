<?php

namespace App\Mail;

use App\Comment;
use App\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Commented extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $comment, Post $post)
    {
        $this->user = Auth()->user()->username;
        $this->post = $post->title;
        $this->comment = $comment->comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.commented')
                    ->with([
                        'user' => $this->user,
                        'post' => $this->post,
                        'comment' => $this->comment
                    ]);
    }
}
