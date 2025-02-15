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
                    <a href="{{ route('level_1.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-users"></i></span>
                        <span class="dash-mtext">{{ __('Level 1') }}</span>
                    </a>
                </li>

                <li class="dash-item">
                    <a href="{{ route('level_2.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-users"></i></span>
                        <span class="dash-mtext">{{ __('Level 2') }}</span>
                    </a>
                </li>

                <li class="dash-item">
                    <a href="{{ route('level_3.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-users"></i></span>
                        <span class="dash-mtext">{{ __('Level 3') }}</span>
                    </a>
                </li>

                <li class="dash-item">
                    <a href="{{ route('works.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-users"></i></span>
                        <span class="dash-mtext">{{ __('Works') }}</span>
                    </a>
                </li>

          
            <!--dashboard-->


     
            <!--------------------- Start System Setup ----------------------------------->

       

            <!--------------------- End System Setup ----------------------------------->
</ul>

</div>
</div>
</nav>
