<section class="content">
    <div class="container">
        <h2 class="col-md-6 text-left">Edit User</h2>
        <p><a href="<?php echo base_url('user/index'); ?>">Users</a></p>

        <?php echo form_open('user/edit_user', ['id' => 'userForm']); ?>

        <!-- Hidden field for user ID -->
        <input type="hidden" name="id" value="<?= isset($user['id']) ? $user['id'] : ''; ?>">

        <div class="row clearfix">

            <div class="col-md-4">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email"
                        value="<?= isset($user['email']) ? set_value('email', $user['email']) : ''; ?>" required>
                </div>
            </div>

            <!-- Role Dropdown -->
            <div class="col-md-4">
                <div class="form-group">
                    <select name="roleId" class="form-control" required>
                        <option value="">Select Role</option>
                        <?php foreach ($role as $r): ?>
                        <option value="<?php echo $r['id']; ?>"
                            <?= isset($user['roleId']) && $user['roleId'] == $r['id'] ? 'selected' : ''; ?>>
                            <?php echo $r['name']; ?>
                            <!-- Ensure API returns 'role_name' -->
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <small>Current: <?= isset($user['roleId']) ? $user['roleId'] : 'Not Set'; ?></small>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <select name="isActive" class="form-control" required>
                        <option value="1"
                           >True
                        </option>
                        <option value="0"
                           >False
                        </option>
                    </select>
                </div>
            </div>



            <!-- <div class="col-md-4">
                <div class="form-group">
                    <select name="isActive" class="form-control" required>
                        <option value="1"
                            <?//= //isset($user['isActive']) && $user['isActive'] == true ? 'selected' : ''; ?>>True
                        </option>
                        <option value="0"
                            <?//= //isset($user['isActive']) && $user['isActive'] == false ? 'selected' : ''; ?>>False
                        </option>
                    </select>
                </div>
            </div> -->



            <div class="col-md-4">
                <button type="submit" class="btn btn-success mt-2">Update User</button>
            </div>
        </div>

        <?php echo form_close(); ?>
    </div>
</section>



<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->
<script>
$(document).ready(function() {
    $('#userForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission
        let formData = $(this).serialize(); // Serialize form data
        let csrfTokenName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        let csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
        $.ajax({
            url: "<?php echo base_url('user/edit_user'); ?>",
            type: "POST",
            data: formData + '&' + csrfTokenName + '=' + csrfHash,
            dataType: "json",
            success: function(response) {
                console.log("Response received:", response); // Debugging
                if (response.status === 'success') {
                    Swal.fire("Success!", response.message, "success")
                        .then(() => window.location.href =
                            "<?php echo base_url('user/index'); ?>");
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