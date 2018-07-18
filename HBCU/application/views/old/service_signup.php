<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

    <title> SignUp </title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>Public/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>Public/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo base_url();?>Public/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>Public/assets/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>Public/assets/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>Public/assets/bootstrap-daterangepicker/daterangepicker.css" />

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url();?>Public/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url();?>Public/css/style-responsive.css" rel="stylesheet" />
    <style>
    .field-required {
      color: red;
    }
    </style>
    <!-- css phone scroll start -->

   <!--  <link href="<?php echo base_url();?>Public/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="<?php echo base_url();?>Public/css/driverCss/intlTelInput.css" rel="stylesheet">

    <!-- css phone scroll start -->




    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->


  </head>

  <body>

  <section id="container" class="">
      <!--header start-->
      <header class="header white-bg">
          <div class="sidebar-toggle-box">
              <div data-original-title="Toggle Navigation" data-placement="" class="fa fa-bars tooltips"></div>
          </div>
          <!--logo start-->
          <a href="driver_signup" class="logo" ><span>Signup</span></a>
          <!--logo end-->
          <div class="nav notify-row" id="top_menu">

          </ul>
          </div>
          <div class="top-nav ">
              <ul class="nav pull-right top-menu">
         
                  <!-- user login dropdown end -->
              </ul>
          </div>
      </header>
      <!--header end-->
  
      <!--main content start-->
      <section id="main-content" class="driverlogin_penal" style="margin-left: 0px !important;">
          <section class="wrapper">
            <div class="container">
              <?php
              // echo "<pre>";
              // print_r($_POST);
              // print_r($_FILES);
              // echo "</pre>";
              ?>
              <!-- page start-->
             <div class="row">
             <div class="col-lg-12 col-sm-12 Dlogin">
             <?php 
              if ($this->session->flashdata('msg')!='') { ?>
                <div class="alert alert-success alert-dismissable dPage">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php
                  echo $this->session->flashdata('msg'); 
                ?>
                </div>
              <?php } 
              ?>
                  
          <form id='myform' role="form" name="add_subcategory" method="POST" action="" enctype="multipart/form-data"> 

            <!-- Personal Details start -->
<input type="hidden" name="userType" value="<?php echo $_POST['userType']?>"/>
            <div class="form-group col-sm-10">
              <div class=""><h3>Personal Details </h3></div>
              <p class="">We Need To Know More About You </p>
            </div>

            <div class="form-group col-md-6 col-sm-6 col-xs-12">  
              <label>First Name <span class="field-required">(required)</span></label>
              <input type="text" class="form-control"  value="<?php echo $this->input->post('fname'); ?>" id="fname" name="fname" placeholder="First Name" autofocus required>
            </div>

            <div class="form-group col-md-6 col-sm-6 col-xs-12">  
            <label>Last Name</label>
              <input type="text" class="form-control"  value="<?php echo $this->input->post('lname'); ?>" id="lname" name="lname" placeholder="Last Name" >
            
            </div>

            <div class="form-group col-md-6 col-sm-6 col-xs-12 has-feedback">
              <label>Email <span class="field-required">(required) </span><p id="emailCheck" style="display: none; color: red;" ></p></label>
              <input type="email" class="form-control"  value="<?php echo $this->input->post('email'); ?>" id="email" name="email" placeholder="email" required>
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <label>Password <span class="field-required">(required)</span></label>
              <input type="password" class="form-control"  value="<?php echo $this->input->post('password'); ?>" id="password" name="password" placeholder="Password" required>
             
            </div>

            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <label class="control-label">Address <span class="field-required">(required)</span></label>
                <div class="controls">
                    <input id="address" class="form-control" name="address" type="textarea" value="<?php echo $this->input->post('address'); ?>" placeholder="Apartment, City, Region, Country, etc."
                    class="input-xlarge" required>
                
                </div>
            </div>


            <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <div class="LabLE_BOX"><label>phone number <span class="field-required">(required)</span></label></div>
              <input type="tel" onclick ="myfunction();" class="form-control" id="phone" name="phone" required>
                <input id="hidden" type="hidden" name="phone-full">
             
            </div>

            <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <div class="LabLE_BOX"><label>Select your gender <span class="field-required">(required)</span></label></div>
              <input type="radio" <?php if($this->input->post('gender')==0) echo "Checked"; ?> name="gender" value="0"> Male
              <input type="radio" <?php if($this->input->post('gender')==1) echo "Checked"; ?> name="gender" value="1"> Female
            </div>


            <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <div class="LabLE_BOX"><label>Identity card number <span class="field-required">(required)</span></label></div>
              <input type="icno" class="form-control" id="icno" name="icno" >
             
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <label>Profile Pic: <span class="field-required">(required)</span></label>
              <input type="file" id="profile_pic" name="profile_pic" required>
            </div>

            <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <label>Upload your IC front: <span class="field-required">(required)</span></label>
              <input type="file" id="icf_image" name="icf_image" required>
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <label>Upload your IC back: <span class="field-required">(required)</span></label>
              <input type="file" id="icb_image" name="icb_image" required>
            </div>
<?php
if ($_POST['userType']==1) { ?>
            
<?php }
?>

            

            <!-- <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <label>Your Photo: <span class="field-required">(required)</span></label>
              <input type="file" id="photo" name="photo" >
              <input type="file" id="photo2" name="photo2" >
              <p class="iphorm-description">Head Shot Like A Passport Photo
Maximum size 10MB</p>
            </div> -->
            <!-- Payment Method details start -->
            <div class="form-group col-sm-10">
              <div class=""><h3>Bank Account Details </h3></div>
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <div class="LabLE_BOX"><label>Payment Method? <span class="field-required">(required)</span></label></div>
              <input type="radio" name="paymentMethod" value="1" checked id='watch-mePayPal'> PayPal
              <input type="radio" name="paymentMethod" value="2" id='watch-meBank'> Bank
            </div>
              
            <div id="show-meBank" style='display:none' class="" >
              <div class="form-group col-md-6 col-sm-6 col-xs-12">  
              <label>Account Holder Name <span class="field-required">(required)</span></label>
                <input type="text" class="form-control"  value="<?php echo $this->input->post('accHolderName'); ?>" id="accHolderName" name="accHolderName" placeholder="Account Holder Name" >
              </div>
              <div class="form-group col-md-6 col-sm-6 col-xs-12">  
              <label>Account Number <span class="field-required">(required)</span></label>
                <input type="text" class="form-control"  value="<?php echo $this->input->post('accountNumber'); ?>" id="accountNumber" name="accountNumber" placeholder="Account Number" >
              </div>
              <div class="form-group col-md-6 col-sm-6 col-xs-12">  
              <label>IFCSC Code <span class="field-required">(required)</span></label>
                <input type="text" class="form-control"  value="<?php echo $this->input->post('ifcsc'); ?>" id="ifcsc" name="ifcsc" placeholder="IFCSE Code" >
              </div>
            </div>


            <div id="show-mePayPal" style='display:block' class="">
              <div class="form-group col-md-6 col-sm-6 col-xs-12">  
              <label>PayPal Id <span class="field-required">(required)</span></label>
                <input type="text" class="form-control"  value="<?php echo $this->input->post('paypalId'); ?>" id="paypalId" name="paypalId" placeholder="Paypal Id" >
              </div>
            </div>
            <!-- Payment Method details end -->

            <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <div class="LabLE_BOX"><label>Applying As? <span class="field-required">(required)</span></label></div>
              <input type="radio" name="appliedAs" value="1" checked> Individual
              <input type="radio" name="appliedAs" value="2" id='watch-me'> Company, sole trader, LLP, PTE
              <p class="iphorm-description">Are you applying as a company, sole trader, LLP, PTE or individual </p>
            </div>

            <!-- Personal Details start -->

            <!-- Registered Company details start -->
          <div id="show-me" style='display:none'>
            <div class="form-group col-sm-10">
              <div class=""><h3>Registered Company Details </h3></div>
              <p class="">For Registered Companies, Sole Proprietors & LLP</p>
            </div>

            <div class="form-group col-md-6 col-sm-6 col-xs-12">  
            <label>Company Name <span class="field-required">(required)</span></label>
              <input type="text" class="form-control"  value="<?php echo $this->input->post('compName'); ?>" id="compName" name="compName" placeholder="Company Name" >
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">  
            <label>Company Address <span class="field-required">(required)</span></label>
              <input type="text" class="form-control"  value="<?php echo $this->input->post('compAddress'); ?>" id="compAddress" name="compAddress" placeholder="Company Address" >
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">  
            <label>ACRA Regitsration Number <span class="field-required">(required)</span></label>
              <input type="text" class="form-control"  value="<?php echo $this->input->post('acraNo'); ?>" id="acraNo" name="acraNo" placeholder="ACRA Regitsration Number" >
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <label>Upload You ACRA BIZ FILE - Less Than 14 Days Old: <span class="field-required">(required)</span></label>
              <input type="file" id="acraBiz" name="acraBiz" >
            </div>
            <!-- <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <label>Company Registration: <span class="field-required">(required)</span></label>
              <input type="file" id="reg_image" name="reg_image" >
            </div> -->
          </div>
            <!-- Registered Company details end -->
<?php
if ($_POST['userType']==1) { ?>
            <!-- Vehicle On Hand start -->
            <div class="form-group col-sm-10">
              <div class=""><h3>Vehicle On Hand </h3></div>
              <p class="">What Vehicle Do you Have On Hand </p>
            </div>

            <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <label>Upload your driving licence front: <span class="field-required">(required)</span></label>
              <input type="file" id="dlf_image" name="dlf_image" required>
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <label>Upload your driving licence back: <span class="field-required">(required)</span></label>
              <input type="file" id="dlb_image" name="dlb_image" required>
            </div>

            <div class="form-group col-md-6 col-sm-6 col-xs-12">  
            <label>Own or Rented <span class="field-required">(required)</span></label>
              <select class="form-control" id="sel1" name="ownOrRented" required>
                <option value="1">Own</option>
                <option value="2">Rented</option>
              </select>
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">  
            <label>Any Logo Or Company Names ? <span class="field-required">(required)</span></label>
              <select class="form-control" id="sel1" name="logo" required>
                <option value="1">No</option>
                <option value="2">Yes</option>
              </select>
            </div>
            
    <!---      <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <label>License No <span class="field-required">(required)</span></label>
              <input type="text" class="form-control"  value="<?php echo $this->input->post('licence_no'); ?>" id="licenseNo" name="licence_no" placeholder="license No" required>
           
            </div> 
            -->
            
 <!---  
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <label>Vehicle Registration Number <span class="field-required">(required)</span></label>
              <input type="text" class="form-control"  value="<?php echo $this->input->post('registration_id'); ?>" id="registrationId" name="registration_id" placeholder="registration Id" required>
            </div>
            -->
 <!---           
              <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <label>Registration Expiry <span class="field-required">(required)</span></label>
              <input type="text" class="form-control"  value="<?php echo $this->input->post('registration_expiry'); ?>" id="registrationExpiry" name="registration_expiry" placeholder="registration Expiry" required>
              <input type="hidden" id ="code" name="concode"></input>
            </div>
            -->

<!---
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <label>Insurance No <span class="field-required">(required)</span></label>
              <input type="text" class="form-control"  value="<?php echo $this->input->post('insurance_no'); ?>" id="InsuranceNo" name="insurance_no" placeholder="Insurance No" required>
             
            </div>
            -->

            <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <label>Upload Front Picture: <span class="field-required">(required)</span></label>
              <input type="file" id="frontPicture" name="frontPicture" required>
              <p class="iphorm-description">Must Be From The Right Front Angle Showing The Plate Number & the Side
Maximum size 10MB</p>
            </div>

            <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <label>Upload Full Side View Of The Vehicle: <span class="field-required">(required)</span></label>
              <input type="file" id="sidePicture" name="sidePicture" required>
              <p class="iphorm-description">Must Show The whole Right Side Of The Vehicle & Any Logos On The Vehicle Maximum size 10MB</p>
            </div>

            <div class="form-group col-md-6 col-sm-6 col-xs-12">  
            <label>Do you have commercial insurance?</label>
              <div class="radio">
                <label><input type="radio" name="commercialRadio" value="1">Yes</label>
              </div>
              <div class="radio">
                <label><input type="radio" name="commercialRadio" value="2">No, I will get it </label>
              </div>
              <div class="radio disabled">
                <label><input type="radio" name="commercialRadio" value="3">No, I wont be getting any </label>
              </div>
            <p class="">Do you have the correct insurance to carry out the bookings?</p>
            </div>



            
            <!-- Vehicle On Hand end -->
<?php }
?>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <div class="LabLE_BOX"><label>What Do You Want To Join? <span class="field-required">(required)</span></label></div>
              <input type="radio" name="joinType" value="1" required> Kudos Pre Priced Jobs 
              <input type="radio" name="joinType" value="2"> Bid On Jobs 
              <input type="radio" name="joinType" value="3"> Future Platforms 
              <p class="">Which platforms would you like to join?</p>
            </div>

            <!-- values From previous form fields as hidden types  -->
              <?php 

foreach ($_POST as  $subData) { 

 echo '<input type="hidden"  name = "subCatHidden[]" value="'.$subData.'">';


}
 ?>
            
             <div class="form-group col-sm-10">
              <div class="checkbox">
                <label><input type="checkbox" name="tandc" id='agree'>I ACCEPT THE TERMS </label>
                <p class="">I have read the rems & conditions, I fully understand & accept all the terms & conditions!
  If you do not agree. Please DO NOT PROCEED</p>
              </div>
            </div>

            

            <!-- Trigger the modal with a button -->
            <div class="form-group col-md-12 col-sm-12 col-xs-12 text-center">
              <!-- <button type="submit" name ="add_driver" class="btn btn-info SUBmit_button_DRiver">Submit</button> -->
              <button type="button" class="btn btn-info btn-lg Process_buTTOn" data-toggle="modal" onclick="showPhone(this)" data-target="#myModal">Proceed</button>
            </div>

            <!-- Modal -->
            <div id="myModal" class="modal fade" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Enter OTP to save and proceed.</h4>
                  </div>
                  <div class="modal-body">
                    <div>
                      <input type="text" class="form-control verifyOtp"  style="display: none;" value="" id="otp" name="otp" placeholder="Enter your otp" required>
                      <p id="message"></p>
                      <p id="urNmbr"></p>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <div class="form-group col-md-12 col-sm-12 col-xs-12 text-center">
                      <div id="hideMsg" style="display: none;">
                        You can resend OTP in <span>30</span> Seconds
                      </div>
                      <button type="button" class="btn btn-success" id="sendOTPbtn" onclick="sendOTP(this)">Send OTP</button>
                      <button type="button" class="btn btn-default verifyOtp" style="display: none;" onclick="verifyOtp(this)">Verify</button>
                      <button type="submit" name ="add_driver" style="display: none;" id="subButtobDriver" class="btn btn-info SUBmit_button_DRiver">Submit</button>
                    </div>
                  </div>
                </div>

              </div>
            </div>

            </form>

                  </div>
                  </div>
              <!-- page end-->

            </div>
          </section>
      </section>
    
      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer DRIVER_Login_penal">
          <div class="text-center">
              2017 &copy; KudosFind.com.
              <a href="#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
     <!-- js phone scroll start -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

     <!-- js phone scroll end -->
    <script src="<?php echo base_url();?>Public/js/jquery.js"></script>
    <script src="<?php echo base_url();?>Public/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>Public/js/jquery.scrollTo.min.js"></script>
    <script src="<?php echo base_url();?>Public/js/jquery.nicescroll.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>Public/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script class="include" type="text/javascript" src="<?php echo base_url();?>Public/js/jquery.dcjqaccordion.2.7.js"></script>

  <!--custom switch-->
  <script src="<?php echo base_url();?>Public/js/bootstrap-switch.js"></script>
  <!--custom tagsinput-->
  <script src="<?php echo base_url();?>Public/js/jquery.tagsinput.js"></script>
  <!--custom checkbox & radio-->
  <script type="text/javascript" src="<?php echo base_url();?>Public/js/ga.js"></script>

  <script type="text/javascript" src="<?php echo base_url();?>Public/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>Public/assets/bootstrap-daterangepicker/date.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>Public/assets/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>Public/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>Public/assets/ckeditor/ckeditor.js"></script>

  <script type="text/javascript" src="<?php echo base_url();?>Public/assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
  <script src="<?php echo base_url();?>Public/js/respond.min.js" ></script>


  <!--common script for all pages-->
    <script src="<?php echo base_url();?>Public/js/common-scripts.js"></script>

  <!--script for this page-->
  <script src="<?php echo base_url();?>Public/js/form-component.js"></script>
    <script src="<?php echo base_url();?>Public/js/driverJs/intlTelInput.min.js"></script>
     <script>
     $(document).ready(function(){
      $( "#phone" ).change(function() {
        $("#subButtobDriver").hide();
        $("#sendOTPbtn").show();
        $("#message").html("You have changed your phone number.");
      });

      $( "#email" ).change(function() {
        var email = $("#email").val();
        setTimeout(function() {
          $.ajax(
          {
            type: 'post',
            url: 'emailCheck',
            dataType: 'json',
            data: {
              email: email
            },
            cache: false,
            beforeSend: function () {
                $(document.body).css({'cursor' : 'wait'});
            },
            success: function (data) {
              $(document.body).css({'cursor' : 'default'});
              if (data.status=='success') {
                $("#emailCheck").hide();
                $("#emailCheckIcn").hide();
              } else if(data.status=='error'){
                $("#emailCheck").show();
                $("#emailCheckIcn").show();
                $("#emailCheck").html("Email already exist.");
                $("#email").focus();
              };
            },
            complete: function () {
                $(document.body).css({'cursor' : 'default'});
            },
            error: function (request, status, error) {

            }
          });   
        }, 1000);
      });

     });
     function myfunction(){
      var data = $('.selected-flag').attr('title');
      var n = data.indexOf('+'); 
      var len = data.length;
      var word = data.slice( n, len );
      $("#code").val(word);
      
     }
// $(document).ready (function(){
    
    $("#phone").intlTelInput({
      onlyCountries: ['sg'],
      //preferredCountries: ['sg'],
      utilsScript: "<?php echo base_url();?>Public/js/driverJs/utils.js"
    });

    $("form").submit(function() {
      var valm = $("#hidden").val($("#phone").intlTelInput("getNumber"));
      // alert(valm);

      if ($('#agree').is(":checked"))
      {
        console.log('check');
        return true;
      }else{
        alert('Please accept the terms to submit form.');
        $('#myModal').modal('hide');
        return false;
      }
    });
// });
  </script>
<!-- <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script> -->
<script>
  // just for the demos, avoids form submit
  /*jQuery.validator.setDefaults({
    debug: true,
    success: "valid"
  });
  $( "#myform" ).validate({
    rules: {
      agree: {
        required: true
      }
    }
  });*/
function showPhone (argument) {
  var phone = $("#phone").intlTelInput("getNumber");
  $("#urNmbr").html("Your Phone Number Is: <b>"+phone+"</b>");
}

function sendOTP (argument) {

  $('#hideMsg').show('fast');
  var sec = 30
  var timer = setInterval(function() { 
     $('#hideMsg span').text(sec--);
     if (sec == -1) {
        $('#hideMsg').fadeOut('fast');
        clearInterval(timer);
     } 
  }, 1000);
  $("#sendOTPbtn").attr("disabled", "disabled");
  setTimeout(function() {
      $("#sendOTPbtn").removeAttr("disabled");      
  }, 31000);

  var phone = $("#phone").intlTelInput("getNumber");
  var iniphone = $("#phone").val();
  console.log(phone);
  if (iniphone=="") {
    alert("Phone number can't be empty.");
    $('#myModal').modal('hide');
    $("#phone").focus();
    return false;
  };

  $.ajax(
  {
    type: 'post',
    url: 'sendOTP',
    dataType: 'json',
    data: {
      phone: phone
    },
    cache: false,
    beforeSend: function () {
        $(document.body).css({'cursor' : 'wait'});
    },
    success: function (data) {
      $(document.body).css({'cursor' : 'default'});
      if (data.status=='success') {
        $(".verifyOtp").show();
        $("#sendOTPbtn").html("Resend OTP");
        $("#message").show();
        $("#message").html(data.message);
      } else if(data.status=='error'){
        $("#message").show();
        $("#message").html(data.message);
      };
    },
    complete: function () {
        $(document.body).css({'cursor' : 'default'});
    },
    error: function (request, status, error) {

    }
  });
}

function verifyOtp (argument) {
  // body...
  // console.log(argument);
  var otp = $('#otp').val();
  var phone = $("#phone").intlTelInput("getNumber");
  var iniphone = $("#phone").val();
  console.log(phone);

  if(iniphone==""){
    alert("Phone number can't be empty.");
    $('#myModal').modal('hide');
    $("#phone").focus();
    return false;
  }else if (otp=="") {
    alert("Please Enter OTP.");
    $("#otp").focus();
    return false;
  };

  $.ajax(
  {
    type: 'post',
    url: 'verifyOtp',
    dataType: 'json',
    data: {
      otp: otp,
      phone: phone
    },
    cache: false,
    beforeSend: function () {
        $(".loadermyli").show();
    },
    success: function (data) {
      if (data.status=='success') {
        $(".verifyOtp").hide();
        $("#sendOTPbtn").hide();
        $("#subButtobDriver").show();
        $("#message").show();
        $("#message").html(data.message);
      } else if(data.status=='error'){
        $("#message").show();
        $("#message").html(data.message);
      };
    },
    complete: function () {
        $(".loadermyli").hide();
    },
    error: function (request, status, error) {

    }
  });
}
  $('input[name=appliedAs]').click(function () {
      if (this.id == "watch-me") {
          $("#show-me").show();
          $("#compName").attr('required','required');
          $("#compAddress").attr('required','required');
          $("#acraNo").attr('required','required');
          $("#acraBiz").attr('required','required');
          $("#reg_image").attr('required','required');
      } else {
          $("#show-me").hide();
          $("#compName").removeAttr('required');
          $("#compAddress").removeAttr('required');
          $("#acraNo").removeAttr('required');
          $("#acraBiz").removeAttr('required');
          $("#reg_image").removeAttr('required');
      }
  });

  $('input[name=paymentMethod]').click(function () {
      if (this.id == "watch-meBank") {

          $("#show-mePayPal").hide();
          $("#show-meBank").show();

          $("#accHolderName").attr('required','required');
          $("#accountNumber").attr('required','required');
          $("#ifcsc").attr('required','required');

          $("#paypalId").removeAttr('required');
      } else if(this.id == "watch-mePayPal") {

          $("#show-meBank").hide();
          $("#show-mePayPal").show();

          $("#paypalId").attr('required','required');

          $("#accHolderName").removeAttr('required');
          $("#accountNumber").removeAttr('required');
          $("#ifcsc").removeAttr('required');
      }
  });

</script> 
  </body>
</html>
