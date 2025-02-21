<?php

class Collection extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->module('template');
        $this->load->module('utility');
        $this->load->helper('url');
        $this->load->module('agg');
    }

    // public function index()
    // {
    //     $products = $this->utility->collection_list();
    //     $data['title'] = 'Dashboard';
    //     $data['content_view'] = 'collection/table';
    //     $this->template->general_template($data);
    // }
    public function collection_list()
    {
        $data['title'] = 'Dashboard';
        $data['content_view'] = 'collection/table';
        $this->template->general_template($data);
    }

    public function adds_collection()
    {
        $data['title'] = 'Dashboard';
        $data['content_view'] = 'collection/add_collection';
        $this->template->general_template($data);
    }
    public function add_collection()
    {
        if ($this->input->post()) {
            // Collect and map the input data to the new structure
            $walletFundingData = [
                "hospitalId" => $this->input->post('hospitalId'),
                "eWalletAccount" => $this->input->post('eWalletAccount'),
                "patientPhoneNumber" => $this->input->post('patientPhoneNumber'),
                "amount" => $this->input->post('amount'),
                "terminalId" => $this->input->post('terminalId'),
                "rrn" => $this->input->post('rrn'),
                "pan" => $this->input->post('pan'),
                "paymentMethod" => $this->input->post('paymentMethod'),
                "issuer" => $this->input->post('issuer')

            ];
    
            // Uncomment the line below for debugging purposes
            // print_r($walletFundingData); die();
    
            // Call the API and capture the response
            $apiResponse = $this->utility->create_collection($walletFundingData);
    
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
            $data['content_view'] = 'collection/add_collection'; // Update the view file name as needed
            $this->template->general_template($data);
        }
    }
    // public function index()
    // {
    //     $data['title'] = 'collections List';
    //     $data['collections'] = $this->utility->get_collections();
    //     print_r($data['collections']); die();
    //     $data['content_view'] = 'collection/table';
    //     $this->template->general_template($data);
    // }

//     public function index()
// {
//     $data['title'] = 'collections List';
//     $collectionsData = $this->utility->get_collection();
//     //print_r($collectionsData); die();
//     // Ensure the result contains data
//     $data['collections'] = isset($collectionsData['result']['data']) && is_array($collectionsData['result']['data']) 
//         ? $collectionsData['result']['data'] 
//         : [];

//     $data['content_view'] = 'collection/table';
//     $this->template->general_template($data);
// }





// public function index()
// {
//     if ($this->input->is_ajax_request()) {
//         // Get input values
//         $startDate = $this->input->post('startDate');
//         $endDate = $this->input->post('endDate');

//         // Initialize an empty array for dates
//         $var = [];

//         // Format dates if provided
//         if (!empty($startDate)) {
//             $var['startDate'] = (new DateTime($startDate))->format('Y/m/d');
//         }

//         if (!empty($endDate)) {
//             $var['endDate'] = (new DateTime($endDate))->format('Y/m/d');
//         }

//         // Validate form inputs (allow one of them to be empty)
//         $this->form_validation->set_rules('startDate', 'Start Date', 'callback_valid_date_format');
//         $this->form_validation->set_rules('endDate', 'End Date', 'callback_valid_date_format');

//         // Fetch data from API based on input
//         $collectionsData = $this->utility->get_collection($var);
//         $network_result = $collectionsData['result']['data'] ;

//         // Return success response
//         $response = [
//             'status' => 'success',
//             'message' => 'Data fetched successfully.',
//             'data' => $network_result
//         ];

//         // Send JSON response
//         $this->output->set_content_type('application/json')->set_output(json_encode($response));
//         return;
//     }

//     // If no AJAX request, fetch all data without filters first
//     $collectionsData = $this->utility->get_collection([]);
//     $network_result = $collectionsData['result']['data'] ;

//     $data = [
//         'title' => 'Dashboard',
//         'content_view' => 'collection/table',
//         'network_result' => $network_result,
//         'start_dt' => $this->input->post('startDate') ?? '',
//         'end_dt' => $this->input->post('endDate') ?? ''
//     ];

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
        $collectionsData = $this->utility->get_collection($var);
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
    $collectionsData = $this->utility->get_collection([]);
    $network_result = $collectionsData['result']['data'] ?? [];

    $data = [
        'title'          => 'Dashboard',
        'content_view'   => 'collection/table',
        'network_result' => $network_result,
        'start_dt'       => $this->input->post('startDate') ?? '',
        'end_dt'         => $this->input->post('endDate') ?? ''
    ];

    // Load the view template
    $this->template->general_template($data);
}






/**
 * Custom date validation function (YYYY-MM-DD format)
 */









    public function edits_collection($id = null) {
        // Fetch the collection data by ID
        $apiResponse = $this->utility->get_collection_by_id($id);
   // print_r($apiResponse); die();
        $data = array(
            'title' => 'Edit collection',
            'content_view' => 'collection/edit',
            'collection' => $apiResponse['result']
        );

        $this->template->general_template($data);
    }


     public function edit_collection() {
    // Validate CSRF token (if CSRF protection is enabled)
     if ($this->input->is_ajax_request()) {
        $id = $this->input->post('id'); // Get the collection ID from the form data

        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid collection ID']);
            return;
        }

        // Fetch the existing collection data
        $existingcollection = $this->utility->get_collection_by_id($id);

        if (!$existingcollection || !isset($existingcollection['data'])) {
            echo json_encode(['status' => 'error', 'message' => 'collection not found']);
            return;
        }

        // Update the collection data
        $collectionData = [
                "hospitalId" => $this->input->post('hospitalId'),
                "merchantId" => $this->input->post('merchantId'),
                "merchantAccount" => $this->input->post('merchantAccount'),
                "collectionAmount" => $this->input->post('collectionAmount'),
                "merchantBank" => $this->input->post('merchantBank'),
        ];


        // Call the utility method to update the collection
        $result = $this->utility->update_collection($id, $collectionData);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'collection updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update collection']);
        }
    } else {
        show_404(); // Handle non-AJAX requests
    }
}
}