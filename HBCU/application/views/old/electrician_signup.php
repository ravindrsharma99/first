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
              <div data-original-title="Toggle Navigation" data-placement="right" class="fa fa-bars tooltips"></div>
          </div>
          <!--logo start-->
          <a href="DriverLogin" class="logo" >Electrician <span>Signup</span></a>
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
          <section class="wrapper site-min-height">
            <div class="container">
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
                  
          <form role="form" name="add_subcategory" method="POST" action="" enctype="multipart/form-data"> 
            <div class="form-group col-md-6 col-sm-6 col-xs-12">  
              <label>First Name</label>
              <input type="text" class="form-control"  value="<?php echo $this->input->post('fname'); ?>" id="fname" name="fname" placeholder="First Name" autofocus required="">
            </div>

            <div class="form-group col-md-6 col-sm-6 col-xs-12">  
            <label>Last Name</label>
              <input type="text" class="form-control"  value="<?php echo $this->input->post('lname'); ?>" id="lname" name="lname" placeholder="Last Name" >
            
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <div class="LabLE_BOX"><label>Select your gender</label></div>
              <input type="radio" <?php if($this->input->post('gender')==0) echo "Checked"; ?> name="gender" value="0"> Male
              <input type="radio" <?php if($this->input->post('gender')==1) echo "Checked"; ?> name="gender" value="1"> Female
            </div>

            <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <label>Electrician Profile Pic:</label>
              <input type="file" id="profile_pic" name="profile_pic" required>
            </div>

               <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <label>Company Registration:</label>
              <input type="file" id="reg_image" name="reg_image" required>
            </div>

              <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <div class="LabLE_BOX"><label>phone number</label></div>
              <input type="tel" onclick ="myfunction1();" class="form-control"  value="<?php echo $this->input->post('phone'); ?>" id="phone" name="phone" placeholder="phone number" required>
               <input id="hidden" type="hidden" name="phone-full">
              <input type="hidden" id ="code" name="concode"></input>
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <div class="LabLE_BOX"><label>Email</label></div>
              <input type="text" class="form-control"  value="<?php echo $this->input->post('email'); ?>" id="email" name="email" placeholder="email" required>
             
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <label>Password</label>
              <input type="text" class="form-control"  value="<?php echo $this->input->post('password'); ?>" id="password" name="password" placeholder="Password" required>
             
            </div>

            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <label class="control-label">Address</label>
                <div class="controls">
                    <input id="address" class="form-control" name="address" type="textarea" value="<?php echo $this->input->post('address'); ?>" placeholder="Apartment, City, Region, Country, etc."
                    class="input-xlarge" required>
                
                </div>
            </div>


             
            <div class="form-group col-md-12 col-sm-12 col-xs-12 text-center">
              <button type="submit" name = "add_driver" class="btn btn-info SUBmit_button_DRiver">Submit</button>
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
    <script src="<?php echo base_url();?>Public/js/driverJs/intlTelInput.js"></script>
     <script>
      function myfunction1(){
      var data = $('.selected-flag').attr('title');
      var n = data.indexOf('+'); 
      var len = data.length;
      var word = data.slice( n, len );
      $("#code").val(word);
      
     }
    $("#phone").intlTelInput({
      utilsScript: "<?php echo base_url();?>Public/js/driverJs/utils.js"
    });

    $("form").submit(function() {



$("#hidden").val($("#phone").intlTelInput("getNumber"));

   });
  </script>

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

  </body>
</html>
