<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {

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
        $this->load->model('Admin_model');
        $this->load->helper('date');  
        $this->load->helper(array('form', 'url'));
       // $this->load->library('email', $config);
        $this->load->library('form_validation');

    }

     public function Terms_Condition(){
     $this->load->view('Termsandconditions');
     }
     public function PrivacyPolicy(){
     $this->load->view('PrivacyPolicy');
     }
     public function faq(){
     $this->load->view('faq');
     }
     public function Contactus(){
     $this->load->view('Contactus');
     }
     public function Pricing(){
     $this->load->view('Pricing');
     }
}
