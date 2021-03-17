<?php
class CronjobModel extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

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

  // get baby admission data
  public function getBabyAdmissionDischargeData($loungeArray=false){
    $start_date = date('Y-m-d',strtotime("-1 days")).' 08:00:00';
    $end_date = date('Y-m-d').' 07:59:59';

    $this->db->select('babyAdmission.babyId,babyAdmission.id as babyAdmissionId,babyAdmission.status as dischargeStatus,babyAdmission.babyFileId,babyAdmission.lengthValue as admissionHeight,babyAdmission.babyAdmissionWeight,babyAdmission.admissionDateTime,babyAdmission.dateOfDischarge,babyAdmission.typeOfDischarge,babyRegistration.babyGender,babyRegistration.registrationDateTime,babyRegistration.motherId,babyRegistration.babyWeight,babyRegistration.deliveryDate,babyRegistration.deliveryTime,babyRegistration.typeOfBorn,babyRegistration.deliveryType,motherRegistration.motherName,motherRegistration.isMotherAdmitted,motherRegistration.motherMobileNumber,motherRegistration.fatherName,motherRegistration.motherAadharNumber,motherRegistration.fatherAadharNumber,motherRegistration.motherMCTSNumber,motherRegistration.motherWeight,motherRegistration.motherDOB,motherRegistration.motherAge,motherRegistration.profileUpdateNurseId,motherRegistration.ageAtMarriage,motherRegistration.motherEducation,motherRegistration.motherReligion,motherRegistration.motherCaste,motherRegistration.multipleBirth,motherRegistration.gravida,motherRegistration.para,motherRegistration.abortion,motherRegistration.live,motherRegistration.birthSpacing,motherRegistration.fatherMobileNumber,motherRegistration.guardianName,motherRegistration.guardianRelation,motherRegistration.guardianNumber,motherRegistration.rationCardType,staffMaster.name as motherProfileUpdateNurse,loungeMaster.facilityId,loungeMaster.loungeName,facilitylist.FacilityName, motherRegistration.presentResidenceType,motherRegistration.presentCountry,motherRegistration.presentState,motherRegistration.presentDistrictName,motherRegistration.presentBlockName,motherRegistration.presentVillageName,motherRegistration.presentAddress,motherRegistration.presentPinCode,motherRegistration.presentAddNearByLocation,motherRegistration.sameAddress,motherRegistration.permanentResidenceType,motherRegistration.permanentCountry,motherRegistration.permanentState,motherRegistration.permanentDistrictName,motherRegistration.permanentBlockName,motherRegistration.permanentVillageName,motherRegistration.permanentAddress,motherRegistration.permanentPinCode,motherRegistration.permanentAddNearByLocation');
    $this->db->join('babyRegistration','babyRegistration.babyId=babyAdmission.babyId');
    $this->db->join('motherRegistration','motherRegistration.motherId=babyRegistration.motherId');
    $this->db->join('loungeMaster','loungeMaster.loungeId=babyAdmission.loungeId');
    $this->db->join('facilitylist','facilitylist.FacilityID=loungeMaster.facilityId');
    $this->db->join('staffMaster','staffMaster.staffId=motherRegistration.profileUpdateNurseId','left');
    $this->db->where('babyAdmission.dateOfDischarge >=', $start_date);
    $this->db->where('babyAdmission.dateOfDischarge <=', $end_date);
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

  // get lounge birth review data
  public function getLoungeBirthReview($loungeId,$shift){
    $start_date = date('Y-m-d',strtotime("-1 days")).' 08:00:00';
    $end_date = date('Y-m-d').' 07:59:59';

    $this->db->select('loungeBirthReview.*,staffMaster.name as nurseName');
    $this->db->join('staffMaster','staffMaster.staffId=loungeBirthReview.nurseId');
    $this->db->where('loungeBirthReview.addDate >=', $start_date);
    $this->db->where('loungeBirthReview.addDate <=', $end_date);
    $query = $this->db->get_where('loungeBirthReview',array('loungeBirthReview.loungeId'=>$loungeId,'loungeBirthReview.shift'=>$shift))->result_array();
    return $query;
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


  public function getNurseList($FacilityArray=false){
    $previousDate = date('Y-m-d',strtotime("-1 days"));
    $currentDate = date('Y-m-d');
    // $previousDate = "2021-01-27";
    // $currentDate = "2021-01-28";
    //$time = "08:00:00";
    if(!empty($loungeArray))
    {
      $facilityId = implode(",", $FacilityArray);
      $con = "staffMaster.facilityId in(".$facilityId.") AND ";
    }
    else
    {
      $con = '';
    }

    $query = $this->db->query('SELECT staffMaster.*,facilitylist.FacilityName as FacilityName FROM staffMaster JOIN facilitylist on facilitylist.FacilityID=staffMaster.facilityId WHERE '.$con.' staffMaster.status ="1"')->result_array();
    return $query;
  }



  public function getAllAdmitionDischargeByNurse($loungeArray)
  {
    $loungeId = implode(",", $loungeArray);
    $qry = "SELECT * FROM `V_babyAdmissionDischargeMotherAdmission` where loungeid in (".$loungeId.")  
ORDER BY `V_babyAdmissionDischargeMotherAdmission`.`loungeId` ASC";

    $query = $this->db->query($qry)->result_array();
    return $query;
  }

  public function getAllLBW($loungeArray)
  {
    $previousDate = date('Y-m-d',strtotime("-1 days"));
    $currentDate = date('Y-m-d');

    $previous = "'".$previousDate.' 8:00:00'."'";
    $current = "'".$currentDate.' 8:00:00'."'";

    $loungeId = implode(",", $loungeArray);
    $qry = "SELECT * FROM `V_loungeBirthReview` where loungeid in (".$loungeId.") AND  addDate BETWEEN ".$previous." AND ".$current."
ORDER BY `V_loungeBirthReview`.`loungeId` ASC";

    $query = $this->db->query($qry)->result_array();
    return $query;
  }



   // get nurse Nurse Admition list by lounge
  public function getNurseAdmitionList($loungeId){
    $previousDate = date('Y-m-d',strtotime("-1 days"));
    $currentDate = date('Y-m-d');

    // $previousDate = "2021-01-27";
    // $currentDate = "2021-01-28";

    $previous = "'".$previousDate.' 8:00:00'."'";
    $current = "'".$currentDate.' 8:00:00'."'";
   

    $query = $this->db->query('SELECT babyAdmission.*,staffMaster.name as nurseName,motherAdmission.dischargeByNurse as motherDischargeNurse FROM staffMaster JOIN babyAdmission on staffMaster.staffId=babyAdmission.staffId left JOIN motherAdmission on staffMaster.staffId=motherAdmission.dischargeByNurse WHERE babyAdmission.loungeId = '.$loungeId.' AND ((babyAdmission.admissionDateTime BETWEEN '.$previous.' AND '.$current.') OR (babyAdmission.dateOfDischarge BETWEEN '.$previous.' AND '.$current.') OR (motherAdmission.dateOfDischarge BETWEEN '.$previous.' AND '.$current.')) group by staffMaster.staffId')->result_array();
    return $query;
  }

  //total Admission by nurse 
   public function totalAdmissionByNurse($loungeId, $stafId){
    $previousDate = date('Y-m-d',strtotime("-1 days"));
    $currentDate = date('Y-m-d');

    $return = array();
  
    $withmothers =0;
    $dethmothers =0;
    $notmothers =0;
    $referral =0;
    $samehospitalmothers =0;
    $unknownmothers=0;
    $othermothers = 0;

    $previous = "'".$previousDate.' 8:00:00'."'";
    $current = "'".$currentDate.' 8:00:00'."'";
    $wheres = 'babyAdmission.loungeId = "'.$loungeId.'" AND babyAdmission.staffId="'.$stafId.'" AND babyAdmission.admissionDateTime BETWEEN '.$previous.' AND '.$current;

    //babyAdmission.dateOfDischarge BETWEEN '.$previous.' AND '.$current;
   
    $query = $this->db->query('SELECT babyAdmission.*,babyRegistration.motherId FROM babyAdmission JOIN babyRegistration on babyRegistration.babyId=babyAdmission.babyId WHERE '.$wheres);
    $total = $query->num_rows();
    if($total > 0)
    {
      $record = $query->result_array();
      foreach ($record as $key => $value) {
        $ids = $value["motherId"];
        $mother = $this->db->query('SELECT motherRegistration.*,motherAdmission.typeOfDischarge FROM motherAdmission JOIN motherRegistration on motherAdmission.motherId=motherRegistration.motherId WHERE motherRegistration.motherId="'.$ids.'"');
        $mothers = $mother->row_array();
        if($mothers['typeOfDischarge']=="Referral"){
          $referral = $referral+1;
        }

        if($mothers['isMotherAdmitted']=="Yes")
        {
          $withmothers =$withmothers+1;
        }
        else
        {
          if($mothers['notAdmittedReason']=="Dead" || $mothers['notAdmittedReason']=="मृत")
          {
            $dethmothers =$dethmothers+1;
          }
          elseif ($mothers['notAdmittedReason']=="Baby was referred & mother did not accompanied" || $mothers['notAdmittedReason']=="बेबी को रेफर किया गया और माँ साथ नहीं आयी") {
            $notmothers =$notmothers+1;
          }
          elseif ($mothers['notAdmittedReason']=="Mother is in a different ward in same hospital" || $mothers['notAdmittedReason']=="माँ एक ही अस्पताल के अलग वार्ड में है") {
            $samehospitalmothers = $samehospitalmothers+1;
          }
          elseif ($mothers['notAdmittedReason']=="Unknown/ Baby is an orphan" || $mothers['notAdmittedReason']=="अज्ञात/ बेबी अनाथ है") {
            $unknownmothers = $unknownmothers+1;
          }
          elseif ($mothers['notAdmittedReason']=="Other" || $mothers['notAdmittedReason']=="अन्य") {
            $othermothers = $othermothers+1;
          }
        }

      }
      

    }
    $return['total']=$total;
    $return['withmothers']=$withmothers;
    $return['dethmothers']=$dethmothers;
    $return['notmothers']=$notmothers;
    $return['samehospitalmothers']=$samehospitalmothers;
    $return['referral']=$referral;
    $return['unknownmothers']=$unknownmothers;
    $return['othermothers']=$othermothers;
    return $return;
  }

// total baby discharge
  public function totalBabyDischargeByNurse($loungeId, $stafId){
    $previousDate = date('Y-m-d',strtotime("-1 days"));
    $currentDate = date('Y-m-d');

    $return = array();
  
    $Absconded =0;
    $Died =0;
    $Doctor =0;
    $DOPR =0;
    $LAMA =0;
    $Referral=0;

    $previous = "'".$previousDate.' 8:00:00'."'";
    $current = "'".$currentDate.' 8:00:00'."'";
    $wheres = 'babyAdmission.loungeId = "'.$loungeId.'" AND babyAdmission.staffId="'.$stafId.'" AND babyAdmission.dateOfDischarge BETWEEN '.$previous.' AND '.$current;

    //babyAdmission.dateOfDischarge BETWEEN '.$previous.' AND '.$current;
   
    $query = $this->db->query('SELECT babyAdmission.*,babyRegistration.motherId FROM babyAdmission JOIN babyRegistration on babyRegistration.babyId=babyAdmission.babyId WHERE '.$wheres);
    $total = $query->num_rows();
    if($total > 0)
    {
      $record = $query->result_array();
      foreach ($record as $key => $mothers) {
        
        if($mothers['typeOfDischarge']=="Referral"){
          $referral = $referral+1;
        }
        elseif($mothers['typeOfDischarge']=="LAMA"){
          $LAMA = $LAMA+1;
        }
        elseif($mothers['typeOfDischarge']=="DOPR"){
          $DOPR = $DOPR+1;
        }
        elseif($mothers['typeOfDischarge']=="Doctor's discretion"){
          $Doctor = $Doctor+1;
        }
        elseif($mothers['typeOfDischarge']=="Died"){
          $Died = $Died+1;
        }
        elseif($mothers['typeOfDischarge']=="Absconded"){
          $Absconded = $Absconded+1;
        }


      }
      

    }
    $return['total']=$total;
    $return['referral']=$referral;
    $return['LAMA']=$LAMA;
    $return['DOPR']=$DOPR;
    $return['Doctor']=$Doctor;
    $return['Died']=$Died;
    $return['Absconded']=$Absconded;
    return $return;
  }


  // total Mother discharge
  public function totalMotherDischargeByNurse($loungeId, $stafId){
    $previousDate = date('Y-m-d',strtotime("-1 days"));
    $currentDate = date('Y-m-d');

    $return = array();
  
    $Absconded =0;
    $Died =0;
    $Doctor =0;
    $DOPR =0;
    $LAMA =0;
    $Referral=0;
    $Normal=0;

    $previous = "'".$previousDate.' 8:00:00'."'";
    $current = "'".$currentDate.' 8:00:00'."'";
    $wheres = 'motherAdmission.loungeId = "'.$loungeId.'" AND motherAdmission.dischargeByNurse="'.$stafId.'" AND motherAdmission.dateOfDischarge BETWEEN '.$previous.' AND '.$current;

    //babyAdmission.dateOfDischarge BETWEEN '.$previous.' AND '.$current;
   
    $query = $this->db->query('SELECT motherAdmission.*,motherRegistration.motherId FROM motherAdmission JOIN motherRegistration on motherRegistration.motherId=motherAdmission.motherId WHERE '.$wheres);
    $total = $query->num_rows();
    if($total > 0)
    {
      $record = $query->result_array();
      foreach ($record as $key => $mothers) {
        
        if($mothers['typeOfDischarge']=="Referral"){
          $referral = $referral+1;
        }
        elseif($mothers['typeOfDischarge']=="LAMA"){
          $LAMA = $LAMA+1;
        }
        elseif($mothers['typeOfDischarge']=="DOPR"){
          $DOPR = $DOPR+1;
        }
        elseif($mothers['typeOfDischarge']=="Doctor's discretion"){
          $Doctor = $Doctor+1;
        }
        elseif($mothers['typeOfDischarge']=="Died"){
          $Died = $Died+1;
        }
        elseif($mothers['typeOfDischarge']=="Absconded"){
          $Absconded = $Absconded+1;
        }
        elseif($mothers['typeOfDischarge']=="Normal Discharge"){
          $Normal = $Normal+1;
        }


      }
      

    }
    $return['total']=$total;
    $return['Normal']=$Normal;
    $return['referral']=$referral;
    $return['LAMA']=$LAMA;
    $return['DOPR']=$DOPR;
    $return['Doctor']=$Doctor;
    $return['Died']=$Died;
    $return['Absconded']=$Absconded;
    return $return;
  }


}
?>