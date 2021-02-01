<style type="text/css">
    #sections .box{ border-left: 1px solid #3c8dbc;border-right: 1px solid #3c8dbc;border-bottom: 1px solid #3c8dbc;
    }
    .form-control{
        height:0%;
    }
    .manage_divP, .divPadding{padding: 0px !important;}
    .box-body{padding: 10px 0px !important; background: #fff;}
    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn){width: 100% !important;}
    .btn{ border-radius: 0px !important;}
    .box-header.with-border{border: 0px solid !important;}
    .red{color: red;}


    .success_msg{               
        width: 280px;                
        min-height: 50px;               
        position: fixed;                 
        top: 50px;                
        right: 0px; 
        background: #4BB543;                   
        color: #fff;                   
        z-index: 1000000;                
        padding: 15px 5px;               
        border: 1px solid #fff;              
        border-radius: 15px;            
    }              
    .set_div_img2{
        text-align: right; cursor: pointer;
    }
    .select2-selection.select2-selection--multiple{
        border-radius: 0px !important;
        border-color: #ddd !important;
    }
    .hd {
        background: #5882fa;
        color:#fff;
    }
    .panel-menu {
        background: #58acfa;
        color:#fff;
    }
    .sbmn{
        background: #58d3f7;
        color:#fff;
    }
    .select2-selection__rendered{padding: 0 12px !important;}
    .set_new_padding{padding-left: 8px !important;}
    .flt_r{float: right;}
    .hide_measure, .common_base{display: none;}
    .set_bdr{border-bottom: 1px solid #f4f4f4; padding-top: 3px !important;}
    .panel { margin-bottom: 0px;!important
    }
     .mg {
        margin-top:20px;
     }
</style>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit Privileges of Menu Group </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('Miscellaneous/viewMenuGroup'); ?>"> Manage Menu Group </a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- small box -->
                <div class="box box-primary">
                <!-- form start -->
                    <div class="box-header with-border">
                      <h3 class="box-title">Group Permission Form</h3>
                      
                    </div>
                    <?php echo form_open_multipart('Miscellaneous/editMenuGroup/'.$get_group['id']); ?>
                        <div class="box-body col-xs-12 divPadding" style="border-bottom: 1px solid #f4f4f4;margin-bottom: 10px;">
                           <div class="error_validator">
                            <?php 
                                echo validation_errors(); 
                                if($this->session->flashdata('message'))
                                    echo $this->session->flashdata('message');
                            ?> 
                            </div>
                            <div class="col-xs-12 col-sm-12" id="error"></div>

                            <div class="col-xs-12 col-sm-12 divPadding">
                                 <!-- employee id -->
                                <div class="form-group col-sm-12 col-xs-12 manage_divP">
                                    <div  class="col-xs-3">
                                        <label for="exampleInputEmail1">Group Name <span class="red">*</span></label>
                                    </div>
                                    <div  class="col-xs-9">
                                        <?php echo form_input(
                                            array(
                                                    'name'              => 'name',
                                                    'class'             => 'form-control',
                                                    'placeholder'       => 'Name',
                                                    'value'             => $get_group['groupName'],
                                                    'type'              => 'text',
                                                    'id'                => 'group_name'
                                                )
                                            );
                                        ?>
                                        <span id="err_group_name" class="user_err"></span>
                                    </div>
                                </div> <!-- name / -->

                                <div class="form-group col-sm-12 col-xs-12 manage_divP">
                                    <div  class="col-xs-3">
                                        <label for="exampleInputEmail1">Status <span class="red">*</span></label>
                                    </div>
                                    <div  class="col-xs-9">

                                        <select id="status" name="status" data-live-search="true" data-live-search-style="startsWith" class="selectpicker form-control">                                            
                                            <option value="1" <?php
                                             if ($get_group['status'] == 1) {  echo "selected";  }
                                             else {
                                                echo ""; } ?>>Active</option>
                                                <option value="2" <?php
                                             if ($get_group['status'] == 2) {  echo "selected";  }
                                             else {
                                                echo ""; } ?>>Deactive</option>

                                        </select>
                                        
                                    </div>

                                </div> <!--  Status / -->

                                <!-- add assets -->
                                <div class="form-group col-sm-12 col-xs-12 manage_divP">
                                    <div  class="col-xs-3">
                                        <label for="exampleInputEmail1">Select Group Permission Settings <span class="red">*</span></label>
                                    </div>
                                    <div  class="col-xs-9 divPadding">

                                        <!-- this code use for UI -->
                                        <div class="col-xs-12 col-sm-12 divPadding set_bdr">
                                            <div class="col-xs-12 col-sm-4">
                                                <!-- <div class="col-xs-12 col-sm-1 divPadding"></div> -->
                                                <div class="col-xs-12 col-sm-12 divPadding">
                                                    <label for="exampleInputEmail1">Heading Name</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-8"></div>
                                        </div> <!-- this code use for UI / -->

                                        <!-- this code use for loop -->

                                        <?php $i = 1; foreach ($get_menu_list as $key => $value) { 
                                            if($value['type'] == 'heading') {
                                            ?>


                                            <div class="col-xs-12 col-sm-12 divPadding panel mg">
                                                <div class="col-xs-12 col-sm-4">
                                                    <div class="col-xs-12 col-sm-1 divPadding">
                                                        <input type="checkbox" name="view_head[]" id="view_head_<?= $value['id']; ?>" value="<?php echo $value['id']; ?>" data-id="<?= $value['id']; ?>" title="Permission" class="set_heads" data-value="<?= $value['id']; ?>" onclick="getMenuChild(<?php echo $value['id']; ?>);">
                                                        <input type="hidden" name="head_id[]" id="head_id_<?= $i; ?>" value="<?= $value['id']; ?>-off" data-id="<?= $i; ?>"  class="id_heads">
                                                    </div>
                                                    <div class="col-xs-12 col-sm-11 divPadding">
                                                        <label for="exampleInputEmail1"><?= $value['levelName']; ?></label>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div style="margin-left:20px;">
                                                <div class="hide" id="child_div_<?php echo $value['id']; ?>"></div>
                                            </div>
                                                
                                            <?php $i++; } else { ?>

                                                <div class="col-xs-12 col-sm-12 divPadding panel mg">
                                                    <div class="col-xs-12 col-sm-4">
                                                        <div class="col-xs-12 col-sm-1 divPadding">
                                                            <input type="checkbox" name="view_head[]" id="view_head_<?= $value['id']; ?>" value="<?php echo $value['id']; ?>" data-id="<?= $value['id']; ?>" title="Permission" class="set_heads" data-value="<?= $value['id']; ?>" onclick="getMenuChild(<?php echo $value['id']; ?>);">
                                                        <input type="hidden" name="head_id[]" id="head_id_<?= $i; ?>" value="<?= $value['id']; ?>-off" data-id="<?= $i; ?>"  class="id_heads">
                                                        </div>
                                                        <div class="col-xs-12 col-sm-11 divPadding">
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
                        </div>
                        <!-- add assets -->
                        <div class="box-footer">
                            <?php echo form_submit(array('value' => 'Submit', 'class' => 'btn btn-primary', 'id' => 'add')); ?>
                        </div>
                    <?php echo form_close();?>
                </div><!-- /.box -->
            </div><!-- ./col -->  
        </div><!-- /.row -->
        <!-- Main row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
     
<?php
foreach($menu_permission_array as $menu_permission_array_list)
{ 
?>
<script type="text/javascript">
    $(document).ready(function(){
        var id = '<?php echo $menu_permission_array_list; ?>';        
        $('#view_head_'+id).attr('checked', true);
        getMenuChild(id, 'true');
    });
</script>
    
<?php } ?>

 

<!-- check validation -->
<script type="text/javascript">
    setTimeout(function(){
        $('.error_validator').hide();
    },3000);
    //$(function () {$('.select2').select2()});
    
    $('#error').hide();

    function enableEdit() {
        $("input").prop("readonly", false);
        $('#add').removeClass('hide');
        $('select').attr('disabled', false);
        $('input:checkbox').attr('disabled', false);
        $('.selectpicker').selectpicker('refresh');
    }

   
    $(document).ready(function(){
        setTimeout(function(){ $('#secc_msg').fadeOut(); }, 10000);
        
        $('.set_div_img2').on('click', function() {
            $('#secc_msg').fadeOut();
        });
        
        
    });

    function getMenuChild(id, status)
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
                        // $('input:checkbox').attr('disabled', status);

                    }
                    else
                    {
                        $('#child_div_'+id).addClass('hide');
                        $('#child_div_'+id).html('');
                        // $('input:checkbox').attr('disabled', status);
                    }
                }
            });
        }
        
    }

    function getMenuChild_test(id)
    {
        if($("#view_head_"+id).prop('checked') == true)
        {
            $.ajax({
                url:'<?php echo base_url('Miscellaneous/getMenuChild');?>',
                type:'post',
                data:{ id:id,checked_menu:$('#check_menu_permission').val() },
                success:function(output){
                    if(output!="")
                    {
                        $('#child_div_'+id).removeClass('hide');
                        $('#child_div_'+id).html(output);

                        //$('#view_head_'+id).prop('checked', true);

                        //getMenuChild(8);

                    }
                    else
                    {
                        $('#child_div_'+id).addClass('hide');
                        $('#child_div_'+id).html('');
                    }
                    
                }
            });
        }
        else
        {
            $('#child_div_'+id).addClass('hide');
            $('#child_div_'+id).html('');
        }
    }


    

    /* check validation */
    $('#add').on('click', function() {
        var group_name = $('#group_name').val();
        

        if (group_name == '') {
            $('#err_group_name').css('color', 'red').text('Please enter group name.').show();
            setTimeout(function() {
                $('#err_group_name').hide();
            }, 5000);
            $('#group_name').focus();
            return false;
        }
    }); /* check validation / */


</script>


