<section class="content">
    <div class="container">
        <h2>Add Wallet Funding</h2>
        <p><a href="<?= base_url('patient_wallet/index'); ?>">Wallet Fundings</a></p>

        <?= form_open('patient_wallet/add_manual_funding', ['id' => 'walletFundingForm']); ?>
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
                    <input type="text" name="description" class="form-control" placeholder="Funding Description"
                        required>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-md-4">
                <button type="submit" class="btn btn-success mt-2">Add Wallet Funding</button>
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
        console.log("Serialized Form Data:", formData); // ✅ Debugging

        $.ajax({
            url: "<?= base_url('patient_wallet/add_manual_funding'); ?>",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                console.log("AJAX Success Response:", response); // ✅ Debugging

                // Ensure response has 'status' and it's 'success'
                if (response && response.status === 'success') {
                    Swal.fire({
                        title: "Success!",
                        text: response.message || "Wallet funded successfully.",
                        icon: "success"
                    }).then(() => {
                        window.location.href = "<?= base_url('patient_wallet/index'); ?>";
                    });
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: response.message || "Unexpected response format.",
                        icon: "error"
                    });
                }
            },
            error: function(xhr, status, error) {
                console.log("AJAX Error:", xhr.responseText); // ✅ Debugging

                let errorMsg = "An unexpected error occurred.";
                if (xhr.responseText && xhr.responseText.startsWith("{")) { // Ensure it's JSON
                    try {
                        let jsonError = JSON.parse(xhr.responseText);
                        errorMsg = jsonError.message || errorMsg;
                    } catch (e) {
                        console.error("Error parsing JSON:", e);
                    }
                }

                Swal.fire({
                    title: "Error!",
                    text: errorMsg,
                    icon: "error"
                });
            }
        });
    });
});

</script>