

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Invite Friends List')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Invite Friends List')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-body text">
        <h5 class="card-title"><?php echo e(__('Invite Your Friends')); ?></h5>
        
        <br>
        <!-- Copy Invitation Link -->
        <button class="btn btn-primary d-block w-50 mb-2" onclick="copyInvitationLink()">
            <?php echo e(__('Copy Invitation Link')); ?>

        </button>
        
        <!-- Join Telegram Channel -->
        <a href="<?php echo e($telegram_channel); ?>" target="_blank" class="btn btn-info d-block w-50 mb-2">
            <?php echo e(__('Join Telegram Channel')); ?>

        </a>

        <!-- Contact Customer Support -->
        <a href="mailto:<?php echo e($customer_support); ?>" class="btn btn-warning d-block w-50 mb-2">
            <?php echo e(__('Contact Customer Support')); ?>

        </a>
    </div>
</div>

<script>
    function copyInvitationLink() {
        // Create a temporary input field to copy the invitation link
        const tempInput = document.createElement('input');
        document.body.appendChild(tempInput);
        tempInput.value = "<?php echo e($invitation_link); ?>"; // Add the invitation link
        tempInput.select();
        document.execCommand('copy'); // Copy the text to clipboard
        document.body.removeChild(tempInput);

        // Optional: Notify the user that the link has been copied
        alert("Invitation Link copied to clipboard!");
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Earnkaro\resources\views/invite_friends/index.blade.php ENDPATH**/ ?>