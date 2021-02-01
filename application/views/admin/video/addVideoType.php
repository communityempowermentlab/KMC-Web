 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       <?php echo 'Add Video Type';  ?>
       
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
            
            <form class="form-horizontal" name='Lounge'  action="<?php echo site_url('videoM/addVideoType/');?>" method="POST" enctype="multipart/form-data" onsubmit="return checkValidation()">
              <div class="box-body">

                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Video Type Name
                     <span style="color:red">  *</span></label>
                     <input type="text" class="form-control" name="video_type" id="video_type" placeholder="Video Type Name">
                     <span style="color: red; font-style: italic;" id="err_video_type"></span>
                  </div>
                </div>
                 
            </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-sm-12 col-xs-12 form-group">
                  <button type="submit" class="btn btn-info pull-left" style="margin-left: 15px;">Submit</button>
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

 

<script type="text/javascript">
    
     // validation code added by neha

    function checkValidation(){
      var video_type = $('#video_type').val();
      if(video_type == ''){
        $('#err_video_type').html('This field is required.').show();
        return false;
      } else {
        $('#err_video_type').html('').hide();
      }

      
    }

</script>