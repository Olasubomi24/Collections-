

<section class="content">
    <div class="container">
        <h2 class="col-md-6 text-left">Edit Hospital</h2>
        <p ><a href="<?php echo base_url('hospital/index'); ?>">hospital</a>
</p>
        <?php echo form_open('hospital/edit_hospital', ['id' => 'hosp']); ?>

        <!-- Hidden field for hospital ID -->
        <input type="hidden" name="id" value="<?= isset($hospital['id']) ? $hospital['id'] : ''; ?>">

        <div class="row clearfix">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="hospitalName" class="form-control" placeholder="Hospital Name" value="<?= isset($hospital['hospitalName']) ? set_value('hospitalName', $hospital['hospitalName']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="hospitalAdminName" class="form-control" placeholder="Admin Name" value="<?= isset($hospital['hospitalAdminName']) ? set_value('hospitalAdminName', $hospital['hospitalAdminName']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="hospitalPhoneNumber" class="form-control" placeholder="Phone Number" value="<?= isset($hospital['hospitalPhoneNumber']) ? set_value('hospitalPhoneNumber', $hospital['hospitalPhoneNumber']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="email" name="hospitalEmail" class="form-control" placeholder="Email" value="<?= isset($hospital['hospitalEmail']) ? set_value('hospitalEmail', $hospital['hospitalEmail']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="hospitalAddress" class="form-control" placeholder="Address" value="<?= isset($hospital['hospitalAddress']) ? set_value('hospitalAddress', $hospital['hospitalAddress']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="number" step="0.1" name="hospitalCardInsuranceCommission" class="form-control" placeholder="Insurance Commission" value="<?= isset($hospital['hospitalCardInsuranceCommission']) ? set_value('hospitalCardInsuranceCommission', $hospital['hospitalCardInsuranceCommission']) : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="number" step="0.1" name="hospitalEWalletFundingCommission" class="form-control" placeholder="E-Wallet Funding Commission" value="<?= isset($hospital['hospitalEWalletFundingCommission']) ? set_value('hospitalEWalletFundingCommission', $hospital['hospitalEWalletFundingCommission']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="number" step="0.1" name="hospitalCollectionCommission" class="form-control" placeholder="Collection Commission" value="<?= isset($hospital['hospitalCollectionCommission']) ? set_value('hospitalCollectionCommission', $hospital['hospitalCollectionCommission']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="domain" class="form-control" placeholder="Domain" value="<?= isset($hospital['domain']) ? set_value('domain', $hospital['domain']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-success mt-2">Update Hospital</button>
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
        let csrfTokenName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        let csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

        $.ajax({
            url: "<?php echo base_url('hospital/edit_hospital'); ?>",
            type: "POST",
            data: formData + '&' + csrfTokenName + '=' + csrfHash,
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