<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
<style type="text/css">
  .coloring{
    border: 1px solid #999;
    color: black;
    background-color: #e9e9e9;
    margin-bottom: 2px;
  }
</style>
<style type="text/css">
/*.sticky {
  position: fixed !important;
  top: 50px !important;
  width: 95% !important;
  padding-right: 18% !important;
  overflow: hidden;
  z-index: 999;
  height: 100px;
}
.nav-tabs {
    background-color: #fff;
  }*/
</style>
<style type="text/css">
.purple{
  border:2px solid #9B59B6;
}

.purple thead{
  background:#9B59B6;
}

th,td{
  text-align:center;
  padding:5px 0;
}

tbody tr:nth-child(even){
  background:#ECF0F1;
}


.fixed{
  top:50px;
  position:fixed;
  width:100%;
  display:none;
  border:none;
  overflow: hidden;
  z-index: 999;
}
.nav-tabs {
    background-color: #fff;
  }
.up{
  cursor:pointer;
}
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
           <span style="font-size: 20px;">Manage Resources:</span> [<a href="" data-toggle="modal" data-target="#dfdModal">DataFlow Diagram</a>][<a href="" data-toggle="modal" data-target="#myModal">Functional Diagram</a>]
          
            <div class="box-body" >
              <div class="col-sm-12" style="overflow: auto;">
                 <div class="text-right;"><button name="create_excel" id="create_excel" class="btn btn-info coloring">Download Report</button></div>
                <table cellpadding="0" cellspacing="0" border="0"
                class="table-striped table table-bordered editable-datatable example" id="employee_table">

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
                                echo $GetMother;
                              }else{
                                echo "<a href='".base_url('Admin/dateWiseMother/').$value['LoungeID'].'/'. $sendDate."'>".$GetMother."</a>";
                              }
                             ?></td>
                            
                              <?php 
                                $temp =  max($maxData);
                                if($temp == $Getbaby && $temp != 0){
                                 echo "<td style='color:black;background:yellow;'><a href='".base_url('Admin/dateWiseBaby/').$value['LoungeID'].'/'. $sendDate."'>".$temp."</a></span></td>";
                               }else{
                                 if($Getbaby == 0){
                                  echo "<td>".$Getbaby."</td>";
                                 }else{
                                  echo "<td><a href='".base_url('Admin/dateWiseBaby/').$value['LoungeID'].'/'. $sendDate."'>".$Getbaby."</a></td>";
                                 }
                               }
                              ?>

                            
                       
                        <?php } ?>
                    </tr>
                   <?php }  ?> 
                </tbody>



                <thead class="nav-tabs">
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

<!-- dfd and functional -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Manage Report Functional Diagram</h4>
        </div>
        <div class="modal-body text-center">
         <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/motherBaby.png') ;?>" style="height:300px;width:100%;"> 
      
        </div>
      </div>
      
    </div>
  </div>

  <div class="modal fade" id="dfdModal" role="dialog">
    <div class="modal-dialog modal-lg" style="width:850px !important">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Manage Report DataFlow Diagram (DFD)</h4>
        </div>
        <div class="modal-body" style="padding:0px !important;">
         <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/manageReport.png') ;?>" style="height:900px;width:100%;">

        </div>
      </div>
    </div>
  </div>

<script type="text/javascript" charset="utf-8">
                       
      $(document).ready(function() {
        var fileNamed = 'Lounge_Wise_Report_List';
    });                    
</script>

<script>  
 $(document).ready(function(){  
   $('#create_excel').click(function(){ 
    var s_url = '<?php echo base_url('Admin/excelGenerate'); ?>';
    window.location.href = s_url;
 });
});   
</script>  
 <script>
   // window.onscroll = function() {myFunction()};
   // var header = document.getElementById("myHeader");
    //var sticky = header.offsetTop;

/*    function myFunction() {
      if (window.pageYOffset > sticky) {
        header.classList.add("sticky");
      } else {
        header.classList.remove("sticky");
      }
    }*/
</script>
<script type="text/javascript">
  ;(function($) {
   $.fn.fixMe = function() {
      return this.each(function() {
         var $this = $(this),
            $t_fixed;
         function init() {
            $t_fixed = $this.clone();
            $t_fixed.find("tbody").remove().end().addClass("fixed").insertBefore($this);
            resizeFixed();
         }
         function resizeFixed() {
           $t_fixed.width($this.outerWidth());
            $t_fixed.find("th").each(function(index) {
               $(this).css("width",$this.find("th").eq(index).outerWidth()+"px");
            });
         }
         function scrollFixed() {
            var offsetY = $(this).scrollTop(),
            offsetX = $(this).scrollLeft(),
            tableOffsetTop = $this.offset().top,
            tableOffsetBottom = tableOffsetTop + $this.height() - $this.find("thead").height(),
            tableOffsetLeft = $this.offset().left;
            if(offsetY < tableOffsetTop || offsetY > tableOffsetBottom)
               $t_fixed.hide();
            else if(offsetY >= tableOffsetTop && offsetY <= tableOffsetBottom && $t_fixed.is(":hidden"))
               $t_fixed.show();
            $t_fixed.css("left", tableOffsetLeft - offsetX + "px");
         }
         $(window).resize(resizeFixed);
         $(window).scroll(scrollFixed);
         init();
      });
   };
})(jQuery);

$(document).ready(function(){
   $("table").fixMe();
/*   $(".up").click(function() {
      $('html, body').animate({
      scrollTop: 100
   }, 2000);
 });*/
});
</script>