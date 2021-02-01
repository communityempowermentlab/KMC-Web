<script type="text/javascript">
  function setWidth(custumVal) {
    if(custumVal == '1'){
     var id = $('#setiingID').val('2');     
     $('#style-2').addClass('setWidthSiderbar');     
    }else{
     var id = $('#setiingID').val('1');     
     $('#style-2').removeClass('setWidthSiderbar'); 
    }
  }
</script>
<style type="text/css">
  .scrollbar {
    background-color: #F5F5F5 !important;
    height: 100% !important;
    /*overflow-y: scroll !important;*/
    position: fixed;
  }
  #style-1::-webkit-scrollbar {
    width: 4px !important;
    background-color: #F5F5F5 !important;
  } #style-1::-webkit-scrollbar-thumb {
      background-color: #63dbdb !important;
  }.setWidthSiderbar{
    width: 100%;
  }
  .main-header .sidebar-toggle{
    border: none;
  }
  .sidebar-menu{
    overflow-y: scroll !important;
    height: 70% !important;
  }
  .label-sm{
    font-size: 12px;
  }
  .errorMessage{
    color: red;
    font-style: italic;
  }
  .tooltip {
    position: relative;
    display: inline-block;
    opacity: 1;
  }

  .tooltip .tooltiptext {
    visibility: hidden;
    width: 100px;
    background-color: #5F6162;
    color: #fff;
    text-align: center;
    border-radius: 3px;
    padding: 2px 0;

    /* Position the tooltip */
    position: absolute;
    z-index: 1;
    top: 25px;
    left: 12px;
    font-size: 11px;
  }

  .tooltip:hover .tooltiptext {
    visibility: visible;
  }
  
  .showImgOnHover .modal-content {
    margin: auto;
    display: block;
    width: 80%;
    height: 95%;
    max-width: 700px;
  }
  .showImgOnHover .close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
  }

  .showImgOnHover .close:hover,
  .showImgOnHover .close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
  }

</style>
<section class="sidebar scrollbar" id="style-2">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <ul class="sidebar-menu" id="style-1">
      <?php $adminData = $this->session->userdata('adminData');
        if($adminData['Type']==1) { ?>
          <li class="treeview <?php echo ($index =='index'  ? 'active' : ''); ?>">
            <a href="<?php echo site_url('/admin/dashboard/index'); ?>">
              <i class="fa fa-dashboard"></i> <span>KMC V2 Dashboard</span>
            </a>
          </li>

          <li class="treeview <?php echo (($index=='LoginHistory') || ($index=='facilities')? 'active' : ''); ?>">
            <a href="<?php echo site_url('/facility/manageFacility'); ?>">
              <i class="fa fa-handshake-o"></i> <span>Facilities
            </a>
          </li>

          <li class="treeview <?php echo ( ($index=='LoungeLoginHistory') || ($index=='lounge')? 'active' : ''); ?>">
            <a href="<?php echo site_url('/loungeM/manageLounge'); ?>">
              <i class="fa fa-home"></i> <span>Lounges
            </a>
          </li>

          <li class="treeview <?php echo (($index == 'staff')? 'active' : ''); ?>">
            <a href="<?php echo site_url('/staffM/manageStaff'); ?>">
              <i class="fa fa-user"></i> <span>Staff
            </a>
          </li>

          <li class="treeview <?php echo (($index == 'enquiryM')? 'active' : ''); ?>">
            <a href="<?php echo site_url('/enquiryM/enquiryList'); ?>">
              <i class="fa fa-circle-o"></i> <span>Enquiries
            </a>
          </li>

          <li class="treeview <?php echo ($index == 'manageVideo'  ? 'active' : ''); ?>">
            <a href="<?php echo site_url('/videoM/manageVideo'); ?>">
              <i class="glyphicon glyphicon-film"></i> <span>Videos</span> 
            </a>
          </li>

          <li class="treeview <?php echo (($index=='manageState') || ($index=='manageRevenue') ? 'active' : ''); ?>">
            <a href="#"><i class="fa fa-microchip"></i> <span>Location</span>
              <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
            </a>
            <ul class="treeview-menu">
              <li class="treeview <?php echo (($index=='manageState') ? 'active' : ''); ?>"><a href="<?php echo site_url('/Location/manageState'); ?>"><i class="fa fa-circle-o" aria-hidden="true"></i><span>States</span></a></li>
              <li class="treeview <?php echo (($index=='manageRevenue') ? 'active' : ''); ?>"><a href="<?php echo site_url('/Location/manageRevenue'); ?>"><i class="fa fa fa-circle-o"></i><span>Revenue District</span></a></li>      
            </ul>       
          </li>

          <li class="treeview <?php echo (($index == 'employee')? 'active' : ''); ?>">
            <a href="<?php echo site_url('/employeeM/manageEmployee'); ?>">
              <i class="fa fa-user-plus"></i> <span>CEL Employees
            </a>
          </li>

          <li class="<?php echo (($index2=='reg_mother') ? 'active' : ''); ?>">
            <a href="<?php echo site_url('/motherM/mothersViaLounge'); ?>">
              <i class="fa fa-female" aria-hidden="true"></i> 
              <span>Mothers
            </a>
          </li>


          <li class="<?php echo (($index=='Baby') ? 'active' : ''); ?>">
            <a href="<?php echo site_url('/babyM/babysViaLounge'); ?>">
              <i class="fa fa-child" aria-hidden="true"></i> 
              <span>Babies
            </a>
          </li>


          <li class="treeview <?php echo (($index=='report') || ($index=='report1') ? 'active' : ''); ?>">
            <a href="#"><i class="fa fa-file-text-o"></i> <span>Reports</span>
              <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
            </a>
            <ul class="treeview-menu">
              <li class="treeview <?php echo (($index=='report') ? 'active' : ''); ?>"><a href="<?php echo site_url('/Admin/statisticsReport'); ?>"><i class="fa fa-circle-o" aria-hidden="true"></i><span>View Statistics</span></a></li>
              <li class="treeview <?php echo (($index=='report1') ? 'active' : ''); ?>"><a href="<?php echo site_url('/Admin/downloadReports'); ?>"><i class="fa fa fa-circle-o"></i><span>Download Reports</span></a></li>      
            </ul>       
          </li>


          <li class="treeview <?php echo (($index=='manageNBCU') || ($index=='MenuGroup') || ($index=='managementType') || ($index=='Sitemap') || ($index=='StaffType') || ($index=='FacilityType') || ($index=='manageTemplate') || ($index=='videoType') ? 'active' : ''); ?>">
            <a href="#"><i class="fa fa-microchip"></i> <span>Miscellaneous</span>
              <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
            </a>
            <ul class="treeview-menu">
              <li class="treeview <?php echo (($index=='manageNBCU') ? 'active' : ''); ?>"><a href="<?php echo site_url('/Miscellaneous/manageNBCU'); ?>"><i class="fa fa-circle-o" aria-hidden="true"></i><span>Newborn Care Unit Type</span></a></li>
              <li class="treeview <?php echo (($index=='managementType') ? 'active' : ''); ?>"><a href="<?php echo site_url('/Miscellaneous/managementType'); ?>"><i class="fa fa fa-circle-o"></i><span>Management Type</span></a></li>   
              <li class="treeview <?php echo (($index=='FacilityType') ? 'active' : ''); ?>"><a href="<?php echo site_url('/facility/facilityType/'); ?>"><i class="fa fa fa-circle-o"></i><span>Facility Type</span></a></li>  
              <li class="treeview <?php echo (($index=='StaffType') ? 'active' : ''); ?>"><a href="<?php echo base_url('staffM/staffType/');?>"><i class="fa fa fa-circle-o"></i><span>Staff Type</span></a></li>    
               <li class="treeview <?php echo (($index=='videoType') ? 'active' : ''); ?>"><a href="<?php echo base_url('videoM/videoType');?>"><i class="fa fa fa-circle-o"></i><span>Video Type</span></a></li>     
              <li class="treeview <?php echo (($index=='manageTemplate') ? 'active' : ''); ?>"><a href="<?php echo site_url('/staffM/manageTemplate/'); ?>"><i class="fa fa fa-circle-o"></i><span>SMS Template</span></a></li> 
              <li class="treeview <?php echo (($index=='Sitemap') ? 'active' : ''); ?>"><a href="<?php echo site_url('/Miscellaneous/manageSitemap'); ?>"><i class="fa fa-sitemap" aria-hidden="true"></i><span>Sitemap</span></a></li> 
              <li class="treeview <?php echo (($index=='MenuGroup') ? 'active' : ''); ?>"><a href="<?php echo site_url('/Miscellaneous/viewMenuGroup'); ?>"><i class="fa fa-link" aria-hidden="true"></i><span>Menu Group</span></a></li>    
            </ul>       
          </li>


          <!-- <li class="treeview <?php echo ($index == 'dutyChange'  ? 'active' : ''); ?>">
            <a href="<?php echo site_url('/staffM/manageDutyChangeModule'); ?>">
              <i class="fa fa-clock-o"></i> <span>Duty Change Module</span> 
            </a>
          </li> -->


          <li class="treeview <?php echo ($index == 'SentSms'  ? 'active' : ''); ?>">
            <a href="<?php echo site_url('/smsM/loungeWiseSMS'); ?>">
              <i class="glyphicon glyphicon-envelope"></i><span>Sent SMS</span>
              <span class="pull-right-container">
                      <span class="label label-success pull-right"><?php echo $coun1['smsmaster']; ?></span>
              </span> 
            </a>
          </li>


          <li class="treeview <?php echo ($index == 'NotificationCenter'  ? 'active' : ''); ?>">
            <a href="<?php echo site_url('/smsM/loungeWiseNotification'); ?>">
              <i class="fa fa-bell-o"></i><span>Notification Center</span>
              <span class="pull-right-container">
                      <span class="label label-warning pull-right"><?php echo $count['notification']; ?></span>
              </span> 
            </a>
          </li>


          <li class="treeview <?php echo ($index == 'timeline'  ? 'active' : ''); ?>">
            <a href="<?php echo site_url('/smsM/timeline'); ?>">
              <i class="fa fa-hospital-o"></i><span>Timeline</span> 
            </a>
          </li>

          <li class="treeview <?php echo ($index == 'suppliment'  ? 'active' : ''); ?>">
            <a href="<?php echo site_url('/supplimentM/manageSupplement'); ?>">
              <i class="fa fa-plus-square"></i><span>Supplements</span> 
            </a>
          </li>

          <li class="treeview <?php echo ($index == 'Settings'  ? 'active' : ''); ?>">
            <a href="<?php echo site_url('/admin/settings'); ?>">
              <i class="fa fa-cog"></i><span>Settings</span> 
            </a>
          </li>
      
          <li class="treeview <?php echo ($index == 'waroom'  ? 'active' : ''); ?>">
            <a href="<?php echo site_url('/admin/warRoom'); ?>">
              <i class="fa fa-hospital-o"></i><span>War-Room</span> 
            </a>
          </li>

         


      <?php } else {
        $userPermittedMenuData = $this->session->userdata('userPermission');
      ?>
        <?php if(in_array(1, $userPermittedMenuData)){ ?>
          <li class="treeview <?php echo ($index =='index'  ? 'active' : ''); ?>">
            <a href="<?php echo site_url('/admin/dashboard/index'); ?>">
              <i class="fa fa-dashboard"></i> <span>KMC V2 Dashboard</span>
            </a>
          </li>
        <?php } ?>


        <?php if(in_array(2, $userPermittedMenuData)){ ?>
          <li class="treeview <?php echo (($index=='LoginHistory') || ($index=='facilities')? 'active' : ''); ?>">
            <a href="<?php echo site_url('/facility/manageFacility'); ?>">
              <i class="fa fa-handshake-o"></i> <span>Facilities
            </a>
          </li>
        <?php } ?>

        <?php if(in_array(3, $userPermittedMenuData)){ ?>
          <li class="treeview <?php echo ( ($index=='LoungeLoginHistory') || ($index=='lounge')? 'active' : ''); ?>">
            <a href="<?php echo site_url('/loungeM/manageLounge'); ?>">
              <i class="fa fa-home"></i> <span>Lounges
            </a>
          </li>
        <?php } ?>

        <?php if(in_array(4, $userPermittedMenuData)){ ?>
          <li class="treeview <?php echo (($index == 'staff')? 'active' : ''); ?>">
            <a href="<?php echo site_url('/staffM/manageStaff'); ?>">
              <i class="fa fa-user"></i> <span>Staff
            </a>
          </li>
        <?php } ?>

        <?php if(in_array(5, $userPermittedMenuData)){ ?>
          <li class="<?php echo (($index2=='reg_mother') ? 'active' : ''); ?>">
            <a href="<?php echo site_url('/motherM/mothersViaLounge'); ?>">
              <i class="fa fa-female" aria-hidden="true"></i> 
              <span>Mothers
            </a>
          </li>
        <?php } ?>

        <?php if(in_array(6, $userPermittedMenuData)){ ?>
          <li class="<?php echo (($index=='Baby') ? 'active' : ''); ?>">
            <a href="<?php echo site_url('/babyM/babysViaLounge'); ?>">
              <i class="fa fa-child" aria-hidden="true"></i> 
              <span>Babies
            </a>
          </li>
        <?php } ?>

        <?php if(in_array(7, $userPermittedMenuData)){ ?>
          <li class="treeview <?php echo (($index=='manageNBCU') || ($index=='MenuGroup') || ($index=='managementType') || ($index=='Sitemap') || ($index=='StaffType') || ($index=='FacilityType') || ($index=='manageTemplate') ? 'active' : ''); ?>">
            <a href="#"><i class="fa fa-microchip"></i> <span>Miscellaneous</span>
              <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
            </a>
            <ul class="treeview-menu">
              <?php if(in_array(8, $userPermittedMenuData)){ ?>
                <li class="treeview <?php echo (($index=='manageNBCU') ? 'active' : ''); ?>"><a href="<?php echo site_url('/Miscellaneous/manageNBCU'); ?>"><i class="fa fa-circle-o" aria-hidden="true"></i><span>New born Care Unit Type</span></a></li>
              <?php } ?>

              <?php if(in_array(9, $userPermittedMenuData)){ ?>
                <li class="treeview <?php echo (($index=='managementType') ? 'active' : ''); ?>"><a href="<?php echo site_url('/Miscellaneous/managementType'); ?>"><i class="fa fa fa-circle-o"></i><span>Management Type</span></a></li>
              <?php } ?>   

              <?php if(in_array(10, $userPermittedMenuData)){ ?>  
                <li class="treeview <?php echo (($index=='FacilityType') ? 'active' : ''); ?>"><a href="<?php echo site_url('/facility/facilityType/'); ?>"><i class="fa fa fa-circle-o"></i><span>Facility Type</span></a></li>  
              <?php } ?>

              <?php if(in_array(11, $userPermittedMenuData)){ ?>
              <li class="treeview <?php echo (($index=='StaffType') ? 'active' : ''); ?>"><a href="<?php echo base_url('staffM/staffType/');?>"><i class="fa fa fa-circle-o"></i><span>Staff Type</span></a></li> 
              <?php } ?>

              


            </ul>       
          </li>
        <?php } ?>

      <?php }  ?>
    </ul>
    <div style="position: static;bottom: 0;width:100%;">
      <img src="<?php echo base_url().'assets/logo.png';?>" style="background-color: white; width:230px;">
    </div>
</section>