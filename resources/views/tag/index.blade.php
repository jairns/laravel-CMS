
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card-body">
                    <h3>All Tags</h3>    
                    <ul class="list-group">
                        <!-- Loop through all tags and display them  -->
                        @foreach($tags as $tag)
                            <li class="list-group-item">
                                <!-- Display tag name -->
                                <span style="font-size: 130%;" class="badge badge-{{ $tag->style }}">{{ $tag->name }}</span>
                                <!-- Tag deletion form -->
                                <form class='form-inline float-right' action="/tag/{{ $tag->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input class="btn btn-outline-danger btn-sm ml-2" type="submit" value="Delete">
                                </form>
                                <!-- Edit tag link -->
                                <a class="ml-2 btn btn-sm btn-outline-primary float-right" href="/tag/{{ $tag->id }}/edit"><i class="fas fa-edit"></i> Edit</a>
                            </li>
                        @endforeach
                    </ul>
                        <!-- Create a new tag -->
                        <a class="btn btn-success btn-sm mt-3" href="/tag/create"><i class="fas fa-plus-circle"></i> New Tag</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
