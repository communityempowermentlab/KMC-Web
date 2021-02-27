<?php
class CronjobModelArvind extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

  // get baby admission data
  public function getBabyAdmissionDischargeData($loungeArray=false){
    $start_date = date('Y-m-d',strtotime("-1 days"));
    $end_date = date('Y-m-d',strtotime("-1 days"));

    $this->db->select('babyAdmission.babyId,babyAdmission.id as babyAdmissionId,babyAdmission.status as dischargeStatus,babyAdmission.babyFileId,babyAdmission.lengthValue as admissionHeight,babyAdmission.babyAdmissionWeight,babyAdmission.admissionDateTime,babyAdmission.dateOfDischarge,babyAdmission.typeOfDischarge,babyRegistration.babyGender,babyRegistration.registrationDateTime,babyRegistration.motherId,babyRegistration.babyWeight,babyRegistration.deliveryDate,babyRegistration.deliveryTime,babyRegistration.typeOfBorn,babyRegistration.deliveryType,motherRegistration.motherName,motherRegistration.isMotherAdmitted,motherRegistration.motherMobileNumber,motherRegistration.fatherName,motherRegistration.motherAadharNumber,motherRegistration.fatherAadharNumber,motherRegistration.motherMCTSNumber,motherRegistration.motherWeight,motherRegistration.motherDOB,motherRegistration.motherAge,motherRegistration.profileUpdateNurseId,motherRegistration.ageAtMarriage,motherRegistration.motherEducation,motherRegistration.motherReligion,motherRegistration.motherCaste,motherRegistration.multipleBirth,motherRegistration.gravida,motherRegistration.para,motherRegistration.abortion,motherRegistration.live,motherRegistration.birthSpacing,motherRegistration.fatherMobileNumber,motherRegistration.guardianName,motherRegistration.guardianRelation,motherRegistration.guardianNumber,motherRegistration.rationCardType,staffMaster.name as motherProfileUpdateNurse,loungeMaster.facilityId,loungeMaster.loungeName,facilitylist.FacilityName, motherRegistration.presentResidenceType,motherRegistration.presentCountry,motherRegistration.presentState,motherRegistration.presentDistrictName,motherRegistration.presentBlockName,motherRegistration.presentVillageName,motherRegistration.presentAddress,motherRegistration.presentPinCode,motherRegistration.presentAddNearByLocation,motherRegistration.sameAddress,motherRegistration.permanentResidenceType,motherRegistration.permanentCountry,motherRegistration.permanentState,motherRegistration.permanentDistrictName,motherRegistration.permanentBlockName,motherRegistration.permanentVillageName,motherRegistration.permanentAddress,motherRegistration.permanentPinCode,motherRegistration.permanentAddNearByLocation');
    $this->db->join('babyRegistration','babyRegistration.babyId=babyAdmission.babyId');
    $this->db->join('motherRegistration','motherRegistration.motherId=babyRegistration.motherId');
    $this->db->join('loungeMaster','loungeMaster.loungeId=babyAdmission.loungeId');
    $this->db->join('facilitylist','facilitylist.FacilityID=loungeMaster.facilityId');
    $this->db->join('staffMaster','staffMaster.staffId=motherRegistration.profileUpdateNurseId','left');
    $this->db->where('DATE(babyAdmission.dateOfDischarge) >=', $start_date);
    $this->db->where('DATE(babyAdmission.dateOfDischarge) <=', $end_date);
    if(!empty($loungeArray)){
      $this->db->where_in('babyAdmission.loungeId',$loungeArray);
    }
    $this->db->order_by('babyAdmission.id','desc');
    $query = $this->db->get_where('babyAdmission',array('babyAdmission.status'=>2))->result_array();
    return $query;
  }

  // get baby monitoring data
  public function getBabyDailyMonitoring($admissionId){
    $this->db->select('babyDailyMonitoring.assesmentDate,babyDailyMonitoring.assesmentTime,babyDailyMonitoring.isThermometerAvailable,babyDailyMonitoring.temperatureValue,babyDailyMonitoring.temperatureUnit,babyDailyMonitoring.reasonValue,babyDailyMonitoring.otherValue,babyDailyMonitoring.respiratoryRate,babyDailyMonitoring.isPulseOximatoryDeviceAvail,babyDailyMonitoring.pulseReasonValue,babyDailyMonitoring.pulseOtherValue,babyDailyMonitoring.spo2,babyDailyMonitoring.pulseRate');
    return $this->db->get_where('babyDailyMonitoring',array('babyDailyMonitoring.babyAdmissionId'=>$admissionId))->result_array();
  }

  // get baby daily weight by admission id
  public function getBabyDailyWeightById($admissionId){
    $this->db->select('babyDailyWeight.weightDate,babyDailyWeight.babyWeight');
    return $this->db->get_where('babyDailyWeight',array('babyDailyWeight.babyAdmissionId'=>$admissionId))->result_array();
  }

  // get baby kmc position by admission id
  public function getBabyKmcPositionById($admissionId){
    $this->db->select('babyDailyKMC.startDate,babyDailyKMC.startTime,babyDailyKMC.endDate,babyDailyKMC.endTime,babyDailyKMC.provider,staffMaster.name as nurseName');
    $this->db->join('staffMaster','staffMaster.staffId=babyDailyKMC.nurseId');
    return $this->db->get_where('babyDailyKMC',array('babyDailyKMC.babyAdmissionId'=>$admissionId,'babyDailyKMC.isDataValid'=>1))->result_array();
  }

  // get baby nutrition by admission id
  public function getBabyNutritionById($admissionId){
    $this->db->select('babyDailyNutrition.breastFeedMethod,babyDailyNutrition.milkQuantity,babyDailyNutrition.feedDate,babyDailyNutrition.feedTime,babyDailyNutrition.fluid,staffMaster.name as nurseName');
    $this->db->join('staffMaster','staffMaster.staffId=babyDailyNutrition.nurseId');
    return $this->db->get_where('babyDailyNutrition',array('babyDailyNutrition.babyAdmissionId'=>$admissionId))->result_array();
  }

  // get baby prescription by admission id
  public function getBabyPrescriptionById($admissionId){
    $this->db->select('doctorBabyPrescription.prescriptionName,doctorBabyPrescription.comment,doctorBabyPrescription.addDate,staffMaster.name as doctorName');
    $this->db->join('staffMaster','staffMaster.staffId=doctorBabyPrescription.doctorId');
    return $this->db->get_where('doctorBabyPrescription',array('doctorBabyPrescription.babyAdmissionId'=>$admissionId))->result_array();
  }

  // get baby counselling poster duration
  public function getBabyCounsellingTimeById($babyId,$posterType){
    return $this->db->query('SELECT `babyId`, `counsellingType`, SEC_TO_TIME(SUM(duration)) as totalSeconds, floor(SUM(duration)/3600) as Hours, (SUM(duration)%3600)/60 as Minutes, (SUM(duration)%60) as Seconds FROM `babyCounsellingPosterLog` where babyId='.$babyId.' AND counsellingType='.$posterType.' group by 2')->row_array();
  }

  // get DistrictNameProperCase from revenuevillagewithblcoksandsubdistandgs via PRIDistrictCode
  public function GetPresentDistrictName($Id){
    $this->db->select('DistrictNameProperCase');
    $this->db->limit('1');
    return $this->db->get_where('revenuevillagewithblcoksandsubdistandgs',array('PRIDistrictCode'=>$Id))->row_array();
  }

  // get BlockPRINameProperCase from revenuevillagewithblcoksandsubdistandgs via BlockPRICode
  public function GetPresentBlockName($Id){
    $this->db->select('BlockPRINameProperCase');
    $this->db->limit('1');
    return $this->db->get_where('revenuevillagewithblcoksandsubdistandgs',array('BlockPRICode'=>$Id))->row_array();
  }

  // get GPNameProperCase from revenuevillagewithblcoksandsubdistandgs via GPPRICode
  public function GetPresentVillageName($Id){
    $this->db->select('GPNameProperCase');
    $this->db->limit('1');
    return $this->db->get_where('revenuevillagewithblcoksandsubdistandgs',array('GPPRICode'=>$Id))->row_array();
  }

  /**************************************************************************************************************************************/

  // get all lounge
  public function getAllLounges($loungeArray=false){
    $this->db->select('loungeMaster.loungeId,loungeMaster.facilityId,loungeMaster.loungeName,loungeMaster.loungePassword,facilitylist.FacilityName');
    $this->db->join('facilitylist','facilitylist.FacilityID=loungeMaster.facilityId');
    if(!empty($loungeArray)){
      $this->db->where_in('loungeMaster.loungeId',$loungeArray);
    }
    $this->db->order_by('loungeMaster.loungeName','asc');
    $query = $this->db->get_where('loungeMaster',array('loungeMaster.status'=>1))->result_array();
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

  // get nurse checkin checkout list by lounge
  public function getNurseAttendanceList($loungeId){
    $previousDate = date('Y-m-d',strtotime("-1 days"));
    $currentDate = date('Y-m-d');

    $reportCheckinDateStart = "'".$previousDate.' 7:30:00'."'";
    $reportCheckinDateEnd = "'".$currentDate.' 7:30:00'."'";

    $reportCheckoutDateStart = "'".$previousDate.' 8:31:00'."'";
    $reportCheckoutDateEnd = "'".$currentDate.' 8:30:00'."'";

    $query = $this->db->query('SELECT nurseDutyChange.*,staffMaster.name as nurseName FROM nurseDutyChange JOIN staffMaster on staffMaster.staffId=nurseDutyChange.nurseId WHERE nurseDutyChange.loungeId = '.$loungeId.' AND ((nurseDutyChange.addDate BETWEEN '.$reportCheckinDateStart.' AND '.$reportCheckinDateEnd.') OR (nurseDutyChange.modifyDate BETWEEN '.$reportCheckoutDateStart.' AND '.$reportCheckoutDateEnd.'))')->result_array();
    return $query;
  }

  // get checkin log history
  public function getNurseAttendanceLogList($id){
    $this->db->select('logHistory.*');
    $query = $this->db->get_where('logHistory',array('logHistory.tableReferenceId'=>$id,'tableReference'=>1))->result_array();
    return $query;
  }

  // get report settings
  public function getReportSettings($id){
    $this->db->select('reportsetting.*');
    $settingData = $this->db->get_where('reportsetting',array('reportsetting.id'=>$id))->row_array();

    $settingData['emails'] = $this->db->get_where('reportemail',array('reportemail.reportsettingId'=>$settingData['id']))->result_array();
    $settingData['facilities'] = $this->db->get_where('reportfacilities',array('reportfacilities.reportsettingId'=>$settingData['id']))->result_array();
    return $settingData;
  }

  // get baby admission data
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

  // get baby weight by weight date
  public function getBabyDailyWeightData($admissionId,$weightDate){
    $this->db->select('babyDailyWeight.id,babyDailyWeight.babyWeight,babyDailyWeight.weightDate');
    $this->db->where('DATE(babyDailyWeight.weightDate)', $weightDate);
    $query = $this->db->get_where('babyDailyWeight',array('babyDailyWeight.babyAdmissionId'=>$admissionId))->row_array();
    return $query;
  }

  // get baby last weight
  public function getBabyLastWeightData($admissionId){
    $this->db->select('babyDailyWeight.id,babyDailyWeight.babyWeight,babyDailyWeight.weightDate');
    $this->db->order_by('id', 'desc');
    $query = $this->db->get_where('babyDailyWeight',array('babyDailyWeight.babyAdmissionId'=>$admissionId))->row_array();
    return $query;
  }

  // get baby admission list
  public function getBabyAdmissionList($loungeArray=false){
    $this->db->select('babyAdmission.id as babyAdmissionId,babyAdmission.babyFileId,babyRegistration.registrationDateTime,babyRegistration.motherId,motherRegistration.motherName,loungeMaster.facilityId,loungeMaster.loungeName,facilitylist.FacilityName');
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

  // kmc position duplicate data
  public function getKmcPositionDuplicateData($admissionId){
    $query = $this->db->query('SELECT `babyAdmissionId`, `nurseId`,`startDate`, `startTime`,endDate,endTime, count(*) as duplicateCount FROM `babyDailyKMC` where babyAdmissionId='.$admissionId.' group by 1,2,3,4 HAVING count(*) > 1 ORDER BY duplicateCount DESC ')->result_array();
    return $query;
  }

  // get data count by table
  public function getCountDataByTable($table,$condition){
    $query = $this->db->get_where($table,$condition)->num_rows();
    return $query;
  }

  // get kmc data by kmc date
  public function getBabyKmcDateData($admissionId,$kmcDate){
    $from = $kmcDate;
    $startTime = '08:00:00';
    $to = date("Y-m-d", strtotime("+1 day", strtotime($kmcDate)));
    $endTime = '08:00:00';

    $query = $this->db->query("SELECT * FROM `babyDailyKMC` where babyAdmissionId = ".$admissionId." AND isDataValid=1 AND ((startDate = '".$from."' AND startTime >= '".$startTime."') OR (startDate = '".$to."' AND startTime < '".$endTime."')) AND ((endDate = '".$from."' AND endTime > '".$startTime."') OR (endDate = '".$to."' AND endTime < '".$endTime."')) ORDER BY `id` DESC ")->result_array();

    $totalSeconds = 0;
    foreach($query as $query_data){
      $endDateTime = strtotime($query_data['endDate'].' '.$query_data['endTime']);
      $startDateTime = strtotime($query_data['startDate'].' '.$query_data['startTime']);

      $dateDifference = intval(($endDateTime-$startDateTime)/60);
      $totalSeconds = $totalSeconds+$dateDifference;
    }

    $durationHours = intval($totalSeconds/60);
    $durationMinutes = $totalSeconds%60;
    $totalKmcDuration = (($durationHours != "0" || $durationHours != "") ? ($durationHours."h "):"").$durationMinutes."m";

    $returnArray['totalKmcDuration'] = $totalKmcDuration;
    $returnArray['totalSeconds'] = $totalSeconds;

    return $returnArray;
  }


  public function getBabyNutritionList($loungeArray=false){
    $previousDate = date('Y-m-d',strtotime("-1 days"));
    $currentDate = date('Y-m-d');
    // $previousDate = "2021-01-27";
    // $currentDate = "2021-01-28";
    $time = "08:00:00";
    if(!empty($loungeArray))
    {
      $loung = implode(",", $loungeArray);
      $con = "babyAdmission.loungeId in(".$loung.") AND ";
    }
    else
    {
      $con = '';
    }


    $query = $this->db->query('SELECT babyDailyNutrition.*,staffMaster.name as nurseName, babyAdmission.loungeId FROM babyDailyNutrition JOIN staffMaster on staffMaster.staffId=babyDailyNutrition.nurseId JOIN babyAdmission on babyAdmission.id=babyDailyNutrition.babyAdmissionId WHERE '.$con.' ((babyDailyNutrition.feedDate ="'.$previousDate.'" AND babyDailyNutrition.feedTime >= "'.$time.'") OR (babyDailyNutrition.feedDate = "'.$currentDate.'" AND babyDailyNutrition.feedTime < "'.$time.'"))')->result_array();
    return $query;
  }


  public function getBabyAdmissionDatabyBabyid($id){
    $this->db->select('babyAdmission.id as babyAdmissionId,babyAdmission.babyFileId,babyRegistration.registrationDateTime,babyRegistration.motherId,motherRegistration.motherName,loungeMaster.facilityId,loungeMaster.loungeName,facilitylist.FacilityName');
    $this->db->join('babyRegistration','babyRegistration.babyId=babyAdmission.babyId');
    $this->db->join('motherRegistration','motherRegistration.motherId=babyRegistration.motherId');
    $this->db->join('loungeMaster','loungeMaster.loungeId=babyAdmission.loungeId');
    $this->db->join('facilitylist','facilitylist.FacilityID=loungeMaster.facilityId');
    
      $this->db->where('babyAdmission.id',$id);
    
    $query = $this->db->get_where('babyAdmission')->row_array();
    return $query;
  }


}
?>