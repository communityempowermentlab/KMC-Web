<section class="sidebar">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<ul class="sidebar-menu" >
  <?php $adminData = $this->session->userdata('adminData');  ?>
	<!-- sidebar menu: : style can be found in sidebar.less -->
  <?php if($adminData['Type']==1){?>
  <li class="treeview <?php echo ($index =='index'  ? 'active' : ''); ?>">
    <a href="<?php echo site_url('/admin/dashboard/index'); ?>">
      <i class="fa fa-dashboard"></i> <span>Dashboard</span>  <?php #echo DASHBOARD ?>
    </a>
  </li>

  <li class="treeview <?php echo (($index=='LoginHistory') || ($index=='facilities')? 'active' : ''); ?>">
    <a href="<?php echo site_url('/facility/manageFacility'); ?>">
      <i class="fa fa-handshake-o"></i> <span>Manage Facilities <?php #echo FACILITIES ?></span> 
    </a>
  </li>


  <li class="<?php echo (($index=='LoungeLoginHistory') || ($index=='lounge')? 'active' : ''); ?>">
    <a href="<?php echo site_url('/loungeM/manageLounge'); ?>">
      <i class="fa fa-home" aria-hidden="true"></i> 
      <span>Manage Lounges<?php #echo MANAGE_LOUNGE ?></span> 
    </a>
  </li>
  <li class="treeview <?php echo (($index=='Mother') || ($index=='MotherAssessment') || ($index=='ViewMother')? 'active' : ''); ?>">

    <a href="#"><i class="fa fa-female"></i> <span>Manage Mothers</span>
       <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
    </a>
    <ul class="treeview-menu">

      <li class="treeview <?php echo ($index == 'MotherAssessment'  ? 'active' : ''); ?>"><a href="<?php echo site_url('/motherM/mothersViaLounge'); ?>"><i class="fa fa-circle-o" aria-hidden="true"></i><span>Display All Lounges</span></a></li> 
          
      <li class="treeview <?php echo (($index=='Mother') || ($index=='ViewMother')? 'active' : ''); ?>"><a href="<?php echo site_url('/motherM/registeredMother'); ?>"> <i class="fa fa-circle-o" aria-hidden="true"></i><span>Registered  Mothers<?php #echo MANAGE_LOUNGE ?></span></a> </li> 
      <li class="treeview <?php echo ($index == 'MotherAssessment'  ? 'active' : ''); ?>"><a href="<?php echo site_url('/motherM/motherAssessment'); ?>"><i class="fa fa-circle-o" aria-hidden="true"></i><span>Mothers Assessment<?php #echo MANAGE_LOUNGE ?></span></a></li>      
    </ul>       
  </li>
<li class="treeview <?php echo (($index=='Baby') || ($index=='BabyAssessment')? 'active' : ''); ?>">
                                <a href="#"><i class="fa fa-child"></i> <span>Manage Babies</span>
                                   <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
                                </a>
                              <ul class="treeview-menu">
                                    <li class="treeview <?php echo (($index=='Baby') || ($index=='Baby')? 'active' : ''); ?>"><a href="<?php echo site_url('/babyM/registeredBaby'); ?>"><i class="fa fa-child" style="font-size:20px"></i><span>Registered Babies<?php #echo MANAGE_LOUNGE ?></span></a></li> 
                                   <li class="treeview <?php echo (($index=='BabyAssessment') || ($index=='BabyAssessment')? 'active' : ''); ?>"><a href="<?php echo site_url('/babyM/babyAssessment/'); ?>"><i class="fa fa-child" style="font-size:20px"></i><span>Babies Assessment<?php #echo MANAGE_LOUNGE ?></span></a></li>      
                              </ul>       
  </li> 
  <li class="treeview <?php echo ($index == 'staff'  ? 'active' : ''); ?>">
    <a href="<?php echo site_url('/staffM/manageStaff'); ?>">
      <i class="fa fa-user"></i> <span>Manage Staff</span> 
    </a>
  </li>

  <li class="treeview <?php echo ($index == 'report'  ? 'active' : ''); ?>">
    <a href="<?php echo site_url('Admin/statisticsReport'); ?>">
      <i class="fa fa-file-text-o"></i> <span>Report</span> 
    </a>
  </li>

  <li class="treeview <?php echo ($index == 'manageVideo'  ? 'active' : ''); ?>">
    <a href="<?php echo site_url('/videoM/manageVideo'); ?>">
      <i class="glyphicon glyphicon-film"></i> <span>Manage Videos<?php #echo MANAGE_LOUNGE ?></span> 
    </a>
  </li>
  <li class="treeview <?php echo ($index == 'SentSms'  ? 'active' : ''); ?>">
    <a href="<?php echo site_url('/smsM/sentSms'); ?>">
      <span class="glyphicon glyphicon-envelope"></span><span>Sent SMS<?php #echo MANAGE_LOUNGE ?></span>
       <span class="pull-right-container">
              <span class="label label-success pull-right"><?php echo $coun1['smsmaster']; ?></span>
      </span> 
    </a>
  </li>
   <li class="treeview <?php echo ($index == 'NotificationCenter'  ? 'active' : ''); ?>">
    <a href="<?php echo site_url('/smsM/notificationCenter'); ?>">
      <i class="fa fa-bell-o"></i><span>Notification Center<?php #echo MANAGE_LOUNGE ?></span>
      <span class="pull-right-container">
              <span class="label label-warning pull-right"><?php echo $count['notification']; ?></span>
      </span> 
    </a>
  </li>
  <li class="treeview <?php echo ($index == 'suppliment'  ? 'active' : ''); ?>">
    <a href="<?php echo site_url('/supplimentM/manageSupplement'); ?>">
      <i class="fa fa-plus-square"></i><span>Manage Supplements<?php #echo MANAGE_LOUNGE ?></span> 
    </a>
  </li>
  <li class="treeview <?php echo ($index == 'Settings'  ? 'active' : ''); ?>">
    <a href="<?php echo site_url('/admin/Settings'); ?>">
      <i class="fa fa-cog"></i><span>Manage Settings<?php #echo MANAGE_LOUNGE ?></span> 
    </a>
  </li>
  
  <li class="treeview <?php echo ($index == 'waroom'  ? 'active' : ''); ?>">
    <a href="<?php echo site_url('/admin/warroom'); ?>">
      <i class="fa fa-hospital-o"></i><span>Manage War-Room<?php #echo MANAGE_LOUNGE ?></span> 
    </a>
  </li>

  <li class="treeview">
   <img src="<?php echo base_url().'assets/logo_white.png';?>" style="background-color: white; width:230px;height:100px;">

  </li>

  
<?php } else { ?>
   <li class="treeview <?php echo ($index =='index'  ? 'active' : ''); ?>">
       <a href="<?php echo site_url('/admin/dashboard/index'); ?>">
       <i class="fa fa-dashboard"></i> <span>Dashboard</span>  <?php #echo DASHBOARD ?>
       </a>
   </li>

  <li class="treeview <?php echo (($index=='Mother') || ($index=='MotherAssessment') || ($index=='ViewMother')? 'active' : ''); ?>">

                                <a href="#"><i class="fa fa-female"></i> <span>Manage Mothers</span>
                                   <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
                                </a>
                              <ul class="treeview-menu">
                                   <li class="treeview <?php echo (($index=='Mother') || ($index=='ViewMother')? 'active' : ''); ?>"><a href="<?php echo site_url('/motherM/registeredMother'); ?>"> <i class="fa fa-circle-o" aria-hidden="true"></i><span>Registered  Mothers<?php #echo MANAGE_LOUNGE ?></span></a> </li> 
                                   <li class="treeview <?php echo ($index == 'MotherAssessment'  ? 'active' : ''); ?>"><a href="<?php echo site_url('/motherM/motherAssessment'); ?>"><i class="fa fa-circle-o" aria-hidden="true"></i><span>Mothers Assessment<?php #echo MANAGE_LOUNGE ?></span></a></li>      
                              </ul>       
</li>
<li class="treeview <?php echo (($index=='Baby') || ($index=='BabyAssessment')? 'active' : ''); ?>">
                                <a href="#"><i class="fa fa-child"></i> <span>Manage Babies</span>
                                   <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
                                </a>
                              <ul class="treeview-menu">
                                    <li class="treeview <?php echo (($index=='Baby') || ($index=='Baby')? 'active' : ''); ?>"><a href="<?php echo site_url('/babyM/registeredBaby'); ?>"><i class="fa fa-child" style="font-size:20px"></i><span>Registered Babies<?php #echo MANAGE_LOUNGE ?></span></a></li> 
                                   <li class="treeview <?php echo (($index=='BabyAssessment') || ($index=='BabyAssessment')? 'active' : ''); ?>"><a href="<?php echo site_url('/babyM/babyAssessment/'); ?>"><i class="fa fa-child" style="font-size:20px"></i><span>Babies Assessment<?php #echo MANAGE_LOUNGE ?></span></a></li>      
                              </ul>       
</li> 
  <li class="treeview <?php echo ($index == 'SentSms'  ? 'active' : ''); ?>">
    <a href="<?php echo site_url('/smsM/sentSms'); ?>">
      <span class="glyphicon glyphicon-envelope"></span><span>Sent SMS<?php #echo MANAGE_LOUNGE ?></span>
       <span class="pull-right-container">
              <span class="label label-success pull-right"><?php echo $coun1['smsmaster']; ?></span>
      </span> 
    </a>
  </li>
   <li class="treeview <?php echo ($index == 'NotificationCenter'  ? 'active' : ''); ?>">
    <a href="<?php echo site_url('/smsM/notificationCenter'); ?>">
      <i class="fa fa-bell-o"></i><span>Notification Center<?php #echo MANAGE_LOUNGE ?></span>
      <span class="pull-right-container">
              <span class="label label-warning pull-right"><?php echo $count['notification']; ?></span>
      </span> 
    </a>
  </li>
  <li class="treeview <?php echo ($index == 'staff'  ? 'active' : ''); ?>">
    <a href="<?php echo site_url('/staffM/manageStaff'); ?>">
     <i class="fa fa-user"></i><span>Registered Staff<?php #echo MANAGE_LOUNGE ?></span> 
    </a>
  </li>
<?php } ?>

</ul>
</section>