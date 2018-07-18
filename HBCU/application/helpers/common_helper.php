<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('get_user_details')){

	function get_user_details($user_id){
        // get_instance() function returns the main CodeIgniter object.
		$CI =& get_instance();

       //load databse library
		$CI->load->database();
		$query = $CI->db->get_where('tbl_users',array('id'=>$user_id));
		if($query->num_rows() > 0){
			$result = $query->row_array();
			return $result;
		}else{
			return false;
		}
	}
}


if ( ! function_exists('get_all_user')){

	function get_all_user(){
        // get_instance() function returns the main CodeIgniter object.
		$CI =& get_instance();

       //load databse library
		$CI->load->database();
		$query = $CI->db->get('hb_users');
		// $CI->db->where('user_type',0);
		if($query->num_rows() > 0){
			$result = $query->result();
			return $result;
		}else{
			return false;
		}
	}
}

if ( ! function_exists('get_all_hbcu_title')){

	function get_all_hbcu_title(){
        // get_instance() function returns the main CodeIgniter object.
		$CI =& get_instance();

       //load databse library
		$CI->load->database();
		$query = $CI->db->get('hb_hbcu');
		if($query->num_rows() > 0){
			$result = $query->result();
			return $result;
		}else{
			return false;
		}
	}
}

if ( ! function_exists('get_all_organization_title')){

	function get_all_organization_title(){
        // get_instance() function returns the main CodeIgniter object.
		$CI =& get_instance();

       //load databse library
		$CI->load->database();
		$query = $CI->db->get('hb_organization');
		if($query->num_rows() > 0){
			$result = $query->result();
			return $result;
		}else{
			return false;
		}
	}
}

if ( ! function_exists('is_logged_in')){
	function is_logged_in(){
		$CI =& get_instance();
		$is_logged_in = $CI->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			echo 'You don\'t have permission to access this page. <a href="../login">Login</a>';
			die();
		}
	}

if ( ! function_exists('get_login_user')){

	function get_login_user(){
        // get_instance() function returns the main CodeIgniter object.
		$CI =& get_instance();

       //load databse library
		$CI->load->database();
		$query = $CI->db->get('hb_login');
		if($query->num_rows() > 0){
			$result = $query->result();
			return $result;
		}else{
			return false;
		}
	}
}

}