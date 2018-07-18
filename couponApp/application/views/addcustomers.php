
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->


              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel col-lg-12">




              <?php if ($this->session->flashdata('msg')!='') { ?>
              <div class="alert alert-danger alert-dismissable">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <?php
              echo $this->session->flashdata('msg');
              ?>
              </div>
              <?php } ?>



                          <header class="panel-heading">
                             Add Retailers
                          </header>
                          <div class="panel-body">
                              <div class="form align">
                                  <form class="cmxform form-horizontal tasi-form type_box_lab" id="signupForm" method="post" action="<?php echo base_url("Admin/addCustomer")?>" enctype="multipart/form-data" >
                                      <div class="form-group ">
                                            <label for="firstname" class="control-label">Name</label>
                                              <input class=" form-control"  name="name" type="text" placeholder="Enter Name" required="" />
                                      </div>
                                      <div class="form-group ">
                                            <label for="firstname" class="control-label">Email</label>
                                              <input class=" form-control"  name="email" type="text" placeholder="Enter Email" required="" />
                                      </div>


                                             <div class="form-group ">
                                            <label for="firstname" class="control-label">Profile Image</label>
                                              <input class=" form-control"  name="profilePic" type="file" placeholder="Enter Email" required="" />
                                      </div>


                                      <div class="form-group ">
                                            <label for="firstname" class="control-label">Phone </label>
                                              <input class=" form-control"  name="phoneNo" type="text" placeholder="Enter phone" required="" />
                                      </div>



                                  




                                      <div class="form-group">
                                              <button class="btn btn-success submit" name="addedCustomer" type="submit">Submit</button>

                                      </div>
                                  </form>
                              </div>
                          </div>
                      </section>
                  </div>
              </div>
              <!-- page end-->
          </section>
      </section>
<?php include('template/footer.php') ?>