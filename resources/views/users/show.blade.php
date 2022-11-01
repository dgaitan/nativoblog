@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h1 class="mb-3 mt-3">{{ $user->name }} {{ $user->last_name }}</h1>
                        <hr>
                        <div class="mb-2">
                            <strong>Email: </strong> {{ $user->email }}
                        </div>
                        <div class="mb-2">
                            <strong>Last Login: </strong> {{ $user->last_login->format('F j, Y @ h:i a') }}
                        </div>
                        @if (Auth::user()->hasPermissionTo('filter_user_types'))
                        <div class="mb-2">
                            <strong>Role: </strong> {{ $user->getUserTypeLabel() }}
                        </div>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('app.users.index') }}" class="btn btn-dark">Back</a>
                    @if (Auth::user()->hasPermissionTo('edit_users'))
                    <a href="{{ $user->getEditLink() }}" class="btn btn-success text-white">Edit</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection