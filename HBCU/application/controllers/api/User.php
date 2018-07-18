<?php


defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'/libraries/REST_Controller.php');
require(APPPATH.'/libraries/stripe.php');
/**
* This is an example of a few basic user interaction methods you could use
* all done with a hardcoded array
*
* @package         CodeIgniter
* @subpackage      Rest Server
* @category        Controller
*
**/
class User extends REST_Controller {
  function __construct() {
        parent::__construct();
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('User_model');
        $this->load->library('email');
        $this->email->initialize(array(
        'protocol' => 'smtp',
        'smtp_host' => 'smtp.sendgrid.net',
        'smtp_user' => 'osvinphp',
        'smtp_pass' => '@osvinphp12',
        'smtp_port' => 587,
        'crlf' => "\r\n",
        'newline' => "\r\n"
        ));
        $this->load->library('form_validation');
        $this->load->database();
        Stripe\Stripe::setApiKey("sk_test_0HEIX5gE8pRO5X5xuSPrPczU");
    }
    public function signup_post(){
          $email=$this->input->post('email');
          $password=$this->input->post('password');
          $signup_type=$this->input->post('signup_type');
          $fb_id=$this->input->post('fb_id');
          $signup_level=$this->input->post('signup_level');
          $first_name=$this->input->post('first_name');
          $last_name=$this->input->post('last_name');

          if(isset($_FILES['profile']['name'])){
            $profile=$_FILES['profile']['name'];
          }else{
            $profile=$this->input->post('profile_url');;
          }
          $hbcu=$this->input->post('hbcu');
          $percent= $this->input->post('percent');
          $greek_org=$this->input->post('greek_org');
          $organization=$this->input->post('organization');
          $anonymous=$this->input->post('anonymous');
          $user_id=$this->input->post('user_id');

          $name_on_card=$this->input->post('name_on_card');
          $card_num=$this->input->post('card_num');
          $card_type=$this->input->post('card_type');
          $card_token=$this->input->post('card_token');
          $pin=$this->input->post('pin');

          $login_via=$this->input->post('login_via');
          $unique_device_id=$this->input->post('unique_device_id');
          $token_id=$this->input->post('token_id');

          $referral_link=$this->input->post('referral_link');
          $is_default=$this->input->post('is_default');

          $alpha    = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
          $numeric  = str_shuffle('0123456789');
          $code     = substr($alpha, 0, 7) . substr($numeric, 0, 3);
          $unique_code= strtolower(str_shuffle($code));
          $unique_url = base_url()."invite/".$unique_code;

          if(empty($signup_level))
          {
               $response= $this->User_model->errorResponse("Required fields are missing");

          }
          elseif(($signup_level<1 OR $signup_level>5))
          {
               $response= $this->User_model->errorResponse("Wrong value of signup level");
          }
          if($signup_level=="1")
          {
               if(empty($email) OR empty($signup_type) and ((empty($password) and $signup_type=="email") or (empty($fb_id) and $signup_type=="facebook")) )
               {
                    $response= $this->User_model->errorResponse("Required fields are missing");

               }else
               {
                    if($signup_type=="facebook")
                    {
                         $myarray = array(
                         'email'=>$email,
                         'fb_id'=>$fb_id,
                         'signup_level'=>$signup_level,
                         'signup_type'=>$signup_type
                         );
                    }
                    if($signup_type=="email")
                    {
                         $myarray = array(
                         'email'=>$email,
                         'password'=>md5($email."-".$password),
                         'signup_level'=>$signup_level,
                         'signup_type'=>$signup_type
                         );
                    }
                    $response=$this->User_model->signup($myarray);
               }
          }
          if($signup_level=="2")
          {
               if(empty($first_name) OR empty($profile) OR empty($greek_org)  OR empty($hbcu) OR  empty($user_id) )
               {
                    $response= $this->User_model->errorResponse("Required fields are missing");
               }else
               {
                    if (!empty($referral_link)) {
                         $checkreferal  = $this->User_model->select_data('*','hb_users',array('unique_url'=>$referral_link));
                         if (empty($checkreferal)) {
                              $response= $this->User_model->errorResponse("referral link does not match.");
                         }
                    }
                    else{
                         $referral_link='0';
                    }
                    if(empty($organization))
                    {
                         $organization=0;
                    }
                    if(isset($_FILES['profile']['name']))
                    {
                         $upload_path = 'Public/profilePic';
                         $image = 'profile';
                         $profile = $this->file_upload($upload_path, $image);
                    }
                    $myarray = array(
                    'first_name'=>$first_name,
                    'last_name'=>$last_name,
                    'profile'=>$profile,
                    'signup_level'=>$signup_level,
                    'greek_org'=>$greek_org,
                    'organization'=>$organization,
                    'anonymous'=>$anonymous,
                    'unique_url'=>$unique_url,
                    'referral_link'=>$referral_link
                    );
                    $response = $this->User_model->updateprofile($myarray,$user_id,$hbcu,$percent);
               }
          }
          if($signup_level=="3")
          {
               $public_token=$this->input->post('public_token');
               $institution_id=$this->input->post('institution_id');
               if(empty($public_token))
               {
                    $response= $this->User_model->errorResponse("Required fields are missing");
               }else
               {
                    $vars = array(
                    'client_id'=>'596cd0c14e95b810ac887df6',
                    'secret'=>'36ca7ae963c88b05111f1246a5df69',
                    'public_token'=>$public_token
                    );
                    $aa=json_encode($vars);
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,"https://sandbox.plaid.com/item/public_token/exchange");
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS,$aa);  
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $headers = [
                    'Content-Type: application/json'
                    ];  
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $server_output = curl_exec ($ch);
                    // print_r($server_output);die;
                    curl_close ($ch);
                    $getaccesstoken=json_decode($server_output);
                    $access_token=$getaccesstoken->access_token;
                    $date=date('Y-m-d');
                    $vars12 = array(
                    'client_id'=>'596cd0c14e95b810ac887df6',
                    'secret'=>'36ca7ae963c88b05111f1246a5df69',
                    'access_token'=>$access_token,
                    "start_date"=> "2010-05-20",
                    "end_date"=> $date,
                    );
                    $aa2=json_encode($vars12);
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,"https://sandbox.plaid.com/transactions/get");
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS,$aa2);  //Post Fields
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $headers = [
                    'Content-Type: application/json'
                    ];
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $server_output = curl_exec ($ch);
                    curl_close ($ch);
                    $arr=json_decode($server_output);

                    $myarray = array(
                    'plaid_public_token'=>$public_token,
                    'plaid_access_token'=>$access_token,
                    'signup_level'=>$signup_level,
                    'plaid_ins_id'=>$institution_id,
                    );
                    $response = $this->User_model->updateprofile($myarray,$user_id);
               } 
          }


          // if($signup_level=="4")
          // {
          //      if(empty($name_on_card) OR empty($card_num) OR empty($user_id) OR empty($card_token) OR empty($card_type))
          //      {
          //           $response= $this->User_model->errorResponse("Required fields are missing");

          //      }else
          //      {
          //           $customer = \Stripe\Customer::create(array(
          //           "source" => $card_token,
          //           "description" => "work")
          //           );
          //           $customer_id = $customer->id;
          //           $myarray = array(
          //           'user_id'=>$user_id,
          //           'card_type'=>$card_type,
          //           'name_on_card'=>$name_on_card,
          //           'card_num'=>($card_num),
          //           'card_token'=>$card_token,
          //           'is_default'=>$is_default
          //           );
          //           $response = $this->User_model->insertCards($myarray,$user_id,$signup_level);

          //           $Stripecustomerdetails = array(
          //           'user_id'=>$user_id,
          //           'card_num'=>($card_num),
          //           'customer_id'=>$customer_id,
          //           'is_default'=>$is_default
          //           );
          //           $this->User_model->insertStripecustomerdetails($Stripecustomerdetails);

          //           $myarray = array(
          //           'signup_level'=>$signup_level
          //           );
          //           $this->User_model->updateprofile($myarray,$user_id);
          //      }

          // }

          if($signup_level=="5")
          {
               if(empty($pin) OR empty($user_id)  OR ($login_via< 0 or $login_via>1) OR empty($unique_device_id) OR empty($token_id))
               {
                    $response= $this->User_model->errorResponse("Required fields are missing");
               }else
               {
                    $myarray = array(
                    'signup_level'=>$signup_level,
                    'pin'=>md5($pin),
                    );
                    $checkreferal  = $this->User_model->select_data('*','hb_users',array('id'=>$user_id));
                    if (!empty($checkreferal[0]->referral_link)) {
                    $checkreferal1  = $this->User_model->select_data('*','hb_users',array('unique_url'=>$checkreferal[0]->referral_link));

                         if ($checkreferal1[0]->pushNotifications==0) {
                              $checklogin=$this->User_model->select_data('*','hb_login',array('user_id'=>$checkreferal1[0]->id,'status'=>1));
                              foreach ($checklogin as $key => $value) {
                                   $pushData['message'] = "Your referral link is used by ".ucfirst($first_name)." ";
                                   $pushData['action'] = "referral";
                                   $pushData['token'] = $value->token_id;
                                   if($value->login_via == 1){
                                        $this->User_model->iosPush($pushData);
                                   }else if($value->login_via == 0){
                                        $this->User_model->androidPush($pushData);
                                   }
                              }
                         }
                    }
                    $response = $this->User_model->updateprofile($myarray,$user_id);
                    $this->User_model->insertlogin($user_id,$login_via,$unique_device_id,$token_id);
               }
          }
          $this->set_response($response, REST_Controller::HTTP_OK);
          }
     public function createAccountId_post(){
          $user_id=$this->input->post('user_id');
          $access_token=$this->input->post('access_token');
          $account_id=$this->input->post('account_id');
          if (empty($user_id) || empty($access_token) || empty($account_id) ) {
               $response= $this->User_model->errorResponse("Required fields are missing");
          }
          else{
               $vars12 = array(
               'client_id'=>'596cd0c14e95b810ac887df6',
               'secret'=>'36ca7ae963c88b05111f1246a5df69',
               'access_token'=>$access_token,
               'account_id'=>$account_id
               );

               $aa2=json_encode($vars12);
               $url="https://sandbox.plaid.com/processor/stripe/bank_account_token/create";
               $result=curl_function($aa2,$url);

               if (isset($result->stripe_bank_account_token)) {
                    $stripe_token=$result->stripe_bank_account_token;
                    $customer = \Stripe\Customer::create(array(
                    "source" => $stripe_token,
                    "description" => "work")
                    );
                    $customer_id = $customer->id;
                    $myarray = array(
                    'plaid_access_token'=>$access_token,
                    'account_ids'=> $account_id,
                    'stripe_token'=>$stripe_token,
                    'stripe_customer_id'=>$customer_id
                    );
                    $response =$this->User_model->updateprofile($myarray,$user_id);
               }
               else{
                    $response= $this->User_model->errorResponse($result->error_message);
               }
          }
          $this->set_response($response, REST_Controller::HTTP_OK);
    }


    public function createaccesstoken_post(){
        $public_token = $this->input->post('public_token');
        $institution_id = $this->input->post('institution_id');
        $user_id = $this->input->post('user_id');
        if(empty($public_token) ||  empty($institution_id)  || empty($user_id))
        {
            $response= $this->User_model->errorResponse("Required fields are missing");
        }else
        {
            $params = array(
            'client_id'=>'596cd0c14e95b810ac887df6',
            'secret'=>'36ca7ae963c88b05111f1246a5df69',
            'public_token'=>$public_token
            );
            $params=json_encode($params);
            $url="https://sandbox.plaid.com/item/public_token/exchange";
            $getaccesstoken=curl_function($params,$url);
            $access_token=$getaccesstoken->access_token;
            if (isset($getaccesstoken->access_token)) {
                $date=date('Y-m-d');
                $params = array(
                'client_id'=>'596cd0c14e95b810ac887df6',
                'secret'=>'36ca7ae963c88b05111f1246a5df69',
                'access_token'=>$access_token,
                );

                $params=json_encode($params);
                $url="https://sandbox.plaid.com/transactions/get";
                curl_function($params,$url);
                $myarray = array(
                'plaid_public_token'=>$public_token,
                'plaid_access_token'=>$access_token,
                'plaid_ins_id'=>$institution_id,
                'account_ids'=>''
                );
                $response = $this->User_model->updateprofile($myarray,$user_id);
            }
            else{
                $response= $this->User_model->errorResponse("Error in creating token.");
            }   
        }
        $this->set_response($response, REST_Controller::HTTP_OK);
    } 
    public function checktokenstatus_post(){
        $user_id=$this->input->post('user_id');
        $query=$this->db->query("SELECT * from hb_users where id='".$user_id."' and signup_level=5 ")->row();
        if (!empty($query)) {
            if (empty($query->plaid_access_token)) {
                $response= $this->User_model->errorResponse("Token is empty.");
            }
            else{
                $response= $this->User_model->successResponse("Token is not empty.");
            }
        }
        else{
            $response= $this->User_model->errorResponse("User id does not exist.");
        }
        $this->set_response($response, REST_Controller::HTTP_OK);
    }

    function addCard_post() {

      $user_id=$this->input->post('user_id');
      $name_on_card=$this->input->post('name_on_card');
      $card_num=$this->input->post('card_num');
      $card_type=$this->input->post('card_type');
      $card_token=$this->input->post('card_token');
      $is_default=$this->input->post('is_default');

      if(empty($name_on_card) OR empty($card_num) OR empty($user_id) OR empty($card_token) OR empty($card_type))
      {
        $response= $this->User_model->errorResponse("Required fields are missing");

      }else
      {
        $response = $this->User_model->getUserDetails($user_id);  

        if(!empty($response))
        { 
          $signup_level=$response->signup_level;

          $customer = \Stripe\Customer::create(array(
            "source" => $card_token,
            "description" => "work")
          );

          $customer_id = $customer->id;

          $myarray = array(
            'user_id'=>$user_id,
            'card_type'=>$card_type,
            'name_on_card'=>$name_on_card,
            'card_num'=>($card_num),
            'card_token'=>$card_token,
            'is_default'=>$is_default
            );
          if ($is_default==1) {
            $data = $this->User_model->update_data('hb_cards',array('is_default'=>0),array('user_id'=>$user_id));
            $data1 = $this->User_model->update_data('hb_stripecustomerdetails',array('is_default'=>0),array('user_id'=>$user_id));
          }


          $response = $this->User_model->insertCards($myarray,$user_id,$signup_level);


          $Stripecustomerdetails = array(
            'user_id'=>$user_id,
            'card_num'=>($card_num),
            'customer_id'=>$customer_id,
            'is_default'=>$is_default
            );
          $this->User_model->insertStripecustomerdetails($Stripecustomerdetails);

        }

      }

      $this->set_response($response, REST_Controller::HTTP_OK);
    }


    function addReoccurringDonation_post() {
        $user_id=$this->input->post('user_id');
        $amount=$this->input->post('amount');
        $id=$this->input->post('id');
        $card_id=$this->input->post('card_id');
        $donation_type=1;
        $cycle=$this->input->post('cycle');
        $hbcu_id=$this->input->post('hbcu_id');
        $date=date("Y-m-d");
        $dateTime=date("Y-m-d H:i:s");

        if(empty($user_id) OR empty($amount))
        {
        $response= $this->User_model->errorResponse("Required fields are missing");
        }else
        {
            if($amount<1 or !is_numeric($amount))
            {
                $response= $this->User_model->errorResponse("Please enter a valid amount");
            }else
            {
                $ReoccurringPayments  = $this->User_model->select_data('*','hb_users',array('id'=>$user_id));
                $checkUserHBCU = $this->User_model->checkUserHBCU($user_id);
                $UserHBCU11 = $this->User_model->checkUserHBCUpercent($user_id);
                if(empty($checkUserHBCU))
                {
                    $response= $this->User_model->errorResponse("Sorry your HBCUs are not added or updated");
                }else
                    {
                    if (empty($UserHBCU11)) {
                      $response= $this->User_model->errorResponse("Hbcu percentage not defined");
                    }
                    else{
                        if ($ReoccurringPayments[0]->isActivereoccuring==0) {
                            $response= $this->User_model->errorResponse("Your reoccurring status is inactive");
                        }
                        else{
                        $myarray =array(
                        'user_id'=>$user_id,
                        'amount'=>$amount,
                        'cycle'=>$cycle,
                        'card_id'=>$card_id,
                        'date'=>$date,
                        'hbcu_id'=>$hbcu_id,
                        'dateTime'=>$dateTime,
                        );
                        $response = $this->User_model->addReoccurringDonation($myarray,$id);
                        }
                    }
                }
            }
        }    
        $this->set_response($response, REST_Controller::HTTP_OK);
    }
    public function oneTimeDonation_post() {
        $user_id=$this->input->post('user_id');
        $card_id=$this->input->post('card_id');
        $hbcu=$this->input->post('hbcu');
        $amount=$this->input->post('amount');
        $is_reoccurring=$this->input->post('is_reoccurring');
        $donation_type=2;
        $date=date("Y-m-d");
        $dateTime=date("Y-m-d H:i:s");

        if(empty($user_id)  OR empty($hbcu) OR empty($amount))
        {
        $response= $this->User_model->errorResponse("Required fields are missing");
        }else
        {
        $response = $this->User_model->getUserDetails($user_id);
        if(empty($response))
        {
            $response=$this->User_model->errorResponse("User not found");
        }else
        {   
            if(isset($response->organization->id))
            {    
                $organization=$response->organization->id;
            }else
            {
                $organization=0;
            }
            if (!empty($card_id)) {
                $check_card = $this->User_model->getUserCard($card_id);
                $addedcard=$check_card->customer_id;
            }
            else{
                $addedcard=$response->stripe_customer_id;
            }

            // $check_card = $this->User_model->getUserCard($card_id);

            // if(empty($check_card))
            // {
            //   $response=$this->User_model->errorResponse("Card not found");
            // }else
            // {

                    $stripeAmount = $amount * 100;    // Since the amount charged by stripe is in cents for singapore doller, so here amount = 1 is being converted into 100 cents since actual payment will be 1 doller from front end |here| 1 doller = 100 cents:
                    $pay =  \Stripe\Charge::create(array(
                      "amount"   => $stripeAmount,
                      "currency" => "USD",
                      "customer" => $addedcard
                      ));


                    // print_r($pay);die;
                    $txnId = $pay->balance_transaction;
                    $card_num=$check_card->card_num;
                    $myarray =array(
                    'user_id'=>$user_id,
                    // 'card_num'=>$card_num,
                    'card_id'=>$card_id,
                    'hbcu'=>$hbcu,
                    'organization'=>$organization,
                    'donation_type'=>$donation_type,
                    'amount'=>$amount,
                    'txnId'=>$txnId,
                    'paymentdate'=>$date,
                    'date'=>$date,
                    'dateTime'=>$dateTime,
                    );
                    if(!empty($response) && $txnId!="")
                    {
                        $response = $this->User_model->addDonation($myarray);
                        $response= $this->User_model->successResponse("Payment Successfull",$response);
                       /*if($is_reoccurring==1)
                       {       
                               $date=date("Y-m-d");
                               $dateTime=date("Y-m-d H:i:s");
                               
                             $getReoccurringDonation = $this->User_model->getReoccurringDonation($user_id);
                             if($getReoccurringDonation)
                             { 
                                   $updateArray =array(
                                                 'amount'=>$amount
                                                  );
                                   $this->User_model->addReoccurringDonation($updateArray,$getReoccurringDonation->id);

                             }else
                             {
                                   $myarray =array(
                                                  'user_id'=>$user_id,
                                                  'amount'=>$amount,
                                                  'cycle'=>1,
                                                  'card_id'=>$card_id,
                                                  'date'=>$date,
                                                  'dateTime'=>$dateTime,
                                   );  
                                   $this->User_model->addReoccurringDonation($myarray);
                             }
                         }*/
                    }else
                    {
                        $response= $this->User_model->errorResponse("Something went wrong, try again after some time");
                    }
            }
        }
        $this->set_response($response, REST_Controller::HTTP_OK);

    }
    public function updateprofile_post() {
        $user_id=$this->input->post('user_id');
        $first_name=$this->input->post('first_name');
        $last_name=$this->input->post('last_name');
        $hbcu="";
        $percent=$this->input->post('percent');
        $greek_org=$this->input->post('greek_org');
        $organization=$this->input->post('organization');

        if(empty($user_id))
        {
        $response= $this->User_model->errorResponse("Required fields are missing");
        }else
        {
            if(isset($_FILES['profile']['name']))
            {
                $profile=$_FILES['profile']['name'];
                $upload_path = 'Public/profilePic';
                $image = 'profile';
                $profile = $this->file_upload($upload_path, $image);
            }else
            {
                $profile="";
            }
            $myarray = array(
            'first_name'=>$first_name,
            'last_name'=>$last_name,
            'profile'=>$profile,
            'greek_org'=>$greek_org,
            'organization'=>$organization
            );
            $myarray=array_filter($myarray);
            if($organization==0){
                $myarray['organization']=$organization;
            }
            $response = $this->User_model->updateprofile($myarray,$user_id,$hbcu,$percent);
        }
        $this->set_response($response, REST_Controller::HTTP_OK);
    }
    function adduserhbcu_post() 
    {
        $user_id=$this->input->post('user_id');
        $hbcu=$this->input->post('hbcu');
        $donation_percent=$this->input->post('percent');
        $hbcuType=$this->input->post('hbcuType');
        $userDetails = $this->User_model->getUserDetails($user_id);
        if(empty($user_id) or empty($hbcu))
        {
            $response= $this->User_model->errorResponse("Required fields are missing");
        }elseif(!$userDetails)
        {
            $response= $this->User_model->errorResponse("User not found");
        }else
        {   
            $checkHbcuExists = $this->User_model->checkHbcuExists($hbcu);
            if($checkHbcuExists==false)
            {
                $response= $this->User_model->errorResponse("HBCU not Found");
                goto a;
            }
            $HbcuDetails = $this->User_model->checkHbcuAreadyInserted($hbcu,$user_id);
            if($HbcuDetails)
            {
                $response= $this->User_model->errorResponse("HBCU Already Inserted");
            }else
            {
                $myarray = array(
                'user_id'=>$user_id,
                'hbcu'=>$hbcu,
                'donation_percent'=>$donation_percent,
                'hbcuType'=>$hbcuType
                );
                $response = $this->User_model->adduserhbcu($myarray);
            } 
        }
        a: 
        $this->set_response($response, REST_Controller::HTTP_OK);
    }
    function updateuserhbcu_post() 
        {
        $user_id=$this->input->post('user_id');
        $id=$this->input->post('id');
        $hbcu=$this->input->post('hbcu');
        $userDetails = $this->User_model->getUserDetails($user_id);
        if(empty($user_id) or empty($hbcu))
        {
            $response= $this->User_model->errorResponse("Required fields are missing");
        }elseif(!$userDetails)
        {
            $response= $this->User_model->errorResponse("User not found");
        }else
        {
            $checkHbcuExists = $this->User_model->checkHbcuExists($hbcu);
            if($checkHbcuExists==false)
            {
                $response= $this->User_model->errorResponse("HBCU not Found");
                goto a;
            }
            $HbcuDetails = $this->User_model->checkHbcuAreadyInserted($hbcu,$user_id);
            if($HbcuDetails)
            {
                $response= $this->User_model->errorResponse("HBCU Already Inserted");
            }else
            {
                $myarray = array(
                'hbcu'=>$hbcu,
                );
                $response = $this->User_model->updateuserhbcu($myarray,$id);
            } 
        }
        a: 
        $this->set_response($response, REST_Controller::HTTP_OK);
    }
    function deleteuserhbcu_post(){
        $id=$this->input->post('id');
        if(empty($id))
        {
            $response= $this->User_model->errorResponse("Required fields are missing");
        }else
        {
            $HbcuDelete = $this->User_model->deleteUserHbcu($id);
            if($HbcuDelete)
            {
                $response= $this->User_model->successResponse("Deleted Successfully",$id);
            }else
            {
                $response= $this->User_model->errorResponse("Something went wrong");
            } 
        }
        $this->set_response($response, REST_Controller::HTTP_OK);
    }
    public function checklevel_post(){
        $email=$this->input->post('email');
        if(empty($email))
        {
            $response= $this->User_model->errorResponse("Required fields are missing");
        }
        else
        {
            $response=$this->User_model->select_data('signup_level','hb_users',array('email'=>$email));
            if($response)
            {    
                $response=$response[0]->signup_level;
                $response= $this->User_model->successResponse("Current Sign Up level",$response);
            }else
            {
                $response= $this->User_model->errorResponse("User Not found");
            }
        }
        $this->set_response($response, REST_Controller::HTTP_OK);
    }

    public function login_post(){
        $email=lcfirst($this->input->post('email'));
        $password=$this->input->post('password');
        $login_type=$this->input->post('login_type');
        $fb_id=$this->input->post('fb_id');
        $login_via=$this->input->post('login_via');
        $unique_device_id=$this->input->post('unique_device_id');
        $token_id=$this->input->post('token_id');
        $myarray = array(
        'email'=>$email,
        'fb_id'=>$fb_id,
        'password'=>$password,
        'login_type'=>$login_type,
        'login_via'=>$login_via,
        'unique_device_id'=>$unique_device_id,
        'token_id'=>$token_id,
        );
        if(empty($login_type) OR empty($unique_device_id) OR empty($token_id)  OR empty($email))
        {
        $response= $this->User_model->errorResponse("Required fields are missing");

        }
        elseif(empty($email)  and ((empty($password) and $login_type=="email") or (empty($email) and empty($fb_id)  and $login_type=="facebook") ))
        {
        $response= $this->User_model->errorResponse("Required fields are missing");

        }else
        {
        if($login_type=="facebook")
        {
        $response=$this->User_model->login($myarray);

        }
        elseif($login_type=="email")
        { 



        $response=$this->User_model->login($myarray);
        }
        else
        {
        $response= $this->User_model->errorResponse("Wrong Login Type");

        }
        }
        $this->set_response($response, REST_Controller::HTTP_OK);
    }


    function forgotpassword_post() {

        $email = lcfirst($this->post('email'));

        $result = $this->User_model->forgotpassword($email);

        if ($result == 0)
        {
        $response= $this->User_model->errorResponse("Email does not exist");

        } else {

        $body = "<!DOCTYPE html>
        <head>
        <meta content=text/html; charset=utf-8 http-equiv=Content-Type />
        <title>Forgot Password</title>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
        </head>
        <body>
        <table width=60% border=0 bgcolor=#53CBE6 style=margin:0 auto; float:none;font-family: 'Open Sans', sans-serif; padding:0 0 10px 0;>
        <tr>
        <th width=20px></th>
        <th width=20px  style=padding-top:30px;padding-bottom:30px;><img height='250' width='180' src=".base_url()."Public/img/logo.png></th>
        <th width=20px></th>
        </tr>
        <tr>
        <td width=20px></td>
        <td bgcolor=#fff style=border-radius:10px;padding:20px;>
        <table width=100%;>
        <tr>
        <th style=font-size:20px; font-weight:bolder; text-align:right;padding-bottom:10px;border-bottom:solid 1px #ddd;> Hello " . $result['first_name'] . "</th>
        </tr>

        <tr>
        <td style=font-size:16px;>
          <p> You have requested a password retrieval for your user account at HBCU.To complete the process, click the link below.</p>
          <p><a href=" . site_url('api/User/newpassword?token=' . $result['token']) . ">Change Password</a></p>
        </td>
        </tr>


        <tr>
        <td style=text-align:center; padding:20px;>
          <h2 style=margin-top:50px; font-size:29px;>Best Regards,</h2>
          <h3 style=margin:0; font-weight:100;>Customer Support</h3>
          <h3 style=margin:0; font-weight:100;><img height='150' width='100' src=".base_url()."Public/img/ic_logo.png></h3>
        </td>
        </tr>
        </table>
        </td>
        <td width=20px></td>
        </tr>
        <tr>
        <td width=20px></td>
        <td style=text-align:center; color:#fff; padding:10px;> Copyright © HBCU All Rights Reserved</td>
        <td width=20px></td>
        </tr>
        </table>
        </body>";
        $this->load->library('encryption');
        $this->email->set_newline("\r\n");
        $this->email->from('info@hbcu.com', 'HBCU');
        $this->email->to($email);
        $this->email->subject('Forgot Password');
        $this->email->message($body);
        $mail=$this->email->send();
        // print_r($mail);die;

        $response= $this->User_model->successResponse("Check you mail",$email);
        }

        $this->set_response($response, REST_Controller::HTTP_OK);
    }

    public function addHBCUComment_post(){
        $hbcu=$this->input->post('hbcu');
        $comment= $this->input->post('comment');
        $user_id=$this->input->post('user_id');
        if(empty($hbcu) OR empty($comment) OR empty($user_id))
        {
        $response= $this->User_model->errorResponse("Required fields are missing");
        }else
        {  
        $checkHbcuExist = $this->User_model->checkHbcuExist($hbcu);
        if(!$checkHbcuExist)
        {
        $response = $this->User_model->errorResponse("HBCU not found");
        }else
        {
        $response = $this->User_model->addHBCUComment($user_id,$hbcu,$comment);
        }
        }
        $this->set_response($response, REST_Controller::HTTP_OK);
    }


    public function getReoccurringDonation_get(){                                  // Get category list

        $user_id=$this->input->get('user_id');
        $response = $this->User_model->getUserDetails($user_id);
        if(empty($response))
        {
        $response = $this->User_model->errorResponse("User not found",$response);
        }else
        {
            $response = $this->User_model->getReoccurringDonation($user_id);
            if($response)
            {   
                $response->serverCurrentDate=date("Y-m-d");
                $response = $this->User_model->successResponse("success",$response);
            }else
            {
                $response = $this->User_model->errorResponse("No recurring donation found.",$response);
            }
        }
        $this->set_response($response, REST_Controller::HTTP_OK);
    }

    public function getHbcu_get(){                                  // Get category list
        $user_id=$this->input->get('user_id');
        $response = $this->User_model->getHbcu($user_id);

        if(empty($response))
        {
        $response = $this->User_model->successResponse("No record found",$response);
        }else
        {
        $response = $this->User_model->successResponse("success",$response);
        }
        $this->set_response($response, REST_Controller::HTTP_OK);
    }


    public function getHbcuFavouriteBy_get(){                                  // Get category list
        $hbcu=$this->input->get('hbcu');
        if(empty($hbcu))
        {
        $response = $this->User_model->errorResponse("Required fields are missing");
        }else
        {     
            $checkHbcuExist = $this->User_model->checkHbcuExist($hbcu);
            if(!$checkHbcuExist)
            {
                $response = $this->User_model->errorResponse("HBCU not found");
            }else
            {
                $response = $this->User_model->getHbcuFavouriteBy($hbcu); 
                if($response)
                {
                    $response = $this->User_model->successResponse("success",$response);
                }else
                {
                    $response = $this->User_model->errorResponse("No record found"); 
                }
            }
        }
        $this->set_response($response, REST_Controller::HTTP_OK);
    }
    public function getHbcuCommentsBy_get(){                                  // Get category list
        $hbcu=$this->input->get('hbcu');
        if(empty($hbcu))
        {
            $response = $this->User_model->errorResponse("Required fields are missing");
        }else{     
            $checkHbcuExist = $this->User_model->checkHbcuExist($hbcu);
            if(!$checkHbcuExist)
            {
            $response = $this->User_model->errorResponse("HBCU not found");
            }else
            {
            $response = $this->User_model->getHbcuCommentsBy($hbcu); 
            if($response)
            {
            $response = $this->User_model->successResponse("success",$response);
            }else
            {
            $response = $this->User_model->errorResponse("No record found"); 
            }
            }
            }
        $this->set_response($response, REST_Controller::HTTP_OK);

    }
    public function getHbcuDonatedBy_get(){                                  // Get category list
        $hbcu=$this->input->get('hbcu');
        if(empty($hbcu))
        {
        $response = $this->User_model->errorResponse("Required fields are missing");
        }else
        {     
        $checkHbcuExist = $this->User_model->checkHbcuExist($hbcu);

        if(!$checkHbcuExist)
        {
        $response = $this->User_model->errorResponse("HBCU not found");
        }else
        {
        $response = $this->User_model->getHbcuDonatedBy($hbcu); 
        if($response)
        {
        $response = $this->User_model->successResponse("success",$response);
        }else
        {
        $response = $this->User_model->errorResponse("No record found"); 
        }
        }
        }
        $this->set_response($response, REST_Controller::HTTP_OK);
    }


    public function getHbcuDetails_get(){                                  // Get category list
        $hbcu=$this->input->get('hbcu');
        if(empty($hbcu))
        {
        $response = $this->User_model->errorResponse("Required fields are missing");
        }else
        {     
        $checkHbcuExist = $this->User_model->checkHbcuExist($hbcu);

        if(!$checkHbcuExist)
        {
        $response = $this->User_model->errorResponse("HBCU not found");
        }else
        {


        $response = $this->User_model->getHbcuDetails($hbcu); 
        $response['logo']=$checkHbcuExist->logo;
        $response['title']=$checkHbcuExist->title;
        $response['image']=$checkHbcuExist->image;
        // print_r($response);die;
        $response = $this->User_model->successResponse("success",$response);
        }

        }

        $this->set_response($response, REST_Controller::HTTP_OK);

    }
    public function getUserDetails_get(){                                  // Get category list
        $user_id = trim($this->get('user_id'));
        $response = $this->User_model->getUserDetails($user_id);
        if(empty($response))
        {
        $response=$this->User_model->errorResponse("User not found");
        }else
        {
        $response= $this->User_model->successResponse("success",$response);
        }
        $this->set_response($response, REST_Controller::HTTP_OK);
     }




    public function getOrganization_get(){                                  // Get category list

        $user_id = trim($this->get('user_id')); 
        $response = $this->User_model->getOrganization($user_id);
        if(empty($response))
        {
        $response = $this->User_model->errorResponse("No record found",$response);    
        }else
        {
        $response = $this->User_model->successResponse("success",$response);
        }
        $this->set_response($response, REST_Controller::HTTP_OK);
    }



    public function changePassword_post(){
        $user_id = $this->input->post('user_id');
        $old_password = ($this->input->post('old_password'));
        $new_password = ($this->input->post('new_password'));
        $response = $this->User_model->getUserDetails($user_id);
        if($response)
        {
            $email=$response->email;
            $old_password= md5($response->email."-".$old_password);
            $CheckUserPssword=$this->User_model->CheckUserPssword($old_password,$user_id);
            if($CheckUserPssword)
            {
              $newPassword= md5($response->email."-".$new_password);
              $updatePssword=$this->User_model->updatePssword($newPassword,$user_id);
              $response = $this->User_model->successResponse("Password changed successfully",$user_id);
            }else{
              $response = $this->User_model->errorResponse("Wrong old password");
            }
        }else
        {
            $response = $this->User_model->errorResponse("User not found");
        }
        $this->set_response($response, REST_Controller::HTTP_OK);
    }



    public function logout_post(){
        $myarray = [
        'unique_device_id' => $this->input->post('unique_device_id'),
        'user_id' => $this->input->post('user_id')
        ];
        $id = $this->User_model->logout($myarray);
        $response=$this->User_model->successResponse("Logged out Successfully",$this->input->post('user_id'));
        $this->set_response($response, REST_Controller::HTTP_OK);
    }






    public function getDonationStatement_get(){                                  // Get category list
        $user_id = $this->input->get('user_id');
        $from_date = $this->input->get('from_date');
        $to_date = $this->input->get('to_date');

        if(empty($user_id) or empty($from_date) or empty($to_date))
        {
        $response = $this->User_model->errorResponse("Required fields are missing");
        }else
        {

        $response['statement'] = $this->User_model->getDonationStatement($user_id,$from_date,$to_date);
        $response['pdflink']="getDonationStatementpdf?user_id=$user_id&from_date=$from_date&to_date=$to_date";

        if(empty($response['statement']))
        {
        $response = $this->User_model->errorResponse("User not found");    
        }else
        {
        $response = $this->User_model->successResponse("success",$response);
        }
        }
        $this->set_response($response, REST_Controller::HTTP_OK);
    }
public function getDonationStatementpdf_get(){                                  // Get category list

  $user_id = $this->input->get('user_id');
  $from_date = $this->input->get('from_date');
  $to_date = $this->input->get('to_date');

  if(empty($user_id) or empty($from_date) or empty($to_date))
  {
    $response = $this->User_model->errorResponse("Required fields are missing");
  }else
  {


    $this->load->library('M_pdf');

    /*to get only values between date*/
    $getresultdonation = $this->db->query(" SELECT  hb_donations.*,hb_organization.title as organizationtitle,hb_hbcu.title as hbcutitle FROM hb_donations left join  hb_organization on hb_donations.organization=hb_organization.id  left join hb_hbcu on hb_donations.hbcu=hb_hbcu.id
      WHERE  date BETWEEN '".$from_date."' AND '".$to_date."' and  user_id= '".$user_id."' and status='1' GROUP BY date")->result();


    $result = $this->db->query(" SELECT  round(SUM(amount),2) as total_amount FROM hb_donations
      WHERE  date BETWEEN '".$from_date."' AND '".$to_date."' and  user_id= '".$user_id."' and status='1'")->row();
    $countdonatedmoney = $result->total_amount ?: "0";


    $from_date = date('M-d-Y', strtotime( $from_date ));
    $to_date = date('M-d-Y', strtotime( $to_date ));


    $html="<html>
    <head>
    </head>

    <body>
      <htmlpagefooter name='myfooter'>
      <div style='border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; '>

      </div>
      </htmlpagefooter>

      <sethtmlpageheader name='myheader' value='on' show-this-page='1' />
      <sethtmlpagefooter name='myfooter' value='on' />
      <p style='text-align:center;font-size: 22pt;'>Donated to  my HBCU
      </p>

      <p style='text-align:center;font-size: 15pt;'>From ".$from_date." to ".$to_date."</p>

      ";



      /*for making according to date array*/
      $resultDonations=array();
      foreach ($getresultdonation as $key => $value) {
        $abc=array();
        $abc=$this->db->query(" SELECT  hb_donations.*,hb_organization.title as organizationtitle,hb_hbcu.title as hbcutitle FROM hb_donations left join  hb_organization on hb_donations.organization=hb_organization.id  left join hb_hbcu on hb_donations.hbcu=hb_hbcu.id
          WHERE `date`='".$value->date."' and user_id= '".$user_id."' and status='1'")->result();
        $abc1=$value->date;
        if (!empty($abc)) {
          $resultDonations[]->$abc1=$abc;

        }
      }


      $username=$this->db->query("select first_name from hb_users where id='".$user_id."' ")->result();

      $html.= "<table class='items' width='100%' style='font-size: 20pt;' cellpadding='8'>
      <thead>
        <tr>
          <tr><td>Dear ".$username[0]->first_name." you have donated a total of $ ".$countdonatedmoney."</td></tr>


        </thead>
        <tbody>
        </tbody>
      </table>"; 
      foreach ($resultDonations as $key => $value) {

        foreach ($value as $key => $value1) {
          $key= date('M-d-Y', strtotime( $key ));
          $html.= "<table class='items' width='100%' style='font-size: 15pt; border-collapse: collapse;' cellpadding='8'>
          <thead>
            <tr>
              <tr><td>".$key."</td></tr>
            </tr>

          </thead>
          <tbody>
          </tbody>
        </table>";  
        foreach ($value1 as $key => $value2) {
          $abc=$this->db->query("SELECT * from hb_hbcu where id='".$value2->hbcu."' ")->result();
          $html.= " <table  width='100%' style='font-size: 10pt; align:center;' >
          <thead>
            <tr>
              <tr >
                <td style='align:justify;'>
                  ".$abc[0]->title."</td>
                  <td  width='40%'  style='align:right;'>$".$value2->amount."
                  </td>
                </tr>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>";    

        }
      }
    }


    $html.="<p style='font-size: 15pt;'>If you have any issue with this transaction,please visit our customer support page.</p></body></html>";
    $this->m_pdf->pdf->WriteHTML($html);
    $this->m_pdf->pdf->Output('DonationStatement.pdf', 'D');    

  }
}



      public function getDonationDetails_get(){                                  // Get category list
        $user_id = $this->input->get('user_id');
        $response = $this->User_model->getDonationDetails($user_id);
        if(empty($response))
        {
          $response = $this->User_model->errorResponse("User not found");    
        }else
        {
          $response = $this->User_model->successResponse("success",$response);
        }
        $this->set_response($response, REST_Controller::HTTP_OK);

      }


      public function getTopDonors_get(){                                  // Get category list
        $sort= $this->input->get('sort');
        $user_id= $this->input->get('user_id');

        $response = $this->User_model->getTopDonors($sort,$user_id);

        if(empty($response))
        {
          $response = $this->User_model->errorResponse("no record found");    
        }else
        {
          $response = $this->User_model->successResponse("success",$response);
        }
        $this->set_response($response, REST_Controller::HTTP_OK);

      }


public function getDonations_get(){                                  // Get category list

  $sort= $this->input->get('sort');
  $user_id= $this->input->get('user_id');
  $response = $this->User_model->getDonations($sort,$user_id);

  if(empty($response))
  {
    $response = $this->User_model->errorResponse("no record found");    
  }else
  {
    $response = $this->User_model->successResponse("success",$response);
  }


  $this->set_response($response, REST_Controller::HTTP_OK);

}



public function addOtherHBCU_post(){


  $hbcu=$this->input->post('hbcu');
  $percent= $this->input->post('percent');
  $user_id=$this->input->post('user_id');


  if(empty($hbcu) OR empty($user_id) OR empty($percent))
  {
    $response= $this->User_model->errorResponse("Required fields are missing");
  }else
  {
    $response = $this->User_model->addOtherHBCU($user_id,$hbcu,$percent);
  }

  $this->set_response($response, REST_Controller::HTTP_OK);
}

public function getUserHBCU_get(){                                  // Get category list

  $user_id= $this->input->get('user_id');
  if(isset($_GET['hbcuType']) && $_GET['hbcuType']!='')
  {
    $hbcuType= $this->input->get('hbcuType');
  }else
  {
    $hbcuType= "";
  }

  $response = $this->User_model->getUserHBCU($user_id,$hbcuType);

  if(empty($response))
  {
    $response = $this->User_model->errorResponse("No hbcu found");    
  }else
  {
    $response = $this->User_model->successResponse("success",$response);
  }


  $this->set_response($response, REST_Controller::HTTP_OK);

}



public function updateHBCUDonationPercent_post(){                                  // Get category list


/*try { 
  
print("try start");   

$s = NULL;
echo $length = strlen($s);

print("try end");   
} catch (Exception $e) {
  print "something went wrong\n";
} finally {
  print "This part is always executed\n";
}
die;*/


$user_id= $this->input->post('user_id');
$id= $this->input->post('id');
$percent= $this->input->post('percent');
$hbcuType= $this->input->post('hbcuType');

$userdetails = $this->User_model->getUserDetails($user_id);


if(empty($id) or empty($percent) or $hbcuType=="" or empty($user_id))
{
  $response = $this->User_model->errorResponse("Required fields are missing");    
}elseif(empty($userdetails))
{
  $response=$this->User_model->errorResponse("User not found");
}else
{   

  $id=explode(",", $id);
  $percent=explode(",", $percent);
  $hbcuType=explode(",", $hbcuType);
  $x=0;

 // foreach ($percent as $key => $percentvalue) 
 // {
 //     if($percentvalue> 100 or $percentvalue<=0)
 //     {
 //         $response=$this->User_model->errorResponse("wrong donation percent entered");
 //         goto a;
 //     }  
 // }

        //  print_r($hbcuType);die;

  foreach ($hbcuType as $key => $hbcuTypevalue) 
  {
    if($hbcuTypevalue==0  or $hbcuTypevalue==1)
    {

    } else{
      $response=$this->User_model->errorResponse("wrong hbcu type entered");
      goto a;

    } 
  }


  foreach ($id as $key => $value) 
  {

    $myarray=""; 
    $myarray = array(
      'donation_percent'=>$percent[$x],
      'hbcuType'=>$hbcuType[$x]
      );
    $response[] = $this->User_model->updateHBCUDonationPercent($myarray,$value);  
    $x++;
  }

  a:
  $response = $this->User_model->successResponse("success",$response);

}


$this->set_response($response, REST_Controller::HTTP_OK);

}





//////////////////////////////////////////////////////////////////////////////////////////////////




function newpassword_get()
{
        // echo "string";
  $data['token'] = $this->input->get('token');
  $data['title'] = "new Password";
  $this->load->view('template/header');
  $this->load->view('template/newpassword', $data);
}


function newpin_get()
{
        // echo "string";
  $data['token'] = $this->input->get('token');
  $data['title'] = "new Pin";
  $this->load->view('template/header');
  $this->load->view('template/newpin', $data);
}

function updateNewpassword_post()
{

  $message = ['token' => $this->input->post('token') , 'password' => $this->input->post('password')];
  $this->load->library('form_validation');
  $this->form_validation->set_rules('password', 'Password', 'trim|required|md5');
  $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]|md5');
  if ($this->form_validation->run() == FALSE)
  {

    $this->session->set_flashdata('msg', '<span style="color:red">Please Enter Same Password</span>');
    redirect("api/User/newpassword?token=" . $message['token']);
  }
  else
  {

    $this->User_model->updateNewpassword($message);
  }
}


function updateNewpin_post()
{
  $pin=$this->input->post('pin');
  $length = strlen($pin);
  if ($length <= 3 or $length >= 5) {
    $this->session->set_flashdata('msg', '<span style="color:red">Please Enter 4 digit Pin</span>');
    redirect("api/User/newpin?token=" . $message['token']);
  }



  $message = ['token' => $this->input->post('token') , 'pin' => $this->input->post('pin')];

  $this->load->library('form_validation');
  $this->form_validation->set_rules('pin', 'Pin', 'trim|required|md5');
  $this->form_validation->set_rules('pinconf', 'Pin Confirmation', 'required|matches[pin]|md5');
  if ($this->form_validation->run() == FALSE)
  {

    $this->session->set_flashdata('msg', '<span style="color:red">Please Enter Same Pin</span>');
    redirect("api/User/newpin?token=" . $message['token']);
  }
  else
  {

    $this->User_model->updateNewpin($message);
  }
}








public function CroneReoccurringPaymentsMonthly_get(){

//hb_reoccurringDonations
  $d=date("d");
  if($d=="15")  
  {
    $dateTime=date("Y-m-d H:i:s");
    $date=date("Y-m-d");

                $cycle=1;// for monthly
                $ReoccurringPayments = $this->User_model->getAllReoccurringDonations($cycle);
                $donation_type=1;
                //echo "<pre>";print_r($ReoccurringPayments);die;
                
                foreach ($ReoccurringPayments as $key => $value) 
                {

                  $user_id=$value->user_id;
                  $response = $this->User_model->getUserDetails($user_id);


                  if(isset($response->organization->id))
                  {    
                    $organization=$response->organization->id;
                  }else
                  {
                    $organization=0;
                  }


                  $totalAmount=$value->amount;
                  $cycle=$value->cycle;
                  $card_id=$value->card_id;
                  $UserHBCU = $this->User_model->getUserHbcu($user_id);



                  $data=array('user_id'=>$user_id,
                    'amount'=>$totalAmount,
                    'type'=>2
                    );
                  $insert_data = $this->User_model->insert_data('hb_donationpercent',$data);



                  // print_r($UserHBCU);die;


            // foreach ($UserHBCU  as $key => $valueHBCU) 
            // {
                  $hbcu=$value->hbcu_id;
                // $donation_percent=$valueHBCU->donation_percent;
                  $UserCard = $this->User_model->getUserCard($card_id);

                  if(isset($value->stripe_customer_id) )
                  {
                   // $amount=($donation_percent*$totalAmount)/100;
                    $amount=round($totalAmount,1);
                    $customer_id=$value->stripe_customer_id;
                    $card_num=$UserCard->card_num;
                             $stripeAmount = $amount * 100;    // Since the amount charged by stripe is in cents for singapore doller, so here amount = 1 is being converted into 100 cents since actual payment will be 1 doller from front end |here| 1 doller = 100 cents:
                             $pay =  \Stripe\Charge::create(array(
                              "amount"   => $stripeAmount,
                              "currency" => "USD",
                              "customer" => $customer_id
                              ));

                             if(isset($pay->error))
                             {
                              $dd=((array)$pay->error['message']);
                              $message=($dd[0]);

                             }else
                             {
                              $message="success";
                              if(isset($pay->balance_transaction))
                              {
                                $txnId = $pay->balance_transaction;
                                $currency = $pay->currency;
                                $status=1;
                              }
                              else
                              { 
                                $currency="";
                                $txnId="";
                                $status=0;
                              }
                             } 

                             $myarray =array
                             (
                              'user_id'=>$user_id,
                              // 'card_num'=>$card_num,
                              // 'card_id'=>$card_id,
                              'hbcu'=>$hbcu,
                              'message'=>$message,
                              'currency'=>$currency,
                              'organization'=>$organization,
                              'donation_type'=>$donation_type,
                              'amount'=>$amount,
                              'status'=>$status,
                              'txnId'=>$txnId,
                              'paymentdate'=>$date,  
                              'date'=>$date,
                              'dateTime'=>$dateTime,
                              'percentage'=>$donation_percent,
                              'donation_percent_id'=>$insert_data
                              );
                             print_r($myarray);


                             $response = $this->User_model->addDonation($myarray);
                             if(!empty($response) && $txnId!="")
                             {
                              $response= $this->User_model->successResponse("Payment Successfull",$response);
                             }else
                             {
                              $response= $this->User_model->errorResponse("Something went wrong, try again after some time");
                             }
                         }else
                         {
                          $response= $this->User_model->errorResponse("stripe customer id not found","card_id".$card_id);
                         }


             // }

                  // print_r($UserHBCU);
                  # code...
                     }


                 }else
                 {
                  $response= $this->User_model->errorResponse("Today is not a monthly reoccurring day");

                 }

                 if(empty($ReoccurringPayments))
                 {
                  $response= $this->User_model->errorResponse("Not reoccurring payments found");
                 }

                 $this->set_response($response, REST_Controller::HTTP_OK);
             }


             public function CroneReoccurringPaymentsWeekly_get(){

//hb_reoccurringDonations
              $d=date("l");
    // print_r($d);die;

    // if($d=="Thursday" OR $d=="thursday" OR $d=="THURSDAY")
              if($d=="Friday" OR $d=="friday" OR $d=="FRIDAY")
              {
                $dateTime=date("Y-m-d H:i:s");
                $date=date("Y-m-d");

                $cycle=0;// for weekly
                $ReoccurringPayments = $this->User_model->getAllReoccurringDonations($cycle);
                $donation_type=1;
                // echo "<pre>";print_r($ReoccurringPayments);die;
                
                foreach ($ReoccurringPayments as $key => $value) 
                {

                  $user_id=$value->user_id;
                  $response = $this->User_model->getUserDetails($user_id);


                  if(isset($response->organization->id))
                  {    
                    $organization=$response->organization->id;
                  }else
                  {
                    $organization=0;
                  }


                  $totalAmount=$value->amount;
                  $cycle=$value->cycle;
                  $card_id=$value->card_id;

                  $UserHBCU = $this->User_model->getUserHbcu($user_id);

                  // print_r($UserHBCU);die;

                  $data=array('user_id'=>$user_id,
                    'amount'=>$totalAmount,
                    'type'=>2
                    );
                  $insert_data = $this->User_model->insert_data('hb_donationpercent',$data);




            // foreach ($UserHBCU  as $key => $valueHBCU) 
            // {
                  $hbcu=$value->hbcu_id;
                // $donation_percent=$valueHBCU->donation_percent;
                  $UserCard = $this->User_model->getUserCard($card_id);

                  if(isset($value->stripe_customer_id) && $value->stripe_customer_id!="")
                  {
                   // $amount=($donation_percent*$totalAmount)/100;
                    $amount=round($totalAmount,1);
                    $customer_id=$value->stripe_customer_id;
                    $card_num=$UserCard->card_num;
                             $stripeAmount = $amount * 100;    // Since the amount charged by stripe is in cents for singapore doller, so here amount = 1 is being converted into 100 cents since actual payment will be 1 doller from front end |here| 1 doller = 100 cents:
                             $pay =  \Stripe\Charge::create(array(
                              "amount"   => $stripeAmount,
                              "currency" => "USD",
                              "customer" => $customer_id
                              ));
                             

                             if(isset($pay->error))
                             {
                              $dd=((array)$pay->error['message']);
                              $message=($dd[0]);

                             }else
                             {  
                              $message="success";                              
                              if(isset($pay->balance_transaction))
                              {
                                $txnId = $pay->balance_transaction;
                                $currency = $pay->currency;
                                $status=1;
                              }else
                              { 
                                $currency="";
                                $txnId="";
                                $status=0;
                              }
                             } 

                             $myarray =array
                             (
                              'user_id'=>$user_id,
                              // 'card_num'=>$card_num,
                              // 'card_id'=>$card_id,
                              'hbcu'=>$hbcu,
                              'message'=>$message,
                              'currency'=>$currency,
                              'organization'=>$organization,
                              'donation_type'=>$donation_type,
                              'amount'=>$amount,
                              'status'=>$status,
                              'txnId'=>$txnId,
                              'paymentdate'=>$date,  
                              'date'=>$date,
                              'dateTime'=>$dateTime,
                              'percentage'=>$donation_percent,
                              'donation_percent_id'=>$insert_data
                              );
                             print_r($myarray);
                             $response = $this->User_model->addDonation($myarray);
                             if(!empty($response) && $txnId!="")
                             {
                              $response= $this->User_model->successResponse("Payment Successfull",$response);
                             }else
                             {
                              $response= $this->User_model->errorResponse("Something went wrong, try again after some time");
                             }
                         }else
                         {
                          $response= $this->User_model->errorResponse("stripe customer id not found","card_id".$card_id);
                         }
                     }
                 }else
                 {
                  $response= $this->User_model->errorResponse("Today is not a monthly reoccurring day");

                 }

                 if(empty($ReoccurringPayments))
                 {
                  $response= $this->User_model->errorResponse("Not reoccurring payments found");
                 }

                 $this->set_response($response, REST_Controller::HTTP_OK);
             }





             function generateRandomString($length = 4) {
              $characters = '0123456789';
              $charactersLength = strlen($characters);
              $randomString = '';
              for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
              }
              return $randomString;
             }






             function file_upload($upload_path, $image) {

              $baseurl = base_url();
              $config['upload_path'] = $upload_path;
              $config['allowed_types'] = 'gif|jpg|png|jpeg';
              $config['max_size'] = '10000';
              $config['max_width'] = '5024';
              $config['max_height'] = '5068';
              $this->load->library('upload', $config);
              if (!$this->upload->do_upload($image))
              {
                $error = array(
                  'error' => $this->upload->display_errors()
                  );
                print_r($error);die;

                return $imagename = "";
              }
              else
              {
                $detail = $this->upload->data();
                return $imagename = $upload_path .'/'. $detail['file_name'];
              }
             }



             public function enterPin_post()
             {
              $user_id = $this->input->post('user_id');
              $pin = md5($this->input->post('pin'));
              if (empty($user_id)  OR empty($pin)) {
                $response= $this->User_model->errorResponse("Required fields are missing");
              }
              else
              {
                $selectData = $this->User_model->select_data('*','hb_users',array('id'=>$user_id,'pin'=>$pin));
                if($selectData)
                {
                  $response['pin']=$selectData[0]->pin;
                  if (empty($selectData[0]->plaid_access_token) ||  empty($selectData[0]->account_ids)) {
                    $response['plaid_access_token']=0;
                  }
                  else{
                    $response['plaid_access_token']=1;

                  }
                  $response= $this->User_model->successResponse("User Pin", $response);
                }else
                {
                  $response= $this->User_model->errorResponse("Wrong pin entered");
                }
              }
              $this->set_response($response, REST_Controller::HTTP_OK);

             }

             public function changePin_post()
             {
              $user_id = $this->input->post('user_id');
              $pin = md5($this->input->post('pin'));

              if(empty($user_id) OR empty($pin))
              {
                $response= $this->User_model->errorResponse("Required fields are missing");
              }
              else
              {
                $data = $this->User_model->update_data('hb_users',array('pin'=>$pin),array('id'=>$user_id));
                $response= $this->User_model->successResponse("Pin updated successfully", $data);
              }
              $this->set_response($response, REST_Controller::HTTP_OK);

             }

             public function forgotPin_post()
             {

              $user_id = $this->input->post('user_id');
              $email = $this->input->post('email');
              if(empty($user_id) OR empty($email))
              {
                $response= $this->User_model->errorResponse("Required fields are missing");

              }else
              {


                $result = $this->User_model->forgotpin($email,$user_id);

                if ($result == 0)
                {
                  $response= $this->User_model->errorResponse("User does not exist");

                } else {

                  $body = "<!DOCTYPE html>
                  <head>
                    <meta content=text/html; charset=utf-8 http-equiv=Content-Type />
                    <title>Forgot Pin</title>
                    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
                  </head>
                  <body>
                    <table width=60% border=0 bgcolor=#53CBE6 style=margin:0 auto; float:none;font-family: 'Open Sans', sans-serif; padding:0 0 10px 0;>
                      <tr>
                        <th width=20px></th>
                        <th width=20px  style=padding-top:30px;padding-bottom:30px;><img height='250' width='180' src=".base_url()."Public/img/ic_logo.png></th>
                        <th width=20px></th>
                      </tr>
                      <tr>
                        <td width=20px></td>
                        <td bgcolor=#fff style=border-radius:10px;padding:20px;>
                          <table width=100%;>
                            <tr>
                              <th style=font-size:20px; font-weight:bolder; text-align:right;padding-bottom:10px;border-bottom:solid 1px #ddd;> Hello " . $result['first_name'] . "</th>
                            </tr>

                            <tr>
                              <td style=font-size:16px;>
                                <p> You have requested 4 Digit Pin retrieval for your user account at HBCU.To complete the process, click the link below.</p>
                                <p><a href=" . site_url('api/User/newpin?token=' . $result['token']) . ">Change Pin</a></p>
                              </td>
                            </tr>


                            <tr>
                              <td style=text-align:center; padding:20px;>
                                <h2 style=margin-top:50px; font-size:29px;>Best Regards,</h2>
                                <h3 style=margin:0; font-weight:100;>Customer Support</h3>
                                <h3 style=margin:0; font-weight:100;><img height='150' width='100' src=".base_url()."Public/img/ic_logo.png></h3>
                              </td>
                            </tr>
                          </table>
                        </td>
                        <td width=20px></td>
                      </tr>
                      <tr>
                        <td width=20px></td>
                        <td style=text-align:center; color:#fff; padding:10px;> Copyright © HBCU All Rights Reserved</td>
                        <td width=20px></td>
                      </tr>
                    </table>
                  </body>";

                  $this->email->set_newline("\r\n");
                  $this->email->from('osvinandroid@gmail.com', 'HBCU');
                  $this->email->to($email);
                  $this->email->subject('Forgot Pin');
                  $this->email->message($body);
                  $this->email->send();

                  $response= $this->User_model->successResponse("Check you mail",$email);
                }

              }

              $this->set_response($response, REST_Controller::HTTP_OK);





             }

             public function linkedcards_post()
             {
              $user_id = $this->input->post('user_id');

              if(empty($user_id))
              {
                $response= $this->User_model->errorResponse("Required fields are missing");

              }
              else
              {
                $response = $this->User_model->select_data('*','hb_cards',array('user_id'=>$user_id));
                $response= $this->User_model->successResponse("User Cards", $response);
              }
              $this->set_response($response, REST_Controller::HTTP_OK);
             }


             public function pausedonations_post()
             {
              $user_id = $this->input->post('user_id');
              $spare_change = $this->input->post('spare_change');
              $reoccurring = $this->input->post('reoccurring');

              $data=array(
                'user_id'=>$user_id,
                'isActive'=>$reoccurring
                );

              if(empty($user_id) OR $spare_change == "" OR $reoccurring == "")
              {
                $response= $this->User_model->errorResponse("Required fields are missing");
              }
              else
              {
                $update_data = $this->User_model->update_data('hb_users',array('isActivereoccuring'=>$reoccurring),array('id'=>$user_id));

                $update_data1 = $this->User_model->update_data('hb_users',array('isActivesparechange'=>$spare_change),array('id'=>$user_id));

                $response= $this->User_model->successResponse("Pause donations updated successfully", $update_data);

              }

              $this->set_response($response, REST_Controller::HTTP_OK);
             }



             public function pushNotifications_post()
             {
              $user_id = $this->input->post('user_id');
              $status  = $this->input->post('status');
              $data=array(
                'user_id'=>$user_id,
                'status'=>$status
                );

              if(empty($user_id) OR $status == "")
              {
                $response= $this->User_model->errorResponse("Required fields are missing");

              }
              else
              {
                $select_data = $this->User_model->select_data('*','hb_notifications',array('user_id'=>$user_id));
                if (empty($select_data)) {
                  $insert_data = $this->User_model->insert_data('hb_notifications',$data);
                  $response = $this->User_model->successResponse("Notification status inserted successfully", $insert_data);

                }
                else
                {
                  $update_data = $this->User_model->update_data('hb_notifications',array('status'=>$status),array('user_id'=>$user_id));
                  $response = $this->User_model->successResponse("Notification status updated successfully", $update_data);
                }

              }
              $this->set_response($response, REST_Controller::HTTP_OK);
             }



             public function insertunapproved_post(){
              $user_id = $this->input->post('user_id');
              $amount = $this->input->post('amount');
              $txnId=$this->input->post('txnId');
              $place_name=$this->input->post('place_name');
              $account_id=$this->input->post('account_id');
              $type=$this->input->post('type');
              $spareid = $this->input->post('spareid');
              $total_amount=$this->input->post('total_amount');

              if ($type==1) {
                $data=array('user_id'=>$user_id,
                  'amount'=>$amount,
                  'transaction_id'=>$txnId,
                  'name'=>$place_name,
                  'account_id'=>$account_id,
                  'total_amount'=>$total_amount,
                  'date'=>date('Y-m-d'),
                  'dateTime'=>date('Y-m-d H:i:s')
                  );
                $insert_data = $this->User_model->insert_data('hb_spareChangeDonations',$data);
                $response = $this->User_model->successResponse("amount inserted successfully", $insert_data);
              }
              elseif($type==2){
                if (!empty($spareid)) {
                  $update_data = $this->User_model->update_data('hb_spareChangeDonations',array('status'=>1),array('id'=>$spareid));
                  $response = $this->User_model->successResponse("sparechange updated successfully", $insert_data);
                }
                else{
                  $data=array('user_id'=>$user_id,
                    'amount'=>$amount,
                    'transaction_id'=>$txnId,
                    'name'=>$place_name,
                    'account_id'=>$account_id,
                    'status'=>1,
                    'total_amount'=>$total_amount,
                    'date'=>date('Y-m-d'),
                    'dateTime'=>date('Y-m-d H:i:s')
                    );
                  $insert_data = $this->User_model->insert_data('hb_spareChangeDonations',$data);
                  $response = $this->User_model->successResponse("amount inserted successfully", $insert_data);
                }

              }
              $this->set_response($response, REST_Controller::HTTP_OK);
             }



             public function listSparechange_post(){

              $userid=$this->input->post('user_id');
              $type=$this->input->post('type');
              /*type 1 for unapproved request*/
              if ($type==1) {
                $selectsparedata = $this->User_model->select_data('*','hb_spareChangeDonations',array('user_id'=>$user_id,'status'=>0));
              }
              /*type 2 for approved request*/
              elseif ($type==2) {
                $selectsparedata = $this->User_model->select_data('*','hb_spareChangeDonations',array('user_id'=>$user_id,'status'=>1));
              }
              $response = $this->User_model->successResponse("Your data shows sucessfully", $selectsparedata);
              $this->set_response($response, REST_Controller::HTTP_OK);
             }

          public function plaidtransaction_post(){
              function custom_sort($a,$b) {
                return strtotime($b->date)>strtotime($a->date);
              }

              $user_id=$this->input->post('user_id');
              $page=$this->input->post('page');
              $type=$this->input->post('type');

              if (!empty($type)) {
                if ($type==1) {
                  $UserDetails = $this->User_model->getUserDetails($user_id);
                        $account_ids=$UserDetails->account_ids;
                  $access_token=$UserDetails->plaid_access_token;
                  if(!empty($access_token))
                  {
                    $date=date('Y-m-d');
                    $date1 = date('Y-m-d', strtotime($date . ' -30 days'));

                    $vars = array(
                      'client_id'=>'596cd0c14e95b810ac887df6',
                      'secret'=>'36ca7ae963c88b05111f1246a5df69',
                      'access_token'=>$access_token,
                      "start_date"=> $date1,
                      "end_date"=> $date,
                      );
                    $aa=json_encode($vars);
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,"https://sandbox.plaid.com/transactions/get?account_name=Plaid%20Savings");
                    curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$aa);  //Post Fields
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $headers = [
                'Content-Type: application/json'
                ];
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $server_output = curl_exec ($ch);
                curl_close ($ch);
                $arr=json_decode($server_output);
                // print_r($arr);die;

                $abc['all']=array();
                foreach ($arr->transactions as $key => $value) {
                  $checkfloat= is_float($value->amount);
                  $arr=$this->db->query("SELECT * from hb_spareChangeDonations where user_id='".$user_id."' and account_id='".$value->account_id."'")->result();
                  // $query=$this->db->query("SELECT  * from hb_spareChangeDonations where  donation_status='2' and  transaction_id='".$value->transaction_id."' and user_id='".$user_id."' and account_id='".$value->account_id."'")->result();
                  if(($checkfloat == 1 && $value->amount >0 && $value->account_id==$account_ids)){
                    unset($key);
                    $abc['all'][]=$value;
                  }
                }


                foreach ($abc['all'] as $key => $value) {
                  $query=$this->db->query("SELECT  * from hb_spareChangeDonations where transaction_id='".$value->transaction_id."' and user_id='".$user_id."' ")->result();
                  if (!empty($query)) {
                    $abc['all'][$key]->status=$query[0]->status;
                    $abc['all'][$key]->id=$query[0]->id;
                  }
                  else{
                    $abc['all'][$key]->status='2';
                    $abc['all'][$key]->id='';
                  }
                }
                $add=count($abc['all']);
                $abc['no_of_transaction']=$add;
                $abc['all'] = array_slice( $abc['all'], $page, 10 ); 

            }
            else{
              $errror= "access token empty";
              $response= $this->User_model->errorResponse($errror);
            }

        }
        elseif ($type==2) {

          $UserDetails = $this->User_model->getUserDetails($user_id);
            $account_ids=$UserDetails->account_ids;
          $access_token=$UserDetails->plaid_access_token;
          $date=($UserDetails->created);
          $date1 = date('Y-m-d', strtotime($date . ' -30 days'));
          $enddate = date('Y-m-d', strtotime($date));


          $vars = array(
            'client_id'=>'596cd0c14e95b810ac887df6',
            'secret'=>'36ca7ae963c88b05111f1246a5df69',
            'access_token'=>$access_token,
            "start_date"=> $date1,
            "end_date"=> $enddate,
          );

          $aa=json_encode($vars);
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL,"https://sandbox.plaid.com/transactions/get");
          curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$aa);  //Post Fields
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $headers = [
                'Content-Type: application/json'
                ];
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $server_output = curl_exec ($ch);
                curl_close ($ch);
                // print_r($server_output);die;
                $arr=json_decode($server_output);
                $aaa=array();
                foreach ($arr->transactions as $key => $value) {
                  $checkfloat= is_float($value->amount);
                  $query=$this->db->query("SELECT  * from hb_spareChangeDonations where   donation_status=1 and  transaction_id='".$value->transaction_id."' and user_id='".$user_id."' and account_id='".$value->account_id."'")->result();
                  if(($checkfloat == 1 && $value->amount >0)&& empty($query) && $value->account_id==$account_ids && DATE($UserDetails->created) > $value->date ){
                    unset($key);
                    $aaa[]=$value;
                  }
                }

                foreach ($aaa as $key => $value) {
                  $amount1=$value->amount;
                  $amount2=floor($value->amount);

                  $amount=$amount1-$amount2;
                  $data=array('user_id'=>$user_id,
                    'amount'=>$amount,
                    'transaction_id'=>$value->transaction_id,
                    'name'=>$value->name,
                    'account_id'=>$value->account_id,
                    'total_amount'=>$value->amount,
                    'date'=>$value->date,
                    'status'=>0,
                    'dateTime'=>date('Y-m-d H:i:s')
                    );
                  $insert_data = $this->User_model->insert_data('hb_spareChangeDonations',$data);
                }

                $abc['unapproved'] = $this->User_model->select_data('*','hb_spareChangeDonations',array('user_id'=>$user_id,'status'=>0,'donation_status'=>1));
                $add=count($abc['unapproved']);
                foreach ($abc['unapproved'] as $key => $value) {
                  unset($key['total_amount']);
                  $abc['unapproved'][$key]->amount=$value->total_amount;
                }
                usort($abc['unapproved'], "custom_sort");
                $abc['no_of_transaction']=$add;
                $abc['unapproved'] = array_slice( $abc['unapproved'], $page, 10 ); 

            }
            elseif ($type==3) {


              $UserDetails = $this->User_model->getUserDetails($user_id);
              $access_token=$UserDetails->plaid_access_token;
                $account_ids=$UserDetails->account_ids;
              $date=date('Y-m-d');
              $enddate=date('Y-m-d', strtotime($UserDetails->created));
              $date1 = date('Y-m-d', strtotime($date . ' -30 days'));

              $vars = array(
                'client_id'=>'596cd0c14e95b810ac887df6',
                'secret'=>'36ca7ae963c88b05111f1246a5df69',
                'access_token'=>$access_token,
                "start_date"=> $enddate,
                "end_date"=> $date,
                );
              $aa=json_encode($vars);
              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL,"https://sandbox.plaid.com/transactions/get");
              curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$aa);  //Post Fields
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $headers = [
                'Content-Type: application/json'
                ];
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $server_output = curl_exec ($ch);
                curl_close ($ch);
                $arr=json_decode($server_output);

                $aaa=array();
                foreach ($arr->transactions as $key => $value) {
                  $checkfloat= is_float($value->amount);

                  $query=$this->db->query("SELECT  * from hb_spareChangeDonations where    transaction_id='".$value->transaction_id."' and user_id='".$user_id."' and account_id='".$value->account_id."'")->result();
                  if(($checkfloat == 1 && $value->amount >0)&& empty($query) && ($value->account_id==$account_ids) && DATE($UserDetails->created) < $value->date && $UserDetails->isActivesparechange==1){
                    unset($key);
                    $aaa[]=$value;
                  }
                }
                
                foreach ($aaa as $key => $value) {
                  $amount1=$value->amount;
                  $amount2=floor($value->amount);
                  $fraction=$amount1-$amount2;
                  $amount=1-$fraction;
                  $data=array('user_id'=>$user_id,
                    'amount'=>$amount,
                    'transaction_id'=>$value->transaction_id,
                    'name'=>$value->name,
                    'account_id'=>$value->account_id,
                    'total_amount'=>$value->amount,
                    'date'=>$value->date,
                    'status'=>1,
                    'dateTime'=>date('Y-m-d H:i:s')
                    );
                  $insert_data = $this->User_model->insert_data('hb_spareChangeDonations',$data);
                }

                $abc['approved'] = $this->User_model->select_data('*','hb_spareChangeDonations',array('user_id'=>$user_id,'status'=>1));
                $add=count($abc['approved']);
                foreach ($abc['approved'] as $key => $value) {
                  unset($key['total_amount']);
                  $abc['approved'][$key]->amount=$value->total_amount;
                }
                usort($abc['approved'], "custom_sort");

                $abc['no_of_transaction']=$add;
                $abc['approved'] = array_slice( $abc['approved'], $page, 10 ); 
            }
            $add = $this->db->query(" SELECT SUM(amount) as total_amount FROM hb_donations where user_id='".$user_id."' and status='1' and donation_type='0'")->row();
            if (empty($add->total_amount)) {
              $abc['totaldonated']=0;  
            }
            else{
              $abc['totaldonated']=($add->total_amount);
            }
            $abc['tilldonate'] = $this->db->query(" SELECT id ,(SELECT round(SUM(hb_spareChangeDonations.amount),2) as todonate_amount from hb_spareChangeDonations where user_id='".$user_id."' and status='1' and donation_status='1') as todonateamount  FROM hb_spareChangeDonations where user_id='".$user_id."' and status='1' and donation_status='1'  ")->result();

            $response = $this->User_model->successResponse("success",$abc);
        }
        else{
          $response= $this->User_model->errorResponse("Something went wrong, try again after some time");
        }
        $this->set_response($response, REST_Controller::HTTP_OK); 
    }
    public function donateSpare_post(){
        $user_id=$this->input->post('user_id');
        $amount=$this->input->post('amount');
        $card_id=$this->input->post('card_id');
        $ids=$this->input->post('approved_id');
        $abc=explode(',', $ids);


        $date=date('Y-m-d');
        $dateTime=date('Y-m-d H:i:s');



        $activestatus  = $this->User_model->select_data('*','hb_users',array('id'=>$user_id));
        if ($activestatus[0]->isActivesparechange==1) {
            $check_card = $this->User_model->getUserCard($card_id);
            if(empty($check_card)){
                $response=$this->User_model->errorResponse("Card not found");
                }else{
                    $UserHBCU = $this->User_model->checkUserHBCU($user_id);
                    // print_r($UserHBCU);
                    // $UserHBCU11 = $this->User_model->checkUserHBCUpercent($user_id);
                    // print_r($UserHBCU11);die;

                    if (empty($UserHBCU)) {
                        $response=$this->User_model->errorResponse("HBCU not found");
                    }
                    else{
                        $UserHBCU11 = $this->User_model->checkUserHBCUpercent($user_id);
                        if (empty($UserHBCU11)) {
                            $response=$this->User_model->errorResponse("HBCU percentage not defined");
                        }
                        else{
                            foreach ($abc as $key => $value) {
                            $update_data = $this->User_model->update_data('hb_spareChangeDonations',array('donation_status'=>2),array('id'=>$value));
                            }
                            $data=array('user_id'=>$user_id,
                            'amount'=>$amount,
                            'type'=>1
                            );
                            $insert_data = $this->User_model->insert_data('hb_donationpercent',$data);
                            $customer_id=$activestatus[0]->stripe_customer_id;
                            $stripeAmount = $amount * 100;    // Since the amount charged by stripe is in cents for singapore doller, so here amount = 1 is being converted into 100 cents since actual payment will be 1 doller from front end |here| 1 doller = 100 cents:

                            $pay =  \Stripe\Charge::create(array(
                            "amount"   => $stripeAmount,
                            "currency" => "USD",
                            "customer" => $customer_id
                            ));
                            foreach ($UserHBCU  as $key => $valueHBCU){
                                if ($valueHBCU->donation_percent>0) {
                                    $hbcu=$valueHBCU->hbcu;
                                    $donation_percent=$valueHBCU->donation_percent;
                                    $amount1=round(($donation_percent*$amount)/100,2);
                                    $amount2=($amount1);
                                    $customer_id=$activestatus[0]->stripe_customer_id;
                                    if(isset($pay->error))
                                    {
                                        $dd=((array)$pay->error['message']);
                                        $message=($dd[0]);
                                    }else
                                    {
                                        $message="success";
                                        if(isset($pay->balance_transaction))
                                        {
                                            $txnId = $pay->balance_transaction;
                                            $currency = $pay->currency;
                                            $status=1;
                                        }else
                                        {
                                            $currency="";
                                            $txnId="";
                                            $status=0;
                                        }
                                    }
                                    $myarray =array
                                    (
                                    'user_id'=>$user_id,
                                    'card_num'=>"stripe",
                                    'card_id'=>"stripe",
                                    'hbcu'=>$hbcu,
                                    'message'=>$message,
                                    'currency'=>$currency,
                                    'donation_type'=>'0',
                                    'amount'=>$amount2,
                                    'status'=>$status,
                                    'txnId'=>$txnId,
                                    'paymentdate'=>$date,
                                    'date'=>$date,
                                    'dateTime'=>$dateTime,
                                    'percentage'=>$donation_percent,
                                    'donation_percent_id'=>$insert_data
                                    );
                                    $response = $this->User_model->addDonation($myarray);
                                    if($response){
                                        $response= $this->User_model->successResponse("Payment Successfull",$response);
                                    }else{
                                        $response= $this->User_model->errorResponse("Something went wrong, try again after some time");
                                    }
                                }
                            }
                        }

                    }
            }
        }
        else{
            $response= $this->User_model->errorResponse("Your spare change is inactive");
        }
        $this->set_response($response, REST_Controller::HTTP_OK); 
    }

    public function activeSparechnage_post(){
        $user_id=$this->input->post('user_id');
        $status=$this->input->post('status');
        $update_data = $this->User_model->update_data('hb_users',array('isActivesparechange'=>$status),array('id'=>$user_id));
        if($response){
            $response= $this->User_model->successResponse("Spare change status activated sucessfully",$response);
        }else{
            $response= $this->User_model->errorResponse("Something went wrong");
        }
        $this->set_response($response, REST_Controller::HTTP_OK);
    }

    public function getDonationstatusDetail_post(){
        $user_id=$this->input->post('user_id');
        $UserDetails = $this->User_model->getUserDetails($user_id);
        $ins_id=$UserDetails->plaid_ins_id;
        $vars = array(
        'public_key'=>'c74afb41cee71cd888636cc90426fb',
        "institution_id"=> $ins_id,
        "options"=> [
        "include_display_data"=> true
        ]
        );
        $aa=json_encode($vars);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://sandbox.plaid.com/institutions/get_by_id");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$aa);  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = [
        'Content-Type: application/json'
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        $response['bankdetail']=json_decode($server_output);
        $activestatus  = $this->User_model->select_data('isActivesparechange','hb_users',array('id'=>$user_id));
        $response['activestatus']=$activestatus[0]->isActivesparechange;
        if($response){
            $response= $this->User_model->successResponse("your data shows sucessfully",$response);
        }else{
            $response= $this->User_model->errorResponse("Something went wrong");
        }
        $this->set_response($response, REST_Controller::HTTP_OK); 
    }
    public function feedback_post(){
        $array=array(
        'user_id'=>$this->input->post('user_id'),
        'rating'=>$this->input->post('rating'),
        'comment'=>$this->input->post('comment'),
        'subject'=>$this->input->post('subject'),
        'created'=>date('Y-m-d H:i:s'),
        );

        $Response = $this->User_model->insert_data('hb_feedback',$array); 
        if($Response){
            $Response= $this->User_model->successResponse("your feedback submitted sucessfully",$Response);
        }else{
            $Response= $this->User_model->errorResponse("Something went wrong");
        }
        $this->set_response($Response, REST_Controller::HTTP_OK); 
    }
    public function CronspareChange_get(){
        /*get all user of signup level 5 and user_type 0 and isActivaesdparechange 1*/
        $ReoccurringPayments  = $this->User_model->select_data('*','hb_users',array('isActivesparechange'=>1,'user_type'=>0,'signup_level'=>5));
        $date=date('Y-m-d');
        $dateTime=date('Y-m-d H:i:s');
        $count=array();
        $sd=array();
        foreach ($ReoccurringPayments as $key => $value) {
            $count=$this->db->query("SELECT * from hb_spareChangeDonations where user_id='".$value->id."' and donation_status=1 and status=1 ")->result();
            $card=$this->db->query("SELECT * from hb_stripecustomerdetails where user_id='".$value->id."' and is_default=1")->result();
            if (empty($card)) {
                $card=$this->db->query("SELECT * from hb_stripecustomerdetails where user_id='".$value->id."'")->result();
            }
            $ReoccurringPayments[$key]->count=$count;
            $ReoccurringPayments[$key]->card=$card;
            $count1=$this->db->query("SELECT round(sum(amount),2) as sum from hb_spareChangeDonations where user_id='".$value->id."' and donation_status=1 and status=1 ")->row();
            $ReoccurringPayments[$key]->sum=$count1->sum;
            foreach ($ReoccurringPayments[$key]->count as $key1 => $value1) {
                $ReoccurringPayments[$key]->aa[]=$value1->id;
            }
            $ReoccurringPayments[$key]->aav=implode(',',$ReoccurringPayments[$key]->aa);
        }

        /*get user having amount of  greater then 5 start */
        $alluser=array();
        foreach ($ReoccurringPayments as $key => $value) {
            if ($value->sum>=5) {
                $alluser[]=$value;
            }
        }
        /*get user having amount of  greater then 5 end */

        foreach ($alluser as $key => $value){
            $user_id=$value->id;
            /*user all hbcu*/
            $UserHBCU = $this->User_model->checkUserHBCU($user_id);
            /*user detail get*/
            $response = $this->User_model->getUserDetails($user_id);
            if(isset($response->organization->id)){    
                $organization=$response->organization->id;
            }else{
                $organization=0;
            }
            print_r($UserHBCU);
            if (empty($UserHBCU)) {
                echo "hbcu not defined";
                $response=$this->User_model->errorResponse("HBCU not found");
            }
            else{
                $UserHBCU11 = $this->User_model->checkUserHBCUpercent($value->id);
                if (empty($UserHBCU11)) {
                    echo "hbcu percentage not defined";
                    $response=$this->User_model->errorResponse("HBCU percentage not defined");
                }
                else{
                    $newids=$value->aav;
                    $cusid=$value->stripe_customer_id;
                    $card_num=$value->card[0]->card_num;
                    $card_id=$value->card[0]->id;
                    $amount=round($value->sum,2); 

                    $stripeAmount = $amount * 100; 
                    $customer_id='cus_CkBCTQ3bPOiu3o';

                    $pay =  \Stripe\Charge::create(array(
                        "amount"   => $stripeAmount,
                        "currency" => "USD",
                        "customer" => $customer_id
                        ));
                    print_r($pay);
                    if(isset($pay->error))
                    {
                        $dd=((array)$pay->error['message']);
                        $message=($dd[0]);
                        break;
                    }
                    $message="success";
                    if(isset($pay->balance_transaction))
                    {
                        $txnId = $pay->balance_transaction;
                        $currency = $pay->currency;
                        $status=1;
                    }
                    else
                    { 
                        $currency="";
                        $txnId="";
                        $status=0;
                    }
                    $user_id=$value->id;
                    foreach ($UserHBCU  as $key => $valueHBCU){
                        $donation_percent=$valueHBCU->donation_percent;
                        $hbcu=$valueHBCU->hbcu;
                        $amount1=($donation_percent*$amount)/100;
                        $amount2=round($amount1,2);
                        $abc=explode(',', $newids);
                        $customer_id=$cusid;
                        $stripeAmount = $amount2 * 100; 
                        print_r($stripeAmount);  
                        echo "stripe amount";
                        $myarray =array
                        (
                        'user_id'=>$user_id,
                        // 'card_num'=>$card_num,
                        // 'card_id'=>$card_id,
                        'message'=>$message,
                        'currency'=>$currency,
                        'organization'=>$organization,
                        'amount'=>$amount2,
                        'status'=>$status,
                        'txnId'=>$txnId,
                        'hbcu'=>$hbcu,
                        'paymentdate'=>$date,  
                        'date'=>$date,
                        'dateTime'=>$dateTime,
                        'percentage'=>$donation_percent
                        );
                        $response = $this->User_model->addDonation($myarray);
                    }

                    $checkreferal1  = $this->User_model->select_data('*','hb_users',array('id'=>$user_id));
                    if ($checkreferal1[0]->pushNotifications==0) {
                        $checklogin=$this->User_model->select_data('*','hb_login',array('user_id'=>$checkreferal1[0]->id,'status'=>1));
                        foreach ($checklogin as $key => $value) {
                            $pushData['message'] = "Your donation of ".$amount." is sucess ";
                            $pushData['action'] = "donation";
                            $pushData['token'] = $value->token_id;
                            if($value->login_via == 1){
                                $this->User_model->iosPush($pushData);
                            }else if($value->login_via == 0){
                                $this->User_model->androidPush($pushData);
                            }
                        }
                    }
                    foreach ($abc as $key => $value) {
                        $update_data = $this->User_model->update_data('hb_spareChangeDonations',array('donation_status'=>2),array('id'=>$value));
                    }
                }
            }
        }
        $this->set_response($response, REST_Controller::HTTP_OK);
    }


    public function unapprovedCron_GET(){
        $UserDetails = $this->db->query("SELECT * from  hb_users where user_type=0 and active_status =0")->result();
        foreach ($UserDetails as $key => $value1) {
            if ($value1->plaid_access_token) {
                $account_ids=$value1->account_ids;
                $access_token=$value1->plaid_access_token;
                $date=($value1->created);
                $date1 = date('Y-m-d', strtotime($date . ' -30 days'));
                $enddate = date('Y-m-d', strtotime($date));

                $vars = array(
                'client_id'=>'596cd0c14e95b810ac887df6',
                'secret'=>'36ca7ae963c88b05111f1246a5df69',
                'access_token'=>$access_token,
                "start_date"=> $date1,
                "end_date"=> $enddate,
                );
                $aa=json_encode($vars);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,"https://sandbox.plaid.com/transactions/get");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$aa);  //Post Fields
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $headers = [
                'Content-Type: application/json'
                ];
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $server_output = curl_exec ($ch);
                curl_close ($ch);

                $arr=json_decode($server_output);
                $aaa=array();
                foreach ($arr->transactions as $key => $value) {
                    $checkfloat= is_float($value->amount);
                    $query=$this->db->query("SELECT  * from hb_spareChangeDonations where  (donation_status='2' or donation_status='1') and  transaction_id='".$value->transaction_id."' and user_id='".$value1->id."' and account_id='".$value->account_id."'")->result();
                    if(($checkfloat == 1 && $value->amount >0)&& empty($query) && ($value->account_id==$account_ids) && DATE($value1->created) > $value->date ){
                        unset($key);
                        $aaa[]=$value;
                    }
                }

                foreach ($aaa as $key => $value) {
                    $amount1=$value->amount;
                    $amount2=floor($value->amount);
                    $fraction=$amount1-$amount2;
                    $amount=1-$fraction;

                    $data=array('user_id'=>$value1->id,
                    'amount'=>$amount,
                    'transaction_id'=>$value->transaction_id,
                    'name'=>$value->name,
                    'account_id'=>$value->account_id,
                    'total_amount'=>$value->amount,
                    'date'=>$value->date,
                    'status'=>0,
                    'dateTime'=>date('Y-m-d H:i:s')
                    );
                    $insert_data = $this->User_model->insert_data('hb_spareChangeDonations',$data);
                }
            }        
        }
        /*another cron job*/
        $UserDetails = $this->db->query("SELECT * from  hb_users where user_type=0 and active_status =0 and isActivesparechange=0")->result();
        print_r($UserDetails);
        foreach ($UserDetails as $key => $value1) {
            if ($value1->plaid_access_token) {
                $account_ids=$value1->account_ids;
                $access_token=$value1->plaid_access_token;
                $date=($value1->created);
                $date1 = date('Y-m-d', strtotime($date ));
                $enddate = date('Y-m-d');

                $vars = array(
                'client_id'=>'596cd0c14e95b810ac887df6',
                'secret'=>'36ca7ae963c88b05111f1246a5df69',
                'access_token'=>$access_token,
                "start_date"=> $date1,
                "end_date"=> $enddate,
                );
                $aa=json_encode($vars);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,"https://sandbox.plaid.com/transactions/get");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$aa);  //Post Fields
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $headers = [
                'Content-Type: application/json'
                ];
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $server_output = curl_exec ($ch);
                curl_close ($ch);

                $arr=json_decode($server_output);
                print_r($arr);
                $aaa=array();
                foreach ($arr->transactions as $key => $value) {
                    $checkfloat= is_float($value->amount);
                    $query=$this->db->query("SELECT  * from hb_spareChangeDonations where  (donation_status='2' or donation_status='1') and  transaction_id='".$value->transaction_id."' and user_id='".$value1->id."' and account_id='".$value->account_id."'")->result();
                    if(($checkfloat == 1 && $value->amount >0) && ($value->account_id==$account_ids)  &&  empty($query) && DATE($value1->created) < $value->date){
                        unset($key);
                        $aaa[]=$value;
                    }
                }
                print_r($aaa);
                foreach ($aaa as $key => $value) {
                    $amount1=$value->amount;
                    $amount2=floor($value->amount);
                    $fraction=$amount1-$amount2;
                    $amount=1-$fraction;

                    $data=array('user_id'=>$value1->id,
                    'amount'=>$amount,
                    'transaction_id'=>$value->transaction_id,
                    'name'=>$value->name,
                    'account_id'=>$value->account_id,
                    'total_amount'=>$value->amount,
                    'date'=>$value->date,
                    'status'=>0,
                    'dateTime'=>date('Y-m-d H:i:s')
                    );
                    $insert_data = $this->User_model->insert_data('hb_spareChangeDonations',$data);
                }
            }        
        }
    }
    public function approvedCron_get(){
        $UserDetails = $this->db->query("SELECT * from  hb_users where user_type=0 and active_status =0 and isActivesparechange=1")->result();
        foreach ($UserDetails as $key => $value1) {
            if (!empty($value1->plaid_access_token)) {
                $account_ids=$value1->account_ids;
                $access_token=$value1->plaid_access_token;
                $date=date('Y-m-d');
                $enddate=date('Y-m-d', strtotime($value1->created));
                $vars = array(
                'client_id'=>'596cd0c14e95b810ac887df6',
                'secret'=>'36ca7ae963c88b05111f1246a5df69',
                'access_token'=>$access_token,
                "start_date"=> $enddate,
                "end_date"=> $date,
                );
                $aa=json_encode($vars);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,"https://sandbox.plaid.com/transactions/get");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$aa);  //Post Fields
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $headers = [
                'Content-Type: application/json'
                ];
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $server_output = curl_exec ($ch);
                curl_close ($ch);
                $arr=json_decode($server_output);
                $aaa=array();
                foreach ($arr->transactions as $key => $value) {
                    $checkfloat= is_float($value->amount);
                    $query=$this->db->query("SELECT  * from hb_spareChangeDonations where  (donation_status='2' or donation_status='1') and  transaction_id='".$value->transaction_id."' and user_id='".$value1->id."' and account_id='".$value->account_id."'")->result();
                    if(($checkfloat == 1 && $value->amount >0) && ($value->account_id==$account_ids)   &&  empty($query) && DATE($value1->created) < $value->date ){
                        unset($key);
                        $aaa[]=$value;
                    }
                }
                foreach ($aaa as $key => $value) {
                    $amount1=$value->amount;
                    $amount2=floor($value->amount);
                    $fraction=$amount1-$amount2;
                    $amount=1-$fraction;

                    $data=array('user_id'=>$value1->id,
                    'amount'=>$amount,
                    'transaction_id'=>$value->transaction_id,
                    'name'=>$value->name,
                    'account_id'=>$value->account_id,
                    'total_amount'=>$value->amount,
                    'date'=>$value->date,
                    'status'=>1,
                    'dateTime'=>date('Y-m-d H:i:s')
                    );
                    $insert_data = $this->User_model->insert_data('hb_spareChangeDonations',$data);
                }
                $checkreferal1  = $this->User_model->select_data('*','hb_users',array('id'=>$value1->id));
                if ($checkreferal1[0]->pushNotifications==0) {
                    $checklogin=$this->User_model->select_data('*','hb_login',array('user_id'=>$checkreferal1[0]->id,'status'=>1));
                    foreach ($checklogin as $key => $value) {
                        $pushData['message'] = "Your donation of  is sucess ";
                        $pushData['action'] = "donation";
                        $pushData['token'] = $value->token_id;
                        if($value->login_via == 1){
                            $this->User_model->iosPush($pushData);
                        }else if($value->login_via == 0){
                            $this->User_model->androidPush($pushData);
                        }
                    }
                }
            }
        }
    }
    public function appversion_get(){
        $query=$this->db->query("SELECT * from hb_app_versions order by date_created desc")->result();
        $response= $this->User_model->successResponse("Your data shows sucessfully",$query);
        $this->set_response($response, REST_Controller::HTTP_OK);
    }
    public function checktime_get(){
        print_r(date('Y-m-d H:i:s'));die;
    }


  
}