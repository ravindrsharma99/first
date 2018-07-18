<link href="<?php echo base_url();?>Public/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>Public/css/owl.carousel.css" type="text/css">
<!--main content start-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!--state overview start-->
        <div class="row state-overview">
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <section class="panel">
                    <div class="symbol terques">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="value">
                        <h1 class="couxnt">
                                 <?php echo count($all_users); ?>
                              </h1>
                        <p>All Users</p>
                    </div>
                </section>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <section class="panel">
                    <div class="symbol red">
                        <i class="fa fa-tags"></i>
                    </div>
                    <div class="value">
                        <h1 class=" couxnt">
                                <?php echo count($login_users); ?>
                              </h1><!-- get_login_user -->
                        <p>Login Users</p>
                    </div>
                </section>
            </div>
            <!-- <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <section class="panel">
                    <div class="symbol red">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="value">
                        <h1 class=" couxnt">
                                <?php // echo count($distance); ?>
                              </h1>
                        <p>Distance Based</p>
                    </div>
                </section>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <section class="panel">
                    <div class="symbol red">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="value">
                        <h1 class=" couxnt">
                                <?php // echo count($hourly); ?>
                              </h1>
                        <p>Hourly Based</p>
                    </div>
                </section>
            </div> -->
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <!--pie chart start-->
                <section class="panel">
                    <div class="dash_board pDD_Bot">
                        <div id="piexhart" style="height:400px"></div>
                        <!--pie chart start-->
                    </div>
                </section>
            </div>
        </div>
        <!--state overview end-->
    </section>
</section>
<!--main content end-->
<?php
// print_r($electrician);die();
$ch_data = $ch_data . "['Spare Change'," . 345 . "],";
$ch_data = $ch_data . "['Reoccurring'," . 545 . "],";
$ch_data = $ch_data . "['One-Time'," . 3434 . "],";

$ch_data = rtrim($ch_data, ',');
 // print_r($ch_data); die;
?>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script type="text/javascript">
    Highcharts.chart('piexhart', {
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Total %Users',
            data: [

                <?php  echo $ch_data; ?>

                // ['Firefox', 45.0],
                // ['IE', 26.8],

                // ['Safari', 8.5],
                // ['Opera', 6.2],
                // ['Others', 0.7]
            ]
        }]
    });
    </script>
