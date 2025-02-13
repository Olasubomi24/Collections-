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

    public function index()
{
    $data['title'] = 'settlements List';
    $settlementsData = $this->utility->get_settlement();
    //print_r($settlementsData); die();
    // Ensure the result contains data
    $data['settlements'] = isset($settlementsData['result']['data']) && is_array($settlementsData['result']['data']) 
        ? $settlementsData['result']['data'] 
        : [];

    $data['content_view'] = 'settlement/table';
    $this->template->general_template($data);
}





    public function edits_settlement($id = null) {
        // Fetch the settlement data by ID
        $apiResponse = $this->utility->get_settlement_by_id($id);
   // print_r($apiResponse); die();
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

        if (!$existingsettlement || !isset($existingsettlement['data'])) {
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