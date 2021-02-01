    <?php 
       $adminData = $this->session->userdata('adminData');  
       $QuickEmail = $this->load->facility_model->getQuickEmail();
       $TotalMilk = $this->load->facility_model->overAllMilkQuantity();
       $TotalKMC = $this->load->facility_model->overAllKMC();
       $TotalAdmittedChild = $this->load->facility_model->getTotalAdmittedChild();
       // for SSC timing graph like 0-4,4-8,.... hrs as well as
        $getSSCTime = $this->load->facility_model->getCurrentBabyInHour();
        $status1=0;
        $status2=0;
        $status3=0;
        $status4=0;
        $status5=0;
        $status6=0;
        $totalsscHrs=0;
        $receivedSccBabyCounting = 0;
        foreach ($getSSCTime as $key => $value) {
          $skinTimePerBaby = floor(($value['totalseconds']/60)/60);
          if($skinTimePerBaby > 0 && $skinTimePerBaby < 4){
            $status1++;
          }if($skinTimePerBaby >= 4 && $skinTimePerBaby < 8){
            $status2++;
          }if($skinTimePerBaby >= 8 && $skinTimePerBaby < 12){
            $status3++;
          }if($skinTimePerBaby >= 12 && $skinTimePerBaby < 16){
            $status4++;
          }if($skinTimePerBaby >= 16 && $skinTimePerBaby < 20){
            $status5++;
          }if($skinTimePerBaby >= 20 && $skinTimePerBaby < 24){
            $status6++;
          }
            $totalsscHrs += $skinTimePerBaby;
            $receivedSccBabyCounting++;
        }
   ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
<?php 
//echo time();exit();
?>
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li>
           <select name="LoungeName" onchange="GetLoungeWiseValue(this)" style="width:180px;height:25px !important;">
              <option value="all">Select All Lounges</option>
              <?php foreach ($totalLounges as $key => $value) { ?>
              <option value="<?php echo $value['LoungeID']; ?>"><?php echo $value['LoungeName']; ?></option>
            <?php } ?>
           </select>
         </li>
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>

          </ol>

        </section>

    <!-- Main content -->
    <section class="content">
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
        <script type="text/javascript">
          function GetLoungeWiseValue(data)
          {
           var loungeId =(data.value);
           if(loungeId == 'all'){
            location.reload(true);
           }
            $("#dynamicDiv").load('<?php echo base_url("Admin/action1"); ?>', {"loungeWiseValue": loungeId} );
          }
        </script>
      </div> 
<?php if($adminData['Type'] == 1){?>       
      <div class="row">
        <div id="dynamicDiv">
              <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-handshake-o"></i></span>
                    <div class="info-box-content">
                     <span class="info">Total Facilities &<br> Total Lounges</span>
                    <span class="info-box-number"><a href="<?php echo base_url('facility/manageFacility'); ?>"><?php echo $counting['facility']; ?>/<?php echo $counting['lounge']; ?></a></span>
                  </div>
                 </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                     <span class="info">Total Staff</span>
                    <span class="info-box-number"><a href="<?php echo base_url('staffM/manageStaff'); ?>"><?php echo $counting['staff']; ?></a></span>
                  </div>
                 </div>
              </div>


              <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-female"></i></span>
                    <div class="info-box-content">
                     <span class="info">Total Mothers</span>
                    <span class="info-box-number"><a href="<?php echo base_url('motherM/registeredMother'); ?>"><?php echo $counting['mother']; ?></a></span>
                  </div>
                 </div>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-blue"><i class="fa fa-child"></i></span>
                    <div class="info-box-content">
                     <span class="info">Total Babies</span>
                    <span class="info-box-number"><a href="<?php echo base_url('babyM/registeredBaby'); ?>"><?php echo $counting['baby']; ?></a></span>
                  </div>
                 </div>
              </div>
          
      <section class="col-lg-6 connectedSortable">       
           <div class="box box-success">
                  <div class="box-header with-border">
                   <h3 class="box-title">Registered Mothers And Babies </h3>
                  <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                  </div>
                  <div class="box-body">
                  <div class="chart">
                  <canvas id="barChart" style="height:230px"></canvas>
                  <ul class="fc-color-picker" id="color-chooser">
                      <li><a class="" href="#" style="font-size:15px;color:#f390bd;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">Mothers (<?php echo $counting['mother']; ?>).</span></li> 
                    </ul>
                    <ul class="fc-color-picker" id="color-chooser">
                      <li><a class="text-blue" href="#" style="font-size:15px;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">Babies (<?php echo $counting['baby']; ?>).</span></li> 
                    </ul>
                 </div>
                 </div>
           </div>



           <div class="box box-success">
                  <div class="box-header with-border">
                   <h3 class="box-title">Baby Feeding Status</h3>
                  <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                  </div>
                  <div class="box-body">
                  <div class="chart">
                  <canvas id="barChart2" style="height:230px"></canvas>
                  <ul class="fc-color-picker" id="color-chooser">
                      <li><a class="" href="#" style="font-size:15px;color:#f88641"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">Total MiLk (<?php echo floor($TotalMilk['quantityOFMilk']/1000); ?> lts)</span></li> 
                    </ul>
                 </div>
                 </div>
           </div>

           <div class="box box-success">
                  <div class="box-header with-border">
                   <h3 class="box-title">Baby Breast Feeding In (24 hrs)</h3>
                  <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                  </div>
                  <div class="box-body">
                     <div id="container" style="width:100%;height:300px;"></div>
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
           <div class="box box-success">
                  <div class="box-header with-border">
                   <h3 class="box-title">Baby KMC Timing</h3>
                  <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                  </div>
                  <div class="box-body">
                  <div class="chart">
                  <canvas id="barChart1" style="height:230px"></canvas>
                  <ul class="fc-color-picker" id="color-chooser">
                      <li><a class="" href="#" style="font-size:15px;color:#fdc80f"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">Total KMC Timing (<?php echo floor(($TotalKMC['kmcTime']/60)/60); ?> hrs)</span></li> 
                    </ul>
                 </div>
                 </div>
           </div>

           <div class="box box-success">
                  <div class="box-header with-border">
                   <h3 class="box-title">Current SSC Babies(Skin To Skin)</h3>
                  <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                  </div>
                  <div class="box-body">
                  <div class="chart">
                  <canvas id="barChart3" style="height:230px"></canvas>
                  <ul class="fc-color-picker" id="color-chooser">
                      <li><a class="" href="#" style="font-size:15px;color:#0073b7"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">X-Axis -> <?php echo $totalsscHrs; ?>hrs SSC Given and Y-Axis -> <?php echo $receivedSccBabyCounting; ?> Babies SSC received</span></li> 
                    </ul>
                 </div>
                 </div>
           </div>

           <div class="box box-success">
                  <div class="box-header with-border">
                   <h3 class="box-title">KMC Given Or Not Given In (24 hrs)</h3>
                  <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                  </div>
                  <div class="box-body">
                     <div id="container1" style="width:100%;height:300px;"></div>
                 </div>
           </div>



          <div class="box box-solid bg-light-blue-gradient">
              <div class="box-header">
                 <div class="pull-right box-tools">
                 </div>
                 <i class="fa fa-map-marker"></i>
                 <h3 class="box-title">
                  KMC Facilities
                 </h3>
              </div>
                <?php foreach($totalLounges as $val){ 
                      $getFacilityData = $this->facility_model->FindMobileForResend($val['FacilityID']);
                      $address_latlng[]=array
                         ( 'title'=>$getFacilityData["Address"],
                           'description'=>'<b>Facility Name:&nbsp;</b>'.$getFacilityData["FacilityName"].'<br/><br/><b>Mobile:</b>&nbsp;'.$getFacilityData["AdministrativeMoblieNo"].'<br/><br/><b>Address:</b>&nbsp;'.$getFacilityData["Address"],
                           'lat'=>$getFacilityData["Latitude"],
                           'lng'=>$getFacilityData["Longitude"]
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
                   </script>
                  <div id="dvMap" style="width:100%; height: 500px;color:black;"></div>
          </div>
          <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Latest Registered Mothers</h3>

                  <div class="box-tools pull-right">
                   <!--  <span class="label label-danger"><a href="<?php //echo base_url();?>Facility/ViewCalendar" style="color:white;">Calender | View</a></span> -->
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
                         <img src="<?php echo base_url();?>assets/images/user.png" alt="User Image" class="img-responsive" style="height:100px;width:100px;">   
                          <?php } else {?>
                          <img src="<?php echo base_url();?>assets/images/mother_images/<?php echo $value['MotherPicture']; ?>" alt="User Image" class="img-responsive" style="height:100px;width:100px;">
                          <?php } ?>
                          
                        <a class="users-list-name" href="<?php echo base_url();?>Admin/ViewMother/<?php echo $value['MotherID'];?>"><img src="<?php echo base_url();?>assets/images/happy-face.png" style="width:25px;height:25px;">&nbsp;<?php
                           echo ucwords($value['MotherName']);?></a>
                        <span class="users-list-date"><?php echo date('d-m-Y g:i A',$value['AddDate']) ?></span>
                      </li>
                  <?php }?>

                  </ul>
                  <!-- /.users-list -->
                </div>
          </div>
             
            <br/> 
      </section>
  </div>         
      </div>
  <?php } else { ?>
       <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-handshake-o"></i></span>
                    <div class="info-box-content">
                     <span class="info">Total Facilities &<br> Total Lounges</span>
                    <span class="info-box-number"><a href=""><?php echo '1'; ?>/<?php echo $counting['lounge']; ?></a></span>
                  </div>
                 </div>
              </div>
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
                    <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                     <span class="info">Total Staff</span>
                    <span class="info-box-number"><a href=""><?php echo $counting['staff']; ?></a></span>
                  </div>
                 </div>
              </div>  
            

        <section class="col-lg-6 connectedSortable">
           <div class="box box-success">
                  <div class="box-header with-border">
                  <h3 class="box-title">Registred Mothers And Babies &nbsp;&nbsp;&nbsp;&nbsp;<button class="btn" style="background:rgba(210, 214, 222, 1);color:black;">Mothers</button>&nbsp;&nbsp;&nbsp;<button class="btn btn-success" style="color:black;">Babies</button></h3>
                  <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                  </div>
                  <div class="box-body">
                  <div class="chart">
                  <canvas id="barChart1" style="height:230px"></canvas>
                 </div>
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
                   $Facilities  = $this->facility_model->GetFacilityListForMap();
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
                          <img src="<?php echo base_url();?>assets/images/user.png" alt="User Image" class="img-responsive" style="height:100px;width:100px;">     
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
    </section>
  </div>
            <script src="https://static.anychart.com/js/8.0.1/anychart-core.min.js"></script>
            <script src="https://static.anychart.com/js/8.0.1/anychart-pie.min.js"></script>
              <canvas id="areaChart" style="height:250px;display:none;"></canvas>
              <canvas id="areaChart1" style="height:250px;display:none;"></canvas>
              <canvas id="areaChart2" style="height:250px;display:none;"></canvas>
              <canvas id="areaChart3" style="height:250px;display:none;"></canvas>
              <canvas id="pieChart" style="height:250px;display:none"></canvas>
              <canvas id="lineChart" style="height:250px;display:none"></canvas>
              <?php
                   $latestMonth=date('M Y');
                 for ($i = 1; $i < 6; $i++) {
                     $month=date(" M Y", strtotime("-$i month"));
                  $array[]=$month;
                  }
                     $FirstDayTimeStamp = strtotime(date('Y-m-01 00:00:00'));  
                     $LastDayTimeStamp = strtotime(date('Y-m-t 23:59:59'));  
                     $GetLM=$this->load->facility_model->GetCurrentMonthRegistredMother($FirstDayTimeStamp,$LastDayTimeStamp);
                     $GetLB=$this->load->facility_model->GetCurrentMonthRegistredBabies($FirstDayTimeStamp,$LastDayTimeStamp);
                     $first_day_this_month = date('Y-m-01 00:00:00');

                         $date = new DateTime(date('Y-m-01 00:00:00'));
                            $date->modify('-1 month');
                         $FirstDay_1 = strtotime($date->format('Y-m-d H:i:s'));
                            $date->modify('-1 month');
                         $FirstDay_2 = strtotime($date->format('Y-m-d H:i:s'));
                            $date->modify('-1 month');
                         $FirstDay_3 = strtotime($date->format('Y-m-d H:i:s'));
                            $date->modify('-1 month');
                         $FirstDay_4 = strtotime($date->format('Y-m-d H:i:s'));
                            $date->modify('-1 month');
                         $FirstDay_5 = strtotime($date->format('Y-m-d H:i:s'));

                         $date = new DateTime(date('Y-m-t 23:59:59'));
                           $monthNumber =date('m', strtotime($array[0]));
                           if($monthNumber == '04' || $monthNumber == '02' || $monthNumber == '06' || $monthNumber == '09' || $monthNumber == '11'|| $monthNumber == '12'){
                              $date->modify('-31 day');
                          }
                         else if($monthNumber == '03' || $monthNumber == '05' || $monthNumber == '07'|| $monthNumber == '08'|| $monthNumber == '09'){ 
                              $date->modify('-30 day');
                            }else{
                              $date->modify('-28 day');
                          }
                         
                         $LastDay_1= strtotime($date->format('Y-m-d H:i:s'));
                          $monthNumber =date('m', strtotime($array[1]));
                         if($monthNumber == '04' || $monthNumber == '02' || $monthNumber == '06' || $monthNumber == '09' || $monthNumber == '11'|| $monthNumber == '12'){
                              $date->modify('-31 day');
                          }
                         else if($monthNumber == '03' || $monthNumber == '05' || $monthNumber == '07'|| $monthNumber == '08'|| $monthNumber == '09'){ 
                              $date->modify('-30 day');
                            }else{
                              $date->modify('-28 day');
                          }
                        
                         $LastDay_2= strtotime($date->format('Y-m-d H:i:s'));
                            $monthNumber =date('m', strtotime($array[2]));
                           if($monthNumber == '04' || $monthNumber == '02' || $monthNumber == '06' || $monthNumber == '09' || $monthNumber == '11'|| $monthNumber == '12'){
                              $date->modify('-31 day');
                          }
                         else if($monthNumber == '03' || $monthNumber == '05' || $monthNumber == '07'|| $monthNumber == '08'|| $monthNumber == '09'){ 
                              $date->modify('-30 day');
                            }else{
                              $date->modify('-28 day');
                          }
                         $LastDay_3= strtotime($date->format('Y-m-d H:i:s'));
                            $monthNumber =date('m', strtotime($array[3]));
                           if($monthNumber == '04' || $monthNumber == '02' || $monthNumber == '06' || $monthNumber == '09' || $monthNumber == '11'|| $monthNumber == '12'){
                              $date->modify('-31 day');
                          }
                         else if($monthNumber == '03' || $monthNumber == '05' || $monthNumber == '07'|| $monthNumber == '08'|| $monthNumber == '09'){ 
                              $date->modify('-30 day');
                            }else{
                              $date->modify('-28 day');
                          }
            
                         $LastDay_4= strtotime($date->format('Y-m-d H:i:s'));
                            $monthNumber =date('m', strtotime($array[4]));
                        if($monthNumber == '04' || $monthNumber == '02' || $monthNumber == '06' || $monthNumber == '09' || $monthNumber == '11'|| $monthNumber == '12'){
                              $date->modify('-31 day');
                          }
                         else if($monthNumber == '03' || $monthNumber == '05' || $monthNumber == '07'|| $monthNumber == '08'|| $monthNumber == '09'){ 
                              $date->modify('-30 day');
                            }else{
                              $date->modify('-28 day');
                          }
                         $LastDay_5= strtotime($date->format('Y-m-d H:i:s'));
                      
                    $GetLM1 = $this->load->facility_model->GetCurrentMonthRegistredMother($FirstDay_1,$LastDay_1);
                    $GetLB1 = $this->load->facility_model->GetCurrentMonthRegistredBabies($FirstDay_1,$LastDay_1);

                    $GetLM2 = $this->load->facility_model->GetCurrentMonthRegistredMother($FirstDay_2,$LastDay_2);
                    $GetLB2 = $this->load->facility_model->GetCurrentMonthRegistredBabies($FirstDay_2,$LastDay_2);

                    $GetLM3 = $this->load->facility_model->GetCurrentMonthRegistredMother($FirstDay_3,$LastDay_3);
                    $GetLB3 = $this->load->facility_model->GetCurrentMonthRegistredBabies($FirstDay_3,$LastDay_3);

                    $GetLM4 = $this->load->facility_model->GetCurrentMonthRegistredMother($FirstDay_4,$LastDay_4);
                    $GetLB4 = $this->load->facility_model->GetCurrentMonthRegistredBabies($FirstDay_4,$LastDay_4);

                    $GetLM5 = $this->load->facility_model->GetCurrentMonthRegistredMother($FirstDay_5,$LastDay_5);
                    $GetLB5 = $this->load->facility_model->GetCurrentMonthRegistredBabies($FirstDay_5,$LastDay_5);


                    $lastesMonthKmc  = $this->load->facility_model->GetCurrentMonthKMC($FirstDayTimeStamp,$LastDayTimeStamp);
                    $lastesMonthKmc1 = $this->load->facility_model->GetCurrentMonthKMC($FirstDay_1,$LastDay_1);
                    $lastesMonthKmc2 = $this->load->facility_model->GetCurrentMonthKMC($FirstDay_2,$LastDay_2);
                    $lastesMonthKmc3 = $this->load->facility_model->GetCurrentMonthKMC($FirstDay_3,$LastDay_3);
                    $lastesMonthKmc4 = $this->load->facility_model->GetCurrentMonthKMC($FirstDay_4,$LastDay_4);
                    $lastesMonthKmc5 = $this->load->facility_model->GetCurrentMonthKMC($FirstDay_5,$LastDay_5);
 
                   $lastesMonthKmc  = floor(($lastesMonthKmc['totalseconds']/60)/60);
                   $lastesMonthKmc1 = floor(($lastesMonthKmc1['totalseconds']/60)/60);
                   $lastesMonthKmc2 = floor(($lastesMonthKmc2['totalseconds']/60)/60);
                   $lastesMonthKmc3 = floor(($lastesMonthKmc3['totalseconds']/60)/60);
                   $lastesMonthKmc4 = floor(($lastesMonthKmc4['totalseconds']/60)/60);
                   $lastesMonthKmc5 = floor(($lastesMonthKmc5['totalseconds']/60)/60);



                    $lastesMonthMilk  = $this->load->facility_model->GetCurrentMonthMilk($FirstDayTimeStamp,$LastDayTimeStamp);
                    $lastesMonthMilk1 = $this->load->facility_model->GetCurrentMonthMilk($FirstDay_1,$LastDay_1);
                    $lastesMonthMilk2 = $this->load->facility_model->GetCurrentMonthMilk($FirstDay_2,$LastDay_2);
                    $lastesMonthMilk3 = $this->load->facility_model->GetCurrentMonthMilk($FirstDay_3,$LastDay_3);
                    $lastesMonthMilk4 = $this->load->facility_model->GetCurrentMonthMilk($FirstDay_4,$LastDay_4);
                    $lastesMonthMilk5 = $this->load->facility_model->GetCurrentMonthMilk($FirstDay_5,$LastDay_5);
              // fpr SKS Baby graph in current hrs wise

                    $currentDate           = date('Y-m-d');
                    $datenTimeBegin        = date($currentDate.' 00:00:01'); 
                    $datenTimeBegin1       = date($currentDate.' 03:59:59'); 
                    $datenTimeBegin2       = date($currentDate.' 07:59:59'); 
                    $datenTimeBegin3       = date($currentDate.' 11:59:59'); 
                    $datenTimeBegin4       = date($currentDate.' 15:59:59'); 
                    $datenTimeBegin5       = date($currentDate.' 19:59:59'); 
                    $datenTimeBegin6       = date($currentDate.' 23:59:59'); 
                  /*  convert in to timestamp*/
                    $SKSdatenTime          = strtotime($datenTimeBegin);
                    $SKSdatenTime1         = strtotime($datenTimeBegin1);
                    $SKSdatenTime2         = strtotime($datenTimeBegin2);
                    $SKSdatenTime3         = strtotime($datenTimeBegin3);
                    $SKSdatenTime4         = strtotime($datenTimeBegin4);
                    $SKSdatenTime5         = strtotime($datenTimeBegin5);
                    $SKSdatenTime6         = strtotime($datenTimeBegin5);
               
     // for Breast Feeding graph in current date
              $StartCurrentdateTime     = date("Y-m-d H:i:s", strtotime('-24 hours', time()));; 
              $EndCurrentdateTime       = date("Y-m-d H:i:s"); 
              $DateStart                = strtotime($StartCurrentdateTime);
              $DateEnd                  = strtotime($EndCurrentdateTime);

              $getExclusiveCurrentDateFeeding = $this->load->facility_model->getExCurrentDateFeeding($DateStart,$DateEnd);
              $getExistFeeding = $this->load->facility_model->getExexistingFeeding($DateStart,$DateEnd);
              $getNonExclusiveCurrentDateFeeding = $this->load->facility_model->getNonExCurrentDateFeeding($DateStart,$DateEnd);
      // for KMC Given or not       
              $getKMCGiven = $this->load->facility_model->getGivenKMC($DateStart,$DateEnd);

                ?>   
     <!--  Mother and Baby Graph -->
<script>
  $(function () {
    var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
    var areaChart = new Chart(areaChartCanvas);
    var areaChartData = {
      labels: ["<?php echo $array['4'];?>", "<?php echo $array['3'];?>", "<?php echo $array['2'];?>", "<?php echo $array['1'];?>", "<?php echo $array['0'];?>", "<?php echo $latestMonth;?>"],
    
      datasets: [
        {
          label: "Electronics",
          fillColor: "rgba(210, 214, 222, 1)",
          strokeColor: "rgba(210, 214, 222, 1)",
          pointColor: "rgba(210, 214, 222, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: [<?php echo $GetLM5;?>, <?php echo $GetLM4;?>, <?php echo $GetLM3;?>, <?php echo $GetLM2;?>, <?php echo $GetLM1;?>, <?php echo $GetLM;?>]
        },
        {
          label: "Digital Goods",
          fillColor: "rgba(60,141,188,0.9)",
          strokeColor: "rgba(60,141,188,0.8)",
          pointColor: "#3b8bba",
          pointStrokeColor: "rgba(60,141,188,1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(60,141,188,1)",
          data: [<?php echo $GetLB5;?>, <?php echo $GetLB4;?>, <?php echo $GetLB3;?>, <?php echo $GetLB2;?>,<?php echo $GetLB1;?>, <?php echo $GetLB;?>]
        }
      ]
    };

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
    var barChartData = areaChartData;
    barChartData.datasets[1].fillColor = "#0073b7";
    barChartData.datasets[1].strokeColor = "#0073b7";
    barChartData.datasets[1].pointColor = "#0073b7";
    barChartData.datasets[0].fillColor = "#f390bd";
    barChartData.datasets[0].strokeColor = "#f390bd";
    barChartData.datasets[0].pointColor = "#f390bd";
    var barChartOptions = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };

    barChartOptions.datasetFill = false;
    barChart.Bar(barChartData, barChartOptions);
  });

  /********************************* kmc Bar chart *************************************/

  $(function () {
    var areaChartCanvas1 = $("#areaChart1").get(0).getContext("2d");
    var areaChart1 = new Chart(areaChartCanvas1);
    var areaChartData1 = {
      labels: ["<?php echo $array['4'];?>", "<?php echo $array['3'];?>", "<?php echo $array['2'];?>", "<?php echo $array['1'];?>", "<?php echo $array['0'];?>", "<?php echo $latestMonth;?>"],
    
      datasets: [
        {
          label: "Electronics",
          fillColor: "rgba(210, 214, 222, 1)",
          strokeColor: "rgba(210, 214, 222, 1)",
          pointColor: "rgba(210, 214, 222, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: [<?php echo $lastesMonthKmc5;?>, <?php echo $lastesMonthKmc4;?>, <?php echo $lastesMonthKmc3;?>, <?php echo $lastesMonthKmc2;?>, <?php echo $lastesMonthKmc1;?>, <?php echo $lastesMonthKmc;?>]
        }
      ]
    };

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas1 = $("#barChart1").get(0).getContext("2d");
    var barChart1 = new Chart(barChartCanvas1);
    var barChartData1 = areaChartData1;
    barChartData1.datasets[0].fillColor = "#fdc80f ";
    barChartData1.datasets[0].strokeColor = "#fdc80f ";
    barChartData1.datasets[0].pointColor = "#fdc80f ";
    var barChartOptions1 = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };

    barChartOptions1.datasetFill = false;
    barChart1.Bar(barChartData1, barChartOptions1);
  });




  /********************************* Milk Status BAR CHART *************************************/

  $(function () {
    var areaChartCanvas2 = $("#areaChart2").get(0).getContext("2d");
    var areaChart2 = new Chart(areaChartCanvas2);
    var areaChartData2 = {
      labels: ["<?php echo $array['4'];?>", "<?php echo $array['3'];?>", "<?php echo $array['2'];?>", "<?php echo $array['1'];?>", "<?php echo $array['0'];?>", "<?php echo $latestMonth;?>"],
    
      datasets: [
        {
          label: "Electronics",
          fillColor: "rgba(210, 214, 222, 1)",
          strokeColor: "rgba(210, 214, 222, 1)",
          pointColor: "rgba(210, 214, 222, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: [<?php echo floor($lastesMonthMilk5['quantityOFMilk']/1000);?>, <?php echo floor($lastesMonthMilk4['quantityOFMilk']/1000);?>, <?php echo floor($lastesMonthMilk3['quantityOFMilk']/1000);?>, <?php echo floor($lastesMonthMilk2['quantityOFMilk']/1000);?>, <?php echo floor($lastesMonthMilk1['quantityOFMilk']/1000);?>, <?php echo floor($lastesMonthMilk['quantityOFMilk']/1000);?>]
        }
      ]
    };

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas2 = $("#barChart2").get(0).getContext("2d");
    var barChart2 = new Chart(barChartCanvas2);
    var barChartData2 = areaChartData2;
    barChartData2.datasets[0].fillColor = "#f88641";
    barChartData2.datasets[0].strokeColor = "#f88641";
    barChartData2.datasets[0].pointColor = "#f88641";
    var barChartOptions2 = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };

    barChartOptions2.datasetFill = false;
    barChart2.Bar(barChartData2, barChartOptions2);
  });

 /********************************* SCS Baby BAR CHART *************************************/

  $(function () {
    var areaChartCanvas2 = $("#areaChart3").get(0).getContext("2d");
    var areaChart2 = new Chart(areaChartCanvas2);
    var areaChartData2 = {
      labels: ['0 - 4','4 - 8','8 - 12','12 - 16','16 - 20','20 - 24'],
    
      datasets: [
        {
          label: "Electronics",
          fillColor: "rgba(210, 214, 222, 1)",
          strokeColor: "rgba(210, 214, 222, 1)",
          pointColor: "rgba(210, 214, 222, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: [<?php echo floor($status1);?>,<?php echo floor($status2);?>,<?php echo floor($status3);?>,<?php echo floor($status4);?>,<?php echo floor($status5);?>,<?php echo floor($status6);?>]
        }
      ]
    };

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas2 = $("#barChart3").get(0).getContext("2d");
    var barChart2 = new Chart(barChartCanvas2);
    var barChartData2 = areaChartData2;
    barChartData2.datasets[0].fillColor = "#0073b7";
    barChartData2.datasets[0].strokeColor = "#0073b7";
    barChartData2.datasets[0].pointColor = "#0073b7";
    var barChartOptions2 = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };

    barChartOptions2.datasetFill = false;
    barChart2.Bar(barChartData2, barChartOptions2);
  });  


</script>
<script>
  // for Breast Feeding
anychart.onDocumentReady(function() {
<?php  $notReceive=($TotalAdmittedChild - $getExistFeeding); 
$notReceivePercent = round(((100*$notReceive)/$TotalAdmittedChild),1).'%';
$ExclusivePercent  = round(((100*$getExclusiveCurrentDateFeeding)/$TotalAdmittedChild),1).'%';
$NonExclusivePercent  = round(((100*$getNonExclusiveCurrentDateFeeding)/$TotalAdmittedChild),1).'%';
?>
  // set the data
  var data = [
      {x: "Total Babies: <?php echo $TotalAdmittedChild; ?>"},
      {x: "Not Received Babies: <?php echo $notReceive; ?> (<?php echo $notReceivePercent; ?>)", value: <?php echo $notReceive; ?>},
      {x: "Received Babies: <?php echo ($TotalAdmittedChild - $notReceive); ?>"},
      {x: "Exclusive: <?php echo $getExclusiveCurrentDateFeeding; ?> (<?php echo $ExclusivePercent; ?>)", value: <?php echo $getExclusiveCurrentDateFeeding; ?>},
      {x: "Non Exclusive: <?php echo $getNonExclusiveCurrentDateFeeding; ?> (<?php echo $NonExclusivePercent; ?>)", value: <?php echo $getNonExclusiveCurrentDateFeeding; ?>}
  ];

  // create the chart
  var chart = anychart.pie();

  // set the chart title
  chart.title("");

  // add the data
  chart.data(data);
  
  // sort elements
  chart.sort("desc");  
  
  // set legend position
  chart.legend().position("right");
  // set items layout
  chart.legend().itemsLayout("vertical");  

  // display the chart in the container
  chart.container('container');
  chart.draw();

});


// for KMC given or not given
anychart.onDocumentReady(function() {
<?php 
$kmcNotGiven = ($TotalAdmittedChild - $getKMCGiven);
$kmcNotGivenPercent = round(((100*$kmcNotGiven)/$TotalAdmittedChild),1).'%';
$kmcGivenPercent = round(((100*$getKMCGiven)/$TotalAdmittedChild),1).'%';
?>
  // set the data
  var data = [
  {x: "Total Babies: <?php echo $TotalAdmittedChild; ?>"},
  {x: "KMC Given: <?php echo $getKMCGiven; ?> (<?php echo $kmcGivenPercent; ?>)", value: <?php echo $getKMCGiven; ?>,
   normal:  {fill: "#404040"},
   hovered: {fill: "#404040"}
  },
  {x: "KMC Not Given: <?php echo $kmcNotGiven; ?> (<?php echo $kmcNotGivenPercent; ?>)", value: <?php echo $kmcNotGiven; ?>,
   normal:  {
              fill: "#ffff00",
              hatchFill: "percent50"        
            },
   hovered: {
              fill: "#ffff00",
              hatchFill: "percent50"
            }
  }
  ];

  // create the chart
  var chart = anychart.pie();

  // set the chart title
  chart.title("");

  // add the data
  chart.data(data);
  
  // sort elements
  chart.sort("desc");  
chart.normal().fill("#48574", 0.5);
chart.hovered().fill("#669999", 0.3);

  // set legend position
  chart.legend().position("right");
  // set items layout
  chart.legend().itemsLayout("vertical");  

  // display the chart in the container
  chart.container('container1');
  chart.draw();

});
</script>
</body>
</html>
