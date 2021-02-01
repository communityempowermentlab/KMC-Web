

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
                      <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $GetStaffData['name'];?>&nbsp;<?php echo 'Nurse Checkin'; ?></h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>loungeM/manageLounge">Lounges</a>
                          </li>
                          <li class="breadcrumb-item active">Nurse Checkin
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
                                      <th>At&nbsp;The&nbsp;Time&nbsp;Of</th>
                                      <th>Selfie</th>
                                      <th>Date&nbsp;&&nbsp;Time</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php 
                                  $counter ="1";
                                  foreach ($GetCheckinData as $value ) {
                                    $url = signDirectoryUrl.$value['selfie']; 
                                  $loungePic = !empty($value['selfie']) ? "<img src='".signDirectoryUrl.$value['selfie']."' style='width:100px;height:100px;'' class='signatureSize'>" : 'N/A';
                                  if($value['type'] == 1) {
                                    $generated_on =     $this->load->FacilityModel->time_ago_in_php($value['addDate']);
                                    $generated_on_txt = '<a href="javascript:void(0);" class="tooltip">'.$generated_on.'<span class="tooltiptext">'.date("m/d/y, h:i A",strtotime($value['addDate'])).'</span></a>';
                                    $dateTime  = !empty($value['addDate']) ? $generated_on_txt : '--';
                                  } else {
                                    $generated_on =     $this->load->FacilityModel->time_ago_in_php($value['modifyDate']);
                                    $generated_on_txt = '<a href="javascript:void(0);" class="tooltip">'.$generated_on.'<span class="tooltiptext">'.date("m/d/y, h:i A",strtotime($value['modifyDate'])).'</span></a>';
                                    $dateTime  = !empty($value['modifyDate']) ? $generated_on_txt : '--';
                                  }
                                ?>
                                  <tr>
                                     <td><?php echo $counter; ?></td>
                                     <td><?php if($value['type'] == 1) { echo 'Checked In'; } else { echo 'Checked Out'; } ?></td>
                                     <td><?php if(!empty($value['selfie'])) { ?>
                                      <img onclick="showNurseSelfie('<?= signDirectoryUrl.$value['selfie'] ?>')" src="<?= signDirectoryUrl.$value['selfie'] ?>" style="width:100px;height:100px;cursor: pointer;" class="signatureSize">
                                     <?php } else { echo 'N/A'; } ?></td>
                                     <td><?php echo $dateTime; ?></td>
                                  </tr>  
                                  <?php $counter ++ ; } ?>
                                    
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

