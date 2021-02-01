

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
                      <h5 class="content-header-title float-left pr-1 mb-0">CEL Employees </h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item active">CEL Employees 
                          </li>
                        </ol>
                      </div>
                    </div>
                    
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        
                        <div id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>

                        <div class="table-responsive">
                            <table class="table table-striped dataex-html5-selectors-lounge">
                                <thead>
                                    <tr>
                                      <th>S&nbsp;No.</th>
                                      <th>Code</th>
                                      <th>Name</th>
                                      <th>Email</th>
                                      <th>Mobile</th>
                                      
                                      <th>Status</th>
                                      <th>Action</th>
                                      
                                      <th>Login&nbsp;Details</th>
                                      <th>Updated On</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php 
                                  $counter = '1';
                                  if(!empty($results)) { 
                                  foreach ($results as $value) {
                                    $last_updated =     $this->load->FacilityModel->time_ago_in_php($value['modifyDate']);    
                                    $lastLogin = $this->EmployeeModel->getLastLogin($value['id']);
                                    $greenIcon = '';
                                    if($lastLogin['type'] == 1){
                                      $greenIcon = '<div class="green_dot"></div>';
                                    }
                                    $url = base_url()."assets/employee/".$value['profileImage'];
                                ?>
                                  <tr>
                                    <td><?php echo $counter; ?></td>
                                    <td><?php echo $value['employeeCode']; ?></td>
                                    <td><?php echo $greenIcon.$value['name']; if(!empty($value['profileImage'])) { ?> 
                                      <span onclick="showEmployeeImage('<?= $url ?>', 'Employee Picture')" class="hover-image"><i class="bx bx-paperclip cursor-pointer mr-50"></i></span>
                                    <?php } ?></td>
                                    <td><?php echo $value['email']; ?></td>
                                    <td><?php echo $value['contactNumber']; ?></td>
                                    
                                    <td>
                                    <?php if($value['status'] == 1) { ?> 
                                        <span class="badge badge-pill badge-light-success mr-1">
                                          Activated  
                                        </span>
                                    <?php } else { ?>
                                        <span class="badge badge-pill badge-light-warning mr-1">
                                          Deactivated
                                        </span>
                                    <?php } ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>employeeM/updateEmployee/<?php echo $value['id']; ?>" title="Edit EMployee Information" class="btn btn-info btn-sm">View/Edit</a></td>
                                    <td></td>
                                    <td><a class="tooltip" href="<?php echo base_url(); ?>employeeM/viewEmployeeLog/<?php echo $value['id']; ?>"><?php echo $last_updated; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['modifyDate'])) ?></span></a></td>
                                    
                                  </tr>
                                <?php $counter ++ ; } } else {
                                  echo '<tr><td colspan="13" style="text-align:center;">No Records Found!</td></tr>';
                                } ?>
                                    
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
  <a href="<?php echo base_url('employeeM/addEmployee/');?>" class="btn btn btn-danger align-items-center">
      <i class="bx bx-plus"></i>&nbsp; Add New CEL Employee
  </a>
</div>