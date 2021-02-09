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

<?php
  if(isset($_GET['district']) && !empty($_GET['district'])){
    $district = $_GET['district']; 
    $Facility = $this->LoungeModel->GetFacilityByDistrict($district); 
  } else {
    $district = '';
    $Facility = array();
  }

  if(isset($_GET['facilityname'])){
    $facilityname = $_GET['facilityname']; 
  } else {
    $facilityname = '';
  }


?>




<!-- Column selectors with Export Options and print table -->
<section id="column-selectors">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-12 pull-left">
                      <h5 class="content-header-title float-left pr-1 mb-0">Enquiries</h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item active">Enquiries
                          </li>
                        </ol>
                      </div>
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
                                  <div class="col-md-2"></div>
                                  <div class="col-md-10">
                                    <div class="row">
                                      <div class="col-md-3 p-0">
                                        <select class="select2 form-control" name="district" onchange="getFacility(this.value, '<?php echo base_url('loungeM/getFacility/') ?>')">
                                          <option value="">Select District</option>
                                          <?php
                                            foreach ($GetDistrict as $key => $value) {?>
                                              <option value="<?php echo $value['PRIDistrictCode']; ?>" <?php if($district == $value['PRIDistrictCode']) { echo 'selected'; } ?>><?php echo $value['DistrictNameProperCase']; ?></option>
                                          <?php } ?>
                                        </select>
                                      </div>
                                      <div class="col-md-3 p-0">
                                        <select class="select2 form-control" name="facilityname" id="facilityname" onchange="getLounge(this.value, '<?php echo base_url('motherM/getLounge/') ?>'), getNurse(this.value, '<?php echo base_url('motherM/getNurse/') ?>')">
                                          <option value="">Select Facility</option>
                                          <?php
                                            foreach ($Facility as $key => $value) {?>
                                              <option value="<?php echo $value['FacilityID']; ?>" <?php if($facilityname == $value['FacilityID']) { echo 'selected'; } ?>><?php echo $value['FacilityName']; ?></option>
                                          <?php } ?>
                                        </select>
                                      </div>
                                      <div class="col-md-6 p-0">
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
                            <table class="table table-striped dataex-html5-selectors-enquiry">
                                <thead>
                                    <tr>
                                        <th style="padding: 1.15rem 1.25rem;">S&nbsp;No.</th>
                                        <th style="padding: 1.15rem 1.25rem;">Ticket&nbsp;ID</th>
                                        <th>District</th> 
                                        <th>Facility</th>   
                                        <th>Lounge</th>                             
                                        <th>Location</th>
                                        <th>Enquiry&nbsp;At</th>
                                        <!-- <t
                                          h>Response</th> -->
                                        <th>Response&nbsp;At</th>
                                        <th>Action&nbsp;By</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                  <?php 
                                    $counter ="1";

                                    foreach ($GetList as $value) {
                                      $last_updated =     $this->load->FacilityModel->time_ago_in_php($value['modifyDate']);
                                      if(!empty($value['loungeId'])){
                                        $lounge =     $this->load->FacilityModel->GetLoungeById($value['loungeId']); 
                                        $loungeName = $lounge['loungeName'];
                                        $facility   =     $this->load->FacilityModel->GetFacilityName($lounge['facilityId']); 
                                        $facilityName = $facility['FacilityName'];
                                        $district   =     $this->load->FacilityModel->GetDistrictName($facility['PRIDistrictCode']);
                                      } else {
                                        $loungeName   = '--';
                                        $facilityName = '--';
                                        $district   = '--';
                                      }
                                      $generated_on =     $this->load->FacilityModel->time_ago_in_php($value['addDate']);
                                      
                                  ?>
                                  <tr id="update<?php echo $value['id'];?>">
                                    <td style="padding: 1.15rem 1.25rem;"><?php echo $counter; ?></td>
                                    <td style="padding: 1.15rem 1.25rem;"><?php echo $value['id']; ?></td>
                                    <td><?php echo $district; ?></td>
                                    <td><?php echo $facilityName; ?></td>
                                    <td><?php echo $loungeName; ?></td>
                                    <td style="min-width:100px;"><?php echo (!empty($value['location']))?$value['location']:"--" ?></td>
                                    <td>
                                      <a class="tooltip nonclick_link"><?php echo $generated_on; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['addDate'])) ?></span></a>
                                    </td>
                                    <!-- <td>
                                     <?php  if ($value['responseGivenBy'] != '') { 
                                      echo $value['remark'];
                                       } else { echo '--'; } ?>
                                      &nbsp;  
                                    </td> -->
                                    <td><?php if ($value['responseGivenBy'] != '') { ?> 
                                      <a class="tooltip nonclick_link"><?php echo $last_updated; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['modifyDate'])) ?></span></a>
                                      <?php  } else { echo "--"; } ?></td>
                                    <td><?php if ($value['responseGivenBy'] != '') { echo 'Admin'; } else { echo '--'; } ?></td>
                                    <td>
                                     <?php  
                                      $status = ($value['status']=='1') ? 'assets/act.png' :'assets/delete.png';
                                      if ($value['status'] == 1) { ?> 
                                      <span class="badge badge-pill badge-light-warning mr-1">
                                         Pending</span> 
                                      <?php } else  if ($value['status'] == 2) { ?>
                                      <span class="badge badge-pill badge-light-success mr-1">
                                          Closed  </span> 
                                      <?php } else  if ($value['status'] == 3) { ?>
                                      <span class="badge badge-pill badge-light-danger mr-1">
                                          Cancelled  </span> 
                                      <?php } ?>
                                      &nbsp;  
                                    </td>
                                    <td> <a href="<?php echo base_url(); ?>enquiryM/takeAction/<?php echo $value['id']; ?>" class="btn btn-info btn-sm" title="Take Action On Enquiry">
                                      <?php if(($sessionData['Type']==1) || in_array(13, $userPermittedMenuData)){
                                        echo VIEW_BUTTON;
                                      }
                                      if(($sessionData['Type']==1) || (in_array(13,$userPermittedMenuData) && in_array(68,$userPermittedMenuData)))
                                      {
                                        echo "/";
                                      }
                                      if(($sessionData['Type']==1) || in_array(68, $userPermittedMenuData)){
                                        echo EDIT_BUTTON;
                                      }
                                      ?>
                                    </a> </td>
                                    
                                    
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

