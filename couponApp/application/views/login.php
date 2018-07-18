<!DOCTYPE html>
<html class="loginmain" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="<?php echo base_url("assets/img/favicon.ico")?>">

    <title>Pendulum Points</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url("assets/css/bootstrap.min.css")?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/css/bootstrap-reset.css")?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/assets/font-awesome/css/font-awesome.css")?>" rel="stylesheet" />
    <link href="<?php echo base_url("assets/css/style.css")?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/css/style-responsive.css")?>" rel="stylesheet" />

</head>

  <body class="login-body">
<div class="login_overlay">
    <div class="container">
      <form class="form-signin" action="<?php echo base_url('Login/checkLogin')?>" method="post" >
        <h2 class="form-signin-heading">sign in now</h2>
        <div class="login-wrap">


            <?php if ($this->session->flashdata('msg')!='') { ?>
            <div class="alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php
            echo $this->session->flashdata('msg');
            ?>
            </div>
            <?php } ?>

                                
            <label>Email</label><input type="text" name="email" value=""  class="form-control" placeholder="Email" required="" autofocus>
            <label>Password</label><input type="password" name="password" value="" class="form-control" placeholder="Password" required="">
            <button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>
            <div data-toggle="modal" data-target="#forGot" class="text-center" style="font-size: 14px;color: #226fbf;cursor: pointer;">Forgot Password</div>
        </div>
      </form>
    </div>
</div>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url("assets/js/jquery.js")?>"></script>
    <script src="<?php echo base_url("assets/js/bootstrap.min.js")?>"></script>
  </body>
</html>
  <!-- Modal -->
  <div class="modal fade" id="forGot" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Forgot Password</h4>
        </div>
        <div class="modal-body">

        <div id="successmsg" style="display: none" class="alert alert-success fade in"><p>Mail sent successfully.</p></div>
          <form class="form-signin" style="max-width: 100%;" onsubmit="return false;" >
            <label>Email</label><input type="text" name="email" value="" id="old_email"  class="form-control" placeholder="Enter Email" required="">
            <span id="errormsg" ></span>
            <span id="requiredmsg" ></span>
            <button class="btn btn-lg btn-login btn-block" id="forgotPassword" type="submit">Submit</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

<script type="text/javascript">
$('#forgotPassword').click(function() {
$('#errormsg').html("");
$('#successmsg').html('');
$('#successmsg').hide();
var old_email = $('#old_email').val();
$("#forgotPassword").prop('disabled', true);
if (old_email=='') {
$("#forgotPassword").prop('disabled', false);
$("#requiredmsg").html("Email is required.");
return false;
}
$("#requiredmsg").html("");
$.ajax({type: "POST",url:'<?php echo base_url('Login/forgotPassword')?>',data:{email:old_email}}).done(function(msg){
if (msg==0) {
$('#errormsg').html("Email id does not exists.");
$('#requiredmsg').html('');
$("#forgotPassword").prop('disabled', false);
}
else if(msg==1){
$('#old_email').val('');
$('#successmsg').html("Email sent successfully.");
$('#successmsg').show();
$("#forgotPassword").prop('disabled', false);
}
});
});
</script>