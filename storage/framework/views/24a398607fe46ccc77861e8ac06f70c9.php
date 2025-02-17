

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Activate User')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('inactive_users.activate')); ?>"><?php echo e(__('Activate User')); ?></a></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <!-- Display Available Recharge Balance -->
                <div class="recharge-balance" style="position: absolute; top: 10px; right: 10px; font-size: 16px; background-color: #f1f1f1; padding: 5px 10px; border-radius: 5px;">
                    <strong><?php echo e(__('Available Recharge Balance: Rs')); ?> <?php echo e($balance); ?></strong>
                </div>

                <!-- Display the user details -->
                <p><strong><?php echo e(__('User ID:')); ?></strong> <?php echo e($id); ?> | <strong><?php echo e(__('Name:')); ?></strong> <?php echo e($userName); ?> | <strong><?php echo e(__('Mobile:')); ?></strong> <?php echo e($userMobile); ?></p>

                <!-- Display the level-specific activation button -->
                <div class="mt-4">
                    <h5><?php echo e(__('Activate for Level ')); ?> <?php echo e($level); ?></h5>

                    <?php if(request()->query('level') > 1): ?>
                        <div class="mt-4" id="userDropdownContainer">
                            <select class="form-select" id="userDropdown" style="width: 50%;"> 
                                <?php if(request()->query('level') == 2): ?>
                                    <option value=""><?php echo e(__('Choose Your Level 1 Users')); ?></option>
                                <?php elseif(request()->query('level') == 3): ?>
                                    <option value=""><?php echo e(__('Choose Your Level 2 Users')); ?></option>
                                <?php elseif(request()->query('level') == 4): ?>
                                    <option value=""><?php echo e(__('Choose Your Level 3 Users')); ?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                    <?php elseif(request()->query('level') == 1): ?>
                       
                    <?php endif; ?>

                    <br>
                    <button type="button" class="btn btn-success" ><?php echo e(__('Click to Activate')); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    var userId = "<?php echo e($id); ?>"; // Get the user ID from the Blade variable
    var level = "<?php echo e($level); ?>"; // Get the level from the Blade variable

    // Hide the dropdown for level 1 and show custom message instead
    if (level == 1) {
        $('#userDropdownContainer').hide(); // Hide the dropdown
        $('#activateLevelBtn').prop('disabled', true); // Disable the button since no activation can happen for level 1
    }

    // Function to fetch users for a specific level via AJAX
    function fetchUsersForLevel() {
        // Only fetch users for levels greater than 1
        if (level > 1) {
            $.ajax({
                url: "<?php echo e(route('inactive_users.getLevelUsers')); ?>", // The route to your controller method
                type: 'GET',
                data: {
                    user_id: userId,
                    level: level
                },
                success: function(response) {
                    if (response.data) {
                        var userDropdown = $('#userDropdown');
                        userDropdown.empty(); // Clear the existing options
                        
                        $.each(response.data, function(index, user) {
                            userDropdown.append('<option value="' + user.id + '" data-name="' + user.name + '" data-mobile="' + user.mobile + '">' + user.id + ' - ' + user.name + ' - ' + user.mobile + '</option>');
                        });
                    } else {
                        alert('No users found for the selected level.');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Failed to fetch users: ' + error);
                }
            });
        }
    }

    // Call the fetch function when the page loads for level > 1
    if (level > 1) {
        fetchUsersForLevel();
    }

   
});
</script>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Earnkaro\resources\views/inactive_users/activate.blade.php ENDPATH**/ ?>