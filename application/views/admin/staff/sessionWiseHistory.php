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
  .setSize{
    width: 25px;
    height: 25px;
  }
</style>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'Training App Point History'; ?>
      </h1>
      
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">

         <div class="box box-info"> 
           <div class="box-body">
              <div class="form-group" >
                     <div class="col-sm-6">
                     <div class="col-sm-4" style="margin-top: 6px;">

                        <?php
                        $sessionId = $this->uri->segment(4); 
                        $TotalScore    = $this->db->query("SELECT SUM(score) as Allpoints from trainingapp_store_answer where userid=".$StaffIDs." and sessionid=".$sessionId ."")->row_array();
                        $GetNurseDetail = $this->UserModel->getStaffNameBYID($StaffIDs);
                        $TotalCreditNursePoint    = $this->db->query("SELECT SUM(Points) as creditPoint from pointstransactions where NurseId=".$StaffIDs." and TransactionStatus='Credit'")->row_array();
                     
                        $TotalDebitNursePoint    = $this->db->query("SELECT SUM(Points) as debitPoint from pointstransactions where NurseId=".$StaffIDs." and TransactionStatus='Debit'")->row_array();
                         if(empty($GetNurseDetail['ProfilePic'])) { ?>
                               <img  src="<?php echo base_url();?>assets/nurse/default.png" style="height:150px;width:140px;">
                             
                          <?php } else { ?>
                             <img  src="<?php echo base_url();?>assets/nurse/<?php echo $GetNurseDetail['ProfilePic']?>" style="height:150px;width:140px;" class="img-responsive">
                         <?php } ?>
                       </div>
                       <div class="col-sm-8" style="padding-left:10px;">
                        <span style="font-size: 20px;"><?php echo $GetNurseDetail['Name']; ?></span><br>
                        <b>Score Point: </b><?php echo $TotalScore['Allpoints']; ?>
                       </div>
                     </div>
                     <div class="col-sm-3"><br>

                     </div>
                </div>
           </div>
        </div>  


          <div class="box">
            <div class="box-body">
              <table cellpadding="0" cellspacing="0" border="0"
                class="table-striped table table-bordered editable-datatable example " id="example" >
                <thead>
                <tr>
                  <th>SrNo.</th>
                  <th>Question</th>
                  <th>Points</th>
                  <th>Currect/Incorrect</th>
                  <th>Question Attempt</th>
                  <th>DateTime</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                $counter ="1";
                foreach ($GetTrainingData as $value) {
                 // print_r($GetTrainingData);exit;
                  $question=$this->db->get_where('trainingapp_manage_question',array('id'=>$value['questionid']))->row_array();
                 ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                 <td width="350"><?php echo $question['title']; ?></td>
                 <td><?php echo "+".$value['score']; ?></td>
                 <td><?php echo ucwords($value['answer_type']); ?></td>
                 <td><?php echo $value['attempt']; ?></td>
                 <td><?php echo date("d-m-Y h:i A",$value['created_date']); ?></td>
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
