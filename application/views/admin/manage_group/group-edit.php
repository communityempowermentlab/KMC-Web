

   
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
            <h5 class="content-header-title float-left pr-1 mb-0">Edit Menu Group</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Miscellaneous/viewMenuGroup">Menu Group</a>
                </li>
                <li class="breadcrumb-item active">Edit Menu Group
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" novalidate action="<?php echo site_url('Miscellaneous/editMenuGroup/'.$get_group['id']);?>">

              <div class="col-12 row">
                <h5 class="float-left pr-1">Group Permission Form</h5>
              </div>
              
              <div class="offset-sm-2 col-sm-10">
                  <div class="form-group row">
                    <div class="col-md-3">
                      <label>Group Name <span class="red">*</span></label>
                    </div>
                    <div class="col-md-9">
                      <div class="controls">
                        <input type="text" class="form-control" name="name" id="group_name" placeholder="NBCU Name" required="" data-validation-required-message="This field is required" value="<?= $get_group['groupName']; ?>">
                      </div>
                    </div>
                  </div>
              </div>

              <div class="offset-sm-2 col-sm-10">
                  <div class="form-group row">
                    <div class="col-md-3">
                      <label>Status <span class="red">*</span></label>
                    </div>
                    <div class="col-md-9">
                      <div class="controls">
                        <select class="select2 form-control" id="status" name="status" required="" data-validation-required-message="This field is required">
                          <option value="">Select Status</option>
                          <option value="1" <?php if($get_group['status'] == 1) { echo 'selected'; } ?>>Active</option>
                          <option value="2" <?php if($get_group['status'] == 2) { echo 'selected'; } ?>>Deactive</option>
                        </select>
                      </div>
                    </div>
                  </div>
              </div>


              <div class="offset-sm-2 col-sm-10">
                  <div class="form-group row">
                    <div class="col-md-3">
                      <label>Select Group Permission Settings <span class="red">*</span></label>
                    </div>
                    <div class="col-md-9">
                      <div class="col-12 mb-1">
                        <label for="exampleInputEmail1">Heading Name</label>
                      </div>
                      <?php $i = 1; foreach ($get_menu_list as $key => $value) { 
                                            if($value['type'] == 'heading') {
                                            ?>


                                            <div class="col-sm-12 panel mg mb-1">
                                                <div class="col-sm-4 pl-0">
                                                  <fieldset>
                                                    <div class="checkbox">
                                                      <input type="checkbox" class="checkbox-input set_heads" name="view_head[]" id="view_head_<?= $value['id']; ?>" value="<?php echo $value['id']; ?>" data-id="<?= $value['id']; ?>" title="Permission" onclick="getMenuChildEdit(<?php echo $value['id']; ?>, '<?php echo base_url('Miscellaneous/getMenuChild');?>');">
                                                      <input type="hidden" name="head_id[]" id="head_id_<?= $i; ?>" value="<?= $value['id']; ?>-off" data-id="<?= $i; ?>"  class="id_heads">
                                                      <label for="view_head_<?= $value['id']; ?>"><?= $value['levelName']; ?></label>
                                                    </div>
                                                  </fieldset>
                                                    
                                                </div>
                                                
                                            </div>

                                            <div style="margin-left:20px;">
                                                <div class="hide" id="child_div_<?php echo $value['id']; ?>"></div>
                                            </div>
                                                
                                            <?php $i++; } else { ?>

                                                <div class="col-sm-12 divPadding panel mg">
                                                    <div class="col-sm-4">
                                                        <div class="col-sm-1 divPadding">
                                                            <input type="checkbox" name="view_head[]" id="view_head_<?= $value['id']; ?>" value="<?php echo $value['id']; ?>" data-id="<?= $value['id']; ?>" title="Permission" class="set_heads" data-value="<?= $value['id']; ?>" onclick="getMenuChildEdit(<?php echo $value['id']; ?>, '<?php echo base_url('Miscellaneous/getMenuChild');?>');">
                                                            <input type="hidden" name="head_id[]" id="head_id_<?= $i; ?>" value="<?= $value['id']; ?>-off" data-id="<?= $i; ?>"  class="id_heads">
                                                        </div>
                                                        <div class="col-sm-11 divPadding">
                                                            <label for="exampleInputEmail1"><?= $value['levelName']; ?></label>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div style="margin-left:20px;">
                                                    <div class="hide" id="child_div_<?php echo $value['id']; ?>"></div>
                                                </div>

                                            <?php } } ?>

                                            <input type="hidden" name="check_menu_permission" id="check_menu_permission" value="<?php echo $menu_permission_string ?>">

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
    
    function getMenuChild(id, selectMenu, status)
    {   
        var selectMenu = $('#check_menu_permission').val();
        if($("#view_head_"+id).prop('checked') == true)
        { 
            $.ajax({
                url:'<?php echo base_url('Miscellaneous/getMenuChild');?>',
                type:'post',
                data:{ id:id,checked_menu:selectMenu },
                success:function(output){
                    if(output!="")
                    {
                        $('#child_div_'+id).removeClass('hide');
                        $('#child_div_'+id).html(output);
                        

                    }
                    else
                    {
                        $('#child_div_'+id).addClass('hide');
                        $('#child_div_'+id).html('');
                       
                    }
                }
            });
        }
        
    }

</script>


<?php
foreach($menu_permission_array as $menu_permission_array_list)
{ 
?>
<script type="text/javascript">
    $(document).ready(function(){
      var selectMenu = '<?php echo $menu_permission_string ?>'; 
        var id = '<?php echo $menu_permission_array_list; ?>';        
        $('#view_head_'+id).attr('checked', true);
        getMenuChild(id, 'true'); 
    });
</script>
    
<?php } ?>
    
   