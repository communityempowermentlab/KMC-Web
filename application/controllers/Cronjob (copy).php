<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cronjob extends CI_Controller {


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
        
        $this->load->model('CronjobModel','cmodel');
        $this->load->library('m_pdf');    
        $this->load->library('excel');
    }

    public function sendNurseDutyReport(){

      //$reportDate = date('jS F Y, l',strtotime("-1 days"));
      $reportDate = date('jS F Y, l',strtotime("2021-01-29"));
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

      $objWorkSheet->getColumnDimension('A')->setWidth(5);
      $objWorkSheet->getColumnDimension('B')->setWidth(22);
      $objWorkSheet->getColumnDimension('C')->setWidth(17);
      $objWorkSheet->getColumnDimension('D')->setWidth(22);
      $objWorkSheet->getColumnDimension('E')->setWidth(22);
      $objWorkSheet->getColumnDimension('F')->setWidth(15);
      $objWorkSheet->getColumnDimension('G')->setWidth(10);

      for($col = ord('A'); $col <= ord('G'); $col++){
        $objWorkSheet->getStyle(chr($col))->getFont()->setSize(10);
        $objWorkSheet->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle(chr($col))->getAlignment()->setWrapText(true);
      }

      $objWorkSheet->setCellValue('A4', 'Sr. No.');
      $objWorkSheet->setCellValue('B4', 'Facility Name');
      $objWorkSheet->setCellValue('C4', 'Nurse Name');
      $objWorkSheet->setCellValue('D4', 'Checkin Date Time');
      $objWorkSheet->setCellValue('E4', 'Checkout Date Time');
      $objWorkSheet->setCellValue('F4', 'Total Duration');
      $objWorkSheet->setCellValue('G4', 'Shift No.');

      $objWorkSheet->setCellValue('A1', 'KMC App Usage Ranking');
      $objWorkSheet->setCellValue('A2', "For Date: ".$reportDate);

      $getReportSettings = $this->cmodel->getReportSettings(1);
      $facilityArray = array_column($getReportSettings['facilities'], 'facilityId');
      
      // Get all facilities
      $getAllFacilities = $this->cmodel->getAllFacilities($facilityArray);
      $dataCount = 1;
      $a=5;
      
      foreach($getAllFacilities as $key_facility => $getAllFacilitiesData){

          $facilityListArray    = [];
          $facilityListArray[]  = $dataCount;
          $facilityListArray[]  = $getAllFacilitiesData['FacilityName'];

          $getNurseAttendanceList = $this->cmodel->getNurseAttendanceList($getAllFacilitiesData['loungeId']); 

          $objWorkSheet->fromArray($facilityListArray, null, 'A'.$a);
          $innerRow = $a;

          //$previousDate = date('Y-m-d',strtotime("-1 days"));
          //$currentDate = date('Y-m-d');

          $previousDate = '2021-01-29';
          $currentDate = '2021-01-30';

          if(!empty($getNurseAttendanceList)){
            foreach($getNurseAttendanceList as $key_nurse => $getNurseAttendanceListData){

              if(!empty($getNurseAttendanceListData['addDate'])){
                $checkinTimestamp = strtotime($getNurseAttendanceListData['addDate']);
                $startLimitDate = strtotime($previousDate.' 7:30:00');
                $endLimitDate = strtotime($currentDate.' 7:30:00');
                if(($checkinTimestamp >= $startLimitDate) && ($checkinTimestamp <= $endLimitDate)){
                  $checkInTime = date('h:i A, jS F Y',strtotime($getNurseAttendanceListData['addDate']));

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

                }else{
                  $checkInTime = "";
                  $shiftName = "Can not calculate shift as no checkin time";
                  $checkinTimeForDuration = strtotime($previousDate.' 7:31:00');
                }
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
                    $checkOutTime = date('h:i A, jS F Y',strtotime($getNurseAttendanceListData['modifyDate']));
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

              $nurseListArray   = [];
              $nurseListArray[] = $getNurseAttendanceListData['nurseName'];
              $nurseListArray[] = $checkInTime;
              $nurseListArray[] = $checkOutTime;
              $nurseListArray[] = $shiftDuration;
              $nurseListArray[] = $shiftName;
              $objWorkSheet->fromArray($nurseListArray, null, 'C'.$innerRow);
              $innerRow = $innerRow+1;
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

      //$file = "Checkin_Report_".date('d-m-Y',strtotime("-1 days")); 
      $file = "Checkin_Report_".date('d-m-Y',strtotime("2021-01-29")); 
      $filename=$file.'.xls';
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$filename.'"');
      header('Cache-Control: max-age=0');

      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
      $objWriter->save('php://output');
      //$objWriter->save(str_replace(__FILE__,'assets/checkinReports/'.$filename,__FILE__));
      //chmod('assets/checkinReports/'.$filename, 0777);
    }

	
    // send nurse duty details
    public function sendNurseDutyReportOld(){

      $reportDate = date('jS F Y, l',strtotime("-1 days"));
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
      }

      $objWorkSheet->getColumnDimension('A')->setWidth(7);
      $objWorkSheet->getColumnDimension('B')->setWidth(25);
      $objWorkSheet->getColumnDimension('C')->setWidth(25);
      $objWorkSheet->getColumnDimension('D')->setWidth(12);
      $objWorkSheet->getColumnDimension('E')->setWidth(12);
      $objWorkSheet->getColumnDimension('F')->setWidth(12);
      $objWorkSheet->getColumnDimension('G')->setWidth(12);

      for($col = ord('A'); $col <= ord('G'); $col++){
        $objWorkSheet->getStyle(chr($col))->getFont()->setSize(10);
        $objWorkSheet->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      }

      $objWorkSheet->setCellValue('A4', 'Rank');
      $objWorkSheet->setCellValue('B4', 'Facility Name');
      $objWorkSheet->setCellValue('C4', 'Nurse Name');
      $objWorkSheet->setCellValue('D4', 'Status');
      $objWorkSheet->setCellValue('E4', '8AM - 2PM');
      $objWorkSheet->setCellValue('F4', '2PM - 8PM');
      $objWorkSheet->setCellValue('G4', '8PM - 8AM');

      $objWorkSheet->setCellValue('A1', 'KMC App Usage Ranking');
      $objWorkSheet->setCellValue('A2', "For Date: ".$reportDate);

      // Get all facilities
      $getAllFacilities = $this->cmodel->getAllFacilities();
      $dataCount = 1;
      $a=5;
      
      foreach($getAllFacilities as $key_facility => $getAllFacilitiesData){

          $facilityListArray    = [];
          $facilityListArray[]  = $dataCount;
          $facilityListArray[]  = $getAllFacilitiesData['FacilityName'];

          $getNurseAttendanceList = $this->cmodel->getNurseAttendanceList($getAllFacilitiesData['loungeId']); 
          
          $objWorkSheet->fromArray($facilityListArray, null, 'A'.$a);
          $innerRow = $a;

          if(!empty($getNurseAttendanceList)){
            foreach($getNurseAttendanceList as $key_nurse => $getNurseAttendanceListData){
              
              $getNurseAttendanceLogList = $this->cmodel->getNurseAttendanceLogList($getNurseAttendanceListData['id']); 
              $firstShift = "";
              $secondShift = "";
              $thirdShift = "";
              foreach($getNurseAttendanceLogList as $key_logs => $getNurseAttendanceLogListData){

                  $search = 'checked in';
                  if(preg_match("/{$search}/i", $getNurseAttendanceLogListData['remark'])) {
                    $checkStatus = "Checked In";

                    $splitDate = explode(" ",$getNurseAttendanceListData['addDate']);
                    $newTime = str_replace(":","",$splitDate[1]);
                    if($newTime >= 73100 && $newTime <= 133000)
                    {
                        $firstShift = date('h:i A',strtotime($getNurseAttendanceListData['addDate']));
                        $secondShift = "";
                        $thirdShift = "";
                    }
                    else if($newTime >= 133100 && $newTime <= 193000)
                    {
                        $firstShift = "";
                        $secondShift = date('h:i A',strtotime($getNurseAttendanceListData['addDate']));
                        $thirdShift = "";
                    }
                    else if($newTime >= 193100 || $newTime <= 73000)
                    {
                        $firstShift = "";
                        $secondShift = "";
                        $thirdShift = date('h:i A',strtotime($getNurseAttendanceListData['addDate']));
                    }

                  }else{
                    $checkStatus = "Checked Out";

                    $splitDate = explode(" ",$getNurseAttendanceListData['addDate']);
                    $newTime = str_replace(":","",$splitDate[1]);
                    if($newTime >= 73100 && $newTime <= 133000)
                    {
                        $firstShift = date('h:i A',strtotime($getNurseAttendanceListData['modifyDate']));
                        $secondShift = "";
                        $thirdShift = "";
                    }
                    else if($newTime >= 133100 && $newTime <= 193000)
                    {
                        $firstShift = "";
                        $secondShift = date('h:i A',strtotime($getNurseAttendanceListData['modifyDate']));
                        $thirdShift = "";
                    }
                    else if($newTime >= 193100 || $newTime <= 73000)
                    {
                        $firstShift = "";
                        $secondShift = "";
                        $thirdShift = date('h:i A',strtotime($getNurseAttendanceListData['modifyDate']));
                    }

                  }

                  $nurseListArray   = [];
                  $nurseListArray[] = $getNurseAttendanceListData['nurseName'];
                  $nurseListArray[] = $checkStatus;
                  $nurseListArray[] = $firstShift;
                  $nurseListArray[] = $secondShift;
                  $nurseListArray[] = $thirdShift;
                  $objWorkSheet->fromArray($nurseListArray, null, 'C'.$innerRow);
                  $innerRow = $innerRow+1;
              }
              
            }
            $a = $innerRow+1;
          }
          else{

            $nurseListArray   = [];
            $nurseListArray[] = "N/A";
            $nurseListArray[] = "-";
            $nurseListArray[] = "-";
            $nurseListArray[] = "-";
            $nurseListArray[] = "-";
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

      $file = "Checkin_Report_".date('d-m-Y',strtotime("-1 days")); 
      $filename=$file.'.xls';
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$filename.'"');
      header('Cache-Control: max-age=0');

      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
      $objWriter->save('php://output');

    }


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



}
