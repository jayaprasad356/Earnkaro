

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage users')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('users')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
            <form action="<?php echo e(route('users.index')); ?>" method="GET" class="mb-3">
            <div class="row align-items-end">
                <div class="col-md-3">
                    <label for="filter_date"><?php echo e(__('Filter by Date')); ?></label>
                    <input type="date" name="filter_date" id="filter_date" class="form-control" value="<?php echo e(request()->get('filter_date')); ?>" onchange="this.form.submit()">
                </div>
            </div>
            </form>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Actions')); ?></th>
                                <th><?php echo e(__('ID')); ?></th>
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Mobile')); ?></th>
                                <th><?php echo e(__('Password')); ?></th>
                                <th><?php echo e(__('Recharge')); ?></th>
                                <th><?php echo e(__('Total Recharge')); ?></th>
                                <th><?php echo e(__('Email')); ?></th>
                                <th><?php echo e(__('Age')); ?></th>
                                <th><?php echo e(__('City')); ?></th>
                                <th><?php echo e(__('State')); ?></th>
                                <th><?php echo e(__('Refer Code')); ?></th>
                                <th><?php echo e(__('Referred By')); ?></th>
                                <th><?php echo e(__('Balance')); ?></th>
                                <th><?php echo e(__('Total Income')); ?></th>
                                <th><?php echo e(__('Today Income')); ?></th>
                                <th><?php echo e(__('Earning Wallet')); ?></th>
                                <th><?php echo e(__('Bonus Wallet')); ?></th>
                                <th><?php echo e(__('Device ID')); ?></th>
                                <th><?php echo e(__('Account Number')); ?></th>
                                <th><?php echo e(__('Holder Name')); ?></th>
                                <th><?php echo e(__('Bank')); ?></th>
                                <th><?php echo e(__('Branch')); ?></th>
                                <th><?php echo e(__('IFSC')); ?></th>
                                <th><?php echo e(__('Total Assets')); ?></th>
                                <th><?php echo e(__('Total Withdrawals')); ?></th>
                                <th><?php echo e(__('Team Income')); ?></th>
                                <th><?php echo e(__('Registered Datetime')); ?></th>
                                <!-- <th><?php echo e(__('Profile')); ?></th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="Action">
                                        <!-- <div class="action-btn bg-info ms-2">
                                            <a href="<?php echo e(route('users.edit', $user->id)); ?>" class="btn btn-sm align-items-center" data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                        </div> -->
                                        <div class="action-btn bg-danger ms-2">
                                            <form method="POST" action="<?php echo e(route('users.destroy', $user->id)); ?>">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm align-items-center bs-pass-para" 
                                                        data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>"
                                                        onclick="return confirm('Are you sure you want to delete this user?');">
                                                    <i class="ti ti-trash text-white"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    <td><?php echo e($user->id); ?></td>
                                    <td><?php echo e(ucfirst($user->name)); ?></td>
                                    <td><?php echo e($user->mobile); ?></td>
                                    <td><?php echo e($user->password); ?></td>
                                    <td><?php echo e($user->recharge); ?></td>
                                    <td><?php echo e($user->total_recharge); ?></td>
                                    <td><?php echo e($user->email); ?></td>
                                    <td><?php echo e($user->age); ?></td>
                                    <td><?php echo e($user->city); ?></td>
                                    <td><?php echo e($user->state); ?></td>
                                    <td><?php echo e($user->refer_code); ?></td>
                                    <td><?php echo e($user->referred_by); ?></td>
                                    <td><?php echo e($user->balance); ?></td>
                                    <td><?php echo e($user->total_income); ?></td>
                                    <td><?php echo e($user->today_income); ?></td>
                                    <td><?php echo e($user->earning_wallet); ?></td>
                                    <td><?php echo e($user->bonus_wallet); ?></td>
                                    <td><?php echo e($user->device_id); ?></td>
                                    <td><?php echo e($user->account_num); ?></td>
                                    <td><?php echo e($user->holder_name); ?></td>
                                    <td><?php echo e($user->bank); ?></td>
                                    <td><?php echo e($user->branch); ?></td>
                                    <td><?php echo e($user->ifsc); ?></td>
                                    <td><?php echo e($user->total_assets); ?></td>
                                    <td><?php echo e($user->total_withdrawal); ?></td>
                                    <td><?php echo e($user->team_income); ?></td>
                                    <td><?php echo e($user->registered_datetime); ?></td>
                                    <!-- <td>
                                        <?php if($user->avatar && $user->avatar->image): ?>
                                            <a href="<?php echo e(asset('storage/app/public/' . $user->avatar->image)); ?>" data-lightbox="image-<?php echo e($user->avatar->id); ?>">
                                                <img class="user-img img-thumbnail img-fluid" 
                                                    src="<?php echo e(asset('storage/app/public/' . $user->avatar->image)); ?>" 
                                                    alt="Avatar Image" 
                                                    style="max-width: 100px; max-height: 100px;">
                                            </a>
                                        <?php else: ?>
                                            <?php echo e(__('No Avatar')); ?>

                                        <?php endif; ?>
                                    </td> -->
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">

<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#pc-dt-simple').DataTable();
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel_new\resources\views/users/index.blade.php ENDPATH**/ ?>