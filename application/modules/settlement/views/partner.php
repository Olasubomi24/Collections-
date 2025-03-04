<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <h2>Settlement Report</h2>
        </div>
        <div class="container-fluid">
            <!-- Filter Form for Partners -->
            <?php echo form_open('settlement/partner_index', ['method' => 'post', 'id' => 'settlementForm']); ?>
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

            <!-- Partners Settlement Report Table -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Settlement Records</strong></h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="partnersTable" class="table table-bordered table-striped">
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
                                        <!-- Data will be loaded via AJAX -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settlement Details Modal -->
            <div class="modal fade" id="settlementDetailsModal" tabindex="-1" role="dialog" aria-labelledby="settlementDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="settlementDetailsModalLabel">Settlement Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Settlement Date:</strong> <span id="modal-settlement-date"></span></p>
                            <p><strong>Beneficiary Name:</strong> <span id="modal-beneficiary-name"></span></p>
                            <p><strong>Account Number:</strong> <span id="modal-account-number"></span></p>
                            <p><strong>Bank Name:</strong> <span id="modal-bank-name"></span></p>
                            <p><strong>Total Amount:</strong> <span id="modal-total-amount"></span></p>
                            <p><strong>Status:</strong> <span id="modal-status"></span></p>
                            <p><strong>Processing Error:</strong> <span id="modal-processing-error"></span></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal -->

        </div>
    </div>
</section>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Include DataTables CSS and JS, Buttons extension, and export libraries -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<!-- Optionally include pdfmake for PDF export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<script>
// Optional: A function to sanitize strings (if needed)
function sanitize(str) {
    return $('<div>').text(str).html();
}

$(document).ready(function() {
    // Initialize DataTable with AJAX source, export buttons, pagination, and search box
    var table = $('#partnersTable').DataTable({
        processing: true,
        serverSide: false, // Use client-side processing; change if you need server-side
        ajax: {
            url: '<?= base_url("settlement/partner_index") ?>',  // Adjust the endpoint as needed
            type: 'POST',
            data: function(d) {
                d.startDate = $('#startDate').val();
                d.endDate = $('#endDate').val();
            },
            dataSrc: function(json) {
                Swal.close();
                if (json.status === 'success') {
                    return json.data;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Data Load Error',
                        text: 'Failed to load data from the server.'
                    });
                    return [];
                }
            },
            beforeSend: function() {
                Swal.fire({
                    title: 'Loading...',
                    text: 'Please wait while data is being fetched.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            complete: function() {
                Swal.close();
            },
            error: function(xhr, status, error) {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'AJAX Error',
                    text: 'Error occurred: ' + error
                });
            }
        },
        columns: [
            { data: null, render: function(data, type, row, meta) {
                return meta.row + 1;
            }},
            { data: 'settlementDate', defaultContent: '-' },
            { data: 'merchantAccount.beneficiaryName', defaultContent: '-' },
            { data: 'merchantAccount.accountNumber', defaultContent: '-' },
            { data: 'merchantAccount.bankName', defaultContent: '-' },
            { data: 'totalAmount', defaultContent: '-' },
            { data: 'status', defaultContent: '-' },
            { data: 'processingError', 
              defaultContent: '-',
              render: function(data, type, row, meta) {
                  // Wrap the totalAmount in a clickable link to view settlement details.
                  // You can adjust this as needed; here we assume the JSON data is sent along.
                  return '<a href="#" class="view-settlement-details" data-settlement=\'' + JSON.stringify(row).replace(/'/g, "&#39;") + '\'>' + data + '</a>';
              }
            }
        ],
        dom: 'Bfrtip',
        buttons: [
            { extend: 'csv', text: 'Download CSV' },
            { extend: 'excel', text: 'Download Excel' },
            { extend: 'pdf', text: 'Download PDF' },
            { extend: 'print', text: 'Print Table' }
        ],
        pageLength: 20
    });

    // Reload the table data when the filter form is submitted
    $('#settlementForm').on('submit', function(e) {
        e.preventDefault();
        table.ajax.reload();
    });

    // Delegate event for viewing settlement details from AJAX-loaded rows
    $('#partnersTable tbody').on('click', '.view-settlement-details', function(e) {
        e.preventDefault();
        var settlementData = $(this).data("settlement");

        // Populate modal fields with data from the settlement record
        $("#modal-settlement-date").text(settlementData.settlementDate);
        $("#modal-beneficiary-name").text(settlementData.merchantAccount.beneficiaryName);
        $("#modal-account-number").text(settlementData.merchantAccount.accountNumber);
        $("#modal-bank-name").text(settlementData.merchantAccount.bankName);
        $("#modal-total-amount").text(settlementData.totalAmount);
        $("#modal-status").text(settlementData.status);
        $("#modal-processing-error").text(settlementData.processingError);

        // Show the modal (assuming you are using Bootstrap's modal)
        $("#settlementDetailsModal").modal("show");
    });
});
</script>
