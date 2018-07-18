<style type="text/css">
a.button_CLASS {
    background: #EC6459 none repeat scroll 0 0;
    border-radius: 5px;
    color: #fff;
    width: 70px;
    padding: 4px 8px;
}
</style>
<?php
//Helpers called to get all hbcu titles & organization titles
$hbc=get_all_hbcu_title();
$org=get_all_organization_title();
?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js" ></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css">
<section id="main-content">
    <section class="wrapper site-min-height">

    <!-- page start-->
    <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Donations Listing
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
    <li class="active"><a data-toggle="tab" href="#home">Individual</a></li>
    <li><a data-toggle="tab" href="#menu1">Total</a></li>
  </ul>



   <div class="tab-content">
    <div id="home" class="tab-pane fade in active">

        <div class="adv-table">

  <?php $id=$abc; ?>

        <div class="select_MOnth">
 <form role="form" method='POST' class="form-horizontal" action="<?php echo base_url('Dashboard/usertxn/'.$id)?>" enctype="multipart/form-data">
  <div class="form-group">
    <label>SELECT Month:</label>
    <input type="text" class="form-control4554 form-control-1 input-sm from" placeholder="Select month From Here" name="date" required="" value="" >
</div>
<input type="submit" name="submit" value="Submit" class="Add_bg">
</form>
</div>



                            <div class="table-responsive">
                             <table class="display table table-bordered datatable" id="jr">
                              
                                
                             
                              <!--   <a class="btn btn-info" href="<?php echo base_url('Dashboard/usertxnxls').'/'.$id ?>"  type="submit">Download</a> -->


        <?php
if (($add=='1')) {
?>
<a class="btn btn-info" href="<?php echo $url ;?>"  type="submit">Download </a>
<?php
}
else{?>

<a class="btn btn-info" href="<?php echo $url ;?>"  type="submit">Download </a>

<?php
}
?>


                                    <thead>
                                        <tr>

                                            <th>Sr.No</th>
                                           
                                            <th>Full Name</th>
                                          
                                            <th>E-mail</th>
                                            <th>Amount</th>
                                            <th>Donation Type</th>
                                            <!-- <th>Donation Percent</th> -->
                                            <th>HBCU</th>
                                            <th>Transaction ID</th>
                                           
                                            <th>Date Time</th>

                                        </tr>
                                    </thead>
                                    <?php $i =1;
                                // echo "<prE>";print_r($userData['indivisual']);die;
                                    foreach ($userData['indivisual'] as $user) {

                                        ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                     
                                        <td><?php echo $user->first_name.' '.$user->last_name; ?></td>
                                        
                                        <td><?php echo $user->email; ?></td>
                                        <td><?php echo $user->amount; ?></td>
                                        <td><?php $donate_type=$user->donation_type; 
                                            if($donate_type == 0){
                                                echo "Spare Change";
                                            }elseif($donate_type == 1){
                                                echo "Re-occurring";
                                            }else{
                                                echo "One Time";
                                            }
                                           ?></td>
                                     <!--    <td><?php 
                                        if (!empty($user->percentage)) {
                                        echo $user->percentage;    
                                        }
                                        else{
                                            echo "N/A";
                                        }



                                        ?></td> -->
                                        <td><?php echo $user->title; ?></td>
                                        <td><?php echo $user->txnId; ?></td>
                                  
                                        <td><?php echo $d = date('d-M-Y g:i a',strtotime($user->dateTime)); ?></td>
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
                                <?php $id=$userData['total'][0]->user_id; ?>
                                
                             
                                <a class="btn btn-info" href="<?php echo base_url('Dashboard/usertotalxls').'/'.$id ?>"  type="submit">Download</a>
                                    <thead>
                                        <tr>

                                            <th>Sr.No</th>
                                           
                                            <th>Full Name</th>
                                            <th>E-mail</th>
                                            <th>Amount</th>
                                            <th>Donation Type</th>
                                            <th>HBCU</th>
                                            <th>HBCU Percentage(%)</th>
                                      
                                      

                                        </tr>
                                    </thead>
                                    <?php $i =1;
                            
                                    foreach ($userData['total'] as $user) {
                                    //     echo "<pre>";
                                    // print_r($userData['total']);
                                        ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                     
                                        <td><?php echo $user->first_name.' '.$user->last_name; ?></td>
                                        <td><?php echo $user->email; ?></td>
                                        <td><?php echo $user->total; ?></td>
                                <td><?php $donate_type=$user->donation_type; 
                                            if($donate_type == 0){
                                                echo "Spare Change";
                                            }elseif($donate_type == 1){
                                                echo "Re-occurring";
                                            }else{
                                                echo "One Time";
                                            }
                                           ?></td> 
                                           <td><?php
                                           $add=array();
                                           foreach ($user->total12 as $key => $value) {
                                                $add[]=$value->title;
                                           }
                                           echo implode(',',$add);
                                            ?></td>
                                            <td>
                                                
                                                    <?php

                                                    // print_r($user->avgg);

                                                    if ($user->avgg=='N/A') {
                                                        echo "N/A";
                                                    }
                                                    else{

                                                      $add=array();
                                           foreach ($user->avgg as $key => $value) {
                                                $add[]=round($value->average*100/ $user->total,2);
                                           }
                                           echo implode(',',$add);
                                       }
                                                     ?>

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

<!--dsfdgf  -->



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
                                <!-- <button type="button" class="btn btn-primary submitBtn" onclick="submitContactForm()">SUBMIT</button> -->
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
// document.getElementById('hbcu').value = hbcu;


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