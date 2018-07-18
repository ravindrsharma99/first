      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                      <?php 
                      // echo "<pre>";
                      // print_r($data);
                      // echo "</pre>";
                      ?>
                  
                  <aside class="profile-info col-lg-12">
                      <section class="panel">
                          <div id="map" class="gmaps"></div>

                          <footer class="panel-footer">
                              <p>Service Providers</p>
                          </footer>
                      </section>
                  </aside>
              </div>
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->


    <!--script for this page only-->
    <script>

    var marker;
var markersA = [];
var markersA2 = [];
var markersA3 = [];
var otm=0;
var fit = 0;
      function initMap() {

        //create empty LatLngBounds object
        var bounds = new google.maps.LatLngBounds();
        var loc = {lat: 20.5937, lng: 78.9629};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 3,
          center: loc
        });

        
    function DeleteMarkers2() {
      // console.log(markersA2);
      //Loop through all the markers and remove
      for (var i = 0; i < markersA2.length; i++) {
          markersA2[i].setMap(null);
      }
      markersA2 = [];
      markers2();
      // mapNotifications();
    };
    function markers2(){

      // alert("uidhsfiuh");
      $.ajax({
          type: "GET",
          url: "providersPosition",
          data: '',
          dataType: "json", // Set the data type so jQuery can parse it for you
          success: function (data) {
            var count = data.length;
              for (var i = 0; i < data.length; i++) {
                // console.log(data[i]["longitude"]);
                var marker = new google.maps.Marker({
                  map: map,
                  draggable: false,
                  icon: "http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld="+data[i]["id"]+"|FE7569|000000",
                  title: "#"+data[i]["id"]+", Name:"+data[i]["fname"]+' '+data[i]["lname"],
                  // animation: google.maps.Animation.DROP,
                  // url: "http://phphosting.osvin.net/aberback/Admin/Dashboard/profile/"+data[i]["id"],
                  position: {lat: parseFloat(data[i]["latitude"]), lng: parseFloat(data[i]["longitude"])}
                  // position: {lat: 35.7009855, lng: 51.3518852}
                });
                // google.maps.event.addListener(marker, 'click', (function(marker, i) {
                //     return function() {
                //         // window.location.href = marker.url;
                //         window.open(marker.url,'Profile');
                //     }
                // })(marker, i));
                markersA2.push(marker);
                //extend the bounds to include each marker's position
                /*bounds.extend(marker.position);
                console.log(i);
                  console.log(count);
                  console.log(fit);

                if (i==count-1 && fit==0) {
                  console.log(count);
                  var fit = 1;
                  map.fitBounds(bounds);
                };*/
                //now fit the map to the newly inclusive bounds
              }
              
              // console.log(count);
              $("#count").html(count+" Available Drivers");
          }
      });
    }

    var myVar2 = setInterval(function(){ DeleteMarkers2() }, 3000);
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7gXc5t6ToETjPlSBLsh_gqL36niD47n8&callback=initMap">
    </script>
 