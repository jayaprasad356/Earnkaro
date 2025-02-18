@extends('layouts.admin')

@section('page-title')
    {{ __('Register New User') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('inactive_users.index') }}">{{ __('Inactive Users') }}</a></li>
    <li class="breadcrumb-item">{{ __('Register New User') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('inactive_users.register') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="mobile">{{ __('Mobile') }}</label>
                        <input type="text" class="form-control" id="mobile" name="mobile" required value="{{ old('mobile') }}">
                        @error('mobile') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="age">{{ __('Age') }}</label>
                        <input type="number" class="form-control" id="age" name="age" required value="{{ old('age') }}">
                        @error('age') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="city">{{ __('City') }}</label>
                        <input type="text" class="form-control" id="city" name="city" required value="{{ old('city') }}">
                        @error('city') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">{{ __('Email') }}</label>
                        <input type="email" class="form-control" id="email" name="email" required value="{{ old('email') }}">
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="state">{{ __('State') }}</label>
                        <input type="text" class="form-control" id="state" name="state" required value="{{ old('state') }}">
                        @error('state') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">{{ __('Password') }}</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="referred_by">{{ __('Referred By') }}</label>
                        <input type="text" class="form-control" id="referred_by" name="referred_by" value="{{ $refer_code }}" disabled>
                        @error('referred_by') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group text-end">
                        <button type="submit" class="btn btn-primary">{{ __('Register User') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
