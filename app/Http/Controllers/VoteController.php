<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Upvoted;
use App\Vote;
use App\Post;

class VoteController extends Controller
{
    public function upvote($id)
    {        
        $hasUpvote = Vote::where('user_id', Auth()->user()->id)
                         ->where('post_id', $id)
                         ->where('vote', '1')
                         ->count();
        $hasDownvote = Vote::where('user_id', Auth()->user()->id)
                            ->where('post_id', $id)
                            ->where('vote', '0')
                            ->count();

        if($hasUpvote==1){
            $removeUp =  Vote::where('user_id', Auth()->user()->id)
                             ->where('post_id', $id)
                             ->where('vote', '1')
                             ->first();
            $removeUp->delete();

            $upvoteCt = Vote::where('post_id', $id)
                            ->where('vote', '1')
                            ->count();

            $post = Post::find($id);
            $post->upvotes = $upvoteCt;
            $post->save();

            return redirect()->back();
        }
        else {
            $post = Post::find($id);

            if($hasDownvote==1){
                $removeDown =  Vote::where('user_id', Auth()->user()->id)
                                ->where('post_id', $id)
                                ->where('vote', '0')
                                ->first();
                $removeDown->vote = '1';
                $removeDown->save();

                if($removeDown->user_id!=$post->user_id){
                    $user = User::find(Auth()->user()->id);
                    Mail::to($user->email)->send(new Upvoted($post));
                }
            }
            else {
                $createUpvote = new Vote ([
                                'user_id' => Auth()->user()->id,
                                'post_id' => $id,
                                'vote' => '1'
                ]);
                $createUpvote->save();  
                
                if($createUpvote->user_id!=$post->user_id){
                    $user = User::find(Auth()->user()->id);
                    Mail::to($user->email)->send(new Upvoted($post));
                }
            }

            $upvoteCt = Vote::where('post_id', $id)
                            ->where('vote', '1')
                            ->count();

            $downvoteCt = Vote::where('post_id', $id)
                                ->where('vote', '0')
                                ->count();

            $post = Post::find($id);
            $post->upvotes = $upvoteCt;
            $post->downvotes = $downvoteCt;
            $post->save();
            
            return redirect()->back();
        }
    }

    public function downvote($id)
    {
        $hasUpvote = Vote::where('user_id', Auth()->user()->id)
                        ->where('post_id', $id)
                        ->where('vote', '1')
                        ->count();
        $hasDownvote = Vote::where('user_id', Auth()->user()->id)
                            ->where('post_id', $id)
                            ->where('vote', '0')
                            ->count();

        if($hasDownvote==1){
            $removeDown =  Vote::where('user_id', Auth()->user()->id)
                                ->where('post_id', $id)
                                ->where('vote', '0')
                                ->first();
            $removeDown->delete();
            
            $downvoteCt = Vote::where('post_id', $id)
                            ->where('vote', '0')
                            ->count();

            $post = Post::find($id);
            $post->downvotes = $downvoteCt;
            $post->save();

            return redirect()->back();
        }
        else {
            if($hasUpvote==1){
                $removeUp =  Vote::where('user_id', Auth()->user()->id)
                                ->where('post_id', $id)
                                ->where('vote', '1')
                                ->first();
                $removeUp->vote = '0';
                $removeUp->save();
            }
            else {
            $createDownvote = new Vote ([
                            'user_id' => Auth()->user()->id,
                            'post_id' => $id,
                            'vote' => '0'
            ]);
            $createDownvote->save();
            }

            $downvoteCt = Vote::where('post_id', $id)
                            ->where('vote', '0')
                            ->count();

            $upvoteCt = Vote::where('post_id', $id)
                            ->where('vote', '1')
                            ->count();

            $downvoteCt = Vote::where('post_id', $id)
                                ->where('vote', '0')
                                ->count();

            $post = Post::find($id);
            $post->upvotes = $upvoteCt;
            $post->downvotes = $downvoteCt;
            $post->save();

            return redirect()->back();
        }
    }
}
