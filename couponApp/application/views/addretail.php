<section id="main-content">
<section class="wrapper site-min-height">
<!-- page start-->


<div class="row">
<div class="col-lg-12">
<section class=" col-lg-12">
<div class="panel">


<header class="panel-heading pull-right" style="width: 100%">
Add Retailer
</header>
<div class="panel-body">
  <div class="clearfix"></div>
<div class="form align">

<div style="display: none" class="alert alert-success fade in" id="successmsg"><p>Password changes Successfully.</p></div>
<div class="col-sm-6">
  <div class="form-group ">
    <label for="name" class="control-label">Name</label>
    <input class="form-control" type="text" name="name" id="name" required="" value="" />
    <!-- <span id="oldpasserror"></span> -->
    <span id="name_required"></span>
  </div>
</div>
<div class="col-sm-6">
  <div class="form-group">
    <label for="email" class="control-label">Email</label>
    <input class="form-control" type="text" name="email" id="email" required="" value="" />
    <span id="email_required"></span>
  </div>
</div>
<div class="clearfix"></div>
<div class="col-sm-6">
  <div class="form-group">
    <label for="password" class="control-label">Password</label>
    <input class="form-control" id="password" name="password" type="password" required="" value="" />
    <span id="password_required"></span>
    <!-- <span id="matchpassword"></span> -->
  </div>
</div>
<div class="col-sm-6">
  <div class="form-group">
    <label for="storeAllowed" class="control-label">storeAllowed</label>
    <input class="form-control" id="storeAllowed" name="storeAllowed" type="text" required="" value="" />
    <span id="storeAllowed_required"></span>
    <!-- <span id="matchpassword"></span> -->
  </div>
</div>
<div class="clearfix"></div>
<div class="form-group text-right col-sm-12" style="padding-top: 10px;">
           <button class="btn ACt_SuBMIT_Button btn_barcode"  name="Submit" type="submit" id="submit">Submit</button>
</div>

</div>
</div>
</div>
</section>
</div>
</div>
<!-- page end-->
</section>
</section>

<script type = "text/javascript" 
         src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
      </script>
    
      <script type = "text/javascript" language = "javascript">
         $(document).ready(function() {
            $("#submit").click(function(event){
              var name = $("#name").val();
              var email = $("#email").val();
              var password = $("#password").val();
              var storeAllowed = $("#storeAllowed").val();

$.ajax({type: "POST",
  url:'<?php base_url();?>addRetailers',
  data:{
    name:name,
    email:email,
    password:password,
    storeAllowed:storeAllowed
  }
}).done(function(msg1){
    $('#successmsg').html("Form submitted successfully.");
    $("#submit").prop('disabled', false);
    });
  });
});
</script>


//addRetailersfunction
  public function addRetailers(){
    if (isset($_POST)) {
      // if (empty($_POST['name'] || empty($_POST['email']) || empty($_POST['password'])  )) {
      //  $this->session->set_flashdata('msg', 'Please fill required field.');
      //  redirect('Admin/addRetailers'); 
      // }
      // else{
      $name=$this->input->post('name');
      $email=$this->input->post('email');
      $password=$this->input->post('password');
      $storeAllowed=$this->input->post('storeAllowed');
      $addretailer=$this->Common_model->insert_data('tblRetailer',array('email'=>$email,'name'=>$name,'password'=>md5($password),'storeAllowed'=>$storeAllowed));   
      }         
  }

  //jquery
  <section id="main-content">
<section class="wrapper site-min-height">
<!-- page start-->


<div class="row">
<div class="col-lg-12">
<section class=" col-lg-12">
<div class="panel">


<header class="panel-heading pull-right" style="width: 100%">
Add Retailer
</header>
<div class="panel-body">
  <div class="clearfix"></div>
<div class="form align">

<div style="display: none" class="alert alert-success fade in" id="successmsg"><p>Password changes Successfully.</p></div>
<div class="col-sm-6">
  <div class="form-group ">
    <label for="name" class="control-label">Name</label>
    <input class="form-control" type="text" name="name" id="name" required="" value="" />
    <!-- <span id="oldpasserror"></span> -->
    <span id="name_required"></span>
  </div>
</div>
<div class="col-sm-6">
  <div class="form-group">
    <label for="email" class="control-label">Email</label>
    <input class="form-control" type="text" name="email" id="email" required="" value="" />
    <span id="email_required"></span>
  </div>
</div>
<div class="clearfix"></div>
<div class="col-sm-6">
  <div class="form-group">
    <label for="password" class="control-label">Password</label>
    <input class="form-control" id="password" name="password" type="password" required="" value="" />
    <span id="password_required"></span>
    <!-- <span id="matchpassword"></span> -->
  </div>
</div>
<div class="col-sm-6">
  <div class="form-group">
    <label for="storeAllowed" class="control-label">storeAllowed</label>
    <input class="form-control" id="storeAllowed" name="storeAllowed" type="text" required="" value="" />
    <span id="storeAllowed_required"></span>
    <!-- <span id="matchpassword"></span> -->
  </div>
</div>
<div class="clearfix"></div>
<div class="form-group col-sm-12" style="padding-top: 10px;">
           <button class="btn ACt_SuBMIT_Button btn_barcode"  name="submit" type="submit" id="submit">Submit</button>
</div>

</div>
</div>
</div>
</section>
</div>
</div>
<!-- page end-->
</section>
</section>

<script type = "text/javascript" 
         src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
      </script>
    
      <script type = "text/javascript" language = "javascript">
         $(document).ready(function() {
            $("#submit").click(function(event){
              var name = $("#name").val();
              var email = $("#email").val();
              var password = $("#password").val();
              var storeAllowed = $("#storeAllowed").val();

$.ajax({type: "POST",
  url:'<?php base_url();?>addRetailers',
  data:{
    name:name,
    email:email,
    password:password,
    storeAllowed:storeAllowed
  }
}).done(function(msg1){
        $('#name').val();
    $("#email").val();
     $("#password").val();
      $("#storeAllowed").val();

    $('#successmsg').html("Form submitted successfully.");
    $("#submit").prop('disabled', false);
    });
  });
});
</script>

public function addRetailer(){
    
      $this->template();
      $this->load->view('addretailers');
    
  }
 // public function addRetailers(){
 //    if (isset($_POST)) {
 //      // if (empty($_POST['name'] || empty($_POST['email']) || empty($_POST['password'])  )) {
 //      //  $this->session->set_flashdata('msg', 'Please fill required field.');
 //      //  redirect('Admin/addRetailers'); 
 //      // }
 //      // else{
 //      $name=$this->input->post('name');
 //      $email=$this->input->post('email');
 //      $password=$this->input->post('password');
 //      $storeAllowed=$this->input->post('storeAllowed');
 //      $addretailer=$this->Common_model->insert_data('tblRetailer',array('email'=>$email,'name'=>$name,'password'=>md5($password),'storeAllowed'=>$storeAllowed));   
 //      }         
 //  }

 //addRetailers function
  public function addRetailers(){
    print_r($_POST);die;
    if (isset($_POST['submit'])) {
      if (empty($_POST['name'] || empty($_POST['email']) || empty($_POST['password'])  )) {
        $this->session->set_flashdata('msg', 'Please fill required field.');
        redirect('Admin/addRetailers'); 
      }
      else{
        function test_input($data)
        {
          $data = trim($data);
          $data = stripslashes($data);
          $data = htmlspecialchars($data);
          return $data;
        }
        function random_username($string) {
          $firstPart = (strtolower($string));
          $nrRand = rand(1000, 9999);
          $username = trim($firstPart).trim($nrRand);
          return $username;
        }
        $email = test_input($_POST["email"]);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $_SESSION['retailerAdd']=array('name'=>$_POST['name'],'email'=>$_POST['email']);
          $this->session->set_flashdata('msg', 'Please provide valid email format.');
          redirect('Admin/addRetailers');
        }
      else{
        $checkname=$this->Common_model->selectresult('tblRetailer','*',array('name'=>$_POST['name']));
        if (!empty($checkname)) {
          $newdata = array(
          'retailerName'  => $_POST['name'],
          'retailerEmail'     => $_POST['email'],
          'storeAllowed' => $_POST['storeAllowed'],
          'retailerPassword' => $_POST['password']
          );
          $this->session->set_userdata($newdata);
          $this->session->set_flashdata('msg', 'Please provide unique name.');
          redirect('Admin/addRetailers');
        }
        else{
          $checkemail=$this->Common_model->selectresult('tblRetailer','*',array('email'=>$_POST['email']));
            if(empty($checkemail)){
              if (empty($_POST['storeAllowed']) || $_POST['storeAllowed'] < 0 ) {

                $this->session->set_flashdata('msg', 'Please provide valid store allowed.');
                redirect('Admin/addRetailers');
              }
              else{
                $name=str_replace(' ','',$_POST['name']);
                $userName=random_username(trim($name));
                $password= $_POST['password']; 
                /*mail functioning start*/
                $fromemail="couponapp@gmail.com";
                $data['username'] = $userName;
                $data['password'] = $password;
                $data['name'] = $_POST['name'];
                $subject = "Username and password for coupon App.";
                $mesg = $this->load->view('app/createpassword',$data,true);
                $this->email->to($email);
                $this->email->from($fromemail, "From Coupon App.");
                $this->email->subject($subject);
                $this->email->message($mesg);
                $mail = $this->email->send();
                /*mail functioning end*/

                $this->Common_model->insert_data('tblRetailer',array('email'=>$_POST['email'],'name'=>$_POST['name'],'userName'=>$userName,'password'=>md5($password),'storeAllowed'=>$_POST['storeAllowed']));

                $this->session->set_flashdata('msg', 'Retailer successfully added.');
                redirect('Admin/addRetailers');
              }
            }
            else{
              $this->session->set_flashdata('msg', 'Email already exists.');
              redirect('Admin/addRetailers');
            }   
          }
        }
      }
    }
    else{
      $this->template();
      $this->load->view('addretailers');
    }
  }

 //addRetailers view
 
 
<section id="main-content">
<section class="wrapper site-min-height">
<!-- page start-->


<div class="row">
<div class="col-lg-12">
  <div class="panel">
    <header class="panel-heading pull-right" style="width: 100%">
Add Retailers
<a class="btn add_move pull-right btn_barcode" role="button" href="<?php echo base_url("Admin/retailers")?>">Back
</a>
</header>
  <div class="clearfix"></div>

<section class="col-lg-12">

<div class="panel-body">
<?php if ($this->session->flashdata('msg')!='') { ?>
<div class="col-sm-12"><div class="alert alert-danger alert-dismissable">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<?php
echo $this->session->flashdata('msg');
?>
</div></div>
<?php } ?>
  <div class="clearfix"></div>
<div class="form align">

<form class="cmxform tasi-form type_box_lab" id="signupForm" method="post" action="<?php echo base_url("Admin/addRetailers")?>" enctype="multipart/form-data"  onsubmit="return checkCoords();" >



<div class="form-group col-sm-6">
<label for="firstname" class="control-label">Name</label>
<input  class=" form-control"  name="name" type="text" placeholder="Enter Name" value="<?php if (isset($_SESSION['retailerName'])) {echo $_SESSION['retailerName'];
} ?>" required=""  >
</div>


<div class="form-group col-sm-6">
<label for="firstname" class="control-label">Email</label>
<input class=" form-control"  type="email" name="email" required pattern=".{5,30}"  placeholder="Enter Email" oninvalid="setCustomValidity('Please enter valid email. ')"
onchange="try{setCustomValidity('')}catch(e){}" value="<?php if (isset($_SESSION['retailerEmail'])) {echo $_SESSION['retailerEmail'];
} ?>" >
</div>




<div class="form-group col-sm-6">
<label for="firstname" class="control-label">Password</label>
<input class=" form-control"  type="password" name="password" required pattern=".{5,10}"  placeholder="Enter Password" oninvalid="setCustomValidity('Please enter password length between 5 to 10 characters.')"
onchange="try{setCustomValidity('')}catch(e){}" value="<?php if (isset($_SESSION['retailerPassword'])) {echo $_SESSION['retailerPassword'];
} ?>" >
</div>

<div class="form-group col-sm-6">
<label for="firstname" class="control-label">Store allowed</label>
<input class=" form-control"  type="text" name="storeAllowed" required pattern="[0-9]{1,3}"  placeholder="Enter Store allowed" oninvalid="setCustomValidity('Please enter Store allowed length between 1 to 3 digit.')"
onchange="try{setCustomValidity('')}catch(e){}" value="<?php if (isset($_SESSION['storeAllowed'])) {echo $_SESSION['storeAllowed'];
} ?>" >
</div>




<div class="form-group text-center">
    <button class="btn btn_barcode submit" name="addretailer" type="submit">Submit</button>

</div>
</form>
</div>
</div>
</section>
</div>
</div>
</div>
<!-- page end-->
</section>
</section>



<?php include('template/footer.php') ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>


      </script>
    
      <script type = "text/javascript" language = "javascript">
         $(document).ready(function() {
            $("#submit").click(function(){
              var name = $("#name").val();
              var email = $("#email").val();
              var password = $("#password").val();
              var storeAllowed = $("#storeAllowed").val();

$.ajax({type: "POST",
  url:'<?php base_url();?>addRetailers',
  data:{
    name:name,
    email:email,
    password:password,
    storeAllowed:storeAllowed
  }
}).done(function(msg1){
        $('#name').val();
    $("#email").val();
     $("#password").val();
      $("#storeAllowed").val();

    $('#successmsg').html("Form submitted successfully.");
    $("#submit").prop('disabled', false);
    });
  });
});
</script> 