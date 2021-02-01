<?php
  if(isset($_GET['district']) && !empty($_GET['district'])){
    $district = $_GET['district']; 
  } else {
    $district = '';
  }

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
                <div class="card-header pb-0">
                    <div class="col-6 pull-left">
                      <h5 class="content-header-title float-left pr-1 mb-0">Facilities</h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item active">Facilities
                          </li>
                        </ol>
                      </div>
                    </div>
                    <div class="col-6 pull-right">
                        <p>Resources [<a href="javascript:void(0)" onclick="facilityDfd('<?php echo base_url(); ?>assets/dfdAndFunctionalDiagram/facilityERDiagram.png', 'Facilities Data Flow Diagram (DFD)')">Data Flow Diagram</a>] [<a href="javascript:void(0)" onclick="facilityDfd('<?php echo base_url(); ?>assets/dfdAndFunctionalDiagram/facilityFunctional.png', 'Facilities Functional Diagram')">Functional Diagram</a>]</p>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        
                        <div id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>

                        <div class="table-responsive">
                          <div class="row col-md-10 search pl-1" style="float: right;">
                            <div class="col-md-12">
                              <form action="" method="GET">
                                <div class="row">
                                  <div class="col-md-5"></div>
                                  <div class="col-md-7">
                                    <div class="row">
                                      <div class="col-md-5 p-0">
                                        <select class="select2 form-control" name="district" onchange="getFacility(this.value, '<?php echo base_url('loungeM/getFacility/') ?>')">
                                          <option value="">Select District</option>
                                          <?php
                                            foreach ($GetDistrict as $key => $value) {?>
                                              <option value="<?php echo $value['PRIDistrictCode']; ?>" <?php if($district == $value['PRIDistrictCode']) { echo 'selected'; } ?>><?php echo $value['DistrictNameProperCase']; ?></option>
                                          <?php } ?>
                                        </select>
                                      </div>
                                      
                                      <div class="col-md-7 p-0">
                                        <fieldset>
                                          <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Enter Keywords" aria-describedby="button-addon2" name="keyword" value="<?php
                                             if (!empty($_GET['keyword'])) {
                                                 echo $_GET['keyword'];
                                             }
                                             ?>">
                                            <div class="input-group-append" id="button-addon2">
                                              <button class="btn btn-sm btn-primary" type="submit"><i class="bx bx-search"></i></button>
                                            </div>
                                          </div>
                                        </fieldset>
                                      </div>
                                      
                                    </div>
                                  </div>
                                  
                                </div>
                                
                              </form>
                            </div>
                          </div>
                            <table class="table table-striped dataex-html5-selectors-facility">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <!-- <th>Type</th> -->
                                        <th>District</th>
                                        <th>Name</th>
                                        
                                        <!-- <th>Address</th> -->
                                        <th>CMS/MOIC Name</th>
                                        <th>CMS/MOIC Number</th>
                                        <th>Status</th>
                                        <th>Updated&nbsp;On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                  <?php $counter ="1";
                                   foreach ($GetFacilities as $key => $value) {
                                      $FacilityManagement = $this->load->FacilityModel->GetDataById('masterData',$value['FacilityManagement']);
                                      $BlockName = $this->load->FacilityModel->GetBlockName2($value['PRIBlockCode']);
                                     
                                      $DistrictName = $this->load->FacilityModel->GetDistrictName($value['PRIDistrictCode']); 
                                      $Village = $this->load->FacilityModel->GetVillageName($value['GPPRICode']);
                                      $state = $this->load->FacilityModel->GetStateName($value['StateID']);
                                      $address = $value['Address'].' '.$Village.' '.$BlockName.' '.$DistrictName.', '.$state;
                                      $get_last_updated = $this->load->FacilityModel->GetFacilityLastUpdate($value['FacilityID']);
                                      $last_updated =     $this->load->FacilityModel->time_ago_in_php($get_last_updated['addDate']);
                                   ?>
                                    <tr>
                                        <td><?php echo $counter; ?></td>
                                        <!-- <td><?php echo $value['FacilityType']; ?></td> -->
                                        <td><?php echo $DistrictName; ?></td>
                                        <td><?php echo $value['FacilityName']; ?></td>
                                        
                                        <!-- <td><?php echo $address; ?></td> -->
                                        <td><?php if(!empty($value['CMSOrMOICName'])){ echo $value['CMSOrMOICName']; } else { echo 'N/A'; }?></td>
                                        <td><?php if(!empty($value['CMSOrMOICMoblie'])){ echo $value['CMSOrMOICMoblie']; } else { echo 'N/A'; }?></td>
                                        <td>
                                          <?php $status = ($value['Status'] == '1') ? 'assets/act.png' :'assets/delete.png';
                                          if($value['Status'] =='1'){?>
                                                <span class="badge badge-pill badge-light-success mr-1">Activated
                                                </span>
                                          <?php } else { ?>
                                                 <span class="badge badge-pill badge-light-warning mr-1">
                                                  Deactivated  
                                                 </span>
                                          <?php } ?>
                                        </td>
                                        <td>
                                          <?php if(!empty($get_last_updated)) { ?>
                                          <a href="<?php echo base_url(); ?>facility/viewFacilityLog/<?php echo $value['FacilityID']; ?>" class="tooltip"><?php echo $last_updated; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['ModifyDate'])) ?></span></a>
                                        <?php } else { echo 'N/A'; } ?>
                                        </td>
                                        <td>
                                          <a href="<?php echo base_url(); ?>facility/updateFacility/<?php echo $value['FacilityID']; ?>" title="Edit Facility Information" class="btn btn-info btn-sm">View/Edit</a>
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

<div class="add-new">
  <a href="<?php echo base_url('facility/AddFacility/');?>" class="btn btn btn-danger align-items-center">
      <i class="bx bx-plus"></i>&nbsp; Add New Facility
  </a>
</div>