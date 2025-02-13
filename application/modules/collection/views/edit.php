
<section class="content">
    <div class="container">
        <h2 class="col-md-6 text-left">Edit Patient</h2>
        <p><a href="<?php echo base_url('patient_wallet/index'); ?>">Patients</a></p>
        
        <?php echo form_open('patient_wallet/edit_patient_wallet', ['id' => 'patientForm']); ?>
        
        <!-- Hidden field for patient ID -->
        <input type="hidden" name="id" value="<?= isset($patient['id']) ? $patient['id'] : ''; ?>">
        
        <div class="row clearfix">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="patientFirstName" class="form-control" placeholder="First Name" value="<?= isset($patient['patientFirstName']) ? set_value('patientFirstName', $patient['patientFirstName']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="patientLastName" class="form-control" placeholder="Last Name" value="<?= isset($patient['patientLastName']) ? set_value('patientLastName', $patient['patientLastName']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="patientMiddleName" class="form-control" placeholder="Middle Name" value="<?= isset($patient['patientMiddleName']) ? set_value('patientMiddleName', $patient['patientMiddleName']) : ''; ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <select name="gender" class="form-control" required>
                        <option value="" disabled>Select Gender</option>
                        <option value="Male" <?= isset($patient['gender']) && $patient['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?= isset($patient['gender']) && $patient['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                        <option value="Other" <?= isset($patient['gender']) && $patient['gender'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="date" name="dob" class="form-control" placeholder="Date of Birth" value="<?= isset($patient['dob']) ? set_value('dob', $patient['dob']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" value="<?= isset($patient['email']) ? set_value('email', $patient['email']) : ''; ?>" required>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="phoneNumber" class="form-control" placeholder="Phone Number" value="<?= isset($patient['phoneNumber']) ? set_value('phoneNumber', $patient['phoneNumber']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="alternateNumber" class="form-control" placeholder="Alternate Phone Number" value="<?= isset($patient['alternateNumber']) ? set_value('alternateNumber', $patient['alternateNumber']) : ''; ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="address" class="form-control" placeholder="Address" value="<?= isset($patient['address']) ? set_value('address', $patient['address']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="bvn" class="form-control" placeholder="BVN (Bank Verification Number)" value="<?= isset($patient['bvn']) ? set_value('bvn', $patient['bvn']) : ''; ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="nin" class="form-control" placeholder="NIN (National Identification Number)" value="<?= isset($patient['nin']) ? set_value('nin', $patient['nin']) : ''; ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="hospitalId" class="form-control" placeholder="Hospital ID" value="<?= isset($patient['hospitalId']) ? set_value('hospitalId', $patient['hospitalId']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-success mt-2">Update Patient</button>
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
    $('#patientForm').submit(function (event) {
        event.preventDefault(); // Prevent default form submission
        let formData = $(this).serialize(); // Serialize form data
        let csrfTokenName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        let csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
        $.ajax({
            url: "<?php echo base_url('patient_wallet/edit_patient_wallet'); ?>",
            type: "POST",
            data: formData + '&' + csrfTokenName + '=' + csrfHash,
            dataType: "json",
            success: function(response) {
                console.log("Response received:", response); // Debugging
                if (response.status === 'success') {
                    Swal.fire("Success!", response.message, "success")
                        .then(() => window.location.href = "<?php echo base_url('patient_wallet/index'); ?>");
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