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
    public function add_hospital()
    {
        if ($this->input->post()) {
            $hospitalData = [
                "hospitalName" => $this->input->post('hospitalName'),
                "hospitalAdminName" => $this->input->post('hospitalAdminName'),
                "hospitalPhoneNumber" => $this->input->post('hospitalPhoneNumber'),
                "hospitalEmail" => $this->input->post('hospitalEmail'),
                "hospitalAddress" => $this->input->post('hospitalAddress'),
                "hospitalCardInsuranceCommission" => $this->input->post('hospitalCardInsuranceCommission'),
                "hospitalEWalletFundingCommission" => $this->input->post('hospitalEWalletFundingCommission'),
                "hospitalCollectionCommission" => $this->input->post('hospitalCollectionCommission'),
                "domain" => $this->input->post('domain'),
                "settings" => [
                    "theme" => "light",
                    "language" => "en",
                    "timezone" => "UTC",
                    "notifications" => true
                ]
            ];
    
            // Call the API and capture the response
            $apiResponse = $this->utility->create_hospital($hospitalData);
    
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
                    'message' => 'Hospital added successfully.'
                ]);
            } else {
                $errorMessage = isset($responseData['message']) ? $responseData['message'] : 'An error occurred while adding the hospital.';
                echo json_encode([
                    'status' => 'error',
                    'message' => $errorMessage
                ]);
            }
            exit();
        } else {
            $data['title'] = 'Add Hospital';
            $data['content_view'] = 'hospital/add_hospital';
            $this->template->general_template($data);
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
//         // Collect form data
//         $hospitalData = [
//             "hospitalName" => $this->input->post('hospitalName'),
//             "hospitalAdminName" => $this->input->post('hospitalAdminName'),
//             "hospitalPhoneNumber" => $this->input->post('hospitalPhoneNumber'),
//             "hospitalEmail" => $this->input->post('hospitalEmail'),
//             "hospitalAddress" => $this->input->post('hospitalAddress'),
//             "hospitalCardInsuranceCommission" => $this->input->post('hospitalCardInsuranceCommission'),
//             "hospitalEWalletFundingCommission" => $this->input->post('hospitalEWalletFundingCommission'),
//             "hospitalCollectionCommission" => $this->input->post('hospitalCollectionCommission'),
//             "domain" => $this->input->post('domain'),
//             "settings" => [
//                 "theme" => "light",
//                 "language" => "en",
//                 "timezone" => "UTC",
//                 "notifications" => true
//             ]
//         ];

//         // Get the hospital ID from the hidden input field
//         $id = $this->input->post('id');

//         // Update the hospital via the utility class (API call)
//         $updateResult = $this->utility->update_hospital($id, $hospitalData);

//         if ($updateResult) {
//             $this->session->set_flashdata('success', 'Hospital updated successfully.');
//             redirect('hospital/index');
//         } else {
//             $this->session->set_flashdata('error', 'Failed to update hospital.');
//             redirect('hospital/edits_hospital/' . $id); // Redirect back to edit page with error
//         }
//     } else {
//         // If accessed directly without POST data, redirect to the correct edit page
//         redirect('hospital/index');
//     }
// }

public function edit_hospital() {
    // Validate CSRF token (if CSRF protection is enabled)
    if ($this->input->is_ajax_request()) {
        $id = $this->input->post('id'); // Get the hospital ID from the form data

        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid hospital ID']);
            return;
        }

        // Fetch the existing hospital data
        $existingHospital = $this->utility->get_hospital_by_id($id);
       // print_r($existingHospital); die;
        if (!$existingHospital || !isset($existingHospital['result'])) {
            echo json_encode(['status' => 'error', 'message' => 'Hospital not found']);
            return;
        }

        // Update the hospital data
        $hospitalData = [
            "hospitalName" => $this->input->post('hospitalName'),
            "hospitalAdminName" => $this->input->post('hospitalAdminName'),
            "hospitalPhoneNumber" => $this->input->post('hospitalPhoneNumber'),
            "hospitalEmail" => $this->input->post('hospitalEmail'),
            "hospitalAddress" => $this->input->post('hospitalAddress'),
            "hospitalCardInsuranceCommission" => $this->input->post('hospitalCardInsuranceCommission'),
            "hospitalEWalletFundingCommission" => $this->input->post('hospitalEWalletFundingCommission'),
            "hospitalCollectionCommission" => $this->input->post('hospitalCollectionCommission'),
            "domain" => $this->input->post('domain'),
            "settings" => [
                "theme" => "light",
                "language" => "en",
                "timezone" => "UTC",
                "notifications" => true
            ]
        ];
  // print_r($hospitalData); die;

        // Call the utility method to update the hospital
        $result = $this->utility->update_hospital($id, $hospitalData);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Hospital updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update hospital']);
        }
    } else {
        show_404(); // Handle non-AJAX requests
    }
}
}