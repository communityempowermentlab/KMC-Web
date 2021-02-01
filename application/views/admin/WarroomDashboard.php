  <?php 
    $adminData = $this->session->userdata('adminData');  
    $QuickEmail = $this->load->FacilityModel->getQuickEmail();
    $TotalMilk = $this->db->query("SELECT sum(milkQuantity) as quantityOFMilk FROM `babyDailyNutrition`")->row_array();
    $TotalKMC = $this->db->query("SELECT @totsec:=sum(TIME_TO_SEC(subtime(endTime,startTime))) as kmcTime, floor(@totsec/3600) as Hours, (@totsec%3600)/60 as Minutes, (@totsec%60) as seconds from `babyDailyKMC` where startTime < endTime")->row_array();
  ?>
   <style type="text/css">
   .widthCounting{
    width:100%;
  }
     .countingsize{
    height: auto;
    border-radius: 29px;
    text-align: center;
    background-color: #f39c12;
    color: #fff;
    padding: 2px 22px 2px 22px;
    width:100%;
     }
.incode{
  border-top: 2px #80777729 solid;
}.goodLook{
border-bottom: 2px #7b74741c solid;
padding: 4px 0px;
margin-bottom: 3px;
margin-right: 0px;
margin-left: -10px;
}
.textFormat{
  text-align: center;font-weight:600;font-size:18px;
}.boldtext{
  font-weight:600;
}.proper-format{
    border-right: 2px solid #80777729;
    padding: 8px 0px 8px 0px;
}
   </style>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

          <h1>
            War-Room Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
    
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
        
      </div> 
<?php if($adminData['Type'] == 1){?>       
      <div class="row">

           <?php foreach ($totalLounges as $key => $value) {
           $TotalBaby = count($this->db->query("SELECT * from babyAdmission where status='1' and loungeId=".$value['loungeId']."")->result_array());
           $TotalAdmittedMother = count($this->db->query("SELECT * from motherAdmission where status='1' and loungeId=".$value['loungeId']."")->result_array());
           $getLastDutyData = $this->db->query("SELECT * FROM `nurseDutyChange` INNER JOIN babyAdmission on `nurseDutyChange`.babyAdmissionId = `babyAdmission`.id where `babyAdmission`.loungeId ='".$value['loungeId']."' ORDER BY nurseDutyChange.`id` DESC")->row_array();
           $getLastDutyNurseName  = $this->db->query("select * from staffMaster where staffId='".$getLastDutyData['nextDutyNurseId']."' and status='1'")->row_array();
           $getMoicData  = $this->db->query("select * from staffMaster where facilityId='".$value['facilityId']."' and staffSubType='6' and status='1'")->row_array();
           $getStable = $this->db->query("SELECT * from babyAdmission as ba inner join babyDailyMonitoring as bm on bm.`babyAdmissionId`=ba.`id` where ba.`loungeId`=".$value['loungeId']." and ba.`status`='1' order by bm.id desc")->result_array();         
                $stablecount   = 1 ;
                $unstablecount = 1;
                $stable=0;
                $unstable=0;
                $status1=0;
                $status2=0;
                $status3=0;
                foreach ($getStable as $key => $value1) {
                $get_last_assessment = $this->db->query("SELECT * from babyDailyMonitoring where babyAdmissionId=".$value1['id']." order by id desc limit 0,1")->row_array();
                if($get_last_assessment['respiratoryRate'] > 60 || $get_last_assessment['respiratoryRate'] < 30){
                  $status1 = '1';
                                  
                 }

                if($get_last_assessment['temperatureValue'] < 95.9 || $get_last_assessment['temperatureValue'] > 99.5){
                  $status2 = '1';

                 }
                if($get_last_assessment['spo2'] < 95 && $get_last_assessment['isPulseOximatoryDeviceAvail']=="Yes"){
                  $status3 = '1';

                 }                
                if($status1 == '1' && $status2 == '1' && $status3 == '1'){ 
                  $unstable += $unstablecount;
                }else{
                      $stable += $stablecount;
                      }
               }


            ?>
              <div class="col-md-4 col-sm-6 col-xs-12">
                  <div class="info-box" style="margin-bottom: 0px;">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-hospital-o"></i></span>
                    <div class="info-box-content" style="padding-top:0px !important;">
                     <span class="info textFormat"><a href="<?php echo base_url();?>loungeM/updateLounge/<?php echo $value['loungeId'];?>"><?php echo $value['loungeName']; ?></a></span><br>
                     <span style="color:black;font-weight:600;">Nurse On Duty &nbsp;&nbsp;</span>: 
                     <?php if($getLastDutyNurseName['name'] != '') { ?>
                     <a href="<?php echo base_url().'staffM/updateStaff/'.$getLastDutyData['nextDutyNurseId'] ?>"><?php echo $getLastDutyNurseName['name']; ?></a>
                   <?php } else { echo 'N/A'; } ?><br>
                     <span style="color:black;font-weight:600;">Mobile Number </span>: <?php echo ($getLastDutyNurseName['staffMobileNumber'] != '') ? $getLastDutyNurseName['staffMobileNumber'] : 'N/A'; ?><br>
                     <span style="color:black;font-weight:600;">Duty Date time &nbsp;</span>: <?php echo ($getLastDutyData['addDate'] != '') ? date("d-m-Y g:i A", strtotime($getLastDutyData['addDate'])) : 'N/A'; ?><br>
                  </div>
                 </div>
                 <div class="info-box incode">
                   <div style="margin-left:10px;margin-top: 6px"> 
                    <div class="row goodLook text-center">
                          <div class="col-lg-6 col-md-6 proper-format">
                           <img src="<?php echo base_url();?>assets/images/sad-face.png" style="width:30px;height:30px;"><br>
                           <?php echo $unstable; ?>
                          </div>
                          <div class="col-lg-6 col-md-6" style="padding: 8px 0px 8px 0px;">
                           <img src="<?php echo base_url();?>assets/images/happy-face.png" style="width:30px;height:30px;"><br>
                           <?php echo $stable; ?>
                          </div>
                    </div>
                      
                      
                    <div class="row goodLook">
                          <div class="col-lg-6 col-md-6">
                            <b class="boldtext"><span class="fa fa-female"></span>&nbsp;Admitted Mothers</b>
                          </div>
                          <div class="col-lg-6 col-md-6">
                            <div class="countingsize text-center"><?php echo $TotalAdmittedMother; ?></div>
                          </div>
                    </div>


                    <div class="row goodLook">
                          <div class="col-lg-6 col-md-6" style="padding-right: 0px;">
                            <b class="boldtext"><span class="fa fa-child"></span>&nbsp;Admitted Babies</b>
                          </div>
                          <div class="col-lg-6 col-md-6">
                           <div class="countingsize text-center"><?php echo $TotalBaby; ?></div>
                          </div>
                    </div>

                    <div class="row goodLook">
                          <div class="col-lg-6 col-md-6" style="padding-right: 0px;">
                            <b class="boldtext"><span class="fa fa-user"></span>&nbsp;MOIC Name</b>
                          </div>
                          <div class="col-lg-6 col-md-6">
                           <div class="countingsize text-center">
                            <?php
                                if(strlen($getMoicData['name']) > 14) 
                                {
                                  $moicName = substr($getMoicData['name'],0,14).'..';
                                }else{
                                  $moicName = $getMoicData['name'];
                                }
                             echo ($getMoicData['name'] != "") ? $moicName : 'N/A';?></div>
                          </div>
                    </div>

                    <div class="row goodLook">
                          <div class="col-lg-6 col-md-6" style="padding-right: 0px;">
                            <b class="boldtext"><span class="fa fa-phone"></span>&nbsp;MOIC Number</b>
                          </div>
                          <div class="col-lg-6 col-md-6">
                           <div class="countingsize text-center"><?php echo ($getMoicData['staffMobileNumber'] != "") ? $getMoicData['staffMobileNumber'] : 'N/A'; ?></div>
                          </div>
                    </div>

                   </div>
                 </div>
              </div>              
            <?php } ?>

          <!--  <span class="info-box-number"><a href="<?php echo base_url('facility/manageFacility'); ?>"><?php echo $counting['facility']; ?>/<?php echo $counting['lounge']; ?></a></span> -->

    

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
                   $Facilities  = $this->FacilityModel->GetFacilityListForMap();
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

     <!--  Mother and Baby Graph -->


</body>
</html>
