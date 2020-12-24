@extends('layouts.app')
@section('page_title', 'About')
@section('page_description')
@section('content')
<div class="container">
    <div class="jumbotron">
        <h1 class="display-3">Hello and Welcome!</h1>
        <p class="lead">Dev Blog is a blogging platform where users can read and create blogs related to web development and software engineering.</p>
        <hr class="my-4">
        <p>click the button below to view our post's!</p>
        <p class="lead">
            <a class="btn btn-primary" href="/post" role="button">View posts</a>
        </p>
        </div>
    </div>
</div>
@endsection
