
      <!--sidebar end-->
      <!--main content start-->
     <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading pull-right" style="width: 100%">
                             Retailers Deal Listing
                              <a class="btn add_move pull-right btn_barcode" role="button" href="<?php echo base_url("Admin/retailerDetail/".$dealAssigned[0]->retailerId)?>">Back</a>

                                <?php if ($this->session->flashdata('msg')!='') { ?>
                                <div class="alert alert-danger alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php
                                echo $this->session->flashdata('msg');
                                ?>
                                </div>
                                <?php } ?>
                          </header>
                      
                          <div class="panel-body table-responsive">
                                <div class="adv-table">
                                    <table  class="display table table-bordered table-striped example" id="datatable" style="width: 100%;">
                                      <thead>
                                      <tr class="tabel_head">
                                          <th>Assigned  Id</th>
                                          <th>Deal Name</th>
                                          <th>Deal Image</th>
                                          <th>Description</th>
                                          <th>Expiry Date</th>
                                          <th>Valid For</th>
                                      </tr>
                                      </thead>
                                  </table>
                                </div>
                          </div>
                      </section>
                  </div>
              </div>
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->


<!--footer start-->
<?php include('template/footer.php') ?>
<!--footer end-->

  </body>
</html>


<script>
var placeId=<?php echo $dealAssigned[0]->placeId; ?>;
$('#datatable').DataTable({
"processing": true,
"language": {
processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
"serverSide": true,
"bInfo" : false,
"ajax":{
"url": "<?php echo base_url('Admin/retailerDealsAssigned/') ?>"+placeId,
"dataType": "json",
"type": "POST",
},
"columns": [
{ "data": "dealId" },
{ "data": "dealName" },
{ "data": "dealImage" , render: getImg},
{ "data": "description" },
{ "data": "expiryDate" },
{ "data": "validFor" },
]
});

function getImg(data, type, full) {
  if (data != '') {
    return '<img src="'+data+'" class="img-responsive store_img_respon"/>';
  } else {
    return '<img src="http://phphosting.osvin.net/couponApp/assets/apidata/dummy.jpg" class="img-responsive store_img_respon"/>';
  }
}
$.fn.dataTableExt.sErrMode = 'throw';
</script>

