  <style>
  .set_div_img2{
        text-align: right; cursor: pointer;
     } 
  </style>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <script src="<?php echo base_url();?>assets/admin/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
  <link href="<?php echo base_url();?>assets/admin/css/fullcalendar.css" rel="stylesheet" type="text/css" />
  <div class="content-wrapper">
  <?php $adminData = $this->session->userdata('adminData');  
      $QuickEmail = $this->load->facility_model->getQuickEmail();
  ?>
    
    <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>
    <section class= "content">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <?php echo $this->session->flashdata('activate'); ?>
         <script type="text/javascript">
            $(document).ready(function(){     
            setTimeout(function(){
            $('#secc_msg').fadeOut(); 
            }, 10000);   
            $('.set_div_img2').on('click', function() {  
            $('#secc_msg').fadeOut();    
            });
            });
        </script>



      </div>
      <?php if($adminData['Type']==1){?>
        <div class="row">
             <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-handshake-o"></i></span>
                    <div class="info-box-content">
                     <span class="info">Total Facilities &<br> Total Lounges</span>
                    <span class="info-box-number"><a href="<?php echo base_url('Admin/Facility'); ?>"><?php echo $counting['facility']; ?>/<?php echo $counting['lounge']; ?></a></span>
                  </div>
                 </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-female"></i></span>
                    <div class="info-box-content">
                     <span class="info">Total Mothers</span>
                    <span class="info-box-number"><a href="<?php echo base_url('Admin/Mother'); ?>"><?php echo $counting['mother']; ?></a></span>
                  </div>
                 </div>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-blue"><i class="fa fa-child"></i></span>
                    <div class="info-box-content">
                     <span class="info">Total Babies</span>
                    <span class="info-box-number"><a href="<?php echo base_url('Admin/Baby'); ?>"><?php echo $counting['baby']; ?></a></span>
                  </div>
                 </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                     <span class="info">Total Staff</span>
                    <span class="info-box-number"><a href="<?php echo base_url('Admin/staff'); ?>"><?php echo $counting['staff']; ?></a></span>
                  </div>
                 </div>
              </div>
               
              
       
      <section class="col-lg-6 connectedSortable">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
              <li class="active">
                <a href="#revenue-chart" data-toggle="tab">
                  <button type="button" class="btn btn-primary btn-sm daterange pull-right" data-toggle="tooltip"
                        title="Date range">
                  <i class="fa fa-calendar"></i></button>
                </a>
              </li>
              <li>
                
              </li>
              <li class="pull-left header"><i class="fa fa-inbox"></i>Registred Mothers</li>
            </ul>
            <div class="tab-content no-padding">
              <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
              <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>
            </div>
          </div>
          <div class="box box-info">
            <form action="<?php echo base_url('Facility/SendMail')?>" method="POST" enctype ="multipart/form-data">
            <div class="box-header">
              <i class="fa fa-envelope"></i>
              <h3 class="box-title">Quick Email</h3>
              <div class="pull-right box-tools">

                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                        title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
               <div class="form-group">
                  <input type="text" class="form-control" name="subject" placeholder="Subject" required>
                </div>
                <div>
                  <textarea class="textarea"  name ="Message" placeholder="Message"
                            style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>
                </div>
              
            </div>
            <div class="box-footer clearfix">
              <input type="submit" class="pull-right btn btn-default" value="Send">
            </div>
            </form>
          </div>
    </section>
    <section class="col-lg-6 connectedSortable">
          <div class="box box-solid bg-light-blue-gradient">
              <div class="box-header">
                 <div class="pull-right box-tools">
                 </div>
                 <i class="fa fa-map-marker"></i>
                 <h3 class="box-title">
                  KMC Facilities
                 </h3>
              </div>
                  <?php 
                   $Facilities    = $this->facility_model->GetFacilityListForMap();
                      foreach($Facilities as $val){ ?>
                     <?php 
                      $address_latlng[]=array

                         ( 'title'=>$val["Address"],
                           'description'=>'<b>Facility Name:&nbsp;</b>'.$val["FacilityName"].'<br/><br/><b>Mobile:</b>&nbsp;'.$val["AdministrativeMoblieNo"].'<br/><br/><b>Address:</b>&nbsp;'.$val["Address"],
                           'lat'=>$val["Latitude"],
                           'lng'=>$val["Longitude"]
                         );
                       ?>
                    <?php }?>        
                    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAxpNXGcquaqlg4PeuA1lqAU-tl4-KQ-xg&callback=initMap" type="text/javascript"></script><script type="text/javascript">// <![CDATA[
                    var markers = <?php echo json_encode($address_latlng);?>

                    window.onload = function () {
                    var mapOptions = {
                    center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
                    zoom: 10,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                    };
                    var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
                    var infoWindow = new google.maps.InfoWindow();
                    var lat_lng = new Array();
                    var latlngbounds = new google.maps.LatLngBounds();
                    for (i = 0; i < markers.length; i++) {
                    var data = markers[i]
                    var myLatlng = new google.maps.LatLng(data.lat, data.lng);
                    lat_lng.push(myLatlng);
                    var marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    title: data.title
                    });
                    latlngbounds.extend(marker.position);
                    (function (marker, data) {
                    google.maps.event.addListener(marker, "click", function (e) {
                    infoWindow.setContent(data.description);
                    infoWindow.open(map, marker);
                    });
                    })(marker, data);
                    }
                    map.setCenter(latlngbounds.getCenter());
                    map.fitBounds(latlngbounds);

                    }
                   </script></pre>
                  <div id="dvMap" style="width:100%; height: 500px;color:black;"></div>
          </div>

         
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Latest Registered Mothers</h3>

                  <div class="box-tools pull-right">
                    <span class="label label-danger"><a href="<?php echo base_url();?>Facility/ViewCalendar" style="color:white;">Calender | View</a></span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                     <?php 
                    foreach ($LatestMother as $key => $value) { ?>
                      <li>
                        <?php  if($value['MotherPicture']==NULL){ ?>
                         <img src="<?php echo base_url();?>assets/images/Sorry-image-not-available.png" alt="User Image">   
                          <?php } else {?>
                          <img src="<?php echo base_url();?>assets/images/mother_images/<?php echo $value['MotherPicture']; ?>" alt="User Image" class="img-responsive"style="height:100px;width:100px;">
                          <?php } ?>
                          
                        <a class="users-list-name" href="<?php echo base_url();?>Admin/ViewMother/<?php echo $value['MotherID'];?>"><img src="<?php echo base_url();?>assets/images/happy-face.png" style="width:25px;height:25px;">&nbsp;<?php
                           echo ucwords($value['MotherName']);?></a>
                        <span class="users-list-date"><?php echo date('d M,y H:i:s',$value['AddDate']) ?></span>
                      </li>
                  <?php }?>

                  </ul>
                  <!-- /.users-list -->
                </div>
              </div>
              <!--/.box -->
            
  </section>
  </div>
  
<?php } else { ?>
       <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                     <span class="info">Total Mothers</span>
                    <span class="info-box-number"><a href="<?php echo base_url('Admin/Mother'); ?>"><?php echo $counting['mother']; ?></a></span>
                  </div>
                 </div>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-blue"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                     <span class="info">Total Babies</span>
                    <span class="info-box-number"><a href="<?php echo base_url('Admin/Baby'); ?>"><?php echo $counting['baby']; ?></a></span>
                  </div>
                 </div>
              </div> 
               <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                 </div>
              </div> 
              <div class="col-md-3 col-sm-6 col-xs-12">
                 <div class="info-box">
                 </div>
              </div> 

        <section class="col-lg-6 connectedSortable">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
              <li class="active">
                <a href="#revenue-chart" data-toggle="tab">
                  <button type="button" class="btn btn-primary btn-sm daterange pull-right" data-toggle="tooltip"
                        title="Date range">
                  <i class="fa fa-calendar"></i></button>
                </a>
              </li>
              <li>
                
              </li>
              <li class="pull-left header"><i class="fa fa-inbox"></i>Sales</li>
            </ul>
            <div class="tab-content no-padding">
              <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
              <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>
            </div>
          </div>
          <div class="box box-info">
            <form action="<?php echo base_url('Facility/SendMail')?>" method="POST" enctype ="multipart/form-data">
            <div class="box-header">
              <i class="fa fa-envelope"></i>
              <h3 class="box-title">Quick Email</h3>
              <div class="pull-right box-tools">

                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                        title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="form-group">
                  <input type="text" class="form-control" name="subject" placeholder="Subject">
                </div>
                <div>
                  <textarea class="textarea"  name ="Message" placeholder="Message"
                            style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div>
              
            </div>
            <div class="box-footer clearfix">
              <input type="submit" class="pull-right btn btn-default" value="Send">
            </div>
            </form>
          </div>
       </section>
       <section class="col-lg-6 connectedSortable">
         <div class="box box-solid bg-light-blue-gradient">
              <div class="box-header">
                 <div class="pull-right box-tools">
                 </div>
                 <i class="fa fa-map-marker"></i>
                 <h3 class="box-title">
                  KMC Facilities
                 </h3>
              </div>
                  <?php 
                   $Facilities    = $this->facility_model->GetFacilityListForMap();
                      foreach($Facilities as $val){ ?>
                     <?php 
                      $address_latlng[]=array

                         ( 'title'=>$val["Address"],
                           'description'=>'<b>Facility Name:&nbsp;</b>'.$val["FacilityName"].'<br/><br/><b>Mobile:</b>&nbsp;'.$val["AdministrativeMoblieNo"].'<br/><br/><b>Address:</b>&nbsp;'.$val["Address"],
                           'lat'=>$val["Latitude"],
                           'lng'=>$val["Longitude"]
                         );
                       ?>
                    <?php }?>        
                    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAxpNXGcquaqlg4PeuA1lqAU-tl4-KQ-xg&callback=initMap" type="text/javascript"></script><script type="text/javascript">// <![CDATA[
                    var markers = <?php echo json_encode($address_latlng);?>

                    window.onload = function () {
                    var mapOptions = {
                    center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
                    zoom: 10,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                    };
                    var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
                    var infoWindow = new google.maps.InfoWindow();
                    var lat_lng = new Array();
                    var latlngbounds = new google.maps.LatLngBounds();
                    for (i = 0; i < markers.length; i++) {
                    var data = markers[i]
                    var myLatlng = new google.maps.LatLng(data.lat, data.lng);
                    lat_lng.push(myLatlng);
                    var marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    title: data.title
                    });
                    latlngbounds.extend(marker.position);
                    (function (marker, data) {
                    google.maps.event.addListener(marker, "click", function (e) {
                    infoWindow.setContent(data.description);
                    infoWindow.open(map, marker);
                    });
                    })(marker, data);
                    }
                    map.setCenter(latlngbounds.getCenter());
                    map.fitBounds(latlngbounds);

                    }
                   </script></pre>
                  <div id="dvMap" style="width:100%; height: 500px;color:black;"></div>
          </div>
            
             <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Latest Registered Mothers</h3>

                  <div class="box-tools pull-right">
                    <span class="label label-danger"><a href="<?php echo base_url();?>Facility/ViewCalendar" style="color:white;">Calender | View</a></span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                     <?php 
                    foreach ($LatestMother as $key => $value) { ?>
                      <li>
                        <?php  if($value['MotherPicture']==NULL){ ?>
                         <img src="<?php echo base_url();?>assets/images/Sorry-image-not-available.png" alt="User Image">   
                          <?php } else {?>
                          <img src="<?php echo base_url();?>assets/images/mother_images/<?php echo $value['MotherPicture']; ?>" alt="User Image" class="img-responsive"style="height:100px;width:100px;">
                          <?php } ?>
                          
                        <a class="users-list-name" href="<?php echo base_url();?>Admin/ViewMother/<?php echo $value['MotherID'];?>"><img src="<?php echo base_url();?>assets/images/happy-face.png" style="width:25px;height:25px;">&nbsp;<?php
                           echo ucwords($value['MotherName']);?></a>
                        <span class="users-list-date"><?php echo date('d M,y H:i:s',$value['AddDate']) ?></span>
                      </li>
                  <?php }?>

                  </ul>
                  <!-- /.users-list -->
                </div>
              </div>
       </section>
</div>

       <?php } ?>
 </section>

  </div>
 <script src="<?php echo base_url()?>assets/admin/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php  echo base_url()?>assets/admin/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
 setTimeout(function() { $("#success").hide(); }, 2000);
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script>
            $(function () {
              $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' /* optional */
              });
            });
        </script>

        <script type="application/javascript">
            /** After window Load */
            $(window).bind("load", function() {
              window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove();
                });
            }, 4000);
            });

            $(document).ready(function(){       
                setTimeout(function(){ 
                    $('#secc_msg').fadeOut(); 
                }, 10000);

                $('.set_div_img2').on('click', function() {         
                    $('#secc_msg').fadeOut();       
                });


                setTimeout(function(){ 
                    $('#un_secc_msg').fadeOut(); 
                }, 10000);

                $('.set_div_img2').on('click', function() {         
                    $('#un_secc_msg').fadeOut();        
                }); 
            });
        </script>

