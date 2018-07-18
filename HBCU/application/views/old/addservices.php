
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
   <button type="button"onclick="document.getElementById('categoryIdServices').focus(); return false;">Add more</button>
   <a href = "listServices"> <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
 Back to List</a>
   </div>
                          <header class="panel-heading">
                            Add Services
                          </header>
                          <div class="panel-body">

                         <form role="form" name="add_services" method="POST" action="add_services" enctype="multipart/form-data">                                
                         <div class="form-group col-md-12">
                                <label for="selectbox">Select Category</label>
                                  <select class="form-control" id="categoryIdServices" name = "category_id">
                                  <option>Select Category </option>
                              <?php 
                                 foreach($dataCat as $opts)  {?>
                                    <option value = "<?php echo $opts->id; ?>"><?php echo $opts->categoryName; ?></option>
                       
                                    <?php 
                                  
                                    }?>
                                  </select>
                                </div>

                                <div class="form-group col-md-12">
                                <label for="selectbox">Select SubCategory</label>
                                  <select class="form-control" id="new_select" name = "subCategory_id">
                                   <option>Select SubCategory</option>
                                  </select>
                                </div>

                                  <div class="form-group col-md-12">
                                      <label for="exampleInputEmail1">Service Title</label>
                                      <input type="text" class="form-control" id="ServiceTitle" name ="ServiceTitle" placeholder="Enter Title" required>
                                  </div>
                         
                                   <div class="form-group col-md-12">
                                   <label for="exampleInputEmail1">Service Type</label>
                                  <select class="form-control" id="new_select" name = "ServiceType">
                                   <option>Type</option>
                                   <option value = "1">Per Hour</option>
                                   <option value = "2">Per Item</option>
                                   <option value = "3">Per Distance</option>
                                   <option value = "4">Fixed</option>
                                  </select>
                                  </div>

                                  <div class="form-group col-md-12">
                                <label for="selectbox">Price</label>
                                   <input type="text" class="form-control hi" id="price" name ="price" placeholder="Enter Price" maxlength="15" required>
                                </div>


                         <!--        <div class="form-group col-lg-12 col-sm-12" style="float:left;">
                                    <label for="exampleInputEmail2">Charge</label>
                                </div>
                                <div class="form-group col-md-6 ">
                                  <input type="text" class="form-control" id="kmCharge" name ="kmCharge" placeholder="Charge per km">
                                </div>
                                <div class="form-group col-md-6">
                                  <input type="text" class="form-control" id="hourlyCharge" name ="hourlyCharge" placeholder="Charge per Hour">
                                </div> -->
                                 
                                 <div class="form-group col-md-12">
                                    <button type="submit" name = "add_service" class="btn btn-info SUBMIT_BUtton">Submit</button>
                                </div>
                                  
                              </form>

                          </div>
                      </section>
                  </div>
                  </div>
                  </section>
                  </section>
                    <script type="text/javascript">
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
                  </script>
 
