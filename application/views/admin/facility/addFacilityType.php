 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?php echo 'Add Facility Type';  ?></h1>
        <ol class="breadcrumb"> 
            <li><a href="<?php echo base_url() ?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>

            <li class=""><a href="<?php echo base_url(); ?>facility/facilityType/">Facility Type</a></li>
            <li class="active">Add Facility Type</li>   
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">

                  <!-- 3 column form desig done by neha -->
            
                    <form class="form-horizontal" name='Lounge'  action="<?php echo site_url('facility/addFacilityType/');?>" method="POST" enctype="multipart/form-data" onsubmit="return checkValidation()">
                        <div class="box-body">
          <!--   Facility Information ++++++++++++++++++++++ -->
                            
                            <div class="col-sm-12 col-xs-12 form-group">
                              <div class="col-sm-4 col-xs-4">
                                <label for="inputEmail3" class="control-label"> Facility Type Name<span style="color:red">  *</span> </label>
                                <input type="hidden" name="status" value="1">
                                <input type="text" class="form-control"  name="facility_type_name" id="facility_type_name" placeholder="Facility Type Name">
                                <span style="color: red; font-style: italic;" id="err_facility_type_name"></span>
                              </div>

                              <div class="col-sm-4 col-xs-4">
                                <label for="inputEmail3" class="control-label"> Set Priority<span style="color:red">  *</span> </label>
                                <select class="form-control" name="priority" id="priority">
                                  <option value="">--Select Priority--</option>
                                  <option value="1">1</option>
                                  <option value="2">2</option>
                                  <option value="3">3</option>
                                  <option value="4">4</option>
                                  <option value="5">5</option>
                                </select>
                                <span style="color: red; font-style: italic;" id="err_priority"></span>
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
      var facility_type_name = $('#facility_type_name').val();
      if(facility_type_name == ''){
        $('#err_facility_type_name').html('This field is required.').show();
        return false;
      } else {
        $('#err_facility_type_name').html('').hide();
      }

      var priority = $('#priority').val();
      if(priority == ''){
        $('#err_priority').html('This field is required.').show();
        return false;
      } else {
        $('#err_priority').html('').hide();
      }
    }

</script>
