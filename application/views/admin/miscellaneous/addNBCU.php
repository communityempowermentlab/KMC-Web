 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?php echo 'Add Newborn Care Unit';  ?></h1>
        <ol class="breadcrumb"> 
            <li><a href="<?php echo base_url() ?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>

            <li class=""><a href="<?php echo base_url(); ?>facility/facilityType/">Manage NBCU</a></li>
            <li class="active">Add NBCU</li>   
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">

                  <!-- 3 column form desig done by neha -->
            
                    <form class="form-horizontal" name='Lounge'  action="<?php echo site_url('Miscellaneous/addNBCU/');?>" method="POST" enctype="multipart/form-data" onsubmit="return checkValidation()">
                        <div class="box-body">
          <!--   Facility Information ++++++++++++++++++++++ -->
                            
                            <div class="col-sm-12 col-xs-12 form-group">
                              <div class="col-sm-4 col-xs-4">
                                <label for="inputEmail3" class="control-label"> NBCU Name<span style="color:red">  *</span> </label>
                                <input type="text" class="form-control"  name="nbcu_name" id="nbcu_name" placeholder="NBCU Name">
                                <span style="color: red; font-style: italic;" id="err_nbcu_name"></span>
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
      var nbcu_name = $('#nbcu_name').val();
      if(nbcu_name == ''){
        $('#err_nbcu_name').html('This field is required.').show();
        return false;
      } else {
        $('#err_nbcu_name').html('').hide();
      }
    }

</script>
