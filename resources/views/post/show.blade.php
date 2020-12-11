@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card mb-3">
                <div class="card-header">
                    <b>{{ $post->title }}</b>
                </div>
                <div class="card-body">
                    <h5>{{ $post->description }}</h5>
                    <p>{{ $post->content }}</p>
                </div>
            </div>
        <div>
            <a class="btn btn-primary btn-sm float-left" href="/post"><i class="fas fa-arrow-circle-left"></i> Back to all posts</a>
        </div>
        </div>
    </div>
</div>
@endsection
