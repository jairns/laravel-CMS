@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div style="font-size: 150%;" class="card-header">{{ $user->name }}</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <b>{{$user->job}}</b>
                                <p class="mt-2"><b>{{$user->location}}</b></p>

                                <h5>Post's by {{ $user->name }}</h5>
                                <ul class="list-group">
                                    @if($user->posts->count() > 0)
                                        @foreach($user->posts as $post)
                                            <li class="list-group-item">
                                                <a title="Show Details" href="/post/{{ $post->id }}">{{ $post->title }}</a>
                                                <span class="float-right mx-2">{{ $post->created_at->diffForHumans() }}</span>
                                                <br>
                                                @foreach($post->tags as $tag)
                                                    <a href="/post/tag/{{ $tag->id }}"><span class="badge badge-{{ $tag->style }}">{{ $tag->name }}</span></a>
                                                @endforeach
                                            </li>
                                        @endforeach
                                </ul>
                                @else
                                    <p>
                                        {{ $user->name }} has not created any posts yet.
                                    </p>
                                @endif
                            </div>
                            <div class="col-md-3">
                            @if(file_exists('storage/users/' . 'user_' . $post->user->id . '_img.jpg'))
                                <img class='rounded-circle' src='/storage/users/user_{{ $post->user->id }}_img.jpg' alt='User profile picture' style='height:125px; width:125px'/>
                            @endif
                            </div>
                        </div>


                    </div>

                </div>

                <div class="mt-4">
                    <a class="btn btn-primary btn-sm" href="{{ URL::previous() }}"><i class="fas fa-arrow-circle-up"></i> Back to Overview</a>
                </div>
            </div>
        </div>
    </div>
@endsection