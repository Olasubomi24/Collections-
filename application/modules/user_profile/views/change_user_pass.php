<section class="content">
    <div class="container">
        <h2>Change Password</h2>
        <p><a href="<?php echo base_url('user_profile/index'); ?>">Back to Dashboard</a></p>

        <?php echo form_open('user_profile/change_user_password', ['id' => 'changePasswordForm']); ?>

        <div class="row clearfix">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="userName">User Name</label>
                    <input type="text" id="userName" name="userName" class="form-control" value="<?php echo $_SESSION['username']; ?>" readonly>
                </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" class="form-control" value="<?php echo $_SESSION['email']; ?>" readonly>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="oldPassword">Old Password</label>
                    <input type="password" id="oldPassword" name="oldPassword" class="form-control" placeholder="Old Password" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="newPassword">New Password</label>
                    <input type="password" id="newPassword" name="newPassword" class="form-control" placeholder="New Password" required>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary mt-2">Change Password</button>
            </div>
        </div>

        <?php echo form_close(); ?>
    </div>
</section>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->
<script>
$(document).ready(function () {
    $('#changePasswordForm').submit(function (event) {
        event.preventDefault(); // Prevent default form submission

        let formData = $(this).serialize(); // Serialize form data

        $.ajax({
            url: "<?php echo base_url('user_profile/change_user_password'); ?>",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                console.log("Response received:", response); // Debugging
                if (response.status === 'success') {
                    Swal.fire("Success!", response.message, "success")
                        .then(() => window.location.href = "<?php echo base_url('user_profile/index'); ?>");
                } else {
                    Swal.fire("Error!", response.message, "error");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText);
                Swal.fire("Error!", "An unexpected error occurred.", "error");
            }
        });
    });
});
</script>