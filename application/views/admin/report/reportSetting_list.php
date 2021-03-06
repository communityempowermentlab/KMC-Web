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


<?php
  if(isset($_GET['district']) && !empty($_GET['district'])){
    $district = $_GET['district']; 
    $Facility = $this->LoungeModel->GetFacilityByDistrict($district); 
  } else {
    $district = '';
    $Facility = array();
  }

  if(isset($_GET['fromDate'])){
    $fromDate = $_GET['fromDate'];
  } else {
    $fromDate = '';
  }

  if(isset($_GET['toDate'])){
    $toDate = $_GET['toDate'];
  } else {
    $toDate = '';
  }

  if(isset($_GET['category'])){
    $category = $_GET['category']; 
  } else {
    $category = '';
  }


?>




<!-- Column selectors with Export Options and print table -->
<section id="column-selectors">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="col-6 pull-left">
                      <h5 class="content-header-title float-left pr-1 mb-0">Report Setting</h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item active">Report Setting List
                          </li>
                        </ol>
                      </div>
                    </div>
                    <div class="col-6 pull-right">
                        <p>Resources [<a href="javascript:void(0)" onclick="facilityDfd('<?php echo base_url(); ?>assets/dfdAndFunctionalDiagram/report.png', 'Staff Data Flow Diagram (DFD)')">Data Flow Diagram</a>]
                         <!-- [<a href="javascript:void(0)" onclick="facilityDfd('<?php echo base_url(); ?>assets/dfdAndFunctionalDiagram/staffFlowChart.png', 'Staff Functional Diagram')">Functional Diagram</a>] -->
                        </p>

                    </div>

                </div>
                &nbsp;
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        
                        <div id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>

                        <div class="table-responsive">
                          <div class="row col-md-6 search pl-1" style="float: right;">
                            <div class="col-md-12">
                              <form action="" method="GET">
                                <div class="row">
                                  <div class="col-md-2"></div>
                                  <div class="col-md-10">
                                    <div class="row">
                                      <!-- <div class="col-md-3 p-0">
                                        <select class="select2 form-control" name="district" onchange="getFacility(this.value, '<?php echo base_url('loungeM/getFacility/') ?>')">
                                          <option value="">Select District</option>
                                          <?php
                                            foreach ($GetDistrict as $key => $value) {?>
                                              <option value="<?php echo $value['PRIDistrictCode']; ?>" <?php if($district == $value['PRIDistrictCode']) { echo 'selected'; } ?>><?php echo $value['DistrictNameProperCase']; ?></option>
                                          <?php } ?>
                                        </select>
                                      </div> -->
                                      <div class="col-md-6 p-0">
                                        <select class="select2 form-control" name="category" id="category">
                                          <option value="">Select Report Category</option>
                                          <?php
                                            foreach ($reportCategory as $key => $value) {?>
                                              <option value="<?php echo $value['id']; ?>" <?php if($category == $value['id']) { echo 'selected'; } ?>><?php echo $value['name']; ?></option>
                                          <?php } ?>
                                        </select>
                                      </div>
                                      <div class="col-md-6 p-0">
                                        <fieldset>
                                          <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Enter Keywords" aria-describedby="button-addon2" name="keyword" value="<?php
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
                            <table class="table table-striped dataex-html5-selectors-staff">
                                <thead>
                                    <tr>
                                      <th>S&nbsp;No.</th>
                                      <th>Report Category</th>
                                      <th>Subject</th>
                                      <!-- <th>Body</th> -->
                                      <th>Subscription</th>
                                      <th>Action</th>
                                      <!-- <th>UPDATED&nbsp;AT</th> -->
                                    </tr>
                                </thead>
                                <tbody>

                                <?php 
                                  ($pageNo == '1') ? $counter = '1' : $counter = ((($pageNo*DATA_PER_PAGE)-DATA_PER_PAGE) + 1);
                                  if(!empty($results)) { 
                                  foreach ($results as $value) { ?>
                                  <tr>
                                    <td><?php echo $counter; ?></td>
                                    <td><?php echo $value['categoryName']; ?></td>
                                    <td><?php echo $value['subject'];
                                    $totalloungeInReport = $this->ReportSettingModel->GettotalLoungeAddInReport($value['id']);
                                    if ($totalloungeInReport == $totalActivLounge) { ?> &nbsp;
                                      <i class="fas fa-check-square green-color fa-1x" title="All Lounge Add"></i>
                                    <?php } else{
                                     ?>
                                        <i class="fa fa-window-close red-color" aria-hidden="true" title="Missing Lounge"></i>
                                    <?php } ?>
                                    </td>
                                    <!-- <td><?php echo $value['body']; ?></td> -->
                                    
                                    <td>
                                     <?php if($value['subscription'] == "Yes") { ?> 
                                        <span class="badge badge-pill badge-light-success mr-1">
                                          Yes 
                                        </span>
                                      <?php } else { ?>
                                          <span class="badge badge-pill badge-light-warning mr-1">
                                            No
                                          </span>
                                      <?php } ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>/GenerateReportM/updateReport/<?php echo $value['id']; ?>" title="View/Edit Report" class="btn btn-info btn-sm" style="margin: 1px;">
                                      <?php if(($sessionData['Type']==1) || in_array(70, $userPermittedMenuData)){
                                        echo VIEW_BUTTON;
                                      }
                                      if(($sessionData['Type']==1) || (in_array(70,$userPermittedMenuData) && in_array(71,$userPermittedMenuData)))
                                      {
                                        echo "/";
                                      }
                                      if(($sessionData['Type']==1) || in_array(71, $userPermittedMenuData)){
                                        echo EDIT_BUTTON;
                                      }
                                      ?>
                                    </a>


                                    <?php if(($sessionData['Type']==1) || in_array(72, $userPermittedMenuData)){ ?>
                                      <a href="<?php echo base_url(); ?>/GenerateReportM/dailyDownloadReport/<?php echo $value['id']; ?>" title="Reports" class="btn btn-primary btn-sm" style="margin: 1px;">Reports</a>
                                    <?php } ?>
                                    </td>
                                   
                                    
                                    
                                    <!-- <td><?php if(!empty($value['addDate'])) { ?><span class="tooltiptext"><?php
                                   echo $last_updated =     $this->load->FacilityModel->time_ago_in_php($value['addDate']);
                                     ?></span><?php } else { echo "N/A"; } ?> </td> -->
                                    
                                  </tr>
                                    <?php $counter ++ ; } } else {
                                      echo '<tr><td colspan="13" style="text-align:center;">No Records Found!</td></tr>';
                                    } ?>
                                    
                                </tbody>
                                
                            </table>
                            <?php if(!empty($totalResult)) { 
                    ($pageNo == '1') ?  $counter = '1' : $counter = ((($pageNo*DATA_PER_PAGE)-DATA_PER_PAGE) + 1);
                    echo '<br>Showing '.$counter.' to '.((($pageNo*DATA_PER_PAGE)-DATA_PER_PAGE) + DATA_PER_PAGE).' of '.count($totalResult).' entries';
                 } ?>
                            <ul class="pagination pull-right">
                              <?php
                              if(!empty($links)){
                                foreach ($links as $link) {
                                    echo "<li >" . $link . "</li>";
                                }
                              }
                               ?>
                            </ul> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Column selectors with Export Options and print table -->

<?php if(($sessionData['Type']==1) || in_array(69, $userPermittedMenuData)){ ?>
  <div class="add-new">
    <a href="<?php echo base_url('GenerateReportM/addGenerateReportM/');?>" class="btn btn btn-danger align-items-center">
        <i class="bx bx-plus"></i>&nbsp; Add New Report
    </a>
  </div>
<?php } ?>
<style>
.blue-color {
color:blue;
}
.green-color {
color:green;
}
.teal-color {
color:teal;
}
.yellow-color {
color:yellow;
}
.red-color {
color:red;
}
</style>