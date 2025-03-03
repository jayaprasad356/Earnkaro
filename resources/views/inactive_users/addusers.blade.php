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
                        <label for="pincode">{{ __('Pincode') }}</label>
                        <input type="text" class="form-control" id="pincode" name="pincode" required value="{{ old('pincode') }}">
                        @error('pincode') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="gender">{{ __('Gender') }}</label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="">{{ __('Select Gender') }}</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>{{ __('male') }}</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                        </select>
                        @error('gender') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

  

                    <div class="form-group">
                        <label for="password">{{ __('Password') }}</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="level_1_refer">{{ __('Level 1 Refer') }}</label>
                        <input type="text" class="form-control" id="level_1_refer" name="level_1_refer" value="{{ $refer_code }}" disabled>
                        @error('level_1_refer') <span class="text-danger">{{ $message }}</span> @enderror
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
