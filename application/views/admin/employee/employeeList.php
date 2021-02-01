<?php $adminData = $this->session->userdata('adminData');?>
<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'CEL Employees'; ?>
      
      <?php 
          if($adminData['Type'] == '1'){ ?>
            <a href="<?php echo base_url('employeeM/addEmployee/');?>" class="btn btn-info" style="float: right; padding-right: 10px;margin-right:15px;">Add CEL Employee</a>
      
      <?php }  ?>
      
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
              <table class="table-striped table table-bordered example" id="example">
                <thead>
                <tr>
                  <th>S&nbsp;No.</th>
                  <th>Employee&nbsp;Code</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  
                  <th>Status</th>
                  <th>Action</th>
                  
                  <th>&nbsp;&nbsp;&nbsp;Login&nbsp;Details&nbsp;&nbsp;</th>
                  <th>Last Updated On</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                $counter = '1';
                if(!empty($results)) { 
                foreach ($results as $value) {
                  $last_updated =     $this->load->FacilityModel->time_ago_in_php($value['modifyDate']);    
                ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><?php echo $value['employeeCode']; ?></td>
                  <td><?php echo $value['name']; ?></td>
                  <td><?php echo $value['email']; ?></td>
                  <td><?php echo $value['contactNumber']; ?></td>
                  <!-- <td style="width:70px;height:50px;">
                    <?php  if(empty($value['profileImage'])) { ?>
                      <img  src="<?php echo base_url();?>assets/nurse/default.png" style="height:100px;width:100px;margin-top:5px;">
                    <?php } else { ?>
                      <img  src="<?php echo base_url();?>assets/employee/<?php echo $value['profileImage']?>" class="img-responsive">
                    <?php } ?>
                  </td> -->
                  <td>
                   <?php if($value['status'] == 1) { ?> 
                      <span class="click_btn change" id="id_<?php echo $value['id'];?>" s_id="<?php echo $value['id'];?>" status="1">
                         <a href="#" class="btn btn-success btn-sm">Activated</a> 
                      </span>
                    <?php } else { ?>
                           <span class="click_btn change" id="id_<?php echo $value['id'];?>" s_id="<?php echo $value['id'];?>" status="2">
                          <a href="#" class="btn btn-warning btn-sm">Deactivated</a>   
                       </span>  
                    <?php } ?>
                  </td>
                  <td><a href="<?php echo base_url(); ?>employeeM/updateEmployee/<?php echo $value['id']; ?>" title="Edit EMployee Information" class="btn btn-info btn-sm">View/Edit</a></td>
                  <td></td>
                  <td><a class="tooltip" href="<?php echo base_url(); ?>employeeM/viewEmployeeLog/<?php echo $value['id']; ?>"><?php echo $last_updated; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['modifyDate'])) ?></span></a></td>
                  
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

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Staff Functional Diagram</h4>
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
          <h4 class="modal-title">Staff DataFlow Diagram (DFD)</h4>
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
        var table = 'employeesData';
        var s_url = '<?php echo base_url('Admin/changeStatus'); ?>';
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
                data: {'table': table, 'id': s_id,'tbl_id':'id'},
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