@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit Post</div>
                    <div class="card-body">
                        <form action="/post/{{$post->id}}" method="POST">
                        @csrf
                        @method('PATCH')
                            <div class="form-group">
                                <label for="name">title</label>
                                <input type="text" 
                                    class="form-control{{ $errors->has('title') ? ' border-danger' : '' }}" 
                                    id="title" 
                                    name="title" 
                                    value="{{ old('title') ?? $post->title }}">                         
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea 
                                    class="form-control{{ $errors->has('description') ? ' border-danger' : '' }}"
                                    id="description" 
                                    name="description" 
                                    rows="2" 
                                    >{{ old('description') ?? $post->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="description">Content</label>
                                <textarea 
                                    class="form-control {{ $errors->has('content') ? ' border-danger' : '' }}" 
                                    id="content" 
                                    name="content" 
                                    rows="5" 
                                    >{{ old('content') ?? $post->content }}</textarea>
                            </div>
                            <input class="btn btn-primary mt-4" type="submit" value="Save Post"> 
                            <a class="btn btn-primary mt-4 float-right" href="/post"><i class="fas fa-arrow-circle-up"></i> Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection