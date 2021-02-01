<?php 
  $loungeId      = $this->uri->segment('3'); 
  $GetFacility   = $this->FacilityModel->GetFacilitiesID($loungeId);
  $motherStatus = $this->uri->segment(4); 
    if($GetFacility['type'] == 1){
      $regNumberHeading   = "SNCU&nbsp;Reg.&nbsp;Number";
    }else{
      $regNumberHeading   = "Registration&nbsp;No.";
    }

?>

<input type="hidden" id="loungeidNumber" value="<?php echo $loungeId; ?>">
<style type="text/css">
  .dt-buttons, .cg_filter{ display: inline !important; width: 50% !important; float: left; }
  .col-xs-15,
  .col-sm-15,
  .col-md-15,
  .col-lg-15 {
      position: relative;
      min-height: 1px;
      padding-right: 10px;
      padding-left: 10px;
      height: 165px;
  }
  .col-xs-15 {
    width: 17%;
    float: left;
  }
  @media (min-width: 768px) {
  .col-sm-15 {
          width: 17%;
          float: left;
      }
  }
  @media (min-width: 992px) {
      .col-md-15 {
          width: 17%;
          float: left;
      }
  }
  @media (min-width: 1200px) {
      .col-lg-15 {
          width: 17%;
          float: left;
      }
  }
  .boxDiv{
    margin:15px;
    padding: 10px;
  }
  .dataDiv:hover{
    cursor: pointer;
    box-shadow: rgba(0, 0, 0, 0.78) -1px 5px 18px -3px;
  }
</style>
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1><?php echo 'Manage Mothers'; ?> (<?php echo $GetFacility['loungeName']; ?>)</h1>
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
           

                 <div class="col-md-offset-3 col-md-4" align="right">
                    <a href="#"><span style="font-size: 24px; margin-right: 10px; color: #0ac7c7;"><i class="fa fa-th"></i></span></a>
                    <a href="<?php echo base_url(); ?>motherM/registeredMother/<?= $loungeId; ?>"><span style="font-size: 24px; color: #0ac7c7;"><i class="fa fa-align-justify"></i></span></a>
                 </div>
                 


                </div> 
                <div class="box-body" style="margin-top: 15px;">
                  <div class="col-sm-12" style="overflow: auto;">
                      <div class="row">

                        <?php for($i=0; $i < $noOfBeds; $i++) {
                          if($GetFacility['type'] == 1){
                             $HospitalNo   = !empty($results[$i]['temporaryFileId']) ? $results[$i]['temporaryFileId'] : 'N/A';
                          }else{
                             $HospitalNo   = !empty($results[$i]['hospitalRegistrationNumber']) ? substr($results[$i]['hospitalRegistrationNumber'], 0, 20) : 'N/A';
                          }


                         ?>
                          
                              <?php if(!empty($results[$i])) {

                                $get_last_assessment  = $this->MotherModel->GetLastAsessmentBabyOrMother('motherMonitoring','motherId',$results[$i]['motherId'],$results[$i]['id']);
                                
                                
                                    $motherIconStatus     = $this->DangerSignModel->getMotherIcon($get_last_assessment);
                                    if($motherIconStatus == '0'){
                                      $icon = 'redBed.png';
                                      
                                    } else {
                                      $icon = 'greenBed.png';
                                    }
                                

                              ?>
                              <a href="<?php echo base_url(); ?>motherM/viewMother/<?= $results[$i]['id'] ?>" style="color: #000;">
                                <div class="col-md-15 col-sm-3 boxDiv dataDiv">
                                  <center>
                                    <img src="<?php echo base_url(); ?>assets/images/icons/<?= $icon; ?>" style="width:70px;">
                                    <p style="margin-top: 10px;"><b><?= ucwords($results[$i]['motherName']); ?></b><br>
                                      <?= $HospitalNo; ?><br>
                                      <?= date('d-m-Y g:i A', strtotime($results[$i]['addDate'])); ?>
                                    </p>
                                  </center>
                                </div>
                              </a>
                              <?php }  else { ?>
                                <div class="col-md-15 col-sm-3 boxDiv">
                                  <center>
                                    <img src="<?php echo base_url(); ?>assets/images/icons/grayBed.png" style="width:70px;">
                                  </center>
                                </div>
                              <?php } ?>
                            

                        <?php } ?>

                        
                        
                    </div>
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