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
     <?php 
      $FacilityID  = $this->uri->segment(3);
      $Facility  = $this->load->UserModel->getFacilityNameBYID($FacilityID); ?>
      <h1><?php echo  $Facility['FacilityName'];?>&nbsp;<?php  echo $title; ?>
      </h1>
      
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
           <div  id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
           <div class="" id="MDG"></div>
            <div class="box-body" >
              <div class="col-sm-12" style="overflow: auto;">
                <table cellpadding="0" cellspacing="0" border="0"
                class="table-striped table table-bordered editable-datatable example " id="example">
                <thead>
                   <tr>
                      <th>Sr.&nbsp;No.</th>
                      <th>Mobile&nbsp;Number</th>
                      <th>IpAddress</th>
                      <th>Login&nbsp;Date</th>
                      <th>Logout&nbsp;Date</th>
                      
                   </tr>
                </thead>
                <tbody>
                 <?php 
                 $counter ="1";
                 foreach ($GetHistory as$key=> $value ) {
                    ?>
                   <tr>
                     <td><?php echo $counter; ?></td>
                     <td><?php echo $value['MobileNumber']; ?></td>
                     <td><?php echo $value['device_id']; ?></td>
                     <td><?php echo $date=date("d-m-Y H:i:s",$value['login_time']); ?></td>
                     <td></td>
                     
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


</script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
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
                title: '<?php echo  $Facility['FacilityName'];?> <?php  echo $title; ?>',
                exportOptions: {
                    columns: ':visible'
                }
            },{
                extend: 'pdf',
                 title: '<?php echo  $Facility['FacilityName'];?> <?php  echo $title; ?>',
                exportOptions: {
                    columns: ':visible'
                }
            },{
                extend: 'excel',
                title: '<?php echo  $Facility['FacilityName'];?> <?php  echo $title; ?>',
                exportOptions: {
                    columns: ':visible'
                }
            },{
                extend: 'csv',
                 title: '<?php echo  $Facility['FacilityName'];?> <?php  echo $title; ?>',
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