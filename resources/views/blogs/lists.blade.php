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
                                    <a href="{{ $post->getDetailLink() }}" class="btn btn-xs btn-info text-white">See</a>
                                    <a href="{{ $post->getEditLink() }}" class="btn btn-xs btn-success text-white">Edit</a>
                                    <button 
                                        type="button" 
                                        class="btn btn-xs btn-danger text-white delete-post" 
                                        data-post-id="{{ $post->id }}" 
                                        data-action="{{ $post->getDeleteActionLink() }}"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deletePostModal" 
                                        data-bs-whatever="@mdo">Delete</button>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $posts->links() }}
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <!-- Modal -->
    <div class="modal fade" id="deletePostModal" tabindex="-1" aria-labelledby="deletePostModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" id="deletePostModalForm" method="POST" action="">
                <input type="hidden" name="_method" value="DELETE">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePostModalLabel">Are you sure?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>You are close to delete this post. Are you sure about this action?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="deletePostModalSubmit" class="btn btn-primary text-white">Confirm</button>
                </div>
            </form>
        </div>
    </div>
@endsection