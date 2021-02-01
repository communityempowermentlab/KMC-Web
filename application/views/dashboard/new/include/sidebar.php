<script type="text/javascript">
  function setWidth(custumVal) {
    if(custumVal == '1'){
     var id = $('#setiingID').val('2');     
     $('#style-1').addClass('setWidthSiderbar');     
    }else{
     var id = $('#setiingID').val('1');     
     $('#style-1').removeClass('setWidthSiderbar'); 
    }
  }
</script>
<style type="text/css">
  .scrollbar {
    background-color: #F5F5F5 !important;
    height: 670px !important;
    overflow-y: scroll !important;
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
</style>
<section class="sidebar scrollbar" id="style-1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <ul class="sidebar-menu" style="width:230px;">
      <?php $adminData = $this->session->userdata('adminData');
        if($adminData['Type'] == 1) { ?>
          <li class="treeview <?php echo ($index =='index'  ? 'active' : ''); ?>">
            <a href="<?php echo site_url('/admin/wecomeDashboard'); ?>">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
          </li>

          <li class="treeview <?php echo (($index=='LoginHistory') || ($index=='facilities')? 'active' : ''); ?>">
            <a href="#">
              <i class="fa fa-handshake-o"></i> <span>Manage Facilities
            </a>
          </li>

          <li class="<?php echo (($index=='LoungeLoginHistory') || ($index=='lounge')? 'active' : ''); ?>">
            <a href="#">
              <i class="fa fa-home" aria-hidden="true"></i> 
              <span>Manage Lounges
            </a>
          </li>

           <li class="treeview <?php echo (($index=='Mother') || ($index=='MotherAssessment') || ($index=='ViewMother')? 'active' : ''); ?>">
            <a href="#"><i class="fa fa-female"></i> <span>Manage Mothers</span>
              <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
            </a>
            <ul class="treeview-menu">
              <li class="treeview <?php echo ($index2 == 'reg_mother' ? 'active' : ''); ?>">
                <a href="#">
                  <i class="fa fa-circle-o" aria-hidden="true"></i>
                  <span>Registered  Mothers</span>
                </a>
              </li> 

              <li class="treeview <?php echo ($index2 == 'motherMonitoring'  ? 'active' : ''); ?>"><a href="#"><i class="fa fa-circle-o" aria-hidden="true"></i><span>Mothers Assessment</span></a></li>
            </ul>       
          </li>

          <li class="treeview <?php echo (($index=='Baby') || ($index=='BabyAssessment')? 'active' : ''); ?>">
            <a href="#"><i class="fa fa-child"></i> <span>Manage Babies</span>
              <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
            </a>
            <ul class="treeview-menu">
              <li class="treeview <?php echo (($index=='Baby') || ($index=='Baby')? 'active' : ''); ?>"><a href="#"><i class="fa fa-circle-o" aria-hidden="true"></i><span>Registered Babies</span></a></li>
              <li class="treeview <?php echo (($index=='BabyAssessment') || ($index=='BabyAssessment')? 'active' : ''); ?>"><a href="#"><i class="fa fa-child" style="font-size:20px"></i><span>Babies Assessment</span></a></li>      
            </ul>       
          </li>  
<!-- 
        <li class="treeview <?php echo ($index == 'draft'  ? 'active' : ''); ?>">
            <a href="<?php echo site_url('/motherM/manageDraft'); ?>">
              <i class="fa fa-user"></i> <span>Manage Draft</span> 
            </a>
          </li> -->


<!--           <li class="treeview <?php echo (($index=='report') || ($index=='report1') ? 'active' : ''); ?>">
            <a href="#"><i class="fa fa-file-text-o"></i> <span>Manage Reports</span>
              <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
            </a>
            <ul class="treeview-menu">
              <li class="treeview <?php echo (($index=='report') ? 'active' : ''); ?>"><a href="<?php echo site_url('/Admin/report'); ?>"><i class="fa fa-circle-o" aria-hidden="true"></i><span>View Statistics</span></a></li>
              <li class="treeview <?php echo (($index=='report1') ? 'active' : ''); ?>"><a href="<?php echo site_url('/Admin/pdfReport'); ?>"><i class="fa fa fa-circle-o"></i><span>Download Reports</span></a></li>      
            </ul>       
          </li>

          <li class="treeview <?php echo ($index == 'staff'  ? 'active' : ''); ?>">
            <a href="<?php echo site_url('/staffM/manageStaff'); ?>">
              <i class="fa fa-user"></i> <span>Manage Staff</span> 
            </a>
          </li>

          <li class="treeview <?php echo ($index == 'manageVideo'  ? 'active' : ''); ?>">
            <a href="<?php echo site_url('/videoM/manageVideo'); ?>">
              <i class="glyphicon glyphicon-film"></i> <span>Manage Videos</span> 
            </a>
          </li>

          <li class="treeview <?php echo ($index == 'SentSms'  ? 'active' : ''); ?>">
            <a href="<?php echo site_url('/smsM/loungeWiseSMS'); ?>">
              <span class="glyphicon glyphicon-envelope"></span><span>Sent SMS</span>
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
              <i class="fa fa-hospital-o"></i><span>Manage Timeline</span> 
            </a>
          </li>

          <li class="treeview <?php echo ($index == 'suppliment'  ? 'active' : ''); ?>">
            <a href="<?php echo site_url('/supplimentM/manageSupplement'); ?>">
              <i class="fa fa-plus-square"></i><span>Manage Supplements</span> 
            </a>
          </li>

          <li class="treeview <?php echo ($index == 'Settings'  ? 'active' : ''); ?>">
            <a href="<?php echo site_url('/admin/Settings'); ?>">
              <i class="fa fa-cog"></i><span>Manage Settings</span> 
            </a>
          </li>
      
          <li class="treeview <?php echo ($index == 'waroom'  ? 'active' : ''); ?>">
            <a href="<?php echo site_url('/admin/warroom'); ?>">
              <i class="fa fa-hospital-o"></i><span>Manage War-Room</span> 
            </a>
          </li> 


      <?php }  ?>
    </ul>
  <!--   <ul class="sidebar-menu" >
      <li class="treeview">
      <img src="<?php echo base_url().'assets/logo_white.png';?>" style="background-color: white; width:230px;height:100px;">
      </li>
    </ul> -->
</section>