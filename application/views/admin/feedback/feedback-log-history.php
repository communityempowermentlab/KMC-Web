

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
                      <h5 class="content-header-title float-left pr-1 mb-0"><?= $GetMotherData['motherName']; ?> Feedback Update History</h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>FeedbackManagement/dischargeMother/all/all">Mother</a>
                          </li>
                          <li class="breadcrumb-item active"><?= $GetMotherData['motherName']; ?> Feedback Update History
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
                                      <th>Column Name</th>
                                      <th>Previous Value</th>
                                      <th>Updated Value </th>
                                      <th>Updated&nbsp;By</th>
                                      <th>IP&nbsp;Address</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php 
                                  $counter = '1';
                                  $chkDate = "";
                                  
                                  foreach ($GetLogHistory as $value) {

                                    if($value['type'] == 1){
                                      $addedBy = $this->load->FacilityModel->GetDataById('adminMaster',$value['updatedBy']);
                                    } else if($value['type'] == 4){
                                      $addedBy = $this->load->FacilityModel->GetDataById('employeesData',$value['updatedBy']);
                                    }

                                    $generated_on =     $this->load->FacilityModel->time_ago_in_php($value['addDate']);

                                    $oldValue = $value['oldValue'];
                                    $newValue = $value['newValue'];
                                ?>
                                    <?php if($chkDate != $value['addDate']) { ?>
                                      <tr>
                                        <td colspan="6" class="td-heading"><?= $generated_on; ?></td>
                                      </tr>

                                      <tr>
                                        <td><?php echo $counter; ?></td>
                                        <td><?php echo $value['columnName'];?></td>
                                        <td><?php echo $oldValue;?></td>
                                        <td><?php echo $newValue;?></td>
                                        <td><?php echo ucwords($addedBy['name']);?></td>
                                        <td><?php echo $value['deviceInfo']?></td>
                                      </tr>

                                    <?php } else { ?>

                                      <tr>
                                        <td><?php echo $counter; ?></td>
                                        <td><?php echo $value['columnName'];?></td>
                                        <td><?php echo $oldValue;?></td>
                                        <td><?php echo $newValue;?></td>
                                        <td><?php echo ucwords($addedBy['name']);?></td>
                                        <td><?php echo $value['deviceInfo']?></td>
                                      </tr>
                                    <?php } $counter ++ ; $chkDate = $value['addDate']; } ?> 
                                    
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

