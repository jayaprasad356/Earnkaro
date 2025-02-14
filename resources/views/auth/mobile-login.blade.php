@extends('layouts.auth')

@section('page-title', __('Mobile Login'))

@section('content')
    <div class="card-body">
        <div class="text-center mb-4">
            <img src="{{ asset('storage/uploads/logo/jiyo.jpeg') }}" alt="Logo" width="100">
        </div>

        <div>
            <center><h2 class="mb-3 f-w-600">{{ __('Login with Mobile') }}</h2></center> 
        </div>

        <div class="custom-login-form">
            <form method="POST" action="{{ route('mobile.login') }}">
                @csrf
                <div class="form-group mb-3">
                    <label class="form-label">{{ __('Mobile Number') }}</label>
                    <input type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror" placeholder="Enter your mobile number" required autofocus>
                    @error('mobile')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">{{ __('Password') }}</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter password" required>
                    @error('password')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>

                <div class="d-grid">
                    <button class="btn btn-primary mt-2" type="submit">{{ __('Login') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
