<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>KudosFind</title>
    <link href="<?php echo base_url();?>Public/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>Public/css/custom.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <!--ServiceDashboard content start-->
    <section id="Service_provider_page">
        <div class="container-fluid">
            <div class="magn_none">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="login-page">
                      <div class="form">
                        <div class="HEADing_tittle_penal">
                          <div class="HEADing_tittle"><img class="img-responsive" src="<?php echo base_url();?>Public/img/SERlogoicon.png"></div>
                          <h2 class="HEDing">KudosFind</h2>
                        </div>
                        <?php 
                        if ($this->session->flashdata('msg')!='') { ?>
                          <div class="alert alert-success alert-dismissable dPage">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                          <?php
                            echo $this->session->flashdata('msg'); 
                          ?>
                          </div>
                        <?php }elseif ($this->session->flashdata('error')!='') {?>
                          <div class="alert alert-danger alert-dismissable dPage">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                          <?php
                            echo $this->session->flashdata('error'); 
                          ?>
                          </div>
                        <?php
                        } 
                        ?>
                        <div class="row BOXXXO">      
                             <div class="col-md-12 col-sm-12 col-lg-12">
                              <h3 class="HEDing_inner">Singaporeans are looking for your services everyday</h3>
                              <p class="Pargraph">Fill in your details and we'll contact you to conduct a quick business verification before your profile can be activated. This may take up to a few weeks depending on availability of spaces.</p>
                             </div>            
                        </div>

                        <form class="login-form" method="Post" action = "<?php echo base_url('ServiceProviders/next');?>" enctype="multipart/form-data">
                          <h3 class="HEDing_inner_small">Tell us what you do</h3>
                                              <select class="SELECT_BOx" id="combo" name="cat">
                           <option selected>Select Category</option>
                          <?php  $i =1;
                            foreach($catData as $opts)  {
                              
                              ?>
                                    <option value = "<?php echo $opts->id; ?>" name ="<?php echo $opts->id; ?>">
                                    <?php echo $opts->categoryName; ?></option>
                       
                                    <?php  $i++;
                                  }
                                    ?>
                          </select> 
                          <button type = "submit" disabled id="submit-button" name = "submit" >Next</button>

                         
                        </form>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--ServiceDashboard content end-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo base_url();?>Public/js/jquery.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url();?>Public/js/bootstrap.js"></script>
<script type="text/javascript">

$(document).ready(function() {
   // Executed when select is changed
    $("select").on('change',function() {
        var x = this.selectedIndex;
        if (x == "") {

           $("#submit-button").attr('disabled',true);
        } else {
           $("#submit-button").attr('disabled',false);
        }
    });
    
    // It must not be visible at first time
    // $("#submit-button").css("display","none");
});
</script>
<!--     <script type="text/javascript">
$(document).ready(function(){


$(".SELECT_BOx").change(function() {
var selected = $(this).children(":selected").text();
var value = $('#combo :selected').val();

//if (value == 1){
$(".login-form").attr('action', 'next');
$(".login-form").attr('id', value);

}else if(value == 2){
$(".login-form").attr('action', 'electrician_signup');

}else{
$(".login-form").attr('action', '#');
}
});
      });
    </script> -->
</body>

</html>
