<?php
 $loungeId    = $this->uri->segment('4');
 $GetFacility = $this->FacilityModel->GetFacilitiesID($loungeId);
 $type  = $this->uri->segment(3);
  if(isset($_GET['type'])){ 
    $babyStatus = $_GET['type']; 
    $fromDate = $_GET['fromDate']; 
    $toDate = $_GET['toDate']; 
  } else { 
    if($type == 4){
      $fromDate = date('Y-m-d');
      $toDate = date('Y-m-d');
    } else {
      $fromDate = ''; 
      $toDate = '';
    }
    $babyStatus = $type;
  }
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'Manage Babies '; if($loungeId != 'all') {
       ?>(<?php echo $GetFacility['loungeName']; ?>) <?php } ?>
      </h1>
       <ol class="breadcrumb">
        <li style="text-align:right;"><small><b>Temperature:</b>&nbsp;(&lt; 95.9 - &gt; 99.5)&nbsp;<b>|</b>&nbsp; <b>SpO2:</b>&nbsp;(&lt; 95)&nbsp;<b>|</b>&nbsp; <b>Heart Beat:</b>&nbsp;(&lt; 75 - &gt; 200)&nbsp;<b>|</b>&nbsp; <b>Breath Count:</b>&nbsp;(&lt; 30 - &gt; 60)</small></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
           <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
              <div class="row" style="padding-right: 25px; padding-left: 25px;margin-top: 5px;">
                 <div class="col-md-5">
                     <span style="font-size: 20px;">Manage Resources:</span>
                      [<a href="" data-toggle="modal" data-target="#dfdModal">DataFlow Diagram</a>]
                      [<a href="" data-toggle="modal" data-target="#myModal">Functional Diagram</a>]
                    <?php if(isset($totalResult)) { 
                        ($pageNo == '1') ?  $counter = '1' : $counter = ((($pageNo*100)-100) + 1);
                        echo '<br>Showing '.$counter.' to '.((($pageNo*100)-100) + 100).' of '.$totalResult.' entries';
                     } ?>
                </div>
              </div>

              <div class="row">
                <form action="" method="GET">
                  <div class="col-sm-12 col-md-12">
                    <div class="col-md-5" style="padding: 0;">
                      <div class="col-md-6">
                        <label>From:</label>
                        <input type="date" name="fromDate" class="form-control" value="<?php echo $fromDate; ?>">
                      </div>
                      <div class="col-md-6">
                        <label>To:</label>
                        <input type="date" name="toDate" class="form-control" value="<?php echo $toDate; ?>">
                      </div>
                    </div>

                    <div class="col-md-7" style="padding: 0;">
                      <div class="col-md-6">
                        <label>Category:</label>
                        <select name="type" class="form-control" id="selectValue1">
                          <option value="1" <?php echo ($babyStatus == '1') ? 'selected' : ''; ?>>Total Babies</option>
                          <option value="2" <?php echo ($babyStatus == '2') ? 'selected' : ''; ?>>Admitted Babies</option>
                          <option value="3" <?php echo ($babyStatus == '3') ? 'selected' : ''; ?>>Discharged Babies</option>
                        </select>
                      </div>
                       <div class="col-md-6">
                        <label>Keyword:</label>
                            <div class="input-group pull-right">
                                <input type="text" class="form-control" placeholder="Enter Keyword Value" 
                                       name="keyword" value="<?php
                                       if (!empty($_GET['keyword'])) {
                                           echo $_GET['keyword'];
                                       }
                                       ?>">

                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                                </span>

                            </div>
                             <br><span style="font-size:12px;">Search via: Mother Name, Reg No, Delivery Type and Gender.</span>
                       </div>
                    </div>
                  </div>
                </form>
              </div> 

            <div class="box-body">
              <div class="col-sm-12" style="overflow: auto;">
                <table cellpadding="0" cellspacing="0" border="0"
                  class="table-striped table table-bordered example" id="example">
                  <thead>
                  <tr>
                    <th>S&nbsp;No.</th>
                    <th>Status</th>
                    <th>Action</th>
                    <?php if($loungeId == 'all') { ?>
                      <th>Lounge&nbsp;Name</th>
                    <?php } ?>
                    <th>Generate&nbsp;PDF</th>
                    <th>Baby&nbsp;Photo</th>
                    <th>Baby&nbsp;Of</th>
                    <th>Baby File ID</th>
                    <th>Total&nbsp;KMC&nbsp;Time</th>
                    <th>Latest&nbsp;24 Hrs&nbsp;KMC</th>
                    <th>Total&nbsp;Milk&nbsp;Qty.</th>
                    <th>Comments</th>
                    <th>Delivery&nbsp;Date&nbsp;&&nbsp;Time</th>
                    <th>Gender</th>
                    <th>Delivery&nbsp;Type</th>
                    <th>Born&nbsp;Type</th>
                    <th>Outborn&nbsp;Value</th>
                    <th>Apgar&nbsp;OneMinute</th>
                    <th>Apgar&nbsp;FiveMinute</th>
                    <th>Vitamin&nbsp;K&nbsp;Given</th>
                    <th>Reg.&nbsp;Date&nbsp;&&nbsp;Time</th>  
                    <th>Last&nbsp;Assessment</th>  
                    <th>Nurse&nbsp;Name/Sign</th>  
                    
                  </tr>
                  </thead>

                  <tbody>
                    <?php
                    ($pageNo == '1') ? $counter = '1' : $counter = ((($pageNo*100)-100) + 1); 
                    foreach ($results as $value1) { 
                      $babyRecord          = $this->BabyModel->GetBabyViaBabyId('babyRegistration',$value1['babyId']);
                      $babyAdmissionData   = $this->BabyModel->GetBabyViaBabyId('babyAdmission',$value1['babyId']);
                      
                      $get_last_assessment = $this->BabyModel->getMonitoringExistData($value1['babyId'],$value1['id'],$value1['loungeId']);

                      $getCommentData = $this->BabyModel->getCommentList(2,2,$value1['babyId'],$value1['id']);
                      
                      $babyIconStatus      = $this->DangerSignModel->getBabyIcon($get_last_assessment);
                      $motherName          = $this->BabyModel->singlerowparameter2('motherName','motherId',$babyRecord['motherId'],'motherRegistration');
                      $getKMCTime          = $this->DashboardDataModel->getTotalKmc($value1['id']);
                      $getMilkQty          = $this->BabyModel->getTotalMilk($value1['id']);
                      $lastAdmissionID     = $this->MotherModel->GetLastAsessment('motherAdmission','motherId',$babyRecord['motherId']);
              
                      $latestEndKmcTime    = time();
                      $latestStartKmcTime  = strtotime(date("Y-m-d H:m:s", strtotime('-24 hours',time())));
                      $latestKMCTime       = $this->DashboardDataModel->getLatestKMC($latestStartKmcTime,$latestEndKmcTime,$value1['id']);

                      $getAdmissionData = $this->db->get_where('motherAdmission',array('motherId'=>$babyRecord['motherId']));
                      $checkAdmission = $getAdmissionData->num_rows();

                      $GetFacility   = $this->FacilityModel->GetFacilitiesID($value1['loungeId']);

                      // set variables for td


                      $babyOf   = !empty($checkAdmission) ? "<a href='".base_url()."motherM/viewMother/".$lastAdmissionID['id']."'>".$motherName."</a>" : "<a href='' data-toggle='modal' data-target='#motherInfoModal'>UNKNOWN</a>";

                      if($GetFacility['type'] == 1){
                        $babyFileId   = !empty($value1['temporaryFileId']) ? $value1['temporaryFileId'] : 'N/A';
                      }else{
                        $babyFileId   = !empty($value1['babyFileId']) ? $value1['babyFileId'] : 'N/A';
                      }


                        // set danger Icon and mother photo
                        if($babyIconStatus == '1') { 
                          $topMargin = "";
                          $icon="<img src='".base_url()."assets/images/happy-face.png' class='iconSet'>";
                        }else if($babyIconStatus == '0') {
                          $topMargin = "";
                          $icon = "<img src='".base_url()."assets/images/sad-face.png' class='iconSet'>";
                        }else{
                          $icon = "";
                          $topMargin = "margin-top:5%";
                        }
                        $babyPhoto    = empty($babyRecord['babyPhoto']) ? "<img  src='<?php echo base_url();?>assets/images/baby.png' class='img-responsive motherImage' style=".$topMargin.">" : "<img  src='".babyDirectoryUrl.$babyRecord['babyPhoto']."' class='img-responsive motherImage' style=".$topMargin.">";
                     
                      if(!empty($getKMCTime['kmcTime'])){
                        $hours  = floor($getKMCTime['kmcTime'] / 3600);
                        ($hours == '1') ?  $unit = "Hr" : $unit = "Hrs";
                     
                        $minutes = floor(($getKMCTime['kmcTime'] / 60) % 60);
                        $totalKmcTime = $hours.' '.$unit.' '.$minutes.' Mins';
                      }else{
                        $totalKmcTime = '--';
                      }

                    // latest 24 four hrs kmc timing
                      if(!empty($latestKMCTime['kmcTimeLatest'])){
                        $hours  = floor($latestKMCTime['kmcTimeLatest'] / 3600);
                        ($hours == '1') ?  $unit = "Hr" : $unit = "Hrs";
                     
                        $minutes = floor(($latestKMCTime['kmcTimeLatest'] / 60) % 60);
                        $totalKmcTime1 = $hours.' '.$unit.' '.$minutes.' Mins';
                      }else{
                        $totalKmcTime1 = '--';
                      }


                      
                       if($getMilkQty['quantityOFMilk'] == '0.00'){
                         $totalMilk    = 'N/A';
                       }else{
                         $totalMilk    = !empty($getMilkQty['quantityOFMilk']) ? $getMilkQty['quantityOFMilk'].' ml' : '--';
                       }

                      $deliveryDateT = $babyRecord['deliveryDate'].'&nbsp;'.date('g:i A',strtotime($babyRecord['deliveryTime']));        
                      $LstMonitoring = !empty($get_last_assessment['addDate']) ? date('d-m-Y g:i A', strtotime($get_last_assessment['addDate'])) : 'N/A';        
                     
                      if($babyAdmissionData['status'] == '2') { 
                        $getStaffName     = $this->db->get_where('staffMaster',array('staffId'=>$value1['dischargeByNurse']))->row_array(); 
                        $nurseName        = "<a href='".base_url()."staffM/updateStaff/".$value1['dischargeByNurse']."'>".$getStaffName['name']."</a>";
                        $status           = '<span class="label label-success">Discharged</span>';
                        // $nurseSign    =  empty($value1['DoctorSign']) ? "N/A" : "<img  src='".base_url()."assets/images/sign/".$value1['DoctorSign']."' class='signatureSize'>";
                      }else if($babyAdmissionData['status'] == '1'){ 
                        $getCheckListData = $this->db->order_by('id', 'desc')->get_where('admissionCheckList',array('babyAdmissionId'=>$value1['id']))->row_array(); 
                        $getStaffName1    = $this->db->get_where('staffMaster',array('staffId'=>$getCheckListData['nurseId']))->row_array();
                        $nurseName        = "<a href='".base_url()."staffM/updateStaff/".$getCheckListData['nurseId']."'>".$getStaffName1['name']."</a>";
                        $status           = '<span class="label label-warning">Admitted</span>';

                      } 


                       $getNurseSign =  $this->db->order_by('id', 'desc')->get_where('admissionCheckList',array('babyAdmissionId'=>$value1['id']))->row_array();
                       $nurseSign    =  empty($getNurseSign['nurseDigitalSign']) ? "N/A" : "<img  src='".signDirectoryUrl.$getNurseSign['nurseDigitalSign']."' class='signatureSize'>";
                      ?>
                      <tr>
                        <td><?php echo $counter; ?></td>
                        <td><?php echo $status; ?></td>
                        <td><a href="<?php echo base_url();?>babyM/viewBaby/<?php echo $value1['id']; ?>" class="btn btn-info btn-sm">View Baby Details</a></td>
                        <?php if($loungeId == 'all') { ?>
                          <td><?= $GetFacility['loungeName']; ?></td>
                        <?php } ?>
                        <td>
                          <a href="<?php echo base_url();?>babyM/BabyAdmissionPDF/<?php echo $value1['id'] ?>" class="btn btn-info btn-xs">Admission PDF</a>
                          <a href="<?php echo base_url();?>babyM/BabyWeightPDF/<?php echo $value1['id'] ?>" class="btn btn-info btn-xs" style="margin-top: 2px;">DailyWeight PDF</a>
                          <a href="<?php echo base_url();?>babyM/BabyKmcPDF/<?php echo $value1['id'] ?>" class="btn btn-info btn-xs" style="margin-top: 2px;">DailyKMC PDF</a>
                          <a href="<?php echo base_url();?>babyM/BabyFeedingPDF/<?php echo $value1['id'] ?>" class="btn btn-info btn-xs" style="margin-top: 2px;">Feeding PDF</a>
                          <?php if($value1['status'] == '2') { ?>
                            <a href="<?php echo base_url();?>babyM/BabyDischargePdf/<?php echo $value1['id'] ?>" class="btn btn-info btn-xs" style="margin-top: 2px;">Discharged PDF</a>
                           <?php } ?>
                        </td>
                        <td><?php echo '<span style="left:78%;position:relative;top:3px">'.$icon.'</span>'.$babyPhoto; ?></td>
                        <td><?php echo $babyOf; ?></td>
                        <td><?php echo $babyFileId; ?></td>
                        <td><?php echo $totalKmcTime; ?></td>
                        <td><?php echo $totalKmcTime1; ?></td>
                        <td><?php echo $totalMilk; ?></td>
                        <td><?php echo !empty($getCommentData) ? '<a href="'.base_url().'babyM/viewBaby/'.$value1['id'].'/comment">'.$getCommentData.'</a>' : 'N/A'; ?></td>
                        <td><?php echo $deliveryDateT; ?></td>
                        <td><?php echo $babyRecord['babyGender']; ?></td>
                        <td><?php echo $babyRecord['deliveryType']; ?></td>
                        <td><?php echo !empty($babyRecord['typeOfBorn']) ? $babyRecord['typeOfBorn'] : 'N/A'; ?></td>
                        <td><?php echo !empty($babyRecord['typeOfOutBorn']) ? $babyRecord['typeOfOutBorn'] : 'N/A'; ?></td>
                        <td><?php echo !empty($babyRecord['apgarAtOneMinute']) ? $babyRecord['apgarAtOneMinute'] : 'N/A'; ?></td>
                        <td><?php echo !empty($babyRecord['apgarAtFiveMinute']) ? $babyRecord['apgarAtFiveMinute'] : 'N/A'; ?></td>
                        <td><?php echo !empty($babyRecord['vitaminKGiven']) ? $babyRecord['vitaminKGiven'] : 'N/A'; ?></td>
 
                        <td><?php echo date('d-m-Y g:i A', strtotime($value1['addDate'])); ?></td>
                        <td><?php echo $LstMonitoring; ?></td>
                        <td><?php echo $nurseName.'<br>'.$nurseSign; ?></td>
                        
                      </tr>
                   <?php $counter ++ ; } ?>
                  </tbody>
                </table>
                  <ul class="pagination pull-right">
                    <?php
                      foreach ($links as $link) {
                          echo "<li>" . $link . "</li>";
                      }
                     ?>
                  </ul> 
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>


  <div class="modal fade" id="motherInfoModal" role="dialog">
    <div class="modal-dialog modal-lg" style="width:1100px !important">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Mother Information</h4>
        </div>
        <div class="modal-body text-center"><br><br>
          <h3>Coming Soon...</h3><br>
        </div>
      </div>
    </div>
  </div>



<!-- dfd and functional -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Manage Babies Functional Diagram</h4>
        </div>
        <div class="modal-body" >
         <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/BabyRegistrationProcess.png') ;?>" style="height:720px;width:100%;"> 
        </div>
      </div>
      
    </div>
  </div>

  <div class="modal fade" id="dfdModal" role="dialog">
    <div class="modal-dialog modal-lg" style="width:1100px !important">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Manage Babies DataFlow Diagram (DFD)</h4>
        </div>
        <div class="modal-body" style="padding:0px !important;">
          <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/ManagebabyDfd.png') ;?>" style="height:950px;width:100%;">
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript">
  window.onload = function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script> 

<script type="text/javascript">
  $(document).ready(function(){
  $("#selectValue").change(function(){
   var status11 = $(this).val();
     if(status11 == 1){
       window.location.href = "<?php echo base_url().'babyM/registeredBaby/1/'.$loungeId; ?>";
     }else if(status11 == 2){
       window.location.href = "<?php echo base_url().'babyM/registeredBaby/2/'.$loungeId; ?>";
     }else if(status11 == 3){
       window.location.href = "<?php echo base_url().'babyM/registeredBaby/3/'.$loungeId; ?>";
     }
  });
});
</script>