<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="<?php echo base_url();?>/Public/img/ic_favicon.png">

    <title>HBCU</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>/Public/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/Public/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/Public/css/bootstrap-reset.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/Public/assets/bootstrap-datetimepicker/css/datetimepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/Public/assets/bootstrap-timepicker/compiled/timepicker.css" />
    <!--external css-->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <!--     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url();?>Public/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/Public/css/style-responsive.css" rel="stylesheet" />



  <script src="<?php echo base_url();?>Public/js/jquery.js"></script>
     <script type="text/javascript">
                    $(document).ready(function(){
                    $('#categoryIdServices').change(function () {
                    var catId = $(this).val();
                   // alert(catId);
             $.ajax(
                    {
                        type: 'post',
                        url: 'ajaxCall',
                        data: {catId: catId},
                        beforeSend: function () {
                            $(".loadermyli").show();
                        },
                        success: function (data) {
                           // alert(data);

                        document.getElementById("new_select").innerHTML=data;

                      // $('#new_select').html(data);
                      // $('#new_select').html(data);

                        }

                    });


                  });
                    });





                  </script>
</head>
