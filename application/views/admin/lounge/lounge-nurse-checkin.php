

    <!-- BEGIN: Content-->
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        
      <div class="content-body">


<?php
  $ID      = $this->uri->segment(3);
  $Lounge  = $this->FacilityModel->GetLoungeById($ID);
?>



<!-- Column selectors with Export Options and print table -->
<section id="column-selectors">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-12 ">
                      <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $Lounge['loungeName'];?>&nbsp;<?php echo 'Lounge Nurse Checkin'; ?></h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>loungeM/manageLounge">Lounges</a>
                          </li>
                          <li class="breadcrumb-item active">Lounge Nurse Checkin
                          </li>
                        </ol>
                      </div>
                    </div>
                    
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        
                        <div id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>

                        <div class="table-responsive">
                            <table class="table table-striped dataex-html5-selectors-log">
                                <thead>
                                    <tr>
                                      <th>Sr.&nbsp;No.</th>
                                      <th>Nurse</th>
                                      <th>Photo</th>
                                      <th>At&nbsp;The&nbsp;Time&nbsp;Of</th>
                                      <th>Feeling</th>
                                      <th>Date&nbsp;&&nbsp;Time</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php 
                                  $counter ="1";
                                  foreach ($GetCheckinData as $value) {
                                    if(empty($value['modifyDate'])){
                                      $maxRow = 1;
                                    }else{
                                      $maxRow = 2;
                                    }
                                    //$staffCheckinLog = $this->LoungeModel->loungeNurseCheckinLogs($value['id']);
                                    for($attendanceRow=1;$attendanceRow<=$maxRow;$attendanceRow++){

                                      $search = 'checked in';
                                      if($attendanceRow == "1") {
                                          $dateTime = date("F d ",strtotime($value['addDate'])).'at '.date("h:i A",strtotime($value['addDate']));
                                          $checkStatus = "Checked In";
                                      }else{
                                        $dateTime = date("F d ",strtotime($value['modifyDate'])).'at '.date("h:i A",strtotime($value['modifyDate']));
                                        $checkStatus = "Checked Out";
                                      }
                                ?>
                                <tr>
                                   <td><?php echo $counter; ?></td>
                                   <td><?php echo ucwords($value['nurseName']); ?></td>
                                   <td>
                                    <?php if($attendanceRow == "1") { ?>
                                      <img src="<?php echo signDirectoryUrl.$value['selfie']; ?>" style="border-radius:50%;width: 60px;height: 60px;cursor:pointer;" onclick="showNurseSelfie('<?= signDirectoryUrl.$value['selfie'] ?>')">
                                    <?php }else{ ?>
                                      <img src="<?php echo signDirectoryUrl.$value['checkoutSelfie']; ?>" style="border-radius:50%;width: 60px;height: 60px;cursor:pointer;" onclick="showNurseSelfie('<?= signDirectoryUrl.$value['checkoutSelfie'] ?>')">
                                    <?php } ?>
                                  </td>
                                   <td><?php echo $checkStatus; ?></td>
                                   <td>
                                    <?php if($attendanceRow == "1") { ?>
                                      <?php if($value['feeling'] == 1){
                                        $feeling_icon = "happy_feeling.svg";
                                        $feeling_text = "Happy";
                                      }else if($value['feeling'] == 2){ 
                                        $feeling_icon = "fine_feeling.svg";
                                        $feeling_text = "Fine";
                                      }else{
                                        $feeling_icon = "bad_feeling.svg";
                                        $feeling_text = "Not Feeling Good";
                                      }?>
                                      <a class="tooltip nonclick_link"><img src="<?php echo base_url('assets/images/'.$feeling_icon); ?>" style="width: 50px;height: 30px;"><span class="tooltiptext"><?php echo $feeling_text; ?></span></a>
                                    <?php }else{ echo "&nbsp;&nbsp;&nbsp;N/A"; } ?>
                                   </td>
                                   <td><?php echo $dateTime; ?></td>
                                </tr>  
                                <?php $counter ++ ; } } ?>
                                    
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Column selectors with Export Options and print table -->

