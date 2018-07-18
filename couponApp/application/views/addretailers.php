
<section id="main-content">
<section class="wrapper site-min-height">
<!-- page start-->


<div class="row">
<div class="col-lg-12">
	<div class="panel">
		<header class="panel-heading pull-right" style="width: 100%">
Add Retailers
<!-- <a class="btn add_move pull-right btn_barcode" role="button" href="<?php //echo base_url("Admin/retailers")?>">Back
</a> -->
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
            <span id="retaileradded"></span>

<form id="addRetailer" name="addRetailer" class="cmxform tasi-form" method="POST" enctype="multipart/form-data">
 <!--  <div style="display: none" class="alert alert-success fade in" id="successmsg"><p>Retailer detail updated Successfully.</p></div> -->
  <div class="col-sm-6">
    <div class="form-group ">
      <label for="firstname" class="control-label">Name</label>
      <input class="form-control" type="text" name="name" id="name" required="" value="" />
      <!-- <span id="oldpasserror"></span> -->
      <span id="name_required"></span>
            <span id="namevalidity"></span>

    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group ">
      <label for="firstname" class="control-label">Email</label>
      <input class="form-control" type="text" name="email" id="email" required="" value="" />
      <span id="email_required"></span>
      <span id="emailvalidity1"></span>
<span id="emailvalidity2"></span>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group ">
      <label for="firstname" class="control-label">Password</label>
      <input class="form-control" type="password" name="password" id="password" required="" value="" />
      <span id="password_required"></span>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group ">
      <label for="firstname" class="control-label">Store Allowed</label>
      <input class="form-control" type="text" name="storeAllowed" id="storeAllowed" required="" value="" />
      <span id="storeAllowed_required"></span>
      <span id="storeAllowedvalidity"></span>

    </div>
  </div>
<input type="button" class="btn ACt_SuBMIT_Button btn_barcode"  name="addretailer"  id="addretailer" value="Submit">
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
<!-- <script>
	$('#addretailer').click(function(){
		//function to validate email
		function validateEmail($email) {
			var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
			return emailReg.test( $email );
		}
		$('#emailvalidity1').html(" ");
		$('#namevalidity').html(" ");
		$('#storeAllowedvalidity').html(" ");
		$('#retaileradded').html(" ");
		$('#emailvalidity2').html(" ");
		var name = $('#name').val();
		var email = $('#email').val();
		//validating email
		if( !validateEmail(email)) 
			{$('#emailvalidity1').html("Email is invalid.");  
		return false;}
		var password = $('#password').val();
		var storeAllowed = $('#storeAllowed').val();
		//checking is storeAllowed is numeric or not
		if(!$.isNumeric(storeAllowed)) {
			$('#storeAllowedvalidity').html("storeAllowed is not numeric.");
			return false; }
			$('#successmsg').html("");
			$("#addretailer").prop('disabled', true);
// check fields are not empty
if (name=='') {
	$("#addretailer").prop('disabled', false);
	$('#name_required').html("name is required.");
	return false;
}
else{
	$('#name_required').html("");
}
if (email=='') {
	$("#addretailer").prop('disabled', false);

	$('#email_required').html("email is required.");
	return false;
}
else{
	$('#email_required').html("");
}

if (password=='') {
	$("#addretailer").prop('disabled', false);

	$('#password_required').html("password is required.");
	return false;
}
else{
	$('#password_required').html("");
}

if (storeAllowed=='') {
	$("#addretailer").prop('disabled', false);
	$('#storeAllowed_required').html("storeAllowed is required.");
	return false;
}
else{
	$('#storeAllowed_required').html("");
}
var formData = new FormData();
formData.append("name",$("#name").val());
formData.append("email",$("#email").val());
formData.append("password",$("#password").val());
formData.append("storeAllowed",$("#storeAllowed").val());
$.ajax({
	type: 'POST',
	url:'<?php echo base_url('Admin/addRetailers') ?>',
	data: formData,
	processData: false,
	contentType: false,
  // dataType    : 'multipart/form-data',
  success: function(data) {
  	$("#addretailer").prop('disabled', false);
  	if (data==1) {
  		$('#emailvalidity1').html("Email is invalid.");
  		return false;
  	}
  	if (data==2) {

  		$('#namevalidity').html("Name already exists.");
  		return false;
  	}
  	if (data==3) {

  		$('#storeAllowedvalidity').html("Enter valid storeAllowed.");
  		return false;
  	}
  	if (data==4) {

  		$('#retaileradded').html("Retailer added Successfully");
  		$("#addRetailer")[0].reset();
  		return false;
  	}
  	if (data==5) {

  		$('#emailvalidity2').html("Email already exists.");
  		return false;
  	}
  }      
});
});
</script> -->