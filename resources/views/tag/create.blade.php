@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3>Create New Tag</h3>
                <div class="card">
                    <div class="card-body">
                        <form action="/tag" method="POST">
                        @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control{{ $errors->has('name') ? ' border-danger' : '' }}" id="name" name="name" value="{{old('name')}}" />                            
                            </div>
                            <div class="form-group">
                                <label for="style">Style</label>
                                <input type="text" class="form-control{{ $errors->has('style') ? ' border-danger' : '' }}" id="style" name="style" value="{{old('style')}}" />
                            </div>
                            <input class="btn btn-primary mt-4" type="submit" value="Save Tag"> 
                            <a class="btn btn-primary mt-4 float-right" href="/tag"><i class="fas fa-arrow-circle-left"></i> Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection