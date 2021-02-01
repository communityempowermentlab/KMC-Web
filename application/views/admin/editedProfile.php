 <script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Update Profile
       </h1>
     
      
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
      <div class="row">
        <div class="col-md-12">   
          <div class="box box-info">
            
           
            <form class="form-horizontal"  action="<?php echo site_url('admin/Dashboard/UpdateAdminProfile').'/'.$getData['id'];?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Name</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control"  name="name" id="name" placeholder="Name" value = "<?php  echo $getData['name']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Email</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control"  name="email" id="email" placeholder="Email" value = "<?php  echo $getData['email']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Password</label>

                  <div class="col-sm-10">
                    <input type="password" class="form-control"  name="password" id="password" placeholder="Password" value = "<?php  echo base64_decode($getData['password'])?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Contact Number</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control"  name="phone_no" id="phone_no" placeholder="Contact Number" value = "<?php  echo $getData['phone_no']?>">
                  </div>
                </div>
                 
                <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label">Profile Pic</label>
                  <div class="col-sm-10">
                    
                    <input type="file" id="exampleInputFile" name="uploadFile">
                     <?php if($getData['profile_pic']!=" ") {?><img src="<?php echo base_url()."assets/profile_image/".$getData['profile_pic']; ?>" style="width: 115px;"> <?php } ?>
                  </div>
                </div>
            
              <div class="box-footer">
                
                <button type="submit" class="btn btn-info pull-right">Submit</button>
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