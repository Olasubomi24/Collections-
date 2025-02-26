<?php

class Audit extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->module('template');
        $this->load->module('utility');

        $this->load->module('agg');
    }

    // public function index()
    // {
    //     $products = $this->utility->audit_list();
    //     $data['title'] = 'Dashboard';
    //     $data['content_view'] = 'audit/table';
    //     $this->template->general_template($data);
    // }
    public function audit_list()
    {
        $data['title'] = 'Dashboard';
        $data['content_view'] = 'audit/table';
        $this->template->general_template($data);
    }

    public function adds_audit()
    {
        $data['title'] = 'Dashboard';
        $data['content_view'] = 'audit/add_audit';
        $this->template->general_template($data);
    }
    public function add_audit()
    {
        if ($this->input->post()) {
            // Collect and map the input data to the new structure
            $walletFundingData = [
                "hospitalId" => $this->input->post('hospitalId'),
                "merchantId" => $this->input->post('merchantId'),
                "merchantAccount" => $this->input->post('merchantAccount'),
                "auditAmount" => $this->input->post('auditAmount'),
                "merchantBank" => $this->input->post('merchantBank'),

            ];


    
            // Uncomment the line below for debugging purposes
            // print_r($walletFundingData); die();
    
            // Call the API and capture the response
            $apiResponse = $this->utility->create_audit($walletFundingData);
    
            // Check if the response is already an array
            if (is_array($apiResponse)) {
                $responseData = $apiResponse;
            } else {
                // Decode the JSON string if it's not already an array
                $responseData = json_decode($apiResponse, true);
            }
    
            if ($responseData && isset($responseData['status']) && $responseData['status'] == 'success') {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Wallet funding initiated successfully.'
                ]);
            } else {
                $errorMessage = isset($responseData['message']) ? $responseData['message'] : 'An error occurred while initiating wallet funding.';
                echo json_encode([
                    'status' => 'error',
                    'message' => $errorMessage
                ]);
            }
            exit();
        } else {
            // Load the form view for adding wallet funding
            $data['title'] = 'Add Wallet Funding';
            $data['content_view'] = 'audit/add_audit'; // Update the view file name as needed
            $this->template->general_template($data);
        }
    }
    // public function index()
    // {
    //     $data['title'] = 'audits List';
    //     $data['audits'] = $this->utility->get_audits();
    //     print_r($data['audits']); die();
    //     $data['content_view'] = 'audit/table';
    //     $this->template->general_template($data);
    // }

//     public function index()
// {
//     $data['title'] = 'audits List';
//     $auditsData = $this->utility->get_audit();
//    // print_r($auditsData); die();
//     // Ensure the result contains data
//     $data['audits'] = isset($auditsData['result']['items']) && is_array($auditsData['result']['items']) 
//         ? $auditsData['result']['items'] 
//         : [];

//     $data['content_view'] = 'audit/table';
//     $this->template->general_template($data);
// }

public function index()
{
    if ($this->input->is_ajax_request()) {
        // Get input values
        $startDate = trim($this->input->post('startDate'));
        $endDate = trim($this->input->post('endDate'));

        log_message('debug', "Received AJAX Request: Start Date = {$startDate}, End Date = {$endDate}");

        // Initialize filter array
        $var = [];

        // Validate and format dates if provided
        if (!empty($startDate) && strtotime($startDate)) {
            $var['startDate'] = date('Y/m/d', strtotime($startDate));
        }

        if (!empty($endDate) && strtotime($endDate)) {
            $var['endDate'] = date('Y/m/d', strtotime($endDate));
        }

        log_message('debug', 'Formatted Filters: ' . json_encode($var));

        // Fetch filtered data from API
        $collectionsData = $this->utility->get_audit($var);
        log_message('debug', 'API Response: ' . json_encode($collectionsData));

        // Check if API response contains valid data
        $network_result = $collectionsData['result']['data'] ?? [];
        
        $response = [
            'status'  => !empty($network_result) ? 'success' : 'error',
            'message' => !empty($network_result) ? 'Data fetched successfully.' : 'No data found for the selected filters.',
            'data'    => $network_result
        ];

        // Send JSON response
        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($response));
    }

    // If no AJAX request, fetch all data without filters
    $collectionsData = $this->utility->get_audit([]);
    $network_result = $collectionsData['result']['data'] ?? [];

    $data = [
        'title'          => 'Dashboard',
        'content_view'   => 'audit/table',
        'network_result' => $network_result,
        'start_dt'       => $this->input->post('startDate') ?? '',
        'end_dt'         => $this->input->post('endDate') ?? ''
    ];

    // Load the view template
    $this->template->general_template($data);
}


public function indexs()
{
    $data['title'] = 'audits List';
    $auditsData = $this->utility->get_audit();
   // print_r($auditsData); die();
    // Ensure the result contains data
    $data['audits'] = isset($auditsData['result']['items']) && is_array($auditsData['result']['items']) 
        ? $auditsData['result']['items'] 
        : [];

    $data['content_view'] = 'audit/audit_table';
    $this->template->general_template($data);
}





    public function edits_audit($id = null) {
        // Fetch the audit data by ID
        $apiResponse = $this->utility->get_audit_by_id($id);
   //print_r($apiResponse); die();
        $data = array(
            'title' => 'Edit audit',
            'content_view' => 'audit/edit',
            'audit' => $apiResponse['result']
        );

        $this->template->general_template($data);
    }


     public function edit_audit() {
    // Validate CSRF token (if CSRF protection is enabled)
     if ($this->input->is_ajax_request()) {
        $id = $this->input->post('id'); // Get the audit ID from the form data

        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid audit ID']);
            return;
        }

        // Fetch the existing audit data
        $existingaudit = $this->utility->get_audit_by_id($id);
  
        if (!$existingaudit || !isset($existingaudit['result'])) {
            echo json_encode(['status' => 'error', 'message' => 'audit not found']);
            return;
        }

        // Update the audit data
        $auditData = [
                "hospitalId" => $this->input->post('hospitalId'),
                "merchantId" => $this->input->post('merchantId'),
                "merchantAccount" => $this->input->post('merchantAccount'),
                "auditAmount" => $this->input->post('auditAmount'),
                "merchantBank" => $this->input->post('merchantBank'),
        ];
     //print_r($auditData); die();

        // Call the utility method to update the audit
        $result = $this->utility->update_audit($id, $auditData);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'audit updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update audit']);
        }
    } else {
        show_404(); // Handle non-AJAX requests
    }
}
}