<?php
  $loungeId      = $this->uri->segment('3');
  $GetFacility   = $this->FacilityModel->GetFacilitiesID($loungeId);
?>

<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'Sent SMS'; ?> (<?php echo $GetFacility['loungeName']; ?>) </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
           <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
            <div class="row" style="padding-right: 25px; padding-left: 25px;margin-top: 5px;">
            <div class="col-md-6">
             <span style="font-size: 20px;">Manage Resources:</span> [<a href="" data-toggle="modal" data-target="#dfdModal">DataFlow Diagram</a>][<a href="" data-toggle="modal" data-target="#myModal">Functional Diagram</a>]
                <?php if(isset($totalResult)) { 
                    ($pageNo == '1') ?  $counter = '1' : $counter = ((($pageNo*100)-100) + 1);
                    echo '<br>Showing '.$counter.' to '.((($pageNo*100)-100) + 100).' of '.$totalResult.' entries';
                 } ?>
             </div> 
             <div class="col-md-6">
                <form action="" method="GET">
                    <div class="input-group pull-right">
                        <input type="text" class="form-control" placeholder="Enter Keyword Value" 
                               name="keyword" value="<?php
                               if (!empty($_GET['keyword'])) {
                                   echo $_GET['keyword'];
                               }
                               ?>">

                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                        </span>

                    </div>
                     <br><span style="font-size:12px;">Search via: Mother Name, Message etc.</span>
                </form>
             </div>
            </div>   
            <div class="box-body">
              <div class="col-sm-12" style="overflow: auto;">
              <table class="table-striped table table-bordered editable-datatable" id="example" >
                <thead>
                <tr>
                  <th>S&nbsp;No.</th>
                  <th>Baby&nbsp;Photo</th>
                  <th>Baby&nbsp;Of</th>
                  <th>Doctor&nbsp;Name</th>
                  <th>Message</th>
                  <th>Sent&nbsp;Time</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                ($pageNo == '1') ? $counter = '1' : $counter = ((($pageNo*100)-100) + 1);
                foreach ($results as $value) {
                  $GetFacilittyName = $this->SmsModel->GetFacilityName($value['facilityId']);
                  $BabyDetail = $this->SmsModel->getBabyById($value['babyId']);
                  $MotherName = $this->load->SmsModel->getMotherDataById('motherRegistration',$BabyDetail['motherId']);
                  $this->db->order_by('id','desc');
                  $getMotherAdmId = $this->db->get_where('motherAdmission',array('motherId'=>$MotherName['motherId']))->row_array();
                  $doctorName = $this->load->SmsModel->getDoctorByMobile($value['sendTo']);
                  ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><img  src="<?php echo base_url();?>assets/images/baby_images/<?php echo $BabyDetail['babyPhoto']?>" class="img-responsive" style="width:70px;height:70px;"></td>
                  <td><a href="<?php echo base_url();?>motherM/viewMother/<?php echo $getMotherAdmId['id'];  ?>"><?php echo $MotherName['motherName'];?></td>
                  <!-- <td><a href="<?php echo base_url();?>facility/updateFacility/<?php echo $value['facilityId'];?>"><?php echo $GetFacilittyName['FacilityName'] ;?></a></td> -->
                  <td><a href="<?php echo base_url();?>staffM/updateStaff/<?php echo $doctorName['staffId'];?>"><?php echo $doctorName['name'] ;?></a><br/><?php echo $value['sendTo'] ;?></td>
                  <td><?php echo $value['message'] ;?></td> 
                  <td>
                    <?php echo  $time_ago=date("d-m-Y g:i A", strtotime($value['addDate']));?><br/>
                    <span class="label label-success">Delivered</span>
                  </td> 
                </tr>
                  <?php  $counter ++ ; } ?>
                </tbody>
               </table>
                   <ul class="pagination pull-right">
                    <?php
                      foreach ($links as $link) {
                          echo "<li>" . $link . "</li>";
                      }
                     ?>
                  </ul>
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

<script>
function Verfiy_Video(id,status) {
     var Vid= id;
     var url = "<?php echo site_url('admin/Dashboard/BannerStatus');?>/"+id;
    if(status == 1){  var r =  confirm("Are you sure! You want to Deactivate this Lounge ?");}
    if(status == 2){  var r =  confirm("Are you sure! You want to Activate this Lounge ?");}
    if (r == true) {
    $.ajax({ 
      type: "POST", 
      url: url, 
      dataType: "text", 
      success:function(response){
        console.log(response);
        if(response == 1){ $('.status_img_'+id).attr('src','<?php echo base_url("assets/act.png")?>');} 
        if(response == 2){ $('.status_img_'+id).attr('src','<?php echo base_url("assets/delete.png")?>');}
        //console.log(response);
      }
    });
    }
  }
</script>
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md" style="width:700px !important">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Manage SMS Functional Diagram</h4>
        </div>
        <div class="modal-body text-center" >
                 
          <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/smsFunctional.png') ;?>" style="height:400px;width:100%;">  
        </div>
      </div>
      
    </div>
  </div>
  <div class="modal fade" id="dfdModal" role="dialog">
    <div class="modal-dialog modal-md" style="width:900px !important">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Manage SMS DataFlow Diagram (DFD)</h4>
        </div>
        <div class="modal-body text-center" style="padding:0px !important;">
         <!--  <h3> Comming Soon...</h3> -->
          <br>
           <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/manageSMSDfd.png') ;?>" style="height:700px;width:100%;">
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
      var fileName = $("#scriptFileName").val();
      $('#example').DataTable({
      dom: 'Brtip',
       "paging":   false,
      buttons: [
          
          {
              extend: 'pdf',
              title: fileName,
              exportOptions: {
                columns: ':visible'
              }
          },{
              extend: 'excel',
              title: fileName,
              exportOptions: {
                columns: ':visible'
              }
          },{
              extend: 'csv',
              title: fileName,
              exportOptions: {
                columns: ':visible'
              }
          },
          'colvis'
      ]
    });
  });            
</script>