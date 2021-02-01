<?php defined('BASEPATH') OR exit('No direct script access allowed');
$adminData = $this->session->userdata('adminData');  
 if(!isset($adminData['is_logged_in']) && $adminData['is_logged_in']!=true)
    {   redirect('admin/');    }   ?>
<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title; ?></title>
 
  
  
  <link rel="shortcut icon" href="<?php echo base_url('/assets/kmc.png');?>" type="image/x-icon">  
  <link rel="icon" href="<?php echo base_url('assets/images/favicon-32x32.png');?>" type="image/x-icon">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->

  
  
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url('assets/images/android-icon-36x36.png'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/admin/css/bootstrap.min.css'); ?>">


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/dist/css/AdminLTE.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/dist/css/skins/_all-skins.min.css'); ?>">
  

  <script src="<?php echo base_url('assets/admin/plugins/chartjs/Chart.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/admin/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/admin/js/bootstrap.min.js'); ?>"></script>
  <script src="<?php echo base_url(); ?>assets/admin/plugins/fastclick/fastclick.js"></script>
  <script src="<?php echo base_url(); ?>assets/admin/dist/js/app.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/admin/dist/js/demo.js"></script>

 <style>
 	#country-list{float:left;list-style:none;margin-top:-3px;padding:0;width:97%;z-index: 99999999;position: absolute;}
	#country-list li{padding: 10px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;width:100%;}
	#country-list li:hover{background:#ece3d2;cursor: pointer;}
/*#search-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}*/

li {

  z-index: 99999999;
  list-style: none;
  display: list-item;
 }
 .example {
  overflow-wrap: break-word;
}
.navbar-nav>.notifications-menu>.dropdown-menu>li .menu>li>a, .navbar-nav>.messages-menu>.dropdown-menu>li .menu>li>a, .navbar-nav>.tasks-menu>.dropdown-menu>li .menu>li>a{white-space: normal !important;}
 </style>
</head>

<body class="skin-blue sidebar-mini wysihtml5-supported">
<div class="wrapper">

  	<header class="main-header" style="position: fixed;top:0;right:0;width: 100%;">
	    <!-- Logo -->
	    <a href="<?php echo base_url('/admin/Dashboard/index'); ?>" class="logo">
	      <!-- mini logo for sidebar mini 50x50 pixels -->
	    
	      	<span class="logo-mini"><b>K</b>M<b>C</b></span>
	      	<span class="logo-lg"> <b><?php echo PROJECT_NAME; ?></b></span>
	    </a>
	    <!-- Header Navbar: style can be found in header.less -->
	    <nav class="navbar navbar-static-top" role="navigation">
	      <!-- Sidebar toggle button-->
        <button href="#" value='1' onclick="setWidth(this.value)" id="setiingID" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
        </button>
    	<?php if($adminData['Type'] == 3) { ?>
    	<a href="#"  style="font-size: 25px;line-height: 50px;text-align: center;font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;padding: 0 15px;font-weight: 250;color: #fff;"><span class="logo-mini" >
    		<?php echo  ucwords($this->School_model->GetSchoolName($adminData['Id']));
          
        ?>
    	</span></a><?php }
      $GetAdminInfo=$this->load->FacilityModel->GetAdminInfo();
       $count  = $this->load->FacilityModel->CountNotification($GetAdminInfo['notificationTime']);
       $coun1  = $this->load->FacilityModel->CountSMS($GetAdminInfo['smsTime']);
       $Notification  = $this->load->FacilityModel->GetlatestNotification();
       $SMS  = $this->load->FacilityModel->GetlatestSms(); 
      
       ?>	   
	      <div class="navbar-custom-menu">
	        <ul class="nav navbar-nav">
	          	  <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success"><?php echo $coun1['smsmaster']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <?php echo $coun1['smsmaster']; ?> unread messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <?php 
                  foreach ($SMS as $key => $value) {
                    $GetFacilittyName = $this->FacilityModel->GetFacilityName($value['FacilityID']);
                    $BabyDetail = $this->FacilityModel->getBabyById($value['BabyID']);
                  ?>
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        
                        <img src="<?php echo base_url();?>assets/images/baby_images/<?php echo $BabyDetail['BabyPhoto']?>" class="img-circle" alt="User Image" style="width:60px;height:60px;">
                      </div>
                      <h4>
                        <?php echo $GetFacilittyName['FacilityName'];?>
                       
                      </h4>
                      <p class="example">
                        <?php  $string1=$value['Messege'];?>
                        <?php echo $string2 = substr($string1, 0, 68); ?>&nbsp;...
                        <br>
                        <small style="margin-left:0px;"> <img src="<?php echo base_url();?>assets/images/Child-Dashboard.png" style="width:15px;height:15px;"></i>&nbsp;
                       <?php 
                        $time_ago=date("Y-m-d H:i:s",$value['AddDate']);
                              $time_ago = strtotime($time_ago);
                              $cur_time   = time();
                              $time_elapsed   = $cur_time - $time_ago;
                              $seconds    = $time_elapsed ;
                              $minutes    = round($time_elapsed / 60 );
                              $hours      = round($time_elapsed / 3600);
                              $days       = round($time_elapsed / 86400 );
                              $weeks      = round($time_elapsed / 604800);
                              $months     = round($time_elapsed / 2600640 );
                              $years      = round($time_elapsed / 31207680 );
                           // Seconds
                         if($seconds <= 60){
                           echo "just now";
                          }
                           //Minutes
                         else if($minutes <=60){
                           if($minutes==1){
                            echo "one minute ago";
                          }
                        else{
                          echo "$minutes minutes ago";
                         }
                        }
                         //Hours
                        else if($hours <=24){
                         if($hours==1){
                         echo "1 hour ago";
                        }else{
                         echo "$hours hrs ago";
                         }
                        }
                         //Days
                        else if($days <= 7){
                         if($days==1){
                          echo "yesterday";
                         }else{
                          echo "$days days ago";
                        }
                       }
                         //Weeks
                        else if($weeks <= 4.3){
                         if($weeks==1){
                          echo "a week ago";
                        }else{
                         echo "$weeks weeks ago";
                        }
                       }
                      //Months
                     else if($months <=12){
                      if($months==1){
                        echo "a month ago";
                      }else{
                         echo "$months months ago";
                       }
                      }
                          //Years
                     else{
                        if($years==1){
                        echo "one year ago";
                       }else{
                       echo "$years years ago";
                      }
                    }     
                  ?>
                </small>

                      </p>
                      
                    </a>
                  </li>
                <?php } ?>
                </ul>
              </li>
              <li class="footer"><a href="<?php echo base_url('smsM/loungeWiseSMS');?>">See All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"><?php echo $count['notification']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <?php echo $count['notification']; ?> unread notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <?php foreach ($Notification as $key => $value) {?>
                    <li>
                      <a href="#">
                        <?php if($value['TypeOfNotification']=='1'){?>
                           <img src="<?php echo base_url();?>assets/images/Mother-Dashboard.png" style="width:20px;height:20px;">
                        <?php } else if($value['TypeOfNotification']=='2'){ ?>
                            <img src="<?php echo base_url();?>assets/images/Child-Dashboard.png" style="width:20px;height:20px;">
                        <?php } else {?>
                            <img src="<?php echo base_url();?>assets/images/Lounge-Dashboard.png" style="width:20px;height:20px;">
                        <?php } ?>

                        <?php echo $value['Messege']; ?>
                      </a>
                   </li>
                    <?php  } ?> 
                </ul>
              </li>
              <li class="footer"><a href="<?php echo base_url('smsM/loungeWiseNotification');?>">View all</a></li>
            </ul>
          </li>
	          	<li class="dropdown user user-menu">
		            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
		            	<?php 
		            		$image = (!empty($adminData['Picture']) ? 'assets/profile_image/'.$adminData['Picture'] : 'assets/school1.png');
		            	?>
		              <img src="<?php echo base_url('assets/logo_white.png'); ?>" class="user-image" alt="User Image" style="background-color: white;">
		              <span class="hidden-xs"><?php echo $adminData['Name']; ?></span>
		            </a>
		            <ul class="dropdown-menu">
		              <!-- User image -->
		              <li class="user-header">
		                <img src="<?php echo base_url('assets/logo_white.png'); ?>" class="img-responsive" style="background-color: white; width:400px;height:125px;" alt="User Image">

		                <p>
		                  <small><?php echo $adminData['Name']; ?>
		                  (<?php echo $adminData['Email']; ?>)</small>
		                </p>
		              </li>
		              <!-- Menu Footer-->
		              <li class="user-footer">
                    <?php if($adminData['Type'] == 1) { ?>
                         <div class="pull-left">
                          <a href="<?php echo base_url('admin/changePassword');?>" class="btn btn-default btn-flat">Change Password</a>
                         </div>
                    <?php } ?>
		                 <div class="pull-right">
		                  <a href="<?php echo  base_url('Welcome/logout') ?>" class="btn btn-default btn-flat">Sign out</a>
		                </div>
		              </li>
		            </ul>
	          	</li>
	        </ul>
	      </div>
	    </nav>
  	</header>
  	<!-- Left side column. contains the logo and sidebar -->
  	<aside class="main-sidebar">
	    <!-- sidebar: style can be found in sidebar.less -->
	    <?php include('sidebar.php'); ?>
	    <!-- /.sidebar -->
  	</aside>


