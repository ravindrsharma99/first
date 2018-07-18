<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <?php
                  // echo "<pre>";
                  // print_r($pending);
                  // echo "</pre>";
                  ?>
                        <header class="panel-heading">
                            Requested Services
                        </header>
                        <div class="panel-body">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#home">Pending</a></li>
                                <li><a data-toggle="tab" href="#menu1">Activated</a></li>
                                <li><a data-toggle="tab" href="#menu2">Completed</a></li>
                                <li><a data-toggle="tab" href="#menu3">Cancelled</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="home" class="tab-pane fade in active">
                                    <div class="adv-table">
                                        <div class="table-responsive">
                                            <table class="display table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Req Id</th>
                                                        <th>Name</th>
                                                        <th>Category Name</th>
                                                        <th>Sub Category Name</th>
                                                        <th>Service Type</th>
                                                        <th>Price</th>
                                                        <th>Booking Date</th>
                                                        <th>Booking Time</th>
                                                        <th>Hours required</th>
                                                        <th>Date_created</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <?php $i =1;             
                                  foreach ($pending as $val) {

                        $CatName = $this->Admin_model->select_data('categoryName','tbl_categories',array('id'=>$val->category_id));
                        $SubCatName = $this->Admin_model->select_data('subCategoryName','tbl_subCategory',array('id'=>$val->subCategory_id));
                                     ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $i; ?>
                                                    </td>
                                                    <td>
                                                        <a class="link_class" href="<?php echo base_url(); ?>Dashboard/jobView?jobid=<?php echo $val->id; ?>"><?php echo $val->id; ?></a>
                                                    </td>
                                                    <td>
                                                        <?php echo $val->name; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $CatName[0]->categoryName; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $SubCatName[0]->subCategoryName; ?>
                                                    </td>
                                                    <td>
                                                        <?php if($val->ServiceType == 1){echo 'Per Hour';}else if($val->ServiceType == 2){echo 'Per Item';}else if($val->ServiceType == 3){echo 'Per Distance';}else if($val->ServiceType == 4){echo 'Fixed';} ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $val->totalprice.' $'; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $d = date('d-M-Y',strtotime($val->booking_date)); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $d = date('h:i:s',strtotime($val->booking_time)); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $val->hours; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $d = date('d-M-Y g:i a',strtotime($val->date_created)); ?>
                                                    </td>
                                                    <td>
                                                        <a href="#assignModal" data-toggle="modal" class="btn btn-primary freeProviders" reqid="<?php echo $val->id; ?>" userId="<?php echo $val->user_id; ?>">Assign</a>
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
                                            <table class="display table table-bordered" id="activatedTable">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Req Id</th>
                                                        <th>Name</th>
                                                        <th>Service Provider</th>
                                                        <th>Category Name</th>
                                                        <th>Sub Category Name</th>
                                                        <!-- <th>Service Type</th> -->
                                                        <!-- <th>Price</th> -->
                                                        <th>Accepted</th>
                                                        <th>Started</th>
                                                        <th>Date_created</th>
                                                        <th>Booking Date</th>
                                                        <th>Booking Time</th>
                                                        <th>Start Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <?php $i =1;             
                                  foreach ($activated as $val) {

                        $CatName = $this->Admin_model->select_data('categoryName','tbl_categories',array('id'=>$val->category_id));
                        $SubCatName = $this->Admin_model->select_data('subCategoryName','tbl_subCategory',array('id'=>$val->subCategory_id));
                        $serviceProviderDetail = $this->Admin_model->select_data('*','tbl_users',array('id'=>$val->accepted_by));
                                     ?>
                                                <tr id="removeRow<?php echo $val->id; ?>">
                                                    <td>
                                                        <?php echo $i; ?>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo base_url(); ?>Dashboard/jobView?jobid=<?php echo $val->id; ?>"><?php echo $val->id; ?></a>
                                                    </td>
                                                    <td>
                                                        <?php echo $val->name; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $serviceProviderDetail[0]->fname; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $CatName[0]->categoryName; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $SubCatName[0]->subCategoryName; ?>
                                                    </td>
                                                    <!-- <td>
                                        <?php if($val->ServiceType == 1){echo 'Per Hour';}else if($val->ServiceType == 2){echo 'Per Item';}else if($val->ServiceType == 3){echo 'Per Distance';}else if($val->ServiceType == 4){echo 'Fixed';} ?>
                                    </td>
                                      <td>
                                        <?php echo $val->totalprice.' $'; ?>
                                    </td> -->
                                                    <td>
                                                        <?php echo $val->is_accepted; ?>
                                                    </td>
                                                    <td id="actIsStarted<?php echo $val->id ?>">
                                                        <?php echo $val->is_started; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $d = date('d-M-Y g:i a',strtotime($val->date_created)); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $d = date('d-M-Y',strtotime($val->booking_date)); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $d = date('g:i a',strtotime($val->booking_time)); ?>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class='input-group date datetimepicker1' id=''>
                                                                <input type='text' id="actStartDate<?php echo $val->id ?>" class="form-control" value="<?php echo(date(" Y-m-d h:i:s ")) ?>"/>
                                                                <span class="input-group-addon">
                                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <!-- <td>
                                        <div class="form-group">
                                                        <div class='input-group date datetimepicker3' id=''>
                                                            <input type='text' id="actBookTime<?php echo $val->id ?>" class="form-control" value="<?php echo $val->booking_time ?>"/>
                                                            <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-time"></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                        
                                    </td> -->
                                                    <td>
                                                        <?php
                                        if ($val->is_started==1) { ?>
                                                            <a class="btn btn-info startService" id="actStartBut<?php echo $val->id ?>" data-reqid="<?php echo $val->id; ?>" userId="<?php echo $val->user_id; ?>" serviceProvider="<?php echo $val->accepted_by; ?>" isStart="0">Update</a>

                                                            <a class="btn btn-warning endService" id="actEndBut<?php echo $val->id ?>" data-reqid="<?php echo $val->id; ?>" userId="<?php echo $val->user_id; ?>" serviceProvider="<?php echo $val->accepted_by; ?>">end</a>
                                                            <?php } else { ?>
                                                            <a class="btn btn-primary startService" id="actStartBut<?php echo $val->id ?>" data-reqid="<?php echo $val->id; ?>" userId="<?php echo $val->user_id; ?>" serviceProvider="<?php echo $val->accepted_by; ?>" isStart="1">Start</a>

                                                            <a class="btn btn-danger cancelService" id="actCancelBut<?php echo $val->id ?>" data-reqid="<?php echo $val->id; ?>" userId="<?php echo $val->user_id; ?>" serviceProvider="<?php echo $val->accepted_by; ?>">cancel</a>
                                                            <?php }
                                        
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
                                <div id="menu2" class="tab-pane fade">
                                    <div class="adv-table">
                                        <div class="table-responsive">
                                            <table class="display table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Req Id</th>
                                                        <th>Name</th>
                                                        <th>Service Provider</th>
                                                        <th>Category Name</th>
                                                        <th>Sub Category Name</th>
                                                        <th>Service Type</th>
                                                        <th>Price</th>
                                                        <th>Date_created</th>
                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                </thead>
                                                <?php $i =1;             
                                  foreach ($completed as $val) {

                        $CatName = $this->Admin_model->select_data('categoryName','tbl_categories',array('id'=>$val->category_id));
                        $SubCatName = $this->Admin_model->select_data('subCategoryName','tbl_subCategory',array('id'=>$val->subCategory_id));
                        $serviceProviderDetail = $this->Admin_model->select_data('*','tbl_users',array('id'=>$val->accepted_by));
                                     ?>
                                                <tr id="delData<?php echo $val->id; ?>">
                                                    <td>
                                                        <?php echo $i; ?>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo base_url(); ?>Dashboard/jobView?jobid=<?php echo $val->id; ?>"><?php echo $val->id; ?></a>
                                                    </td>
                                                    <td>
                                                        <?php echo $val->name; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $serviceProviderDetail[0]->fname; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $CatName[0]->categoryName; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $SubCatName[0]->subCategoryName; ?>
                                                    </td>
                                                    <td>
                                                        <?php if($val->ServiceType == 1){echo 'Per Hour';}else if($val->ServiceType == 2){echo 'Per Item';}else if($val->ServiceType == 3){echo 'Per Distance';}else if($val->ServiceType == 4){echo 'Fixed';} ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $val->totalprice.' $'; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $d = date('d-M-Y g:i a',strtotime($val->date_created)); ?>
                                                    </td>
                                                    <!-- <td>
                                        <a class="btn btn-success"  href="javascript:void(0)" > <span class = "deleteAction" revid = "<?php echo $val->id; ?>">Delete</span></a>

                                        <a href="#myModal"  data-toggle="modal" class="btn btn-danger" data-userid ="<?php echo $val->id; ?>">Edit</a>

                                    </td> -->
                                                </tr>
                                                <?php $i++;
                                 }   
                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="menu3" class="tab-pane fade">
                                    <div class="adv-table">
                                        <div class="table-responsive">
                                            <table class="display table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Req Id</th>
                                                        <th>Name</th>
                                                        <th>Service Provider</th>
                                                        <th>Category Name</th>
                                                        <th>Sub Category Name</th>
                                                        <th>Service Type</th>
                                                        <th>Price</th>
                                                        <th>Date_created</th>
                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                </thead>
                                                <?php $i =1;             
                                  foreach ($cancelled as $val) {

                        $CatName = $this->Admin_model->select_data('categoryName','tbl_categories',array('id'=>$val->category_id));
                        $SubCatName = $this->Admin_model->select_data('subCategoryName','tbl_subCategory',array('id'=>$val->subCategory_id));
                        $serviceProviderDetail = $this->Admin_model->select_data('*','tbl_users',array('id'=>$val->accepted_by));
                                     ?>
                                                <tr id="delData<?php echo $val->id; ?>">
                                                    <td>
                                                        <?php echo $i; ?>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo base_url(); ?>Dashboard/jobView?jobid=<?php echo $val->id; ?>"><?php echo $val->id; ?></a>
                                                    </td>
                                                    <td>
                                                        <?php echo $val->name; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $serviceProviderDetail[0]->fname; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $CatName[0]->categoryName; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $SubCatName[0]->subCategoryName; ?>
                                                    </td>
                                                    <td>
                                                        <?php if($val->ServiceType == 1){echo 'Per Hour';}else if($val->ServiceType == 2){echo 'Per Item';}else if($val->ServiceType == 3){echo 'Per Distance';}else if($val->ServiceType == 4){echo 'Fixed';} ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $val->totalprice.' $'; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $d = date('d-M-Y g:i a',strtotime($val->date_created)); ?>
                                                    </td>
                                                    <!-- <td>
                                        <a class="btn btn-success"  href="javascript:void(0)" > <span class = "deleteAction" revid = "<?php echo $val->id; ?>">Delete</span></a>

                                        <a href="#myModal"  data-toggle="modal" class="btn btn-danger" data-userid ="<?php echo $val->id; ?>">Edit</a>

                                    </td> -->
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
                            <h4 class="modal-title">Edit Service</h4>
                        </div>
                        <div class="modal-body">
                            <form role="form" name="editSubcategory" method="POST" action="editService" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Title</label>
                                    <input type="text" class="form-control" id="serviceTitle" name="serviceTitle" placeholder="Enter Service Title">
                                    <input type="hidden" name="editId" id="hiddenServiceVal" value="">
                                </div>
                                <div class="form-group">
                                    <label for="selectbox">Service Type</label>
                                    <select class="form-control" id="jobFareType" name="selServiceType">
                                        <option>Select Type</option>
                                        <option value=1>Per Hour</option>
                                        <option value=2>Per Item</option>
                                        <option value=3>Per Distance</option>
                                        <option value=4>Fixed</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Price</label>
                                    <input type="text" class="form-control" id="servicePrice" name="servicePrice" placeholder="Enter Price">
                                </div>
                                <button type="submit" name="subCatServiceSubmit" class="btn btn-default">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div aria-hidden="true" aria-labelledby="assignModalLabel" role="dialog" tabindex="-1" id="assignModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Assign Provider</h4>
                        </div>
                        <div class="modal-body">
                            <form role="form" name="assignProvider" method="POST" action="serviceRequest" enctype="multipart/form-data">
                                <div id="assignProvider"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
<script type="text/javascript">
$(document).ready(function() {

    //Disable cut copy paste
    /* $('body').bind('cut copy paste', function (e) {
         e.preventDefault();
     });
   
     //Disable mouse right click
     $("body").on("contextmenu",function(e){
         return false;
     });*/


    $("body").delegate(".freeProviders", "click", function() {
        var reqid = $(this).attr('reqid');
        var userId = $(this).attr('userId');
        // console.log(reqid);
        $.ajax({
            type: 'post',
            url: 'freeProviders',
            dataType: 'json',
            data: {
                reqid: reqid,
                userId: userId
            },
            cache: false,
            beforeSend: function() {
                $("#wait").css("display", "none");
                $("#wait").css("display", "block");
                $(document.body).css({
                    'cursor': 'wait'
                });

                $("#assignProvider").empty();
                $("#assignProvider").append("Loading...");
            },
            success: function(data) {
                // console.log(data);
                $("#assignProvider").empty();
                $("#assignProvider").append(data);
            },
            complete: function() {
                $("#wait").css("display", "none");
                $(document.body).css({
                    'cursor': 'default'
                });
            },
            error: function(request, status, error) {}
        });

    });

    $(function() {
        $('.datetimepicker1').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss'
        });
    });

    $(function() {
        $('.datetimepicker3').datetimepicker({
            format: 'HH:mm:ss'
        });
    });
    /*function freeProviders (elem) {
      console.log(elem);
    }*/
    $("body").delegate(".startService", "click", function() {
        var reqid = $(this).attr('data-reqid');
        var userId = $(this).attr('userId');
        var serviceProvider = $(this).attr('serviceProvider');
        var isStart = $(this).attr('isStart');
        // var booking_date = $("#actBookDate"+reqid).val();
        // var booking_time = $("#actBookTime"+reqid).val();
        var started_time = $("#actStartDate" + reqid).val();
        // console.log(reqid);
        // console.log(booking_date);
        console.log(started_time);
        $.ajax({
            type: 'post',
            url: 'startService',
            dataType: 'json',
            data: {
                reqid: reqid,
                userId: userId,
                serviceProvider: serviceProvider,
                started_time: started_time,
                isStart: isStart
            },
            cache: false,
            beforeSend: function() {
                $("#wait").css("display", "none");
                $("#wait").css("display", "block");
                $(document.body).css({
                    'cursor': 'wait'
                });
            },
            success: function(data) {
                console.log(data);
                $("#actStartBut" + reqid).removeClass("btn-success");
                $("#actStartBut" + reqid).addClass("btn-info");
                $("#actStartBut" + reqid).html("Update");
                $("#actIsStarted" + reqid).html("1");

                $("#actCancelBut" + reqid).removeClass("btn-danger");
                $("#actCancelBut" + reqid).addClass("btn-warning");
                $("#actCancelBut" + reqid).removeClass("cancelService");
                $("#actCancelBut" + reqid).addClass("endService");
                $("#actCancelBut" + reqid).html("End");
            },
            complete: function() {
                $("#wait").css("display", "none");
                $(document.body).css({
                    'cursor': 'default'
                });
            },
            error: function(request, status, error) {}
        });

    });

    $("body").delegate(".endService", "click", function() {
        var reqid = $(this).attr('data-reqid');
        var userId = $(this).attr('userId');
        var serviceProvider = $(this).attr('serviceProvider');
        // console.log(reqid);
        $.ajax({
            type: 'post',
            url: 'endService',
            dataType: 'json',
            data: {
                reqid: reqid,
                userId: userId,
                serviceProvider: serviceProvider
            },
            cache: false,
            beforeSend: function() {
                $("#wait").css("display", "none");
                $("#wait").css("display", "block");
                $(document.body).css({
                    'cursor': 'wait'
                });

            },
            success: function(data) {
                console.log(data);
                var table = $('#activatedTable').DataTable();
                table.row('#removeRow' + reqid).remove().draw(false);
            },
            complete: function() {
                $("#wait").css("display", "none");
                $(document.body).css({
                    'cursor': 'default'
                });
            },
            error: function(request, status, error) {}
        });
    });

    $("body").delegate(".cancelService", "click", function() {
        var reqid = $(this).attr('data-reqid');
        var userId = $(this).attr('userId');
        var serviceProvider = $(this).attr('serviceProvider');
        // console.log(reqid);
        $.ajax({
            type: 'post',
            url: 'cancelService',
            dataType: 'json',
            data: {
                reqid: reqid,
                userId: userId,
                serviceProvider: serviceProvider
            },
            cache: false,
            beforeSend: function() {
                $("#wait").css("display", "none");
                $("#wait").css("display", "block");
                $(document.body).css({
                    'cursor': 'wait'
                });

            },
            success: function(data) {
                console.log(data);
                var table = $('#activatedTable').DataTable();
                table.row('#removeRow' + reqid).remove().draw(false);
            },
            complete: function() {
                $("#wait").css("display", "none");
                $(document.body).css({
                    'cursor': 'default'
                });
            },
            error: function(request, status, error) {}
        });
    });

    $('#myModal').on('show.bs.modal', function(e) {
        var userid = $(e.relatedTarget).data('userid');

        document.getElementById('hiddenServiceVal').value = userid;
    });

});
</script>
<div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo base_url(); ?>Public/img/demo_wait.gif' width="64" height="64" />
    <br>Processing...</div>
