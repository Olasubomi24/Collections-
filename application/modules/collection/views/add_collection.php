<section class="content">
    <div class="container">
        <h2>Add Collection</h2>
        <p><a href="<?php echo base_url('collection/index'); ?>">Collections</a></p>
        
        <?php echo form_open('collection/add_collection', ['id' => 'collectionForm']); ?>
        
        <div class="row clearfix">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="hospitalId" class="form-control" placeholder="Hospital ID" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="eWalletAccount" class="form-control" placeholder="E-Wallet Account" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="patientPhoneNumber" class="form-control" placeholder="Patient Phone Number" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="number" step="0.01" name="amount" class="form-control" placeholder="Amount" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="terminalId" class="form-control" placeholder="Terminal ID" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="rrn" class="form-control" placeholder="RRN (Retrieval Reference Number)" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="pan" class="form-control" placeholder="PAN (Payment Card Number)" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="paymentMethod" class="form-control" placeholder="Payment Method" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="issuer" class="form-control" placeholder="Issuer" required>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-4">
                <button type="submit" class="btn btn-success mt-2">Add Collection</button>
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
    $('#collectionForm').submit(function (event) {
        event.preventDefault(); // Prevent default form submission
        let formData = $(this).serialize(); // Serialize form data
        $.ajax({
            url: "<?php echo base_url('collection/add_collection'); ?>",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                console.log("Response received:", response); // Debugging
                if (response.status === 'success') {
                    Swal.fire("Success!", response.message, "success")
                        .then(() => window.location.href = "<?php echo base_url('collection/index'); ?>");
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