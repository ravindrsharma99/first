<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Categories
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <div class="table-responsive">
                                <table class="display table table-bordered" id="jr">
                                    <thead>
                                        <tr>
                                            <th>Category_Id</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Date_created</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <?php              
                                  foreach ($mainData as $user) {?>
                                    <tr id="delData<?php echo $user->id; ?>">
                                        <td>
                                            <?php echo $user->id; ?>
                                        </td>
                                        <td>
                                            <?php echo $user->categoryName; ?>
                                        </td>
                                        <td><img src="<?php echo $user->image; ?>" width="100px" /></td>
                                        <td>
                                            <?php echo $d = date('d-M-Y g:i a',strtotime($user->date_created)); ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-danger" href="javascript:void(0)" onclick="alert('Are You Sure')"> <span class = "deleteAction" revid = "<?php echo $user->id; ?>">Delete</span></a>
                                            <a href="#myModal" data-toggle="modal" data-userid="<?php echo $user->id; ?>" data-username="<?php echo $user->categoryName; ?>" class="btn btn-info">Edit</a>
                                        </td>
                                    </tr>
                                    <?php }   
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
                            <h4 class="modal-title">Edit Category</h4>
                        </div>
                        <div class="modal-body">
                            <form role="form" name="editCategory" method="POST" action="editCategory" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" class="form-control" id="name" name="catName" placeholder="Enter Category Name">
                                    <input type="hidden" name="editId" id="hiddVal" value="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Category image</label>
                                    <input type="file" id="exampleInputFile3" name="catImage">
                                </div>
                                <button type="submit" name="catSubmit" class="btn btn-default">Submit</button>
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
    $("body").delegate(".deleteAction", "click", function() {
        var revid = $(this).attr('revid');
        // alert(revid);
        $.ajax({
            type: 'post',
            url: 'ajaxDel',
            dataType: 'json',
            data: {
                revid: revid
            },
            cache: false,
            beforeSend: function() {
                $(".loadermyli").show();
            },
            success: function(data) {


                if (data == 1) {
                    var table = $('#jr').DataTable();
                    table.row('#delData' + revid).remove().draw(false);

                }
            },
            complete: function() {
                $(".loadermyli").hide();
            },
            error: function(request, status, error) {

            }
        });
    });


    $('#myModal').on('show.bs.modal', function(e) {
        var userid = $(e.relatedTarget).data('userid');
        var username = $(e.relatedTarget).data('username');
        //alert(userid);
        document.getElementById('hiddVal').value = userid;
        document.getElementById('name').value = username;
        // $(e.currentTarget).find('input[name="user_id"]').val(userid);
    });

});
</script>
