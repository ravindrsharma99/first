
      <!--sidebar end-->
      <!--main content start-->

      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             Deals List

                        <?php 
                        if ($count<6) {?>
                        <a class="btn add_move pull-right btn_barcode" role="button" href="<?php echo base_url("Admin/addDeal")?>">Add Deal</a>
                        <?php }
                        ?>
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
                                <div class="adv-table">
                     
        <div id="successmsg" style="display: none" class="alert alert-success fade in"><p>Deal deleted successfully.</p></div>

                                    <table  class="display table table-bordered table-striped example" id="datatable">
                                      <thead>
                                      <tr class="tabel_head">
                                          <th>Deal Id</th>
                                          <th>Deal Name</th>
                                          <th>Deal Image</th>
                                          <th>Offer Or Discount</th>
                                          <th>Description</th>
                                          <th>Terms & Conditions</th>
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
<h4 class="modal-title">Update Deal Detail</h4>
</div>
<div class="modal-body">
<form class="form-horizontal" id="default" method="POST" action="<?php echo base_url("Admin/updateDeal")?>">

<div class="form-group type_box">

<div class="col-lg-12">
<label> Deal Name: </label>
<input type="text"  class="form-control" id="dealName"  name="dealName" value="" required="" pattern=".{5,150}" oninvalid="setCustomValidity('Please enter deal name length between 5 to 150 characters. ')"
onchange="try{setCustomValidity('')}catch(e){}" >
</div>


<div class="col-lg-12">
<label> Image: </label>
<input type="file"  class="form-control number"   name="dealImage" value="" >
</div>


<div class="col-lg-12">
<label> Offer Or Discount: </label>
<input type="text"  class="form-control" id="offerOrDiscount"  name="offerOrDiscount" value="" pattern=".{1,20}" oninvalid="setCustomValidity('Please enter Offer Or Discount length between 1 to 20 characters. ')"
onchange="try{setCustomValidity('')}catch(e){}"  >
</div>



<div class="col-lg-12">
<label> Description: </label>
<input type="text"  class="form-control" id="description"  name="description" pattern=".{1,20}" value="" oninvalid="setCustomValidity('Please enter Description length between 1 to 20 characters. ')"
onchange="try{setCustomValidity('')}catch(e){}"  >
</div>



<div class="col-lg-12">
<label> Terms & Conditions: </label>
<input type="text"  class="form-control" id="termsConditions"  name="termsConditions" pattern=".{1,20}" value="" oninvalid="setCustomValidity('Please enter terms & Conditions length between 1 to 20 characters. ')"
onchange="try{setCustomValidity('')}catch(e){}"  >
</div>





</div>

<input type="hidden" name= "dealId" id='dealId' value=""/>
<button  type="submit" class="btn btn_barcode editdata submit" name="editDeal"  >Submit</button>
</div>
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

<script type="text/javascript">
var url='<?php echo base_url();?>';
function addBarCodes(id){
window.location.href = '<?php echo base_url('Admin/addBarCodes')?>/'+id;
}

function dealdetail(id){
window.location.href = '<?php echo base_url('Admin/dealdetail')?>/'+id;
}
</script>
<script>
$(document).ready(function() {
$('#datatable').DataTable({
"processing": true,
"language": {
processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
"serverSide": true,
"bInfo" : false,
"ajax":{
"url": "<?php echo base_url('Admin/newdeal') ?>",
"dataType": "json",
"type": "POST",
},
"columns": [
{ "data": "id" },
{ "data": "dealName" },
{ "data": "dealImage" , render: getImg},
{ "data": "offerOrDiscount" },
{ "data": "description" },
{ "data": "termsConditions" },
{
"data": null,
render:function(data, type, row)
{
return '<button id="actionButton" class="btn btn_edit" type="button"  onclick="dealdetail('+data.id+')" >Edit/Detail</button><button id="actionButton" class="btn btn_detail" type="button"  onclick="managedeal('+data.id+')" >Manage Deal</button><button id="actionButton" class="btn btn_barcode" type="button"  onclick="managebarcode('+data.id+')" >Manage Bar Code</button><button id="actionButton" class="btn btn_suspend" type="button"  onclick="deleteDeal('+data.id+')" >Remove</button>';
},
"targets": -1
}
]   
});
function getImg(data, type, full, meta) {
var orderType = data.OrderType;
if (data != '') {
return '<img src="'+data+'" class="img-responsive img-small-new"/>';
} else {
return '<img src="http://phphosting.osvin.net/couponApp/assets/apidata/dummy.jpg" class="img-responsive img-small-new"/>';
}
}
$.fn.dataTableExt.sErrMode = 'throw';
});




var url='<?php echo base_url()?>';
function dealdetail(id){
  window.location.href = '<?php echo base_url("Admin/dealdetail/")?>'+id;
}

function managedeal(id){
  window.location.href = '<?php echo base_url("Admin/managedeal/")?>'+id;
}


function managebarcode(id){
  window.location.href = '<?php echo base_url("Admin/addBarCodes/")?>'+id;
}


function deleteDeal(id){
  window.location.href = '<?php echo base_url("Admin/deleteDeal/")?>'+id;
}


function editDeal(id){
$.ajax
({ 
url: url+'Admin/getdealdetail',
data: "dealId="+id,
type: 'post',
success: function(data,row)
{
data=JSON.parse(data);
$("#myModal").modal();
$("#dealName").val(data[0].dealName);
$("#category").val(data[0].category);
$("#expiryDate").val(data[0].expiryDate);
$("#offerOrDiscount").val(data[0].offerOrDiscount);
$("#termsConditions").val(data[0].termsConditions);
$("#description").val(data[0].description);
$("#dealId").val(id);
}
});
}


function deleteDeal(id){
    $('#successmsg').hide();

$.ajax
({ 
url: url+'Admin/deleteDeal',
data: "dealId="+id,
type: 'post',
success: function(data,row)
{
  if (data==0) {
    $('#error').html("Deal can not be deleted."); 
    $('#successmsg').show();
  }
  else{
    var table = $('#datatable').DataTable();
    table.ajax.reload();
    $('#successmsg').show();
    
    $('#error').html("Deal deleted successfully."); 
  }
}
});
}




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


