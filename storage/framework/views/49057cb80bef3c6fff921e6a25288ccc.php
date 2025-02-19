

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
                                        <div class="ms-2">
                                            <small class="text-muted"><?php echo e(__('Monthly')); ?></small>
                                            <h6 class="m-0"><?php echo e(__('Salary')); ?></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto text-end">
                                    <h4 class="m-0 text-success"><?php echo e(number_format($monthly_salary, 2)); ?></h4>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                            <a href="javascript:void(0);" class="btn btn-success" onclick="addToBalance('monthly_salary', <?php echo e($monthly_salary); ?>)">
                                    <?php echo e(__('Add to Withdrawals')); ?>

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
                                        <div class="ms-2">
                                            <small class="text-muted"><?php echo e(__('Level')); ?></small>
                                            <h6 class="m-0"><?php echo e(__('Income')); ?></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto text-end">
                                    <h4 class="m-0 text-info"><?php echo e(number_format($level_income, 2)); ?></h4>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                            <a href="javascript:void(0);" class="btn btn-info" onclick="addToBalance('level_income', <?php echo e($level_income); ?>)">
                                    <?php echo e(__('Add to Withdrawals')); ?>

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
                                        <div class="ms-2">
                                            <small class="text-muted"><?php echo e(__('Refer')); ?></small>
                                            <h6 class="m-0"><?php echo e(__('Income')); ?></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto text-end">
                                    <h4 class="m-0 text-warning"><?php echo e(number_format($refer_income, 2)); ?></h4>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                            <a href="javascript:void(0);" class="btn btn-warning" onclick="addToBalance('refer_income', <?php echo e($refer_income); ?>)">
                                    <?php echo e(__('Add to Withdrawals')); ?>

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
                                        <div class="theme-avtar bg-danger">
                                            <i class="ti ti-credit-card"></i>
                                        </div>
                                        <div class="ms-2">
                                            <small class="text-muted"><?php echo e(__('Whatsapp Status ')); ?></small>
                                            <h6 class="m-0"><?php echo e(__('Income')); ?></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto text-end">
                                    <h4 class="m-0 text-danger"><?php echo e(number_format($whatsapp_status_income, 2)); ?></h4>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                            <a href="javascript:void(0);" class="btn btn-danger" onclick="addToBalance('whatsapp_status_income', <?php echo e($whatsapp_status_income); ?>)">
                                    <?php echo e(__('Add to Withdrawals')); ?>

                                </a>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<script>
function addToBalance(type, amount) {
    $.ajax({
        url: "<?php echo e(route('balance.add')); ?>",
        type: "POST",
        data: {
            _token: "<?php echo e(csrf_token()); ?>",
            type: type,
            amount: amount
        },
        success: function(response) {
            if (response.success) {
                alert(response.message);
                location.reload();
            } else {
                alert(response.message);
            }
        },
        error: function() {
            alert("Something went wrong. Try again!");
        }
    });
}
</script>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Earnkaro\resources\views/dashboard/dashboard.blade.php ENDPATH**/ ?>