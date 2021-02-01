<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <?php $adminData = $this->session->userdata('adminData');  ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
    </section>

     <?php if($adminData['Type']==1){?>
     <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $this->user_model->TotalGetCategorie()?></h3>

              <p>Total Categories</p>
            </div>
            <div class="icon">
              <i class="ion-android-list"></i>
            </div>
            <a href="<?php echo site_url('admin/Dashboard/Category');?>" class="small-box-footer">View Categories <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $this->user_model->TotalGetBrand()?></h3>

              <p>Total Brands</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo site_url('admin/Dashboard/BrandList');?>" class="small-box-footer">View Brand <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $this->user_model->TotalGetBanners() ?></h3>

              <p>Total Banners</p>
            </div>
            <div class="icon">
              <i class="ion ion-image"></i>
            </div>
            <a href="<?php echo site_url('admin/Dashboard/BannerList');?>" class="small-box-footer">View Banners <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $this->user_model->TotalGetUsers() ?></h3>

              <p>Total Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-people"></i>
            </div>
            <a href="<?php echo site_url('admin/Users/');?>" class="small-box-footer">View Users <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
         <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3><?php echo $this->user_model->TotalGetVendors() ?></h3>

              <p>Total Vendors</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="<?php echo site_url('admin/Vendor/');?>" class="small-box-footer">View Vendors <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $this->user_model->TotalGetProducts() ?></h3>

              <p>Total Product</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="<?php echo site_url('admin/Product/');?>" class="small-box-footer">View Products <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

      </section>
     <?php }?>
     <?php if($adminData['Type']==2){ ?>
     <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $this->user_model->TotalGetVendorProduct($adminData['Id'])?></h3>

               <p>Total Product</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="<?php echo site_url('admin/Product/');?>" class="small-box-footer">View Products <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

      </section>

      <?php } ?>

  </div>
 <script src="<?php echo base_url()?>assets/admin/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php  echo base_url()?>assets/admin/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->




<?php /*

*/ ?>