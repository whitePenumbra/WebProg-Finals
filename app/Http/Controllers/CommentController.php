<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function addComment(Request $request, Post $post)
    {
        $this->validate($request, [
            'content' => 'required',
        ]);

        $comment = new Comment([
            'content' => $request->get('content'),
            'post_id' => $request->get('post_id'),
            'user_id' => Auth()->user()->user_id,
        ]);

        $post->comments()->save($comment);

        if($comment->user_id!=$post->user_id){
            $user = User::where('user_id', $post->user_id)->first();
            Mail::to($user->email)->send(new Commented($comment, $post));
        }
        return back()->withMessage('Comment posted!');
    }
}
