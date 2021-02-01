

    <!-- BEGIN: Content-->
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        
      <div class="content-body">


<?php
  $ID      = $this->uri->segment(3);
  $Lounge  = $this->FacilityModel->GetLoungeById($ID);
  $FacilityId  = $Lounge['facilityId'];
  $Facility  = $this->FacilityModel->GetFacilityName($FacilityId);
?>



<!-- Column selectors with Export Options and print table -->
<section id="column-selectors">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-12 ">
                      <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $Facility['FacilityName'];?>&nbsp;<?php echo 'Facility Birth Review'; ?></h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>loungeM/manageLounge">Lounges</a>
                          </li>
                          <li class="breadcrumb-item active">Facility Birth Review
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
                                      <th>Shift</th>
                                      <th>Total&nbsp;Live&nbsp;Birth</th>
                                      <th>Total&nbsp;Stable&nbsp;Babies</th>
                                      <th>Total&nbsp;Unstable&nbsp;Babies</th>
                                      <th>Date&nbsp;&&nbsp;Time</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php 
                                  $counter ="1";
                                  foreach ($GetBirthReview as $value ) {
                                  $getStaffDetails = $this->db->query("SELECT * from staffMaster where StaffID=".$value['nurseId']."")->row_array();
                                  $generated_on =     $this->load->FacilityModel->time_ago_in_php($value['addDate']);
                                ?>
                                  <tr>
                                     <td><?php echo $counter; ?></td>
                                     <td><?php echo ucwords($getStaffDetails['name']); ?></td>
                                     <td><?php if($value['shift'] == 1) { echo '8 AM - 2PM'; } else if($value['shift'] == 2) { echo '2 PM - 8 PM'; } else { echo '8 PM - 8 AM'; } ?></td>
                                     <td><?php echo $value['totalLiveBirth']; ?></td>
                                     <td><?php echo $value['totalStableBabies']; ?></td>
                                     <td><?php echo $value['totalUnstableBabies']; ?></td>
                                     
                                     <td><a href="javascript:void(0);" class="tooltip"><?php echo $generated_on; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['addDate'])) ?></span></a></td>
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

