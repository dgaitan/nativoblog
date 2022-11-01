@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <h1 class="mb-3 mt-3">{{ $post->title }}</h1>
                <div class="mb-3">
                    <strong>By: </strong> {{ $post->author->name }}
                </div>
                <div>
                    {{ $post->content }}
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('app.posts.index') }}" class="btn btn-dark">Back</a>
                    <a href="{{ $post->getEditLink() }}" class="btn btn-success text-white">Edit</a>
                </div>
            </div>
        </div>
    </div>
@endsection