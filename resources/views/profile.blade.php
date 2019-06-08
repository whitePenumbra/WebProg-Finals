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

            <div class="modal fade" id="updateProfileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Update Profile</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('settings')}}" id="updateSettings" enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" placeholder="Enter username" value="{{$user->username}}" required>
                               
                                    @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Enter email address" value="{{$user->email}}" required>
                                
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Enter name" value="{{$user->name}}" required>
                                
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="name">Profile Picture</label>
                                    <div class="custom-file">
                                        <input type="file" id="customFile" name="profile_pic">
                                    </div>

                                    @error('profile_pic')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" onclick="updateSettings()" class="btn btn-primary">Save changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Profile | {{$user->username}}
                    <button class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#updateProfileModal">Update Profile</button>
                </div>

                <div class="card-body">
                    <div>                     
                        <div class="text-center pb-3">
                            <img src="{{ asset('userimages/'.$user->profile_pic ) }}" height="150" class="mr-3 mx-auto" alt="{{$user->username}}">
                            <h4 class="pt-2">{{$user->username}}</h4>
                        </div> 

                        <h4 class="pt-4">Posts</h4>
                        @if($userposts->isEmpty())
                        <div class="text-center">
                            You haven't created any posts yet!
                        </div>
                        @endif
                        @foreach($userposts as $post)
                        <div>
                            <h4><a href="{{ url('/post/'.$post->id) }}">{{$post->title}}</a></h4>
                            <span class="float-right" style="font-size: 12px">{{\Carbon\Carbon::parse($post->created_at)->diffForHumans()}}</span>
                            <p class="w-75 text-truncate">{{$post->content}}</p>
                        </div>
                        <hr>
                        @endforeach
                        {{$userposts->links()}}

                        <h4 class="pt-4">Comments</h4>
                        @if($comments->isEmpty())
                        <div class="text-center">
                            You haven't posted any comments yet!
                        </div>
                        @endif

                        @foreach($comments as $comment)
                        <div class="media">
                            <div class="media-body">
                                @foreach($posts as $post)
                                    @if($comment->post_id == $post->id)
                                    <h5 class="mt-0">{{$post->title}}</h5>
                                    @endif
                                @endforeach
                                <span class="float-right">{{\Carbon\Carbon::parse($comment->created_at)->diffForHumans()}}</span>
                                {{$comment->comment}}
                            </div>
                        </div>
                        <hr>
                        @endforeach
                        {{$comments->links()}}

                        <h4 class="pt-4">Posts Upvoted</h4>
                        @if($votes->isEmpty())
                        <div class="text-center">
                            You haven't upvoted any posts yet!
                        </div>
                        @endif
                        <ul class="list-group list-group-flush">
                            @foreach($votes as $vote)
                                @foreach($posts as $post)
                                    @if($vote->post_id == $post->id)
                                    <li class="list-group-item">
                                        {{$post->title}}
                                        <span class="float-right">{{\Carbon\Carbon::parse($vote->created_at)->format('m-d-Y')}}</span>
                                    </li>
                                    @endif
                                @endforeach
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
