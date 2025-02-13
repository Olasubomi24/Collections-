<?php

class Collection extends MX_Controller
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

    public function index()
{
    $data['title'] = 'collections List';
    $collectionsData = $this->utility->get_collection();
    //print_r($collectionsData); die();
    // Ensure the result contains data
    $data['collections'] = isset($collectionsData['result']['data']) && is_array($collectionsData['result']['data']) 
        ? $collectionsData['result']['data'] 
        : [];

    $data['content_view'] = 'collection/table';
    $this->template->general_template($data);
}





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