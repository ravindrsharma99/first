 <?php
 defined('BASEPATH') OR exit('No direct script access allowed');
 class Common_model extends CI_Model{
	public function __construct() {
		parent::__construct();
		$this->load->library( array('image_lib') );
	}
	/*not in working situation*/
	public function insertfunction($tbl,$data){
		$query=$this->db->query("INSERT INTO '".$tbl."' ('".$data."') SELECT * FROM  '".$tbl."' ")->result();
		return $query; 
	}
	public function updatefunction($tbl,$data,$where){
		$query=$this->db->query("UPDATE '".$tbl."' SET '".$data."'  SELECT * FROM '".$tbl."' WHERE  '".$where."' where '".$where."'")->row();
		return $query;
	}
	/*not in working situation*/


	public function sucessResponse($msg=null,$data=null,$count=null,$storeAllowed=null){
 		if (!empty($data) && !empty($msg) && !empty($count) && !empty($storeAllowed) ) {
			$result=array(
			'responseCode'=>true,
			'message'=>$msg,
			'count'=>$count,
			'response'=>$data,
			'storeAllowed'=>$storeAllowed
			); 		
 		}
 		elseif (!empty($data) && !empty($msg) && !empty($count) ) {
			$result=array(
			'responseCode'=>true,
			'message'=>$msg,
			'count'=>$count,
			'response'=>$data
			); 		
 		}
 		elseif (!empty($data) && !empty($msg) ) {
			$result=array(
			'responseCode'=>true,
			'message'=>$msg,
			'response'=>$data
			); 			
 		}

 		elseif (empty($data)) {
			$result=array(
			'responseCode'=>true,
			'message'=>$msg
			); 			
 		}
 		elseif(empty($msg)){
 			$result=array(
			'responseCode'=>true,
			'response'=>$data
			); 		
 		}
 		return $result;
 	}

 	public function errorResponse($msg=null,$res=null){
 		if (!empty($msg) && !empty($res) ) {
			$result=array(
			'responseCode'=>false,
			'message'=>$msg,
			'storeAllowed'=>$res
			); 			
 		}
 		elseif (!empty($msg)) {
			$result=array(
			'responseCode'=>false,
			'message'=>$msg
			); 			
 		}
 		else{
 			$result=array(
			'responseCode'=>false,
			'message'=>"something went wrong"
			);
 		}
 		return $result;
 	}
 	public function selectrow($tbl,$where=null,$select){
 		if (empty($where)) {
 			$this->db->select($select);
			$this->db->from($tbl); 
			$query = $this->db->get()->row();
 		}
 		else{
			$this->db->select($select);
			$this->db->from($tbl);
			$this->db->where($where); 
			$query = $this->db->get()->row();

 		}
 		return $query;
 	}
	public function selectresult($tbl,$selection,$where=null,$order=null){
		if (empty($where) && empty($order) ) {
			$data_response = $this->db->select($selection)
			->from($tbl)
			->get()->result();
		}
		elseif(empty($order)){
			$data_response =
			$this->db->select($selection)
			->from($tbl)
			->where($where)
			->get()->result();

		}else{
			$data_response =
			$this->db->select($selection)
			->from($tbl)
			->where($where)
			->order_by($order)
			->get()->result();
		}
		return $data_response;
	}
	public function insert_data($tbl,$data){
		$this->db->insert($tbl, $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	public function update_data($tbl,$data,$where){
 		$this->db->where($where);
 		$this->db->update($tbl,$data);
 		$aff_row=$this->db->affected_rows();
 		return $aff_row;
 	}
	public function file_upload($upload_path, $image) {
		$baseurl = base_url();
		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = '*';
		$config['max_size'] = '0';
		$config['max_width'] = '0';
		$config['max_height'] = '0';
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload($image)){
			$error = array(
			'error' => $this->upload->display_errors()
			);
			return $imagename = $error['error'];
		}
		else
		{
			$detail = $this->upload->data();
			return $imagename = $baseurl . $upload_path .'/'. $detail['file_name'];
		}
	}

	/*testing function*/
	public function Adminfile_upload($upload_path, $image) {
		$baseurl = base_url();
		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = '*';
		$config['max_size'] = '0';
		$config['max_width'] = '0';
		$config['max_height'] = '0';
		$config['maintain_ratio'] = TRUE;
		$config['width']         = 16;
		$config['height']       = 9;
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload($image)){
			$error = array(
			'error' => $this->upload->display_errors()
			);
			return $imagename = $error['error'];
		}
		else
		{
		$detail = $this->upload->data();
		$imagename = $baseurl . $upload_path .'/'. $detail['file_name'];
		$config['image_library'] = 'imagemagick';
		$config['source_image'] =$imagename;
		$config['x_axis'] = 100;
		$config['y_axis'] = 81;

		$this->image_lib->initialize($config);

		if ( ! $this->image_lib->crop())
		{
			echo $this->image_lib->display_errors();
		}
		else{
			echo "succes";
		}
		die;
		return $imagename = $baseurl . $upload_path .'/'. $detail['file_name'];

		}
	}
	public function requiredResponse(){
 		$result=array(
			'responseCode'=>false,
			'message'=>"Please fill required field."
		);
		return $result;
	}
	public function getretailerloggeddetail($id){
		$query=$this->selectresult('tblLogin','*',array('userId'=>$id,'status'=>1,'userType'=>2));
		return $query;
	}
	public function logoutpush($userid){
		$userData=$this->selectrow('tblRetailer',array('id'=>$userid),'*');
		$userlogindetail=$this->getretailerloggeddetail($userid);
		foreach ($userlogindetail as $key => $value) {
			$pushData['token']=$value->tokenId;
			$pushData['message']="You are logged in on another device.";
			$pushData['action']="loggedout";
			if ($value->deviceId==0) {
				$this->androidPush($pushData);
			}
			elseif($value->deviceId==1){
				$this->iosPush($pushData);
			}
		}
	}

	public function customerLoggedOut($userid){
		$userData=$this->selectrow('tblCustomer',array('id'=>$userid),'*');
		$userlogindetail=$this->getcustomerloggeddetail($userid);
		foreach ($userlogindetail as $key => $value) {
			$pushData['token']=$value->tokenId;
			$pushData['message']="You are logged in on another device.";
			$pushData['action']="loggedout";
			if ($value->deviceId==0) {
				$this->androidPush($pushData);
			}
			elseif($value->deviceId==1){
				$this->iosPush($pushData);
			}
		}
	}

	public function suspendRetailerPush($retailerId){
		$userData=$this->selectrow('tblRetailer',array('id'=>$retailerId),'*');
		$userlogindetail=$this->getretailerloggeddetail($retailerId);
		foreach ($userlogindetail as $key => $value) {
			$pushData['token']=$value->tokenId;
			$pushData['message']="You account is suspended.";
			$pushData['action']="suspend";
			if ($value->deviceId==0) {
				$this->androidPush($pushData);
			}
			elseif($value->deviceId==1){
				$this->iosPush($pushData);
			}
		}
	}

		public function suspendCustomerPush($customerId){
		$userData=$this->selectrow('tblRetailer',array('id'=>$customerId),'*');
		$userlogindetail=$this->getcustomerloggeddetail($customerId);
		foreach ($userlogindetail as $key => $value) {
			$pushData['token']=$value->tokenId;
			$pushData['message']="You account is suspended.";
			$pushData['action']="suspend";
			if ($value->deviceId==0) {
				$this->androidPush($pushData);
			}
			elseif($value->deviceId==1){
				$this->iosPush($pushData);
			}
		}
	}


	
	public function getcustomerloggeddetail($customerId){
		$query=$this->selectresult('tblLogin','*',array('userId'=>$customerId,'status'=>1,'userType'=>1));
		return $query;
	}

	public function freebarcodepush($customerId){
		$userData=$this->selectrow('tblCustomer',array('id'=>$customerId),'*');
		$userlogindetail=$this->getcustomerloggeddetail($customerId);

		foreach ($userlogindetail as $key => $value) {
			$pushData['token']=$value->tokenId;
			$pushData['message']="Deal is expired.";
			$pushData['action']="expireddeal";
			if ($value->deviceId==0) {
				$this->androidPush($pushData);
			}
			elseif($value->deviceId==1){
				$this->iosPush($pushData);
			}
		}
	}

 	public function androidPush($pushData=null){
 		$mytime = date("Y-m-d H:i:s");
		$api_key = "AAAATJexA6Y:APA91bFxWZiElLOr-bn1UB7KrodSrXl9pEkE6xeatD8SWVfMBKRPvdQQaztialq6HpqMz8lpxySax3QwM-BrPCuz3ui5Aw1TC-L4M46psVE1iIMV4j-MVShAoPwLjPPOkfKpp8pMPVsZ";  
		$fcm_url = 'https://fcm.googleapis.com/fcm/send';
		$fields = array(
			'registration_ids' => array(
				$pushData['token']
			),
			'data' => array(
				"message" =>$pushData['message'],
				"spMessage" =>$pushData['message1'],
				"action" => $pushData['action'],
				"time" => $mytime
			) ,
		);
		$headers = array(
			'Authorization: key=' . $api_key,
			'Content-Type: application/json'
		);
		$curl_handle = curl_init();
		curl_setopt($curl_handle, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		curl_setopt($curl_handle, CURLOPT_URL, $fcm_url);
		curl_setopt($curl_handle, CURLOPT_POST, true);
		curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl_handle, CURLOPT_POSTFIELDS, json_encode($fields));
		$response = curl_exec($curl_handle);
		curl_close($curl_handle);
	}
	/*push notification for ios common function*/
	public function iosPush($pushData=null) {
		$deviceToken = $pushData['token'];
		$mytime = date("Y-m-d H:i:s");
		$passphrase = '123456789';
		$ctx = stream_context_create();
		stream_context_set_option($ctx, 'ssl', 'local_cert', './certs/pendulum.pem');
		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
		$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
		$body['aps'] = array(
			"from_name"=>$pushData['fromname'],
			'alert' => array(
			'title' => $pushData['title'],//post name
			'body' =>$pushData['message1'],//zohaib: message
		),
			"action"=>$pushData['action'],
			"message"=>$pushData['message'],
			'sound' => 'default'
		);
		$payload = json_encode($body);
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
		$result = fwrite($fp, $msg, strlen($msg));
		fclose($fp);
	}
	public function forgotAdminpassword($email){	
		$query=$this->db->query("SELECT * from tblAdmin where email='".$email."'")->row();
		$static_key = "afvsdsdjkldfoiuy4uiskahkhsajbjksasdasdgf43gdsddsf";
		$id = $query->id . "_" . $static_key;
		$result['bId'] = base64_encode($id);
		$result['userId'] = $query->id;
		$result['fname'] = $query->name;
		$result['email'] = $query->email;
		return $result;
 	}

	




	


}