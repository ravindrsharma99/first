
      <!--header end-->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper dashboard-full">
              <!--state overview start-->
              <div class="row state-overview">
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol terques">
                              <img src="<?php echo base_url("assets/apidata/dash_retailers.png")?>" class="img-responsive" />
                          </div>
                          <div class="value">
                              <h1 class="">
                                  <?php print_r($retailer); ?>
                              </h1>
                              <p>Total Retailer</p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol red">
                              <img src="<?php echo base_url("assets/apidata/dash_list.png")?>" class="img-responsive" />
                          </div>
                          <div class="value">
                              <h1 class=" ">
                                  <?php print_r($customer); ?>
                                  
                              </h1>
                              <p>Total Customer</p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol yellow">
                              <img src="<?php echo base_url("assets/apidata/dash_store.png")?>" class="img-responsive" />
                          </div>
                          <div class="value">
                              <h1 class=" ">
                                  <?php print_r($store); ?>
                                  
                              </h1>
                              <p>Total Store places</p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol blue">
                              <img src="<?php echo base_url("assets/apidata/dash_deal.png")?>" class="img-responsive" />
                          </div>
                          <div class="value">
                              <h1 class="">
                                  <?php print_r($deal); ?>
                                
                              </h1>
                              <p>Total Deals</p>
                          </div>
                      </section>
                  </div>
              </div>

<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">

</header>
<div class="panel-body">
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
</div>
</section>
</div>
</section>










      </section>
      <?php include('template/footer.php') ?>




    <script>
    window.onload = function() {
    var dataPoints = [];
    var dataPoints1 = [];
    var dataPoints2 = [];
    var dataPoints3 = [];
    var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    theme: "light2",
    title: {
    text: "Report",
    fontSize: 22
    },
    axisX: {
    valueFormatString: "DD MMM,YY"
    },
    axisY: {
    title: "",
    titleFontSize: 24
    },
    data: [{
    name: "Login",
    type: "spline",
    yValueFormatString: "#,### Total users Created",
    showInLegend: true,
    dataPoints: dataPoints
    },
    {
    name: "Total",
    type: "spline",
    yValueFormatString: "#,### Total Logged in users",
    showInLegend: true,
    dataPoints: dataPoints1
    },
    {
    name: "Store places",
    type: "spline",
    yValueFormatString: "#,### Total store places",
    showInLegend: true,
    dataPoints: dataPoints2
    },
    {
    name: "Store deals",
    type: "spline",
    yValueFormatString: "#,### Total store deals",
    showInLegend: true,
    dataPoints: dataPoints3
    }]
    });
    chart.render();
    function addData(data) {
    for (var i = 0; i < data.length; i++) {
    dataPoints.push({
    x: new Date(data[i].datee),
    y: data[i].units
    });
    }
    chart.render();
    }
    function addData1(data) {
    for (var i = 0; i < data.length; i++) {
    dataPoints1.push({
    x: new Date(data[i].datee),
    y: data[i].units
    });
    }
    chart.render();
    }
    function addData2(data) {
    for (var i = 0; i < data.length; i++) {
    dataPoints2.push({
    x: new Date(data[i].datee),
    y: data[i].units
    });
    }
    chart.render();
    }
    function addData3(data) {
    for (var i = 0; i < data.length; i++) {
    dataPoints3.push({
    x: new Date(data[i].datee),
    y: data[i].units
    });
    }
    chart.render();
    }
    $.getJSON("http://goachievenow.com/admin/Dashboard/spline/1", addData);
    $.getJSON("http://goachievenow.com/admin/Dashboard/spline/2", addData1);
    $.getJSON("http://goachievenow.com/admin/Dashboard/spline/3", addData2);
    $.getJSON("http://goachievenow.com/admin/Dashboard/spline/4", addData3);
    }
    </script>