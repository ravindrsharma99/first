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
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">
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
            <div class="row magn_none">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="login-page">
                        <div class="form">
                            <div class="HEADing_tittle_penal">
                                <div class="HEADing_tittle"><img class="img-responsive" src="<?php echo base_url();?>Public/img/SERlogoicon.png"></div>
                                <h2 class="HEDing">KudosFind</h2>
                            </div>
                            <div class="row BOXXXO">
                                <div class="col-md-12 col-sm-12 col-lg-12">
                                    <h3 class="HEDing_inner">Singaporeans are looking for your services everyday</h3>
                                    <p class="Pargraph">The services that you select will decide what job requests we will send to you, so please only select the services that you can and want to provide</p>
                                </div>
                            </div>
                            <form class="SERVICE_PROVider_next" method="post" action="Service_signup" enctype="multipart/form-data">
                     
                    <div class="col-md-12">
                      <fieldset>
                
                                    <?php 

                                    if(isset($_POST['submit'])){
// print_r($_POST); die;

                    $subCatData = $this->Admin_model->select_data('*','tbl_subCategory',array('category_id'=>$_POST['cat']));
                    $getType = $this->Admin_model->select_data('categoryType','tbl_categories',array('id'=>$_POST['cat']));

                                    $i = 1;
                            foreach($subCatData as $valueData){ ?>
                                <div class="checkbox checkbox-info BOXES_CHECK">
                                    <input id="checkbox<?php echo $i; ?>" type="checkbox" name ="subId<?php echo $valueData->id;?>" value = "<?php echo $valueData->id;?>" class="check">
                                    <label for="checkbox<?php echo $i; ?>"><?php echo $valueData->subCategoryName;?></label>
                                </div>
                            <?php $i++;
                             }
                             } ?>
                     <!--                    <div class="checkbox BOXES_CHECK">
                                            <input id="checkbox2" type="checkbox" checked="">
                                            <label for="checkbox2">House Cleaning</label>
                                        </div>
                                        <div class="checkbox checkbox-success BOXES_CHECK">
                                            <input id="checkbox3" type="checkbox">
                                            <label for="checkbox3">Mattress Cleaning</label>
                                        </div>
                                        <div class="checkbox checkbox-info BOXES_CHECK">
                                            <input id="checkbox4" type="checkbox">
                                            <label for="checkbox4">Moving In & Out / After Renovation / Thorough Cleaning</label>
                                        </div>
                                        <div class="checkbox checkbox-warning BOXES_CHECK">
                                            <input id="checkbox5" type="checkbox" checked="">
                                            <label for="checkbox5">Office / Commercial Cleaning</label>
                                        </div>
                                        <div class="checkbox checkbox-danger BOXES_CHECK">
                                            <input id="checkbox6" type="checkbox" checked="">
                                            <label for="checkbox6">Upholstery Cleaning</label>
                                        </div> -->
                      </fieldset>
                      <input id = "hVal" type = "hidden" value = "<?php echo $_POST['cat']; ?>">
                      <input id = "typeVal1" name="userType" type = "hidden" value = "<?php echo $getType[0]->categoryType; ?>">
                    </div>

                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="checkbox checkbox-info BOXES_CHECK">
                                        <input id="checkboxAll" type="checkbox" class="check" onchange="checkAll(this)">
                                        <label for="checkboxAll">Select All</label>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
     <button class="PROCESSED__button pull-right"   disabled='disabled' id = "hg" name = "submit">Proceed <i class="fa fa-arrow-right" aria-hidden="true"></i>
</button>
                                </div>
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
 function checkAll(ele) {

     var checkboxes = document.getElementsByTagName('input');
     if (ele.checked) {
         for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = true;
             }
         }
     } else {
         for (var i = 0; i < checkboxes.length; i++) {
             console.log(i)
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = false;
             }
         }
     }
 }


$(document).ready(function(){
  $('.check').change(function() {
      if ($('.check:checked').length) {
          $('#hg').removeAttr('disabled');
      } else {
          $('#hg').attr('disabled', 'disabled');
      }
  });

  $("#hg").click(function() {
    var PageId = document.getElementById("typeVal1").value;
  console.log(PageId); 
//  if(PageId ==1){

// /*$(".SERVICE_PROVider_next").attr('action', 'driver_signup');
// }else if(PageId ==2){

// $(".SERVICE_PROVider_next").attr('action', 'electrician_signup');
// }else{

//  $(".SERVICE_PROVider_next").attr('action', '#');
// }*/

// // var selected = $(this).children(":selected").text();
// // var value = $('#combo :selected').val();

//     if (value == 1){
//     $(".login-form").attr('action', 'driver_signup');

//     }else if(value == 2){
//     $(".login-form").attr('action', 'electrician_signup');

//     }else{
//     $(".login-form").attr('action', '#');
//     }
// };
      });
});

    </script>
</body>

</html>
