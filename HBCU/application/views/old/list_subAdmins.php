<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                      Sub Admins
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <div class="table-responsive">
                                <table class="table table-bordered display" id="jr">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>FirstName</th>
                                            <th>LastName</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Phone</th>
                                            <th>ProfilePic</th>
                                            <th>Date_created</th>
                                            <th>Action</th>

                                        </tr>

                                    </thead>
                                    <?php $i =1;             
                                  foreach ($subData as $user) {?>
                                    <tr id = "delData<?php echo $user->id; ?>">
                                        <td>
                                            <?php echo $i; ?>
                                        </td>
                                        <td>
                                            <?php echo $user->fname; ?>
                                        </td>
                                        <td>
                                            <?php echo $user->lname; ?>
                                        </td>
                                        <td>
                                            <?php echo $user->email; ?>
                                        </td>
                                        <td>
                                            <?php echo $user->address; ?>
                                        </td>
                                        <td>
                                            <?php echo $user->phone; ?>
                                        </td>
                                        <td><img src="<?php echo empty($user->profile_pic)?base_url('Public/img/AdminImages').'/default.jpg':$user->profile_pic; ?>" style="width:90px;height:auto;border-radius:50%" /></td>
                                        <td>
                                            <?php echo $d = date('d-M-Y g:i a',strtotime($user->date_created)); ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>Dashboard/addPermissions?userId=<?php echo $user->id; ?>" data-toggle="modal" data-userid="<?php echo $user->id; ?>" data-username="<?php echo $user->categoryName; ?>" class="btn btn-info">Permissions</a>

                                              <a class="btn btn-danger" href="javascript:void(0)" onclick="alert('Are You Sure')"> <span class ="subDelete" id="<?php echo $user->id; ?>" myid = "<?php echo $user->id; ?>">Delete</span></a> 
                                        </td>
                                    
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
    </section>
</section>
<script type="text/javascript">
$(document).ready(function() {

        $("body").delegate(".subDelete", "click", function() {
        var myid = $(this).attr('myid');
        // alert(revid);
        $.ajax({
            type: 'post',
            url: 'ajaxsubAdminDel',
            //dataType: 'json',
            data: {
                myid: myid
            },
            cache: false,
            beforeSend: function() {
                $(".loadermyli").show();
            },
            success: function(data) {


                if (data == 1) {

                    var table = $('#jr').DataTable();
                    table.row('#delData' + myid).remove().draw(false);

                }
            },
            complete: function() {
                $(".loadermyli").hide();
            },
            error: function(request, status, error) {

            }
        });
    });



});
</script>
