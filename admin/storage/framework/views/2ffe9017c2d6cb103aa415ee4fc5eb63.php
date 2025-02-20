

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Edit user')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('users.index')); ?>"><?php echo e(__('users')); ?></a></li>
<?php $__env->stopSection(); ?>
<style>
    /* Style for Switch */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .switch label {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 34px;
    }

    .switch label:before {
        content: "";
        position: absolute;
        left: -3px;
        top: 4px;
        width: 26px;
        height: 26px;
        background-color: white;
        border-radius: 50%;
        transition: 0.4s;
    }

    /* When checked, move the slider */
    .switch input:checked + label {
        background-color: #4CAF50;
    }

    .switch input:checked + label:before {
        transform: translateX(26px);
    }

    /* Disabled state */
    .switch input:disabled + label {
        background-color: #e0e0e0;
    }

    .switch input:disabled + label:before {
        background-color: #bdbdbd;
    }

    .form-group .switch-container {
        display: flex;
        align-items: center;
    }

    .form-group .switch-container label {
        margin-left: 10px;
    }
</style>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header">
                 <!-- Open Modal for Add Coins -->
                 <a href="#" data-bs-toggle="modal" data-bs-target="#addRechargeModal" class="btn btn-primary ms-auto"><?php echo e(__('Add Recharge')); ?></a>
                <a href="#" data-bs-toggle="modal" data-bs-target="#addBalanceModal" class="btn btn-success ms-auto"><?php echo e(__('Add Balance')); ?></a>
            </div>

            <div class="card-body">
                <?php echo e(Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data'])); ?>


                <div class="modal-body">
                    <div class="row">
                        <!-- Avatar Dropdown -->
                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('name', __('Name'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('name', null, ['class' => 'form-control', 'required'])); ?>

                        </div>

                        <!-- Mobile Number -->
                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('mobile', __('Mobile'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('mobile', null, ['class' => 'form-control', 'required'])); ?>

                        </div>

                        <!-- Age -->
                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('age', __('Age'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::number('age', null, ['class' => 'form-control'])); ?>

                        </div>


                        <div class="form-group col-md-6">
                        <label for="gender"><?php echo e(__('Gender')); ?></label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value=""><?php echo e(__('Select Gender')); ?></option>
                            <option value="male" <?php echo e($user->gender == 'male' ? 'selected' : ''); ?>><?php echo e(__('male')); ?></option>
                            <option value="female" <?php echo e($user->gender == 'female' ? 'selected' : ''); ?>><?php echo e(__('female')); ?></option>
                        </select>
                        <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group col-md-6">
                            <?php echo e(Form::label('pincode', __('Pincode'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::number('pincode', null, ['class' => 'form-control'])); ?>

                        </div>


                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('balance', __('Balance'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::number('balance', null, ['class' => 'form-control'])); ?>

                        </div>


                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('recharge', __('Recharge'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::number('recharge', null, ['class' => 'form-control'])); ?>

                        </div>

                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('Refer Code', __('Refer Code'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('refer_code', null, ['class' => 'form-control'])); ?>

                        </div>

                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('Level 1 Refer', __('Level 1 Refer'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('level_1_refer', null, ['class' => 'form-control'])); ?>

                        </div>

                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('Level 2 Refer', __('Level 2 Refer'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('level_2_refer', null, ['class' => 'form-control'])); ?>

                        </div>

                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('Level 3 Refer', __('Level 3 Refer'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('level_3_refer', null, ['class' => 'form-control'])); ?>

                        </div>

                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('Level 4 Refer', __('Level 4 Refer'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('level_4_refer', null, ['class' => 'form-control'])); ?>

                        </div>

                        <div class="form-group col-md-6">
                            <br>
                            <?php echo e(Form::label('status', __('Status'), ['class' => 'form-label'])); ?>

                            <div class="btn-group" role="group" aria-label="Status">
                                <input type="radio" class="btn-check" name="status" id="status_pending" value="0" <?php echo e($user->status == 0 ? 'checked' : ''); ?>>
                                <label class="btn btn-outline-warning" for="status_pending"><?php echo e(__('Pending')); ?></label>

                                <input type="radio" class="btn-check" name="status" id="status_verified" value="1" <?php echo e($user->status == 1 ? 'checked' : ''); ?>>
                                <label class="btn btn-outline-success" for="status_verified"><?php echo e(__('Verified')); ?></label>

                                <input type="radio" class="btn-check" name="status" id="status_blocked" value="2" <?php echo e($user->status == 2 ? 'checked' : ''); ?>>
                                <label class="btn btn-outline-danger" for="status_blocked"><?php echo e(__('Cancelled')); ?></label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn btn-light" data-bs-dismiss="modal">
                    <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn btn-primary">
                </div>

                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>
</div>

<!-- Modal for Add Coins -->
<div class="modal fade" id="addRechargeModal" tabindex="-1" aria-labelledby="addCoinsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRechargeModalLabel"><?php echo e(__('Add Recharge to user')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo e(route('users.addRecharge', $user->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="recharge"><?php echo e(__('Recharge to Add')); ?></label>
                        <input type="number" id="recharge" name="recharge" class="form-control" required>
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary"><?php echo e(__('Add Recharge')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addBalanceModal" tabindex="-1" aria-labelledby="addBalanceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBalanceModalLabel"><?php echo e(__('Add Balance to user')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo e(route('users.addBalance', $user->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="coins"><?php echo e(__('Balance to Add')); ?></label>
                        <input type="number" id="balance" name="balance" class="form-control" required>
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary"><?php echo e(__('Add Balance')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Earnkaro\admin\resources\views/users/edit.blade.php ENDPATH**/ ?>