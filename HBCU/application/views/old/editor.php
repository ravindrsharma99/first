<section id="main-content">
  <section class="wrapper">
    <?php if($this->session->flashdata('msg')): ?>
      <div class="alert alert-danger  alert-block fade in">
        <button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>
        <h4><i class="fa fa-ok-sign"></i><?php echo $this->session->flashdata('msg'); ?></h4>
      </div> 
    <?php endif; ?> 
    <div class="row">
      <div class="col-lg-12">
        <section class="panel">                  
               <header class="panel-heading"> <?php echo $name; ?> </header>              
          <div class="panel-body">
              <div class="form">
              <!-- <form class="cmxform form-horizontal tasi-form" id="AddJobType" name="AddJobType" method="post" action=""> -->

             <form class="form-horizontal" action="" method="post">
             
             <?php 
             $col = ($columns -2);
             $num  = floor($col/2);
             
             	for ($i = 1;$i <= $num;$i++) {

             	// print_r($key);
 ?>	
              <div class="form-group">
                  <label for="inputPassword1" class="col-lg-2 col-sm-2 control-label">QUESTION<?php echo $i;?></label>
                  <div class="col-lg-5">
                      <input type="text" name="question<?php echo $i;?>" value="<?php print_r($data->question.$i);?>" class="form-control" id="inputPassword1" placeholder="question<?php echo $i;?>">
                  </div>
              </div>

      
                <div class="form-group">
                  <label class="col-sm-2 control-label col-sm-2">ANSWER<?php echo $i;?></label>
                  <div class="col-sm-10">
                      <textarea class="form-control ckeditor" value="<?php print_r($data->answer.$i);?>" name="answer<?php echo $i;?>" placeholder = "answer<?php echo $i;?>" rows="50"></textarea>
                      <!-- <input type="hidden" name="type" value="<?php //echo $name ?>"> -->
                  </div>
              </div>
  	<?php 
            } ?>
                <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">                    
                    <button type="submit"  name="Submit" class="btn btn-danger">Update</button> 
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

<script src="https://globalfitness.com/public/assets/ckeditor/ckeditor.js" ></script>