
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
    class App extends REST_Controller {
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
			$this->load->helper('smiley');
		}
		public function index(){
			$this->load->view('welcome_message');
		}

		public function addPlace_post(){
			$data=array(
			'retailerId'=>$this->input->post('retailerId'),
			'storeName'=>$this->input->post('storeName'),
			'storeLocation'=>$this->input->post('storeLocation'),
			'city'=>$this->input->post('city'),
			'state'=>$this->input->post('state'),
			'latitude'=>$this->input->post('latitude'),
			'longitude'=>$this->input->post('longitude'),
			'description'=>$this->input->post('description'),
			);

			if (empty($data['retailerId'])){
				$response=$this->Common_model->requiredResponse();
			}
			else{
				if (isset($_FILES['storeImage'])) {
					$image='storeImage';
					$upload_path='assets/apidata';
					$imagename=$this->Common_model->file_upload($upload_path,$image);
					$data['storeImage']=$imagename;
				}
				$checkResponse=$this->Common_model->insert_data('tblStorePlaces',$data);
				if ($checkResponse) {
	 				$query=$this->Common_model->selectrow('tblStorePlaces',array('id'=>$checkResponse),'*');
	 				$response= $this->Common_model->sucessResponse('place added succesfully',$query);
				}
				else{
	 				$response= $this->Common_model->errorResponse('Something went Wrong');
				}
			}
			$this->set_response($response,REST_Controller::HTTP_OK);
		}
		

		public function deletePlace_post(){
			$placeId=$this->input->post('placeId');
			if (empty($placeId)) {
				$response=$this->Common_model->requiredResponse();
			}
			else{
				$this->db->delete('tblStorePlaces', array('id' => $placeId)); 
				$response= $this->Common_model->sucessResponse('Place deleted succesfully');
			}
			$this->set_response($response,REST_Controller::HTTP_OK);
		}

		public function updatePlace_post(){
			$placeId=$this->input->post('placeId');

			if (empty($placeId)) {
				$response=$this->Common_model->requiredResponse();
			}
			else{
				$data=array(
					'storeName'=>$this->input->post('storeName'),
					'storeLocation'=>$this->input->post('storeLocation'),
					'latitude'=>$this->input->post('latitude'),
					'longitude'=>$this->input->post('longitude'),
					'description'=>$this->input->post('description'),
					'city'=>$this->input->post('city'),
					'state'=>$this->input->post('state'),
				);
				if (isset($_FILES['storeImage'])) {
					$image='storeImage';
					$upload_path='assets/apidata';
					$imagename=$this->Common_model->file_upload($upload_path,$image);
					$data['storeImage']=$imagename;
				}
				$placeId=array('id'=>$placeId);
				$response=$this->App_model->updatePlace($placeId,$data);
			}
			$this->set_response($response,REST_Controller::HTTP_OK);
		}
	
		public function placeDetail_post(){
			$placeId=$this->input->post('placeId');
			$retailerId=$this->input->post('retailerId');
			$currentDate=date('Y-m-d');
			$query=$this->Common_model->selectrow('tblStorePlaces',array('id'=>$placeId),'*');
			$query->runningDeals=$this->db->query("SELECT * from tblDeals join tblAssignedPlaceDeal on tblAssignedPlaceDeal.dealId=tblDeals.id  where tblAssignedPlaceDeal.placeId='".$placeId."' and expiryDate >='".$currentDate."' and isAvailable=1 ")->result();
			if (!empty($query)) {
	 			$response= $this->Common_model->sucessResponse('Your data shows succesfully',$query);
			}
			else{
	 			$response= $this->Common_model->errorResponse('No data exists in table.');
			}
			$this->set_response($response,REST_Controller::HTTP_OK);
		}
		public function dealDetail_post(){
			$dealId=$this->input->post('dealId');
			$retailerId=$this->input->post('retailerId');

			$query=$this->Common_model->selectrow('tblDeals',array('id'=>$dealId),'*');
			$query->storePlaces=$this->db->query("SELECT * from tblStorePlaces join tblAssignedPlaceDeal on tblAssignedPlaceDeal.placeId=tblStorePlaces.id  where tblAssignedPlaceDeal.dealId='".$dealId."' and  tblStorePlaces.retailerId='".$retailerId."'")->result();
			if (!empty($query)) {
	 			$response= $this->Common_model->sucessResponse('Your data shows succesfully',$query);
			}
			else{
	 			$response= $this->Common_model->errorResponse('No data exists in table.');
			}
			$this->set_response($response,REST_Controller::HTTP_OK);
		}

		public function PlaceDeals_post(){
			$placeId=$this->input->post('placeId');
			$retailerId=$this->input->post('retailerId');
			$offset=$this->input->post('offset');
			$currentDate=date('Y-m-d');
			$query=$this->db->query("SELECT * from tblDeals join tblAssignedPlaceDeal on tblAssignedPlaceDeal.dealId=tblDeals.id  where tblAssignedPlaceDeal.placeId='".$placeId."' and expiryDate >='".$currentDate."'  and isAvailable=1 ")->result();
			
			$count=count($query);
			$query=array_slice($query, $offset, 20 );

			if (!empty($query)) {
	 			$response= $this->Common_model->sucessResponse('Your data shows succesfully',$query,$count);
			}
			else{
	 			$response= $this->Common_model->errorResponse('No data exists in table.');
			}
			$this->set_response($response,REST_Controller::HTTP_OK);
		}
		public function dealPlace_post(){
			$dealId=$this->input->post('dealId');
			$retailerId=$this->input->post('retailerId');
			$offset=$this->input->post('offset');

			$query=$this->db->query("SELECT *,tblStorePlaces.id from tblStorePlaces join tblAssignedPlaceDeal on tblAssignedPlaceDeal.placeId=tblStorePlaces.id  where tblAssignedPlaceDeal.dealId='".$dealId."' and  tblStorePlaces.retailerId='".$retailerId."'")->result();

			$count=count($query);
			$query=array_slice($query, $offset, 20 );

			if (!empty($query)) {
	 			$response= $this->Common_model->sucessResponse('Your data shows succesfully',$query,$count);
			}
			else{
	 			$response= $this->Common_model->errorResponse('No data exists in table.');
			}
			$this->set_response($response,REST_Controller::HTTP_OK);
		}
		public function placeListing_post(){
			$retailerId=$this->input->post('retailerId');
			$offset=$this->input->post('offset');

			if (empty($retailerId)) {
				$response=$this->Common_model->requiredResponse();
			}
			else{
				$query=$this->db->query("SELECT * from tblStorePlaces where retailerId = '".$retailerId."'  order by id desc ")->result();
				$storeAllowed=$this->db->query("SELECT * from tblRetailer where id='".$retailerId."' ")->row()->storeAllowed;
				$count=count($query);
				$query=array_slice($query, $offset, 20 );
				if (!empty($query)) {
		 			$response= $this->Common_model->sucessResponse('Your data shows succesfully',$query,$count,$storeAllowed);
				}
				else{
		 			$response= $this->Common_model->errorResponse('No data exists in table.',$storeAllowed);
				}
			}
			$this->set_response($response,REST_Controller::HTTP_OK);
		}

		public function dealListing_post(){
			$offset=$this->input->post('offset');
			$retailerId=$this->input->post('retailerId');
			$date=date('Y-m-d');
			$query=$this->db->query("SELECT tblDeals.*,tblAssignedPlaceDeal.validFor from tblDeals join tblAssignedPlaceDeal on tblAssignedPlaceDeal.dealId=tblDeals.id where expiryDate >= '".$date."' and isAvailable=1  and retailerId='".$retailerId."' group by tblDeals.id  order by id desc ")->result();
			$count=count($query);
			$query=array_slice($query, $offset, 20 );
			if (!empty($query)) {
				$response= $this->Common_model->sucessResponse('Your data shows succesfully',$query,$count);
			}
			else{
				$response= $this->Common_model->errorResponse('No data exists in table.');
			}

			$this->set_response($response,REST_Controller::HTTP_OK);
		}

		/*may use group by of retailer id*/	
		public function allPlaces_post(){
			$customerId=$this->input->post('customerId');
			$offset=$this->input->post('offset');
			$lat=$this->input->post('lat');
			$lng=$this->input->post('lng');
			if (empty($customerId) ||  empty($lat) || empty($lng) ) {
				$response=$this->Common_model->requiredResponse();
			}
			else{
				$date=date('Y-m-d');

				$query=$this->db->query("SELECT tblStorePlaces.*,tblRetailer.name,tblRetailer.email,tblRetailer.phoneNo,(3959 * acos(cos(radians('".$lat."')) * cos(radians(latitude)) * cos(radians(longitude) - radians('".$lng."')) + sin(radians('".$lat."')) * sin(radians(latitude)))) as distance from tblStorePlaces join tblRetailer on tblRetailer.id=tblStorePlaces.retailerId join tblAssignedPlaceDeal on tblAssignedPlaceDeal.placeId=tblStorePlaces.id  join tblDeals on tblAssignedPlaceDeal.dealId=tblDeals.id  where tblAssignedPlaceDeal.expiryDate>='".$date."' and validFor > 0 and isAvailable =1  order  by distance ")->result();
				$date=date('Y-m-d');
				foreach ($query as $key => $value) {
					$query[$key]->activeDealcount=$this->db->query("SELECT count(tblDeals.id) as count from tblDeals join tblAssignedPlaceDeal on tblDeals.id=tblAssignedPlaceDeal.dealId where  expiryDate >= '".$date."' and isAvailable=1  and tblAssignedPlaceDeal.placeId='".$value->id."' ")->row()->count;
					$checkplaces=$this->db->query("SELECT * from tblCustomerFavPlaces where placeId='".$value->id."' and customerId='".$customerId."' and status=1 ")->row();

					if (empty($checkplaces)) {
						$query[$key]->favCheck=0;
					}
					else{
						$query[$key]->favCheck=1;
					}
				}
				$count=count($query);
				$query=array_slice($query, $offset, 20 );
				
				if (!empty($query)) {
					$response= $this->Common_model->sucessResponse('Your data shows succesfully',$query,$count);
				}
				else{
					$response= $this->Common_model->errorResponse('No data exists in table.');
				}
			}
			$this->set_response($response,REST_Controller::HTTP_OK);
		}

		public function allDeals_post(){
			$customerId=$this->input->post('customerId');
			$offset=$this->input->post('offset');
			if (empty($customerId) ) {
				$response=$this->Common_model->requiredResponse();
			}
			else{
				$date=date('Y-m-d');
				$query=$this->db->query("SELECT tblDeals.*,tblAssignedPlaceDeal.validFor  from tblDeals join tblAssignedPlaceDeal on tblAssignedPlaceDeal.dealId=tblDeals.id where expiryDate >= '".$date."' and isAvailable=1  and validFor > 0 group by tblDeals.id   order by id desc ")->result();

				
				foreach ($query as $key => $value) {
					$checkdeal=$this->db->query("SELECT * from tblCustomerFavDeals where dealId='".$value->id."' and customerId='".$customerId."' and status=1 ")->row();
					$query[$key]->offerByCount=$this->db->query("SELECT *,count(id) as countdata from tblAssignedPlaceDeal  where expiryDate >= '".$date."' and dealId='".$value->id."'  and validFor > 0    ")->row()->countdata;
					if (empty($checkdeal)) {
						$query[$key]->favCheck=0;
					}
					else{
						$query[$key]->favCheck=1;
					}
				}
				$count=count($query);
				$query=array_slice($query, $offset, 20 );
				if (!empty($query)) {
					$response= $this->Common_model->sucessResponse('Your data shows succesfully',$query,$count);
				}
				else{
					$response= $this->Common_model->errorResponse('No data exists in table.');
				}
			}
			$this->set_response($response,REST_Controller::HTTP_OK);
		}
	
		public function setFavDeals_post(){
			$dealId=$this->input->post('dealId');
			$customerId=$this->input->post('customerId');
			if (empty($customerId) || empty($dealId) ) {
				$response=$this->Common_model->requiredResponse();
			}
			else{
				$query=$this->Common_model->insert_data('tblCustomerFavDeals',array('dealId'=>$dealId,'customerId'=>$customerId,'status'=>1));	
				if (!empty($query)) {
					$response= $this->Common_model->sucessResponse('Your Favourite added succesfully');
				}
				else{
					$response= $this->Common_model->errorResponse('Something went wrong.');
				}
			}
			$this->set_response($response,REST_Controller::HTTP_OK);
		}


		public function setFavPlaces_post(){
			$placeId=$this->input->post('placeId');
			$customerId=$this->input->post('customerId');
			if (empty($customerId) || empty($placeId) ) {
				$response=$this->Common_model->requiredResponse();
			}
			else{
				$query=$this->Common_model->insert_data('tblCustomerFavPlaces',array('placeId'=>$placeId,'customerId'=>$customerId,'status'=>1));	
				if (!empty($query)) {
					$response= $this->Common_model->sucessResponse('Your Favourite added succesfully');
				}
				else{
					$response= $this->Common_model->errorResponse('Something went wrong.');
				}
			}
			$this->set_response($response,REST_Controller::HTTP_OK);
		}


		public function removeFavPlaces_post(){
			$placeId=$this->input->post('placeId');
			$customerId=$this->input->post('customerId');
			if (empty($customerId) || empty($placeId) ) {
				$response=$this->Common_model->requiredResponse();
			}
			else{
				$query=$this->Common_model->update_data('tblCustomerFavPlaces',array('status'=>0),array('placeId'=>$placeId,'customerId'=>$customerId));	
				if (!empty($query)) {
					$response= $this->Common_model->sucessResponse('Your Favourite removed succesfully');
				}
				else{
					$response= $this->Common_model->errorResponse('Something went wrong.');
				}
			}
			$this->set_response($response,REST_Controller::HTTP_OK);
		}

		public function removeFavDeals_post(){
			$dealId=$this->input->post('dealId');
			$customerId=$this->input->post('customerId');
			if (empty($customerId) || empty($dealId) ) {
				$response=$this->Common_model->requiredResponse();
			}
			else{
				$query=$this->Common_model->update_data('tblCustomerFavDeals',array('status'=>0),array('dealId'=>$dealId,'customerId'=>$customerId));	
				if (!empty($query)) {
					$response= $this->Common_model->sucessResponse('Your Favourite removed succesfully');
				}
				else{
					$response= $this->Common_model->errorResponse('Something went wrong.');
				}
			}
			$this->set_response($response,REST_Controller::HTTP_OK);
		}
		public function customerPlaceDetail_post(){
			$placeId=$this->input->post('placeId');
			$customerId=$this->input->post('customerId');
			if (empty($customerId) || empty($placeId) ) {
				$response=$this->Common_model->requiredResponse();
			}
			else{
				$query=$this->db->query("SELECT tblStorePlaces.*,tblRetailer.name,tblRetailer.email,tblRetailer.phoneNo from tblStorePlaces join tblRetailer on tblRetailer.id=tblStorePlaces.retailerId where tblStorePlaces.id='".$placeId."'  ")->row();
				
				$date=date('Y-m-d');
				$query->activeDeals=$this->db->query("SELECT *,tblDeals.id from tblDeals join tblAssignedPlaceDeal on tblAssignedPlaceDeal.dealId=tblDeals.id where expiryDate >='".$date."' and isAvailable=1 and placeId ='".$placeId."' group by tblDeals.id ")->result();
				
				foreach ($query->activeDeals as $key => $value) {
					$checkdeal=$this->db->query("SELECT * from tblCustomerFavDeals where dealId='".$value->id."' and customerId='".$customerId."' and status=1 ")->row();
					$query->activeDeals[$key]->offerByCount=$this->db->query("SELECT count(id) as count from tblAssignedPlaceDeal where dealId='".$value->dealId."' ")->row()->count;
					if (empty($checkdeal)) {
						$query->activeDeals[$key]->favCheck=0;
					}
					else{
						$query->activeDeals[$key]->favCheck=1;
					}
				}

				$favPlacesCheck=$this->db->query("SELECT * from tblCustomerFavPlaces  where placeId ='".$placeId."' and customerId ='".$customerId."' and status=1 ")->row();

				if (!empty($query)) {
					$query->favCheck=empty($favPlacesCheck)?0:1;
		 			$response= $this->Common_model->sucessResponse('Your data shows succesfully',$query);
				}
				else{
		 			$response= $this->Common_model->errorResponse('No data exists in table.');
				}
			}
			$this->set_response($response,REST_Controller::HTTP_OK);
		}
		public function customerDealDetail_post(){
			$dealId=$this->input->post('dealId');
			$customerId=$this->input->post('customerId');
			$lat=$this->input->post('lat');
			$lng=$this->input->post('lng');
			if (empty($customerId) || empty($dealId) ) {
				$response=$this->Common_model->requiredResponse();
			}
			else{
				$query=$this->db->query("SELECT tblDeals.* from tblDeals   where tblDeals.id='".$dealId."' ")->row();
				
				$query->storePlaces=$this->db->query("SELECT *,(3959 * acos(cos(radians('".$lat."')) * cos(radians(latitude)) * cos(radians(longitude) - radians('".$lng."')) + sin(radians('".$lat."')) * sin(radians(latitude)))) as distance,tblRetailer.email,tblRetailer.phoneNo,tblStorePlaces.id from tblStorePlaces join tblAssignedPlaceDeal on tblAssignedPlaceDeal.placeId=tblStorePlaces.id join tblRetailer on tblAssignedPlaceDeal.retailerId=tblRetailer.id and validFor > 0 group by tblStorePlaces.id  order by distance asc ")->result();

				foreach ($query->storePlaces as $key => $value) {
					$checkplace=$this->db->query("SELECT * from tblCustomerFavPlaces where placeId='".$value->id."' and customerId='".$customerId."' and status=1 ")->row();
					if (empty($checkplace)) {
						$query->storePlaces[$key]->favCheck=0;
					}
					else{
						$query->storePlaces[$key]->favCheck=1;
					}
				}

				$favPlacesCheck=$this->db->query("SELECT * from tblCustomerFavDeals  where dealId ='".$dealId."' and customerId ='".$customerId."' and status=1 ")->row();
				$query->favCheck=empty($favPlacesCheck)?0:1;

				if (!empty($query)) {
		 			$response= $this->Common_model->sucessResponse('Your data shows succesfully',$query);
				}
				else{
		 			$response= $this->Common_model->errorResponse('No data exists in table.');
				}
			}
			$this->set_response($response,REST_Controller::HTTP_OK);
		}



		public function addDeal_post(){
			$data=array(
			'retailerId'=>$this->input->post('retailerId'),
			'dealName'=>$this->input->post('dealName'),
			'category'=>$this->input->post('category'),
			'offerOrDiscount'=>$this->input->post('offerOrDiscount'),
			'expiryDate'=>$this->input->post('expiryDate'),
			'description'=>$this->input->post('description'),
			'termsConditions'=>$this->input->post('termsConditions'),
			);
			if (empty($data['retailerId'])){
				$response=$this->Common_model->requiredResponse();
			}
			else{
				if (isset($_FILES['dealImage'])) {
					$image='dealImage';
					$upload_path='assets/apidata';
					$imagename=$this->Common_model->file_upload($upload_path,$image);
					$data['dealImage']=$imagename;
				}
				$date=date('Y-m-d');
				/*count check not to be add more then six*/
				$checkimagescount=$this->db->query("SELECT * from tblDeals where retailerId='".$data['retailerId']."' and expiryDate >= '".$date."' and isAvailable=1 ")->result();
				if (count($checkimagescount) < 6) {
					$checkResponse=$this->Common_model->insert_data('tblDeals',$data);
					if ($checkResponse) {
	 					$query=$this->Common_model->selectrow('tblDeals',array('id'=>$checkResponse),'*');
		 				$response= $this->Common_model->sucessResponse('Deal added succesfully',$query);
					}
					else{
		 				$response= $this->Common_model->errorResponse('Something went Wrong');
					}
				}
				else{
		 			$response= $this->Common_model->errorResponse('You can not add more then six deals.');
				}
			}
			$this->set_response($response,REST_Controller::HTTP_OK);
		}

		public function deleteDeal_post(){
			$dealId=$this->input->post('dealId');
			if (empty($dealId)) {
				$response=$this->Common_model->requiredResponse();
			}
			else{
				$this->db->delete('tblDeals', array('id' => $dealId)); 
				$response= $this->Common_model->sucessResponse('Deal deleted succesfully');
			}
			$this->set_response($response,REST_Controller::HTTP_OK);
		}
		public function updateDeal_post(){
			$dealId=$this->input->post('dealId');

			if (empty($dealId)) {
				$response=$this->Common_model->requiredResponse();
			}
			else{
				$data=array(
					'dealName'=>$this->input->post('dealName'),
					'category'=>$this->input->post('category'),
					'offerOrDiscount'=>$this->input->post('offerOrDiscount'),
					'expiryDate'=>$this->input->post('expiryDate'),
					'description'=>$this->input->post('description'),
					'termsConditions'=>$this->input->post('termsConditions'),
				);
				if (isset($_FILES['dealImage'])) {
					$image='dealImage';
					$upload_path='assets/apidata';
					$imagename=$this->Common_model->file_upload($upload_path,$image);
					$data['dealImage']=$imagename;
				}
				$dealId=array('id'=>$dealId);
				$response=$this->App_model->updateDeal($dealId,$data);
			}
			$this->set_response($response,REST_Controller::HTTP_OK);
		}


		public function grabbedDealDetail_post(){
			$grabbedDealId=$this->input->post('grabbedDealId');
			if (empty($grabbedDealId) ) {
				$response=$this->Common_model->requiredResponse();
			}
			else{
				$query=$this->db->query("SELECT tblAssignedPlaceDeal.*,tblGrabbedDeal.*,tblDeals.*,tblBarCode.*,tblRetailer.name,tblRetailer.email,tblRetailer.image,tblStorePlaces.*,tblGrabbedDeal.dateCreated as grabbeddatetime from tblGrabbedDeal join tblDeals on tblDeals.id=tblGrabbedDeal.dealId join tblStorePlaces on tblStorePlaces.id=tblGrabbedDeal.placeId join tblBarCode on tblBarCode.id=tblGrabbedDeal.barCodeId join tblRetailer on tblRetailer.id=tblGrabbedDeal.retailerId join tblAssignedPlaceDeal on tblAssignedPlaceDeal.placeId=tblStorePlaces.id and tblAssignedPlaceDeal.dealId=tblDeals.id where tblGrabbedDeal.id='".$grabbedDealId."' ")->result();

				foreach ($query as $key => $value) {
					$query[$key]->offerByCount=$this->db->query("SELECT count(id) as count from tblStorePlaces where retailerId='".$value->retailerId."' ")->row()->count;
					$query[$key]->favCheck=1;
					$query[$key]->serverDateTime=date('Y-m-d H:i:s');
				}
				if (!empty($query)) {
					$response= $this->Common_model->sucessResponse('Your data shows succesfully',$query);
				}
				else{
					$response= $this->Common_model->errorResponse('No data exists in table.');
				}
			}
			$this->set_response($response,REST_Controller::HTTP_OK);
		}

		public function storeOffers_post(){
			$dealId=$this->input->post('dealId');
			$customerId=$this->input->post('customerId');
			$lat=$this->input->post('lat');
			$lng=$this->input->post('lng');
			$offset=$this->input->post('offset');

			if (empty($dealId)  || empty($customerId)  ) {
				$response=$this->Common_model->requiredResponse();
			}
			else{
				$query=$this->db->query("SELECT tblStorePlaces.*,tblAssignedPlaceDeal.*,(3959 * acos(cos(radians('".$lat."')) * cos(radians(latitude)) * cos(radians(longitude) - radians('".$lng."')) + sin(radians('".$lat."')) * sin(radians(latitude)))) as distance,tblStorePlaces.id as placeId,tblRetailer.email,tblRetailer.phoneNo from tblDeals join tblAssignedPlaceDeal on tblAssignedPlaceDeal.dealId=tblDeals.id join tblRetailer on tblAssignedPlaceDeal.retailerId=tblRetailer.id join tblStorePlaces on tblAssignedPlaceDeal.placeId=tblStorePlaces.id where tblDeals.id='".$dealId."' order by distance asc ")->result();

				foreach ($query as $key => $value) {
					$checkplace=$this->db->query("SELECT * from tblCustomerFavPlaces where placeId='".$value->placeId."' and customerId='".$customerId."' and status=1 ")->row();
					$query[$key]->activeDealcount=$this->db->query("SELECT count(tblDeals.id) as count,tblDeals.id  from tblDeals join tblAssignedPlaceDeal on tblAssignedPlaceDeal.placeId=tblDeals.id where placeId='".$value->placeId."' and expiryDate >= '".$date."' and isAvailable=1 ")->row()->count;

					$query[$key]->favCheck=empty($checkplace)?0:1;
				}
				$storeCount=count($query);
				$query=array_slice($query,$offset,10);
				if (!empty($query)) {
					$response= $this->Common_model->sucessResponse('Your data shows succesfully',$query,$storeCount);
				}
				else{
					$response= $this->Common_model->errorResponse('No data exists in table.');
				}
			}
			$this->set_response($response,REST_Controller::HTTP_OK);	
		}

		public function activeDeals_post(){
			$placeId=$this->input->post('placeId');
			$customerId=$this->input->post('customerId');
			$offset=$this->input->post('offset');

			if (empty($placeId) || empty($customerId) ) {
				$response=$this->Common_model->requiredResponse();
			}
			else{
				$date=date('Y-m-d');
				$query=$this->db->query("SELECT * from tblAssignedPlaceDeal join tblDeals on tblDeals.id=tblAssignedPlaceDeal.dealId   where tblAssignedPlaceDeal.placeId='".$placeId."' and expiryDate >= '".$date."' and isAvailable=1 ")->result();

				foreach ($query as $key => $value) {
					$checkDeal=$this->db->query("SELECT * from tblCustomerFavDeals where dealId='".$value->dealId."' and customerId='".$customerId."' and status=1 ")->row();
					$query[$key]->favCheck=empty($checkDeal)?0:1;
					$query[$key]->offerByCount=$this->db->query("SELECT count(id) as count from tblStorePlaces where retailerId='".$value->retailerId."' ")->row()->count;
				}
				$activeDealsCount=count($query);
				$query=array_slice($query,$offset,10);

				if (!empty($query)) {
					$response= $this->Common_model->sucessResponse('Your data shows succesfully',$query,$activeDealsCount);
				}
				else{
					$response= $this->Common_model->errorResponse('No data exists in table.');
				}
			}
			$this->set_response($response,REST_Controller::HTTP_OK);
		}

		public function grabbDeal_post(){
			$customerId=$this->input->post('customerId');
			$dealId=$this->input->post('dealId');
			$placeId=$this->input->post('placeId');
			if (empty($customerId) ||  empty($dealId) ) {
				$response=$this->Common_model->requiredResponse();
			}
			else{
			    $query['barCodeDetail']=$this->db->query("SELECT tblBarCode.*,tblStorePlaces.retailerId,tblDeals.*,tblBarCode.id from  tblBarCode join tblDeals on tblDeals.id=tblBarCode.dealId join tblStorePlaces on tblStorePlaces.id=$placeId  where tblBarCode.dealId='".$dealId."' and tblBarCode.status=0 ")->row();
			    $checkprevious=$this->db->query("SELECT * from tblGrabbedDeal where dealId='".$dealId."' and customerId='".$customerId."' ")->result();
	
			    if (!empty($query['barCodeDetail'])) {
					$query['grabbDealId']=$this->Common_model->insert_data('tblGrabbedDeal',array('retailerId'=>$query['barCodeDetail']->retailerId,'placeId'=>$placeId,'dealId'=>$dealId,'customerId'=>$customerId,'barCodeId'=>$query['barCodeDetail']->id));	
					if (!empty($query['grabbDealId'])) {
				    	$this->Common_model->update_data('tblBarCode',array('status'=>1,'usedDateTime'=>date('Y-m-d H:i:s')),array('id'=>$query['barCodeDetail']->id));

				    	$assigneddata=$this->db->query("SELECT * from tblAssignedPlaceDeal where placeId='".$placeId."' and dealId='".$dealId."' ")->row();

				    	$this->Common_model->update_data('tblAssignedPlaceDeal',array('validFor'=>$assigneddata->validFor-1),array('id'=>$assigneddata->id));

						$response= $this->Common_model->sucessResponse('Deal grabbed succesfully',$query);
					}
					else{
						$response= $this->Common_model->errorResponse('Something went wrong.');
					}
				}
				else{
					$response= $this->Common_model->errorResponse('Deal is not free at that time.Please try after some time.');
				}
			}
			end:
			$this->set_response($response,REST_Controller::HTTP_OK);
		}

		public function useDeal_post(){
			$grabbDealId=$this->input->post('grabbDealId');
			if (empty($grabbDealId)) {
				$response=$this->Common_model->requiredResponse();
			}
			else{
			    $this->Common_model->update_data('tblGrabbedDeal',array('status'=>1),array('id'=>$grabbDealId));
				$barCodeData=$this->Common_model->selectrow('tblGrabbedDeal',array('id'=>$data['grabbDealId']),'*');
			    $this->Common_model->update_data('tblBarCode',array('status'=>0),array('id'=>$barCodeData->barCodeId));
				$response= $this->Common_model->sucessResponse('Deal used succesfully');
			}
			$this->set_response($response,REST_Controller::HTTP_OK);
		}


		public function grabbedDeals_post(){
			$customerId=$this->input->post('customerId');
			$type=$this->input->post('type');
			$offset=$this->input->post('offset');
			$lat=$this->input->post('lat');
			$lng=$this->input->post('lng');
			if (empty($customerId) || empty($type)  ) {
				$response=$this->Common_model->requiredResponse();
			}
			else{
				$date=date('Y-m-d');
				if ($type==1) {
					$query=$this->db->query("SELECT *,tblGrabbedDeal.dateCreated as grabbeddatetime,tblGrabbedDeal.id as grabbedDealId from tblGrabbedDeal join tblDeals on tblDeals.id=tblGrabbedDeal.dealId where tblGrabbedDeal.customerId='".$customerId."'  order by tblGrabbedDeal.dateCreated desc ")->result();

					foreach ($query as $key => $value) {
						$query[$key]->offerByCount=$this->db->query("SELECT count(id) as count from tblStorePlaces where retailerId='".$value->retailerId."' ")->row()->count;
						$query[$key]->favCheck=1;
					}
				}
				elseif ($type==2) {
					$query=$this->db->query("SELECT *,tblDeals.id from tblCustomerFavDeals join tblDeals on tblDeals.id=tblCustomerFavDeals.dealId  join tblAssignedPlaceDeal on tblDeals.id=tblAssignedPlaceDeal.dealId where tblCustomerFavDeals.customerId='".$customerId."' and tblCustomerFavDeals.status=1 and tblAssignedPlaceDeal.expiryDate >= '".$date."' and validFor > 0 and isAvailable=1 group by tblDeals.id order by tblCustomerFavDeals.id desc")->result();
					foreach ($query as $key => $value) {
						$query[$key]->offerByCount=$this->db->query("SELECT count(id) as count from  tblAssignedPlaceDeal  where dealId='".$value->id."' and expiryDate >='".$date."' and validFor > 0 ")->row()->count;
						$query[$key]->favCheck=1;
					}
				}
				elseif($type==3){
					$query=$this->db->query("SELECT tblCustomerFavPlaces.*,tblStorePlaces.*,tblRetailer.name,(3959 * acos(cos(radians('".$lat."')) * cos(radians(latitude)) * cos(radians(longitude) - radians('".$lng."')) + sin(radians('".$lat."')) * sin(radians(latitude)))) as distance,tblRetailer.email,tblRetailer.phoneNo from tblCustomerFavPlaces join tblStorePlaces on tblStorePlaces.id=tblCustomerFavPlaces.placeId join tblRetailer on tblRetailer.id=tblStorePlaces.retailerId  join tblAssignedPlaceDeal on tblStorePlaces.id=tblAssignedPlaceDeal.placeId where tblCustomerFavPlaces.customerId='".$customerId."' and tblCustomerFavPlaces.status=1 and validFor > 0 and expiryDate >'".$date."' order by tblCustomerFavPlaces.id desc ")->result();

					$date=date('Y-m-d');
					foreach ($query as $key => $value) {
						$query[$key]->activeDealcount=$this->db->query("SELECT count(tblDeals.id) as count from tblDeals join tblAssignedPlaceDeal on tblDeals.id =tblAssignedPlaceDeal.dealId where retailerId='".$value->retailerId."' and expiryDate >= '".$date."' and isAvailable=1  and tblDeals.id not in (SELECT dealId from tblGrabbedDeal where customerId =".$customerId.")  ")->row()->count;
						$query[$key]->favCheck=1;
					}
				}
				if (!empty($query)) {
					$count=count($query);
					$query=array_slice($query, $offset, 20 );
					$response= $this->Common_model->sucessResponse('Your data shows succesfully',$query,$count);
				}
				elseif(empty($query)){
					$response= $this->Common_model->errorResponse('No data exists in table.');
				}
				else{
					$response= $this->Common_model->errorResponse('Something went wrong.');
				}
			}
			$this->set_response($response,REST_Controller::HTTP_OK);
		}


		public function test_get(){
// $inputArray = array(1, 4, 2, 1, 6, 4, 9, 7, 2, 9,9,445);
// $outputArray = array();
// foreach($inputArray as $inputArrayItem) {
//     foreach($outputArray as $outputArrayItem) {
//         if($inputArrayItem == $outputArrayItem) {
//             continue 2;
//         }
//     }
//     $outputArray[] = $inputArrayItem;
// }
// print_r($outputArray);
// die;

$array=array('2','4','8','5','1','7','6','9','10','3','2','4','8');


// for($j = 0; $j < count($array); $j ++) {
//     for($i = 0; $i < count($array)-1; $i ++){
//         if($array[$i] > $array[$i+1]) {
//             $temp = $array[$i+1];
//             $array[$i+1]=$array[$i];
//             $array[$i]=$temp;
//         }
//     }
// }
$newarray=array();
foreach ($array as $key => $value) {
	foreach ($newarray as $key => $value2) {
		if ($value==$value2) {
			continue 2;
		}
	}
	$newarray[]=$value;
}

print_r($newarray);

die;

			for ($i=0; $i < 10; $i++) { 
				for ($j=0; $j <=$i ; $j++) { 
					echo "*";
				}
				echo "<br>";
			}
			die;


			// for ($i=0; $i < 5; $i++) { 
			// 	for ($j=5; $j > $i  ; $j--) { 
			// 		echo "*";
			// 	}
			// 	echo "<br>";
			// 	echo "**";
			// 	echo "<br>";

			// }die;

			// for ($i=0; $i < 5; $i++) { 
			// 	for ($j=0; $j <= $i ; $j++) { 
			// 		echo "*";
			// 	}
			// 	echo "<br>";
			// }
			// die;
			/*print * table*/
			// for ($i=0; $i < 5 ; $i++) { 
			// 	for ($j=5; $j > $i ; $j--) { 
			// 		echo "*";
			// 	}
			// 	echo "<br>";
			// 	echo "**";
			// 	echo "<br>";
			// }
			// $temp=array();
			// $i=array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
			// foreach ($i as $key => $value) {
			// 	if ($value%3==0 && $value%5==0  ) {
			// 		$temp[]="appyfizz";
			// 	}
			// 	else if ($value%3==0) {
			// 		$temp[]="appy";
			// 	}
			// 	else if ($value%5==0) {
			// 		$temp[]="fizz";
			// 	}
			// 	else {
			// 		$temp[]=$value;
			// 	}
			// }
			// print_r(implode(',',$temp));
			/*remove duplicate value*/
			// $temp=array();
			// $i=array(1,2,3,4,3,2,45);
			// $newarray=array();
			// foreach ($i as $key => $value) {
			// 	foreach ($newarray as $key => $valuenewarray) {
			// 		if ($valuenewarray==$value) {
			// 			continue 2;
			// 		}
			// 	}
			// 	$newarray[]=$value;
			// }
			// print_r($newarray);die;

			// $temp=array();
			// $i=array(1,2,3,4,5,1,3,1,5,5,5);
			// $new=array_count_values($i);
			// print_r($new);


			// $temp=array();
			// $i=array(1,2,3,4,5,1,3,1,5,5,5);
			// foreach (array_count_values($i) as $key => $value) {
			// 	if ($value>1) {
			// 		$temp[]=$key;
			// 	}
			// 	else{
			// 		unset($value);
			// 	}
			// }
			// print_r($temp);die;

			// for ($i=0; $i < 5; $i++) { 
			// 	for ($j=0; $j<=$i; $j++) { 
			// 		echo "*";
			// 	}
			// 	echo "<br>";
			// }
			// for ($i=0; $i < 5 ; $i++) { 
			// 	for ($j=5; $j > $i ; $j--) { 
			// 		echo "*";
			// 	}
			// 	echo "<br>";
			// }


		}



// public function subquery_get(){
// 	$query=$this->db->query("SELECT * from  tblLogin ")->result();
// 		$query=$this->db->query("SELECT * from tblGrabbedDeal join  tblBarCode on tblBarCode.id=tblGrabbedDeal.barCodeId where tblBarCode.status=1  ")->result();
// 		print_r($query);
// 		foreach ($query as $key => $value) {
// 			$endTime = date('Y-m-d H:i:s',strtotime("+5 minutes",strtotime($value->usedDateTime)));
// 			$dateTime=date('Y-m-d H:i:s');
// 			if ($endTime < $dateTime ) {
// 	    		$this->Common_model->update_data('tblBarCode',array('status'=>0),array('id'=>$value->barCodeId));
// 	    		$this->Common_model->freebarcodepush($value->customerId);
// 			}
// 	}
// $sub = $this->subquery->start_subquery('select');
// $sub->select('*')->from('tblDeals');
// $sub->where('users.id = roles.id');
// $this->subquery->end_subquery('role');
// $this->db->from('users')
// $this->db->where('id', '1');
// die;
// 		$this->db->select('id')->from('employees_backup');
// $subQuery =  $this->db->get_compiled_select();
// // Main Query
// $this->db->select('*')
//          ->from('employees')
//          ->where("id IN ($subQuery)", NULL, FALSE)
//          ->get()
//          ->result();
// 		print_r($subQuery);die;
// $this->db->select('*')->from('tblDeals');
// $sub = $this->subquery->start_subquery('where_in');
// $sub->select('dealId')->from('tblGrabbedDeal');
// $this->subquery->end_subquery('dealId', FALSE);
// $query=$this->db->get->result();
// }




}
