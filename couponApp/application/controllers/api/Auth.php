    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require APPPATH . '/libraries/REST_Controller.php';

    /**
    * This is an example of a few basic user interaction methods you could use
    * all done with a hardcoded array
    *
    * @package         CodeIgniter
    * @subpackage      Rest Server
    * @category        Controller
    * @author          Ravinder Sharma,Osvin web solution.
    * @license         MIT
    * @link            https://github.com/chriskacerguis/codeigniter-restserver
    */
    class Auth extends REST_Controller {
		function __construct(){
			parent::__construct();
			$this->load->helper('form');
			error_reporting(0);
			ini_set('display_errors',0);
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
		}
	public function index()
	{
		$this->load->view('welcome_message');
	}
	public function loginRetailer_post(){
		$data=array(
			'userName'=>$this->input->post('userName'),
			'password'=>md5($this->input->post('password'))
		);

		if (empty($data['userName'] || empty($data['password'])  )) {
			$response=$this->Common_model->requiredResponse();
		}
		else{
	        $loginParams=array(
	            'tokenId'=>$this->input->post('tokenId'),
	            'deviceId'=>$this->input->post('deviceId'),
	            'uniqueDeviceID'=>$this->input->post('uniqueDeviceID'),
	            'status'=>1,
	            'userType'=>2
	        );
	        $response=$this->Auth_model->retailerLogin($data,$loginParams);
		}
        $this->set_response($response,REST_Controller::HTTP_OK);
	}
	public function updateRetailerProfile_post(){
		$retailerId=$this->input->post('retailerId');
		$retailerarray=array(
			'name'=>$this->input->post('name'),
			'email'=>$this->input->post('email'),
			'phoneNo'=>$this->input->post('phoneNo'),
			'isComplete'=>1
			);
		if (empty($retailerId)) {
			$response=$this->Common_model->requiredResponse();
			// goto end;
		}
		else{
			if (isset($_FILES['image']['name'])) {
		    	$image='image';
		        $upload_path='assets/apidata';
		        $retailerarray['image']=$this->Common_model->file_upload($upload_path,$image);
		    }
		    if (isset($_FILES['logo']['name'])) {
		    	$image='logo';
		        $upload_path='assets/apidata';
		        $retailerarray['logo']=$this->Common_model->file_upload($upload_path,$image);
		    }
		    $query=$this->Common_model->update_data('tblRetailer',array('id'=>$retailerId),$retailerarray);
		    $retailerData=$this->Common_model->selectrow('tblRetailer',array('id'=>$retailerId),'*');
			$response= $this->Common_model->sucessResponse('Retailer Signed up successfully.',$retailerData);

		}
        $this->set_response($response,REST_Controller::HTTP_OK);
	}
    public function logout_post(){
        $data=array(
            'userId'=>$this->input->post('userId'),
            'uniqueDeviceId'=>$this->input->post('uniqueDeviceId')
        );
        $userType=$this->input->post('userType');
		if (empty($data['userId'] || empty($data['uniqueDeviceId']) || empty($userType)  )) {
			$response=$this->Common_model->requiredResponse();
		}
		else{
        	$response=$this->Auth_model->logout($data,$userType);
        }
        $this->set_response($response,REST_Controller::HTTP_OK);
    }

    public function forgotpassword_post(){
        $userType=$this->input->post('userType');
        $data=array('userName'=>$this->input->post('userName'));
        $phoneNo=$this->input->post('phoneNo');

        if ( empty($userType)  ) {
			$response=$this->Common_model->requiredResponse();
		}
		else{

		    $checkemail=$this->Auth_model->forgotpassword($data,$userType,$phoneNo);

			if ($userType==2) {
		        if ($checkemail==0) {
		            $response= $this->Common_model->errorResponse('Username does not exists');
		        }
		        else{
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
					
		            $fromemail="coupenapp@gmail.com";
		            $toemail = $checkemail['email'];
		            $subject = "Password reset Mail.";
		            $data['data']=$checkemail;
		            $mesg = $this->load->view('app/forgotpassword',$data,true);

		            $this->email->to($toemail);
		            $this->email->from($fromemail, "From Coupon App.");
		            $this->email->subject($subject);
		            $this->email->message($mesg);
		            $mail = $this->email->send();
		            $response= $this->Common_model->sucessResponse('Password reset mail send successfully');
		        }
			}
			elseif($userType==1){
				if ($checkemail==0) {
		            $response= $this->Common_model->errorResponse('Phone No does not exists');
		        }
		        else{
					$otp=rand(1000,9999);
					$otpResponse=$this->sendOtp($phoneNo,$otp);
					if ($otpResponse->IsError) {
						$response= $this->Common_model->errorResponse('Something went wrong.',$otpResponse->ErrorMessage);
					}
					else{
						$otpData=$this->Common_model->selectrow('tblOtp',array('phoneNo'=>$phoneNo),'*');
						if(empty($otpData)){
							$otpParams=array('phoneNo'=>$phoneNo,'otp'=>$otp );
							$this->Common_model->insert_data('tblOtp',$otpParams);	
						}
						else{
							$this->Common_model->update_data('tblOtp',array('otp'=>$otp),array('phoneNo'=>$phoneNo));
						}
						$response= $this->Common_model->sucessResponse('Otp sent successfully.',$otp);
					}
		        }
			}
		}
        $this->set_response($response,REST_Controller::HTTP_OK);
    }

    function newpassword_get($user_id=null){
        if ($user_id!="") {
            $user_id = base64_decode($user_id);
        }
        else{
            $user_id = base64_decode($this->get('id'));
        }

        $useridArr = explode("_", $user_id);
        $user_id = $useridArr[0];
        $data['id'] = $user_id;

        $data['title'] = "new Password";
        $this->load->view('app/header');
        $this->load->view('app/newpassword', $data);
    }



    function updateNewpassword_post(){
        $uid = $this->input->post('id');
        $userType = $this->input->post('userType');

        $static_key = "afvsdsdjkldfoiuy4uiskahkhsajbjksasdasdgf43gdsddsf";
        $id = $uid . "_" . $static_key;
        $id = base64_encode($id);
        $message = ['id' => $this->input->post('id') , 'password' => $this->input->post('password') , 'base64id' => $id];
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|md5');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]|md5');

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('msg', '<span style="color:red">Please Enter Same Password</span>');
            redirect("api/Auth/newpassword?id=" . $message['base64id']);
        }
        else
        {
            $this->Auth_model->updateNewpassword($message);
        }
    }



    public function viewProfile_post(){
        $userId=$this->input->post('userId');
        $userType=$this->input->post('userType');

        if (empty($userId) || empty($userType)){
			$response=$this->Common_model->requiredResponse();
		}
		else{
		    if ($userType==1) {
		        $query=$this->db->query("SELECT * from tblCustomer  where id='".$userId."' ")->row();
		        if (!empty($query)) {
		            $response=$this->Common_model->sucessResponse('Your profile data shows successfully.',$query);
		        }
		        else{
		            $response=$this->Common_model->errorResponse('Something went wrong.');
		        }
		    }
		    elseif ($userType==2) {
		        $query=$this->db->query("SELECT * from tblRetailer  where id='".$userId."' ")->row();
		        if (!empty($query)) {
		            $response=$this->Common_model->sucessResponse('Your profile data shows successfully.',$query);
		        }
		        else{
		            $response=$this->Common_model->errorResponse('Something went wrong.');
		        }
		    }
		}
        $this->set_response($response,REST_Controller::HTTP_OK);
    }


    public function changePassword_post(){
        $userId=$this->input->post('userId');
        $oldPassword=md5($this->input->post('oldPassword'));
        $newPassword=md5($this->input->post('newPassword'));
        $userType=$this->input->post('userType');

        if (empty($userId) || empty($userType)){
			$response=$this->Common_model->requiredResponse();
		}
		else{

	        if ($userType==1) {
	            $query=$this->Common_model->selectrow('tblCustomer',array('id'=>$userId,'password'=>$oldPassword),'*');
	            if (empty($query)) {
	                $response=$this->Common_model->errorResponse('Old password not matched.');
	            }
	            else{
	                $this->Common_model->update_data('tblCustomer',array('password'=>$newPassword),array('id'=>$userId));
	                $response=$this->Common_model->sucessResponse('Your password changed successfully.');
	            }
	        }
	        elseif($userType==2){
	            $query=$this->Common_model->selectrow('tblRetailer',array('id'=>$userId,'password'=>$oldPassword),'*');
	            if (empty($query)) {
	                $response=$this->Common_model->errorResponse('Old password not matched.');
	            }
	            else{
	                $this->Common_model->update_data('tblRetailer',array('password'=>$newPassword),array('id'=>$userId));
	                $response=$this->Common_model->sucessResponse('Your password changed successfully.');
	            }
	        }
	    }

        $this->set_response($response,REST_Controller::HTTP_OK);
    }


    public function resetCustomerPassword_post(){
    	$phoneNo=$this->input->post('phoneNo');
    	$password=md5($this->input->post('password'));
    	if (empty($phoneNo) || empty($password)){
			$response=$this->Common_model->requiredResponse();
		}
		else{
	        $this->Common_model->update_data('tblCustomer',array('password'=>$password),array('phoneNo'=>$phoneNo));
	        $response=$this->Common_model->sucessResponse('Password reset successfully.');
		}
        $this->set_response($response,REST_Controller::HTTP_OK);
    }

    public function editRetailerProfile_post(){
        $retailerId=$this->input->post('retailerId');
        $name=$this->input->post('name');
        $email=$this->input->post('email');
        $phoneNo=$this->input->post('phoneNo');

        if (empty($retailerId)){
			$response=$this->Common_model->requiredResponse();
		}
		else{
	        if (isset($_FILES['image'])) {
	            $image='image';
	            $upload_path='assets/apidata';
	            $image=$this->Common_model->file_upload($upload_path,$image);
	        }
	        if (isset($_FILES['logo'])) {
	            $logo='logo';
	            $upload_path='assets/apidata';
	            $logo=$this->Common_model->file_upload($upload_path,$logo);
	        }
	        $checkemail=$this->db->query("SELECT * from tblRetailer where email='".$email."' and id !='".$retailerId."' ")->result();
	        if (empty($checkemail)) {
		        $this->Common_model->update_data('tblRetailer',array('name'=>$name,'email'=>$email,'phoneNo'=>$phoneNo,'image'=>$image,'logo'=>$logo,'isComplete'=>1),array('id'=>$retailerId));
		        $query=$this->Common_model->selectrow('tblRetailer',array('id'=>$retailerId),'*');
		        $response=$this->Common_model->sucessResponse('Your profile updated successfully.',$query);
	        }
	        else{
	            $response=$this->Common_model->errorResponse('Email already exists.');
	        }
	    }
        $this->set_response($response,REST_Controller::HTTP_OK);
    }


    public function editCustomerProfile_post(){
    	$customerId=$this->input->post('customerId');
        $firstName=$this->input->post('firstName');
        $lastName=$this->input->post('lastName');
        $email=$this->input->post('email');
        if (empty($customerId)){
			$response=$this->Common_model->requiredResponse();
		}
		else{
	        if (isset($_FILES['profilePic'])) {
	            $image='profilePic';
	            $upload_path='assets/apidata';
	            $imagename=$this->Common_model->file_upload($upload_path,$image);
	        }
		    $this->Common_model->update_data('tblCustomer',array('firstName'=>$firstName,'lastName'=>$lastName,'email'=>$email,'profilePic'=>$imagename),array('id'=>$customerId));
		    $query=$this->Common_model->selectrow('tblCustomer',array('id'=>$customerId),'*');
		    $response=$this->Common_model->sucessResponse('Your profile updated successfully.',$query);
	    
	    }
        $this->set_response($response,REST_Controller::HTTP_OK);
    }

    public function pushNotification_post(){
        $userId=$this->input->post('userId');
        $userType=$this->input->post('userType');
        $status=$this->input->post('status');

        if (empty($userId) || empty($userType)){
			$response=$this->Common_model->requiredResponse();
		}
		else{
	        if ($userType==1) {
	            $this->Common_model->update_data('tblCustomer',array('pushNotification'=>$status),array('id'=>$userId));            
	        }
	        elseif($userType=2){
	            $this->Common_model->update_data('tblRetailer',array('pushNotification'=>$status),array('id'=>$userId));
	        }
	        $response= $this->Common_model->sucessResponse('Your Push Notification status succesfully');
	    }
        $this->set_response($response,REST_Controller::HTTP_OK);
    }

    public function activeStatus_post(){
    	$userId=$this->input->post('userId');
    	$userType=$this->input->post('userType');
    	$uniqueDeviceId=$this->input->post('uniqueDeviceId');

    	if (empty($userId) || empty($userType) || empty($uniqueDeviceId) ) {
	        $response=$this->Common_model->requiredResponse();
    	}
    	else{
    		if ($userType==1) {
    			$checksuspend=$this->db->query("SELECT * from tblCustomer where id='".$userId."'  ")->row();
    		}
    		elseif($userType==2){
    			$checksuspend=$this->db->query("SELECT * from tblRetailer where id='".$userId."'  ")->row();
    		}

    		if ($checksuspend->suspend==0) {
	        	$checkLogin=$this->db->query("SELECT * from tblLogin where userId='".$userId."' and userType ='".$userType."' and  uniqueDeviceId='".$uniqueDeviceId."' order by id desc ")->row();

	        	if ($checkLogin->status==0) {
	        		$response= $this->Common_model->errorResponse('logged in on other device',$checkLogin);
	        	}
	        	else{
	        		$response= $this->Common_model->sucessResponse('logged in.',$checkLogin);
	        	}
    		}
    		else{
	        	$response= $this->Common_model->errorResponse('account suspended.');
    		}
    	}
        $this->set_response($response,REST_Controller::HTTP_OK);
    }



	public function sendOtp($to,$otp)
	{
		$from = '+13022465586';
		$message = 'Your otp for coupon App '.$otp.'.Please do not share with anyone.';
		$response = $this->twilio->sms($from, $to, $message);
		return $response; 
	}
    /*signup function*/
	public function signUp($data){
		$signUpData=$this->Common_model->selectrow('tblCustomer',array('phoneNo'=>$data['phoneNo']),'*');
		if(empty($signUpData)){
			$query=$this->Common_model->insert_data('tblCustomer',$data);
		}
		else{
			$this->Common_model->update_data('tblCustomer',$data,array('phoneNo'=>$data['phoneNo']));
			return $signUpData->id;
		}
		return 	$query;
	}

	public function otpcheck($data,$otp){
		$otpData=$this->Common_model->selectrow('tblOtp',array('phoneNo'=>$data['phoneNo']),'*');
		if(empty($otpData)){
			$otpParams=array('phoneNo'=>$data['phoneNo'],'otp'=>$otp );
			$this->Common_model->insert_data('tblOtp',$otpParams);
		}
		else{
			$this->Common_model->update_data('tblOtp',array('otp'=>$otp),array('phoneNo'=>$data['phoneNo']));
		}
		return true;
	}
    /*signup function*/

	public function customerSignup_post(){
		$data=array(
			'firstName'=>$this->input->post('firstName'),
			'lastName'=>$this->input->post('lastName'),
			'phoneNo'=>$this->input->post('phoneNo'),
			'password'=>md5($this->input->post('password')),
			'fbId'=>$this->input->post('fbId'),
			'email'=>$this->input->post('email'),
			'dob'=>$this->input->post('dob'),
		);
		$query=$this->Common_model->selectrow('tblCustomer',array('phoneNo'=>$data['phoneNo'],'complete'=>1),'*');
		if(empty($query)){
			$otp=rand(1000,9999);
			$otpResponse=$this->sendOtp($data['phoneNo'],$otp);
			if ($otpResponse->IsError) {
		        $response= $this->Common_model->errorResponse('Something went wrong.',$otpResponse->ErrorMessage);
			}
			else{
				$this->otpcheck($data,$otp);
				$userId=$this->signUp($data);
		        $response= $this->Common_model->sucessResponse('Signed up successfully.');
			}
		}
		else{
		    $response= $this->Common_model->errorResponse('Phone no already exists.');
		}
        $this->set_response($response,REST_Controller::HTTP_OK);
	}


	public function verifyOtp_post(){
		$otp=$this->input->post('otp');
		$phoneNo=$this->input->post('phoneNo');

		$loginParams=array(
		'tokenId'=>$this->input->post('tokenId'),
		'deviceId'=>$this->input->post('deviceId'),
		'uniqueDeviceID'=>$this->input->post('uniqueDeviceID'),
		'status'=>1,
		'userType'=>1
		);
		$query=$this->Common_model->selectrow('tblOtp',array('phoneNo'=>$phoneNo,'otp'=>$otp),'*');
		if (empty($query)) {
		    $response= $this->Common_model->errorResponse('Otp not valid.');
		}
		else{
			$loginParams['userId']=$query->id;
			$this->Common_model->insert_data('tblLogin',$loginParams);	
			$this->Common_model->update_data('tblCustomer',array('complete'=>1),array('phoneNo'=>$phoneNo));
			$query=$this->Common_model->selectrow('tblCustomer',array('phoneNo'=>$phoneNo),'*');
		    $response= $this->Common_model->sucessResponse('Otp successfully verfied.',$query);
		}
        $this->set_response($response,REST_Controller::HTTP_OK);
	}

	public function reSendOtp_post(){
		$data=array(
			'phoneNo'=>$this->input->post('phoneNo'),
		);
		$otp=rand(1000,9999);
		$otpResponse=$this->sendOtp($data['phoneNo'],$otp);
		if ($otpResponse->IsError) {
			$response= $this->Common_model->errorResponse('Something went wrong.',$otpResponse->ErrorMessage);
		}
		else{
			$otpData=$this->Common_model->selectrow('tblOtp',array('phoneNo'=>$data['phoneNo']),'*');
			if(empty($otpData)){
				$otpParams=array('phoneNo'=>$data['phoneNo'],'otp'=>$otp );
				$this->Common_model->insert_data('tblOtp',$otpParams);	
			}
			else{
	            $this->Common_model->update_data('tblOtp',array('otp'=>$otp),array('phoneNo'=>$data['phoneNo']));
			}
			$response= $this->Common_model->sucessResponse('Otp sent successfully.',$userinsertresponse);
		}
		$this->set_response($response,REST_Controller::HTTP_OK);
	}
	
	public function loginCustomer_post(){
		$data=array(
			'phoneNo'=>$this->input->post('phoneNo'),
			'password'=>md5($this->input->post('password'))
		);

		$loginType=$this->input->post('loginType');
		$fbId=$this->input->post('fbId');
		$email=$this->input->post('email');

        $loginParams=array(
            'tokenId'=>$this->input->post('tokenId'),
            'deviceId'=>$this->input->post('deviceId'),
            'uniqueDeviceID'=>$this->input->post('uniqueDeviceID'),
            'status'=>1,
            'userType'=>1
        );
        $response=$this->Auth_model->customerlogin($data,$loginParams,$loginType,$fbId,$email);
    	$this->set_response($response,REST_Controller::HTTP_OK);
	}
	public function newAdminpassword_get($user_id=null){
        if ($user_id!="") {
            $user_id = base64_decode($user_id);
        }
        else{
            $user_id = base64_decode($this->get('id'));
        }

        $useridArr = explode("_", $user_id);
        $user_id = $useridArr[0];
        $data['id'] = $user_id;

        $data['title'] = "new Password";
        $this->load->view('app/header');
        $this->load->view('app/newAdminpassword', $data);
    }








}
