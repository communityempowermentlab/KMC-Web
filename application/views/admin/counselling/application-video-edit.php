  
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
            <h5 class="content-header-title float-left pr-1 mb-0">Edit Application Training Videos</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>counsellingM/manageApplicationVideos">Application Training Videos</a>
                </li>
                <li class="breadcrumb-item active">Edit Application Training Videos
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" novalidate action="<?php echo site_url();?>counsellingM/UpdateApplicationVideoData/<?php echo $this->uri->segment(3);?>" enctype="multipart/form-data">

              <div class="col-12">
                <h5 class="float-left pr-1">Video Information</h5>
              </div>
              
              <div class="row col-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Video Title <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="form-control" name="VideoTitle" id="VideoTitle" placeholder="Video Title" required="" data-validation-required-message="This field is required" value="<?php echo $VideoData['videoTitle'];?>">
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
                      <label>Upload Video </label>
                      <div class="controls">
                        <input type="file" class="form-control" name="image" id="image">
                        <input type="hidden"  class="form-control" name="imageOld" value="<?php echo $VideoData['videoName'];?>"><br/>
                        <span>
                          <video id="video1" class="video-js vjs-default-skin" width="340" height="220" 
                          data-setup='{"controls" : true, "autoplay" : false, "preload" : "auto"}'>
                            <source src="<?php echo base_url();?>assets/images/video/<?=$VideoData['videoName'];?>" type='video/mp4'>
                          </video>
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


    