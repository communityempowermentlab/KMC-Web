

   
    <!-- BEGIN: Content-->
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        
      <div class="content-body">




<!-- Input Validation start -->
<section class="input-validation">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="col-12">
            <h5 class="content-header-title float-left pr-1 mb-0">SMS Template</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                
                <li class="breadcrumb-item active">SMS Template
                </li>
              </ol>
            </div>
          </div>
          <div class="col-6 pull-right">
                        <p>Resources [<a href="javascript:void(0)" onclick="facilityDfd('<?php echo base_url(); ?>assets/dfdAndFunctionalDiagram/smsERDiagram.png', 'SMS Template Data Flow Diagram (DFD)')">Data Flow Diagram</a>]</p>
                    </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" novalidate action="<?php echo site_url('staffM/SmsSettingData/');?>">
              <div id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
              <div class="col-12">
                <h5 class="float-left pr-1">This Template is used for sending staff login credentials:</h5>
              </div>
              
              <div class="row col-12">
                  <div class="col-md-12">
                    <div class="form-group">
                      
                      <div class="controls">
                        <textarea class="form-control" name="smsFormatThird" required="" data-validation-required-message="This field is required" rows="7"><?php echo $Settings['smsFormatThird']; ?></textarea>
                      </div>
                    </div>
                  </div>
                  
              </div>
              
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Input Validation end -->
        </div>
      </div>
    </div>
    <!-- END: Content-->


    