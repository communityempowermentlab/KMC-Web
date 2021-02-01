<?php
  $loungeId      = $this->uri->segment('3');
  $GetFacility   = $this->FacilityModel->GetFacilitiesID($loungeId);
  
    if($GetFacility['type'] == 1){
      $regNumberHeading   = "SNCU&nbsp;Reg.&nbsp;Number";
    }else{
      $regNumberHeading   = "Registration&nbsp;No.";
    }
  if(isset($_GET['motherStatus'])){
    $motherStatus = $_GET['motherStatus']; 
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];
  } else {
    $type      = $this->uri->segment('4');
    if($type != ''){
      $fromDate = '';
      $toDate = '';
    } else {
      $fromDate = date('Y-m-d');
      $toDate = date('Y-m-d');
    }
    $motherStatus = $type;
  }
?>

<input type="hidden" id="loungeidNumber" value="<?php echo $loungeId; ?>">
<style type="text/css">
  .dt-buttons, .cg_filter{ display: inline !important; width: 50% !important; float: left; }
</style>
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1><?php echo 'Manage Mothers'; if($loungeId != 'all') { ?> (<?php  echo $GetFacility['loungeName'];  ?>)<?php } ?></h1>
           <ol class="breadcrumb">
            <li>
              <small>
                <b>Temperature:</b>&nbsp;(< 95.9 - > 99.5)<b>&nbsp;|&nbsp;</b><b>Heart Beat:&nbsp;</b>(< 50 - > 120)<b>&nbsp;|&nbsp;</b><b>Systolic:</b>&nbsp;(>= 140 - <= 90)<b>&nbsp;|&nbsp;</b><b>Diastolic:</b>&nbsp;(>= 90 - <= 60)
              </small>
            </li>
          </ol>  
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="row" style="padding-right: 25px; padding-left: 25px;margin-top: 5px;">
                 <div class="col-md-5">
                   <span style="font-size: 18px;">Manage Resources:</span>
                    [<a href="" data-toggle="modal" data-target="#dfdModal">DataFlow Diagram</a>]
                   [<a href="" data-toggle="modal" data-target="#myModal">Functional Diagram</a>]
                <?php if(isset($totalResult)) { 
                    ($pageNo == '1') ?  $counter = '1' : $counter = ((($pageNo*100)-100) + 1);
                    echo '<br>Showing '.$counter.' to '.((($pageNo*100)-100) + 100).' of '.$totalResult.' entries';
                 } ?>
                 </div>
           
              </div> 

              <div class="row">
                <div class="col-sm-12 col-md-12">
                  <form action="" method="GET">
                  <div class="col-md-5" style="padding: 0;">
                    <div class="col-md-6">
                      <label>From:</label>
                      <input type="date" name="fromDate" class="form-control" value="<?= $fromDate; ?>">
                    </div>
                    <div class="col-md-6">
                      <label>To:</label>
                      <input type="date" name="toDate" class="form-control" value="<?= $toDate; ?>">
                    </div>
                  </div>

                  <div class="col-md-7" style="padding: 0;">

                   <div class="col-md-6">
                    <label>Category:</label>
                     <select name="motherStatus" class="form-control" id="selectValue1">
                       <option value="total">Total Mothers</option>
                       <option value="admitted" <?php echo ($motherStatus == 'admitted') ? 'selected' : ''; ?>>Admitted Mothers</option>
                       <option value="currentlyAvail" <?php echo ($motherStatus == 'currentlyAvail') ? 'selected' : ''; ?>>Currently Admitted Mothers</option>
                       <option value="dischargedMother" <?php echo ($motherStatus == 'dischargedMother') ? 'selected' : ''; ?>>Discharged Mothers</option>
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
                         <br><span style="font-size:12px;">Search via: Mother Name, Reg No and Mobile No.</span>
                    
                   </div>

                  </div>
                  </form>
                </div>

              </div> 
                <div class="box-body">
                  <div class="col-sm-12" style="overflow: auto;">
                      <table id="example" class="table-striped table-bordered table example" style="width: 100% !important;">
                          <thead>
                            <tr>
                              <th>S&nbsp;No.</th>
                              <th>Nurse&nbsp;Name/Sign</th>  
                              <th>Status</th> 
                              <?php if($loungeId == 'all'){ ?>
                                <th>Lounge&nbsp;Name</th>
                              <?php } ?>
                              <th>Mother&nbsp;Photo</th>
                              <th>Mother&nbsp;Name(Age)</th>
                              <th>Baby&nbsp;Info.</th>
                              <th><?php echo $regNumberHeading; ?></th>
                              <th>Comments</th>
                              <th>Mother&nbsp;Mobile&nbsp;No.</th>
                              <th>Mother&nbsp;Weight(Kg.)</th>
                              <th>Age&nbsp;At&nbsp;Marriage(Yrs)</th>
                              <th>Birth&nbsp;Spacing</th>
                              <th>Consanguinity</th>
                              <th>Reg.&nbsp;Date&nbsp;&&nbsp;Time</th>  
                              <th>Last&nbsp;Assessment</th>  
                               
                            </tr>
                          </thead>
                          <tbody>
                          <?php 
                                if($pageNo == '1'){
                                  $counter = '1'; 
                                }else{
                                  $counter = ((($pageNo*100)-100) + 1);
                                } 
                              foreach ($results as $val) { 
                                $getCommentData       = $this->BabyModel->getCommentList(2,1,$val['motherId'],$val['id']); 
                                $getRegMotherData     = $this->MotherModel->GetMotherType($val['motherId']); 
                                $get_last_assessment  = $this->MotherModel->GetLastAsessmentBabyOrMother('motherId',$val['id']); 
                                $GetAllBaby           = $this->MotherModel->GetAllBabiesViaMother('babyRegistration',$val['motherId']);
                                $GetAllBabies         = $this->MotherModel->getMotherData('babyRegistration',$val['motherId']);
                                $GetFacility   = $this->FacilityModel->GetFacilitiesID($val['loungeId']);
                                // mother danger sign
                         
                                  // set mother name
                                  if($getRegMotherData['type'] == '1' || $getRegMotherData['type'] == '3'){

                                    if(!empty($getRegMotherData['motherAge'])) {
                                     $motherAge = 'Age: '.$getRegMotherData['motherAge'].' years';
                                    } else if(!empty($getRegMotherData['motherDOB'])) {
                                      $date1 = date_create(date("Y-m-d",strtotime($getRegMotherData['motherDOB']))); 
                                        $date2 = date_create(date("Y-m-d"));
                                        $diff  = date_diff($date1 , $date2);
                                        $motherAge = 'Age: '.$diff->format("%y years, %m month, %d days");
                                    } else{
                                        $motherAge = 'N/A';

                                    }

                                    $motherName = "<a href='".base_url()."motherM/viewMother/".$val['id']."'>".$getRegMotherData['motherName']."</a>";
                                    $MotherMoblieNo = $getRegMotherData['motherMobileNumber'];

                                  } else{
                                    $motherName     = "<a href='".base_url()."motherM/viewMother/".$val['id']."'>UNKNOWN</a>";
                                    $MotherMoblieNo = "--";
                                  }
                                  $motherIconStatus     = $this->DangerSignModel->getMotherIcon($get_last_assessment); 
                                  if($motherIconStatus == '1'){
                                  $icon = "<img src='".base_url()."assets/images/happy-face.png' class='iconSet'>";
                                  $topMargin = "";
                                  } else if($motherIconStatus == '0'){
                                  $icon = "<img src='".base_url()."assets/images/sad-face.png' class='iconSet'>";
                                  $topMargin = "";
                                  }else {  $icon='';
                                      $topMargin = "margin-top:5%";
                                   }
                                // set mother picture
                                 $motherPicture = empty($getRegMotherData['motherPicture']) ? "<img  src='".base_url()."assets/images/user.png' class='img-responsive motherImage' style=".$topMargin.">" : "<img  src='".motherDirectoryUrl.$getRegMotherData['motherPicture']."' class='img-responsive motherImage' style=".$topMargin.">";

                                // set total babies of mother
                                  if($GetAllBaby == 0){
                                    $totalBabies = 0;
                                  }else{
                                    $totalBabies = "<a href='".base_url()."BabyManagenent/registeredBaby/particularMother/".$loungeId."/".$val['motherId']."'>".$GetAllBaby."</a>";
                                  }
                                // set Hospital reg no  

                                  if($GetFacility['type'] == 1){
                                     $HospitalNo   = !empty($val['temporaryFileId']) ? $val['temporaryFileId'] : 'N/A';
                                  }else{
                                     $HospitalNo   = !empty($val['hospitalRegistrationNumber']) ? $val['hospitalRegistrationNumber'] : 'N/A';
                                  }
                                // Last monitoring date
                                   $lastAssessment = ($get_last_assessment['addDate'] !='') ? date('d-m-Y g:i A', strtotime($get_last_assessment['addDate'])) :'N/A';
                                // set nurse data

                                   if($val['status'] == '2') {
                                     $getStaffName = $this->db->get_where('staffMaster',array('staffId'=>$val['dischargeByNurse']))->row_array();
                                     $nurseName = "<a href='".base_url()."staffM/updateStaff/".$val['dischargeByNurse']."'>".$getStaffName['name']."</a>"; 
                                   }
                                    else if($val['status'] == '1'){ 
                                      $getCheckListData = $this->db->get_where('admissionCheckList',array('motherAdmissionId'=>$val['id']))->row_array(); 
                                      $getStaffName1 = $this->db->get_where('staffMaster',array('staffId'=>$getCheckListData['nurseId']))->row_array();
                                      $nurseName = "<a href='".base_url()."staffM/updateStaff/".$getCheckListData['nurseId']."'>".$getStaffName1['name']."</a>";
                                    }  

                                    // admitted nurse sign

                                       //$nurseSign =  empty($val['AdmittedPersonSign']) ? "N/A" : "<img  src='".base_url()."assets/images/sign/".$val['AdmittedPersonSign']."' class='signatureSize'>";
                                       $getNurseSign =  $this->db->get_where('admissionCheckList',array('motherAdmissionId'=>$val['id']))->row_array();
                                       $nurseSign    =  empty($getNurseSign['nurseDigitalSign']) ? "N/A" : "<img  src='".base_url()."assets/images/sign/".$getNurseSign['nurseDigitalSign']."' class='signatureSize'>";
                            // set mother status
                                     if($getRegMotherData['type'] == '1') { 
                                         $motherStatus = '<span class="label label-success">Live</span>';
                                     } else if($getRegMotherData['type'] == '2') { 
                                        $motherStatus =  '<span class="label label-warning">Unknown</span>';
                                       } else if($getRegMotherData['type'] == '3') {
                                        $motherStatus =  '<span class="label label-danger">Died</span>';
                                     } 

                                    if($val['status']=='1') { 
                                      $motherStatus2 = '<span class="label label-warning">Admitted</span>';
                                    } else if($val['status']=='2'){
                                      $getLastBabyId = $this->db->query("select br.`babyId` from babyRegistration as br inner join motherRegistration as mr on br.`motherId` = mr.`motherId` where mr.`motherId`=".$val['motherId']." order by br.`babyId` desc limit 1")->row_array();
                                      $getPdfName = $this->db->query("select babyDischargePdfName from babyAdmission where babyId=".$getLastBabyId['babyId']." order by id desc limit 1")->row_array(); 
                                      $motherStatus2 = "<span class='label label-success'>Discharged</span>
                                         <a href='".base_url()."assets/PdfFile/".$getPdfName['babyDischargePdfName']."'target='_blank' style='font-size:10px;'>View Report</a>";
                                   }  else {
                                     $motherStatus2 = '<span class="label label-danger">Not Admitted</span>';
                                   } 

                             //  echo "<b>".$getRegMotherData['Type'];exit;
                                 $getTotalBabys = array(); 
                                  foreach ($GetAllBabies as $key => $vals) {
                                         $this->db->order_by('id','desc');
                                         $getbabyAdmisionId = $this->db->get_where('babyAdmission',array('babyId'=>$vals['babyId']))->row_array();
                                         $getTotalBabys[] = "<a href='".base_url()."babyM/viewBaby/".$getbabyAdmisionId['id']."/".$vals['status']."'><img src='".base_url()."assets/images/babyImages/".$vals['babyPhoto']."' width='45' height='45' style='margin-bottom: 2px;'></a>";
                                  } 
                                ?>
                                <tr>
                                  <td><?php echo $counter; ?></td>
                                  <td><?php echo $nurseName.'<br>'.$nurseSign; ?></td>
                                  <td><?php echo $motherStatus.'<br>'.$motherStatus2; ?></td>
                                  <?php if($loungeId == 'all'){ ?>
                                    <td><?= $GetFacility['loungeName']; ?></td>
                                  <?php } ?>
                                  <td><?php 

                                  echo '<span style="left:78%;position:relative;top:3px;">'.$icon.'</span>'.$motherPicture; ?></td>
                                  <td><?php echo $motherName.'<br>('.$motherAge.')'; ?></td>
                                  <td><?php echo "Total: ".$totalBabies."<br>".implode($getTotalBabys); ?></td>
                                  <td><?php echo $HospitalNo; ?></td>
                                  <td><?php echo !empty($getCommentData) ? '<a href="'.base_url().'motherM/viewMother/'.$val['id'].'/comment">'.$getCommentData.'</a>' : 'N/A'; ?></td>
                                  <td><?php echo $MotherMoblieNo; ?></td>

                                  <td><?php echo !empty($getRegMotherData['motherWeight']) ? $getRegMotherData['motherWeight'] : 'N/A'; ?></td>
                                  <td><?php echo !empty($getRegMotherData['ageAtMarriage']) ? $getRegMotherData['ageAtMarriage'] : 'N/A'; ?></td>
                                  <td><?php echo !empty($getRegMotherData['birthSpacing']) ? $getRegMotherData['birthSpacing'] : 'N/A'; ?></td>
                                  <td><?php echo !empty($getRegMotherData['consanguinity']) ? $getRegMotherData['consanguinity'] : 'N/A'; ?></td>
                                  
                                  <td><?php echo date('d-m-Y g:i A', strtotime($getRegMotherData['addDate'])); ?></td>
                                  <td><?php echo $lastAssessment; ?></td>
                                  
                                </tr>
                              
                                <?php  $counter ++ ; } ?>
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
            </div>
          </div>
        </div>
      </section>
      <!-- /.content -->
  </div>

    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Manage Mothers Functional Diagram</h4>
          </div>
          <div class="modal-body" >
           <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/MotherRegistrationProcess.png') ;?>" style="height:620px;width:100%;"> 
          </div>
        </div>
        
      </div>
    </div>

  <div class="modal fade" id="dfdModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Manage Mothers DataFlow Diagram (DFD)</h4>
        </div>
        <div class="modal-body" style="padding:0px !important;">
          <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/ManageMotherDFD.png') ;?>" style="height:850px;width:100%;">
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript">
  $(document).ready(function(){
  $("#selectValue").change(function(){
   var status11 = $(this).val();
     if(status11 == 1){
       window.location.href = "<?php echo base_url().'motherM/registeredMother/'.$loungeId; ?>";
     }else if(status11 == 2){
       window.location.href = "<?php echo base_url().'motherM/registeredMother/'.$loungeId.'/admitted'; ?>";
     }else if(status11 == 3){
       window.location.href = "<?php echo base_url().'motherM/registeredMother/'.$loungeId.'/currentlyAvail'; ?>";
     }else if(status11 == 4){
       window.location.href = "<?php echo base_url().'motherM/registeredMother/'.$loungeId.'/dischargedMother'; ?>";
     }
  });
});
</script>