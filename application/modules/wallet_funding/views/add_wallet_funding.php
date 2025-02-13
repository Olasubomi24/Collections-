<section class="content">
    <div class="container">
        <h2>Add Wallet Funding</h2>
        <p><a href="<?php echo base_url('wallet_funding/index'); ?>">Wallet Fundings</a></p>
        
        <?php echo form_open('wallet_funding/add_wallet_funding', ['id' => 'walletFundingForm']); ?>
        
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
                    <input type="text" name="fundingBank" class="form-control" placeholder="Funding Bank" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="sourceCode" class="form-control" placeholder="Source Code" required>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="sessionId" class="form-control" placeholder="Session ID" value="<?= uniqid() . rand(1000, 9999); ?>" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-success mt-2">Add Wallet Funding</button>
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
    $('#walletFundingForm').submit(function (event) {
        event.preventDefault(); // Prevent default form submission
        let formData = $(this).serialize(); // Serialize form data
        $.ajax({
            url: "<?php echo base_url('wallet_funding/add_wallet_funding'); ?>",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                console.log("Response received:", response); // Debugging
                if (response.status === 'success') {
                    Swal.fire("Success!", response.message, "success")
                        .then(() => window.location.href = "<?php echo base_url('wallet_funding/index'); ?>");
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