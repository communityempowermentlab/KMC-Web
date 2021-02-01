<?php 

  $Lounge = $this->uri->segment('5'); 

  $loungeData = $this->db->query("SELECT * FROM `loungeMaster` WHERE `loungeId` = ".$Lounge."")->row_array();
  $loungeName = str_replace(' ', '_', $loungeData['loungeName']);
    header('Content-Type: application/vnd.ms-excel');  
    header('Content-disposition: attachment; filename= AdmissionReportFor'.$loungeName.'.xls'); 
    
    $tot = '0';
    $fromDate =$this->uri->segment('3'); 

    $toDate = $this->uri->segment('4'); 
    

    $from = strtotime(date("Y-m-d 00:00:00",strtotime("+1 month", strtotime($fromDate))));  
    $to   = strtotime(date("Y-m-d 23:59:59",strtotime("+1 month", strtotime($toDate)))); 
    
                 
    
 ?>


                <table id="employee_table" border="1">
                <thead>
                   <tr>
                      <th>Month</th>
                      <th>Total Mother</th>
                      <th>Total Babies</th>
                      
                        
                   </tr>
                </thead>
                
                <tbody>
                  <?php

                    while($from <= $to)
                    {

                        $startDate = date('Y-m-01 00:00:00', $from);
                        $endDate = date('Y-m-31 23:59:59', $from);

                        $month = date('F Y', $from); 
                        
                        $getBabyCount = $this->db->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` where ba.`loungeId`=".$Lounge." AND ba.`addDate` between '".$startDate."' AND '".$endDate."' order By ba.`id` desc")->num_rows();

                        $getMotherCount = $this->db->query("SELECT * FROM `motherAdmission` WHERE `loungeId` = ".$Lounge." AND addDate between '".$startDate."' AND '".$endDate."'")->num_rows();
                       
                        $from = strtotime("+1 month", $from);
                        

                  ?>
                    <tr>
                      <td><?php echo $month; ?></td>
                      <td><?php echo $getMotherCount; ?></td>
                      <td><?php echo $getBabyCount; ?></td>
                    </tr>
                  <?php

                    }

                  ?>
                </tbody>
                
               </table>