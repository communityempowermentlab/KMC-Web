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
      <h1><?php echo 'Sent SMS'; ?>
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
                  <th>Baby&nbsp;Photo</th>
                  <th>Baby&nbsp;Of</th>
                  <th>Facility&nbsp;Name</th>
                  <th>Doctor&nbsp;Name</th>
                  <th>Message</th>
                  <th>Sent&nbsp;Time</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                $counter ="1";
              
                foreach ($GetSms as $value) {
                  $GetFacilittyName = $this->SmsModel->GetFacilityName($value['FacilityID']);
                  $BabyDetail = $this->SmsModel->getBabyById($value['BabyID']);
                  $MotherName = $this->load->SmsModel->getMotherDataById('mother_registration',$BabyDetail['MotherID']);
                  $this->db->order_by('id','desc');
                  $getMotherAdmId = $this->db->get_where('mother_admission',array('MotherID'=>$MotherName['MotherID']))->row_array();
                  $doctorName = $this->load->SmsModel->getDoctorByMobile($value['SendTo']);
                  ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td style="width:70px;height:50px; !important"> <img  src="<?php echo base_url();?>assets/images/baby_images/<?php echo $BabyDetail['BabyPhoto']?>" class="img-responsive" style="width:70px;height:70px;"></td>
                  <td><a href="<?php echo base_url();?>motherM/viewMother/<?php echo $getMotherAdmId['id'];  ?>"><?php echo $MotherName['MotherName'];?></td>
                  <td><a href="<?php echo base_url();?>facility/updateFacility/<?php echo $value['FacilityID'];?>"><?php echo $GetFacilittyName['FacilityName'] ;?></a></td>
                  <td><a href="<?php echo base_url();?>staffM/updateStaff/<?php echo $doctorName['StaffID'];?>"><?php echo $doctorName['Name'] ;?></a><br/><?php echo $value['SendTo'] ;?></td>
                  <td><?php echo $value['Messege'] ;?></td> 
                  <td>
                    <?php echo  $time_ago=date("d-m-Y g:i A",$value['AddDate']);?><br/>
                    <span class="label label-success">Delivered</span>
                  </td> 
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
                title: 'Sent SMS List',
                exportOptions: {
                    columns: ':visible'
                }
            },{
                extend: 'pdf',
                title: 'Sent SMS List',
                exportOptions: {
                    columns: ':visible'
                }
            },{
                extend: 'excel',
                title: 'Sent SMS List',
                exportOptions: {
                    columns: ':visible'
                }
            },{
                extend: 'csv',
                title: 'Sent SMS List',
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
