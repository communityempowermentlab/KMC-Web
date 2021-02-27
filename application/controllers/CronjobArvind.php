<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CronjobArvind extends CI_Controller {


	public function __construct() {
        parent::__construct();

        date_default_timezone_set('Asia/Kolkata');

        ini_set('memory_limit', '-1');
        $this->load->helper('string');
        $this->load->helper('api');
        $this->load->library('email');

	    ini_set('max_execution_time', 0);
			ini_set("memory_limit", "1024M");
			// $this->email->initialize(array(
   //              'mailtype'      => 'html'
   //      	));
	        // $this->email->initialize(array(
	        //   'protocol'  => 'smtp',
	        //   'smtp_host' => 'smtp.sendgrid.net',
	        //   'smtp_user' => 'neha@cel',
	        //   'smtp_pass' => 'Neha@cel1',
	        //   'mailtype' => 'html',
	        //   'wordwrap' => TRUE,
	        //   'smtp_port' => 587,
	        //   'crlf'      => "\r\n", 
	        //   'newline'   => "\r\n"
	        // ));

        $this->email->initialize(array(
            'protocol'  => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_user' => 'noreply@celworld.org',
            'smtp_pass' => 'Community#2050',
            'mailtype' => 'html',
            'wordwrap' => TRUE,
            'smtp_port' => 465,
            'crlf'      => "\r\n", 
            'smtp_crypto'  => 'ssl',
            'newline'   => "\r\n"
          ));
        
        $this->load->model('CronjobModelArvind','cmodel');
        $this->load->library('m_pdf');    
        $this->load->library('excel');
    }

    // Mother Baby discharge details for feedback calling report
    public function getMotherBabyDischargeFeedbackReport(){
      
      // set loop for all teams
      $filename = "";
      $dataCount = 0;
      $a=0;
      for($team_row=7;$team_row<=14;$team_row++){

          $objPHPExcel = new PHPExcel();

          $objWorkSheet = $objPHPExcel->setActiveSheetIndex(0);
          $objWorkSheet->getRowDimension('1')->setRowHeight(25);
          $objWorkSheet->mergeCells('A1:G1');
          $objWorkSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $objWorkSheet->getStyle('A1')->getFont()->setBold(true)->setSize(13);

          $objWorkSheet->getStyle('A3:CL3')->getFont()->setBold(true)->setSize(10);
          $objWorkSheet->getStyle('A3:CL3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $objWorkSheet->getStyle('A3:CL3')->getAlignment()->setWrapText(true);

          $objWorkSheet->getColumnDimension('A')->setWidth(8);
          $objWorkSheet->getColumnDimension('B')->setWidth(18);
          $objWorkSheet->getColumnDimension('C')->setWidth(24);
          $objWorkSheet->getColumnDimension('D')->setWidth(15);
          $objWorkSheet->getColumnDimension('E')->setWidth(15);
          $objWorkSheet->getColumnDimension('F')->setWidth(20);
          $objWorkSheet->getColumnDimension('G')->setWidth(13);
          $objWorkSheet->getColumnDimension('H')->setWidth(13);
          $objWorkSheet->getColumnDimension('I')->setWidth(10);
          $objWorkSheet->getColumnDimension('J')->setWidth(14);
          $objWorkSheet->getColumnDimension('K')->setWidth(14);
          $objWorkSheet->getColumnDimension('L')->setWidth(14);
          $objWorkSheet->getColumnDimension('M')->setWidth(14);
          $objWorkSheet->getColumnDimension('N')->setWidth(14);
          $objWorkSheet->getColumnDimension('O')->setWidth(18);
          $objWorkSheet->getColumnDimension('P')->setWidth(20);
          $objWorkSheet->getColumnDimension('Q')->setWidth(16);
          $objWorkSheet->getColumnDimension('R')->setWidth(16);
          $objWorkSheet->getColumnDimension('S')->setWidth(14);
          $objWorkSheet->getColumnDimension('T')->setWidth(10);
          $objWorkSheet->getColumnDimension('U')->setWidth(13);
          $objWorkSheet->getColumnDimension('V')->setWidth(20);
          $objWorkSheet->getColumnDimension('W')->setWidth(16);
          $objWorkSheet->getColumnDimension('X')->setWidth(16);
          $objWorkSheet->getColumnDimension('Y')->setWidth(21);
          $objWorkSheet->getColumnDimension('Z')->setWidth(21);
          $objWorkSheet->getColumnDimension('AA')->setWidth(21);
          $objWorkSheet->getColumnDimension('AB')->setWidth(21);
          $objWorkSheet->getColumnDimension('AC')->setWidth(15);
          $objWorkSheet->getColumnDimension('AD')->setWidth(18);
          $objWorkSheet->getColumnDimension('AE')->setWidth(20);
          $objWorkSheet->getColumnDimension('AF')->setWidth(20);
          $objWorkSheet->getColumnDimension('AG')->setWidth(23);
          $objWorkSheet->getColumnDimension('AH')->setWidth(16);
          $objWorkSheet->getColumnDimension('AI')->setWidth(14);
          $objWorkSheet->getColumnDimension('AJ')->setWidth(20);
          $objWorkSheet->getColumnDimension('AK')->setWidth(25);
          $objWorkSheet->getColumnDimension('AL')->setWidth(25);
          $objWorkSheet->getColumnDimension('AM')->setWidth(22);
          $objWorkSheet->getColumnDimension('AN')->setWidth(28);
          $objWorkSheet->getColumnDimension('AO')->setWidth(28);
          $objWorkSheet->getColumnDimension('AP')->setWidth(28);
          $objWorkSheet->getColumnDimension('AQ')->setWidth(28);
          $objWorkSheet->getColumnDimension('AR')->setWidth(28);
          $objWorkSheet->getColumnDimension('AS')->setWidth(30);
          $objWorkSheet->getColumnDimension('AT')->setWidth(30);
          $objWorkSheet->getColumnDimension('AU')->setWidth(16);
          $objWorkSheet->getColumnDimension('AV')->setWidth(20);
          $objWorkSheet->getColumnDimension('AW')->setWidth(20);
          $objWorkSheet->getColumnDimension('AX')->setWidth(20);
          $objWorkSheet->getColumnDimension('AY')->setWidth(20);
          $objWorkSheet->getColumnDimension('AZ')->setWidth(20);
          $objWorkSheet->getColumnDimension('BA')->setWidth(15);
          $objWorkSheet->getColumnDimension('BB')->setWidth(16);
          $objWorkSheet->getColumnDimension('BC')->setWidth(16);
          $objWorkSheet->getColumnDimension('BD')->setWidth(16);
          $objWorkSheet->getColumnDimension('BE')->setWidth(20);
          $objWorkSheet->getColumnDimension('BF')->setWidth(20);
          $objWorkSheet->getColumnDimension('BG')->setWidth(16);
          $objWorkSheet->getColumnDimension('BH')->setWidth(16);
          $objWorkSheet->getColumnDimension('BI')->setWidth(18);
          $objWorkSheet->getColumnDimension('BJ')->setWidth(20);
          $objWorkSheet->getColumnDimension('BK')->setWidth(20);
          $objWorkSheet->getColumnDimension('BL')->setWidth(20);
          $objWorkSheet->getColumnDimension('BM')->setWidth(20);
          $objWorkSheet->getColumnDimension('BN')->setWidth(16);
          $objWorkSheet->getColumnDimension('BO')->setWidth(20);
          $objWorkSheet->getColumnDimension('BP')->setWidth(20);
          $objWorkSheet->getColumnDimension('BQ')->setWidth(20);
          $objWorkSheet->getColumnDimension('BR')->setWidth(20);
          $objWorkSheet->getColumnDimension('BS')->setWidth(20);
          $objWorkSheet->getColumnDimension('BT')->setWidth(20);
          $objWorkSheet->getColumnDimension('BU')->setWidth(15);
          $objWorkSheet->getColumnDimension('BV')->setWidth(15);
          $objWorkSheet->getColumnDimension('BW')->setWidth(20);
          $objWorkSheet->getColumnDimension('BX')->setWidth(20);
          $objWorkSheet->getColumnDimension('BY')->setWidth(20);
          $objWorkSheet->getColumnDimension('BZ')->setWidth(20);
          $objWorkSheet->getColumnDimension('CA')->setWidth(14);
          $objWorkSheet->getColumnDimension('CB')->setWidth(20);
          $objWorkSheet->getColumnDimension('CC')->setWidth(20);
          $objWorkSheet->getColumnDimension('CD')->setWidth(20);
          $objWorkSheet->getColumnDimension('CE')->setWidth(20);
          $objWorkSheet->getColumnDimension('CF')->setWidth(20);
          $objWorkSheet->getColumnDimension('CG')->setWidth(20);
          $objWorkSheet->getColumnDimension('CH')->setWidth(20);
          $objWorkSheet->getColumnDimension('CI')->setWidth(20);
          $objWorkSheet->getColumnDimension('CJ')->setWidth(20);
          $objWorkSheet->getColumnDimension('CK')->setWidth(18);
          $objWorkSheet->getColumnDimension('CL')->setWidth(20);

          $objWorkSheet->getStyle('A:CL')->getFont()->setSize(10);
          $objWorkSheet->getStyle('A:CL')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $objWorkSheet->getStyle('A:CL')->getAlignment()->setWrapText(true);

          $objWorkSheet->setCellValue('A3', 'Sr. No.');
          $objWorkSheet->setCellValue('B3', 'Facility Name');
          $objWorkSheet->setCellValue('C3', 'Lounge Name');
          $objWorkSheet->setCellValue('D3', "Mother's Name");
          $objWorkSheet->setCellValue('E3', 'Mother accompanied during admission?');
          $objWorkSheet->setCellValue('F3', 'Mother Mobile Number');
          $objWorkSheet->setCellValue('G3', 'Delivery Date');
          $objWorkSheet->setCellValue('H3', 'Delivery Time');
          $objWorkSheet->setCellValue('I3', 'Gender');
          $objWorkSheet->setCellValue('J3', 'Birth Weight(gm)');
          $objWorkSheet->setCellValue('K3', 'Inborn/Outborn');
          $objWorkSheet->setCellValue('L3', 'Type of Delivery');
          $objWorkSheet->setCellValue('M3', 'Admission Date');
          $objWorkSheet->setCellValue('N3', 'Admission Time');
          $objWorkSheet->setCellValue('O3', 'Admission Weight(gm)');
          $objWorkSheet->setCellValue('P3', 'Assessment Date & time');
          $objWorkSheet->setCellValue('Q3', 'Thermometer Value');
          $objWorkSheet->setCellValue('R3', 'Respiratory Count');
          $objWorkSheet->setCellValue('S3', 'Pulse Oximeter');
          $objWorkSheet->setCellValue('T3', 'SpO2');
          $objWorkSheet->setCellValue('U3', 'Pulse Rate');
          $objWorkSheet->setCellValue('V3', 'Reason if Pulse Oximeter not available');
          $objWorkSheet->setCellValue('W3', 'Daily Weight Date');
          $objWorkSheet->setCellValue('X3', 'Daily Weight(gm)');
          $objWorkSheet->setCellValue('Y3', 'KMC Position Start Date');
          $objWorkSheet->setCellValue('Z3', 'KMC Position Start Time');
          $objWorkSheet->setCellValue('AA3', 'KMC Position Stop Date');
          $objWorkSheet->setCellValue('AB3', 'KMC Position Stop Time');
          $objWorkSheet->setCellValue('AC3', 'KMC Provider');
          $objWorkSheet->setCellValue('AD3', 'KMC Nurse Name');
          $objWorkSheet->setCellValue('AE3', 'Nutrition Feeding Date');
          $objWorkSheet->setCellValue('AF3', 'Nutrition Feeding Time');
          $objWorkSheet->setCellValue('AG3', 'Nutrition Feeding Method');
          $objWorkSheet->setCellValue('AH3', 'Nutrition Type');
          $objWorkSheet->setCellValue('AI3', 'Nutrition Quantity(ml)');
          $objWorkSheet->setCellValue('AJ3', 'Nutrition Nurse Name');
          $objWorkSheet->setCellValue('AK3', 'Doctor Round Doctor Name');
          $objWorkSheet->setCellValue('AL3', 'Doctor Round Treatment Time');
          $objWorkSheet->setCellValue('AM3', 'Doctor Round Treatment');
          $objWorkSheet->setCellValue('AN3', 'Doctor Round Treatment Remarks');
          $objWorkSheet->setCellValue('AO3', 'Counselling Poster What Is KMC');
          $objWorkSheet->setCellValue('AP3', 'Counselling Poster KMC Position');
          $objWorkSheet->setCellValue('AQ3', 'Counselling Poster KMC Nutrition');
          $objWorkSheet->setCellValue('AR3', 'Counselling Poster KMC Hygiene');
          $objWorkSheet->setCellValue('AS3', 'Counselling Poster KMC Monitoring');
          $objWorkSheet->setCellValue('AT3', 'Counselling Poster KMC Respect');
          $objWorkSheet->setCellValue('AU3', 'Discharge Type');
          $objWorkSheet->setCellValue('AV3', 'Discharge Date and Time');
          $objWorkSheet->setCellValue('AW3', 'Profile - Nurse Name');
          $objWorkSheet->setCellValue('AX3', "Father's Name");
          $objWorkSheet->setCellValue('AY3', 'Mother Aadhaar Number');
          $objWorkSheet->setCellValue('AZ3', 'Father Aadhaar Number');
          $objWorkSheet->setCellValue('BA3', 'MCTS Number');
          $objWorkSheet->setCellValue('BB3', "Mother's Weight(Kg)");
          $objWorkSheet->setCellValue('BC3', "Mother's DOB");
          $objWorkSheet->setCellValue('BD3', "Mother's Age(in case DOB not known)");
          $objWorkSheet->setCellValue('BE3', "Age at Marriage(years)");
          $objWorkSheet->setCellValue('BF3', "Mother's Education");
          $objWorkSheet->setCellValue('BG3', "Religion");
          $objWorkSheet->setCellValue('BH3', "Caste");
          $objWorkSheet->setCellValue('BI3', "Have you ever had multiple births?");
          $objWorkSheet->setCellValue('BJ3', "Total Pregnancies (gravida)");
          $objWorkSheet->setCellValue('BK3', "No. of births (para)");
          $objWorkSheet->setCellValue('BL3', "No. of miscarriage or abortion");
          $objWorkSheet->setCellValue('BM3', "Total no. of children who are currently alive");
          $objWorkSheet->setCellValue('BN3', "Birth Spacing");
          $objWorkSheet->setCellValue('BO3', "Father Mobile Number");
          $objWorkSheet->setCellValue('BP3', "Guardian Name");
          $objWorkSheet->setCellValue('BQ3', "Relationship with Child");
          $objWorkSheet->setCellValue('BR3', "Guardian Phone Number");
          $objWorkSheet->setCellValue('BS3', "Family ration card type");
          $objWorkSheet->setCellValue('BT3', "Present Address Type");
          $objWorkSheet->setCellValue('BU3', "Country");
          $objWorkSheet->setCellValue('BV3', "State");
          $objWorkSheet->setCellValue('BW3', "District");
          $objWorkSheet->setCellValue('BX3', "Rural Block");
          $objWorkSheet->setCellValue('BY3', "Rural Gram");
          $objWorkSheet->setCellValue('BZ3', "Address");
          $objWorkSheet->setCellValue('CA3', "Pincode");
          $objWorkSheet->setCellValue('CB3', "Nearby Location");
          $objWorkSheet->setCellValue('CC3', "Permanent address same as present address");
          $objWorkSheet->setCellValue('CD3', "Permanent Address type");
          $objWorkSheet->setCellValue('CE3', "Permanent Country");
          $objWorkSheet->setCellValue('CF3', "Permanent State");
          $objWorkSheet->setCellValue('CG3', "Permanent District");
          $objWorkSheet->setCellValue('CH3', "Permanent Rural Block");
          $objWorkSheet->setCellValue('CI3', "Permanent Rural Gram");
          $objWorkSheet->setCellValue('CJ3', "Permanent Address");
          $objWorkSheet->setCellValue('CK3', "Permanent Pincode");
          $objWorkSheet->setCellValue('CL3', "Permanent Nearby Location");

          $objWorkSheet->setCellValue('A1', 'Mother Baby Details For Feedback Calling');



          $getReportSettings = $this->cmodel->getReportSettings($team_row);
          $loungeArray = array_column($getReportSettings['facilities'], 'loungeId');
          if(!empty($loungeArray)){

              // Get all baby of lounge
              $getAllBabyAdmission = $this->cmodel->getBabyAdmissionDischargeData($loungeArray);
              $dataCount = 1;
              $a=4;

              foreach($getAllBabyAdmission as $key_baby => $getAllBabyAdmissionData){

                $babyListArray    = [];
                $babyListArray[]  = $dataCount;
                $babyListArray[]  = $getAllBabyAdmissionData['FacilityName'];
                $babyListArray[]  = $getAllBabyAdmissionData['loungeName'];
                $babyListArray[]  = $getAllBabyAdmissionData['motherName'];
                $babyListArray[]  = $getAllBabyAdmissionData['isMotherAdmitted'];
                $babyListArray[]  = $getAllBabyAdmissionData['motherMobileNumber'];
                $babyListArray[]  = date('jS M',strtotime($getAllBabyAdmissionData['deliveryDate']));
                $babyListArray[]  = date('h:i A',strtotime($getAllBabyAdmissionData['deliveryTime']));
                $babyListArray[]  = ($getAllBabyAdmissionData['babyGender'] == "Male") ? "M" : (($getAllBabyAdmissionData['babyGender'] == "Female") ? "F" : "Others");
                $babyListArray[]  = $getAllBabyAdmissionData['babyWeight'];
                $babyListArray[]  = $getAllBabyAdmissionData['typeOfBorn'];
                $babyListArray[]  = $getAllBabyAdmissionData['deliveryType'];
                $babyListArray[]  = date('jS M',strtotime($getAllBabyAdmissionData['admissionDateTime']));
                $babyListArray[]  = date('h:i A',strtotime($getAllBabyAdmissionData['admissionDateTime']));
                $babyListArray[]  = $getAllBabyAdmissionData['babyAdmissionWeight'];

                $objWorkSheet->fromArray($babyListArray, null, 'A'.$a);
                $sortMaxElement = $a;
                /****************baby assessment list*****************/
                $getAllBabyAssessmentList = $this->cmodel->getBabyDailyMonitoring($getAllBabyAdmissionData['babyAdmissionId']);
                $assessment_row = $a;
                foreach($getAllBabyAssessmentList as $key_assessment => $getAllBabyAssessmentData){

                  // thermometer value
                  if($getAllBabyAssessmentData['isThermometerAvailable']=="Yes"){
                    $thermometerValue = $getAllBabyAssessmentData['temperatureValue']." ".$getAllBabyAssessmentData['temperatureUnit'];
                  }else{
                    if(!empty($getAllBabyAssessmentData['reasonValue']) && $getAllBabyAssessmentData['reasonValue'] != "Other"){
                     $thermometerValue = $getAllBabyAssessmentData['reasonValue']; 
                    }elseif($getAllBabyAssessmentData['reasonValue'] == "Other"){ 
                      $thermometerValue = $getAllBabyAssessmentData['otherValue']; 
                    }else{ 
                      $thermometerValue = ""; 
                    }
                  }

                  // pulse oximeter value
                  if($getAllBabyAssessmentData['isPulseOximatoryDeviceAvail'] == "Yes"){ 
                    $spO2Value = $getAllBabyAssessmentData['spo2']."%";
                    $pulseRateValue = $getAllBabyAssessmentData['pulseRate']." bpm";
                    $oximeterNotAvailReason = "";
                  }else{
                    $spO2Value = "";
                    $pulseRateValue = "";
                    if(!empty($getAllBabyAssessmentData['pulseReasonValue']) && $getAllBabyAssessmentData['pulseReasonValue'] != "Other"){
                     $oximeterNotAvailReason = $getAllBabyAssessmentData['pulseReasonValue']; 
                    }elseif($getAllBabyAssessmentData['pulseReasonValue'] == "Other"){ 
                      $oximeterNotAvailReason = $getAllBabyAssessmentData['pulseOtherValue']; 
                    }else{ 
                      $oximeterNotAvailReason = ""; 
                    }
                  }

                  $assessmentListArray    = [];
                  $assessmentListArray[]    = date('jS M',strtotime($getAllBabyAssessmentData['assesmentDate']))." ".date('h:i A',strtotime($getAllBabyAssessmentData['assesmentTime']));
                  $assessmentListArray[]    = $thermometerValue;
                  $assessmentListArray[]    = $getAllBabyAssessmentData['respiratoryRate']."/min";
                  $assessmentListArray[]    = $getAllBabyAssessmentData['isPulseOximatoryDeviceAvail'];
                  $assessmentListArray[]    = $spO2Value;
                  $assessmentListArray[]    = $pulseRateValue;
                  $assessmentListArray[]    = $oximeterNotAvailReason;

                  $objWorkSheet->fromArray($assessmentListArray, null, 'P'.$assessment_row);
                  $assessment_row = $assessment_row+1;
                }

                /****************baby daily weight list*****************/
                $getAllBabyDailyWeightList = $this->cmodel->getBabyDailyWeightById($getAllBabyAdmissionData['babyAdmissionId']);
                $dailyweight_row = $a;
                foreach($getAllBabyDailyWeightList as $key_weight => $getAllBabyDailyWeightData){
                  $weightListArray    = [];
                  $weightListArray[]    = date('jS M',strtotime($getAllBabyDailyWeightData['weightDate']));
                  $weightListArray[]    = $getAllBabyDailyWeightData['babyWeight'];

                  $objWorkSheet->fromArray($weightListArray, null, 'W'.$dailyweight_row);
                  $dailyweight_row = $dailyweight_row+1;
                }

                /****************baby kmc position list*****************/
                $getAllBabyKmcPositionList = $this->cmodel->getBabyKmcPositionById($getAllBabyAdmissionData['babyAdmissionId']);
                $kmcposition_row = $a;
                foreach($getAllBabyKmcPositionList as $key_kmc => $getAllBabyKmcPositionData){
                  $kmcListArray    = [];
                  $kmcListArray[]    = date('jS M',strtotime($getAllBabyKmcPositionData['startDate']));
                  $kmcListArray[]    = date('h:i A',strtotime($getAllBabyKmcPositionData['startTime']));
                  $kmcListArray[]    = date('jS M',strtotime($getAllBabyKmcPositionData['endDate']));
                  $kmcListArray[]    = date('h:i A',strtotime($getAllBabyKmcPositionData['endTime']));
                  $kmcListArray[]    = $getAllBabyKmcPositionData['provider'];
                  $kmcListArray[]    = $getAllBabyKmcPositionData['nurseName'];

                  $objWorkSheet->fromArray($kmcListArray, null, 'Y'.$kmcposition_row);
                  $kmcposition_row = $kmcposition_row+1;
                }

                /****************baby nutrition list*****************/
                $getAllBabyNutritionList = $this->cmodel->getBabyNutritionById($getAllBabyAdmissionData['babyAdmissionId']);
                $nutrition_row = $a;
                foreach($getAllBabyNutritionList as $key_nutrition => $getAllBabyNutritionData){
                  $nutritionListArray    = [];
                  $nutritionListArray[]    = date('jS M',strtotime($getAllBabyNutritionData['feedDate']));
                  $nutritionListArray[]    = date('h:i A',strtotime($getAllBabyNutritionData['feedTime']));
                  $nutritionListArray[]    = $getAllBabyNutritionData['breastFeedMethod'];
                  $nutritionListArray[]    = $getAllBabyNutritionData['fluid'];
                  $nutritionListArray[]    = $getAllBabyNutritionData['milkQuantity'];
                  $nutritionListArray[]    = $getAllBabyNutritionData['nurseName'];

                  $objWorkSheet->fromArray($nutritionListArray, null, 'AE'.$nutrition_row);
                  $nutrition_row = $nutrition_row+1;
                }

                /****************doctor prescription list*****************/
                $getAllBabyPrescriptionList = $this->cmodel->getBabyPrescriptionById($getAllBabyAdmissionData['babyAdmissionId']);
                $prescription_row = $a;
                foreach($getAllBabyPrescriptionList as $key_prescription => $getAllBabyPrescriptionData){
                  $prescriptionListArray    = [];
                  $prescriptionListArray[]    = $getAllBabyPrescriptionData['doctorName'];
                  $prescriptionListArray[]    = date('jS M h:i A',strtotime($getAllBabyPrescriptionData['addDate']));
                  $prescriptionListArray[]    = $getAllBabyPrescriptionData['prescriptionName'];
                  $prescriptionListArray[]    = $getAllBabyPrescriptionData['comment'];
                  
                  $objWorkSheet->fromArray($prescriptionListArray, null, 'AK'.$prescription_row);
                  $prescription_row = $prescription_row+1;
                }

                /****************counselling time*****************/
                $counsellingListArray = [];
                $getCounsellingWhatisKmc = $this->cmodel->getBabyCounsellingTimeById($getAllBabyAdmissionData['babyId'],1);
                if(!empty($getCounsellingWhatisKmc)){
                  $explodeTimeFormat = explode(":",$getCounsellingWhatisKmc['totalSeconds']);
                  $counsellingListArray[]    = (($explodeTimeFormat[0] != "0") ? ($explodeTimeFormat[0]."h "):"").(($explodeTimeFormat[1] != "0") ? ($explodeTimeFormat[1]."m "):"").(($explodeTimeFormat[2] != "0") ? (round($explodeTimeFormat[2])."s"):""); 
                }else{
                  $counsellingListArray[] = "";
                }
                

                $getCounsellingKmcPosition = $this->cmodel->getBabyCounsellingTimeById($getAllBabyAdmissionData['babyId'],2);
                if(!empty($getCounsellingKmcPosition)){
                  $explodeTimeFormat = explode(":",$getCounsellingKmcPosition['totalSeconds']);
                  $counsellingListArray[]    = (($explodeTimeFormat[0] != "0") ? ($explodeTimeFormat[0]."h "):"").(($explodeTimeFormat[1] != "0") ? ($explodeTimeFormat[1]."m "):"").(($explodeTimeFormat[2] != "0") ? (round($explodeTimeFormat[2])."s"):""); 
                }else{
                  $counsellingListArray[] = "";
                }

                $getCounsellingKmcNutrition = $this->cmodel->getBabyCounsellingTimeById($getAllBabyAdmissionData['babyId'],3);
                if(!empty($getCounsellingKmcNutrition)){
                  $explodeTimeFormat = explode(":",$getCounsellingKmcNutrition['totalSeconds']);
                  $counsellingListArray[]    = (($explodeTimeFormat[0] != "0") ? ($explodeTimeFormat[0]."h "):"").(($explodeTimeFormat[1] != "0") ? ($explodeTimeFormat[1]."m "):"").(($explodeTimeFormat[2] != "0") ? (round($explodeTimeFormat[2])."s"):""); 
                }else{
                  $counsellingListArray[] = "";
                }

                $getCounsellingKmcHygiene = $this->cmodel->getBabyCounsellingTimeById($getAllBabyAdmissionData['babyId'],4);
                if(!empty($getCounsellingKmcHygiene)){
                  $explodeTimeFormat = explode(":",$getCounsellingKmcHygiene['totalSeconds']);
                  $counsellingListArray[]    = (($explodeTimeFormat[0] != "0") ? ($explodeTimeFormat[0]."h "):"").(($explodeTimeFormat[1] != "0") ? ($explodeTimeFormat[1]."m "):"").(($explodeTimeFormat[2] != "0") ? (round($explodeTimeFormat[2])."s"):""); 
                }else{
                  $counsellingListArray[] = "";
                }

                $getCounsellingKmcMonitoring = $this->cmodel->getBabyCounsellingTimeById($getAllBabyAdmissionData['babyId'],5);
                if(!empty($getCounsellingKmcMonitoring)){
                  $explodeTimeFormat = explode(":",$getCounsellingKmcMonitoring['totalSeconds']);
                  $counsellingListArray[]    = (($explodeTimeFormat[0] != "0") ? ($explodeTimeFormat[0]."h "):"").(($explodeTimeFormat[1] != "0") ? ($explodeTimeFormat[1]."m "):"").(($explodeTimeFormat[2] != "0") ? (round($explodeTimeFormat[2])."s"):""); 
                }else{
                  $counsellingListArray[] = "";
                }

                $getCounsellingKmcRespect = $this->cmodel->getBabyCounsellingTimeById($getAllBabyAdmissionData['babyId'],6);
                if(!empty($getCounsellingKmcRespect)){
                  $explodeTimeFormat = explode(":",$getCounsellingKmcRespect['totalSeconds']);
                  $counsellingListArray[]    = (($explodeTimeFormat[0] != "0") ? ($explodeTimeFormat[0]."h "):"").(($explodeTimeFormat[1] != "0") ? ($explodeTimeFormat[1]."m "):"").(($explodeTimeFormat[2] != "0") ? (round($explodeTimeFormat[2])."s"):""); 
                }else{
                  $counsellingListArray[] = "";
                }

                $objWorkSheet->fromArray($counsellingListArray, null, 'AO'.$a);
                
                /**************Discharge & Mother Profile Data*****************/
                $motherProfileDataArray = [];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['typeOfDischarge'];
                $motherProfileDataArray[]  = date('jS M h:i A',strtotime($getAllBabyAdmissionData['dateOfDischarge']));
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['motherProfileUpdateNurse'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['fatherName'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['motherAadharNumber'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['fatherAadharNumber'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['motherMCTSNumber'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['motherWeight'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['motherDOB'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['motherAge'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['ageAtMarriage'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['motherEducation'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['motherReligion'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['motherCaste'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['multipleBirth'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['gravida'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['para'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['abortion'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['live'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['birthSpacing'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['fatherMobileNumber'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['guardianName'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['guardianRelation'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['guardianNumber'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['rationCardType'];

                $PresentDistrictName = $this->cmodel->GetPresentDistrictName($getAllBabyAdmissionData['presentDistrictName']);
                $PresentBlockName = $this->cmodel->GetPresentBlockName($getAllBabyAdmissionData['presentBlockName']);
                $PresentVillageName = $this->cmodel->GetPresentVillageName($getAllBabyAdmissionData['presentVillageName']);

                $motherProfileDataArray[]  = $getAllBabyAdmissionData['presentResidenceType'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['presentCountry'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['presentState'];
                $motherProfileDataArray[]  = $PresentDistrictName['DistrictNameProperCase'];
                $motherProfileDataArray[]  = $PresentBlockName['BlockPRINameProperCase'];
                $motherProfileDataArray[]  = $PresentVillageName['GPNameProperCase'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['presentAddress'];

                $PermanentDistrictName = $this->cmodel->GetPresentDistrictName($getAllBabyAdmissionData['permanentDistrictName']);
                $PermanentBlockName = $this->cmodel->GetPresentBlockName($getAllBabyAdmissionData['permanentBlockName']);
                $PermanentVillageName = $this->cmodel->GetPresentVillageName($getAllBabyAdmissionData['permanentVillageName']);

                $motherProfileDataArray[]  = $getAllBabyAdmissionData['presentPinCode'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['presentAddNearByLocation'];
                $motherProfileDataArray[]  = ($getAllBabyAdmissionData['sameAddress'] == "1")?"Yes":"No";
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['permanentResidenceType'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['permanentCountry'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['permanentState'];
                $motherProfileDataArray[]  = $PermanentDistrictName['DistrictNameProperCase'];
                $motherProfileDataArray[]  = $PermanentBlockName['BlockPRINameProperCase'];
                $motherProfileDataArray[]  = $PermanentVillageName['GPNameProperCase'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['permanentAddress'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['permanentPinCode'];
                $motherProfileDataArray[]  = $getAllBabyAdmissionData['permanentAddNearByLocation'];

                $objWorkSheet->fromArray($motherProfileDataArray, null, 'AU'.$a);

                /************************/
                $maximumRowsArray = array(count($getAllBabyAssessmentList),count($getAllBabyDailyWeightList),count($getAllBabyKmcPositionList),count($getAllBabyNutritionList),count($getAllBabyPrescriptionList));
                $sortMaxElement = max($maximumRowsArray);

                // increment next row
                $a = $a+$sortMaxElement+1;

                $styleArray = array(
                  'borders' => array(
                  'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
                  )
                  )
                );
                $objWorkSheet->getStyle('A1:CL'.$a.'')->applyFromArray($styleArray);

                $dataCount++;
              }

              $objWorkSheet->setTitle('Mother Baby Details');

              $folderArray = array('7'=>'Team1','8'=>'Team2','9'=>'Team3','10'=>'Team4','11'=>'Team5','12'=>'Team6','13'=>'Team7','14'=>'Team8');
              $folderName = "motherBabyDetailsForFeedback/".$folderArray[$team_row]."/";
              $file = "Mother-Baby-Details-For-Feedback-".$folderArray[$team_row]."-".date('Y-m-d',strtotime("-1 days"));
              $filename = $file.'.xls';
              
              header('Content-Type: application/vnd.ms-excel');
              header('Content-Disposition: attachment;filename="'.$filename.'"');
              header('Cache-Control: max-age=0');

              $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
              //$objWriter->save('php://output');
              $objWriter->save(str_replace(__FILE__,'assets/Reports/'.$folderName.$filename,__FILE__));
              chmod('assets/Reports/'.$folderName.$filename, 0777);

              // save file log
              if(!empty($getReportSettings)){
                $checkFileExist = $this->db->get_where('reportLogs',array('reportLogs.reportSettingId'=>$getReportSettings['id'],'fileName'=>$filename))->row_array();
                if(empty($checkFileExist)){
                  $logData['reportSettingId']      = $getReportSettings['id'];
                  $logData['fileName']             = $filename;
                  $logData['addDate']              = date('Y-m-d',strtotime("-1 days"));
                  $this->db->insert('reportLogs',$logData);
                }
              }
          }

      }

    }

    // Baby Weight Report
    public function babyWeightReport(){
      $objPHPExcel = new PHPExcel();

      $objWorkSheet = $objPHPExcel->setActiveSheetIndex(0);
      $objWorkSheet->getRowDimension('1')->setRowHeight(25);
      $objWorkSheet->mergeCells('A1:G1');
      $objWorkSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $objWorkSheet->getStyle('A1')->getFont()->setBold(true)->setSize(13);

      $objWorkSheet->getStyle('A3:AO3')->getFont()->setBold(true)->setSize(10);
      $objWorkSheet->getStyle('A3:AO3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $objWorkSheet->getStyle('A3:AO3')->getAlignment()->setWrapText(true);

      $objWorkSheet->getColumnDimension('A')->setWidth(8);
      $objWorkSheet->getColumnDimension('B')->setWidth(18);
      $objWorkSheet->getColumnDimension('C')->setWidth(24);
      $objWorkSheet->getColumnDimension('D')->setWidth(15);
      $objWorkSheet->getColumnDimension('E')->setWidth(16);
      $objWorkSheet->getColumnDimension('F')->setWidth(15);
      $objWorkSheet->getColumnDimension('G')->setWidth(15);
      $objWorkSheet->getColumnDimension('H')->setWidth(8);
      $objWorkSheet->getColumnDimension('I')->setWidth(18);
      $objWorkSheet->getColumnDimension('J')->setWidth(16);
      $objWorkSheet->getColumnDimension('K')->setWidth(20);
      $objWorkSheet->getColumnDimension('L')->setWidth(16);
      $objWorkSheet->getColumnDimension('M')->setWidth(16);
      $objWorkSheet->getColumnDimension('N')->setWidth(33);
      $objWorkSheet->getColumnDimension('O')->setWidth(33);
      $objWorkSheet->getColumnDimension('P')->setWidth(16);
      $objWorkSheet->getColumnDimension('Q')->setWidth(16);
      $objWorkSheet->getColumnDimension('R')->setWidth(35);
      $objWorkSheet->getColumnDimension('S')->setWidth(35);
      $objWorkSheet->getColumnDimension('T')->setWidth(16);
      $objWorkSheet->getColumnDimension('U')->setWidth(16);
      $objWorkSheet->getColumnDimension('V')->setWidth(35);
      $objWorkSheet->getColumnDimension('W')->setWidth(35);
      $objWorkSheet->getColumnDimension('X')->setWidth(16);
      $objWorkSheet->getColumnDimension('Y')->setWidth(16);
      $objWorkSheet->getColumnDimension('Z')->setWidth(35);
      $objWorkSheet->getColumnDimension('AA')->setWidth(35);
      $objWorkSheet->getColumnDimension('AB')->setWidth(16);
      $objWorkSheet->getColumnDimension('AC')->setWidth(16);
      $objWorkSheet->getColumnDimension('AD')->setWidth(35);
      $objWorkSheet->getColumnDimension('AE')->setWidth(35);
      $objWorkSheet->getColumnDimension('AF')->setWidth(16);
      $objWorkSheet->getColumnDimension('AG')->setWidth(16);
      $objWorkSheet->getColumnDimension('AH')->setWidth(35);
      $objWorkSheet->getColumnDimension('AI')->setWidth(35);
      $objWorkSheet->getColumnDimension('AJ')->setWidth(12);
      $objWorkSheet->getColumnDimension('AK')->setWidth(13);
      $objWorkSheet->getColumnDimension('AL')->setWidth(16);
      $objWorkSheet->getColumnDimension('AM')->setWidth(20);
      $objWorkSheet->getColumnDimension('AN')->setWidth(16);
      $objWorkSheet->getColumnDimension('AO')->setWidth(20);

      $objWorkSheet->getStyle('A:AO')->getFont()->setSize(10);
      $objWorkSheet->getStyle('A:AO')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $objWorkSheet->getStyle('A:AO')->getAlignment()->setWrapText(true);

      $objWorkSheet->setCellValue('A3', 'Sr. No.');
      $objWorkSheet->setCellValue('B3', 'Facility Name');
      $objWorkSheet->setCellValue('C3', 'Lounge Name');
      $objWorkSheet->setCellValue('D3', 'Reg. No.');
      $objWorkSheet->setCellValue('E3', 'Mother Name');
      $objWorkSheet->setCellValue('F3', 'Admission Date');
      $objWorkSheet->setCellValue('G3', 'Admission Time');
      $objWorkSheet->setCellValue('H3', 'Gender');
      $objWorkSheet->setCellValue('I3', 'Admission Height(cm)');
      $objWorkSheet->setCellValue('J3', 'Birth Weight(gm)');
      $objWorkSheet->setCellValue('K3', 'Admission Weight(gm)');
      $objWorkSheet->setCellValue('L3', 'Day 2 Weight(gm)');
      $objWorkSheet->setCellValue('M3', 'Day 2 KMC');
      $objWorkSheet->setCellValue('N3', 'Difference (Day 2-Admission Weight)');
      $objWorkSheet->setCellValue('O3', 'Gain/Loss % (Day 2-Admission Weight)');
      $objWorkSheet->setCellValue('P3', 'Day 3 Weight(gm)');
      $objWorkSheet->setCellValue('Q3', 'Day 3 KMC');
      $objWorkSheet->setCellValue('R3', 'Difference (Current Weight-Last Weight)');
      $objWorkSheet->setCellValue('S3', 'Gain/Loss % (Current Weight-Last Weight)');
      $objWorkSheet->setCellValue('T3', 'Day 4 Weight(gm)');
      $objWorkSheet->setCellValue('U3', 'Day 4 KMC');
      $objWorkSheet->setCellValue('V3', 'Difference (Current Weight-Last Weight)');
      $objWorkSheet->setCellValue('W3', 'Gain/Loss % (Current Weight-Last Weight)');
      $objWorkSheet->setCellValue('X3', 'Day 5 Weight(gm)');
      $objWorkSheet->setCellValue('Y3', 'Day 5 KMC');
      $objWorkSheet->setCellValue('Z3', 'Difference (Current Weight-Last Weight)');
      $objWorkSheet->setCellValue('AA3', 'Gain/Loss % (Current Weight-Last Weight)');
      $objWorkSheet->setCellValue('AB3', 'Day 6 Weight(gm)');
      $objWorkSheet->setCellValue('AC3', 'Day 6 KMC');
      $objWorkSheet->setCellValue('AD3', 'Difference (Current Weight-Last Weight)');
      $objWorkSheet->setCellValue('AE3', 'Gain/Loss % (Current Weight-Last Weight)');
      $objWorkSheet->setCellValue('AF3', 'Day 7 Weight(gm)');
      $objWorkSheet->setCellValue('AG3', 'Day 7 KMC');
      $objWorkSheet->setCellValue('AH3', 'Difference (Current Weight-Last Weight)');
      $objWorkSheet->setCellValue('AI3', 'Gain/Loss % (Current Weight-Last Weight)');
      $objWorkSheet->setCellValue('AJ3', 'Discharge');
      $objWorkSheet->setCellValue('AK3', 'Total Duration');
      $objWorkSheet->setCellValue('AL3', 'Total Difference');
      $objWorkSheet->setCellValue('AM3', 'Overall Gain/Loss (%)');
      $objWorkSheet->setCellValue('AN3', 'Total KMC');
      $objWorkSheet->setCellValue('AO3', 'Remarks');

      $objWorkSheet->setCellValue('A1', 'Weight Report');

      $getReportSettings = $this->cmodel->getReportSettings(2);
      $loungeArray = array_column($getReportSettings['facilities'], 'loungeId');

      // Get all baby
      $getAllBabyAdmission = $this->cmodel->getBabyAdmissionData($loungeArray);
      $babyTotalKmc = 0;
      $dataCount = 1;
      $a=4;

      foreach($getAllBabyAdmission as $key_baby => $getAllBabyAdmissionData){

          $babyListArray    = [];
          $babyListArray[]  = $dataCount;
          $babyListArray[]  = $getAllBabyAdmissionData['FacilityName'];
          $babyListArray[]  = $getAllBabyAdmissionData['loungeName'];
          $babyListArray[]  = $getAllBabyAdmissionData['babyFileId'];
          $babyListArray[]  = $getAllBabyAdmissionData['motherName'];
          $babyListArray[]  = date('jS M',strtotime($getAllBabyAdmissionData['registrationDateTime']));
          $babyListArray[]  = date('h:i A',strtotime($getAllBabyAdmissionData['registrationDateTime']));
          $babyListArray[]  = ($getAllBabyAdmissionData['babyGender'] == "Male") ? "M":"F";
          $babyListArray[]  = $getAllBabyAdmissionData['admissionHeight'];
          $babyListArray[]  = $getAllBabyAdmissionData['babyWeight'];
          $babyListArray[]  = $getAllBabyAdmissionData['babyAdmissionWeight'];


          // Get baby weight dates
          $secondWeightDate = date('Y-m-d', strtotime('+1 day', strtotime($getAllBabyAdmissionData['registrationDateTime'])));
          $thirdWeightDate = date('Y-m-d', strtotime('+2 day', strtotime($getAllBabyAdmissionData['registrationDateTime'])));
          $fourthWeightDate = date('Y-m-d', strtotime('+3 day', strtotime($getAllBabyAdmissionData['registrationDateTime'])));
          $fifthWeightDate = date('Y-m-d', strtotime('+4 day', strtotime($getAllBabyAdmissionData['registrationDateTime'])));
          $sixthWeightDate = date('Y-m-d', strtotime('+5 day', strtotime($getAllBabyAdmissionData['registrationDateTime'])));
          $seventhWeightDate = date('Y-m-d', strtotime('+6 day', strtotime($getAllBabyAdmissionData['registrationDateTime'])));
          
          // Get baby weight 2
          $getBabyWeight2 = $this->cmodel->getBabyDailyWeightData($getAllBabyAdmissionData['babyAdmissionId'],$secondWeightDate);
          if(!empty($getBabyWeight2)){
            $getBabyWeightValue2 = $getBabyWeight2['babyWeight'];
            if(!empty($getAllBabyAdmissionData['babyAdmissionWeight'])){
              $getWeightGainLoss2 = round(((intval($getBabyWeightValue2-$getAllBabyAdmissionData['babyAdmissionWeight']))*100)/$getAllBabyAdmissionData['babyAdmissionWeight'],1);
              $getWeightDifference2 = intval($getBabyWeightValue2-$getAllBabyAdmissionData['babyAdmissionWeight']);
            }else{
              $getWeightGainLoss2 = "";
              $getWeightDifference2 = "";
            }
            
          }else{
            $getBabyWeightValue2 = "";
            $getWeightGainLoss2 = "";
            $getWeightDifference2 = "";
          }

          // Get baby kmc time 2
          $getBabyKmcValue2 = $this->cmodel->getBabyKmcDateData($getAllBabyAdmissionData['babyAdmissionId'],$secondWeightDate);

          // Get baby weight 3
          $getBabyWeight3 = $this->cmodel->getBabyDailyWeightData($getAllBabyAdmissionData['babyAdmissionId'],$thirdWeightDate);
          if(!empty($getBabyWeight3)){
            $getBabyWeightValue3 = $getBabyWeight3['babyWeight'];

            // previous weight
            if(!empty($getBabyWeightValue2)){
              $previousWeightValue3 = $getBabyWeightValue2;
            }else{
              $previousWeightValue3 = $getAllBabyAdmissionData['babyAdmissionWeight'];
            }

            if(!empty($previousWeightValue3)){
              $getWeightGainLoss3 = round(((intval($getBabyWeightValue3-$previousWeightValue3))*100)/$previousWeightValue3,1);
              $getWeightDifference3 = intval($getBabyWeightValue3-$previousWeightValue3);
            }else{
              $getWeightGainLoss3 = "";
              $getWeightDifference3 = "";
            }
            
          }else{
            $getBabyWeightValue3 = "";
            $getWeightGainLoss3 = "";
            $getWeightDifference3 = "";
          }

          // Get baby kmc time 3
          $getBabyKmcValue3 = $this->cmodel->getBabyKmcDateData($getAllBabyAdmissionData['babyAdmissionId'],$thirdWeightDate);

          // Get baby weight 4
          $getBabyWeight4 = $this->cmodel->getBabyDailyWeightData($getAllBabyAdmissionData['babyAdmissionId'],$fourthWeightDate);
          if(!empty($getBabyWeight4)){
            $getBabyWeightValue4 = $getBabyWeight4['babyWeight'];

            // previous weight
            if(!empty($getBabyWeightValue3)){
              $previousWeightValue4 = $getBabyWeightValue3;
            }else{
              if(!empty($getBabyWeightValue2)){
                $previousWeightValue4 = $getBabyWeightValue2;
              }else{
                $previousWeightValue4 = $getAllBabyAdmissionData['babyAdmissionWeight'];
              }
            }

            if(!empty($previousWeightValue4)){
              $getWeightGainLoss4 = round(((intval($getBabyWeightValue4-$previousWeightValue4))*100)/$previousWeightValue4,1);
              $getWeightDifference4 = intval($getBabyWeightValue4-$previousWeightValue4);
            }else{
              $getWeightGainLoss4 = "";
              $getWeightDifference4 = "";
            }
            
          }else{
            $getBabyWeightValue4 = "";
            $getWeightGainLoss4 = "";
            $getWeightDifference4 = "";
          }

          // Get baby kmc time 4
          $getBabyKmcValue4 = $this->cmodel->getBabyKmcDateData($getAllBabyAdmissionData['babyAdmissionId'],$fourthWeightDate);

          // Get baby weight 5
          $getBabyWeight5 = $this->cmodel->getBabyDailyWeightData($getAllBabyAdmissionData['babyAdmissionId'],$fifthWeightDate);
          if(!empty($getBabyWeight5)){
            $getBabyWeightValue5 = $getBabyWeight5['babyWeight'];

            // previous weight
            if(!empty($getBabyWeightValue4)){
              $previousWeightValue5 = $getBabyWeightValue4;
            }else{
              if(!empty($getBabyWeightValue3)){
                $previousWeightValue5 = $getBabyWeightValue3;
              }else{
                if(!empty($getBabyWeightValue2)){
                  $previousWeightValue5 = $getBabyWeightValue2;
                }else{
                  $previousWeightValue5 = $getAllBabyAdmissionData['babyAdmissionWeight'];
                }
              }
            }

            if(!empty($previousWeightValue5)){
              $getWeightGainLoss5 = round(((intval($getBabyWeightValue5-$previousWeightValue5))*100)/$previousWeightValue5,1);
              $getWeightDifference5 = intval($getBabyWeightValue5-$previousWeightValue5);
            }else{
              $getWeightGainLoss5 = "";
              $getWeightDifference5 = "";
            }
            
          }else{
            $getBabyWeightValue5 = "";
            $getWeightGainLoss5 = "";
            $getWeightDifference5 = "";
          }

          // Get baby kmc time 5
          $getBabyKmcValue5 = $this->cmodel->getBabyKmcDateData($getAllBabyAdmissionData['babyAdmissionId'],$fifthWeightDate);

          // Get baby weight 6
          $getBabyWeight6 = $this->cmodel->getBabyDailyWeightData($getAllBabyAdmissionData['babyAdmissionId'],$sixthWeightDate);
          if(!empty($getBabyWeight6)){
            $getBabyWeightValue6 = $getBabyWeight6['babyWeight'];

            // previous weight
            if(!empty($getBabyWeightValue5)){
              $previousWeightValue6 = $getBabyWeightValue5;
            }else{
              if(!empty($getBabyWeightValue4)){
                $previousWeightValue6 = $getBabyWeightValue4;
              }else{
                if(!empty($getBabyWeightValue3)){
                  $previousWeightValue6 = $getBabyWeightValue3;
                }else{
                  if(!empty($getBabyWeightValue2)){
                    $previousWeightValue6 = $getBabyWeightValue2;
                  }else{
                    $previousWeightValue6 = $getAllBabyAdmissionData['babyAdmissionWeight'];
                  }
                }
              }
            }

            if(!empty($previousWeightValue6)){
              $getWeightGainLoss6 = round(((intval($getBabyWeightValue6-$previousWeightValue6))*100)/$previousWeightValue6,1);
              $getWeightDifference6 = intval($getBabyWeightValue6-$previousWeightValue6);
            }else{
              $getWeightGainLoss6 = "";
              $getWeightDifference6 = "";
            }
            
          }else{
            $getBabyWeightValue6 = "";
            $getWeightGainLoss6 = "";
            $getWeightDifference6 = "";
          }

          // Get baby kmc time 6
          $getBabyKmcValue6 = $this->cmodel->getBabyKmcDateData($getAllBabyAdmissionData['babyAdmissionId'],$sixthWeightDate);

          // Get baby weight 7
          $getBabyWeight7 = $this->cmodel->getBabyDailyWeightData($getAllBabyAdmissionData['babyAdmissionId'],$seventhWeightDate);
          if(!empty($getBabyWeight7)){
            $getBabyWeightValue7 = $getBabyWeight7['babyWeight'];

            // previous weight
            if(!empty($getBabyWeightValue6)){
              $previousWeightValue7 = $getBabyWeightValue6;
            }else{
              if(!empty($getBabyWeightValue5)){
                $previousWeightValue7 = $getBabyWeightValue5;
              }else{
                if(!empty($getBabyWeightValue4)){
                  $previousWeightValue7 = $getBabyWeightValue4;
                }else{
                  if(!empty($getBabyWeightValue3)){
                    $previousWeightValue7 = $getBabyWeightValue3;
                  }else{
                    if(!empty($getBabyWeightValue2)){
                      $previousWeightValue7 = $getBabyWeightValue2;
                    }else{
                      $previousWeightValue7 = $getAllBabyAdmissionData['babyAdmissionWeight'];
                    }
                  }
                }
              }
            }

            if(!empty($previousWeightValue7)){
              $getWeightGainLoss7 = round(((intval($getBabyWeightValue7-$previousWeightValue7))*100)/$previousWeightValue7,1);
              $getWeightDifference7 = intval($getBabyWeightValue7-$previousWeightValue7);
            }else{
              $getWeightGainLoss7 = "";
              $getWeightDifference7 = "";
            }
            
          }else{
            $getBabyWeightValue7 = "";
            $getWeightGainLoss7 = "";
            $getWeightDifference7 = "";
          }

          // Get baby kmc time 7
          $getBabyKmcValue7 = $this->cmodel->getBabyKmcDateData($getAllBabyAdmissionData['babyAdmissionId'],$seventhWeightDate);

          
          // get last weight data
          if(!empty($getBabyWeight7)){
            $getLastWeightData = $getBabyWeight7;
          }else{
            if(!empty($getBabyWeight6)){
              $getLastWeightData = $getBabyWeight6;
            }else{
              if(!empty($getBabyWeight5)){
                $getLastWeightData = $getBabyWeight5;
              }else{
                if(!empty($getBabyWeight4)){
                  $getLastWeightData = $getBabyWeight4;
                }else{
                  if(!empty($getBabyWeight3)){
                    $getLastWeightData = $getBabyWeight3;
                  }else{
                    if(!empty($getBabyWeight2)){
                      $getLastWeightData = $getBabyWeight2;
                    }else{
                      $getLastWeightData = "";
                    }
                  }
                }
              }
            }
          }

          if(!empty($getLastWeightData)){
            // total duration
            $getLastWeightDate = strtotime($getLastWeightData['weightDate'].' 00:00:00');
            $getAdmissionDate = strtotime($getAllBabyAdmissionData['registrationDateTime']);

            $dateDifference = intval(($getLastWeightDate-$getAdmissionDate)/60);
            $durationHours = intval($dateDifference/60);
            $durationMinutes = $dateDifference%60;
            $totalWeightingDuration = (($durationHours != "0" || $durationHours != "") ? ($durationHours."h "):"").$durationMinutes."m";

            // last profit loss gain
            $getLastWeight = $getLastWeightData['babyWeight'];
            $getbabyAdmissionWeight = $getAllBabyAdmissionData['babyAdmissionWeight'];
            if(!empty($getbabyAdmissionWeight)){
              $getLastWeightGainLoss = round(((intval($getLastWeight-$getbabyAdmissionWeight))*100)/$getbabyAdmissionWeight,1);
              $getLastWeightDifference = intval($getLastWeight-$getbabyAdmissionWeight);
            }else{
              $getLastWeightGainLoss = "";
              $getLastWeightDifference = "";
            }
          }else{
            $totalWeightingDuration = "";
            $getLastWeightGainLoss = "";
            $getLastWeightDifference = "";
          }

          // total baby Kmc time
          $babyTotalKmcSeconds = $getBabyKmcValue2['totalSeconds']+$getBabyKmcValue3['totalSeconds']+$getBabyKmcValue4['totalSeconds']+$getBabyKmcValue5['totalSeconds']+$getBabyKmcValue6['totalSeconds']+$getBabyKmcValue7['totalSeconds'];
          $totalDurationHours = intval($babyTotalKmcSeconds/60);
          $totalDurationMinutes = $babyTotalKmcSeconds%60;
          $babyTotalKmc = (($totalDurationHours != "0" || $totalDurationHours != "") ? ($totalDurationHours."h "):"").$totalDurationMinutes."m";

          
          $babyListArray[]  = $getBabyWeightValue2;
          $babyListArray[]  = $getBabyKmcValue2['totalKmcDuration'];
          $babyListArray[]  = ($getWeightDifference2 == "0") ? "0" :(($getWeightDifference2 != "") ? $getWeightDifference2 : "");
          $babyListArray[]  = ($getWeightGainLoss2 == "0") ? "0" :(($getWeightGainLoss2 != "") ? $getWeightGainLoss2 : "");
          $babyListArray[]  = $getBabyWeightValue3;
          $babyListArray[]  = $getBabyKmcValue3['totalKmcDuration'];
          $babyListArray[]  = ($getWeightDifference3 == "0") ? "0" :(($getWeightDifference3 != "") ? $getWeightDifference3 : "");
          $babyListArray[]  = ($getWeightGainLoss3 == "0") ? "0" :(($getWeightGainLoss3 != "") ? $getWeightGainLoss3 : "");
          $babyListArray[]  = $getBabyWeightValue4;
          $babyListArray[]  = $getBabyKmcValue4['totalKmcDuration'];
          $babyListArray[]  = ($getWeightDifference4 == "0") ? "0" :(($getWeightDifference4 != "") ? $getWeightDifference4 : "");
          $babyListArray[]  = ($getWeightGainLoss4 == "0") ? "0" :(($getWeightGainLoss4 != "") ? $getWeightGainLoss4 : "");
          $babyListArray[]  = $getBabyWeightValue5;
          $babyListArray[]  = $getBabyKmcValue5['totalKmcDuration'];
          $babyListArray[]  = ($getWeightDifference5 == "0") ? "0" :(($getWeightDifference5 != "") ? $getWeightDifference5 : "");
          $babyListArray[]  = ($getWeightGainLoss5 == "0") ? "0" :(($getWeightGainLoss5 != "") ? $getWeightGainLoss5 : "");
          $babyListArray[]  = $getBabyWeightValue6;
          $babyListArray[]  = $getBabyKmcValue6['totalKmcDuration'];
          $babyListArray[]  = ($getWeightDifference6 == "0") ? "0" :(($getWeightDifference6 != "") ? $getWeightDifference6 : "");
          $babyListArray[]  = ($getWeightGainLoss6 == "0") ? "0" :(($getWeightGainLoss6 != "") ? $getWeightGainLoss6 : "");
          $babyListArray[]  = $getBabyWeightValue7;
          $babyListArray[]  = $getBabyKmcValue7['totalKmcDuration'];
          $babyListArray[]  = ($getWeightDifference7 == "0") ? "0" :(($getWeightDifference7 != "") ? $getWeightDifference7 : "");
          $babyListArray[]  = ($getWeightGainLoss7 == "0") ? "0" :(($getWeightGainLoss7 != "") ? $getWeightGainLoss7 : "");
          $babyListArray[]  = ($getAllBabyAdmissionData['dischargeStatus']== "2" || $getAllBabyAdmissionData['dischargeStatus']== "3") ? "Y":"N";
          $babyListArray[]  = $totalWeightingDuration;
          $babyListArray[]  = ($getLastWeightDifference == "0") ? "0" :(($getLastWeightDifference != "") ? $getLastWeightDifference : "");
          $babyListArray[]  = ($getLastWeightGainLoss == "0") ? "0" :(($getLastWeightGainLoss != "") ? $getLastWeightGainLoss : "");
          $babyListArray[]  = $babyTotalKmc;
          $babyListArray[]  = "";

          $objWorkSheet->fromArray($babyListArray, null, 'A'.$a);

          $gainLossArray = array('2'=>$getWeightGainLoss2,'3'=>$getWeightGainLoss3,'4'=>$getWeightGainLoss4,'5'=>$getWeightGainLoss5,'6'=>$getWeightGainLoss6,'7'=>$getWeightGainLoss7);
          $weightDifferenceArray = array('2'=>$getWeightDifference2,'3'=>$getWeightDifference3,'4'=>$getWeightDifference4,'5'=>$getWeightDifference5,'6'=>$getWeightDifference6,'7'=>$getWeightDifference7);

          // red color if percentage is loss
          for ($profitRow=2; $profitRow<=7 ; $profitRow++) {
            $gainLossRow = $gainLossArray[$profitRow];
            $weightDifferenceRow = $weightDifferenceArray[$profitRow];
            $cellName = array('2'=>'O','3'=>'S','4'=>'W','5'=>'AA','6'=>'AE','7'=>'AI');
            $differenceCellName = array('2'=>'N','3'=>'R','4'=>'V','5'=>'Z','6'=>'AD','7'=>'AH');
            
            // if gain loss value is negative
            if($gainLossRow < 0){
              $lossColorArray = array(
              'font'  => array(
                  'color' => array('rgb' => 'FF0000')
              ));
            }else{
              $lossColorArray = array(
              'font'  => array(
                  'color' => array('rgb' => '000000')
              ));
            }

            // if weight difference value is negative
            if($weightDifferenceRow < 0){
              $weightDifferenceColorArray = array(
              'font'  => array(
                  'color' => array('rgb' => 'FF0000')
              ));
            }else{
              $weightDifferenceColorArray = array(
              'font'  => array(
                  'color' => array('rgb' => '000000')
              ));
            }

            $objWorkSheet->getStyle($cellName[$profitRow].$a)->applyFromArray($lossColorArray);
            $objWorkSheet->getStyle($differenceCellName[$profitRow].$a)->applyFromArray($weightDifferenceColorArray);
          }

          // red color if last percentage is loss
          if($getLastWeightGainLoss < 0){
            $lastLossColorArray = array(
            'font'  => array(
                'color' => array('rgb' => 'FF0000')
            ));
          }else{
            $lastLossColorArray = array(
            'font'  => array(
                'color' => array('rgb' => '000000')
            ));
          }

          $objWorkSheet->getStyle('AM'.$a.'')->applyFromArray($lastLossColorArray);
          /*********************/

          // red color if last total weight difference is loss
          if($getLastWeightDifference < 0){
            $lastWeightDifferenceColorArray = array(
            'font'  => array(
                'color' => array('rgb' => 'FF0000')
            ));
          }else{
            $lastWeightDifferenceColorArray = array(
            'font'  => array(
                'color' => array('rgb' => '000000')
            ));
          }

          $objWorkSheet->getStyle('AL'.$a.'')->applyFromArray($lastWeightDifferenceColorArray);
          /*********************/
          
          $styleArray = array(
            'borders' => array(
            'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
            )
            )
          );

          $objWorkSheet->getStyle('A1:AO'.$a.'')->applyFromArray($styleArray);

          $a++;
          $dataCount++;
      }

      $objWorkSheet->setTitle('Weight-Report');

      $file = "Weight-Report-".date('d-m-Y');  
      $filename=$file.'.xls';
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$filename.'"');
      header('Cache-Control: max-age=0');

      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
      $objWriter->save('php://output');
      $objWriter->save(str_replace(__FILE__,'assets/Reports/weightReports/'.$filename,__FILE__));
      chmod('assets/Reports/weightReports/'.$filename, 0777);

      // save file log
      if(!empty($getReportSettings)){
        $checkFileExist = $this->db->get_where('reportLogs',array('reportLogs.reportSettingId'=>$getReportSettings['id'],'fileName'=>$filename))->row_array();
        if(empty($checkFileExist)){
          $logData['reportSettingId']      = $getReportSettings['id'];
          $logData['fileName']             = $filename;
          $logData['addDate']              = date('Y-m-d');
          $this->db->insert('reportLogs',$logData);
        }
      }
    }

    // Checkin Checkout Report
    public function sendNurseDutyReport(){

      $reportDate = date('jS F Y, l',strtotime("-1 days"));
      //$reportDate = date('jS F Y, l',strtotime("2021-01-29"));
      $objPHPExcel = new PHPExcel();

      $objWorkSheet = $objPHPExcel->setActiveSheetIndex(0);
      $objWorkSheet->getRowDimension('1')->setRowHeight(25);
      $objWorkSheet->getRowDimension('2')->setRowHeight(20);
      $objWorkSheet->mergeCells('A1:G1');
      $objWorkSheet->mergeCells('A2:G2');
      $objWorkSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $objWorkSheet->getStyle('A1')->getFont()->setBold(true)->setSize(13);
      $objWorkSheet->getStyle('A2')->getFont()->setBold(true)->setSize(10);

      for($col = ord('A'); $col <= ord('G'); $col++)
      {
        $objWorkSheet->getStyle(chr($col)."4")->getFont()->setBold(true)->setSize(10);
        $objWorkSheet->getStyle(chr($col)."4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle(chr($col)."4")->getAlignment()->setWrapText(true);
      }

      $objWorkSheet->getColumnDimension('A')->setWidth(8);
      $objWorkSheet->getColumnDimension('B')->setWidth(22);
      $objWorkSheet->getColumnDimension('C')->setWidth(17);
      $objWorkSheet->getColumnDimension('D')->setWidth(22);
      $objWorkSheet->getColumnDimension('E')->setWidth(22);
      $objWorkSheet->getColumnDimension('F')->setWidth(15);
      $objWorkSheet->getColumnDimension('G')->setWidth(10);

      $timeNotes = "("."7:30 am Checkin at ".date('jS F',strtotime(date('Y-m-d',strtotime("-1 days"))))." to 8:30 am Checkout at ".date('jS F',strtotime(date('Y-m-d'))).")";
      //$timeNotes = "("."7:30 am Checkin at ".date('jS F',strtotime("2021-01-29"))." to 8:30 am Checkout at ".date('jS F',strtotime("2021-01-30")).")";

      for($col = ord('A'); $col <= ord('G'); $col++){
        $objWorkSheet->getStyle(chr($col))->getFont()->setSize(10);
        $objWorkSheet->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle(chr($col))->getAlignment()->setWrapText(true);
      }

      $objWorkSheet->setCellValue('A4', 'Sr. No.');
      $objWorkSheet->setCellValue('B4', 'Lounge Name');
      $objWorkSheet->setCellValue('C4', 'Nurse Name');
      $objWorkSheet->setCellValue('D4', 'Checkin Date Time');
      $objWorkSheet->setCellValue('E4', 'Checkout Date Time');
      $objWorkSheet->setCellValue('F4', 'Total Duration');
      $objWorkSheet->setCellValue('G4', 'Shift No.');

      $objWorkSheet->setCellValue('A1', 'KMC App Usage Ranking');
      $objWorkSheet->setCellValue('A2', "For Date: ".$reportDate." ".$timeNotes);

      $getReportSettings = $this->cmodel->getReportSettings(1);
      $loungeArray = array_column($getReportSettings['facilities'], 'loungeId');
      
      // Get all lounges
      $getAllLounges = $this->cmodel->getAllLounges($loungeArray);
      $dataCount = 1;
      $a=5;
      
      foreach($getAllLounges as $key_lounge => $getAllLoungesData){

          $loungeListArray    = [];
          $loungeListArray[]  = $dataCount;
          $loungeListArray[]  = $getAllLoungesData['loungeName'];

          $getNurseAttendanceList = $this->cmodel->getNurseAttendanceList($getAllLoungesData['loungeId']); 

          $objWorkSheet->fromArray($loungeListArray, null, 'A'.$a);
          $innerRow = $a;

          $previousDate = date('Y-m-d',strtotime("-1 days"));
          $currentDate = date('Y-m-d');
          //$previousDate = '2021-01-29';
          //$currentDate = '2021-01-30';

          if(!empty($getNurseAttendanceList)){
            foreach($getNurseAttendanceList as $key_nurse => $getNurseAttendanceListData){

              $restrictCurrentDateCheckin = strtotime($currentDate.' 7:30:00');
              $checkinTimestamp = strtotime($getNurseAttendanceListData['addDate']);
              
              if($checkinTimestamp <= $restrictCurrentDateCheckin){
                  if(!empty($getNurseAttendanceListData['addDate'])){
                    $checkinTimestamp = strtotime($getNurseAttendanceListData['addDate']);
                    $startLimitDate = strtotime($previousDate.' 7:30:00');
                    $endLimitDate = strtotime($currentDate.' 7:30:00');
                    //if(($checkinTimestamp >= $startLimitDate) && ($checkinTimestamp <= $endLimitDate)){
                      $checkInTime = date('h:i A, jS M',strtotime($getNurseAttendanceListData['addDate']));

                      $splitDate = explode(" ",$getNurseAttendanceListData['addDate']);
                      $newTime = str_replace(":","",$splitDate[1]);
                      if($newTime >= 73100 && $newTime <= 133000)
                      {
                          $shiftName = "1st";
                      }
                      else if($newTime >= 133100 && $newTime <= 193000)
                      {
                          $shiftName = "2nd";
                      }
                      else if($newTime >= 193100 || $newTime <= 73000)
                      {
                          $shiftName = "3rd";
                      }

                      $checkinTimeForDuration = strtotime($getNurseAttendanceListData['addDate']);

                    // }else{
                    //   $checkInTime = "";
                    //   $shiftName = "Can not calculate shift as no checkin time";
                    //   $checkinTimeForDuration = strtotime($previousDate.' 7:31:00');
                    // }
                  }else{
                    $checkInTime = "";
                    $shiftName = "Can not calculate shift as no checkin time";
                    $checkinTimeForDuration = strtotime($previousDate.' 7:31:00');
                  }

                  if(!empty($getNurseAttendanceListData['modifyDate'])){
                    $checkoutTimestamp = strtotime($getNurseAttendanceListData['modifyDate']);
                    $startLimitDate = strtotime($previousDate.' 7:31:00');
                    $endLimitDate = strtotime($currentDate.' 8:30:00');
                    if(($checkoutTimestamp >= $startLimitDate) && ($checkoutTimestamp <= $endLimitDate)){
                        $checkOutTime = date('h:i A, jS M',strtotime($getNurseAttendanceListData['modifyDate']));
                        $checkoutTimeForDuration = strtotime($getNurseAttendanceListData['modifyDate']);
                    }else{
                        $checkOutTime = "";
                        $checkoutTimeForDuration = strtotime($currentDate.' 8:31:00');
                    }

                  }else{
                    $checkOutTime = "";
                    $checkoutTimeForDuration = strtotime($currentDate.' 8:31:00');
                  }

                  $dateDifference = intval(($checkoutTimeForDuration-$checkinTimeForDuration)/60);
                  $durationHours = intval($dateDifference/60);
                  $durationMinutes = $dateDifference%60;
                  $shiftDuration = (($durationHours != "0" || $durationHours != "") ? ($durationHours."h "):"").$durationMinutes."m";

                  // red color if hours greater than 12
                  if(intval($durationHours) >= 12){
                    $maxTimeColorArray = array(
                    'font'  => array(
                        'color' => array('rgb' => 'FF0000')
                    ));
                  }else{
                    $maxTimeColorArray = array(
                    'font'  => array(
                        'color' => array('rgb' => '000000')
                    ));
                  }

                  $nurseListArray   = [];
                  $nurseListArray[] = $getNurseAttendanceListData['nurseName'];
                  $nurseListArray[] = $checkInTime;
                  $nurseListArray[] = $checkOutTime;
                  $nurseListArray[] = $shiftDuration;
                  $nurseListArray[] = $shiftName;
                  $objWorkSheet->fromArray($nurseListArray, null, 'C'.$innerRow);
                  $objWorkSheet->getStyle('F'.$innerRow.'')->applyFromArray($maxTimeColorArray);
                  $innerRow = $innerRow+1;

              }else{
                  $nurseListArray   = [];
                  $nurseListArray[] = "";
                  $nurseListArray[] = "";
                  $nurseListArray[] = "";
                  $nurseListArray[] = "";
                  $nurseListArray[] = "";
                  $objWorkSheet->fromArray($nurseListArray, null, 'C'.$innerRow);
              }
            }
            $a = $innerRow+1;
          }
          else{
            $nurseListArray   = [];
            $nurseListArray[] = "N/A";
            $nurseListArray[] = "";
            $nurseListArray[] = "";
            $nurseListArray[] = "";
            $nurseListArray[] = "";
            $objWorkSheet->fromArray($nurseListArray, null, 'C'.$innerRow);

            $a = $innerRow+2;
          }
          

          $styleArray = array(
            'borders' => array(
            'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
            )
            )
          );

          $objWorkSheet->getStyle('A1:G'.$a.'')->applyFromArray($styleArray);

          $objWorkSheet->setTitle('KMC App Usage Ranking');
          $dataCount++;   
      }

      $file = "Checkin-Checkout-Report-".date('d-m-Y',strtotime("-1 days")); 
      //$file = "Checkin-Checkout-Report-".date('d-m-Y',strtotime("2021-01-29")); 
      $filename=$file.'.xls';
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$filename.'"');
      header('Cache-Control: max-age=0');

      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
      $objWriter->save('php://output');
      $objWriter->save(str_replace(__FILE__,'assets/Reports/checkinReports/'.$filename,__FILE__));
      chmod('assets/Reports/checkinReports/'.$filename, 0777);

      // save file log
      if(!empty($getReportSettings)){
        $checkFileExist = $this->db->get_where('reportLogs',array('reportLogs.reportSettingId'=>$getReportSettings['id'],'fileName'=>$filename))->row_array();
        if(empty($checkFileExist)){
          $logData['reportSettingId']      = $getReportSettings['id'];
          $logData['fileName']             = $filename;
          $logData['addDate']              = date('Y-m-d',strtotime("-1 days"));
          $this->db->insert('reportLogs',$logData);
        }
      }

      // call baby weight report cron
      $this->babyWeightReport();

      // call kmc position duplicate report cron
      $this->getKmcPositionDuplicateReport();

      // call baseline report cron
      $this->getBaselineInfoAvailableReport();

      // baby nutrition report
      $this->babyNutritionReport();
    }

    /**************************************************Old code start***********************************************/


	public function sendDailyEmail1() {
		$totalLounges  = $this->cmodel->getAllLounges();

		foreach ($totalLounges as $key => $value) {
			$loungeID = $value['LoungeID'];
			$totalMothers  = $this->cmodel->countAllMothers($loungeID);
			$totalMothersCount = count($totalMothers);
			$template2  = $this->cmodel->getTemplate(2);

			$split = explode("----DYNAMIC LOOP CONTENT----",$template2['template']);

			$static_part = $split[0];
			$dynamic_part = $split[1];

			$vars1 = array(
                                '[$DATE]'  		=> date('d-m-Y'),
                                '[$TOTALMOTHERCOUNT]' => $totalMothersCount,
                                '[$LOUNGENAME]' => $value['LoungeName']

                                ); 

			$msg1 		= strtr($static_part, $vars1);

			$vars2 = array(
                                '[$LOUNGENAME]'  		=> $value['LoungeName']

                                ); 

			$sub = strtr($template2['subject'], $vars2); 

			$final_msg = $msg1;

			
			foreach ($totalMothers as $key => $value1) {
				

				$motherDetail  = $this->cmodel->getMotherDetail($value1['MotherID']); 
				$GetAllBaby    = $this->cmodel->GetAllBabiesViaMother('baby_registration',$value1['MotherID']); 
				$GetAllBabyCount = count($GetAllBaby);
				

				

				foreach ($GetAllBaby as $key => $value2) {
					$baby_weight = $this->cmodel->getBabyWeight($value2['BabyID']); 

					if(!empty($baby_weight['BabyWeight'])){
						$baby_weight_txt = $baby_weight['BabyWeight'].' grams'.' ('.date('d-m-Y', $baby_weight['AddDate']).')'; 
					} else {
						$baby_weight_txt = '--';
					}
					
					$getKMCTime          = $this->cmodel->getTotalKmc($baby_weight['baby_admissionID']);
					if(!empty($getKMCTime['kmcTime'])){
                        $hours  = floor($getKMCTime['kmcTime'] / 3600);
                        ($hours == '1') ?  $unit = "Hr" : $unit = "Hrs";
                     
                        $minutes = floor(($getKMCTime['kmcTime'] / 60) % 60);
                        $totalKmcTime = $hours.' '.$unit.' '.$minutes.' Mins';
                    }else{
                        $totalKmcTime = '--';
                    }
                    $baby_last_feeding = $this->cmodel->getBabyLastFeeding($value2['BabyID']); 

                    if(!empty($baby_last_feeding)){
                    	$feeding_txt = $baby_last_feeding['BreastFeedDuration'].' min ('.date('d-m-Y',strtotime($baby_last_feeding['FeedDate'])).' '.strtoupper(date('h:i a', strtotime($baby_last_feeding['FeedTime']))).')';
                    } else {
                    	$feeding_txt = '--';
                    }

                    $vars2 = array(
								
                                '[$MOTHERNAME]'  		=> $motherDetail['MotherName'],
                                '[$MOTHERTOTALBABY]' 	=> $GetAllBabyCount,
                                '[$BABYWEIGHT]'  		=> $baby_weight_txt,
                                '[$KMCSTATUS]' 			=> $totalKmcTime,
                                '[$LASTFEEDING]' 		=> $feeding_txt

                                ); 

					$msg2 		= strtr($dynamic_part, $vars2);

					$final_msg.= $msg2;
					
				}
			}
			echo $sub;
			echo $final_msg;

		}

	}




	public function sendEmail() {
			$file_data = '';
			$msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns:v="urn:schemas-microsoft-com:vml">

    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta name="viewport" content="width=device-width">
      <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,700" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
      <title>Title</title>

      <style>
        @media only screen and (max-width: 600px) {
              /*------ top header ------ */
             
              .logo_nhm {
                  width: 75px!important;
              }
              .logo{
              	width: 90px!important;
              }
              .logo_govt{
              	width: 65px!important;
              }
              
            }
      </style>
      
    </head>

    <body style="background: #f3f3f3;">
      <!-- <style> -->
      <table class="body" data-made-with-foundation="" width="100%">
        <tr>
          <td class="float-center" align="center" valign="top">
            <center data-parsed="">
              <table align="center" class="container float-center" style="background: #F5BD4D; width: 580px; border-radius: 10px;">
                <tbody>
                  <tr>
                    <td>
                      
                      <table class="row" width="590">
                        <tbody>
                          <tr>
                            <th class="small-12 large-12 columns first last">
                              <table width="100%;">
                                <tr>
                                  <th>
                                    
                                    <div class="roundedCorners" style="font-size: 16px;line-height:16px;background: #fefefe;border: 1px solid #eee; border-radius: 13px;  border-spacing: 0; margin-top: 5px;">
                                      <table width="100%;">
                                          <tr>
                                            <td width="70%" style="padding: 10px;">

                                              <div style="float: left;"><img class="img-responsive logo_govt" src="http://52.201.54.81/kclounge/assets/logo_govt.png" height="75" width="75" style="margin-right: 15px;"></div>
                                            
                                              <div style="float: left;"><img class="img-responsive logo_nhm" src="http://52.201.54.81/kclounge/assets/logo_nhm.png" height="75" width="85"></div>
                                            </td>
                                            <td width="30%" align="right" style="padding: 0 10px 10px 10px;">
                                              <img class="img-responsive logo" src="http://52.201.54.81/kclounge/assets/logo.png" style="float: right; width: 120px; height: 75px;">
                                            </td>
                                          </tr>
                                          <tr>
                                            <td colspan="3" style="text-align: center; color: #F059A6;text-align: center;font-family: Quicksand, Calibri, sans-serif;font-size: 18px;" align="center">
                                              <center>
                                                <div class="calen">
                                                  <img src="http://52.201.54.81/kclounge/assets/img_calender.png" height="21" width="21" style="vertical-align: text-bottom;"> NOVEMBER 04, 2019
                                                </div>
                                              </center>
                                            </td>
                                            <tr><td colspan="3" style="padding: 10px; text-align: center;">Lounge Name</td></tr>
                                          </tr>
                                      </table>
                                    </div>


                                    <div class="roundedCorners" style="font-size: 16px;line-height:16px;background: #fefefe; margin-top: 15px;border: 1px solid #eee; border-radius: 13px;  border-spacing: 0;">
                                      <table width="100%;">
                                          <tr>
                                            <td width="50%" style="padding: 10px;text-align: center;font-family: "Montserrat", sans-serif;font-size: 18px;" align="center" >
                                              <img src="http://52.201.54.81/kclounge/assets/icon_mother.png" height="125" width="125" style="margin: auto;">
                                              <div style="color: #1CBBBF; padding: 10px;">Total Mothers</div>
                                              <div style="color: #F059A6;font-size: 24px;">5</div>
                                            </td>
                                            <td width="50%" style="padding: 10px;text-align: center;font-family: Quicksand, Calibri, sans-serif;font-size: 18px;" align="center">
                                              <img src="http://52.201.54.81/kclounge/assets/icon_baby.png" height="125" width="125" style="margin: auto;">
                                              <div style="color: #1CBBBF; padding: 10px;">Total Babies</div>
                                              <div style="color: #F059A6;font-size: 24px;">5</div>
                                            </td>
                                            
                                          </tr>
                                          
                                      </table>
                                    </div>


                                    <div class="roundedCorners" style="font-size: 16px;line-height:16px;background: #fefefe; margin-top: 15px;border: 1px solid #eee; border-radius: 13px;  border-spacing: 0;width:100%;">
                                      <table width="100%;">
                                        <tr>
                                          <td width="100%" style="padding: 10px 10px 0 10px;text-align: center;font-family: Quicksand, Calibri, sans-serif;font-size: 18px;" align="center" colspan="2">
                                              
                                                <div style="color: #1CBBBF; padding: 10px;">Total KMC Status</div>
                                                <div style="color: #F059A6;font-size: 24px;">5 Hours</div>
                                                <div style="color: #1CBBBF; padding: 30px 10px 0 10px;">Total Feeding</div>
                                              </td>
                                        </tr>
                                          <tr>
                                            <td width="50%" style="padding: 0 10px 10px 10px;text-align: center;font-family: Quicksand, Calibri, sans-serif;font-size: 18px;" align="center" >
                                              
                                              <div style="color: #1CBBBF; padding: 10px;">Direct (Minutes)</div>
                                              <div style="color: #F059A6;font-size: 24px;">50</div>
                                            </td>
                                            <td width="50%" style="padding: 0 10px 10px 10px;text-align: center;font-family: Quicksand, Calibri, sans-serif;font-size: 18px;" align="center">
                                              
                                              <div style="color: #1CBBBF; padding: 10px;">Breastfeed (ml)</div>
                                              <div style="color: #F059A6;font-size: 24px;">500</div>
                                            </td>
                                            
                                          </tr>
                                          
                                      </table>
                                    </div>

                                    <div class="roundedCorners" style="font-size: 16px;line-height:16px;background: #fefefe; margin-top: 15px;border: 1px solid #eee; border-radius: 13px;  border-spacing: 0;">
                                      <table width="100%;">
                                          <tr>
                                            <td style="padding: 10px 10px 0 10px;font-family: Quicksand, Calibri, sans-serif;font-size: 18px;" colspan="4" align="left">
                                              
                                              <div style="color: #1CBBBF; padding: 10px;">Baby of</div>
                                              
                                            </td>
                                          </tr>

                                          <tr>

                                            <td width="25%" style="text-align: center;text-align: center;font-family: Quicksand, Calibri, sans-serif;font-size: 18px;">
                                              <img src="http://52.201.54.81/kclounge/assets/images/happy-face.png" height="35" width="35" style="margin: auto;">
                                              <div style="color: #F059A6;padding: 5px 5px 0; font-size: 14px;">Mother Name</div>
                                              <div style="color: #F059A6;padding: 5px 5px 10px; font-size: 16px;">Weight</div>
                                            </td>
                                            <td width="25%" style="text-align: center;text-align: center;font-family: Quicksand, Calibri, sans-serif;font-size: 18px;">
                                              <img src="http://52.201.54.81/kclounge/assets/images/happy-face.png" height="35" width="35" style="margin: auto;">
                                              <div style="color: #F059A6;padding: 5px 5px 0; font-size: 14px;">Mother Name</div>
                                              <div style="color: #F059A6;padding: 5px 5px 10px; font-size: 16px;">Weight</div>
                                            </td>
                                            <td width="25%" style="text-align: center;text-align: center;font-family: Quicksand, Calibri, sans-serif;font-size: 18px;">
                                              <img src="http://52.201.54.81/kclounge/assets/images/happy-face.png" height="35" width="35" style="margin: auto;">
                                              <div style="color: #F059A6;padding: 5px 5px 0; font-size: 14px;">Mother Name</div>
                                              <div style="color: #F059A6;padding: 5px 5px 10px; font-size: 16px;">Weight</div>
                                            </td>
                                            <td width="25%" style="text-align: center;text-align: center;font-family: Quicksand, Calibri, sans-serif;font-size: 18px;">
                                              <img src="http://52.201.54.81/kclounge/assets/images/happy-face.png" height="35" width="35" style="margin: auto;">
                                              <div style="color: #F059A6;padding: 5px 5px 0; font-size: 14px;">Mother Name</div>
                                              <div style="color: #F059A6;padding: 5px 5px 10px; font-size: 16px;">2000 gm</div>
                                            </td>

                                          </tr>
                                          
                                          
                                      </table>
                                    </div><h4 style="color: #000; text-align: center:">Copyright &copy; 2019 CEL. All rights reserved. </h4>
                                  </th>
                                </tr>
                              </table>
                            </th>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                </tbody>
              </table>
            </center>
          </td>
        </tr>
      </table>
    </body>

    </html>';
  			$this->email->from('noreply@celworld.org', 'VIS');
  			$this->email->to('neha.shukla@celworld.org');
  			// $this->email->cc('another@another-example.com');
  			// $this->email->bcc('them@their-example.com');
  			$this->email->subject('Test subject');
  			$this->email->message($msg);
  			// $this->email->attach($file_data);
  			$this->email->send();
  			echo $this->email->print_debugger();
  			// return 1;
	}



  public function sendDailyEmail(){ 
    $dailyMailList  = $this->cmodel->getdailyMailList();
    foreach ($dailyMailList as $dailyMailListKey => $dailyMailListValue) { 
      $split = explode("<!--BABY OF DIV-->",$dailyMailListValue['template']);
      $email = $dailyMailListValue['email'];
      $emailArray = explode(',', $email); 
      $start_part   = $split[0];
      $dynamic_part = $split[1];
      $end_part     = $split[2];

      $split2 = explode("<!--DYNAMIC LOOP CONTENT-->",$dynamic_part);
      $dynamic_start_part   = $split2[0];
      $dynamic_middle_part  = $split2[1];
      $dynamic_end_part     = $split2[2];

      $loungeString   = $dailyMailListValue['lounge'];
      $loungeArray    = explode(', ', $loungeString);
      foreach ($loungeArray as $loungeKey => $loungeId) { 
        if($dailyMailListValue['templateId'] == 1){
          $loungeDetail   = $this->cmodel->getLoungeDetails($loungeId);
          $loungeName     = $loungeDetail['LoungeName'];
          $totalMothers   = $this->cmodel->countAllMothers($loungeId); 
          $totalMothersCount = count($totalMothers);
          $totalBabies      = $this->cmodel->countAllBabies($loungeId); 
          $totalBabiesCount = count($totalBabies);
          $totalBabyKMCGiven        = $this->cmodel->countBabiesKMCGiven($loungeId); 
          $totalBabyKMCGivenCount   = count($totalBabyKMCGiven); 
          $totalDirectFeeding       = $this->cmodel->countFeedingViaType($loungeId, 1); 
          $totalDirectFeedingCount  = count($totalDirectFeeding); 
          $totalBreastFeeding       = $this->cmodel->countFeedingViaType($loungeId, 2); 
          $totalBreastFeedingCount  = count($totalBreastFeeding); 

          $subject_vars = array(
                                '[$LoungeName]'     => ucwords($loungeName),
                                '[$Date]' => date('21/m/Y')

                                ); 

          $subject     = strtr($dailyMailListValue['subject'], $subject_vars);
          echo $subject;
          $start_part_vars    = array(
                                '[$ReportDate]'     => date('21 F, Y'),
                                '[$LoungeName]'     => ucwords($loungeName),
                                '[$TotalMothers]'   => $totalMothersCount,
                                '[$TotalBabies]'    => $totalBabiesCount,
                                '[$TotalKMC]'       => $totalBabyKMCGivenCount,
                                '[$TotalDirectFeeding]'    => $totalDirectFeedingCount,
                                '[$TotalBreastfeed]'       => $totalBreastFeedingCount

                                ); 

          $msg1     = strtr($start_part, $start_part_vars);

          $final_msg = $msg1;
          $i = 0;

          $html  = '<!DOCTYPE html>
      <html>
        <head>
          <style>
          table, th, td {
              border-collapse: collapse;
          }
        </style>
        </head>
        <body>
          <div style="">
              <h3 style ="text-align: center; margin-top:-5px !important"><u>Daily Report: '.ucwords($loungeName).' ('.date('d F, Y').')</u> </h3>
              <table border="1">
                <thead>
                <tr>
                  <th>Baby Of</th>
                  <th>Baby Gender</th>
                  <th>Delivery Date & Time</th>
                  <th>Last Status Of Baby</th>
                  <th>Birth Weight (In Grams)</th>
                  <th>Admission Date & Time</th>
                  <th>Weight Measured</th>
                  <th>Weight Gain/Lost Since Admission</th>
                  <th>Duration Of STSC</th>
                  <th>Method Of Feeding Baby</th>
                  <th>Number Of Breastfeeding Episodes</th>
                  <th>List Of Danger Signs</th>
                  <th>Baby Temperature</th>
                  <th>Supplements Given To Baby</th>
                </tr>
                </thead>
                <tbody>
                  ';

              if(!empty($totalBabies)){
                $final_msg.= $dynamic_start_part;
                foreach ($totalBabies as $babiesKey => $babiesValue) { 
                  $babyDetail       = $this->cmodel->getBabyDetails($babiesValue['BabyID']); 
                  $motherName       = singlerowparameter2('MotherName','MotherID',$babyDetail['MotherID'],'mother_registration'); 
                  $babyAdmissionWeight = $babiesValue['BabyAdmissionWeight'];
                  $babyCurrentWeightDetail = $this->cmodel->getBabyCurrentWeight($babiesValue['BabyID']); 
                  $babyCurrentWeight = $babyCurrentWeightDetail['BabyWeight'];

                  if(!empty($babyCurrentWeightDetail)){
                    $babyWeight = $babyCurrentWeight.' grams';
                    if($babyCurrentWeight > $babyAdmissionWeight){ 
                      $icon_url = base_url().'assets/images/happy-face.png';
                      $marginWt = $babyCurrentWeight - $babyAdmissionWeight;
                      $weightGainLost = 'Gain - '.$marginWt;
                    } else if($babyCurrentWeight == $babyAdmissionWeight){
                      $icon_url = base_url().'assets/images/happy-face.png';
                      $weightGainLost = 'Same Weight';
                    } else { 
                      $icon_url = base_url().'assets/images/sad-face.png';
                      $marginWt = $babyAdmissionWeight - $babyCurrentWeight;
                      $weightGainLost = 'Lost - '.$marginWt;
                    }
                  } else { 
                    $babyWeight = $babyAdmissionWeight.' grams';
                    $icon_url = base_url().'assets/images/sad-face.png';
                  }

                  $dynamic_part_vars    = array(
                                      '[$MotherName]'     => ucwords($motherName),
                                      '[$Weight]'         => $babyWeight,
                                      '[$IconURL]'        => $icon_url

                                      ); 

                  $msg2     = strtr($dynamic_middle_part, $dynamic_part_vars);
                  $final_msg.= $msg2;
                  $i++;
                  if($i>3){
                    $final_msg.= '</tr><tr>';
                    $i = 0;
                  }

                  if($babyDetail['BirthWeightAvail']=='1'){

                    $birthWeight = $babyDetail['BabyWeight'];
                  } else {
                    $birthWeight = "Not Available";
                  }

                  if(empty($babyCurrentWeight)){
                    $babyCurrentWeight = 'Daily Weight Not Taken';
                  } 

                  $getKMCTime          = $this->cmodel->getTotalKmc($babiesValue['id']);

                  if(!empty($getKMCTime['kmcTime'])){
                    $hours  = floor($getKMCTime['kmcTime'] / 3600);
                    ($hours == '1') ?  $unit = "Hr" : $unit = "Hrs";
                 
                    $minutes = floor(($getKMCTime['kmcTime'] / 60) % 60);
                    $totalKmcTime = $hours.' '.$unit.' '.$minutes.' Mins';
                  }else{
                    $totalKmcTime = '--';
                  }

                  $getBabyFeedingType          = $this->cmodel->getBabyFeedingType($loungeId, $babyDetail['BabyID']);
                  
                  $feedingType = '';
                  foreach($getBabyFeedingType as $row){
                      $feedingType .=$row['BreastFeedMethod'].',';
                  }
                  $feedingType = trim($feedingType,',');

                  $getBabyFeedingType          = $this->cmodel->countBreastfeedEp($loungeId, $babyDetail['BabyID']);
                  $countBFep     = count($getBabyFeedingType);

                  $getBabyAssesment = $this->cmodel->getBabysBYAdmisionId($babyDetail['BabyID'],$babiesValue['id']);

                  $data =json_decode($getBabyAssesment['BabyOtherDangerSign'], true);
                  $dangerTxt = '';
                    if(count($data) > 0){
                            $count=1; 
                               foreach ($data as $key => $val) {
                                  $dangerTxt.= $count++.'&nbsp'. $val['name'];
                                  } 
                    } else { 
                         $dangerTxt.= 'No Danger Sign';
                    }

                  $getBabySupplement = $this->cmodel->getBabysSupplimentBYAdmissionID($babyDetail['BabyID'],$babiesValue['id']);

                  $supplements = '';
                  if(!empty($getBabySupplement)){
                    foreach($getBabySupplement as $row){
                        $supplements .=$row['SupplimentName'].',';
                    }
                  } else {
                    $supplements = '--';
                  }

                  if(!empty($babiesValue['TypeOfDischarge'])){
                    if($babiesValue['TypeOfDischarge'] == 'Died'){
                      $babyLastStatus = 'Dead';
                    } else {
                      $babyLastStatus = 'Alive';
                    }
                  } else {
                    $babyLastStatus = 'Alive';
                  }

                  $html.='<tr>
                          <td style="text-align: center;">'.ucwords($motherName).'</td>
                          <td style="text-align: center;">'.$babyDetail['BabyGender'].'</td>
                          <td style="text-align: center;">'.$babyDetail['DeliveryDate'].' & '.date('g:i A',strtotime($babyDetail['DeliveryTime'])).'</td>
                          <td style="text-align: center;">'.$babyLastStatus.'</td>
                          <td style="text-align: center;">'.$birthWeight.'</td>
                          <td style="text-align: center;">'.date('d-m-Y g:i A',$babiesValue['add_date']).'</td>
                          <td style="text-align: center;">'.$babyCurrentWeight.'</td>
                          <td style="text-align: center;">'.$weightGainLost.'</td>
                          <td style="text-align: center;">'.$totalKmcTime.'</td>
                          <td style="text-align: center;">'.$feedingType.'</td>
                          <td style="text-align: center;">'.$countBFep.'</td>
                          <td style="text-align: center;">'.$dangerTxt.'</td>
                          <td style="text-align: center;">'.$getBabyAssesment['BabyTemperature'].'&nbsp;<sup>0</sup>F</td>
                          <td style="text-align: center;">'.$supplements.'</td>
                          
                        </tr>
                      ';

                } 
                $final_msg.= $dynamic_end_part;
              }


          $html.='</tbody>
              </table>
          </div>
        </body>
      </html>';

          $end_part_vars    = array(
                                '[$CurrentYear]'     => date('Y')
                                ); 

          $msg3     = strtr($end_part, $end_part_vars);
          $final_msg.= $msg3;
          $final_msg.= $dailyMailListValue['signature'];

          if(!empty($totalBabies)){
            $filename = "dailyReport".$loungeName."_".date('d-m-Y').".pdf";

            $this->m_pdf->pdf->autoScriptToLang = true;
            $this->m_pdf->pdf->baseScript = 1;
            $this->m_pdf->pdf->autoVietnamese = true;
            $this->m_pdf->pdf->autoArabic = true;
            $this->m_pdf->pdf->autoLangToFont = true;
            $pdfFilePath =  MAILREPORT_DIRECTORY.$filename;
            $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
            $this->m_pdf->pdf->WriteHTML($PDFContent);
            $this->m_pdf->pdf->Output($pdfFilePath, "F"); 
            $attched_file = $_SERVER["DOCUMENT_ROOT"].'/kclounge'.'/assets/PdfFile/MailReport/'.$filename; 
            foreach ($emailArray as $key => $value) {
              $this->email->from('noreply@celworld.org');
              $this->email->to($value);
              $this->email->subject($subject);
              $this->email->message($final_msg);
              $this->email->attach($attched_file);
              $this->email->send(); 
            }

          }


          echo $final_msg;die;
        }
      }
    }
    
  }



  // Baby Daily Nutrition Report
    public function babyNutritionReport(){
    	$reportDate = date('jS F Y, l',strtotime("-1 days"));
      $objPHPExcel = new PHPExcel();

      $objWorkSheet = $objPHPExcel->setActiveSheetIndex(0);
      $objWorkSheet->getRowDimension('1')->setRowHeight(25);
      $objWorkSheet->mergeCells('A1:K1');
      $objWorkSheet->mergeCells('A2:K2');
      $objWorkSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $objWorkSheet->getStyle('A1')->getFont()->setBold(true)->setSize(13);
      $objWorkSheet->getStyle('A2')->getFont()->setBold(true)->setSize(10);

      for($col = ord('A'); $col <= ord('K'); $col++)
      {
        $objWorkSheet->getStyle(chr($col)."3")->getFont()->setBold(true)->setSize(10);
        $objWorkSheet->getStyle(chr($col)."3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle(chr($col)."3")->getAlignment()->setWrapText(true);
      }

      $objWorkSheet->getColumnDimension('A')->setWidth(8);
      $objWorkSheet->getColumnDimension('B')->setWidth(18);
      $objWorkSheet->getColumnDimension('C')->setWidth(24);
      $objWorkSheet->getColumnDimension('D')->setWidth(15);
      $objWorkSheet->getColumnDimension('E')->setWidth(16);
      $objWorkSheet->getColumnDimension('F')->setWidth(15);
      $objWorkSheet->getColumnDimension('G')->setWidth(15);
      $objWorkSheet->getColumnDimension('H')->setWidth(15);
      $objWorkSheet->getColumnDimension('I')->setWidth(18);
      $objWorkSheet->getColumnDimension('J')->setWidth(16);
      $objWorkSheet->getColumnDimension('K')->setWidth(20);
      

      for($col = ord('A'); $col <= ord('K'); $col++){
        $objWorkSheet->getStyle(chr($col))->getFont()->setSize(10);
        $objWorkSheet->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle(chr($col))->getAlignment()->setWrapText(true);
      }

      $objWorkSheet->setCellValue('A3', 'Sr. No.');
      $objWorkSheet->setCellValue('B3', 'Lounge Name');
      $objWorkSheet->setCellValue('C3', 'Staf Name');
      $objWorkSheet->setCellValue('D3', 'Baby Reg. No.');
      $objWorkSheet->setCellValue('E3', 'Mother Name');
      $objWorkSheet->setCellValue('F3', 'Feeding Date');
      $objWorkSheet->setCellValue('G3', 'Feeding Time');
      $objWorkSheet->setCellValue('H3', 'Feeding Method');
      $objWorkSheet->setCellValue('I3', 'Method type');
      $objWorkSheet->setCellValue('J3', 'Quantity (ml)');
      $objWorkSheet->setCellValue('K3', 'Exclusive & Non Exclusive');
      
		$timeNotes = "(Nutrition 08:00 am ".date('jS F',strtotime(date('Y-m-d',strtotime("-1 days"))))." to 08:00 am ".date('jS F',strtotime(date('Y-m-d'))).")";

      $objWorkSheet->setCellValue('A1', 'Nutrition Report');
      $objWorkSheet->setCellValue('A2', "For Date: ".$reportDate." ".$timeNotes);

      $getReportSettings = $this->cmodel->getReportSettings(5);
      $loungeArray = array_column($getReportSettings['facilities'], 'loungeId');
     // print_r($loungeArray);die;

      // Get all baby
      $getAllBabyAdmission = $this->cmodel->getBabyNutritionList($loungeArray);
      
      $dataCount = 1;
      $a=4;

       foreach($getAllBabyAdmission as $key_baby => $getAllBabyAdmissionData){

       	$babydetail = $this->cmodel->getBabyAdmissionDatabyBabyid($getAllBabyAdmissionData['babyAdmissionId']);

          $babyListArray    = [];
          $babyListArray[]  = $dataCount;
          $babyListArray[]  = $babydetail['loungeName'];
          $babyListArray[]  = $getAllBabyAdmissionData['nurseName'];
          $babyListArray[]  = $babydetail['babyFileId'];
          $babyListArray[]  = $babydetail['motherName'];
          $babyListArray[]  = $getAllBabyAdmissionData['feedDate'];
          $babyListArray[]  = $getAllBabyAdmissionData['feedTime'];
          $babyListArray[]  = $getAllBabyAdmissionData['breastFeedMethod'];
          $babyListArray[]  = $getAllBabyAdmissionData['fluid'];
          $babyListArray[]  = $getAllBabyAdmissionData['milkQuantity'];
          if($getAllBabyAdmissionData['fluid']=="Mother's own milk")
          {
          	$babyListArray[]  = "Exclusive";
          }
          else
          {
          	$babyListArray[]  = "Non Exclusive";
          }

          $objWorkSheet->fromArray($babyListArray, null, 'A'.$a);

          $styleArray = array(
            'borders' => array(
            'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
            )
            )
          );

          $objWorkSheet->getStyle('A1:K'.$a.'')->applyFromArray($styleArray);

          $a++;
          $dataCount++;
      }


       $objWorkSheet->setTitle('Daily Nutrition Report');

      $file = "Baby-Nutrition-Report-".date('d-m-Y',strtotime("-1 days"));  
      $filename=$file.'.xls';

      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$filename.'"');
      header('Cache-Control: max-age=0');

      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
      $objWriter->save('php://output');
      $objWriter->save(str_replace(__FILE__,'assets/Reports/nutritionReports/'.$filename,__FILE__));
      chmod('assets/Reports/nutritionReports/'.$filename, 0777);


//print_r($getReportSettings);die;


      // save file log
      if(!empty($getReportSettings)){
        $checkFileExist = $this->db->get_where('reportLogs',array('reportLogs.reportSettingId'=>$getReportSettings['id'],'fileName'=>$filename))->row_array();

        if(empty($checkFileExist)){
          $logData['reportSettingId']      = $getReportSettings['id'];
          $logData['fileName']             = $filename;
          $logData['addDate']              = date('Y-m-d',strtotime("-1 days"));
          $this->db->insert('reportLogs',$logData);
        }
      }
  }



}
