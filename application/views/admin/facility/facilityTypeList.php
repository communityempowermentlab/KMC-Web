<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'Facility Type'; ?>
     <a href="<?php echo base_url(); ?>facility/addFacilityType/"><button type="button" style="float: right; padding-right: 10px; "  class="btn btn-info">Add Facility Type </button></a>
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
                  <th>Facility Type Name</th>                
                  <th>Priority</th>                
                  <th>Total&nbsp;Facilities</th>                
                  <th>Status</th>
                  <th>Action</th>
                  <th>Last&nbsp;Updated&nbsp;On</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                $counter ="1";
               /* echo "<pre>";
                print_r($GetFacilities); exit;*/

                foreach ($GetFacilities as $value) {
                  $countFacilitis= $this->FacilityModel->countFacilitis($value['id']);
                  $last_updated =     $this->load->FacilityModel->time_ago_in_php($value['modifyDate']); 
                ?>
                <tr id="update<?php echo $value['id'];?>">
                  <td><?php echo $counter; ?></td>
                  <td><?php echo $value['facilityTypeName']; ?></td>
                  <td><?php echo $value['priority']; ?></td>
                  <td><?php echo $countFacilitis; ?></td>
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
                  <td> <a href="<?php echo base_url(); ?>facility/editFacilityType/<?php echo $value['id']; ?>" class="btn btn-info btn-sm" title="Edit Facility Type Information">View/Edit</a> </td>
                  <td><a class="tooltip" href="<?php echo base_url(); ?>facility/viewFacilityTypeLog/<?php echo $value['id']; ?>"><?php echo $last_updated; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['modifyDate'])) ?></span></a></td>
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



  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Facility Type</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="<?php echo base_url('facility/AddUpdateFacility') ?>" method="post" onsubmit="return formValidation()" >
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="email">Facility Type Name: <?php echo REQUIRED;?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="facility_name" placeholder="Facility Name">
                            <input type="hidden" name="FacilityTypeID">
                            <div class="text-red"><span id="facility_name_err"></span></div>
                        </div>
                    </div>

                    <div class="form-group">

                        <label class="control-label col-sm-4" for="email">Set Priority: <?php echo REQUIRED;?></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="priority">
                              <option>--Select Priority--</option>
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                              <option>5</option>
                            </select>
                        </div>
                    </div>
            
                    <div class="modal-footer">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" id="saveBTN" class="btn btn-default">Save</button>
                            </div>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>


<script>

$('.click_btn').on('click', function(){
        var get_id = $(this).attr('id');
        var s_id = $(this).attr('s_id');
        var status = $(this).attr('status');
        var table = 'facilityType';
        var s_url = '<?php echo base_url('facility/changeStatus'); ?>';
        if(status == '1'){
            var text = 'Deactivate';     
        } else {
            var text = 'Activate';    
        }
        var r =  confirm("Are you sure! You want to "+text+" this Facility Type?");
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



  function updatefacility(getID){
   // alert(getID);
    $( "#callFuncation" ).trigger( "click" );
    var tableValue = $('#update'+getID).closest("tr").find("td");
    //console.log(tableValue[2]['innerText']);
    
    var facility_name = tableValue[1]['innerText'];
   

    $('input[name="FacilityTypeID"]').val(getID);
    $('input[name="facility_name"]').val(facility_name);
    $('#saveBTN').text('Update');
  }
 
    // Add Facility type 
  function addSchool(){
    $( "#callFuncation" ).trigger( "click" );
    $('input[name="FacilityTypeID"]').val('');
    $('input[name="facility_name"]').val('');
    $('#facility_name_err').text('');
    $('#saveBTN').text('Save');
  }

  function formValidation()
  {
    var returnValue  = true;

    var facility_name   = $('input[name="facility_name"]').val();
   
    if(facility_name==''){
     $('#facility_name_err').text('Facility name is required.');
     returnValue = false;
    }else{
     $('#facility_name_err').text('');
    }

    return returnValue;
  }
  
</script>
  <script>
  function Getvalue(FeedbackId)
  {
   // alert("FeedbacksOxdis");
  $("#mods1").load('<?php echo base_url('Admin/action1'); ?>', {"FeedbackId": FeedbackId} );
  }
  </script>
