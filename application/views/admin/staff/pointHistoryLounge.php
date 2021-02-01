<?php $adminData = $this->session->userdata('adminData');
      $GetLoungeDetail          = $this->db->get_where('lounge_master',array('LoungeID'=>$LoungeId))->row_array();
      $TotalCreditLoungePoint   = $this->db->query("SELECT SUM(Points) as creditPoint from pointstransactions where LoungeID=".$LoungeId." and TransactionStatus='Credit'")->row_array();
      $TotalDebitLoungePoint    = $this->db->query("SELECT SUM(Points) as debitPoint from pointstransactions where LoungeID=".$LoungeId." and TransactionStatus='Debit'")->row_array();
?>
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
  .setSize{
    width: 25px;
    height: 25px;
  }
</style>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo $GetLoungeDetail['LoungeName'].' Points History'; ?>
       <span style="float: right;">
        <?php echo 'Total Points: '.($TotalCreditLoungePoint['creditPoint'] - $TotalDebitLoungePoint['debitPoint']); ?>
        </span>
      </h1>
      
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="row" style="padding-right: 10px; padding-left: 10px;margin-top: 5px;">
            <div class="col-md-4">
                <?php
                   
                 if(isset($totalResult)) { 
                    ($pageNo == '1') ?  $counter = '1' : $counter = ((($pageNo*100)-100) + 1);
                     echo '<br>Showing '.$counter.' to '.((($pageNo*100)-100) + 100).' of '.$totalResult.' entries';
                 } ?>
             </div> 
             <div class="col-md-8">
                <form action="" method="GET">
                    <div class="input-group pull-right">
                        <input type="text" class="form-control" placeholder="Enter Points" 
                               name="keyword" value="<?php
                               if (!empty($_GET['keyword'])) {
                                   echo $_GET['keyword'];
                               }
                               ?>">

                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                        </span>

                    </div>
                 <!--     <br><span style="font-size:12px;">Search via: Mother Name, Message etc.</span> -->
                </form>
             </div>
            </div> 
            <div class="box-body">
              <table cellpadding="0" cellspacing="0" border="0"
                class="table-striped table table-bordered editable-datatable example" id="example" >
                <thead>
                <tr>
                  <th>S&nbsp;No.</th>
                  <th>Message</th>
                  <th>At&nbsp;the&nbsp;time&nbsp;Of</th>
                  <th>Points</th>
                  <th>Status</th>
                  <th>DateTime</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                 ($pageNo == '1') ? $counter = '1' : $counter = ((($pageNo*100)-100) + 1);
                foreach ($results as $value) {
                 $GetNurseDetail = $this->UserModel->getStaffNameBYID($value['NurseId']);
                 ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td>
                    <?php
            if($value['Type']=='1'){
              echo'<img src="'.base_url().'assets/images/svg/Registration-01.svg" class="setSize">'."&nbsp;";
              $getbaby = $this->db->get_where('baby_admission',array('id'=>$value['GrantedForID']))->row_array();
              $getMother = $this->db->get_where('babyRegistration',array('BabyID'=>$getbaby['BabyID']))->row_array();
              $getMotherName = $this->db->get_where('mother_registration',array('MotherID'=>$getMother['MotherID']))->row_array();
             echo "Points Credited for Registering ".(!empty($getMotherName['MotherName']) ? "B/O ".$getMotherName['MotherName'] : 'B/O UNKNOWN');; 
            }else if($value['Type']=='2'){
             echo'<img src="'.base_url().'assets/images/svg/Daily Weight.svg" class="setSize">'."&nbsp;";
              $getbaby = $this->db->get_where('baby_weight_master',array('ID'=>$value['GrantedForID']))->row_array();
              $getMother = $this->db->get_where('babyRegistration',array('BabyID'=>$getbaby['BabyID']))->row_array();
              $getMotherName = $this->db->get_where('mother_registration',array('MotherID'=>$getMother['MotherID']))->row_array();
               echo "Points Credited for Saving Daily Weigth of ".(!empty($getMotherName['MotherName']) ? "B/O ".$getMotherName['MotherName'] : 'B/O UNKNOWN');
            }else if($value['Type']=='3'){
             echo'<img src="'.base_url().'assets/images/svg/Daily Assessment.svg" class="setSize">'."&nbsp;";              
              $getbaby = $this->db->get_where('baby_monitoring',array('id'=>$value['GrantedForID']))->row_array();
              $getMother = $this->db->get_where('babyRegistration',array('BabyID'=>$getbaby['BabyID']))->row_array();
              $getMotherName = $this->db->get_where('mother_registration',array('MotherID'=>$getMother['MotherID']))->row_array();
               echo "Points Credited for Doing Assessment of ".(!empty($getMotherName['MotherName']) ? "B/O ".$getMotherName['MotherName'] : 'B/O UNKNOWN');
            }else if($value['Type']=='4'){
            echo'<img src="'.base_url().'assets/images/svg/Daily KMC.svg" class="setSize">'."&nbsp;";              
              $getbaby = $this->db->get_where('babyDailyKMC',array('ID'=>$value['GrantedForID']))->row_array();
              $getMother = $this->db->get_where('babyRegistration',array('BabyID'=>$getbaby['BabyID']))->row_array();
              $getMotherName = $this->db->get_where('mother_registration',array('MotherID'=>$getMother['MotherID']))->row_array();
              echo "Points Credited for Saving Daily KMC of ".(!empty($getMotherName['MotherName']) ? "B/O ".$getMotherName['MotherName'] : 'B/O UNKNOWN');
            }else if($value['Type']=='5'){
            echo'<img src="'.base_url().'assets/images/svg/Breast Feeding.svg" class="setSize">'."&nbsp;";
              $getbaby = $this->db->get_where('babyDailyNutrition',array('ID'=>$value['GrantedForID']))->row_array();
              $getMother = $this->db->get_where('babyRegistration',array('BabyID'=>$getbaby['BabyID']))->row_array();
              $getMotherName = $this->db->get_where('mother_registration',array('MotherID'=>$getMother['MotherID']))->row_array();
               echo "Points Credited for Saving Breast Feeding of ".(!empty($getMotherName['MotherName']) ? "B/O ".$getMotherName['MotherName'] : 'B/O UNKNOWN');
            }else if($value['Type']=='6'){
            echo'<img src="'.base_url().'assets/images/svg/Medicaton-01.svg" class="setSize">'."&nbsp;";
              $getbaby = $this->db->get_where('babyvaccination',array('ID'=>$value['GrantedForID']))->row_array();
              $getMother = $this->db->get_where('babyRegistration',array('BabyID'=>$getbaby['BabyID']))->row_array();
              $getMotherName = $this->db->get_where('mother_registration',array('MotherID'=>$getMother['MotherID']))->row_array();
              echo "Points Credited for Saving Medication of ".(!empty($getMotherName['MotherName']) ? "B/O ".$getMotherName['MotherName'] : 'B/O UNKNOWN');
            }else if($value['Type']=='7'){
            echo'<img src="'.base_url().'assets/images/svg/Mother Assessment-01.svg" class="setSize">'."&nbsp;";
              $getMother = $this->db->get_where('mother_monitoring',array('id'=>$value['GrantedForID']))->row_array();
              $getMotherName = $this->db->get_where('mother_registration',array('MotherID'=>$getMother['MotherID']))->row_array();
              echo "Points Credited for Doing Assessment of ".(!empty($getMotherName['MotherName']) ? "B/O ".$getMotherName['MotherName'] : 'B/O UNKNOWN');
            }else if($value['Type']=='8'){
            echo'<img src="'.base_url().'assets/images/svg/Baby Discharge.svg" class="setSize">'."&nbsp;";
              $getbaby = $this->db->get_where('dischargemaster',array('DischargeID'=>$value['GrantedForID']))->row_array();
              $getMother = $this->db->get_where('babyRegistration',array('BabyID'=>$getbaby['MotherOrBabyID']))->row_array();
              $getMotherName = $this->db->get_where('mother_registration',array('MotherID'=>$getMother['MotherID']))->row_array();
               echo "Points Credited for Doing Discharge of ".(!empty($getMotherName['MotherName']) ? "B/O ".$getMotherName['MotherName'] : 'B/O UNKNOWN');
            } else if($value['Type']=='9'){
            echo'<img src="'.base_url().'assets/images/svg/Mother Discharge.svg" class="setSize">'."&nbsp;"; 
              $getMother = $this->db->get_where('dischargemaster',array('DischargeID'=>$value['GrantedForID']))->row_array();
              $getMotherName = $this->db->get_where('mother_registration',array('MotherID'=>$getMother['MotherID']))->row_array();
                echo "Points Credited for Doing Discharge of ".$getMotherName['MotherName'];
            }else if($value['Type']=='10'){
            echo'<img src="'.base_url().'assets/images/svg/Room Temperature.svg" class="setSize">'."&nbsp;";
              $getLounge = $this->db->get_where('lounge_master',array('LoungeID'=>$value['LoungeId']))->row_array();
               echo "Points Credited for Saving Room Temperature ".$getLounge['LoungeName'];
            }else if($value['Type']=='11'){
            echo'<img src="'.base_url().'assets/images/svg/Breakfast-01.svg" class="setSize">'."&nbsp;";
              $getLounge = $this->db->get_where('lounge_master',array('LoungeID'=>$value['LoungeId']))->row_array();
                echo "Points Credited for Informing Mother\'s for Breakfast ".$getLounge['LoungeName'];
            }else if($value['Type']=='12'){
            echo'<img src="'.base_url().'assets/images/svg/lunch-01.svg" class="setSize">'."&nbsp;";
              $getLounge = $this->db->get_where('lounge_master',array('LoungeID'=>$value['LoungeId']))->row_array();
                echo "Points Credited for Informing Mother\'s for Lunch ".$getLounge['LoungeName'];
            }else if($value['Type']=='13'){
            echo'<img src="'.base_url().'assets/images/svg/diner-01.svg" class="setSize">'."&nbsp;";
              $getLounge = $this->db->get_where('lounge_master',array('LoungeID'=>$value['LoungeId']))->row_array();
                echo "Points Credited for Informing Mother\'s for Dinner ".$getLounge['LoungeName'];
            }else if($value['Type']=='14'){
            echo'<img src="'.base_url().'assets/images/svg/duty change-01.svg" class="setSize">'."&nbsp;";
              $getNurse = $this->db->get_where('dutychange',array('id'=>$value['GrantedForID']))->row_array();
                $getCurrentNurseName = $this->db->get_where('staff_master',array('StaffID'=>$getNurse['CurrentDutyNurseId']))->row_array();
                $getNextNurseName = $this->db->get_where('staff_master',array('StaffID'=>$getNurse['NextDutyNurseId']))->row_array();           
             echo "Points Credited for Changing Duty with ".(($getNextNurseName['Name'] != "") ?$getNextNurseName['Name'] : "N/A");  
            }else if($value['Type']=='15'){
                $this->db->select('learningapp_observation_question.question_title');
                $this->db->from('learningapp_observation_question');
                $this->db->join('learningapp_store_answer','learningapp_store_answer.questionid=learningapp_observation_question.id','inner');
                $this->db->where('learningapp_store_answer.id',$value['GrantedForID']);
                $getValue = $this->db->get()->row_array();
              echo "Points Credited for Answering ".(($getValue['question_title'] != "") ? $getValue['question_title'] : "N/A");   
            }else if($value['Type']=='16'){
                $getValue = $this->db->query('SELECT * FROM `learningapp_orders` WHERE id='.$value['GrantedForID'])->row_array();
              echo "Points Credited for Placing Order\nOrder Number ".(($getValue['refOrderId'] != "") ? $getValue['refOrderId'] : "N/A");
            }
                    ?>

                  </td>
                 <td><?php 
                      $GetType = $this->db->get_where('pointmaster',array('id'=>$value['Type']))->row_array();
                      echo  $GetType['Name'];
                  ?></td>
                 <td><?php 
                   if($value['TransactionStatus']=='Credit'){
                       echo "+".$value['Points'];
                     }else{
                      echo "-".$value['Points'];
                     }

                  ?></td>
                 <td><?php  echo $value['TransactionStatus']; ?></td>
                 <td><?php echo date("d-m-Y h:i A",$value['AddDate']); ?></td>
                </tr>
                  <?php $counter ++ ; } ?>
                </tbody>
               </table>
                 <ul class="pagination pull-right">
                  <?php
                    foreach ($links as $link) {
                        echo "<li>" . $link . "</li>";
                    }
                   ?>
                </ul>
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
