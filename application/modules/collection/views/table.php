<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Collection</h2>
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
                            <ul class="header-dropdown"></ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <!-- DataTable element -->
                                <table id="dataTable" class="table table-bordered table-striped table-hover">
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
                                            <th>Card Expired</th>
                                            <th>Card Holder</th>
                                            <th>Remark</th>
                                            <th>Notification Code</th>
                                            <th>Notification Message</th>
                                            <th>Notification Status</th>
                                            <th>Amount Split</th>
                                            <th>POS Payment Status</th>
                                            <th>Payment Instrument</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Table body will be updated via AJAX -->
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

<!-- Include jQuery and SweetAlert2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Include DataTables and Buttons CSS/JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    console.log("Document is ready!");

    // Initialize DataTable with export buttons and pagination
    var table = $('#dataTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            { extend: 'csv', text: 'Download CSV' },
            { extend: 'excel', text: 'Download Excel' },
            { extend: 'pdf', text: 'Download PDF' },
            { extend: 'print', text: 'Print Table' }
        ],
        "pageLength": 10
    });

    // Function to fetch data via AJAX
    function fetchData(startDate = '', endDate = '') {
        $.ajax({
            url: '<?= base_url("collection/index") ?>', // Your endpoint here
            type: 'POST',
            data: {
                startDate: startDate,
                endDate: endDate
            },
            dataType: 'json',
            beforeSend: function() {
                console.log("Sending AJAX request...");
                // Show a loading message
                $('#dataTable tbody').html(
                    '<tr><td colspan="30" class="text-center">Loading.....</td></tr>'
                );
            },
            success: function(response) {
                console.log("API Response:", response);
                // Clear existing data from DataTable
                table.clear().draw();

                if (response.status === 'success' && response.data.length > 0) {
                    let rows = [];
                    $.each(response.data, function(index, collection) {
                        rows.push([
                            index + 1,
                            collection.invoiceNo || '-',
                            collection.invoiceDescription || '-',
                            collection.rrrNo || '-',
                            collection.invoiceDate || '-',
                            collection.invoiceUHID || '-',
                            collection.invoiceItems || '-',
                            collection.invoicePayerName || '-',
                            collection.invoicePayerPhoneNo || '-',
                            collection.invoicePayerEmail || '-',
                            '₦' + parseFloat(collection.invoiceAmount || 0).toFixed(2),
                            '₦' + parseFloat(collection.invoiceEstCharges || 0).toFixed(2),
                            '₦' + parseFloat(collection.invoiceTotalPayable || 0).toFixed(2),
                            '₦' + parseFloat(collection.amountDebited || 0).toFixed(2),
                            collection.debitDate || '-',
                            collection.channel || '-',
                            collection.channelID || '-',
                            collection.transactionID || '-',
                            collection.rrn || '-',
                            collection.stan || '-',
                            collection.cardExpiry || '-',
                            collection.cardHolder || '-',
                            collection.remarks || '-',
                            collection.notificationCode || '-',
                            collection.notificationMessage || '-',
                            collection.notificationStatus || '-',
                            'Gateway: ₦' + parseFloat(collection.amountSplit?.gateway || 0).toFixed(2) +
                                ', Hospital: ₦' + parseFloat(collection.amountSplit?.hospital || 0).toFixed(2) +
                                ', Platform: ₦' + parseFloat(collection.amountSplit?.platform || 0).toFixed(2),
                            collection.invoicePOSPaymentStatus || '-',
                            collection.paymentInstrument || '-',
                            // Action button: store the entire invoice object as JSON in a data attribute.
                            '<button class="print-receipt-btn" data-invoice=\'' + JSON.stringify(collection) + '\'>Print Receipt</button>'
                        ]);
                    });
                    // Add rows to DataTable and redraw
                    table.rows.add(rows).draw();
                } else {
                    $('#dataTable tbody').html(
                        '<tr><td colspan="30" class="text-center">No records found</td></tr>'
                    );
                }
            },
            error: function(xhr) {
                console.error("AJAX Error:", xhr.responseText);
                $('#dataTable tbody').html(
                    '<tr><td colspan="30" class="text-center text-danger">Error loading data</td></tr>'
                );
            }
        });
    }

    // Automatically load data on page load
    fetchData();

    // Handle filter form submission
    $('#collectionForm').on('submit', function(e) {
        e.preventDefault();
        console.log("Form submitted!");
        let startDate = $('#startDate').val();
        let endDate = $('#endDate').val();
        console.log("Start Date:", startDate, "End Date:", endDate);
        fetchData(startDate, endDate);
    });

    // Delegate click event for print receipt buttons (data stored in button)
    $('#dataTable tbody').on('click', '.print-receipt-btn', function() {
        let invoiceData = $(this).data('invoice');  // Retrieve stored invoice object
        if(invoiceData) {
            generateAndPrintReceipt(invoiceData);
        } else {
            alert('Invoice data not found.');
        }
    });

    // Function to generate and print receipt based on invoice data
    function generateAndPrintReceipt(data) {
        let receiptHTML = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Receipt</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        width: 210mm; /* A4 width */
                        margin: 0 auto;
                        padding: 20px;
                        border: 1px solid #ccc;
                    }
                    h1, h3, p strong { font-weight: bold; }
                    .receipt-container { max-width: 600px; margin: 0 auto; }
                    .header { text-align: center; margin-bottom: 20px; }
                    .details { margin-bottom: 10px; }
                    .footer { text-align: right; margin-top: 20px; }
                </style>
            </head>
            <body>
                <div class="receipt-container">
                    <div class="header">
                        <div class="user-info">
                            <a class="image" href="<?= base_url('dashboard/index'); ?>">
                                <img src="<?= isset($_SESSION['hospital_url']) && !empty($_SESSION['hospital_url']) ? $_SESSION['hospital_url'] : base_url('assets/images/profile_av.jpg'); ?>" alt="Hospital Profile">
                            </a>
                            <div class="detail">
                                <h4><?= $_SESSION['hospital_name'] ?></h4>
                            </div>
                        </div>
                        <h1>BILLING RECEIPT</h1>
                    </div>
                    <div class="details">
                        <p><strong>Invoice No:</strong> ${data.invoiceNo || '-'}</p>
                        <p><strong>Description:</strong> ${data.invoiceDescription || '-'}</p>
                        <p><strong>RRR No:</strong> ${data.rrrNo || '-'}</p>
                        <p><strong>Date:</strong> ${data.invoiceDate || '-'}</p>
                        <p><strong>Payer Name:</strong> ${data.invoicePayerName || '-'}</p>
                        <p><strong>Phone:</strong> ${data.invoicePayerPhoneNo || '-'}</p>
                        <p><strong>Email:</strong> ${data.invoicePayerEmail || '-'}</p>
                        <p><strong>Amount:</strong> ₦${parseFloat(data.invoiceAmount || 0).toFixed(2)}</p>
                        <p><strong>Total Payable:</strong> ₦${parseFloat(data.invoiceTotalPayable || 0).toFixed(2)}</p>
                        <p><strong>Payment Status:</strong> ${data.invoicePOSPaymentStatus || '-'}</p>
                        <p><strong>Remarks:</strong> ${data.remarks || '-'}</p>
                    </div>
                    <hr>
                    <div class="footer">
                        <h3>Thank You!</h3>
                    </div>
                </div>
            </body>
            </html>
        `;

        let printWindow = window.open('', '_blank');
        printWindow.document.open();
        printWindow.document.write(receiptHTML);
        printWindow.document.close();
        printWindow.onload = function() {
            printWindow.print();
            printWindow.close();
        };
    }

    // Function to download CSV file (if needed separately)
    function downloadCSV(data) {
        if (!data.length) {
            alert("No data available to download.");
            return;
        }
        let csvContent = "data:text/csv;charset=utf-8,";
        let headers = [
            "Invoice No", "Description", "RRR No", "Date", "Payer Name",
            "Phone", "Email", "Amount", "Total Payable", "Payment Status", "Remarks"
        ];
        csvContent += headers.join(",") + "\n";
        data.forEach(row => {
            let csvRow = [
                row.invoiceNo || '-',
                row.invoiceDescription || '-',
                row.rrrNo || '-',
                row.invoiceDate || '-',
                row.invoicePayerName || '-',
                row.invoicePayerPhoneNo || '-',
                row.invoicePayerEmail || '-',
                parseFloat(row.invoiceAmount || 0).toFixed(2),
                parseFloat(row.invoiceTotalPayable || 0).toFixed(2),
                row.invoicePOSPaymentStatus || '-',
                row.remarks || '-'
            ];
            csvContent += csvRow.join(",") + "\n";
        });
        let encodedUri = encodeURI(csvContent);
        let link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "collection_data.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
});
</script>
