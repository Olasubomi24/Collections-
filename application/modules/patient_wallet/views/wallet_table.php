

<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Patient Wallet Transactions</h2>
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
            <form id="collectionForm">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                    value="<?= $this->security->get_csrf_hash() ?>">

                <div class="row clearfix">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="eWalletAccount">eWallet Account</label>
                            <input type="text" name="eWalletAccount" class="form-control" id="eWalletAccount">
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-success mt-2">Fetch Data</button>
                    </div>
                </div>
            </form>
            <!-- Exportable Table -->
            <div class="clearfix row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><a href="<?php  echo base_url('patient_wallet/adds_manual_funding'); ?>"><strong>Wallet Funding</strong></a>
                            </h2>
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
                            <table id="dataTable" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Email</th>
                                            <th>eWallet Account</th>
                                            <th>Amount</th>
                                            <th>Transaction ID</th>
                                            <th>Transaction Type</th>
                                            <th>Status</th>
                                            <th>Performed By</th>
                                            <th>Transaction Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        <tr>
                                            <td colspan="9" class="text-center">Loading data...</td>
                                        </tr>
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
    function fetchTransactions(filters = {}) {
        $.ajax({
            url: '<?= base_url("patient_wallet/patient_wallet_index") ?>',
            type: 'POST',
            data: filters,
            dataType: 'json',
            beforeSend: function() {
                $('#tableBody').html('<tr><td colspan="9" class="text-center">Loading...</td></tr>');
            },
            success: function(response) {
                if (response.status === 'success' && response.data.length > 0) {
                    var rows = '';
                    $.each(response.data, function(index, collection) {
                        rows += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${collection.patientDetails.email ?? '-'}</td>
                                <td>${collection.eWalletAccount ?? '-'}</td>
                                <td>₦${parseFloat(collection.amount || 0).toFixed(2)}</td>
                                <td>${collection.transactionId ?? '-'}</td>
                                <td>${collection.transactionType ?? '-'}</td>
                                <td>${collection.status ?? '-'}</td>
                                <td>${collection.performedBy.userName ?? '-'}</td>
                                <td>${new Date(collection.transactionDate).toLocaleString()}</td>
                            </tr>`;
                    });
                    $('#tableBody').html(rows);
                } else {
                    $('#tableBody').html('<tr><td colspan="9" class="text-center">No data found</td></tr>');
                }
            },
            error: function() {
                $('#tableBody').html('<tr><td colspan="9" class="text-center">Error fetching data</td></tr>');
            }
        });
    }

    // Fetch transactions on page load
    fetchTransactions({});

    // Fetch transactions on form submit
    $('#collectionForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        fetchTransactions(formData);
    });
});
</script>
