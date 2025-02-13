<section class="content">
    <div class="container">
        <h2 class="col-md-6 text-left">Settlement Detail</h2>
        <p><a href="<?php echo base_url('settlement/index'); ?>">Settlement</a></p>

        <?php //echo form_open('settlement/edit_settlement', ['id' => 'settlementForm']); ?>

        <!-- Hidden field for settlement ID -->
        <input type="hidden" name="id" value="<?= isset($settlement['id']) ? $settlement['id'] : ''; ?>">

        <!-- <div class="row clearfix">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="hospitalId" class="form-control" placeholder="Hospital ID" value="<?= isset($settlement['hospitalId']) ? set_value('hospitalId', $settlement['hospitalId']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="merchantId" class="form-control" placeholder="Merchant ID" value="<?= isset($settlement['merchantId']) ? set_value('merchantId', $settlement['merchantId']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="merchantAccount" class="form-control" placeholder="Merchant Account" value="<?= isset($settlement['merchantAccount']) ? set_value('merchantAccount', $settlement['merchantAccount']) : ''; ?>" required>
                </div>
            </div>
        </div> -->
        <div class="row clearfix">
            <!-- <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="settlementAmount" class="form-control" placeholder="Settlement Amount"
                        value="<?= isset($settlement['settlementAmount']) ? set_value('settlementAmount', $settlement['settlementAmount']) : ''; ?>"
                        required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="merchantBank" class="form-control" placeholder="Merchant Bank"
                        value="<?= isset($settlement['merchantBank']) ? set_value('merchantBank', $settlement['merchantBank']) : ''; ?>"
                        required>
                </div>
            </div> -->
            <!-- <div class="col-md-4">
                <button type="submit" class="btn btn-success mt-2">Update Settlement</button>
            </div> -->
        </div>


        <div class="row clearfix">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Hospital ID:</label>
                    <p class="form-control-static">
                        <strong><?= isset($settlement['hospitalId']) ? htmlspecialchars($settlement['hospitalId']) : ''; ?></strong>
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Merchant ID:</label>
                    <p class="form-control-static">
                        <strong><?= isset($settlement['merchantId']) ? htmlspecialchars($settlement['merchantId']) : ''; ?></strong>
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Merchant Account:</label>
                    <p class="form-control-static">
                        <strong><?= isset($settlement['merchantAccount']) ? htmlspecialchars($settlement['merchantAccount']) : ''; ?></strong>
                    </p>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Settlement Amount:</label>
                    <p class="form-control-static">
                        <strong><?= isset($settlement['settlementAmount']) ? htmlspecialchars($settlement['settlementAmount']) : ''; ?></strong>
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Merchant Bank:</label>
                    <p class="form-control-static">
                        <strong><?= isset($settlement['merchantBank']) ? htmlspecialchars($settlement['merchantBank']) : ''; ?></strong>
                    </p>
                </div>
            </div>
        </div>


        <?php //echo form_close(); ?>
    </div>
</section>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->
<script>
$(document).ready(function() {
    $('#settlementForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        let formData = $(this).serialize(); // Serialize form data
        let csrfTokenName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        let csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

        // Append CSRF token
        formData += '&' + csrfTokenName + '=' + csrfHash;

        $.ajax({
            url: "<?php echo base_url('settlement/edit_settlement'); ?>",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                console.log("Response received:", response); // Debugging
                if (response.status === 'success') {
                    Swal.fire("Success!", response.message, "success")
                        .then(() => window.location.href =
                            "<?php echo base_url('settlement/index'); ?>");
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