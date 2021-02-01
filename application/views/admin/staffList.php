<?php $adminData = $this->session->userdata('adminData');?>
<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
<style type="text/css">
   .ratingpoint{
    color: red;
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
            <div class="box-body">
              <table cellpadding="0" cellspacing="0" border="0"
                class="table-striped table table-bordered editable-datatable example " id="example" >
                <thead>
                <tr>
                  <th>SrNo.</th>
                  <th>Facility</th>
                  <th>Staff&nbsp;Name</th>
                  <th>Staff&nbsp;Type</th>
                  <th>Staff&nbsp;Job&nbsp;Type</th>
                  <th>Staff&nbsp;Mobile</th>
                  <th>Emergency&nbsp;Contact&nbsp;Number</th>
                  <th>Staff&nbsp;Points</th>
                  <th>Staff&nbsp;Address</th>
                  <?php  
                      if($adminData['Type']=='1'){?>
                  <th style="width:100px;">Action</th>
                  <?php } ?>
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

                 ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><a href="<?php echo base_url();?>facility/updateFacility/<?php echo $GetFacility['FacilityID'];?>"><?php echo $GetFacility['FacilityName'];?></a></td>
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
                  <td><?php echo ($TotalCreditNursePoint['creditPoint'] - $TotalDebitNursePoint['debitPoint']); ?></td>
                  <td><?php echo $value['StaffAddress'] ?></td>
                    <?php if($adminData['Type']=='1'){?>
                     <td>
                          <?php $status = ($value['status'] == '1') ? 'assets/act.png' :'assets/delete.png';
                          if($value['status'] == 1){?>
                                <span class="click_btn change" id="id_<?php echo $value['StaffID'];?>" s_id="<?php echo $value['StaffID'];?>" status="1">
                                    <img src="<?php echo base_url($status) ;?>" title="Change Status" style="height: 23px; width: 23px; vertical-align: text-bottom;" class="status_img_'<?php echo $value['StaffID']?>"> 
                                </span>&nbsp;
                                <a href="<?php echo base_url(); ?>staffM/updateStaff/<?php echo $value['StaffID']; ?>" title="Edit Staff Information"><i class="fa fa-edit" style="font-size:23px;"></i></a>&nbsp; 
                                
                          <?php } else { ?>
                                 <span class="click_btn change" id="id_<?php echo $value['StaffID'];?>" s_id="<?php echo $value['StaffID'];?>" status="2">
                                 <img src="<?php echo base_url($status) ;?>" title="Change Status" style="height: 23px; width: 23px; vertical-align: text-bottom;" class="status_img_'<?php echo $value['StaffID']?>"> </span>&nbsp; 
                                 <a href="<?php echo base_url(); ?>staffM/updateStaff/<?php echo $value['StaffID']; ?>" title="Edit Staff Information"><i class="fa fa-edit" style="font-size:23px;"></i></a>&nbsp; 
                                 
                          <?php } ?>
                  </td>
                   <?php } ?>
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
                         image = '<img src="<?php echo base_url(); ?>assets/act.png" title="Change Status" style="height: 23px; width: 23px; vertical-align: text-bottom;"class="status_img">';
                        $('#'+get_id).html(image);
                        $('#MDG').css('color', 'green').html('<div class="alert alert-success">Activated successfully.</div>').show();
                            if (status == '1') {
                            $('#'+get_id).attr('status', '0');
                          } else {
                            $('#'+get_id).attr('status', '1');
                          }
                          setTimeout(function() { $("#MDG").hide(); }, 2000);
                    } else if (data == 2) {
                      image = '<img src="<?php echo base_url(); ?>assets/delete.png" title="Change Status" style="height: 23px; width: 23px; vertical-align: text-bottom;" class="status_img">';
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
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
 <!--  
 <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"> -->
 
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
  <script type="text/javascript" charset="utf-8">
      $(document).ready(function() {
        $('.example').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'pageLength',
            {
                extend: 'print',
                autoPrint: false,
                title: 'Staff List',
                exportOptions: {
                    columns: ':visible'
                }
            },{
                extend: 'pdf',
                title: 'Staff List',
                exportOptions: {
                    columns: ':visible'
                }
            },{
                extend: 'excel',
                title: 'Staff List',
                exportOptions: {
                    columns: ':visible'
                }
            },{
                extend: 'csv',
                title: 'Staff List',
                exportOptions: {
                    columns: ':visible'
                }
            },{
                extend: 'copy',
                exportOptions: {
                    columns: ':visible'
                }
            },
            'colvis'
        ]
    },
    {
        dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            ['10 rows', '25 rows', '50 rows', 'Show all' ]
        ],pageLength:100
    },
    {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'collection',
                text: 'Table control',
                buttons: [
                    'colvis'
                ]
            }
        ]
    } 
         
                );
      } );
                        
                       
    </script>
<script type="text/javascript">
  $('.example')
    .removeClass( 'display' )
    .addClass('table table-striped table-bordered');
</script>
