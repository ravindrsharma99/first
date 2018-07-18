<?php

    class User_model extends CI_Model{

    function __construct() {
        parent::__construct();
    }
    // Sign up level 1
     function signup($myarray) {
             $chk_query = $this->db->select('*')
                                   ->from('hb_users')
                                   ->where('email',$myarray['email'])
                                   ->get()->row();
             if(!empty($chk_query) && $chk_query->access_token_status==0){
          
              if($chk_query->signup_level==5)
              {  
                if($myarray['signup_type']=="facebook")
                {
                   if($chk_query->fb_id==0)
                   {
                            $this->db->where("id", $chk_query->id);
                            $this->db->update("hb_users",$myarray);
                            $myarray['id']= $chk_query->id;
                            return $this->successResponse("Signup Successfully",$myarray);
                   }

                }

              }
              else
              {


                $this->db->where('user_id',$chk_query->id);
                $this->db->delete('hb_cards');
                $this->db->where('user_id',$chk_query->id);
                $this->db->delete('hb_stripecustomerdetails');
                  if($myarray['signup_type']=="facebook")
                  {
                  $this->db->where("id", $chk_query->id);
                  $this->db->update("hb_users",$myarray);
                  $myarray['id']= $chk_query->id;
                  return $this->successResponse("Signup Successfully",$myarray);

                  }elseif($myarray['signup_type']=="email")
                  {


                  $this->db->where("id", $chk_query->id);
                  $this->db->update("hb_users",$myarray);
                  $myarray['id']= $chk_query->id;
                  return $this->successResponse("Signup Successfully",$myarray);
                  } 

                }  
           

               return $this->errorResponse("Email Already Exists");
             }
             elseif(!empty($chk_query) && $chk_query->access_token_status==1){
                $myarray['access_token_status']='0';
                  $this->db->where("id", $chk_query->id);
                  $this->db->update("hb_users",$myarray);
                  $myarray['id']= $chk_query->id;
                  return $this->successResponse("Signup Successfully",$myarray);

             }
             else{
                            $this->db->insert('hb_users', $myarray);
                            $myarray['id']=$insert_id = $this->db->insert_id();
                            return $this->successResponse("Signup Successfully",$myarray);
             }
}
// Sign up level 2 & 4
  public function updateprofile($myarray,$user_id,$hbcu=NULL,$donation_percent=NULL) {
             $chk_query = $this->db->select('*')
                                   ->from('hb_users')
                                   ->where('id',$user_id)
                                   ->get()->row();

             if(empty($chk_query))
             {
               return $this->errorResponse("User not found");
             }

             $this->db->where("id", $user_id);
             $this->db->update("hb_users",$myarray);
             
             
            if(!empty($hbcu) and $hbcu!=0 and $hbcu!="0")
            {

               $this->db->where('user_id',$user_id);
               $this->db->delete('hb_usersHBCU');
 
               $hbcu=explode(",",$hbcu); 
               $donation_percent=explode(",",$donation_percent);
               $x=0;
               foreach ($hbcu as $key => $value) 
               {
                      $hbcuarray =array(
                        'user_id'=>$user_id,
                        'hbcu'=>trim($value),
                        'donation_percent'=>$donation_percent[$x],
                    ); 

                    $x++;
                    $this->db->insert("hb_usersHBCU",$hbcuarray);
               }

            
            }
            $UserDetails=$this->getUserDetails($user_id);
            // $UserDetails->abc=$myarray;
            // $UserDetails="1";
            if(isset($myarray['pin']))
            {
              return $this->successResponse("Pin Updated Successfully",$UserDetails);
            }else
            {

            return $this->successResponse("Profile Updated Successfully",$UserDetails);

            }

    }

 function updatePssword($password,$user_id)
  {

     return $updateData = $this->User_model->update_data('hb_users',array("password"=>$password),array("id"=>$user_id));
  }

   function CheckUserPssword($password,$user_id)
  {


  return $response = $this->db->select('*')->from('hb_users')->where('id', $user_id)->where('password', $password)->get()->row();

  }

  public function addOtherHBCU($user_id,$hbcu=NULL,$donation_percent=NULL) {
             
              $chk_query = $this->db->select('*')
                                   ->from('hb_users')
                                   ->where('id',$user_id)
                                   ->get()->row();

             if(empty($chk_query))
             {
               return $this->errorResponse("User not found");
             }



            if(!empty($hbcu))
            {

               $this->db->where('user_id',$user_id);
                $this->db->where('hbcuType',1);
               $this->db->delete('hb_usersHBCU');
 
               $hbcu=explode(",",$hbcu); 
               $donation_percent=explode(",",$donation_percent);
               $x=0;
               foreach ($hbcu as $key => $value) 
               {
                      $hbcuarray =array(
                        'user_id'=>$user_id,
                        'hbcu'=>trim($value),
                        'hbcuType'=>1,
                        'donation_percent'=>$donation_percent[$x],
                    ); 

                    $x++;
                    $this->db->insert("hb_usersHBCU",$hbcuarray);
               }

            
            }else
            {
               $response= $this->errorResponse("Something went wrong");
            }

          return $this->successResponse("HBCU Added Successfully",$response);
            

    }

  public function addHBCUComment($user_id,$hbcu,$comment) {
             
              $chk_query = $this->db->select('*')
                                   ->from('hb_users')
                                   ->where('id',$user_id)
                                   ->get()->row();

             if(empty($chk_query))
             {
               return $this->errorResponse("User not found");
             }

           
                      $hbcuarray =array(
                        'user_id'=>$user_id,
                        'hbcu'=>trim($hbcu),
                        'comment'=>$comment,
                        'created'=>date("Y-m-d H:i:s"),
                    ); 

                    $this->db->insert("hb_hbcuComments",$hbcuarray);
                  
                  $insert_id = $this->db->insert_id();
                  $getHbcu = $this->db->select('*')
                                   ->from('hb_hbcuComments')
                                   ->where('id',$insert_id)
                                   ->get()->row();

               return $this->successResponse("Comment Added Successfully",$getHbcu);
            

    }
  

    function updateuserhbcu($myarray,$id)
  {       
         
          $update = $this->db->where('id', $id);
          $this->db->update("hb_usersHBCU", $myarray
          );     

          if($update)
          {

             $response=    $getData->hbcu= $this->db->select('hb_usersHBCU.*')
              ->from('hb_usersHBCU')
             ->where('hb_usersHBCU.id',$id)
              ->get()->row();

             $response= $this->successResponse("HBCU Updated Successfully",$response);
          }else
          {
            $response= $this->errorResponse("Something went wrong");
          }
     
     return $response;
  
  }


  public function adduserhbcu($myarray) {

           
               $user_id=$myarray['user_id'];
               $hbcu=$myarray['hbcu']; 
               $donation_percent=$myarray['donation_percent'];
               $hbcuType=$myarray['hbcuType'];
               $x=0;
              if(!empty($hbcu))
              {
                        $hbcuarray =array(
                              'user_id'=>$user_id,
                              'hbcu'=>$hbcu,
                              'hbcuType'=>$hbcuType,
                              'donation_percent'=>$donation_percent);
                          
                          $this->db->insert("hb_usersHBCU",$hbcuarray);
                         $response = $this->User_model->getUserHBCU($user_id,NULL);  
                   $response= $this->successResponse("Added Successfully",$response);
               }
                  
              else
              {
                   $response= $this->errorResponse("Something went wrong");

              }
          
            

          return $response;
            

    }

 public function insertlogin($user_id,$login_via,$unique_device_id,$token_id) {

             $update = $this->db->or_where('unique_device_id=', $unique_device_id);
            $this->db->or_where('token_id =', $token_id);
            $this->db->update('hb_login', array(
              'status' => 0
            ));

            $insiData = array(
              'user_id' => $user_id,
              'login_via' => $login_via,
              'unique_device_id' => $unique_device_id,
              'token_id' => $token_id,
              'status' => 1
            );

            $insert = $this->db->insert("hb_login", $insiData);
    }



   public function insertCards($myarray, $user_id=NULL, $signup_level=NULL) {

             $chk_query = $this->db->select('*')
                                   ->from('hb_cards')
                                   ->where('card_num',$myarray['card_num'])
                                   ->where('user_id',$myarray['user_id'])
                                   ->get()->row();

             if($chk_query)
             {

              return $this->errorResponse("Sorry, Card Already Added by User",$myarray);

             }else
             {
                $chk_query = $this->db->select('*')
                                   ->from('hb_cards')
                                   ->where('card_token',$myarray['card_token'])
                                   ->where('user_id',$myarray['user_id'])
                                   ->get()->row();

                if($chk_query)
                {
                    return $this->errorResponse("Sorry, Card Token Already Added by User",$myarray);
                }
                 
                $this->db->insert("hb_cards",$myarray);
                $insert_id = $this->db->insert_id();
                $signup_level_array = array(
                    'signup_level'=>$signup_level
                ); 
                
                $this->db->where("id", $user_id);
                $this->db->update("hb_users",$signup_level_array);

                $myarray['signup_level'] =$signup_level;
                 $myarray["id"] =$insert_id;
                return $this->successResponse("Card details inserted Successfully",$myarray);
             }
    }

public function insertStripecustomerdetails($myarray) 
 {

                $this->db->insert("hb_stripecustomerdetails",$myarray);
             
}



function errorResponse($message,$data=NULL)
{ 

   if(!empty($data))
   {
        return $result = array(
                    "error" => true,
                    "message" => $message,
                    "result" => $data
                );
   }else
   {

    return $result = array(
                    "error" => true,
                    "message" => $message
                );
   }

}

function successResponse($message,$result)
{

  return $result = array(
                    "error"  => false,
                    "message" =>$message,
                    "result" => $result
                );
}


 function login($myarray)
        {
        $check=$this->db->query("SELECT * from hb_users where email='".$myarray['email']."' ")->row();

        if ($myarray['login_type'] == "email")
        {
        $response = $this->db->select('*')
        ->from('hb_users')
        ->where('lower(email)', $myarray['email'])
        ->where('password', md5($check->email."-".$myarray['password']))
        ->where('active_status =', 0 )
        ->where('signup_level =', 5 )
        ->get()->row();


        if(empty($response))
        {

        $user = $this->db->select('*')
        ->from('hb_users')
        ->where('lower(email)', $myarray['email'])
        ->where('password', md5($check->email."-".$myarray['password']))
        ->where('active_status =', 0 )
        ->get()->row();

        if($user)
        {

        // $array=array("signup_level"=>$user->signup_level);
        // return $this->errorResponse("Your Account is not completed yet",$array);
        return $this->errorResponse("User not registered");


        }else
        {
        return $this->errorResponse("Invalid email or password.");
        }  
        }
        else
        {
        $UserDetails=$this->getUserDetails($response->id);
        }

        }
        elseif ($myarray['login_type'] == "facebook")
        { 

            $response = $this->db->select('*')
            ->from('hb_users')
            ->where('email', $myarray['email'])
            ->where('fb_id', $myarray['fb_id'])
            ->where('fb_id!=', '')
            ->where('fb_id!=', 0)
            ->where('active_status =', 0 )
            ->where('signup_level =', 5 )
            ->get()->row();

            if(empty($response))
            {

            $user = $this->db->select('*')
            ->from('hb_users')
            ->where('email', $myarray['email'])
            ->where('fb_id', $myarray['fb_id'])
            ->where('fb_id!=', '')
            ->where('fb_id!=', 0)
            ->where('active_status =', 0 )
            ->get()->row();

            if($user)
            {
            $array=array("signup_level"=>$user->signup_level);
            return $this->errorResponse("User not registered.");
            }else
            {
            return $this->errorResponse("Invalid email.");
            }

            }else
            {
            $UserDetails=$this->getUserDetails($response->id);
            }

        }

        /*push end*/

        if(!empty($response))
        {
        if ($response->access_token_status==1) {
        return $this->errorResponse("Because of some updations in the basic structure of app, you need to create your account again.");
        }
        else{
        //$update = $this->db->or_where('user_id', $response->id);
        $update = $this->db->or_where('unique_device_id=', $myarray['unique_device_id']);
        $this->db->or_where('token_id =', $myarray['token_id']);
        $this->db->update('hb_login', array(
        'status' => 0
        ));

        $insiData = array(
        'user_id' => $response->id,
        'login_via' => $myarray['login_via'],
        'unique_device_id' => $myarray['unique_device_id'],
        'token_id' => $myarray['token_id'],
        'status' => 1
        );

        $insert = $this->db->insert("hb_login", $insiData);

        return $this->successResponse("Login Successfully",$UserDetails);
        }
        }
        }





function updateHBCUDonationPercent($myarray,$id)
  {       
         
          $update = $this->db->where('id', $id);
          $this->db->update("hb_usersHBCU", $myarray
          );     

          if($update)
          {

             return    $getData->hbcu= $this->db->select('hb_hbcu.*, hb_usersHBCU.donation_percent, hb_usersHBCU.id, hb_usersHBCU.hbcuType')
              ->from('hb_usersHBCU')
              ->join('hb_hbcu','hb_hbcu.id = hb_usersHBCU.hbcu')
             ->where('hb_usersHBCU.id',$id)
              ->get()->row();
          }
     
  
  }


  function checkHbcuAreadyInserted($hbcu,$user_id)
  {       
         
        
             $hbcu= $this->db->select('hb_usersHBCU.*')
              ->from('hb_usersHBCU')
             ->where('hb_usersHBCU.hbcu',$hbcu)
             ->where('hb_usersHBCU.user_id',$user_id)
              ->get()->row();

              return $hbcu;
        
     
  
  }



  function checkHbcuExists($hbcu)
  {       
         
        
              $hbcu= $this->db->select('hb_hbcu.*')
              ->from('hb_hbcu')
             ->where('hb_hbcu.id',$hbcu)
              ->get()->row();

              return $hbcu;
  
  }


 function deleteUserHbcu($id)
  {       
              $result= $this->db->where('id',$id);
             return  $this->db->delete('hb_usersHBCU');
  }







function getUserDetails($user_id)
  {


     $getData = $this->db->select('hb_users.*, hb_users.isActivereoccuring as reoccurringisActive, hb_users.isActivesparechange as spareChangeisActive')
      ->from('hb_users')
      ->join('hb_reoccurringDonations','hb_users.id = hb_reoccurringDonations.user_id', 'left')
      ->join('hb_spareChangeDonations','hb_users.id = hb_spareChangeDonations.user_id', 'left')
      ->where('hb_users.id',$user_id)
      ->get()->row();
      if($getData)
     {

      if($getData->reoccurringisActive==NULL)
      {
        $getData->reoccurringisActive=0;
      }
      if($getData->spareChangeisActive==NULL)
      {
        $getData->spareChangeisActive=0;
      }

        $getData->hbcu=explode(",",$getData->hbcu);
         $getData->hbcu= $this->db->select('hb_hbcu.*, hb_usersHBCU.donation_percent,  hb_usersHBCU.id,  hb_usersHBCU.hbcuType ')
          ->from('hb_usersHBCU')
          ->join('hb_hbcu','hb_hbcu.id = hb_usersHBCU.hbcu')
         ->where('hb_usersHBCU.user_id',$getData->id)
          ->get()->result();
         if($getData->hbcu==NULL)
         {
          $getData->hbcu=[];
         }



      //echo $getData->hbcu;die;
   /*      $getData->hbcu=explode(",",$getData->hbcu);
         $getData->hbcu= $this->db->select('*')
          ->from('hb_hbcu')
          ->where_in('hb_hbcu.id', $getData->hbcu)
          ->get()->result();
         if($getData->hbcu==NULL)
         {
          $getData->hbcu=[];
         }*/

         $getData->organization= $this->db->select('*')
          ->from('hb_organization')
          ->where('hb_organization.id',$getData->organization)
          ->get()->row();
         if($getData->organization==NULL)
         {
          $getData->organization="";
         }


         $getData->link_cards= $this->db->select('*')
          ->from('hb_cards')
          ->where('hb_cards.user_id',$getData->id)
          ->order_by('hb_cards.id', 'DESC')
          ->get()->result();
         if($getData->link_cards==NULL)
         {
          $getData->link_cards=[];
         }

     }



     return $getData;
  //return $response = $this->db->select('*')->from('hb_users')->where('id', $user_id)->get()->row();

  }


   public function getCard($user_id,$card_id){
      $getData = $this->db->select('*')
      ->from('hb_stripecustomerdetails')
      ->where('user_id',$user_id)
      ->where('card_num',$card_num)
      ->get()->row();

      return $getData;
    }

  public function getUserCard($card_id){

     $getData= $this->db->select('hb_cards.user_id, hb_cards.card_num, hb_stripecustomerdetails.customer_id')
          ->from('hb_cards')
          ->join('hb_stripecustomerdetails','hb_cards.user_id = hb_stripecustomerdetails.user_id and hb_cards.card_num = hb_stripecustomerdetails.card_num')
         ->where('hb_cards.id',$card_id)
          ->get()->row();

   

      return $getData;
    }
  

 function getHbcu($user_id)
  {
       return $getData= $this->db->select('hb_hbcu.*, hb_usersHBCU.id as selectedHBCU, hb_usersHBCU.donation_percent')
          ->from('hb_hbcu')
          ->join('hb_usersHBCU','hb_hbcu.id = hb_usersHBCU.hbcu and hb_usersHBCU.user_id='.$user_id, 'left')
          ->group_by('hb_hbcu.id')
          ->order_by('created','ASC')
          ->get()->result();

  }

  function checkHbcuExist($hbcu)
  {
       return $result = $this->db->query(" SELECT * FROM hb_hbcu WHERE id='".$hbcu."'")->row();


  }


  function getHbcuDetails($hbcu)
  {

         $result = $this->db->query(" SELECT round(SUM(amount),2) as total_amount FROM hb_donations WHERE status='1' and hbcu='".$hbcu."'")->row();

         $response['total_donation'] = $result->total_amount ?: "0"; 

         $result = $this->db->query(" SELECT COUNT(comment) as total_comment FROM hb_hbcuComments WHERE hbcu='".$hbcu."'")->row();

          $response['total_comment'] = $result->total_comment ?: "0"; 



         $result = $this->db->query(" SELECT COUNT(hb_usersHBCU.hbcu) as total_favourite FROM hb_usersHBCU INNER JOIN hb_users ON(hb_users.id=hb_usersHBCU.user_id) WHERE hb_usersHBCU.hbcu='".$hbcu."'")->row();

          $response['total_favourite'] = $result->total_favourite ?: "0"; 


          $result = $this->db->query(" SELECT COUNT(distinct(hb_donations.user_id)) as total_donatedby FROM hb_donations INNER JOIN hb_users ON(hb_users.id=hb_donations.user_id) WHERE hb_donations.status='1' and hb_donations.hbcu='".$hbcu."'")->row();

         $response['total_donatedby'] = $result->total_donatedby ?: "0"; 

          return $response;
  }



  function getHbcuDonatedBy($hbcu)
  {

          $result = $this->db->query(" SELECT round(SUM(hb_donations.amount),2) as total_amount, hb_donations.hbcu as hbcuId, hb_users.*,hb_users.id as useredid FROM hb_donations INNER JOIN hb_users ON(hb_users.id=hb_donations.user_id)  WHERE hb_donations.status='1' and hb_donations.hbcu='".$hbcu."' group by hb_donations.user_id order by hb_donations.dateTime desc")->result();
          foreach ($result as $key => $value) {
            $abc=$this->db->query("SELECT * from hb_users where id='".$value->useredid."'")->row();
            if ($abc->anonymous==1) {
              $value->first_name='';
              $value->last_name='';

            }
          }


          // print_r($result);die;

          return $result;
  }

  function getHbcuFavouriteBy($hbcu)
  {

         $result = $this->db->query(" SELECT hb_usersHBCU.id, hb_usersHBCU.hbcu as hbcuId, hb_users.* FROM hb_usersHBCU INNER JOIN hb_users ON(hb_users.id=hb_usersHBCU.user_id)  WHERE  hb_usersHBCU.hbcu='".$hbcu."' order by hb_usersHBCU.date desc")->result();
         // print_r($result);die;

          return $result;
  }


   function getHbcuCommentsBy($hbcu)
  {
         
         $result = $this->db->query(" SELECT hb_hbcuComments.comment, hb_hbcuComments.created, hb_hbcuComments.hbcu as hbcuId, hb_users.* FROM hb_hbcuComments INNER JOIN hb_users ON(hb_users.id=hb_hbcuComments.user_id)  WHERE  hb_hbcuComments.hbcu='".$hbcu."' order by hb_hbcuComments.created desc")->result();
         
          return $result;
  }

 function getOrganization($user_id)
  {

          return $getData= $this->db->select('hb_organization.*, hb_users.organization as selectedOrganization')
          ->from('hb_organization')
          ->join('hb_users','hb_users.organization = hb_organization.id and hb_users.id='.$user_id, 'left')
          ->group_by('hb_organization.id')
          ->get()->result();
  }




function checkUserHBCU($user_id,$hbcu=NULL)
  {
         if(!empty($hbcu))
         {
             return $getData= $this->db->select('hb_usersHBCU.*')
          ->from('hb_usersHBCU')
           ->where('hb_usersHBCU.user_id',$user_id)
           ->where('hb_usersHBCU.hbcu',$hbcu)
          ->get()->result();
         }else
         {
             return $getData= $this->db->select('hb_usersHBCU.*')
          ->from('hb_usersHBCU')
           ->where('hb_usersHBCU.user_id',$user_id)
           // ->where('hb_usersHBCU.donation_percent >','0')
          ->get()->result();
         } 
         
   } 


   function checkUserHBCUpercent($user_id)
  {
   
             $getData= $this->db->select('hb_usersHBCU.*')
          ->from('hb_usersHBCU')
           ->where('hb_usersHBCU.user_id',$user_id)
           ->where('hb_usersHBCU.donation_percent >','0')
          ->get()->result();
          $abc=array();
          foreach ($getData as $key => $value) {
            if ($value->donation_percent!=0) {
              $abc[]=$value;
            }
          }
          // print_r($abc);
          // die;
          return $abc;
    
   } 

function getUserHBCU($user_id,$hbcuType)
  {
       
       if(empty($hbcuType))
       {
         return $getData= $this->db->select('hb_hbcu.*, hb_usersHBCU.donation_percent, hb_usersHBCU.id,  hb_usersHBCU.hbcuType, hb_usersHBCU.hbcu')
          ->from('hb_usersHBCU')
          ->join('hb_hbcu','hb_hbcu.id = hb_usersHBCU.hbcu')
           ->where('hb_usersHBCU.user_id',$user_id)
          ->get()->result();
       }else
       {
      return $getData= $this->db->select('hb_hbcu.*, hb_usersHBCU.donation_percent, hb_usersHBCU.id, hb_usersHBCU.hbcuType')
          ->from('hb_usersHBCU')
          ->join('hb_hbcu','hb_hbcu.id = hb_usersHBCU.hbcu')
           ->where('hb_usersHBCU.user_id',$user_id)
           ->where('hb_usersHBCU.hbcuType',$hbcuType)
          ->get()->result();
        }
}

  

function getDonationDetails($user_id)
  {
             $chk_query = $this->db->select('*')
                                   ->from('hb_users')
                                   ->where('id',$user_id)
                                   ->get()->row();

             if(empty($chk_query))
             {
               return $chk_query;

             }else
             {
                  $result = $this->db->query(" SELECT SUM(amount) as total_amount FROM hb_donations WHERE date BETWEEN CURDATE() - INTERVAL 29 DAY AND CURDATE() and user_id= '".$user_id."' and donation_type='0' group by donation_type")->row();
                 
                  $response['spare_change'] = round($result->total_amount,2) ?: "0";
                 

                  $result = $this->db->query(" SELECT SUM(amount) as total_amount FROM hb_donations WHERE date BETWEEN CURDATE() - INTERVAL 29 DAY AND CURDATE() and user_id= '".$user_id."' and donation_type='1' group by donation_type")->row();

                   $response['reoccurring'] = round($result->total_amount,2) ?: "0";

                  $result = $this->db->query(" SELECT SUM(amount) as total_amount FROM hb_donations WHERE date BETWEEN CURDATE() - INTERVAL 29 DAY AND CURDATE() and user_id= '".$user_id."' and donation_type='2' group by donation_type")->row();

                  $response['one_time'] = round($result->total_amount,2) ?: "0";

                  
                  $result = $this->db->query(" SELECT  SUM(amount) as total_amount
                  FROM    hb_donations
                  WHERE  date BETWEEN CURDATE() - INTERVAL 29 DAY AND CURDATE() and  user_id= '".$user_id."' group by user_id")->row();
                
                    $response['recent_donations'] = round($result->total_amount,2) ?: "0";
                    $UserDetails = $this->User_model->getUserDetails($user_id);
                    $response['ins_id']=$UserDetails->plaid_ins_id;

                  return $response;
             }
  }


function getDonationStatement($user_id,$from_date,$to_date)
  {
             $chk_query = $this->db->select('*')
                                   ->from('hb_users')
                                   ->where('id',$user_id)
                                   ->get()->row();

             if(empty($chk_query))
             {
               return $chk_query;

             }else
             {
                  
                $resultDonations = $this->db->query(" SELECT  hb_donations.*,hb_organization.title as organizationtitle,hb_hbcu.title as hbcutitle FROM hb_donations left join  hb_organization on hb_donations.organization=hb_organization.id  left join hb_hbcu on hb_donations.hbcu=hb_hbcu.id
                WHERE  date BETWEEN '".$from_date."' AND '".$to_date."' and  user_id= '".$user_id."' and status='1'")->result();
              /*     $resultDonations=array();
                  foreach ($getresultdonation as $key => $value) {
                    $abc=array();
                    $abc=$this->db->query("SELECT  hb_donations.*,hb_organization.title as organizationtitle,hb_hbcu.title as hbcutitle FROM hb_donations join  hb_organization on hb_donations.organization=hb_organization.id where `date`='".$value->date."'")->result();
                    $abc1=$value->date;
                    if (!empty($abc)) {
                      $resultDonations[]->$abc1=$abc;
                    }
                  }*/

                $result = $this->db->query(" SELECT  round(SUM(amount),2) as total_amount FROM hb_donations
                  WHERE  date BETWEEN '".$from_date."' AND '".$to_date."' and  user_id= '".$user_id."' and status='1'")->row();
                  
                   $response['donations'] = $resultDonations;
                   $response['total_donations'] = $result->total_amount ?: "0";

                  return $response;
             }
  }

function getReoccurringDonation($user_id)
  {
    
    return $result = $this->db->query(" SELECT *,hb_reoccurringDonations.id as reoccuringid,hb_hbcu.title FROM hb_reoccurringDonations join hb_hbcu on hb_reoccurringDonations.hbcu_id=hb_hbcu.id WHERE user_id= '".$user_id."'")->row();

  }


  function getAllReoccurringDonations($cycle)
  {

      $date=date("Y-m-d");
      return $result = $this->db->query("SELECT * FROM hb_reoccurringDonations join hb_users on hb_users.id=hb_reoccurringDonations.user_id WHERE hb_users.isActivereoccuring= '1' and hb_reoccurringDonations.cycle= '".$cycle."' and '".$date."' NOT IN(select hb_donations.paymentdate from hb_donations where hb_donations.user_id=hb_reoccurringDonations.user_id and  '".$date."'=hb_donations.paymentdate and hb_donations.donation_type='1' and hb_donations.status='1')")->result();
      // return $result=$this->db->query("SELECT * FROM hb_reoccurringDonations WHERE isActive= '1' and cycle= '".$cycle."' ")->result();
  }



function getDonations($sort,$user_id)
  {
      function custom_sort($a,$b) {
          return $b->donation_amount>$a->donation_amount;
     }


      if(strtolower($sort)=="month")
      {


          $response = $this->db->query(" SELECT hb_hbcu.*, hb_hbcu.id as hbcuId  FROM hb_hbcu   ")->result();
          foreach ($response as $key => $value) {
          $abc=$this->db->query("SELECT round(SUM(hb_donations.amount),2) as donation_amount from hb_donations where hbcu='".$value->id."' and hb_donations.status= '1' and  MONTH(hb_donations.date) = MONTH(CURRENT_DATE()) " )->row();
          if (!empty($abc->donation_amount)) {
          $response[$key]->donation_amount=$abc->donation_amount;
            
          }
          else{
            $response[$key]->donation_amount=0;
          }

          }
          usort($response, "custom_sort");
          $result['donations']=$response;




          $response = $this->db->query(" SELECT round(SUM(hb_donations.amount),2) as donation_amount FROM hb_donations  WHERE hb_donations.status= '1' and MONTH(date) = MONTH(CURRENT_DATE())")->row();

             $result['total']=round($response->donation_amount,2);

        
    }
      elseif(strtolower($sort)=="year")
      {


        $response = $this->db->query(" SELECT hb_hbcu.*, hb_hbcu.id as hbcuId  FROM hb_hbcu   ")->result();
        foreach ($response as $key => $value) {
        $abc=$this->db->query("SELECT round(SUM(hb_donations.amount),2) as donation_amount from hb_donations where hbcu='".$value->id."' and hb_donations.status= '1' and  YEAR(hb_donations.date) = YEAR(CURRENT_DATE()) " )->row();
       
             if (!empty($abc->donation_amount)) {
          $response[$key]->donation_amount=$abc->donation_amount;
            
          }
          else{
            $response[$key]->donation_amount=0;
          }

          
        }
        usort($response, "custom_sort");
        $result['donations']=$response;



        $response = $this->db->query(" SELECT round(SUM(hb_donations.amount),2) as donation_amount FROM hb_donations  WHERE hb_donations.status= '1' and YEAR(date) = YEAR(CURRENT_DATE())")->row();
       $result['total']=$response->donation_amount;
      }
      else
       {
         $result="";
       }
         $result['sort']=$sort;
         $result['month']=date("F");
         $result['year']=date("Y");
        return  $result;
  }


    function getTopDonors($sort,$user_id)
  {

     function custom_sort($a,$b) {
          return $b->donation_amount>$a->donation_amount;
     }

      
       if(strtolower($sort)=="month")
       {

        // $response = $this->db->query(" SELECT round(SUM(hb_donations.amount),2) as donation_amount, hb_organization.title, hb_users.organization as id, hb_organization.logo FROM hb_donations LEFT JOIN hb_users ON(hb_users.organization=hb_donations.organization and hb_users.id='".$user_id."'  ) INNER JOIN hb_organization ON(hb_organization.id=hb_donations.organization) WHERE hb_donations.status= '1' and MONTH(date) = MONTH(CURRENT_DATE()) group by hb_donations.organization  order by donation_amount DESC ")->result();
            // $response = $this->db->query(" SELECT round(SUM(hb_donations.amount),2) as donation_amount, hb_organization.title, hb_users.organization as id, hb_organization.logo FROM hb_donations LEFT JOIN hb_users ON(hb_users.organization=hb_donations.organization and hb_users.id='".$user_id."'  ) LEFT JOIN hb_organization ON(hb_organization.id=hb_donations.organization) WHERE hb_donations.status= '1' and MONTH(date) = MONTH(CURRENT_DATE()) group by hb_donations.organization  order by donation_amount DESC ")->result();


               $response = $this->db->query(" SELECT hb_organization.*,hb_organization.id as organid, hb_users.organization as id  FROM hb_organization LEFT JOIN hb_users ON(hb_users.organization=hb_organization.id and hb_users.id='".$user_id."')")->result();


                foreach ($response as $key => $value) {
                $abc=$this->db->query("SELECT round(SUM(hb_donations.amount),2) as donation_amount from hb_donations where hb_donations.organization='".$value->organid."' and  MONTH(hb_donations.date) = MONTH(CURRENT_DATE()) " )->row();
                if (!empty($abc->donation_amount)) {
                $response[$key]->donation_amount=$abc->donation_amount;    
                }
                else{
                $response[$key]->donation_amount=0;
                }
                }

          usort($response, "custom_sort");
               // print_r($response);die;
          $result['donations']=$response;


      
       $result['donations']=$response;
       
        $response = $this->db->query(" SELECT round(SUM(hb_donations.amount),2) as donation_amount FROM hb_donations  INNER JOIN hb_organization ON(hb_organization.id=hb_donations.organization) WHERE hb_donations.status= '1' and MONTH(date) = MONTH(CURRENT_DATE())    order by donation_amount DESC ")->row();
  

       $result['total']=$response->donation_amount;

       }

      else if(strtolower($sort)=="year")
       {

        // $response = $this->db->query(" SELECT round(SUM(hb_donations.amount),2) as donation_amount, hb_organization.title, hb_users.organization as id, hb_organization.logo FROM hb_donations LEFT JOIN hb_users ON(hb_users.organization=hb_donations.organization  and hb_users.id='".$user_id."' ) INNER JOIN hb_organization ON(hb_organization.id=hb_donations.organization) WHERE hb_donations.status= '1' and YEAR(date) = YEAR(CURRENT_DATE()) group by hb_donations.organization  order by donation_amount DESC ")->result();

         $response = $this->db->query(" SELECT hb_organization.*,hb_organization.id as organid, hb_users.organization as id  FROM hb_organization LEFT JOIN hb_users ON(hb_users.organization=hb_organization.id and hb_users.id='".$user_id."')")->result();


                foreach ($response as $key => $value) {
                $abc=$this->db->query("SELECT round(SUM(hb_donations.amount),2) as donation_amount from hb_donations where hb_donations.organization='".$value->organid."' and  YEAR(hb_donations.date) = YEAR(CURRENT_DATE()) " )->row();
                if (!empty($abc->donation_amount)) {
                $response[$key]->donation_amount=$abc->donation_amount;    
                }
                else{
                $response[$key]->donation_amount=0;
                }
                }

          usort($response, "custom_sort");


       $result['donations']=$response;



         $response = $this->db->query(" SELECT round(SUM(hb_donations.amount),2) as donation_amount FROM hb_donations  INNER JOIN hb_organization ON(hb_organization.id=hb_donations.organization) WHERE hb_donations.status= '1' and YEAR(date) = YEAR(CURRENT_DATE())    order by donation_amount DESC ")->row();
       $result['total']=$response->donation_amount;

       }else
       { 
         $result="";
       }


         $result['sort']=$sort; 
         $result['month']=date("F");
         $result['year']=date("Y");  
        return  $result;
    } 



 public function forgotpassword($email)
  {
    $select_user = $this->db->select('*')->from('hb_users')->where('lower(email)', $email)->get()->row();
    
if (empty($select_user->id))
    {
      return 0;
    }
    else
    {
      $token = bin2hex(md5($select_user->id)."_".openssl_random_pseudo_bytes(16)); 
      
      $timestamp=strtotime(date('Y-m-d H:i:s', strtotime('+ 2 hours')));   
         
        
      $update_pwd = $this->db->where('id', $select_user->id);
   $this->db->update("hb_users", array(
      'reset_password_token' => $token,
      'reset_password_timestamp' => $timestamp)
    );

      $result['token'] =$token;
      $result['user_id'] = $select_user->id;
      $result['first_name'] = $select_user->first_name;

      return $result;
    }
  }

public function forgotpin($email,$user_id)
  {
      if($email!='')
      {
        $select_user = $this->db->select('*')->from('hb_users')->where('email', $email)->get()->row();
      }

       if($user_id!='')
      {
        $select_user = $this->db->select('*')->from('hb_users')->where('id', $user_id)->get()->row();
      } 


if (empty($select_user->id))
    {
      return 0;
    }
    else
    {
      $token = bin2hex(md5($select_user->id)."_".openssl_random_pseudo_bytes(16)); 
      
      $timestamp=strtotime(date('Y-m-d H:i:s', strtotime('+ 2 hours'))); 
         
        
      $update_pwd = $this->db->where('id', $select_user->id);
      $this->db->update("hb_users", array(
      'reset_pin_token' => $token,
      'reset_pin_timestamp' => $timestamp)
    );

      $result['token'] =$token;
      $result['user_id'] = $select_user->id;
      $result['first_name'] = $select_user->first_name;

      return $result;
    }
  }




    public function updateNewpassword($message){
    
    $select_user = $this->db->select('*')->from('hb_users')->where('reset_password_token', $message['token'])->get()->row();

   if($select_user->id)
   {
    
    $email=$select_user->email;
    $reset_password_timestamp=$select_user->reset_password_timestamp;

    $current_timestamp=strtotime(date('Y-m-d H:i:s'));
      
    $message['id']=$select_user->id;
      if($current_timestamp<=$reset_password_timestamp)
      {

          
            $update_pwd = $this->db->where('id', $message['id']);
          $this->db->update("hb_users", array(
             'password' => md5($email."-".$message['password']),
            'reset_password_token' => '')
          );


          if ($update_pwd)
          {
            $this->session->set_flashdata('msg', '<span style="color:green">Password Changed Successfully</span>');
            redirect("api/User/newpassword?token=" . $message['token']);
          }
          else
          {
            $this->session->set_flashdata('msg', '<span style="color:red">Error in Updating Password</span>');
            redirect("api/User/newpassword?token=" . $message['token']);
          }

      }else
          {
            $this->session->set_flashdata('msg', '<span style="color:red">Reset password token has been expired</span>');
            redirect("api/User/newpassword?token=" . $message['token']);
          }

   }else
          {
            $this->session->set_flashdata('msg', '<span style="color:red">Wrong Reset password token</span>');
            redirect("api/User/newpassword?token=" . $message['token']);
          }
     

    
  }

public function addDonation($transArray){
      $Response = $this->insert_data('hb_donations',$transArray);

      if($Response)
      {

           $result = $this->db->select('*')->from('hb_donations')->where('id', $Response)->get()->row();
      }else
      {
           $result="";
      }

      return $result;

}

function RemoveFalseButNotZero($value) {
  return ($value || is_numeric($value));
}

public function addReoccurringDonation($transArray,$id=NULL){
      
      if($id>0 and $id!='')
      {
             $updateArray =array(
                                 'amount'=>$transArray['amount'],
                                  'cycle'=>           $transArray['cycle'], 
                                 'card_id'=>$transArray['card_id'],
                                  'hbcu_id'=>$transArray['hbcu_id']
                                 );
           
            // $updateArray = array_filter($updateArray);
            // $updateArray['cycle']=$transArray['cycle'];
            if($transArray['cycle']=="0")
            {
               $updateArray['cycle']=$transArray['cycle'];
            }
              // print_r($updateArray);die;
            $this->db->where("id", $id);
            $this->db->update("hb_reoccurringDonations",$updateArray);
            $Response=$id;
            $Response = $this->db->select('*')->from('hb_reoccurringDonations')->where('id', $Response)->get()->row();
            $response= $this->successResponse("success",$Response);
      }else
      {

         $CheckreoccurringDonations = $this->db->select('*')->from('hb_reoccurringDonations')->where('user_id', $transArray['user_id'])->get()->row();


         if($CheckreoccurringDonations)
         {
            $response= $this->errorResponse("Sorry, Reoccurring Donation already inserted",$CheckreoccurringDonations);
         }else
         {
          $Response = $this->insert_data('hb_reoccurringDonations',$transArray);
          $Response = $this->db->select('*')->from('hb_reoccurringDonations')->where('id', $Response)->get()->row();
          $response= $this->successResponse("success",$Response);
         }

      }


      return $response;

}


 public function insert_data($tbl_name,$data)                                         /* Data insert */
    {
      $this->db->insert($tbl_name, $data);

        $insert_id = $this->db->insert_id();
        return $insert_id;

    }

public function updateNewpin($message){
    
    $select_user = $this->db->select('*')->from('hb_users')->where('reset_pin_token', $message['token'])->get()->row();



   if($select_user->id)
   {
    
    $email=$select_user->email;
    $reset_pin_timestamp=$select_user->reset_pin_timestamp;

  $current_timestamp=strtotime(date('Y-m-d H:i:s'));
       $message['id']=$select_user->id;
  
      if($current_timestamp<=$reset_pin_timestamp)
      {

         
          $update_pwd = $this->db->where('id', $message['id']);
          $this->db->update("hb_users", array(
             'pin' => md5($message['pin']),
            'reset_pin_token' => '')
          );


          if ($update_pwd)
          {
            $this->session->set_flashdata('msg', '<span style="color:green">Pin Changed Successfully</span>');
            redirect("api/User/newpin?token=" . $message['token']);
          }
          else
          {
            $this->session->set_flashdata('msg', '<span style="color:red">Error in Updating Pin</span>');
            redirect("api/User/newpin?token=" . $message['token']);
          }

      }else
          {
            $this->session->set_flashdata('msg', '<span style="color:red">Reset Pin token has been expired</span>');
            redirect("api/User/newpin?token=" . $message['token']);
          }

   }else
          {
            $this->session->set_flashdata('msg', '<span style="color:red">Wrong/expired Reset Pin token</span>');
            redirect("api/User/newpin?token=" . $message['token']);
          }
     

    
  }

function logout($myarray){

      $query=$this->db->query("UPDATE hb_login set status = '0' where  unique_device_id = '" . $myarray['unique_device_id'] . "' or user_id='" . $myarray['user_id'] . "'");

}

   function getprofile($user_id){
              $chk_query = $this->db->select('*')
                                   ->from('tbl_users')
                                   ->where('id',$user_id)
                                   ->where('user_type !=',1)
                                   ->get()->row();
              return $chk_query;
    }

  public function get_data($tbl_name,$limit=null,$offset=null)                         /* Get all data */
    {
       
       $query=array();

      if ($limit!=null) {
        $query = $this->db->get($tbl_name,$limit, $offset)->result();
      } else {
        $query = $this->db->get($tbl_name)->result();
      }

      return $query;
    }



    public function select_data($selection,$tbl_name,$where=null,$order=null)                   /* Select data with condition*/
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
// print_r($this->db->last_query()); die;
    return $data_response;

    }

    public function orSelectData($user_id){

                   $resi = $this->db->query("select * from tbl_bookingRequests where user_id= ".$user_id." and( (is_accepted=1 or is_started=1) and is_completed=0 ) and is_cancelled =0 ")->result();

               return $resi;

    }

    public function driverbookings($driver_id){

               $resi = $this->db->query("select * from tbl_bookingRequests where accepted_by= ".$driver_id." and( (is_accepted=1 or is_started=1) and is_completed=0 ) and is_cancelled =0 ")->result();
               return $resi;

    }
    public function customSubscription_check($user_id){


       $cuRDate = date('Y-m-d H:i:s');
       $getUser = $this->db->select('*')
                         ->from('tbl_driverSubscriptions')
                         ->where('driver_id',$user_id)
                         ->where('status',1)
                         ->get()->row();


                         if(!empty($getUser)){
                          $checkList = $this->db->select('*')
                                                ->from('tbl_subscriptionsList')
                                                ->where('id',$getUser->subscription_id)
                                                ->get()->row();
                            $dt = new DateTime($getUser->date_created);
                            if($checkList->type == 0){

                            $nw =  $dt->modify('+ 30 days');
                            $dtVar = $nw->format('Y-m-d H:i:s');

                            }else if($checkList->type == 1){

                            $nw =  $dt->modify('+ 91 days');
                            $dtVar = $nw->format('Y-m-d H:i:s');

                            }else if($checkList->type == 2){

                            $nw =  $dt->modify('+ 182 days');
                            $dtVar = $nw->format('Y-m-d H:i:s');

                            }else if($checkList->type == 3){

                            $nw =  $dt->modify('+ 365 days');
                            $dtVar = $nw->format('Y-m-d H:i:s');

                            }
                            if($cuRDate > $dtVar){
                              $this->db->where('driver_id',$user_id);
                              $this->db->update('tbl_driverSubscriptions',array('status'=>2));
                              return '';
                            }else{
                              return $getUser;
                            }

                         }else{
                           return '';
                         }

    }

    public function getMembership_check($user_id){


       $cuRDate = date('Y-m-d H:i:s');
       $getUser = $this->db->select('*')
                         ->from('tbl_driverMembership')
                         ->where('driver_id',$user_id)
                         ->where('status',1)
                         ->get()->row();

                         if(!empty($getUser)){
                          $checkList = $this->db->select('*')
                                                ->from('tbl_membership')
                                                ->where('id',$getUser->membership_id)
                                                ->get()->row();
                            $dt = new DateTime($getUser->date_created);
                            $deta = "+ ".$checkList->validity." days";
                            $nw =  $dt->modify($deta);
                            $dtVar = $nw->format('Y-m-d H:i:s');
                            if($cuRDate > $dtVar){
                              $this->db->where('driver_id',$user_id);
                              $this->db->update('driverMembership',array('status'=>2));
                              return '';
                            }else{
                              return $getUser;
                            }

                         }else{
                           return '';
                         }

    }



    public function userSubscriptions($user_id){
       $result = $this->db->select('tbl_driverSubscriptions.driver_id,tbl_subscriptionsList.name,tbl_subscriptionsList.amount,tbl_driverSubscriptions.date_created')
                         ->from('tbl_driverSubscriptions')
                         ->join('tbl_subscriptionsList','tbl_subscriptionsList.id = tbl_driverSubscriptions.subscription_id')
                         ->where('driver_id',$user_id)
                         ->get()->row();

    return $result;

    }

        public function update_data($tbl_name,$data,$where){                                 /* Update data */

      $this->db->where($where);
      $this->db->update($tbl_name,$data);

     return($this->db->affected_rows())?1:0;
    }






    public function userDetails($id){

    $result = $this->db->select('tbl_users.fname,tbl_users.lname,tbl_users.email,tbl_users.phone,tbl_users.profile_pic, tbl_users.id as my_id')
                         ->from('tbl_users')
                         ->where('id',$id)
                         ->get()->row();

                         return $result;

    }
       public function jobTime($id){

      $result = $this->db->select('booking_date,booking_time')
                         ->from('tbl_bookingRequests')
                         ->where('id',$id)
                         ->get()->row();

                         return $result;

    }
      public function MoveUserlogin($req_id){

      $getUser = $this->db->select('user_id')
                         ->from('tbl_bookingRequests')
                         ->where('id',$req_id)
                         ->get()->row();

      $selectlogin = $this->db->select('tbl_login.*,tbl_users.notification_status')
                         ->from('tbl_login')
                         ->join('tbl_users','tbl_users.id = tbl_login.user_id')
                         ->where('user_id',$getUser->user_id)
                         ->where('status',1)
                         ->get()->result();


      return $selectlogin;
    }

   public function customUserTo_driver($req_id,$driver_id){
    $result['bookings'] = $this->db->select('*')
                        ->from('tbl_bookingRequests')
                        ->where('id',$req_id)
                        ->get()->row();

    $result['sender'] = $this->db->select('tbl_users.fname,tbl_users.lname,tbl_users.email,tbl_users.phone,tbl_users.profile_pic,tbl_users.id as sender_id')
                         ->from('tbl_users')
                         ->where('id',$result['bookings']->user_id)
                         ->get()->row();
    $result['reciever'] =  $this->db->select('*')
                         ->from('tbl_login')
                         ->where('user_id',$driver_id)
                         ->where('status',1)
                         ->get()->result();

     return $result;

   }



  


   

    public function getLocation($lat,$long,$rType,$uType)                                         /* Get Location*/
    {
      if($rType == 1) {
        $radius = 10;
      }else if($rType == 2){
        $radius = 50;
      }


      $selectDrivers =
      $this->db->select("*, ( 3959 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians(longitude) - radians($long) ) + sin( radians($lat) ) * sin( radians( latitude ) ) ) ) AS distance FROM tbl_users")
      ->where('user_type',$uType)
      ->having('distance <=',$radius)
      ->order_by('distance', 'DESC')
     // ->limit(20, 0)
      ->get()->result();
      return $selectDrivers;

    }


     public function getLocationNew($lat,$long,$rType,$catType)                                         /* Get Location new*/
    {
      if($rType == 1) {
        $radius = 10;
      }else if($rType == 2){
        $radius = 50;
      }


      $selectDrivers =
      $this->db->select("*, ( 3959 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians(longitude) - radians($long) ) + sin( radians($lat) ) * sin( radians( latitude ) ) ) ) AS distance FROM tbl_users")
      ->where('categoryType',$catType)
      ->where('user_type',2)
      ->having('distance <=',$radius)
      ->order_by('distance', 'DESC')
     // ->limit(20, 0)
      ->get()->result();

      // print_r($this->db->last_query()); die;
      return $selectDrivers;

    }



    public function selMembership($id){
      $selMem = $this->db->select('tbl_driverMembership.driver_id,tbl_membership.membership,tbl_driverMembership.date_created')
                           ->from('tbl_driverMembership')
                           ->join('tbl_membership','tbl_membership.id = tbl_driverMembership.membership_id')
                           ->where('driver_id',$id)
                           ->where('status',1)
                           ->get()->row();

    return $selMem;
    }

    public function selectLogin($id){
      $selLogin = $this->db->select('*')
                           ->from('tbl_login')
                           ->where('user_id',$id)
                           ->where('status',1)
                           ->get()->result();

    return $selLogin;
    }


    public function avgRating($id){

    $rating = $this->db->select('AVG(rating) as avg_r')
                           ->from('tbl_driverRatings')
                           ->where('driver_id',$id)
                           ->get()->row();

    return $rating;

    }

        public function CustRating($id,$req_id){

    $rating = $this->db->select('rating as avg_r')
                           ->from('tbl_customerRatings')
                           ->where('user_id',$id)
                           ->where('req_id',$req_id)
                           ->get()->row();

    return $rating;

    }


    public function customChat_list($message){
      $chatList = $this->db->select('*')
                           ->from('tbl_chat')
                           ->group_start()
                           ->where('req_id',$message['req_id'])
                           ->where('from_id',$message['from_id'])
                           ->where('to_id',$message['to_id'])
                           ->group_end()
                           ->or_group_start()
                           ->where('req_id',$message['req_id'])
                           ->where('from_id',$message['to_id'])
                           ->where('to_id',$message['from_id'])
                           ->group_end()
                           ->get()->result();
     return $chatList;
    }

    public function transactionData($user_id){

      $getData = $this->db->select('*')
      ->from('tbl_wallet')
      ->join('tbl_transactions','tbl_wallet.user_id = tbl_transactions.user_id',left)
      ->where('tbl_wallet.user_id',$user_id)
      ->get()->result();

      return $getData;

    }

    public function randomQuote_reply($quote_id,$spUser_id,$message){
       $this->db->where('quoteReq_id',$quote_id);
       $this->db->where('sp_id',$spUser_id);
       $this->db->update('tbl_random_quotesReq_Sp',$message);
      return($this->db->affected_rows())?1:0;


    }
   

    public function customReply_select($id){

      $data = $this->db->select('sp_id as serviceProvider_id,provider_comment,provider_price,date_answered')
                       ->from('tbl_random_quotesReq_Sp')
                       ->where('quoteReq_id',$id)
                       ->where('is_answered',1)
                       ->get()->result();
       return $data;


    }

    public function calculateFare($req_id){

      $selectFare = $this->db->select('tbl_bookingRequests.*,tbl_moveHistory.*,tbl_subCategory.jobRate_type,tbl_subCategory.kmCharge,tbl_subCategory.hourlyCharge')
      ->from('tbl_bookingRequests')
      ->join('tbl_moveHistory','tbl_moveHistory.req_id = tbl_bookingRequests.id')
      ->join('tbl_subCategory','tbl_subCategory.id = tbl_bookingRequests.subCategory_id')
      ->where('tbl_bookingRequests.id',$req_id)
      ->get()->row();
      if($selectFare->is_quote == 1){

        $fareUsed = $selectFare->acceptedPrice;

      }else{

        $fareUsed = $selectFare->totalprice;
      }


       //$startTime = new DateTime($selectFare->started_time);
       // $endTime = new DateTime($selectFare->completed_time);
       //$diff = $startTime->diff($endTime);
      $currTime = date('Y-m-d H:i:s');
      //print_r($diff->h.'hrs'.$diff->i.'min'); die;

      $dateDiff = intval((strtotime($currTime)-strtotime($selectFare->started_time))/60);
      $hours = intval($dateDiff/60);

$minutes = $dateDiff%60;
    if($selectFare->hourlyCharge != 0 && $hours >= $selectFare->hours){
            if($minutes < 15){
            $secTime = $hours;
            $totalTime = $secTime;
            $val = 0;
            $extraVal = '';
            }else if($minutes > 15 && $minutes < 30){
            $secTime = $hours;
            $totalTime = $secTime.'.'.$minutes;
            $val = 1;
            $MinCharge = $selectFare->hourlyCharge/2;
            $extraVal = $MinCharge;
            }else if($minutes > 30){
            $secTime = 1;
            $totalTime = $hours+$secTime;
            $val =0;
            $extraVal = $secTime * $selectFare->hourlyCharge;
            }

    $amountwithMinCharge =    $MinCharge + $fareUsed;
    $amountwithoutMinCharge = $secTime * $selectFare->hourlyCharge + $fareUsed;
    $overallCharge  = ($val == 1)?$amountwithMinCharge:$amountwithoutMinCharge;
    }else{
    $overallCharge  = $fareUsed;
    $extraVal = '';
    }

    if(!empty($selectFare->promo_codeId) && $selectFare->promo_codeId != 0){
    $getData = $this->db->select('*')
                        ->from('tbl_promocodes')
                        ->where('id',$selectFare->promo_codeId)
                        ->get()->row();
        // $get_percentage = $this->User_model->select_data('minBooking_charge','tbl_settings');
        // $percentage = $get_percentage[0]->minBooking_charge;
        // $promo_amount = ($percentage / 100) * $selectFare->totalprice;
     if($getData->type == 0){

      $dedAmount = $getData->value;
      $nwBalance = $overallCharge - $dedAmount;
     }else if($getData->type == 1){
       $dedAmount = ($getData->type / 100) * $overallCharge;
       $nwBalance = $overallCharge - $dedAmount;
     }
    }else{
       $nwBalance = $overallCharge;
    }
     $get_comPercentage = $this->User_model->select_data('minBooking_charge','tbl_settings');
     $fareResponse = array(
      'req_id'=> $selectFare->req_id,
      'iniBooking_percentage' => $get_comPercentage[0]->minBooking_charge,
      'requested_hours'=>$selectFare->hours,
      'job_hours'=>empty($totalTime)?'':$totalTime,
      'job_mins'=>$minutes,
      'hourly_charge'=>$selectFare->hourlyCharge,
      'booking_price'=>$fareUsed,
      'basefare'=>$selectFare->basefare,
      'servicefare'=>$selectFare->servicefare,
      'waypointfare'=>$selectFare->waypointfare,
      'extra_charge'=>empty($extraVal)?'':$extraVal,
      'peakHourCharge'=>$selectFare->peakHourCharge,
      'promo_discount'=>empty($dedAmount)?'':$dedAmount,
      'total_amount'=>$overallCharge
      );
     if(!empty($extraVal)){

     $updateTbl = $this->User_model->update_data('tbl_bookingRequests',array('afterHourCharges'=>$extraVal),array('id'=>$req_id));
     }
     return $fareResponse;
    }
//     public function customCancel_cron(){

//       $currDate = date('Y-m-d H:i:s');
//       $getData = $this->db->select('*')
//                           ->from('tbl_bookingRequests')
//                           ->where('is_accepted',0)
//                           ->where('is_started',0)
//                           ->where('is_completed',0)
//                           ->where('is_cancelled',0)
//                           ->get()->result();
//      if(!empty($getData)){

//       foreach ($getData as  $bookingData) {
//         $lat = $bookingData->pickup_lat;
//         $long = $bookingData->pickup_long;
//         $rType = 1;
//         $uType = 2;
//         $getProviders = $this->getLocation($lat,$long,$rType,$uType);

//         foreach ($getProviders as $Pro) {

//         }
//        //   $dt = new DateTime($bookingData->date_created);
//        //   $minsDate = $dt->modify('+ 30 mins');
//        //   $hrsDate = $dt->modify('+ 1 hour');
//        //   $mrHrsDate = $dt->modify('+ 90 mins');
//        // if($minsDate->format('Y-m-d H:i:s') == $currDate){

//        //   $pushData['message'] = "You have recieved a request for new task";
//        //   $pushData['action'] = "new move";
//        // } else if($hrsDate->format('Y-m-d H:i:s') == $currDate){
//        //    $pushData['message'] = "You have recieved a request for new task";
//        //    $pushData['action'] = "new move";

//        // }else if($mrHrsDate->format('Y-m-d H:i:s') == $currDate){
//        //     $pushData['message'] = "Your booking has been cancelled";
//        //     $pushData['action'] = "cancelBooking";

//        //         $this->db->where('TIMESTAMP(booking_date,booking_time) <=',$currDate);
//        //         $this->db->where('is_accepted',0);
//        //         $this->db->where('is_started',0);
//        //         $this->db->where('is_completed',0);
//        //         $this->db->update('tbl_bookingRequests',array('is_cancelled'=>1));

//        // }





// }



//      // $getLogin = $this->db->select('*')
//      //                      ->from('tbl_login')
//      //                      ->where('user_id',$logvalue->user_id)
//      //                      ->where('status',1)
//      //                      ->get()->result();
//      //                  foreach ($getLogin as $value) {

//      //                    $pushData['req_id'] = $logvalue->id;

//      //                    if($getUser[0]->notification_status == 0){

//      //                        $pushData['Utype'] = 1;
//      //                        $pushData['token'] = $value->token_id;
//      //                        if($value->device_id == 1){
//      //                         $this->User_model->iosPush($pushData);
//      //                        }else if($value->device_id == 0){
//      //                         $this->User_model->androidPush($pushData);
//      //                        }

//      //                       }





//                           }
//               // $getBalance = $this->User_model->select_data('*','tbl_wallet',array('user_id'=>$logvalue->user_id));
//               // $get_percentage = $this->User_model->select_data('minBooking_charge','tbl_settings');
//               // $percentage = $get_percentage[0]->minBooking_charge;
//               // $req_amount = ($percentage / 100) * $getData[0]->totalprice;
//               // $nwBalance = $getBalance[0]->balance + $req_amount;
//               // $uptDAta = $this->User_model->update_data('tbl_wallet',array('balance'=>$nwBalance,'date_updated'=>date('Y-m-d H:i:s')),array('user_id'=>$logvalue->user_id));


//     }


       public function customCancel_cron(){

     $currDate  = date('Y-m-d H:i:s');

    $nw = $this->db->query(" SELECT * FROM tbl_bookingRequests WHERE '".$currDate."' > DATE_ADD(date_created, INTERVAL 1 MINUTE) and is_accepted = 0 and is_started = 0 and is_completed = 0 and is_cancelled = 0 and is_quote = 0 ")->result();


    if(!empty($nw)){
      foreach ($nw as $logvalue) {
        $getUser = $this->db->select('*')
                          ->from('tbl_users')
                          ->where('id',$nw->user_id)
                          ->get()->row();

     $getLogin = $this->db->select('*')
                          ->from('tbl_login')
                          ->where('user_id',$logvalue->user_id)
                          ->where('status',1)
                          ->get()->result();
                      foreach ($getLogin as $value) {
                        $pushData['message'] = "Your booking has been cancelled";
                        $pushData['action'] = "cancelBooking";
                        $pushData['req_id'] = $logvalue->id;

                        if($getUser[0]->notification_status == 0){

                            $pushData['Utype'] = 1;
                            $pushData['token'] = $value->token_id;
                            if($value->device_id == 1){
                             $this->User_model->iosPush($pushData);
                            }else if($value->device_id == 0){
                             $this->User_model->androidPush($pushData);
                            }

                           }
                          }

              $getBalance = $this->User_model->select_data('*','tbl_wallet',array('user_id'=>$logvalue->user_id));
              $get_percentage = $this->User_model->select_data('minBooking_charge','tbl_settings');
              $percentage = $get_percentage[0]->minBooking_charge;
              $req_amount = ($percentage / 100) * $logvalue->totalprice;
              $nwBalance = $getBalance[0]->balance + $req_amount;
              $uptDAta = $this->User_model->update_data('tbl_wallet',array('balance'=>$nwBalance,'date_updated'=>date('Y-m-d H:i:s')),array('user_id'=>$logvalue->user_id));
             // print_r($nwBalance); die;

               $transArray = array(
              'amount_credited' =>$req_amount,
              'user_id'         =>$logvalue->user_id,
              'txnId'           =>'ride_cancelled_refund',
              'date_created'    =>date('Y-m-d H:i:s')
              );
              $transResponse = $this->User_model->insert_data('tbl_transactions',$transArray);

              // $uptDataNw = $this->User_model->update_data('tbl_wallet',array('balance'=>$nwBalance,'date_updated'=>date('Y-m-d H:i:s')),array('user_id'=>$getData[0]->user_id));
            $delQuery = $this->db->query("update tbl_bookingRequests set is_cancelled = 1 WHERE '".$currDate."' > DATE_ADD(date_created, INTERVAL 1 MINUTE) and is_accepted = 0 and is_started = 0 and is_completed = 0 and is_cancelled = 0 and is_quote = 0");
            $uptQuery = $this->db->query("update tbl_moveHistory set cancelled_time = '".$currDate."' WHERE req_id =".$nw->id);

                }
              }
            }


    public function cancel_QuoteCron(){


     $currDate  = date('Y-m-d H:i:s');

    $nw = $this->db->query(" SELECT * FROM tbl_bookingRequests WHERE '".$currDate."' > DATE_ADD(date_created, INTERVAL 60 MINUTE) and is_accepted = 0 and is_started = 0 and is_completed = 0 and is_cancelled = 0 and is_quote = 1 ")->result();


    if(!empty($nw)){
      foreach ($nw as $logvalue) {
        $getUser = $this->db->select('*')
                          ->from('tbl_users')
                          ->where('id',$nw->user_id)
                          ->get()->row();

     $getLogin = $this->db->select('*')
                          ->from('tbl_login')
                          ->where('user_id',$logvalue->user_id)
                          ->where('status',1)
                          ->get()->result();
                      foreach ($getLogin as $value) {
                        $pushData['message'] = "Your booking has been cancelled";
                        $pushData['action'] = "cancelBooking";
                        $pushData['req_id'] = $logvalue->id;

                        if($getUser[0]->notification_status == 0){

                            $pushData['Utype'] = 1;
                            $pushData['token'] = $value->token_id;
                            if($value->device_id == 1){
                             $this->User_model->iosPush($pushData);
                            }else if($value->device_id == 0){
                             $this->User_model->androidPush($pushData);
                            }

                           }
                          }

              $getBalance = $this->User_model->select_data('*','tbl_wallet',array('user_id'=>$logvalue->user_id));
              $get_percentage = $this->User_model->select_data('minBooking_charge','tbl_settings');
              $percentage = $get_percentage[0]->minBooking_charge;
              $req_amount = ($percentage / 100) * $logvalue->totalprice;
              $nwBalance = $getBalance[0]->balance + $req_amount;
              $uptDAta = $this->User_model->update_data('tbl_wallet',array('balance'=>$nwBalance,'date_updated'=>date('Y-m-d H:i:s')),array('user_id'=>$logvalue->user_id));
             // print_r($nwBalance); die;

               $transArray = array(
              'amount_credited'=>$req_amount,
              'user_id'=>$logvalue->user_id,
              'txnId'=>'refund',
              'date_created'=>date('Y-m-d H:i:s')
              );
              $transResponse = $this->User_model->insert_data('tbl_transactions',$transArray);

              // $uptDataNw = $this->User_model->update_data('tbl_wallet',array('balance'=>$nwBalance,'date_updated'=>date('Y-m-d H:i:s')),array('user_id'=>$getData[0]->user_id));
            $delQuery = $this->db->query("update tbl_bookingRequests set is_cancelled = 1 WHERE '".$currDate."' > DATE_ADD(date_created, INTERVAL 60 MINUTE) and is_accepted = 0 and is_started = 0 and is_completed = 0 and is_cancelled = 0 and is_quote = 1");
            $uptQuery = $this->db->query("update tbl_moveHistory set cancelled_time = '".$currDate."' WHERE req_id =".$nw->id);

                }
              }

            }


    public function customLate_cron(){

        $currDate = date('Y-m-d H:i:s');
        $getData = $this->db->select('*')
                            ->from('tbl_bookingRequests')
                            ->where('TIMESTAMP(booking_date,booking_time) <=',$currDate)
                            ->where('is_accepted',1)
                            ->where('is_started',0)
                            ->where('is_completed',0)
                            ->where('is_cancelled',0)
                            ->get()->result();

        if(!empty($getData)){
          foreach ($getData as $customvalue) {

        $getLogin = $this->db->select('*')
                             ->from('tbl_login')
                             ->where('user_id',$customvalue->accepted_by)
                             ->where('status',1)
                             ->get()->result();
                      foreach ($getLogin as $value) {
                        $pushData['message'] = "Your are getting late for your booking";
                        $pushData['spMessage'] = "Your are getting late for your booking";
                        $pushData['action'] = "lateWarning";
                        $pushData['req_id'] = $customvalue->id;
                        $pushData['Utype'] = 2;
                        $pushData['token'] = $value->token_id;
                            if($value->device_id == 1){
                             $this->User_model->iosPush($pushData);
                            }else if($value->device_id == 0){
                             $this->User_model->androidPush($pushData);
                            }


                          }
            }
          }

    }


    public function selectmoney_data($message){
         $getmoney = $this->db->select('*')
                             ->from('tbl_stripeCustomer_details')
                             ->where('card_no',$message['card_no'])
                             ->where('user_id',$message['user_id'])
                             ->get()->result();

       return $getmoney;
    }

      public function androidPush($pushData=null){

        // print_r($pushData);

        // $pushData['token']="e3Z5B87S3to:APA91bENmJNrHFy7SfIr92x7RzwOCOMCQ6MNVhcGS0C8Jfnm9uHLs9ubDtVDid07BJL4yUN73gGozH9cX99jvOH7E4w-476BcUg-SXLCKN-dRotgtdl63f3z4tAGgsIJpxopew9auTgt";

    $mytime = date("Y-m-d H:i:s");
     $api_key = "AIzaSyBnMVKRooChfUZQ9H5R4QKKAoPY5hGseyA";  
    $fcm_url = 'https://fcm.googleapis.com/fcm/send';
    $fields = array(
      'registration_ids' => array(
        $pushData['token']
      ) ,
      'data' => array(
        "message" =>$pushData['message'] ,
        "action" => $pushData['action'],
        "from_name" =>$pushData['from_name'] ,
        "time" => $mytime
      ) ,
    );
    $headers = array(
      'Authorization: key=' . $api_key,
      'Content-Type: application/json'
    );
    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($curl_handle, CURLOPT_URL, $fcm_url);
    curl_setopt($curl_handle, CURLOPT_POST, true);
    curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, json_encode($fields));
    $response = curl_exec($curl_handle);
    print_r($response);
    curl_close($curl_handle);
  }

  public function iosPush($pushData=null) {

    $deviceToken = $pushData['token'];
    $passphrase = '';
    $ctx = stream_context_create();
      $sound = 'default';
    stream_context_set_option($ctx, 'ssl', 'local_cert', './certs/KudosCustomerDevPush.pem');
    stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);


    // Open a connection to the APNS server

    $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
   // if (!$fp) exit("Failed to connect: $err $errstr" . PHP_EOL);

    	 $body['aps'] = array(
        "message" =>$pushData['message'] ,
        "action" => $pushData['action'],
        'req_id' => $pushData['req_id'],
        "from_name" =>$pushData['from_name'] ,
        "from_id" =>$pushData['from_id'],
        "from_pic"=>$pushData['profile_pic'],
        'is_quote' => $pushData['is_quote'],
        'quote_price' => $pushData['quote_price'],
        'quote_id'=>$pushData['quote_id'],
        'value' => $pushData['value'],
        'alert' => $pushData['spMessage'],
        'sound' => $sound
    );
    // Encode the payload as JSON
    $payload = json_encode($body);
    // Build the binary notification
    $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
    // Send it to the server
    $result = fwrite($fp, $msg, strlen($msg)); //echo "<pre>"; print_r($result);die;
    fclose($fp);
  }

  /* old code for custom cancel cron */
   // start-------------------------------------------------------

    //   public function customCancel_cron(){

    //   $currDate = date('Y-m-d H:i:s');
    //   $getData = $this->db->select('*')
    //                       ->from('tbl_bookingRequests')
    //                       ->where('TIMESTAMP(booking_date,booking_time) <=',$currDate)
    //                       ->where('is_accepted',0)
    //                       ->where('is_started',0)
    //                       ->where('is_completed',0)
    //                       ->where('is_cancelled',0)
    //                       ->get()->result();
    //  if(!empty($getData)){
    //   foreach ($getData as $logvalue) {


    //  $getLogin = $this->db->select('*')
    //                       ->from('tbl_login')
    //                       ->where('user_id',$logvalue->user_id)
    //                       ->where('status',1)
    //                       ->get()->result();
    //                   foreach ($getLogin as $value) {
    //                     $pushData['message'] = "Your booking has been cancelled";
    //                     $pushData['action'] = "cancelBooking";
    //                     $pushData['req_id'] = $logvalue->id;

    //                     if($getUser[0]->notification_status == 0){

    //                         $pushData['Utype'] = 1;
    //                         $pushData['token'] = $value->token_id;
    //                         if($value->device_id == 1){
    //                          $this->User_model->iosPush($pushData);
    //                         }else if($value->device_id == 0){
    //                          $this->User_model->androidPush($pushData);
    //                         }

    //                        }
    //                       }
    //           $getBalance = $this->User_model->select_data('*','tbl_wallet',array('user_id'=>$logvalue->user_id));
    //           $get_percentage = $this->User_model->select_data('minBooking_charge','tbl_settings');
    //           $percentage = $get_percentage[0]->minBooking_charge;
    //           $req_amount = ($percentage / 100) * $getData[0]->totalprice;
    //           $nwBalance = $getBalance[0]->balance + $req_amount;
    //           $uptDAta = $this->User_model->update_data('tbl_wallet',array('balance'=>$nwBalance,'date_updated'=>date('Y-m-d H:i:s')),array('user_id'=>$logvalue->user_id));

    //           // $uptDataNw = $this->User_model->update_data('tbl_wallet',array('balance'=>$nwBalance,'date_updated'=>date('Y-m-d H:i:s')),array('user_id'=>$getData[0]->user_id));
    //            $this->db->where('TIMESTAMP(booking_date,booking_time) <=',$currDate);
    //            $this->db->where('is_accepted',0);
    //            $this->db->where('is_started',0);
    //            $this->db->where('is_completed',0);
    //            $this->db->update('tbl_bookingRequests',array('is_cancelled'=>1));
    //           }
    //         }
    //  // $query  = $this->db->query("update tbl_bookingRequests set is_cancelled = 1 where TIMESTAMP(booking_date,booking_time) <= '".$currDate."'  and is_accepted = 0 and is_started = 0 and is_completed = 0");
    //   //print_r($this->db->last_query()); die;


    // }

    // end ---------------------------------------------------

    public function sendmail($userPin, $username, $email){

        $to = "$email";
        $subject = "Forgot PIN email";
        $message = "
        <html>
        <head>
        <title>Forgot PIN email</title>
        </head>
        <body>
        <p>Hello, $username</p>
        <p>Your current PIN is $userPin</p>
        </body>
        </html>
        ";
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <webmaster@example.com>' . "\r\n";
        $headers .= 'Cc: myboss@example.com' . "\r\n";

        mail($to,$subject,$message,$headers);
    }


}
