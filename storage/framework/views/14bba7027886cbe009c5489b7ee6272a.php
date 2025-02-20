

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Withdrawals List')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Withdrawals List')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <!-- Filter by Type Form -->
                <form action="<?php echo e(route('withdrawals.index')); ?>" method="GET" class="mb-3">
                    <div class="row align-items-end">
          

                        <div class="col-md offset-md-3 d-flex justify-content-end">
                        <a href="<?php echo e(route('withdrawals.show')); ?>" class="btn btn-primary">
                                <?php echo e(__('Withdrawal Request')); ?>

                            </a>
                        </div>

                    </div>
                </form>


                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    
                                    <th><?php echo e(__('Amount')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <th><?php echo e(__('Bank')); ?></th>
                                    <th><?php echo e(__('Branch')); ?></th>
                                    <th><?php echo e(__('Ifsc Code')); ?></th>
                                    <th><?php echo e(__('Account Number')); ?></th>
                                    <th><?php echo e(__('Holder Name')); ?></th>
                                    <th><?php echo e(__('Datetime')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $withdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                       
                                        <td><?php echo e($withdrawal->amount); ?></td>
                                        <td>
                                            <?php if($withdrawal->status == 0): ?>
                                                <i class="fa fa-clock text-warning"></i> <span class="font-weight-bold"><?php echo e(__('Pending')); ?></span>
                                            <?php elseif($withdrawal->status == 1): ?>
                                                <i class="fa fa-check-circle text-success"></i> <span class="font-weight-bold"><?php echo e(__('Paid')); ?></span>
                                            <?php elseif($withdrawal->status == 2): ?>
                                                <i class="fa fa-times-circle text-danger"></i> <span class="font-weight-bold"><?php echo e(__('Cancelled')); ?></span>
                                            <?php else: ?>
                                                <i class="fa fa-question-circle text-secondary"></i> <span class="font-weight-bold"><?php echo e(__('Unknown')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($withdrawal->users->bank ?? ''); ?></td>
                                        <td><?php echo e($withdrawal->users->branch ?? ''); ?></td>
                                        <td><?php echo e($withdrawal->users->ifsc ?? ''); ?></td>
                                        <td><?php echo e($withdrawal->users->account_num ?? ''); ?></td>
                                        <td><?php echo e($withdrawal->users->holder_name ?? ''); ?></td>
                                        <td><?php echo e($withdrawal->datetime); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Earnkaro\resources\views/withdrawals/index.blade.php ENDPATH**/ ?>