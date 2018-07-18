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
                        Drivers
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <div class="table-responsive">
                                <table class="display table table-bordered" id="jr">
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
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <?php $i =1;             
                                  foreach ($drivData as $user) {?>
                                    <tr>
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
                                            
                                            <a class="btn btn-danger button_CLASS" href="javascript:void(0)"> <span class = "clickAction" id="unqButton<?php echo $user->id; ?>" revid = "<?php echo $user->id; ?>"  status = "<?php echo ($user->providersStatus == 1)?0:1;?>"><?php echo ($user->providersStatus ==1)?'Activated':'Inactive'; ?></span></a>
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

    $("body").delegate(".clickAction", "click", function() {
        var revid = $(this).attr('revid');
        var status = $(this).attr('status');
        $.ajax({
            type: 'post',
            url: 'ajaxDrCall',
            dataType: 'json',
            data: {
                revid: revid,
                status: status
            },
            cache: false,
            beforeSend: function() {
                $(".loadermyli").show();
            },
            success: function(data) {


                if (data == 1) {
                    $('#unqButton' + revid).attr("status", "0");
                    $('#unqButton' + revid).html('Activated');
                } else {
                    $('#unqButton' + revid).attr("status", "1");
                    $('#unqButton' + revid).html('Inactive');
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
