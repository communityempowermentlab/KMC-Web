

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
                      <h5 class="content-header-title float-left pr-1 mb-0">Revenue Urban Village</h5>
                      <div class="breadcrumb-wrapper col-12" >
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white" style="max-width: max-content; float: left;">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Location/manageRevenue">Revenue District (U.P)</a>
                          </li>
                         <!--  <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Location/urbanBlock/<?= $BlockPRICode; ?>">Revenue Urban Block</a>
                          </li> -->
                          <li class="breadcrumb-item active">Revenue Urban Village
                          </li>
                        </ol>
                        <p style="float: right; color: black;"><b>Block Name:</b>&nbsp;<?php echo $blockData['BlockPRINameProperCase'] ;?> | <b>Block Code:</b>&nbsp;<?php echo $blockData['BlockPRICode'] ;?>
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
                                        <!-- <th>PRI Block Code</th>                             
                                        <th>Block Name</th> -->
                                        <th>GP PRI Code</th>
                                        <th>GP Name</th>
                                        <th>Status</th> 
                                        <th>Action</th> 
                                    </tr>
                                </thead>
                                <tbody>

                                <?php 
                                  $counter ="1";
                                  foreach ($GetList as $value) {
                                ?>
                                  <tr>
                                    <td><?php echo $counter; ?></td>
                                    <!-- <td><?php echo $value['BlockPRICode']; ?></td>
                                    <td><?php echo $value['BlockPRINameProperCase']; ?></td> -->
                                    <td> <?php echo $value['GPPRICode']; ?> </td>
                                    <td><?php echo $value['GPNameProperCase']; ?></td>
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
                                      <a href="<?php echo base_url(); ?>Location/EditVillage/<?php echo $value['GPPRICode']; ?>" title="Edit District" class="btn btn-info btn-sm">View/Edit</a>
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
  <a href="<?php echo base_url('Location/AddLocation/Urban');?>" class="btn btn btn-danger align-items-center">
      <i class="bx bx-plus"></i>&nbsp; Add New Village
  </a>
</div>