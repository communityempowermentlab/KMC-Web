

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
                      <h5 class="content-header-title float-left pr-1 mb-0">Mothers</h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item"><a href="<?php echo base_url('motherM/viewMother/'.$motherId); ?>">Counselling</a></li>
                          <li class="breadcrumb-item active"><?php echo $GetCounsellingPosterDetails['videoTitle']; ?></li>
                        </ol>
                      </div>
                    </div>
                </div>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        
                        <div id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
                        
                        <div class="table-responsive" style="overflow-y: hidden;">
                            <table class="table table-striped dataex-html5-selectors-log">
                                <thead>
                                    <tr>
                                      <th style="width:70px;">S&nbsp;No.</th>
                                      <th>Date & Time</th>
                                      <th>Seen&nbsp;Time</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php 
                                      $counter=1;
                                      foreach($GetAllCounsellingPosterList as $key => $counsellingValue) { 
                                      $totalSeenTime = $counsellingValue['duration'];

                                      $hours = floor($totalSeenTime / 3600);
                                      $mins = floor($totalSeenTime / 60 % 60);
                                      $secs = floor($totalSeenTime % 60);
                                      $timeFormat = $hours."h"." ".$mins."m"." ".$secs."s";
                                    ?>
                                    <tr>
                                      <td><?php echo $counter++;?></td>
                                      <td><?php echo date("d-m-Y g:i A", strtotime($counsellingValue['addDate']));?></td>         
                                      <td><?php echo $timeFormat; ?></td>
                                    </tr>
                                    <?php } ?>
                                        
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

