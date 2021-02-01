<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kmc extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/baby_model');
        $this->load->library('m_pdf');      
    }
    public function WeightpdfGenerate($id)
    {
      $this->db->order_by('id','desc');
      $babyAdmisionLastId = $this->db->get_where('baby_admission',array('id'=>$id))->row_array();

          $PdfName = $this->BabySkinToSkinPdfFile($babyAdmisionLastId['LoungeID'],$babyAdmisionLastId['BabyID'],$id);
          $this->db->where('id',$babyAdmisionLastId['id']);     
          $res = $this->db->update('baby_admission',array('BabyKMCPdfName'=>$PdfName));
           if($res > 0){
           $this->session->set_flashdata('activate', getCustomAlert('S','KMC PDF Generate Successfully'));
            redirect('BabyManagenent/registeredBaby/1/'.$babyAdmisionLastId['LoungeID']);
           }
    }

     public function BabySkinToSkinPdfFile($LoungeID, $BabyID,$id)
    {
        error_reporting(0);

        $getBabyFileId = $this->db->get_where('baby_admission',array('id'=>$id))->row_array();

        $MotherDetail =  $this->db->query("SELECT MR.`MotherName`, BR.`DeliveryDate`, BR.`BabyWeight` FROM mother_registration as MR LEFT JOIN babyRegistration as BR  on BR.`MotherID` =  MR.`MotherID`  WHERE BR.`BabyID` = '".$BabyID."'")->row_array();


       $GetDay = $this->db->query("SELECT Distinct SkinDate FROM `babyDailyKMC` where  LoungeID = '".$LoungeID."' AND BabyID = '".$BabyID."' AND baby_admissionID = '".$id."'")->result_array(); 
       
          $html.='<html>
          <head>
          <title>FORM C: DAILY KMC COMPLIANCE FORM</title>
          <style>
            table,th,td,tr{
            border-collapse:collapse;
              }

          </style>
          </head>
          <body>';
        $y = '0';     
        foreach ($GetDay as $key => $value) {
      
    
           $html.= '<table style="width: 100%;margin-bottom: -11px;border-bottom:none;" >
            <tr><th style="text-align: center;font-family: sans-serif;" colspan= "7"><u><h3>FORM C: DAILY KMC COMPLIANCE FORM</h3></u></th></tr>
            <tr><td style="text-align: left; " colspan= "8"><strong ><i>Objective:</i></strong><i style="font-family: serif;"> To record the number of hour of KMC given to the baby admitted in the KMC unit in 24 hours (8AM - 8AM ), the duration of each session and the reason for not giving continuous KMC. To be collected by nurse on duty in KMC room via direct observation or from mother/caregiver</i> </td></tr>

              
                <tr>
                  <td style="width: 100%;text-align: left; padding:5px ;font-family: sans-serif"  >
                  <b style="margin-right: 40px" >Day:</b> '.date('l',strtotime($value['SkinDate'])).'
                    <b style="margin-left: 30px" >Hospital Reg. No.:</b> '.$getBabyFileId['BabyFileID'].'  
                    </td>
                 </tr>
              <tr>
                  <td style="width: 50%;text-align: left; padding:5px ;font-family: sans-serif" colspan= "3"><b>Date of Birth(dd/mm/yy) :</b>  '.date("d/m/Y",strtotime($MotherDetail['DeliveryDate'])).'
                <b style="padding-left: 50px" >Mothers Name:</b> '.$MotherDetail['MotherName'].' </td>
              </tr>
            </table>



          <table style="margin-top:10px;border:1px solid;width: 100% " >
              
              <tr style="border:1px solid" >
                <td style="width: 5%;text-align: center;border:1px solid; padding: 11px;border-bottom:none;"><b>S.No</b></td>
                <td style="width: 13%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>Starting time<br>of KMC</b></td>
                <td style="width: 13%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>Stopping time<br>of KMC</b></td>
                <td style="width: 20%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>Duration of KMC per<br>episode</b><br><span>(if KMC duration>=1hour<br>then record in hours if <1<br>hour please record in<br> minutes)</span>
                </td>
               <td style="width: 25%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>Reason for pausing KMC</b><br><span>(Breast feeding,doctorcheckup,mothers<br>mealtime,mothers personal care,family<br>visit,discomfort,complications,etc.)</span></td>
                <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>KMC<br>Provider</b></td>
                <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>Nurse<br>Name</b></td>
                <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>Nurse<br>Signature</b></td>
            </tr>';

            $GetKMCDayDetail = $this->db->query("SELECT * FROM `babyDailyKMC`  where  LoungeID = '".$LoungeID."' AND BabyID = '".$BabyID."' And SkinDate = '".$value['SkinDate']."' AND baby_admissionID = '".$id."'")->result_array();
            
            $i         = 1;
            $Time        = array();
            $RowCount    = count($GetKMCDayDetail)+1;
            $GetRowCount = 7 - $RowCount;

              foreach ($GetKMCDayDetail as $key => $value2) {

                        $nurseName = singlerowparameter2('Name','StaffID',$value2['NurseId'],'staff_master');
                $differ = getTimeDiff($value2['StartTime'],$value2['EndTime']);
                $html.= '<tr style="border:1px solid" >
                    <td style="width: 5%;text-align: center;border:1px solid; padding: 11px;border-bottom:none;">'.$i.'</td>
                    <td style="width: 13%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;">'.date('g:i A',strtotime($value2['StartTime'])).'</td>
                    <td style="width: 13%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;">'.date('g:i A',strtotime($value2['EndTime'])).'</td>
                    <td style="width: 20%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;">'.$differ.'</td>
                    <td style="width: 25%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                    <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;">'.$value2['ByWhom'].'</td>
                    <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;">'.$nurseName.'</td>
                    <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                 </tr>';

                $Time[] = $differ ;
                $i++;
              }
             
              if(($GetRowCount<7) && ($GetRowCount>0))
              {
                for($z = $RowCount; $z <= 8 ; $z++) { 
                $html.= '<tr style="border:1px solid" >  
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

            $GetTotalTime = AddPlayTime($Time);
            $html.= '<tr>
                <td style="text-align: left;width: 5.4%;border:1px solid "></td>
                <td style="text-align: left;padding:5px" colspan = "6" >
                  Total KMC duration in 24 hours (8 am to 8 am):<br><br>
                  '.$GetTotalTime.'
               </td>
                <td style="text-align: left;width: 8.7%;border:1px solid "></td>
            </tr>
          </table>';
        $y++;
      }
      $html.='</body>
      </html>'; 



        $pdfFilePath =  INVOICE_DIRECTORY."b_".$getBabyFileId['id']."_KMC.pdf";

        include_once APPPATH.'/third_party/mpdf/mpdf.php';
        $this->m_pdf->pdf->autoScriptToLang = true;
        $this->m_pdf->pdf->baseScript = 1;
        $this->m_pdf->pdf->autoVietnamese = true;
        $this->m_pdf->pdf->autoArabic = true;
        $this->m_pdf->pdf->autoLangToFont = true;
        $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $this->m_pdf->pdf->WriteHTML($PDFContent);
        $this->m_pdf->pdf->Output($pdfFilePath, "F"); 

        return  "b_".$getBabyFileId['id']."_KMC.pdf";
    }

}