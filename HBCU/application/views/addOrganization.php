<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
  <div >
      </div>
                    
                    <?php 
                      if ($this->session->flashdata('msg')==true) { ?>
                        <div class="alert alert-success alert-block fade in">
                            <button type="button" class="close close-sm" data-dismiss="alert">
                                <i class="fa fa-times"></i>
                            </button>
                            <h4>
                                <i class="fa fa-ok-sign"></i>
                                <?php echo $this->session->flashdata('msg'); ?>
                            </h4>
                        </div>
                      <?php } elseif($this->session->flashdata('msg')=='0') { ?>
                        <div class="alert alert-block alert-danger fade in">
                            <button type="button" class="close close-sm" data-dismiss="alert">
                                <i class="fa fa-times"></i>
                            </button>
                            <strong>Already Exist!</strong> Change promocode and try submitting again.
                        </div>
                      <?php }
                      
                    ?>
                    <div class="panel-body">
                      <h3>Add Orgazination</h3><br>
                       <form role="form" method='POST' class="form-horizontal" enctype="multipart/form-data">
                          <div class="form-group">
                              <label class="col-lg-2 col-sm-2 control-label" for="promocode">Title</label>
                              <div class="col-lg-10">
                                  <input type="text" placeholder="Title" id="title" name="title" class="form-control" required>
                              </div>
                          </div>


                          <div class="form-group hi">
                              <label class="col-lg-2 col-sm-2 control-label" for="value">Logo</label>
                              <div class="col-lg-10">
                                  <input type="file" placeholder="logo" id="logo" name='logo' class="form-control"  required>
                              </div>
                          </div>


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
<script type="text/javascript">
 
     // $('#expiry_date').datetimepicker({  minDate:Date()});
$(document).ready (function (){

 var ab = new Date();

 $("#expiry_date").datetimepicker('setStartDate', ab);

  });

</script>
<!--   <script type="text/javascript">
                    $(function(){
      
  $('.hi').keyup(function(e) {
        if(this.value!='-')
          while(isNaN(this.value))
            this.value = this.value.split('').reverse().join('').replace(/[\D]/i,'')
                                   .split('').reverse().join('');
    })
    .on("cut copy paste",function(e){
      e.preventDefault();
    });

});
                  </script> -->


