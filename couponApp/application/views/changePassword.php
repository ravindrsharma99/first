
<!-- <style type="text/css">
  .form-control {
    width: 97%;
  }
</style> -->
<section id="main-content">
<section class="wrapper site-min-height">
<!-- page start-->


<div class="row">
<div class="col-lg-12">
<section class=" col-lg-12">
<div class="panel">

<?php if ($this->session->flashdata('msg')!='') { ?>
<div class="alert alert-danger alert-dismissable">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<?php
echo $this->session->flashdata('msg');
?>
</div>
<?php } ?>

<header class="panel-heading pull-right" style="width: 100%">
Change password
</header>


<div class="panel-body">
  <div class="clearfix"></div>
<div class="form align">

  <form id="cpassword" name="changepass" class="cmxform tasi-form" onsubmit="return false;">


<div style="display: none" class="alert alert-success fade in" id="successmsg"><p>Password changes Successfully.</p></div>

<div class="col-sm-6">
  <div class="form-group ">
    <label for="firstname" class="control-label">Old Password</label>
    <input class="form-control" type="password" name="old_password" id="old_password" required="" value="" />
    <span id="oldpasserror"></span>
    <span id="old_passwordrequired"></span>
  </div>
</div>
<div class="col-sm-6">
  <div class="form-group">
    <label for="firstname" class="control-label">New Password</label>
    <input class="form-control" type="password" name="new_password" id="new_password" required="" value="" />
    <span id="new_passwordrequired"></span>
  </div>
</div>

<div class="clearfix"></div>
<div class="col-sm-6">
  <div class="form-group">
    <label for="firstname" class="control-label">Confirm Password</label>
    <input class="form-control" id="con_password" name="con_password" type="password" required="" value="" />
    <span id="con_passwordrequired"></span>
    <span id="matchpassword"></span>
  </div>
</div>



<div class="clearfix"></div>
<div class="form-group col-sm-12" style="padding-top: 10px;">
           <button class="btn ACt_SuBMIT_Button btn_barcode"  name="setSubmit" type="submit" id="changepasswordsubmit">Submit</button>
</div>



</form>
</div>
</div>
</div>
</section>
</div>
</div>
<!-- page end-->
</section>
</section>


<?php include('template/footer.php') ?>

  <script type="text/javascript">
  $('#changepasswordsubmit').click(function() {
    $('#successmsg').hide();
    $('#successmsg').html("");

    var old_password = $('#old_password').val();
    var new_password = $('#new_password').val();
    var con_password = $('#con_password').val();
    $('#successmsg').html("");
    $("#changepasswordsubmit").prop('disabled', true);

    if (old_password=='') {
      $("#changepasswordsubmit").prop('disabled', false);
      $('#old_passwordrequired').html("Old password is required.");
      return false;
    }
    else{
      $('#old_passwordrequired').html("");
    }
    if (new_password=='') {
    $("#changepasswordsubmit").prop('disabled', false);

      $('#new_passwordrequired').html("New password is required.");
      return false;
    }
    else{
    $('#new_passwordrequired').html("");
    }
    if (con_password=='') {
    $("#changepasswordsubmit").prop('disabled', false);

      $('#con_passwordrequired').html("Confirm password is required.");
      return false;
    }
    else{
    $('#con_passwordrequired').html("");
    }

    if (con_password != new_password) {
    $('#matchpassword').html("Please match new password and confirm password.");

    $("#changepasswordsubmit").prop('disabled', false);
    return false;
    }
    else{
    $('#matchpassword').html("");
    }
    $.ajax({type: "POST",url:'<?php echo base_url('Admin/checkoldpassword')?>',data:{old_password:old_password}}).done(function(msg){
    var abc=JSON.parse(msg);
    if (abc==1) {      
    $('#oldpasserror').html("");
    $.ajax({type: "POST",
      url:'<?php echo base_url('Admin/chanepassword')?>',
      data:{new_password:new_password}}).done(function(msg1){
      $('#old_password').val('');
      $('#new_password').val('');
      $('#con_password').val('');
    	$('#matchpassword').html("");
    $('#successmsg').html("Password changes successfully.");
    $('#successmsg').show();
    

    $("#changepasswordsubmit").prop('disabled', false);
    });
    }
    else{
    $("#changepasswordsubmit").prop('disabled', false);

    $('#oldpasserror').html("Old password not matched.");
    }
    });
  });
  </script>



