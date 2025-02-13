<section class="content">
    <div class="container">
        <h2>Add User</h2>
        <p><a href="<?php echo base_url('user/index'); ?>">users</a></p>
        
        <?php echo form_open('user/add_user', ['id' => 'userForm']); ?>
        
        <div class="row clearfix">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="userName" class="form-control" placeholder="User Name" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="userPhoneNumber" class="form-control" placeholder="User Phone Number" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="hospitalId" class="form-control" placeholder="Hospital ID" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="roleId" class="form-control" placeholder="Role ID" required>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-4">
                <button type="submit" class="btn btn-success mt-2">Add user</button>
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
    $('#userForm').submit(function (event) {
        event.preventDefault(); // Prevent default form submission
        let formData = $(this).serialize(); // Serialize form data
        $.ajax({
            url: "<?php echo base_url('user/add_user'); ?>",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                console.log("Response received:", response); // Debugging
                if (response.status === 'success') {
                    Swal.fire("Success!", response.message, "success")
                        .then(() => window.location.href = "<?php echo base_url('user/index'); ?>");
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