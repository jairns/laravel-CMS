@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <h2>Hello {{ auth()->user()->name }}</h2>
                            <h5>Your Motto</h5>
                            <p><p>{{ auth()->user()->job ?? '' }}</p></p>
                            <p><p>{{ auth()->user()->location ?? '' }}</p></p>
                        </div>
                        <div class="col-md-3">
                            <img class="img-thumbnail" src="/img/300x400.jpg" alt="{{ auth()->user()->name }}">
                        </div>
                    </div>

                    @isset($posts)
                        @if($posts->count() > 0)
                        <h3>Your posts:</h3>
                        @endif
                    <ul class="list-group">
                        @foreach($posts as $post)
                            <li class="list-group-item">
                                <a title="Show Details" href="/post/{{ $post->id }}">
                                    <img src="/img/thumb_landscape.jpg" alt="thumb"></a>
                                    {{ $post->title }}
                                </a>
                                @auth
                                    <a class="btn btn-sm btn-light ml-2" href="/post/{{ $post->id }}/edit"><i class="fas fa-edit"></i> Edit Post</a>
                                @endauth

                                @auth
                                    <form class="float-right" style="display: inline" action="/post/{{ $post->id }}" method="post">
                                        @csrf
                                        @method("DELETE")
                                        <input class="btn btn-sm btn-outline-danger" type="submit" value="Delete">
                                    </form>
                                @endauth
                                <span class="float-right mx-2">{{ $post->created_at->diffForHumans() }}</span>
                                <br>
                                @foreach($post->tags as $tag)
                                    <a href="/post/tag/{{ $tag->id }}"><span class="badge badge-{{ $tag->style }}">{{ $tag->name }}</span></a>
                                @endforeach
                            </li>
                        @endforeach
                    </ul>
                    @endisset

                    <a class="btn btn-success btn-sm" href="/post/create"><i class="fas fa-plus-circle"></i> Create new Post</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
