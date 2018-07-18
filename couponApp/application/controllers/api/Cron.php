
    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require APPPATH . '/libraries/REST_Controller.php';

    /**
    * This is an example of a few basic user interaction methods you could use
    * all done with a hardcoded array
    *
    * @package         CodeIgniter
    * @subpackage      Rest Server
    * @category        Controller
    * @author          Ravinder Sharma,Osvin web solution.
    * @license         MIT
    * @link            https://github.com/chriskacerguis/codeigniter-restserver
    */
    class Cron extends REST_Controller {
		function __construct(){
			parent::__construct();
		
		}
		public function croneFreeBarcode_get(){
			$query=$this->db->query("SELECT * from tblGrabbedDeal join  tblBarCode on tblBarCode.id=tblGrabbedDeal.barCodeId where tblBarCode.status=1  ")->result();
			print_r($query);
			foreach ($query as $key => $value) {
				$endTime = date('Y-m-d H:i:s',strtotime("+5 minutes",strtotime($value->usedDateTime)));
				$dateTime=date('Y-m-d H:i:s');
				if ($endTime < $dateTime ) {
		    		$this->Common_model->update_data('tblBarCode',array('status'=>0),array('id'=>$value->barCodeId));
		    		$this->Common_model->freebarcodepush($value->customerId);
				}
			}
		}



		

		
}
