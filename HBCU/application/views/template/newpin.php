<!DOCTYPE html>
<html lang="en">
<body class="">
  <div class="loginbg">
    <div class="container">
      <div class="form-signin">
        <?php echo form_open('api/User/updateNewpin'); ?>
        <?php if($this->session->flashdata('msg')): ?>
    <div style="padding-top:10px"><p style="color:"><?php echo $this->session->flashdata('msg'); ?></p></div>
<?php endif; ?>
          <div class="text-center logo2"><img src="<?php echo base_url(); ?>/Public/img/ic_logo.png" width="250px" height = "auto"/>  </div>

          <h2 class="form-signin-heading">New Pin</h2>
          <div class="login-wrap">
            <div class="form-group ">
              <input type="hidden" value = "<?php if(isset($token)) { echo $token; } ?>" name="token">
              <input type="password" class="form-control" id="pin" name="pin" placeholder="Pin" maxlength="4" onkeypress="return validateFloatKeyPress(this,event);" autofocus >
              <div class='error'><?php echo form_error('pin'); ?></div>
            </div>
            <div class="form-group ">
              <input type="password" class="form-control" id="pinconf" name="pinconf" maxlength="4" onkeypress="return validateFloatKeyPress(this,event);" placeholder="Confirm Pin">
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
 <script>
  function validateFloatKeyPress(el, evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    var number = el.value.split('.');
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
    //just one dot
    if(number.length>1 && charCode == 46){
     return false;
   }
    //get the carat position
    var caratPos = getSelectionStart(el);
    var dotPos = el.value.indexOf(".");
    if( caratPos > dotPos && dotPos>-1 && (number[1].length > 1)){
      return false;
    }
    return true;
  }
  </script>