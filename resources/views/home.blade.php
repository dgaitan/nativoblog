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
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">My Profile</div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong class="d-block">Name:</strong>
                        <p class="fs-4">{{ $user->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
