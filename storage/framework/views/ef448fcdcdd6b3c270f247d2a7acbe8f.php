

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Withdrawal Request')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('withdrawals.index')); ?>"><?php echo e(__('Withdrawals List')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Withdrawal Request')); ?></li>
    <br>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <!-- Wrapper with background box -->
    <div class="bg-light p-4 rounded shadow-sm">
        <div class="text-start mt-4">
            <p class="text fw-bold fs-4"><?php echo e(__('Withdrawal Request ')); ?></p>
        </div>

        <!-- CSRF token -->
        <?php echo csrf_field(); ?>
        <div class="row">
            <!-- Remaining Balance -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="balance" class="form-label"><?php echo e(__('Remaining Balance')); ?></label>
                    <input type="text" class="form-control" id="balance" value="<?php echo e(($balance)); ?>" disabled>
                </div>
            </div>

            <!-- Enter Amount -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="amount" class="form-label text-primary fw-bold"> <?php echo e(__('Enter Amount')); ?> (Minimum: ₹<?php echo e($minimum_withdrawals); ?>)</label>
                    <input type="number" class="form-control border-2 border-warning bg-light shadow-lg text-dark fw-bold" 
                        id="amount" name="amount" required placeholder="Enter amount">
                </div>
            </div>


           
        </div>

        <!-- Submit Button -->
        <div class="text-start mt-4">
            <button type="button" id="submitWithdrawalRequest" class="btn btn-success"><?php echo e(__('Submit Withdrawal Request')); ?></button>
        </div>

        <div class="text-start mt-3">
            <p class="text-muted fw-bold fs-8"><?php echo e(__('Withdrawal Request Timing Between 10am to 6pm')); ?></p>
        </div>
    </div>
</div>

<!-- JavaScript to handle form submission and wallet selection -->
<script>
    document.getElementById('submitWithdrawalRequest').addEventListener('click', function() {
        // Get the withdrawal details from the form
        let amount = document.getElementById('amount').value;
      

        // Send the withdrawal request
        fetch('<?php echo e(route("withdrawals.submit")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({
         
                amount: amount,
            
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload(); // Refresh page to show updated balance
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            alert('An error occurred. Please try again.');
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Earnkaro\resources\views/withdrawals/show.blade.php ENDPATH**/ ?>