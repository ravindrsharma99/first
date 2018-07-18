<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Subscriptions
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <div class="table-responsive">
                                <table class="display table table-bordered" id="jr">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Date_created</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <?php $i =1;             
                                  foreach ($subscriptionData as $user) {?>
                                    <tr id="delData<?php echo $user->id; ?>">
                                        <td>
                                            <?php echo $i; ?>
                                        </td>
                                        <td>
                                            <?php echo $user->name; ?>
                                        </td>
                                        <td>
                                            <?php if($user->type == 0){
                                            echo "Monthly";
                                        }else if($user->type == 1){
                                            echo "Quarterly";
                                        }else if($user->type == 2){
                                            echo "Half-Yearly";
                                        }else if($user->type == 3){
                                            echo "Yearly";
                                        } ?>
                                        </td>
                                        <td>
                                            <?php echo $user->amount; ?>
                                        </td>
                                        <td>
                                            <?php echo $d = date('d-M-Y g:i a',strtotime($user->date_created)); ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-danger" href="javascript:void(0)" onclick="alert('Are You Sure')"> <span class = "deleteAction" revid = "<?php echo $user->id; ?>">Delete</span></a>
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

    $("body").delegate(".deleteAction", "click", function() {
        var revid = $(this).attr('revid');
        // alert(revid);
        $.ajax({
            type: 'post',
            url: 'ajaxDel3',
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
});
</script>
