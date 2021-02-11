<?php
class CronjobModel extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

  public function getAllLounges($loungeArray=false){
    $this->db->select('loungeMaster.loungeId,loungeMaster.facilityId,loungeMaster.loungeName');
    if(!empty($loungeArray)){
      $this->db->where_in('loungeMaster.loungeId',$loungeArray);
    }
    $query = $this->db->get_where('loungeMaster')->result_array();
    return $query;
  }

  public function getNurseAttendanceListOld($loungeId){
    //$reportDate = date('Y-m-d',strtotime("-1 days"));
    $reportDate = "2021-01-26";
    $this->db->select('nurseDutyChange.*,staffMaster.name as nurseName');
    $this->db->join('staffMaster','staffMaster.staffId=nurseDutyChange.nurseId');
    $this->db->where('DATE(nurseDutyChange.addDate)', $reportDate);
    $query = $this->db->get_where('nurseDutyChange',array('nurseDutyChange.loungeId'=>$loungeId))->result_array();
    return $query;
  }

  public function getNurseAttendanceList($loungeId){
    $previousDate = date('Y-m-d',strtotime("-1 days"));
    $currentDate = date('Y-m-d');
    //$previousDate = "2021-01-29";
    //$currentDate = "2021-01-30";

    $reportCheckinDateStart = "'".$previousDate.' 7:30:00'."'";
    $reportCheckinDateEnd = "'".$currentDate.' 7:30:00'."'";

    $reportCheckoutDateStart = "'".$previousDate.' 8:31:00'."'";
    $reportCheckoutDateEnd = "'".$currentDate.' 8:30:00'."'";

    $query = $this->db->query('SELECT nurseDutyChange.*,staffMaster.name as nurseName FROM nurseDutyChange JOIN staffMaster on staffMaster.staffId=nurseDutyChange.nurseId WHERE nurseDutyChange.loungeId = '.$loungeId.' AND ((nurseDutyChange.addDate BETWEEN '.$reportCheckinDateStart.' AND '.$reportCheckinDateEnd.') OR (nurseDutyChange.modifyDate BETWEEN '.$reportCheckoutDateStart.' AND '.$reportCheckoutDateEnd.'))')->result_array();
    return $query;
  }

  public function getNurseAttendanceLogList($id){
    $this->db->select('logHistory.*');
    $query = $this->db->get_where('logHistory',array('logHistory.tableReferenceId'=>$id,'tableReference'=>1))->result_array();
    return $query;
  }

  public function getReportSettings($id){
    $this->db->select('reportsetting.*');
    $settingData = $this->db->get_where('reportsetting',array('reportsetting.id'=>$id))->row_array();

    $settingData['emails'] = $this->db->get_where('reportemail',array('reportemail.reportsettingId'=>$settingData['id']))->result_array();
    $settingData['facilities'] = $this->db->get_where('reportfacilities',array('reportfacilities.reportsettingId'=>$settingData['id']))->result_array();
    return $settingData;
  }

  public function getBabyAdmissionData($loungeArray=false){
    $this->db->select('babyAdmission.id as babyAdmissionId,babyAdmission.status as dischargeStatus,babyAdmission.babyFileId,babyAdmission.lengthValue as admissionHeight,babyAdmission.babyAdmissionWeight,babyRegistration.babyGender,babyRegistration.registrationDateTime,babyRegistration.motherId,babyRegistration.babyWeight,motherRegistration.motherName,loungeMaster.facilityId,loungeMaster.loungeName,facilitylist.FacilityName');
    $this->db->join('babyRegistration','babyRegistration.babyId=babyAdmission.babyId');
    $this->db->join('motherRegistration','motherRegistration.motherId=babyRegistration.motherId');
    $this->db->join('loungeMaster','loungeMaster.loungeId=babyAdmission.loungeId');
    $this->db->join('facilitylist','facilitylist.FacilityID=loungeMaster.facilityId');
    if(!empty($loungeArray)){
      $this->db->where_in('babyAdmission.loungeId',$loungeArray);
    }
    $this->db->order_by('babyAdmission.loungeId','asc');
    $query = $this->db->get_where('babyAdmission')->result_array();
    return $query;
  }

  public function getBabyDailyWeightData($admissionId,$weightDate){
    $this->db->select('babyDailyWeight.id,babyDailyWeight.babyWeight,babyDailyWeight.weightDate');
    $this->db->where('DATE(babyDailyWeight.weightDate)', $weightDate);
    $query = $this->db->get_where('babyDailyWeight',array('babyDailyWeight.babyAdmissionId'=>$admissionId))->row_array();
    return $query;
  }

  public function getBabyLastWeightData($admissionId){
    $this->db->select('babyDailyWeight.id,babyDailyWeight.babyWeight,babyDailyWeight.weightDate');
    $this->db->order_by('id', 'desc');
    $query = $this->db->get_where('babyDailyWeight',array('babyDailyWeight.babyAdmissionId'=>$admissionId))->row_array();
    return $query;
  }
}
?>