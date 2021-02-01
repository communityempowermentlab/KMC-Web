  
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
            <h5 class="content-header-title float-left pr-1 mb-0">Edit Counselling Poster</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>counsellingM/manageCounsellingPoster">Counselling Poster</a>
                </li>
                <li class="breadcrumb-item active">Edit Counselling Poster
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" novalidate action="<?php echo site_url();?>counsellingM/UpdateCounsellingPosterData/<?php echo $this->uri->segment(3);?>" enctype="multipart/form-data">

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
                          <option value="1" <?php if($VideoData['posterType'] == 1){ echo "selected"; } ?>>What is KMC?</option>
                          <option value="2" <?php if($VideoData['posterType'] == 2){ echo "selected"; } ?>>KMC Position</option>
                          <option value="3" <?php if($VideoData['posterType'] == 3){ echo "selected"; } ?>>KMC Nutrition</option>
                          <option value="4" <?php if($VideoData['posterType'] == 4){ echo "selected"; } ?>>KMC Hygiene</option>
                          <option value="5" <?php if($VideoData['posterType'] == 5){ echo "selected"; } ?>>KMC Monitoring</option>
                          <option value="6" <?php if($VideoData['posterType'] == 6){ echo "selected"; } ?>>KMC Respect</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Poster Title <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="form-control" name="VideoTitle" id="VideoTitle" placeholder="Poster Title" required="" data-validation-required-message="This field is required" value="<?php echo $VideoData['videoTitle'];?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Status <span class="red">*</span></label>
                      <div class="controls">
                        <select class="select2 form-control" name="status" id="status" required="" data-validation-required-message="This field is required">
                          <option value="">Select Status</option>
                          <option value="1" <?php if($VideoData['status'] == 1) { echo 'selected'; } ?>>Active</option>
                          <option value="2" <?php if($VideoData['status'] == 2) { echo 'selected'; } ?>>Deactive</option>
                        </select>
                      </div>
                    </div>
                  </div>
              </div>


              <div class="row col-12">
                <div class="col-md-4">
                    <div class="form-group">
                      <label>Upload Image </label>
                      <div class="controls">
                        <input type="file" class="form-control" name="image" id="image">
                        <input type="hidden"  class="form-control" name="imageOld" value="<?php echo $VideoData['videoName'];?>"><br/>
                        <span>
                          <img src="<?php echo base_url();?>assets/images/video/<?=$VideoData['videoName'];?>" style="width:100%;height: 100%;">
                        </span>
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


    