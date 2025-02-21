<?php

class Patient_wallet extends MX_Controller
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
    //     $products = $this->utility->patient_wallet_list();
    //     $data['title'] = 'Dashboard';
    //     $data['content_view'] = 'patient_wallet/table';
    //     $this->template->general_template($data);
    // }
    public function patient_wallet_list()
    {
        $data['title'] = 'Dashboard';
        $data['content_view'] = 'patient_wallet/table';
        $this->template->general_template($data);
    }


    public function adds_manual_funding()
    {
        $data['title'] = 'Manual Funding';
        $hospitalId = $_SESSION['hospital_id'] ?? '';
    
        // Fetch patient e-wallets from API
        $response = $this->utility->get_patient_wallets($hospitalId);
    
        // Extract the items array
        $data['ewallets'] = isset($response['result']['items']) ? $response['result']['items'] : [];
    
       // print_r($data['ewallets']); die(); // Debugging: Check extracted items
    
        $data['content_view'] = 'patient_wallet/add_manual_funding';
        $this->template->general_template($data);
    }
    
    public function add_manual_funding()
    {
        if ($this->input->post()) {
            $hospitalId = $this->input->post('hospitalId');
            $eWalletAccount = $this->input->post('eWalletAccount');
            $amount = $this->input->post('amount');
            $description = $this->input->post('description');
    
            // Validate input
            if (empty($hospitalId) || empty($eWalletAccount) || empty($amount) || empty($description)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'All fields are required.'
                ]);
                exit();
            }
    
            $walletFundingData = [
                "hospitalId" => $hospitalId,
                "eWalletAccount" => $eWalletAccount,
                "amount" => $amount,
                "description" => $description
            ];
    
            // Call API and handle response
            $apiResponse = $this->utility->create_manual_funding($walletFundingData);
    
            // Debugging: Log API response
            file_put_contents('debug.log', print_r($apiResponse, true));
    
            // Ensure the response is an array
            $responseData = is_array($apiResponse) ? $apiResponse : json_decode($apiResponse, true);
    
            // Ensure JSON response format
            header('Content-Type: application/json');
    
            if ($responseData && isset($responseData['status']) && $responseData['status'] == 'success') {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Wallet funding initiated successfully.',
                    'result' => $responseData['result'] ?? []
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => $responseData['message'] ?? 'An error occurred while initiating wallet funding.'
                ]);
            }
            exit();
        } else {
            $data['title'] = 'Add Wallet Funding';
            $data['content_view'] = 'patient_wallet/add_manual_funding';
            $this->template->general_template($data);
        }
    }
    

    public function adds_refund()
    {
        $data['title'] = 'Refund';
        $hospitalId = $_SESSION['hospital_id'] ?? '';
    
        // Fetch patient e-wallets from API
        $response = $this->utility->get_patient_wallets($hospitalId);
    
        // Extract the items array
        $data['ewallets'] = isset($response['result']['items']) ? $response['result']['items'] : [];
    
       // print_r($data['ewallets']); die(); // Debugging: Check extracted items
    
        $data['content_view'] = 'patient_wallet/refund';
        $this->template->general_template($data);
    }

public function add_refund()
{
    if ($this->input->post()) {
        $hospitalId = $this->input->post('hospitalId');
        $eWalletAccount = $this->input->post('eWalletAccount');
        $amount = $this->input->post('amount');
        $reason = $this->input->post('reason');

        // Validate input
        if (empty($hospitalId) || empty($eWalletAccount) || empty($amount) || empty($reason)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'All fields are required.'
            ]);
            exit();
        }

        $refundData = [
            "hospitalId" => $hospitalId,
            "eWalletAccount" => $eWalletAccount,
            "amount" => $amount,
            "reason" => $reason
        ];

        // Call API and handle response
        $apiResponse = $this->utility->create_refunding($refundData);

        // Debugging: Log API response
        file_put_contents('debug.log', print_r($apiResponse, true));

        // Ensure the response is an array
        $responseData = is_array($apiResponse) ? $apiResponse : json_decode($apiResponse, true);

        // Ensure JSON response format
        header('Content-Type: application/json');

        if ($responseData && isset($responseData['status']) && $responseData['status'] == 'success') {
            echo json_encode([
                'status' => 'success',
                'message' => 'Refund initiated successfully.',
                'result' => $responseData['result'] ?? []
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => $responseData['message'] ?? 'An error occurred while initiating the refund.'
            ]);
        }
        exit();
    } else {
        $data['title'] = 'Request Refund';
        $data['content_view'] = 'patient_wallet/refund';
        $this->template->general_template($data);
    }
}

   
    public function adds_patient_wallet()
    {
        $data['title'] = 'Dashboard';
        $data['content_view'] = 'patient_wallet/add_patient_wallet';
        $this->template->general_template($data);
    }
    public function add_patient()
    {
        if ($this->input->post()) {
            // Collect and map the input data to the new structure
            $patientData = [
                "patientFirstName" => $this->input->post('patientFirstName'),
                "patientLastName" => $this->input->post('patientLastName'),
                "patientMiddleName" => $this->input->post('patientMiddleName'),
                "gender" => $this->input->post('gender'),
                "dob" => $this->input->post('dob'),
                "email" => $this->input->post('email'),
                "phoneNumber" => $this->input->post('phoneNumber'),
                "alternateNumber" => $this->input->post('alternateNumber'),
                "address" => $this->input->post('address'),
                "bvn" => $this->input->post('bvn'),
                "nin" => $this->input->post('nin'),
                "hospitalId" => $this->input->post('hospitalId')
            ];
    // print_r($patientData); die();
            // Call the API and capture the response
            $apiResponse = $this->utility->create_patient_wallet($patientData);
    
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
                    'message' => 'Patient added successfully.'
                ]);
            } else {
                $errorMessage = isset($responseData['message']) ? $responseData['message'] : 'An error occurred while adding the patient.';
                echo json_encode([
                    'status' => 'error',
                    'message' => $errorMessage
                ]);
            }
            exit();
        } else {
            // Load the form view for adding a patient
            $data['title'] = 'Add Patient';
            $data['content_view'] = 'patient_wallet/add_patient_wallet'; // Update the view file name as needed
            $this->template->general_template($data);
        }
    }
    // public function index()
    // {
    //     $data['title'] = 'patient_wallets List';
    //     $data['patient_wallets'] = $this->utility->get_patient_wallets();
    //     print_r($data['patient_wallets']); die();
    //     $data['content_view'] = 'patient_wallet/table';
    //     $this->template->general_template($data);
    // }

    public function index()
{
    $data['title'] = 'patient_wallets List';
    $patient_walletsData = $this->utility->get_patient_wallet();
//print_r($patient_walletsData['result']['items']); die();
    // Ensure the result contains data
    $data['patient_wallets'] = isset($patient_walletsData['result']['items']) && is_array($patient_walletsData['result']['items']) 
        ? $patient_walletsData['result']['items'] 
        : [];
       // print_r($data['patient_wallets']); die();


    $data['content_view'] = 'patient_wallet/table';
    $this->template->general_template($data);
}





    public function edits_patient_wallet($id = null) {
        // Fetch the patient_wallet data by ID
        $apiResponse = $this->utility->get_patient_wallet_by_id($id);
   // print_r($apiResponse); die();
        $data = array(
            'title' => 'Edit patient_wallet',
            'content_view' => 'patient_wallet/edit',
            'patient_wallet' => $apiResponse['result']
        );

        $this->template->general_template($data);
    }


public function edit_patient_wallet() {
    // Validate CSRF token (if CSRF protection is enabled)
    if ($this->input->is_ajax_request()) {
        $id = $this->input->post('id'); // Get the patient_wallet ID from the form data

        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid patient_wallet ID']);
            return;
        }

        // Fetch the existing patient_wallet data
        $existingpatient_wallet = $this->utility->get_patient_wallet_by_id($id);
  //print_r($existingpatient_wallet); die ;
        if (!$existingpatient_wallet || !isset($existingpatient_wallet['result'])) {
            echo json_encode(['status' => 'error', 'message' => 'patient_wallet not found']);
            return;
        }

        // Update the patient_wallet data
        $patient_walletData = [
            "patientFirstName" => $this->input->post('patientFirstName'),
            "patientLastName" => $this->input->post('patientLastName'),
            "patientMiddleName" => $this->input->post('patientMiddleName'),
            "gender" => $this->input->post('gender'),
            "dob" => $this->input->post('dob'),
            "email" => $this->input->post('email'),
            "phoneNumber" => $this->input->post('phoneNumber'),
            "alternateNumber" => $this->input->post('alternateNumber'),
            "address" => $this->input->post('address'),
            "bvn" => $this->input->post('bvn'),
            "nin" => $this->input->post('nin'),
            "hospitalId" => $this->input->post('hospitalId')
        ];
        
       // print_r($patientData); die;

        // Call the utility method to update the patient_wallet
        $result = $this->utility->update_patient_wallet($id, $patient_walletData);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'patient_wallet updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update patient_wallet']);
        }
    } else {
        show_404(); // Handle non-AJAX requests
    }
}

public function patient_wallet_index()
{
    if ($this->input->is_ajax_request()) {
        $hospitalId = $_SESSION['hospital_id'] ?? '';
        $email = trim($this->input->post('email'));
        $eWalletAccount = trim($this->input->post('eWalletAccount'));

        log_message('debug', "Received AJAX Request: Hospital ID = {$hospitalId}, Email = {$email}, eWalletAccount = {$eWalletAccount}");

        if (empty($hospitalId)) {
            $response = [
                'status'  => 'error',
                'message' => 'Hospital ID is required.',
                'data'    => []
            ];
            return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($response));
        }

        $var = ['hospitalId' => $hospitalId];
        if (!empty($email)) {
            $var['email'] = $email;
        }
        if (!empty($eWalletAccount)) {
            $var['eWalletAccount'] = $eWalletAccount;
        }

        log_message('debug', 'Formatted Filters: ' . json_encode($var));

        $collectionsData = $this->utility->get_patient_wallet_txn($var);
        log_message('debug', 'API Response: ' . json_encode($collectionsData));

        $network_result = $collectionsData['result']['data'] ?? [];

        $response = [
            'status'  => !empty($network_result) ? 'success' : 'error',
            'message' => !empty($network_result) ? 'Data fetched successfully.' : 'No data found.',
            'data'    => $network_result
        ];

        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($response));
    }
        // Load the default view if not an AJAX request
        $data = [
            'title'        => 'Patient Wallet Transactions',
            'content_view' => 'patient_wallet/wallet_table',
        ];
    
        $this->template->general_template($data);
}




}