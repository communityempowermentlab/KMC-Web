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
      <h1><?php echo 'Date Wise Baby'; ?>
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
              <table cellpadding="0" cellspacing="0" border="0"
                class="table-striped table table-bordered editable-datatable example " id="example" >
                <thead>
                <tr>
                  <th style="width:70px;">SrNo.</th>
                  <th >Baby&nbsp;Photo</th>
                  <th>Baby&nbsp;Of</th>
                  <th>Baby&nbsp;File&nbsp;ID </th>
                  <th>MCTS&nbsp;No.</th>
                  <th>Gender</th>
                  <th>Delivery&nbsp;Date</th>
                  <th>Delivery&nbsp;Time</th>
                  <th>Delivery&nbsp;Type</th>
                  <th style="width:100px;">Reg.&nbsp;Date&nbsp;&&nbsp;Time</th>  
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                $counter ="1";
                 $status='0';
                foreach ($GetBaby as $value) {
                  $getBabyRecord = $this->BabyModel->getBabyRecord($value['BabyID']);
                  $GetDangerSign = $this->FacilityModel->GetBabyDanger($value['BabyID']);
                      if($GetDangerSign['BabyRespiratoryRate']>60 || $GetDangerSign['BabyRespiratoryRate']<30){    
                         $status = '1';
                         }
                      if($GetDangerSign['BabyTemperature'] < 95.9 || $GetDangerSign['BabyTemperature'] > 99.5){
                         $status = '1';
                         }
                      if($GetDangerSign['BabyPulseSpO2'] < 95){ 
                         $status = '1'; 
                         }
                       ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td style="width:70px;height:50px;">
                   <?php  if($value['BabyPhoto']=='NULL' || $value['BabyPhoto']==' NULL') { ?>
                               <img  src="<?php echo base_url();?>assets/images/baby.png"   style="height:100px;width:100px;margin-top:5px;">
                          <?php } else { ?>
                             <img  src="<?php echo base_url();?>assets/images/baby_images/<?php echo $value['BabyPhoto']?>" class="img-responsive">
                         <?php } ?>
                 </td>
                  <td><?php if($status=='0') {?>
                       <img src="<?php echo base_url();?>assets/images/happy-face.png" style="width:25px;height:25px;">&nbsp;
                     <?php } else if($status=='1'){?>
                       <img src="<?php echo base_url();?>assets/images/sad-face.png" style="width:25px;height:25px;">&nbsp;
                     <?php } ?>
                    <a href="<?php echo base_url();?>motherM/viewMother/<?php echo $value['MotherID'];?>"><?php echo singlerowparameter2('MotherName','MotherID',$value['MotherID'],'mother_registration') ?></a></td>
                  <td><?php echo ($getBabyRecord['BabyFileID']!=='') ?  $getBabyRecord['BabyFileID'] :'N/A' ?></td>
                  <td><?php echo ($value['BabyMCTSNumber']!=='') ? $value['BabyMCTSNumber'] :'--'?></td>
                  <td><?php echo $value['BabyGender'] ;?></td>
                  <td><?php echo $value['DeliveryDate'] ;?></td>
                  <td><?php echo date('g:i A',strtotime($value['DeliveryTime'])); ?></td>
                  <td><?php echo $value['DeliveryType'] ?></td>
                  <td><?php echo date('d-m-y g:i A ',$value['add_date']) ?></td>
                  <td><a href="<?php echo base_url();?>babyM/viewBaby/<?php echo $value['BabyID'] ?>/<?php echo $status;?>" class="btn btn-info">View</a></td>

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
                title: 'Babies List',
                exportOptions: {
                    columns: ':visible'
                }
            },{
                extend: 'pdf',
                title: 'Babies List',
                exportOptions: {
                    columns: ':visible'
                }
            },{
                extend: 'excel',
                title: 'Babies List',
                exportOptions: {
                    columns: ':visible'
                }
            },{
                extend: 'csv',
                title: 'Babies List',
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
