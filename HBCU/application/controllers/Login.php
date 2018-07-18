<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
     * @package  CodeIgniter
     * @author   Saurabh
     * @category Controller
     *
	 */
	function __construct() {
        // Construct the parent class
        parent::__construct();
        // Configure limits on our controller methods

        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key

        $this->load->library('session');
        $haveAccess = $this->session->userdata('logged_in');
        if ($haveAccess) {
        	redirect('Dashboard');
        }

        $this->load->model('Admin_model');
        $this->load->helper('date');  
        $this->load->helper(array('form', 'url'));
        $this->load->library('email');
        $this->load->library('form_validation');

    }



	public function index()
	{

      
        if (isset($_POST['login'])) {
            $get_data = $this->Admin_model->admin_login($_POST);
            // print_r($get_data);
            // die;
            if (!empty($get_data)) {
                $this->session->set_userdata('logged_in',$get_data);
                redirect('Dashboard');
            }else{

               
                $this->session->set_flashdata('msg', 'Invalid Credentials');
               
            }
            // print_r($_SESSION);die;
        }
        $data['page_title'] = "Admin Login";
        $this->load->view('template/header.php');
		$this->load->view('login.php',$data);
	}
}

 