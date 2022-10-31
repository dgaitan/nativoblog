@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if (session('status'))
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">My Profile</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <strong class="d-block text-muted">First Name:</strong>
                                <p class="fs-4">{{ $user->name }}</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <strong class="d-block text-muted">Last Name:</strong>
                                <p class="fs-4">{{ $user->last_name }}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <strong class="d-block text-muted">Email:</strong>
                                <p class="fs-4">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <strong class="d-block text-muted">Last Login At:</strong>
                                <p class="fs-5">{{ $user->last_login->format('F j, Y @ h:i a') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
