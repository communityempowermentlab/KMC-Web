

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
                      <h5 class="content-header-title float-left pr-1 mb-0">Video Type </h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item active">Video Type 
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
                                      <th>Video Type Name</th>                                
                                      <th>Status</th>
                                      <th>Action</th>
                                      <th>Updated&nbsp;On</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php 
                                  $counter ="1";
                                  foreach ($videoType as $value) {
                                    $last_updated          = $this->FacilityModel->time_ago_in_php($value['modifyDate']);
                                ?>
                                <tr id="update<?php echo $value['id'];?>">
                                  <td><?php echo $counter; ?></td>
                                  <td><?php echo $value['videoTypeName']; ?></td>
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
                                  </td>
                                  <td> <a href="<?php echo base_url(); ?>videoM/editVideoType/<?= $value['id']; ?>" title="Edit Video Type Information" class="btn btn-info btn-sm">View/Edit</a>
                                  </td>
                                  <td><a class="tooltip" href="<?php echo base_url(); ?>videoM/videoTypeLog/<?php echo $value['id']; ?>"><?php echo $last_updated; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['modifyDate'])) ?></span></a></td>
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
  <a href="<?php echo base_url(); ?>videoM/addVideoType" class="btn btn btn-danger align-items-center">
      <i class="bx bx-plus"></i>&nbsp; Add New Video Type
  </a>
</div>