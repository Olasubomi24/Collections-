<section class="content">
    <div class="container">
        <h2>Add User</h2>
        <p><a href="<?php echo base_url('user/index'); ?>">Users</a></p>
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
                    <select name="roleId" class="form-control" required>
                        <option value="">Select Role</option>
                        <?php foreach ($role as $r): ?>
                            <option value="<?php echo $r['id']; ?>"><?php echo $r['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group" id="hospitalField">
                    <?php if ($_SESSION['role'] === 'SUPER_ADMIN'): ?>
                        <input type="hidden" name="hospitalId" class="form-control" placeholder="Hospital ID" value="<?php echo $_SESSION['hospital_id']; ?>" required>
                    <?php else: ?>
                        <select name="hospitalId" class="form-control" required>
                            <option value="">Select Hospital</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?php echo $user['id']; ?>"><?php echo $user['hospitalName']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- <script>
// $(document).ready(function () {
//     $('#userForm').submit(function (event) {
//         event.preventDefault();
//         let formData = $(this).serialize();
//         $.ajax({
//             url: "<?php echo base_url('user/add_user'); ?>",
//             type: "POST",
//             data: formData,
//             dataType: "json",
//             success: function(response) {
//                 let message = typeof response.message === 'string' ? response.message : JSON.stringify(response.message);
                
//                 if (response.status === 'success') {
//                     Swal.fire({
//                         title: "Success!",
//                         text: message,
//                         icon: "success"
//                     }).then(() => window.location.href = "<?php echo base_url('user/index'); ?>");
//                 } else {
//                     Swal.fire({
//                         title: "Error!",
//                         text: message,
//                         icon: "error"
//                     });
//                 }
//             },
//             error: function(xhr, status, error) {
//                 Swal.fire({
//                     title: "Error!",
//                     text: "An unexpected error occurred.",
//                     icon: "error"
//                 });
//             }
//         });
//     });
// });



</script> -->

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