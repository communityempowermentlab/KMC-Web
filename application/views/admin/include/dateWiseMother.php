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
</style>
<style>
style type="text/css">
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
      <h1><?php echo 'Date Wise Mother'; ?>
   <!--    <a href="<?php //echo base_url('Admin/Add_Lounge/');?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add Lounge</a> -->
      </h1>
      
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
           <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
            <div class="box-body">
              <div class="col-sm-12" style="overflow: auto;">
              <table cellpadding="0" cellspacing="0" border="0"
                class="table-striped table table-bordered editable-datatable example " id="example" >
                <thead>
                <tr>
                  <th style="width:70px;">SrNo.</th>
                  <th>Mother&nbsp;Photo</th>
                  <th>Mother&nbsp;Name(Age)</th>
                  <th style="width:300px;">Baby&nbsp;Info.</th>
                  <th>Registration&nbsp;No.</th>
                  <th>MCTS&nbsp;No</th>
                  <th>Mother&nbsp;Mobile&nbsp;No</th>
                  
                  <th style="width:100px;">Reg.&nbsp;Date&nbsp;&&nbsp;Time</th>  
                  <th style="width:100px;">Facility&nbsp;Name</th>  
                  <th style="width:100px;">Status</th>  
                  <th style="width:100px;">Action</th>  
                 <!--  <th style="width:100px">Status</th> -->
                </tr>
                </thead>
                <tbody>

                <?php 
                $counter ="1";
              
                foreach ($GetMother as $value) {
                  $GetAllBaby       = $this->MotherModel->getMotherDataById('babyRegistration',$value['motherId']);

                  $GetStatus        = $this->MotherModel->GetMotherStatus($value['motherId']);
                  $GetFacility      = $this->FacilityModel->GetFacilitiesID($GetStatus['loungeId']);
                  $GetFacilittyName = $this->FacilityModel->GetFacilityName($GetFacility['facilityId']); 
                  ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td>
                  <?php if(empty($value['MotherPicture'])){?>
                  <img  src="<?php echo base_url();?>assets/images/user.png" class="img-responsive">
                  <?php }else{?>
                  <img  src="<?php echo base_url();?>assets/images/mother_images/<?php echo $value['motherPicture']; ?>"  class="img-responsive">
                  <?php } ?>

                  </td>
                    <?php 
                    $bday = new DateTime($value['motherDOB']);
                    $date= date("Y-m-d H:i:s");
                    $today = new DateTime($date); // for testing purposes
                    $diff = $today->diff($bday);
                    //printf('%d years, %d month, %d days', $diff->y, $diff->m, $diff->d);
                    ?>
                  <td><img src="<?php echo base_url();?>assets/images/happy-face.png" style="width:25px;height:25px;">&nbsp;
                    <?php  if($value['type'] == '1'|| $value['type'] == '3') {?>
                              <?php echo $value['motherName']; ?>
                             <?php if(!empty($value['motherAge'])){?>
                             (<?php echo $value['motherAge'];?>)<?php } else { ?>(<?php printf('%d years, %d month', $diff->y, $diff->m);?>)
                    <?php } } else { ?>
                          <?php echo $value['guardianName']; ?><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Gaurdian)
                    <?php } ?>
                  </td>
                  <td>
                   Total:<?php $countBaby = count($GetAllBaby);
                   if($countBaby != '0') {
                    ?>
                      <a href="<?php echo base_url();?>motherM/singleMotherBabies/<?php echo $value['motherId']; ?>">
                       <?php echo $countBaby; ?>
                     </a>
                  <?php } else { ?>
                    <?php echo $countBaby; ?>
                  <?php } ?>
                   <br>
                   <?php 
                   foreach ($GetAllBaby as $key => $vals) {  ?>
                    <a href="<?php echo base_url();?>babyM/viewBaby/<?php echo $vals['babyId'] ?>/<?php echo $vals['status']; ?>">
                      <img src="<?php echo base_url().'assets/images/baby_images/'.$vals['babyPhoto']; ?>" width="30" height="30">
                   </a>
                   <?php } ?>
                      
                    </td>
                  <td><?php echo $GetStatus['hospitalRegistrationNumber'] ;?></td>
                  <td><?php if ($value['motherMCTSNumber'] == '') {  echo"--"; } else {  echo $value['motherMCTSNumber']; } ?> </td>
                  <td> <?php  if($value['type'] == '1'|| $value['type'] == '3') {?>
                                <?php echo $value['motherMoblieNumber'] ;?>
                      <?php }   else { ?>
                                <?php echo $value['guardianNumber'] ;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Gaurdian)
                      <?php } ?>
                  </td>
                  
                  <td><?php echo date('d-m-Y g:i A', strtotime($value['addDate'])) ?></td>
                  <td><a href="<?php echo base_url();?>facility/updateFacility/<?php echo $GetFacilittyName['FacilityID'];?>"><?php if (!empty($GetFacilittyName['FacilityName'])) { echo $GetFacilittyName['FacilityName']; } else {  ?> </a><?php echo " N/A"; } ?></td>
                  <td>
                  <?php if($value['type'] == '1') { ?>
                            <span class="label label-success">Live</span>
                     <?php } else if($value['Type'] == '2') { ?>
                             <span class="label label-warning">Unknown</span>
                      <?php } else if($value['Type'] == '3') {?>
                            <span class="label label-danger">Died</span>
                     <?php  } ?>  

                     <?php if($GetStatus['status']=='1'){?>
                          <span class="label label-warning">Admitted</span>
                      <?php } else if($GetStatus['status']=='2'){?>
                          <span class="label label-success">Discharged</span>
                           <a href="<?php echo base_url();?>motherM/viewMother/<?php echo $value['motherId'];?>" style="font-size:10px;">View Report</a>
                    <?php }  else { ?>
                         <span class="label label-danger">Not Admitted</span>
                     <?php } ?>
                  </td>
                  <td><a href="<?php echo base_url();?>motherM/viewMother/<?php echo $value['motherId'];?>" class="btn btn-info">View</a></td>
                </tr>
                  <?php  $counter ++ ; } ?>
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
function Verfiy_Video(id,status) {
     var Vid= id;
     var url = "<?php echo site_url('admin/Dashboard/BannerStatus');?>/"+id;
    if(status == 1){  var r =  confirm("Are you sure! You want to Deactivate this Lounge ?");}
    if(status == 2){  var r =  confirm("Are you sure! You want to Activate this Lounge ?");}  
    if (r == true) {
    $.ajax({ 
      type: "POST", 
      url: url, 
      dataType: "text", 
      success:function(response){
        console.log(response);
        if(response == 1){ $('.status_img_'+id).attr('src','<?php echo base_url("assets/act.png")?>');} 
        if(response == 2){ $('.status_img_'+id).attr('src','<?php echo base_url("assets/delete.png")?>');}
        //console.log(response);
      }
    });
    }
  }
 

  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })


  
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
                title: 'Mothers List',
                exportOptions: {
                    columns: ':visible'
                }
            },{
                extend: 'pdf',
                title: 'Mothers List',
                exportOptions: {
                    columns: ':visible'
                }
            },{
                extend: 'excel',
                title: 'Mothers List',
                exportOptions: {
                    columns: ':visible'
                }
            },{
                extend: 'csv',
                title: 'Mothers List',
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
  