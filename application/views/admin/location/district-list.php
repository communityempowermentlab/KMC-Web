

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
                          <li class="breadcrumb-item active">Revenue District (U.P)
                          </li>
                        </ol>
                        <p style="float: right; color: black;"><a href="<?php echo base_url(); ?>Location/revenueLog"><b>View Revenue Location Log</b></a>
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
                                        <!-- <th>State Name</th>                             
                                        <th>State Code</th> -->
                                        <th>PRI District Code</th>
                                        <th>District Name</th>
                                        <th>Block Count</th> 
                                        <th>Status</th> 
                                        <th>Action</th> 
                                    </tr>
                                </thead>
                                <tbody>

                                  <?php 
                                    $counter ="1";

                                    foreach ($GetList as $value) {
                                      $getUrbanBlock = $this->LocationModel->getUrbanBlockByDistrict($value['PRIDistrictCode']);
                                      $getRuralBlock = $this->LocationModel->getRuralBlockByDistrict($value['PRIDistrictCode']);
                                  ?>
                                    <tr>
                                      <td><?php echo $counter; ?></td>
                                      <!-- <td><?php echo $value['StateNameProperCase']; ?></td>
                                      <td><?php echo $value['StateCode']; ?></td> -->
                                      <td> <?php echo $value['PRIDistrictCode']; ?> </td>
                                      <td><?php echo $value['DistrictNameProperCase']; ?></td>
                                      <td><a href="<?php echo base_url() ?>Location/urbanBlock/<?php echo $value['PRIDistrictCode']; ?>">Urban (<?php echo count($getUrbanBlock); ?>)</a><br>
                                          <a href="<?php echo base_url() ?>Location/ruralBlock/<?php echo $value['PRIDistrictCode']; ?>">Rural (<?php echo count($getRuralBlock); ?>)</a>
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
                                        <a href="<?php echo base_url(); ?>Location/EditDistrict/<?php echo $value['PRIDistrictCode']; ?>" title="Edit District" class="btn btn-info btn-sm">View/Edit</a>
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



