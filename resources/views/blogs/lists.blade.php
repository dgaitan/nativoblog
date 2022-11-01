@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <h1 class="mr-3">Post List</h1>
                    <a href="" class="btn btn-primary text-white">Add New Post</a>
                </div>
                <div>
                    <div class="input-group mb-3">
                        <input type="search" class="form-control" placeholder="Search Post..." aria-label="Search Post" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection