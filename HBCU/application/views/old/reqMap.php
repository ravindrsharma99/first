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
                              <p>Requested Services</p>
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
      function initMap() {

        //create empty LatLngBounds object
        var bounds = new google.maps.LatLngBounds();
        var loc = {lat: 32.52465, lng: 72.524545};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 14,
          center: loc
        });

        
        <?php
        foreach ($pos as $key => $value) { ?>
          // var value = <?php print_r($value->lat)?>;
          // console.log(value);
          var position = {lat: <?php print_r($value->lat)?>, lng: <?php print_r($value->lng)?>};
          var marker = new google.maps.Marker({
            position: position,
            map: map
          });
          //extend the bounds to include each marker's position
          bounds.extend(marker.position);
        <?php }
        ?>
        //now fit the map to the newly inclusive bounds
        map.fitBounds(bounds);
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7gXc5t6ToETjPlSBLsh_gqL36niD47n8&callback=initMap">
    </script>
 