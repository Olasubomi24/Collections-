<?php
class Utility extends MX_Controller{
    public function __construct()
    {
        parent::__construct();
    }
    
   

    public function call_api($method, $url, $data = false) {
        $header = [
            "Content-Type: application/json",
            "Accept: */*",
           // "x-api-key: " . X_API_KEY
        ];
    
        $curl = curl_init();
    
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, true);
                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;
            default:
                if ($data) {
                    $url = $url . "?" . http_build_query($data);
                }
        }
    
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        
        $result = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // Get HTTP response code
        $err = curl_error($curl);
    
        curl_close($curl);
    
        if ($err) {
            return ["error" => "cURL Error: " . $err];
        } else {
            return [
                "status" => $httpCode,
                "response" => json_decode($result, true)
            ];
        }
    }
    
    
    // Function to send user registration data
    public function create_account($var)
    {
        $url = "https://api.macrotech.com.ng/api/v1/auth/register";
        $response = $this->call_api('POST', $url, $var);

    
        return $response;
        
    }
public function user_login($var) {
    $url = "https://api.macrotech.com.ng/api/v1/auth/login";
    
    // Print the request data
    // echo "<pre>Request Data: ";
    // print_r($var);
    // echo "</pre>";

    $response = $this->call_api('POST', $url, $var);

    // Print the response from API
    // echo "<pre>Response Data: ";
    // print_r($response);
    // echo "</pre>";

    return $response;
}

public function hospital_list($var)
{
    $url = "https://api.macrotech.com.ng/api/v1/hospitals";
    $response = $this->call_api('POST', $url, $var);


    return $response;
    
}


private function call_apis($method, $url, $data = null)
{
    $token = $_SESSION['access_token'];
    $headers = [
        "Authorization: Bearer $token",
        "Accept: application/json",
        "Accept: */*",
        "Content-Type: application/json"
    ];

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => $headers
    ]);

    if ($data) {
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response, true);
}

public function get_hospitals()
{
    $url = "https://api.macrotech.com.ng/api/v1/hospitals";
    $response = $this->call_apis('GET', $url);
   // print_r($response); die;    
    return  $response;
}

public function get_hospital_by_id($id)
{
    return $this->call_apis('GET', "https://api.macrotech.com.ng/api/v1/hospitals/$id");
}

public function create_hospital($data)
{
    return $this->call_apis('POST', "https://api.macrotech.com.ng/api/v1/hospitals", $data);
}

public function update_hospital($id, $data)
{
    return $this->call_apis('PUT', "https://api.macrotech.com.ng/api/v1/hospitals/$id", $data);
}




public function get_patient_wallet()
{
    $url = "https://api.macrotech.com.ng/api/v1/patient-wallets";
    $response = $this->call_apis('GET', $url);
   // print_r($response); die;    
    return  $response;
}

public function get_patient_wallet_by_id($id)
{
    return $this->call_apis('GET', "https://api.macrotech.com.ng/api/v1/patient-wallets/$id");
}

public function create_patient_wallet($data)
{
    return $this->call_apis('POST', "https://api.macrotech.com.ng/api/v1/patient-wallets", $data);
}

public function update_patient_wallet($id, $data)
{
    return $this->call_apis('PUT', "https://api.macrotech.com.ng/api/v1/patient-wallets/$id", $data);
}

public function get_wallet_funding()
{
    $url = "https://api.macrotech.com.ng/api/v1/wallet-funding";
    $response = $this->call_apis('GET', $url);
   // print_r($response); die;    
    return  $response;
}

public function get_wallet_funding_by_id($id)
{
    return $this->call_apis('GET', "https://api.macrotech.com.ng/api/v1/wallet-funding/$id");
}

public function create_wallet_funding($data)
{
    return $this->call_apis('POST', "https://api.macrotech.com.ng/api/v1/wallet-funding", $data);
}

public function update_wallet_funding($id, $data)
{
    return $this->call_apis('PUT', "https://api.macrotech.com.ng/api/v1/wallet-funding/$id", $data);
}
    

public function get_settlement()
{
    $url = "https://api.macrotech.com.ng/api/v1/settlements";
    $response = $this->call_apis('GET', $url);
   // print_r($response); die;    
    return  $response;
}

public function get_settlement_by_id($id)
{
    return $this->call_apis('GET', "https://api.macrotech.com.ng/api/v1/settlements/$id");
}

public function create_settlement($data)
{
    return $this->call_apis('POST', "https://api.macrotech.com.ng/api/v1/settlements", $data);
}

public function update_settlement($id, $data)
{
    return $this->call_apis('PUT', "https://api.macrotech.com.ng/api/v1/settlements/$id", $data);
}

public function get_collection()
{
    $url = "https://api.macrotech.com.ng/api/v1/settlements";
    $response = $this->call_apis('GET', $url);
   // print_r($response); die;    
    return  $response;
}

public function get_collection_by_id($id)
{
    return $this->call_apis('GET', "https://api.macrotech.com.ng/api/v1/collections/$id");
}

public function create_collection($data)
{
    return $this->call_apis('POST', "https://api.macrotech.com.ng/api/v1/collections", $data);
}

public function update_collection($id, $data)
{
    return $this->call_apis('PUT', "https://api.macrotech.com.ng/api/v1/collections/$id", $data);
}
   
    
    // public function get_success_story(){
    //     $url = collection_url . "success_stories";
    //     $callAPi = $this->call_api('GET', $url,'');
    //     //print_r($callAPi);die;
    //     return json_decode($callAPi,true);
    // }

    public function get_user()
{
    $url = "https://api.macrotech.com.ng/api/v1/users";
    $response = $this->call_apis('GET', $url);
   // print_r($response); die;    
    return  $response;
}

public function get_user_by_id($id)
{
    return $this->call_apis('GET', "https://api.macrotech.com.ng/api/v1/users/$id");
}

public function create_user($data)
{
    return $this->call_apis('POST', "https://api.macrotech.com.ng/api/v1/users", $data);
}

public function update_user($id, $data)
{
    return $this->call_apis('PUT', "https://api.macrotech.com.ng/api/v1/users/$id", $data);
}
   
    
    // public function user_details($var){
    //     $url = collection_url . "user_details";
    //     $callApi= $this->call_api('Q_POST', $url, $var);
    //     return  json_decode($callApi, true);
    // }

    // public function update_profile($var){
    //     $url = collection_url . "update_user_account";
    //     $callAPi = $this ->call_api('Q_POST',$url,$var);
    //     return json_decode($callAPi,true);
    // }

    // public function getbanklist(){
    //   $url = collection_url . "ngn_bank";
    //   $callAPi = $this->call_api('GET',$url,'');
    //   return json_decode($callAPi,true);
    // }
    
    // public function campaign_types(){
    //     $url = collection_url . "campaign_types";
    //     $callAPi = $this ->call_api('GET',$url,'');
    //     return json_decode($callAPi,true);
    // }
    //  public function campaigns_total_donation(){
    //     $url = collection_url . "campaigns_total_donation";
    //     $callAPi = $this ->call_api('GET',$url,'');
    //     return json_decode($callAPi,true);
    // }
    // public function create_campaign($var){
    //     $url = collection_url . "create_campaign";
    //     $callAPi = $this ->call_api('Q_POST',$url,$var);
    //     return json_decode($callAPi,true);
    // }
    
    // public function get_campaign($id){
    //     $url = collection_url . "short_campaign?status=".$id;
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }
    // public function list_campaigns(){
    //     $url = collection_url . "list_campaign";
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }
    // public function total_tmc_trans(){
    //     $url = collection_url . "tmc_total_donation";
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }
    // public function email_subscriber($var){
    //     $url = collection_url . "email_subcriber";
    //     $callAPi = $this->call_api('Q_POST', $url, $var);
    //     return json_decode($callAPi, true);
    // }

    // public function questions(){
    //     $url = collection_url . "list_all_questions";
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }

    // public function sheikh_list(){
    //     $url = collection_url . "list_sheikh";
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }
    // public function question_category(){
    //     $url = collection_url . "question_category";
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }
    // public function ask_a_question($var){
    //     $url =collection_url . "create_question";
    //     $callAPi = $this->call_api('Q_POST', $url, $var);
    //     return json_decode($callAPi,true);
    // }
    // public function questions_according_to_category($id){
    //     $url = collection_url . "list_questioncategory_answer/".$id;
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }

    // public function single_question($question_ID){
    //     $url = collection_url . "single_question_page/".$question_ID;
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }

    // public function get_full_campaign_detail($campaign_ID){
    //     $url = collection_url . "full_campaign/".$campaign_ID;
    //     $callAPi = $this->call_api('GET', $url,'');
    //     // print_r($callApi); die;
    //     return json_decode($callAPi,true);
    // }
    
    // public function get_full_campaign_details($var){
    //     $url = collection_url . "full_campaigns";
    //     $callAPi = $this->call_api('Q_POST', $url,$var);
    //     return json_decode($callAPi,true);
    // }
    // public function comments($data){
    //     $url = collection_url . "comments";
    //     $callAPi = $this->call_api('Q_POST', $url,$data);
    //     return json_decode($callAPi,true);
    // }
    //     public function comment_details($decodeCampaignID){
    //     $url = collection_url . "comment_detail/".$decodeCampaignID;
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }
    
    // public function get_verify_user($verification_token){
    //     $url = collection_url . "verify_user?verification_token=".$verification_token;
    //     $callAPi = $this->call_api('GET', $url,'');
    //      //print_r($callAPi); die;
    //     return json_decode($callAPi,true);
       
    // }
    // public function get_verify_seminar_user($verification_token){
    //     $url = collection_url . "verify_seminar_user?verification_token=".$verification_token;
    //     $callAPi = $this->call_api('GET', $url,'');
    //      //print_r($callAPi); die;
    //     return json_decode($callAPi,true);
       
    // }
    //     public function get_verify_subscribe_user($verification_token){
    //     $url = collection_url . "verify_subscribe_user?verification_token=".$verification_token;
    //     $callAPi = $this->call_api('GET', $url,'');
    //      //print_r($callAPi); die;
    //     return json_decode($callAPi,true);
       
    // }
    // public function get_campaign_virtual_account($campaign_ID){
    //     $url = collection_url . "campaign_virtual_account/".$campaign_ID;
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }

    // public function payment($var){
    //     $url =collection_url . "flutter_payment";
    //     $callAPi = $this->call_api('Q_POST', $url, $var);
    //     return json_decode($callAPi,true);
    // }

    // public function payments($var){
    //     $url =collection_url . "flutter_payments";
    //     $callAPi = $this->call_api('Q_POST', $url, $var);
    //     return json_decode($callAPi,true);
    // }
    // public function tmc_payment($var){
    //     $url =collection_url . "tmc_flutter_payment";
    //     $callAPi = $this->call_api('Q_POST', $url, $var);
    //     //print_r($callAPi); die;
    //     return json_decode($callAPi,true);
    // }
    // public function tmc_payments($var){
    //     $url =collection_url . "tmc_flutter_payments";
    //     $callAPi = $this->call_api('Q_POST', $url, $var);
    //     //print_r($callAPi); die;
    //     return json_decode($callAPi,true);
    // }
    // public function ramadan_subcriber($var){
    //     $url =collection_url . "ramdan_subcriber";
    //     $callAPi = $this->call_api('Q_POST', $url, $var);
    //     return json_decode($callAPi,true);
    // }
    // public function tmc_subcriber($var){
    //     $url =collection_url . "tmc_details";
    //     $callAPi = $this->call_api('Q_POST', $url, $var);
    //     //print_r($callAPi); die;
    //     return json_decode($callAPi,true);
    // }
    // public function create_seminar($var){
    //     $url =collection_url . "seminar_creation";
    //     $callAPi = $this->call_api('Q_POST', $url, $var);
    //     return json_decode($callAPi,true);
    // }
    // public function create_subscribes($var){
    //     $url =collection_url . "subscribe_creation";
    //     $callAPi = $this->call_api('Q_POST', $url, $var);
         
    //       $sss = json_decode($callAPi,true);
    //             //print_r($sss);  die;
    //            return $sss ; 
    // }
    // public function about_us_subcriber($var){
    //     $url =collection_url . "about_us";
    //     $callAPi = $this->call_api('Q_POST', $url, $var);
    //     return json_decode($callAPi,true);
    // }
    //     public function campaign_recent_donationwith_total(){
    //     $url = collection_url . "campaign_recent_donationwith_total/";
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }

    // public function generate_token($var){
    //     $url = collection_url . "generate_token";
    //     $callAPi = $this->call_api('Q_POST', $url, $var);
    //     return json_decode($callAPi,true);  
    // }
    // public function forget_password($var){
    //     $url = collection_url . "update_security_details";
    //     $callAPi = $this->call_api('Q_POST', $url, $var);
    //     return json_decode($callAPi,true);
    // }
    // public function needycategory(){
    //     $url = collection_url . "needy_category";
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }

    // public function donateneedycategory($var){
    //     $url =collection_url . "donation_payment";
    //     $callAPi = $this->call_api('Q_POST', $url, $var);
    //     return json_decode($callAPi,true);
    // }
    
    //  public function stop_campaign($campaign_ID){
    //     $url = collection_url . "stop_campaign/".$campaign_ID;
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }
    
    //    public function currency_details(){
    //     $url = collection_url . "currency";
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }
    // public function local_gov_details(){
    //     $url = collection_url . "get_local_gov";
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }
    // public function state_details(){
    //     $url = collection_url . "get_state";
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }
    // public function due_details(){
    //     $url = collection_url . "get_due";
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }
    // public function tmc_branch_details(){
    //     $url = collection_url . "get_tmc_branches";
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }
    
    // public function get_campaign_donation($campaign_ID){
    //     $url = collection_url . "campaign_recent_donation/".$campaign_ID;
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }
    // public function get_tmc_donation(){
    //     $url = collection_url . " ";
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }
    //  public function referraltoken($data){
    //     $url =collection_url . "referral_token";
    //     $callAPi = $this->call_api('Q_POST', $url, $data);
    //     return json_decode($callAPi,true);
    // }

    // public function userrefferal($email){
    //     $url = collection_url . "user_referral?email=".$email;
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }
    //  public function token_refferal_details($tokena){
    //     $url = collection_url . "token_details?user_token=".$tokena;
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }
    
    //    public function get_friday_donation_list(){
    //     $url = collection_url . "friday_donation_list";
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }
    // public function list_project($id = null){
    //     $url = collection_url . "list_projects";
    //     if ($id !== null) {
    //         $url .= "?status=" . $id;
    //     }
    //     $callAPi = $this->call_api('GET', $url, '');
    //     return json_decode($callAPi, true);
    // }
    
    // public function total_friday_donation(){
    //     $url = collection_url . "total_friday_donation";
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }

    // public function total_summary_donation(){
    //     $url = collection_url . "total_summary_donation";
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }

    
    //   public function referral_bank_details($data){
    //     $url =collection_url . "referral_bank_details";
    //     $callAPi = $this->call_api('Q_POST', $url, $data);
    //     return json_decode($callAPi,true);
    // }

    // public function userbankdetails($email){
    //     $url = collection_url . "user_referral_details?email=".$email;
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }
    
    //     public function email_messages($email,$subject,$body){
    //     $url = collection_url . "email_message";
    //     $callAPi = $this->call_api('POST', $url, $email,$subject,$body);
    //     //print_r($callAPi);
    //     // echo $url.' ' .$email.' ' .$subject.' '.$body;
    //     return json_decode($callAPi,true);  
    // }
    // public function get_due_amount($due_id) {
    //     $url = "https://mosquepay.org/mosquepayapi/v1/api/get_due_amount?due_id=" . $due_id;
    
    //     // Log the URL
    //     log_message('debug', 'get_due_amount URL: ' . $url);
    
    //     $callApi = $this->call_api('GET', $url, '');
    
    //     // Log the response
    //     log_message('debug', 'get_due_amount Response: ' . $callApi);
    
    //     return json_decode($callApi, true);
    // }
    
    // public function get_local_gov($state_id) {
    //     $url = "https://mosquepay.org/mosquepayapi/v1/api/get_local_gov?state_id=" . $state_id;
    
    //     // Log the URL
    //     log_message('debug', 'get_local_gov URL: ' . $url);
    
    //     $callApi = $this->call_api('GET', $url, '');
    
    //     // Log the response
    //     log_message('debug', 'get_local_gov Response: ' . $callApi);
    
    //     return json_decode($callApi, true);
    // }
    
    // public function get_branches($state_id, $local_gov_id) {
    //     $url = "https://mosquepay.org/mosquepayapi/v1/api/get_branches?state_id=" . $state_id . "&local_gov_id=" . $local_gov_id;
    
    //     // Log the URL
    //     log_message('debug', 'get_branches URL: ' . $url);
    
    //     $callApi = $this->call_api('GET', $url, '');
    
    //     // Log the response
    //     log_message('debug', 'get_branches Response: ' . $callApi);
    
    //     return json_decode($callApi, true);
    // }
    
    // public function list_of_captain($grade_id = null) {
    //     $url = collection_url . "list_of_captain";
    //     $urls = "https://mosquepay.org/mosquepayapi/v1/api/list_of_captain";
    //     if ($grade_id !== null) {
    //         $url .= "?grade_id=" . $grade_id;
    //     }

    //     // Log the URL
    //     log_message('debug', 'list_of_captain URL: ' . $url);

    //     $callAPi = $this->call_api('GET', $url, '');

    //     // Log the response
    //     log_message('debug', 'list_of_captain Response: ' . $callAPi);

    //     return json_decode($callAPi, true);
    // }
    // public function list_of_branch($grade_id = null) {
    //     $url = collection_url . "list_of_captain";
    //     //$urls = "https://mosquepay.org/mosquepayapi/v1/api/list_of_captain";
    //     if ($grade_id !== null) {
    //         $url .= "?grade_id=" . $grade_id;
    //     }

    //     // Log the URL
    //     log_message('debug', 'list_of_captain URL: ' . $url);

    //     $callAPi = $this->call_api('GET', $url, '');

    //     // Log the response
    //     log_message('debug', 'list_of_captain Response: ' . $callAPi);

    //     return json_decode($callAPi, true);
    // }
    // public function list_of_member($captain_id = null) {
    //     $url = collection_url . "list_of_member";
    //     $urls = "https://mosquepay.org/mosquepayapi/v1/api/list_of_member";
    //     if ($captain_id !== null) {
    //         $url .= "?captain_id=" . $captain_id;
    //     }

    //     // Log the URL
    //     log_message('debug', 'list_of_member URL: ' . $url);

    //     $callAPi = $this->call_api('GET', $url, '');

    //     // Log the response
    //     log_message('debug', 'list_of_member Response: ' . $callAPi);

    //     return json_decode($callAPi, true);
    // }
    // public function list_of_grade(){
    //     $url = collection_url . "list_grade";
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }
    // public function get_some_local_gov(){
    //     $url = collection_url . "get_some_local_gov";
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }
    // public function ifako_ijaye_detail($data){
    //     $url =collection_url . "ifako_ijaye_details";
    //     $callAPi = $this->call_api('Q_POST', $url, $data);
    //     return json_decode($callAPi,true);
    // }
    // public function ifako_ijaye_payment($var){
    //     $url =collection_url . "ifako_ijaye_flutter_payment";
    //     $callAPi = $this->call_api('Q_POST', $url, $var);
    //     //print_r($callAPi); die;
    //     return json_decode($callAPi,true);
    // }
    // public function get_ifako_ijaye_donation(){
    //     $url = collection_url . "ifako_ijaye_recent_donation";
    //     $callAPi = $this->call_api('GET', $url,'');
    //     return json_decode($callAPi,true);
    // }


}
?>