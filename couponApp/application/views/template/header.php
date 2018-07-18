<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico');?>">
    <title>Pendulum Points</title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url("assets/css/bootstrap.min.css");?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/css/bootstrap-reset.css")?>" rel="stylesheet">
    <!--external css-->


    
    <link href="<?php echo base_url("assets/assets/font-awesome/css/font-awesome.css")?>" rel="stylesheet" />
    <link href="<?php echo base_url("assets/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css")?>" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" href="<?php echo base_url("assets/css/owl.carousel.css")?>" type="text/css">
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url("assets/css/style.css")?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/css/style-responsive.css")?>" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/imgareaselect/0.9.10/css/imgareaselect-default.css">



    <style type="text/css">


.canvasjs-chart-credit {
    display: none;
}


    body{
  font-sze:14px;
}

.container{
 max-width:960px;
  margin:0 auto;
}
nav ul li{
  list-style:none;
  float:left;
  padding-right:20px;
}
nav ul li a{
  text-decoration:none;
  color:#222;
  background-color:#ccc;
  padding:4px 5px;
}
.active{
  background-color:#d90000;
  color:#fff;

}

 

</style>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <section id="container" >
      <!--header start-->
      <header class="header white-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <a href="<?php echo base_url('Admin'); ?>" class="logo"><span>Welcome To Pendulum App Dashboard</span></a>
        
            <div class="top-nav ">
                <ul class="nav pull-right top-menu">
<!-- 
                          <li class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li><a href="<?php echo base_url("Logout")?>"><i class="fa fa-key"></i> Log Out</a></li>
                        </li>


                    <li>
                        <!-- <input type="text" class="form-control search" placeholder="Search"> -->
                    <!-- </li>  -->
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false">
                            <!-- <img alt="" src="img/avatar1_small.jpg"> -->
                            <span class="username">Admin</span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li><a href="<?php echo base_url("Logout")?>"><i class="fa fa-key"></i> Log Out</a></li>
                            <li><a href="<?php echo base_url('Admin/changepassword')?>"><i class="fa fa-cog"></i>Change Password</a></li>
                            <!-- <li><a href="#"><i class="fa fa-bell-o"></i> Notification</a></li>
                            <li><a href="<?php echo base_url("Admin/logout")?>"><i class="fa fa-key"></i> Log Out</a></li> -->
                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
                <!--search & user info end-->
            </div>
        </header>