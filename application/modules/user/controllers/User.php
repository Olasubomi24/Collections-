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

    // public function adds_user()
    // {
    //     $data['title'] = 'Dashboard';
    //     $hospitalId = $_SESSION['hospital_id'];
    //     $role = $_SESSION['role'];
    //     $usersData = $this->utility->get_hospitals();
    //     //print_r($usersData); die();
    //     // Ensure the result contains data
    //     $data['users'] = isset($usersData['result']['data']) && is_array($usersData['result']['data']) 
    //         ? $usersData['result']['data'] 
    //         : [];
    //          // Fetch patient e-wallets from API
    //          $response = $this->utility->get_role();
            
    
    //          // Extract the items array
    //          $data['role'] = isset($response['result']['items']) ? $response['result']['items'] : [];
    //           // Extract the items array
    //           $data['hospitail_id'] = isset($response['result']['items']) ? $response['result']['items'] :  $hospitalId;
    //     $data['content_view'] = 'user/add_user';
    //     $this->template->general_template($data);
    // }
    public function add_user()
    {
        if ($this->input->post()) {
            // Collect and map the input data based on the provided credentials structure
            $userData = [
                "email" => $this->input->post('email'),
                "password" => $this->input->post('password'),
                "userName" => $this->input->post('userName'),
                "userPhoneNumber" => $this->input->post('userPhoneNumber'),
                "hospitalId" => $this->input->post('hospitalId'),
                "roleId" => $this->input->post('roleId')
            ];
    
            // Uncomment the line below for debugging purposes
            // print_r($userData); die();
    
            // Call the API to create the user and capture the response
            $apiResponse = $this->utility->create_user($userData);
    
            // Decode the JSON response
            $responseData = is_array($apiResponse) ? $apiResponse : json_decode($apiResponse, true);
    
            if ($responseData && isset($responseData['status']) && $responseData['status'] == 'success') {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'User successfully added.'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => isset($responseData['message']) ? $responseData['message'] : 'Failed to add user.'
                ]);
            }
        }
    }

    public function adds_user() {
        $data['title'] = 'Dashboard';
        $hospitalId = $_SESSION['hospital_id'];
       // $role = $_SESSION['role'];
        $usersData = $this->utility->get_hospitals();
        $data['users'] = isset($usersData['result']['data']) && is_array($usersData['result']['data'])
            ? $usersData['result']['data']
            : [];
        $response = $this->utility->get_role();
        $data['role'] = isset($response['result']['items']) ? $response['result']['items'] : [];
        $data['hospital_id'] = isset($response['result']['items']) ? $response['result']['items'] :  $hospitalId;
        $data['content_view'] = 'user/add_user';
        $this->template->general_template($data);
    }

    // public function add_user() {
    //     if ($this->input->post()) {
    //         $userData = [
    //             "email" => $this->input->post('email'),
    //             "password" => $this->input->post('password'),
    //             "userName" => $this->input->post('userName'),
    //             "userPhoneNumber" => $this->input->post('userPhoneNumber'),
    //             "hospitalId" => $this->input->post('hospitalId'),
    //             "roleId" => $this->input->post('roleId')
    //         ];
    //         $apiResponse = $this->utility->create_user($userData);
    //         //print_r($apiResponse); die();
    //         $responseData = is_array($apiResponse) ? $apiResponse : json_decode($apiResponse, true);
    //         if ($responseData && isset($responseData['status']) && $responseData['status'] == 'success') {
    //             echo json_encode([
    //                 'status' => 'success',
    //                 'message' => 'User successfully added.'
    //             ]);
    //         } else {
    //             echo json_encode([
    //                 'status' => 'error',
    //                 'message' => isset($responseData['message']) ? $responseData['message'] : 'Failed to add user.'
    //             ]);
    //         }
    //     }
    // }
    
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
    // Fetch user data by ID
    $apiResponse = $this->utility->get_user_by_id($id);

    // Fetch hospital and role data
    $hospitalsData = $this->utility->get_hospitals();
    $rolesData = $this->utility->get_role();

    // Get session hospital ID
    $hospitalId = $_SESSION['hospital_id'];

    $data = array(
        'title' => 'Edit user',
        'content_view' => 'user/edit',
        'user' => $apiResponse['result'],
        'hospital_id' => $hospitalsData['result']['data'],  // Corrected hospital data
        'role' => $rolesData['result']['items']  // Corrected role data
    );

    $this->template->general_template($data);
}



//      public function edit_user() {
//     // Validate CSRF token (if CSRF protection is enabled)
//      if ($this->input->is_ajax_request()) {
//         $id = $this->input->post('id'); // Get the user ID from the form data

//         if (!$id) {
//             echo json_encode(['status' => 'error', 'message' => 'Invalid user ID']);
//             return;
//         }

//         // Fetch the existing user data
//         $existinguser = $this->utility->get_user_by_id($id);

//         if (!$existinguser || !isset($existinguser['data'])) {
//             echo json_encode(['status' => 'error', 'message' => 'user not found']);
//             return;
//         }

//         // Update the user data
//         $userData = [
//             "email" => $this->input->post('email'),
//             "password" => $this->input->post('password'),
//             "userName" => $this->input->post('userName'),
//             "userPhoneNumber" => $this->input->post('userPhoneNumber'),
//             "hospitalId" => $this->input->post('hospitalId'),
//             "roleId" => $this->input->post('roleId')
//         ];


//         // Call the utility method to update the user
//         $result = $this->utility->update_user($id, $userData);

//         if ($result) {
//             echo json_encode(['status' => 'success', 'message' => 'user updated successfully']);
//         } else {
//             echo json_encode(['status' => 'error', 'message' => 'Failed to update user']);
//         }
//     } else {
//         show_404(); // Handle non-AJAX requests
//     }
// }


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
  //print_r($existinguser); die();    
        if (!$existinguser['status'] == 'success') {
            echo json_encode(['status' => 'error', 'message' => 'user not found']);
            return;
        }

        // Update the user data
        // $userData = [
        //     "email" => $this->input->post('email'),
        //     "roleId" => $this->input->post('roleId'),
        //     "isActive" => $this->input->post('isActive')
 
        // ];

// Update the user data
$userData = [
    "email" => $this->input->post('email'),
    "roleId" => $this->input->post('roleId'),
    "isActive" => ($this->input->post('isActive') === "true") ? 1 : 0 // Ensures 1 for true, 0 for false
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