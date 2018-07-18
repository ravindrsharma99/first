
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
 
                          <header class="panel-heading">
                            <?php  print_r($page_title); ?>
                          </header>
                          <div class="panel-body">

                         <form role="form" method="POST" enctype="multipart/form-data">                                
                         <div class="form-group col-md-12">
                                <label for="selectbox">Title</label>
                            <input type ="text" class="form-control" name ="title" ></input>
                                </div>

                            <div class="form-group col-md-12">
                                <label for="selectbox">Title Description</label>
                            <input type ="text" class="form-control" name ="TitleDesciption" ></input>
                                </div>
                                <div class="form-group col-md-12">
                                <label for="selectbox">Section Heading1</label>
                            <input type ="text" class="form-control" name ="SectionHeading1" ></input>
                                </div>
                                <div class="form-group col-md-12">
                                <label for="selectbox">Section Description1</label>
                            <input type ="text" class="form-control" name ="SectionDescription1" ></input>
                                </div>
                                <div class="form-group col-md-12">
                                <label for="selectbox">Section Heading2</label>
                            <input type ="text" class="form-control" name ="SectionHeading2" ></input>
                                </div>
                                <div class="form-group col-md-12">
                                <label for="selectbox">Section Description2</label>
                            <input type ="text" class="form-control" name ="SectionDescription2" ></input>
                                </div>
                                <div class="form-group col-md-12">
                                <label for="selectbox">Section Heading3</label>
                            <input type ="text" class="form-control" name ="SectionHeading3" ></input>
                                </div>
                                
                                  <div class="form-group col-md-12">
                                <label for="selectbox">Section Description3</label>
                            <input type ="text" class="form-control" name ="SectionDescription3" ></input>
                                </div>
                                
                                  <div class="form-group col-md-12">
                                <label for="selectbox">Section Heading4</label>
                            <input type ="text" class="form-control" name ="SectionHeading4" ></input>
                                </div>
                                
                                  <div class="form-group col-md-12">
                                <label for="selectbox">Section Description4</label>
                            <input type ="text" class="form-control" name ="SectionDescription4" ></input>
                                </div>
        <!--                         
                                    <div class="form-group col-md-12">
                                  <label for="selectbox">Client Heading</label>
                              <input type ="text" class="form-control" name ="ClientHeading" ></input>
                                  </div>
                                  <div class="form-group col-md-12">
                                  <label for="selectbox">Client Image</label>
                              <input type ="file" name ="ClientImage" ></input>
                                  </div>
                                  <div class="form-group col-md-12">
                                  <label for="selectbox">Client Comment</label>
                              <input type ="text" class="form-control" name ="ClientComment" ></input>
                                  </div>
                                  <div class="form-group col-md-12">
                                  <label for="selectbox">Client Name</label>
                              <input type ="text" class="form-control" name ="ClientName" ></input>
                                  </div> -->
                             
                                  <div class="custom_btnss">
                                  <button type="submit" name="submit">Update</button>
                                  <a href = "http://kudosfind.com/" target = "blank"> <i class="fa fa-long-arrow-left" aria-hidden="true"></i>Preview</a>
                                  </div>
                                  
                              </form>

                          </div>
                      </section>
                  </div>
                  </div>
                  </section>
                  </section>
 
