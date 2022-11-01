@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-between mb-5">
                <div class="d-flex align-items-center">
                    <h2 class="me-3 mb-0">Post List</h2>
                    <a href="" class="btn btn-sm btn-primary text-white">Add New Post</a>
                </div>
                <div>
                    <form action="{{ route('app.posts.index') }}" method="GET" class="input-group">
                        <input type="search" class="form-control" placeholder="Search Post..." name="q" value="{{ $q }}" aria-label="Search Post" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                    </form>
                </div>
            </div>
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <th>{{ $post->id }}</th>
                                <th>{{ $post->title }}</th>
                                <th>{{ $post->author->name }}</th>
                                <th>
                                    <a href="" class="btn btn-xs btn-success text-white">Edit</a>
                                    <a href="" class="btn btn-xs btn-danger text-white">Delete</a>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection