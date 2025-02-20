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
                    <label for="amount" class="form-label text-primary fw-bold"> {{ __('Enter Amount') }} (Minimum: ₹{{ $minimum_withdrawals }})</label>
                    <input type="number" class="form-control border-2 border-warning bg-light shadow-lg text-dark fw-bold" 
                        id="amount" name="amount" required placeholder="Enter amount">
                </div>
            </div>


           
        </div>

        <!-- Submit Button -->
        <div class="text-start mt-4">
            <button type="button" id="submitWithdrawalRequest" class="btn btn-success">{{ __('Submit Withdrawal Request') }}</button>
        </div>

        <div class="text-start mt-3">
            <p class="text-muted fw-bold fs-8">{{ __('Withdrawal Request Timing Between 10am to 6pm') }}</p>
        </div>
    </div>
</div>

<!-- JavaScript to handle form submission and wallet selection -->
<script>
    document.getElementById('submitWithdrawalRequest').addEventListener('click', function() {
        // Get the withdrawal details from the form
        let amount = document.getElementById('amount').value;
      

        // Send the withdrawal request
        fetch('{{ route("withdrawals.submit") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
         
                amount: amount,
            
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
