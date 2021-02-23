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
                <div class="card-header ">
                    <div class="col-12 pull-left">
                      <h5 class="content-header-title float-left pr-1 mb-0">Counselling</h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item active">Counselling Poster
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
                                        <th>Poster&nbsp;Title</th>  
                                        <th>Type</th>  
                                        <th>Status</th> 
                                        <th>Action</th> 
                                        <th>Updated&nbsp;On</th> 
                                    </tr>
                                </thead>
                                <tbody>

                                  <?php 
                                    $counter ="1";
                                    foreach ($GetVideo as $value) {
                                      $last_updated          = $this->FacilityModel->time_ago_in_php($value['modifyDate']);
                                      $posterTypes = array('1'=>'What is KMC?','2'=>'KMC Position','3'=>'KMC Nutrition','4'=>'KMC Hygiene','5'=>'KMC Monitoring','6'=>'KMC Respect');
                                  ?>
                                    <tr>
                                      <td><?php echo $counter; ?></td>
                                      <td><?php echo $value['videoTitle']; ?></td>
                                      <td><?php echo $posterTypes[$value['posterType']]; ?></td>
                                      <td>
                                        <?php if ($value['status'] == 1) { ?> 
                                          <span class="badge badge-pill badge-light-success mr-1">
                                            Activated  
                                          </span>
                                        <?php } else { ?>
                                          <span class="badge badge-pill badge-light-warning mr-1">
                                            Deactivated
                                          </span>
                                        <?php } ?>
                                        </td>
                                       <td><a href="<?php echo base_url(); ?>counsellingM/editCounsellingPoster/<?php echo $value['id']; ?>" title="Edit Poster Information" class="btn btn-info btn-sm">
                                          <?php if(($sessionData['Type']==1) || in_array(80, $userPermittedMenuData)){
                                            echo VIEW_BUTTON;
                                          }
                                          if(($sessionData['Type']==1) || (in_array(80,$userPermittedMenuData) && in_array(81,$userPermittedMenuData)))
                                          {
                                            echo "/";
                                          }
                                          if(($sessionData['Type']==1) || in_array(81, $userPermittedMenuData)){
                                            echo EDIT_BUTTON;
                                          }
                                          ?>
                                       </a></td> 
                                       <td><a class="tooltip nonclick_link"><?php echo $last_updated; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['modifyDate'])) ?></span></a></td>
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
<?php if(($sessionData['Type']==1) || in_array(79, $userPermittedMenuData)){ ?>
  <div class="add-new">
    <a href="<?php echo base_url(); ?>counsellingM/addCounsellingPoster" class="btn btn btn-danger align-items-center">
        <i class="bx bx-plus"></i>&nbsp; Add New Poster
    </a>
  </div>
<?php } ?>