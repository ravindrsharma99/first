
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="row">
                <?php
                // echo "$page_title";
                // echo "<pre>";
                // print_r($data);
                // echo "</pre>";
                ?>

            <aside class="profile-info col-lg-12">
                <section class="panel">
                  <header class="panel-heading">
                      <?php
                         echo "$page_title";
                      ?>
                  </header>
                    <div id="map" class="gmaps"></div>

                    <footer class="panel-footer">
                        <p>Geofence for area</p>
                    </footer>
                </section>
            </aside>
        </div>
        <div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo base_url(); ?>Public/img/demo_wait.gif' width="64" height="64" />
            <br>Processing...</div>
        <!-- page end-->
    </section>
</section>
<!--main content end-->


<!--script for this page only-->
<script>

// This example requires the Drawing library. Include the libraries=drawing
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=drawing">
var map;
var infoWindow;
var geofence = [];

/**
* The CenterControl adds a control to the map that recenters the map on
* Chicago.
* This constructor takes the control DIV as an argument.
* @constructor
*/
function CenterControl(controlDiv, map,polygon) {

  // Set CSS for the control border.
  var controlUI = document.createElement('div');
  controlUI.style.backgroundColor = '#fff';
  controlUI.style.border = '2px solid #fff';
  controlUI.style.borderRadius = '3px';
  controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
  controlUI.style.cursor = 'pointer';
  controlUI.style.marginBottom = '22px';
  controlUI.style.textAlign = 'center';
  controlUI.title = 'Click to save the map';
  controlDiv.appendChild(controlUI);

  // Set CSS for the control interior.
  var controlText = document.createElement('div');
  controlText.style.color = 'rgb(25,25,25)';
  controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
  controlText.style.fontSize = '16px';
  controlText.style.lineHeight = '38px';
  controlText.style.paddingLeft = '5px';
  controlText.style.paddingRight = '5px';
  controlText.innerHTML = 'Save Map';
  controlUI.appendChild(controlText);

  // Setup the click event listeners: simply set the map to Chicago.
  controlUI.addEventListener('click', function() {
    showArrays(this,polygon);
    var data = "";
    var data = JSON.stringify(geofence);
    console.log(data);
    // return false;
    $.ajax({
        type: "POST",
        url: "saveGeofence",
        dataType: "json",
        data: {
          geofence:data
        },
        cache: false,
        beforeSend: function() {
            $("#wait").css("display", "none");
            $("#wait").css("display", "block");
            $(document.body).css({
                'cursor': 'wait'
            });
        },
        success: function(data) {
            console.log(data);
            alert("Polygon Saved!!!");
        },
        complete: function() {
            $("#wait").css("display", "none");
            $(document.body).css({
                'cursor': 'default'
            });
        },
        error: function(request, status, error) {
            $("#wait").css("display", "none");
            $(document.body).css({
                'cursor': 'default'
            });
        }
    });
  });

}

function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 1.3521, lng: 103.8198},
    zoom: 10
  });

  // Define the LatLng coordinates for the polygon's path.
  var serializedArr = <?php echo $geofence; ?>;
  console.log(serializedArr);
   var triangleCoords = serializedArr;

  //  var triangleCoords = [
  //    {lat: 1.255581, lng: 103.838654},
  //    {lat: 1.289905, lng: 103.479538},
  //    {lat: 1.477991, lng: 103.798141},
  //    {lat: 1.255581, lng: 103.838654}
  //  ];

   // Construct the polygon.
   var polygon = new google.maps.Polygon({
     paths: triangleCoords,
     strokeColor: '#FF0000',
     strokeOpacity: 0.8,
     strokeWeight: 2,
     fillColor: '#FF0000',
     fillOpacity: 0.35,
     draggable: true,
    //  geodesic: true,
     editable: true
   });
   polygon.setMap(map);

    // Create the DIV to hold the control and call the CenterControl()
    // constructor passing in this DIV.
    var centerControlDiv = document.createElement('div');
    var centerControl = new CenterControl(centerControlDiv, map,polygon);

    centerControlDiv.index = 1;
    map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);

    // var deleteMenu = new DeleteMenu();
    //
    // google.maps.event.addListener(polygon, 'rightclick', function(e) {
    //   // Check if click was on a vertex control point
    //   if (e.vertex == undefined) {
    //     return;
    //   }
    //   deleteMenu.open(map, polygon.getPath(), e.vertex);
    // });
}
/** @this {google.maps.Polygon} */
function showArrays(event,polygon=null) {

  // Since this polygon has only one path, we can call getPath() to return the
  // MVCArray of LatLngs.
  if (polygon!=null) {
    var vertices = polygon.getPath();
  }else{

    var vertices = this.getPath();
  }

  // Iterate over the vertices.
  geofence = [];
  for (var i =0; i < vertices.getLength(); i++) {
    var xy = vertices.getAt(i);
    b={lat: xy.lat(), lng: xy.lng()};
    geofence.push(b);
  }

  // Replace the info window's content and position.
  console.log(geofence);
  // geofence = JSON.stringify( geofence );
}
/**
 * A menu that lets a user delete a selected vertex of a path.
 * @constructor
 */
// function DeleteMenu() {
//   this.div_ = document.createElement('div');
//   this.div_.className = 'delete-menu';
//   this.div_.innerHTML = 'Delete';
//
//   var menu = this;
//   google.maps.event.addDomListener(this.div_, 'click', function() {
//     menu.removeVertex();
//   });
// }
// DeleteMenu.prototype = new google.maps.OverlayView();
//
// DeleteMenu.prototype.onAdd = function() {
//   var deleteMenu = this;
//   var map = this.getMap();
//   this.getPanes().floatPane.appendChild(this.div_);
//
//   // mousedown anywhere on the map except on the menu div will close the
//   // menu.
//   this.divListener_ = google.maps.event.addDomListener(map.getDiv(), 'mousedown', function(e) {
//     if (e.target != deleteMenu.div_) {
//       deleteMenu.close();
//     }
//   }, true);
// };
//
// DeleteMenu.prototype.onRemove = function() {
//   google.maps.event.removeListener(this.divListener_);
//   this.div_.parentNode.removeChild(this.div_);
//
//   // clean up
//   this.set('position');
//   this.set('path');
//   this.set('vertex');
// };
//
// DeleteMenu.prototype.close = function() {
//   this.setMap(null);
// };
//
// DeleteMenu.prototype.draw = function() {
//   var position = this.get('position');
//   var projection = this.getProjection();
//
//   if (!position || !projection) {
//     return;
//   }
//
//   var point = projection.fromLatLngToDivPixel(position);
//   this.div_.style.top = point.y + 'px';
//   this.div_.style.left = point.x + 'px';
// };
//
// /**
//  * Opens the menu at a vertex of a given path.
//  */
// DeleteMenu.prototype.open = function(map, path, vertex) {
//   this.set('position', path.getAt(vertex));
//   this.set('path', path);
//   this.set('vertex', vertex);
//   this.setMap(map);
//   this.draw();
// };
//
// /**
//  * Deletes the vertex from the path.
//  */
// DeleteMenu.prototype.removeVertex = function() {
//   var path = this.get('path');
//   var vertex = this.get('vertex');
//
//   if (!path || vertex == undefined) {
//     this.close();
//     return;
//   }
//
//   path.removeAt(vertex);
//   this.close();
// };
//
// google.maps.event.addDomListener(window, 'load', initialize);
</script>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7gXc5t6ToETjPlSBLsh_gqL36niD47n8&libraries=drawing&callback=initMap">
</script>
