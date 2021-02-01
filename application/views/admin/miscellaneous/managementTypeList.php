<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'Management Type'; ?>
      <a href="<?php echo base_url('Miscellaneous/addManagementType');?>" class="btn btn-info" style="float: right; padding-right: 10px;  "> Add Management Type</a> 
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
                  <th>Name</th>                             
                  <th>Status</th>
                  <th>Action</th>
                  <th>Last Updated On</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                  $counter ="1";

                  foreach ($GetList as $value) {
                    $last_updated =     $this->load->FacilityModel->time_ago_in_php($value['modifyDate']); 
                ?>
                <tr id="update<?php echo $value['id'];?>">
                  <td><?php echo $counter; ?></td>
                  <td><?php echo $value['name']; ?></td>
                  <td>
                   <?php  
                    $status = ($value['status']=='1') ? 'assets/act.png' :'assets/delete.png';
                    if ($value['status'] == 1) { ?> 
                    <span class="label label-success label-sm">
                       Activated </span> 
                    <?php } else { ?>
                    <span class="label label-warning label-sm">
                        Deactivated  </span> 
                    <?php } ?>
                    &nbsp;  
                  </td>
                  <td> <a href="<?php echo base_url(); ?>Miscellaneous/editManagementType/<?php echo $value['id']; ?>" class="btn btn-info btn-sm" title="Edit NBCU Information">View/Edit</a> </td>
                  <td><a class="tooltip" href="<?php echo base_url(); ?>Miscellaneous/viewManagementTypeLog/<?php echo $value['id']; ?>"><?php echo $last_updated; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['modifyDate'])) ?></span></a></td>
                </tr>
                  <?php $counter ++ ; } ?>
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



<!--Update Modal-->
<div class="container">

  <!-- Modal -->
  <div class="modal fade" id="edit" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Facility Type</h4>
        </div>
        <div class="modal-body" id="mods1">
          
        </div>
       <!--  <div class="modal-footer">
          <button type="submit" class="btn btn-default" data-dismiss="modal">Update</button>
        </div> -->
      </div>
      
    </div>
  </div>
  
</div>

<script>

$('.click_btn').on('click', function(){
        var get_id = $(this).attr('id');
        var s_id = $(this).attr('s_id');
        var status = $(this).attr('status');
        var table = 'masterData';
        var s_url = '<?php echo base_url('facility/changeStatus'); ?>';
        if(status == '1'){
            var text = 'Deactivate';     
        } else {
            var text = 'Activate';    
        }
        var r =  confirm("Are you sure! You want to "+text+" this NBCU?");
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
