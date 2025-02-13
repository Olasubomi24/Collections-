<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Hospital Details</h2>
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
                            <h2><a href="<?php echo base_url('hospital/adds_hospital'); ?>"><strong>Add hospital</strong></a>
                            </h2>
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
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable  ">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Name</th>
                                            <th>Admin</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Card Insurance Commission</th>
                                            <th>E-Wallet Commission</th>
                                            <th>Collection Commission</th>
                                            <th>Domain</th>
                                            <th>Reference ID</th>
                                            <th>Transaction Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <pre><?php //print_r($hospitals); ?></pre> <!-- Debugging Output -->

                                        <?php if (!empty($hospitals)): ?>
                                        <?php $sn = 1; foreach ($hospitals as $hospital): ?>
                                        <tr>
                                            <td><?= $sn++; ?></td>
                                            <td><?= htmlspecialchars($hospital['hospitalName']); ?></td>
                                            <td><?= htmlspecialchars($hospital['hospitalAdminName']); ?></td>
                                            <td><?= htmlspecialchars($hospital['hospitalPhoneNumber']); ?></td>
                                            <td><?= htmlspecialchars($hospital['hospitalEmail']); ?></td>
                                            <td><?= htmlspecialchars($hospital['hospitalAddress']); ?></td>
                                            <td><?= htmlspecialchars($hospital['hospitalCardInsuranceCommission']); ?>%
                                            </td>
                                            <td><?= htmlspecialchars($hospital['hospitalEWalletFundingCommission']); ?>%
                                            </td>
                                            <td><?= htmlspecialchars($hospital['hospitalCollectionCommission']); ?>%
                                            </td>
                                            <td><?= htmlspecialchars($hospital['domain']); ?></td>
                                            <td><?= htmlspecialchars($hospital['referenceId']); ?></td>
                                            <td><?= htmlspecialchars($hospital['transactionDate']); ?></td>
                                            <td>
                                            <a href="<?php echo base_url('hospital/edits_hospital/' . $hospital['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
    <!-- <button class="btn btn-danger btn-sm delete-btn" 
            data-id="<?= $hospital['id']; ?>">Delete</button> -->
</td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <tr>
                                            <td colspan="13" class="text-center">No hospitals found</td>
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