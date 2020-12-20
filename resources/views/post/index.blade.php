@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">

                    @isset($filter)
                        <div class="card-header">Filtered posts by
                            <span style="font-size: 130%;" class="badge badge-{{ $filter->style }}">{{ $filter->name }}</span>
                            <span class="float-right"><a href="/post">Show all Posts</a></span>
                        </div>
                    @else
                        <div class="card-header">All the posts</div>
                    @endisset

                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($posts as $post)
                                <li class="list-group-item">
                                    <a title="Show Details" href="/post/{{ $post->id }}">
                                        {{ $post->title }}
                                    </a>
                                    @auth
                                        @can('update', $post)
                                            <a class="btn btn-sm btn-light ml-2" href="/post/{{ $post->id }}/edit"><i class="fas fa-edit"></i> Edit Post</a>
                                        @endcan
                                    @endauth
                                    <span class="mx-2">Posted by: <a href="/user/{{ $post->user->id }}">{{ $post->user->name }} ({{ $post->user->posts->count() }} Posts)</a>
                                    @if(file_exists('storage/users/' . 'user_' . $post->user->id . '_img.jpg'))
                                        <a href="/user/{{ $post->user->id }}"><img class='rounded-circle' src='/storage/users/user_{{ $post->user->id }}_img.jpg' alt='User profile picture' style='height:50px; width:50px'/></a>
                                    @endif
                                    </span>
                                    @auth
                                        @can('update', $post)
                                            <form class="float-right" style="display: inline" action="/post/{{ $post->id }}" method="post">
                                                @csrf
                                                @method("DELETE")
                                                <input class="btn btn-sm btn-outline-danger" type="submit" value="Delete">
                                            </form>
                                        @endcan
                                    @endauth
                                    <span class="float-right mx-2">{{ $post->created_at->diffForHumans() }}</span>
                                    <br>
                                    @foreach($post->tags as $tag)
                                        <a href="/post/tag/{{ $tag->id }}"><span class="badge badge-{{ $tag->style }}">{{ $tag->name }}</span></a>
                                    @endforeach
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="mt-3">
                    {{ $posts->links() }}
                </div>
                @auth
                <div class="mt-2">
                    <a class="btn btn-success btn-sm" href="/post/create"><i class="fas fa-plus-circle"></i> Create new Post</a>
                </div>
                @endauth
            </div>
        </div>
    </div>
@endsection