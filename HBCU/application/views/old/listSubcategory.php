<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        SubCategories
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <div class="table-responsive">
                                <table class="display table table-bordered" id="jr">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Category Name</th>
                                            <th>Image</th>
                                            <th>Rate Type</th>
                                            <th>Km Charge</th>
                                            <th>Hourly Charge</th>
                                            <th>Base Price</th>
                                            <th>Way Point Charge</th>
                                            <th>Date_created</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <?php   

                 foreach ($subData as $user) {
       
        $datae = $this->Admin_model->select_data('categoryName','tbl_categories',array('id'=>$user->category_id));
        
                            ?>
                                    <tr id="delData<?php echo $user->id; ?>">
                                        <td>
                                            <?php echo $user->id; ?>
                                        </td>
                                        <td>
                                            <?php echo $user->subCategoryName; ?>
                                        </td>
                                        <td>
                                            <?php echo $datae[0]->categoryName; ?>
                                        </td>
                                        <td><img src="<?php echo $user->image; ?>" width="100px" /></td>
                                        <td>
                                            <?php echo ($user->jobRate_type == 2)?'Hourly':'Distance'; ?>
                                        </td>
                                        <td>
                                            <?php echo ($user->kmCharge == 0)?'Not Applicable':$user->kmCharge; ?>
                                        </td>
                                        <td>
                                            <?php echo ($user->hourlyCharge == 0)?'Not Applicable':$user->hourlyCharge; ?>
                                        </td>
                                        <td>
                                            <?php echo $user->base_price; ?>
                                        </td>
                                        <td>
                                            <?php echo $user->wayPoint_charge; ?>
                                        </td>
                                        <td>
                                            <?php echo $d = date('d-M-Y g:i a',strtotime($user->date_created)); ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-danger" href="javascript:void(0)" onclick="alert('Are You Sure')"> <span class = "deleteAction" revid = "<?php echo $user->id; ?>">Delete</span></a>
                                            <a href="#myModal" data-toggle="modal" data-userid="<?php echo $user->id; ?>" data-username="<?php echo $user->subCategoryName; ?>" data-type="<?php echo $user->jobRate_type; ?>" data-baseprice="<?php echo $user->base_price; ?>" class="btn btn-info">Edit</a>
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
                            <h4 class="modal-title">Edit SubCategory</h4>
                        </div>
                        <div class="modal-body">
                            <form role="form" name="editSubcategory" method="POST" action="editSubcategory" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" class="form-control" id="name" name="subCatname" placeholder="Enter SubCategory Name">
                                    <input type="hidden" name="editId" id="hiddenVal" value="">
                                </div>
                                <div class="form-group">
                                    <label for="baseprice">Base Price</label>
                                    <input type="number" class="form-control" id="baseprice" name="base_price" placeholder="">
                                </div>
                                    <div class="form-group">
                                    <label for="wayPoint_charge">Way Point Charge</label>
                                    <input type="number" class="form-control" id="wayPoint_charge" name="wayPoint_charge" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="selectbox">Fare Calculation Type</label>
                                    <select class="form-control" id="jobFareType" name="seljobType">
                                        <option>Select Type</option>
                                        <option value=1>Distance</option>
                                        <option value=2>Hourly</option>
                                    </select>
                                </div>
                                <div style='display:none;' class="form-group" id="kmDiv">
                                    <label for="exampleInputEmail1">Km Charge</label>
                                    <input type="text" class="form-control" id="kmCharge" name="kmCharge" placeholder="Km Charge">
                                </div>
                                <div style='display:none;' class="form-group" id="hourDiv">
                                    <label for="exampleInputEmail1">Hourly Charge</label>
                                    <input type="text" class="form-control" id="hourlyCharge" name="hourlyCharge" placeholder="Hourly Charge">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">SubCategory image</label>
                                    <input type="file" id="exampleInputFile3" name="subCatImage">
                                </div>
                                <button type="submit" name="subCatSubmit" class="btn btn-default">Submit</button>
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
            url: 'ajaxDel1',
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
        var type = $(e.relatedTarget).data('type');
        //alert(userid);
        document.getElementById('hiddenVal').value = userid;
        document.getElementById('name').value = username;
        document.getElementById('jobFareType').value = type;
        document.getElementById('baseprice').value = $(e.relatedTarget).data('baseprice');
        // $(e.currentTarget).find('input[name="user_id"]').val(userid);
    });


    $('#jobFareType').on('change', function() {

        if (this.value == '1')

        {
            $("#kmDiv").show();
            $("#hourDiv").show();
        } else {
            $("#hourDiv").show();
            $("#kmDiv").hide();

        }
    });


});
</script>
