@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Display post title -->
                <h1>{{$post->title}}</h1>
                <h4>{{$post->description}}</h4>
                <!-- If the image exists, display it -->
                @if(file_exists('storage/posts/' . 'post_' . $post->id . '_img.jpg'))
                    <img src='/storage/posts/post_{{ $post->id }}_img.jpg' alt='Image related to the post' style='min-width: 90%; max-width: 100%; height: 500px;'/>
                @endif
                <!-- Display post content -->
                <p>{{$post->content}}</p>
                <!-- If the user on the page is the creator of this post or an admin display the assign and remove options -->
                @can('add_or_rm_post_tag', $post)
                    @if($post->tags->count() > 0)
                        <b>Used Tags:</b> (Click to remove)
                        <p>
                            @foreach($post->tags as $tag)
                                <a href="/post/{{$post->id}}/tag/{{$tag->id}}/remove"><span class="badge badge-{{ $tag->style }}">{{ $tag->name }}</span></a>
                            @endforeach
                        </p>
                    @endif
                    @if($tagsAvailable->count() > 0)
                        <b>Available Tags:</b> (Click to assign)
                        <p>
                            @foreach($tagsAvailable as $tag)
                                <a href="/post/{{$post->id}}/tag/{{$tag->id}}/assign"><span class="badge badge-{{ $tag->style }}">{{ $tag->name }}</span></a>
                            @endforeach
                        </p>
                    @endif
                @endcan
                <div class="mt-2">
                    <a class="btn btn-primary btn-sm" href="/post"><i class="fas fa-arrow-circle-left"></i> Back to all posts</a>
                </div> 
                <hr>
                <!-- Start of comment section -->
                <h4>Post a comment <i>(You must have an account)</i></h4>
                <form class='form' method='POST' action='/comment/{{$post->id}}'>
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <textarea class='form-control' name="comment" cols="30" rows="10"></textarea>
                    </div>
                    <button class="btn btn-sm btn-primary" type="submit">Post comment</button>
                </form>
                @if($post->comments->count() > 0)
                    <h4 class='mt-3'>All comments</h4>
                    @foreach($comments as $comment)
                        @if($comment->post_id === $post->id)
                            <div class='card mt-3'>
                                <div class='card-body'>
                                    <p class='float-right'>{{ $comment->created_at->diffForHumans() }}</p>
                                    <p>User {{ $comment->user->name }} commented:</p>
                                    <p>{{ $comment->comment }}</p>
                                    <!-- Display deletion form and button -->
                                    @can('delete', $comment)
                                        <form class='d-flex' action="/comment/remove/{{ $comment->id }}" method="post">
                                            @csrf
                                            @method("DELETE")
                                            <input class="btn btn-sm btn-outline-danger" type="submit" value="Delete">
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        @endif
                    @endforeach
                    @else
                        <h4 class='mt-3'>No comment's on this post yet</h4>
                @endif
                <!-- End of comment section -->
            </div>                     
        </div>
    </div>
@endsection 