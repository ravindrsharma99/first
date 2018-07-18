
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
Add Bar Code of <?php echo $data->dealName;?> Deal
<a class="btn add_move pull-right btn_barcode" role="button" href="<?php echo base_url("Admin/deals")?>">Back</a>
</header>
<div class="clearfix"></div>
<div class="panel-body">
                              


<div class="form align col-sm-12">

	<form class="cmxform form-horizontal tasi-form type_box_lab" id="signupForm" method="post" style="padding: 0px;" action="<?php echo base_url("Admin/addtobarcode")?>" enctype="multipart/form-data" >
		<input type="hidden" name="dealId" value="<?php echo $data->id;?>" ></input>
		<div class="form-group ">
			<label for="firstname" class="control-label">Bar Code Images</label>
			<input class=""  name="userFiles[]" multiple="" type="file" placeholder="Enter Email" required=""  accept="image/png, image/jpeg"  />
		</div>
		<div class="form-group text-right">
	    <button class="btn btn_barcode submit" name="addbarcode" type="submit">Submit</button>
	</div>
	</form>
</div>
</div>
</section>
</div>
</div>
<!-- page end-->
</section>
</section>
<?php include('template/footer.php') ?>