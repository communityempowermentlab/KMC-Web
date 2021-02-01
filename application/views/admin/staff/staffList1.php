<?php $adminData = $this->session->userdata('adminData');?>
<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'Manage Staff'; ?>
      <?php if($adminData['Type']=='1'){?>
      <a href="<?php echo base_url('staffM/addStaff/');?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add Staff</a>
      <a href="<?php echo base_url('staffM/staffType/');?>" class="btn btn-success" style="float: right; padding-right: 10px; margin-right:15px  "> Manage Staff Type</a>
      <?php } ?>
      </h1>
      
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
           <div  id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
           <div id="MDG"></div>
             <span style="font-size: 20px;">Manage Resources:</span> [<a href="" data-toggle="modal" data-target="#dfdModal">DataFlow Diagram</a>][<a href="" data-toggle="modal" data-target="#myModal">Functional Diagram</a>]
            <div class="box-body">
             <div class="col-sm-12" style="overflow: auto;"> 
              <table cellpadding="0" cellspacing="0" border="0"
                class="table-striped table table-bordered editable-datatable example " id="example" >
                <thead>
                <tr>
                  <th>SrNo.</th>
                  <th>Facility</th>
                  <th>Staff&nbsp;Photo</th>
                  <th>Staff&nbsp;Name</th>
                  <th>Staff&nbsp;Type</th>
                  <th>Staff&nbsp;Job&nbsp;Type</th>
                  <th>Staff&nbsp;Mobile</th>
                  <th>Emergency&nbsp;Contact&nbsp;Number</th>
                  <th>Staff&nbsp;Points</th>
                  <th>Staff&nbsp;Address</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                $counter ="1";
                 /*echo "<pre>";
                print_r(  $GetLounge); exit;
*/
                foreach ($GetStaff as $value) {
                 $GetFacility = $this->UserModel->GetFacilitiesName2($value['StaffID']);
                 $GetStaffName = $this->UserModel->GetStaffName($value['StaffType']);
                 $GetStaffSubName = $this->UserModel->GetStaffSubName($value['staff_sub_type']);
                  //total nurse credited point
                  $TotalCreditNursePoint    = $this->db->query("SELECT SUM(Points) as creditPoint from pointstransactions where NurseId=".$value['StaffID']." and TransactionStatus='Credit'")->row_array();

                  //total nurse debited point
                  $TotalDebitNursePoint    = $this->db->query("SELECT SUM(Points) as debitPoint from pointstransactions where NurseId=".$value['StaffID']." and TransactionStatus='Debit'")->row_array();

                   $checkTrainingAppPoint  = $this->db->query("SELECT * from pointstransactions where NurseId=".$value['StaffID']." and Type='17'")->num_rows();
                 //  echo $this->db->last_query();exit;
                 // echo $checkTrainingAppPoint;exit;

                 ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><a href="<?php echo base_url();?>facility/updateFacility/<?php echo $GetFacility['FacilityID'];?>"><?php echo $GetFacility['FacilityName'];?></a></td>

                  <td style="width:70px;height:50px;">
                   <?php  if(empty($value['ProfilePic'])) { ?>
                               <img  src="<?php echo base_url();?>assets/nurse/default.png" style="height:100px;width:100px;margin-top:5px;">
                          <?php } else { ?>
                             <img  src="<?php echo base_url();?>assets/nurse/<?php echo $value['ProfilePic']?>" class="img-responsive">
                         <?php } ?>
                 </td>
                  <td><?php echo $value['Name'] ?></td>
                  <td><?php echo $GetStaffName['StaffTypeNameEnglish'];?>-<?php echo $GetStaffSubName['StaffTypeNameEnglish'];?>
                    
                  </td>
                  <td>
                    <?php $job_type=$value['job_type']; 
                       if($job_type=='10'){
                         echo"Permanent";
                       }else{
                          echo"Contractual";
                       }?>
                  </td>
                  <td><?php echo $value['StaffMoblieNo'] ?></td>
                  <td><?php echo $value['emergency_contact_number'] ?></td>
                  <td><?php $point = ($TotalCreditNursePoint['creditPoint'] - $TotalDebitNursePoint['debitPoint']);
                     if($point == '0'){
                      echo $point;
                      if($checkTrainingAppPoint > 0)
                      {
                        echo "<br><a href='".base_url()."staffM/traininAppHistory/".$value['StaffID']."' class='label label-success'>Training App Detail</a>";
                      }
                     }else { echo $point.'<br>';  ?>
                      <a href="<?php echo base_url();?>staffM/pointHistoryViaNurse/<?php echo $value['StaffID'];?>" class="label label-success">View Detail</a>
                     <?php  if($checkTrainingAppPoint > 0)
                             {
                       echo "<br><a href='".base_url()."staffM/traininAppHistory/".$value['StaffID']."' class='label label-success'>Training App Detail</a>";
                             }
                            } 
                          ?>
                       
                       
                    </td>
                  <td><?php echo $value['StaffAddress'] ?></td>
                  <td>
                         <?php if($value['status'] == 1){?>
                            <span class="click_btn change" id="id_<?php echo $value['StaffID'];?>" s_id="<?php echo $value['StaffID'];?>" status="1">
                               <a href="#" class="btn btn-success btn-sm">Activated</a> 
                            </span>
                                
                                
                          <?php } else { ?>
                                 <span class="click_btn change" id="id_<?php echo $value['StaffID'];?>" s_id="<?php echo $value['StaffID'];?>" status="2">
                                <a href="#" class="btn btn-warning btn-sm">Deactivated</a>   
                             </span> 
                                 
                          <?php } ?>
                  </td>
                  <td><a href="<?php echo base_url(); ?>staffM/updateStaff/<?php echo $value['StaffID']; ?>" title="Edit Staff Information" class="btn btn-info btn-sm">View/Edit</a></td>

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

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Manage Staff Functional Diagram</h4>
        </div>
        <div class="modal-body" >
         <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/ManageStaff.png') ;?>" style="height:720px;width:100%;"> 
        </div>
      </div>
      
    </div>
  </div>

  <div class="modal fade" id="dfdModal" role="dialog">
    <div class="modal-dialog modal-lg" style="width:900px !important">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Manage Staff DataFlow Diagram (DFD)</h4>
        </div>
        <div class="modal-body" style="padding:0px !important;">
          <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/ManageStaffDFD.png') ;?>" style="height:auto;width:100%;">
        </div>
      </div>
    </div>
  </div>

<script>

$('.click_btn').on('click', function(){
        var get_id = $(this).attr('id');
        var s_id = $(this).attr('s_id');
        var status = $(this).attr('status');
        var table = 'staff_master';
        var s_url = '<?php echo base_url('Admin/changeStatus2'); ?>';
        if(status == '1'){
            var text = 'Deactivate';     
        } else {
            var text = 'Activate';    
        }
        var r =  confirm("Are you sure! You want to "+text+" this Staff?");
       // alert(status);
        var image;
        if (r) {
            $.ajax({
                data: {'table': table, 'id': s_id,'tbl_id':'StaffID'},
                url: s_url,
                type: 'post',
                success: function(data){

                    if (data == 1) {
                        image = '<a href="#" class="btn btn-success btn-sm">Activated</a>';
                        $('#'+get_id).html(image);
                        $('#MDG').css('color', 'green').html('<div class="alert alert-success">Activated successfully.</div>').show();
                            if (status == '1') {
                            $('#'+get_id).attr('status', '0');
                          } else {
                            $('#'+get_id).attr('status', '1');
                          }
                          setTimeout(function() { $("#MDG").hide(); }, 2000);
                    } else if (data == 2) {
                      image = '<a href="#" class="btn btn-warning btn-sm">Deactivated</a>';
                        $('#'+get_id).html(image);
                          $('#MDG').css('color', 'red').html('<div class="alert alert-success">Deactivated successfully.</div>').show();
                         if (status == '0') {
                            $('#'+get_id).attr('status', '1');
                          } else {
                            $('#'+get_id).attr('status', '0');
                          }
                      setTimeout(function() { $("#MDG").hide(); }, 2000);
                    }
                }
            });
        }

    });
</script>
