@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Create New Post</div>
                    <div class="card-body">
                        <form action="/post" method="POST" enctype='multipart/form-data'>
                        @csrf
                        @method('POST')
                            <div class="form-group">
                                <label for="name">Title</label>
                                <input 
                                    type="text"
                                    class="form-control{{ $errors->has('title') ? ' border-danger' : '' }}" 
                                    id="title"
                                    name="title" 
                                    value="{{old('title')}}">                            
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea 
                                    class="form-control{{ $errors->has('description') ? ' border-danger' : '' }}" 
                                    id="description"
                                    name="description"
                                    rows="2" 
                                    value="{{old('description')}}">
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="description">Content</label>
                                <textarea 
                                    class="form-control {{ $errors->has('content') ? ' border-danger' : '' }}" 
                                    id="content" 
                                    name="content" 
                                    rows="5" 
                                    value="{{old('content')}}">
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="name">Image</label>
                                <input 
                                    type="file" 
                                    class="form-control{{ $errors->has('iamge') ? ' border-danger' : '' }}" 
                                    id="image" 
                                    name="image"
                                    value="">                            
                            </div>
                        
                            <button type='submit' class='btn btn-primary mt-4'>Save Post</button>
                            <!-- <input class="btn btn-primary mt-4" href='/tests' type="submit" value="Save Post">  -->
                            <a class="btn btn-primary mt-4 float-right" href="/post"><i class="fas fa-arrow-circle-up"></i> Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection