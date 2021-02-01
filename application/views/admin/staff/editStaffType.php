 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?php echo 'Edit Staff Type';  ?></h1>
        <ol class="breadcrumb"> 
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

            <li class=""><a href="<?php echo base_url(); ?>staffM/staffType/">Staff Type</a></li>
            <li class="active">Edit Staff Type</li>   
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">

                  <!-- 3 column form desig done by neha -->
            
                    <form class="form-horizontal" name='Lounge'  action="<?php echo site_url('staffM/editStaffType/'.$StaffType['staffTypeId']);?>" method="POST" enctype="multipart/form-data" onsubmit="return checkValidation()">
                        <div class="box-body">
          <!--   Facility Information ++++++++++++++++++++++ -->
                            
                            <div class="col-sm-12 col-xs-12 form-group">
                              <div class="col-sm-4 col-xs-4">
                                <label for="inputEmail3" class="control-label"> Staff Type Name<span style="color:red">  *</span> </label>
                                <input type="text" class="form-control"  name="staff_type_name" id="staff_type_name" placeholder="Staff Type Name" value="<?= $StaffType['staffTypeNameEnglish'] ?>">
                                <span style="color: red; font-style: italic;" id="err_staff_type_name"><?php echo form_error('staff_type_name');?></span>
                              </div>

                            <?php  if($StaffType['parentId'] != '0') { ?>

                              <div class="col-sm-4 col-xs-4">
                                <label for="inputEmail3" class="control-label"> Parent Staff Type<span style="color:red">  *</span>  </label>
                                <select class="form-control" name="parent_staff_type" id="parent_staff_type" aria-required="true">
                                  
                                  <?php $GetStaffType=$this->load->FacilityModel->GetNoParentStaffType();

                                   foreach ($GetStaffType as $key => $value) { ?>
                                 <option value="<?php echo $value['staffTypeId'] ?>" <?php if($value['staffTypeId'] == $StaffType['parentId']) { echo 'selected'; } ?>><?php echo $value['staffTypeNameEnglish'] ?></option>
                                <?php } ?>
                                </select>
                                <span style="color: red; font-style: italic;" id="err_parent_staff_type"></span>
                              </div>

                           <?php } else { ?>
                                <input type="hidden" value="0" name="parent_staff_type">
                           <?php } ?>

                            <div class="col-sm-4 col-xs-4">
                                <label for="inputPassword3" class="control-label">Status
                                 <span style="color:red">  *</span>
                                </label>
                                <select class="form-control" name="status" id="status">
                                  <option value="">Select Status</option>
                                  <option value="1" <?php if($StaffType['status'] == 1) { echo 'selected'; } ?>>Active</option>
                                  <option value="2" <?php if($StaffType['status'] == 2) { echo 'selected'; } ?>>Deactive</option>
                                </select>
                                <span style="color: red; font-style: italic;" id="err_status"></span>
                            </div>

                            </div>
                
                        </div>
  
                <div class="box-footer">               
                  <button type="submit" class="btn btn-info pull-left" style="margin-left: 15px;">Submit</button>
                </div>
            
            </form>
          </div>
         </div>
      </div>
    </section>
</div>

<script type="text/javascript">
    
     // validation code added by neha

    function checkValidation(){
      var staff_type_name = $('#staff_type_name').val();
      if(staff_type_name == ''){
        $('#err_staff_type_name').html('This field is required.').show();
        return false;
      } else {
        $('#err_staff_type_name').html('').hide();
      }

      var status = $('#status').val();
      if(status == ''){
        $('#err_status').html('This field is required.').show();
        return false;
      } else {
        $('#err_status').html('').hide();
      }

      
    }

</script>
