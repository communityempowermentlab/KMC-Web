<?php 

  $Lounge = $this->uri->segment('5'); 

  $loungeData = $this->db->query("SELECT * FROM `loungeMaster` WHERE `loungeId` = ".$Lounge."")->row_array();
  $loungeName = str_replace(' ', '_', $loungeData['loungeName']);
   header('Content-Type: application/vnd.ms-excel');  
   header('Content-disposition: attachment; filename= FeedingReportFor'.$loungeName.'.xls'); 
    $GetBaby = count($this->db->get_where('babyRegistration')->result_array()); 
    $tot = '0';
    $fromDate =$this->uri->segment('3'); 
    $toDate = $this->uri->segment('4'); 
    

    $from = date("Y-m-d 00:00:00",strtotime("+1 month", strtotime($fromDate)));  
    $to   = date("Y-m-d 23:59:59",strtotime("+1 month", strtotime($toDate)));  

    $getMaxCount    = $this->db->query("SELECT COUNT( DISTINCT feedDate) as val FROM `babyDailyNutrition` INNER JOIN babyAdmission  on babyAdmission.id = babyDailyNutrition.babyAdmissionId WHERE babyAdmission.`loungeId` = ".$Lounge." and babyAdmission.addDate BETWEEN '".$from."' AND '".$to."' GROUP by babyDailyNutrition.babyAdmissionId")->result_array();
    
    if(!empty($getMaxCount)) {
      $keys = array_keys($getMaxCount, max($getMaxCount));
      $Key  = $keys[0];
      
      // $max_arr = max($getMaxCount);
      $max = $getMaxCount[$Key]['val']; 


      $babyList = $this->db->query("select * from babyRegistration as br inner join babyAdmission  as ba on ba.`babyid`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`loungeId`=".$Lounge." AND ba.`addDate` between '".$from."' AND '".$to."' order By ba.`id` desc")->result_array();
                 
    
 ?>


                <table id="employee_table" border="1">
                <thead>
                   <tr>
                      <th>Baby Of</th>
                      <th>Baby File ID</th>

                      <?php for($i=1; $i<=$max; $i++) { ?>
                        <th>D<?= $i; ?> (No. Of Times)</th>
                        <th>D<?= $i; ?> Total Time (min)</th>
                        <th>D<?= $i; ?> Total Quantity (ml)</th>
                      <?php } ?>
                        
                   </tr>
                </thead>

                <tbody>
                  <?php foreach ($babyList as $key => $value) {

                    $feedList = $this->db->query("SELECT feedDate, COUNT(id) as num , sum(breastFeedDuration) as totalfeed , sum(milkQuantity) as totalml FROM `babyDailyNutrition` WHERE `babyAdmissionId` = ".$value['id']." GROUP BY feedDate")->result_array();

                   ?>
                    <tr>
                      <td><?= $value['motherName']; ?></td>
                      <td><?= $value['babyFileId']; ?></td>

                      <?php for($j=0; $j<$max; $j++ ) { ?>
                        <td><?php if(isset($feedList[$j])) { echo $feedList[$j]['num']; } else { echo 0; } ?></td>
                        <td><?php if(isset($feedList[$j])) { echo $feedList[$j]['totalfeed']; } else { echo 0; } ?></td>
                        <td><?php if(isset($feedList[$j])) { echo $feedList[$j]['totalml']; } else { echo 0; } ?></td>
                      <?php } ?>


                    </tr>
                  <?php } ?>
                </tbody>
                
               </table>

  <?php } else {
    echo '<table id="employee_table" border="1"><tbody>No Records Found.</tbody></table>';

  } ?>