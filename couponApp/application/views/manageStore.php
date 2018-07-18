<section id="main-content">
<section class="wrapper site-min-height">
<!-- page start-->

<div class="row">
<div class="col-lg-12">
<section class=" col-lg-12">




<?php if ($this->session->flashdata('msg')!='') { ?>
<div class="alert alert-danger alert-dismissable">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<?php
echo $this->session->flashdata('msg');
?>
</div>
<?php } ?>

<div class="panel">

<header class="panel-heading pull-right" style="width: 100%">
Manage Store Deal

<a class="btn add_move pull-right btn_barcode" role="button" href="<?php echo base_url("Admin/managedeal/".$dealAssigned->dealId)?>">Back</a>
</header>
<div class="panel-body">
	<div class="align">
		<div class="retailer-manage">
			<form class="form-" method="post" action="<?php echo base_url('Admin/updateManageStoreDeal'); ?>" >


         <div class="form-group col-sm-6"> 
        <label class="control-label" for="date">Date</label>
        <input class="form-control" id="date"  placeholder="YYYY/MM/DD" type="text" name="expiryDate"  value="<?php if(!empty($dealAssigned->expiryDate) && $dealAssigned->expiryDate!='0000-00-00' ){ echo $dealAssigned->expiryDate;} ?>" required="" onkeydown="return false"/>
      </div>



			<div class="form-group col-sm-6">
			<label class="control-label">Valid For</label>
			<div class="clearfix"></div>
			<input  class="form-control file-input" type="text" name="validFor" pattern="[0-9]{1,3}" value="<?php echo $dealAssigned->validFor; ?>"  class="form-control" required="">
			</div>

			<input type="hidden" id="" name="assignedStore" value="<?php echo $dealAssigned->id;?>" ></input>
			<input type="hidden" id="" name="placeId" value="<?php echo $dealAssigned->placeId;?>" ></input>
			

				<div class="clearfix"></div>
				<div class="form-group col-sm-12 text-right">
    				<button class="btn btn_barcode submit" name="addretailer" type="submit">Update</button>
				</div>
			</form>
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


<?php include('template/footer.php') ?>

<script type="text/javascript">
	$(function(){
var dtToday = new Date();
var month = dtToday.getMonth() + 1;
var day = dtToday.getDate();
var year = dtToday.getFullYear();
if(month < 10)
month = '0' + month.toString();
if(day < 10)
day = '0' + day.toString();
var maxDate = year + '-' + month + '-' + day;
$('#expiryDate').attr('min', maxDate);
});


</script>

<script>
    $(document).ready(function(){
      var date_input=$('input[name="expiryDate"]'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      var dp_now = new Date();
      var options={
        format: 'yyyy/mm/dd',
        container: container,
        todayHighlight: true,
        autoclose: true,
        startDate: dp_now
      };
      date_input.datepicker(options);
    })
</script>

