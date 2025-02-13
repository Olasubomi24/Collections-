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
     //print_r($patientData); die();
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
//print_r($patient_walletsData); die();
    // Ensure the result contains data
    $data['patient_wallets'] = isset($patient_walletsData['result']['data']) && is_array($patient_walletsData['result']['data']) 
        ? $patient_walletsData['result']['data'] 
        : [];

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

        if (!$existingpatient_wallet || !isset($existingpatient_wallet['data'])) {
            echo json_encode(['status' => 'error', 'message' => 'patient_wallet not found']);
            return;
        }

        // Update the patient_wallet data
        $patient_walletData = [
            "patient_walletName" => $this->input->post('patient_walletName'),
            "patient_walletAdminName" => $this->input->post('patient_walletAdminName'),
            "patient_walletPhoneNumber" => $this->input->post('patient_walletPhoneNumber'),
            "patient_walletEmail" => $this->input->post('patient_walletEmail'),
            "patient_walletAddress" => $this->input->post('patient_walletAddress'),
            "patient_walletCardInsuranceCommission" => $this->input->post('patient_walletCardInsuranceCommission'),
            "patient_walletEWalletFundingCommission" => $this->input->post('patient_walletEWalletFundingCommission'),
            "patient_walletCollectionCommission" => $this->input->post('patient_walletCollectionCommission'),
            "domain" => $this->input->post('domain'),
            "settings" => [
                "theme" => "light",
                "language" => "en",
                "timezone" => "UTC",
                "notifications" => true
            ]
        ];


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
}