<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
<style type="text/css">
   .ratingpoint{
    }
  i.fa.fa-fw.fa-trash {
    font-size: 30px;
    color: darkred;
    top: 5px;
    position: relative;
  }
 #example_filter label, .paging_simple_numbers .pagination {float: right;}
</style>

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo $index2; ?>
     <a href="<?php echo base_url(); ?>supplimentM/AddSuppliment"><button type="button" style="float: right; padding-right: 10px; "  class="btn btn-info">Add Suppliment </button></a>
     <button type="button" style="display: none;" id="callFuncation" style="float: right; padding-right: 10px; "  class="btn btn-info" data-toggle="modal" data-target="#myModal">Add Suppliment</button>
      </h1>
      
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
           <div  id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
            <div class="" id="MDG"></div>

            <span style="font-size: 20px;">Manage Resources:</span> [<a href="#" data-toggle="modal" data-target="#myModal1">DataFlow Diagram</a>][<a href="" data-toggle="modal" data-target="#myModal2">Functional Diagram</a>]

            <div class="box-body">
              <table cellpadding="0" cellspacing="0" border="0"
                class="table-striped table table-bordered editable-datatable example " id="example" >
                <thead>
                <tr>
                  <th>S&nbsp;No.</th>
                  <th>Name</th>
                  <th>Number&nbsp;Of&nbsp;Days</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                $counter ="1";
                foreach ($SupplimentData as $value) {
                  ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><?php echo $value['name'] ;?></td>
                  <td><?php echo $value['duration'] ;?></td>
                  <td>
                    <?php  
                    //$status = ($value['Status']=='1') ? 'assets/act.png' :'assets/delete.png';
                    if ($value['status'] == 1) { ?> 
                    <span class="click_btn change" id="id_<?php echo $value['id'];?>" s_id="<?php echo $value['id'];?>" status="1">
                        <a href="#" class="btn btn-success btn-sm">Activated</a> 
                      </span> 
                    <?php } else { ?>
                    <span class="click_btn change" id="id_<?php echo $value['id'];?>" s_id="<?php echo $value['id'];?>" status="2">
                         <a href="#" class="btn btn-warning btn-sm">Deactivated</a>
                   </span> 
                    <?php } ?>
                  
                  </td>
                  <td><a href="<?php echo base_url(); ?>supplimentM/EditSuppliment/<?= $value['id']; ?>" title="Edit Suppliment Information" class="btn btn-info btn-sm">View/Edit</a></td>
                </tr>
                  <?php  $counter ++ ; } ?>
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


  <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Manage Supplements DataFlow Diagram (DFD)</h4>
        </div>
        <div class="modal-body text-center">
          <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/supplimentmaster.png') ;?>" style="height:250px;width:50%;">
        </div>
      </div>
      
    </div>
  </div>

  <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Manage Supplements Fuctional Diagram</h4>
        </div>
        <div class="modal-body text-center">
          <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/supplementFunctional.png') ;?>" style="height:300px;width:80%;">

         
        </div>
      </div>
      
    </div>
  </div>

  

<script>
$('.click_btn').on('click', function(){
        var get_id = $(this).attr('id');
        var s_id = $(this).attr('s_id');
        var status = $(this).attr('status');
        var table = 'supplimentMaster';
        var s_url = '<?php echo base_url('facility/changeStatus')?>';
        if(status == '1'){
            var text = 'Deactivate';     
        } else {
            var text = 'Activate';    
        }
        var r =  confirm("Are you sure! You want to "+text+" this Supplement?");
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

 