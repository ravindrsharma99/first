
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
                   <li>
                      <a href="<?php echo base_url(); ?>Dashboard/index">
                          <i class="fa fa-dashboard"></i>
                          <span>Dashboard</span>
                      </a>
                  </li>
                  <li>
                      <a href="<?php echo base_url(); ?>Dashboard/list_users">
                          <i class="fa fa-user"></i>
                          <span>Donors</span>
                      </a>
                  </li>

                  <li class="sub-menu">
                      <a href="javascript:;">
                          <i class="fa fa-glass"></i>
                          <span>HBCU</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="<?php echo base_url(); ?>Dashboard/addHbcu">Add</a></li>
                          <li><a  href="<?php echo base_url(); ?>Dashboard/listHbcu">List</a></li>

                      </ul>
                  </li>
                  <li class="sub-menu">
                      <a href="javascript:;">

                    <i class="fa fa-building-o" aria-hidden="true"></i>
                           <span>Organization</span>
                      </a>
                       <ul class="sub">
                          <li><a  href="<?php echo base_url(); ?>Dashboard/addOrganization">Add</a></li>
                          <li><a  href="<?php echo base_url(); ?>Dashboard/listOrganization">List</a></li>

                      </ul>
                  </li>
                 <li>
                      <a href="<?php echo base_url(); ?>Dashboard/lovedhbcu">
                    
                        <i class="fa fa-gift" aria-hidden="true"></i>
                          <span>The Most Loved HBCUs</span>
                      </a>
                  </li> 




                    <li>
                      <a href="<?php echo base_url(); ?>Dashboard/topdonors">
                    
                        <i class="fa fa-th" aria-hidden="true"></i>
                          <span>Divine 9</span>
                      </a>
                  </li> 





                    <li>
                      <a href="<?php echo base_url(); ?>Dashboard/donations">
                    
                        <i class="fa fa-wrench" aria-hidden="true"></i>
                          <span>Donations</span>
                      </a>
                  </li> 




                       <li>
                      <a href="<?php echo base_url(); ?>Dashboard/referral">
                        
                        <i class="fa fa-bolt" aria-hidden="true"></i>
                          <span>Referral</span>
                      </a>
                  </li>  



                       <li>
                      <a href="<?php echo base_url(); ?>Dashboard/feedback">
               
                        <i class="fa fa-tasks" aria-hidden="true"></i>
                          <span>Feedback</span>
                      </a>
                  </li>  

                  
                 <!--  <li class="sub-menu">
                      <a href="javascript:;">
                          <i class="fa fa-glass"></i>
                          <span>Service Providers</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="<?php echo base_url(); ?>Dashboard/list_drivers">Moving Based</a></li>
                          <li><a  href="<?php echo base_url(); ?>Dashboard/list_electricians">Hourly Based</a></li>

                      </ul>
                  </li>

                  <li class="sub-menu">
                      <a href="javascript:;" id="form_stuffa">
                          <i class="fa fa-tasks"></i>
                          <span>Category</span>
                      </a>
                      <ul class="sub" id="form_stuffsub">
                          <li id="add_eventli"><a  href="<?php echo base_url(); ?>Dashboard/add_category">Add Category</a></li>
                          <li id="report_eventli"><a  href="<?php echo base_url(); ?>Dashboard/listCategories">List Category</a></li>
                      </ul>
                  </li>
                  <li class="sub-menu">
                      <a href="javascript:;" id="data_tablesa" >
                          <i class="fa fa-th"></i>
                          <span>Sub-Category</span>
                      </a>
                      <ul class="sub" id="data_tablessub">
                          <li id="eventsli"><a  href="<?php echo base_url(); ?>Dashboard/add_subcategory">Add SubCategory</a></li>
                          <li id="reported_eventsli"><a  href="<?php echo base_url(); ?>Dashboard/listSubCategories">List SubCategory</a></li>

                      </ul>
                  </li>

                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class=" fa fa-bar-chart-o"></i>
                          <span>SubCategory Services</span>
                      </a>
                      <ul class="sub">
                          <li id="reported_eventsli"><a  href="<?php echo base_url(); ?>Dashboard/add_services">Add Services</a></li>
                          <li id="reported_eventsli"><a  href="<?php echo base_url(); ?>Dashboard/listServices">List Services</a></li>
                      </ul>
                  </li>

                  <li>
                      <a href="<?php echo base_url(); ?>Dashboard/serviceRequest">
                          <i class="fa fa-shopping-cart"></i>
                          <span>Requested Services</span>
                      </a>
                  </li>



                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class=" fa fa-map-marker"></i>
                          <span>Track Services</span>
                      </a>
                      <ul class="sub">
                          <li id="reqMapli"><a  href="<?php echo base_url(); ?>Dashboard/reqMap">Requested Services</a></li>
                          <li id="serviceProvidersli"><a  href="<?php echo base_url(); ?>Dashboard/serviceProvidersMap">Service Providers</a></li>
                      </ul>
                  </li>
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-glass"></i>
                          <span>Promocodes</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="<?php echo base_url(); ?>Dashboard/addPromocode">Add Promocode</a></li>
                          <li><a  href="<?php echo base_url(); ?>Dashboard/promocodeList">Promocodes List</a></li>
                      </ul>
                  </li>
 -->
                  <!-- <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-bolt"></i>
                          <span>Membership</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="<?php echo base_url(); ?>Dashboard/addMembership">Add Membership</a></li>
                          <li><a  href="<?php echo base_url(); ?>Dashboard/membershipList">Membership List</a></li>
                      </ul>
                  </li>

                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-car"></i>
                          <span>DriverSubscriptions</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="<?php echo base_url(); ?>Dashboard/addSubscription">Add Subscription</a></li>
                          <li><a  href="<?php echo base_url(); ?>Dashboard/listSubsciptions">Subscriptions List</a></li>
                      </ul>
                  </li> -->
                <!--   <li>
                    <a href="<?php echo base_url(); ?>Dashboard/pushNotification">
                        <i class="fa fa-sitemap"></i>
                        <span>Send Notifications</span>
                    </a>
                  </li>

                  <li>
                    <a href="<?php echo base_url(); ?>Dashboard/pay_providers">
                        <i class="fa fa-credit-card-alt"></i>
                        <span>Pay ServiceProviders</span>
                    </a>
                  </li>
                        <li>
                    <a href="<?php echo base_url(); ?>Dashboard/subAdmins">
                        <i class="fa fa-puzzle-piece"></i>
                        <span>Sub Admins</span>
                    </a>
                  </li>
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-wrench"></i>
                          <span>Settings</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="<?php echo base_url(); ?>Dashboard/settings">App Settings</a></li>
                          <li><a  href="<?php echo base_url(); ?>Dashboard/geofence">Geofence</a></li>
                      </ul>
                  </li>

                   <li>
                    <a href="<?php echo base_url(); ?>Dashboard/EditPage">
                        <i class="fa fa-gears"></i>
                        <span>Edit FrontPage</span>
                    </a>
                  </li>
              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside> 
      <!--sidebar end-->

