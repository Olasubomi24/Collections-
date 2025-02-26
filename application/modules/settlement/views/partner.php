<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <h2>Settlement Report</h2>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Settlement Records</strong></h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Settlement Date</th>
                                            <th>Beneficiary Name</th>
                                            <th>Account Number</th>
                                            <th>Bank Name</th>
                                            <th>Total Amount</th>
                                            <th>Status</th>
                                            <th>Processing Error</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($network_result)): ?>
                                        <?php $sn = 1; foreach ($network_result as $settlement): ?>
                                        <tr>
                                            <td><?= $sn++; ?></td>
                                            <td><?= htmlspecialchars($settlement['settlementDate']); ?></td>
                                            <td><?= htmlspecialchars($settlement['merchantAccount']['beneficiaryName']); ?>
                                            </td>
                                            <td><?= htmlspecialchars($settlement['merchantAccount']['accountNumber']); ?>
                                            </td>
                                            <td><?= htmlspecialchars($settlement['merchantAccount']['bankName']); ?>
                                            </td>
                                            <td>
                                                <a href="#" class="view-settlement-details"
                                                    data-settlement='<?= json_encode($settlement, JSON_HEX_APOS); ?>'>
                                                    <?= htmlspecialchars($settlement['totalAmount']); ?>
                                                </a>
                                            </td>
                                            <td><?= htmlspecialchars($settlement['status']); ?></td>
                                            <td><?= htmlspecialchars($settlement['processingError']); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center">No settlement records found</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>





<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $(".view-settlement-details").on("click", function(event) {
        event.preventDefault();

        var settlementData = $(this).data("settlement");

        // Populate modal fields with data
        $("#modal-settlement-date").text(settlementData.settlementDate);
        $("#modal-beneficiary-name").text(settlementData.merchantAccount.beneficiaryName);
        $("#modal-account-number").text(settlementData.merchantAccount.accountNumber);
        $("#modal-bank-name").text(settlementData.merchantAccount.bankName);
        $("#modal-total-amount").text(settlementData.totalAmount);
        $("#modal-status").text(settlementData.status);
        $("#modal-processing-error").text(settlementData.processingError);

        // Show modal
        $("#settlementDetailsModal").modal("show");
    });
});

</script>