<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Membership List
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <div class="table-responsive">
                                <table class="display table table-bordered" id="jr">
                                    <thead>
                                        <tr>
                                            <th>Membership id</th>
                                            <th>Membership</th>
                                            <th>Validity</th>
                                            <th>Price</th>
                                            <th>Date_created</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i =1;             
                                  foreach ($membershipList as $val) {

                       
                                     ?>
                                        <tr id="rowData<?php echo $val->id; ?>">
                                            <td>
                                                <?php echo $val->id; ?>
                                            </td>
                                            <td>
                                                <input value="<?php echo $val->membership; ?>" id="membership" name="membership"></input>
                                            </td>
                                            <td>
                                                <input type="number" value="<?php echo $val->validity; ?>" id="validity" name="validity"></input>
                                            </td>
                                            <td>
                                                <input type="number" value="<?php echo $val->price; ?>" id="price" name="price"></input>
                                            </td>
                                            <td>
                                                <?php echo $d = date('d-M-Y g:i a',strtotime($val->addedOn)); ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-danger" href="javascript:void(0)" onclick="alert('Are You Sure')"> <span class = "deleteAction" revid = "<?php echo $val->id; ?>">Delete</span></a>
                                                <button onclick="editMembership(this)" class="btn btn-info" data-userid="<?php echo $val->id; ?>">Edit</button>
                                            </td>
                                        </tr>
                                        <?php $i++;
                                 }   
                                ?>
                                    </tbody>
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
function editMembership(argument) {
    var id = $(argument).attr('data-userid');
    var membership = $("#rowData" + id).find("#membership").val();
    var price = $("#rowData" + id).find("#price").val();
    var validity = $("#rowData" + id).find("#validity").val();
    // console.log(promo_code);
    // console.log(value);
    // console.log(type);
    // console.log(id);
    $.ajax({
        type: "POST",
        url: "editMembership",
        dataType: "json",
        data: {
            id: id,
            membership: membership,
            price: price,
            validity: validity
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
            console.log(data.status);
            $("#rowData" + id).find("#membership").val(data.data[0].membership);
            $("#rowData" + id).find("#price").val(data.data[0].price);
            $("#rowData" + id).find("#validity").val(data.data[0].validity);
            if (data.status == 'success') {
                alert(data.message);
            } else {
                alert(data.message);
            };
        },
        complete: function() {
            $("#wait").css("display", "none");
            $(document.body).css({
                'cursor': 'default'
            });
        },
        error: function(request, status, error) {
            $("#wait").css("display", "none");
            $(document.body).css({
                'cursor': 'default'
            });
        }
    });
}
$(document).ready(function() {
    $("body").delegate(".deleteAction", "click", function() {
        var id = $(this).attr('revid');
        // alert(revid);
        $.ajax({
            type: 'post',
            url: 'ajaxDelUniversal',
            dataType: 'json',
            data: {
                id: id,
                tbl_name: 'tbl_membership'
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


                if (data == 1) {

                    var table = $('#jr').DataTable();
                    table.row('#rowData' + id).remove().draw(false);

                }
            },
            complete: function() {
                $("#wait").css("display", "none");
                $(document.body).css({
                    'cursor': 'default'
                });
            },
            error: function(request, status, error) {
                $("#wait").css("display", "none");
                $(document.body).css({
                    'cursor': 'default'
                });
            }
        });
    });

});
</script>
<div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo base_url(); ?>Public/img/demo_wait.gif' width="64" height="64" />
    <br>Processing...</div>
