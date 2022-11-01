@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-between mb-5">
                <div class="d-flex align-items-center">
                    <h2 class="me-3 mb-0">Supervisors</h2>
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
                            <th>Bloggers</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($supervisors as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->posts()->count() }}</td>
                                <td>{{ $user->bloggers()->count() }}</td>
                                <td>
                                    <a href="{{ $user->getBloggersLink() }}" class="btn btn-xs btn-info text-white">See Bloggers</a>
                                    @if(Auth::user()->hasPermissionTo('edit_users'))
                                    <a href="{{ $user->getEditLink() }}" class="btn btn-xs btn-success text-white">Edit</a>
                                    @endif
                                    @if(Auth::user()->hasPermissionTo('delete_users'))
                                    <button 
                                        type="button" 
                                        class="btn btn-xs btn-danger text-white delete-record" 
                                        data-element-id="{{ $user->id }}" 
                                        data-action="{{ $user->getDeleteActionLink() }}"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteRecordModal" 
                                        data-bs-whatever="@mdo">Delete</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $supervisors->links() }}
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <!-- Modal -->
    <div class="modal fade" id="deleteRecordModal" tabindex="-1" aria-labelledby="deleteRecordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" id="deleteRecordModalForm" method="POST" action="">
                <input type="hidden" name="_method" value="DELETE">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteRecordModalLabel">Are you sure?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>You are close to delete this post. Are you sure about this action?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="deleteRecordModalSubmit" class="btn btn-primary text-white">Confirm</button>
                </div>
            </form>
        </div>
    </div>
@endsection