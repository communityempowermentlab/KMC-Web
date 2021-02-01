<style>
    .group{cursor: pointer;}
    .img_h_w{height: 50px; width: 50px;}
    .del{cursor: pointer;}
    .divPadding{padding-right: 0px !important; padding-left: 0px !important; }
    .success_msg{               
        width: 98% !important;
        min-height: 50px !important;
        position: relative !important;
        top: 0 !important;
        right: 0px !important;
        background: #dff0d8 !important;
        color: #3c763d !important;
        z-index: 1000000 !important;
        padding: 15px 5px !important;
        border: 1px solid #d6e9c6 !important;
        border-radius: 4px !important;
        margin: 0 auto 15px !important;
        font-weight: 500 !important;
        font-size: 16px !important;          
    } 
    .set_succ_msg{
        float: right;
        cursor: pointer;
    }
    
</style>

<?php 

    $this->load->model('admin/MiscellaneousModel', 'MiscellaneousModell');
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Manage Menu Groups </h1>

        <ol class="breadcrumb" style="padding: 0px 5px;">
            <!-- <li><a href="<?php //echo base_url('admin/menuGroup/addMenu'); ?>" class="add_user"><button type="button" class="btn btn-info">Manage Menus</button></a></li> -->
            <li style=""><a href="<?php echo base_url('Miscellaneous/addMenuGroup'); ?>" class="add_user"><button type="button" class="btn btn-success"> Add Menu Group</button></a></li>
        </ol>
    </section>
    <style type="text/css">
        .action i{font-size: 20px}
        .ch_pwd{cursor: pointer;}
    </style>
    <!-- Main content -->
    <section class="content">          
        <div class="row">
            <div class="col-xs-12">
                <div class="box col-xs-12 divPadding">
                    <div class="box-body col-xs-12 col-sm-12 divPadding">
                        <div class="col-xs-12 divPadding" id="hide_data">
                            
                            <?php if($this->session->flashdata('message'))
                                echo $this->session->flashdata('message');
                            ?>
                        </div>
                        <div class="col-xs-12" id="success_msg" style="display: none;"></div>
                        <div class="col-sm-12" style="overflow: auto;">
                            <table class="table-striped table table-bordered editable-datatable example" id ="cg1">
                                <thead>
                                    <tr>
                                        <td><b>S. No.</b></td>
                                        <td><b>Group Name</b></td>
                                        <td><b>Status</b></td>
                                        <td><b>View Details</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  $i = 1; foreach ($res as $value) { ?>

                                        <tr id="<?php echo $value['id']; ?>" class="main_row">
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $value['groupName']; ?></td>
                                            <td id="act" style="padding-top: 10px;">
                                                <?php if ($value['status'] == 1) { ?>
                                                    <div class="label label-success label-sm" id="id_<?php echo $value['id'];?>" s_id="<?php echo $value['id'];?>" type="button">Active</div> 
                                                <?php } else { ?>
                                                    <div class="label label-warning label-sm" id="id_<?php echo $value['id'];?>" s_id="<?php echo $value['id'];?>" type="button">Deactive</div> 
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <a title="Edit Group Data" href="<?php echo base_url('Miscellaneous/editMenuGroup/'.$value['id']); ?>">
                                                    <button type="button" class="btn btn-info">View/Edit</button>
                                                </a>
                                            </td>                                    
                                        </tr>
                                    <?php  $i++; } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        setTimeout(function() {
             $('#hide_data').hide();
         }, 10000);
       $('.c1').on('click', function() {
            $('#hide_data').fadeOut();
        });

        $('#cg').DataTable( {
            dom: 'Bfrtip',
            "pagingType": "full_numbers",
            lengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
            iDisplayLength: 100,

            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );
    });

    $('.del').on('click', function(){
        delRows(this);
    }); 

    $('.click_btn').on('click', function(){
        var get_id = $(this).attr('id');
        var s_id = $(this).attr('s_id');
        var table = 'manage_menu_group_setting';

        var text = $(this).html();
        var txt = '';
        
        if (text == 'Deactivate') {
            txt = 'Activate';
        } else {
            txt = 'Deactivate';
        }
        var s_url = '<?php echo base_url('admin/leadC/changeStatus')?>';

        var conf_msg = 'Are you sure '+txt+' this record.';
        var con = confirm(conf_msg)

        if (con) {
            
            $.ajax({
                data: {'table': table, 'id': s_id},
                url: s_url,
                type: 'post',
                success: function(data){
                    if (data == '1') {
                        $('#'+get_id).removeClass('btn-warning');
                        $('#'+get_id).addClass('btn-success');
                        $('#'+get_id).text('Active');
                    } else if (data == '2') {
                        $('#'+get_id).removeClass('btn-success');
                        $('#'+get_id).addClass('btn-warning');
                        $('#'+get_id).text('Deactivate');
                    }

                    $message = '<div class="success_msg" id="secc_msg"><div class="col-xs-12 set_div_msg">Record successfully '+txt+' <span class="set_succ_msg"><i class="fa fa-times" aria-hidden="true"></i></span></div></div>';

                    $('#hide_data').html($message).show();
                    setTimeout(function() {
                        $('#hide_data').hide();
                    }, 30000);

                    $('.set_succ_msg').on('click', function() {
                        
                        $('#hide_data').hide();
                    });
                }
            });
        }
    });
    

    /* change status for active, deactive btn */
    function changeStatus(e){
      
    }

    function delRows(e) {
        var id = $(e).attr('id');
        
        var url = '<?php echo base_url('admin/deleteRecord')?>/'+id;
        var confirm = window.confirm("Are you sure to delete this record!");
 
        if ( confirm == true) {
            $.ajax({
                url: url,
                type: 'post',
                success: function(data) {
                   // alert(data);
                    if (data) {
                        $('.main_row#'+id).remove(); 
                    }
                }
            });
        }
    }
     
</script>