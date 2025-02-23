<section class="content">
    <div class="container">
        <h2 class="col-md-6 text-left">Edit Hospital</h2>
        <p><a href="<?php echo base_url('hospital/index'); ?>">Hospital</a></p>
        
        <?php echo form_open('hospital/edit_hospital', ['id' => 'hosp']); ?>

        <input type="hidden" name="id" value="<?= isset($hospital['id']) ? $hospital['id'] : ''; ?>">

        <div class="row clearfix">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="hospitalName" class="form-control" placeholder="Hospital Name" 
                        value="<?= isset($hospital['hospitalName']) ? set_value('hospitalName', $hospital['hospitalName']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="hospitalAdminName" class="form-control" placeholder="Admin Name" 
                        value="<?= isset($hospital['hospitalAdminName']) ? set_value('hospitalAdminName', $hospital['hospitalAdminName']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="hospitalPhoneNumber" class="form-control" placeholder="Phone Number" 
                        value="<?= isset($hospital['hospitalPhoneNumber']) ? set_value('hospitalPhoneNumber', $hospital['hospitalPhoneNumber']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="email" name="hospitalEmail" class="form-control" placeholder="Email" 
                        value="<?= isset($hospital['hospitalEmail']) ? set_value('hospitalEmail', $hospital['hospitalEmail']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="hospitalAddress" class="form-control" placeholder="Address" 
                        value="<?= isset($hospital['hospitalAddress']) ? set_value('hospitalAddress', $hospital['hospitalAddress']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="number" step="0.1" name="hospitalCardInsuranceCommission" class="form-control" placeholder="Insurance Commission" 
                        value="<?= isset($hospital['hospitalCardInsuranceCommission']) ? set_value('hospitalCardInsuranceCommission', $hospital['hospitalCardInsuranceCommission']) : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="number" step="0.1" name="hospitalEWalletFundingCommission" class="form-control" placeholder="E-Wallet Funding Commission" 
                        value="<?= isset($hospital['hospitalEWalletFundingCommission']) ? set_value('hospitalEWalletFundingCommission', $hospital['hospitalEWalletFundingCommission']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="number" step="0.1" name="hospitalCollectionCommission" class="form-control" placeholder="Collection Commission" 
                        value="<?= isset($hospital['hospitalCollectionCommission']) ? set_value('hospitalCollectionCommission', $hospital['hospitalCollectionCommission']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="domain" class="form-control" placeholder="Domain" 
                        value="<?= isset($hospital['domain']) ? set_value('domain', $hospital['domain']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <!-- <label for="hospitalLogo">Hospital Logo (Enter file name)</label> -->
                    <input type="file" name="logo" class="form-control" placeholder="Upload your logo e.g., logo.png" 
                        value="<?= isset($hospital['hospitalLogoURL']) ? set_value('hospitalLogo', $hospital['hospitalLogoURL']) : ''; ?>">
                    <small>Current Logo: <b><?= isset($hospital['hospitalLogoURL']) ? $hospital['hospitalLogoURL'] : 'No logo'; ?></b></small>
                </div>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-success mt-2">Update Hospital</button>
            </div>
        </div>

        <?php echo form_close(); ?>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->
<script>
$(document).ready(function () {
    $('#hosp').submit(function (event) {
        event.preventDefault(); // Prevent default form submission

        let formData = new FormData(this); // Collect form data
        let fileInput = $('input[name="logo"]')[0];

        // Remove any existing logo key to avoid duplicate entries
        formData.delete('logo');

        // Check if a file is selected and extract only the filename
        if (fileInput.files.length > 0) {
            let fileName = fileInput.files[0].name; // Extract filename only (e.g., "icon.jpeg")
            formData.append('logo', fileName); // ✅ Only send the filename, not the file object
        } else {
            formData.append('logo', ''); // Ensure logo key is sent even if no file is selected
        }

        // ✅ Console log to verify the correct data is being sent
        console.log("🚀 Data being sent to API:");
        for (let [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }

        $.ajax({
            url: "<?php echo base_url('hospital/edit_hospital'); ?>",
            type: "POST",
            data: formData,
            contentType: false, // Required for file upload
            processData: false, // Prevent jQuery from processing the data
            dataType: "json",
            success: function(response) {
                console.log("✅ API Response:", response); // ✅ Log full API response
                console.log("📌 Result Data:", response.data); // ✅ Log `result["result"]`

                if (response.status === 'success') {
                    Swal.fire("Success!", response.message, "success")
                        .then(() => window.location.href = "<?php echo base_url('hospital/index'); ?>");
                } else {
                    Swal.fire("Error!", response.message, "error");
                }
            },
            error: function() {
                Swal.fire("Error!", "An unexpected error occurred.", "error");
            }
        });
    });
});
$(document).ready(function () {
    $('#hosp').submit(function (event) {
        event.preventDefault(); // Prevent default form submission

        let formData = new FormData(this); // Collect form data
        let fileInput = $('input[name="logo"]')[0];

        // Remove any existing logo key to avoid duplicate entries
        formData.delete('logo');

        // Check if a file is selected and extract only the filename
        if (fileInput.files.length > 0) {
            let fileName = fileInput.files[0].name; // Extract filename only (e.g., "icon.jpeg")
            formData.append('logo', fileName); // ✅ Only send the filename, not the file object
        } else {
            formData.append('logo', ''); // Ensure logo key is sent even if no file is selected
        }

        // ✅ Console log to verify the correct data is being sent
        console.log("🚀 Data being sent to API:");
        for (let [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }

        $.ajax({
            url: "<?php echo base_url('hospital/edit_hospital'); ?>",
            type: "POST",
            data: formData,
            contentType: false, // Required for file upload
            processData: false, // Prevent jQuery from processing the data
            dataType: "json",
            success: function(response) {
                console.log("✅ API Response:", response); // ✅ Log full API response
                console.log("📌 Result Data:", response.data); // ✅ Log `result["result"]`

                if (response.status === 'success') {
                    Swal.fire("Success!", response.message, "success")
                        .then(() => window.location.href = "<?php echo base_url('hospital/index'); ?>");
                } else {
                    Swal.fire("Error!", response.message, "error");
                }
            },
            error: function() {
                Swal.fire("Error!", "An unexpected error occurred.", "error");
            }
        });
    });
});



</script>
