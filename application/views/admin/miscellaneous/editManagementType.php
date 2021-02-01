 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'Edit Management Type';  ?></h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            
            <form class="form-horizontal" name='Lounge'  action="<?php echo site_url('Miscellaneous/editManagementType'); ?>/<?php echo $GetData['id']; ?>" method="POST" enctype="multipart/form-data" onsubmit="return checkValidation()">
              <div class="box-body">
          <!--   Facility Information ++++++++++++++++++++++ -->
                <br>
                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                    <label for="inputEmail3" class="control-label" style="text-align: center;"> Management Type Name<span style="color:red">  *</span> </label>
                      
                    <input type="text" class="form-control"  name="managemnet_type_name" id="managemnet_type_name"  value="<?php echo $GetData['name']; ?>" placeholder="Management Type Name">
                    <span style="color: red; font-style: italic;" id="err_managemnet_type_name"></span>
                    <span style="color: red;"><?php echo form_error('managemnet_type_name');?></span>   
                  </div>   

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Status
                     <span style="color:red">  *</span>
                    </label>
                    <select class="form-control" name="status" id="status">
                      <option value="">Select Status</option>
                      <option value="1" <?php if($GetData['status'] == 1) { echo 'selected'; } ?>>Active</option>
                      <option value="2" <?php if($GetData['status'] == 2) { echo 'selected'; } ?>>Deactive</option>
                    </select>
                    <span style="color: red; font-style: italic;" id="err_status"></span>
                  </div>           
                  
                </div>

              </div>

                <!-- FACILITY_MANGEMENT_TYPE -->
          
              
              <div class="box-footer">               
                <button type="submit" class="btn btn-info pull-right">Update</button>
              </div>
            </form>
          </div>
         </div>
      </div>
    </section>
  </div>

<script type="text/javascript">
   function checkValidation(){
      var managemnet_type_name = $('#managemnet_type_name').val();
      if(managemnet_type_name == ''){
        $('#err_managemnet_type_name').html('This field is required.').show();
        return false;
      } else {
        $('#err_managemnet_type_name').html('').hide();
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


  