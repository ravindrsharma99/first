<style type="text/css">
a.button_CLASS {
    background: #EC6459 none repeat scroll 0 0;
    border-radius: 5px;
    color: #fff;
    width: 70px;
    padding: 4px 8px;
}
</style>


<section id="main-content">
    <section class="wrapper site-min-height">

        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Feedback
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

                  <a class="btn btn-info" href="<?php echo base_url('Dashboard/feedbackxls')?>"  type="submit">Download</a>
                   
                        <div class="adv-table">
                            <div class="table-responsive">
                                <table class="display table table-bordered datatable" id="jr">
                                    <thead>
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>User Name</th>
                                            <th>Rating</th>
                                            <th>Subject</th>
                                            <th>Comment</th>
                                            <th>Date Time</th>
                                    

                                        </tr>
                                    </thead>
                                    <?php $i =1;
                                    foreach ($userData as $user) {?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php 
                                        if (!empty($user->first_name)) {
                                        echo $user->first_name.' '.$user->last_name; 
                                        }
                                        else{
                                        echo "N/A";
                                        }
                                        ?>


                                            

                                        </td>
                                        <td><?php echo $user->rating; ?></td>
                                        <td><?php echo $user->subject; ?></td>
                                         <td><?php echo $user->comment; ?></td>
                                        <td><?php echo $d = date('d-M-Y g:i a',strtotime($user->created)); ?></td>
                                 
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
// document.getElementById('hbcu').value = hbcu;


});
</script>


