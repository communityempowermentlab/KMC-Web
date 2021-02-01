<?php $adminData = $this->session->userdata('adminData');?>
<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Manage Index Page Image
      
      
      <a href="<?php echo base_url('admin/addImage/');?>" class="btn btn-info" style="float: right; padding-right: 10px;margin-right:15px;">Add Image</a>
      
      
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
                  <th>Image</th>
                  <th>Status</th>
                  <th>Action</th>
                  
                </tr>
                </thead>
                <tbody>

                <?php 
                  if(!empty($result)) { 
                    $counter = 1;
                    foreach ($result as $value) {
                 ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><img style="width: 120px;" src="<?php echo base_url();?>assets/loginPage/<?php echo $value['image']?>" class="img-responsive"></td>
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
                  <td><a href="<?php echo base_url(); ?>admin/editImage/<?php echo $value['id']; ?>" title="Edit Staff Information" class="btn btn-info btn-sm">View/Edit</a></td>
                  
                  
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

  
  <script>
    $('.click_btn').on('click', function(){
          var get_id = $(this).attr('id');
          var s_id = $(this).attr('s_id');
          var status = $(this).attr('status');
          var table = 'indexPageImage';
          var s_url = '<?php echo base_url('Admin/changeStatus'); ?>';
          if(status == '1'){
              var text = 'Deactivate';     
          } else {
              var text = 'Activate';    
          }
          var r =  confirm("Are you sure! You want to "+text+" this Image?");
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
