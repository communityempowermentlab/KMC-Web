

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
                      <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $Lounge['loungeName'];?>&nbsp;<?php echo 'Lounge Application Login History'; ?></h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>loungeM/manageLounge">Lounges</a>
                          </li>
                          <li class="breadcrumb-item active">Lounge Application Login History
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
                                      <th>Device&nbsp;ID</th>
                                      <th>Login&nbsp;Date&nbsp;&&nbsp;Time</th>
                                      <th>Logout&nbsp;Date&nbsp;&&nbsp;Time</th>
                                      
                                   </tr>
                                </thead>
                                <tbody>

                                <?php 
                                  $counter ="1";
                                  foreach ($GetLoungeHistory as $value ) {
                                    $loginTime =     $this->load->FacilityModel->time_ago_in_php($value['loginTime']);
                                    $logoutTime =     $this->load->FacilityModel->time_ago_in_php($value['logoutTime']);
                                ?>
                                 <tr>
                                   <td><?php echo $counter; ?></td>
                                   <td><?php echo $value['deviceId']; ?></td>
                                   <td><a href="javascript:void(0);" class="tooltip"><?php echo $loginTime; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['loginTime'])) ?></span></a></td>
                                   <td><?php $date1=$value['logoutTime']; 
                                   if($date1 != '0000-00-00 00:00:00') { ?>
                                    <a href="javascript:void(0);" class="tooltip"><?php echo $logoutTime; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['logoutTime'])) ?></span></a>
                                    <?php } else { echo '--'; } ?></td>
                                   
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

