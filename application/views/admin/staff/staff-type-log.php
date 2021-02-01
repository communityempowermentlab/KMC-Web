

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
                      <h5 class="content-header-title float-left pr-1 mb-0">Staff Type Log </h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item active">Staff Type Log  
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
                                      <th>Staff Type Name</th>                                                              
                                      <th>Staff Sub Type Name</th>                                                    
                                      <th>Status</th>
                                      <th>Date&nbsp;&&nbsp;Time</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php 
                                  $counter ="1";
                                  foreach ($StaffType as $value) { 
                                    $last_updated          = $this->FacilityModel->time_ago_in_php($value['addDate']);
                                ?>
                                <tr id="update<?php echo $value['staffTypeId'];?>">
                                   <td><?php echo $counter; ?></td>
                                   <td><?php echo $value['staffTypeNameEnglish'];?>
                                   <td>
                                    <?php if($value['parentId']=='0'){
                                     echo " -";}
                                    if($value['parentId']=='1'){
                                             $FindPost=$this->load->FacilityModel->GetStaffTypeById('1');
                                             echo $FindPost['staffTypeNameEnglish'];
                                        }else if($value['parentId']=='2'){
                                              $FindPost=$this->load->FacilityModel->GetStaffTypeById('2');
                                             echo $FindPost['staffTypeNameEnglish'];
                                        }else if($value['parentId']=='3'){
                                              $FindPost=$this->load->FacilityModel->GetStaffTypeById('3');
                                             echo $FindPost['staffTypeNameEnglish'];
                                        }else if($value['parentId']=='4'){
                                              $FindPost=$this->load->FacilityModel->GetStaffTypeById('4');
                                              echo $FindPost['staffTypeNameEnglish'];
                                        }else if($value['parentId']=='5'){
                                             $FindPost=$this->load->FacilityModel->GetStaffTypeById('5');
                                             echo $FindPost['staffTypeNameEnglish'];
                                        }    
                                    ?>
                                    </td>
                                   <td>
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
                                   <td><a class="tooltip" href="javascript:void(0);"><?php echo $last_updated; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['addDate'])) ?></span></a></td>
                                </tr>
                              <?php $counter ++ ; }   ?>
                                    
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

