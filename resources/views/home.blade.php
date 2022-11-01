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
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="mb-md-0 mb-2 ">My Profile</h4>
                    <button class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#editAccountModal" data-bs-whatever="@mdo">Edit</button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <strong class="d-block text-muted">First Name:</strong>
                                <p id="account-name" class="fs-5">{{ $user->name }}</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <strong class="d-block text-muted">Last Name:</strong>
                                <p id="account-last_name" class="fs-5">{{ $user->last_name }}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <strong class="d-block text-muted">Email:</strong>
                                <p id="account-email" class="fs-5">{{ $user->email }}</p>
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

        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <p class="mb-2">Posts Created</p>
                    <h2>
                        {{ $posts_count }}
                    </h2>
                </div>
            </div>
        </div>

        @if($user->isSupervisor())
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <p class="mb-2">Bloggers</p>
                    <h2>
                        {{ $bloggers_count }}
                    </h2>
                </div>
            </div>
        </div>
        @endif
        @if($user->isAdmin())
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <p class="mb-2">Supervisors</p>
                    <h2>
                        {{ $supervisors_count }}
                    </h2>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@include('partials/edit-account-modal')
@endsection
