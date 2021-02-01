

    <!-- BEGIN: Content-->
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        
      <div class="content-body">



<?php 
      $FacilityID  = $this->uri->segment(3);
      $Facility  = $this->load->FacilityModel->GetFacilitiesTypeById('facilityType', $FacilityID); 
?>


<!-- Column selectors with Export Options and print table -->
<section id="column-selectors">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-12 pull-left">
                      <h5 class="content-header-title float-left pr-1 mb-0"><?php echo  $Facility['facilityTypeName'];?> Log   </h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>facility/facilityType/">Facility Type</a>
                          </li>
                          <li class="breadcrumb-item active"><?php echo  $Facility['facilityTypeName'];?> Log
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
                                      <th>S&nbsp;No.</th>
                                      <th>Facility&nbsp;Type&nbsp;Name</th>
                                      <th>Priority</th>
                                      <th>Status</th>
                                      <th>Date&nbsp;&&nbsp;Time</th>
                                      <th>Added&nbsp;By</th>
                                      <th>IP&nbsp;Address</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php 
                                  $counter ="1";
                 
                                  foreach ($GetLog as$key=> $value ) {
                                    $addedBy = $this->load->FacilityModel->GetDataById('adminMaster',$value['addedBy']);
                                ?>
                                 <tr>
                                   <td><?php echo $counter; ?></td>
                                   <td><?php echo $value['facilityTypeName']; ?></td>
                                   <td><?php echo $value['priority']; ?></td>
                                   <td>
                                     <?php  
                                      $status = ($value['status']=='1') ? 'assets/act.png' :'assets/delete.png';
                                      if ($value['status'] == 1) { ?> 
                                          <span class="badge badge-pill badge-light-success mr-1">
                                            Activated  
                                          </span> 
                                      <?php } else { ?>
                                          <span class="badge badge-pill badge-light-warning mr-1">
                                            Deactivated
                                          </span>
                                      <?php } ?>
                                      &nbsp;  
                                    </td>
                                    <td><?php echo date("F d ",strtotime($value['addDate'])).'at '.date("h:i A",strtotime($value['addDate'])); ?></td>
                                    <td><?php echo ucwords($addedBy['name']);?></td>
                                    <td><?php echo $value['ipAddress']?></td>
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

