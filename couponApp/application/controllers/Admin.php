<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */


	function __construct(){
		parent::__construct();
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
		$session=$this->session->all_userdata();
		if (empty($session['email'])) {
			redirect('Login');
		}
	}
	
	public function index()
	{

		$data['customer']=count($this->Common_model->selectresult('tblCustomer','*'));
		$data['retailer']=count($this->Common_model->selectresult('tblRetailer','*'));
		$data['deal']=count($this->Common_model->selectresult('tblDeals','*'));
		$data['store']=count($this->Common_model->selectresult('tblStorePlaces','*'));
		$this->template();
		$this->load->view('index',$data);
	}
	public function template(){
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
	}
	public function retailers()
	{
		$this->template();
		$this->load->view('retailersList');
	}
	public function deals()
	{
		$data['count']=$this->db->query("SELECT count(id) as count from tblDeals ")->row()->count;
		$this->template();
		$this->load->view('dealsList',$data);
	}
	public function stores()
	{
		$this->template();
		$this->load->view('storePlaceList');
	}
	public function newretailer(){
		$columns = array( 
			0 =>'id', 
			1 =>'name',
			2=> 'email',
			3=> 'phoneNo',
			4=> 'storeAllowed',
			);

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];

		$totalData = $this->db->query("SELECT * from tblRetailer ")->result();

		$totalFiltered = count($totalData); 

		if(empty($this->input->post('search')['value']))
		{
			$retailer=$this->db->limit($limit,$start)->order_by($order,$dir)->get('tblRetailer')->result();
		}
		else {
			$search = $this->input->post('search')['value']; 
			$retailer = $this->db->like('id',$search)->or_like('name',$search)->or_like('email',$search)->or_like('phoneNo',$search)->limit($limit,$start)->order_by($order,$dir)->get('tblRetailer')->result();
			$totalFiltered=$this->db->like('id',$search)->or_like('name',$search)->or_like('email',$search)->or_like('phoneNo',$search)->get('tblRetailer')->result();
			$totalFiltered=count($totalFiltered);

		}

		$data = array();
		if(!empty($retailer))
		{
			$i=1;
			foreach ($retailer as $retailers)
			{
				$nestedData['srNo'] = $i;
				$nestedData['id'] = $retailers->id;
				$nestedData['suspend'] = $retailers->suspend;
				$nestedData['name'] = $retailers->name;
				$nestedData['email'] = $retailers->email;
				$nestedData['phoneNo'] = $retailers->phoneNo;
				$nestedData['image'] = $retailers->image;
				$nestedData['storeAllowed'] = $retailers->storeAllowed;
				$data[] = $nestedData;
				$i++;
			}
		}

		$json_data = array(
			"draw"            => intval($this->input->post('draw')),  
			"recordsTotal"    => intval($totalData),  
			"recordsFiltered" => intval($totalFiltered), 
			"data"            => $data   
			);
		echo json_encode($json_data); 
	}

	public function retailerDealsAssigned($id){
		$columns = array( 
			0 =>'id', 
			1 =>'dealName',
			2=> 'dealImage',
			3=> 'description',
			);
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];

		$totalData = $this->db->query("SELECT * from tblAssignedPlaceDeal join tblDeals on tblAssignedPlaceDeal.dealId=tblDeals.id where tblAssignedPlaceDeal.placeId='".$id."' ")->result();

		$totalFiltered = count($totalData); 

		if(empty($this->input->post('search')['value']))
		{
			$AssignedDeals=$this->db->query("SELECT * from tblAssignedPlaceDeal join tblDeals on tblAssignedPlaceDeal.dealId=tblDeals.id where placeId='".$id."' order by '".$order."' '".$dir."' ")->result();
		}
		else {
			$search = $this->input->post('search')['value']; 
			$AssignedDeals=$this->db->query("SELECT * from tblAssignedPlaceDeal join tblDeals on tblAssignedPlaceDeal.dealId=tblDeals.id where placeId='".$id."' and (tblAssignedPlaceDeal.id like '".$search."' or dealName like  '".$search."' or expiryDate like '".$search."'  ) order by '".$order."' '".$dir."' ")->result();
			$totalFiltered=$this->db->query("SELECT * from tblAssignedPlaceDeal join tblDeals on tblAssignedPlaceDeal.dealId=tblDeals.id where placeId='".$id."' and (tblAssignedPlaceDeal.id like '".$search."' or   dealName like '".$search."' or expiryDate like   '".$search."'  )  ")->result();
			$totalFiltered=count($totalFiltered);
		}

		$data = array();
		if(!empty($AssignedDeals))
		{
			$i=1;
			foreach ($AssignedDeals as $deals)
			{
				$nestedData['srNo'] = $i;
				$nestedData['id'] = $deals->id;
				$nestedData['dealId'] = $deals->dealId;
				$nestedData['dealName'] = $deals->dealName;
				$nestedData['dealImage'] = $deals->dealImage;
				$nestedData['placeId'] = $deals->placeId;
				$nestedData['expiryDate'] = $deals->expiryDate;
				$nestedData['description'] = $deals->description;
				$nestedData['validFor'] = $deals->validFor;
				$data[] = $nestedData;
				$i++;
			}
		}
		$json_data = array(
			"draw"            => intval($this->input->post('draw')),  
			"recordsTotal"    => intval($totalData),  
			"recordsFiltered" => intval($totalFiltered), 
			"data"            => $data   
			);
		echo json_encode($json_data); 
	}
	public function customers()
	{
		$this->template();
		$this->load->view('customerList');
	}
	public function managestore($id){
		$this->template();
		$data['dealAssigned']=$this->db->query("SELECT * from tblAssignedPlaceDeal where id='".$id."'  ")->row();
		$this->load->view('manageStore.php',$data);
	}


	public function manageretailerDeal($id){
		$this->template();
		$data['dealAssigned']=$this->db->query("SELECT * from tblAssignedPlaceDeal where placeId='".$id."'  ")->result();
		// print_r($data);die;
		$this->load->view('retailerDealListing.php',$data);
	}



	public function updateManageStoreDeal(){
		$this->Common_model->update_data('tblAssignedPlaceDeal',array('expiryDate'=>$_POST['expiryDate'],'validFor'=>$_POST['validFor']),array('id'=>$_POST['assignedStore']));
		$this->session->set_flashdata('msg', 'Store Detail updated Successfully.');
		redirect('Admin/managestore/'.$_POST['assignedStore']);
	}
	
	public function managedeal($id){
		$this->template();
		$data['id']=$id;
		$data['retailer']=$this->db->query("SELECT *,(SELECT count(id) from tblStorePlaces where retailerId=tblRetailer.id ) as count,(SELECT count(id) from tblAssignedPlaceDeal where dealId='".$id."' and tblAssignedPlaceDeal.retailerId=tblRetailer.id  ) as totalcount from tblRetailer where isComplete=1  having count > 0 and count > totalcount ")->result();
		$this->load->view('manageDeal.php',$data);
	}

	public function getspecificRetailerplaces(){
		$data=$this->db->query("SELECT *,(SELECT count(id) from tblAssignedPlaceDeal where placeId=tblStorePlaces.id ) as count  from tblStorePlaces where retailerId='".$_POST['retailerId']."' and id not in (SELECT placeId from tblAssignedPlaceDeal where retailerId='".$_POST['retailerId']."' and dealId='".$_POST['dealId']."' ) having count < 4 ")->result();
		print_r(json_encode($data));
	}

	public function newcustomer(){
		$columns = array( 
			0 =>'id', 
			1 =>'firstName',
			3=> 'phoneNo',
			4=> 'dateCreated',
			);
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];

		$totalData = $this->db->query("SELECT * from tblCustomer ")->result();

		$totalFiltered = count($totalData); 

		if(empty($this->input->post('search')['value']))
		{
			$customer=$this->db->limit($limit,$start)->order_by($order,$dir)->get('tblCustomer')->result();
		}
		else {
			$search = $this->input->post('search')['value']; 
			$customer = $this->db->like('id',$search)->or_like('firstName',$search)->or_like('phoneNo',$search)->limit($limit,$start)->order_by($order,$dir)->get('tblCustomer')->result();
			$totalFiltered=$this->db->like('id',$search)->or_like('firstName',$search)->or_like('phoneNo',$search)->get('tblCustomer')->result();
			$totalFiltered=count($totalFiltered);
		}

		$data = array();
		if(!empty($customer))
		{
			$i=1;
			foreach ($customer as $customers)
			{
				$nestedData['id'] = $customers->id;
				$nestedData['srNo'] = $i;
				$nestedData['firstName'] = $customers->firstName;
				$nestedData['suspend'] = $customers->suspend;
				$nestedData['phoneNo'] = $customers->phoneNo;
				$nestedData['profilePic'] = $customers->profilePic;
				$nestedData['dateCreated'] = date('j M Y h:i a',strtotime($customers->dateCreated));
				$data[] = $nestedData;
			}
		}

		$json_data = array(
			"draw"            => intval($this->input->post('draw')),  
			"recordsTotal"    => intval($totalData),  
			"recordsFiltered" => intval($totalFiltered), 
			"data"            => $data   
			);
		echo json_encode($json_data); 
	}

	public function newdeal(){
		$columns = array( 
			0 =>'id', 
			1 =>'dealName',
			3=> 'dealImage',
			4=> 'offerOrDiscount',
			6=> 'description',
			7=> 'termsConditions',
			8=> 'dateCreated',
			);

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];

		$totalData = $this->db->query("SELECT * from tblDeals ")->result();

		$totalFiltered = count($totalData); 

		if(empty($this->input->post('search')['value']))
		{
			$deals=$this->db->limit($limit,$start)->order_by($order,$dir)->get('tblDeals')->result();
		}
		else {
			$search = $this->input->post('search')['value']; 
			$deals = $this->db->like('id',$search)->or_like('dealName',$search)->or_like('offerOrDiscount',$search)->or_like('description',$search)->or_like('termsConditions',$search)->limit($limit,$start)->order_by($order,$dir)->get('tblDeals')->result();
			$totalFiltered=$this->db->like('id',$search)->or_like('dealName',$search)->get('tblDeals')->result();
			$totalFiltered=count($totalFiltered);
		}

		$data = array();
		if(!empty($deals))
		{
			$i=1;
			foreach ($deals as $deals)
			{
				$nestedData['srNo'] = $i;
				$nestedData['id'] = $deals->id;
				$nestedData['dealName'] = $deals->dealName;
				$nestedData['dealImage'] = $deals->dealImage;
				$nestedData['offerOrDiscount'] = $deals->offerOrDiscount;
				$nestedData['expiryDate'] = $deals->expiryDate;
				$nestedData['description'] = $deals->description;
				$nestedData['termsConditions'] = $deals->termsConditions;
				$nestedData['dateCreated'] = date('j M Y h:i a',strtotime($deals->dateCreated));
				$data[] = $nestedData;
				$i++;
			}
		}
		$json_data = array(
			"draw"            => intval($this->input->post('draw')),  
			"recordsTotal"    => intval($totalData),  
			"recordsFiltered" => intval($totalFiltered), 
			"data"            => $data   
			);
		echo json_encode($json_data); 
	}



	public function newstore(){
		$columns = array( 
			0 =>'id', 
			1 =>'storeName',
			2=> 'storeLocation',
			3=> 'storeImage',
			4=> 'description',
			7=> 'dateCreated',
			);

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];

		$totalData = $this->db->query("SELECT * from tblStorePlaces ")->result();

		$totalFiltered = count($totalData); 

		if(empty($this->input->post('search')['value']))
		{
			$deals=$this->db->limit($limit,$start)->order_by($order,$dir)->get('tblStorePlaces')->result();
		}
		else {
			$search = $this->input->post('search')['value']; 
			$deals = $this->db->like('id',$search)->or_like('storeName',$search)->or_like('storeLocation',$search)->or_like('description',$search)->limit($limit,$start)->order_by($order,$dir)->get('tblStorePlaces')->result();
			$totalFiltered=$this->db->like('id',$search)->or_like('storeName',$search)->or_like('storeLocation',$search)->or_like('description',$search)->get('tblStorePlaces')->result();
			$totalFiltered=count($totalFiltered);
		}

		$data = array();
		if(!empty($deals))
		{

			$i=1;
			foreach ($deals as $deals)
			{
				$nestedData['srNo'] = $i;
				$nestedData['id'] = $deals->id;
				$nestedData['storeName'] = $deals->storeName;
				$nestedData['storeLocation'] = $deals->storeLocation;
				$nestedData['storeImage'] = $deals->storeImage;
				$nestedData['description'] = $deals->description;
				$nestedData['dateCreated'] = date('j M Y h:i a',strtotime($deals->dateCreated));
				$data[] = $nestedData;
				$i++;
			}
		}

		$json_data = array(
			"draw"            => intval($this->input->post('draw')),  
			"recordsTotal"    => intval($totalData),  
			"recordsFiltered" => intval($totalFiltered), 
			"data"            => $data   
			);
		echo json_encode($json_data); 
	}
	// new addRetailer 
	public function insertRetailers(){

			$this->template();
			$this->load->view('addretailers');

	}
	public function addRetailers(){
		if (isset($_POST)) {

			if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])  ) {
				echo "0";/*plz fill required field*/
			}
			else{
				function test_input($data)
				{
					$data = trim($data);
					$data = stripslashes($data);
					$data = htmlspecialchars($data);
					return $data;
				}
				function random_username($string) {
					$firstPart = (strtolower($string));
					$nrRand = rand(1000, 9999);
					$username = trim($firstPart).trim($nrRand);
					return $username;
				}
				$email = test_input($_POST["email"]);

				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
						echo "1";/*email is invalid*/
					
				}
				else{
					$checkname=$this->Common_model->selectresult('tblRetailer','*',array('name'=>$_POST['name']));
					if (!empty($checkname)) {
						echo "2";/*naem already */
					}
					else{
						$checkemail=$this->Common_model->selectresult('tblRetailer','*',array('email'=>$_POST['email']));
						if(empty($checkemail)){
							if (empty($_POST['storeAllowed']) || empty($_POST['storeAllowed']) < 0 ) {
								echo "3"; /*store allowed required*/
							}
							else{
								$name=str_replace(' ','',$_POST['name']);
								$userName=random_username(trim($name));
								$password= $_POST['password']; 
								/*mail functioning start*/
								$fromemail="couponapp@gmail.com";
								$data['username'] = $userName;
								$data['password'] = $password;
								$data['name'] = $_POST['name'];
								$subject = "Username and password for coupon App.";
								$mesg = $this->load->view('app/createpassword',$data,true);
								$this->email->to($email);
								$this->email->from($fromemail, "From Coupon App.");
								$this->email->subject($subject);
								$this->email->message($mesg);
								$mail = $this->email->send();
								/*mail functioning end*/

								$this->Common_model->insert_data('tblRetailer',array('email'=>$_POST['email'],'name'=>$_POST['name'],'userName'=>$userName,'password'=>md5($password),'storeAllowed'=>$_POST['storeAllowed']));

								echo "4"; /*retailer added*/
							}
						}
						else{
							echo "5";/*email already exists*/
						}		
					}
				}
			}
		}
		else{
			$this->template();
			$this->load->view('addretailers');
		}
	}
	public function cropimage($image,$x,$y,$w,$h){
		$fileName = time().basename($image["name"]);
		$fileTmp = $image["tmp_name"];
		$fileType = $image["type"];
		$fileSize = $image["size"];
		$fileExt = substr($fileName, strrpos($fileName, ".") + 1);
	    //specify image upload directory
		$largeImageLoc = 'assets/apidata/'.$fileName;
		$thumbImageLoc = 'assets/apidata/'.$fileName;
		if(move_uploaded_file($fileTmp, $largeImageLoc)){
	            //file permission
			chmod ($largeImageLoc, 0777);
	            //get dimensions of the original image
			list($width_org, $height_org) = getimagesize($largeImageLoc);
	            //get image coords
			$x = (int) $x;
			$y = (int) $y;
			$width = (int) $w;
			$height = (int) $h;
	            //define the final size of the cropped image
			$width_new = $width;
			$height_new = $height;
	            //crop and resize image
			$newImage = imagecreatetruecolor($width_new,$height_new);
			switch($fileType) {
				case "image/gif":
				$source = imagecreatefromgif($largeImageLoc); 
				break;
				case "image/pjpeg":
				case "image/jpeg":
				case "image/jpg":
				$source = imagecreatefromjpeg($largeImageLoc); 
				break;
				case "image/png":
				case "image/x-png":
				$source = imagecreatefrompng($largeImageLoc); 
				break;
			}
			imagecopyresampled($newImage,$source,0,0,$x,$y,$width_new,$height_new,$width,$height);
			switch($fileType) {
				case "image/gif":
				imagegif($newImage,$thumbImageLoc); 
				break;
				case "image/pjpeg":
				case "image/jpeg":
				case "image/jpg":
				imagejpeg($newImage,$thumbImageLoc,90); 
				break;
				case "image/png":
				case "image/x-png":
				imagepng($newImage,$thumbImageLoc);  
				break;
			}
			imagedestroy($newImage);
			return  base_url().$thumbImageLoc;
		}else{
			return $error = "Sorry, there was an error uploading your file.";
		}
	}
	public function addCustomer(){
		if (isset($_POST['addedCustomer'])) {
			$checkemail=$this->Common_model->selectresult('tblCustomer','*',array('email'=>$_POST['email']));
			if(empty($checkemail)){
				if (isset($_FILES['profilePic']['name'])) {
					$image='profilePic';
					$upload_path='assets/apidata';
					$profilePic=$this->Common_model->file_upload($upload_path,$image);
				}
				$this->Common_model->insert_data('tblCustomer',array('email'=>$_POST['email'],'phoneNo'=>$_POST['phoneNo'],'name'=>$_POST['name'],'profilePic'=>$profilePic));
				$this->session->set_flashdata('msg', 'Successfully added.');
				redirect('Admin/addCustomer');
			}	
			else{
				$this->session->set_flashdata('msg', 'Email already exists.');
				redirect('Admin/addCustomer');
			}		
		}
		else{
			$this->template();
			$this->load->view('addcustomers');
		}
	}
	public function addDeal(){
		if (isset($_POST['addedDeals'])) {
			$checkDealcount=$this->db->query("SELECT count(id) as count from tblDeals")->row()->count;
			if ($checkDealcount>=6) {
				$this->session->set_flashdata('msg', 'Only six deals allowed.');
				redirect('Admin/addDeal');	
			}
			else{
				$query=$this->db->query("SELECT * from tblDeals where dealName='".$_POST['dealName']."' ")->row();
				if (empty($query)) {
					if (isset($_FILES['dealImage']['name'])) {
						$image='dealImage';
						$upload_path='assets/apidata';
						$dealImage=$this->Common_model->file_upload($upload_path,$image);
					}
					$this->Common_model->insert_data('tblDeals',array('dealName'=>$_POST['dealName'],'dealImage'=>$dealImage,'offerOrDiscount'=>$_POST['offerOrDiscount'],'description'=>$_POST['description'],'termsConditions'=>$_POST['termsConditions']));
					$this->session->set_flashdata('msg', 'New Deal added Successfully.');
					redirect('Admin/addDeal');	
				}
				else{
					$this->session->set_flashdata('msg', 'Same name deal already exists.');
					redirect('Admin/addDeal');	
				}
			}
		}
		else{
			$this->template();
			$this->load->view('addDeal');
		}
	}

	public function addBarCodes($dealId){
		$data['data']=$this->db->query("SELECT * from tblDeals where id='".$dealId."' ")->row();
		$this->template();
		$this->load->view('addBarCode.php',$data);
	}
	public function addtobarcode(){
		if (!empty($_FILES['userFiles']['name'])) {
			$data = array();
			$filesCount = count($_FILES['userFiles']['name']);
			for($i = 0; $i < $filesCount; $i++){
				$checkbarcodeDetail = $this->db->query("SELECT * from tblBarCode where dealId ='".$_POST['dealId']."' ")->num_rows();
				if ($checkbarcodeDetail<100) {
					$_FILES['userFile']['name'] = $_FILES['userFiles']['name'][$i];
					$_FILES['userFile']['type'] = $_FILES['userFiles']['type'][$i];
					$_FILES['userFile']['tmp_name'] = $_FILES['userFiles']['tmp_name'][$i];
					$_FILES['userFile']['error'] = $_FILES['userFiles']['error'][$i];
					$_FILES['userFile']['size'] = $_FILES['userFiles']['size'][$i];

					$uploadPath = 'assets/apidata';
					$config['upload_path'] = $uploadPath;
					$config['allowed_types'] = '*';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					if($this->upload->do_upload('userFile')){
						$fileData = $this->upload->data();
						$image = base_url() . $uploadPath .'/'. $fileData['file_name'];
						$this->Common_model->insert_data('tblBarCode',array('dealId'=>$_POST['dealId'],'barCodeImage'=>$image,'status'=>0));
						$uploadData[$i]['created'] = date("Y-m-d H:i:s");
						$uploadData[$i]['modified'] = date("Y-m-d H:i:s");
					}
				}
				else{
					$this->session->set_flashdata('msg', 'Maximum limit reached of adding Barcodes.');
					redirect('Admin/addBarcodes/'.$_POST['dealId']);
				}
				$this->Common_model->update_data('tblDeals',array('isAvailable'=>1),array('id'=>$_POST['dealId']));

			}
			$this->session->set_flashdata('msg', 'Bar codes added Successfully.');
			redirect('Admin/addBarcodes/'.$_POST['dealId']);
		}
		else{
			$this->session->set_flashdata('msg', 'Please fill valid field.');
			redirect('Admin/addBarcodes/'.$_POST['dealId']);
		}
	}
	
	public function getretailerdetail(){
		$retailerData = $this->db->query("SELECT * from tblRetailer where id ='".$_POST['retailerId']."' ")->result();
		print_r(json_encode($retailerData));
	}

	public function getcustomerdetail(){
		$customerData = $this->db->query("SELECT * from tblCustomer where id ='".$_POST['customerId']."' ")->result();
		print_r(json_encode($customerData));
	}
	public function dealdetail($id){
		$data['barCodeData']= $this->db->query("SELECT * from tblBarCode where dealId ='".$id."' ")->result();
		$data['dealData']= $this->db->query("SELECT * from tblDeals where id ='".$id."' ")->row();
		$this->template();
		$this->load->view('dealDetail.php',$data);
	}
	public function updateRetailer(){
		if (isset($_POST)) {
			$data=array(
				'name'=>$_POST['name'],
				'email'=>$_POST['email'],
				'phoneNo'=>$_POST['phoneNo'],
				'storeAllowed'=>$_POST['storeAllowed'],
				'image'=>$_FILES['image']['name'],
				'logo'=>$_FILES['logo']['name']
				);

			if (empty($_POST['storeAllowed']) || empty($_POST['storeAllowed']) < 0 ) {
				echo 2;
			}
			else{
					// print_r($_FILES);die;
				if (!empty($_FILES['image']['name'])) {
					$image='image';
					$upload_path='assets/apidata';
					$data['image']=$this->Common_model->file_upload($upload_path,$image);
				}
				if (!empty($_FILES['logo']['name'])) {
					$logo='logo';
					$upload_path='assets/apidata';
					$data['logo']=$this->Common_model->file_upload($upload_path,$logo);
				}
				$data=array_filter($data);
				$this->Common_model->update_data('tblRetailer',$data,array('id'=>$_POST['retailerId']));
				$result['res']=1;
				$result['userdetail']=$this->db->query("SELECT * from tblRetailer where id='".$_POST['retailerId']."'")->result();
				print_r(json_encode($result));
			}
		}
		else{
			echo 0;
		}
	}
	public function updateCustomer(){
		if (isset($_POST['editCustomer'])) {
			$data=array('name'=>$_POST['name'],'email'=>$_POST['email'],'phoneNo'=>$_POST['phoneNo']);
			if (!empty($_FILES['profilePic']['name'])) {
				$image='profilePic';
				$upload_path='assets/apidata';
				$data['profilePic']=$this->Common_model->file_upload($upload_path,$image);
			}
			$this->Common_model->update_data('tblCustomer',$data,array('id'=>$_POST['customerId']));
			$this->session->set_flashdata('msg', 'Customer detail updated successfully.');
			redirect('Admin/retailers');
		}
		else{
			$this->session->set_flashdata('msg', 'Please fill required field.');
			redirect('Admin/retailers');
		}
	}


	public function changeretailerStatus(){
		$this->Common_model->update_data('tblRetailer',array('suspend'=>$_POST['val']),array('id'=>$_POST['retailerId']));
		if ($_POST['val']=='1') {
			$this->Common_model->update_data('tblLogin',array('status'=>0),array('userId'=>$_POST['retailerId'],'userType'=>2));
			$this->Common_model->suspendRetailerPush($_POST['retailerId']);
		}
	}


	public function changecustomerStatus(){
		$this->Common_model->update_data('tblCustomer',array('suspend'=>$_POST['val']),array('id'=>$_POST['customerId']));
		if ($_POST['val']=='1') {
			$this->Common_model->update_data('tblLogin',array('status'=>0),array('userId'=>$_POST['customerId'],'userType'=>1));
			$this->Common_model->suspendCustomerPush($_POST['customerId']);
		}
	}


	public function retailerDetail($id){
		$data['retailerData'] = $this->db->query("SELECT * from tblRetailer where id ='".$id."' ")->row();
		$this->template();
		$this->load->view('retailerDetail.php',$data);
		
	}
	public function changepassword(){
		$this->template();
		$this->load->view('changePassword.php');
	}


	public function customerDetail($id){
		$data['customerData'] = $this->db->query("SELECT * from tblCustomer where id ='".$id."' ")->row();
		$this->template();
		$this->load->view('customerDetail.php',$data);
	}

	public function getdealdetail(){
		$data= $this->db->query("SELECT * from tblDeals where id ='".$_POST['dealId']."' ")->result();
		print_r(json_encode($data));
	}

	public function updateDeal(){
		if (isset($_POST['editDeal'])) {		
			$data=array('dealName'=>$_POST['dealName'],'offerOrDiscount'=>$_POST['offerOrDiscount'],'description'=>$_POST['description'],'termsConditions'=>$_POST['termsConditions']);
			if (!empty($_FILES['dealImage']['name'])) {
				$image='dealImage';
				$upload_path='assets/apidata';
				$data['dealImage']=$this->Common_model->file_upload($upload_path,$image);
			}
			$this->Common_model->update_data('tblDeals',$data,array('id'=>$_POST['dealId']));
			$this->session->set_flashdata('msg', 'Deal detail updated successfully.');
			redirect('Admin/deals');
		}
		else{
			$this->session->set_flashdata('msg', 'Please fill required field.');
			redirect('Admin/deals');
		}
	}
	public function newRetailerPlaces($id){
		$columns = array( 
			0 =>'id', 
			1 =>'storeName',
			2=> 'storeLocation',
			3=> 'storeImage',
			);
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];

		$totalData = $this->db->query("SELECT * from tblStorePlaces where retailerId='".$id."' ")->result();

		$totalFiltered = count($totalData); 

		if(empty($this->input->post('search')['value']))
		{
			$deals=$this->db->where('retailerId',$id)->limit($limit,$start)->order_by($order,$dir)->get('tblStorePlaces')->result();
		}
		else {
			$search = $this->input->post('search')['value']; 
			$deals = $this->db->where('retailerId',$id)->like('id',$search)->or_like('storeName',$search)->or_like('storeLocation',$search)->limit($limit,$start)->order_by($order,$dir)->get('tblStorePlaces')->result();
			$totalFiltered=$this->db->where('retailerId',$id)->like('id',$search)->or_like('storeName',$search)->or_like('storeLocation',$search)->get('tblStorePlaces')->result();
			$totalFiltered=count($totalFiltered);
		}

		$data = array();
		if(!empty($deals))
		{
			$i=1;
			foreach ($deals as $deals)
			{
				$dealRunning=$this->db->query("SELECT count(id) as count from tblAssignedPlaceDeal where retailerId='".$deals->retailerId."' and placeId='".$deals->id."'  ")->row()->count;
				$nestedData['srNo'] = $i;
				$nestedData['id'] = $deals->id;
				$nestedData['storeName'] = $deals->storeName;
				$nestedData['storeLocation'] = $deals->storeLocation;
				$nestedData['storeImage'] = $deals->storeImage;
				$nestedData['dealsRunning'] = $dealRunning;
				$data[] = $nestedData;
				$i++;
			}
		}
		$json_data = array(
			"draw"            => intval($this->input->post('draw')),  
			"recordsTotal"    => intval($totalData),  
			"recordsFiltered" => intval($totalFiltered), 
			"data"            => $data   
			);
		echo json_encode($json_data); 
	}

	public function newmanageDeal($id){
		$columns = array( 
			0 =>'id', 
			1 =>'storeName',
			2=> 'name',
			3=> 'storeLocation'
			);
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$totalData = $this->db->query("SELECT *,tblAssignedPlaceDeal.id,tblRetailer.name from tblAssignedPlaceDeal join tblStorePlaces on tblAssignedPlaceDeal.placeId=tblStorePlaces.id join tblRetailer on tblAssignedPlaceDeal.retailerId=tblRetailer.id where tblAssignedPlaceDeal.dealId='".$id."' ")->result();

		$totalFiltered = count($totalData); 

		if(empty($this->input->post('search')['value']))
		{
			$deals=$this->db->query("SELECT *,tblAssignedPlaceDeal.id,tblRetailer.name from tblAssignedPlaceDeal join tblStorePlaces on tblAssignedPlaceDeal.placeId=tblStorePlaces.id join tblRetailer on tblAssignedPlaceDeal.retailerId=tblRetailer.id where tblAssignedPlaceDeal.dealId='".$id."' order by '".$order."' '".$dir."' ")->result();
		}
		else {
			$search = $this->input->post('search')['value']; 

			$deals=$this->db->query("SELECT *,tblAssignedPlaceDeal.id,tblRetailer.name from tblAssignedPlaceDeal join tblStorePlaces on tblAssignedPlaceDeal.placeId=tblStorePlaces.id join tblRetailer on tblAssignedPlaceDeal.retailerId=tblRetailer.id where dealId='".$id."' and (tblAssignedPlaceDeal.id like '".$search."'  or storeName like '%".$search."%' or name like '%".$search."%' or storeLocation like '%".$search."%' ) order by '".$order."' '".$dir."' ")->result();


			$totalFiltered=$this->db->query("SELECT *,tblAssignedPlaceDeal.id,tblRetailer.name from tblAssignedPlaceDeal join tblStorePlaces on tblAssignedPlaceDeal.placeId=tblStorePlaces.id join tblRetailer on tblAssignedPlaceDeal.retailerId=tblRetailer.id where dealId='".$id."' and (tblAssignedPlaceDeal.id like '".$search."'  or storeName like '%".$search."%' or name like '%".$search."%' or storeLocation like '%".$search."%'  )  ")->result();
			$totalFiltered=count($totalFiltered);
		}

		$data = array();
		if(!empty($deals))
		{
			$i=1;
			foreach ($deals as $deals)
			{
				$nestedData['srNo'] = $i;
				$nestedData['id'] = $deals->id;
				$nestedData['storeName'] = $deals->storeName;
				$nestedData['name'] = $deals->name;
				$nestedData['storeLocation'] = $deals->storeLocation;
				$nestedData['storeImage'] = $deals->storeImage;
				$data[] = $nestedData;
				$i++;
			}
		}
		$json_data = array(
			"draw"            => intval($this->input->post('draw')),  
			"recordsTotal"    => intval($totalData),  
			"recordsFiltered" => intval($totalFiltered), 
			"data"            => $data   
			);
		echo json_encode($json_data); 
	}

	public function deleteDeal(){
		$date=date('Y-m-d');
		// $data= $this->db->query("SELECT * from tblDeals where id ='".$_POST['dealId']."' and expiryDate < '".$date."' ")->result();
		// if (!empty($data)) {
		$this->db->where('id', $_POST['dealId']);
		$this->db->delete('tblDeals'); 
		$this->db->where('dealId', $_POST['dealId']);
		$this->db->delete('tblCustomerFavDeals'); 
		$this->db->where('dealId', $_POST['dealId']);
		$this->db->delete('tblGrabbedDeal');
		$this->db->where('dealId', $_POST['dealId']);
		$this->db->delete('tblAssignedPlaceDeal');
		echo "1";
		// }
		// else{
		// 	echo "0";
		// }
	}
	public function removePlace(){
		$this->db->where('id', $_POST['placeId']);
		$this->db->delete('tblStorePlaces');
		$this->db->where('placeId', $_POST['placeId']);
		$this->db->delete('tblAssignedPlaceDeal');
		$this->db->where('placeId', $_POST['placeId']);
		$this->db->delete('tblCustomerFavPlaces');
		$this->db->where('placeId', $_POST['placeId']);
		$this->db->delete('tblGrabbedDeal');
		echo "1"; 
	}


	public function removeAssignedPlace(){
		$this->db->where('id', $_POST['AssignedPlaceId']);
		$this->db->delete('tblAssignedPlaceDeal');
		echo "1"; 
	}

	
	public function checkoldpassword(){
		$result=$this->db->query("SELECT * from tblAdmin where id=1 and password ='".md5($_POST['old_password'])."'")->row();
		if (!empty($result)) {
			echo 1;
		}
		else{
			echo 0;
		}
	}
	public function chanepassword(){
		$this->db->where('id', 1);
		$this->db->update('tblAdmin',array('password'=>md5($_POST['new_password'])));
		echo "1";die;
	}
	public function assigndealtoplace(){
		if (isset($_POST)) {
			foreach ($_POST['storeId'] as $key => $value) {
				$this->Common_model->insert_data('tblAssignedPlaceDeal',array('dealId'=>$_POST['dealId'],'placeId'=>$value,'retailerId'=>$_POST['retailerId']));
			}
			$this->session->set_flashdata('msg', 'Deal assigned successfully.');
			redirect('Admin/managedeal/'.$_POST['dealId']);
		}
		$this->session->set_flashdata('msg', 'Please fill required field.');
		redirect('Admin/managedeal/'.$_POST['dealId']);
	}



}
