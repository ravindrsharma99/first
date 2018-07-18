<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Settings
                        <?php
                        // echo "<pre>";
                        // var_dump($settings);
                        // echo "</pre>";
                        ?>
                    </header>
                    <div class="panel-body">
                        <div class="adv-table ">
                            <table class="display table-bordered table table-striped">
                                <?php $i =1;
                                foreach ($settings as $val) {


                                    ?>
                                    <tbody id="rowData<?php echo $val->id; ?>">
                                        <!--    <tr>
                                        <td>
                                        <label>ID</label>
                                    </td>
                                    <td>
                                    <?php // echo $val->id; ?>
                                </td>
                            </tr>
                            <tr>
                        -->
                        <td>
                            <label>Min Booking Charge</label>
                        </td>
                        <td>
                            <input type="number" value="<?php echo $val->minBooking_charge; ?>" id="minBooking_charge" name="minBooking_charge"><b> %</b></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Driver Cancellation charge</label>
                        </td>
                        <td>
                            <input type="number" value="<?php echo $val->driverCancellation_charge; ?>" id="driverCancellation_charge" name="driverCancellation_charge"><b> %</b></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>User Cancellation hours</label>
                        </td>
                        <td>
                            <input type="number" value="<?php echo $val->userCancellation_hours; ?>" id="userCancellation_hours" name="userCancellation_hours"><b> hrs</b></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Admin commission</label>
                        </td>
                        <td>
                            <input type="number" value="<?php echo $val->admin_commission; ?>" id="admin_commission" name="admin_commission"><b> %</b></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Promo Referer amount</label>
                        </td>
                        <td>
                            <input type="number" value="<?php echo $val->promoReferer_amount; ?>" id="promoReferer_amount" name="promoReferer_amount"><b> %</b></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Promo User amount</label>
                        </td>
                        <td>
                            <input type="number" value="<?php echo $val->promoUser_amount; ?>" id="promoUser_amount" name="promoUser_amount"><b> %</b></input>
                        </td>
                    </tr>
                    <!-- <tr>
                        <td>
                            <label>Peak Hour Charge</label>
                        </td>
                        <td>
                            <input type="number" value="<?php echo $val->peakHourCharge; ?>" id="PeakHourCharge" name="PeakHourCharge"><b> SGD</b></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Peak Hour From</label>
                        </td>
                        <td>
                            <div class="form-group">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="input-group bootstrap-timepicker">
                                        <input type="text" class="form-control timepicker-24" id = "peakHrFRom" name ="PeakHourFrom" value="<?php echo $val->peakHourFrom; ?>">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default DATE_BTTN" type="button"><i class="fa fa-clock-o"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Peak Hour To</label>
                        </td>
                        <td>
                            <div class="form-group">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="input-group bootstrap-timepicker">
                                        <input type="text" class="form-control timepicker-24" id = "peakHrTo" name ="PeakHourTo" value="<?php echo $val->peakHourTo; ?>">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default DATE_BTTN" type="button"><i class="fa fa-clock-o"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr> -->


                    <!--
                    <div class="form-group">
                    <label class="control-label col-md-3">Default Timepicker</label>
                    <div class="col-md-4">
                    <div class="input-group bootstrap-timepicker">
                    <input type="text" class="form-control timepicker-default">
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
                </span>
            </div>
        </div>
    </div>
-->


    <tr>
    <td>
    <label>Way Point Charge</label>
</td>
<td>
<input type="number" min="0" value="<?php echo $val->wayPoint_charge; ?>" id="wayPoint_charge" name="wayPoint_charge"></input>
</td>
</tr> 
<!--            <tr>
<td>
<label>Date Created</label>
</td>
<td>
<?php echo $d = date('d-M-Y g:i a',strtotime($val->date_created)); ?>
</td>
</tr> -->
</tbody>
<?php $i++;
}
?>
</table>
<br>
<button onclick="editSettings(this)" class="btn btn-info" data-userid="<?php echo $val->id; ?>">Update</button>
</div>
</div>
</section>
</div>
</div>
</section>
</section>
<script type="text/javascript">
function editSettings(argument) {
    var id = $(argument).attr('data-userid');
    var minBooking_charge = $("#rowData" + id).find("#minBooking_charge").val();
    var driverCancellation_charge = $("#rowData" + id).find("#driverCancellation_charge").val();
    var userCancellation_hours = $("#rowData" + id).find("#userCancellation_hours").val();
    var admin_commission = $("#rowData" + id).find("#admin_commission").val();
    var promoReferer_amount = $("#rowData" + id).find("#promoReferer_amount").val();
    var promoUser_amount = $("#rowData" + id).find("#promoUser_amount").val();
    var wayPoint_charge = $("#rowData" + id).find("#wayPoint_charge").val();
    var PeakHourCharge = $("#rowData" + id).find("#PeakHourCharge").val();
    var peakHrFRom = $("#rowData" + id).find("#peakHrFRom").val();
    var peakHrTo = $("#rowData" + id).find("#peakHrTo").val();
    // console.log(promo_code);
    // console.log(value);
    // console.log(type);
    // console.log(wayPoint_charge);return false;
    $.ajax({
        type: "POST",
        url: "editSettings",
        dataType: "json",
        data: {
            id: id,
            minBooking_charge: minBooking_charge,
            driverCancellation_charge: driverCancellation_charge,
            userCancellation_hours: userCancellation_hours,
            admin_commission: admin_commission,
            promoReferer_amount: promoReferer_amount,
            promoUser_amount: promoUser_amount,
            wayPoint_charge: wayPoint_charge,
            PeakHourCharge: PeakHourCharge,
            peakHrFRom: peakHrFRom,
            peakHrTo: peakHrTo
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
            $("#rowData" + id).find("#minBooking_charge").val(data.data[0].minBooking_charge);
            $("#rowData" + id).find("#driverCancellation_charge").val(data.data[0].driverCancellation_charge);
            $("#rowData" + id).find("#userCancellation_hours").val(data.data[0].userCancellation_hours);
            $("#rowData" + id).find("#admin_commission").val(data.data[0].admin_commission);
            $("#rowData" + id).find("#promoReferer_amount").val(data.data[0].promoReferer_amount);
            $("#rowData" + id).find("#promoUser_amount").val(data.data[0].promoUser_amount);
            $("#rowData" + id).find("#wayPoint_charge").val(data.data[0].wayPoint_charge);
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
</script>
<div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo base_url(); ?>Public/img/demo_wait.gif' width="64" height="64" />
    <br>Processing...</div>
    <!-- <script src="<?php echo base_url();?>Public/js/advanced-form-components.js"></script> -->
