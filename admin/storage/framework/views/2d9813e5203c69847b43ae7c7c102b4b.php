

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Edit Settings')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Edit Settings')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header">
                <h5><?php echo e(__('Edit Settings')); ?></h5>
            </div>
            <div class="card-body">
        <form action="<?php echo e(route('news.update', $news->id)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="form-group">
                <label for="telegram_link">Telegram Link</label>
                <input type="text" class="form-control" id="telegram_link" name="telegram_link" value="<?php echo e($news->telegram_link); ?>" required>
            </div>

            <div class="form-group">
                <label for="support_mail">Customer Support Number</label>
                <input type="number" class="form-control" id="customer_support_number" name="customer_support_number" value="<?php echo e($news->customer_support_number); ?>" required>
            </div>

            <div class="form-group">
                <label for="minimum_withdrawals">Minimum Withdrawals</label>
                <input type="number" class="form-control" id="minimum_withdrawals" name="minimum_withdrawals" value="<?php echo e($news->minimum_withdrawals); ?>" required>
            </div>

            <div class="form-group">
                <label for="whatsapp_status_income">Whatsapp Status Income</label>
                <input type="number" class="form-control" id="whatsapp_status_income" name="whatsapp_status_income" value="<?php echo e($news->whatsapp_status_income); ?>" required>
            </div>

            <div class="form-group">
                <label for="download_today_image">Download Today Image</label>
                <?php if($news->download_today_image): ?>
                    <div class="mb-3">
                        <img src="<?php echo e(asset('storage/app/public/' . $news->download_today_image)); ?>" alt="Current Image" class="img-thumbnail" style="max-width: 200px;">
                    </div>
                <?php endif; ?>
                <input type="file" class="form-control" id="download_today_image" name="download_today_image">
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
<script src="//cdn.ckeditor.com/4.21.0/full-all/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        CKEDITOR.replace('privacy_policy', {
            extraPlugins: 'colorbutton'
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Earnkaro\admin\resources\views/news/edit.blade.php ENDPATH**/ ?>