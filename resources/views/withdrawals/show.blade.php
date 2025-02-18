@extends('layouts.admin')

@section('page-title')
    {{ __('Withdrawal Request') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('withdrawals.index') }}">{{ __('Withdrawals List') }}</a></li>
    <li class="breadcrumb-item">{{ __('Withdrawal Request') }}</li>
    <br>
@endsection

@section('content')
<div class="container">
    <!-- Wrapper with background box -->
    <div class="bg-light p-4 rounded shadow-sm">
        <div class="row justify-content-start">
            <!-- Earning Wallet -->
            <div class="col-md-4">
                <div class="card text-center border-success">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('Earning Wallet') }}</h4>
                        <p class="wallet-amount">
                            <i class="fas fa-wallet"></i> {{ number_format($earningWallet, 2) }}
                        </p>
                        <button class="btn btn-success" id="addEarningWallet" data-wallet="earning_wallet">{{ __('Add to Main Balance') }}</button>
                    </div>
                </div>
            </div>

            <!-- Bonus Wallet -->
            <div class="col-md-4">
                <div class="card text-center border-primary">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('Bonus Wallet') }}</h4>
                        <p class="wallet-amount">
                            <i class="fas fa-wallet"></i> {{ number_format($bonusWallet, 2) }}
                        </p>
                        <button class="btn btn-primary" id="addBonusWallet" data-wallet="bonus_wallet">{{ __('Add to Main Balance') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Withdrawal Time Notice -->
        <div class="text-start mt-3">
            <p class="text-muted fw-bold fs-8">{{ __('Withdrawal Request Timing Between 10am to 6pm') }}</p>
        </div>

        <div class="text-start mt-4">
            <p class="text fw-bold fs-4">{{ __('Withdrawal Request ') }}</p>
        </div>

        <!-- CSRF token -->
        @csrf
        <div class="row">
            <!-- Remaining Balance -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="balance" class="form-label">{{ __('Remaining Balance') }}</label>
                    <input type="text" class="form-control" id="balance" value="{{ ($balance) }}" disabled>
                </div>
            </div>

            <!-- Enter Amount -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="amount" class="form-label">{{ __('Enter Amount') }}</label>
                    <input type="number" class="form-control" id="amount" name="amount" required>
                </div>
            </div>

            <!-- Holder Name -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="holder_name" class="form-label">{{ __('Holder Name') }}</label>
                    <input type="text" class="form-control" id="holder_name" name="holder_name" value="{{ ($holder_name) }}" required>
                </div>
            </div>

            <!-- Account Number -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="account_number" class="form-label">{{ __('Account Number') }}</label>
                    <input type="text" class="form-control" id="account_number" name="account_number" value="{{ ($account_num) }}" required>
                </div>
            </div>

            <!-- Bank -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="bank" class="form-label">{{ __('Bank') }}</label>
                    <input type="text" class="form-control" id="bank" name="bank" value="{{ ($bank) }}" required>
                </div>
            </div>

            <!-- Branch -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="branch" class="form-label">{{ __('Branch') }}</label>
                    <input type="text" class="form-control" id="branch" name="branch" value="{{ ($branch) }}" required>
                </div>
            </div>

            <!-- IFSC Code -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="ifsc" class="form-label">{{ __('IFSC Code') }}</label>
                    <input type="text" class="form-control" id="ifsc" name="ifsc" value="{{ ($ifsc) }}" required>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="text-start mt-4">
            <button type="button" id="submitWithdrawalRequest" class="btn btn-success">{{ __('Submit Withdrawal Request') }}</button>
        </div>

    </div>
</div>

<!-- JavaScript to handle form submission and wallet selection -->
<script>
    document.getElementById('submitWithdrawalRequest').addEventListener('click', function() {
        // Get the withdrawal details from the form
        let amount = document.getElementById('amount').value;
        let holderName = document.getElementById('holder_name').value;
        let accountNumber = document.getElementById('account_number').value;
        let bank = document.getElementById('bank').value;
        let branch = document.getElementById('branch').value;
        let ifsc = document.getElementById('ifsc').value;
        let userId = '{{ session("user_id") }}'; // Get user_id from session

        // Send the withdrawal request
        fetch('{{ route("withdrawals.submit") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                user_id: userId,
                amount: amount,
                holder_name: holderName,
                account_number: accountNumber,
                bank: bank,
                branch: branch,
                ifsc: ifsc
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload(); // Refresh page to show updated balance
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            alert('An error occurred. Please try again.');
        });
    });
</script>
@endsection
