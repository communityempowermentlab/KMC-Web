

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
                      <h5 class="content-header-title float-left pr-1 mb-0">Notification</h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item active">Notification
                          </li>
                        </ol>
                      </div>
                    </div>
                    
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        
                        <div id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>

                        <div class="table-responsive">
                          
                            <table class="table table-striped dataex-html5-selectors-notification">
                                <thead>
                                    <tr>
                                        <th>S&nbsp;No.</th>
                                        <th>Notification</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        <th>Generated&nbsp;On</th>
                                    </tr>
                                </thead>
                                <tbody>

                                  <?php 
                                    $counter ="1";

                                    foreach ($GetList as $value) {
                                      
                                      $generated_on =     $this->load->FacilityModel->time_ago_in_php($value['addDate']);
                                      
                                  ?>
                                  <tr id="update<?php echo $value['id'];?>">
                                    <td><?php echo $counter; ?></td>
                                    <td><?php echo $value['text']; ?></td>
                                    <td>
                                     <?php  
                                      $status = ($value['status']=='1') ? 'assets/act.png' :'assets/delete.png';

                                      if($value['type'] == "1"){
                                        $pending_text = "Pending";
                                        $closing_text = "Closed";
                                        $cancelled_text = "Cancelled";
                                      }else{
                                        $pending_text = "Unread";
                                        $closing_text = "Read";
                                        $cancelled_text = "Cancelled";
                                      }

                                      if ($value['status'] == 1) { ?> 
                                      <span class="badge badge-pill badge-light-warning mr-1">
                                         <?php echo $pending_text; ?> </span> 
                                      <?php } else  if ($value['status'] == 2) { ?>
                                      <span class="badge badge-pill badge-light-success mr-1">
                                          <?php echo $closing_text; ?> </span> 
                                      <?php } else  if ($value['status'] == 3) { ?>
                                      <span class="badge badge-pill badge-light-danger mr-1">
                                          <?php echo $cancelled_text; ?> </span> 
                                      <?php } ?>
                                      &nbsp;  
                                    </td>
                                    <td> <a href="<?php echo $value['url']; ?>" class="btn btn-info btn-sm" title="View" onclick="markReadNotification('<?php echo $value['id'] ?>');">View</a> </td>
                                    <td>
                                      <a class="tooltip nonclick_link"><?php echo $generated_on; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['addDate'])) ?></span></a>
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

