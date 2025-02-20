

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
                 <!-- <div class="col-md-3 ms-auto">
                            <label for="search"><?php echo e(__('Search All Users')); ?></label>
                            <input type="text" name="search" id="search" class="form-control"
                             value="<?php echo e(request()->get('search')); ?>" placeholder="Enter Name, Mobile">
                        </div>
                 </div> -->
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
                                <th><?php echo e(__('Age')); ?></th>
                                <th><?php echo e(__('Gender')); ?></th>
                                <th><?php echo e(__('Balance')); ?></th>
                                <th><?php echo e(__('Refer Code')); ?></th>
                                <th><?php echo e(__('Level 1 refer')); ?></th>
                                <th><?php echo e(__('Level 2 refer')); ?></th>
                                <th><?php echo e(__('Level 3 refer')); ?></th>
                                <th><?php echo e(__('Level 1 refer4')); ?></th>
                                <th><?php echo e(__('Registered DateTime')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                <td class="Action">
                                <div class="action-btn bg-info ms-2">
                                            <!-- Direct Link to Edit user Page -->
                                            <a href="<?php echo e(route('users.edit', $user->id)); ?>" class="btn btn-sm align-items-center" data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                        </div>
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
                                    <td><?php echo e($user->age); ?></td>
                                    <td><?php echo e(ucfirst($user->gender)); ?></td>
                                    <td><?php echo e($user->balance); ?></td>
                                    <td><?php echo e($user->refer_code); ?></td>
                                    <td><?php echo e($user->level_1_refer); ?></td>
                                    <td><?php echo e($user->level_2_refer); ?></td>
                                    <td><?php echo e($user->level_3_refer); ?></td>
                                    <td><?php echo e($user->level_4_refer); ?></td>
                                    <td><?php echo e($user->registered_datetime); ?></td>
                                    <td>
                                        <!-- Display Status with values 0, 1, and 2 -->
                                        <?php if($user->status == 0): ?>
                                            <i class="fa fa-clock text-warning"></i> <span class="font-weight-bold"><?php echo e(__('Pending')); ?></span>
                                        <?php elseif($user->status == 1): ?>
                                            <i class="fa fa-check-circle text-success"></i> <span class="font-weight-bold"><?php echo e(__('Verified')); ?></span>
                                        <?php elseif($user->status == 2): ?>
                                            <i class="fa fa-times-circle text-danger"></i> <span class="font-weight-bold"><?php echo e(__('Cancelled')); ?></span>
                                        <?php else: ?>
                                            <i class="fa fa-question-circle text-secondary"></i> <span class="font-weight-bold"><?php echo e(__('Unknown')); ?></span>
                                        <?php endif; ?>
                                    </td>
                              
                                    <!-- Avatar Image -->
                                    <!-- Actions -->
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Earnkaro\admin\resources\views/users/index.blade.php ENDPATH**/ ?>