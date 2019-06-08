<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(PostRequest $request)
    {
        $postCount = Post::where('user_id', Auth()->user()->user_id)->count();
        $commentCount = Comment::where('user_id', Auth()->user()->user_id)->count();
        return view('pages.create')->with('postCount', $postCount)
                                   ->with('commentCount', $commentCount);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Post::create($request->validated());

        $post = new Post([
            'user_id' => auth()->user()->user_id,
            'title' => $request->get('title'),
            'content' => $request->get('content'),
        ]);

        $post->save();

        return redirect()->back()->with('postAlert', "Successfully posted!");
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
        $post->viewCount++;
        $post->save();

        $users = User::get();
        $hasUpvoted = Vote::where('post_id', $id)
                        ->where('vote', '1')
                        ->where('user_id', Auth()->user()->user_id)
                        ->count();
        $hasDownvoted = Vote::where('post_id', $id)
                        ->where('vote', '0')
                        ->where('user_id', Auth()->user()->user_id)
                        ->count();
        $upvotes = Vote::where('post_id', $id)
                        ->where('vote', '1')
                        ->count();
        $downvotes = Vote::where('post_id', $id)
                        ->where('vote', '0')
                        ->count();

        $postCount = Post::where('user_id', Auth()->user()->user_id)->count();
        $commentCount = Comment::where('user_id', Auth()->user()->user_id)->count();
        return view('pages.post')->with('post',$post)
                                 ->with('users', $users)
                                 ->with('hasUpvoted', $hasUpvoted)
                                 ->with('hasDownvoted', $hasDownvoted)
                                 ->with('upvotes', $upvotes)
                                 ->with('downvotes', $downvotes)
                                 ->with('postCount', $postCount)
                                 ->with('commentCount', $commentCount);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->comments()->delete();
        $post->delete();
    }
}
