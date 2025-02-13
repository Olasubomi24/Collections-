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

            <!-- Exportable Table -->
            <div class="clearfix row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <!-- <h2><a
                                    href="<?php //echo base_url('collection/adds_collection'); ?>"><strong>Collection</strong></a>
                            </h2> -->
                            <ul class="header-dropdown">
                                <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle"
                                        data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="zmdi zmdi-more"></i> </a>
                                    <!-- <ul class="dropdown-menu dropdown-menu-right slideUp">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else</a></li>
                                    </ul> -->
                                </li>
                                <!-- <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li> -->
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable  ">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Invoice No</th>
                                            <th>Invoice Description</th>
                                            <th>RRR No</th>
                                            <th>Invoice Date</th>
                                            <th>UHID</th>
                                            <th>Invoice Items</th>
                                            <th>Payer Name</th>
                                            <th>Payer Phone</th>
                                            <th>Payer Email</th>
                                            <th>Invoice Amount</th>
                                            <th>Estimated Charges</th>
                                            <th>Total Payable</th>
                                            <th>Amount Debited</th>
                                            <th>Debit Date</th>
                                            <th>Channel</th>
                                            <th>Channel ID</th>
                                            <th>Transaction ID</th>
                                            <th>RRN</th>
                                            <th>STAN</th>
                                            <th>Notification Code</th>
                                            <th>Notification Message</th>
                                            <th>Amount Split</th>
                                            <th>Remarks</th>
                                            <th>Bank</th>
                                            <th>Payment Instrument</th>
                                            <th>Card Holder</th>
                                            <th>Card Scheme</th>
                                            <th>Card PAN</th>
                                            <th>Card Expiry</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($collections)): ?>
                                        <?php $sn = 1; foreach ($collections as $collection): ?>
                                        <tr>
                                            <td><?= $sn++; ?></td>
                                            <td><?= htmlspecialchars($collection['invoiceNo']); ?></td>
                                            <td><?= htmlspecialchars($collection['invoiceDescription']); ?></td>
                                            <td><?= htmlspecialchars($collection['rrrNo']); ?></td>
                                            <td><?= htmlspecialchars($collection['invoiceDate']); ?></td>
                                            <td><?= htmlspecialchars($collection['invoiceUHID']); ?></td>
                                            <td><?= htmlspecialchars($collection['invoiceItems']); ?></td>
                                            <td><?= htmlspecialchars($collection['invoicePayerName']); ?></td>
                                            <td><?= htmlspecialchars($collection['invoicePayerPhoneNo']); ?></td>
                                            <td><?= htmlspecialchars($collection['invoicePayerEmail']); ?></td>
                                            <td><?= htmlspecialchars(number_format($collection['invoiceAmount'], 2)) . ' ' . ($currencySymbol ?? '₦'); ?>
                                            </td>
                                            <td><?= htmlspecialchars(number_format($collection['invoiceEstCharges'], 2)) . ' ' . ($currencySymbol ?? '₦'); ?>
                                            </td>
                                            <td><?= htmlspecialchars(number_format($collection['invoiceTotalPayable'], 2)) . ' ' . ($currencySymbol ?? '₦'); ?>
                                            </td>
                                            <td><?= htmlspecialchars(number_format($collection['amountDebited'], 2)) . ' ' . ($currencySymbol ?? '₦'); ?>
                                            </td>
                                            <td><?= htmlspecialchars($collection['debitDate']); ?></td>
                                            <td><?= htmlspecialchars($collection['channel']); ?></td>
                                            <td><?= htmlspecialchars($collection['channelID']); ?></td>
                                            <td><?= htmlspecialchars($collection['transactionID']); ?></td>
                                            <td><?= htmlspecialchars($collection['rrn']); ?></td>
                                            <td><?= htmlspecialchars($collection['stan']); ?></td>
                                            <td><?= htmlspecialchars($collection['notificationCode']); ?></td>
                                            <td><?= htmlspecialchars($collection['notificationMessage']); ?></td>
                                            <td><?= htmlspecialchars($collection['amountSplit']); ?></td>
                                            <td><?= htmlspecialchars($collection['remarks']); ?></td>
                                            <td><?= htmlspecialchars($collection['bank']); ?></td>
                                            <td><?= htmlspecialchars($collection['paymentInstrument']); ?></td>
                                            <td><?= htmlspecialchars($collection['cardHolder']); ?></td>
                                            <td><?= htmlspecialchars($collection['cardScheme']); ?></td>
                                            <td><?= htmlspecialchars($collection['cardPAN']); ?></td>
                                            <td><?= htmlspecialchars($collection['cardExpiry']); ?></td>
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