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
              Retailer Detail
            </header>
            <div class="panel-body">
              <div class="clearfix"></div>
              <div class="form align">
<!-- <form  action="<?php //echo site_url("Admin_Creator/do_upload")?>" enctype="multipart/form-data" accept-charset="utf-8" name="formname" id="frm_imageuupload"  method="post">
-->
<span id="Retaileradded"></span>
<form id="update" name="update" class="cmxform tasi-form" method="POST" enctype="multipart/form-data">
  <!-- <div style="display: none" class="alert alert-success fade in" id="successmsg"><p>Retailer detail updated Successfully.</p></div> -->
  <div class="col-sm-6">
    <div class="form-group ">
      <label for="firstname" class="control-label" >Name</label>
      <input class="form-control" type="text" name="name" id="name" value="<?php echo $retailerData->name;?>" required="" />
      <!-- <span id="oldpasserror"></span> -->
      <span id="name_required"></span>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group ">
      <label for="firstname" class="control-label">Email</label>
      <input class="form-control" type="text" name="email" id="email" required="" value="<?php echo $retailerData->email;?>" />
      <span id="email_required"></span>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group ">
      <label for="firstname" class="control-label">Phone</label>
      <input class="form-control" type="text" name="phoneNo" id="phoneNo" required="" value="<?php echo $retailerData->phoneNo;?>" />
      <span id="phoneNo_required"></span>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group ">
      <label for="firstname" class="control-label">Store Allowed</label>
      <input class="form-control" type="text" name="storeAllowed" id="storeAllowed" required="" value="<?php echo $retailerData->storeAllowed;?>" />
      <span id="storeAllowed_required"></span>
            <span id="storeAllowedvalidity1"></span>
            <span id="storeAllowedvalidity2"></span>
    </div>
  </div>
  <div class="col-sm-6">
    <label class="control-label">Image</label>
    <div class="form-group"></div>
    <input  class="form-control" type="file"  id="image" name="image" accept="image/png, image/jpeg" >
    <?php if (!empty($retailerData->image)) {?>
    <img class="img-thumbnail img-responsive img-short" id='imageid' src="<?php echo $retailerData->image; ?>">
    <?php }
    else{?>
    <img class="img-thumbnail img-responsive img-short" src="http://phphosting.osvin.net/couponApp/assets/apidata/file58636788.jpg">
    <?php } ?>
  </div> 
  <div class="col-sm-6">
    <label class="control-label">Logo</label>
    <div class="form-group"></div>
    <input  class="form-control" type="file"  id="logo" name="logo" accept="image/png, image/jpeg"  >
    <?php if (!empty($retailerData->logo)) {?>
    <img class="img-thumbnail img-responsive img-short" id='logoid' src="<?php echo $retailerData->logo; ?>">
    <?php }
    else{?>
    <img class="img-thumbnail img-responsive img-short" src="http://phphosting.osvin.net/couponApp/assets/apidata/file58636788.jpg">
    <?php }?>
  </div>
  <input type="hidden" value="<?php echo $retailerData->id ?>" name="retailerId" id="retailerId" ></input>

  <div class="clearfix"></div>
  <div class="form-group col-sm-12" style="padding-top: 10px;">
    <!-- <button class="btn ACt_SuBMIT_Button btn_barcode"  name="updateDetail" type="submit" id="updateDetail">Submit</button> -->
    <input type="button" class="btn ACt_SuBMIT_Button btn_barcode"  name="updateDetail" id="updateDetail" value="Submit">
  </div>
</form>
</div>
</div>
</div>
<header class="panel-heading pull-right" style="width: 100%">
  Retailer Stores
</header>
<div class="clearfix"></div>
<div class="space-div">
  <div class="table-responsive">
    <table  class="display table table-bordered table-striped example" id="datatable">
      <thead>
        <tr class="tabel_head">
          <th>Id</th>
          <th>Store Name</th>
          <th>Store Address</th>
          <th>Store Image</th>
          <th>Deals Running</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>
  </div>
  <div class="clearfix"></div>
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
<?php $url=base_url(); ?>
<?php $id=$retailerData->id;?>
<?php include('template/footer.php') ?>
<script>
  var id=<?php echo $id; ?>;
  $('#datatable').DataTable({
    "processing": true,
    "language": {
      processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
      "serverSide": true,
      "bInfo" : false,
      "ajax":{
        "url": "<?php echo base_url('Admin/newRetailerPlaces/') ?>"+id,
        "dataType": "json",
        "type": "POST",
      },
      "columns": [
      { "data": "id" },
      { "data": "storeName" },
      { "data": "storeLocation" },
      { "data": "storeImage" , render: getImg},
      { "data": "dealsRunning" },
      {
        "data": null,
        render:function(data, type, row)
        {
          if ( data.dealsRunning!="0" ) {
            return '<button id="actionButton" class="btn btn_suspend" type="button" onclick="myfun('+data.id+')" >Remove</button><button id="actionButton" class="btn btn_detail" type="button" onclick="managestore('+data.id+')" >Manage</button>';

          }
          else{
            return '<button id="actionButton" class="btn btn_suspend" type="button" onclick="myfun('+data.id+')" >Remove</button><button id="actionButton" class="btn btn_detail" type="button"  >Manage</button>';

          }


        },
        "targets": -1
      }
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

  function myfun(id){
    $.ajax
    ({ 
      url: '<?php echo base_url('Admin/removePlace') ?>',
      data: "placeId="+id,
      type: 'post',
      success: function(data,row)
      {
        var table = $('#datatable').DataTable();
        table.ajax.reload();
      }
    });
  }

  function managestore(id){
      window.location.href = '<?php echo base_url("Admin/manageretailerDeal/")?>'+id; //Will take you to Google.
    }
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <script>
 $('#imageid').change(function(){
  alert('red');
});
$('#updateDetail').click(function(){
var id = $('#id').val();
var name = $('#name').val();
var email = $('#email').val();
var phoneNo = $('#phoneNo').val();
var storeAllowed = $('#storeAllowed').val();
if(!$.isNumeric(storeAllowed)) {
  $('#storeAllowedvalidity1').html("storeAllowed is not numeric.");
  return false; 
}
var image = $("#image").get(0).files[0];
var logo = $("#logo").get(0).files[0];
$('#Retaileradded').html(" ");
var formData = new FormData();
formData.append("image",$("#image").get(0).files[0]);
formData.append("logo",$("#logo").get(0).files[0]);
formData.append("name",$("#name").val());
formData.append("email",$("#email").val());
formData.append("retailerId",$("#retailerId").val());
formData.append("phoneNo",$("#phoneNo").val());
formData.append("storeAllowed",$("#storeAllowed").val());
$.ajax({
  type: 'POST',
  url:'<?php echo base_url('Admin/updateRetailer') ?>',
  data: formData,
  processData: false,
  contentType: false,
  // dataType    : 'multipart/form-data',
success: function(data) {
data=JSON.parse(data);
  console.log(data);
  if(data.res==1){
    $("#imageid").attr("src", data.userdetail[0].image);
    $("#logoid").attr("src", data.userdetail[0].logo);
    $("#name").val( data.userdetail[0].name);
    $("#email").val( data.userdetail[0].email);
    $("#phoneNo").val( data.userdetail[0].phoneNo);
  }
  }  
  });
});


</script>



