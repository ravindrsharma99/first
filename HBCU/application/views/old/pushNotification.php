<section id="container" class="">
    <section id="main-content">
        <section class="wrapper site-min-height">
            <!-- page start-->
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Send Notification
                        </header>
                        <div class="panel-body">
                            <div class="adv-table">
                                <form action="pushNotification" method="post">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <div class="box_penal_cust">
                                                <input type="checkbox" name="client" value="atype" id="client"><b> Client</b>
                                                <br>
                                                <br>
                                                <input type="checkbox" name="driver" value="btype" id="driver"><b> Driver</b>
                                                <br>
                                                <br>
                                                <input type="checkbox" name="all" value="alltype" id="all"><b> Select all</b>
                                                <br>
                                                <br>
                                                <!--<div class="funkyradio">
                                                        <div class="funkyradio-default">
                                                            <input type="radio" name="client" value="atype" id="client" />
                                                            <label for="radio1">Client</label>
                                                        </div>
                                                        <div class="funkyradio-primary">
                                                            <input type="radio" name="driver" id="driver" value="btype" checked/>
                                                            <label for="radio2">Driver</label>
                                                        </div>
                                                        <div class="funkyradio-success">
                                                            <input type="radio" name="all" value="alltype" id="all" />
                                                            <label for="radio3">Select All</label>
                                                        </div>
                                                    </div> -->
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Title</label>
                                            <input class="form-control input" name="title" id="title" placeholder="Title" required></input>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Message</label>
                                            <textarea class="form-control textarea" rows="3" name="message" id="Message" placeholder="Message" required maxlength='200'></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <input class="btn btn-info" type="submit" name="send" value="Submit">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </section>
</section>
<script type="text/javascript">
$(document).ready(function() {
    $('#all').bind('change', function() {
        // console.log(this);
        $('#client').removeAttr('checked');
        $('#driver').removeAttr('checked');

    });
    $('#client').bind('change', function() {
        // console.log(this);
        $('#all').removeAttr('checked');
        $('#driver').removeAttr('checked');

    });
    $('#driver').bind('change', function() {
        // console.log(this);
        $('#client').removeAttr('checked');
        $('#all').removeAttr('checked');

    });
});
</script>
