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

<section id="main-content">
    <section class="wrapper site-min-height">

    <!-- page start-->
    <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        DONATIONS
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
                        <div class="adv-table">
                            <div class="table-responsive">
                                <table class="display table table-bordered datatable" id="jr">
                                 <a class="btn btn-info" href="<?php echo base_url('Dashboard/donationsdxls')?>"  type="submit">Download</a>
                                    <thead>
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>User Name</th>
                                            <th>E-mail</th>
                                            <th>Amount</th>
                                            <th>Donation Type</th>
                                            <th>Donation Percentage</th>
                                            <th>HBCU</th>
                                            <th>Transaction ID</th>
                    
                                            <th>Date Time</th>

                                        </tr>
                                    </thead>
                                    <?php $i =1;
                                    foreach ($userData as $user) {?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $user->first_name.' '.$user->last_name; ?></td>
                                        <td><?php echo $user->email; ?></td>
                                        <td><?php echo round($user->amount,2); ?></td>
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
                                        if ($user->percentage) {
                                        echo $user->percentage; 
                                        }
                                        else{
                                            echo "N/A";
                                        }


                                        ?></td>
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



});
</script>


