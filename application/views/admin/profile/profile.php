

   
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
            <h5 class="content-header-title float-left pr-1 mb-0">Update Profile</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white" style="max-width: max-content; float: left;">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>staffM/manageStaff/">Profile</a>
                </li>
                <li class="breadcrumb-item active">Edit Profile
                </li>
              </ol>
              <!-- <p style="float: right; color: black;"> <b>Verified Mobile</b> : <?php if(!empty($GetStaff['verifiedMobile'])) { echo $GetStaff['verifiedMobile']; } else { echo "N/A"; } ?></p> -->
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <div id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
            <form class="form-horizontal" method="post" novalidate action="<?php echo site_url();?>ProfileM/UpdateProfilePost/<?php echo $GetStaff['id'];?>" enctype="multipart/form-data">

              <div class="col-12">
                <h5 class="float-left pr-1">Admin Information</h5>
              </div>
              
              <div class="row col-12">
                  
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Name <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="form-control" data-validation-required-message="This field is required" name="Name" id="name" placeholder="Name" value="<?php echo $GetStaff['name'];?>">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Email <span class="red">*</span></label>
                      <div class="controls">
                        <input type="email" class="form-control" data-validation-required-message="This field is required" name="email" id="email" placeholder="Email" value="<?php echo $GetStaff['email'];?>">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Password </label>
                      <div class="controls">
                        <input type="password" class="form-control"  name="password" id="password" placeholder="*****" value="">
                      </div>
                    </div>
                  </div>
                  
              </div>




              <div class="row col-12">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Staff Photo </label>
                    <div class="controls">
                      <input type="hidden" name="prevFile" value="<?php echo $GetStaff['profileImage']; ?>">
                      <input type="file" class="form-control" name="image" id="fileupload" >
                      <div id="dvPreview">
                        <?php if(!empty($GetStaff['profileImage'])) { ?>
                          <img src="<?php echo base_url(); ?>assets/admin/<?php echo $GetStaff['profileImage']; ?>">
                        <?php } ?>
                      </div>
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

<script type="text/javascript">
  function openOtherStaffSubType(str){ 

    var selected_value = $('option:selected', str).attr('typevalue');
    if((selected_value == 'other') || (selected_value == 'others')){
      $('#staff_sub_type_other_div').show();
      $('#job_type_div1').hide();
      $('#job_type_div2').show();
      $('#staff_sub_type_val').val('Other');
    }else{
      $('#staff_sub_type_other_div').hide();
      $('#job_type_div1').show();
      $('#job_type_div2').hide();
      $('#staff_sub_type_val').val('');
    }
  }
</script>


    