@extends('layouts.app')

@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-lg-6 col-md-12 d-flex'>
                <!-- if the user is filtering by tags displaying the tag, and a link to remove filter -->
                @isset($filteredTag)
                    <h3>Filtered posts by:</h3>
                    <a>
                        <!-- Display tag which the user is filtering by -->
                        <span class="ml-2 p-2 badge badge-pill badge-{{ $filteredTag->style }}">{{ $filteredTag->name }}</span>
                    </a><br>
                        <!-- Remove filter -->
                        <span class='ml-4'><a href="/post">Show all Posts</a></span>
                @else
                    <!-- If no filters are set, display the following heading -->
                    <h3>All the posts</h3>
                @endisset
            </div>
            <div class='col-lg-6 col-md-12 float-right'>
                <form class="form d-flex" method='GET' action='/post'>
                    <input class="form-control border-right-none w-70 outline-none" name='search' type="text" placeholder="Search for a post">
                    <button class="btn btn-info border-left-none w-30" type="submit">Search</button>
                </form>
            </div>
        </div>
            <!-- Store each post from the model as post and loop from them all -->
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
                                    <div class='mt-3 align-items-center border-top'>
                                        <!-- if a user has a profile picture, display it -->
                                        @if(file_exists('storage/users/' . 'user_' . $post->user->id . '_img.jpg'))
                                            <a href="/user/{{ $post->user->id }}"><img class='mt-2' src='/storage/users/user_{{ $post->user->id }}_img.jpg' alt='User profile picture' style='height:50px; width:50px'/></a>
                                        @endif
                                        <span class='mt-2'>
                                            Author: 
                                            <a href="/user/{{ $post->user->id }}">
                                                <!-- Display author's name, job and location -->
                                                {{ $post->user->name }} ({{ $post->user->job }}, {{ $post->user->location }})
                                            </a>
                                        </span>

                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <!-- Pagination -->
            <div class="mt-3">
                {{ $posts->links() }}
            </div>
            <!-- If the user is authorized, display create new post button -->
            @auth
            <div class="mt-2">
                <a class="btn btn-success btn-sm" href="/post/create"><i class="fas fa-plus-circle"></i> Create new Post</a>
            </div>
            @endauth
        </div>
    </div>
@endsection