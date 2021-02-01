 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'Edit Newborn Care Unit';  ?></h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            
            <form class="form-horizontal" name='Lounge'  action="<?php echo site_url('Miscellaneous/editNBCU'); ?>/<?php echo $GetNBCUData['id']; ?>" method="POST" enctype="multipart/form-data" onsubmit="return checkValidation()">
              <div class="box-body">
          <!--   Facility Information ++++++++++++++++++++++ -->
                
                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                    <label for="inputEmail3" class="control-label" > NBCU Name<span style="color:red">  *</span> </label>
                      
                    <input type="text" class="form-control"  name="nbcu_name" id="nbcu_name"  value="<?php echo $GetNBCUData['name']; ?>" placeholder="NBCU Name">
                    <span style="color: red; font-style: italic;" id="err_nbcu_name"></span>
                    <span style="color: red;"><?php echo form_error('nbcu_name');?></span>                 
                      
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Status
                     <span style="color:red">  *</span>
                    </label>
                    <select class="form-control" name="status" id="status">
                      <option value="">Select Status</option>
                      <option value="1" <?php if($GetNBCUData['status'] == 1) { echo 'selected'; } ?>>Active</option>
                      <option value="2" <?php if($GetNBCUData['status'] == 2) { echo 'selected'; } ?>>Deactive</option>
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
      var nbcu_name = $('#nbcu_name').val();
      if(nbcu_name == ''){
        $('#err_nbcu_name').html('This field is required.').show();
        return false;
      } else {
        $('#err_nbcu_name').html('').hide();
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


  