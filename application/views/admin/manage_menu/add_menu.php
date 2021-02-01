<style type="text/css">
    #sections .box{ border-left: 1px solid #3c8dbc;border-right: 1px solid #3c8dbc;border-bottom: 1px solid #3c8dbc;
    }
    .form-control{
        height:0%;
    }
    .manage_divP, .divPadding{padding: 0px !important;}
    .box-body{padding: 10px 0px !important;}
    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn){width: 100% !important;}
    .btn{ border-radius: 0px !important;}
    .box-header.with-border{border: 0px solid !important;}
    .red{color: red;}

    .bx_body {
        padding: 10px 0px !important;
        background: #fff;
    }
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
    .set_div_img2{
        text-align: right; cursor: pointer;
    }
    .select2-selection.select2-selection--multiple{
        border-radius: 0px !important;
        border-color: #ddd !important;
    }

    .heading_div {
        padding: 15px;
    }
    .menu_div {
        padding: 7px;
    }
    .submenu_div {
        padding: 7px;
    }
    .heading_btn {
        background: #0d47a1;
        border-color: #0d47a1;
        color: #fff;
        padding-left: 20px;
        padding-right: 20px;
    }
    .heading_btn:hover {
        color: #fff;
    }
     .heading_btn:focus {
        color: #fff;
    }
     .heading_btn:active {
        color: #fff;
    }
    .btn-secondary {
        background-color: #6c757d;
        color: #fff;
    }
    .select2-selection__rendered{padding: 0 12px !important;}
    .set_new_padding{padding-left: 8px !important;}
    .flt_r{float: right;}
    .hide_measure, .common_base{display: none;}
    .set_bdr{border-bottom: 1px solid #f4f4f4; padding-top: 3px !important;}
    .addbtn {
        color: #000!important;
    }
    #heading:hover {
        cursor: move;
    }
</style>
<!-- <link rel="stylesheet" type="text/css" href="<?php //echo base_url(); ?>assets/admin/css/bootstrap-select.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php //echo base_url(); ?>assets/admin/css/select2.min.css"/> -->
<?php $this->load->model('admin/MiscellaneousModel', 'MiscellaneousModel');  ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Manage Site Map </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/welcome/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Manage Site Map</li>
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
                      <h3 class="box-title">Manage Site Map Architecture</h3>
                     <!-- <a href="<?php echo base_url('admin/menuGroup/addMenu'); ?>" class="addbtn"><button class="pull-right">Add New Menu</button></a> -->
                    </div>
                <div class="col-xs-12 bx_body">

                    <div class="error_validator">
                    <?php 
                        echo validation_errors(); 
                        if($this->session->flashdata('message'))
                            echo $this->session->flashdata('message');
                    ?> 
                    </div>
                    <div class="col-xs-12 col-sm-12" id="error"></div>

                    <!-- ************ -->

                    <div class=" col-xs-7 divPadding" id="heading">

                        <!-- Home Button -->
                        <button type="button" style="margin-left: 10px;"><i class="fa fa-home"></i></button>

                        <a title="Add" id="heading_menu_add_div" onclick="openHeadingMenuDiv();">
                            <button type="button"><i class="fa fa-plus"></i></button>
                        </a>
                        <!-- ********** -->

                        <?php foreach ($heading as $key => $value) { 
                            if($value['type'] != 'menu') {
                            $tab = 'h_';
                            $btn_cls = 'heading_btn';
                            $show = '2';
                            $btn_id = 'hbtn'.$value['id'];
                            $divid = "heading_div";
                        } else {
                            $tab = 'm_';
                            $show = '1';
                            $btn_id = 'mid'.$value['id'];
                            if($value['status'] == 1) {
                                $btn_cls = 'btn-primary';
                             } else {
                                $btn_cls = 'btn-secondary';
                             }
                             $divid = "menu_div";
                        }
                         ?>
                            <div class="col-sm-12 heading_div" id="<?php echo $divid; ?>" data-id="<?php echo $value['id']; ?>">
                                <button type="button" class="btn <?php echo $btn_cls; ?>" id="<?php echo $btn_id; ?>"><?php echo $value['levelName']; ?></button>
                                
                                <a title="Add" id="" onclick="addNewChild(<?php echo $value['id']; ?>);">
                                    <button type="button"><i class="fa fa-plus"></i></button>
                                </a>

                                <a title="Edit Data" class="edit" onclick="editNode(<?php echo $value['id']; ?>);">
                                    <button type="button"><i class="fa fa-edit"></i></button>
                                </a>
                                <?php if($show == '1') {
                                if ($value['status'] == 1) { ?>
                                            <button class="btn btn-sm btn-success click_btn change" id="id_<?php echo $value['id'];?>" s_id="<?php echo $value['id'];?>" type="button">Active</button> 
                                        <?php } else { ?>
                                            <button class="btn btn-sm btn-warning click_btn change" id="id_<?php echo $value['id'];?>" s_id="<?php echo $value['id'];?>" type="button">Deactive</button> 
                                        <?php } } ?>
                                
                                <?php
                                if( $value['parentId'] == 0  && $value['type'] != 'menu') {
                                    
                                $table_name1 = 'manageSitemap';
                                $con1 = array(
                                    'parentId' => $value['id']
                                );
                                $get_heading_menu = $this->MiscellaneousModel->getMenuByPos($table_name1, $con1); 
                                foreach ($get_heading_menu as $key1 => $value1) {
                                    if($value1['status'] == 1) {
                                        $cls = 'btn-primary';
                                    } else if($value1['status'] == 2) {
                                        $cls = 'btn-secondary';
                                    }
                                ?>

                                <div class="col-sm-offset-1 col-sm-12 menu_div" id="head_menu_div" data-id="<?php echo $value1['id']; ?>">

                                    <button type="button" id="mid<?php echo $value1['id'];?>" class="btn menu_btn <?php echo $cls; ?>"><?php echo $value1['levelName']; ?></button>

                                    <a title="Add" id="" onclick="addNewChild(<?php echo $value1['id']; ?>);">
                                        <button type="button"><i class="fa fa-plus"></i></button>
                                    </a>

                                    <a title="Edit Data" class="edit" onclick="editNode(<?php echo $value1['id']; ?>);">
                                        <button type="button"><i class="fa fa-edit"></i></button>
                                    </a>
                                    <?php if ($value1['status'] == 1) { ?>
                                            <button class="btn btn-sm btn-success click_btn change" id="id_<?php echo $value1['id'];?>" s_id="<?php echo $value1['id'];?>" type="button">Active</button> 
                                        <?php } else { ?>
                                            <button class="btn btn-sm btn-warning click_btn change" id="id_<?php echo $value1['id'];?>" s_id="<?php echo $value1['id'];?>" type="button">Deactive</button> 
                                        <?php } ?>

                                <?php
                                 $table_name1 = 'manageSitemap';
                                $con1 = array(
                                    'parentId' => $value1['id'],
                                    'status!=' => 3
                                );
                                $get_subsection = $this->MiscellaneousModel->getMenuByPos($table_name1, $con1);
                                foreach ($get_subsection as $key1 => $value2) {  ?>
                                    <div class="col-sm-offset-1 col-sm-12 submenu_div" data-id="<?php echo $value2['id']; ?>">
                                    <button type="button" class="btn btn-info"><?php echo $value2['levelName']; ?></button>

                                    <!-- <a title="Add" id="" onclick="addNewChild(<?php echo $value2['id']; ?>);">
                                        <button type="button"><i class="fa fa-plus"></i></button>
                                    </a> -->

                                    <a title="Edit Data" class="edit" onclick="editNode(<?php echo $value2['id']; ?>);">
                                        <button type="button"><i class="fa fa-edit"></i></button>
                                    </a>
                                    <?php if ($value2['status'] == 1) { ?>
                                            <button class="btn btn-sm btn-success click_btn change" id="id_<?php echo $value2['id'];?>" s_id="<?php echo $value2['id'];?>" type="button">Active</button> 
                                        <?php } else { ?>
                                            <button class="btn btn-sm btn-warning click_btn change" id="id_<?php echo $value2['id'];?>" s_id="<?php echo $value2['id'];?>" type="button">Deactive</button> 
                                        <?php } ?>

                                    <?php
                                    $table_name2 = 'manageSitemap';
                                    $con2 = array(
                                        'parentId' => $value2['id'],
                                        'status!=' => 3
                                    );
                                    $get_subsection1 = $this->MiscellaneousModel->getMenuByPos($table_name2, $con2); 

                                    foreach ($get_subsection1 as $key2 => $value3) { ?>

                                        <div class="col-sm-offset-1 col-sm-12 submenu_div" data-id="<?php echo $value3['id']; ?>">
                                            <button type="button" class="btn btn-warning"><?php echo $value3['levelName']; ?></button>

                                           <!--  <a title="Add" id="" onclick="addNewChild(<?php echo $value3['id']; ?>);">
                                                <button type="button"><i class="fa fa-plus"></i></button>
                                            </a> -->

                                            <a title="Edit Group Data" class="edit" onclick="editNode(<?php echo $value3['id']; ?>);">
                                                <button type="button"><i class="fa fa-edit"></i></button>
                                            </a>
                                            <?php if ($value3['status'] == 1) { ?>
                                                    <button class="btn btn-sm btn-success click_btn change" id="id_<?php echo $value3['id'];?>" s_id="<?php echo $value3['id'];?>" type="button">Active</button> 
                                                <?php } else { ?>
                                                    <button class="btn btn-sm btn-warning click_btn change" id="id_<?php echo $value3['id'];?>" s_id="<?php echo $value3['id'];?>" type="button">Deactive</button> 
                                                <?php } ?>

                                                <?php
                                                $table_name3 = 'manageSitemap';
                                                $con3 = array(
                                                    'parentId' => $value3['id'],
                                                    'status!=' => 3
                                                );
                                                $get_subsection2 = $this->MiscellaneousModel->getMenuByPos($table_name3, $con3); 

                                                foreach ($get_subsection2 as $key3 => $value4) { ?>

                                                    <div class="col-sm-offset-1 col-sm-12 submenu_div" data-id="<?php echo $value4['id']; ?>">
                                                        <button type="button" class="btn btn-info"><?php echo $value4['levelName']; ?></button>

                                                        <!-- <a title="Add" id="" onclick="addNewChild(<?php //echo $value4['id']; ?>);">
                                                            <button type="button"><i class="fa fa-plus"></i></button>
                                                        </a> -->

                                                        <a title="Edit Group Data" class="edit" onclick="editNode(<?php echo $value4['id']; ?>);">
                                                            <button type="button"><i class="fa fa-edit"></i></button>
                                                        </a>
                                                        <?php if ($value4['status'] == 1) { ?>
                                                                <button class="btn btn-sm btn-success click_btn change" id="id_<?php echo $value4['id'];?>" s_id="<?php echo $value4['id'];?>" type="button">Active</button> 
                                                            <?php } else { ?>
                                                                <button class="btn btn-sm btn-warning click_btn change" id="id_<?php echo $value4['id'];?>" s_id="<?php echo $value4['id'];?>" type="button">Deactive</button> 
                                                            <?php } ?>
                                                    </div>
                                                <?php } ?>

                                        </div>
                                    <?php } ?>

                                </div>
                               <?php } ?>
                                </div>
                            <?php } } //else {
                                // $table_name1 = 'manage_menu_submenu';
                                // $con1 = array(
                                //     'menu_id' => $value['id'],
                                //     'status!=' => 3
                                // );
                                //$get_subsection = $this->MiscellaneousModel->getMenuByPos($table_name1, $con1);
                                //foreach ($get_subsection as $key2 => $value2) {  ?>
                                    <!-- <div class="col-sm-offset-1 col-sm-12 submenu_div" data-id="<?php //echo $value2['id']; ?>">
                                    <button type="button" class="btn btn-info"><?php //echo $value2['sub_section']; ?></button>
                                </div> -->
                               <?php //} 
                            //}  ?>

                            </div>
                     <?php   }  ?>

                                                                                    
                    </div>

                    <div class="col-xs-5 divPadding" style="border-bottom: 1px solid #f4f4f4;margin-bottom: 10px;display:none;" id="menuFormDiv">
                        <?php echo form_open_multipart('Miscellaneous/addMenuHeading',array('id'=>'addMenuHeadingForm')); ?>
                        
                            <div class="col-xs-12 col-sm-12 divPadding">
                                 
                                <!--  Menu Type -->
                                <div class="form-group col-sm-12 col-xs-12 manage_divP">
                                    <div  class="col-xs-5">
                                        <label for="exampleInputEmail1">Select Menu Type <span class="red">*</span></label>
                                    </div>
                                    <div  class="col-xs-7">
                                        <input type="hidden" id="main_id" name="main_id">
                                        <input type="radio" name="menu_type" value="1" id="Heading" checked="checked" onclick="checkMenuType(this.value);"> Heading &nbsp;

                                        <input type="radio" name="menu_type" value="2" id="Menu" onclick="checkMenuType(this.value);"> Menu
                                        <!-- <p id="err_measusement" class="user_err"></p> -->
                                    </div>
                                </div> <!-- Select Menu Type/ --> 

                                <!-- Label Name -->
                                <div class="form-group col-sm-12 col-xs-12 manage_divP">
                                    <div  class="col-xs-5">
                                        <label for="exampleInputEmail1"><span id="m_name">Heading Name</span> <span class="red">*</span></label>
                                    </div>
                                    <div  class="col-xs-7">
                                        <?php echo form_input(
                                            array(
                                                    'name'              => 'label_name',
                                                    'class'             => 'form-control',
                                                    'placeholder'       => 'Heading Name',
                                                    'value'             =>  set_value('name'),
                                                    'type'              => 'text',
                                                    'id'                => 'label_name',
                                                    'required'          => 'true'
                                                )
                                            );
                                        ?>
                                        <!-- <span id="err_group_name" class="user_err"></span> -->
                                    </div>
                                </div> <!-- Label Name / -->
                            
                               
                                
                            </div>

                            <center>
                                <?php echo form_submit(array('value' => 'Submit', 'class' => 'btn btn-primary', 'name' => 'update', 'id' => 'add')); ?>
                            </center>

                    </div>
                                                
                    <?php echo form_close();?>

                    <!-- Add Child Div -->
                    <div class="col-xs-5 divPadding" style="border-bottom: 1px solid #f4f4f4;margin-bottom: 10px;display:none;" id="addChildDiv"></div>
                    <!-- ************* -->

                    <!-- Edit Node Div -->
                    <div class="col-xs-5 divPadding" style="border-bottom: 1px solid #f4f4f4;margin-bottom: 10px;display:none;" id="editNodeDiv"></div>
                    <!-- ************* -->

                </div>
                
                </div><!-- /.box -->
            </div><!-- ./col -->  
        </div><!-- /.row -->
        <!-- Main row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
     

    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>  -->
    <!-- <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>  -->
    <!-- <script src="https://getbootstrap.com/dist/js/bootstrap.min.js"></script> -->

<!-- check validation -->
<script type="text/javascript">

    $(window).scroll(function() {
      $("#menuFormDiv").css({
        "margin-top": ($(window).scrollTop()) + "px",
        "margin-left": ($(window).scrollLeft()) + "px",
        "transition": "1s"
      });

      $("#addChildDiv").css({
        "margin-top": ($(window).scrollTop()) + "px",
        "margin-left": ($(window).scrollLeft()) + "px",
        "transition": "1s"
      });

      $("#editNodeDiv").css({
        "margin-top": ($(window).scrollTop()) + "px",
        "margin-left": ($(window).scrollLeft()) + "px",
        "transition": "1s"
      });

    });

    $(document).ready(function(){
        setTimeout(function(){ $('#secc_msg').fadeOut(); }, 10000);

        $('.set_div_img2').on('click', function() {
            $('#secc_msg').fadeOut();
        });

        $("#addMenuHeadingForm").validate();
    });

    function openHeadingMenuDiv()
    {
        $('#menuFormDiv').show();
        $('#addChildDiv').hide();
        $('#editNodeDiv').hide();
    }

    function checkMenuType(type)
    {
        if(type==1)
        {
            $('#m_name').html("Heading Name");
            $("#label_name").attr("placeholder", "Heading Name");
        }
        else
        {
            $('#m_name').html("Menu Name");
            $("#label_name").attr("placeholder", "Menu Name");
        }
    }

    function addNewChild(id)
    {
        var url = '<?php echo base_url('Miscellaneous/addNewChild') ?>';
        $.ajax({
            url: url,
            type: 'post',
            data: {
                    'id': id
                },
            success: function(data) {
                $('#addChildDiv').show();
                $('#menuFormDiv').hide();
                $('#editNodeDiv').hide();
                $('#addChildDiv').html(data);
            }
        });
    }

    function editNode(id)
    {
        var url = '<?php echo base_url('Miscellaneous/editNode') ?>';
        $.ajax({
            url: url,
            type: 'post',
            data: {
                    'id': id
                },
            success: function(data) {
                $('#addChildDiv').hide();
                $('#menuFormDiv').hide();
                $('#editNodeDiv').show();
                $('#editNodeDiv').html(data);
            }
        });
    }

    $('.click_btn').on('click', function(){
        var get_id = $(this).attr('id');
        var s_id = $(this).attr('s_id');
        var table = 'manageSitemap';
        var text = $(this).html();
        var txt = '';
        if (text == 'Deactive') {
            txt = 'Active';
        } else {
            txt = 'Deactive';
        }

        var msg  = 'Are you sure ' +txt+ ' this record';
        
        var conf = confirm(msg);
        var s_url = '<?php echo base_url('Miscellaneous/changeStatus')?>';
        if (conf) {
            $.ajax({
                data: {'table': table, 'id': s_id},
                url: s_url,
                type: 'post',
                success: function(data){ 
                    if (data == '1') {
                        $('#'+get_id).removeClass('btn-warning');
                        $('#'+get_id).addClass('btn-success');
                        $('#mid'+s_id).removeClass('btn-secondary');
                        $('#mid'+s_id).addClass('btn-primary');
                        $('#'+get_id).text('Active');
                    } else if (data == '2') {
                        $('#'+get_id).removeClass('btn-success');
                        $('#'+get_id).addClass('btn-warning');
                        $('#mid'+s_id).removeClass('btn-primary');
                        $('#mid'+s_id).addClass('btn-secondary');
                        $('#'+get_id).text('Deactive');
                    }
                }
            });
        }

    });


    setTimeout(function(){
        $('.error_validator').hide();
    },3000);
    //$(function () {$('.select2').select2()});
    
    $('#error').hide();

    /*Update Menu Position*/
    function updateMenu(data) { 
        $.ajax({
            url:'<?php echo base_url('admin/menuGroup/updateMenu');?>',
            type:'post',
            data:{position:data},
            success:function(resp){ 
                // alert('menu changed');
            }
        });
    }

    // sortable function for heading and menu without heading 
    var currentlyScrolling = false;
    var SCROLL_AREA_HEIGHT = 40;

     $('#heading').sortable({ 
        scroll: true,
        sort: function(event, ui) {

          if (currentlyScrolling) {
            return;
          }

          var windowHeight   = $(window).height();
          var mouseYPosition = event.clientY;

          if (mouseYPosition < SCROLL_AREA_HEIGHT) {
            currentlyScrolling = true;

            $('html, body').animate({
              scrollTop: "-=" + windowHeight / 2 + "px" // Scroll up half of window height.
            }, 
            400, // 400ms animation.
            function() {
              currentlyScrolling = false;
            });

          } else if (mouseYPosition > (windowHeight - SCROLL_AREA_HEIGHT)) {

            currentlyScrolling = true;

            $('html, body').animate({
              scrollTop: "+=" + windowHeight / 2 + "px" // Scroll down half of window height.
            }, 
            400, // 400ms animation.
            function() {
              currentlyScrolling = false;
            });

          }
        },

        delay: 150,
        stop: function() {
            var selectedData = new Array();
            $('#heading>.heading_div').each(function() {
                selectedData.push($(this).attr("data-id"));
            }); 
            updateMenu(selectedData);
        }
    });

   
</script>