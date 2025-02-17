@extends('layouts.admin')

@section('page-title')
    {{ __('Activate User') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('inactive_users.activate') }}">{{ __('Activate User') }}</a></li>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <!-- Display Available Recharge Balance -->
                <div class="recharge-balance" style="position: absolute; top: 10px; right: 10px; font-size: 16px; background-color: #f1f1f1; padding: 5px 10px; border-radius: 5px;">
                    <strong>{{ __('Available Recharge Balance: Rs') }} {{ $balance }}</strong>
                </div>

                <!-- Display the user details -->
                <p><strong>{{ __('User ID:') }}</strong> {{ $id }} | <strong>{{ __('Name:') }}</strong> {{ $userName }} | <strong>{{ __('Mobile:') }}</strong> {{ $userMobile }}</p>

                <!-- Display the level-specific activation button -->
                <div class="mt-4">
                    <h5>{{ __('Activate for Level ') }} {{ $level }}</h5>

                    @if(request()->query('level') > 1)
                        <div class="mt-4" id="userDropdownContainer">
                            <select class="form-select" id="userDropdown" style="width: 50%;"> 
                                @if(request()->query('level') == 2)
                                    <option value="">{{ __('Choose Your Level 1 Users') }}</option>
                                @elseif(request()->query('level') == 3)
                                    <option value="">{{ __('Choose Your Level 2 Users') }}</option>
                                @elseif(request()->query('level') == 4)
                                    <option value="">{{ __('Choose Your Level 3 Users') }}</option>
                                @endif
                            </select>
                        </div>
                    @elseif(request()->query('level') == 1)
                       
                    @endif

                    <br>
                    <button type="button" class="btn btn-success" >{{ __('Click to Activate') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    var userId = "{{ $id }}"; // Get the user ID from the Blade variable
    var level = "{{ $level }}"; // Get the level from the Blade variable

    // Hide the dropdown for level 1 and show custom message instead
    if (level == 1) {
        $('#userDropdownContainer').hide(); // Hide the dropdown
        $('#activateLevelBtn').prop('disabled', true); // Disable the button since no activation can happen for level 1
    }

    // Function to fetch users for a specific level via AJAX
    function fetchUsersForLevel() {
        // Only fetch users for levels greater than 1
        if (level > 1) {
            $.ajax({
                url: "{{ route('inactive_users.getLevelUsers') }}", // The route to your controller method
                type: 'GET',
                data: {
                    user_id: userId,
                    level: level
                },
                success: function(response) {
                    if (response.data) {
                        var userDropdown = $('#userDropdown');
                        userDropdown.empty(); // Clear the existing options
                        
                        $.each(response.data, function(index, user) {
                            userDropdown.append('<option value="' + user.id + '" data-name="' + user.name + '" data-mobile="' + user.mobile + '">' + user.id + ' - ' + user.name + ' - ' + user.mobile + '</option>');
                        });
                    } else {
                        alert('No users found for the selected level.');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Failed to fetch users: ' + error);
                }
            });
        }
    }

    // Call the fetch function when the page loads for level > 1
    if (level > 1) {
        fetchUsersForLevel();
    }

   
});
</script>
