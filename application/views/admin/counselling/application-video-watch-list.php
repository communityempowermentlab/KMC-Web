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


<!-- Column selectors with Export Options and print table -->
<section id="column-selectors">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="col-6 pull-left">
                      <h5 class="content-header-title float-left pr-1 mb-0">Counselling</h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item active"><?php
                          if(!empty($GetVideo)){
                            $stvediotitle = explode('|', $GetVideo[0]['videoTitle']);
                             echo $stvediotitle[0];
                           } ?>
                          </li>
                          <li class="breadcrumb-item active"> Video Count
                          </li>
                        </ol>
                      </div>
                    </div>
                    <div class="col-6 pull-right">
                        <p>Resources [<a href="javascript:void(0)" onclick="facilityDfd('<?php echo base_url(); ?>assets/dfdAndFunctionalDiagram/counsellingVideoDFD.png', '<?php echo $index; ?> Data Flow Diagram (DFD)')">Data Flow Diagram</a>][<a href="javascript:void(0)" onclick="facilityDfd('<?php echo base_url(); ?>assets/dfdAndFunctionalDiagram/councelingPSD.png', ' <?php echo $index; ?> Data Flow Diagram (DFD)')">Functional Diagram</a>] </p>
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
                                        <th>Lounge Name</th>  
                                        <th>Total Clicks</th> 
                                        <th>Last view</th> 
                                    </tr>
                                </thead>
                                <tbody>

                                  <?php 
                                    $counter ="1";
                                    foreach ($GetVideo as $value) {
                                      // $last_updated          = $this->FacilityModel->time_ago_in_php($value['addDate']);
                                      $timewatch = $this->CounsellingModel->videoWatchlasttime($value['counsellingMasterId'], $value['loungeId']);
                                      //print_r($timewatch);
                                        $last_updated          = $this->FacilityModel->time_ago_in_php($timewatch['addDate']);
                                  ?>

                                    <tr>
                                      <td><?php  echo $counter; ?></td>
                                      <td ><?php  echo $value['loungeName']; ?></td>
                                      <td >
                                        
                                      <a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal" title="Video Information" onclick="watchVideos(<?php echo $value['counsellingMasterId']; ?>,<?php echo $value['loungeId']; ?>,'<?php echo base_url('counsellingM/ajaxVideowatchlist');?>')">
                                        <?php 
                                        echo $result = $this->CounsellingModel->clickVideoCountLounge($value['counsellingMasterId'],$value['loungeId']);
                                      ?> 
                                    </a>
                                     </td>
                                      
                                       
                                       <td><a class="tooltip nonclick_link"><?php echo $last_updated; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($timewatch['addDate'])) ?></span></a></td>
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Video Watching Time</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="ajaxdata">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function watchVideos(id, loungeId, url){ 
    
    //alert(name);
      $.ajax({
            type:"POST",
            url: url,
            data: {"id":id,"loungeId":loungeId},
            success: function(html){ //alert(html);
              // if(html > 0){
                 $('#ajaxdata').html(html);
              //   $('#image').val("").focus();
              // }else{
              //   $('#err_video_name').html("").hide();
              // }
            }
          });
    
    
  }
</script>