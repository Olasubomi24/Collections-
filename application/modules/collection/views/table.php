

<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Collection</h2>
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
            <?php echo form_open('collection/index', ['method' => 'post', 'id' => 'collectionForm']); ?>
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
                            <!-- <h2><a href="<?php // echo base_url('hospital/adds_hospital'); ?>"><strong>Add
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
                                <table id="dataTable" class="table table-bordered table-striped table-hover dataTable js-exportable  ">
                                <thead>
        <tr>
            <th>S/N</th>
            <th>Invoice No</th>
            <th>Description</th>
            <th>RRR No</th>
            <th>Invoice Date</th>
            <th>UHID</th>
            <th>Items</th>
            <th>Payer Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Amount</th>
            <th>Charges</th>
            <th>Total</th>
            <th>Debited</th>
            <th>Debit Date</th>
            <th>Channel</th>
            <th>Channel ID</th>
            <th>Transaction ID</th>
            <th>RRN</th>
            <th>STAN</th>
            <th>Notification Code</th>
            <th>Notification Message</th>
            <th>Amount Split</th>

        </tr>
    </thead>
    <tbody>
        <?php if (!empty($network_result)): ?>
            <?php $sn = 1; foreach ($network_result as $collection): ?>
                <tr>
                    <td><?= $sn++; ?></td>
                    <td><?= htmlspecialchars($collection['invoiceNo'] ?? '-'); ?></td>
                    <td><?= htmlspecialchars($collection['invoiceDescription'] ?? '-'); ?></td>
                    <td><?= htmlspecialchars($collection['rrrNo'] ?? '-'); ?></td>
                    <td><?= htmlspecialchars($collection['invoiceDate'] ?? '-'); ?></td>
                    <td><?= htmlspecialchars($collection['invoiceUHID'] ?? '-'); ?></td>
                    <td><?= htmlspecialchars($collection['invoiceItems'] ?? '-'); ?></td>
                    <td><?= htmlspecialchars($collection['invoicePayerName'] ?? '-'); ?></td>
                    <td><?= htmlspecialchars($collection['invoicePayerPhoneNo'] ?? '-'); ?></td>
                    <td><?= htmlspecialchars($collection['invoicePayerEmail'] ?? '-'); ?></td>
                    <td><?= '₦' . number_format($collection['invoiceAmount'] ?? 0, 2); ?></td>
                    <td><?= '₦' . number_format($collection['invoiceEstCharges'] ?? 0, 2); ?></td>
                    <td><?= '₦' . number_format($collection['invoiceTotalPayable'] ?? 0, 2); ?></td>
                    <td><?= '₦' . number_format($collection['amountDebited'] ?? 0, 2); ?></td>
                    <td><?= htmlspecialchars($collection['debitDate'] ?? '-'); ?></td>
                    <td><?= htmlspecialchars($collection['channel'] ?? '-'); ?></td>
                    <td><?= htmlspecialchars($collection['channelID'] ?? '-'); ?></td>
                    <td><?= htmlspecialchars($collection['transactionID'] ?? '-'); ?></td>
                    <td><?= htmlspecialchars($collection['rrn'] ?? '-'); ?></td>
                    <td><?= htmlspecialchars($collection['stan'] ?? '-'); ?></td>
                    <td><?= htmlspecialchars($collection['notificationCode'] ?? '-'); ?></td>
                    <td><?= htmlspecialchars($collection['notificationMessage'] ?? '-'); ?></td>
                    <td>
                        Gateway: ₦<?= number_format($collection['amountSplit']['gateway'] ?? 0, 2); ?>, 
                        Hospital: ₦<?= number_format($collection['amountSplit']['hospital'] ?? 0, 2); ?>, 
                        Platform: ₦<?= number_format($collection['amountSplit']['platform'] ?? 0, 2); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="30" class="text-center">No collections found</td>
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

    $('#collectionForm').on('submit', function(e) {
        e.preventDefault(); // Prevent page reload
        console.log("Form submitted!");

        let startDate = $('#startDate').val();
        let endDate = $('#endDate').val();

        console.log("Start Date:", startDate, "End Date:", endDate);

        $.ajax({
            url: '<?= base_url("collection/index") ?>', // Ensure correct endpoint
            type: 'POST',
            data: {
                startDate: startDate,
                endDate: endDate
            },
            dataType: 'json',
            beforeSend: function() {
                console.log("Sending AJAX request...");
                $('#dataTable tbody').empty().append('<tr><td colspan="23" class="text-center">Loading...</td></tr>'); // Updated colspan
            },
            success: function(response) {
                console.log("API Response:", response);

                let tbody = $('#dataTable tbody');
                tbody.empty(); // Clear existing data

                if (response.status === 'success' && response.data.length > 0) {
                    let rows = '';
                    $.each(response.data, function(index, collection) {
                        rows += `<tr>
                            <td>${index + 1}</td>
                            <td>${collection.invoiceNo || '-'}</td>
                            <td>${collection.invoiceDescription || '-'}</td>
                            <td>${collection.rrrNo || '-'}</td>
                            <td>${collection.invoiceDate || '-'}</td>
                            <td>${collection.invoiceUHID || '-'}</td>
                            <td>${collection.invoiceItems || '-'}</td>
                            <td>${collection.invoicePayerName || '-'}</td>
                            <td>${collection.invoicePayerPhoneNo || '-'}</td>
                            <td>${collection.invoicePayerEmail || '-'}</td>
                            <td>₦${parseFloat(collection.invoiceAmount || 0).toFixed(2)}</td>
                            <td>₦${parseFloat(collection.invoiceEstCharges || 0).toFixed(2)}</td>
                            <td>₦${parseFloat(collection.invoiceTotalPayable || 0).toFixed(2)}</td>
                            <td>₦${parseFloat(collection.amountDebited || 0).toFixed(2)}</td>
                            <td>${collection.debitDate || '-'}</td>
                            <td>${collection.channel || '-'}</td>
                            <td>${collection.channelID || '-'}</td>
                            <td>${collection.transactionID || '-'}</td>
                            <td>${collection.rrn || '-'}</td>
                            <td>${collection.stan || '-'}</td>
                            <td>${collection.notificationCode || '-'}</td>
                            <td>${collection.notificationMessage || '-'}</td>
                            <td>Gateway: ₦${parseFloat(collection.amountSplit?.gateway || 0).toFixed(2)}, 
                                Hospital: ₦${parseFloat(collection.amountSplit?.hospital || 0).toFixed(2)}, 
                                Platform: ₦${parseFloat(collection.amountSplit?.platform || 0).toFixed(2)}</td>
                        </tr>`;
                    });
                    tbody.append(rows);
                } else {
                    console.warn("No records found. Clearing table.");
                    tbody.html('<tr><td colspan="23" class="text-center text-danger">No records found</td></tr>');
                }
            },
            error: function(xhr) {
                console.error("AJAX Error:", xhr.responseText);
                $('#dataTable tbody').html('<tr><td colspan="23" class="text-center text-danger">Error loading data</td></tr>');
            }
        });
    });
});

</script>



