<?php

class Hospital extends MX_Controller
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
    //     $products = $this->utility->hospital_list();
    //     $data['title'] = 'Dashboard';
    //     $data['content_view'] = 'hospital/table';
    //     $this->template->general_template($data);
    // }
    public function hospital_list()
    {
        $data['title'] = 'Dashboard';
        $data['content_view'] = 'hospital/table';
        $this->template->general_template($data);
    }

    public function adds_hospital()
    {
        $data['title'] = 'Dashboard';
        $data['content_view'] = 'hospital/add_hospital';
        $this->template->general_template($data);
    }
    // public function add_hospital()
    // {
    //     header('Content-Type: application/json'); // Ensure JSON response
    
    //     $this->load->library('form_validation');
    //     $this->form_validation->set_rules('hospitalName', 'Hospital Name', 'required');
    //     $this->form_validation->set_rules('hospitalAdminName', 'Admin Name', 'required');
    
    //     if ($this->form_validation->run() == FALSE) {
    //         echo json_encode(['status' => 'error', 'message' => validation_errors()]);
    //         return;
    //     }
    
    //     // Get file name without uploading
    //     $hospitalLogo = !empty($_FILES['hospitalLogo']['name']) ? $_FILES['hospitalLogo']['name'] : null;
    
    //     // Save hospital details
    //     $data = [
    //         'hospitalName' => $this->input->post('hospitalName'),
    //         'hospitalAdminName' => $this->input->post('hospitalAdminName'),
    //         'hospitalPhoneNumber' => $this->input->post('hospitalPhoneNumber'),
    //         'hospitalEmail' => $this->input->post('hospitalEmail'),
    //         'hospitalAddress' => $this->input->post('hospitalAddress'),
    //         'hospitalCardInsuranceCommission' => $this->input->post('hospitalCardInsuranceCommission'),
    //         'hospitalEWalletFundingCommission' => $this->input->post('hospitalEWalletFundingCommission'),
    //         'hospitalCollectionCommission' => $this->input->post('hospitalCollectionCommission'),
    //         'domain' => $this->input->post('domain'),
    //         'logo' => $hospitalLogo, // Just store the file name, no upload
    //         "settings" => [
    //             "theme" => "light",
    //             "language" => "en",
    //             "timezone" => "UTC",
    //             "notifications" => true
    //         ]
    //     ];
    //   //  print_r($hospitalData); die();
    //     // Call the API and capture the response
    //     $apiResponse = $this->utility->create_hospital($data);

    //     // Decode the JSON response if it's not already an array
    //     $responseData = is_array($apiResponse) ? $apiResponse : json_decode($apiResponse, true);
    
    //     if ($responseData && isset($responseData['status']) && $responseData['status'] == 'success') {
    //         echo json_encode([
    //             'status' => 'success',
    //             'message' => 'Hospital added successfully.'
    //         ]);
    //     } else {
    //         $errorMessage = isset($responseData['message']) ? $responseData['message'] : 'An error occurred while adding the hospital.';
    //         echo json_encode([
    //             'status' => 'error',
    //             'message' => $errorMessage
    //         ]);
    //     }
    // }
    
    
    public function add_hospital()
{
    header('Content-Type: application/json');

    $this->load->library('form_validation');
    $this->form_validation->set_rules('hospitalName', 'Hospital Name', 'required');
    $this->form_validation->set_rules('hospitalAdminName', 'Admin Name', 'required');

    if ($this->form_validation->run() == FALSE) {
        echo json_encode(['status' => 'error', 'message' => validation_errors()]);
        return;
    }

    // Prepare multipart data
    $hospitalData = [
        'hospitalName' => $this->input->post('hospitalName'),
        'hospitalAdminName' => $this->input->post('hospitalAdminName'),
        'hospitalPhoneNumber' => $this->input->post('hospitalPhoneNumber'),
        'hospitalEmail' => $this->input->post('hospitalEmail'),
        'hospitalAddress' => $this->input->post('hospitalAddress'),
        'hospitalCardInsuranceCommission' => $this->input->post('hospitalCardInsuranceCommission'),
        'hospitalEWalletFundingCommission' => $this->input->post('hospitalEWalletFundingCommission'),
        'hospitalCollectionCommission' => $this->input->post('hospitalCollectionCommission'),
        'domain' => $this->input->post('domain'),
        'settings' => json_encode([
            "theme" => "light",
            "language" => "en",
            "timezone" => "UTC",
            "notifications" => true
        ])
    ];

    // Handle file upload properly
    if (!empty($_FILES['logo']['name'])) {
        $hospitalData['logo'] = new CURLFile($_FILES['logo']['tmp_name'], $_FILES['logo']['type'], $_FILES['logo']['name']);
    }

    // Call API
    $apiResponse = $this->utility->create_hospital($hospitalData);

    if ($apiResponse && isset($apiResponse['status']) && $apiResponse['status'] === 'success') {
        echo json_encode(['status' => 'success', 'message' => 'Hospital added successfully.']);
    } else {
        $errorMessage = isset($apiResponse['message']) ? $apiResponse['message'] : 'An error occurred while adding the hospital.';
        echo json_encode(['status' => 'error', 'message' => $errorMessage]);
    }
}

    
    
    

    // public function index()
    // {
    //     $data['title'] = 'Hospitals List';
    //     $data['hospitals'] = $this->utility->get_hospitals();
    //     print_r($data['hospitals']); die();
    //     $data['content_view'] = 'hospital/table';
    //     $this->template->general_template($data);
    // }

    public function index()
{
    $data['title'] = 'Hospitals List';
    $hospitalsData = $this->utility->get_hospitals();
//print_r($hospitalsData); die();
    // Ensure the result contains data
    $data['hospitals'] = isset($hospitalsData['result']['data']) && is_array($hospitalsData['result']['data']) 
        ? $hospitalsData['result']['data'] 
        : [];

    $data['content_view'] = 'hospital/table';
    $this->template->general_template($data);
}



    // public function edits_hospital($id = null)
    // {
    //     if ($id === null) {
    //         show_404(); // Handle case where ID is missing
    //     }

    //     log_message('debug', 'ID Received: ' . $id); // Log the received ID

    //     // Fetch the hospital data by ID from the API
    //     $apiResponse = $this->utility->get_hospital_by_id($id);

    //     // Debug the raw API response
    //     log_message('debug', 'Raw API Response: ' . print_r($apiResponse, true));

    //     if (is_string($apiResponse)) {
    //         // Decode the JSON string if it's valid
    //         $hospital = json_decode($apiResponse, true);
    //     } elseif (is_array($apiResponse)) {
    //         // If the API response is already an array, no need to decode
    //         $hospital = $apiResponse;
    //     } else {
    //         // Handle unexpected response types
    //         log_message('error', 'Unexpected API response type: ' . gettype($apiResponse));
    //         show_error('Failed to fetch hospital data.');
    //     }

    //     if (!$hospital || !isset($hospital['data'])) {
    //         show_404(); // Handle case where hospital does not exist or API failed
    //     }

    //     // Extract the hospital details
    //     $data['hospital'] = $hospital['data'];
    //     $data['title'] = 'Edit Hospital';
    //     $data['content_view'] = 'hospital/edit';
    //     $this->template->general_template($data);
    // }

    public function edits_hospital($id = null) {
        // Fetch the hospital data by ID
        $apiResponse = $this->utility->get_hospital_by_id($id);
   // print_r($apiResponse); die();
        $data = array(
            'title' => 'Edit Hospital',
            'content_view' => 'hospital/edit',
            'hospital' => $apiResponse['result']
        );

        $this->template->general_template($data);
    }



    // public function edit_hospital()
    // {
    //     if ($this->input->post()) {
    //         // Retrieve the existing logo URL (if any)
    //         $existingLogo = isset($existingHospital['result']['hospitalLogoURL']) ? $existingHospital['result']['hospitalLogoURL'] : null;
    
    //         // Check if an image file is uploaded
    //         if (empty($_FILES['logo']['name']) && !$existingLogo) {
    //             echo json_encode(['status' => 'error', 'message' => 'Hospital logo is required.']);
    //             return;
    //         }
    
    //         // Prepare data for update
    //         $hospitalData = [
    //             'hospitalName' => $this->input->post('hospitalName'),
    //             'hospitalAdminName' => $this->input->post('hospitalAdminName'),
    //             'hospitalPhoneNumber' => $this->input->post('hospitalPhoneNumber'),
    //             'hospitalEmail' => $this->input->post('hospitalEmail'),
    //             'hospitalAddress' => $this->input->post('hospitalAddress'),
    //             'hospitalCardInsuranceCommission' => $this->input->post('hospitalCardInsuranceCommission'),
    //             'hospitalEWalletFundingCommission' => $this->input->post('hospitalEWalletFundingCommission'),
    //             'hospitalCollectionCommission' => $this->input->post('hospitalCollectionCommission'),
    //             'domain' => $this->input->post('domain'),
    //             'settings' => json_encode([
    //                 "theme" => "light",
    //                 "language" => "en",
    //                 "timezone" => "UTC",
    //                 "notifications" => true
    //             ])
    //         ];
    
    //         // Handle logo update
    //         if (!empty($_FILES['logo']['name'])) {
    //             $hospitalData['logo'] = new CURLFile( $_FILES['logo']['name']);
    //         } else {
    //             // Retain the existing logo if no new logo is uploaded
    //             if ($existingLogo) {
    //                 $hospitalData['logo'] = $existingLogo;
    //             }
    //         }
    
    //         // Get the hospital ID from the hidden input field
    //         $id = $this->input->post('id');
    
    //         // Debug: Print data being sent to the API
    //         error_log(print_r($hospitalData, true));
    
    //         // Update the hospital via the utility class (API call)
    //         $result = $this->utility->update_hospital($id, $hospitalData);
    
    //         if ($result) {
    //             echo json_encode(['status' => 'success', 'message' => 'Hospital updated successfully']);
    //         } else {
    //             echo json_encode(['status' => 'error', 'message' => 'Failed to update hospital']);
    //         }
    //     } else {
    //         show_404(); // Handle non-AJAX requests
    //     }
    // }
    
    // public function edit_hospital()
    // {
    //     if ($this->input->post()) {
    //         $id = $this->input->post('id'); // Get hospital ID
    
    //         // Fetch existing hospital data (Ensure `$existingHospital` is defined)
    //         $existingHospital = $this->utility->get_hospital_by_id($id); // Fetch hospital details
    //         $existingLogo = isset($existingHospital['result']['hospitalLogoURL']) ? basename($existingHospital['result']['hospitalLogoURL']) : null;
    
    //         // Get the new logo filename from the request
    //         $uploadedLogo = $this->input->post('logo'); // ✅ Should be just the filename
    
    //         // Validate logo (Required if no existing logo)
    //         if (empty($uploadedLogo) && empty($existingLogo)) {
    //             echo json_encode(['status' => 'error', 'message' => 'Hospital logo is required.']);
    //             return;
    //         }
    
    //         // Prepare hospital data
    //         $hospitalData = [
    //             'hospitalName' => $this->input->post('hospitalName'),
    //             'hospitalAdminName' => $this->input->post('hospitalAdminName'),
    //             'hospitalPhoneNumber' => $this->input->post('hospitalPhoneNumber'),
    //             'hospitalEmail' => $this->input->post('hospitalEmail'),
    //             'hospitalAddress' => $this->input->post('hospitalAddress'),
    //             'hospitalCardInsuranceCommission' => $this->input->post('hospitalCardInsuranceCommission'),
    //             'hospitalEWalletFundingCommission' => $this->input->post('hospitalEWalletFundingCommission'),
    //             'hospitalCollectionCommission' => $this->input->post('hospitalCollectionCommission'),
    //             'domain' => $this->input->post('domain'),
    //             'settings' => json_encode([
    //                 "theme" => "light",
    //                 "language" => "en",
    //                 "timezone" => "UTC",
    //                 "notifications" => true
    //             ])
    //         ];
    
    //         // ✅ Set the correct logo filename
    //         if (!empty($uploadedLogo)) {
    //             $hospitalData['logo'] = $uploadedLogo; // ✅ Use the new filename
    //         } else if (!empty($existingLogo)) {
    //             $hospitalData['logo'] = $existingLogo; // ✅ Keep the existing filename
    //         }
    
    //         // Send data to update API
    //         $result = $this->utility->update_hospital($id, $hospitalData);
    
    //         // ✅ Validate and return response
    //         if ($result && isset($result['status']) && $result['status'] === 'success') {
    //             echo json_encode([
    //                 'status' => 'success',
    //                 'message' => 'Hospital updated successfully',
    //                 'data' => $result['result'] ?? null
    //             ]);
    //         } else {
    //             echo json_encode([
    //                 'status' => 'error',
    //                 'message' => $result['message'] ?? 'Failed to update hospital',
    //                 'errorCode' => $result['errorCode'] ?? null
    //             ]);
    //         }
    //     } else {
    //         show_404();
    //     }
    // }

    // public function edit_hospital()
    // {
    //     if ($this->input->post()) {
    //         $id = $this->input->post('id'); // Get hospital ID
    
    //         // Fetch existing hospital data
    //         $existingHospital = $this->utility->get_hospital_by_id($id);
    //         $existingLogo = isset($existingHospital['result']['hospitalLogoURL']) ? basename($existingHospital['result']['hospitalLogoURL']) : null;
    
    //         // ✅ Handle file upload correctly
    //         $hospitalData = [
    //             'hospitalName' => $this->input->post('hospitalName'),
    //             'hospitalAdminName' => $this->input->post('hospitalAdminName'),
    //             'hospitalPhoneNumber' => $this->input->post('hospitalPhoneNumber'),
    //             'hospitalEmail' => $this->input->post('hospitalEmail'),
    //             'hospitalAddress' => $this->input->post('hospitalAddress'),
    //             'hospitalCardInsuranceCommission' => (int) $this->input->post('hospitalCardInsuranceCommission'),
    //             'hospitalEWalletFundingCommission' => (int) $this->input->post('hospitalEWalletFundingCommission'),
    //             'hospitalCollectionCommission' => (int) $this->input->post('hospitalCollectionCommission'),
    //             'domain' => $this->input->post('domain'),
    //             'settings' => json_encode([
    //                 "theme" => "light",
    //                 "language" => "en",
    //                 "timezone" => "UTC",
    //                 "notifications" => true
    //             ])
    //         ];
    
    //         // ✅ If a new file is uploaded, send it as binary
    //         if (!empty($_FILES['logo']['tmp_name'])) {
    //             $hospitalData['logo'] = curl_file_create($_FILES['logo']['tmp_name'], $_FILES['logo']['type'], $_FILES['logo']['name']);
    //         } else if (!empty($existingLogo)) {
    //             $hospitalData['logo'] = $existingLogo; // Keep existing logo if no new one
    //         }
    
    //         // ✅ Send the API request with multipart enabled
    //         $result = $this->utility->update_hospital($id, $hospitalData, true); 
    
    //         // ✅ Validate and return response
    //         if ($result && isset($result['status']) && $result['status'] === 'success') {
    //             echo json_encode([
    //                 'status' => 'success',
    //                 'message' => 'Hospital updated successfully',
    //                 'data' => $result['result'] ?? null
    //             ]);
    //         } else {
    //             echo json_encode([
    //                 'status' => 'error',
    //                 'message' => $result['message'] ?? 'Failed to update hospital',
    //                 'errorCode' => $result['errorCode'] ?? null
    //             ]);
    //         }
    //     } else {
    //         show_404();
    //     }
    // }

    public function edit_hospital()
    {
        if ($this->input->post()) {
            $id = $this->input->post('id'); // Get hospital ID
            
            // Fetch existing hospital data
            $existingHospital = $this->utility->get_hospital_by_id($id);
            $existingLogo = isset($existingHospital['result']['hospitalLogoURL']) ? basename($existingHospital['result']['hospitalLogoURL']) : null;
            
            // Prepare hospital data
            $hospitalData = [
                'hospitalName' => $this->input->post('hospitalName'),
                'hospitalAdminName' => $this->input->post('hospitalAdminName'),
                'hospitalPhoneNumber' => $this->input->post('hospitalPhoneNumber'),
                'hospitalEmail' => $this->input->post('hospitalEmail'),
                'hospitalAddress' => $this->input->post('hospitalAddress'),
                'hospitalCardInsuranceCommission' => (int) $this->input->post('hospitalCardInsuranceCommission'),
                'hospitalEWalletFundingCommission' => (int) $this->input->post('hospitalEWalletFundingCommission'),
                'hospitalCollectionCommission' => (int) $this->input->post('hospitalCollectionCommission'),
                'domain' => $this->input->post('domain'),
                'settings' => json_encode([
                    "theme" => "light",
                    "language" => "en",
                    "timezone" => "UTC",
                    "notifications" => true
                ])
            ];
    
            // ✅ Handle file upload correctly for multipart/form-data
                // Handle file upload properly
    if (!empty($_FILES['logo']['name'])) {
        $hospitalData['logo'] = new CURLFile($_FILES['logo']['tmp_name'], $_FILES['logo']['type'], $_FILES['logo']['name']);
    }

    
            // ✅ Send data to the update API using multipart
            $result = $this->utility->update_hospital($id, $hospitalData, true);
    
            // ✅ Validate and return response
            if ($result && isset($result['status']) && $result['status'] === 'success') {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Hospital updated successfully',
                    'data' => $result['result'] ?? null
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => $result['message'] ?? 'Failed to update hospital',
                    'errorCode' => $result['errorCode'] ?? null
                ]);
            }
        } else {
            show_404();
        }
    }
    

    
    
    
    
    
    

}