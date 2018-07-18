      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                      <?php 
                      $userDetails = $this->Admin_model->select_data('*','tbl_users',array('id'=>$data[0]->user_id));
                      $catDetails = $this->Admin_model->select_data('*','tbl_categories',array('id'=>$data[0]->category_id));
                      $subCatDetails = $this->Admin_model->select_data('*','tbl_subCategory',array('id'=>$data[0]->subCategory_id));
                      // echo "<pre>";
                      // print_r($data);
                      // print_r($userDetails);
                      // echo "</pre>";
                      ?>
                  <aside class="profile-nav col-lg-3">
                      <section class="panel">
                          <div class="user-heading round">
                              <a href="#">
                                  <img src="<?php echo $subCatDetails[0]->image; ?>" alt="">
                              </a>
                              <h1><?php echo $data[0]->id; ?></h1>
                              <p><?php echo $catDetails[0]->categoryName; ?></p>
                          </div>

                          <ul class="nav nav-pills nav-stacked">
                              <li><a href="<?php echo base_url(); ?>Dashboard/jobView?jobid=<?php echo $data[0]->id; ?>"> <i class="fa fa-user"></i> View</a></li>
                              
                              <li class="active"><a href="<?php echo base_url(); ?>Dashboard/jobEdit?jobid=<?php echo $data[0]->id; ?>"> <i class="fa fa-edit"></i> Edit job</a></li>
                          </ul>

                      </section>
                  </aside>
                  <aside class="profile-info col-lg-9">
                      <section class="panel">
                          <div id="map" class="gmapsP"></div>

                          <footer class="panel-footer">
                              
                          </footer>
                      </section>
                      <section class="panel">
                          <div class="bio-graph-heading">
                              <?php echo $catDetails[0]->categoryName.' | '.$subCatDetails[0]->subCategoryName; ?>
                          </div>
                          <div class="panel-body bio-graph-info">
                              <h1>User Details</h1>
                              <div class="row">
                                  <div class="bio-row">
                                      <p><span>First Name </span>: <?php echo $userDetails[0]->fname; ?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Last Name </span>: <?php echo $userDetails[0]->lname; ?></p>
                                  </div>
                                  <!-- <div class="bio-row">
                                      <p><span>State </span>: <?php echo $userDetails[0]->state; ?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>City</span>: <?php echo $userDetails[0]->city; ?></p>
                                  </div> -->
                                  <div class="bio-row">
                                      <p><span>Referral code </span>: <?php echo $userDetails[0]->ref_code; ?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Email </span>: <?php echo $userDetails[0]->email; ?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Mobile </span>: <?php echo $userDetails[0]->phone; ?></p>
                                  </div>
                                  <!-- <div class="bio-row">
                                      <p><span>Status </span>: <?php echo $userDetails[0]->user_status; ?></p>
                                  </div> -->
                              </div>
                          </div>
                      </section>
                      <section class="panel">
                         
                          <div class="panel-body bio-graph-info">
                              <h1>Job Details</h1>
                              <FORM method='POST'>
                                <div class="row">
                                    <div class="bio-row">
                                        <p><span>jobid </span>: <?php echo $data[0]->id; ?></p>
                                    </div>
                                    <!-- <div class="bio-row">
                                        <p><span>category_id </span>: <?php echo $data[0]->category_id; ?></p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>subCategory_id </span>: <?php echo $data[0]->subCategory_id; ?></p>
                                    </div> -->
                                    <div class="bio-row">
                                        <p><span>pickup_location </span>: <input name="pickup_location" class="form-control" value="<?php echo $data[0]->pickup_location; ?>" type="text" id="pickup_location"></p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>pickup_lat </span>: <input name="pickup_lat" class="form-control" value="<?php echo $data[0]->pickup_lat; ?>" type="text" id="pickup_lat"></p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>pickup_long </span>: <input name="pickup_long" class="form-control" value="<?php echo $data[0]->pickup_long; ?>" type="text" id="pickup_long"></p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>dropOff_location </span>: <?php echo $data[0]->dropOff_location; ?></p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>dropOff_lat </span>: <?php echo $data[0]->dropOff_lat; ?></p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>dropOff_long </span>: <?php echo $data[0]->dropOff_long; ?></p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>is_quote </span>: <?php echo $data[0]->is_quote; ?></p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>estimatedprice </span>: <?php echo $data[0]->estimatedprice; ?></p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>totalprice </span>: <?php echo $data[0]->totalprice; ?></p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>promo_codeId </span>: <?php echo $data[0]->promo_codeId; ?></p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>items </span>: <?php echo $data[0]->items; ?></p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>distance </span>: <?php echo $data[0]->distance; ?></p>
                                    </div>
                                    <!-- <div class="bio-row">
                                        <p><span>is_accepted </span>: <?php echo $data[0]->is_accepted; ?></p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>is_started </span>: <?php echo $data[0]->is_started; ?></p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>is_completed </span>: <?php echo $data[0]->is_completed; ?></p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>is_cancelled </span>: <?php echo $data[0]->is_cancelled; ?></p>
                                    </div> -->
                                    <div class="bio-row">
                                        <p><span>accepted_by </span>: <?php echo $data[0]->accepted_by; ?></p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>hours </span>: <?php echo $data[0]->hours; ?></p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>booking_date </span>: <?php echo $data[0]->booking_date; ?></p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>booking_time </span>: <?php echo $data[0]->booking_time; ?></p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>value </span>: <?php echo $data[0]->value; ?></p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>extra_fare </span>: <?php echo $data[0]->extra_fare; ?></p>
                                    </div>
                                    <!-- <div class="bio-row">
                                        <p><span>path_wayPoints </span>: <?php echo $data[0]->path_wayPoints; ?></p>
                                    </div> -->
                                    <div class="bio-row">
                                        <p><span>afterHourCharges </span>: <?php echo $data[0]->afterHourCharges; ?></p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>date_created </span>: <?php echo $data[0]->date_created; ?></p>
                                    </div>
                                    <button class="btn btn-success btn-block" type="button">Update</button>
                                </div>
                              </FORM>
                          </div>
                      </section>
                      <section>
                          
                              <!-- <div class="col-lg-6">
                                  <div class="panel">
                                      <div class="panel-body">
                                         <img src="<?php echo $data[0]->reportimage5; ?>" class="img-responsive" alt="Report Image">                                          
                                      </div>
                                  </div>
                              </div> -->
                          </div>
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
        var loc = {lat: <?php echo $data[0]->pickup_lat; ?>, lng: <?php echo $data[0]->pickup_long; ?>};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 14,
          center: loc
        }); 

        var geocoder = new google.maps.Geocoder;

        
        var marker = new google.maps.Marker({
          draggable: true,
          position: loc,
          map: map
        });

        google.maps.event.addListener(marker, 'dragend', function (event) {
            document.getElementById("pickup_lat").value = this.getPosition().lat();
            document.getElementById("pickup_long").value = this.getPosition().lng();

            latitude=this.getPosition().lat();               
            longitude=this.getPosition().lng();
            var latlng = {lat: parseFloat(latitude), lng: parseFloat(longitude)};

            geocoder.geocode({'location': latlng}, function(results, status) {
              if (status === google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                  console.log(results[1].formatted_address);
                  document.getElementById("pickup_location").value = results[1].formatted_address;

                } else {
                  window.alert('No results found');
                }
              } else {
                window.alert('Geocoder failed due to: ' + status);
              }
            });
        });
      }

    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7gXc5t6ToETjPlSBLsh_gqL36niD47n8&callback=initMap">
    </script>
