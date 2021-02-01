<style>
table.dataTable th:nth-child(3) {
  width: 120px;
  /*max-width: 120px;
  word-break: break-all;
  white-space: pre-line;*/
}
table.dataTable td:nth-child(3){
  width: 120px;
  /*max-width: 120px;
  word-break: break-all;
  white-space: pre-line;*/
}
</style>

<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <?php 
      $FacilityID  = $this->uri->segment(3);
      $Facility  = $this->load->UserModel->getFacilityNameBYID($FacilityID); ?>
      <h1><?php echo  $Facility['FacilityName'];?> Log
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
                
                <table class="table-striped table table-bordered example" id="example">
                <thead>
                   <tr>
                      <th>S&nbsp;No.</th>
                      <th>Facility&nbsp;Type&nbsp;Name</th>
                      <th>Priority</th>
                      <th>Status</th>
                      <th>Date&nbsp;&&nbsp;Time</th>
                      <th>Added&nbsp;By</th>
                      <th>IP&nbsp;Address</th>
                   </tr>
                </thead>
                <tbody>
                 <?php 
                 $counter ="1";
                 //echo "<pre>";
                 //print_r($GetFacilities); exit;
                 foreach ($GetLog as$key=> $value ) {
                      $addedBy = $this->load->FacilityModel->GetDataById('adminMaster',$value['addedBy']);
                   ?>
                   <tr>
                     <td><?php echo $counter; ?></td>
                     <td><?php echo $value['facilityTypeName']; ?></td>
                     <td><?php echo $value['priority']; ?></td>
                     <td>
                       <?php  
                        $status = ($value['status']=='1') ? 'assets/act.png' :'assets/delete.png';
                        if ($value['status'] == 1) { ?> 
                        <span class="label label-success label-sm" >
                           Activated </span> 
                        <?php } else { ?>
                        <span class="label label-warning label-sm">
                            Deactivated </span> 
                        <?php } ?>
                        &nbsp;  
                      </td>
                      <td><?php echo date("F d ",strtotime($value['addDate'])).'at '.date("h:i A",strtotime($value['addDate'])); ?></td>
                      <td><?php echo ucwords($addedBy['name']);?></td>
                      <td><?php echo $value['ipAddress']?></td>
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



  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Facilities Functional Diagram</h4>
        </div>
        <div class="modal-body">
          <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/ManageFacilities.png') ;?>" style="height:500px;width:100%;">
        </div>
      </div>
      
    </div>
  </div>


  <div class="modal fade" id="dfdModal" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Facilities DataFlow Diagram (DFD)</h4>
        </div>
        <div class="modal-body text-center" style="padding:0px !important;">
          <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/facilitydfd.png') ;?>" style="height:598px;width:100%;">
        </div>
      </div>
      
    </div>
  </div>

<script>

    

    $(document).ready(function() {
      var fileName = $("#scriptFileName").val();
      $('.example1').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'pageLength',
            {
                extend: 'pdf',
                title: fileName,
                exportOptions: {
                  columns: ':visible'
                }
            },{
                extend: 'excel',
                title: fileName,
                exportOptions: {
                  columns: ':visible'
                }
            },{
                extend: 'csv',
                title: fileName,
                exportOptions: {
                  columns: ':visible'
                }
            },
            'colvis'
        ],
    "scrollY": false,
    "scrollX": false,
    "paging": true,
    "ordering": false,
    "autoWidth": false,
    "fixedHeader": {
        "header": false,
        "footer": false
    },
    "columnDefs": [
      { "width": "10px", "targets": 0 },
      { "width": "40px", "targets": 1 },
      { "width": "100px", "targets": 2 },
      { "width": "70px", "targets": 3 },
      { "width": "70px", "targets": 4 },
      { "width": "70px", "targets": 5 }
    ],
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
                buttons: ['colvis']
            }
        ]
      });
    });            
  
</script>
