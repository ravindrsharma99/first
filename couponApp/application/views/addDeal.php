
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
Add Deal
<a class="btn add_move pull-right btn_barcode" role="button" href="<?php echo base_url("Admin/deals")?>">Back</a>
</header>


	<div class="panel-body">
		<div class="form align">
			<form class="cmxform tasi-form type_box_lab" id="signupForm" method="post" action="<?php echo base_url("Admin/addDeal")?>" enctype="multipart/form-data" >
				<div class="col-sm-6">
					<div class="form-group ">
						<label for="firstname" class="control-label">Deal Name</label>
						<input  class=" form-control"  name="dealName" type="text" placeholder="Enter Deal Name"  required="" pattern="[a-zA-Z\s0-9^-,]{2,30}" oninvalid="setCustomValidity('Please enter Deal name length between 2 to 30 characters. ')"
						onchange="try{setCustomValidity('')}catch(e){}" >
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group ">
						<label for="firstname" class="control-label">Offer or Discount</label>
						<input  class=" form-control"  name="offerOrDiscount" type="text" placeholder="Enter Offer Or Discount"  required="" pattern="[a-zA-Z\s0-9^-,]{2,30}" oninvalid="setCustomValidity('Please enter Offer Or Discount length between 2 to 30 characters. ')"
						onchange="try{setCustomValidity('')}catch(e){}" >
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group" style="margin-bottom: 0px;">
						<label for="firstname" class="control-label">Deal Image</label>
						<div class="clearfix"></div>
						<input type="file"  class="number form-control-file file-input" onchange="ValidateSize(this)"   name="dealImage" value="" >
						<!-- <img class="img-thumbnail img-responsive img-short" src="<?php echo $dealData->dealImage; ?>"> -->
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group ">
						<label for="firstname" class="control-label">Terms & Condition</label>
						<input  class=" form-control"  name="termsConditions" type="text" placeholder="Enter Terms & Condition"  required="" pattern="{5,255}" oninvalid="setCustomValidity('Please enter Terms and  Conditions length between 5 to 255 characters. ')"
						onchange="try{setCustomValidity('')}catch(e){}" >
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-sm-6">
					<div class="form-group">
						<label for="firstname" class="control-label">Description</label>
						<textarea  class="form-control"  name="description" type="text" placeholder="Enter Description"  required="" pattern="{5,255}" oninvalid="setCustomValidity('Please enter Description length between 5 to 255 characters. ')"
						onchange="try{setCustomValidity('')}catch(e){}" ></textarea>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="form-group col-sm-12 text-right ">
				    <button class="btn btn_barcode submit" name="addedDeals" type="submit">Submit</button>
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
	function ValidateSize(file) {
        var FileSize = file.files[0].size / 1024 / 1024; // in MB
        if (FileSize > 2) {
            alert('File size exceeds 2 MB');
            return false;
           // $(file).val(''); //for clearing with Jquery
        } else {

        }
    }
</script>