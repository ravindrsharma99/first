
<section id="main-content">
<section class="wrapper site-min-height">
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
Detail of  <?php echo $dealData->dealName;?> Deal
<a class="btn add_move pull-right btn_barcode" role="button" href="<?php echo base_url("Admin/deals")?>">Back</a>
</header>
<div class="clearfix"></div>
<div class="panel-body">
	<form class="form-"  method="post" action="<?php echo base_url("Admin/updateDeal")?>" >
		<div class="form-group col-sm-6">
			<label class="control-label">Deal Name</label>
			<input  class="form-control" name="dealName" type="text" placeholder="Enter Deal Name" value="<?php echo $dealData->dealName;?>"   required="" >
		</div>
		<div class="form-group col-sm-6">
			<label class="control-label">Offer Or Discount</label>
			<input  class="form-control" name="offerOrDiscount" type="text" value="<?php echo $dealData->offerOrDiscount;?>"  placeholder="Enter Offer Or Discount"    required="" >
		</div>
		<div class="form-group col-sm-6" style="margin-bottom: 0px;">
			<label class="control-label">Deal Image</label>
			<div class="clearfix"></div>
			<input  class="form-control-file file-input" name="dealImage" type="file" placeholder="Enter Name" onchange="ValidateSize(this)" value="" accept="image/png, image/jpeg"  >
			<img class="img-thumbnail img-responsive img-short" src="<?php echo $dealData->dealImage; ?>">
		</div>
		<div class="form-group col-sm-6">
			<label class="control-label">Terms & Condition</label>
			<input  class="form-control" name="termsConditions" type="text" value="<?php echo $dealData->termsConditions;?>" placeholder="Enter Expiry date"  required="" >
		</div>
		<div class="clearfix"></div>
		<div class="form-group col-sm-6">
			<label class="control-label">Description</label>
			<textarea  class="form-control" name="description" value="<?php echo $dealData->description;?>" type="text" placeholder="Enter Description"  required="" ><?php echo $dealData->description;?></textarea>
		</div>


		<input type="hidden" value="<?php echo $dealData->id; ?>" name='dealId' ></input>
		<div class="clearfix"></div>
		<div class="form-group text-right col-sm-12">
    		<button class="btn btn_barcode submit" id="updateDetail" name="editDeal" type="submit">Update</button>
		</div>
	</form>

</div>
</div>
</section>
</div>
</div>
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