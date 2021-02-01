<?php
class FeedModel extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }
   
    // get babyAdmission data via id
    public function getBabyAdmissionData($admissionId) {
        return $this->db->get_where('babyAdmission',array('id'=>$admissionId))->row_array();
    }

    // get babyRegistration data via babyId
    public function getBabyRegistrationData($BabyID) {
        return $this->db->get_where('babyRegistration',array('babyId'=>$BabyID))->row_array();
    }

    // get motherRegistration data via motherId
    public function getMotherRegistrationData($MotherID) {
        return $this->db->get_where('motherRegistration',array('motherId'=>$MotherID))->row_array();
    }

    // get last babyDailyWeight data via babyAdmissionId
    public function getCurrentBabyWeight($admissionId) {
        $this->db->order_by('id','desc');
        return $this->db->get_where('babyDailyWeight',array('babyAdmissionId'=>$admissionId))->row_array();
    }

    // get staff data via staffId
    public function getStaffData($staffID) {
        return $this->db->get_where('staffMaster',array('staffId'=>$staffID))->row_array();
    }

    // get babyDailyMonitoring data via id
    public function getMonitoringData($monitoringId) {
        return $this->db->get_where('babyDailyMonitoring',array('id'=>$monitoringId))->row_array();
    }

    // get last babyDailyKMC data via babyAdmissionId
    public function getSkinTouchData($skinTouchId) {
        $this->db->order_by('id','desc');
        return $this->db->get_where('babyDailyKMC',array('babyAdmissionId'=>$skinTouchId))->row_array();
    }

    // get nurseDutyChange data via id
    public function dutyChangeData($dutyChangeId) {
        return $this->db->get_where('nurseDutyChange',array('id'=>$dutyChangeId))->row_array();
    }  

    // get doctorRound data via id
    public function getDoctorRoundData($doctorRoundID) {
        return $this->db->get_where('doctorRound',array('id'=>$doctorRoundID))->row_array();
    }  

    // get loungeMaster data via loungeId
    public function getLoungeData($loungeId) {
        return $this->db->get_where('loungeMaster',array('loungeId'=>$loungeId))->row_array();
    }        

    // get days diffence between two dates
    public function calculateDays($birthDate) {
       // $date1=date_create("2013-03-15");
        $currentDate = date("Y-m-d");
        $date1  = date_create($birthDate);
        $date2  = date_create($currentDate);
        $diff   = date_diff($date1,$date2);
        return $diff->format("%R%a");
    }    

    // count data from table via timelineId and type if available
    public function countRows($table,$loungeId,$type='') {
        if($type != ""){
          return $this->db->query("select * from ".$table." where timelineId = ".$loungeId." and type='1'")->num_rows();
        }else{
          return $this->db->query("select * from ".$table." where timelineId = ".$loungeId."")->num_rows();
        }
    }

    // count data from table via loungeId, timelineId and type 
    public function countLike($table,$loungeId,$timelineId) {
        return $this->db->query("select * from ".$table." where loungeId = ".$loungeId." and type='1' and timelineId=".$timelineId."")->num_rows();
    }

    // count data from table via loungeId, timelineId, type and userType
    public function countLikeNew($table,$loungeId,$timelineId,$type) {
      return $this->db->query("select * from ".$table." where loungeId = ".$loungeId." and type='1' and timelineId=".$timelineId." and userType=".$type."")->num_rows();
    }
    
    // get data from table via loungeId and dynamic column name = $id
    public function getLastSyncTime($table,$loungeId,$colName,$id) {
      return $this->db->query("select * from ".$table." where loungeId = ".$loungeId." and ".$colName."=".$id."")->row_array();
    }

    public function GetBabyWeight2($BabyID,$order_by,$WeightDate='',$admisionID='')
    {
        $this->db->order_by('id',$order_by);
        $this->db->select('babyWeight');
        return $this->db->get_where('babyDailyWeight',array('babyId'=>$BabyID,'weightDate'=>$WeightDate,'babyAdmissionId'=>$admisionID))->row_array();
    }

}