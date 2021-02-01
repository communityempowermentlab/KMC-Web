

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
                      <h5 class="content-header-title float-left pr-1 mb-0"><?= $GetStaffData['name']; ?> Information Update History</h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>staffM/manageStaff">Staff</a>
                          </li>
                          <li class="breadcrumb-item active"><?= $GetStaffData['name']; ?> Information Update History
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
                                        <th>Added&nbsp;By</th>
                                        <th>IP&nbsp;Address</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php 
                                  $counter = '1';
                                  $chkDate = "";
                                  
                                  foreach ($GetLogHistory as $value) {
                                    // $GetStaffName          = $this->UserModel->GetStaffName($value['staffType']);
                                    // $GetStaffSubName       = $this->UserModel->GetStaffSubName($value['staffSubType']);
                                    if($value['type'] == 1){
                                      $addedBy = $this->load->FacilityModel->GetDataById('adminMaster',$value['updatedBy']);
                                    } else if($value['type'] == 2){
                                      $addedBy = $this->load->FacilityModel->GetDataById('employeesData',$value['updatedBy']);
                                    }

                                    $generated_on =     $this->load->FacilityModel->time_ago_in_php($value['addDate']);

                                    if($value['columnName'] == 'Facility') {
                                      $oldFacility = $this->LoungeModel->GetFacilitiName($value['oldValue']);
                                      $oldValue = ucwords($oldFacility['FacilityName']);
                                      $newFacility = $this->LoungeModel->GetFacilitiName($value['newValue']);
                                      $newValue = ucwords($newFacility['FacilityName']);
                                    } else if($value['columnName'] == 'Staff Type') {
                                      $oldStaffType = $this->UserModel->GetStaffName($value['oldValue']);
                                      $oldValue     = ucwords($oldStaffType['staffTypeNameEnglish']);
                                      $newStaffType  = $this->UserModel->GetStaffName($value['newValue']);
                                      $newValue     = ucwords($newStaffType['staffTypeNameEnglish']);
                                    } else if($value['columnName'] == 'Staff Sub Type') {
                                      $oldStaffType = $this->UserModel->GetStaffSubName($value['oldValue']);
                                      $oldValue     = ucwords($oldStaffType['staffTypeNameEnglish']);
                                      $newStaffType  = $this->UserModel->GetStaffSubName($value['newValue']);
                                      $newValue     = ucwords($newStaffType['staffTypeNameEnglish']);
                                    } else if($value['columnName'] == 'Job Type') {
                                      $oldStaffType = $this->load->FacilityModel->GetDataById('masterData',$value['oldValue']);
                                      $oldValue     = ucwords($oldStaffType['name']);
                                      $newStaffType  = $this->load->FacilityModel->GetDataById('masterData',$value['newValue']);
                                      $newValue     = ucwords($newStaffType['name']);
                                    } else if($value['columnName'] == 'Status') {
                                      if($value['oldValue'] == '1'){
                                        $oldValue = '<span class="badge badge-pill badge-light-success mr-1">
                                                      Activated  
                                                    </span>';
                                      } else {
                                        $oldValue = '<span class="badge badge-pill badge-light-warning mr-1">
                                                      Deactivated  
                                                    </span>';
                                      }
                                      if($value['newValue'] == '1'){
                                        $newValue = '<span class="badge badge-pill badge-light-success mr-1">
                                                      Activated  
                                                    </span>';
                                      } else {
                                        $newValue = '<span class="badge badge-pill badge-light-warning mr-1">
                                                      Deactivated  
                                                    </span>';
                                      }
                                    } else if($value['columnName'] == 'Staff Photo') {
                                      if(!empty($value['oldValue'])){
                                        $oldValue     = '<img style="width:100px;height:100px;" src="'.base_url().'assets/nurse/'.$value['oldValue'].'">';
                                      } else {
                                        $oldValue = '';
                                      }

                                      if(!empty($value['newValue'])){
                                        $newValue     = '<img style="width:100px;height:100px;" src="'.base_url().'assets/nurse/'.$value['newValue'].'">';
                                      } else {
                                        $newValue = '';
                                      }
                                    } else {
                                      $oldValue = ucwords($value['oldValue']);
                                      $newValue = ucwords($value['newValue']);
                                    }

                                   
                                   
                                ?>
                                <?php if($chkDate != $value['addDate']) { ?>
                                      <tr>
                                        <td colspan="6" class="td-heading"><?= $generated_on; ?></td>
                                      </tr>

                                      <tr>
                                        <td><?php echo $counter; ?></td>
                                        <td><?php echo ucwords($value['columnName']);?></td>
                                        <td><?php echo $oldValue;?></td>
                                        <td><?php echo $newValue;?></td>
                                        <td><?php echo ucwords($addedBy['name']);?></td>
                                        <td><?php echo $value['deviceInfo']?></td>
                                      </tr>

                                    <?php } else {  ?>

                                      <tr>
                                        <td><?php echo $counter; ?></td>
                                        <td><?php echo ucwords($value['columnName']);?></td>
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

