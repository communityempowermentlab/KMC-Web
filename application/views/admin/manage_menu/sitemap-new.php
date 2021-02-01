<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
  integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
  crossorigin="anonymous"></script>
<script src="<?php echo base_url(); ?>assets/js/sitemap.js"></script>
   
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
            <h5 class="content-header-title float-left pr-1 mb-0">Sitemap</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                
                <li class="breadcrumb-item active">Sitemap
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            
              <div id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
              <div class="col-12">
                <h5 class="float-left pr-1">Manage Site Map Architecture</h5>
              </div>
              
              <div class="row col-12">
                <div id="hiddenSms" class="col-12"><?php echo $this->session->flashdata('message'); ?></div>
                  <div class="col-sm-7" id="heading">

                        <!-- Home Button -->
                        <button type="button" class="btn btn-icon btn-outline-primary" style="margin-left: 10px;"><i class="bx bxs-home"></i></button>

                        <a title="Add" id="heading_menu_add_div" onclick="openHeadingMenuDiv();">
                            <button type="button" class="btn btn-icon btn-outline-primary"><i class="bx bx-plus"></i></button>
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
                                
                                <a title="Add" id="" onclick="addNewChild(<?php echo $value['id']; ?>, '<?php echo base_url('Miscellaneous/addNewChild') ?>');">
                                    <button type="button" class="btn btn-icon btn-outline-primary"><i class="bx bx-plus"></i></button>
                                </a>

                                <a title="Edit Data" class="edit" onclick="editNode(<?php echo $value['id']; ?>, '<?php echo base_url('Miscellaneous/editNode') ?>');">
                                    <button type="button" class="btn btn-icon btn-outline-primary"><i class="bx bxs-edit"></i></button>
                                </a>
                                <?php if($show == '1') {
                                if ($value['status'] == 1) { ?>
                                            <button class="btn btn-outline-success click_btn change" id="id_<?php echo $value['id'];?>" s_id="<?php echo $value['id'];?>" s_url="<?= base_url("Miscellaneous/changeStatus")?>" type="button">Active</button> 
                                        <?php } else { ?>
                                            <button class="btn btn-outline-warning click_btn change" id="id_<?php echo $value['id'];?>" s_id="<?php echo $value['id'];?>" s_url="<?= base_url("Miscellaneous/changeStatus")?>" type="button">Deactive</button> 
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

                                    <a title="Add" id="" onclick="addNewChild(<?php echo $value1['id']; ?>, '<?php echo base_url('Miscellaneous/addNewChild') ?>');">
                                        <button type="button" class="btn btn-icon btn-outline-primary"><i class="bx bx-plus"></i></button>
                                    </a>

                                    <a title="Edit Data" class="edit" onclick="editNode(<?php echo $value1['id']; ?>, '<?php echo base_url('Miscellaneous/editNode') ?>');">
                                        <button type="button" class="btn btn-icon btn-outline-primary"><i class="bx bxs-edit"></i></button>
                                    </a>
                                    <?php if ($value1['status'] == 1) { ?>
                                            <button class="btn btn-outline-success click_btn change" id="id_<?php echo $value1['id'];?>" s_id="<?php echo $value1['id'];?>" s_url="<?= base_url("Miscellaneous/changeStatus")?>" type="button">Active</button> 
                                        <?php } else { ?>
                                            <button class="btn btn-outline-warning click_btn change" id="id_<?php echo $value1['id'];?>" s_id="<?php echo $value1['id'];?>" s_url="<?= base_url("Miscellaneous/changeStatus")?>" type="button">Deactive</button> 
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
                                    <button type="button" class="btn info-btn btn-info"><?php echo $value2['levelName']; ?></button>

                                    <!-- <a title="Add" id="" onclick="addNewChild(<?php echo $value2['id']; ?>);">
                                        <button type="button"><i class="fa fa-plus"></i></button>
                                    </a> -->

                                    <a title="Edit Data" class="edit" onclick="editNode(<?php echo $value2['id']; ?>, '<?php echo base_url('Miscellaneous/editNode') ?>');">
                                        <button type="button" class="btn btn-icon btn-outline-primary"><i class="bx bxs-edit"></i></button>
                                    </a>
                                    <?php if ($value2['status'] == 1) { ?>
                                            <button class="btn btn-outline-success click_btn change" id="id_<?php echo $value2['id'];?>" s_id="<?php echo $value2['id'];?>" s_url="<?= base_url("Miscellaneous/changeStatus")?>" type="button">Active</button> 
                                        <?php } else { ?>
                                            <button class="btn btn-outline-warning click_btn change" id="id_<?php echo $value2['id'];?>" s_id="<?php echo $value2['id'];?>" s_url="<?= base_url("Miscellaneous/changeStatus")?>" type="button">Deactive</button> 
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

                                            <a title="Edit Group Data" class="edit" onclick="editNode(<?php echo $value3['id']; ?>, '<?php echo base_url('Miscellaneous/editNode') ?>');">
                                                <button type="button"><i class="fa fa-edit"></i></button>
                                            </a>
                                            <?php if ($value3['status'] == 1) { ?>
                                                    <button class="btn btn-outline-success click_btn change" id="id_<?php echo $value3['id'];?>" s_id="<?php echo $value3['id'];?>" s_url="<?= base_url("Miscellaneous/changeStatus")?>" type="button">Active</button> 
                                                <?php } else { ?>
                                                    <button class="btn btn-outline-warning click_btn change" id="id_<?php echo $value3['id'];?>" s_id="<?php echo $value3['id'];?>" s_url="<?= base_url("Miscellaneous/changeStatus")?>" type="button">Deactive</button> 
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
                                                        <button type="button" class="btn info-btn btn-info"><?php echo $value4['levelName']; ?></button>

                                                        <!-- <a title="Add" id="" onclick="addNewChild(<?php //echo $value4['id']; ?>);">
                                                            <button type="button"><i class="fa fa-plus"></i></button>
                                                        </a> -->

                                                        <a title="Edit Group Data" class="edit" onclick="editNode(<?php echo $value4['id']; ?>, '<?php echo base_url('Miscellaneous/editNode') ?>');">
                                                            <button type="button"><i class="fa fa-edit"></i></button>
                                                        </a>
                                                        <?php if ($value4['status'] == 1) { ?>
                                                                <button class="btn btn-outline-success click_btn change" id="id_<?php echo $value4['id'];?>" s_url="<?= base_url("Miscellaneous/changeStatus")?>" s_id="<?php echo $value4['id'];?>" type="button">Active</button> 
                                                            <?php } else { ?>
                                                                <button class="btn btn-outline-warning click_btn change" id="id_<?php echo $value4['id'];?>" s_url="<?= base_url("Miscellaneous/changeStatus")?>" s_id="<?php echo $value4['id'];?>" type="button">Deactive</button> 
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

                    <div class="col-sm-5 pr-0" style="border-bottom: 1px solid #f4f4f4;margin-bottom: 10px;display:none;" id="menuFormDiv">
                      <form class="form-horizontal" method="post" novalidate action="<?php echo site_url('Miscellaneous/addMenuHeading');?>" id="addMenuHeadingForm">
                        
                            <div class="pr-0 col-sm-12">
                                 
                                <!--  Menu Type -->
                                <div class="form-group col-12 row pr-0">
                                    <div  class="col-sm-5">
                                        <label for="exampleInputEmail1">Select Menu Type <span class="red">*</span></label>
                                    </div>
                                    <div  class="col-sm-7 pl-0">
                                        <input type="hidden" id="main_id" name="main_id">
                                        <ul class="list-unstyled mb-0 ml-1" style="">
                                          <li class="d-inline-block mr-2">
                                            <fieldset>
                                              <div class="radio">
                                                <input type="radio" name="menu_type" value="1" id="Heading" checked="checked" onclick="checkMenuType(this.value);">
                                                <label for="Heading">Heading</label>

                                              </div>
                                            </fieldset>
                                          </li>
                                          <li class="d-inline-block mr-2">
                                            <fieldset>
                                              <div class="radio">
                                                <input type="radio" name="menu_type" value="2" id="Menu" onclick="checkMenuType(this.value);">
                                                <label for="Menu">Menu</label>

                                              </div>
                                            </fieldset>
                                          </li>
                                        </ul>
                                        
                                        <!-- <p id="err_measusement" class="user_err"></p> -->
                                    </div>
                                </div> <!-- Select Menu Type/ --> 

                                <!-- Label Name -->
                                <div class="form-group col-12 row pr-0">
                                    <div  class="col-sm-5">
                                        <label for="exampleInputEmail1"><span id="m_name">Heading Name</span> <span class="red">*</span></label>
                                    </div>
                                    <div  class="col-sm-7 pr-0">
                                      <div class="controls">
                                        <input type="text" class="form-control" placeholder="Heading Name" id="label_name" name="label_name" required="">
                                      </div>
                                        
                                        <!-- <span id="err_group_name" class="user_err"></span> -->
                                    </div>
                                </div> <!-- Label Name / -->
                            
                               
                                
                            </div>
                            <button type="submit" name="update" id="add" class="btn btn-sm btn-primary pull-right mr-1">Submit</button>

                    </div>
                                                
                    </form>

                    <?php echo form_close();?>

                    <!-- Add Child Div -->
                    <div class="col-sm-5" style="border-bottom: 1px solid #f4f4f4;margin-bottom: 10px;display:none;" id="addChildDiv"></div>
                    <!-- ************* -->

                    <!-- Edit Node Div -->
                    <div class="col-sm-5" style="border-bottom: 1px solid #f4f4f4;margin-bottom: 10px;display:none;" id="editNodeDiv">
                      
                    </div>
                    <!-- ************* -->
                  
              </div>
              
              
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


    