@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit Profile</div>
                    <div class="card-body">
                        <form action="/user/{{$user->id}}" method="POST" enctype='multipart/form-data'>
                        @csrf
                        @method('PATCH')
                            <div class="form-group">
                                <label for="job">Job</label>
                                <input type="text" 
                                    class="form-control{{ $errors->has('job') ? ' border-danger' : '' }}" 
                                    id="job" 
                                    name="job" 
                                    value="{{ old('job') ?? $user->job }}">                         
                            </div>
                            <div class="form-group">
                                <label for="location">Location</label>
                                <input type="text" 
                                    class="form-control{{ $errors->has('location') ? ' border-danger' : '' }}" 
                                    id="location" 
                                    name="location" 
                                    value="{{ old('location') ?? $user->location }}">                         
                            </div>
                            @if(file_exists('storage/users/' . 'user_' . $user->id . '_img.jpg'))
                                <img src='/storage/users/user_{{ $user->id }}_img.jpg' alt='User profile picture' style='height:50px; width:50px'/>
                                <a class='float-right btn btn-outline-danger' href='/remove-image/user/{{ $user->id }}'>Remove profile picture</a>
                            @endif
                            <div class="form-group">
                                <label for="name">Profile picture</label>
                                <input type="file" 
                                    class="form-control{{ $errors->has('image') ? ' border-danger' : '' }}" 
                                    id="image" 
                                    name="image" 
                                    value="">                         
                            </div>
                            <input class="btn btn-primary mt-4" type="submit" value="Save Profile"> 
                            <a class="btn btn-primary mt-4 float-right" href="/home"><i class="fas fa-arrow-circle-up"></i> Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection