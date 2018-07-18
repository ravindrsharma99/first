 <?php
 defined('BASEPATH') OR exit('No direct script access allowed');
 class App_model extends CI_Model{
 	public function __construct() {
 		parent::__construct();
 		$this->load->model('Common_model');

 	}
 	public function updatePlace($placeId,$data){
 		$query=$this->Common_model->update_data('tblStorePlaces',$data,$placeId);
 		$data=$this->Common_model->selectrow('tblStorePlaces',$placeId,'*');
		$response= $this->Common_model->sucessResponse('Place updated succesfully',$data);
 		return $response; 
 	}
 	public function updateDeal($dealId,$data){
 		$query=$this->Common_model->update_data('tblDeals',$data,$dealId);
 		$data=$this->Common_model->selectrow('tblDeals',$dealId,'*');
		$response= $this->Common_model->sucessResponse('Deal updated succesfully',$data);
 		return $response; 
 	}


}