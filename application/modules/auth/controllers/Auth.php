<?php
class Auth extends MX_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->module('template');
        $this->load->library('session');
        $this->load->module('utility');
    }

    public function index()
    {
        $data = array(
            'title' => 'Log In',
            'content_view' => 'auth/login'
        );
        $this->template->auth_template($data);
    }

    public function login()
    {
        header('Content-Type: application/json'); // Set response header for JSON output
    
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
    
        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => 400,
                'message' => validation_errors()
            ]);
            return;
        }
    
        $var = array(
            'email' => $this->input->post('email'),
            'password' => $this->input->post('password'),
        );

        $output = $this->utility->user_login($var);
        //print_r($output['response']['status']); die();
        if ($output['response']['status'] == 'success') {  
            $session_data = array(
                'email' => $output['response']['result']['user']['email'],
                'username' => $output['response']['result']['user']['userName'],
                'hospital_id' => $output['response']['result']['user']['hospitalId'],
                'access_token' => $output['response']['result']['access_token'],
                'logged_in' => TRUE
            );
            $this->session->set_userdata($session_data);
     //print_r($session_data); 
            echo json_encode([
                "status" => "success",
                "message" => $output['response']['message'],
                "redirect" => base_url('dashboard/index') // Redirect to login page
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Invalid email or password"
            ]);
        }
    }
    public function sign_up()
    {
        $data = array(
            'title' => 'Sign Up',
            'content_view' => 'auth/sign_up'
        );
        $this->template->auth_template($data);
    }
    
    public function createaccount() {
        $this->load->library('form_validation');

    
        // Set validation rules
        $this->form_validation->set_rules('userName', 'User Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('userPhoneNumber', 'Phone Number', 'trim|required|numeric');
    
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(["status" => "error", "message" => validation_errors()]);
            return;
        }
    
        // Generate a random hospitalId
        $hospitalId = substr(str_shuffle('ABCDEFGHIJKLMNPQRSTUVWXYZ23456789'), 0, 6);
    
        // Prepare data for insertion
        $var = array(
            'userName' => $this->input->post('userName'),
            'email' => $this->input->post('email'),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT), // Hash password
            'userPhoneNumber' => $this->input->post('userPhoneNumber')
        );
    
        // Save user data to database
        $output = $this->utility->create_account($var);
    
        if ($output['status'] == 201) {
            echo json_encode([
                "status" => "success",
                "message" => $output['message'],
                "redirect" => base_url('auth/index') // Redirect to login page
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => is_array($output['message']) ? implode('<br>', $output['message']) : $output['message']
            ]);
        }
    }
    
    
    

    public function signin(){
        $data = array('title' => 'Sign In',
                    'description'=> 'An effective fundraising platform for Muslims in Nigeria.',
                    'content_view' => 'account/signin');
        $this->template->general_format($data);
    }

    public function sign_out()
    {
        session_destroy();
        redirect('auth');
    }

}