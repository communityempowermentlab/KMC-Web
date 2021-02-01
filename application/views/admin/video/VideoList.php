<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
<link href="<?=base_url('twd-theme/videojs/video-js.css');?>" rel="stylesheet">
<script src="<?=base_url('twd-theme/videojs/video.js');?>"></script>
<link rel="stylesheet" href="<?=base_url('twd-theme/style.css');?>">

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'Manage Videos'; ?>
       <a href="<?php echo base_url('videoM/addVideo/');?>" class="btn btn-info" style="float: right; padding-right: 10px;">Add Video</a>
       <!-- <a href="<?php echo base_url('videoM/videoType/');?>" class="btn btn-success" style="float: right; padding-right: 10px; margin-right:15px;"> Manage video Type</a> -->
      </h1>
      
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
           <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
            <div id="MDG"></div>
              <span style="font-size: 20px;">Manage Resources:</span> [<a href="" data-toggle="modal" data-target="#dfdModal" style="color: #3c8dbc;">DataFlow Diagram</a>][<a href="" data-toggle="modal" data-target="#myModal" style="color: #3c8dbc;">Functional Diagram</a>]
            <div class="box-body">
              <div class="col-sm-12" style="overflow: auto;">
              <table cellpadding="0" cellspacing="0" border="0"
                class="table-striped table table-bordered editable-datatable example" id="" >
                <thead>
                <tr>
                  <th>S&nbsp;No.</th>
                  <th>Video&nbsp;Title</th> 
                  <th>Video&nbsp;Type</th> 
                  <!-- <th>Video&nbsp;Thumbnail</th>  -->
                  <th>Status</th> 
                  <th>Action</th> 
                  <th>Last&nbsp;Updated&nbsp;On</th> 
                </tr>
                </thead>
                <tbody>

                <?php 
                $counter ="1";
                foreach ($GetVideo as $value) {
                  $last_updated          = $this->FacilityModel->time_ago_in_php($value['modifyDate']);
                ?>
                <tr>
                  <td><?php  echo $counter; ?></td>
                  <td ><?php  echo $value['videoTitle']; ?></td>
                  <td>
                   <?php  
                   if($value['videoType']=='1'){
                      echo"Counselling";}
                   else if($value['videoType']=='2'){
                      echo"Learning";}
                     
                    ?>
                 </td>
                  
                  <td>
                    <?php if ($value['status'] == 1) { ?> 
                      <span class="label label-sm label-success">Activated
                      </span>
                    <?php } else { ?>
                      <span class="label label-sm label-warning">Deactivated 
                      </span>
                    <?php } ?>
                    </td>
                   <td><a href="<?php echo base_url(); ?>videoM/editVideo/<?php echo $value['id']; ?>" title="Edit Video Information" class="btn btn-info btn-sm">View/Edit</a></td> 
                   <td><a class="tooltip" href="javascript:void(0);" style="color: #72afd2;"><?php echo $last_updated; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['modifyDate'])) ?></span></a></td>
                </tr>
                  <?php $counter ++ ; } ?>
                </tbody>
               </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>


<!-- dfd and functional -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Manage Video Functional Diagram</h4>
        </div>
        <div class="modal-body text-center">
         <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/ManageVideos.png') ;?>" style="height:350px;width:100%;"> 
   
        </div>
      </div>
      
    </div>
  </div>

  <div class="modal fade" id="dfdModal" role="dialog">
    <div class="modal-dialog modal-lg" style="width:650px !important">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Manage Video DataFlow Diagram (DFD)</h4>
        </div>
        <div class="modal-body" style="padding:0px !important;">
         <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/manageVideo.png') ;?>" style="height:400px;width:100%;">

        </div>
      </div>
    </div>
  </div>

<script>

// $('.click_btn').on('click', function(){
//         var get_id = $(this).attr('id');
//         var s_id = $(this).attr('s_id');
//         var status = $(this).attr('status');
//         var table = 'counsellingMaster';
//         var s_url = '<?php echo base_url('facility/changeStatus'); ?>';
//         if(status == '1'){
//             var text = 'Deactivate';     
//         } else {
//             var text = 'Activate';    
//         }
//         var r =  confirm("Are you sure! You want to "+text+" this Video?");
//        // alert(status);
//         var image;
//         if (r) {
//             $.ajax({
//                 data: {'table': table, 'id': s_id,'tbl_id':'id'},
//                 url: s_url,
//                 type: 'post',
//                 success: function(data){
//                     if (data == 1) {
//                          image = '<a href="#" class="btn btn-success btn-sm">Activated</a>';
//                         $('#'+get_id).html(image);
//                         $('#MDG').css('color', 'green').html('<div class="alert alert-success">Activated successfully.</div>').show();
//                             if (status == '1') {
//                             $('#'+get_id).attr('status', '0');
//                           } else {
//                             $('#'+get_id).attr('status', '1');
//                           }
//                           setTimeout(function() { $("#MDG").hide(); }, 2000);
//                     } else if (data == 2) {
//                       image = '<a href="#" class="btn btn-warning btn-sm">Deactivated</a>';
//                         $('#'+get_id).html(image);
//                           $('#MDG').css('color', 'red').html('<div class="alert alert-success">Deactivated successfully.</div>').show();
//                          if (status == '0') {
//                             $('#'+get_id).attr('status', '1');
//                           } else {
//                             $('#'+get_id).attr('status', '0');
//                           }
//                         setTimeout(function() { $("#MDG").hide(); }, 2000);
//                     }

//                 }
//             });
//         }

// });



</script>
