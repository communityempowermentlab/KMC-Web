 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Update Users</h1>
     
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
       
      
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            
            <form class="form-horizontal"  action="<?php echo site_url('admin/Users/UpdateUserData').'/'.$getData['User_id'];?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
            <!--   <div class="col-md-12" style="text-align: center; background-color: #eee  ">

              <h3 style="padding-bottom: 25px;">Users Informations</h3>
              </div> -->
               <?php /*
                   <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label"> Full Name <span style="color: red">*</span></label>
                  <div class="col-sm-10">
                    
                    <input type="text" class="form-control" name="UsersName" required placeholder="Full Name" value="<?php echo $getData['name'] ?>">
                  </div>

                </div>
               */?>
                  
                <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label"> Username <span style="color: red">*</span></label>
                  <div class="col-sm-10">
                    
                    <input type="text" class="form-control" name="UserName" required placeholder="Username" value="<?php echo $getData['username'] ?>">
                  </div>
                </div>

                 <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label"> Email-Id <span style="color: red">*</span></label>
                  <div class="col-sm-6">
                    <input type="email" class="form-control" name="UsersEmail" required placeholder="Email" value="<?php echo $getData['email_id'] ?>">
                  </div>
                    
                <!-- </div>
                <div class="form-group"> -->
              <!--   <label for="inputEmail3" class="col-sm-2 control-label"> Contact No. <span style="color: red">*</span></label> -->
                  <!-- <div class="col-sm-4">
 -->
                  <div class="col-sm-4" >
                  <a href="javascript:ResetPass(<?php echo $getData['User_id'] ?>)" class="btn btn-info" style="float: center; padding-right: 10px; ">Resend Password </a>
                  <span id="phone_check" style="color:green"></span>
                  </div>
                  
                </div>



                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label"> Gender <span style="color: red">*</span></label>
                      <div class="col-sm-2">
                        <select class="form-control" name="gender">
                          <option value="">Select Gender</option>
                          <option value="1" <?php echo ($getData['gender'] == '1') ? 'Selected' :'' ?>>Male</option>
                          <option value="2" <?php echo ($getData['gender'] == '2') ? 'Selected' :'' ?>>Female</option>
                        </select>
                      </div>

                     <label for="inputEmail3" class="col-sm-2 control-label"> DOB<span style="color: red">*</span></label> 
                      <div class="col-sm-2">
                        <div class="input-group date ">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control " id="datepicker" name="Dob"  value="<?php echo ($getData['dob']!='') ? date('d-m-Y',$getData['dob']): '' ?>">
                        </div>
                      </div>
                       <label for="inputEmail3" class="col-sm-2 control-label"> Contact no<span style="color: red">*</span></label> 
                      <div class="col-sm-2">
                       <input type="text" class="form-control" name="UsersCntct" onchange="ContactnumberCheck(this.value)" required placeholder="Contact Number" value="<?php echo $getData['phone_no'] ?>">
                           <!--  <span id="phone_check" style="color:red"></span> -->
                      </div>
                 </div>
                   <div class="form-group">
                     <label for="inputEmail3" class="col-sm-2 control-label">Upload Pic</label>
                    <div class="col-sm-4">
                      
                      <input type="file" class="form-control" name="uploadFileUsers" >
                      
                    
                    <?php  if($getData['profile_pic']!=''){ ?>
                     
                      <img src="<?php echo base_url()."assets/profile_image/".$getData['profile_pic']; ?>"  style=" margin-left:35px; width: 115px;">

                      <?php } ?>
                      </div>
                  </div>
             


               <?php /*
                   <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Home Address<span style="color: red">*</span></label>
                  <div class="col-sm-10">
                    <textarea class="form-control" name="address1" rows="4" required placeholder="Company Address"> <?php echo $getData['home_address'] ?></textarea>
                  </div>
                </div>

                <hr>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Company Name<span style="color: red">*</span></label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="CompanyName" required placeholder="Company Name" value="<?php echo $getData['company_name'] ?>">
                  </div>
                </div>

                 <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Phone No.<span style="color: red">*</span></label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="CompanyPhone" required placeholder="Company Phone Number" value="<?php echo $getData['company_phone_no'] ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Company Address<span style="color: red">*</span></label>
                  <div class="col-sm-10">
                    <textarea class="form-control" name="address2" rows="4" required placeholder="Company Address"><?php echo $getData['company_phone_no'] ?>
                    </textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Company Pan No.<span style="color: red">*</span></label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="CompanyPan" required placeholder="CompanyPan" value="<?php echo $getData['company_pan_no'] ?>">
                  </div>


                  <label for="inputEmail3" class="col-sm-2 control-label">Company  TIN No.<span style="color: red">*</span></label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="CompanyTin" required placeholder="Company TIN No." value="<?php echo $getData['company_tin_no'] ?>">
                  </div>
                </div>
                <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label">Upload Pic</label>
                  <div class="col-sm-4">
                    
                    <input type="file" class="form-control" name="uploadFileUsers" >
                    
                  
                  <?php  if($getData['profile_pic']!=''){ ?>
                   
                    <img src="<?php echo base_url()."assets/profile_image/".$getData['profile_pic']; ?>"  style=" margin-left:35px; width: 115px;">

                    <?php } ?>
                    </div>
                </div>

               */ ?>
             

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

  <script type="text/javascript">
     function ResetPass(id) {
   
    var Url = "<?php  echo base_url('admin/Users/ResetPass')?>/"+id;
    var r =  confirm("Are you sure! You want to Resend User Password ?");
       if (r == true) {
          $.ajax({
            type: "POST",
            url: Url,
                   
            success: function(result){
              console.log(result)
            if(result==1)
              {
                $('#phone_check').html("Password Sent Successfully");
              }else{
                $('#phone_check').html("");
              } 
                    
            }
          });
        }
            
      }


  </script>


  