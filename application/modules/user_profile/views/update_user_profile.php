<section class="content">
    <div class="container">
        <h2>Update User Profile</h2>
        <p><a href="<?php echo base_url('user_profile/index'); ?>">Back to Users</a></p>
        
        <?php echo form_open('user_profile/update_user_profile', ['id' => 'updateUserProfileForm']); ?>
        
        <div class="row clearfix">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="userName">User Name</label>
                    <input type="text" id="userName" name="userName" class="form-control" placeholder="User Name" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="userPhoneNumber">Phone Number</label>
                    <input type="text" id="userPhoneNumber" name="userPhoneNumber" class="form-control" placeholder="User Phone Number" required>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary mt-2">Update Profile</button>
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
    $('#updateUserProfileForm').submit(function (event) {
        event.preventDefault(); // Prevent default form submission

        let formData = $(this).serialize(); // Serialize form data

        $.ajax({
            url: "<?php echo base_url('user_profile/update_user_profile'); ?>",
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