<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use App\Comment;
use App\Vote;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'photo' => 'nullable|image'
        ]);

        if($request->has('photo')){
            $filename = $request->get('title').auth()->user()->id.'-photo.'.request()->photo->getClientOriginalExtension();
            request()->photo->move(public_path('postimages'), $filename);
        } else {
            $filename = NULL;
        }

        $post = new Post([
            'user_id' => auth()->user()->id,
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'photo' => $filename
        ]);

        $post->save();

        return redirect()->route('home')->with('status', "Successfully posted!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $users = User::all();
        $upvoted = Vote::where('post_id', $id)
                        ->where('vote', '1')
                        ->where('user_id', Auth()->user()->id)
                        ->count();
        $downvoted = Vote::where('post_id', $id)
                        ->where('vote', '0')
                        ->where('user_id', Auth()->user()->id)
                        ->count();
        $upvotes = Vote::where('post_id', $id)
                        ->where('vote', '1')
                        ->count();
        $downvotes = Vote::where('post_id', $id)
                        ->where('vote', '0')
                        ->count();

        return view('post')->with('post',$post)
                            ->with('users', $users)
                            ->with('upvoted', $upvoted)
                            ->with('downvoted', $downvoted)
                            ->with('upvotes', $upvotes)
                            ->with('downvotes', $downvotes);
    }
}
