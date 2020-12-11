@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
        @foreach($posts as $post)
            <div class="card mb-3">
                <div class="card-header"> 
                    <a title="Show Post" href="/post/{{ $post->id }}">{{ $post->title }}</a>
                    <a class="btn btn-sm btn-light ml-2" href="/post/{{ $post->id }}/edit"><i class="fas fa-edit"></i> Edit Post</a>
                    <form style="display: inline" class="float-right" action="post/{{ $post->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Delete Post" class="btn btn-sm btn-outline-danger"/>
                    </form>
                </div>

                <div class="card-body">
                    <div>
                        <h3>{{ $post->description}}</h3>
                        <!-- <p>{{ $post->content}}</p> -->
                    </div>
                </div>
            </div>
        @endforeach
        <div>
            <a class="btn btn-success btn-sm float-left" href="/post/create "><i class="fas fa-plus-circle"></i> Create new post</a>
        </div>
        </div>
    </div>
</div>
@endsection
