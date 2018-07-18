<style type="text/css">
a.button_CLASS {
    background: #EC6459 none repeat scroll 0 0;
    border-radius: 5px;
    color: #fff;
    width: 70px;
    padding: 4px 8px;
}
</style>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js" ></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css">
<!-- <script type="text/javascript" src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js" ></script> -->
<!-- <link rel="stylesheet" type="text/css" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css"> -->
<section id="main-content">
    <section class="wrapper site-min-height">

        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Most Loved HBCU
                    </header>

                   <?php 
                      if ($this->session->flashdata('msg')==true) { ?>
                        <div class="alert alert-success alert-block fade in">
                            <button type="button" class="close close-sm" data-dismiss="alert">
                                <i class="fa fa-times"></i>
                            </button>
                            <h4>
                                <i class="fa fa-ok-sign"></i>
                               <?php echo $this->session->flashdata('msg'); ?>
                            </h4>
                        </div>
                      <?php }
                      
                    ?>
                   <div class="panel-body">



                     <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Monthly</a></li>
    <li><a data-toggle="tab" href="#menu1">Yearly</a></li>
  </ul>



   <div class="tab-content">
    <div id="home" class="tab-pane fade in active">

        <div class="adv-table">


<div class="select_MOnth">
 <form role="form" method='POST' class="form-horizontal" action="<?php echo base_url('Dashboard/lovedhbcu')?>" enctype="multipart/form-data">
  <div class="form-group">
    <label>SELECT Month:</label>
    <input type="text" class="form-control4554 form-control-1 input-sm from " placeholder="Select month From Here" name="date" required="" value="" >
</div>
<input type="submit" name="submit" value="Submit" class="Add_bg">
</form>
</div>



                            <div class="table-responsive">
                                                   <table class="display table table-bordered datatable" id="jr">

<?php
if (($add=='1')) {
?>
<a class="btn btn-info" href="<?php echo $url ;?>"  type="submit">Download Monthly</a>
<?php
}
else{?>

<a class="btn btn-info" href="<?php echo $url ;?>"  type="submit">Download Monthly</a>

<?php
}
?>
                                    <thead>
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>Id</th>
                                            <th>Title</th>
                                            <th>Donation Amount</th>
                                             <th>No Of Donors</th>
                                             <th>No Of Donations</th>
                                            <th>logo</th>
                                           
                                    

                                        </tr>
                                    </thead>
                                    <?php 
                                    $i =1;
                    
                                    foreach ($userData['month'] as $user) {
                 

                                        ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php 
                                        if (!empty($user->hbcuId)) {
                                        echo $user->hbcuId; 
                                        }
                                        else{
                                        echo "N/A";
                                        }
                                        ?>


                                            

                                        </td>
                                        <td><?php echo $user->title; ?></td>
                                        <td><?php echo $user->donation_amount; ?></td>
                                         <td><?php echo $user->nodonors; ?></td>
                                          <td><?php echo $user->nodonation; ?></td>
                             

                                              <td><?php 
                                         if (!empty($user->logo)) {
                                         echo "<img height='100' src='".base_url().$user->logo."' / >";
                                             
                                         }else{


                                            echo "N/A";

                                         } ?>
                                     </td>
                              
                                 
                                    </tr>
                                    <?php $i++;
                                }
                                ?>
                            </table>
                        </div>
                    </div>
    </div>
    <div id="menu1" class="tab-pane fade">
   
        <div class="adv-table">
                            <div class="table-responsive">
                             <table class="display table table-bordered datatable" id="jr">
                               <a class="btn btn-info" href="<?php echo base_url('Dashboard/lovedhbcuyearxls')?>"  type="submit">Download Yearly</a>
                                    <thead>
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>Id</th>
                                            <th>Title</th>
                                            <th>Donation Amount</th>
                                         <th>No Of Donors</th>
                                             <th>No Of Donations</th>
                                            <th>logo</th>
                                           
                                    

                                        </tr>
                                    </thead>
                                    <?php $i =1;
                               
                                    foreach ($userData['year'] as $user) {
                                

                                        ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php 
                                        if (!empty($user->hbcuId)) {
                                        echo $user->hbcuId; 
                                        }
                                        else{
                                        echo "N/A";
                                        }
                                        ?>


                                            

                                        </td>
                                        <td><?php echo $user->title; ?></td>
                                        <td><?php echo $user->donation_amount; ?></td>
                                         <td><?php echo $user->nodonors; ?></td>
                                          <td><?php echo $user->nodonation; ?></td>
                                      
                                                   <td><?php 
                                         if (!empty($user->logo)) {
                                         echo "<img height='100' src='".base_url().$user->logo."' / >";
                                             
                                         }else{


                                            echo "N/A";

                                         } ?>
                                     </td>

                              
                                 
                                    </tr>
                                    <?php $i++;
                                }
                                ?>
                            </table>
                        </div>
                    </div>
    </div>
  </div>
                      
                </div>
            </section>
        </div>
    </div>


    <div class="panel-body">
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Edit Users</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form" name="editHbcu" method="POST" action="editHbcu" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="fullname">Title</label>
                                <input type="text" class="form-control" id="title" name="title">
                                <input type="hidden" name="editId" id="hiddenVal" value="<?php echo $user->id; ?>">
                            </div>

                           


                                <div class="form-group">
                                    <label for="exampleInputFile">Logo</label>
                                    <img src="" style="width:90px;height:auto;border-radius:50%" id="editLogo" />
                                    <input type="file" id="logo" name="logo">
                                </div>
                                <button type="submit" name="editUsers" id="FORM_ID"class="btn btn-default">Submit</button>
                             
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>

<script type="text/javascript">
$('#myModal').on('show.bs.modal', function(e) {

    var userid = $(e.relatedTarget).data('userid');
    var title = $(e.relatedTarget).data('title');
     var logo = $(e.relatedTarget).data('logo');



document.getElementById('hiddenVal').value = userid;
document.getElementById('title').value = title;
$('#editLogo').attr('src',logo);  



});
</script>


<script type="text/javascript">
    var startDate = new Date();
var fechaFin = new Date();
var FromEndDate = new Date();
var ToEndDate = new Date();




$('.from').datepicker({
    autoclose: true,
    minViewMode: 1,
    format: 'mm/yyyy'
}).on('changeDate', function(selected){
        startDate = new Date(selected.date.valueOf());
        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
        $('.to').datepicker('setStartDate', startDate);
    }); 

$('.to').datepicker({
    autoclose: true,
    minViewMode: 1,
    format: 'mm/yyyy'
}).on('changeDate', function(selected){
        FromEndDate = new Date(selected.date.valueOf());
        FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
        $('.from').datepicker('setEndDate', FromEndDate);
    });




</script>
