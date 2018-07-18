<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        List SubCategory Services
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                          <div class="table-responsive">
                            <table class="display table table-bordered" id="jr">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Category Name</th>
                                        <th>Sub Category Name</th>
                                        <th>Title</th>
                                        <th>Service Type</th>
                                        <th>Price</th>
                                        <th>Date_created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php $i =1;             
                                  foreach ($mainData as $user) {

                        $CatName = $this->Admin_model->select_data('categoryName','tbl_categories',array('id'=>$user->category_id));
                        $SubCatName = $this->Admin_model->select_data('subCategoryName','tbl_subCategory',array('id'=>$user->subCategory_id));
                                     ?>
                                <tr id = "delData<?php echo $user->id; ?>">
                                    <td>
                                        <?php echo $i; ?>
                                    </td>
                                    <td>
                                        <?php echo $CatName[0]->categoryName; ?>
                                    </td>
                                      <td>
                                        <?php echo $SubCatName[0]->subCategoryName; ?>
                                    </td>
                                      <td>
                                        <?php echo $user->ServiceTitle; ?>
                                    </td>
                                      <td>
                                        <?php if($user->ServiceType == 1){echo 'Per Hour';}else if($user->ServiceType == 2){echo 'Per Item';}else if($user->ServiceType == 3){echo 'Per Distance';}else if($user->ServiceType == 4){echo 'Fixed';} ?>
                                    </td>
                                      <td>
                                        <?php echo $user->price.' $'; ?>
                                    </td>
                                    <td>
                                        <?php echo $d = date('d-M-Y g:i a',strtotime($user->date_created)); ?>
                                    </td>
                                    <td>
                                        <a class="btn btn-danger"  href="javascript:void(0)" onclick="alert('Are You Sure')"> <span class = "deleteAction" revid = "<?php echo $user->id; ?>">Delete</span></a>

                                        <a href="#myModal"  data-toggle="modal" class="btn btn-info" data-userid ="<?php echo $user->id; ?>">Edit</a>

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
                                                      <input type="text" class="form-control" id="serviceTitle"  name ="serviceTitle" placeholder="Enter Service Title">
                                                       <input type="hidden" name="editId" id ="hiddenServiceVal" value=""> 
                                                  </div>

                                                  <div class="form-group">
                                                      <label for="selectbox">Service Type</label>
                                                       <select class="form-control" id="jobFareType" name = "selServiceType">
                                                              <option>Select Type</option>
                                                              <option value = 1>Per Hour</option>
                                                              <option value = 2>Per Item</option>
                                                              <option value = 3>Per Distance</option>
                                                              <option value = 4>Fixed</option>
                                                         
                                                       </select>
                                                     
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="exampleInputEmail1">Price</label>
                                                      <input type="text" class="form-control" id="servicePrice"  name ="servicePrice" placeholder="Enter Price">
                                                  
                                                  </div>
                                                 
                                      
                                                  <button type="submit" name = "subCatServiceSubmit" class="btn btn-default">Submit</button>
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
            $("body").delegate(".deleteAction", "click", function () {
            var revid = $(this).attr('revid');
           // alert(revid);
            $.ajax(
                    {
                        type: 'post',
                        url: 'ajaxDel2',
                        dataType: 'json',
                        data: {revid: revid},
                        cache: false,
                        beforeSend: function () {
                            $(".loadermyli").show();
                        },
                        success: function (data) {

                            
                                    if(data == 1){

                                      var table = $('#jr').DataTable();
                                      table.row('#delData'+revid).remove().draw( false );
                         
                            }
                        },
                        complete: function () {
                            $(".loadermyli").hide();
                        },
                        error: function (request, status, error) {

                        }
            });
        });


   $('#myModal').on('show.bs.modal', function(e) {
    var userid = $(e.relatedTarget).data('userid');
   
   document.getElementById('hiddenServiceVal').value = userid;
  
});

    });
</script>



