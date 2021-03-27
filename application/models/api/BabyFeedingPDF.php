<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BabyFeedingPDF extends CI_Model {
  public function __construct()
    {
        parent::__construct();         
          
        $this->load->library('m_pdf');       
    }
    public function FeedingpdfGenerate($id)
    {
      $babyAdmisionLastId = $this->db->get_where('babyAdmission',array('id'=>$id))->row_array();

      $pdfHtml = $this->BabyDailyFeedPDFFile($babyAdmisionLastId['loungeId'],$babyAdmisionLastId['babyId'],$id);

      // create pdf file
      $PdfName = $this->createBabyNutritionPdfFile($pdfHtml['htmlData'],$id);

      $this->db->where('id',$babyAdmisionLastId['id']);     
      $res = $this->db->update('babyAdmission',array('babyFeedingPdfName'=>$PdfName));
      return $res;
    }

    // create Baby nutrition pdf file
    public function createBabyNutritionPdfFile($html,$admissionId){
      $pdfFilePath =  pdfDirectory."b_".$admissionId."_Feeding.pdf";

      $this->m_pdf->pdf->autoScriptToLang = true;
      $this->m_pdf->pdf->baseScript = 1;
      $this->m_pdf->pdf->autoVietnamese = true;
      $this->m_pdf->pdf->autoArabic = true;
      $this->m_pdf->pdf->autoLangToFont = true;
      $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
      $this->m_pdf->pdf->WriteHTML($PDFContent);
      $this->m_pdf->pdf->Output($pdfFilePath, "F"); 
      return "b_".$admissionId."_Feeding.pdf";
    }

    public function BabyDailyFeedPDFFile($LoungeID, $BabyID,$id)
    {
        error_reporting(0);

        $getBabyFileId = $this->db->get_where('babyAdmission',array('id'=>$id))->row_array();

        $MotherDetail =  $this->db->query("SELECT MR.`motherName`, BR.`deliveryDate`, BR.`babyWeight` FROM motherRegistration as MR LEFT JOIN babyRegistration as BR  on BR.`motherId` =  MR.`motherId`  WHERE BR.`babyId` = '".$BabyID."'")->row_array();

        $admissionDate = date('Y-m-d', strtotime($getBabyFileId['admissionDateTime']));
        $startDate = date('Y-m-d', strtotime('-1 day', strtotime($admissionDate)));

        if(!empty($getBabyFileId['dateOfDischarge'])){
          $dischargeDate = date('Y-m-d', strtotime("+1 day",strtotime($getBabyFileId['dateOfDischarge'])));
        } else {
          $dischargeDate = date('Y-m-d', strtotime("+1 day",strtotime(date('Y-m-d'))));
        }

        $header ='';
        $content = '';
        $footer = '';
        $finalHtml = '';

        $header.='<html>
          <head>
          <title>FORM B: DAILY INTAKE MONITORING RECORD</title>
          <style>
            table,th,td,tr{
              border-collapse:collapse;
            }
            td{
              width: 6%;text-align: center;border:1px solid ; padding: 13px;
            }
          </style>
          </head>
          <body>';     
  
      $y = 0;

      $begin = new DateTime($startDate);
      $end = new DateTime($dischargeDate);

      $interval = DateInterval::createFromDateString('1 day');
      $startPeriod = new DatePeriod($begin, $interval, $end);
      $GetWeightData = array();
      foreach ($startPeriod as $startPeriodDate) {

        $from = $startPeriodDate->format("Y-m-d");
        $to = date ("Y-m-d", strtotime("+1 day", strtotime($from)));
        $time = '08:00:00';

        $GetNutritionDetail = $this->db->query('SELECT babyDailyNutrition.*,staffMaster.name as nurseName, babyAdmission.loungeId FROM babyDailyNutrition JOIN staffMaster on staffMaster.staffId=babyDailyNutrition.nurseId JOIN babyAdmission on babyAdmission.id=babyDailyNutrition.babyAdmissionId WHERE babyDailyNutrition.babyAdmissionId = '.$id.' AND ((babyDailyNutrition.feedDate ="'.$from.'" AND babyDailyNutrition.feedTime >= "'.$time.'") OR (babyDailyNutrition.feedDate = "'.$to.'" AND babyDailyNutrition.feedTime < "'.$time.'"))')->result_array();

        $GetWeightData = $this->getBabyWeight($id,$to);
        
        $Age = $this->calculateAge($from,$MotherDetail['deliveryDate']);
        $BabyAge = $Age.' day';
        $feedingRequirements = $this->calculateFeedingRequirements($GetWeightData['babyWeight'],$Age);

        if(!empty($GetNutritionDetail)){
            if($y != 0){
              $content.= "<pagebreak />";
            }

          $content.='
            <div>
                <h3 style= "text-align: center;font-family: sans-serif;"> <u>FORM B: DAILY INTAKE MONITORING RECORD </u></h3>
               <p style="font-size: 14px"> <b>Objective:</b> To record the quantity and frequency of feeding of the baby admitted in the KMC unit in 24 hours (8 AM - 8 AM), so as to compare the total quantity to the total feeding requirement. To be filled by nurse on duty in the KMC </p>
            </div>

             <div>

              <div style=" padding-bottom: 5px; padding-top: 5px">
                <label> <b>Day :</b> '.date('l',strtotime($from)).'</label> 
                <label> &nbsp;<b>Hospital Reg. No.:</b>  '.$getBabyFileId['babyFileId'].'</label> 
                <label> &nbsp;<b>Date:</b> '.date('F j, Y',strtotime($from)).' 8 AM - '.date('F j, Y',strtotime($to)).' 8 AM</label>
                </div>
                
              <div>

               <div style=" padding-bottom: 5px; padding-top: 5px">
                <label> <b>Mother Name :</b>  '.ucwords($MotherDetail['motherName']).'</label> 
                <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Baby age</b> (in days): '.$BabyAge.' </label> 
                <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total feeding requirement for the day</b>: '.$feedingRequirements.' ml</label>
                </div>
             
              <div>  

              <table width="100%" border="1" style="text-align: center">
                  <tr>
                    <th rowspan="3" style="width: 10px">S.No.</th>
                    <th rowspan="3" style="width: 100px">Time of feeding<br>( From, to)</th>
                    <th colspan="8" style="width: 650px">Feeding method and measurement <br>(fill in where applicable) </th>
                    <th colspan="5" rowspan="2">Supplements Received<br>(name and dose)</th>
                    <th rowspan="2" style="width: 80px">Nurse Signature</th>
                  </tr>

                  <tr>
                   
                    <th rowspan="2" style="width: 100px">Direct breast feeding (in min)  </th>
                    <th rowspan="2" style="width: 100px">Expressed breast feed (EBF) (in ml)  </td>
                    <th colspan="4">Mixed Feeding (in ml)</th>
                    <th colspan="2">Other:* IV Type</th>
                  </tr>

                  <tr>
                    <th>EBF</th>
                    <th>Formula</th>
                    <th>Other</th>
                    <th>Net</th>
                    <th>In ml/hr</th>
                    <th>In drop/min</th>
                    <th>Vit D3</th>
                    <th>Calcium</th>
                    <th>HMF</th>
                    <th>Iron</th>
                    <th>Other</th>
                    <th></th>
                  </tr>';

                  $i = 1;
                  $Time = array();
                  $RowCount = count($GetNutritionDetail)+1;
                  $GetRowCount = 12 - $RowCount;

                  foreach ($GetNutritionDetail as $key => $value2) {

                    if((($value2['breastFeedMethod'] == "Spoon/ Palladai") || ($value2['breastFeedMethod'] == "OG Tube")) && (($value2['fluid'] == "Mother's own milk") || ($value2['fluid'] == "Other Human Milk")) ){
                      $expressedQuantity = $value2['milkQuantity'];
                    }else{
                      $expressedQuantity = "";
                    }

                    if((($value2['breastFeedMethod'] == "Spoon/ Palladai") || ($value2['breastFeedMethod'] == "OG Tube")) && ($value2['fluid'] == "Formula Milk")){
                      $formulaQuantity = $value2['milkQuantity'];
                    }else{
                      $formulaQuantity = "";
                    }

                    if((($value2['breastFeedMethod'] == "Spoon/ Palladai") || ($value2['breastFeedMethod'] == "OG Tube")) && ($value2['fluid'] == "Animal Milk")){
                      $otherQuantity = $value2['milkQuantity'];
                    }else{
                      $otherQuantity = "";
                    }

                    if(($value2['breastFeedMethod'] == "IV Drip") && ($value2['fluid'] == "IV fluid")){
                      $ivTypeQuantity = $value2['milkQuantity'];
                    }else{
                      $ivTypeQuantity = "";
                    }

                    $content.= '<tr>
                      <td>'.$i.'</td>
                      <td>'.date('g:i A',strtotime($value2['feedTime'])).'</td>
                      <td></td>
                      <td>'.$expressedQuantity.'</td>
                      <td></td>
                      <td>'.$formulaQuantity.'</td>
                      <td>'.$otherQuantity.'</td>
                      <td></td>
                      <td>'.$ivTypeQuantity.'</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>'.$value2['nurseName'].'</td>
                    </tr>';
                    $i++;
                  }

                  if(($GetRowCount<12) && ($GetRowCount>0))
                  {
                    for($z = $RowCount; $z <= 11 ; $z++) { 
                      $content.= '<tr style="border:1px solid">  
                          <td style="width: 5%;text-align: center;border:1px solid; padding: 11px;border-bottom:none;">'.$z.'</td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                      </tr>';
                    }
                  } 
              $content.='</table>';
              $y++;
        }       
      }


      $footer .='</body></html>';

      $finalHtml .= $header;
      $finalHtml .= $content;
      $finalHtml .= $footer;

      $returnOutput['content'] = $content;
      $returnOutput['htmlData'] = $finalHtml;
      return $returnOutput;
    }

    public function TestDate($date1)
    {
      $now = time(); 
      $your_date = strtotime($date1);
      $datediff = $now - $your_date;
      return round($datediff / (60 * 60 * 24));
    }

    // calculate Age
    public function calculateAge($reportDate, $deliveryDate)
    {
      $datediff = strtotime($reportDate)-strtotime($deliveryDate);
      $day = round($datediff / (60 * 60 * 24));
      if($day < 0 || $day == 0){
        $dayData = 1;
      }else{
        $dayData = $day;
      }
      return $dayData;
    }

    // calculate feeding requirement for the day
    public function calculateFeedingRequirements($weight,$age){
      $quantity = 0;
      if ($weight < 1500) {
            if ($age < 6) {
                $exp1 = $weight / 1000;
                $exp2 = 80 + ($age * 15);
                $quantity = $exp1 * $exp2;
            } else {
                $exp1 = $weight / 1000;
                $exp2 = 150;
                $quantity = $exp1 * $exp2;
            }
      } else if ($weight >= 1500) {
            if ($age < 7) {
                $exp1 = $weight / 1000;
                $exp2 = 60 + ($age * 15);
                $quantity = $exp1 * $exp2;
            } else {
                $exp1 = $weight / 1000;
                $exp2 = 150;
                $quantity = $exp1 * $exp2;
            }
      }
      return round(($quantity/2));
    }

    public function getBabyWeight($admissionId,$date){
      $GetWeight = $this->db->query('SELECT babyDailyWeight.babyWeight from babyDailyWeight WHERE babyAdmissionId = '.$admissionId.' AND weightDate="'.$date.'" order by id desc limit 1')->row_array();
      if(empty($GetWeight)){
        
        $nextDate = date('Y-m-d', strtotime('-1 days', strtotime($date)));
        $GetWeight = $this->getBabyWeight($admissionId,$nextDate);
      }
      
      return $GetWeight;
    }

}