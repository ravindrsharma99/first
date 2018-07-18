 <?php
 defined('BASEPATH') OR exit('No direct script access allowed');
 class Auth_model extends CI_Model{
 	public function __construct() {
 		parent::__construct();
 	}

 	public function retailerLogin($data,$loginParams){
 		$query=$this->Common_model->selectrow('tblRetailer',array('userName'=>$data['userName']),'*');
 		if (!empty($query)) {
 			$passwordcheck=$this->Common_model->selectrow('tblRetailer',array('userName'=>$data['userName'],'password'=>$data['password']),'*');
 			if (!empty($passwordcheck)) {
	 			if ($query->suspend==1) {
	 				return $this->Common_model->errorResponse('account suspended');
	 			}
	 			else{

	 				$this->Common_model->logoutpush($query->id);
	 				$this->Common_model->update_data('tblLogin',array('status'=>0),array('userId'=>$query->id,'userType'=>2));
	 				$loginParams['userId']=$query->id;
	 				$this->Common_model->insert_data('tblLogin',$loginParams);
	 				return $this->Common_model->sucessResponse('successfully login',$query);
	 			}
 			}
 			else{
 				return $this->Common_model->errorResponse('Wrong credential.');
 			}
 		}
 		else{
 			return $this->Common_model->errorResponse('User does not exist.');
 		}
 	}

 	public function logout($data,$userType){
 		$this->Common_model->update_data('tblLogin',array('status'=>0),array('userId'=>$data['userId'],'uniqueDeviceId'=>$data['uniqueDeviceId'],'userType'=>$userType));
 		$response=$this->Common_model->sucessResponse('successfully logged out');
 		return $response;
 	}




 	public function forgotpassword($email,$userType,$phoneNo){	
 		if ($userType==1) {
 			$query=$this->Common_model->selectrow('tblCustomer',array('phoneNo'=>$phoneNo),'*');
 			if (!empty($query)) {
 				return $query;
 			}
 			else{
	 			return 0;
 			}
 		}
 		elseif ($userType==2) {
 			$query=$this->Common_model->selectrow('tblRetailer',$email,'*');

	 		if (!empty($query)) {
				$static_key = "afvsdsdjkldfoiuy4uiskahkhsajbjksasdasdgf43gdsddsf";
				$id = $query->id . "_" . $static_key;
				$result['bId'] = base64_encode($id);
				$result['userId'] = $query->id;
				$result['fname'] = $query->name;
				$result['email'] = $query->email;
				$time=date('Y-m-d H:i:s');
				$getforgot = $this->db->select('*')->from('tblForgotPassword')->where('userId', $query->id)->get()->result();
				if (empty($getforgot)) {
					$addtransArray = array(
					'userId'=>$query->id,
					'time'=>date('Y-m-d H:i:s'),
					'status' => 1,
					);
					$addtrans = $this->Common_model->insert_data('tblForgotPassword',$addtransArray);
				}
				else{
					$uptBal = $this->Common_model->update_data('tblForgotPassword',array('status'=>1,' time'=>date('Y-m-d H:i:s')),array('userId'=>$query->id));
				}
	 			return $result;
	 		}
	 		else{
	 			return 0;
	 		}

 		}
 	}


	public function updateNewpassword($message){
		$getforgot = $this->db->select('*')->from('tblForgotPassword')->where('userId', $message['id'])->get()->result();

		$sendtime=$getforgot[0]->time;
		$time=date('Y-m-d H:i:s');
		$det= date('Y-m-d H:i:s', strtotime("$sendtime  +30 minutes"));


		/*checking that user can update password only in 30 minute*/
		if ($time <= $det && $getforgot[0]->status==1) {
	
				$update_pwd = $this->db->where('id', $message['id']);
				$this->db->update("tblRetailer", array(
				'password' => md5($message['password']))
				);
		
			$update_pwd2 =  $this->db->where('userId', $message['id']);
							$this->db->update("tblForgotPassword", array(
							'status' => 0)
							);
			if ($update_pwd)
			$this->session->set_flashdata('msg', '<span style="color:green">Password Changed Successfully</span>');
			redirect("api/auth/newpassword?id=" . $message['base64id']);
		}
		else{
			$this->session->set_flashdata('msg', '<span style="color:red">Your Reset Password Link has been Expired</span>');
			redirect("api/auth/newpassword?id=" . $message['base64id']);
		}
	}


	 	public function customerlogin($data,$loginParams,$loginType,$fbId,$email){
	 		if ($loginType==1) {		
		 		$query=$this->Common_model->selectrow('tblCustomer',array('phoneNo'=>$data['phoneNo'],'complete'=>1),'*');
		 		if (!empty($query)) {
		 			$passwordcheck=$this->Common_model->selectrow('tblCustomer',array('phoneNo'=>$data['phoneNo'],'password'=>($data['password']),'complete'=>1),'*');
		 			if (!empty($passwordcheck)) {
			 			if ($query->suspend==1) {
			 				return $this->Common_model->errorResponse('account suspended');
			 			}
			 			else{

			 				$this->Common_model->customerLoggedOut($query->id);
			 				$this->Common_model->update_data('tblLogin',array('status'=>0),array('userId'=>$query->id,'userType'=>1));
			 				$loginParams['userId']=$query->id;
			 				$this->Common_model->insert_data('tblLogin',$loginParams);
			 				return $this->Common_model->sucessResponse('successfully login',$query);
			 			}
		 			}
		 			else{
		 				return $this->Common_model->errorResponse('Wrong credential.');
		 			}
		 		}
		 		else{
		 			return $this->Common_model->errorResponse('User does not exist.');
		 		}
	 		}
	 		elseif($loginType==2){
	 			$query=$this->Common_model->selectrow('tblCustomer',array('fbId'=>$fbId,'complete'=>1),'*');
		 		if (!empty($query)) {
		 			if ($query->suspend==1) {
		 				return $this->Common_model->errorResponse('account suspended');
		 			}
		 			else{
		 				$this->Common_model->customerLoggedOut($query->id);
		 				$this->Common_model->update_data('tblLogin',array('status'=>0),array('userId'=>$query->id,'userType'=>1));
		 				$loginParams['userId']=$query->id;
		 				$this->Common_model->insert_data('tblLogin',$loginParams);
		 				return $this->Common_model->sucessResponse('successfully login',$query);
		 			}
		 		}
		 		else{
		 			if (!empty($email)) {
	 					$query=$this->Common_model->selectrow('tblCustomer',array('email'=>$email,'complete'=>1),'*');
	 					if (!empty($query)) {
							if ($query->suspend==1) {
								return $this->Common_model->errorResponse('account suspended');
							}
							else{
		 						$this->Common_model->customerLoggedOut($query->id);
			 					$this->Common_model->update_data('tblLogin',array('status'=>0),array('userId'=>$query->id,'userType'=>1));
			 					$this->Common_model->update_data('tblCustomer',array('fbId'=>$fbId),array('id'=>$query->id));
			 					$loginParams['userId']=$query->id;
			 					$this->Common_model->insert_data('tblLogin',$loginParams);
			 					return $this->Common_model->sucessResponse('successfully login',$query);
		 					}
	 					}
	 					else{
		 					return $this->Common_model->errorResponse('User does not exist.');
	 					}
		 				
		 			}
		 			else{
		 				return $this->Common_model->errorResponse('User does not exist.');
		 			}
		 		}
	 		}
 	}





}