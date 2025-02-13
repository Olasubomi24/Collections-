<?php

class Wallet_funding extends MX_Controller
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
    //     $products = $this->utility->wallet_funding_list();
    //     $data['title'] = 'Dashboard';
    //     $data['content_view'] = 'wallet_funding/table';
    //     $this->template->general_template($data);
    // }
    public function wallet_funding_list()
    {
        $data['title'] = 'Dashboard';
        $data['content_view'] = 'wallet_funding/table';
        $this->template->general_template($data);
    }

    public function adds_wallet_funding()
    {
        $data['title'] = 'Dashboard';
        $data['content_view'] = 'wallet_funding/add_wallet_funding';
        $this->template->general_template($data);
    }
    public function add_wallet_funding()
    {
        if ($this->input->post()) {
            // Collect and map the input data to the new structure
            $walletFundingData = [
                "hospitalId" => $this->input->post('hospitalId'),
                "eWalletAccount" => $this->input->post('eWalletAccount'),
                "patientPhoneNumber" => $this->input->post('patientPhoneNumber'),
                "amount" => $this->input->post('amount'),
                "fundingBank" => $this->input->post('fundingBank'),
                "sourceCode" => $this->input->post('sourceCode'),
                "sessionId" => uniqid() . rand(1000, 9999) // Generate a unique session ID with a random number
            ];
    
            // Uncomment the line below for debugging purposes
            // print_r($walletFundingData); die();
    
            // Call the API and capture the response
            $apiResponse = $this->utility->create_wallet_funding($walletFundingData);
    
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
            $data['content_view'] = 'wallet_funding/add_wallet_funding'; // Update the view file name as needed
            $this->template->general_template($data);
        }
    }
    // public function index()
    // {
    //     $data['title'] = 'wallet_fundings List';
    //     $data['wallet_fundings'] = $this->utility->get_wallet_fundings();
    //     print_r($data['wallet_fundings']); die();
    //     $data['content_view'] = 'wallet_funding/table';
    //     $this->template->general_template($data);
    // }

    public function index()
{
    $data['title'] = 'wallet_fundings List';
    $wallet_fundingsData = $this->utility->get_wallet_funding();
//print_r($wallet_fundingsData); die();
    // Ensure the result contains data
    $data['wallet_fundings'] = isset($wallet_fundingsData['result']['data']) && is_array($wallet_fundingsData['result']['data']) 
        ? $wallet_fundingsData['result']['data'] 
        : [];

    $data['content_view'] = 'wallet_funding/table';
    $this->template->general_template($data);
}





    public function edits_wallet_funding($id = null) {
        // Fetch the wallet_funding data by ID
        $apiResponse = $this->utility->get_wallet_funding_by_id($id);
   // print_r($apiResponse); die();
        $data = array(
            'title' => 'Edit wallet_funding',
            'content_view' => 'wallet_funding/edit',
            'wallet_funding' => $apiResponse['result']
        );

        $this->template->general_template($data);
    }


public function edit_wallet_funding() {
    // Validate CSRF token (if CSRF protection is enabled)
    if ($this->input->is_ajax_request()) {
        $id = $this->input->post('id'); // Get the wallet_funding ID from the form data

        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid wallet_funding ID']);
            return;
        }

        // Fetch the existing wallet_funding data
        $existingwallet_funding = $this->utility->get_wallet_funding_by_id($id);

        if (!$existingwallet_funding || !isset($existingwallet_funding['data'])) {
            echo json_encode(['status' => 'error', 'message' => 'wallet_funding not found']);
            return;
        }

        // Update the wallet_funding data
        $wallet_fundingData = [
            "wallet_fundingName" => $this->input->post('wallet_fundingName'),
            "wallet_fundingAdminName" => $this->input->post('wallet_fundingAdminName'),
            "wallet_fundingPhoneNumber" => $this->input->post('wallet_fundingPhoneNumber'),
            "wallet_fundingEmail" => $this->input->post('wallet_fundingEmail'),
            "wallet_fundingAddress" => $this->input->post('wallet_fundingAddress'),
            "wallet_fundingCardInsuranceCommission" => $this->input->post('wallet_fundingCardInsuranceCommission'),
            "wallet_fundingEWalletFundingCommission" => $this->input->post('wallet_fundingEWalletFundingCommission'),
            "wallet_fundingCollectionCommission" => $this->input->post('wallet_fundingCollectionCommission'),
            "domain" => $this->input->post('domain'),
            "settings" => [
                "theme" => "light",
                "language" => "en",
                "timezone" => "UTC",
                "notifications" => true
            ]
        ];


        // Call the utility method to update the wallet_funding
        $result = $this->utility->update_wallet_funding($id, $wallet_fundingData);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'wallet_funding updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update wallet_funding']);
        }
    } else {
        show_404(); // Handle non-AJAX requests
    }
}
}