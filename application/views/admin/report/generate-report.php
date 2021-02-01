

    <!-- BEGIN: Content-->
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        
      <div class="content-body">



<?php
  if(isset($_GET['fromDate'])) {
      $fromDate = date("d F, Y",strtotime($_GET['fromDate']));
      $toDate = date("d F, Y",strtotime($_GET['toDate']));
  } else {
      $fromDate = date("01 F, Y");
      $toDate = date("d F, Y");
  }
?>


<!-- Column selectors with Export Options and print table -->
<section id="column-selectors">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-12 pull-left">
                      <h5 class="content-header-title float-left pr-1 mb-0">Generate Reports  </h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item active">Generate Reports  
                          </li>
                        </ol>
                      </div>
                    </div>
                    
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        
                        <div id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>

                        <div class="row col-12">
                          <div class="col-md-4">
                            <label>Lounge:</label>
                            <select class="select2 form-control" name="loungeid" id="lounge">
                              <?php
                                foreach ($totalLounges as $key => $value) {?>
                                  <option value="<?php echo $value['loungeId']; ?>" ><?php echo $value['loungeName']; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="col-md-4">
                              <label>From:</label>
                              <div class="controls">
                                <fieldset class="form-group position-relative has-icon-left">
                                  <input type="text" class="form-control pickadate-months-year" id="fromDate" value="<?= $fromDate; ?>" placeholder="Select From Date" name="fromDate" required="" data-validation-required-message="This field is required">
                                  <div class="form-control-position calendar-position">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                  </div>
                                </fieldset>
                              </div>
                            
                          </div>
                          <div class="col-md-4">
                            <label>To:</label>
                            <div class="controls">
                              <fieldset class="form-group position-relative has-icon-left">
                                <input type="text" class="form-control pickadate-months-year" id="toDate" value="<?= $toDate; ?>" placeholder="Select To Date" name="toDate" required="" data-validation-required-message="This field is required">
                                <div class="form-control-position calendar-position">
                                  <i class="fa fa-calendar" aria-hidden="true"></i>
                                </div>
                              </fieldset>
                            </div>
                          </div>
                        </div>

                         <div class=" col-12">
                            <button name="create_excel_sts" id="create_excel_sts" class="btn btn-sm btn-primary">Download KMC Report</button>
                            <button name="create_excel_feedng" id="create_excel_feedng" class="btn btn-sm btn-primary">Download Feeding Report</button>
                            <button name="create_excel_admission" id="create_excel_admission" class="btn btn-sm btn-primary">Download Admission Report</button>
                         </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Column selectors with Export Options and print table -->

<script>  
$(document).ready(function(){  
    $('#create_excel_feedng').click(function(){ 
      var fromDate  = $('#fromDate').val(); 
      var date      = new Date(fromDate),
          yr        = date.getFullYear(),
          month     = date.getMonth(),
          day       = date.getDate(),
          newDate   = yr + '-' + month + '-' + day; 
      var toDate    = $('#toDate').val();
      var date1     = new Date(toDate),
          yr1       = date1.getFullYear(),
          month1    = date1.getMonth(),
          day1      = date1.getDate(),
          newDate1  = yr1 + '-' + month1 + '-' + day1; 
      var lounge    = $('#lounge').val();
      var s_url     = '<?php echo base_url('Admin/generateReportExcel/'); ?>'+newDate+'/'+newDate1+'/'+lounge; 
      window.location.href = s_url;
   });

  $('#create_excel_sts').click(function(){ 
    var fromDate  = $('#fromDate').val(); 
    var date    = new Date(fromDate),
        yr      = date.getFullYear(),
        month   = date.getMonth(),
        day     = date.getDate(),
        newDate = yr + '-' + month + '-' + day; 
    var toDate    = $('#toDate').val();
    var date1    = new Date(toDate),
        yr1      = date1.getFullYear(),
        month1   = date1.getMonth(),
        day1    = date1.getDate(),
        newDate1 = yr1 + '-' + month1 + '-' + day1; 
    var lounge    = $('#lounge').val();
    var s_url     = '<?php echo base_url('Admin/generateReportExcelSTS/'); ?>'+newDate+'/'+newDate1+'/'+lounge; 
    window.location.href = s_url;
  });

  $('#create_excel_admission').click(function(){ 
    var fromDate  = $('#fromDate').val(); 
    var date    = new Date(fromDate),
        yr      = date.getFullYear(),
        month   = date.getMonth(),
        day     = date.getDate(),
        newDate = yr + '-' + month + '-' + day; 
    var toDate    = $('#toDate').val();
    var date1    = new Date(toDate),
        yr1      = date1.getFullYear(),
        month1   = date1.getMonth(),
        day1    = date1.getDate(),
        newDate1 = yr1 + '-' + month1 + '-' + day1; 
    var lounge    = $('#lounge').val();
    var s_url     = '<?php echo base_url('Admin/generateReportExcelAdmission/'); ?>'+newDate+'/'+newDate1+'/'+lounge; 
    window.location.href = s_url;
  });

});   
</script>  