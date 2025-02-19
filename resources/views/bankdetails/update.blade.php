@extends('layouts.admin')

@section('page-title')
    {{ __('Bank Details') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('bankdetails.update') }}">{{ __('Bank Details') }}</a></li>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('Update Bank Details') }}</h4>

                <!-- Display success or error messages -->
                @if(session('success'))
                    <div class="alert alert-success" id="success-message">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger" id="error-message">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Bank Details Form -->
                <form action="{{ route('bankdetails.update') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">{{ __('Account Number') }}</label>
                        <input type="text" name="account_num" class="form-control" value="{{ $user->account_num ?? '' }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('Holder Name') }}</label>
                        <input type="text" name="holder_name" class="form-control" value="{{ $user->holder_name ?? '' }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('Bank Name') }}</label>
                        <input type="text" name="bank" class="form-control" value="{{ $user->bank ?? '' }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('Branch') }}</label>
                        <input type="text" name="branch" class="form-control" value="{{ $user->branch ?? '' }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('IFSC Code') }}</label>
                        <input type="text" name="ifsc" class="form-control" value="{{ $user->ifsc ?? '' }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('Update Bank Details') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
            var errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }, 4000); // 4000 milliseconds = 4 seconds
    });
</script>
@endsection
