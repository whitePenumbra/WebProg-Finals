<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Comment;
use App\Post;
use App\Vote;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        $user = User::where('username', $username)->first();
        $comments = Comment::where('user_id', $user->id)->paginate(12);
        $userposts = Post::where('user_id', $user->id)->paginate(12);
        $posts = Post::all();
        $votes = Vote::where('user_id', $user->id)
                    ->where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(12);

        return view('profile')->with('user', $user)
                            ->with('comments', $comments)
                            ->with('userposts', $userposts)
                            ->with('posts', $posts)
                            ->with('votes', $votes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $settings = User::find(Auth()->user()->id);
        $settings->name = $request->get('name');
        $settings->email = $request->get('email');
        $settings->username = $request->get('username');

        if($request->has('profile_pic')){
            $filename = time().'-'.auth()->user()->id.'-icon.'.request()->profile_pic->getClientOriginalExtension();
            request()->profile_pic->move(public_path('userimages'), $filename);
            $settings->profile_pic = $filename;
        }

        $settings->save();

        return redirect()->to('profile/'.$settings->username)->with('status','Your account has been updated!');
    }
}
