<?php
/**
* @author saurabh
*/
class Admin_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function get_data($tbl_name,$limit=null,$offset=null)                                   /* Get all data */
	{
		if ($limit!=null) {
			$query = $this->db->get($tbl_name,$limit, $offset)->result();
		} else {
			$query = $this->db->get($tbl_name)->result();
		}
		return (empty($query))?'':$query;
	}


public function get_Hbcu()
	{

		$res = $this->db->select('*')
		            ->from('hb_hbcu')
		            ->get()->result();

		return $res;
	}
	public function get_feedback()
	{
		$this->db->select('hb_feedback.*,hb_users.first_name');
		$this->db->from('hb_feedback');
		$this->db->join('hb_users', 'hb_users.id = hb_feedback.user_id');
		$res = $this->db->get()->result();
		return $res;
	}

	public function get_referal()
	{

		$res = $this->db->select('*')
		            ->from('hb_users')
		            ->get()->result();
		            $abc=array();

		            foreach ($res as $key => $value) {
		            	if (!empty($value->referral_link)) {
		            		$abc[]=$value;
		            }
		            }

		            foreach ($abc as $key => $value) {
		            		$count= $this->db->query("SELECT hb_users.first_name as referbyname,hb_users.last_name as referbylastname,count(id) as referral_count from hb_users where referral_link='".$value->referral_link."'")->row();
		            		$userDetail= $this->db->query("SELECT hb_users.first_name as referbyname from hb_users where unique_url='".$value->referral_link."'")->row();
		            	$refercount=$count->referral_count;
		            	$abc[$key]->referedbycount=$refercount;
		            	$abc[$key]->referbyname=$userDetail->referbyname;
		            }

		return $abc;
	}


		public function get_referalxls()
	{

		$users = $this->db->select('first_name,last_name,unique_url,referral_link,id,created')
		            ->from('hb_users')
		            ->get();
		               foreach ($users->result_array() as $row){
                $exceldata[] = $row;
        }

		            $abc=array();

		            foreach ($exceldata as $key => $value) {
		            	if (!empty($value['referral_link'])) {
		            		$abc[]=$value;
		            }
		            }

		            foreach ($abc as $key => $value) {
		            		$count= $this->db->query("SELECT hb_users.first_name as referbyname,hb_users.last_name as referbylastname,count(id) as referral_count from hb_users where referral_link='".$value['referral_link']."'")->row();
		            		$userDetail= $this->db->query("SELECT hb_users.first_name as referbyname from hb_users where unique_url='".$value['referral_link']."'")->row();
		            	$refercount=$count->referral_count;
		            	$abc[$key]['referbyname']=$userDetail->referbyname;
		            	$abc[$key]['referedbycount']=$refercount;
		            }

		return $abc;
	}


		public function get_donationsxls()
	{
		$res = $this->db->select('hb_donations.user_id,hb_donations.user_id,round(hb_donations.amount,2) as amount,hb_donations.donation_type,hb_donations.txnId,hb_donations.percentage,hb_donations.dateTime


			,hb_hbcu.title,hb_users.first_name,hb_users.last_name,hb_users.email')
		                ->from('hb_donations')
		                ->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
                        ->join('hb_users','hb_donations.user_id = hb_users.id')
						->get();

							foreach ($res->result_array() as $row){
							$exceldata[] = $row;
							}


						return $exceldata;
	}



		public function topdonorsmonthxls(){
	     //  $response = $this->db->SELECT("round(SUM(hb_donations.amount),2) as donation_amount, hb_organization.title, hb_users.organization as id, hb_organization.logo FROM hb_donations LEFT JOIN hb_users ON(hb_users.organization=hb_donations.organization) INNER JOIN hb_organization ON(hb_organization.id=hb_donations.organization) WHERE hb_donations.status= '1' and MONTH(date) = MONTH(CURRENT_DATE()) group by hb_donations.organization   order by donation_amount DESC")->get();
						// foreach ($response->result_array() as $row){
						// 	$exceldata[] = $row;
						// }


			// $response = $this->db->SELECT("round(SUM(hb_donations.amount),2) as donation_amount,hb_donations.organization,hb_donations.status   FROM hb_donations  INNER JOIN hb_organization ON(hb_organization.id=hb_donations.organization)  WHERE hb_donations.status= '1' and MONTH(date) = MONTH(CURRENT_DATE()) group by hb_donations.organization  order by donation_amount DESC")->get();
			// foreach ($response->result_array() as $row){
			// $exceldata[] = $row;
			// }
			// foreach ($exceldata as $key => $value) {
			// $abc=$this->db->query("SELECT * from hb_organization where id=".$value['organization'])->result();	
			// $exceldata[$key]['logo']=$abc[0]->logo;
			// $exceldata[$key]['title']=$abc[0]->title; 
			// $exceldata[$key]['id']=$abc[0]->id;        	
			// }
			// return $exceldata;


			   function custom_sort($a,$b) {
                return $b['donation_amount']>$a['donation_amount'];
               }

               $response = $this->db->query(" SELECT hb_organization.*,hb_organization.id as organid, hb_users.organization as id  FROM hb_organization LEFT JOIN hb_users ON(hb_users.organization=hb_organization.id and hb_users.id='".$user_id."')")->result_array();


                foreach ($response as $key => $value) {


$add=$this->db->query("SELECT count(DISTINCT user_id) as number1 from hb_donations where hb_donations.organization='".$value['organid']."' and  MONTH(hb_donations.date) = MONTH(CURRENT_DATE())  ")->row(); 

$add1=$this->db->query("SELECT count( id) as number2 from hb_donations where hb_donations.organization='".$value['organid']."' and  MONTH(hb_donations.date) = MONTH(CURRENT_DATE()) ")->row(); 


$response[$key]['nodonors']=$add->number1; 
$response[$key]['nodonation']=$add1->number2;





                $abc=$this->db->query("SELECT round(SUM(hb_donations.amount),2) as donation_amount from hb_donations where hb_donations.organization='".$value['organid']."' and  MONTH(hb_donations.date) = MONTH(CURRENT_DATE()) " )->row();
                if (!empty($abc->donation_amount)) {
                $response[$key]['donation_amount']=$abc->donation_amount;    
                }
                else{
                $response[$key]['donation_amount']='0';
                }
                }

          usort($response, "custom_sort");
          // echo "<pre>";
          // print_r($response);die;
          return $response;











	    
		
	}
	public function topdonorsyearlyxls(){
		  // $response = $this->db->SELECT("  round(SUM(hb_donations.amount),2) as donation_amount, hb_organization.title, hb_users.organization as id, hb_organization.logo FROM hb_donations LEFT JOIN hb_users ON(hb_users.organization=hb_donations.organization) INNER JOIN hb_organization ON(hb_organization.id=hb_donations.organization) WHERE hb_donations.status= '1' and YEAR(date) = YEAR(CURRENT_DATE()) group by hb_donations.organization   order by donation_amount DESC")->get();
		  // 	foreach ($response->result_array() as $row){
				// 			$exceldata[] = $row;
				// 		}


			// $response = $this->db->SELECT("round(SUM(hb_donations.amount),2) as donation_amount,hb_donations.organization,hb_donations.status   FROM hb_donations  INNER JOIN hb_organization ON(hb_organization.id=hb_donations.organization)  WHERE hb_donations.status= '1' and YEAR(date) = YEAR(CURRENT_DATE()) group by hb_donations.organization  order by donation_amount DESC")->get();
			// foreach ($response->result_array() as $row){
			// $exceldata[] = $row;
			// }

			// foreach ($exceldata as $key => $value) {
			// $abc=$this->db->query("SELECT * from hb_organization where id=".$value['organization'])->result();	
			// $exceldata[$key]['logo']=$abc[0]->logo;
			// $exceldata[$key]['title']=$abc[0]->title; 
			// $exceldata[$key]['id']=$abc[0]->id;        	
			// }
			// return $exceldata;
					    function custom_sort($a,$b) {
               return $b['donation_amount']>$a['donation_amount'];
             }
   $response = $this->db->query(" SELECT hb_organization.*,hb_organization.id as organid, hb_users.organization as id  FROM hb_organization LEFT JOIN hb_users ON(hb_users.organization=hb_organization.id and hb_users.id='".$user_id."')")->result_array();


                foreach ($response as $key => $value) {


$add=$this->db->query("SELECT count(DISTINCT user_id) as number1 from hb_donations where hb_donations.organization='".$value['organid']."' and  YEAR(hb_donations.date) = YEAR(CURRENT_DATE())  ")->row(); 

$add1=$this->db->query("SELECT count( id) as number2 from hb_donations where hb_donations.organization='".$value['organid']."' and  YEAR(hb_donations.date) = YEAR(CURRENT_DATE()) ")->row(); 


$response[$key]['nodonors']=$add->number1; 
$response[$key]['nodonation']=$add1->number2;



                $abc=$this->db->query("SELECT round(SUM(hb_donations.amount),2) as donation_amount from hb_donations where hb_donations.organization='".$value['organid']."' and  YEAR(hb_donations.date) = YEAR(CURRENT_DATE()) " )->row();
                if (!empty($abc->donation_amount)) {
                $response[$key]['donation_amount']=$abc->donation_amount;    
                }
                else{
                $response[$key]['donation_amount']='0';
                }
                }

          usort($response, "custom_sort");
          // echo "<pre>";
          // print_r($response);die;
          return $response;







	}
	public function lovedhbcumonthxls(){
		 // $response = $this->db->SELECT("round(SUM(hb_donations.amount),2) as donation_amount, hb_hbcu.id as hbcuId, hb_hbcu.title, hb_hbcu.logo, hb_usersHBCU.id FROM hb_donations INNER JOIN hb_hbcu ON(hb_hbcu.id=hb_donations.hbcu) LEFT JOIN hb_usersHBCU ON(hb_hbcu.id=hb_usersHBCU.hbcu) WHERE hb_donations.status= '1' and MONTH(hb_donations.date) = MONTH(CURRENT_DATE()) and hb_donations.amount > 0 group by hb_donations.hbcu order by donation_amount DESC ")->get();
		 // 	foreach ($response->result_array() as $row){
			// 				$exceldata[] = $row;
			// 			}
			// echo "<prE>";
			// 			print_r($exceldata);die;


						function custom_sort($a,$b) {
						return $b['donation_amount']>$a['donation_amount'];
						}
						$response= $this->db->query(" SELECT hb_hbcu.id,hb_hbcu.logo,hb_hbcu.title, hb_hbcu.id as hbcuId  FROM hb_hbcu   ")->result_array();
						foreach ($response as $key => $value) {




				$add=$this->db->query("SELECT count(DISTINCT user_id) as number1 from hb_donations where hbcu='".$value['id']."' and  MONTH(hb_donations.date) = MONTH(CURRENT_DATE()) ")->row(); 
                $add1=$this->db->query("SELECT count( id) as number2 from hb_donations where hbcu='".$value['id']."' and  MONTH(hb_donations.date) = MONTH(CURRENT_DATE()) ")->row(); 
             $response[$key]['nodonors']=$add->number1; 
          	$response[$key]['nodonation']=$add1->number2;


						$abc=$this->db->query("SELECT round(SUM(hb_donations.amount),2) as donation_amount from hb_donations where hbcu='".$value['id']."' and  MONTH(hb_donations.date) = MONTH(CURRENT_DATE()) " )->row();
						if (!empty($abc->donation_amount)) {
						$response[$key]['donation_amount']=$abc->donation_amount;
						}
						else{
						$response[$key]['donation_amount']='0';
						}
						}
						usort($response, "custom_sort");
						return $response;

	}
		public function lovedhbcuyearxls(){

	  // $response = $this->db->SELECT("  round(SUM(hb_donations.amount),2) as donation_amount, hb_hbcu.id as hbcuId, hb_hbcu.title, hb_hbcu.logo, hb_usersHBCU.id FROM hb_donations INNER JOIN hb_hbcu ON(hb_hbcu.id=hb_donations.hbcu) LEFT JOIN hb_usersHBCU ON(hb_hbcu.id=hb_usersHBCU.hbcu ) WHERE hb_donations.status= '1' and YEAR(hb_donations.date) = YEAR(CURRENT_DATE()) and hb_donations.amount > 0 group by hb_donations.hbcu order by donation_amount DESC")->get();
		 //  	foreach ($response->result_array() as $row){
			// 				$exceldata[] = $row;
			// 			}
			// 			return $exceldata;

						function custom_sort($a,$b) {
						return $b['donation_amount']>$a['donation_amount'];
						}
						$response= $this->db->query(" SELECT hb_hbcu.id,hb_hbcu.logo,hb_hbcu.title, hb_hbcu.id as hbcuId  FROM hb_hbcu   ")->result_array();
						foreach ($response as $key => $value) {



				$add=$this->db->query("SELECT count(DISTINCT user_id) as number1 from hb_donations where hbcu='".$value['id']."' and  YEAR(hb_donations.date) = YEAR(CURRENT_DATE()) ")->row(); 
                $add1=$this->db->query("SELECT count( id) as number2 from hb_donations where hbcu='".$value['id']."' and  YEAR(hb_donations.date) = YEAR(CURRENT_DATE()) ")->row(); 
             $response[$key]['nodonors']=$add->number1; 
          	$response[$key]['nodonation']=$add1->number2;




						$abc=$this->db->query("SELECT round(SUM(hb_donations.amount),2) as donation_amount from hb_donations where hbcu='".$value['id']."' and  YEAR(hb_donations.date) = YEAR(CURRENT_DATE()) " )->row();
						if (!empty($abc->donation_amount)) {
						$response[$key]['donation_amount']=$abc->donation_amount;
						}
						else{
						$response[$key]['donation_amount']='0';
						}
						}
						usort($response, "custom_sort");
						return $response;


	    }

				public function get_donations_id_xls($id){
						$response = $this->db->select('hb_donations.user_id,hb_donations.user_id,round(hb_donations.amount,2) as amount,hb_donations.donation_type,hb_donations.txnId,hb_donations.dateTime,hb_donations.percentage,hb_hbcu.title,hb_users.first_name,hb_users.last_name,hb_users.email')
						->from('hb_donations')
						->where('hb_donations.user_id', $id)
						->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
						->join('hb_users','hb_donations.user_id = hb_users.id')
						->get();
						foreach ($response->result_array() as $row){
						$exceldata[] = $row;
						}
						return $exceldata;

				}








	public function get_donations()
	{
		$res = $this->db->select('hb_donations.*,hb_hbcu.title,hb_users.first_name,hb_users.last_name,hb_users.email')
		                ->from('hb_donations')
		                ->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
                        ->join('hb_users','hb_donations.user_id = hb_users.id')
						->get()->result();
						return $res;
	}



	public function get_Organization()
	{

		$res = $this->db->select('*')
		->from('hb_organization')
		->get()->result();

		return $res;
	}

	public function lovedhbcu(){


		   // $response['month'] = $this->db->query(" SELECT round(SUM(hb_donations.amount),2) as donation_amount, hb_hbcu.id as hbcuId, hb_hbcu.title, hb_hbcu.logo, hb_usersHBCU.id FROM hb_donations INNER JOIN hb_hbcu ON(hb_hbcu.id=hb_donations.hbcu) LEFT JOIN hb_usersHBCU ON(hb_hbcu.id=hb_usersHBCU.hbcu ) WHERE hb_donations.status= '1' and MONTH(hb_donations.date) = MONTH(CURRENT_DATE()) and hb_donations.amount > 0 group by hb_donations.hbcu order by donation_amount DESC ")->result();



		   //      $response['year'] = $this->db->query(" SELECT round(SUM(hb_donations.amount),2) as donation_amount, hb_hbcu.id as hbcuId, hb_hbcu.title, hb_hbcu.logo, hb_usersHBCU.id FROM hb_donations INNER JOIN hb_hbcu ON(hb_hbcu.id=hb_donations.hbcu) LEFT JOIN hb_usersHBCU ON(hb_hbcu.id=hb_usersHBCU.hbcu  ) WHERE hb_donations.status= '1' and YEAR(hb_donations.date) = YEAR(CURRENT_DATE()) and hb_donations.amount > 0 group by hb_donations.hbcu order by donation_amount DESC")->result();

		    function custom_sort($a,$b) {
               return $b->donation_amount>$a->donation_amount;
             }


          $response['month'] = $this->db->query(" SELECT hb_hbcu.id,hb_hbcu.logo,hb_hbcu.title, hb_hbcu.id as hbcuId  FROM hb_hbcu   ")->result();
          foreach ($response['month'] as $key => $value) {


          	$add=$this->db->query("SELECT count(DISTINCT user_id) as number1 from hb_donations where hbcu='".$value->id."' and  MONTH(hb_donations.date) = MONTH(CURRENT_DATE()) ")->row();

          	$add1=$this->db->query("SELECT count(id) as number2 from hb_donations where hbcu='".$value->id."' and  MONTH(hb_donations.date) = MONTH(CURRENT_DATE()) ")->row();

          	$response['month'][$key]->nodonors=$add->number1; 
          	$response['month'][$key]->nodonation=$add1->number2; 


          $abc=$this->db->query("SELECT round(SUM(hb_donations.amount),2) as donation_amount from hb_donations where hbcu='".$value->id."' and  MONTH(hb_donations.date) = MONTH(CURRENT_DATE()) " )->row();
	          if (!empty($abc->donation_amount)) {
	          	$response['month'][$key]->donation_amount=$abc->donation_amount; 
	          }
	          else{
	            $response['month'][$key]->donation_amount=0;
	          }
          }
          usort($response['month'], "custom_sort");





          $response['year'] = $this->db->query(" SELECT hb_hbcu.id,hb_hbcu.logo,hb_hbcu.title, hb_hbcu.id as hbcuId  FROM hb_hbcu   ")->result();
          foreach ($response['year'] as $key => $value) {


          	$add=$this->db->query("SELECT count(DISTINCT user_id) as number1 from hb_donations where hbcu='".$value->id."' and  YEAR(hb_donations.date) = YEAR(CURRENT_DATE()) ")->row();

          	$add1=$this->db->query("SELECT count(id) as number2 from hb_donations where hbcu='".$value->id."' and  YEAR(hb_donations.date) = YEAR(CURRENT_DATE()) ")->row();

          	$response['year'][$key]->nodonors=$add->number1; 
          	$response['year'][$key]->nodonation=$add1->number2; 


          $abc=$this->db->query("SELECT round(SUM(hb_donations.amount),2) as donation_amount from hb_donations where hbcu='".$value->id."' and  YEAR(hb_donations.date) = YEAR(CURRENT_DATE()) " )->row();
          if (!empty($abc->donation_amount)) {
          $response['year'][$key]->donation_amount=$abc->donation_amount;
            
          }
          else{
            $response['year'][$key]->donation_amount=0;
          }

          }
          usort($response['year'], "custom_sort");


    

        return $response;
	}
	public function topdonors(){

			    function custom_sort($a,$b) {
               return $b->donation_amount>$a->donation_amount;
             }





	      // $response['month'] = $this->db->query(" SELECT round(SUM(hb_donations.amount),2) as donation_amount,(SELECT hb_organization.title from hb_organization  where hb_organization.id=hb_donations.organization) as data, hb_organization.title, hb_users.organization as id, hb_organization.logo FROM hb_donations LEFT JOIN hb_users ON(hb_users.organization=hb_donations.organization ) INNER JOIN hb_organization ON(hb_organization.id=hb_donations.organization) WHERE hb_donations.status= '1' and MONTH(date) = MONTH(CURRENT_DATE()) group by hb_donations.organization  order by donation_amount DESC limit 5")->result();
		



	   //      $response['month'] = $this->db->query(" SELECT round(SUM(hb_donations.amount),2) as donation_amount,hb_donations.*   FROM hb_donations  INNER JOIN hb_organization ON(hb_organization.id=hb_donations.organization)  WHERE hb_donations.status= '1' and MONTH(date) = MONTH(CURRENT_DATE()) group by hb_donations.organization  order by donation_amount DESC")->result();
	
	   //      foreach ($response['month'] as $key => $value) {
				// $abc=$this->db->query("SELECT * from hb_organization where id=".$value->organization)->result();	
				// $response['month'][$key]->logo=$abc[0]->logo;
				// $response['month'][$key]->title=$abc[0]->title; 
				// $response['month'][$key]->id=$abc[0]->id;        	
	   //      }


         	   $response['month'] = $this->db->query(" SELECT hb_organization.*,hb_organization.id as organid, hb_users.organization as id  FROM hb_organization LEFT JOIN hb_users ON(hb_users.organization=hb_organization.id and hb_users.id='".$user_id."')")->result();


                foreach ($response['month'] as $key => $value) {


                	$add=$this->db->query("SELECT count(DISTINCT user_id) as number1 from hb_donations where hb_donations.organization='".$value->organid."' and  MONTH(hb_donations.date) = MONTH(CURRENT_DATE()) ")->row(); 

                	$add1=$this->db->query("SELECT count( id) as number2 from hb_donations where hb_donations.organization='".$value->organid."' and  MONTH(hb_donations.date) = MONTH(CURRENT_DATE()) ")->row(); 


                    $response['month'][$key]->nodonors=$add->number1; 
          	        $response['month'][$key]->nodonation=$add1->number2;




                $abc=$this->db->query("SELECT round(SUM(hb_donations.amount),2) as donation_amount from hb_donations where hb_donations.organization='".$value->organid."' and  MONTH(hb_donations.date) = MONTH(CURRENT_DATE()) " )->row();
                if (!empty($abc->donation_amount)) {
                $response['month'][$key]->donation_amount=$abc->donation_amount;    
                }
                else{
                $response['month'][$key]->donation_amount=0;
                }
                }

                usort($response['month'], "custom_sort");
          // echo "<prE>";
          // print_r($response);die;


	      




	        // $response['year'] = $this->db->query(" SELECT round(SUM(hb_donations.amount),2) as donation_amount, hb_organization.title, hb_users.organization as id, hb_organization.logo FROM hb_donations LEFT JOIN hb_users ON(hb_users.organization=hb_donations.organization and hb_users.id='$user_id') INNER JOIN hb_organization ON(hb_organization.id=hb_donations.organization) WHERE hb_donations.status= '1' and YEAR(date) = YEAR(CURRENT_DATE()) group by hb_donations.organization  order by donation_amount DESC limit 5")->result();


	   //       $response['year'] = $this->db->query(" SELECT round(SUM(hb_donations.amount),2) as donation_amount,hb_donations.*   FROM hb_donations  INNER JOIN hb_organization ON(hb_organization.id=hb_donations.organization)  WHERE hb_donations.status= '1' and YEAR(date) = YEAR(CURRENT_DATE()) group by hb_donations.organization  order by donation_amount DESC")->result();
	
	   //      foreach ($response['year'] as $key => $value) {
				// $abc=$this->db->query("SELECT * from hb_organization where id=".$value->organization)->result();	
				// $response['year'][$key]->logo=$abc[0]->logo;
				// $response['year'][$key]->title=$abc[0]->title; 
				// $response['year'][$key]->id=$abc[0]->id;        	
	   //      }


          	   $response['year'] = $this->db->query(" SELECT hb_organization.*,hb_organization.id as organid, hb_users.organization as id  FROM hb_organization LEFT JOIN hb_users ON(hb_users.organization=hb_organization.id and hb_users.id='".$user_id."')")->result();


                foreach ($response['year'] as $key => $value) {


            $add=$this->db->query("SELECT count(DISTINCT user_id) as number1 from hb_donations where hb_donations.organization='".$value->organid."' and  YEAR(hb_donations.date) = YEAR(CURRENT_DATE()) ")->row(); 

                	$add1=$this->db->query("SELECT count( id) as number2 from hb_donations where hb_donations.organization='".$value->organid."' and  YEAR(hb_donations.date) = YEAR(CURRENT_DATE()) ")->row(); 


             $response['year'][$key]->nodonors=$add->number1; 
          	$response['year'][$key]->nodonation=$add1->number2;




                $abc=$this->db->query("SELECT round(SUM(hb_donations.amount),2) as donation_amount from hb_donations where hb_donations.organization='".$value->organid."' and  YEAR(hb_donations.date) = YEAR(CURRENT_DATE()) " )->row();
                if (!empty($abc->donation_amount)) {
                $response['year'][$key]->donation_amount=$abc->donation_amount;    
                }
                else{
                $response['year'][$key]->donation_amount=0;
                }
                }

                usort($response['year'], "custom_sort");

                // echo "<pre>";
                // 	print_r($response);die;

	        return $response;
		
	}



	public function insert_data($tbl_name,$data)                                                    /* Data insert */
	{
		$this->db->insert($tbl_name, $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}


// To selct data from database
	public function select_data($selection,$tbl_name,$where=null,$order=null)                      /* Select data with condition*/
	{
		if (empty($where)&&empty($order)) {
			$data_response = $this->db->select($selection)
			->from($tbl_name)
			->get()->result();
		}
		elseif(empty($order)){
			$data_response =
			$this->db->select($selection)
			->from($tbl_name)
			->where($where)
			->get()->result();

		}else{
			$data_response =
			$this->db->select($selection)
			->from($tbl_name)
			->where($where)
			->order_by($order)
			->get()->result();
		}
		return $data_response;

	}

	// To count data from database
	public function count_data($selection,$tbl_name,$where=null,$order=null)                      /* Select data with condition*/
	{
		if (empty($where)&&empty($order)) {
			$data_response = $this->db->select($selection)
			->from($tbl_name)
			->get()->num_rows();
		}
		elseif(empty($order)){
			$data_response =
			$this->db->select($selection)
			->from($tbl_name)
			->where($where)
			->get()->num_rows();
		}else{
			$data_response =
			$this->db->select($selection)
			->from($tbl_name)
			->where($where)
			->order_by($order)
			->get()->num_rows();
		}
		return $data_response;

	}

// To update data
	public function update_data($tbl_name,$data,$where)                                    /* Update data */
	{
		$this->db->where($where);
		$this->db->update($tbl_name,$data);
		return($this->db->affected_rows())?1:0;
	}

// To delete data
	function row_delete($where,$tbl_name)
	{
		$this->db->where($where);
		$this->db->delete($tbl_name);
		return($this->db->affected_rows())?1:0;
	}


	public function admin_login($data)
	{

		$res = $this->db->select('*')
		->from('hb_users')
		->where('email',$data['email'])
		->where('password',md5($data['password']))
		->where('user_type',1)
		->get()->row();

		return $res;
	}


	public function subAdmin_login($data)
	{
		$res = $this->db->select('*')
		->from('tbl_subadmin')
		->where('email',$data['email'])
		->where('password',md5($data['password']))
		->get()->row();

		return $res;
	}

	function updateReviewStatus($revid,$val)
	{
		$this->db->where('id', $revid);
		$this->db->update('hb_users',array('providersStatus'=> $val));
		return $val;

	}

	function updateUserStatus($myid,$nwStatus)
	{
		$this->db->where('id', $myid);
		$this->db->update('hb_users',array('UserCurrStatus'=> $nwStatus));
		return $nwStatus;
	}

	public function freeServiceProviders($minTime,$maxTime)
	{
		$list = $this->db->query("SELECT * FROM `hb_users`
			where (user_type=2 or user_type=3) and (id not in (SELECT accepted_by FROM `tbl_bookingRequests`
				where accepted_by!=0 and (TIMESTAMP(booking_date,booking_time)<= '$minTime' and DATE_ADD(TIMESTAMP(booking_date,booking_time), INTERVAL `hours` HOUR)>= '$maxTime' )) or id not in (SELECT accepted_by FROM `tbl_bookingRequests`) )")->result();
		// print_r($this->db->last_query());
		return $list;
	}
	function getpusha(){
		$this->db->select('*')
		->from('hb_users')
		->join('tbl_login', 'hb_users.id = tbl_login.user_id')
		->where('user_type',0)
		->where('tbl_login.status',1);
		$data = $this->db->get()->result();
		return $data;
	}
	function getpushb(){
		$this->db->select('*')
		->from('hb_users')
		->join('tbl_login', 'hb_users.id = tbl_login.user_id')
		->where('user_type',2)
		->where('tbl_login.status',1);
		$data = $this->db->get()->result();
		return $data;
	}
	function getpushall(){
		$this->db->select('*')
		->from('hb_users')
		->join('tbl_login', 'hb_users.id = tbl_login.user_id')
		->where('((user_type=0 or user_type=2) and tbl_login.status=1 )');
		$data = $this->db->get()->result();
		return $data;
	}

	function selPrData(){
		$this->db->select('hb_users.*,tbl_wallet.balance as myAmount')
		->from('hb_users')
		->join('tbl_wallet','hb_users.id = tbl_wallet.user_id',left)
		->where('(hb_users.user_type=3 or hb_users.user_type=2)');
		$data = $this->db->get()->result();
		return $data;
	}


	function customQuoteSelect($id){
		$this->db->select('*')
		->from('tbl_pushQuotes')
		->join('hb_users','hb_users.id = tbl_pushQuotes.driver_id',left)
		->where('tbl_pushQuotes.req_id',$id);
		$data = $this->db->get()->result();
		return $data;
	}
	
	function logincount(){
		$query=$this->db->query("SELECT DISTINCT(user_id) AS count FROM tbl_login where status=1")->result();
		return $query;
	}


	public function get_users($selection,$tbl_name)
	{
		$row = $this->db->select("hb_users.*,hb_hbcu.title as hbcu_title,hb_organization.title as organization_title")
		->from("hb_users")
		->join('hb_hbcu','hb_hbcu.id = hb_users.hbcu','left')
		->join('hb_organization','hb_organization.id = hb_users.organization','left')
		->where('hb_users.user_type','0')
		->get()->result();
		return $row;
	}

	public function get_donations_id($id){

	$res['indivisual'] = $this->db->select('hb_donations.*,hb_hbcu.title,hb_users.first_name,hb_users.last_name,hb_users.email')
	->from('hb_donations')
	->where('hb_donations.user_id', $id)
	->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
	->join('hb_users','hb_donations.user_id = hb_users.id')
	->get()->result();



    $res['total'] = $this->db->select('hb_donations.*,hb_hbcu.title,hb_users.first_name,hb_users.last_name,hb_users.email')
	->from('hb_donations')
	->where('hb_donations.user_id', $id)
	->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
	->join('hb_users','hb_donations.user_id = hb_users.id')
	->group_by('donation_type')
	->get()->result();


	foreach ($res['total'] as $key => $value) {
		if ($value->donation_type==0) {
		$abc1=$this->db->SELECT('hb_hbcu.title')
	->from('hb_donations')
	->where('hb_donations.user_id', $id)
	->where('hb_donations.donation_type=',0)
	->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
	->join('hb_users','hb_donations.user_id = hb_users.id')
	->group_by('hb_donations.hbcu')
	->get()->result();

	$count=$this->db->query("SELECT  round(SUM(hb_donations.amount),2) as average FROM `hb_donations` join hb_hbcu on  hb_donations.hbcu = hb_hbcu.id  where hb_donations.user_id='".$id."' and hb_donations.donation_type=0 group by hb_donations.hbcu")->result();
	// print_r($count);
 



		$abc=$this->db->SELECT(' round(SUM(hb_donations.amount),2) as donation_amount_type1,hb_users.email')
	->from('hb_donations')
	->where('hb_donations.user_id', $id)
	->where('hb_donations.donation_type=',0)
	->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
	->join('hb_users','hb_donations.user_id = hb_users.id')
	->group_by('donation_type')
	->get()->row();

			$res['total'][$key]->total=$abc->donation_amount_type1;
			$res['total'][$key]->total12=$abc1;
			$res['total'][$key]->avgg=$count;
		}
		elseif($value->donation_type==1){

	$abc1=$this->db->SELECT('hb_hbcu.title')
	->from('hb_donations')
	->where('hb_donations.user_id', $id)
	->where('hb_donations.donation_type=',1)
	->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
	->join('hb_users','hb_donations.user_id = hb_users.id')
	->group_by('hb_donations.hbcu')
	->get()->result();

	$abc=$this->db->SELECT(' round(sum(hb_donations.amount),2) as donation_amount_type1,hb_users.email')
	->from('hb_donations')
	->where('hb_donations.user_id', $id)
	->where('hb_donations.donation_type=',1)
	->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
	->join('hb_users','hb_donations.user_id = hb_users.id')
	->group_by('donation_type')
	->get()->row();


		$count=$this->db->query("SELECT  round(SUM(hb_donations.amount),2) as average FROM `hb_donations` join hb_hbcu on  hb_donations.hbcu = hb_hbcu.id  where hb_donations.user_id='".$id."' and hb_donations.donation_type=1 group by hb_donations.hbcu")->result();
			// print_r($count);


			$res['total'][$key]->total=$abc->donation_amount_type1;
			$res['total'][$key]->total12=$abc1;
			$res['total'][$key]->avgg="N/A";
		}
elseif($value->donation_type==2){

	$abc1=$this->db->SELECT('hb_hbcu.title')
	->from('hb_donations')
	->where('hb_donations.user_id', $id)
	->where('hb_donations.donation_type=',2)
	->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
	->join('hb_users','hb_donations.user_id = hb_users.id')
	->group_by('hb_donations.hbcu')
	->get()->result();

	$abc=$this->db->SELECT(' round(sum(hb_donations.amount),2) as donation_amount_type1,hb_users.email')
	->from('hb_donations')
	->where('hb_donations.user_id', $id)
	->where('hb_donations.donation_type=',2)
	->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
	->join('hb_users','hb_donations.user_id = hb_users.id')
	->group_by('donation_type')
	->get()->row();


		$count=$this->db->query("SELECT  round(SUM(hb_donations.amount),2) as average FROM `hb_donations` join hb_hbcu on  hb_donations.hbcu = hb_hbcu.id  where hb_donations.user_id='".$id."' and hb_donations.donation_type=2 group by hb_donations.hbcu")->result();



			$res['total'][$key]->total=$abc->donation_amount_type1;	
			$res['total'][$key]->total12=$abc1;
			$res['total'][$key]->avgg="N/A";
		}
	}
	
		return $res;
			}
	public function get_totaldonations_id_xls($id){
				$res = $this->db->select('hb_donations.id,hb_donations.user_id,hb_donations.donation_type,hb_hbcu.title,hb_users.first_name,hb_users.last_name,hb_users.email')
	->from('hb_donations')
	->where('hb_donations.user_id', $id)
	->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
	->join('hb_users','hb_donations.user_id = hb_users.id')
	->group_by('donation_type')
	->get()->result_array();


	foreach ($res as $key => $value) {
		if ($value['donation_type']==0) {


	$abc1=$this->db->SELECT('hb_hbcu.title')
	->from('hb_donations')
	->where('hb_donations.user_id', $id)
	->where('hb_donations.donation_type=',0)
	->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
	->join('hb_users','hb_donations.user_id = hb_users.id')
	->group_by('hb_donations.hbcu')
	->get()->result();

	// $count=$this->db->query("SELECT  round(AVG(hb_donations.amount),2) as average FROM `hb_donations` join hb_hbcu on  hb_donations.hbcu = hb_hbcu.id join hb_users on  hb_donations.user_id = hb_users.id  where hb_donations.user_id='".$id."' and hb_donations.donation_type=0 group by hb_donations.hbcu")->result();
		$count=$this->db->query("SELECT  round(SUM(hb_donations.amount),2) as average FROM `hb_donations` join hb_hbcu on  hb_donations.hbcu = hb_hbcu.id  where hb_donations.user_id='".$id."' and hb_donations.donation_type=0 group by hb_donations.hbcu")->result();






		$abc=$this->db->SELECT(' round(sum(hb_donations.amount),2) as donation_amount_type1,hb_users.email')
	->from('hb_donations')
	->where('hb_donations.user_id', $id)
	->where('hb_donations.donation_type=',0)
	->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
	->join('hb_users','hb_donations.user_id = hb_users.id')
	->group_by('donation_type')
	->get()->row();


			$res[$key]['amount']=$abc->donation_amount_type1;
			$res[$key]['total12']=$abc1;
			$res[$key]['avgg']=$count;
		}
		elseif($value['donation_type']==1){



				$abc1=$this->db->SELECT('hb_hbcu.title')
	->from('hb_donations')
	->where('hb_donations.user_id', $id)
	->where('hb_donations.donation_type=',1)
	->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
	->join('hb_users','hb_donations.user_id = hb_users.id')
	->group_by('hb_donations.hbcu')
	->get()->result();

	$count=$this->db->query("SELECT  round(SUM(hb_donations.amount),2) as average FROM `hb_donations` join hb_hbcu on  hb_donations.hbcu = hb_hbcu.id join hb_users on hb_donations.user_id = hb_users.id  where hb_donations.user_id='".$id."' and hb_donations.donation_type=1 group by hb_donations.hbcu")->result();

		// $count=$this->db->query("SELECT  round(AVG(hb_donations.amount),2) as average FROM `hb_donations` join hb_hbcu on  hb_donations.hbcu = hb_hbcu.id  where hb_donations.user_id='".$id."' and hb_donations.donation_type=1 group by hb_donations.hbcu")->result();
		// print_r($this->db->last_query());die;



	$abc=$this->db->SELECT(' round(sum(hb_donations.amount),2) as donation_amount_type1,hb_users.email')
	->from('hb_donations')
	->where('hb_donations.user_id', $id)
	->where('hb_donations.donation_type=',1)
	->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
	->join('hb_users','hb_donations.user_id = hb_users.id')
	->group_by('donation_type')
	->get()->row();


			$res[$key]['amount']=$abc->donation_amount_type1;
			$res[$key]['total12']=$abc1;
			$res[$key]['avgg']="N/A";
		}
		elseif($value['donation_type']==2){



	$abc1=$this->db->SELECT('hb_hbcu.title')
	->from('hb_donations')
	->where('hb_donations.user_id', $id)
	->where('hb_donations.donation_type=',2)
	->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
	->join('hb_users','hb_donations.user_id = hb_users.id')
	->group_by('hb_donations.hbcu')
	->get()->result();

	// $count2=$this->db->query("SELECT  round(AVG(hb_donations.amount),2) as average FROM `hb_donations` join hb_hbcu on  hb_donations.hbcu = hb_hbcu.id  join hb_users on  hb_donations.user_id = hb_users.id  where hb_donations.user_id='".$id."' and hb_donations.donation_type=2 group by hb_donations.hbcu")->result();
	$count=$this->db->query("SELECT  round(SUM(hb_donations.amount),2) as average FROM `hb_donations` join hb_hbcu on  hb_donations.hbcu = hb_hbcu.id  where hb_donations.user_id='".$id."' and hb_donations.donation_type=2 group by hb_donations.hbcu")->result();




	$abc=$this->db->SELECT(' round(sum(hb_donations.amount),2) as donation_amount_type1,hb_users.email')
	->from('hb_donations')
	->where('hb_donations.user_id', $id)
	->where('hb_donations.donation_type=',2)
	->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
	->join('hb_users','hb_donations.user_id = hb_users.id')
	->group_by('donation_type')
	->get()->row();
			$res[$key]['amount']=$abc->donation_amount_type1;
			$res[$key]['total12']=$abc1;
			$res[$key]['avgg']="N/A";
		}
	}

	// echo "<pre>";
	// print_r($res);die;

		// foreach ($res as $row){
		// 				$exceldata[] = $row;
		// 				}
						return $res;


	// return $res;

			}


			public function datewisedonors($date){


			function custom_sort($a,$b) {
               return $b->donation_amount>$a->donation_amount;
             }



				 $response['month'] = $this->db->query(" SELECT hb_organization.*,hb_organization.id as organid, hb_users.organization as id  FROM hb_organization LEFT JOIN hb_users ON(hb_users.organization=hb_organization.id and hb_users.id='".$user_id."')")->result();


                foreach ($response['month'] as $key => $value) {


                	$add=$this->db->query("SELECT count(DISTINCT user_id) as number1 from hb_donations where hb_donations.organization='".$value->organid."' and  MONTH(hb_donations.date) = MONTH('".$date."') and  YEAR (hb_donations.date) = YEAR ('".$date."') ")->row(); 

                	$add1=$this->db->query("SELECT count( id) as number2 from hb_donations where hb_donations.organization='".$value->organid."' and  MONTH(hb_donations.date) = MONTH('".$date."') and  YEAR (hb_donations.date) = YEAR ('".$date."') ")->row(); 


                    $response['month'][$key]->nodonors=$add->number1; 
          	        $response['month'][$key]->nodonation=$add1->number2;




                $abc=$this->db->query("SELECT round(SUM(hb_donations.amount),2) as donation_amount from hb_donations where hb_donations.organization='".$value->organid."' and  MONTH(hb_donations.date) = MONTH('".$date."') and  YEAR(hb_donations.date) = YEAR('".$date."') " )->row();
                if (!empty($abc->donation_amount)) {
                $response['month'][$key]->donation_amount=$abc->donation_amount;    
                }
                else{
                $response['month'][$key]->donation_amount=0;
                }
                }

                usort($response['month'], "custom_sort");




                          	   $response['year'] = $this->db->query(" SELECT hb_organization.*,hb_organization.id as organid, hb_users.organization as id  FROM hb_organization LEFT JOIN hb_users ON(hb_users.organization=hb_organization.id and hb_users.id='".$user_id."')")->result();


                foreach ($response['year'] as $key => $value) {


            $add=$this->db->query("SELECT count(DISTINCT user_id) as number1 from hb_donations where hb_donations.organization='".$value->organid."' and  YEAR(hb_donations.date) = YEAR(CURRENT_DATE()) ")->row(); 

                	$add1=$this->db->query("SELECT count( id) as number2 from hb_donations where hb_donations.organization='".$value->organid."' and  YEAR(hb_donations.date) = YEAR(CURRENT_DATE()) ")->row(); 


             $response['year'][$key]->nodonors=$add->number1; 
          	$response['year'][$key]->nodonation=$add1->number2;




                $abc=$this->db->query("SELECT round(SUM(hb_donations.amount),2) as donation_amount from hb_donations where hb_donations.organization='".$value->organid."' and  YEAR(hb_donations.date) = YEAR(CURRENT_DATE()) " )->row();
                if (!empty($abc->donation_amount)) {
                $response['year'][$key]->donation_amount=$abc->donation_amount;    
                }
                else{
                $response['year'][$key]->donation_amount=0;
                }
                }

                usort($response['year'], "custom_sort");

                return $response;
			}


		public function datewiselovedhbcu($date){


		    function custom_sort($a,$b) {
               return $b->donation_amount>$a->donation_amount;
             }


          $response['month'] = $this->db->query(" SELECT hb_hbcu.id,hb_hbcu.logo,hb_hbcu.title, hb_hbcu.id as hbcuId  FROM hb_hbcu   ")->result();
          foreach ($response['month'] as $key => $value) {


          	$add=$this->db->query("SELECT count(DISTINCT user_id) as number1 from hb_donations where hbcu='".$value->id."' and  MONTH(hb_donations.date) = MONTH('".$date."') and  YEAR (hb_donations.date) = YEAR ('".$date."') ")->row();

          	$add1=$this->db->query("SELECT count(id) as number2 from hb_donations where hbcu='".$value->id."' and  MONTH(hb_donations.date) = MONTH('".$date."') and  YEAR (hb_donations.date) = YEAR ('".$date."') ")->row();

          	$response['month'][$key]->nodonors=$add->number1; 
          	$response['month'][$key]->nodonation=$add1->number2; 


          $abc=$this->db->query("SELECT round(SUM(hb_donations.amount),2) as donation_amount from hb_donations where hbcu='".$value->id."' and  MONTH(hb_donations.date) = MONTH('".$date."') and  YEAR(hb_donations.date) = YEAR('".$date."') " )->row();
	          if (!empty($abc->donation_amount)) {
	          	$response['month'][$key]->donation_amount=$abc->donation_amount; 
	          }
	          else{
	            $response['month'][$key]->donation_amount=0;
	          }
          }
          usort($response['month'], "custom_sort");





          $response['year'] = $this->db->query(" SELECT hb_hbcu.id,hb_hbcu.logo,hb_hbcu.title, hb_hbcu.id as hbcuId  FROM hb_hbcu   ")->result();
          foreach ($response['year'] as $key => $value) {


          	$add=$this->db->query("SELECT count(DISTINCT user_id) as number1 from hb_donations where hbcu='".$value->id."' and  YEAR(hb_donations.date) = YEAR(CURRENT_DATE()) ")->row();

          	$add1=$this->db->query("SELECT count(id) as number2 from hb_donations where hbcu='".$value->id."' and  YEAR(hb_donations.date) = YEAR(CURRENT_DATE()) ")->row();

          	$response['year'][$key]->nodonors=$add->number1; 
          	$response['year'][$key]->nodonation=$add1->number2; 


          $abc=$this->db->query("SELECT round(SUM(hb_donations.amount),2) as donation_amount from hb_donations where hbcu='".$value->id."' and  YEAR(hb_donations.date) = YEAR(CURRENT_DATE()) " )->row();
          if (!empty($abc->donation_amount)) {
          $response['year'][$key]->donation_amount=$abc->donation_amount;
            
          }
          else{
            $response['year'][$key]->donation_amount=0;
          }

          }
          usort($response['year'], "custom_sort");


    

        return $response;
	}

	public function topdonorsdatewisexls($date){
		function custom_sort($a,$b) {
		return $b['donation_amount']>$a['donation_amount'];
		}
		$response = $this->db->query(" SELECT hb_organization.*,hb_organization.id as organid, hb_users.organization as id  FROM hb_organization LEFT JOIN hb_users ON(hb_users.organization=hb_organization.id and hb_users.id='".$user_id."')")->result_array();
		foreach ($response as $key => $value) {


		$add=$this->db->query("SELECT count(DISTINCT user_id) as number1 from hb_donations where hb_donations.organization='".$value['organid']."' and  MONTH(hb_donations.date) = MONTH('".$date."') and  YEAR(hb_donations.date) = YEAR('".$date."')  ")->row();


		$add1=$this->db->query("SELECT count( id) as number2 from hb_donations where hb_donations.organization='".$value['organid']."' and  MONTH(hb_donations.date) = MONTH('".$date."') and  YEAR(hb_donations.date) = YEAR('".$date."')  ")->row(); 


		$response[$key]['nodonors']=$add->number1; 
		$response[$key]['nodonation']=$add1->number2;


		$abc=$this->db->query("SELECT round(SUM(hb_donations.amount),2) as donation_amount from hb_donations where hb_donations.organization='".$value['organid']."' and  MONTH(hb_donations.date) = MONTH('".$date."') and  YEAR(hb_donations.date) = YEAR('".$date."')  " )->row();
		if (!empty($abc->donation_amount)) {
		$response[$key]['donation_amount']=$abc->donation_amount;    
		}
		else{
		$response[$key]['donation_amount']='0';
		}
		}

		usort($response, "custom_sort");

		return $response;











	    
		
	}

public function lovedhbcuxlss($date){
				function custom_sort($a,$b) {
				return $b['donation_amount']>$a['donation_amount'];
				}


						$response= $this->db->query(" SELECT hb_hbcu.id,hb_hbcu.logo,hb_hbcu.title, hb_hbcu.id as hbcuId  FROM hb_hbcu   ")->result_array();
						foreach ($response as $key => $value) {




				$add=$this->db->query("SELECT count(DISTINCT user_id) as number1 from hb_donations where hbcu='".$value['id']."' and  MONTH(hb_donations.date) = MONTH('".$date."') and  YEAR(hb_donations.date) = YEAR('".$date."') ")->row(); 
                $add1=$this->db->query("SELECT count( id) as number2 from hb_donations where hbcu='".$value['id']."' and  MONTH(hb_donations.date) = MONTH('".$date."') and  YEAR(hb_donations.date) = YEAR('".$date."') ")->row(); 
             $response[$key]['nodonors']=$add->number1; 
          	$response[$key]['nodonation']=$add1->number2;


						$abc=$this->db->query("SELECT round(SUM(hb_donations.amount),2) as donation_amount from hb_donations where hbcu='".$value['id']."' and  MONTH(hb_donations.date) = MONTH('".$date."') and  YEAR(hb_donations.date) = YEAR('".$date."') " )->row();
						if (!empty($abc->donation_amount)) {
						$response[$key]['donation_amount']=$abc->donation_amount;
						}
						else{
						$response[$key]['donation_amount']='0';
						}
						}
						usort($response, "custom_sort");
						return $response;
}




public function get_donations_date($id,$date){

	// $res['indivisual'] = $this->db->select('hb_donations.*,hb_hbcu.title,hb_users.first_name,hb_users.last_name,hb_users.email')
	// ->from('hb_donations')
	// ->where('hb_donations.user_id', $id)
	// ->where('MONTH(hb_donations.date)', 'MONTH('".$date."')')
	// ->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
	// ->join('hb_users','hb_donations.user_id = hb_users.id')
	// ->get()->result();

	 $res['indivisual']=$this->db->query("SELECT hb_donations.*,hb_hbcu.title,hb_users.first_name,hb_users.last_name,hb_users.email from hb_donations join hb_hbcu on hb_donations.hbcu = hb_hbcu.id join hb_users on hb_donations.user_id = hb_users.id where hb_donations.user_id= '".$id."' and  MONTH(hb_donations.date) = MONTH('".$date."') and  YEAR(hb_donations.date) = YEAR('".$date."')  " )->result();





    $res['total'] = $this->db->select('hb_donations.*,hb_hbcu.title,hb_users.first_name,hb_users.last_name,hb_users.email')
	->from('hb_donations')
	->where('hb_donations.user_id', $id)
	->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
	->join('hb_users','hb_donations.user_id = hb_users.id')
	->group_by('donation_type')
	->get()->result();


	foreach ($res['total'] as $key => $value) {
		if ($value->donation_type==0) {
		$abc1=$this->db->SELECT('hb_hbcu.title')
	->from('hb_donations')
	->where('hb_donations.user_id', $id)
	->where('hb_donations.donation_type=',0)
	->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
	->join('hb_users','hb_donations.user_id = hb_users.id')
	->group_by('hb_donations.hbcu')
	->get()->result();

	$count=$this->db->query("SELECT  round(SUM(hb_donations.amount),2) as average FROM `hb_donations` join hb_hbcu on  hb_donations.hbcu = hb_hbcu.id  where hb_donations.user_id='".$id."' and hb_donations.donation_type=0 group by hb_donations.hbcu")->result();
	// print_r($count);
 



		$abc=$this->db->SELECT(' round(SUM(hb_donations.amount),2) as donation_amount_type1,hb_users.email')
	->from('hb_donations')
	->where('hb_donations.user_id', $id)
	->where('hb_donations.donation_type=',0)
	->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
	->join('hb_users','hb_donations.user_id = hb_users.id')
	->group_by('donation_type')
	->get()->row();

			$res['total'][$key]->total=$abc->donation_amount_type1;
			$res['total'][$key]->total12=$abc1;
			$res['total'][$key]->avgg=$count;
		}
		elseif($value->donation_type==1){

	$abc1=$this->db->SELECT('hb_hbcu.title')
	->from('hb_donations')
	->where('hb_donations.user_id', $id)
	->where('hb_donations.donation_type=',1)
	->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
	->join('hb_users','hb_donations.user_id = hb_users.id')
	->group_by('hb_donations.hbcu')
	->get()->result();

	$abc=$this->db->SELECT(' round(sum(hb_donations.amount),2) as donation_amount_type1,hb_users.email')
	->from('hb_donations')
	->where('hb_donations.user_id', $id)
	->where('hb_donations.donation_type=',1)
	->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
	->join('hb_users','hb_donations.user_id = hb_users.id')
	->group_by('donation_type')
	->get()->row();


		$count=$this->db->query("SELECT  round(SUM(hb_donations.amount),2) as average FROM `hb_donations` join hb_hbcu on  hb_donations.hbcu = hb_hbcu.id  where hb_donations.user_id='".$id."' and hb_donations.donation_type=1 group by hb_donations.hbcu")->result();
			// print_r($count);


			$res['total'][$key]->total=$abc->donation_amount_type1;
			$res['total'][$key]->total12=$abc1;
			$res['total'][$key]->avgg="N/A";
		}
elseif($value->donation_type==2){

	$abc1=$this->db->SELECT('hb_hbcu.title')
	->from('hb_donations')
	->where('hb_donations.user_id', $id)
	->where('hb_donations.donation_type=',2)
	->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
	->join('hb_users','hb_donations.user_id = hb_users.id')
	->group_by('hb_donations.hbcu')
	->get()->result();

	$abc=$this->db->SELECT(' round(sum(hb_donations.amount),2) as donation_amount_type1,hb_users.email')
	->from('hb_donations')
	->where('hb_donations.user_id', $id)
	->where('hb_donations.donation_type=',2)
	->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
	->join('hb_users','hb_donations.user_id = hb_users.id')
	->group_by('donation_type')
	->get()->row();


		$count=$this->db->query("SELECT  round(SUM(hb_donations.amount),2) as average FROM `hb_donations` join hb_hbcu on  hb_donations.hbcu = hb_hbcu.id  where hb_donations.user_id='".$id."' and hb_donations.donation_type=2 group by hb_donations.hbcu")->result();



			$res['total'][$key]->total=$abc->donation_amount_type1;	
			$res['total'][$key]->total12=$abc1;
			$res['total'][$key]->avgg="N/A";
		}
	}
	
		return $res;
			}


				public function userdatewisetxnxls($id,$newDate){


						// $response = $this->db->select('hb_donations.user_id,hb_donations.user_id,round(hb_donations.amount,2) as amount,hb_donations.donation_type,hb_donations.txnId,hb_donations.dateTime,hb_donations.percentage,hb_hbcu.title,hb_users.first_name,hb_users.last_name,hb_users.email')
						// ->from('hb_donations')
						// ->where('hb_donations.user_id', $id)
						// ->where('MONTH(hb_donations.date)=', 'Month('.$newDate.')')
						// ->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
						// ->join('hb_users','hb_donations.user_id = hb_users.id')
						// ->get();


						// // print_r($response);die;
						// foreach ($response->result_array() as $row){
						// $exceldata[] = $row;
						// }

						// $response = $this->db->select('hb_donations.user_id,hb_donations.user_id,round(hb_donations.amount,2) as amount,hb_donations.donation_type,hb_donations.txnId,hb_donations.dateTime,hb_donations.percentage,hb_hbcu.title,hb_users.first_name,hb_users.last_name,hb_users.email')
						// ->from('hb_donations')
						// ->where('hb_donations.user_id', $id)
						// ->where('MONTH(hb_donations.date)=', 'MONTH('.$newDate.')')
						// ->join('hb_hbcu','hb_donations.hbcu = hb_hbcu.id')
						// ->join('hb_users','hb_donations.user_id = hb_users.id')
						// ->get();
						// foreach ($response->result_array() as $row){
						// $exceldata[] = $row;
						// }
						// print_r($exceldata);die;

					$response=$this->db->query("SELECT hb_donations.user_id,hb_donations.user_id,round(hb_donations.amount,2) as amount,hb_donations.donation_type,hb_donations.txnId,hb_donations.dateTime,hb_donations.percentage,hb_hbcu.title,hb_users.first_name,hb_users.last_name,hb_users.email from hb_donations join hb_hbcu on hb_donations.hbcu = hb_hbcu.id join hb_users on hb_donations.user_id = hb_users.id where hb_donations.user_id= '".$id."' and MONTH ( hb_donations.date ) = MONTH ('".$newDate."') and YEAR ( hb_donations.date ) = YEAR ('".$newDate."') ")->result_array();
						return $response;

						// return $exceldata;

				}




}

?>
