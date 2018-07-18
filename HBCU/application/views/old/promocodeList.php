<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Promo Code List
                    </header>
                    <div class="">
                        <div class="">
                            <div class="table-responsive">
                                <table class="display table table-bordered" id="jr">
                                    <thead>
                                        <tr>
                                            <th>Promo id</th>
                                            <th>Promo code</th>
                                            <th>Promo Type</th>
                                            <th>Value</th>
                                            <th>Max Usage</th>
                                            <th>Usage PerUser</th>
                                            <th>Date_created</th>
                                            <th>Expiry Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i =1;             
                                            foreach ($promocodeList as $val) {
                                        ?>
                                        <tr id="rowData<?php echo $val->id; ?>">
                                            <td>
                                                <?php echo $val->id; ?>
                                            </td>
                                            <td>
                                                <input value="<?php echo $val->promo_code; ?>" id="promocode" name="promocode" />
                                            </td>
                                            <td>
                                                <select name="promocodeType" id="promocodeType">
                                                    <option value="0" <?php if ($val->type==0) { ?> selected
                                                        <?php } ?> >Amount</option>
                                                    <option value="1" <?php if ($val->type==1) { ?> selected
                                                        <?php } ?> >Percentage</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" value="<?php echo $val->value; ?>" id="promocodeVal" name="promocodeVal" />
                                            </td>
                                            <td>
                                                <input type="number" value="<?php echo $val->max_usage; ?>" id="max_usage" name="max_usage" />
                                            </td>
                                            <td>
                                                <select name="usage" id="usage">
                                                    <option value="0" <?php if ($val->type==0) { ?> selected
                                                        <?php } ?> >10 Times</option>
                                                    <option value="1" <?php if ($val->type==1) { ?> selected
                                                        <?php } ?> >20 Times</option>
                                                    <option value="2" <?php if ($val->type==2) { ?> selected
                                                        <?php } ?> >30 Times</option>
                                                    <option value="3" <?php if ($val->type==3) { ?> selected
                                                        <?php } ?> >40 Times</option>
                                                    <option value="4" <?php if ($val->type==4) { ?> selected
                                                        <?php } ?> >50 Times</option>
                                                    <option value="5" <?php if ($val->type==5) { ?> selected
                                                        <?php } ?> >Unlimited</option>
                                                </select>
                                            </td>
                                            <td>
                                                <?php echo $d = date('d-M-Y g:i a',strtotime($val->date_created)); ?>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Expiry Date</label>
                                                    <div class="">
                                                        <input size="16" type="text" value="<?php echo $val->expiry_date; ?>" id="expiry_date" name="expiry_date" readonly class="form_datetime form-control" />
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <button onclick="editPromoCode(this)" class="btn btn-info" data-userid="<?php echo $val->id; ?>">Update</button>
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
function editPromoCode(argument) {
    var id = $(argument).attr('data-userid');
    var promo_code = $("#rowData" + id).find("#promocode").val();
    var value = $("#rowData" + id).find("#promocodeVal").val();
    var type = $("#rowData" + id).find("#promocodeType").val();
    var max_usage = $("#rowData" + id).find("#max_usage").val();
    var usage = $("#rowData" + id).find("#usage").val();
    var expiry_date = $("#rowData" + id).find("#expiry_date").val();
    // console.log(promo_code);
    // console.log(value);
    // console.log(type);
    // console.log(id);
    $.ajax({
        type: "POST",
        url: "editPromoCode",
        dataType: "json",
        data: {
            id: id,
            promo_code: promo_code,
            value: value,
            type: type,
            max_usage: max_usage,
            usage: usage,
            expiry_date: expiry_date
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
            $("#rowData" + id).find("#promocode").val(data.data[0].promo_code);
            $("#rowData" + id).find("#promocodeVal").val(data.data[0].value);
            $("#rowData" + id).find("#promocodeType").val(data.data[0].type);
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
        var revid = $(this).attr('revid');
        // alert(revid);
        $.ajax({
            type: 'post',
            url: 'ajaxDel2',
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

        document.getElementById('hiddenServiceVal').value = userid;

    });

var ab = new Date();

 $("#expiry_date").datetimepicker('setStartDate', ab);

});
</script>
<div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo base_url(); ?>Public/img/demo_wait.gif' width="64" height="64" />
    <br>Processing...</div>
new_map