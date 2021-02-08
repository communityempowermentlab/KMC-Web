<?php 
$sessionData = $this->session->userdata('adminData'); 
$userPermittedMenuData = array();
$userPermittedMenuData = $this->session->userdata('userPermission');
?>

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
                    <div class="col-6 pull-left">
                      <h5 class="content-header-title float-left pr-1 mb-0">Not Approved Staff</h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item active">Not Approved Staff
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
                                      <th>District</th>                                                              
                                      <th>Facility</th>     
                                      <th>Staff Name</th>    
                                      <th>Staff Mobile</th>  
                                      <th>Verified Mobile</th>                                                    
                                      <th>Status</th>
                                      <th>Action</th>
                                      <th>Added&nbsp;On</th>
                                    </tr>
                                </thead>
                                <tbody>

                                  <?php 
                                    $counter ="1";
                                    foreach ($results as $value) {
                                      
                                      $Facility = $this->db->query("SELECT * FROM `facilitylist` where FacilityID='".$value['facilityId']."'")->row_array();
                                      $District = $this->db->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs` where PRIDistrictCode='".$Facility['PRIDistrictCode']."'")->row_array();
                                      
                                      $added_on = $this->load->FacilityModel->time_ago_in_php($value['addDate']);
                                  ?>


                                    <tr>
                                      <td><?php echo $counter; ?></td>
                                      <td><?php echo $District['DistrictNameProperCase']; ?></td>
                                      <td><?php echo $Facility['FacilityName']; ?></td>
                                      <td><?php echo $value['name']; ?></td>
                                      <td><?php echo $value['staffMobileNumber']; ?></td>
                                      <td><?php echo (!empty($value['verifiedMobile'])) ? $value['verifiedMobile']:"N/A"; ?></td>
                                      <td>
                                        <?php $status = ($value['status'] == '1') ? 'assets/act.png' :'assets/delete.png';
                                        if($value['status'] == 1){?>
                                              <span class="badge badge-pill badge-light-warning mr-1">
                                                Pending  
                                              </span>
                                              
                                        <?php } else if($value['status'] == '2'){ ?>
                                              <span class="badge badge-pill badge-light-success mr-1">
                                                Approved
                                              </span>
                                        <?php } else { ?>
                                              <span class="badge badge-pill badge-light-danger mr-1">
                                                Rejected
                                              </span>
                                        <?php } ?> 
                                      </td>
                                      <td> <a href="<?php echo base_url(); ?>staffM/editTemporaryStaff/<?php echo $value['staffId']; ?>" class="btn btn-sm btn-info">
                                        <?php if(($sessionData['Type']==1) || in_array(66, $userPermittedMenuData)){
                                          echo VIEW_BUTTON;
                                        }
                                        if(($sessionData['Type']==1) || (in_array(66,$userPermittedMenuData) && in_array(67,$userPermittedMenuData)))
                                        {
                                          echo "/";
                                        }
                                        if(($sessionData['Type']==1) || in_array(67, $userPermittedMenuData)){
                                          echo EDIT_BUTTON;
                                        }
                                        ?>
                                      </a>
                                      </td>
                                      <td><a class="tooltip nonclick_link"><?php echo $added_on; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['addDate'])) ?></span></a>
                                      </td>
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

