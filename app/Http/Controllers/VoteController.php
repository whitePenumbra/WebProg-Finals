<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function upvote($id)
    {        
        $checkExistingUpvote = Vote::where('user_id', Auth()->user()->user_id)
                                ->where('post_id', $id)
                                ->where('vote', '1')
                                ->count();
        $checkExistingDownvote = Vote::where('user_id', Auth()->user()->user_id)
                                ->where('post_id', $id)
                                ->where('vote', '0')
                                ->count();

        if($checkExistingUpvote==1){
            $undoUpvote =  Vote::where('user_id', Auth()->user()->user_id)
                            ->where('post_id', $id)
                            ->where('vote', '1')
                            ->first();
            $undoUpvote->delete();
            
            $storeUpvotes = Vote::where('post_id', $id)
                                ->where('vote', '1')
                                ->count();

            $post = Post::find($id);
            $post->upvotes = $storeUpvotes;
            $post->save();

            return redirect()->back();
        }
        else {
            $post = Post::find($id);

            if($checkExistingDownvote==1){
                $undoDownvote =  Vote::where('user_id', Auth()->user()->user_id)
                                ->where('post_id', $id)
                                ->where('vote', '0')
                                ->first();
                $undoDownvote->vote = '1';
                $undoDownvote->save();

                if($undoDownvote->user_id!=$post->user_id){
                    $user = User::where('user_id', $post->user_id)->first();
                    Mail::to($user->email)->send(new Upvoted($undoDownvote, $post));
                }
            }
            else {
                $upvote = new Vote ([
                    'user_id' => Auth()->user()->user_id,
                    'post_id' => $id,
                    'vote' => '1'
                ]);
                $upvote->save();  
                
                if($upvote->user_id!=$post->user_id){
                    $user = User::where('user_id', $post->user_id)->first();
                    Mail::to($user->email)->send(new Upvoted($upvote, $post));
                }
            }

            $storeUpvotes = Vote::where('post_id', $id)
                                ->where('vote', '1')
                                ->count();

            $post->upvotes = $storeUpvotes;
            $post->save();
            
            return redirect()->back();
        }
    }

    public function downvote($id)
    {
        $checkExistingUpvote = Vote::where('user_id', Auth()->user()->user_id)
                                ->where('post_id', $id)
                                ->where('vote', '1')
                                ->count();
        $checkExistingDownvote = Vote::where('user_id', Auth()->user()->user_id)
                                    ->where('post_id', $id)
                                    ->where('vote', '0')
                                    ->count();

        if($checkExistingDownvote==1){
            $undoDownvote =  Vote::where('user_id', Auth()->user()->user_id)
                            ->where('post_id', $id)
                            ->where('vote', '0')
                            ->first();
            $undoDownvote->delete();

            $storeDownvotes = Vote::where('post_id', $id)
                                   ->where('vote', '0')
                                   ->count();

            $post = Post::find($id);
            $post->downvotes = $storeDownvotes;
            $post->save();
            
            return redirect()->back();
        }
        else {
            if($checkExistingUpvote==1){
                $undoUpvote =  Vote::where('user_id', Auth()->user()->user_id)
                                ->where('post_id', $id)
                                ->where('vote', '1')
                                ->first();
                $undoUpvote->vote = '0';
                $undoUpvote->save();
            }
            else {
            $downvote = new Vote ([
                'user_id' => Auth()->user()->user_id,
                'post_id' => $id,
                'vote' => '0'
            ]);
            $downvote->save();
            }

            $storeDownvotes = Vote::where('post_id', $id)
                                  ->where('vote', '0')
                                  ->count();

            $post = Post::find($id);
            $post->downvotes = $storeDownvotes;
            $post->save();

            return redirect()->back();
        }
    }
}
