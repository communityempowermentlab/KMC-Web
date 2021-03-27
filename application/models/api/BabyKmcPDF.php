<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BabyKmcPDF extends CI_Model {
  public function __construct()
    {
        parent::__construct();         
        $this->load->library('M_pdf');      
    }
    public function KMCpdfGenerate($id)
    {
      $this->db->order_by('id','desc');
      $babyAdmisionLastId = $this->db->get_where('babyAdmission',array('id'=>$id))->row_array();

      $pdfHtml = $this->BabySkinToSkinPdfFile($babyAdmisionLastId['loungeId'],$babyAdmisionLastId['babyId'],$id);

      // create pdf file
      $PdfName = $this->createBabyKmcPdfFile($pdfHtml['htmlData'],$id);

      $this->db->where('id',$babyAdmisionLastId['id']);     
      $res = $this->db->update('babyAdmission',array('babyKMCPdfName'=>$PdfName));
      return $res;      
    }

    // create Baby kmc pdf file
    public function createBabyKmcPdfFile($html,$admissionId){
      $pdfFilePath =  pdfDirectory."b_".$admissionId."_KMC.pdf";

      $this->m_pdf->pdf->autoScriptToLang = true;
      $this->m_pdf->pdf->baseScript = 1;
      $this->m_pdf->pdf->autoVietnamese = true;
      $this->m_pdf->pdf->autoArabic = true;
      $this->m_pdf->pdf->autoLangToFont = true;
      $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
      $this->m_pdf->pdf->WriteHTML($PDFContent);
      $this->m_pdf->pdf->Output($pdfFilePath, "F"); 
      return "b_".$admissionId."_KMC.pdf";
    }

    public function BabySkinToSkinPdfFile($LoungeID, $BabyID,$id)
    {
        error_reporting(0);

        $getBabyFileId = $this->db->get_where('babyAdmission',array('id'=>$id))->row_array();
        $MotherDetail =  $this->db->query("SELECT MR.`motherName`, BR.`deliveryDate`, BR.`babyWeight` FROM motherRegistration as MR LEFT JOIN babyRegistration as BR  on BR.`motherID` =  MR.`motherID`  WHERE BR.`babyId` = '".$BabyID."'")->row_array();

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
          <title>FORM C: DAILY KMC COMPLIANCE FORM</title>
          <style>
            table,th,td,tr{
              border-collapse:collapse;
            }
          </style>
          </head>
          <body>';
          $y = 0;

          $begin = new DateTime($startDate);
          $end = new DateTime($dischargeDate);

          $interval = DateInterval::createFromDateString('1 day');
          $startPeriod = new DatePeriod($begin, $interval, $end);

        foreach ($startPeriod as $startPeriodDate) {
          $from = $startPeriodDate->format("Y-m-d");
          $startTime = '08:00:00';
          $to = date ("Y-m-d", strtotime("+1 day", strtotime($from)));
          $endTime = '08:00:00';

          $GetKMCDayDetail = $this->db->query("SELECT * FROM `babyDailyKMC` where babyAdmissionId = ".$id." AND isDataValid=1 AND ((startDate = '".$from."' AND startTime >= '".$startTime."') OR (startDate = '".$to."' AND startTime < '".$endTime."')) AND ((endDate = '".$from."' AND endTime > '".$startTime."') OR (endDate = '".$to."' AND endTime < '".$endTime."')) ORDER BY `id` DESC ")->result_array();

          if(!empty($GetKMCDayDetail)){
            if($y != 0){
              $content.= "<pagebreak />";
            }
            
            $content.= '<table style="width: 100%;margin-bottom: -11px;border-bottom:none;" >
              <tr><th style="text-align: center;font-family: sans-serif;" colspan= "7"><u><h3>FORM C: DAILY KMC COMPLIANCE FORM</h3></u></th></tr>
              <tr><td style="text-align: left;" colspan= "8"><strong><i>Objective:</i></strong><i style="font-family: serif;"> To record the number of hour of KMC given to the baby admitted in the KMC unit in 24 hours (8AM - 8AM), the duration of each session and the reason for not giving continuous KMC. To be collected by nurse on duty in KMC room via direct observation or from mother/caregiver</i> </td></tr>

                  <tr>
                    <td style="width: 100%;text-align: left; padding:5px ;font-family: sans-serif">
                    <b style="margin-right: 40px" >Date:</b> '.date('F j, Y',strtotime($from)).' 8 AM - '.date('F j, Y',strtotime($to)).' 8 AM
                      <b style="margin-left: 30px" >Hospital Registration Number:</b> '.$getBabyFileId['babyFileId'].'  
                      </td>
                   </tr>
                <tr>
                    <td style="width: 50%;text-align: left; padding:5px ;font-family: sans-serif" colspan= "3"><b>Date of Birth</b> (dd/mm/yy): '.date("d/m/Y",strtotime($MotherDetail['deliveryDate'])).'
                  <b style="padding-left: 50px" >Mothers Name:</b> '.$MotherDetail['motherName'].' </td>
                </tr>
              </table>

            <table style="margin-top:10px;border:1px solid;width: 100% " >
                
                <tr style="border:1px solid" >
                  <td style="width: 5%;text-align: center;border:1px solid; padding: 11px;border-bottom:none;"><b>S.No</b></td>
                  <td style="width: 13%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>Start DateTime<br>of KMC</b></td>
                  <td style="width: 13%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>Stop DateTime<br>of KMC</b></td>
                  <td style="width: 20%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>Duration of KMC per<br>episode</b><br><span>(if KMC duration>=1hour<br>then record in hours if <1<br>hour please record in<br> minutes)</span>
                  </td>
                 <td style="width: 25%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>Reason for pausing KMC</b><br><span>(Breast feeding,doctorcheckup,mothers<br>mealtime,mothers personal care,family<br>visit,discomfort,complications,etc.)</span></td>
                  <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>KMC<br>Provider</b></td>
                  <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>Nurse<br>Name</b></td>
                  <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>Nurse<br>Signature</b></td>
              </tr>';

              $i           = 1;
              $Time        = array();
              $RowCount    = count($GetKMCDayDetail)+1;
              $GetRowCount = 9 - $RowCount;

                foreach ($GetKMCDayDetail as $key => $value2) {

                  $nurseName = $this->singlerowparameter('name','staffId',$value2['nurseId'],'staffMaster');
                  $differ = $this->getTimeDiff($value2['startTime'],$value2['endTime']);
                  $content.= '<tr style="border:1px solid" >
                      <td style="width: 5%;text-align: center;border:1px solid; padding: 11px;border-bottom:none;">'.$i.'</td>
                      <td style="width: 13%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;">'.date('F j, Y',strtotime($value2['startDate'])).' '.date('g:i A',strtotime($value2['startTime'])).'</td>
                      <td style="width: 13%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;">'.date('F j, Y',strtotime($value2['endDate'])).' '.date('g:i A',strtotime($value2['endTime'])).'</td>
                      <td style="width: 20%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;">'.$differ.'</td>
                      <td style="width: 25%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                      <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;">'.$value2['provider'].'</td>
                      <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;">'.$nurseName.'</td>
                      <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                   </tr>';

                  $Time[] = $differ ;
                  $i++;
                }
               
                if(($GetRowCount<9) && ($GetRowCount>0))
                {
                  for($z = $RowCount; $z <= 8 ; $z++) { 
                  $content.= '<tr style="border:1px solid" >  
                  <td style="width: 5%;text-align: center;border:1px solid; padding: 11px;border-bottom:none;">'.$z.'</td>
                        <td style="width: 13%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                        <td style="width: 13%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                        <td style="width: 20%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                        <td style="width: 25%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                        <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                        <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                        <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                    </tr>';
                  }

                }

                  $GetTotalTime = $this->AddPlayTime($Time);
                  $content.= '<tr>
                      <td style="text-align: left;width: 5.4%;border:1px solid "></td>
                      <td style="text-align: left;padding:5px" colspan = "6" >
                        Total KMC duration in 24 hours ('.$from.' 8 AM to '.$to.' 8 AM):<br><br>
                        '.$GetTotalTime.'
                     </td>
                      <td style="text-align: left;width: 8.7%;border:1px solid "></td>
                  </tr>
                </table>';
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


    function singlerowparameter($select,$matchWith,$matchingId,$table)
    {
        $tableRecord = & get_instance();
        $tableRecord->load->database();     
        $tableRecord->db->select($select);  
        $query = $tableRecord->db->get_where($table,array($matchWith => $matchingId))->row_array();   
        return $query[$select];       
    }


    function getTimeDiff($StartTime,$EndTime)
    {
      $Hours = floor((strtotime($EndTime)- strtotime($StartTime))/60);
      $d = floor($Hours / 1440);
      $h = floor(($Hours - $d * 1440) / 60);
      $m = $Hours - ($d * 1440) - ($h * 60);
      return sprintf('%02d:%02d', $h, $m);
      //return  $h.':'.$m ;    

    }

    function AddPlayTime($times) {
        $minutes = 0; 
        foreach ($times as $time) {
            list($hour, $minute) = explode(':', $time);
            $minutes += $hour * 60;
            $minutes += $minute;
        }

        $hours = floor($minutes / 60);
        $minutes -= $hours * 60;

        // returns the time already formatted
        return sprintf('%02d:%02d', $hours, $minutes);
    }


}