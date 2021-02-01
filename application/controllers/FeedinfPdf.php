<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FeedinfPdf extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/baby_model');  
        $this->load->library('m_pdf');       
    }
    public function WeightpdfGenerate($id)
    {
      $babyAdmisionLastId = $this->db->get_where('baby_admission',array('id'=>$id))->row_array();

           $PdfName = $this->BabyDailyFeedPDFFile($babyAdmisionLastId['LoungeID'],$babyAdmisionLastId['BabyID'],$id);
          $this->db->where('id',$babyAdmisionLastId['id']);     
          $res = $this->db->update('baby_admission',array('BabyFeedingPdfName'=>$PdfName));
           if($res > 0){
           $this->session->set_flashdata('activate', getCustomAlert('S','Feeding PDF Generate Successfully'));
            redirect('BabyManagenent/registeredBaby/1/'.$babyAdmisionLastId['LoungeID']);
           }

    }

      public function BabyDailyFeedPDFFile($LoungeID, $BabyID,$id)
    {
        error_reporting(0);

        $getBabyFileId = $this->db->get_where('baby_admission',array('id'=>$id))->row_array();

        $MotherDetail =  $this->db->query("SELECT MR.`MotherName`, BR.`DeliveryDate`, BR.`BabyWeight` FROM mother_registration as MR LEFT JOIN babyRegistration as BR  on BR.`MotherID` =  MR.`MotherID`  WHERE BR.`BabyID` = '".$BabyID."'")->row_array();

        $Age = $this->TestDate($MotherDetail['DeliveryDate']);

        $BabyAge = ($Age > 0) ?  $Age.' days' :'_______________________';

        $html.='<html>
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
        $y = '0';     
  
      $GetDay = $this->db->query("SELECT Distinct FeedDate FROM `babyDailyNutrition` where  LoungeID = '".$LoungeID."' AND BabyID = '".$BabyID."' and baby_admissionID = '".$id."'")->result_array(); 
  
      //echo $this->db->last_query(); exit;
      foreach ($GetDay as $key => $value) {

      $html.='<body>


        <div>
            <h2 style= "text-align:center"> <u>FORM B: DAILY INTAKE MONITORING RECORD </u></h2>
           <p style="font-size: 14px"> <b>Objective:</b> To record the quantity and frequency of feeding of the baby admitted in the KMC unit in 24 hours (8 AM - 8 Am), so as to compare the total quantity to the total feeding requirement. To be filled by nurse on duty in the KMC </p>
        </div>


         <div>

          <div style=" padding-bottom: 5px; padding-top: 5px">
            <label> <b>Day :</b> '.date('l',time()).'</label> 
            <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Hospital Reg. No.:</b>  '.$getBabyFileId['BabyFileID'].'</label> 
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Date (dd/mm/yyyy)</b>: '.date('d/m/Y',strtotime($value['FeedDate'])). '</label>
            </div>
            
          <div>

           <div style=" padding-bottom: 5px; padding-top: 5px">
            <label> <b>Mother Name :</b>  '.ucwords($MotherDetail['MotherName']).'</label> 
            <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Baby age(in days):</b> '.$BabyAge.' </label> 
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total feeding requirement for the day</b>: _________________________________</label>
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

            $GetKMCDayDetail = $this->db->query("SELECT * FROM `babyDailyNutrition`  where  LoungeID = '".$LoungeID."' AND BabyID = '".$BabyID."' And FeedDate = '".$value['FeedDate']."'  and baby_admissionID = '".$id."'")->result_array();

            
            $i = 1;

            $Time = array();
            $RowCount = count($GetKMCDayDetail)+1;
            $GetRowCount = 11 - $RowCount;

            /*$($value['FeedingType'] ==1)? $*/

            foreach ($GetKMCDayDetail as $key => $value2) {


                $html.= '<tr>
                  <td>'.$i.'</td>
                  <td>'.date('g:i A',strtotime($value2['FeedTime'])).'</td>
                  <td>'.$value2['BreastFeedDuration'].'</td>
                  <td>'.$value2['MilkQuantity'].'</td>
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
                $i++;
              }

              if(($GetRowCount<11) && ($GetRowCount>0))
            {
              for($z = $RowCount; $z <= 11 ; $z++) { 
              $html.= '<tr style="border:1px solid" >  
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
              $html.='</table>';
          }


      $html.='</body>
      </html>' ;

      $pdfFilePath =  INVOICE_DIRECTORY."b_".$getBabyFileId['id']."_Feeding.pdf";

      include_once APPPATH.'/third_party/mpdf/mpdf.php';
        $this->m_pdf->pdf->autoScriptToLang = true;
        $this->m_pdf->pdf->baseScript = 1;
        $this->m_pdf->pdf->autoVietnamese = true;
        $this->m_pdf->pdf->autoArabic = true;
        $this->m_pdf->pdf->autoLangToFont = true;
        $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $this->m_pdf->pdf->WriteHTML($PDFContent);
        $this->m_pdf->pdf->Output($pdfFilePath, "F"); 

      return  "b_".$getBabyFileId['id']."_Feeding.pdf";
    }

    public function TestDate($date1)
    {
      $now = time(); 
    $your_date = strtotime($date1);
    $datediff = $now - $your_date;
    return round($datediff / (60 * 60 * 24));
    }

}