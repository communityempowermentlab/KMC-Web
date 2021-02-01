<?php $adminData = $this->session->userdata('adminData');?>
<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'Employee Log'; ?>
      
      
      
      </h1>
      
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            
           <div  id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
               
            <div class="box-body">
             <div class="col-sm-12" style="overflow: auto;"> 
              <table class="table-striped table table-bordered example" id="example" data-page-length='25'>
                <thead>
                <tr>
                  <th>S&nbsp;No.</th>
                  <th>Employee&nbsp;Code</th>
                  <th>Employee&nbsp;Name</th>
                  <th>Employee&nbsp;Email</th>
                  <th>Employee&nbsp;Mobile</th>
                  <th>Assigned&nbsp;Menus</th>
                  <th>Employee&nbsp;Photo</th>
                  <th>Status</th>
                  <th>Date&nbsp;&&nbsp;Time</th>
                  <th>Added&nbsp;By</th>
                  <th>IP&nbsp;Address</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                $counter = '1';
                if(!empty($results)) { 
                foreach ($results as $value) {
                    $addedBy = $this->load->FacilityModel->GetDataById('adminMaster',$value['addedBy']);
                    $getMenuGroup = $this->load->EmployeeModel->getMenuGroup($value['menuGroup']); 
                    $strMenu = implode(",", array_column($getMenuGroup, "groupName"));
                 ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><?php echo $value['employeeCode']; ?></td>
                  <td><?php echo $value['name']; ?></td>
                  <td><?php echo $value['email']; ?></td>
                  <td><?php echo $value['contactNumber']; ?></td>
                  <td><?php echo $strMenu; ?></td>
                  <td style="width:70px;height:50px;">
                    <?php  if(empty($value['profileImage'])) { ?>
                      <img  src="<?php echo base_url();?>assets/nurse/default.png" style="height:100px;width:100px;margin-top:5px;">
                    <?php } else { ?>
                      <img  src="<?php echo base_url();?>assets/employee/<?php echo $value['profileImage']?>" class="img-responsive">
                    <?php } ?>
                  </td>
                  <td>
                   <?php if($value['status'] == 1) { ?> 
                      <span class="label label-success label-sm">Activated 
                      </span>
                    <?php } else { ?>
                           <span class="label label-warning label-sm">Deactivated  
                       </span>  
                    <?php } ?>
                  </td>
                  
                  <td><?php echo $date=date("d-m-Y h:i A",strtotime($value['addDate'])); ?></td>
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

  

