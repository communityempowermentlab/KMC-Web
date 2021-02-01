 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?php echo 'Add Management Type';  ?></h1>
        <ol class="breadcrumb"> 
            <li><a href="<?php echo base_url() ?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>

            <li class=""><a href="<?php echo base_url(); ?>facility/facilityType/">Manage Management Type</a></li>
            <li class="active">Add Management Type</li>   
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">

                  <!-- 3 column form desig done by neha -->
            
                    <form class="form-horizontal" name='Lounge'  action="<?php echo site_url('Miscellaneous/addManagementType/');?>" method="POST" enctype="multipart/form-data" onsubmit="return checkValidation()">
                        <div class="box-body">
          <!--   Facility Information ++++++++++++++++++++++ -->
                            
                            <div class="col-sm-12 col-xs-12 form-group">
                              <div class="col-sm-4 col-xs-4">
                                <label for="inputEmail3" class="control-label"> Management Type Name<span style="color:red">  *</span> </label>
                                <input type="text" class="form-control"  name="managemnet_type_name" id="managemnet_type_name" placeholder="Management Type Name">
                                <span style="color: red; font-style: italic;" id="err_managemnet_type_name"></span>
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
      var managemnet_type_name = $('#managemnet_type_name').val();
      if(managemnet_type_name == ''){
        $('#err_managemnet_type_name').html('This field is required.').show();
        return false;
      } else {
        $('#err_managemnet_type_name').html('').hide();
      }
    }

</script>
