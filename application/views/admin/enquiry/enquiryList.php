<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'Enquiries List'; ?>
      
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
              <div class="col-sm-12" style="overflow: auto;"> 
                <table class="table-striped table table-bordered example" id="example">
                  <thead>
                    <tr>
                      <th>S&nbsp;No.</th>
                      <th>Ticket&nbsp;ID</th>  
                      <th>Lounge</th>                             
                      <th>Location</th>
                      <th>Enquiry&nbsp;Date&nbsp;Time</th>
                      <th>Response</th>
                      <th>Response&nbsp;Date&nbsp;Time</th>
                      <th>Action&nbsp;Taken&nbsp;By</th>
                      <th>Status</th>
                      <th>Action</th>
                      
                    </tr>
                  </thead>
                  <tbody>

                    <?php 
                      $counter ="1";

                      foreach ($GetList as $value) {
                        $last_updated =     $this->load->FacilityModel->time_ago_in_php($value['modifyDate']);
                        if(!empty($value['loungeId'])){
                          $lounge =     $this->load->FacilityModel->GetLoungeById($value['loungeId']); 
                          $loungeName = $lounge['loungeName'];
                        } else {
                          $loungeName = '--';
                        }
                        $generated_on =     $this->load->FacilityModel->time_ago_in_php($value['addDate']);
                        
                    ?>
                    <tr id="update<?php echo $value['id'];?>">
                      <td><?php echo $counter; ?></td>
                      <td><?php echo $value['id']; ?></td>
                      <td><?php echo $loungeName; ?></td>
                      <td><?php echo $value['location']; ?></td>
                      <td>
                        <a href="javascript:void(0);" class="tooltip"><?php echo $generated_on; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['addDate'])) ?></span></a>
                      </td>
                      <td>
                       <?php  if ($value['responseGivenBy'] != '') { 
                        echo $value['remark'];
                         } else { echo '--'; } ?>
                        &nbsp;  
                      </td>
                      <td><?php if ($value['responseGivenBy'] != '') { ?> 
                        <a href="javascript:void(0);" class="tooltip"><?php echo $last_updated; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['modifyDate'])) ?></span></a>
                        <?php  } else { echo "--"; } ?></td>
                      <td><?php if ($value['responseGivenBy'] != '') { echo 'Admin'; } else { echo '--'; } ?></td>
                      <td>
                       <?php  
                        $status = ($value['status']=='1') ? 'assets/act.png' :'assets/delete.png';
                        if ($value['status'] == 1) { ?> 
                        <span class="label label-warning label-sm">
                           Pending</span> 
                        <?php } else  if ($value['status'] == 2) { ?>
                        <span class="label label-success label-sm">
                            Closed  </span> 
                        <?php } else  if ($value['status'] == 3) { ?>
                        <span class="label label-danger label-sm">
                            Cancelled  </span> 
                        <?php } ?>
                        &nbsp;  
                      </td>
                      <td> <a href="<?php echo base_url(); ?>enquiryM/takeAction/<?php echo $value['id']; ?>" class="btn btn-info btn-sm" title="Take Action On Enquiry">View/Edit</a> </td>
                      
                      
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
