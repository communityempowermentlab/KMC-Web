

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
                      <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $Lounge['loungeName'];?>&nbsp;<?php echo 'Doctor Round Visit History '; ?></h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>loungeM/manageLounge">Lounges</a>
                          </li>
                          <li class="breadcrumb-item active">Doctor Round Visit History 
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
                                      <th>Doctor&nbsp;Name</th>
                                      <th>Doctor&nbsp;Signature</th>
                                      <th>Visit&nbsp;Date&nbsp;&&nbsp;Time</th>
                                    </tr>
                                </thead>
                                <tbody>

                                  <?php 
                                    $counter ="1";
                                    foreach ($dutyData as $value) {
                                    $doctorData = $this->db->get_where('staffMaster',array('staffId'=>$value['staffId']))->row_array();
                                  ?>


                                    <tr>
                                      <td><?php echo $counter; ?></td>
                                      <td><a href="<?php echo base_url();?>staffM/updateStaff/<?php echo $doctorData['staffId'];?>"><?php echo $doctorData['name'];?></td>
                                      <td><?php if(!empty($value['staffSignature'])) { ?> 
                                        <img src="<?php echo signDirectoryUrl.$value['staffSignature']; ?>" width="160" height="120" style="border: 1px solid #e3dfdf;">
                                       <?php } else { echo 'N/A'; } ?>
                                      </td>
                                      <td><?php echo !empty($value['addDate']) ? date("d-m-Y g:i A", strtotime($value['addDate'])) : 'N/A'; ?></td>
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

