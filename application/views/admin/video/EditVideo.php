<link href="<?=base_url('twd-theme/videojs/video-js.css');?>" rel="stylesheet">
<script src="<?=base_url('twd-theme/videojs/video.js');?>"></script>
<link rel="stylesheet" href="<?=base_url('twd-theme/style.css');?>">
<style type="text/css">
   #dvPreview img{
    width: 100%;
    height: 200px;
    border: 1px solid #a69494;
   }
 </style>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       <?php echo 'Edit Video';  ?>
       
      </h1>
     
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
       
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            
            <form class="form-horizontal" name='Lounge'  action="<?php echo site_url();?>videoM/UpdateVideoData/<?php echo $this->uri->segment(3);?>" method="POST" enctype="multipart/form-data" onsubmit="return checkValidation()">
              <div class="box-body">

                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Video Type
                     <span style="color:red">  *</span>
                    </label>
                    <select class="form-control" name="VideoType" id="VideoType">
                        <option value="">--Select Video Type--</option>
                      
                         <?php 
                        $videoType = $this->load->FacilityModel->GetVideoType();
                          foreach ($videoType as $key => $value) {?>
                              <option value ="<?php echo $value['id'];?>"<?php echo $VideoData['videoType'] == $value['id'] ? "selected" : ''; ?>><?php echo $value['videoTypeName'];?></option>
                         <?php  } ?>
                      </select>
                      <span style="color: red; font-style: italic;" id="err_VideoType"></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Video Title
                     <span style="color:red">  *</span>
                    </label>
                    <input type="text" class="form-control" value="<?php echo $VideoData['videoTitle'];?>"  name="VideoTitle" placeholder="Enter Video title" id="VideoTitle">
                    <span style="color: red; font-style: italic;" id="err_VideoTitle"></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Status
                     <span style="color:red">  *</span>
                    </label>
                    <select class="form-control" name="status" id="status">
                      <option value="">Select Status</option>
                      <option value="1" <?php if($VideoData['status'] == 1) { echo 'selected'; } ?>>Active</option>
                      <option value="2" <?php if($VideoData['status'] == 2) { echo 'selected'; } ?>>Deactive</option>
                    </select>
                    <span style="color: red; font-style: italic;" id="err_status"></span>
                  </div>

                </div>

                <div class="col-sm-12 col-xs-12 form-group">

                  <!-- <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Upload Thumbnail
                      <span style="color:red">  *</span>
                    </label>
                    <input type="file" id="fileupload" class="form-control" name="thumbnail" style="margin-bottom: 5px;">
                    <input type="hidden" id="fileupload1" name="thumbnailOld" value="<?php echo $VideoData['thumbnail']; ?>">
                    <div id="dvPreview" style="margin-top: 20px;">
                      <?php if(!empty($VideoData['thumbnail'])) { ?>
                        <img src="<?php echo base_url(); ?>assets/images/video/thumbnail/<?php echo $VideoData['thumbnail']; ?>">
                      <?php } ?>
                    </div>
                    <span style="color: red; font-style: italic;" id="err_fileupload"></span>
                  </div> -->

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Upload Video
                      <span style="color:red">  *</span>
                     </label>
                    <input type="file"  class="form-control" name="image" id="image">
                      <input type="hidden"  class="form-control" name="imageOld" value="<?php echo $VideoData['videoName'];?>"><br/>
                      <span>
                        <video id="video1" class="video-js vjs-default-skin" width="340" height="220" 
                        data-setup='{"controls" : true, "autoplay" : false, "preload" : "auto"}'>
                          <source src="<?php echo base_url();?>assets/images/video/<?=$VideoData['videoName'];?>" type='video/mp4'>
                        </video>
                      </span>
                      <span style="color: red; font-style: italic;" id="err_image"></span>
                  </div>

                </div>

               
                 
            </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                    <button type="submit" class="btn btn-info">Submit</button>
                  </div>
                </div>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
         
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

 
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script type="text/javascript">
    function checkValidation(){
      var VideoType = $('#VideoType').val(); 
      if(VideoType == ''){
        $('#err_VideoType').html('This field is required.').show();
        return false;
      } else {
        $('#err_VideoType').html('').hide();
      }

      var VideoTitle = $('#VideoTitle').val();
      if(VideoTitle == ''){
        $('#err_VideoTitle').html('This field is required.').show();
        return false;
      } else {
        $('#err_VideoTitle').html('').hide();
      }

      var status = $('#status').val();
      if(status == ''){
        $('#err_status').html('This field is required.').show();
        return false;
      } else {
        $('#err_status').html('').hide();
      }

      // var fileupload = $('#fileupload').val();
      // var fileupload1 = $('#fileupload1').val();
      // if(fileupload == '' && fileupload1 == ''){
      //   $('#err_fileupload').html('This field is required.').show();
      //   return false;
      // } else {
      //   $('#err_fileupload').html('').hide();
      // }

      var image1 = $('#image1').val();
      var image = $('#image').val();
      if(image1 == '' && image == ''){
        $('#err_image').html('This field is required.').show();
        return false;
      } else {
        $('#err_image').html('').hide();
      }
    }

    $(function () {
      $("#fileupload").change(function () {
          $('#err_fileupload').html('').hide();
          $("#dvPreview").html("");
          var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
          if (regex.test($(this).val().toLowerCase())) {
              if ($.browser.msie && parseFloat(jQuery.browser.version) <= 9.0) {
                  $("#dvPreview").show();
                  $("#dvPreview")[0].filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = $(this).val();
              }
              else {
                  if (typeof (FileReader) != "undefined") {
                      $("#dvPreview").show();
                      $("#dvPreview").append("<img />");
                      var reader = new FileReader();
                      reader.onload = function (e) {
                          $("#dvPreview img").attr("src", e.target.result);
                      }
                      reader.readAsDataURL($(this)[0].files[0]);
                  } else {
                      alert("This browser does not support FileReader.");
                  }
              }
          } else {
              alert("Please upload a valid image file.");
          }
      });
  });
  </script>
  