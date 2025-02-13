<section class="content">
    <div class="container">
        <h2>Add Hospital</h2>
        <p ><a href="<?php echo base_url('hospital/index'); ?>">hospital</a>
</p>
        <?php echo form_open('hospital/add_hospital', ['id' => 'hosp']); ?>
        <div class="row clearfix">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="hospitalName" class="form-control" placeholder="Hospital Name" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="hospitalAdminName" class="form-control" placeholder="Admin Name" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="hospitalPhoneNumber" class="form-control" placeholder="Phone Number" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="email" name="hospitalEmail" class="form-control" placeholder="Email" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="hospitalAddress" class="form-control" placeholder="Address" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="number" step="0.1" name="hospitalCardInsuranceCommission" class="form-control" placeholder="Insurance Commission" required>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="number" step="0.1" name="hospitalEWalletFundingCommission" class="form-control" placeholder="E-Wallet Funding Commission" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="number" step="0.1" name="hospitalCollectionCommission" class="form-control" placeholder="Collection Commission" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="domain" class="form-control" placeholder="Domain" required>
                </div>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-success mt-2">Add Hospital</button>
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
    $('#hosp').submit(function (event) {
        event.preventDefault(); // Prevent default form submission
        let formData = $(this).serialize(); // Serialize form data

        $.ajax({
            url: "<?php echo base_url('hospital/add_hospital'); ?>",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                console.log("Response received:", response); // Debugging
                if (response.status === 'success') {
                    Swal.fire("Success!", response.message, "success")
                        .then(() => window.location.href = "<?php echo base_url('hospital/index'); ?>");
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
