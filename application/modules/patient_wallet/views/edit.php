<section class="content">
    <div class="container">
        <h2 class="col-md-6 text-left">Edit Patient</h2>
        <p><a href="<?php echo base_url('patient_wallet/index'); ?>">Patients</a></p>
        
        <?php echo form_open('patient_wallet/edit_patient_wallet', ['id' => 'patientForm']); ?>
        
        <!-- Hidden field for patient ID -->
        <input type="hidden" name="id" value="<?= isset($patient_wallet['id']) ? $patient_wallet['id'] : ''; ?>">
        
        <div class="row clearfix">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="patientFirstName" class="form-control" placeholder="First Name" value="<?= isset($patient_wallet['patientFirstName']) ? set_value('patientFirstName', $patient_wallet['patientFirstName']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="patientLastName" class="form-control" placeholder="Last Name" value="<?= isset($patient_wallet['patientLastName']) ? set_value('patientLastName', $patient_wallet['patientLastName']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="patientMiddleName" class="form-control" placeholder="Middle Name" value="<?= isset($patient_wallet['patientMiddleName']) ? set_value('patientMiddleName', $patient_wallet['patientMiddleName']) : ''; ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <select name="gender" class="form-control" required>
                        <option value="" disabled>Select Gender</option>
                        <option value="male" <?= isset($patient_wallet['gender']) && $patient_wallet['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                        <option value="female" <?= isset($patient_wallet['gender']) && $patient_wallet['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                        <option value="Other" <?= isset($patient_wallet['gender']) && $patient_wallet['gender'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="date" name="dob" class="form-control" placeholder="Date of Birth" value="<?= isset($patient_wallet['dob']) ? set_value('dob', $patient_wallet['dob']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" value="<?= isset($patient_wallet['email']) ? set_value('email', $patient_wallet['email']) : ''; ?>" required>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="phoneNumber" class="form-control" placeholder="Phone Number" value="<?= isset($patient_wallet['phoneNumber']) ? set_value('phoneNumber', $patient_wallet['phoneNumber']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="alternateNumber" class="form-control" placeholder="Alternate Phone Number" value="<?= isset($patient_wallet['alternateNumber']) ? set_value('alternateNumber', $patient_wallet['alternateNumber']) : ''; ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="address" class="form-control" placeholder="Address" value="<?= isset($patient_wallet['address']) ? set_value('address', $patient_wallet['address']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="bvn" class="form-control" placeholder="BVN (Bank Verification Number)" value="<?= isset($patient_wallet['bvn']) ? set_value('bvn', $patient_wallet['bvn']) : ''; ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="nin" class="form-control" placeholder="NIN (National Identification Number)" value="<?= isset($patient_wallet['nin']) ? set_value('nin', $patient_wallet['nin']) : ''; ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="hospitalId" class="form-control" placeholder="Hospital ID" value="<?= empty($_SESSION['hospital_id']) ? '' : $_SESSION['hospital_id']; ?>" required>
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