
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
Manage  Deal
<?php 
$query=$this->db->query("SELECT * from tblStorePlaces where id='".$id."' ")->row();
?>
<a class="btn add_move pull-right btn_barcode" role="button" href="<?php echo base_url("Admin/deals")?>">Back</a>
</header>

<div class="panel-body">
<div class="align">
<div class="retailer-manage">
<div class="clearfix"></div>
			<form class="form-manage-deal" method="post" action="<?php echo base_url('Admin/assigndealtoplace'); ?>"  >

				<div class="form-group col-sm-6">
				<label class="control-label">Select Retailer</label>
				<select id="pty_select" name="retailerId" class="form-control" >
				<option value="">SELECT</option>
				<?php 
				foreach ($retailer as $key => $value) {?>
				<option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
				<?php }
				?>
				</select>
				<span id="retailerRequired"></span>
				</div>

				<div style="display: none" id='selectcity' class="col-sm-6">
				<label class="required">Select Store</label>
				<div class="selectdiv"> 
				<select name="storeId[]" id="cityselect"  multiple="multiple" class="sel-store" >
				<option value="">Choose</option>
				</select>
				<span id="retailerStoreRequired"></span>

				</div> 
				</div>


				<input type="hidden"  name="dealId" value="<?php echo $id; ?>" ></input>

				<div class="clearfix"></div>
				<div class="form-group text-right col-sm-12 update-deal-btn">
    				<button class="btn btn_barcode submit" id="retailerSubmit" name="addretailer" type="submit">Update</button>
				</div>
			</form>
			<!-- <span>Set expiry date</span> -->
		</div>
	</div>
</div>
<header class="panel-heading pull-right" style="width: 100%">
Manage Deal Table
</header>
<div class="clearfix"></div>
	<div class="space-div">
		<div class="table-responsive">
			<table  class="display table table-bordered table-striped example" id="datatable">
		        <thead>
		            <tr class="tabel_head">
		                <th>Id</th>
		                <th>Store Name</th>
		                <th>Retailer Name</th>
		                <th>Store Address</th>
		                <th>Store Image</th>
		                <th>Action</th>
		            </tr>
		        </thead>
			</table>
		</div>
	</div>	
	<div class="clearfix"></div>
</div>
</section>
</div>
</div>
</div>
<!-- page end-->
</section>
</section>


<?php include('template/footer.php') ?>

<script src="https://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/js/bootstrap-multiselect.js"
    type="text/javascript"></script>



		<script type="text/javascript">
		var id=<?php echo $id; ?>;
		$('#pty_select').on('change', function() {
		$('#cityselect').empty();
		$("#cityselect").multiselect('destroy');
		$("#pty_select1").hide();
		var pty = $("#pty_select").val();
		$.ajax({type: "POST",url:"<?php echo base_url("Admin/getspecificRetailerplaces")?>",data:{retailerId:pty,dealId:id}}).done(function(data){
		var abc=JSON.parse(data);
		$("#selectcity").show();
		$('#cityselect').empty();
		$.each(abc,function(item,i){
		$("#cityselect").append('<option value='+i.id+'>'+i.storeName+'</option>');
		}); 
		$("#cityselect").multiselect({ 
		numberDisplayed: 20,
		includeSelectAllOption: true
		})
		});

		});
		</script>


<script>
var id=<?php echo $id; ?>;
$('#datatable').DataTable({
"processing": true,
"language": {
processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
"serverSide": true,
"bInfo" : false,
"ajax":{
"url": "<?php echo base_url('Admin/newmanageDeal/') ?>"+id,
"dataType": "json",
"type": "POST",
},
"columns": [
{ "data": "id" },
{ "data": "storeName" },
{ "data": "name" },
{ "data": "storeLocation" },
{ "data": "storeImage" , render: getImg},

{
"data": null,
render:function(data, type, row)
{
    return '<button id="actionButton" class="btn btn_suspend" type="button" onclick="myfun('+data.id+')" >Remove</button><button id="actionButton" class="btn btn_detail" type="button" onclick="managestore('+data.id+')" >Manage</button>'; 
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
function myfun(id){
$.ajax
({ 
url: '<?php echo base_url('Admin/removeAssignedPlace') ?>',
data: "AssignedPlaceId="+id,
type: 'post',
success: function(data,row)
{
  	var table = $('#datatable').DataTable();
   	table.ajax.reload();
}
});
}
function managestore(id){
  	window.location.href = '<?php echo base_url("Admin/managestore/")?>'+id; //Will take you to Google.
}
</script>


<script type="text/javascript">
$('#retailerSubmit').click(function() {
var selected=[];
$('#selectcity :selected').each(function(){
selected[$(this).val()]=$(this).text();
});
var retailers = $( "#pty_select" ).val();
var retailerStore = $( "#selectcity" ).val();
$('#retailerRequired').html('');
$('#retailerStoreRequired').html('');
if (retailers=='') {
$('#retailerRequired').html('Please select retailer.');
return false;
}
else{
$('#retailerRequired').html('');
}
if (selected=='') {
$('#retailerStoreRequired').html('Please select retailer store.');
return false;
}
else{
$('#retailerStoreRequired').html('');
}
});
</script>