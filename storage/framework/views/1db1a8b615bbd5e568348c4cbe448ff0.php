

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Bank Details')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('bankdetails.update')); ?>"><?php echo e(__('Bank Details')); ?></a></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><?php echo e(__('Update Bank Details')); ?></h4>

                <!-- Display success or error messages -->
                <?php if(session('success')): ?>
                    <div class="alert alert-success" id="success-message"><?php echo e(session('success')); ?></div>
                <?php endif; ?>
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger" id="error-message">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Bank Details Form -->
                <form action="<?php echo e(route('bankdetails.update')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('Account Number')); ?></label>
                        <input type="text" name="account_num" class="form-control" value="<?php echo e($user->account_num ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('Holder Name')); ?></label>
                        <input type="text" name="holder_name" class="form-control" value="<?php echo e($user->holder_name ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('Bank Name')); ?></label>
                        <input type="text" name="bank" class="form-control" value="<?php echo e($user->bank ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('Branch')); ?></label>
                        <input type="text" name="branch" class="form-control" value="<?php echo e($user->branch ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('IFSC Code')); ?></label>
                        <input type="text" name="ifsc" class="form-control" value="<?php echo e($user->ifsc ?? ''); ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary"><?php echo e(__('Update Bank Details')); ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
            var errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }, 4000); // 4000 milliseconds = 4 seconds
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Earnkaro\resources\views/bankdetails/update.blade.php ENDPATH**/ ?>