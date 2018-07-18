
      <!--sidebar end-->
      <!--main content start-->

      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             Store places List
                              <!-- <a class="btn btn-info add_move" role="button" href="<?php echo base_url("Admin/addCustomer")?>">Add Customers</a> -->

                          </header>
                                <?php if ($this->session->flashdata('msg')!='') { ?>
                                <div class="alert alert-danger alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php
                                echo $this->session->flashdata('msg');
                                ?>
                                </div>
                                <?php } ?>
    
                          <div class="panel-body table-responsive">
                                <div class="adv-table ">
                                    <table  class="display table table-bordered table-striped example" id="datatable">
                                      <thead>
                                      <tr class="tabel_head">   


                                          <th>Store Id</th>
                                          <th>Store Name</th>
                                          <th>Store Location</th>
                                          <th>Store Image</th>
                                          <th>Store Description</th>
                      
                                           <th>Date Created</th>
                                 
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
      <!--popup start-->
        <div class="panel-body">
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Update Your Detail Here</h4>
                  </div>
                  <div class="modal-body">
                    <form class="form-horizontal" id="default" method="POST" action="<?php echo base_url("Dashboard/promocode_list")?>">

                          <div class="form-group type_box">

                        <div class="col-lg-12">
                        <label> Promo: </label>
                         <input type="text"  class="form-control" id="promo"  name="promo" value="" >
                        </div>
                             <div class="col-lg-12">
                        <label> Value: </label>
                         <input type="text"  class="form-control number" id="promovalue"  name="value" value="" >
                        </div>

                         <div class="col-lg-12">
                        <label> Max Amount: </label>
                         <input type="number"  class="form-control number" id="maxamount"  name="maxamount" value="" >
                        </div>


                        <div class="col-lg-12">
                        <label> Maxusage Per User: </label>
                         <input type="number"  class="form-control number" id="maxusageperuser"  name="maxusageperuser" value="" >
                        </div>

                         <div class="">
                        <label> Expiry Date: </label>
                          <div id="datepicker" class="input-group date" data-date-format="yyyy-mm-dd">
                          <input class="form-control " type="date" name="date" id="expiry" value="" readonly />
                          <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                          </div>
                        </div>



                      </div>

                      <input type="hidden" name= "edit" id='hiddid' value=""/>
                      <button  type="submit" class="btn btn-info editdata submit" name="editpromo"  >Submit</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
           <!--popup end-->
      <!--footer start-->

<?php include('template/footer.php') ?>

      <!--footer end-->

  </body>
</html>






<script>
$(document).ready(function() {
$('#datatable').DataTable({
"processing": true,
"language": {
processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
"serverSide": true,
"bInfo" : false,
"ajax":{
"url": "<?php echo base_url('Admin/newstore') ?>",
"dataType": "json",
"type": "POST",
},
"columns": [
{ "data": "id" },
{ "data": "storeName" },
{ "data": "storeLocation" },
{ "data": "storeImage", render: getImg },
{ "data": "description" },
{ "data": "dateCreated" },
]   
});


function getImg(data, type, full, meta) {
    var orderType = data.OrderType;
    if (data != '') {
        return '<img src="'+data+'" class="img-responsive img-small-new" />';
    } else {
        return '<img src="http://phphosting.osvin.net/couponApp/assets/apidata/dummy.jpg" class="img-responsive img-small-new"/>';
    }
}
$.fn.dataTableExt.sErrMode = 'throw';
});
</script>