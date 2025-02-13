<div class="authentication">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <div class="card auth_form">
                    <div class="header">
                        <img class="logo" src="<?= base_url('assets/images/logo.svg') ?>" alt="">
                        <h5>Sign Up</h5>
                        <span>Register a new membership</span>
                    </div>

                    <?php echo form_open('auth/createaccount', ['id' => 'signupForm']); ?>
                    <div class="body">
                        <div class="input-group mb-3">
                            <input type="text" name="userName" class="form-control" placeholder="Username" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="zmdi zmdi-email"></i></span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Password" required>
                            <div class="input-group-append">
                                <span class="input-group-text toggle-password" data-target="password">
                                    <i class="zmdi zmdi-eye" id="togglePasswordIcon1"></i>
                                </span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                                placeholder="Confirm Password" required>
                            <div class="input-group-append">
                                <span class="input-group-text toggle-password" data-target="confirm_password">
                                    <i class="zmdi zmdi-eye" id="togglePasswordIcon2"></i>
                                </span>
                            </div>
                        </div>


                        <div class="input-group mb-3">
                            <input type="text" name="userPhoneNumber" class="form-control" placeholder="Phone Number"
                                required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="zmdi zmdi-phone"></i></span>
                            </div>
                        </div>

                        <div class="checkbox">
                            <input id="agree_terms" type="checkbox" name="agree_terms" required>
                            <label for="agree_terms">
                                I read and agree to the <a href="javascript:void(0);">terms of usage</a>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">SIGN
                            UP</button>

                        <div class="signin_with mt-3">
                            <a class="link" href="<?= base_url('auth/login') ?>">You already have a membership?</a>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>

                <div class="copyright text-center">
                    &copy;
                    <script>
                    document.write(new Date().getFullYear())
                    </script>
                </div>
            </div>

            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <img src="<?= base_url('assets/images/signin.svg') ?>" alt="Sign In" />
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->

<script>
$(document).ready(function() {
    $("#signupForm").submit(function(e) {
        e.preventDefault(); // Prevent form reload

        // Ensure the terms checkbox is checked
        if (!$("#agree_terms").prop("checked")) {
            Swal.fire({
                icon: "error",
                title: "Terms Required",
                text: "You must agree to the terms before signing up.",
            });
            return;
        }

        $.ajax({
            url: "<?= base_url('auth/createaccount'); ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
                // Show loading spinner in SweetAlert
                Swal.fire({
                    title: "Processing...",
                    text: "Please wait while we create your account.",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                Swal.close(); // Close loading modal

                if (response.status === "error") {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        html: response.message.replace(/<\/?p>/g,
                        ''), // Remove <p> tags
                    });
                } else {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: "You have registered successfully.",
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = "<?= base_url('auth/index'); ?>";
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.close(); // Ensure modal closes on error
                Swal.fire({
                    icon: "error",
                    title: "AJAX Error!",
                    text: "Something went wrong. Please try again.",
                });
                console.error(xhr.responseText); // Debugging
            }
        });
    });
});
</script>

<script>
    document.querySelectorAll(".toggle-password").forEach(item => {
    item.addEventListener("click", function() {
        let target = document.getElementById(this.getAttribute("data-target"));
        let icon = this.querySelector("i");

        if (target.type === "password") {
            target.type = "text";
            icon.classList.remove("zmdi-eye");
            icon.classList.add("zmdi-eye-off");
        } else {
            target.type = "password";
            icon.classList.remove("zmdi-eye-off");
            icon.classList.add("zmdi-eye");
        }
    });
});

</script>