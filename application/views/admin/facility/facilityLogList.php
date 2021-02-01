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
                      <th>Facility&nbsp;Name</th>
                      <th>Facility&nbsp;Type</th>
                      <th>Newborn&nbsp;Care&nbsp;Unit </th>
                      <th>Management&nbsp;Type</th>
                      <th>Govt&nbsp;OR&nbsp;Non&nbsp;Govt</th>
                      <!-- <th>KMC&nbsp;Lounge&nbsp;Status</th> -->
                      <th>KMC&nbsp;Unit&nbsp;Start</th>
                      <th>KMC&nbsp;Unit&nbsp;Close</th>
                      <th>Address&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                      <!-- <th>Administration </th> -->
                      <th>CMS&nbsp;MOIC</th>
                      <th>CMS/MOIC</th>
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
                 foreach ($GetFacilityLog as$key=> $value ) {
                      $govtOrNon = $this->load->FacilityModel->GetDataById('masterData',$value['GOVT_NonGOVT']);
                      $NCUtype = $this->load->FacilityModel->GetDataById('masterData',$value['NCUType']);
                      $FacilityManagement = $this->load->FacilityModel->GetDataById('masterData',$value['FacilityManagement']);
                      $BlockName = $this->load->FacilityModel->GetBlockName2($value['PRIBlockCode']);
                     /* echo $BlockName; exit;*/
                      $DistrictName = $this->load->FacilityModel->GetDistrictName($value['PRIDistrictCode']);
                      $Village = $this->load->FacilityModel->GetVillageName($value['GPPRICode']);
                      $state = $this->load->FacilityModel->GetStateName($value['StateID']);
                      $address = $value['Address'].' '.$Village.' '.$BlockName.' '.$DistrictName.', '.$state;
                      $addedBy = $this->load->FacilityModel->GetDataById('adminMaster',$value['addedBy']);
                      $generated_on =     $this->load->FacilityModel->time_ago_in_php($value['AddDate']);
                   ?>
                   <tr>
                     <td><?php echo $counter; ?></td>
                     <td><?php echo $value['FacilityName']; ?></td>
                     <td><?php echo $value['FacilityType']; ?></td>
                     <td><?php echo $NCUtype['name']; ?></td>
                     <td><?php echo $FacilityManagement['name']; ?></td>
                     <td><?php echo $govtOrNon['name']; ?></td>
                     <td><?php echo $value['KMCUnitStartedOn']; ?></td>
                     <td><?php echo $value['KMCUnitClosedOn']; ?></td>
                      <td><?php echo $address; ?></td>
                      <!-- <td><?php if(!empty($value['AdministrativeMoblieNo'])) { 
                          echo $value['AdministrativeMoblieNo'];  } ?>
                      </td>   -->
                      <td><?php echo $value['CMSOrMOICName']?></td>
                      <td><?php echo $value['CMSOrMOICMoblie']?></td>
                      <td>
                          <?php $status = ($value['Status'] == '1') ? 'assets/act.png' :'assets/delete.png';
                          if($value['Status'] =='1'){?>
                                <span class="label label-success label-sm">Activated
                                </span>
                          <?php } else { ?>
                                 <span class="label label-warning label-sm">
                                  Deactivated  
                                 </span>
                          <?php } ?>
                      </td>
                      <td><a href="javascript:void(0);" class="tooltip"><?php echo $generated_on; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['AddDate'])) ?></span></a></td>
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

$('.click_btn').on('click', function(){
        var get_id = $(this).attr('id');
        var s_id = $(this).attr('s_id');
        var status = $(this).attr('status');
        var table = 'facilitylist';
        var s_url = '<?php echo base_url('facility/changeFacilityStatus'); ?>';
        if(status == '1'){
            var text = 'Deactivate';     
        } else {
            var text = 'Activate';    
        }
        var r =  confirm("Are you sure! You want to "+text+" this Facility?");
       // alert(status);
        var image;
        if (r) {
            $.ajax({
                data: {'table': table, 'id': s_id,'tbl_id':'FacilityID'},
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
