
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
   <button type="button"onclick="document.getElementById('categoryId').focus(); return false;">Add more</button>
   <a href = "listSubCategories"> <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
 Back to List</a>
   </div>
                          <header class="panel-heading">
                            Add SubCategory
                          </header>
                          <div class="panel-body">

                         <form role="form" name="add_subcategory" method="POST" action="add_subcategory" enctype="multipart/form-data">                                
                         <div class="form-group col-md-12">
                                <label for="selectbox">Select Category</label>
                                  <select class="form-control" id="categoryId" name = "categoryId">
                              <?php    foreach($data1 as $opts)  {?>
                                    <option><?php echo $opts->categoryName; ?></option>
                       
                                    <?php }?>
                                  </select>
                                </div>

                                  <div class="form-group col-md-6">
                                      <label for="exampleInputEmail1">Name</label>
                                      <input type="subcategory" class="form-control" id="subCategoryName" name ="subCategoryName" placeholder="Enter Sub Category" required>
                                  </div>
                                          <div class="form-group col-md-6">
                                      <label for="exampleInputFile">Base Price</label>
                                         <input type="base_price" class="form-control hi" id="base_price" name ="base_price" placeholder="Enter Base price" maxlength="15">
                         <!--              <p class="help-block">Example block-level help text here.</p>
 -->                                  </div>
                         <!--          <div class="form-group">
                                      <label for="exampleInputPassword1">Password</label>
                                      <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                  </div> -->
                                  <div class="form-group col-md-6">
                                      <label for="exampleInputFile">Image</label>
                                      <input type="file" id="imagename" name="imagename" required="">
                         <!--              <p class="help-block">Example block-level help text here.</p>
 -->                                  </div>

                                  


                                 <!--  <div class="form-group col-md-6">
                                <label for="selectbox">Fare Calculation Type</label>
                                  <select class="form-control" id="jobType" name = "jobType">
                              
                                     <option value = 1>Distance</option>
                                     <option value = 2>Hourly</option>
                                                       
                                  </select>
                                </div> -->
                       

                                <div class="form-group col-lg-12 col-sm-12 hi "  style="float:left;">
                                    <label for="exampleInputEmail2">Charge</label>
                                </div>
                                <div class="form-group col-md-6 ">
                                  <input type="text" class="form-control hi" id="kmCharge" name ="kmCharge" placeholder="Charge per km" maxlength="15">
                                </div>
                                <div class="form-group col-md-6">
                                  <input type="text" class="form-control hi" id="hourlyCharge" name ="hourlyCharge" placeholder="Charge per Hour" maxlength="15">
                                </div>
                                 
                                 <div class="form-group col-md-6">
                                    <button type="submit" name = "add_sub" class="btn btn-info SUBMIT_BUtton">Submit</button>
                                </div>
                                  
                              </form>

                          </div>
                      </section>
                  </div>
                  </div>
                  </section>
                  </section>
    <!--               <script type="text/javascript">
          $('.form-control').keypress(function(eve) {
  if ((eve.which != 46 || $(this).val().indexOf('.') != -1) && (eve.which < 48 || eve.which > 57) || (eve.which == 46 && $(this).caret().start == 0) ) {
    eve.preventDefault();
  }
     
// this part is when left part of number is deleted and leaves a . in the leftmost position. For example, 33.25, then 33 is deleted

});
                  </script> -->
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

