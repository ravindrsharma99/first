<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('adddata')){
   function adddata($tbl,$data){

       $ci =& get_instance();
       $ci->load->database(); 
       // $query = $ci->db->get_where('users',array('id'=>$id));       
       // if($query->num_rows() > 0){
       //     $result = $query->row_array();
       //     return $result;
       // }else{
       //     return false;
       // }
   }
}
