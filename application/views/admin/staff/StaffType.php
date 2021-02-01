<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo $index2; ?>
     <a href="<?php echo base_url(); ?>staffM/addStaffType/"><button type="button"  style="float: right; padding-right: 10px; "  class="btn btn-info">Add Staff Type </button></a>
     <button type="button" style="display: none;" id="callFuncation" style="float: right; padding-right: 10px; "  class="btn btn-info" data-toggle="modal" data-target="#myModal">Add Facility Type</button>
      </h1>
      
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
           <div  id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
            <div class="" id="MDG"></div>
            <div class="box-body">
              <table cellpadding="0" cellspacing="0" border="0"
                class="table-striped table table-bordered editable-datatable example " id="example" >
                <thead>
                <tr>
                  <th>S&nbsp;No.</th>
                  <th>Staff Type Name</th>                                                              
                  <th>Staff Sub Type Name</th>                                                    
                  <th>Status</th>
                  <th>Action</th>
                  <th>Last&nbsp;Updated&nbsp;On</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $counter ="1";
                foreach ($StaffType as $value) { 
                  $last_updated          = $this->FacilityModel->time_ago_in_php($value['modifyDate']);
                ?>
                     <tr id="update<?php echo $value['staffTypeId'];?>">
                         <td><?php echo $counter; ?></td>
                         <td><?php echo $value['staffTypeNameEnglish'];?>
                         <td>
                          <?php if($value['parentId']=='0'){
                           echo " -";}
                          if($value['parentId']=='1'){
                                   $FindPost=$this->load->FacilityModel->GetStaffTypeById('1');
                                   echo $FindPost['staffTypeNameEnglish'];
                              }else if($value['parentId']=='2'){
                                    $FindPost=$this->load->FacilityModel->GetStaffTypeById('2');
                                   echo $FindPost['staffTypeNameEnglish'];
                              }else if($value['parentId']=='3'){
                                    $FindPost=$this->load->FacilityModel->GetStaffTypeById('3');
                                   echo $FindPost['staffTypeNameEnglish'];
                              }else if($value['parentId']=='4'){
                                    $FindPost=$this->load->FacilityModel->GetStaffTypeById('4');
                                    echo $FindPost['staffTypeNameEnglish'];
                              }else if($value['parentId']=='5'){
                                   $FindPost=$this->load->FacilityModel->GetStaffTypeById('5');
                                   echo $FindPost['staffTypeNameEnglish'];
                              }    
                          ?>
                          </td>
                         <td>
                           <?php if ($value['status'] == 1) { ?> 
                           <span class="label label-success label-sm">
                              Activated
                            </span> 
                           <?php } else { ?>
                            <span class="label label-warning label-sm">
                              Deactivated   
                            </span> 
                            <?php } ?>
                         </td>
                         <td><a href="<?php echo base_url(); ?>staffM/editStaffType/<?php echo $value['staffTypeId']; ?>" title="Edit Facility Type Information" class="btn btn-info btn-sm">View/Edit</a>
                         </td>
                         <td><a class="tooltip" href="<?php echo base_url(); ?>staffM/staffTypeLog/<?php echo $value['staffTypeId']; ?>"><?php echo $last_updated; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['modifyDate'])) ?></span></a></td>
                      </tr>
                    <?php $counter ++ ; }   ?>
                </tbody>
               </table>
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

$('.click_btn').on('click', function(){
        var get_id = $(this).attr('id');
        var s_id = $(this).attr('s_id');
        var status = $(this).attr('status');
        var table = 'staffType';
        var s_url = '<?php echo base_url('facility/changeStatus'); ?>';
        if(status == '1'){
            var text = 'Deactivate';     
        } else {
            var text = 'Activate';    
        }
        var r =  confirm("Are you sure! You want to "+text+" this Staff Type?");
       // alert(status);
        var image;
        if (r) {
            $.ajax({
                data: {'table': table, 'id': s_id,'tbl_id':'staffTypeId'},
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
