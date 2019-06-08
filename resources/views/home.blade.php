@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="modal fade" id="createPostModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Create Post</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <form role="form" id="createPost" method="POST" action="{{route('submit')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="Enter post title" required>
                                
                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="content">Content</label>
                                    <textarea class="form-control @error('content') is-invalid @enderror" name="content" rows="6" placeholder="Enter post content" required></textarea>
                                
                                    @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="photo">Photo</label>
                                    <div class="custom-file">
                                        <input type="file" id="customFile" name="photo">
                                    </div>

                                    @error('photo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" onclick="submitForm()" class="btn btn-primary">Post</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

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
                <div class="card-header">
                    Feed
                    <button class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#createPostModal">Create Post</button>
                </div>

                <div class="card-body">
                    @if($posts->isEmpty())
                        <div class="text-center">
                            There are no posts to show.
                        </div>
                    @endif
                    @foreach($posts as $post)
                    <div>
                        @foreach($users as $user)
                        @if($post->user_id == $user->id)
                        <span class="float-right">by <a href=" {{url('profile/'.$user->username)}}">{{$user->username}}</a></span>
                        @endif
                        @endforeach
                        <h4 class="w-75 text-truncate"><a href="{{ url('/post/'.$post->id) }}">{{$post->title}}</a></h4>
                        <span class="float-right" style="font-size: 12px">{{\Carbon\Carbon::parse($post->created_at)->diffForHumans()}}</span>
                        <p class="w-75 text-truncate">{{$post->content}}</p>
                    </div>
                    <hr>
                    @endforeach
                    {{$posts->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
