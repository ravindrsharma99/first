
      <!--sidebar end-->
      <!--main content start-->

      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading pull-right" style="width: 100%">
                             Retailers List
                              <a class="btn add_move pull-right btn_barcode" role="button" href="<?php echo base_url("Admin/insertRetailers")?>">Add Retailers</a>

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
                                          <th>Retailer Id</th>
                                          <th>Name</th>
                                          <th>Email</th>
                                          <th>Image</th>
                                          <th>Store allowed</th>
                                          <th>Action</th>
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
                    <h4 class="modal-title">Update Retailer Detail Here</h4>
                  </div>
                  <div class="modal-body">

                  <div class="form-group type_box">



<form method="post" action="<?php echo base_url('Admin/updateRetaileraction');?>" enctype="multipart/form-data" >



<div class="col-lg-12">
<label> Name: </label>
<input type="text"  class="form-control" id="name"  name="name" value="" required="" pattern="[a-zA-Z\s0-9]{5,15}" oninvalid="setCustomValidity('Please enter name length between 5 to 15 characters. ')"
onchange="try{setCustomValidity('')}catch(e){}" >
</div>
<div class="col-lg-12">
<label> Email: </label>
<input type="text"  class="form-control" id="email"  name="email" value="" required pattern=".{5,30}"  placeholder="Enter Email" oninvalid="setCustomValidity('Please enter valid email. ')"
onchange="try{setCustomValidity('')}catch(e){}" >
</div>
<div class="col-lg-12">
<label> Phone No: </label>
<input type="text"  class="form-control" id="phoneNo"  name="phoneNo" value="" required="" pattern="[0-9+]{8,13}" oninvalid="setCustomValidity('Please enter phone number between 8 to 12 number. ')"
onchange="try{setCustomValidity('')}catch(e){}" >
</div>
<div class="col-lg-12">
<label> Profile Pic </label>
<input type="file" class="form-control" id="uploadbtn"  name="profilePic" value="" >
</div>
</div>
<input type="hidden" name= "retailerId" id='retailerId' value=""/>
<button  type="submit" class="btn btn_barcode editdata submit" id="editReatiler" name="editRetailer"  >Submit</button>
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
$('#datatable').DataTable({
"processing": true,
"language": {
processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
"serverSide": true,
"bInfo" : false,
"ajax":{
"url": "<?php echo base_url('Admin/newretailer') ?>",
"dataType": "json",
"type": "POST",
},
"columns": [
{ "data": "id" },
{ "data": "name" },
{ "data": "email" },
{ "data": "image" , render: getImg},
{ "data": "storeAllowed" },
{
"data": null,
render:function(data, type, row)
{
  if (data.suspend==0) {
    return '<button id="actionButton" class="btn btn_suspend" type="button" onclick="myfun('+data.id+',1)" >Deactivate</button><button id="actionButton" class="btn btn_detail" type="button" onclick="retailerDetail('+data.id+')" >Manage</button>';
  }
  else{
    return '<button id="actionButton" class="btn btn_barcode" type="button" onclick="myfun('+data.id+',0)" >Activate</button><button id="actionButton" class="btn btn_detail" type="button" onclick="retailerDetail('+data.id+')" >Manage</button>';
  }
},
"targets": -1
}
]   
});
function getImg(data, type, full) {

if (data != '') {
  return '<img src="'+data+'" class="img-responsive img-small-new"/>';
} else {
  return '<img src="http://phphosting.osvin.net/couponApp/assets/apidata/dummy.jpg" class="img-responsive img-small-new"/>';
}
}
$.fn.dataTableExt.sErrMode = 'throw';
</script>
<script type="text/javascript">
var url='<?php echo base_url()?>';
function editClick(id,val){
$.ajax
({ 
url: url+'Admin/getretailerdetail',
data: "retailerId="+id+'&val='+val,
type: 'post',
success: function(data,row)
{
data=JSON.parse(data);
$("#myModal").modal();
$("#name").val(data[0].name);
$("#email").val(data[0].email);
$("#phoneNo").val(data[0].phoneNo);
$("#retailerId").val(id);
$("#image").attr('src', data[0].image);
}
});
}
function retailerDetail(id){
  window.location.href = '<?php echo base_url("Admin/retailerDetail/")?>'+id; //Will take you to Google.
}
function myfun(id,val){
$.ajax
({ 
url: url+'Admin/changeretailerStatus',
data: "retailerId="+id+'&val='+val,
type: 'post',
success: function(data,row)
{
  var table = $('#datatable').DataTable();
   table.ajax.reload();
}
});
}




</script>


<script>
$(document).ready(function(){
$("#deleteRetailer").click(function(){

});
});


function readURL(input) {

if (input.files && input.files[0]) {
var reader = new FileReader();

reader.onload = function(e) {
$('#profilePic').attr('src', e.target.result);
}

reader.readAsDataURL(input.files[0]);
}
}

$("#uploadbtn").change(function() {
readURL(this);
});

</script>
