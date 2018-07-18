<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Add membership
                    </header>
                    <?php 
                      if ($this->session->flashdata('msg')=='1') { ?>
                        <div class="alert alert-success alert-block fade in">
                            <button type="button" class="close close-sm" data-dismiss="alert">
                                <i class="fa fa-times"></i>
                            </button>
                            <h4>
                                <i class="fa fa-ok-sign"></i>
                                Success!
                            </h4>
                            <p>membership Added Successfully...</p>
                        </div>
                      <?php } elseif($this->session->flashdata('msg')=='0') { ?>
                        <div class="alert alert-block alert-danger fade in">
                            <button type="button" class="close close-sm" data-dismiss="alert">
                                <i class="fa fa-times"></i>
                            </button>
                            <strong>Already Exist!</strong> Change membership and try submitting again.
                        </div>
                      <?php }
                      
                    ?>
                    <div class="panel-body">
                       <form role="form" method='POST' class="form-horizontal">
                          <div class="form-group">
                              <label class="col-lg-2 col-sm-2 control-label" for="membership">membership</label>
                              <div class="col-lg-10">
                                  <input type="text" placeholder="" id="membership" name="membership" class="form-control" required>
                                  <p class="help-block">Example kudos VIP</p>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-lg-2 col-sm-2 control-label" for="value">Validity</label>
                              <div class="col-lg-10">
                                  <input type="number" placeholder="In days" id="validity" name='validity' class="form-control" required>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-lg-2 col-sm-2 control-label" for="value">Price</label>
                              <div class="col-lg-10">
                                  <input type="number" placeholder="price" id="price" name='price' class="form-control" required>
                              </div>
                          </div>
                          <input type="hidden" name='addedOn' value="<?php echo(date('Y-m-d H:i:s')); ?>">
                          <div class="form-group">
                              <div class="col-lg-offset-2 col-lg-10">
                                  <button class="btn btn-success" type="submit">Save</button>
                              </div>
                          </div>
                      </form>
                    </div>
                </section>
            </div>
        </div>
    </section>
</section>




