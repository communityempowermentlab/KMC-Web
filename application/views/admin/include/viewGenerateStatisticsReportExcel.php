<?php 
 header('Content-Type: application/vnd.ms-excel');  
 header('Content-disposition: attachment; filename= ReportList_'.rand().'.xls'); 
    $GetBaby = count($this->db->get_where('babyRegistration')->result_array()); 
    $tot = '0';
 ?>


                <table border="1" id="employee_table">

                <thead>
                   <tr>
                      <th>Lounge&nbsp;Name</th>
                        <?php 

                        $t2   = $date1;
                        $t1   = $date2; 
                        
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

                            <th style="white-space: nowrap;">
                             <?= $sendDate = date("d-m-Y",strtotime($date)); ?> 
                            </th>
                       
                                                 
                        <?php } ?>
                   </tr>
                </thead>
          

                <tbody> 
                  <?php 
                        $Startdate     = $date3;  
                        $EndDate       = $date4;
                        $DateStart     = $Startdate;
                        $DateEnd       = $EndDate;
                    ?>
                    
                      <?php foreach ($Getlounge as $key=> $value) {   
                        $CountingMother    = count($this->db->query("select * from motherRegistration as mr left join motherAdmission as ma on ma.`motherId`=mr.`motherId` where ma.`loungeId`=".$value['loungeId']." and (mr.`addDate` between '".$DateStart."' and '".$DateEnd."')")->result_array()); 

                      ?>
                       <tr> <td><b><?php echo $value['loungeName'].' Mother<br>'; ?>  
                             <?php echo 'Total: '.$CountingMother; ?> </b></td> 
                      <?php 
                       

                        $CountingBaby     = count($this->db->query("select * from babyRegistration as br left join babyAdmission as ba on br.`babyId`=ba.`babyId` where ba.`loungeId`=".$value['loungeId']." and (br.`addDate` between '".$DateStart."' and '".$DateEnd."')")->result_array()); 


                        $number = 0;
                        foreach($dates as $date){ 
                           $alldate = $date;
                           $t1 = date($alldate. ' 00:00:01'); 
                           $t2 = date($alldate. ' 23:59:59'); 
                           $Datefrom = $t1;
                           $Dateto   = $t2;
                            $startTimeStamp   = strtotime("2018/04/12");
                            $endTimeStamp     = strtotime($t2);
                            $timeDiff         = abs($endTimeStamp - $startTimeStamp);
                            $numberDays       = $timeDiff/86400; 
                            $numberDays       = intval($numberDays);  
                        
                    
                            $GetMother    = count($this->db->query("select * from motherRegistration as mr left join motherAdmission as ma on ma.`motherId`=mr.`motherId` where ma.`loungeId`=".$value['loungeId']." and (mr.`addDate` between '".$Datefrom."' and '".$Dateto."')")->result_array()); 
                                                        
                         ?>
                            <td><?php 
                              if($GetMother == '0'){
                                echo $GetMother;
                              }else{
                                echo $GetMother;
                              }
                             ?></td>
                            
                              <?php }
                                
                              ?>

                          </tr>    
                          <tr> <td><b><?php echo $value['loungeName'].' Baby<br>'; ?>
                              <?php echo 'Total: '.$CountingBaby; ?> </b> </td> 
                        <?php  
                          foreach($dates as $date){ 
                           $alldate = $date;
                           $t1 = date($alldate. ' 00:00:01');
                           $t2 = date($alldate. ' 23:59:59');
                           $Datefrom = $t1;
                           $Dateto   = $t2;
                            $startTimeStamp   = strtotime("2018/04/12");
                            $endTimeStamp     = strtotime($t2);
                            $timeDiff         = abs($endTimeStamp - $startTimeStamp);
                            $numberDays       = $timeDiff/86400; 
                            $numberDays       = intval($numberDays);  
                            $maxData = array();
                            for($i = 0;  $i < count($Getlounge); $i++){
                              $Getbaby = count($this->db->query("select * from babyRegistration as br left join babyAdmission as ba on br.`babyId`=ba.`BabyId` where ba.`LoungeId`=".$Getlounge[$i]['loungeId']." and (br.`addDate` between '".$Datefrom."' and '".$Dateto."')")->result_array()); 
                               
                              $maxData[] = $Getbaby;
                            }

                            $Getbaby = count($this->db->query("select * from babyRegistration as br left join babyAdmission as ba on br.`babyId`=ba.`BabyId` where ba.`LoungeId`=".$value['loungeId']." and (br.`addDate` between '".$Datefrom."' and '".$Dateto."')")->result_array());

                        ?>

                          <?php 
                                $temp =  max($maxData);
                                if($temp == $Getbaby && $temp != 0){
                                 echo "<td>".$temp."</td>";
                               }else{
                                 if($Getbaby == 0){
                                  echo "<td>".$Getbaby."</td>";
                                 }else{
                                  echo "<td>".$Getbaby."</td>";
                                 }
                               }
                              ?>
                           <?php } ?>
                          </tr>                        
                       
                        <?php } ?>
                    
                  
                </tbody>



                
               </table>