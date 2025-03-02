
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Settlement </h2>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i
                            class="zmdi zmdi-sort-amount-desc"></i></button>

                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="float-right btn btn-primary btn-icon right_icon_toggle_btn" type="button"><i
                            class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <!-- Basic Examples -->
            <?php echo form_open('settlement/index', ['method' => 'post', 'id' => 'settlementForm']); ?>
            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                value="<?= $this->security->get_csrf_hash() ?>">
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="startDate">Start Date</label>
                        <input type="date" name="startDate" class="form-control" id="startDate"
                            value="<?= htmlspecialchars($start_dt ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="endDate">End Date</label>
                        <input type="date" name="endDate" class="form-control" id="endDate"
                            value="<?= htmlspecialchars($end_dt ?? '') ?>">
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success mt-2">Submit</button>
                </div>
            </div>
            <?php echo form_close(); ?>

            <!-- Exportable Table -->
            <div class="clearfix row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <!-- <h2><a href="<?php //echo base_url('hospital/adds_hospital'); ?>"><strong>Add
                                        hospital</strong></a>
                            </h2> -->
                            <ul class="header-dropdown">
                                <!-- <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle"
                                        data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="zmdi zmdi-more"></i> </a>
                                    <ul class="dropdown-menu dropdown-menu-right slideUp">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else</a></li>
                                    </ul>
                                </li> -->
                                <!-- <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li> -->
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="dataTable"
                                    class="table table-bordered table-striped table-hover dataTable js-exportable  ">
                                    <thead>
                                    <tr>
                                            <th>#</th>
                                            <th>Transaction Ref</th>
                                            <th>Transaction Description</th>
                                            <th>Request Ref</th>
                                            <th>Transaction Date</th>
                                            <th>Customer Reference</th>
                                            <th>Amount</th>
                                            <th>Payer Name</th>
                                            <th>Payer Phone</th>
                                            <th>Payer Email</th>
                                            <th>Provider</th>
                                            <th>Status</th>
                                            <th>Requester</th>
                                            <th>Payment Channel</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($network_result)): ?>
                                        <?php $sn = 1; foreach ($network_result as $transaction): ?>
                                        <tr>
                                            <td><?= $sn++; ?></td>
                                            <td><?= htmlspecialchars($transaction['transaction_ref'] ?? '-'); ?></td>
                                            <td><?= htmlspecialchars($transaction['transaction_desc'] ?? '-'); ?></td>
                                            <td><?= htmlspecialchars($transaction['request_ref'] ?? '-'); ?></td>
                                            <td><?= htmlspecialchars($transaction['time_in'] ?? '-'); ?></td>
                                            <td><?= htmlspecialchars($transaction['customer_ref'] ?? '-'); ?></td>
                                            <td>₦<?= number_format(((int) ($transaction['amount'] ?? 0)) / 100, 2); ?></td>
                                            <td><?= htmlspecialchars($transaction['customer_firstname'] . ' ' . $transaction['customer_surname'] ?? '-'); ?>
                                            </td>
                                            <td><?= htmlspecialchars($transaction['customer_mobile_no'] ?? '-'); ?></td>
                                            <td><?= htmlspecialchars($transaction['customer_email'] ?? '-'); ?></td>
                                            <td><?= htmlspecialchars($transaction['provider'] ?? '-'); ?></td>
                                            <td><?= htmlspecialchars($transaction['status'] ?? '-'); ?></td>
                                            <td><?= htmlspecialchars($transaction['requester'] ?? '-'); ?></td>
                                            <td><?= htmlspecialchars($transaction['transaction_type'] ?? '-'); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <tr>
                                            <td colspan="14" class="text-center">No transaction data available</td>
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
    console.log("Document is ready!");

    $('#settlementForm').on('submit', function(e) {
        e.preventDefault(); // Prevent page reload
        console.log("Form submitted!");

        let startDate = $('#startDate').val();
        let endDate = $('#endDate').val();

        console.log("Start Date:", startDate, "End Date:", endDate);

        $.ajax({
            url: '<?= base_url("settlement/index") ?>', // Ensure correct endpoint
            type: 'POST',
            data: {
                startDate: startDate,
                endDate: endDate
            },
            dataType: 'json',
            beforeSend: function() {
                console.log("Sending AJAX request...");
                $('#dataTable tbody').empty().append(
                    '<tr><td colspan="16" class="text-center">Loading...</td></tr>'
                ); // Show loading message
            },
            success: function(response) {
                console.log("API Response:", response);

                let tbody = $('#dataTable tbody');
                tbody.empty(); // Clear existing data

                if (response.status === 'success' && Array.isArray(response.data) &&
                    response.data.length > 0) {
                    let rows = '';
                    $.each(response.data, function(index, transaction) {
                        rows += `<tr>
                            <td>${index + 1}</td>
                            <td>${sanitize(transaction.transaction_ref)}</td>
                            <td>${sanitize(transaction.transaction_desc)}</td>
                            <td>${sanitize(transaction.request_ref)}</td>
                            <td>${sanitize(transaction.time_in)}</td>
                            <td>${sanitize(transaction.customer_ref)}</td>
                            <td>₦${parseFloat(transaction.amount || 0).toFixed(2)}</td>
                            <td>${sanitize(transaction.customer_firstname)} ${sanitize(transaction.customer_surname)}</td>
                            <td>${sanitize(transaction.customer_mobile_no)}</td>
                            <td>${sanitize(transaction.customer_email)}</td>
                            <td>${sanitize(transaction.provider)}</td>
                            <td>${sanitize(transaction.status)}</td>
                            <td>${sanitize(transaction.requester)}</td>
                            <td>${sanitize(transaction.transaction_type)}</td>
                        </tr>`;
                    });
                    tbody.append(rows);
                } else {
                    console.warn("No records found. Clearing table.");
                    tbody.html(
                        '<tr><td colspan="14" class="text-center text-danger">No transaction data available</td></tr>'
                    );
                }
            },

            error: function(xhr) {
                console.error("AJAX Error:", xhr.responseText);
                $('#dataTable tbody').html(
                    '<tr><td colspan="16" class="text-center text-danger">Error loading data</td></tr>'
                );
            }
        });
    });
});
</script>

