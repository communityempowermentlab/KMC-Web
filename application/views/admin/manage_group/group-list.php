

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
                      <h5 class="content-header-title float-left pr-1 mb-0">Menu Group</h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item active">Menu Group
                          </li>
                        </ol>
                      </div>
                    </div>
                    
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        
                        <div id="hiddenSms"><?php echo $this->session->flashdata('message'); ?></div>

                        <div class="">
                            <table class="table table-striped dataex-html5-selectors-log">
                                <thead>
                                    <tr>
                                      <td><b>S. No.</b></td>
                                      <td><b>Group Name</b></td>
                                      <td><b>Status</b></td>
                                      <td><b>View Details</b></td>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php  $i = 1; foreach ($res as $value) { ?>

                                        <tr id="<?php echo $value['id']; ?>" class="main_row">
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $value['groupName']; ?></td>
                                            <td id="act" style="padding-top: 10px;">
                                                <?php if ($value['status'] == 1) { ?>
                                                    <span class="badge badge-pill badge-light-success mr-1">
                                                      Activated  
                                                    </span>
                                                <?php } else { ?>
                                                    <span class="badge badge-pill badge-light-warning mr-1">
                                                      Deactivated
                                                    </span> 
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <a title="Edit Group Data" href="<?php echo base_url('Miscellaneous/editMenuGroup/'.$value['id']); ?>">
                                                    <button type="button" class="btn btn-sm btn-info">View/Edit</button>
                                                </a>
                                            </td>                                    
                                        </tr>
                                    <?php  $i++; } ?>
                                    
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
  <a href="<?php echo base_url('Miscellaneous/addMenuGroup'); ?>" class="btn btn btn-danger align-items-center">
      <i class="bx bx-plus"></i>&nbsp; Add New Menu Group
  </a>
</div>