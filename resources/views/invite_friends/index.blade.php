@extends('layouts.admin')

@section('page-title')
    {{ __('Invite Friends List') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Invite Friends List') }}</li>
@endsection

@section('content')
<div class="card">
    <div class="card-body text">
        <h5 class="card-title">{{ __('Invite Your Friends') }}</h5>
        
        <br>
        <!-- Copy Invitation Link -->
        <button class="btn btn-primary d-block w-50 mb-2" onclick="copyInvitationLink()">
            {{ __('Copy Invitation Link') }}
        </button>
        
        <!-- Join Telegram Channel -->
        <a href="{{ $telegram_channel }}" target="_blank" class="btn btn-info d-block w-50 mb-2">
            {{ __('Join Telegram Channel') }}
        </a>

        <!-- Contact Customer Support -->
        <a href="mailto:{{ $customer_support }}" class="btn btn-warning d-block w-50 mb-2">
            {{ __('Contact Customer Support') }}
        </a>
    </div>
</div>

<script>
    function copyInvitationLink() {
        // Create a temporary input field to copy the invitation link
        const tempInput = document.createElement('input');
        document.body.appendChild(tempInput);
        tempInput.value = "{{ $invitation_link }}"; // Add the invitation link
        tempInput.select();
        document.execCommand('copy'); // Copy the text to clipboard
        document.body.removeChild(tempInput);

        // Optional: Notify the user that the link has been copied
        alert("Invitation Link copied to clipboard!");
    }
</script>
@endsection
