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


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/themify-icons/0.1.2/css/themify-icons.css">

<div class="navbar-wrapper">
    <div class="m-header main-logo">
        <a href="<?php echo e(route('dashboard')); ?>" class="b-brand">
            <!-- ========   change your logo hear   ============ -->
            <img src="<?php echo e(asset('storage/uploads/logo/greenkaro.png')); ?>" alt="Logo"
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
                    <a href="#" class="dash-link" id="levels-toggle">
                        <span class="dash-micon"><i class="ti ti-building"></i></span>
                        <span class="dash-mtext"><?php echo e(__('Levels')); ?></span>
                    </a>
                    <ul class="list-unstyled" id="levels-menu" style="display: none; padding-left: 60px; list-style-type: disc;">
                        <li>
                            <a href="<?php echo e(route('level_1.index')); ?>" class="dash-link">
                                <span class="dash-mtext"><?php echo e(__('Level 1')); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('level_2.index')); ?>" class="dash-link">
                                <span class="dash-mtext"><?php echo e(__('Level 2')); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('level_3.index')); ?>" class="dash-link">
                                <span class="dash-mtext"><?php echo e(__('Level 3')); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('level_4.index')); ?>" class="dash-link">
                                <span class="dash-mtext"><?php echo e(__('Level 4')); ?></span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="dash-item">
                    <a href="<?php echo e(route('works.index')); ?>" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-briefcase"></i></span> <!-- Briefcase icon for works -->
                        <span class="dash-mtext"><?php echo e(__('Works')); ?></span>
                    </a>
                </li>

                <li class="dash-item">
                    <a href="<?php echo e(route('inactive_users.index')); ?>" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-users"></i></span> <!-- User-slash icon for inactive users -->
                        <span class="dash-mtext"><?php echo e(__('My Inactive Users')); ?></span>
                    </a>
                </li>

                <li class="dash-item">
                    <a href="<?php echo e(route('my_products.index')); ?>" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-users"></i></span> 
                        <span class="dash-mtext"><?php echo e(__('My Products')); ?></span>
                    </a>
                </li>

                <li class="dash-item">
                    <a href="<?php echo e(route('invite_friends.index')); ?>" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-user-plus"></i></span> <!-- User-plus icon for invite friends -->
                        <span class="dash-mtext"><?php echo e(__('Help & Support')); ?></span>
                    </a>
                </li>

                <li class="dash-item">
                <a href="<?php echo e(route('bankdetails.update')); ?>" class="dash-link">
                    <span class="dash-micon">
                        <i class="ti ti-wallet"></i> <!-- Icon for withdrawals -->
                    </span>
                    <span class="dash-mtext"><?php echo e(__('Bank Details')); ?></span>
                </a>
                </li>


                <li class="dash-item">
                <a href="<?php echo e(route('transactions.index')); ?>" class="dash-link">
                    <span class="dash-micon">
                        <i class="ti ti-wallet"></i> <!-- Icon for withdrawals -->
                    </span>
                    <span class="dash-mtext"><?php echo e(__('Transactions')); ?></span>
                </a>
                </li>

                <li class="dash-item">
                <a href="<?php echo e(route('withdrawals.index')); ?>" class="dash-link">
                    <span class="dash-micon">
                        <i class="ti ti-wallet"></i> <!-- Icon for withdrawals -->
                    </span>
                    <span class="dash-mtext"><?php echo e(__('Withdrawals')); ?></span>
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
</script><?php /**PATH C:\xampp\htdocs\Earnkaro\resources\views/partial/Admin/menu.blade.php ENDPATH**/ ?>