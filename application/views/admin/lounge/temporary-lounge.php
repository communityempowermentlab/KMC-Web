    <!-- BEGIN: Content-->
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        
      <div class="content-body">

<?php
  $ID      = $this->uri->segment(3);
  $Lounge  = $this->FacilityModel->GetLoungeById($ID);

  if(isset($_GET['district']) && !empty($_GET['district'])){
    $district = $_GET['district']; 
  } else {
    $district = '';
  }

  if(isset($_GET['facilityname']) && !empty($_GET['facilityname'])){
    $facilityname = $_GET['facilityname']; 
  } else {
    $facilityname = '';
  }

  if(isset($_GET['facility_status']) && !empty($_GET['facility_status'])){
    $facility_status = $_GET['facility_status']; 
  } else {
    $facility_status = '';
  }
?>



<!-- Column selectors with Export Options and print table -->
<section id="column-selectors">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-12 ">
                      <h5 class="content-header-title float-left pr-1 mb-0">Amenities Information</h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          
                          <li class="breadcrumb-item active">Amenities Information
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
                                  <div class="col-md-3"></div>
                                  <div class="col-md-9">
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
                                        <input type="hidden" id="searched_facilityname" value="<?php echo $facilityname; ?>">
                                      </div>

                                      <div class="col-md-3 p-0">
                                        <select class="select2 form-control" name="facility_status" id="facility_status">
                                          <option value="0">Select Status</option>
                                          <option value="1" <?php if($facility_status == 1){ echo "selected"; } ?>>Pending</option>
                                          <option value="2" <?php if($facility_status == 2){ echo "selected"; } ?>>Approved</option>
                                          <option value="3" <?php if($facility_status == 3){ echo "selected"; } ?>>Rejected</option>
                                        </select>
                                        <input type="hidden" id="searched_facilityname" value="<?php echo $facilityname; ?>">
                                      </div>
                                      
                                      <div class="col-md-3 p-0">
                                        <fieldset>
                                          <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Enter Keyword" autocomplete="off" aria-describedby="button-addon2" name="keyword" value="<?php
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

                            <table class="table table-striped dataex-html5-selectors-lounge">
                                <thead>
                                    <tr>
                                      <th>S&nbsp;No.</th>
                                      <th>District</th>
                                      <th>Facility</th>
                                      <th>Lounge</th>
                                      <th>Lounge Mobile</th>
                                      <th>Verified Mobile</th>
                                      <th>Added&nbsp;On</th>
                                      <th>Status</th>
                                      <th style="width:200px !important;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                  <?php 
                                    $counter ="1";
                                    foreach ($GetLounge as $value) {
                                      
                                      $Facility = $this->db->query("SELECT * FROM `facilitylist` where FacilityID='".$value['facilityId']."'")->row_array();
                                      $District = $this->db->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs` where PRIDistrictCode='".$Facility['PRIDistrictCode']."'")->row_array();
                                      $Lounge = $this->db->query("SELECT * FROM `loungeMaster` where loungeId='".$value['loungeId']."'")->row_array();
                                      $added_on = $this->load->FacilityModel->time_ago_in_php($value['addDate']);
                                  ?>


                                    <tr>
                                      <td><?php echo $counter; ?></td>
                                      <td><?php echo $District['DistrictNameProperCase']; ?></td>
                                      <td><?php echo $Facility['FacilityName']; ?></td>
                                      <td><?php echo $Lounge['loungeName']; ?></td>
                                      <td><?php echo !empty($Lounge['loungeContactNumber']) ? $Lounge['loungeContactNumber'] : 'N/A'; ?></td>
                                      <td><?php echo (!empty($value['verifiedMobile'])) ? $value['verifiedMobile']:"N/A"; ?></td>
                                      <td><a class="tooltip" href="javascript:void(0)" style="cursor: default;color: #727E8C;"><?php echo $added_on; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['addDate'])) ?></span></a>
                                      </td>
                                      <td>
                                        <?php $status = ($value['status'] == '1') ? 'assets/act.png' :'assets/delete.png';
                                        if($value['status'] == '1'){?>
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
                                      <td> <a href="<?php echo base_url(); ?>loungeM/editTemporaryLounge/<?php echo $value['id']; ?>" class="btn btn-sm btn-info">View</a>
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

<script type="text/javascript">
$( document ).ready(function() {
  var district = '<?php echo $district; ?>';
  if(district != ""){
    getFacility('<?php echo $district ?>', '<?php echo base_url('loungeM/getFacility/') ?>');
  }
});
</script>

