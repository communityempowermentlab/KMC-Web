

   
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
            <h5 class="content-header-title float-left pr-1 mb-0">Memory Detail</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>facility/facilityType/">Memory Detail</a>
                </li>
                <li class="breadcrumb-item active">Memory Detail
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" novalidate action="">

              <div class="col-12">
                <h5 class="float-left pr-1">Nurse & Doctor profile media data detail </h5>
              </div>
              <?php 
              $Nursepath = 'assets/nurse/';
              $Nursesize = $contro->getFolderSize($Nursepath);
              $Nursefile = $contro->countFiles($Nursepath);
              ?>
              <div class="row col-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Total Photo</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="facility_type_name" id="facility_type_name" placeholder="Facility Type Name" readonly="" value="<?php echo $Nursefile; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Total Size</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="facility_type_name" id="facility_type_name" placeholder="Facility Type Name" readonly="" value="<?php echo $contro->getFormattedSize($Nursesize); ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Path URL</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="facility_type_name" id="facility_type_name" placeholder="Facility Type Name" readonly="" value="<?php echo base_url($Nursepath); ?>">
                      </div>
                    </div>
                  </div>
              </div>
            </form>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" novalidate action="">

              <div class="col-12">
                <h5 class="float-left pr-1">Chcekin - Checkout & Signature (mother & baby Discharge) media data detail </h5>
              </div>
              <?php 
              $Chcekinpath = 'assets/images/sign/';
              $Chcekinsize = $contro->getFolderSize($Chcekinpath);
              $Chcekinfile = $contro->countFiles($Chcekinpath);
              ?>
              <div class="row col-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Total Photo</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="facility_type_name" id="facility_type_name" placeholder="Facility Type Name" readonly="" value="<?php echo $Chcekinfile; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Total Size</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="facility_type_name" id="facility_type_name" placeholder="Facility Type Name" readonly="" value="<?php echo $contro->getFormattedSize($Chcekinsize); ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Path URL</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="facility_type_name" id="facility_type_name" placeholder="Facility Type Name" readonly="" value="<?php echo base_url($Chcekinpath); ?>">
                      </div>
                    </div>
                  </div>
              </div>
            </form>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" novalidate action="">

              <div class="col-12">
                <h5 class="float-left pr-1">Mother media information included (Mother Images & Mother discharge concent form) </h5>
              </div>
              <?php 
              $Motherpath = 'assets/images/motherImages/';
              $Mothersize = $contro->getFolderSize($Motherpath);
              $Motherfile = $contro->countFiles($Motherpath);
              ?>
              <div class="row col-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Total Photo</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="facility_type_name" id="facility_type_name" placeholder="Facility Type Name" readonly="" value="<?php echo $Motherfile; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Total Size</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="facility_type_name" id="facility_type_name" placeholder="Facility Type Name" readonly="" value="<?php echo $contro->getFormattedSize($Mothersize); ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Path URL</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="facility_type_name" id="facility_type_name" placeholder="Facility Type Name" readonly="" value="<?php echo base_url($Motherpath); ?>">
                      </div>
                    </div>
                  </div>
              </div>
            </form>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" novalidate action="">

              <div class="col-12">
                <h5 class="float-left pr-1">Baby media information included (Baby Images, baby weight & baby discharge concent form) </h5>
              </div>
              <?php 
              $Babypath = 'assets/images/babyImages/';
              $Babysize = $contro->getFolderSize($Babypath);
              $Babyfile = $contro->countFiles($Babypath);
              ?>
              <div class="row col-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Total Photo</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="facility_type_name" id="facility_type_name" placeholder="Facility Type Name" readonly="" value="<?php echo $Babyfile; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Total Size</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="facility_type_name" id="facility_type_name" placeholder="Facility Type Name" readonly="" value="<?php echo $contro->getFormattedSize($Babysize); ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Path URL</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="facility_type_name" id="facility_type_name" placeholder="Facility Type Name" readonly="" value="<?php echo base_url($Babypath); ?>">
                      </div>
                    </div>
                  </div>
              </div>
            </form>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" novalidate action="">

              <div class="col-12">
                <h5 class="float-left pr-1">Lounge media data detail </h5>
              </div>
              <?php 
              $Loungepath = 'assets/images/lounge/';
              $Loungesize = $contro->getFolderSize($Loungepath);
              $Loungefile = $contro->countFiles($Loungepath);
              ?>
              <div class="row col-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Total Photo</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="facility_type_name" id="facility_type_name" placeholder="Facility Type Name" readonly="" value="<?php echo $Loungefile; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Total Size</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="facility_type_name" id="facility_type_name" placeholder="Facility Type Name" readonly="" value="<?php echo $contro->getFormattedSize($Loungesize); ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Path URL</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="facility_type_name" id="facility_type_name" placeholder="Facility Type Name" readonly="" value="<?php echo base_url($Loungepath); ?>">
                      </div>
                    </div>
                  </div>
              </div>
            </form>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" novalidate action="">

              <div class="col-12">
                <h5 class="float-left pr-1">Total Media Information </h5>
              </div>
              <?php 
              $Totalsize = $Nursesize + $Chcekinsize + $Mothersize + $Babysize +$Loungesize;
              $Totalfile = $Nursefile +$Chcekinfile + $Motherfile + $Babyfile + $Loungefile;
              ?>
              <div class="row col-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Total Photo</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="facility_type_name" id="facility_type_name" placeholder="Facility Type Name" readonly="" value="<?php echo $Totalfile; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Total Size</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="facility_type_name" id="facility_type_name" placeholder="Facility Type Name" readonly="" value="<?php echo $contro->getFormattedSize($Totalsize); ?>">
                      </div>
                    </div>
                  </div>
                  
              </div>
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


    