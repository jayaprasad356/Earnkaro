


<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Works List')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Works List')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-12">
              <!-- Default Image Download Button -->
              <?php if($news && $news->download_today_image): ?>
                <div class="mb-3">
                    <a href="<?php echo e(asset('admin/storage/app/public/' . $news->download_today_image)); ?>" download="news_image_<?php echo e($news->id); ?>.jpg">
                        <i class="fa fa-download"></i> <?php echo e(__('Download Default Image')); ?>

                    </a>
                </div>
            <?php endif; ?>

         <form action="<?php echo e(route('works.upload')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="image"><?php echo e(__('Upload Image')); ?></label>
                        <input type="file" class="form-control" name="image" id="image" required>
                    </div>
                    
                    <input type="hidden" name="user_id" value="<?php echo e(session('user_id', '')); ?>">
                    <input type="hidden" name="status" value="0">

                    <button type="submit" class="btn btn-success"><?php echo e(__('Submit')); ?></button>
                </form>
                <br>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th><?php echo e(__('ID')); ?></th>
                                <th><?php echo e(__('User Name')); ?></th>
                                <th><?php echo e(__('Mobile')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Image')); ?></th>
                                <!-- <th><?php echo e(__('Download')); ?></th> -->
                                <th><?php echo e(__('DateTime')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $works; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $work): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($work['id']); ?></td>
                                    <td><?php echo e($work->user->name ?? 'N/A'); ?></td>
                                    <td><?php echo e($work->user->mobile ?? 'N/A'); ?></td>
                                    <td>
                                        <?php if($work->status == 0): ?>
                                            <i class="fa fa-clock text-warning"></i> <span class="font-weight-bold"><?php echo e(__('Not-Verified')); ?></span>
                                        <?php elseif($work->status == 1): ?>
                                            <i class="fa fa-check-circle text-success"></i> <span class="font-weight-bold"><?php echo e(__('Verified')); ?></span>
                                        <?php elseif($work->status == 2): ?>
                                            <i class="fa fa-times-circle text-danger"></i> <span class="font-weight-bold"><?php echo e(__('Rejected')); ?></span>
                                        <?php else: ?>
                                            <i class="fa fa-question-circle text-secondary"></i> <span class="font-weight-bold"><?php echo e(__('Unknown')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($work->image): ?>
                                            <a href="<?php echo e(asset('storage/app/public/' . $work->image)); ?>" data-lightbox="image-<?php echo e($work->id); ?>">
                                                <img class="user-img img-thumbnail img-fluid" 
                                                    src="<?php echo e(asset('storage/app/public/' . $work->image)); ?>" 
                                                    alt="Image" 
                                                    style="max-width: 100px; max-height: 100px;">
                                            </a>
                                        <?php else: ?>
                                            <img class="user-img img-thumbnail img-fluid" 
                                                src="<?php echo e(asset('storage/default.jpg')); ?>" 
                                                alt="Default Image" 
                                                style="max-width: 100px; max-height: 100px;">
                                        <?php endif; ?>
                                    </td>
                                    <!-- <td>
                                        <a href="<?php echo e(asset($work->image ? 'storage/app/public/' . $work->image : 'storage/default.jpg')); ?>" 
                                           download="work_image_<?php echo e($work->id); ?>.jpg" 
                                           class="btn btn-primary btn-sm">
                                            <?php echo e(__('Download Image')); ?>

                                        </a>
                                    </td> -->
                                    <td><?php echo e($work['datetime'] ?? 'N/A'); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('image-preview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Earnkaro\resources\views/works/index.blade.php ENDPATH**/ ?>