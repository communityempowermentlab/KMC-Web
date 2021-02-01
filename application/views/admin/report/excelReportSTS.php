<?php 

  $Lounge = $this->uri->segment('5');

  $loungeData = $this->db->query("SELECT * FROM `loungeMaster` WHERE `loungeId` = ".$Lounge."")->row_array();
  $loungeName = str_replace(' ', '_', $loungeData['loungeName']);
    header('Content-Type: application/vnd.ms-excel');  
    header('Content-disposition: attachment; filename= KMCReportFor'.$loungeName.'.xls'); 
    $GetBaby = count($this->db->get_where('babyRegistration')->result_array()); 
    $tot = '0';
    $fromDate =$this->uri->segment('3'); 
    $toDate = $this->uri->segment('4'); 
     

    $from = date("Y-m-d 00:00:00",strtotime("+1 month", strtotime($fromDate)));  
    $to   = date("Y-m-d 23:59:59",strtotime("+1 month", strtotime($toDate)));    

    $getMaxCount    = $this->db->query("SELECT COUNT( DISTINCT startDate) as val FROM `babyDailyKMC` INNER join babyAdmission on babyAdmission.id = babyDailyKMC.babyAdmissionId WHERE babyAdmission.`loungeId` = ".$Lounge." and babyAdmission.addDate BETWEEN '".$from."' AND '".$to."' GROUP by babyDailyKMC.babyAdmissionId")->result_array(); 
    
    if(!empty($getMaxCount)) {

      $keys = array_keys($getMaxCount, max($getMaxCount));
      $Key  = $keys[0];
      
      // $max_arr = max($getMaxCount);
      $max = $getMaxCount[$Key]['val']; 

      $babyList = $this->db->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`loungeId`=".$Lounge." AND ba.`addDate` between '".$from."' AND '".$to."' order By ba.`id` desc")->result_array();
                   
      
   ?>


                  <table id="employee_table" border="1">
                  <thead>
                     <tr>
                        <th>Baby Of</th>
                        <th>Baby File ID</th>

                        <?php for($i=1; $i<=$max; $i++) { ?>
                          <th>D<?= $i; ?></th>
                          
                        <?php } ?>
                        <th>Total (In Hours)</th>
                        <th>Average (In Hours)</th>
                          
                     </tr>
                  </thead>
                  
                  <tbody>
                    <?php foreach ($babyList as $key => $value) {

                      $stsList = $this->db->query("select startDate, sum(TIME_TO_SEC(subtime(endTime,startTime))) as kmc from babyDailyKMC where babyAdmissionId = ".$value['id']." GROUP by startDate")->result_array();

                      $total = 0;
                      $countAvg = count($stsList);
                     ?>
                      <tr>
                        <td><?= $value['motherName']; ?></td>
                        <td><?= $value['babyFileId']; ?></td>

                        <?php for($j=0; $j<$max; $j++ ) { ?>
                          <td><?php if($countAvg != 0) { echo gmdate("H.i", $stsList[$j]['kmc']);  ?></td>
                          
                        <?php $total = $total + $stsList[$j]['kmc']; } }
                              
                         ?>

                        <td><?= gmdate("H.i", $total); ?></td>

                        <?php if($countAvg != 0) { $avg = $total/$countAvg; } else { $avg = 0; } ?>

                        <td><?= gmdate("H.i", $avg); ?></td>

                      </tr>
                    <?php } ?>
                  </tbody>
                  
                 </table>

  <?php } else {
    echo '<table id="employee_table" border="1"><tbody>No Records Found.</tbody></table>';

  } ?>              