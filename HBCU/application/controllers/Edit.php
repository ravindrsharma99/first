<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

  class Edit extends CI_Controller {

	function __construct() {
        // Construct the parent class
        parent::__construct();
        // Configure limits on our controller methods
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
        // $this->load->library('ckeditor');
        $this->load->model('Admin_model');
        $this->load->helper('date');  
        $this->load->helper(array('form', 'url'));
  //       $this->load->helper('ckeditor');
  //       $this->data['ckeditor'] = array(
 
		// 	//ID of the textarea that will be replaced
		// 	'id' 	=> 	'content',
		// 	'path'	=>	'js/ckeditor',
 
		// 	//Optionnal values
		// 	'config' => array(
		// 		'toolbar' 	=> 	"Full", 	//Using the Full toolbar
		// 		'width' 	=> 	"550px",	//Setting a custom width
		// 		'height' 	=> 	'100px',	//Setting a custom height
 
		// 	),
 
		// 	//Replacing styles from the "Styles tool"
		// 	'styles' => array(
 
		// 		//Creating a new style named "style 1"
		// 		'style 1' => array (
		// 			'name' 		=> 	'Blue Title',
		// 			'element' 	=> 	'h2',
		// 			'styles' => array(
		// 				'color' 	=> 	'Blue',
		// 				'font-weight' 	=> 	'bold'
		// 			)
		// 		),
 
		// 		//Creating a new style named "style 2"
		// 		'style 2' => array (
		// 			'name' 	=> 	'Red Title',
		// 			'element' 	=> 	'h2',
		// 			'styles' => array(
		// 				'color' 		=> 	'Red',
		// 				'font-weight' 		=> 	'bold',
		// 				'text-decoration'	=> 	'underline'
		// 			)
		// 		)				
		// 	)
		// );
 
		// $this->data['ckeditor_2'] = array(
 
		// 	//ID of the textarea that will be replaced
		// 	'id' 	=> 	'content_2',
		// 	'path'	=>	'js/ckeditor',
 
		// 	//Optionnal values
		// 	'config' => array(
		// 		'width' 	=> 	"550px",	//Setting a custom width
		// 		'height' 	=> 	'100px',	//Setting a custom height
		// 		'toolbar' 	=> 	array(	//Setting a custom toolbar
		// 			array('Bold', 'Italic'),
		// 			array('Underline', 'Strike', 'FontSize'),
		// 			array('Smiley'),
		// 			'/'
		// 		)
		// 	),
 
		// 	//Replacing styles from the "Styles tool"
		// 	'styles' => array(
 
		// 		//Creating a new style named "style 1"
		// 		'style 3' => array (
		// 			'name' 		=> 	'Green Title',
		// 			'element' 	=> 	'h3',
		// 			'styles' => array(
		// 				'color' 	=> 	'Green',
		// 				'font-weight' 	=> 	'bold'
		// 			)
		// 		)
 
		// 	)
		// );		
 
  //       $this->ckeditor->basePath = base_url().'Public/assets/ckeditor/';
  //       $this->ckeditor->config['toolbar'] = array(
  //               array( 'Source', '-', 'Bold', 'Italic', 'Underline', '-','Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','NumberedList','BulletedList' )
  //                                                   );
  //       $this->ckeditor->config['language'] = 'it';
  //       $this->ckeditor->config['width'] = '730px';
  //       $this->ckeditor->config['height'] = '300px';            

    }


	public function index() {
		// $sql = "your-table
		if(isset($_POST['Submit'])){
			unset($_POST['Submit']);
			$data = $this->db->query('select * from tbl_FAQ')->num_rows();
			if($data==0){
$this->db->insert('tbl_FAQ', $_POST); 	
			}else{
				$this->db->update('tbl_FAQ', $_POST); 
						
			}
		}
		$result['columns'] = $this->db->query('SHOW COLUMNS FROM  tbl_FAQ')->num_rows();
		$result['data'] = $this->db->query('select * from tbl_FAQ')->row();
	
		// print_r($result);die();
 		$this->load->view('template/header');
		$this->load->view('template/subheader');
	    $this->load->view('template/sidebar');
		$this->load->view('editor',$result);
		$this->load->view('template/footer');
 
}

}