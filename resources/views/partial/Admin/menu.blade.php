@php

    $logo = \App\Models\Utility::get_file('uploads/logo/');
    $company_logo = \App\Models\Utility::GetLogo();
    $companys = \App\Models\Utility::GetLogo();
    $user = \Auth::user();
    $profile = \App\Models\Utility::get_file('uploads/avatar/');
  
    $emailTemplate = App\Models\EmailTemplate::getemailTemplate();
    
@endphp

@if (isset($setting['cust_theme_bg']) && $setting['cust_theme_bg'] == 'on')
    <nav class="dash-sidebar light-sidebar transprent-bg">
    @else
        <nav class="dash-sidebar light-sidebar">
@endif

{{-- <nav class="dash-sidebar light-sidebar {{ isset($cust_theme_bg) && $cust_theme_bg == 'on' ? 'transprent-bg' : '' }}"> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/themify-icons/0.1.2/css/themify-icons.css">

<div class="navbar-wrapper">
    <div class="m-header main-logo">
        <a href="{{ route('dashboard') }}" class="b-brand">
            <!-- ========   change your logo hear   ============ -->
            <img src="{{ asset('storage/uploads/logo/jiyo.jpeg') }}" alt="Logo"
                alt="{{ config('app.name', 'HRMGo') }}" class="logo logo-lg" style="height: 50px;">
        </a>
    </div>
    <div class="navbar-content">
        <ul class="dash-navbar">

            <!-- dashboard-->
                <li class="dash-item">
                    <a href="{{ route('dashboard') }}" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-home"></i></span><span class="dash-mtext">{{ __('Dashboard') }}</span></a>
                </li>
        
                <li class="dash-item">
                <a href="#" class="dash-link" id="levels-toggle">
                    <span class="dash-micon"><i class="ti ti-building"></i></span>
                    <span class="dash-mtext">{{ __('Levels') }}</span>
                </a>
                <ul class="list-unstyled" id="levels-menu" style="display: none;">
                    <li>
                        <a href="{{ route('level_1.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-users"></i></span>
                            <span class="dash-mtext">{{ __('Level 1') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('level_2.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-users"></i></span>
                            <span class="dash-mtext">{{ __('Level 2') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('level_3.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-users"></i></span>
                            <span class="dash-mtext">{{ __('Level 3') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('level_4.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-users"></i></span>
                            <span class="dash-mtext">{{ __('Level 4') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
               

                <li class="dash-item">
                    <a href="{{ route('works.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-briefcase"></i></span> <!-- Briefcase icon for works -->
                        <span class="dash-mtext">{{ __('Works') }}</span>
                    </a>
                </li>

                <li class="dash-item">
                    <a href="{{ route('inactive_users.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-users"></i></span> <!-- User-slash icon for inactive users -->
                        <span class="dash-mtext">{{ __('My Inactive Users') }}</span>
                    </a>
                </li>

                <li class="dash-item">
                    <a href="{{ route('invite_friends.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-user-plus"></i></span> <!-- User-plus icon for invite friends -->
                        <span class="dash-mtext">{{ __('Invite Friends') }}</span>
                    </a>
                </li>

                <li class="dash-item">
                <a href="{{ route('transactions.index') }}" class="dash-link">
                    <span class="dash-micon">
                        <i class="ti ti-credit-card"></i> <!-- Icon for transactions -->
                    </span>
                    <span class="dash-mtext">{{ __('Transactions') }}</span>
                </a>

                <li class="dash-item">
                <a href="{{ route('withdrawals.index') }}" class="dash-link">
                    <span class="dash-micon">
                        <i class="ti ti-wallet"></i> <!-- Icon for withdrawals -->
                    </span>
                    <span class="dash-mtext">{{ __('Withdrawals') }}</span>
                </a>
                </li>


          
            <!--dashboard-->


     
            <!--------------------- Start System Setup ----------------------------------->

       

            <!--------------------- End System Setup ----------------------------------->
</ul>

</div>
</div>
</nav>
<script>
document.getElementById('levels-toggle').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default link behavior
    var submenu = document.getElementById('levels-menu');
    submenu.style.display = (submenu.style.display === 'none' || submenu.style.display === '') ? 'block' : 'none';
});
</script>