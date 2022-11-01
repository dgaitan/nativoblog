@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <h1 class="mb-3 mt-3">New Post</h1>
                <form action="{{ route('app.users.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group row mb-4">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

                        <div class="col-md-6">
                            <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required>

                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label for="user_type" class="col-md-4 col-form-label text-md-right">{{ __('User Type') }}</label>

                        <div class="col-md-6">
                            <select class="form-control{{ $errors->has('user_type') ? ' is-invalid' : '' }}" name="user_type" required>
                                @foreach($user_types as $key => $user_type)
                                    <option value="{{ $key }}">{{ $user_type }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('user_type'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('user_type') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('app.users.index') }}" class="btn btn-dark">Back</a>
                        <button type="submit" class="btn btn-primary text-white">
                            {{ __('Update') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection