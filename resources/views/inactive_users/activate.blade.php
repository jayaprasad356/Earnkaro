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
                    <strong>{{ __('Available Recharge : Rs') }} {{ $recharge }}</strong>
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
                    <button type="button" class="btn btn-success" id="activateUserBtn">{{ __('Click to Activate') }}</button>
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
    var userId = "{{ Session::get('user_id') }}"; // Get user_id from the session
    var level = "{{ $level }}"; // Get the level from the Blade variable
    var droplevel = Number(level) - 1;
    // Hide the dropdown for level 1 and show custom message instead
    if (level == 1) {
        $('#userDropdownContainer').hide(); // Hide the dropdown
        $('#activateLevelBtn').prop('disabled', true); // Disable the button since no activation can happen for level 1
    }

    function fetchUsersForLevel() {
    if (level > 1) {
        $.ajax({
            url: "{{ route('inactive_users.getLevelUsers') }}",
            type: 'GET',
            data: {
                user_id: userId,
                level: droplevel
            },
            success: function(response) {
                if (response.data) {
                    var userDropdown = $('#userDropdown');
                    userDropdown.empty();
                    
                    $.each(response.data, function(index, user) {
                        userDropdown.append('<option value="' + user.id + '" data-name="' + user.name + '" data-mobile="' + user.mobile + '">' + user.id + ' - ' + user.name + ' - ' + user.mobile + '</option>');
                    });
                } else {
                    alert('No users found for the selected level.');
                }
                },
                error: function(xhr, status, error) {
                    alert('No users found for the selected level.');
                }
            });
        }
    }
    if (level > 1) {
        fetchUsersForLevel();
    }

});
</script>
<script>
    $(document).ready(function() {
  $('#activateUserBtn').click(function () {
    function getQueryParam(param) {
        var urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    var selectedLevel = getQueryParam("level");
    var selectedUserId = getQueryParam("id");
    var selectedUserName = getQueryParam("name");
    var selectedUserMobile = getQueryParam("mobile");
    var selectedLevelUserId = null;

    if (selectedLevel > 1) {
        selectedLevelUserId = $("#userDropdown").val();
        selectedUserName = $("#userDropdown option:selected").data('name');
        selectedUserMobile = $("#userDropdown option:selected").data('mobile');

        if (!selectedLevelUserId) {
            alert("Please select a user from the dropdown.");
            return;
        }
    }

    if (!selectedUserId) {
        alert("No user selected for activation.");
        return;
    }

    $.ajax({
        url: "{{ route('inactive_users.activateusers') }}",
        type: 'GET',
        data: {
            id: selectedUserId,
            name: selectedUserName,
            mobile: selectedUserMobile,
            level: selectedLevel,
            level_user_id: selectedLevelUserId 
        },
        success: function (response) {
            if (response.success) {
                alert('User activated successfully!');
                window.location.href = "{{ route('inactive_users.index') }}";
            } else {
                alert('Failed to activate user. ' + response.message);
            }
        },
        error: function () {
            alert('Error activating user.');
        }
    });
});

});
</script>
