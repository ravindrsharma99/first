<!DOCTYPE html>
<html class="loginmain" lang="en">
<link href="<?php echo base_url("assets/css/style.css")?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/css/style-responsive.css")?>" rel="stylesheet" />
<body class="login-body">
  <div class="loginbg login_overlay">
    <div class="container">
      <div class="form-signin form_newpassword">
            
        <?php echo form_open('Login/updateNewpassword'); ?>    
        <?php if($this->session->flashdata('msg')): ?>
    <div style="padding-top:10px"><p style="color:"><?php echo $this->session->flashdata('msg'); ?></p></div>
<?php endif; ?>  
      

          <h2 class="form-signin-heading">Set New Password</h2>         
          <div class="login-wrap">
            <div class="form-group ">                
              <input type="hidden" value = "<?php if(isset($id)) { echo $id; } ?>" name="id">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password" autofocus required="">
              <div class='error'><?php echo form_error('password'); ?></div>
            </div>
            <div class="form-group ">               
              <input type="password" class="form-control" id="passconf" name="passconf" placeholder="Confirm Password" required="">
              <div class="error"><?php echo form_error('passconf'); ?></div>
            </div>
            <div class="alert alert-block  fade in" style="display:none"></div>
            <button class="btn btn-lg btn-login btn-block" id="chngpass" name="chngpass" type="submit">Change</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
<script src="<?php echo base_url();?>/public/js/jquery.js"></script>
<script src="<?php echo base_url();?>/public/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo base_url();?>/public/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="<?php echo base_url();?>/public/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo base_url();?>/public/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url();?>/public/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>/public/js/jquery.sparkline.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>/public/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
<script src="<?php echo base_url();?>/public/js/owl.carousel.js" ></script>
<script src="<?php echo base_url();?>/public/js/jquery.customSelect.min.js" ></script>
<script src="<?php echo base_url();?>/public/js/respond.min.js" ></script>
<script class="include" type="text/javascript" src="<?php echo base_url();?>/public/js/jquery.dcjqaccordion.2.7.js"></script>

<!--common script for all pages-->
<script src="<?php echo base_url();?>/public/js/common-scripts.js"></script>

<!--script for this page-->
<script src="<?php echo base_url();?>/public/js/sparkline-chart.js"></script>
<script src="<?php echo base_url();?>/public/js/easy-pie-chart.js"></script>
<script src="<?php echo base_url();?>/public/js/count.js"></script>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<script src="https://cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.8/js/dataTables.bootstrap.min.js " type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(){
  $('#hidden-table-info').DataTable();
});
</script>


  <script type="text/javascript">
  $('#changepasswordsubmit').click(function() {
    $('#successmsg').hide();
    $('#successmsg').html("");
    var new_password = $('#new_password').val();
    var con_password = $('#con_password').val();
    $('#successmsg').html("");
    $("#changepasswordsubmit").prop('disabled', true);

    if (con_password != new_password) {
    $('#matchpassword').html("Please match new password and confirm password.");

    $("#changepasswordsubmit").prop('disabled', false);
    return false;
    }
    else{
    $('#matchpassword').html("");
    }
    
  });
  </script>


