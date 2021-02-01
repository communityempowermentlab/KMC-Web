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
      <h1><?php echo $title; ?></h1>
    </section>
    <!-- Main content -->
<?php 
    $GetBaby = count($this->db->get_where('babyRegistration')->result_array()); 
    $tot = '0';
 ?>

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

                <tbody> 
                    <?php 
                        $t2 = Date('d-m-Y', strtotime("+1 day"));
                        $t1   = '05-05-2018';
                        $begin = new DateTime($t1);
                        $end = new DateTime($t2);

                        $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
                  foreach ($daterange as $key => $date) {
                    $dates[] = $date->format("Y-m-d");
                  }

                  $dates = array_reverse($dates);

                    $number = 0;
                    foreach($dates as $date){
                       $alldate = $date;
                       $t1 = date($alldate. ' 00:00:01');
                       $t2 = date($alldate. ' 23:59:59');
                       $Datefrom = strtotime($t1);
                       $Dateto   = strtotime($t2);
                        $startTimeStamp   = strtotime("2018/04/12");
                        $endTimeStamp     = strtotime($t2);
                        $timeDiff         = abs($endTimeStamp - $startTimeStamp);
                        $numberDays       = $timeDiff/86400; 
                        $numberDays       = intval($numberDays);  
                    ?>
                    <tr>      
                        <td><?= $sendDate = date("d-m-Y",strtotime($date)); ?></td> 
                      <?php 
                        $maxData = array();
                           // foreach ($Getlounge as $key=> $value) { 
                           //  $Getbaby      = count($this->db->query("select * from babyRegistration as br left join baby_admission as ba on br.`BabyID`=ba.`BabyId` where ba.`LoungeId`=".$value['LoungeID']." and (br.`add_date` between ".$Datefrom." and ".$Dateto.")")->result_array()); 
                           //      $first  = $Getbaby;
                           //      $temp 
                           //    // if($first != 0):
                           //    //     $temp = $first;
                           //    // endif;
                           //    //  if($Getbaby > $temp){
                           //    //     $temp = $Getbaby;
                           //    //  }
                           //   }
                             for($i = 0;  $i < count($Getlounge); $i++){
                                   $Getbaby = count($this->db->query("select * from babyRegistration as br left join baby_admission as ba on br.`BabyID`=ba.`BabyId` where ba.`LoungeId`=".$Getlounge[$i]['LoungeID']." and (br.`add_date` between ".$Datefrom." and ".$Dateto.")")->result_array()); 
                                   $maxData[] = $Getbaby;
                             }
                          foreach ($Getlounge as $key=> $value) { 
                            $GetMother    = count($this->db->query("select * from mother_registration as mr left join mother_admission as ma on ma.`MotherID`=mr.`MotherID` where ma.`LoungeID`=".$value['LoungeID']." and (mr.`AddDate` between ".$Datefrom." and ".$Dateto.")")->result_array()); 
                            $Getbaby      = count($this->db->query("select * from babyRegistration as br left join baby_admission as ba on br.`BabyID`=ba.`BabyId` where ba.`LoungeId`=".$value['LoungeID']." and (br.`add_date` between ".$Datefrom." and ".$Dateto.")")->result_array());                            
                         ?>
                            <td><?php 
                              if($GetMother == '0'){
                        ;        echo $GetMother;
                              }else{
                                echo $GetMother;
                                echo "<a href='".base_url('Admin/dateWiseMother/').$value['LoungeID'].'/'. $sendDate."'>".$GetMother."</a>";
                              }

                             ?></td>
                            
                              <?php 
                                $temp =  max($maxData);
                               if($temp == $Getbaby && $temp != 0){
                                 echo "<td style='color:black;background:yellow;'>".$temp."</span></td>";
                               }else{
                                echo '<td>'.$Getbaby.'</td>'; 
                               }
                              ?>

                            
                       
                        <?php } ?>
                    </tr>
                   <?php }  ?> 
                </tbody>



                <thead>
                   <tr>
                      <th>Registration Date</th>
                        <?php 

                  $Startdate     = "2018-05-05 00:00:01"; 
                  $EndDate       = date('Y-m-d H:i:s');
                  $DateStart     = strtotime($Startdate);
                  $DateEnd       = strtotime($EndDate);
                          foreach ($Getlounge as $key=> $value) {  
                    $CountingMother    = count($this->db->query("select * from mother_registration as mr left join mother_admission as ma on ma.`MotherID`=mr.`MotherID` where ma.`LoungeID`=".$value['LoungeID']." and (mr.`AddDate` between ".$DateStart." and ".$DateEnd.")")->result_array()); 

                    $CountingBaby     = count($this->db->query("select * from babyRegistration as br left join baby_admission as ba on br.`BabyID`=ba.`BabyId` where ba.`LoungeId`=".$value['LoungeID']." and (br.`add_date` between ".$DateStart." and ".$DateEnd.")")->result_array()); 

                            ?>
                            <th>
                             <?php echo $value['LoungeName'].' Mother<br>'; ?>  
                             <?php echo 'Total: '.$CountingMother; ?>  
                            </th>
                       
                            <th>
                             <?php echo $value['LoungeName'].' Baby<br>'; ?>
                              <?php echo 'Total: '.$CountingBaby; ?>  
                            </th>                       
                        <?php } ?>
                   </tr>
                </thead>


               </table>
             </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>  
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
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
  <script src="http://cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js"></script>
  <script type="text/javascript" charset="utf-8">
      $(document).ready(function() {
        var fileNamed = 'Lounge_Wise_Report_List';
        $('.example').DataTable({
        order: [[0, 'desc']],
        paging: false,
        dom: 'Bfrtip',
        buttons: [
            'pageLength',
            {
                extend: 'pdf',
                title: fileNamed,
                exportOptions: {
                    columns: ':visible'
                }
            },{
                extend: 'excel',
                title: fileNamed,
                exportOptions: {
                    columns: ':visible'
                }
            },{
                extend: 'csv',
                title: fileNamed,
                exportOptions: {
                    columns: ':visible'
                }
            }
        ]
  
      });
    });                    
                       
    </script>
