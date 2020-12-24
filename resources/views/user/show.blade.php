@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @if($user->job || $user->location)
                <div class="col-md-11">
                    <h3 class='mb-3'>{{ $user->name }}'s profile:</h3>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <!-- If the user has specified a job, display here -->
                                    @if( $user->job)
                                        <b>Job: {{ $user->job}}</b><br>
                                    @endif
                                    <!-- If the user has specified a location, display here -->
                                    @if($user->location)
                                        <b>Location: {{ $user->location}}</b>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <!-- If the user has a profile picture, display here -->
                                    @if(file_exists('storage/users/' . 'user_' . $user->id . '_img.jpg'))
                                        <img src='/storage/users/user_{{ $user->id }}_img.jpg' alt='User profile picture' style='height:125px; width:125px'/>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- If the user has any post's, display them all -->
                @if($user->posts->count() > 0)
                    <h3 class='mt-3'>{{ $user->name }}'s post's:</h3>
                    <!-- Loop through each post -->
                    @foreach($user->posts as $post)
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                <a class="btn btn-primary btn-sm mt-3" href="/post"><i class="fas fa-arrow-circle-left"></i> Back to all posts</a>
            </div>
        </div>
    </div>
@endsection
