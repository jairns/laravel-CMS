@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">Hobby Detail</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <b>{{$post->title}}</b>
                                <!-- If the image exists, display it -->
                                @if(file_exists('storage/posts/' . 'post_' . $post->id . '_img.jpg'))
                                    <img src='/storage/posts/post_{{ $post->id }}_img.jpg' alt='Image related to the post'/>
                                @endif
                                <p>{{$post->description}}</p>
                                <p>{{$post->content}}</p>
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
                            </div>
                            <div class="col-md-3">
                                <a href="/img/400x300.jpg" data-lightbox="400x300.jpg" data-title="{{ $post->title }}">
                                    <img class="img-fluid" src="/img/400x300.jpg" alt="">
                                </a>
                                <i class="fa fa-search-plus"></i> Click image to enlarge
                            </div>
                        </div>
                    </div>
                </div>
                <!--
                <div class="mt-2">
                    <a class="btn btn-primary btn-sm" href="{{ URL::previous() }}"><i class="fas fa-arrow-circle-up"></i> Back to Overview</a>
                </div>
                -->
            </div>
        </div>
    </div>
@endsection