<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Audit</h2>
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
                            <h2><a
                                    href="<?php echo base_url('audit/adds_audit'); ?>"><strong>Audit</strong></a>
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
                                            <th>Hospital ID</th>
                                            <th>Merchant ID</th>
                                            <th>Merchant Account</th>
                                            <th>audit Amount</th>
                                            <th>Merchant Bank</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <pre><?php //print_r($audits); ?></pre> <!-- Debugging Output -->
                                        <?php if (!empty($audits)): ?>
                                        <?php $sn = 1; foreach ($audits as $audit): ?>
                                        <tr>
                                            <td><?= $sn++; ?></td>
                                            <td><?= htmlspecialchars($audit['hospitalId']); ?></td>
                                            <td><?= htmlspecialchars($audit['merchantId']); ?></td>
                                            <td><?= htmlspecialchars($audit['merchantAccount']); ?></td>
                                            <td><?= htmlspecialchars(($currencySymbol ?? '₦') . ' ' . number_format($audit['auditAmount'], 2)); ?>
                                            </td>

                                            <td><?= htmlspecialchars($audit['merchantBank']); ?></td>
                                            <td>
                                                <a href="<?php echo base_url('audit/edits_audit/' . $audit['id']); ?>"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <!-- <button class="btn btn-danger btn-sm delete-btn"
                                                    data-id="<?= $audit['id']; ?>">Delete</button> -->
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">No audits found</td>
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