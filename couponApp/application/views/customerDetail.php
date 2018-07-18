
<section id="main-content">
<section class="wrapper site-min-height">
<!-- page start-->


<div class="row">
<div class="col-lg-12">
<section class="panel col-lg-12">




<?php if ($this->session->flashdata('msg')!='') { ?>
<div class="alert alert-danger alert-dismissable">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<?php
echo $this->session->flashdata('msg');
?>
</div>
<?php } ?>



<header class="panel-heading pull-right" style="width: 100%">
Customer Detail
<a class="btn add_move pull-right btn_barcode" role="button" href="<?php echo base_url("Admin/customers")?>">Back</a>
</header>
<div class="panel-body">
	<div class="align retailer_detail_list">
		<div class="col-md-12 col-lg-12 col-xs-12">
						<div class="box_information">
							<div class="detail_info">
								<span class="col-sm-4 col-xs-4">Name</span>
								<span class="col-sm-8 col-xs-8"><?php echo $customerData->firstName.' '.$customerData->lastName; ?></span>
							</div>
							<div class="detail_info">
								<span class="col-sm-4 col-xs-4">Email</span>
								<span class="col-sm-8 col-xs-8"><?php echo $customerData->email; ?></span>
							</div>
							<div class="detail_info">
								<span class="col-sm-4 col-xs-4">Phone</span>
								<span class="col-sm-8 col-xs-8"><?php echo $customerData->phoneNo; ?></span>
							</div>
							<div class="detail_info">
								<span class="col-sm-4 col-xs-4">Profile Picture</span>
								
								<span class="col-sm-8 col-xs-8">
								<?php if(!empty($customerData->profilePic)){ ?>
								<img src="<?php echo $customerData->profilePic;?>" class="detal_profile_pic img-responsive" />
								<?php }else{ ?>
								<img src="http://phphosting.osvin.net/couponApp/assets/apidata/Airplane.jpg" class="detal_profile_pic img-responsive" />
								<?php } ?>
								</span>

							</div>
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