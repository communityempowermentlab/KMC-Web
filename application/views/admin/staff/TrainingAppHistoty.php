<?php $adminData = $this->session->userdata('adminData');?>
<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
<style type="text/css">
.progress{
    width: 150px;
    height: 150px;
    line-height: 150px;
    background: none;
    margin: 0 auto;
    box-shadow: none;
    position: relative;
        margin-bottom: 44px;
}
.progress:after{
    content: "";
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 12px solid #fff;
    position: absolute;
    top: 0;
    left: 0;
}
.progress > span{
    width: 50%;
    height: 100%;
    overflow: hidden;
    position: absolute;
    top: 0;
    z-index: 1;
}
.progress .progress-left{
    left: 0;
}
.progress .progress-bar{
    width: 100%;
    height: 100%;
    background: none;
    border-width: 12px;
    border-style: solid;
    position: absolute;
    top: 0;
}
.progress .progress-left .progress-bar{
    left: 100%;
    border-top-right-radius: 80px;
    border-bottom-right-radius: 80px;
    border-left: 0;
    -webkit-transform-origin: center left;
    transform-origin: center left;
}
.progress .progress-right{
    right: 0;
}
.progress .progress-right .progress-bar{
    left: -100%;
    border-top-left-radius: 80px;
    border-bottom-left-radius: 80px;
    border-right: 0;
    -webkit-transform-origin: center right;
    transform-origin: center right;
    animation: loading-1 1.8s linear forwards;
}
.progress .progress-value{
    width: 90%;
    height: 90%;
    border-radius: 50%;
    background: #44484b;
    font-size: 24px;
    color: #fff;
    line-height: 135px;
    text-align: center;
    position: absolute;
    top: 5%;
    left: 5%;
}
.progress.blue .progress-bar{
    border-color: #049dff;
}
.progress.blue .progress-left .progress-bar{
    animation: loading-2 1.5s linear forwards 1.8s;
}
.progress.yellow .progress-bar{
    border-color: #fdba04;
}
.progress.yellow .progress-left .progress-bar{
    animation: loading-3 1s linear forwards 1.8s;
}
.progress.pink .progress-bar{
    border-color: #ed687c;
}
.progress.pink .progress-left .progress-bar{
    animation: loading-4 0.4s linear forwards 1.8s;
}
.progress.green .progress-bar{
    border-color: #1abc9c;
}
.progress.green .progress-left .progress-bar{
    animation: loading-5 1.2s linear forwards 1.8s;
}
@keyframes loading-1{
    0%{
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100%{
        -webkit-transform: rotate(180deg);
        transform: rotate(180deg);
    }
}
@keyframes loading-2{
    0%{
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100%{
        -webkit-transform: rotate(144deg);
        transform: rotate(144deg);
    }
}
@keyframes loading-3{
    0%{
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100%{
        -webkit-transform: rotate(90deg);
        transform: rotate(90deg);
    }
}
@keyframes loading-4{
    0%{
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100%{
        -webkit-transform: rotate(36deg);
        transform: rotate(36deg);
    }
}
@keyframes loading-5{
    0%{
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100%{
        -webkit-transform: rotate(126deg);
        transform: rotate(126deg);
    }
}
@media only screen and (max-width: 990px){
    .progress{ margin-bottom: 20px; }
}
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
      <h1><?php echo 'Staff Training App Session & Point History'; ?>
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
                        $GetNurseDetail = $this->UserModel->getStaffNameBYID($StaffIDs);
                        $TotalCreditNursePoint    = $this->db->query("SELECT SUM(Points) as creditPoint from pointstransactions where NurseId=".$StaffIDs." and TransactionStatus='Credit' and Type='17'")->row_array();
                    
                         if(empty($GetNurseDetail['ProfilePic'])) { ?>
                      
                               <img  src="<?php echo base_url();?>assets/nurse/default.png" style="height:150px;width:140px;">
                             
                          <?php } else { ?>
                             <img  src="<?php echo base_url();?>assets/nurse/<?php echo $GetNurseDetail['ProfilePic']?>" style="height:150px;width:140px;" class="img-responsive">
                         <?php } ?>
                       </div>
                       <div class="col-sm-8" style="padding-left:10px;">
                        <span style="font-size: 20px;"><?php echo $GetNurseDetail['Name']; ?></span><br>
                        <b>Score Point &nbsp;&nbsp;&nbsp;</b><?php echo $TotalCreditNursePoint['creditPoint']; ?>
                          </b>
                       </div>
                     </div>
                     <div class="col-sm-3"><br>

                     </div>
                </div>
           </div>
        </div>  


          <div class="box">
            <div class="box-body">
                <div class="row">
                  <?php $getSession =$this->db->query("SELECT * FROM trainingapp_manage_session where userType='1' ORDER BY id asc LIMIT 0,100")->result_array();
                       foreach ($getSession as $key => $value) 
                       { ?>
                    <div class="col-md-3 col-sm-6 text-center">
                      <a href="<?php echo base_url();?>staffM/sessionWiseHistory/<?php echo $StaffIDs;?>/<?php echo $value['id'];?>">
                    <?php if(!empty($value['thumbnail'])){ ?>
                        <img src="http://localhost/trainingapp/uploads/session/<?php echo $value['thumbnail']; ?>" style="height:140px;width:140px;border:1px solid #ccc" class="img-circle">
                  <?php } else{ ?>
                        <img  src="http://localhost/trainingapp/uploads/session/d4ddc7c2c4876dafcb2173a19d89e353.gif" style="height:140px;width:140px;border:1px solid #ccc;" class="img-circle">
                <?php } ?>
                        <br><div style="padding-top:10px;padding-bottom:10px;font-weight:normal;font-size:20px;"><?php echo $value['session_name']; ?></div>
                    </div>
                  <?php } ?>
                </a>
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
<!--                 <div class="row">
                  <?php $i=1;
                       while($i<= 5){ ?>
                    <div class="col-md-3 col-sm-6 text-center">
                        <div class="progress blue">
                            <span class="progress-left">
                                <span class="progress-bar"></span>
                            </span>
                            <span class="progress-right">
                                <span class="progress-bar"></span>
                            </span>
                            <div class="progress-value">90%</div>

                        </div>
                        <span style="font-s;margin-top: -21px;position: absolute;right: 42%;">session</span>
                    </div>
                  <?php $i++;} ?>
                </div> -->