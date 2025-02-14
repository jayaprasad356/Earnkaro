

<?php $__env->startSection('page-title', __('Mobile Login')); ?>

<?php $__env->startSection('content'); ?>
    <div class="card-body">
        <div class="text-center mb-4">
            <img src="<?php echo e(asset('storage/uploads/logo/jiyo.jpeg')); ?>" alt="Logo" width="100">
        </div>

        <div>
            <center><h2 class="mb-3 f-w-600"><?php echo e(__('Login with Mobile')); ?></h2></center> 
        </div>

        <div class="custom-login-form">
            <form method="POST" action="<?php echo e(route('mobile.login')); ?>">
                <?php echo csrf_field(); ?>
                <div class="form-group mb-3">
                    <label class="form-label"><?php echo e(__('Mobile Number')); ?></label>
                    <input type="text" name="mobile" class="form-control <?php $__errorArgs = ['mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Enter your mobile number" required autofocus>
                    <?php $__errorArgs = ['mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-danger"><small><?php echo e($message); ?></small></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label"><?php echo e(__('Password')); ?></label>
                    <input type="password" name="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Enter password" required>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-danger"><small><?php echo e($message); ?></small></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="d-grid">
                    <button class="btn btn-primary mt-2" type="submit"><?php echo e(__('Login')); ?></button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel_new\resources\views/auth/mobile-login.blade.php ENDPATH**/ ?>