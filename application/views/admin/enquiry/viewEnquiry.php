 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'Edit Enquiry';  ?></h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            
            <form class="form-horizontal" name='Lounge'  action="<?php echo site_url('enquiryM/takeAction'); ?>/<?php echo $GetData['id']; ?>" method="POST" enctype="multipart/form-data" onsubmit="return checkValidation()">
              <div class="box-body">
          <!--   Enquiry Information ++++++++++++++++++++++ -->
                
                <div class="col-sm-12 col-xs-12 form-group">

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputEmail3" class="control-label"> Ticket ID<span style="color:red">  *</span> </label> 
                    <input type="text" class="form-control" value="<?php echo $GetData['id']; ?>" placeholder="NBCU Name" readonly>            
                  </div>


                  <div class="col-sm-4 col-xs-4">
                    <label for="inputEmail3" class="control-label"> Lounge<span style="color:red">  *</span> </label> 
                    <input type="text" class="form-control" value="<?php echo $loungeName; ?>" placeholder="NBCU Name" readonly>            
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputEmail3" class="control-label"> Location<span style="color:red">  *</span> </label>
                    <textarea class="form-control" readonly rows="3"><?php echo $GetData['location']; ?></textarea>              
                      
                  </div>

                </div>

                <div class="col-sm-12 col-xs-12 form-group">


                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Status
                     <span style="color:red">  *</span>
                    </label>
                    <select class="form-control" name="status" id="status">
                      <option value="">Select Status</option>
                      <option value="1" <?php if($GetData['status'] == 1) { echo 'selected'; } ?>>Pending</option>
                      <option value="2" <?php if($GetData['status'] == 2) { echo 'selected'; } ?>>Closed</option>
                      <option value="3" <?php if($GetData['status'] == 3) { echo 'selected'; } ?>>Cancelled</option>
                    </select>
                    <span style="color: red; font-style: italic;" id="err_status"></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputEmail3" class="control-label"> Remark<span style="color:red">  *</span> </label>
                    <textarea class="form-control" name="remark" id="remark" rows="3"><?php echo $GetData['remark']; ?></textarea>
                    <span style="color: red; font-style: italic;" id="err_remark"></span>             
                      
                  </div>

                </div>


              </div>

                <!-- Enquiry Information -->
          
              
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

      var status = $('#status').val();
      if(status == ''){
        $('#err_status').html('This field is required.').show();
        return false;
      } else {
        $('#err_status').html('').hide();
      }

      var remark = $('#remark').val();
      if(remark == ''){
        $('#err_remark').html('This field is required.').show();
        return false;
      } else {
        $('#err_remark').html('').hide();
      }
    }
</script>


  