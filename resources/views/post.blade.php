@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('error-status'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error-status') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">Post #{{$post->id}}</div>

                <div class="card-body">
                    <div>
                        @foreach($users as $user)
                        @if($post->user_id == $user->id)
                        <span class="float-right">by <a href=" {{url('profile/'.$user->username)}}">{{$user->username}}</a> | {{\Carbon\Carbon::parse($post->created_at)->diffForHumans()}}</span>
                        @endif
                        @endforeach
                        <h4 class="pb-3">{{$post->title}}</h4>
                        @if($post->photo!=NULL)
                        <div class="text-center pt-2 pb-4">
                            <img src="{{ asset('postimages/'.$post->photo ) }}" height="200" class="mr-3 mx-auto" alt="Post Image">
                        </div>
                        @endif
                        <p style="white-space: pre-wrap">{{$post->content}}</p>
                        <div class="text-center">
                            <div class="btn-group" role="group" aria-label="Vote Options">
                                @if($upvoted==1)
                                <button type="button" class="btn btn-secondary"><a class="text-white" href="{{url('post/upvote/'.$post->id)}}">Upvoted <b>{{$post->upvotes}}</b></a></button>
                                @else
                                <button type="button" class="btn btn-success"><a class="text-white" href="{{url('post/upvote/'.$post->id)}}">Upvote <b>{{$post->upvotes}}</b></a></button>
                                @endif

                                @if($downvoted==1)
                                <button type="button" class="btn btn-secondary"><a class="text-white" href="{{url('post/downvote/'.$post->id)}}">Downvoted <b>{{$post->downvotes}}</b></a></button>
                                @else
                                <button type="button" class="btn btn-danger"><a class="text-white" href="{{url('post/downvote/'.$post->id)}}">Downvote <b>{{$post->downvotes}}</b></a></button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h5>Write a Comment</h5>
                    <div class="media">
                        <img src="{{ asset('userimages/'.auth()->user()->profile_pic ) }}" height="64" class="mr-3" alt="{{auth()->user()->username}}">
                        <div class="media-body">
                            <form action="{{route('comment')}}" method="POST">
                                @csrf
                                <input type="hidden" name="post_id" value="{{$post->id}}">
                                <div class="form-group">
                                    <textarea name="comment" class="form-control" rows="4" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary float-right">Post</button>
                            </form>
                        </div>
                    </div>
                    @foreach($post->comments as $comment)
                    <div class="media pt-2">
                        @foreach($users as $user)
                        @if($comment->user_id == $user->id)
                        <img src="{{ asset('userimages/'.$user->profile_pic ) }}" height="64" class="mr-3" alt="{{$user->username}}">
                        <div class="media-body">
                            <h5 class="mt-1">{{$user->username}}</h5>
                            @endif
                            @endforeach
                            <span class="float-right">{{\Carbon\Carbon::parse($comment->created_at)->diffForHumans()}}</span>
                            {{$comment->comment}}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
