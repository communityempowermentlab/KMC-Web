<?php   $adminData = $this->session->userdata('adminData');  
   $QuickEmail = $this->load->FacilityModel->getQuickEmail(); ?>
<style type="text/css">
  .listitem{
    list-style-type: none;
    padding-left: 12px !important;
  }
</style>

<script type="text/javascript">
   $(document).ready(function(){
    GetLoungeWiseValue('all');

   });
</script>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li>
             <a href="http://trendytoday.in/kclounge_offline/Admin/Dashboard"> <span class="label" style="font-size: 13px;background-color:#3c8dbc;">Switch to KMC dashboard</span></a>
            </li>
            <li>
           <select name="LoungeName" onchange="GetLoungeWiseValue(this)" style="width:180px;height:25px !important;">
              <option value="all">Select All Lounges</option>
              <?php foreach ($totalLounges as $key => $value) { ?>
              <option value="<?php echo $value['loungeId']; ?>"><?php echo $value['loungeName']; ?></option>
            <?php } ?>
           </select>
         </li>
            <li><a href="<?php echo base_url() ?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>

          </ol>

        </section>

    <!-- Main content -->
    <section class="content">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <?php echo $this->session->flashdata('activate'); ?>
        <script type="text/javascript">
            $(document).ready(function(){     
            setTimeout(function(){
            $('#secc_msg').fadeOut(); 
            }, 10000);   
            $('.set_div_img2').on('click', function() {  
            $('#secc_msg').fadeOut();    
            });
            });
        </script>

      </div> 
<?php if($adminData['Type'] == 1){?>       
      <div class="row">
        <div id="dynamicDiv">
        </div>         
      </div>
  <?php } ?>
 </section>

  </div>
    </section>
  </div>

<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAxpNXGcquaqlg4PeuA1lqAU-tl4-KQ-xg&callback=initMap" type="text/javascript"></script>
<script src="https://static.anychart.com/js/8.0.1/anychart-core.min.js"></script>
<script src="https://static.anychart.com/js/8.0.1/anychart-pie.min.js"></script>
<script type="text/javascript">
  function GetLoungeWiseValue(data)
  { 
    if(data == 'all')
    { 
      var loungeId = data;
     $("#dynamicDiv").load('<?php echo base_url("Admin/getDashboardCharts"); ?>', {"loungeWiseValue": loungeId} );
    }else{ //alert("hell2");
      var loungeId =(data.value);
      $("#dynamicDiv").load('<?php echo base_url("Admin/getDashboardCharts"); ?>', {"loungeWiseValue": loungeId});
    }
     
  }
</script>
</body>
</html>
