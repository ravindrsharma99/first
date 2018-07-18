<?php
error_reporting(0); ini_set('display_errors',0);
require_once APPPATH.'third_party/PHPExcel.php';
require_once APPPATH.'third_party/PHPReport.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	/**
     * @package  CodeIgniter
     * @author   Vijender
     * @category Controller
     *
	 */
	function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->methods['user_post']['limit'] = 100;                     // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50;                    // 50 requests per hour per user/key
        $this->load->library('session');
        $haveAccess = $this->session->userdata('logged_in');
        if (!$haveAccess) {
        	redirect('Login');
        }
        $this->load->model('Admin_model');
        $this->load->helper(array('form', 'url'));
        $this->load->helper('common_helper');
        $this->load->helper('date');
        $this->load->library('email');
        $this->load->library('form_validation');
    }

	public function index()
	{
		// $data['all_users'] = $this->Admin_model->select_data('*',"hb_users",array('user_type'=>0));


		// $data['login_users'] = $this->Admin_model->select_data('*',"hb_login",array('status'=>1));

		$data['all_users']=$this->db->query("SELECT * from hb_users where signup_level=5 and user_type=0")->result();
		// $data['all_users']=count($data['all_users']);

		$data['login_users']=$this->db->query("SELECT * from hb_users join hb_login on hb_login.user_id=hb_users.id where hb_users.signup_level=5 and hb_users.user_type=0 and hb_login.status=1")->result();
		// $data['login_users']=count($data['login_users'])


		$data['spare'] = $this->Admin_model->count_data('*',"hb_donations",array('donation_type'=>0));
		$data['reoccurring'] = $this->Admin_model->count_data('*',"hb_donations",array('donation_type'=>1));

		$data['one_time'] = $this->Admin_model->count_data('*',"hb_donations",array('donation_type'=>2));
		$data['hb_hbcu'] = $this->Admin_model->select_data('*',"hb_hbcu");
		$data['hb_organization'] = $this->Admin_model->select_data('*',"hb_organization");

		$data['partialuser']=$this->db->query("SELECT * from hb_users where user_type!=1 and signup_level!=5")->result();

		$this->load->view('template/header.php');
		$this->load->view('template/subheader.php');
	    $this->load->view('template/sidebar');
		$this->load->view('index.php',$data);
		$this->load->view('template/footer');
	}

	public function logout()
	{
		$this->session->unset_userdata('logged_in');
		$this->session->sess_destroy();
		redirect('Login');
	}

	public function template($view,$data)
	{
		$this->load->view('template/header.php',$data);
		$this->load->view('template/subheader.php');
		$this->load->view('template/sidebar.php');
		$this->load->view($view);
		$this->load->view('template/footer.php');
	}




	public function list_users()
	{

        $data['page_title'] = "Users";
		$data['userData']=$this->db->query("SELECT * from hb_users where user_type!=1 and signup_level=5")->result();
		foreach ($data['userData'] as $key => $value) {
			$abc=$this->db->query("SELECT * from hb_reoccurringDonations where user_id='".$value->id."'")->row();
			if (!empty($abc)) {
				$data['userData'][$key]->isActive=$abc->isActive;
			}
			else{
			    $data['userData'][$key]->isActive='3';	
			}
		}


	
		$this->template('listUsers.php',$data);

	}


	public function partial_list_users()
	{

        $data['page_title'] = "Users";
		$data['userData']=$this->db->query("SELECT * from hb_users where user_type!=1 and signup_level!=5")->result();
		foreach ($data['userData'] as $key => $value) {
			$abc=$this->db->query("SELECT * from hb_reoccurringDonations where user_id='".$value->id."'")->row();
			if (!empty($abc)) {
				$data['userData'][$key]->isActive=$abc->isActive;
			}
			else{
			    $data['userData'][$key]->isActive='3';	
			}
		}


	
		$this->template('partiallistUsers.php',$data);

	}

	
//  To edit user details customers tab
	public function editUser(){
		if (isset($_POST['editUsers'])) {

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


			$id = $this->input->post('editId');
			$hbcu = $this->input->post('hbcu');
			$hbcu = implode(",",$hbcu);
			$oldUser_data = array(
				'first_name'=>$this->input->post('first_name'),
				'email'=>$this->input->post('email'),
				'hbcu'=>$hbcu,
				'organization'=>$this->input->post('organization'),
				'profile'=>$profile
				);
		    
		    $User_data = array_filter($oldUser_data);

			// echo $id;
			// echo "<pre>"; print_r($User_data); die;
			$this->Admin_model->update_data("hb_users",$User_data,array('id'=>$id));
			$this->session->set_flashdata('msg', 'Updated Successfully!');
		}
		
		$data['page_title'] = "Users";
		$data['userData'] = $this->Admin_model->get_users('*','hb_users',array("user_type"=>0));
		// echo "<pre>"; print_r($data['userData']); die;
		$this->template('listUsers.php',$data);

	}


	
public function addHbcu()
	{
     


      if (isset($_POST['title'])) {

			
		       if(isset($_FILES['logo']['name']))
		        {
		          $upload_path = 'Public/hbcu';
		          $image = 'logo';
		          $logo = $this->file_upload($upload_path, $image);
		        }else
		        {
		          $logo="";
		        }


		           if(isset($_FILES['image']['name']))
		        {
		          $upload_path = 'Public/hbcu';
		          $image = 'image';
		          $imagename = $this->file_upload($upload_path, $image);
		        }else
		        {
		          $imagename="";
		        }



  			    $title = $this->input->post('title');
				$oldCat_data = array(
					'title'=>$title,
					'logo'=>$logo,
					'image'=>$imagename
					);
				$catData = array_filter($oldCat_data);


			$this->Admin_model->insert_data("hb_hbcu",$catData);
			$this->session->set_flashdata('msg', 'Added Successfully!');
		}

       $this->template('addHbcu.php');

	}	


	public function editHbcu(){
		if (isset($_POST['editUsers'])) {

			 if(isset($_FILES['logo']['name']))
		        {
		          $upload_path = 'Public/hbcu';
		          $image = 'logo';
		          $logo = $this->file_upload($upload_path, $image);
		        }else
		        {
		          $logo="";
		        }


		             if(isset($_FILES['image']['name']))
		        {
		          $upload_path = 'Public/hbcu';
		          $image = 'image';
		          $imagename = $this->file_upload($upload_path, $image);
		        }else
		        {
		          $imagename="";
		        }



			$id = $this->input->post('editId');
			$title = $this->input->post('title');
			
			$oldUser_data = array(
				'title'=>$title,
				'logo'=>$logo,
				'image'=>$imagename
				);
		    
		    $User_data = array_filter($oldUser_data);
			$this->Admin_model->update_data("hb_hbcu",$User_data,array('id'=>$id));
			$this->session->set_flashdata('msg', 'Updated Successfully!');
		}
		
		redirect('Dashboard/listHbcu');

	}

		public function editorganization1(){
		if (isset($_POST['editUsers'])) {

			 if(isset($_FILES['logo']['name']))
		        {
		          $upload_path = 'Public/hbcu';
		          $image = 'logo';
		          $logo = $this->file_upload($upload_path, $image);
		        }else
		        {
		          $logo="";
		        }



			$id = $this->input->post('editId');
			$title = $this->input->post('title');
			
			$oldUser_data = array(
				'title'=>$title,
				'logo'=>$logo,
				);
		    
		    $User_data = array_filter($oldUser_data);
			$this->Admin_model->update_data("hb_organization",$User_data,array('id'=>$id));
			$this->session->set_flashdata('msg', 'Updated Successfully!');
		}
		
		redirect('Dashboard/listOrganization');

	}



	function deleteHbcu($id)
	{
	   
	      $this->Admin_model->row_delete(array('id'=>$id),'hb_hbcu');
	      redirect("Dashboard/listhbcu");
	   
    }


    	function deleteOrganization($id)
	{

	      $this->Admin_model->row_delete(array('id'=>$id),'hb_organization');
	      redirect("Dashboard/listOrganization");

    }



	public function listHbcu()
	{

        $data['page_title'] = "Users";
		$data['userData'] = $this->Admin_model->get_Hbcu();
		$this->template('listHbcu.php',$data);

	}

		public function lovedhbcu()
	{

		if (isset($_POST['date'])) {
			$date='01/'.$_POST['date'];
			$newDate = date("Y-d-m", strtotime($date));
        	$data['page_title'] = "Users";
			$data['userData'] = $this->Admin_model->datewiselovedhbcu($newDate);
			$data['add']='2';
			$data['url']='http://admin.iheartmyhbcu.org/Dashboard/lovedhbcudatewisexls/?id='.$newDate;
			$this->template('lovedhbcu.php',$data);
		}
		else{

        	$data['page_title'] = "Users";
			$data['userData'] = $this->Admin_model->lovedhbcu();
			$data['add']='1';
			$data['url']='http://admin.iheartmyhbcu.org/Dashboard/lovedhbcumonthxls';
			$this->template('lovedhbcu.php',$data);
		}

	}


		public function topdonors()
	{

		if (isset($_POST['date'])) {
			$date='01/'.$_POST['date'];
			$newDate = date("Y-d-m", strtotime($date));
			$data['page_title'] = "Users";
			$data['userData'] = $this->Admin_model->datewisedonors($newDate);
        	$data['add']='2';
        	$data['url']='http://admin.iheartmyhbcu.org/Dashboard/topdonorsdatewisexls/?id='.$newDate;
			$this->template('topdonors.php',$data);
		}
		else{
	        $data['page_title'] = "Users";
			$data['userData'] = $this->Admin_model->topdonors();
			$data['add']='1';
			$data['url']='http://admin.iheartmyhbcu.org/Dashboard/topdonorsmonthxls';
			$this->template('topdonors.php',$data);
		}
	}

	


	public function referral()
	{

        $data['page_title'] = "Referal";
		$data['userData'] = $this->Admin_model->get_referal();
		$this->template('referal.php',$data);

	}
	public function feedback()
	{

        $data['page_title'] = "Feedback";
		$data['userData'] = $this->Admin_model->get_feedback();
		$this->template('feedback.php',$data);
	}

	

	public function donations()
	{
        $data['page_title'] = "Users";
		$data['userData'] = $this->Admin_model->get_donations();
		$this->template('donations.php',$data);
	}

	public function edituserstatus(){
		// print_r($_POST);die;
		$id=$_POST['title'];
		if (isset($_POST['spare'])&& isset($_POST['reoccur'])  ) {
		$User_data = array(
				'isActivesparechange'=>$_POST['spare']
				);
		$this->Admin_model->update_data("hb_users",$User_data,array('id'=>$id));


		$User_data1 = array(
				'isActivereoccuring'=>$_POST['reoccur']
				);
		$this->Admin_model->update_data("hb_users",$User_data1,array('id'=>$id));


		$this->session->set_flashdata('msg', 'Updated Successfully!');
		redirect('Dashboard/list_users');
		}
		elseif (isset($_POST['spare'])) {
			$User_data = array(
				'isActivesparechange'=>$_POST['spare']
				);
		$this->Admin_model->update_data("hb_users",$User_data,array('id'=>$id));
		$this->session->set_flashdata('msg', 'Updated Successfully!');
		redirect('Dashboard/list_users');

		}
		elseif (isset($_POST['reoccur'])) {
				$User_data1 = array(
				'isActivereoccuring'=>$_POST['reoccur']
				);
		$this->Admin_model->update_data("hb_users",$User_data1,array('id'=>$id));


		$this->session->set_flashdata('msg', 'Updated Successfully!');
		redirect('Dashboard/list_users');
		
		}
		else{
					$this->session->set_flashdata('msg', 'Please selecet at least one field!');
		redirect('Dashboard/list_users');

		}




	}
	public function getuserdetail(){
		// print_r($_POST['id']);die;
		// $id=$_POST['id'];
		$abc['isActivesparechange']=$this->db->query("SELECT isActivesparechange from hb_users where id='".$_POST['id']."'")->row();
		$abc['reoccur']=$this->db->query("SELECT isActivereoccuring from hb_users where id='".$_POST['id']."'")->row();
		if (empty($abc['reoccur'])) {
			$abc['reoccur']='3';
		}
		else{
			$abc['reoccur']=$abc['reoccur']->isActivereoccuring;

		}
		print_r(json_encode($abc));die;

	}



public function addOrganization()
	{

      if (isset($_POST['title'])) {
		       if(isset($_FILES['logo']['name']))
		        {
		          $upload_path = 'Public/hbcu';
		          $image = 'logo';
		          $logo = $this->file_upload($upload_path, $image);
		        }else
		        {
		          $logo="";
		        }

  			    $title = $this->input->post('title');
				$oldCat_data = array(
					'title'=>$title,
					'logo'=>$logo,
					);
				$catData = array_filter($oldCat_data);


			$this->Admin_model->insert_data("hb_organization",$catData);
			$this->session->set_flashdata('msg', 'Added Successfully!');
		}

       $this->template('addOrganization.php');

	}	


	public function editOrganization(){
		if (isset($_POST['editUsers'])) {

			 if(isset($_FILES['logo']['name']))
		        {
		          $upload_path = 'Public/hbcu';
		          $image = 'logo';
		          $logo = $this->file_upload($upload_path, $image);
		        }else
		        {
		          $logo="";
		        }



			$id = $this->input->post('editId');
			$title = $this->input->post('title');
			
			$oldUser_data = array(
				'title'=>$title,
				'logo'=>$logo,
				);
		    
		    $User_data = array_filter($oldUser_data);

			$this->Admin_model->update_data("hb_hbcu",$User_data,array('id'=>$id));
			$this->session->set_flashdata('msg', 'Updated Successfully!');
		}
		
		redirect('Dashboard/listOrganization');

	}
	public function listOrganization()
	{

        $data['page_title'] = "Users";
		$data['userData'] = $this->Admin_model->get_Organization();
		// echo "<pre>"; print_r($data); die;
		$this->template('listOrganization.php',$data);

	}
/////////////////////////////////////////

		public function add_services()
	{
	//	print_r($_POST);

		if (isset($_POST['add_service'])) {


			$service_data = array(
                'category_id'=>$this->input->post('category_id'),
                'subCategory_id'=>$this->input->post('subCategory_id'),
                'ServiceTitle'=>$this->input->post('ServiceTitle'),
                'ServiceType'=>$this->input->post('ServiceType'),
                'price'=>$this->input->post('price'),
                'date_created'=> date('Y-m-d H:i:s')
        	);


			$this->Admin_model->insert_data("tbl_subCategoryServices",$service_data);
			$this->session->set_flashdata('msg', 'Added Successfully!');
		}
		$data['page_title'] = "Add Services";
		$data['dataCat'] = $this->Admin_model->get_data('tbl_categories');
		$this->template('addservices.php',$data);
	}


		
	



	public function editCategory()
	{
		if (isset($_POST['catSubmit'])) {

			foreach ($_FILES as $key => $value) {

				if (!empty($value['name'])) {
					$upload_path = "Public/img/uploaded";
					$image = $key;
					$imagename = $this->file_upload($upload_path, $image);
				}

			}
			$id = $this->input->post('editId');
			$oldCat_data = array(
				'categoryName'=>$this->input->post('catName'),
				'image'=>$imagename,
				'date_created'=> date('Y-m-d H:i:s')
				);
			$catData = array_filter($oldCat_data);


			$this->Admin_model->update_data("tbl_categories",$catData,array('id'=>$id));
			$this->session->set_flashdata('msg', 'Updated Successfully!');
		}
		$data['page_title'] = "Categories";
		$data['mainData'] = $this->Admin_model->get_data('tbl_categories');
		$this->template('listCategory.php',$data);

	}

	public function listServices()
	{
        $data['page_title'] = "Services";
		$data['mainData'] = $this->Admin_model->get_data('tbl_subCategoryServices');
		$this->template('listServices',$data);


	}

		public function listSubsciptions()
	{
        $data['page_title'] = "listSubsciptions";
		$data['subscriptionData'] = $this->Admin_model->get_data('tbl_subscriptionsList');
		$this->template('listSubsciptions',$data);


	}

		public function pay_providers(){
        $data['page_title'] = "Pay";
		$data['mainData'] = $this->Admin_model->selPrData();
		$this->template('providersList',$data);


	}

			public function addSubscription()
	{


		if (isset($_POST['addSubscription'])) {

			$Subscription_data = array(
                'name'=>$this->input->post('STitle'),
                'amount'=>$this->input->post('Samount'),
                'type'=>$this->input->post('SType'),
                'date_created'=> date('Y-m-d H:i:s')
        	);
        	$SubscriptionData = array_filter($Subscription_data);


			$this->Admin_model->insert_data("tbl_subscriptionsList",$SubscriptionData);
			$this->session->set_flashdata('msg', 'Added Successfully!');
		}
		$data['page_title'] = "addSubscriptions";

		$this->template('addsubscription',$data);

	}



		public function editService()
	{


		if (isset($_POST['subCatServiceSubmit'])) {



            $id = $this->input->post('editId');
			$oldservice_data = array(
                'ServiceTitle'=>$this->input->post('serviceTitle'),
                'ServiceType'=>$this->input->post('selServiceType'),
                'price'=>$this->input->post('servicePrice'),
                'date_created'=> date('Y-m-d H:i:s')
        	);
        	$serviceData = array_filter($oldservice_data);


			$this->Admin_model->update_data("tbl_subCategoryServices",$serviceData,array('id'=>$id));
			$this->session->set_flashdata('msg', 'Updated Successfully!');
		}
		$data['page_title'] = "Services";
		$data['mainData'] = $this->Admin_model->get_data('tbl_subCategoryServices');
		$this->template('listServices',$data);

	}


	public function subAdmins()
	{
        $data['page_title'] = "SubAdmins";
		$data['subData'] = $this->db->get('tbl_subadmin')->result();
		$this->template('list_subAdmins',$data);

	}

		public function addPermissions()
	{
       	if (isset($_POST['add_permission'])) {


			$oldaccessData = array(
                'Customers'=>($this->input->post('Customers') == 'on')?1:0,
                'serviceProviders'=>($this->input->post('serviceProviders') == 'on')?1:0,
                'Category'=>($this->input->post('Category') == 'on')?1:0,
                'subCategory'=>($this->input->post('subCategory') == 'on')?1:0,
                'subCategoryServices'=>($this->input->post('subCategoryServices') == 'on')?1:0,
                'requestedServices'=>($this->input->post('requestedServices') == 'on')?1:0,
                'trackServices'=>($this->input->post('trackServices') == 'on')?1:0,
                'Promocodes'=>($this->input->post('Promocodes') == 'on')?1:0,
                'Membership'=>($this->input->post('Membership') == 'on')?1:0,
                'driverSubscription'=>($this->input->post('driverSubscription') == 'on')?1:0,
                'sendNotifications'=>($this->input->post('sendNotifications') == 'on')?1:0,
                'payServiceProviders'=>($this->input->post('payServiceProviders') == 'on')?1:0,
                'Settings'=>($this->input->post('Settings') == 'on')?1:0,
                'editFrontPage'=>($this->input->post('editFrontPage') == 'on')?1:0
        	);
        	$accessData = serialize($oldaccessData);
        	// $editId = $this->input->post('editId');
// print_r($oldaccessData);
// echo"<br>";
// print_r($accessData); die;

		$this->Admin_model->update_data("tbl_subadminAccess",array('tabName'=>$accessData,'date_given'=>date('Y-m-d H:i:s')),array('id'=>$_GET['userId']));
	    $this->session->set_flashdata('msg', 'Updated Successfully!');
		}


        $data['page_title'] = "addPermissions";
        $data['perdata'] = $this->Admin_model->select_data('*','tbl_subadminAccess',array('subAdmin_id'=>$_GET['userId']));
        // $data['eId'] = $_GET['userId'];

		$this->template('addPermission',$data);

	}


// 	   public function editPermissions()
// 	{


// 	if (isset($_POST['add_permission'])) {



// 			$oldaccessData = array(
//                 'Customers'=>($this->input->post('Customers') == 'on')?1:0,
//                 'serviceProviders'=>($this->input->post('serviceProviders') == 'on')?1:0,
//                 'Category'=>($this->input->post('Category') == 'on')?1:0,
//                 'subCategory'=>($this->input->post('subCategory') == 'on')?1:0,
//                 'subCategoryServices'=>($this->input->post('subCategoryServices') == 'on')?1:0,
//                 'requestedServices'=>($this->input->post('requestedServices') == 'on')?1:0,
//                 'trackServices'=>($this->input->post('trackServices') == 'on')?1:0,
//                 'Promocodes'=>($this->input->post('Promocodes') == 'on')?1:0,
//                 'Membership'=>($this->input->post('Membership') == 'on')?1:0,
//                 'driverSubscription'=>($this->input->post('driverSubscription') == 'on')?1:0,
//                 'sendNotifications'=>($this->input->post('sendNotifications') == 'on')?1:0,
//                 'payServiceProviders'=>($this->input->post('payServiceProviders') == 'on')?1:0,
//                 'Settings'=>($this->input->post('Settings') == 'on')?1:0,
//                 'editFrontPage'=>($this->input->post('editFrontPage') == 'on')?1:0
//         	);
//         	$accessData = serialize($oldaccessData);
//         	$editId = $this->input->post('editId');
// // print_r($oldaccessData);
// // echo"<br>";
// // print_r($accessData); die;

// 			$this->Admin_model->update_data("tbl_subadminAccess",array('tabName'=>$accessData,'date_given'=>date('Y-m-d H:i:s')),array('id'=>$editId));
// 			$this->session->set_flashdata('msg', 'Updated Successfully!');
// 		}
//         $data['page_title'] = "addPermissions";
//         $data['perdata'] = $this->Admin_model->select_data('*','tbl_subadminAccess',array('subAdmin_id'=>$editId));

// 		$this->template('addPermission',$data);

// 	}

	public function payMoney(){
		if(isset($_POST['payMoney'])){
			// print_r($_POST); die;
			$wb = $this->Admin_model->select_data('balance','tbl_wallet',array('user_id'=>$_POST['editId']));
			if ($_POST['amount']<=$wb[0]->balance) {
				$nwb = $wb[0]->balance-$_POST['amount'];
				$this->Admin_model->update_data("tbl_wallet",array('balance'=>$nwb),array('user_id'=>$_POST['editId']));
			}else{
				$this->session->set_flashdata('payMoneymsg','1');
			}
		}
		redirect('Dashboard/pay_providers');
	}



	Public function file_upload($upload_path, $image) {                                  /* File upload function */

        $baseurl = base_url();
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '5000';
        $config['max_width'] = '5024';
        $config['max_height'] = '5068';
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($image))
		{
			$error = array(
			'error' => $this->upload->display_errors()
			);
			//print_r($error);die;
			return $imagename = "";
		}
		else
		{
			$detail = $this->upload->data();
			return $imagename = $upload_path .'/'. $detail['file_name'];
		}
    }



    public function ajaxCall(){
	   if(isset($_POST)){

	   $catId = $_POST['catId'];
	   $data = $this->Admin_model->select_data('*','tbl_subCategory',array('category_id'=>$catId));
	   //print_r($data); die;
	   foreach($data as $dropData){
	  echo "<option value = ".$dropData->id." >".$dropData->subCategoryName."</option>";
	}
	  //echo $data;
	  }
    }


    public function ajaxDel(){
	  if(isset($_POST)){

	   $revid = $_POST['revid'];

	   $data = $this->Admin_model->row_delete('tbl_categories',array('id'=>$revid));

	  echo $data;
	  }

	}


    public function ajaxDel1(){
	  if(isset($_POST)){

	   $revid = $_POST['revid'];

	   $data = $this->Admin_model->row_delete('tbl_subCategory',array('id'=>$revid));

	  echo $data;
	  }

	}

    public function ajaxDel2(){
	  if(isset($_POST)){

	   $revid = $_POST['revid'];

	   $data = $this->Admin_model->row_delete('tbl_subCategoryServices',array('id'=>$revid));

	  echo $data;
	  }

	}
	    public function ajaxDel3(){
	  if(isset($_POST)){

	   $revid = $_POST['revid'];

	   $data = $this->Admin_model->row_delete('tbl_subscriptionsList',array('id'=>$revid));

	  echo $data;
	  }

	}

	    public function ajaxPay(){
	  if(isset($_POST)){

	   $payId = $_POST['payId'];
/*
	   $data = $this->Admin_model->row_delete('tbl_subCategoryServices',array('id'=>$payId));*/
	  $data =1;
	  echo $data;
	  }

	}

	public function ajaxDrCall(){
	  if(isset($_POST)){

	   $val = $_POST['status'];

	   $revid = $_POST['revid'];
	   $data = $this->Admin_model->updateReviewStatus($revid,$val);

	  echo $data;
	  }

	}

	public function ajaxUserUpdate(){
	  if(isset($_POST)){
	  	$myid = $_POST['myid'];
	  	$dataSelect = $this->Admin_model->select_data('UserCurrStatus','hb_users',array('id'=>$myid));

	   if($dataSelect[0]->UserCurrStatus == 0){
	   	$nwStatus = 1;
	   }else{
	   	$nwStatus = 0;
	   }


	   $data = $this->Admin_model->updateUserStatus($myid,$nwStatus);

	  echo $data;
	  }

	}


   public function ajaxsubAdminDel(){
	  if(isset($_POST)){

	   $myid = $_POST['myid'];

	   $data = $this->Admin_model->row_delete('tbl_subadmin',array('id'=>$myid));

	  echo $data;
	  }

	}

	public function server_processing()
	{
		// print_r($_GET);die;

		$draw = $_GET['draw'];
		$conditions = array();
		$conditions['tbl_name'] = "mapp_event_report";
		$conditions['selection'] = "*";
		$conditions['order'] = $_GET['order'][0]['dir'];

		switch ($_GET['order'][0]['column']) {
			case 0:
				$conditions['order_by'] = 'eventid';
				break;
			case 1:
				$conditions['order_by'] = 'reportedbyid';
				break;
			case 2:
				$conditions['order_by'] = 'eventid';
				break;
			case 3:
				$conditions['order_by'] = 'eventid';
				break;
			case 4:
				$conditions['order_by'] = 'description';
				break;
			case 5:
				$conditions['order_by'] = 'status';
				break;
			case 5:
				$conditions['order_by'] = 'eventdate';
				break;
			default:
				$conditions['order_by'] = 'eventid';
				break;
		}

		$conditions['limit'] = $_GET['length'];
		$conditions['offset'] = $_GET['start'];
		$conditions['search'] = $_GET['search']['value'];

		// print_r($conditions['search']);die;
		$count = $this->Admin_model->select_data('count(*)','mapp_event_report');
		$table_row_count = $count[0]->count;

		$data = $this->Admin_model->select_where($conditions);
		print_r($data);die;
		if (!empty($conditions['search'])) {
			$recordsFiltered = $data['filteredRows'];
		} else {
			$recordsFiltered = $table_row_count;
		}
		for ($i=0; $i < count($data)-1; $i++) {
			$result[$i][] = $data[$i]->id;
			$result[$i][] = $data[$i]->first_name;
			$result[$i][] = $data[$i]->end_address;
			$result[$i][] = $data[$i]->first_name;
			$result[$i][] = $data[$i]->first_name;
			$result[$i][] = $data[$i]->addedOn;
			$result[$i][] = $data[$i]->estimated_price;
		}
		$res = '{"draw":'.$draw.',
			"recordsTotal":'.$table_row_count.',
			"recordsFiltered":'.$recordsFiltered.',
			"data":'.json_encode($result).'}';
		echo "$res";
	}

	public function iosPush($pushData=null)
	{
		// Put your device token here (without spaces):
		$deviceToken = $pushData['token_id'];
		// Put your private key's passphrase here:
		$passphrase = '';
		// Put your alert message here:
		// $message = 'A push notification has been sent!';
		////////////////////////////////////////////////////////////////////////////////
		$ctx = stream_context_create();
		stream_context_set_option($ctx, 'ssl', 'local_cert', $pushData['pemPath']);
		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
		// Open a connection to the APNS server
		if ($production) {
		    $gateway = 'gateway.push.apple.com:2195';
		} else {
		    $gateway = 'gateway.sandbox.push.apple.com:2195';
		}
		$fp = stream_socket_client($gateway, $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
		// $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
		// print_r($pushData);
		// var_dump($ctx);
		// var_dump($gateway);
		if (!$fp)
		exit("Failed to connect: $err $errstr" . PHP_EOL);
		// echo 'Connected to APNS' . PHP_EOL;
		// Ensure that blocking is disabled
		stream_set_blocking($fp, 0);
		// Create the payload body
		$body['aps'] = $pushData['msg'];
		// Encode the payload as JSON
		$payload = json_encode($body);
		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));
			// if (!$result)
			// 	echo 'Message not delivered' . PHP_EOL;
			// else
			// 	echo 'Message successfully delivered' . PHP_EOL;
		// Close the connection to the server
		fclose($fp);
	}

	public function androidPush($pushData=null)
	{
		$API_ACCESS_KEY = $pushData['API_ACCESS_KEY'];
		$registrationIds = $pushData['token_id'];
		#API access key from Google API's Console
		// define( 'API_ACCESS_KEY', 'YOUR-SERVER-API-ACCESS-KEY-GOES-HERE' );
		// $registrationIds = $_GET['id'];
		#prep the bundle

		$fields = array
		(
			'to'	=> $registrationIds,
			'data'	=> $pushData['msg']
		);
		$headers = array
		(
			'Authorization: key=' . $API_ACCESS_KEY,
			'Content-Type: application/json'
		);
		#Send Reponse To FireBase Server
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );
		#Echo Result Of FireBase Server
		// echo $result;
	}

	public function serviceProviders()
	{
		$data['page_title'] = "Driver on Map";
		$data['pos'] = $this->Admin_model->select_data('latitude as lat, longitude as lng',"hb_users",array('user_type'=>2,'latitude !='=>'','longitude !='=>''));
		$this->template('serviceProviders',$data);
	}

	public function serviceProvidersMap()
	{
		$data['page_title'] = "Driver on Map";
		$data['pos'] = $this->Admin_model->select_data('latitude as lat, longitude as lng',"hb_users",array('user_type'=>2,'latitude !='=>'','longitude !='=>''));
		$this->template('serviceProvidersMap',$data);
	}

	public function providersPosition()
	{
		$position = $this->Admin_model->select_data('*',"hb_users",array('user_type'=>2,'latitude !='=>'','longitude !='=>''));
		echo(json_encode($position));
	}

	public function reqMap()
	{
		$data['page_title'] = "Request on Map";
		$data['pos'] = $this->Admin_model->select_data('pickup_lat as lat, pickup_long as lng',"tbl_bookingRequests",array('pickup_lat !='=>'','pickup_long !='=>''));
		$this->template('reqMap',$data);
	}

	public function pushNotification()
	{
		$data['page_title'] = "Push Notification";
		if (isset($_POST['send'])) {
					// echo "<pre>";
			if ($_POST['client']) {
			    $client = $this->Admin_model->getpusha();
				foreach ($client as $key => $value) {
					$pushData=array();
					$pushData['token_id'] = $value->token_id;
					// echo($pushData['token_id']);
					if ($value->device_id == 0) {
						$pushData['API_ACCESS_KEY'] = "AIzaSyBaMNwomWh3o884269FmM9zYC1HdylJDco";
					    $pushData['msg'] = array(
					       'message' => $_POST['message'],
					       'title' => $_POST['title'],
					       "action" => "bulkPush",
					       'time' => date("Y-m-d H:i:s")
					    );
					   $this->androidPush($pushData);
					}
					else {
					 $pushData['pemPath'] = './certs/moveDev.pem';
					  $pushData['msg'] = array(
					     'message' => $_POST['message'],
					      'title' => $_POST['title'],
					      "action" => "bulkPush",
					      'alert' => $_POST['message'],
					  );
					  $this->iosPush($pushData);
					}
	    		}
			}
			elseif ($_POST['driver']) {
			    $data['driver'] = $this->Admin_model->getpushb();
		        foreach ($data['driver'] as $key => $value) {
		        	$pushData=array();
		        	$pushData['token_id'] = $value->token_id;
					// echo($pushData['token_id']);

					if ($value->device_id == 0) {
						$pushData['API_ACCESS_KEY'] = "AAAAVoM4uNQ:APA91bH0qje7eQquF9p1v-w5vJUOSSxVpqFYnnYePUjldaIuOENladiyA1JrC1dRl_7asQiQlUxmelbePiOhqTHUzJiAULDFPJZYzWMHUp84an02gT3CVpTGM15DkQo6yvG_iMdqJ7Yi";
						$pushData['msg'] = array(
					    'message' => $_POST['message'],
					    'title' => $_POST['title'],
						"action" => "bulkPush",
						"time" => date("Y-m-d H:i:s")
						);
						$this->androidPush($pushData);
					}
					else {
						$pushData['pemPath'] = './certs/driverDev.pem';
						$pushData['msg'] = array(
					    'message' => $_POST['message'],
					    'title' => $_POST['title'],
						"action" => "bulkPush",
						'alert' => $_POST['message'],
						);
						$this->iosPush($pushData);
					}
			    }
			}
			elseif($_POST['all']){
				$data['all'] = $this->Admin_model->getpushall();
				foreach ($data['all'] as $key => $value) {
					$pushData=array();
					// print_r($value->user_type);
					// die();
					$pushData['token_id'] = $value->token_id;
					// echo($pushData['token_id']);

					if ($value->user_type==0) {


						if ($value->device_id == 0) {
							$pushData['API_ACCESS_KEY'] = "AIzaSyBaMNwomWh3o884269FmM9zYC1HdylJDco";

							$pushData['msg'] = array(
							'message' => $_POST['message'],
					    	'title' => $_POST['title'],
							"action" => "bulkPush",
							'time' => date("Y-m-d H:i:s"),

							);
							$this->androidPush($pushData);
						}
						else {
							$pushData['pemPath'] = './certs/moveDev.pem';
							$pushData['msg'] = array(
							'message' => $_POST['message'],
					    	'title' => $_POST['title'],
							"action" => "bulkPush",
							'alert' => "hello",
							'sound' => 'default'
							);
							$this->iosPush($pushData);
						}
					}
					elseif($value->user_type==2) {


						if ($value->device_id == 0) {
							$pushData['API_ACCESS_KEY'] = "AAAAVoM4uNQ:APA91bH0qje7eQquF9p1v-w5vJUOSSxVpqFYnnYePUjldaIuOENladiyA1JrC1dRl_7asQiQlUxmelbePiOhqTHUzJiAULDFPJZYzWMHUp84an02gT3CVpTGM15DkQo6yvG_iMdqJ7Yi";

							$pushData['msg'] = array(
							'message' => $_POST['message'],
					    	'title' => $_POST['title'],
							"action" => "bulkPush",
							'time' => date("Y-m-d H:i:s")
							);
							$this->androidPush($pushData);
						}
						else {
							$pushData['pemPath'] = './certs/driverDev.pem';
							$pushData['msg'] = array(
							'message' => $_POST['message'],
					    	'title' => $_POST['title'],
							"action" => "bulkPush",
							'alert' => "hello",
							'sound' => 'default'
							);
							$this->iosPush($pushData);
						}
					}
				}
			}
			// echo "</pre>";
		}
		$this->template('pushNotification');
	}

	public function membershipList()
	{
		$data['page_title'] = "Membership List";
		$data['membershipList'] = $this->Admin_model->get_data('tbl_membership');
		$this->template('membershipList',$data);
	}

	public function addMembership()
	{
		$data['page_title'] = "Add Membership";
		if (isset($_POST['membership'])) {
			// print_r($_POST);
			$isExist = $this->Admin_model->select_data('*',"tbl_membership",array('membership'=>$_POST['membership']));
			if (empty($isExist)) {
				$this->Admin_model->insert_data('tbl_membership',$_POST);
				$this->session->set_flashdata('msg','1');
			}else{
				$this->session->set_flashdata('msg','0');
			}

		}
		$this->template('addMembership',$data);
	}

	function editMembership()
	{
		$id = $_POST['id'];
		$membership = $_POST['membership'];
  		$validity = $_POST['validity'];
		$price = $_POST['price'];
		$isExist = $this->Admin_model->select_data('*',"tbl_membership",array('membership'=>$membership,'id !='=>$id));
		if (empty($isExist)) {
			if ( ($type==1 && $value<=100) || $type==0 ) {
				$this->Admin_model->update_data("tbl_membership",array('membership'=>$membership,'validity'=>$validity,'price'=>$price),array('id'=>$id));
				$status = 1;
			}else{
				$status = 2;
			}
		}else{
			$status = 0;
		}
		$data = $this->Admin_model->select_data('*',"tbl_membership",array('id'=>$id));

		$response = array();

        $response['data'] = $data;
	    if ( $status == 0 ) {
	        $response['status'] = 'error';
	        $response['message'] = 'Membership already Exist.';
	    }elseif ($status==2) {
	    	$response['status'] = 'error';
	        $response['message'] = 'Invalid Inputs.';
	    } else {
	        $response['status'] = 'success';
	        $response['message'] = 'Updated Successfully!';
	    }

	    echo json_encode($response);
	}

	public function promocodeList()
	{
		$data['page_title'] = "Promocodes List";
		$data['promocodeList'] = $this->Admin_model->get_data('tbl_promocodes');
		$this->template('promocodeList',$data);
	}

	public function addPromocode()
	{

		$data['page_title'] = "Add Promocode";
		if (isset($_POST['promo_code'])) {
			// print_r($_POST);
			$isExist = $this->Admin_model->select_data('*',"tbl_promocodes",array('promo_code'=>$_POST['promo_code']));
			if (empty($isExist)) {
				$this->Admin_model->insert_data('tbl_promocodes',$_POST);
				$this->session->set_flashdata('msg','1');
			}else{
				$this->session->set_flashdata('msg','0');
			}

		}
		$this->template('addPromocode',$data);
	}

	function editPromoCode()
	{

		$id = $_POST['id'];
		$promo_code = $_POST['promo_code'];
  		$value = $_POST['value'];
		$type = $_POST['type'];
		$max_usage = $_POST['max_usage'];
		$usage = $_POST['usage'];
		$expiry_date = $_POST['expiry_date'];
        $date = strtotime($_POST['expiry_date']);
        $newDate = date('Y-m-d H:i:s',$date);
		$isExist = $this->Admin_model->select_data('*',"tbl_promocodes",array('promo_code'=>$promo_code,'id !='=>$id));
		if (empty($isExist)) {
			if ( ($type==1 && $value<=100) || $type==0 ) {
				$this->Admin_model->update_data("tbl_promocodes",array('promo_code'=>$promo_code,'value'=>$value,'type'=>$type,'max_usage'=>$max_usage,'usage'=>$usage,'expiry_date'=>$newDate),array('id'=>$_POST['id']));
				$status = 1;
			}else{
				$status = 2;
			}
		}else{
			$status = 0;
		}
		$data = $this->Admin_model->select_data('*',"tbl_promocodes",array('id'=>$id));

		$response = array();

        $response['data'] = $data;
	    if ( $status == 0 ) {
	        $response['status'] = 'error';
	        $response['message'] = 'Promo Code already Exist.';
	    }elseif ($status==2) {
	    	$response['status'] = 'error';
	        $response['message'] = 'Invalid Inputs.';
	    } else {
	        $response['status'] = 'success';
	        $response['message'] = 'Updated Successfully!';
	    }

	    echo json_encode($response);
	}

	public function settings()
	{
		$data['page_title'] = "Settings";
		$data['settings'] = $this->Admin_model->get_data('tbl_settings');
		$this->template('settings',$data);
	}



	function editSettings()
	{

		$id = $_POST['id'];

		$update_data = array(
			'minBooking_charge'=>$_POST['minBooking_charge'],
			'driverCancellation_charge'=>$_POST['driverCancellation_charge'],
			'userCancellation_hours'=>$_POST['userCancellation_hours'],
			'admin_commission'=>$_POST['admin_commission'],
			'promoReferer_amount'=>$_POST['promoReferer_amount'],
			'promoUser_amount'=>$_POST['promoUser_amount'],
			'wayPoint_charge'=>$_POST['wayPoint_charge'],
			'peakHourCharge'=>$_POST['PeakHourCharge'],
			'peakHourFrom'=>$_POST['peakHrFRom'],
			'peakHourTo'=>$_POST['peakHrTo']

		);

		$this->Admin_model->update_data("tbl_settings",$update_data,array('id'=>$id));
//print_r($thsi->db->last_query()); die;
		$status =1;
		$data = $this->Admin_model->select_data('*',"tbl_settings",array('id'=>$id));

		$response = array();

        $response['data'] = $data;
	    if ( $status == 0 ) {
	        $response['status'] = 'error';
	        $response['message'] = 'Promo Code already Exist.';
	    }elseif ($status==2) {
	    	$response['status'] = 'error';
	        $response['message'] = 'Invalid Inputs.';
	    } else {
	        $response['status'] = 'success';
	        $response['message'] = 'Updated Successfully!';
	    }

	    echo json_encode($response);
	}

	public function ajaxDelUniversal()
	{
		if(isset($_POST)){

			$id = $_POST['id'];
			$tbl_name = $_POST['tbl_name'];

			$data = $this->Admin_model->row_delete($tbl_name,array('id'=>$id));

			echo $data;
		}
	}

	public function geofence()
	{
		$data['page_title'] = "Geofence";
		$id = 1;
		$geofence = $this->Admin_model->select_data('geofence',"tbl_settings",array('id'=>$id));
		$data['geofence'] = $geofence[0]->geofence;
		// var_dump($data['geofence']);die;
		$this->template('geofence',$data);
	}

	public function saveGeofence()
	{
		$id = 1;
		$update_data = array(
			'geofence'=>$_POST['geofence']
		);
		$this->Admin_model->update_data("tbl_settings",$update_data,array('id'=>$id));

		$status =1;
		$response = array();
		if ( $status == 0 ) {
		  $response['status'] = 'error';
		  $response['message'] = 'Not saved please try again';
		}elseif ($status==2) {
		$response['status'] = 'error';
		  $response['message'] = 'Invalid Inputs.';
		} else {
		  $response['status'] = 'success';
		  $response['message'] = 'Updated Successfully!';
		}

		echo json_encode($response);
	}

// To delete user
function deleteUser($id){
    if($_GET['action']=="user_list"){
      $this->Admin_model->row_delete(array('id'=>$id),'hb_users');
      redirect("Dashboard/list_users");
    }
  }
  public function suspenduser($id){


  	    if($_GET['action']=="user_list"){
		$this->Admin_model->update_data("hb_users",array('active_status'=>1),array('id'=>$id));
      redirect("Dashboard/list_users");
    }




  }
    public function activeuser($id){


  	    if($_GET['action']=="user_list"){
		$this->Admin_model->update_data("hb_users",array('active_status'=>0),array('id'=>$id));
      redirect("Dashboard/list_users");
    }
}

public function feedbackxls(){

        $this->excel = new PHPExcel(); 
		$this->excel->setActiveSheetIndex(0);

        $this->excel->getActiveSheet()->setTitle('Feedback list');
        $users=$this->db->query('SELECT id,user_id,rating,subject,comment,created from hb_feedback');
          foreach ($users->result_array() as $row){
                $exceldata[] = $row;
        }
        $i=1;
        foreach ($exceldata as $key => $value) {
        	$abc=$this->db->query("SELECT first_name,last_name from hb_users where id='".$value['user_id']."'")->row();
        	$name=$abc->first_name.' '.$abc->last_name;
        	array_unshift($exceldata[$key],$name);
        	array_unshift($exceldata[$key],$i);
        	$i++;


        }
        $add=array();
        foreach ($exceldata as $key => $value) {
        	unset($value['id']);
        	unset($value['user_id']);
        	$add[]=$value;
        }
        $this->excel->getActiveSheet()->fromArray($add, null, 'A2');
         $this->excel->getActiveSheet()->SetCellValue('A1', 'Sr.No');
        $this->excel->getActiveSheet()->SetCellValue('B1', 'User Name');
        $this->excel->getActiveSheet()->SetCellValue('C1', 'Rating');
        $this->excel->getActiveSheet()->SetCellValue('D1', 'Subject');
        $this->excel->getActiveSheet()->SetCellValue('E1', 'Comment');
        $this->excel->getActiveSheet()->SetCellValue('F1', 'Date time');
        // // read data to active sheet
        $filename='feedback.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');

        //force user to download the Excel file without writing it to server's HD
           
        $objWriter->save('php://output');



	}


    public function referralxls(){

    	 $this->excel = new PHPExcel(); 
		$this->excel->setActiveSheetIndex(0);

        $this->excel->getActiveSheet()->setTitle('Referral list');
    		$dat = $this->Admin_model->get_referalxls();
    		$i=1;
    		foreach ($dat as $key => $value) {

    		 array_unshift($dat[$key],$value['created']);
    		 array_unshift($dat[$key],$value['referedbycount']);
    		 array_unshift($dat[$key],$value['referbyname'].' '.$value['referbylastname']);
    		 array_unshift($dat[$key],$value['first_name'].' '.$value['last_name']);
        	 array_unshift($dat[$key],$i);
    			$i++;
    		}
			$add=array();
			foreach ($dat as $key => $value) {
			unset($value['first_name']);
			unset($value['unique_url']);
			unset($value['referral_link']);
			unset($value['id']);
			unset($value['referbyname']);
			unset($value['referedbycount']);
			unset($value['created']);
			unset($value['last_name']);
			unset($value['referbylastname']);
			$add[]=$value;
			}
		$this->excel->getActiveSheet()->fromArray($add, null, 'A2');
        $this->excel->getActiveSheet()->SetCellValue('A1', 'Sr.No');
        $this->excel->getActiveSheet()->SetCellValue('B1', 'User Name');
        $this->excel->getActiveSheet()->SetCellValue('C1', 'Referred By Name');
        $this->excel->getActiveSheet()->SetCellValue('D1', 'Referred By Refer Count');
        $this->excel->getActiveSheet()->SetCellValue('E1', 'Date time');
        // // read data to active sheet
        $filename='referral.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="referral.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');

        //force user to download the Excel file without writing it to server's HD
           
        $objWriter->save('php://output');	

    
    
    
        }
        public function donationsdxls(){
				$this->excel = new PHPExcel(); 
				$this->excel->setActiveSheetIndex(0);

				$this->excel->getActiveSheet()->setTitle('Donation list');
				$dat = $this->Admin_model->get_donationsxls();


    		$i=1;
    		foreach ($dat as $key => $value) {
    			if ($value['donation_type']==0) {
    				$type="Spare";
    			}
    			if ($value['donation_type']==1) {
    				$type="Reoccuring";
    			}
    			if ($value['donation_type']==2) {
    				$type="One Time";
    			}


    		 array_unshift($dat[$key],$value['dateTime']);
    		 array_unshift($dat[$key],$value['txnId']);
    		 array_unshift($dat[$key],$value['title']);

    		 array_unshift($dat[$key],$value['percentage']);

    		 array_unshift($dat[$key],$type);
    		 array_unshift($dat[$key],$value['amount']);
    		 array_unshift($dat[$key],$value['email']);
    		 array_unshift($dat[$key],$value['first_name'].' '.$value['last_name']);
        	 array_unshift($dat[$key],$i);
    			$i++;
    		}
			$add=array();
			foreach ($dat as $key => $value) {
			unset($value['dateTime']);
			unset($value['txnId']);
			unset($value['donation_type']);
			unset($value['title']);
			unset($value['amount']);
			unset($value['percentage']);
			unset($value['email']);
			unset($value['first_name']);
			unset($value['last_name']);
			unset($value['user_id']);
			$add[]=$value;
			}

		

		$this->excel->getActiveSheet()->fromArray($add, null, 'A2');
        $this->excel->getActiveSheet()->SetCellValue('A1', 'Sr.No');
        $this->excel->getActiveSheet()->SetCellValue('B1', 'User Name');
        $this->excel->getActiveSheet()->SetCellValue('C1', 'Email');
        $this->excel->getActiveSheet()->SetCellValue('D1', 'Amount');
        $this->excel->getActiveSheet()->SetCellValue('E1', 'Donation Type');
        $this->excel->getActiveSheet()->SetCellValue('F1', 'Donation Percentage');
        $this->excel->getActiveSheet()->SetCellValue('G1', 'HBCU');
        $this->excel->getActiveSheet()->SetCellValue('H1', 'Transaction Id');
        $this->excel->getActiveSheet()->SetCellValue('I1', 'Date Time');
        // // read data to active sheet
        $filename='donation.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="donation.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');

        //force user to download the Excel file without writing it to server's HD
           
        $objWriter->save('php://output');	

        }


        public function topdonorsmonthxls(){
        	$this->excel = new PHPExcel(); 
				$this->excel->setActiveSheetIndex(0);
				$this->excel->getActiveSheet()->setTitle('Top Donors Months');
				$dat = $this->Admin_model->topdonorsmonthxls();
				// echo "<pre>";
				// print_r($dat);die;

				    		$i=1;
    		foreach ($dat as $key => $value) {
    		array_unshift($dat[$key],$value['nodonation']);
    		 array_unshift($dat[$key],$value['nodonors']);
    		 array_unshift($dat[$key],$value['donation_amount']);
    		 array_unshift($dat[$key],$value['title']);
    		 array_unshift($dat[$key],$value['organid']);
        	 array_unshift($dat[$key],$i);
    			$i++;
    		}
			$add=array();
			foreach ($dat as $key => $value) {
			unset($value['donation_amount']);
			unset($value['title']);
			unset($value['id']);
			unset($value['logo']);
			unset($value['status']);
			unset($value['organization']);
			unset($value['organid']);
				unset($value['nodonors']);
			unset($value['nodonation']);
			unset($value['created']);

			
			
	
			$add[]=$value;
			}

		

		$this->excel->getActiveSheet()->fromArray($add, null, 'A2');
        $this->excel->getActiveSheet()->SetCellValue('A1', 'Sr.No');
        $this->excel->getActiveSheet()->SetCellValue('B1', 'Id');
        $this->excel->getActiveSheet()->SetCellValue('C1', 'Title');
        $this->excel->getActiveSheet()->SetCellValue('D1', 'Donation Amount');
        $this->excel->getActiveSheet()->SetCellValue('E1', 'No Of Donors');
        $this->excel->getActiveSheet()->SetCellValue('F1', 'No Of Donation');
        // // read data to active sheet
        $filename='rtf.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="topdonorsmonth.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');

        //force user to download the Excel file without writing it to server's HD
           
        $objWriter->save('php://output');


				

        }
               public function topdonorsyearxls(){
        	$this->excel = new PHPExcel(); 
				$this->excel->setActiveSheetIndex(0);
				$this->excel->getActiveSheet()->setTitle('Top Donors Year');
				$dat = $this->Admin_model->topdonorsyearlyxls();
				// echo "<prE>";
				// print_r($dat);die;


				    $i=1;
    		foreach ($dat as $key => $value) {
    			  		 array_unshift($dat[$key],$value['nodonation']);
    		 array_unshift($dat[$key],$value['nodonors']);
    		 array_unshift($dat[$key],$value['donation_amount']);
    		 array_unshift($dat[$key],$value['title']);
    		 array_unshift($dat[$key],$value['organid']);
        	 array_unshift($dat[$key],$i);
    			$i++;
    		}

    		// print_r($dat);die;
			$add=array();
			foreach ($dat as $key => $value) {
			unset($value['donation_amount']);
			unset($value['title']);
			unset($value['id']);
			unset($value['logo']);
			unset($value['status']);
			unset($value['organization']);
			unset($value['organid']);
			unset($value['nodonors']);
			unset($value['nodonation']);
			unset($value['created']);
			
	
			$add[]=$value;
			}
			// echo "<pre>";
			// print_r($add);die;
		$this->excel->getActiveSheet()->fromArray($add, null, 'A2');
        $this->excel->getActiveSheet()->SetCellValue('A1', 'Sr.No');
        $this->excel->getActiveSheet()->SetCellValue('B1', 'Id');
        $this->excel->getActiveSheet()->SetCellValue('C1', 'Title');
        $this->excel->getActiveSheet()->SetCellValue('D1', 'Donation Amount');
                $this->excel->getActiveSheet()->SetCellValue('E1', 'No Of Donors');
        $this->excel->getActiveSheet()->SetCellValue('F1', 'No Of Donation');
        // // read data to active sheet
        $filename='rtf.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="topdonorsyear.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');

        //force user to download the Excel file without writing it to server's HD
           
        $objWriter->save('php://output');


				

        }



        public function lovedhbcumonthxls(){
        	        	$this->excel = new PHPExcel(); 
				$this->excel->setActiveSheetIndex(0);
				$dat = $this->Admin_model->lovedhbcumonthxls();

				  $i=1;
    		foreach ($dat as $key => $value) {
    		 array_unshift($dat[$key],$value['nodonation']);
    		 array_unshift($dat[$key],$value['nodonors']);
    		 array_unshift($dat[$key],$value['donation_amount']);
    		 array_unshift($dat[$key],$value['title']);
    		 array_unshift($dat[$key],$value['hbcuId']);
        	 array_unshift($dat[$key],$i);
    			$i++;
    		}
			$add=array();
			foreach ($dat as $key => $value) {
			unset($value['donation_amount']);
			unset($value['title']);
			unset($value['id']);
			unset($value['logo']);
			unset($value['hbcuId']);
			unset($value['nodonors']);
			unset($value['nodonation']);
			
	
			$add[]=$value;
			}

		

		$this->excel->getActiveSheet()->fromArray($add, null, 'A2');
				$this->excel->getActiveSheet()->setTitle('Loved HBCU Month');
        $this->excel->getActiveSheet()->SetCellValue('A1', 'Sr.No');
        $this->excel->getActiveSheet()->SetCellValue('B1', ' Id');
        $this->excel->getActiveSheet()->SetCellValue('C1', 'Title');
        $this->excel->getActiveSheet()->SetCellValue('D1', 'Donation Amount');
        $this->excel->getActiveSheet()->SetCellValue('E1', 'No Of Donors');
        $this->excel->getActiveSheet()->SetCellValue('F1', 'No Of Donation');
        // // read data to active sheet
        $filename='rtf.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="lovedhbcumonth.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');

        //force user to download the Excel file without writing it to server's HD
           
        $objWriter->save('php://output');

        }


         public function lovedhbcuyearxls(){
         	        	$this->excel = new PHPExcel(); 
				$this->excel->setActiveSheetIndex(0);
				$this->excel->getActiveSheet()->setTitle('Loced HBCU Year');
				$dat = $this->Admin_model->lovedhbcuyearxls();
					  $i=1;
    		foreach ($dat as $key => $value) {
    		array_unshift($dat[$key],$value['nodonation']);
    		 array_unshift($dat[$key],$value['nodonors']);
    		 array_unshift($dat[$key],$value['donation_amount']);
    		 array_unshift($dat[$key],$value['title']);
    		 array_unshift($dat[$key],$value['hbcuId']);
        	 array_unshift($dat[$key],$i);
    			$i++;
    		}
			$add=array();
			foreach ($dat as $key => $value) {
			unset($value['donation_amount']);
			unset($value['title']);
			unset($value['id']);
			unset($value['logo']);
			unset($value['hbcuId']);
				unset($value['nodonors']);
			unset($value['nodonation']);
			$add[]=$value;
			}
		$this->excel->getActiveSheet()->fromArray($add, null, 'A2');
        $this->excel->getActiveSheet()->SetCellValue('A1', 'Sr.No');
        $this->excel->getActiveSheet()->SetCellValue('B1', ' Id');
        $this->excel->getActiveSheet()->SetCellValue('C1', 'Title');
        $this->excel->getActiveSheet()->SetCellValue('D1', 'Donation Amount');
                $this->excel->getActiveSheet()->SetCellValue('E1', 'No Of Donors');
        $this->excel->getActiveSheet()->SetCellValue('F1', 'No Of Donation');
        // // read data to active sheet
        $filename='rtf.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="lovedhbcuyear.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
        	
        }
        public function usertxn($id){


        	if (isset($_POST['date'])) {
        		$data['abc']=$id;
        		$date='01/'.$_POST['date'];
			    $newDate = date("Y-d-m", strtotime($date));
        	    $data['userData'] = $this->Admin_model->get_donations_date($id,$newDate);
        	    $data['add']='1';
        	    $data['url']='http://admin.iheartmyhbcu.org/Dashboard/userdatewisetxnxls?id='.$newDate.'&idi='.$id;
		        $this->template('usertxn.php',$data);
        	}
        	else{
        	$data['abc']=$id;
        	$data['userData'] = $this->Admin_model->get_donations_id($id);
        	$data['add']='2';
        	$data['url']='http://admin.iheartmyhbcu.org/Dashboard/usertxnxls?id='.$id;
		    $this->template('usertxn.php',$data);
        	}
        }


         public function userdatewisetxnxls(){
         	// 

         	$id=$_GET['idi'];
         	$newDate=$_GET['id'];

 
         	 $newDate1= date("F", strtotime($newDate));



        	$this->excel = new PHPExcel(); 
			$this->excel->setActiveSheetIndex(0);
        	$dat = $this->Admin_model->userdatewisetxnxls($id,$newDate);
        	// print_r($dat);die;


        	$i=1;
    		foreach ($dat as $key => $value) {
    			if ($value['donation_type']==0) {
    				$type="Spare";
    			}
    			if ($value['donation_type']==1) {
    				$type="Reoccuring";
    			}
    			if ($value['donation_type']==2) {
    				$type="One Time";
    			}


    		 array_unshift($dat[$key],$value['dateTime']);

    		 
    		 array_unshift($dat[$key],$value['txnId']);
    		 array_unshift($dat[$key],$value['title']);
    		 
    		 // array_unshift($dat[$key],$value['percentage']);
    		 array_unshift($dat[$key],$type);
    		 array_unshift($dat[$key],$value['amount']);
    		 array_unshift($dat[$key],$value['email']);
    		 array_unshift($dat[$key],$value['first_name'].' '.$value['last_name']);
        	 array_unshift($dat[$key],$i);
    			$i++;
    		}
			$add=array();
			foreach ($dat as $key => $value) {
			unset($value['dateTime']);
			unset($value['txnId']);
			unset($value['percentage']);
			unset($value['donation_type']);
			unset($value['title']);
			unset($value['amount']);
			unset($value['email']);
			unset($value['first_name']);
			unset($value['user_id']);
			$add[]=$value;
			}

		
			// $title="dfsdsdsa";
		    // $this->excel->activeSheet->setTitle($title);
		$this->excel->getActiveSheet()->mergeCells('A1:H1');
		    $style = array(
           'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          )
        );
   $this->excel->getActiveSheet()->getStyle("A1")->applyFromArray($style);




		// add some text
		$this->excel->getActiveSheet()->setCellValue('A1','Donation reports of '.$newDate1);

		$this->excel->getActiveSheet()->fromArray($add, null, 'A3');
        $this->excel->getActiveSheet()->SetCellValue('A2', 'Sr.No');
        $this->excel->getActiveSheet()->SetCellValue('B2', 'User Name');
        $this->excel->getActiveSheet()->SetCellValue('C2', 'Email');
        $this->excel->getActiveSheet()->SetCellValue('D2', 'Amount');
        $this->excel->getActiveSheet()->SetCellValue('E2', 'Donation Type');
        // $this->excel->getActiveSheet()->SetCellValue('E1', 'Donation Percent');
        $this->excel->getActiveSheet()->SetCellValue('F2', 'HBCU');
        $this->excel->getActiveSheet()->SetCellValue('G2', 'Transaction Id');
        $this->excel->getActiveSheet()->SetCellValue('H2', 'Date Time');
        // // read data to active sheet
        $filename='rtf.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="usertxn.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');

        //force user to download the Excel file without writing it to server's HD
           
        $objWriter->save('php://output');	

        }



        public function usertxnxls($id){
        	$id=$_GET['id'];

        	$this->excel = new PHPExcel(); 
			$this->excel->setActiveSheetIndex(0);
        	$dat = $this->Admin_model->get_donations_id_xls($id);

        	$i=1;
    		foreach ($dat as $key => $value) {
    			if ($value['donation_type']==0) {
    				$type="Spare";
    			}
    			if ($value['donation_type']==1) {
    				$type="Reoccuring";
    			}
    			if ($value['donation_type']==2) {
    				$type="One Time";
    			}


    		 array_unshift($dat[$key],$value['dateTime']);

    		 
    		 array_unshift($dat[$key],$value['txnId']);
    		 array_unshift($dat[$key],$value['title']);
    		 
    		 // array_unshift($dat[$key],$value['percentage']);
    		 array_unshift($dat[$key],$type);
    		 array_unshift($dat[$key],$value['amount']);
    		 array_unshift($dat[$key],$value['email']);
    		 array_unshift($dat[$key],$value['first_name'].' '.$value['last_name']);
        	 array_unshift($dat[$key],$i);
    			$i++;
    		}
			$add=array();
			foreach ($dat as $key => $value) {
			unset($value['dateTime']);
			unset($value['txnId']);
			unset($value['percentage']);
			unset($value['donation_type']);
			unset($value['title']);
			unset($value['amount']);
			unset($value['email']);
			unset($value['first_name']);
			unset($value['user_id']);
			$add[]=$value;
			}

		

		$this->excel->getActiveSheet()->fromArray($add, null, 'A2');
        $this->excel->getActiveSheet()->SetCellValue('A1', 'Sr.No');
        $this->excel->getActiveSheet()->SetCellValue('B1', 'User Name');
        $this->excel->getActiveSheet()->SetCellValue('C1', 'Email');
        $this->excel->getActiveSheet()->SetCellValue('D1', 'Amount');
        $this->excel->getActiveSheet()->SetCellValue('E1', 'Donation Type');
        // $this->excel->getActiveSheet()->SetCellValue('E1', 'Donation Percent');
        $this->excel->getActiveSheet()->SetCellValue('F1', 'HBCU');
        $this->excel->getActiveSheet()->SetCellValue('G1', 'Transaction Id');
        $this->excel->getActiveSheet()->SetCellValue('H1', 'Date Time');
        // // read data to active sheet
        $filename='rtf.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="usertxn.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');

        //force user to download the Excel file without writing it to server's HD
           
        $objWriter->save('php://output');	

        }

           public function usertotalxls($id){

        	$this->excel = new PHPExcel(); 
			$this->excel->setActiveSheetIndex(0);
        	$dat = $this->Admin_model->get_totaldonations_id_xls($id);
        	// echo "<pre>";
        	// print_r($dat);die;
        	

        	$i=1;
    		foreach ($dat as $key => $value) {


               $add=array();
               foreach ($value['total12'] as $key1 => $value1) {
                    $add[]=$value1->title;
               }
               $hbcu= implode(',',$add);

				if ($value['avgg']=='N/A') {
				$percent="N/A";
				}
				else{

				$add1=array();
				foreach ($value['avgg'] as $key2 => $value3) {
				$add1[]=round($value3->average*100/$value['amount'],2);
				}
				$percent= implode(',',$add1);
				}



    			if ($value['donation_type']==0) {
    				$type="Spare";
    			}
    			if ($value['donation_type']==1) {
    				$type="Reoccuring";
    			}
    			if ($value['donation_type']==2) {
    				$type="One Time";
    			}


    		
    		 array_unshift($dat[$key],$percent);
    		 array_unshift($dat[$key],$hbcu);
    		 array_unshift($dat[$key],$type);
    		 array_unshift($dat[$key],$value['amount']);
    		 array_unshift($dat[$key],$value['email']);
    		 array_unshift($dat[$key],$value['first_name'].' '.$value['last_name']);
        	 array_unshift($dat[$key],$i);
    			$i++;
    		}
    		// echo "<pre>";
    		// print_r($dat);
    		// die;
			$add=array();
			foreach ($dat as $key => $value) {
			unset($value['dateTime']);
			unset($value['avgg']);
			unset($value['txnId']);
			unset($value['donation_type']);
			unset($value['title']);
			unset($value['amount']);
			unset($value['email']);
			unset($value['first_name']);
			unset($value['last_name']);
			unset($value['user_id']);
			unset($value['id']);
			$add[]=$value;
			}

		

		$this->excel->getActiveSheet()->fromArray($add, null, 'A2');
        $this->excel->getActiveSheet()->SetCellValue('A1', 'Sr.No');
        $this->excel->getActiveSheet()->SetCellValue('B1', 'User Name');
        $this->excel->getActiveSheet()->SetCellValue('C1', 'Email');
        $this->excel->getActiveSheet()->SetCellValue('D1', 'Amount');
        $this->excel->getActiveSheet()->SetCellValue('E1', 'Donation Type');
        $this->excel->getActiveSheet()->SetCellValue('F1', 'HBCU');
        $this->excel->getActiveSheet()->SetCellValue('G1', 'Donation Percent');
        // // read data to active sheet
        $filename='rtf.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="totaltxn.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');

        //force user to download the Excel file without writing it to server's HD
           
        $objWriter->save('php://output');	

        }


         public function topdonorsdatewisexls(){

	        $date= $_GET['id'];
	        $newDate1= date("F", strtotime($date));


        	$this->excel = new PHPExcel(); 
				$this->excel->setActiveSheetIndex(0);
				$this->excel->getActiveSheet()->setTitle('Top Donors Months');
				$dat = $this->Admin_model->topdonorsdatewisexls($date);
				// echo "<pre>";
				// print_r($dat);die;

				    		$i=1;
    		foreach ($dat as $key => $value) {
    		array_unshift($dat[$key],$value['nodonation']);
    		 array_unshift($dat[$key],$value['nodonors']);
    		 array_unshift($dat[$key],$value['donation_amount']);
    		 array_unshift($dat[$key],$value['title']);
    		 array_unshift($dat[$key],$value['organid']);
        	 array_unshift($dat[$key],$i);
    			$i++;
    		}
			$add=array();
			foreach ($dat as $key => $value) {
			unset($value['donation_amount']);
			unset($value['title']);
			unset($value['id']);
			unset($value['logo']);
			unset($value['status']);
			unset($value['organization']);
			unset($value['organid']);
				unset($value['nodonors']);
			unset($value['nodonation']);
			unset($value['created']);

			
			
	
			$add[]=$value;
			}

		$this->excel->getActiveSheet()->mergeCells('A1:F1');
		    $style = array(
           'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          )
        );
         $this->excel->getActiveSheet()->getStyle("A1")->applyFromArray($style);




		// add some text
		$this->excel->getActiveSheet()->setCellValue('A1','Top Donors of '.$newDate1);

		$this->excel->getActiveSheet()->fromArray($add, null, 'A3');
        $this->excel->getActiveSheet()->SetCellValue('A2', 'Sr.No');
        $this->excel->getActiveSheet()->SetCellValue('B2', 'Id');
        $this->excel->getActiveSheet()->SetCellValue('C2', 'Title');
        $this->excel->getActiveSheet()->SetCellValue('D2', 'Donation Amount');
        $this->excel->getActiveSheet()->SetCellValue('E2', 'No Of Donors');
        $this->excel->getActiveSheet()->SetCellValue('F2', 'No Of Donation');
        // // read data to active sheet
        $filename='rtf.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="donationtxn.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');

        //force user to download the Excel file without writing it to server's HD
           
        $objWriter->save('php://output');


				

        }


           public function lovedhbcudatewisexls(){

              	$date=$_GET['id'];
              	$newDate1= date("F", strtotime($date));
        	    $this->excel = new PHPExcel(); 
				$this->excel->setActiveSheetIndex(0);
				$dat = $this->Admin_model->lovedhbcuxlss($date);
		

				  $i=1;
    		foreach ($dat as $key => $value) {
    		 array_unshift($dat[$key],$value['nodonation']);
    		 array_unshift($dat[$key],$value['nodonors']);
    		 array_unshift($dat[$key],$value['donation_amount']);
    		 array_unshift($dat[$key],$value['title']);
    		 array_unshift($dat[$key],$value['hbcuId']);
        	 array_unshift($dat[$key],$i);
    			$i++;
    		}
			$add=array();
			foreach ($dat as $key => $value) {
			unset($value['donation_amount']);
			unset($value['title']);
			unset($value['id']);
			unset($value['logo']);
			unset($value['hbcuId']);
			unset($value['nodonors']);
			unset($value['nodonation']);
			
	
			$add[]=$value;
			}

		
		$this->excel->getActiveSheet()->mergeCells('A1:F1');
		    $style = array(
           'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          )
        );
   $this->excel->getActiveSheet()->getStyle("A1")->applyFromArray($style);




		// add some text
		$this->excel->getActiveSheet()->setCellValue('A1','Loved HBCU of '.$newDate1);


		$this->excel->getActiveSheet()->fromArray($add, null, 'A3');
				$this->excel->getActiveSheet()->setTitle('Loved HBCU Month');
        $this->excel->getActiveSheet()->SetCellValue('A2', 'Sr.No');
        $this->excel->getActiveSheet()->SetCellValue('B2', ' Id');
        $this->excel->getActiveSheet()->SetCellValue('C2', 'Title');
        $this->excel->getActiveSheet()->SetCellValue('D2', 'Donation Amount');
        $this->excel->getActiveSheet()->SetCellValue('E2', 'No Of Donors');
        $this->excel->getActiveSheet()->SetCellValue('F2', 'No Of Donation');
        // // read data to active sheet
        $filename='rtf.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="lovedhbcumonth.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');

        //force user to download the Excel file without writing it to server's HD
           
        $objWriter->save('php://output');

        }

        public function allusersdownload(){ 

        	$dat = $this->db->query("SELECT id,first_name,last_name,email,created,organization from hb_users where signup_level=5 and  user_type!=1")->result_array();

        	foreach ($dat as $key => $value) {
    
	        	$result1 = $this->db->query("SELECT hb_hbcu.title,hb_hbcu.id,hb_usersHBCU.user_id from hb_usersHBCU  join  hb_hbcu on(hb_hbcu.id=hb_usersHBCU.hbcu) where hb_usersHBCU.user_id = '".$value['id']."'")->result();
					$title=array();
					foreach ($result1 as $key1 => $value1) {
						$title[]=$value1->title;
					}
					$dat[$key]['title']=implode(',',$title);
	
        	}
        	foreach ($dat as $key => $value) {
				if (!empty($value['organization'])) {
					$abc=$this->db->query("SELECT * from  hb_organization where id='".$value['organization']."' ")->row();	      		
					$dat[$key]['organization12']=$abc->title;
				}
				else{
					$dat[$key]['organization12']="";	
				}

				$abc=$this->db->query("SELECT * from hb_login where user_id='".$value['id']."' and status=1 ")->row();

				$status=$abc->status;

				if ($status==1) {
				$dat[$key]['status']= "Active";
				}
				elseif($status==0){
				$dat[$key]['status']= "Inactive";
				}
        	}


        	$this->excel = new PHPExcel(); 
			$this->excel->setActiveSheetIndex(0);

        	$i=1;
    		foreach ($dat as $key => $value) {
		
			 		 array_unshift($dat[$key],$value['status']);
			 		 array_unshift($dat[$key],$value['created']);
			 		 array_unshift($dat[$key],$value['organization12']);
			 		 array_unshift($dat[$key],$value['title']);
			 		 array_unshift($dat[$key],$value['email']);
			 		 array_unshift($dat[$key],$value['last_name']);
			 		 array_unshift($dat[$key],$value['first_name']);
			     	 array_unshift($dat[$key],$i);
			 			$i++;
    		}
    
  
			$add=array();
			foreach ($dat as $key => $value) {
			unset($value['organization']);
			unset($value['id']);
			unset($value['first_name']);
			unset($value['last_name']);
			unset($value['email']);
			unset($value['created']);
			unset($value['organization']);
			unset($value['title']);
			unset($value['organization12']);
			unset($value['status']);
			$add[]=$value;
			}

		

		$this->excel->getActiveSheet()->fromArray($add, null, 'A2');
        $this->excel->getActiveSheet()->SetCellValue('A1', 'Sr.No');
        $this->excel->getActiveSheet()->SetCellValue('B1', 'First Name');
        $this->excel->getActiveSheet()->SetCellValue('C1', 'Last Name');
        $this->excel->getActiveSheet()->SetCellValue('D1', 'Email');
        $this->excel->getActiveSheet()->SetCellValue('E1', 'HBCU');
        // $this->excel->getActiveSheet()->SetCellValue('E1', 'Donation Percent');
        $this->excel->getActiveSheet()->SetCellValue('F1', 'Organization');
        $this->excel->getActiveSheet()->SetCellValue('G1', 'Member Since');
        $this->excel->getActiveSheet()->SetCellValue('H1', 'Status');
        // // read data to active sheet
        $filename='rtf.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="userdata.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');

        //force user to download the Excel file without writing it to server's HD
           
        $objWriter->save('php://output');	

        }



        public function partiallusersdownload(){ 

        	$dat = $this->db->query("SELECT id,first_name,last_name,email,created,organization,signup_level from hb_users where signup_level!=5 and  user_type!=1")->result_array();

        	foreach ($dat as $key => $value) {
    
	        	$result1 = $this->db->query("SELECT hb_hbcu.title,hb_hbcu.id,hb_usersHBCU.user_id from hb_usersHBCU  join  hb_hbcu on(hb_hbcu.id=hb_usersHBCU.hbcu) where hb_usersHBCU.user_id = '".$value['id']."'")->result();
					$title=array();
					foreach ($result1 as $key1 => $value1) {
						$title[]=$value1->title;
					}
					$dat[$key]['title']=implode(',',$title);
	
        	}
        	foreach ($dat as $key => $value) {
				if (!empty($value['organization'])) {
					$abc=$this->db->query("SELECT * from  hb_organization where id='".$value['organization']."' ")->row();	      		
					$dat[$key]['organization12']=$abc->title;
				}
				else{
					$dat[$key]['organization12']="";	
				}


				if ($value['signup_level']==1) {
					$dat[$key]['level']= "Basic Info";
				}
				elseif($value['signup_level']==2){
					$dat[$key]['level']="HBCU Added";
				}
				elseif($value['signup_level']==3){
					$dat[$key]['level']= "Bank Added";
				}
				elseif($value['signup_level']==4){
					$dat[$key]['level']= "Card Added";
				}
        	}


        	$this->excel = new PHPExcel(); 
			$this->excel->setActiveSheetIndex(0);

        	$i=1;
    		foreach ($dat as $key => $value) {
		
			 		 array_unshift($dat[$key],$value['level']);
			 		 array_unshift($dat[$key],$value['created']);
			 		 array_unshift($dat[$key],$value['organization12']);
			 		 array_unshift($dat[$key],$value['title']);
			 		 array_unshift($dat[$key],$value['email']);
			 		 array_unshift($dat[$key],$value['last_name']);
			 		 array_unshift($dat[$key],$value['first_name']);
			     	 array_unshift($dat[$key],$i);
			 			$i++;
    		}
    		// echo "<prE>";
    		// print_r($dat);die;
  
			$add=array();
			foreach ($dat as $key => $value) {
			unset($value['organization']);
			unset($value['id']);
			unset($value['first_name']);
			unset($value['last_name']);
			unset($value['email']);
			unset($value['created']);
			unset($value['organization']);
			unset($value['title']);
			unset($value['organization12']);
			unset($value['signup_level']);
			unset($value['level']);
			$add[]=$value;
			}

		

		$this->excel->getActiveSheet()->fromArray($add, null, 'A2');
        $this->excel->getActiveSheet()->SetCellValue('A1', 'Sr.No');
        $this->excel->getActiveSheet()->SetCellValue('B1', 'First Name');
        $this->excel->getActiveSheet()->SetCellValue('C1', 'Last Name');
        $this->excel->getActiveSheet()->SetCellValue('D1', 'Email');
        $this->excel->getActiveSheet()->SetCellValue('E1', 'HBCU');
        // $this->excel->getActiveSheet()->SetCellValue('E1', 'Donation Percent');
        $this->excel->getActiveSheet()->SetCellValue('F1', 'Organization');
        $this->excel->getActiveSheet()->SetCellValue('G1', 'Member Since');
        $this->excel->getActiveSheet()->SetCellValue('H1', 'Signup Level');
        // // read data to active sheet
        $filename='rtf.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="userdata.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');

        //force user to download the Excel file without writing it to server's HD
           
        $objWriter->save('php://output');	

        }


}
