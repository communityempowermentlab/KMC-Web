<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <?php $adminData = $this->session->userdata('adminData');  ?>
    <!-- Content Header (Page header) style="background-image: url('../../assets/logo_white.png');  -->
    <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>
    <section class= "content">
        <div class="row">
             <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                     <span class="info-box-text">Total Facilities</span>
                    <span class="info-box-number"><a href="<?php echo base_url('Admin/Facility'); ?>"><?php echo $counting['facility']; ?></a></span>
                  </div>
                 </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                     <span class="info-box-text">Total Lounges </span>
                    <span class="info-box-number"><a href="<?php echo base_url('Admin/Lounge'); ?>"><?php echo $counting['lounge']; ?></a></span>
                  </div>
                 </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                     <span class="info-box-text">Total Mothers</span>
                    <span class="info-box-number"><a href="<?php echo base_url('Admin/Mother'); ?>"><?php echo $counting['mother']; ?></a></span>
                  </div>
                 </div>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-blue"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                     <span class="info-box-text">Total Babys</span>
                    <span class="info-box-number"><a href="<?php echo base_url('Admin/Baby'); ?>"><?php echo $counting['baby']; ?></a></span>
                  </div>
                 </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                     <span class="info-box-text">Total Staffs</span>
                    <span class="info-box-number"><a href="<?php echo base_url('Admin/staff'); ?>"><?php echo $counting['staff']; ?></a></span>
                  </div>
                 </div>
              </div>
        </div>


    </section>

     <!--  -->


  </div>
 <script src="<?php echo base_url()?>assets/admin/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php  echo base_url()?>assets/admin/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>

