<style type="text/css">
.Label_penal {
    width: 50%;
    float: left;
}
</style>
<section id="main-content">
    <section class="wrapper site-min-height">
        <div class="container">
            <div class="col-lg-12 col-sm-12 col-md-12">
                <h3 class="text-center">Enable Permission Here</h3>
                <section class="panel">
                <?php 
                 if ($this->session->flashdata('msg')!='') { ?>
    <div class="alert alert-success alert-dismissable">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <?php
      echo $this->session->flashdata('msg'); 
    ?>
    </div>
  <?php } 
  ?>
                    <header class="panel-heading">
                        Update Permissions
                    </header>
                    <div class="panel-body">
                        <form role="form" method="POST" enctype="multipart/form-data" action=''>
                        <?php $chkVariable =unserialize($perdata[0]->tabName); ?>
                            <div class="row">
                           <!--  <input type="hidden" name="editId" value = "<?php echo $eId; ?>" /> -->
                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <label class="Label_penal">Customers</label>
                                    <div class="switch switch-square" data-on-label="<i class=' fa fa-ok'></i>" data-off-label="<i class='fa fa-remove'></i>">
                                        <input id = "chk1" name = "Customers" type="checkbox" <?php if ($chkVariable['Customers'] == 1) { echo "checked"; } ?>/>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <label class="Label_penal">Service Providers</label>
                                    <div class="switch switch-square" data-on-label="<i class=' fa fa-ok'></i>" data-off-label="<i class='fa fa-remove'></i>">
                                    <input id = "chk2" name = "serviceProviders" type="checkbox" <?php if ($chkVariable['serviceProviders'] == 1) { echo "checked"; } ?>/>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <label class="Label_penal">Category</label>
                                    <div class="switch switch-square" data-on-label="<i class=' fa fa-ok'></i>" data-off-label="<i class='fa fa-remove'></i>">
                                    <input id = "chk3" name = "Category" type="checkbox" <?php if ($chkVariable['Category'] == 1) { echo "checked"; } ?>/>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <label class="Label_penal">Sub Category</label>
                                    <div class="switch switch-square" data-on-label="<i class=' fa fa-ok'></i>" data-off-label="<i class='fa fa-remove'></i>">
                                    <input id = "chk4" name = "subCategory" type="checkbox" <?php if ($chkVariable['subCategory'] == 1) { echo "checked"; } ?>/>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <label class="Label_penal">SubCategory Services</label>
                                    <div class="switch switch-square" data-on-label="<i class=' fa fa-ok'></i>" data-off-label="<i class='fa fa-remove'></i>">
                                    <input id = "chk5" name = "subCategoryServices" type="checkbox" <?php if ($chkVariable['subCategoryServices'] == 1) { echo "checked"; } ?>/>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <label class="Label_penal">Requested Services</label>
                                    <div class="switch switch-square" data-on-label="<i class=' fa fa-ok'></i>" data-off-label="<i class='fa fa-remove'></i>">
                                    <input id = "chk6" name = "requestedServices" type="checkbox" <?php if ($chkVariable['requestedServices'] == 1) { echo "checked"; } ?>/>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <label class="Label_penal">Track Services</label>
                                    <div class="switch switch-square" data-on-label="<i class=' fa fa-ok'></i>" data-off-label="<i class='fa fa-remove'></i>">
                                    <input id = "chk7" name = "trackServices" type="checkbox" <?php if ($chkVariable['trackServices'] == 1) { echo "checked"; } ?>/>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <label class="Label_penal">Promocodes</label>
                                    <div class="switch switch-square" data-on-label="<i class=' fa fa-ok'></i>" data-off-label="<i class='fa fa-remove'></i>">
                                    <input id = "chk8" name = "Promocodes" type="checkbox" <?php if ($chkVariable['Promocodes'] == 1) { echo "checked"; } ?>/>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <label class="Label_penal">Membership</label>
                                    <div class="switch switch-square" data-on-label="<i class=' fa fa-ok'></i>" data-off-label="<i class='fa fa-remove'></i>">
                                    <input id = "chk9" name = "Membership" type="checkbox" <?php if ($chkVariable['Membership'] == 1) { echo "checked"; } ?>/>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <label class="Label_penal">Driver Subscriptions</label>
                                    <div class="switch switch-square" data-on-label="<i class=' fa fa-ok'></i>" data-off-label="<i class='fa fa-remove'></i>">
                                    <input id = "chk10" name = "driverSubscription" type="checkbox" <?php if ($chkVariable['driverSubscription'] == 1) { echo "checked"; } ?>/>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <label class="Label_penal">Send Notifications</label>
                                    <div class="switch switch-square" data-on-label="<i class=' fa fa-ok'></i>" data-off-label="<i class='fa fa-remove'></i>">
                                    <input id = "chk11" name = "sendNotifications" type="checkbox" <?php if ($chkVariable['sendNotifications'] == 1) { echo "checked"; } ?>/>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <label class="Label_penal">Pay Service Providers</label>
                                    <div class="switch switch-square" data-on-label="<i class=' fa fa-ok'></i>" data-off-label="<i class='fa fa-remove'></i>">
                                    <input id = "chk12" name = "payServiceProviders" type="checkbox" <?php if ($chkVariable['payServiceProviders'] == 1) { echo "checked"; } ?>/>
                                    </div>
                                </div>
                                          <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <label class="Label_penal">Settings</label>
                                    <div class="switch switch-square" data-on-label="<i class=' fa fa-ok'></i>" data-off-label="<i class='fa fa-remove'></i>">
                                    <input id = "chk13" name = "Settings" type="checkbox" <?php if ($chkVariable['Settings'] == 1) { echo "checked"; } ?>/>
                                    </div>
                                </div>
                                          <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <label class="Label_penal">Edit Front Page</label>
                                    <div class="switch switch-square" data-on-label="<i class=' fa fa-ok'></i>" data-off-label="<i class='fa fa-remove'></i>">
                                    <input id = "chk14" name = "editFrontPage" type="checkbox" <?php if ($chkVariable['editFrontPage'] == 1) { echo "checked"; } ?>/>
                                    </div>
                                </div>
                            </div>
                            <div class="custom_btnss">
                            <button type="submit" name = "add_permission" class="btn btn-info SUBMIT_BUtton">Submit</button>
                            <a href = "<?php echo base_url(); ?>Dashboard/subAdmins" > <i class="fa fa-long-arrow-left" aria-hidden="true"></i>Back to List</a>
                            </div>
              
                     </form>
                    </div>
            </div>
            </section>
        </div>
        </div>
    </section>
</section>
<script src="<?php echo base_url();?>Public/js/bootstrap-switch.js"></script>
