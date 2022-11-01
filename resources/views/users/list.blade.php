@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-between mb-5">
                <div class="d-flex align-items-center">
                    <h2 class="me-3 mb-0">User List</h2>
                    @if (Auth::user()->hasPermissionTo('create_users'))
                        <a href="{{ route('app.users.new') }}" class="btn btn-sm btn-primary text-white">Add New User</a>
                    @endif
                </div>
                <div>
                    <form action="{{ route('app.users.index') }}" method="GET" class="input-group">
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
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Posts Created</th>
                            @if (Auth::user()->hasPermissionTo('filter_user_types'))
                            <th>Role</th>
                            @endif
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->posts()->count() }}</td>
                                @if (Auth::user()->hasPermissionTo('filter_user_types'))
                                <td>{{ $user->getUserTypeLabel() }}</td>
                                @endif
                                <td>
                                    <a href="{{ $user->getDetailLink() }}" class="btn btn-xs btn-info text-white">See</a>
                                    @if(Auth::user()->hasPermissionTo('edit_users'))
                                    <a href="{{ $user->getEditLink() }}" class="btn btn-xs btn-success text-white">Edit</a>
                                    @endif
                                    @if(Auth::user()->hasPermissionTo('delete_users'))
                                    <button 
                                        type="button" 
                                        class="btn btn-xs btn-danger text-white delete-post" 
                                        data-post-id="{{ $user->id }}" 
                                        data-action="{{ $user->getDeleteActionLink() }}"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deletePostModal" 
                                        data-bs-whatever="@mdo">Delete</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $users->links() }}
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