<?php

class Settlement extends MX_Controller
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
    //     $products = $this->utility->settlement_list();
    //     $data['title'] = 'Dashboard';
    //     $data['content_view'] = 'settlement/table';
    //     $this->template->general_template($data);
    // }
    public function settlement_list()
    {
        $data['title'] = 'Dashboard';
        $data['content_view'] = 'settlement/table';
        $this->template->general_template($data);
    }

    public function adds_settlement()
    {
        $data['title'] = 'Dashboard';
        $data['content_view'] = 'settlement/add_settlement';
        $this->template->general_template($data);
    }
    public function add_settlement()
    {
        if ($this->input->post()) {
            // Collect and map the input data to the new structure
            $walletFundingData = [
                "hospitalId" => $this->input->post('hospitalId'),
                "merchantId" => $this->input->post('merchantId'),
                "merchantAccount" => $this->input->post('merchantAccount'),
                "settlementAmount" => $this->input->post('settlementAmount'),
                "merchantBank" => $this->input->post('merchantBank'),

            ];


    
            // Uncomment the line below for debugging purposes
            // print_r($walletFundingData); die();
    
            // Call the API and capture the response
            $apiResponse = $this->utility->create_settlement($walletFundingData);
    
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
            $data['content_view'] = 'settlement/add_settlement'; // Update the view file name as needed
            $this->template->general_template($data);
        }
    }
    // public function index()
    // {
    //     $data['title'] = 'settlements List';
    //     $data['settlements'] = $this->utility->get_settlements();
    //     print_r($data['settlements']); die();
    //     $data['content_view'] = 'settlement/table';
    //     $this->template->general_template($data);
    // }

//     public function index()
// {
//     $data['title'] = 'settlements List';
//     $settlementsData = $this->utility->get_settlement();
//    // print_r($settlementsData); die();
//     // Ensure the result contains data
//     $data['settlements'] = isset($settlementsData['result']['items']) && is_array($settlementsData['result']['items']) 
//         ? $settlementsData['result']['items'] 
//         : [];

//     $data['content_view'] = 'settlement/table';
//     $this->template->general_template($data);
// }bank_settlement_index

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
        $collectionsData = $this->utility->get_settlements($var);
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
    $collectionsData = $this->utility->get_settlements([]);
    $network_result = $collectionsData['result']['data'] ?? [];

    $data = [
        'title'          => 'Dashboard',
        'content_view'   => 'settlement/table',
        'network_result' => $network_result,
        'start_dt'       => $this->input->post('startDate') ?? '',
        'end_dt'         => $this->input->post('endDate') ?? ''
    ];

    // Load the view template
    $this->template->general_template($data);
}

public function partner_index()
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
        $collectionsData = $this->utility->get_pertner_settlements($var);
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
    $collectionsData = $this->utility->get_pertner_settlements([]);
    $network_result = $collectionsData['result']['data'] ?? [];
//print_r($network_result); die;
    $data = [
        'title'          => 'Dashboard',
        'content_view'   => 'settlement/partner',
        'network_result' => $network_result,
        'start_dt'       => $this->input->post('startDate') ?? '',
        'end_dt'         => $this->input->post('endDate') ?? ''
    ];

    // Load the view template
    $this->template->general_template($data);
}


public function bank_settlement_index()
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
        $collectionsData = $this->utility->get_bank_settlements($var);
        log_message('debug', 'API Response: ' . json_encode($collectionsData));

        // Check if API response contains valid data
        $network_result = $collectionsData['result'] ?? [];
//  print_r($network_result); die;
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
    $collectionsData = $this->utility->get_bank_settlements([]);
    $network_result = $collectionsData['result'] ?? [];
    //print_r($network_result); die;
    $data = [
        'title'          => 'Dashboard',
        'content_view'   => 'settlement/bank_transfer_payment',
        'network_result' => $network_result,
        'start_dt'       => $this->input->post('startDate') ?? '',
        'end_dt'         => $this->input->post('endDate') ?? ''
    ];

    // Load the view template
    $this->template->general_template($data);
}


    public function edits_settlement($id = null) {
        // Fetch the settlement data by ID
        $apiResponse = $this->utility->get_settlement_by_id($id);
   //print_r($apiResponse); die();
        $data = array(
            'title' => 'Edit settlement',
            'content_view' => 'settlement/edit',
            'settlement' => $apiResponse['result']
        );

        $this->template->general_template($data);
    }


     public function edit_settlement() {
    // Validate CSRF token (if CSRF protection is enabled)
     if ($this->input->is_ajax_request()) {
        $id = $this->input->post('id'); // Get the settlement ID from the form data

        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid settlement ID']);
            return;
        }

        // Fetch the existing settlement data
        $existingsettlement = $this->utility->get_settlement_by_id($id);
  
        if (!$existingsettlement || !isset($existingsettlement['result'])) {
            echo json_encode(['status' => 'error', 'message' => 'settlement not found']);
            return;
        }

        // Update the settlement data
        $settlementData = [
                "hospitalId" => $this->input->post('hospitalId'),
                "merchantId" => $this->input->post('merchantId'),
                "merchantAccount" => $this->input->post('merchantAccount'),
                "settlementAmount" => $this->input->post('settlementAmount'),
                "merchantBank" => $this->input->post('merchantBank'),
        ];
     //print_r($settlementData); die();

        // Call the utility method to update the settlement
        $result = $this->utility->update_settlement($id, $settlementData);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'settlement updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update settlement']);
        }
    } else {
        show_404(); // Handle non-AJAX requests
    }
}


}