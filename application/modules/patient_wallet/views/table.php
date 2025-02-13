<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Patient Wallet Details</h2>
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
                            <h2><a href="<?php echo base_url('patient_wallet/adds_patient_wallet'); ?>"><strong>Add Patient Wallet</strong></a>
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
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Middle Name</th>
                                            <th>Gender</th>
                                            <th>Date of Birth</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Alternate Number</th>
                                            <th>Address</th>
                                            <th>BVN</th>
                                            <th>NIN</th>
                                            <th>Hospital ID</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <pre><?php //print_r($patients); ?></pre> <!-- Debugging Output -->
                                        <?php if (!empty($patient_wallets)): ?>
                                        <?php $sn = 1; foreach ($patient_wallets as $patient): ?>
                                        <tr>
                                            <td><?= $sn++; ?></td>
                                            <td><?= htmlspecialchars($patient['patientFirstName']); ?></td>
                                            <td><?= htmlspecialchars($patient['patientLastName']); ?></td>
                                            <td><?= htmlspecialchars($patient['patientMiddleName']); ?></td>
                                            <td><?= htmlspecialchars($patient['gender']); ?></td>
                                            <td><?= htmlspecialchars($patient['dob']); ?></td>
                                            <td><?= htmlspecialchars($patient['email']); ?></td>
                                            <td><?= htmlspecialchars($patient['phoneNumber']); ?></td>
                                            <td><?= htmlspecialchars($patient['alternateNumber']); ?></td>
                                            <td><?= htmlspecialchars($patient['address']); ?></td>
                                            <td><?= htmlspecialchars($patient['bvn']); ?></td>
                                            <td><?= htmlspecialchars($patient['nin']); ?></td>
                                            <td><?= htmlspecialchars($patient['hospitalId']); ?></td>
                                            <td>
                                                <a href="<?php echo base_url('patient_wallet/edits_patient_wallet/' . $patient['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <!-- <button class="btn btn-danger btn-sm delete-btn" 
                                                    data-id="<?= $patient['id']; ?>">Delete</button> -->
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <tr>
                                            <td colspan="14" class="text-center">No patients found</td>
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