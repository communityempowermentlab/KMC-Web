<?php
class DangerSignModel extends CI_Model {
  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  //mother danger or non-danger icon code
  public function getMotherIcon($get_last_assessment){
    $status1 = 0;
    $status2 = 0;
    $status3 = 0;
    $status4 = 0;
    $status5 = 0;
    $status6 = 0;
    $status7 = 0;
    $status8 = 0;
    if(!empty($get_last_assessment['id'])){
      if($get_last_assessment['motherPulse'] < 50 || $get_last_assessment['motherPulse'] > 120){
       $status1 = 1;
      }

      if($get_last_assessment['motherTemperature'] < 95.9 || $get_last_assessment['motherTemperature'] > 99.5){
       $status2 = 1;
      }

     if($get_last_assessment['motherSystolicBP'] >= 140 || $get_last_assessment['motherSystolicBP'] <= 90){
       $status3 = 1;
      }

      if($get_last_assessment['motherDiastolicBP'] <= 60 || $get_last_assessment['motherDiastolicBP'] >= 90){
       $status4 = 1;
      }

      // if($get_last_assessment['motherUterineTone'] == 'Hard/Collapsed (Contracted)'){
      //  $status5 = '1';
      // }

      // if(!empty($get_last_assessment['episitomyCondition']) && $get_last_assessment['episitomyCondition'] == 'Infected'){
      //  $status6 = '1';
      // }                                   

      // if(!empty($get_last_assessment['sanitoryPadStatus']) && $get_last_assessment['sanitoryPadStatus'] == "It's FULL"){
      //  $status7 = '1';
      // }   

      // if(!empty($get_last_assessment['motherBleedingStatus']) && $get_last_assessment['motherBleedingStatus'] == "Yes"){
      //  $status8 = '1';
      // }                      

      if($status1 == 1 || $status2 == 1 || $status3 == 1 || $status4 == 1)
      {
           return '0';  // for sad mother
      }else{
            return '1'; // for happy mother                      
      }
    }
        
  }

  // baby danger or normal icon code here
  public function getBabyIcon($get_last_assessment1){
    $checkupCount1 = '0';
    $checkupCount2 = '0';
    $checkupCount3 = '0';
    $checkupCount4 = '0';
    if(!empty($get_last_assessment1['id'])){
        if($get_last_assessment1['respiratoryRate'] > 60 || $get_last_assessment1['respiratoryRate'] < 30){
          $checkupCount1 = 1;
        }

        if($get_last_assessment1['temperatureValue'] < 95.9 || $get_last_assessment1['temperatureValue'] > 99.5){
          $checkupCount2 = 1;
        }

        if($get_last_assessment1['pulseRate'] < 75 || $get_last_assessment1['pulseRate'] > 200){
          $checkupCount3 = 1;
        }

        if($get_last_assessment1['spo2'] < 95 && $get_last_assessment1['isPulseOximatoryDeviceAvail']=="Yes"){
           $checkupCount4 = 1;
        }

        if($checkupCount1 == 1 || $checkupCount2 == 1 || $checkupCount3 == 1 || $checkupCount4 == 1){
           return '0'; // for danger or unstable (sad)
        }else{
           return '1'; // for happy or stable icon
        }
    }  
    
  }
}
 ?>