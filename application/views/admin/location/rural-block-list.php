

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
                      <h5 class="content-header-title float-left pr-1 mb-0">Revenue Rural Block</h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white" style="max-width: max-content; float: left;">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Location/manageRevenue">Revenue District (U.P)</a>
                          </li>
                          <li class="breadcrumb-item active">Revenue Rural Block
                          </li>
                        </ol>
                        <p style="float: right; color: black;"><b>District Name:</b>&nbsp;<?php echo $districtData['DistrictNameProperCase'] ;?> | <b>District Code:</b>&nbsp;<?php echo $districtData['PRIDistrictCode'] ;?>
                        </p>
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
                                        <!-- <th>PRI District Code</th>
                                        <th>District Name</th> -->
                                        <th>PRI Block Code</th>                             
                                        <th>Block Name</th>
                                        <th>Village Count</th>
                                        <th>Status</th> 
                                        <th>Action</th> 
                                    </tr>
                                </thead>
                                <tbody>

                                  <?php 
                                    $counter ="1";

                                    foreach ($GetList as $value) {
                                      $getUrbanVillage = $this->LocationModel->getUrbanVillageByBlock($value['BlockPRICode']);
                                      $getRuralVillage = $this->LocationModel->getRuralVillageByBlock($value['BlockPRICode']);
                                  ?>
                                    <tr>
                                      <td><?php echo $counter; ?></td>
                                      <!-- <td><?php echo $value['PRIDistrictCode']; ?></td>
                                      <td><?php echo $value['DistrictNameProperCase']; ?></td> -->
                                      <td> <?php echo $value['BlockPRICode']; ?> </td>
                                      <td><?php echo $value['BlockPRINameProperCase']; ?></td>
                                      <td><a href="<?php echo base_url() ?>Location/urbanVillage/<?php echo $value['BlockPRICode']; ?>">Urban (<?php echo count($getUrbanVillage); ?>)</a><br>
                                          <a href="<?php echo base_url() ?>Location/ruralVillage/<?php echo $value['BlockPRICode']; ?>">Rural (<?php echo count($getRuralVillage); ?>)</a>
                                      </td>
                                      <td>
                                          <?php 
                                          if($value['STATUS'] =='1'){?>
                                                <span class="badge badge-pill badge-light-success mr-1">Activated
                                                </span>
                                          <?php } else { ?>
                                                 <span class="badge badge-pill badge-light-warning mr-1">
                                                  Deactivated  
                                                 </span>
                                          <?php } ?>
                                      </td>
                                      <td>
                                        <a href="<?php echo base_url(); ?>Location/EditBlock/<?php echo $value['BlockPRICode']; ?>" title="Edit District" class="btn btn-info btn-sm">View/Edit</a>
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

