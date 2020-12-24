@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <h3 class='mb-3'>User Profile:</h3>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <!-- Welcome the user  -->
                            <h2>Hello {{ auth()->user()->name }}</h2>
                            <!-- If the user has specified a job, display here -->
                            @if(auth()->user()->job)
                                <b>Job: {{ auth()->user()->job}}</b><br>
                            @endif
                            <!-- If the user has specified a location, display here -->
                            @if(auth()->user()->location)
                                <b>Location: {{ auth()->user()->location}}</b>
                            @endif
                            <p>
                                <!-- Edit profile button -->
                                <a class='mt-3 btn btn-primary' href='user/{{ auth()->user()->id }}/edit'>Edit profile</a>
                            </p>
                        </div>
                        <div class="col-md-3">
                            <!-- If the user has a profile picture, display here -->
                            @if(file_exists('storage/users/' . 'user_' . auth()->user()->id . '_img.jpg'))
                                <img src='/storage/users/user_{{ auth()->user()->id }}_img.jpg' alt='User profile picture' style='height:125px; width:125px'/>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @isset($posts)
                <!-- If the user has any post's, display them all -->
                @if($posts->count() > 0)
                    <h3 class='mt-3'>Your posts:</h3>
                    <!-- Loop through each post -->
                    @foreach($posts as $post)
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="mt-3 card text-left bg-white">
                                    <div class="card-body">
                                        <div>
                                            <span class="mt-1 float-right">
                                                <!-- Display date in hours, days, weeks.. ago -->
                                                {{ $post->created_at->diffForHumans() }}
                                            </span>
                                            <!-- Link which leads to a page dedicated to a specific post -->
                                            <a title="Show Details" href="/post/{{ $post->id }}">
                                                <!-- Displaying post title -->
                                                <h3>{{ $post->title }}</h3>
                                            </a>
                                        </div>
                                        <!-- Displaying post descrption -->
                                        <h5 class="mt-3 card-title">{{ $post->description }}</h5>
                                        <!-- Displaying first 200 characters of the post's content -->
                                        <p class='mt-3'>{!! substr($post->content, 0,200) !!}...</p>
                                        <!-- Link which leads to a page dedicated to a specific post -->
                                        <a href="/post/{{ $post->id }}" class="text-info">View post <i class='fas fa-arrow-right'></i> </a>
                                        <br>
                                        <!-- Loop through the tags assigned to this post and display them -->
                                        @foreach($post->tags as $tag)
                                            <a href="/post/tag/{{ $tag->id }}"><span class="mt-3 badge badge-pill badge-{{ $tag->style }}">{{ $tag->name }}</span></a>
                                        @endforeach
                                        <div class='w-100 d-flex mt-3'>
                                            <!-- If the user is authenticated -->
                                            @auth
                                                <!-- And they CAN update the post (permitted within the controller and policy) -->
                                                @can('update', $post)
                                                    <!-- Display this button -->
                                                    <a class="btn btn-sm btn-outline-primary" href="/post/{{ $post->id }}/edit"><i class="fas fa-edit"></i> Edit Post</a>
                                                @endcan
                                                <!-- If the user CAN delete this post (permitted within the controller and policy) -->
                                                @can('delete', $post)
                                                    <!-- Display deletion form and button -->
                                                    <form class='d-flex' action="/post/{{ $post->id }}" method="post">
                                                        @csrf
                                                        @method("DELETE")
                                                        <input class="btn btn-sm btn-outline-danger" type="submit" value="Delete">
                                                    </form>
                                                @endcan
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endisset
            <!-- Create new post button -->
            <a class="btn btn-success btn-sm mt-2" href="/post/create"><i class="fas fa-plus-circle"></i> Create new Post</a>
        </div>
    </div>
</div>
@endsection
