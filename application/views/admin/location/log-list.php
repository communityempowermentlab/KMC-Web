

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
                      <h5 class="content-header-title float-left pr-1 mb-0">Revenue District (U.P)</h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white" style="max-width: max-content; float: left;">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>Location/manageRevenue">Revenue District (U.P)</a>
                          </li>
                          <li class="breadcrumb-item active">Revenue District Log
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
                                        
                                        <th>PRI District Code</th>
                                        <th>District Name</th>
                                        <th>Urban/Rural</th> 
                                        <th>PRI Block Code</th>                             
                                        <th>Block Name</th>
                                        <th>GP PRI Code</th>
                                        <th>GP Name</th>
                                        <th>Status</th> 
                                        <th>Action</th> 
                                        <th>Updated By</th> 
                                        <th>Updated At</th> 
                                        <th>IP Address</th> 
                                    </tr>
                                </thead>
                                <tbody>

                                  <?php 
                                    $counter ="1";

                                    foreach ($GetList as $value) {
                                      if($value['addedByType'] == 1){
                                        $addedBy = $this->load->FacilityModel->GetDataById('adminMaster',$value['addedBy']);
                                      } else if($value['addedByType'] == 2){
                                        $addedBy = $this->load->FacilityModel->GetDataById('employeesData',$value['addedBy']);
                                      } 
                                      $generated_on =     $this->load->FacilityModel->time_ago_in_php($value['addDate']);
                                  ?>
                                    <tr>
                                      <td><?php echo $counter; ?></td>
                                      
                                      <td> <?php echo empty($value['PRIDistrictCode']) ? 'N/A' : $value['PRIDistrictCode']; ?> </td>
                                      <td> <?php echo empty($value['DistrictNameProperCase']) ? 'N/A' : $value['DistrictNameProperCase']; ?></td>
                                      <td> <?php echo empty($value['UrbanRural']) ? 'N/A' : $value['UrbanRural']; ?></td>
                                      <td> <?php echo empty($value['BlockPRICode']) ? 'N/A' : $value['BlockPRICode']; ?> </td>
                                      <td> <?php echo empty($value['BlockPRINameProperCase']) ? 'N/A' : $value['BlockPRINameProperCase']; ?></td>
                                      <td> <?php echo empty($value['GPPRICode']) ? 'N/A' : $value['GPPRICode']; ?> </td>
                                      <td> <?php echo empty($value['GPNameProperCase']) ? 'N/A' : $value['GPNameProperCase']; ?></td>
                                      <td>
                                          <?php 
                                          if($value['status'] =='1'){?>
                                                <span class="badge badge-pill badge-light-success mr-1">Activated
                                                </span>
                                          <?php } else { ?>
                                                 <span class="badge badge-pill badge-light-warning mr-1">
                                                  Deactivated  
                                                 </span>
                                          <?php } ?>
                                      </td>
                                      <td> <?php echo $value['actionType']; ?> </td>
                                      <td><?php echo ucwords($addedBy['name']);?></td>
                                      <td><a href="javascript:void(0);" class="tooltip"><?php echo $generated_on; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['addDate'])) ?></span></a></td>
                                      <td><?php echo $value['ipAddress']?></td>
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



