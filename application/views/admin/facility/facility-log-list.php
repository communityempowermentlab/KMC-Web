

    <!-- BEGIN: Content-->
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        
      <div class="content-body">



<?php 
    $FacilityID  = $this->uri->segment(3);
    $Facility  = $this->load->UserModel->getFacilityNameBYID($FacilityID); 
?>


<!-- Column selectors with Export Options and print table -->
<section id="column-selectors">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-6 pull-left">
                      <h5 class="content-header-title float-left pr-1 mb-0"><?php echo  $Facility['FacilityName'];?> Log</h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>facility/manageFacility">Facilities</a>
                          </li>
                          <li class="breadcrumb-item active">Facility Log
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
                                    $counter ="1";
                                    $chkDate = "";
                                    foreach ($GetFacilityLog as$key=> $value ) {
                                      if($value['type'] == 1){
                                        $addedBy = $this->load->FacilityModel->GetDataById('adminMaster',$value['updatedBy']);
                                      } else if($value['type'] == 2){
                                        $addedBy = $this->load->FacilityModel->GetDataById('employeesData',$value['updatedBy']);
                                      }
                                      $generated_on =     $this->load->FacilityModel->time_ago_in_php($value['addDate']);

                                      if($value['columnName'] == 'Management Type') {
                                        $oldManagement = $this->load->FacilityModel->GetDataById('masterData',$value['oldValue']);
                                        $oldValue = ucwords($oldManagement['name']);
                                        $newManagement = $this->load->FacilityModel->GetDataById('masterData',$value['newValue']);
                                        $newValue = ucwords($newManagement['name']);
                                      } else if($value['columnName'] == 'Facility Type') {
                                        $oldManagement = $this->load->FacilityModel->GetDataById('facilityType',$value['oldValue']);
                                        $oldValue = ucwords($oldManagement['facilityTypeName']);
                                        $newManagement = $this->load->FacilityModel->GetDataById('facilityType',$value['newValue']);
                                        $newValue = ucwords($newManagement['facilityTypeName']);
                                      } else if($value['columnName'] == 'Newborn Care Unit Type') {
                                        $oldManagement = $this->load->FacilityModel->GetDataById('masterData',$value['oldValue']);
                                        $oldValue = ucwords($oldManagement['name']);
                                        $newManagement = $this->load->FacilityModel->GetDataById('masterData',$value['newValue']);
                                        $newValue = ucwords($newManagement['name']);
                                      } else if($value['columnName'] == 'Govt OR Non Govt') {
                                        $oldManagement = $this->load->FacilityModel->GetDataById('masterData',$value['oldValue']);
                                        $oldValue = ucwords($oldManagement['name']);
                                        $newManagement = $this->load->FacilityModel->GetDataById('masterData',$value['newValue']);
                                        $newValue = ucwords($newManagement['name']);
                                      } else if($value['columnName'] == 'Village/Town/City') {
                                        $oldValue = ucwords($this->load->FacilityModel->GetVillageName($value['oldValue']));
                                        $newValue = ucwords($this->load->FacilityModel->GetVillageName($value['newValue']));
                                      } else if($value['columnName'] == 'District') {
                                        $oldValue = ucwords($this->load->FacilityModel->GetDistrictName($value['oldValue']));
                                        $newValue = ucwords($this->load->FacilityModel->GetDistrictName($value['newValue']));
                                      } else if($value['columnName'] == 'Block') {
                                        $oldValue = ucwords($this->load->FacilityModel->GetBlockName2($value['oldValue']));
                                        $newValue = ucwords($this->load->FacilityModel->GetBlockName2($value['newValue']));
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
