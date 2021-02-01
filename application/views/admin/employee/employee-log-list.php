

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
                                      <th>Employee&nbsp;Code</th>
                                      <th>Name</th>
                                      <th>Email</th>
                                      <th>Mobile</th>
                                      <th>Assigned&nbsp;Menus</th>
                                      <th>Photo</th>
                                      <th>Status</th>
                                      <th>Date&nbsp;&&nbsp;Time</th>
                                      <th>Added&nbsp;By</th>
                                      <th>IP&nbsp;Address</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php 
                                  $counter = '1';
                                  if(!empty($results)) { 
                                  foreach ($results as $value) {
                                    $addedBy = $this->load->FacilityModel->GetDataById('adminMaster',$value['addedBy']);
                                    $getMenuGroup = $this->load->EmployeeModel->getMenuGroup($value['menuGroup']); 
                                    $strMenu = implode(",", array_column($getMenuGroup, "groupName"));
                                ?>
                                <tr>
                                  <td><?php echo $counter; ?></td>
                                  <td><?php echo $value['employeeCode']; ?></td>
                                  <td><?php echo $value['name']; ?></td>
                                  <td><?php echo $value['email']; ?></td>
                                  <td><?php echo $value['contactNumber']; ?></td>
                                  <td><?php echo $strMenu; ?></td>
                                  <td style="width:70px;height:50px;">
                                    <?php  if(empty($value['profileImage'])) { ?>
                                      <img  src="<?php echo base_url();?>assets/nurse/default.png" style="height:100px;width:100px;margin-top:5px;">
                                    <?php } else { ?>
                                      <img  src="<?php echo base_url();?>assets/employee/<?php echo $value['profileImage']?>" class="img-responsive" style="height:100px;width:100px;margin-top:5px;">
                                    <?php } ?>
                                  </td>
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
                                  
                                  <td><?php echo $date=date("d-m-Y h:i A",strtotime($value['addDate'])); ?></td>
                                  <td><?php echo ucwords($addedBy['name']);?></td>
                                  <td><?php echo $value['ipAddress']?></td>
                                  
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
