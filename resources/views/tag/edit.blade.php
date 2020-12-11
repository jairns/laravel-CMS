@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit Tag</div>
                    <div class="card-body">
                        <form action="/tag/{{$tag->id}}" method="POST">
                        @csrf
                        @method('PATCH')
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" 
                                    class="form-control{{ $errors->has('name') ? ' border-danger' : '' }}" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name') ?? $tag->name }}">                         
                            </div>
                            <div class="form-group">
                                <label for="style">Style</label>
                                <input
                                    type="text" 
                                    class="form-control{{ $errors->has('style') ? ' border-danger' : '' }}"
                                    id="style" 
                                    name="style" 
                                    value="{{old('style') ?? $tag->style}}">
                            </div>
                            <input class="btn btn-primary mt-4" type="submit" value="Save Tag"> 
                            <a class="btn btn-primary mt-4 float-right" href="/tag"><i class="fas fa-arrow-circle-up"></i> Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection