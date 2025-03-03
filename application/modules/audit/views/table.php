<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Audit logs</h2>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button">
                        <i class="zmdi zmdi-sort-amount-desc"></i>
                    </button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="float-right btn btn-primary btn-icon right_icon_toggle_btn" type="button">
                        <i class="zmdi zmdi-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <!-- Filter Form -->
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
                            <ul class="header-dropdown"></ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Hospital Name</th>
                                            <th>Email</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                            <th>Status</th>
                                            <th>Response Body</th>
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
        </div>
    </div>
</section>

<!-- Include jQuery, SweetAlert2, and DOMPurify if needed -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.10/purify.min.js"></script>

<!-- Include DataTables and Buttons extension -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

<script>
// Optional: A function to sanitize strings (using jQuery here)
function sanitize(str) {
    return $('<div>').text(str).html();
}

// Function to format JSON data for display
function formatJson(jsonData) {
    try {
        if (typeof jsonData === 'string') {
            jsonData = JSON.parse(jsonData);
        }
        return JSON.stringify(jsonData, null, 2);
    } catch (e) {
        console.error("Invalid JSON:", e);
        return sanitize(jsonData || '-');
    }
}

$(document).ready(function() {
    console.log("Document is ready!");

    // Initialize DataTable with AJAX source, export buttons (including Print), and pagination
    var table = $('#dataTable').DataTable({
        processing: true,
        serverSide: false, // Using client-side paging here
        ajax: {
            url: '<?= base_url("audit/index") ?>',  // Adjust your endpoint as needed
            type: 'POST',
            data: function(d) {
                d.startDate = $('#startDate').val();
                d.endDate = $('#endDate').val();
            },
            dataSrc: function(json) {
                if (json.status === 'success') {
                    return json.data;
                } else {
                    return [];
                }
            },
            beforeSend: function() {
                // Show a loading message with five dots
                $('#dataTable tbody').html(
                    // '<tr><td colspan="7" class="text-center">Loading.....</td></tr>'
                );
            }
        },
        columns: [
            { data: null, render: function(data, type, row, meta) {
                return meta.row + 1;
            }},
            { data: 'Hospital.hospitalName', defaultContent: '-' },
            { data: 'user.email', defaultContent: '-' },
            { data: 'type', defaultContent: '-' },
            { data: 'action', defaultContent: '-' },
            { data: 'status', defaultContent: '-' },
            { data: 'responseBody', render: function(data, type, row, meta) {
                let formatted = formatJson(data);
                let summary = formatted.substring(0, 50) + '...';
                // Use row.id if available, otherwise meta.row
                let id = row.id || meta.row;
                return '<button class="btn btn-sm btn-secondary toggle-json" data-id="' + id + '">View Details</button>' +
                       '<div id="json-summary-' + id + '" style="display:inline;"> ' + summary + '</div>' +
                       '<div id="json-full-' + id + '" style="display:none; white-space: pre-wrap; border:1px solid #ccc; padding:10px; margin-top:5px;">' + formatted + '</div>';
            }, defaultContent: '-' }
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

    // Reload table when the filter form is submitted
    $('#settlementForm').on('submit', function(e) {
        e.preventDefault();
        table.ajax.reload();
    });

    // Delegate event for toggling JSON details in the responseBody column
    $('#dataTable tbody').on('click', '.toggle-json', function() {
        let id = $(this).data('id');
        $('#json-full-' + id).toggle();
        $('#json-summary-' + id).toggle();
    });
});
</script>




