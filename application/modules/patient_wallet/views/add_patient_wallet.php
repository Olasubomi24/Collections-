<section class="content">
    <div class="container">
        <h2>Add Patient</h2>
        <p><a href="<?php echo base_url('patient_wallet/index'); ?>">Patients</a></p>

        <?php echo form_open('patient_wallet/add_patient', ['id' => 'patientForm']); ?>

        <div class="row clearfix">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="patientFirstName" class="form-control" placeholder="First Name" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="patientLastName" class="form-control" placeholder="Last Name" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="patientMiddleName" class="form-control" placeholder="Middle Name">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <select name="gender" class="form-control" required>
                        <option value="" disabled selected>Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="date" name="dob" class="form-control" placeholder="Date of Birth" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="phoneNumber" class="form-control" placeholder="Phone Number" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="alternateNumber" class="form-control" placeholder="Alternate Phone Number">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="address" class="form-control" placeholder="Address" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="bvn" class="form-control" placeholder="BVN (Bank Verification Number)">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="nin" class="form-control"
                        placeholder="NIN (National Identification Number)">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="hospitalId" class="form-control" placeholder="Hospital ID"
                        value="<?= empty($_SESSION['hospital_id']) ? '' : $_SESSION['hospital_id']; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-success mt-2">Add Patient</button>
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
    $('#patientForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission
        let formData = $(this).serialize(); // Serialize form data
        $.ajax({
            url: "<?php echo base_url('patient_wallet/add_patient'); ?>",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                console.log("Response received:", response); // Debugging
                if (response.status === 'success') {
                    Swal.fire("Success!", response.message, "success")
                        .then(() => window.location.href =
                            "<?php echo base_url('patient_wallet/index'); ?>");
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