

    <!-- BEGIN: Content-->
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        
      <div class="content-body">






<!-- Column selectors with Export Options and print table -->
<section id="column-selectors">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-12 pull-left">
                      <h5 class="content-header-title float-left pr-1 mb-0">Facility Type   </h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item active">Facility Type 
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
                                      <th>Facility Type Name</th>                
                                      <th>Priority</th>                
                                      <th>Total&nbsp;Facilities</th>                
                                      <th>Status</th>
                                      <th>Action</th>
                                      <th>Updated&nbsp;On</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php 
                                  $counter ="1";
               
                                  foreach ($GetFacilities as $value) {
                                    $countFacilitis= $this->FacilityModel->countFacilitis($value['id']);
                                    $last_updated =     $this->load->FacilityModel->time_ago_in_php($value['modifyDate']); 
                                ?>
                                  <tr id="update<?php echo $value['id'];?>">
                                    <td><?php echo $counter; ?></td>
                                    <td><?php echo $value['facilityTypeName']; ?></td>
                                    <td><?php echo $value['priority']; ?></td>
                                    <td><?php echo $countFacilitis; ?></td>
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
                                    <td> <a href="<?php echo base_url(); ?>facility/editFacilityType/<?php echo $value['id']; ?>" class="btn btn-info btn-sm" title="Edit Facility Type Information">View/Edit</a> </td>
                                    <td><a class="tooltip" href="<?php echo base_url(); ?>facility/viewFacilityTypeLog/<?php echo $value['id']; ?>"><?php echo $last_updated; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['modifyDate'])) ?></span></a></td>
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

<div class="add-new">
  <a href="<?php echo base_url(); ?>facility/addFacilityType/" class="btn btn btn-danger align-items-center">
      <i class="bx bx-plus"></i>&nbsp; Add New Facility Type 
  </a>
</div>