<?php

class User_profile extends MX_Controller
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
    //     $products = $this->utility->user_profile_list();
    //     $data['title'] = 'Dashboard';
    //     $data['content_view'] = 'user_profile/table';
    //     $this->template->general_template($data);
    // }
    public function user_profile_list()
    {
        $data['title'] = 'Dashboard';
        $data['content_view'] = 'user_profile/table';
        $this->template->general_template($data);
    }

    public function updates_user_profile()
    {
        $data['title'] = 'Dashboard';
        $data['content_view'] = 'user_profile/update_user_profile';
        $this->template->general_template($data);
    }
    public function update_user_profile()
    {
        if ($this->input->post()) {
            // Collect and map the input data for updating the user profile
            $userData = [
                "userName" => $this->input->post('userName'),
                "userPhoneNumber" => $this->input->post('userPhoneNumber'),
                "preferences" => [] // Add preferences if needed
            ];
    
            // Uncomment the line below for debugging purposes
            // print_r($userData); die();
    
            // Call the API and capture the response
            $apiResponse = $this->utility->update_user_profile($userData);
    
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
                    'message' => 'User profile updated successfully.'
                ]);
            } else {
                $errorMessage = isset($responseData['message']) ? $responseData['message'] : 'An error occurred while updating the user profile.';
                echo json_encode([
                    'status' => 'error',
                    'message' => $errorMessage
                ]);
            }
            exit();
        } else {
            // Load the form view for updating the user profile
            $data['title'] = 'Update User Profile';
            $data['content_view'] = 'user_profile/update_user_profile'; // Update the view file name as needed
            $this->template->general_template($data);
        }
    }


    public function change_user_pass()
    {
        $data['title'] = 'Change Password';
        $data['content_view'] = 'user_profile/change_user_pass';
        $this->template->general_template($data);
    }
    
    public function change_user_password()
    {
        if ($this->input->post()) {
            // Collect and map the input data for changing the password
            $passwordData = [
                "oldPassword" => $this->input->post('oldPassword'),
                "newPassword" => $this->input->post('newPassword'),
                "email" => $this->input->post('email') // Email from the form
            ];
    
            // Uncomment the line below for debugging purposes
            // print_r($passwordData); die();
    
            // Call the API and capture the response
            $apiResponse = $this->utility->change_user_password($passwordData);
    
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
                    'message' => 'Password changed successfully.'
                ]);
            } else {
                $errorMessage = isset($responseData['message']) ? $responseData['message'] : 'An error occurred while changing the password.';
                echo json_encode([
                    'status' => 'error',
                    'message' => $errorMessage
                ]);
            }
            exit();
        } else {
            // Load the form view for changing the password
            $data['title'] = 'Change Password';
            $data['content_view'] = 'user_profile/change_user_pass'; // Update the view file name as needed
            $this->template->general_template($data);
        }
    }
    // public function index()
    // {
    //     $data['title'] = 'user_profiles List';
    //     $data['user_profiles'] = $this->utility->get_user_profiles();
    //     print_r($data['user_profiles']); die();
    //     $data['content_view'] = 'user_profile/table';
    //     $this->template->general_template($data);
    // }

    public function index()
{
    $data['title'] = 'user_profiles List';
    $user_profilesData = $this->utility->get_user_profile();
    //print_r($user_profilesData); die();
    // Ensure the result contains data
    $data['user_profiles'] = isset($user_profilesData['result']['data']) && is_array($user_profilesData['result']['data']) 
        ? $user_profilesData['result']['data'] 
        : [];

    $data['content_view'] = 'user_profile/table';
    $this->template->general_template($data);
}





    public function edits_user_profile($id = null) {
        // Fetch the user_profile data by ID
        $apiResponse = $this->utility->get_user_profile_by_id($id);
   // print_r($apiResponse); die();
        $data = array(
            'title' => 'Edit user_profile',
            'content_view' => 'user_profile/edit',
            'user_profile' => $apiResponse['result']
        );

        $this->template->general_template($data);
    }


     public function edit_user_profile() {
    // Validate CSRF token (if CSRF protection is enabled)
     if ($this->input->is_ajax_request()) {
        $id = $this->input->post('id'); // Get the user_profile ID from the form data

        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid user_profile ID']);
            return;
        }

        // Fetch the existing user_profile data
        $existinguser_profile = $this->utility->get_user_profile_by_id($id);

        if (!$existinguser_profile || !isset($existinguser_profile['data'])) {
            echo json_encode(['status' => 'error', 'message' => 'user_profile not found']);
            return;
        }

        // Update the user_profile data
        $user_profileData = [
                "hospitalId" => $this->input->post('hospitalId'),
                "merchantId" => $this->input->post('merchantId'),
                "merchantAccount" => $this->input->post('merchantAccount'),
                "user_profileAmount" => $this->input->post('user_profileAmount'),
                "merchantBank" => $this->input->post('merchantBank'),
        ];


        // Call the utility method to update the user_profile
        $result = $this->utility->update_user_profile($id, $user_profileData);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'user_profile updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update user_profile']);
        }
    } else {
        show_404(); // Handle non-AJAX requests
    }
}
}