<?php

class User extends MX_Controller
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
    //     $products = $this->utility->user_list();
    //     $data['title'] = 'Dashboard';
    //     $data['content_view'] = 'user/table';
    //     $this->template->general_template($data);
    // }
    public function user_list()
    {
        $data['title'] = 'Dashboard';
        $data['content_view'] = 'user/table';
        $this->template->general_template($data);
    }

    public function adds_user()
    {
        $data['title'] = 'Dashboard';
        $data['content_view'] = 'user/add_user';
        $this->template->general_template($data);
    }
    public function add_user()
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
            $apiResponse = $this->utility->create_user($walletFundingData);
    
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
            $data['content_view'] = 'user/add_user'; // Update the view file name as needed
            $this->template->general_template($data);
        }
    }
    // public function index()
    // {
    //     $data['title'] = 'users List';
    //     $data['users'] = $this->utility->get_users();
    //     print_r($data['users']); die();
    //     $data['content_view'] = 'user/table';
    //     $this->template->general_template($data);
    // }

    public function index()
{
    $data['title'] = 'users List';
    $usersData = $this->utility->get_user();
    //print_r($usersData); die();
    // Ensure the result contains data
    $data['users'] = isset($usersData['result']['data']) && is_array($usersData['result']['data']) 
        ? $usersData['result']['data'] 
        : [];

    $data['content_view'] = 'user/table';
    $this->template->general_template($data);
}





    public function edits_user($id = null) {
        // Fetch the user data by ID
        $apiResponse = $this->utility->get_user_by_id($id);
   // print_r($apiResponse); die();
        $data = array(
            'title' => 'Edit user',
            'content_view' => 'user/edit',
            'user' => $apiResponse['result']
        );

        $this->template->general_template($data);
    }


     public function edit_user() {
    // Validate CSRF token (if CSRF protection is enabled)
     if ($this->input->is_ajax_request()) {
        $id = $this->input->post('id'); // Get the user ID from the form data

        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid user ID']);
            return;
        }

        // Fetch the existing user data
        $existinguser = $this->utility->get_user_by_id($id);

        if (!$existinguser || !isset($existinguser['data'])) {
            echo json_encode(['status' => 'error', 'message' => 'user not found']);
            return;
        }

        // Update the user data
        $userData = [
                "hospitalId" => $this->input->post('hospitalId'),
                "merchantId" => $this->input->post('merchantId'),
                "merchantAccount" => $this->input->post('merchantAccount'),
                "userAmount" => $this->input->post('userAmount'),
                "merchantBank" => $this->input->post('merchantBank'),
        ];


        // Call the utility method to update the user
        $result = $this->utility->update_user($id, $userData);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'user updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update user']);
        }
    } else {
        show_404(); // Handle non-AJAX requests
    }
}
}