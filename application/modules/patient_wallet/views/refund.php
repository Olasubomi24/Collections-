<section class="content">
    <div class="container">
        <h2>Add Wallet Funding</h2>
        <p><a href="<?= base_url('patient_wallet/index'); ?>">Refund</a></p>

        <?= form_open('patient_wallet/add_refund', ['id' => 'walletFundingForm']); ?>
        <div class="row clearfix">
            <div class="col-md-4">
                <input type="text" name="hospitalId" class="form-control" placeholder="Hospital ID"
                    value="<?= $_SESSION['hospital_id'] ?? ''; ?>" required readonly>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <select name="eWalletAccount" class="form-control" required>
                        <option value="">Select E-Wallet Account</option>
                        <?php if (!empty($ewallets) && is_array($ewallets)): ?>
                        <?php foreach ($ewallets as $wallet): ?>
                        <option value="<?= htmlspecialchars($wallet['eWalletAccount'], ENT_QUOTES, 'UTF-8'); ?>">
                            <?= htmlspecialchars($wallet['patientFirstName'] . " " . $wallet['patientLastName'], ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <option value="">No e-wallets available</option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>



            <div class="col-md-4">
                <div class="form-group">
                    <input type="number" step="0.01" name="amount" class="form-control" placeholder="Amount" required>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <input type="text" name="reason" class="form-control" placeholder="Reason for Refund"   
                        required>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-md-4">
                <button type="submit" class="btn btn-success mt-2">Refund</button>
            </div>
        </div>

        <?= form_close(); ?>
    </div>
</section>

<!-- Include jQuery and SweetAlert -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#walletFundingForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        let formData = $(this).serialize(); // Serialize form data
        console.log("Serialized Form Data:", formData); // ✅ Log form data before AJAX request

        $.ajax({
            url: "<?= base_url('patient_wallet/add_refund'); ?>",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                console.log("AJAX Success Response:", response); // ✅ Log success response
                if (response.status === 'success') {
                    Swal.fire("Success!", response.message, "success")
                        .then(() => window.location.href =
                            "<?= base_url('patient_wallet/index'); ?>");
                } else {
                    Swal.fire("Error!", response.message, "error");
                }
            },
            error: function(xhr, status, error) {
                console.log("AJAX Error:", xhr.responseText); // ✅ Log detailed error message
                Swal.fire("Error!", "An unexpected error occurred.", "error");
            }
        });
    });
});

</script>