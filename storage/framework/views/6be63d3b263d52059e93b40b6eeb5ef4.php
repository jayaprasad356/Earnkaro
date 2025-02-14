<?php

    $logo = \App\Models\Utility::get_file('uploads/logo/');
    $company_logo = \App\Models\Utility::GetLogo();
    $companys = \App\Models\Utility::GetLogo();
    $user = \Auth::user();
    $profile = \App\Models\Utility::get_file('uploads/avatar/');
  
    $emailTemplate = App\Models\EmailTemplate::getemailTemplate();
    
?>

<?php if(isset($setting['cust_theme_bg']) && $setting['cust_theme_bg'] == 'on'): ?>
    <nav class="dash-sidebar light-sidebar transprent-bg">
    <?php else: ?>
        <nav class="dash-sidebar light-sidebar">
<?php endif; ?>



<div class="navbar-wrapper">
    <div class="m-header main-logo">
        <a href="<?php echo e(route('dashboard')); ?>" class="b-brand">
            <!-- ========   change your logo hear   ============ -->
            <img src="<?php echo e(asset('storage/uploads/logo/jiyo.jpeg')); ?>" alt="Logo"
                alt="<?php echo e(config('app.name', 'HRMGo')); ?>" class="logo logo-lg" style="height: 50px;">
        </a>
    </div>
    <div class="navbar-content">
        <ul class="dash-navbar">

            <!-- dashboard-->
                <li class="dash-item">
                    <a href="<?php echo e(route('dashboard')); ?>" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-home"></i></span><span class="dash-mtext"><?php echo e(__('Dashboard')); ?></span></a>
                </li>
        
            
                <li class="dash-item">
                    <a href="<?php echo e(route('level_1.index')); ?>" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-users"></i></span>
                        <span class="dash-mtext"><?php echo e(__('Level 1')); ?></span>
                    </a>
                </li>

                <li class="dash-item">
                    <a href="<?php echo e(route('level_2.index')); ?>" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-users"></i></span>
                        <span class="dash-mtext"><?php echo e(__('Level 2')); ?></span>
                    </a>
                </li>

                <li class="dash-item">
                    <a href="<?php echo e(route('level_3.index')); ?>" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-users"></i></span>
                        <span class="dash-mtext"><?php echo e(__('Level 3')); ?></span>
                    </a>
                </li>

          
            <!--dashboard-->


     
            <!--------------------- Start System Setup ----------------------------------->

       

            <!--------------------- End System Setup ----------------------------------->
</ul>

</div>
</div>
</nav>
<?php /**PATH C:\xampp\htdocs\laravel_new\resources\views/partial/Admin/menu.blade.php ENDPATH**/ ?>