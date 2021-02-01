 
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
            <h5 class="content-header-title float-left pr-1 mb-0">Add Counselling Poster</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>counsellingM/manageCounsellingPoster">Counselling Poster</a>
                </li>
                <li class="breadcrumb-item active">Add Counselling Poster
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" novalidate action="<?php echo site_url('counsellingM/AddCounsellingPosterData/');?>" enctype="multipart/form-data">

              <div class="col-12">
                <h5 class="float-left pr-1">Poster Information</h5>
              </div>
              
              <div class="row col-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Poster Type <span class="red">*</span></label>
                      <div class="controls">
                        <select class="select2 form-control" name="posterType" id="posterType" required="" data-validation-required-message="This field is required">
                          <option value="">Select Poster Type</option>
                          <option value="1">What is KMC?</option>
                          <option value="2">KMC Position</option>
                          <option value="3">KMC Nutrition</option>
                          <option value="4">KMC Hygiene</option>
                          <option value="5">KMC Monitoring</option>
                          <option value="6">KMC Respect</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Poster Title <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="form-control" name="VideoTitle" id="VideoTitle" placeholder="Poster Title" required="" data-validation-required-message="This field is required">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Upload Image </label>
                      <div class="controls">
                        <input type="file" class="form-control" name="image" id="image" required="" data-validation-required-message="This field is required">
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


    