

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
                      <h5 class="content-header-title float-left pr-1 mb-0">States</h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item active">States
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
                                        <th>Name</th>                             
                                        <th>State Code</th>
                                        <th>Census Code 2001</th>
                                        <th>Census Code 2011</th> 
                                    </tr>
                                </thead>
                                <tbody>

                                  <?php 
                                    $counter ="1";

                                    foreach ($GetList as $value) {
                    
                                  ?>
                                    <tr id="update<?php echo $value['id'];?>">
                                      <td><?php echo $counter; ?></td>
                                      <td><?php echo $value['stateName']; ?></td>
                                      <td><?php echo $value['stateCode']; ?></td>
                                      <td> <?php echo $value['censusCode2001']; ?> </td>
                                      <td><?php echo $value['censusCode2011']; ?></td>
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

