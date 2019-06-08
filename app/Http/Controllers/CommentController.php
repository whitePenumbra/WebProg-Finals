<?php

namespace App\Http\Controllers;

use App\Comment;
use App\User;
use App\Post;
use App\Mail\Commented;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'comment' => 'required'
        ]);

        $comment = new Comment([
            'comment' => $request->get('comment'),
            'post_id' => $request->get('post_id'),
            'user_id' => Auth()->user()->id
        ]);

        $comment->save();

        $post = Post::find($comment->post_id);
        $user = User::find(Auth()->user()->id);
        Mail::to($user->email)->send(new Commented($comment, $post));
        
        return redirect()->back()->with('status','Comment posted!');
    }
}
