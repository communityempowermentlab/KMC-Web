<?php $adminData = $this->session->userdata('adminData');?>
<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?= $GetStaffData['name']; ?> Information Update History</h1>
      
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            
            <div class="col-xs-12" style="padding-bottom: 15px; padding-top: 15px;"><b>Staff Name: <a  href="<?php echo base_url();?>staffM/updateStaff/<?php echo $GetStaffData['staffId'];?>"><?= $GetStaffData['name']; ?></a></b></div>  
            
           <div  id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
              
            <div class="box-body">
             <div class="col-sm-12" style="overflow: auto;"> 
              <table class="table-striped table table-bordered example" id="example" data-page-length='25'>
                <thead>
                <tr>
                  <th>S&nbsp;No.</th>
                  <th>Staff&nbsp;Name</th>
                  
                  <th>Staff&nbsp;Photo</th>
                  <!-- <th>Staff&nbsp;Name</th> -->
                  <th>Staff&nbsp;Type</th>
                  <th>Staff&nbsp;Job&nbsp;Type</th>
                  <th>Staff&nbsp;Mobile&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                  <th>Emergency&nbsp;Number</th>
                  <th>Staff&nbsp;Address</th>
                  
                  <th>Status</th>
                  <th>Date&nbsp;&&nbsp;Time</th>
                  <th>Added&nbsp;By</th>
                  <th>IP&nbsp;Address</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                $counter = '1';
                if(!empty($GetLogHistory)) { 
                foreach ($GetLogHistory as $value) {
                  $GetStaffName          = $this->UserModel->GetStaffName($value['staffType']);
                  $GetStaffSubName       = $this->UserModel->GetStaffSubName($value['staffSubType']);
                  $addedBy = $this->load->FacilityModel->GetDataById('adminMaster',$value['addedBy']);
                 
                 ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><?php echo !empty($value['name']) ? $value['name'] : 'N/A'; ?></td>
                
                  
                  <td style="width:70px;height:50px;">
                    <?php  if(empty($value['profilePicture'])) { ?>
                      <img  src="<?php echo base_url();?>assets/nurse/default.png" style="height:100px;width:100px;margin-top:5px;">
                    <?php } else { ?>
                      <img  src="<?php echo base_url();?>assets/nurse/<?php echo $value['profilePicture']?>" class="img-responsive">
                    <?php } ?>
                 </td>
                  <!-- <td><?php echo !empty($value['Name']) ? $value['Name'] : 'N/A'; ?></td> -->
                  <td><?php echo $GetStaffName['staffTypeNameEnglish'];?>-<?php echo $GetStaffSubName['staffTypeNameEnglish'];?></td>
                  <td><?php echo ($value['jobType'] == '10') ? "Permanent" : "Contractual"; ?></td>
                  <td><?php echo !empty($value['staffMobileNumber']) ? $value['staffMobileNumber'] : 'N/A'; ?>
                  </td>
                  <td><?php echo !empty($value['emergencyContactNumber']) ? $value['emergencyContactNumber'] : 'N/A'; ?></td>
                  
                  <td><?php echo !empty($value['staffAddress']) ? $value['staffAddress'] : 'N/A'; ?></td>
                  
                    <td>
                   <?php if($value['status'] == 1) { ?> 
                      <span class="label label-success label-sm">Activated</span>
                    <?php } else { ?>
                      <span class="label label-warning label-sm">Deactivated</span>  
                    <?php } ?>
                  </td>
                    <td><?php echo date("F d ",strtotime($value['addDate'])).'at '.date("h:i A",strtotime($value['addDate'])); ?></td>
                    <td><?php echo ucwords($addedBy['name']);?></td>
                    <td><?php echo $value['ipAddress']?></td>
                </tr>
                  <?php $counter ++ ; } } else {
                    echo '<tr><td colspan="13" style="text-align:center;">No Records Found!</td></tr>';
                  } ?>
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

  

  

