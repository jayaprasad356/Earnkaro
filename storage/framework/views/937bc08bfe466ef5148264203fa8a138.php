

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Dashboard')); ?>

<?php $__env->stopSection(); ?>

<?php
    $setting = App\Models\Utility::settings();
?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php if(session('status')): ?>
            <div class="alert alert-success" role="alert">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <div class="col-xxl-12">
            <div class="row">

                <!-- Total Income Box -->
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-auto mb-3 mb-sm-0">
                                    <div class="d-flex align-items-center">
                                        <div class="theme-avtar bg-success">
                                            <i class="ti ti-wallet"></i>
                                        </div>
                                        <div class="ms-3">
                                            <small class="text-muted"><?php echo e(__('Total')); ?></small>
                                            <h6 class="m-0"><?php echo e(__('Income')); ?></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto text-end">
                                    <h4 class="m-0 text-success"><?php echo e(number_format($total_income, 2)); ?></h4>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <a  class="btn btn-success">
                                    <?php echo e(__('Enter Amount')); ?>

                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Balance Box -->
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-auto mb-3 mb-sm-0">
                                    <div class="d-flex align-items-center">
                                        <div class="theme-avtar bg-info">
                                            <i class="ti ti-credit-card"></i>
                                        </div>
                                        <div class="ms-3">
                                            <small class="text-muted"><?php echo e(__('Current')); ?></small>
                                            <h6 class="m-0"><?php echo e(__('Balance')); ?></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto text-end">
                                    <h4 class="m-0 text-info"><?php echo e(number_format($balance, 2)); ?></h4>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <a class="btn btn-info">
                                    <?php echo e(__('Enter Amount')); ?>

                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recharge Value Box -->
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-auto mb-3 mb-sm-0">
                                    <div class="d-flex align-items-center">
                                        <div class="theme-avtar bg-warning">
                                            <i class="ti ti-receipt"></i>
                                        </div>
                                        <div class="ms-3">
                                            <small class="text-muted"><?php echo e(__('Total')); ?></small>
                                            <h6 class="m-0"><?php echo e(__('Recharges')); ?></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto text-end">
                                    <h4 class="m-0 text-warning"><?php echo e(number_format($recharge_value, 2)); ?></h4>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <a  class="btn btn-warning">
                                    <?php echo e(__('Enter Amount')); ?>

                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel_new\resources\views/dashboard/dashboard.blade.php ENDPATH**/ ?>