 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'Update Facility Type';  ?></h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            
            <form class="form-horizontal" name='Lounge'  action="<?php echo site_url('facility/UpdateFacilitiesTypePost'); ?>/<?php echo $FacilitiesTypeData['FacilityTypeID']; ?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
          <!--   Facility Information ++++++++++++++++++++++ -->
                <br>
                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                    <label for="inputEmail3" class="control-label" > Facility Type Name<span style="color:red">  *</span> </label>
                    
                    <input type="text" class="form-control"  name="FacilityTypeName"  value="<?php echo $FacilitiesTypeData['FacilityTypeName']; ?>" placeholder="Facility Name" required>
                    <span style="color: red;"><?php echo form_error('facility_name');?></span>                 
                  </div>
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
  $(document).on("change","input[name=Banner_On]",function(){
  var BanneType = $('[name="Banner_On"]:checked').val();
  var Url = "<?php  echo base_url('admin/Dashboard/Get_SubCat_Product_list')?>/"+BanneType;
  /*alert(Url);*/
  $.ajax({
      type: "POST",
      url: Url,
             
      success: function(result){
        console.log(result)
      if(result!='')
        {
          $('#sub_product_list').html(result);
        } else
        {
          $('#sub_product_list').html('');
        }
       
      }
    });
});
</script>


  