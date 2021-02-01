<?php $adminData             = $this->session->userdata('adminData');
      $GetNurseDetail        = $this->UserModel->getStaffNameBYID($StaffIDs);
      $TotalCreditNursePoint = $this->db->query("SELECT SUM(Points) as creditPoint from pointstransactions where NurseId=".$StaffIDs." and TransactionStatus='Credit'")->row_array();
      $TotalDebitNursePoint  = $this->db->query("SELECT SUM(Points) as debitPoint from pointstransactions where NurseId=".$StaffIDs." and TransactionStatus='Debit'")->row_array();
?>
<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
<style type="text/css">
  .setSize{
    width: 25px;
    height: 25px;
  }
</style>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <h1><?php echo $GetNurseDetail['Name'].' Points History'; ?>
       <span style="float: right;">
        <?php echo 'Total Points: '.($TotalCreditNursePoint['creditPoint'] - $TotalDebitNursePoint['debitPoint']); ?></span>
          
        </h1>
      
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">

<!--          <div class="box box-info"> 
           <div class="box-body">
              <div class="form-group" >
                     <div class="col-sm-6">
                     <div class="col-sm-4" style="margin-top: 6px;">

                        <?php
                          if(empty($GetNurseDetail['ProfilePic'])) { ?>
                            <img src="<?php echo base_url(); ?>assets/nurse/default.png" style="height:150px;width:140px;">
                          <?php } else { ?>
                            <img src="<?php echo base_url(); ?>assets/nurse/<?php echo $GetNurseDetail['ProfilePic']?>" style="height:150px;width:140px;" class="img-responsive">
                        <?php } ?>
                       </div>
                       <div class="col-sm-8" style="padding-left:10px;">
                        <span style="font-size: 20px;"><?php// echo ; ?></span><br>
                        <b>Total Credit Point &nbsp;&nbsp;&nbsp;</b><?php echo $TotalCreditNursePoint['creditPoint']; ?><br>
                       <b>Total Debit Point&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><?php echo ($TotalDebitNursePoint['debitPoint']=="")? '0':$TotalDebitNursePoint['debitPoint']; ?><br>
                        <b>Score Point&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          &nbsp;&nbsp;&nbsp;&nbsp;
                          </b><?php  ?>
                       </div>
                     </div>
                     <div class="col-sm-3"><br>

                     </div>
                </div>
           </div>
        </div>   -->


          <div class="box">
            <div class="box-body">
              <table cellpadding="0" cellspacing="0" border="0"
                class="table-striped table table-bordered editable-datatable example " id="example" >
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
                $counter = "1";
                foreach ($GetNurseData as $value) {
                 $GetNurseDetail = $this->UserModel->getStaffNameBYID($value['NurseId']);
                 ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td>
                    <?php
            if($value['Type'] == '1'){
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
/*                echo '<b>Current Nurse- </b>'.(($getCurrentNurseName['Name'] != "") ?$getCurrentNurseName['Name'] : "N/A").'<br>';
                echo '<b>Next Nurse- </b>'.(($getNextNurseName['Name'] != "") ?$getNextNurseName['Name'] : "N/A");*/
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
