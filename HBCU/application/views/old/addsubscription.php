

        <section id="main-content">
          <section class="wrapper site-min-height">
           <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                                            <?php 
  if ($this->session->flashdata('msg')!='') { ?>
    <div class="alert alert-info danger-dismissable">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <?php
      echo $this->session->flashdata('msg'); 
    ?>
    </div>
  <?php } 
  ?>
  <div class="custom_btnss">
   <button type="button"onclick="document.getElementById('STitle').focus(); return false;">Add more</button>
   <a href = "listSubsciptions"> <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
 Back to List</a>
   </div>
                          <header class="panel-heading">
                            Add Driver Subscriptions
                          </header>
                          <div class="panel-body">

                         <form role="form" name="addSubscription" method="POST" action="addSubscription" enctype="multipart/form-data">                                

                    
                                  <div class="form-group col-md-12">
                                      <label for="exampleInputEmail1">SubscriptionTitle</label>
                                      <input type="text" class="form-control" id="STitle" name ="STitle" placeholder="Enter Title">
                                  </div>
                         

                                  <div class="form-group col-md-12">
                                      <label for="exampleInputEmail1">Amount</label>
                                      <input type="number" class="form-control" id="Samount" name ="Samount" placeholder="Enter Amount" onkeypress="return isNumberKey(event)>
                                  </div>
                         
                                   <div class="form-group col-md-12">
                                   <label for="exampleInputEmail1">Subscription Type</label>
                                  <select class="form-control" id="new_select" name = "SType">
                                   <option>Type</option>
                                   <option value = "0">Monthly</option>
                                   <option value = "1">Quarterly</option>
                                   <option value = "2">Half-Yearly</option>
                                   <option value = "3">Yearly</option>
                                  </select>
                                  </div>
                                 
                                 <div class="form-group col-md-12">
                                    <button type="submit" name = "addSubscription" class="btn btn-info SUBMIT_BUtton">Submit</button>
                                </div>
                                  
                              </form>

                          </div>
                      </section>
                  </div>
                  </div>
                  </section>
                  </section>
                  <script type="text/javascript">
$(document).ready(function(){
  function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
});
</script>
 
