

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('My Inactive Users List')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('My Inactive Users List')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="recharge-balance" style="position: absolute; top: 10px; right: 10px; font-size: 16px; background-color: #f1f1f1; padding: 5px 10px; border-radius: 5px;">
                    <strong><?php echo e(__('Available Recharge Balance: Rs')); ?> <?php echo e($recharge); ?></strong>
                </div>
                <br><br>
                <div class="text-end">
                    <a href="<?php echo e(route('inactive_users.addusers')); ?>" class="btn btn-primary"><?php echo e(__('New User')); ?></a>
                </div>
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th><?php echo e(__('ID')); ?></th>
                                <th><?php echo e(__('User Name')); ?></th>
                                <th><?php echo e(__('Mobile')); ?></th>
                                <th><?php echo e(__('DateTime')); ?></th>
                                <th><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($user['id']); ?></td>
                                    <td><?php echo e($user['name'] ?? 'N/A'); ?></td>
                                    <td><?php echo e($user['mobile'] ?? 'N/A'); ?></td>
                                    <td><?php echo e($user['registered_datetime'] ?? 'N/A'); ?></td>
                                    <td>
                                        <!-- Button to trigger modal -->
                                        <button type="button" class="btn btn-success btn-sm activate-user-btn" 
                                            data-id="<?php echo e($user['id']); ?>" 
                                            data-name="<?php echo e($user['name'] ?? 'N/A'); ?>" 
                                            data-mobile="<?php echo e($user['mobile'] ?? 'N/A'); ?>">
                                            <?php echo e(__('Click To Activate')); ?>

                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Bootstrap Modal -->
                <div class="modal fade" id="userActivationModal" tabindex="-1" aria-labelledby="userActivationModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="userActivationModalLabel"><?php echo e(__('User Details')); ?></h5>
                                <!-- Button to close modal -->
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p><strong><?php echo e(__('User ID:')); ?></strong> <span id="modalUserId"></span> | <strong><?php echo e(__('Name:')); ?></strong> <span id="modalUserName"></span> | <strong><?php echo e(__('Mobile:')); ?></strong> <span id="modalUserMobile"></span></p>

                                <!-- Level-specific activation buttons -->
                                <div class="mt-3">
                                    <center><button type="button" class="btn btn-primary w-50 mb-2" id="level1Btn"><?php echo e(__('Level 1')); ?></button></center>
                                    <center><button type="button" class="btn btn-secondary w-50 mb-2" id="level2Btn"><?php echo e(__('Level 2')); ?></button></center>
                                    <center><button type="button" class="btn btn-warning w-50 mb-2" id="level3Btn"><?php echo e(__('Level 3')); ?></button></center>
                                    <center><button type="button" class="btn btn-danger w-50 mb-2" id="level4Btn"><?php echo e(__('Level 4')); ?></button></center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Ensure jQuery is loaded -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> <!-- Bootstrap JS -->

<script>
    $(document).ready(function () {
    // When "Activate User" button is clicked
    $(".activate-user-btn").on("click", function () {
        let userId = $(this).data("id");
        let userName = $(this).data("name");
        let userMobile = $(this).data("mobile");

        // Update modal content with the selected user's info
        $("#modalUserId").text(userId);
        $("#modalUserName").text(userName);
        $("#modalUserMobile").text(userMobile);

        // Set the data attributes for level-specific buttons
        $("#level1Btn").data("userId", userId).data("userName", userName).data("userMobile", userMobile).data("level", 1);
        $("#level2Btn").data("userId", userId).data("userName", userName).data("userMobile", userMobile).data("level", 2);
        $("#level3Btn").data("userId", userId).data("userName", userName).data("userMobile", userMobile).data("level", 3);
        $("#level4Btn").data("userId", userId).data("userName", userName).data("userMobile", userMobile).data("level", 4);

        // Open the modal
        $("#userActivationModal").modal("show");
    });

    // Handle level-specific activation buttons (1 to 4)
    $("#level1Btn").on("click", function () {
        let userId = $(this).data("userId");
        let userName = $(this).data("userName");
        let userMobile = $(this).data("userMobile");
        let level = $(this).data("level");

        // Redirect to the activation route with the user details and level
        window.location.href = "<?php echo e(route('inactive_users.activate')); ?>" + "?id=" + userId + "&name=" + userName + "&mobile=" + userMobile + "&level=" + level;
    });

    $("#level2Btn").on("click", function () {
        let userId = $(this).data("userId");
        let userName = $(this).data("userName");
        let userMobile = $(this).data("userMobile");
        let level = $(this).data("level");

        // Redirect to the activation route with the user details and level
        window.location.href = "<?php echo e(route('inactive_users.activate')); ?>" + "?id=" + userId + "&name=" + userName + "&mobile=" + userMobile + "&level=" + level;
    });

    $("#level3Btn").on("click", function () {
        let userId = $(this).data("userId");
        let userName = $(this).data("userName");
        let userMobile = $(this).data("userMobile");
        let level = $(this).data("level");

        // Redirect to the activation route with the user details and level
        window.location.href = "<?php echo e(route('inactive_users.activate')); ?>" + "?id=" + userId + "&name=" + userName + "&mobile=" + userMobile + "&level=" + level;
    });

    $("#level4Btn").on("click", function () {
        let userId = $(this).data("userId");
        let userName = $(this).data("userName");
        let userMobile = $(this).data("userMobile");
        let level = $(this).data("level");

        // Redirect to the activation route with the user details and level
        window.location.href = "<?php echo e(route('inactive_users.activate')); ?>" + "?id=" + userId + "&name=" + userName + "&mobile=" + userMobile + "&level=" + level;
    });
});

</script>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Earnkaro\resources\views/inactive_users/index.blade.php ENDPATH**/ ?>