<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class InvestigationPdf extends CI_Controller {
  public function __construct()
    {
      
      parent::__construct();         
      $this->load->library('M_pdf'); 
      include_once APPPATH.'/third_party/mpdf/mpdf.php';    
    }


  
   public function generatePdf()
    {
      error_reporting(0); 
      $this->load->library('Mpdf');
      $mpdf=new mPDF('utf-8');

        $html.= '<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
          <style type="text/css">
            table, th, td {
              border: 1px solid black;
              border-collapse: collapse;
            }th, td{
              padding:2px;
              text-align: left;    
            }#SN {
              height:60x;
              width:100%;
              padding:2px;
            }#SN1 {
              height:30x;
              width:100%;
            }#SN11 {
              height:30x;
              width:60%;
              float:left;
            }#SN12 {
              height:30x;
              width:40%;
              float:left;
            }#SN21 {
              height:30x;
              width:60%;
              float:left;
            }#SN22 {
              height:30x;
              width:40%;
              float:left;
            }#SN2{
              height:30x;
              width:100%;
            }
          </style>

          <body>
              <p style="text-align:center; font-weight:bold;">INVESTIGATION SHEET</p>

              
               <div id="SN">

                <div id="SN1">
                
                <div id="SN11"><p style="font-size:14px;">SNCU Reg.No.........................................................</p></div>
                <div id="SN12"><p style="font-size:14px;">Date of Admission................................</p></div>

                </div>
                <div id="SN2">

                <div id="SN21"><p>Baby of(Mothers name).........................................................</p></div>
                <div id="SN22"><p>Sex................................</p></div>

                </div>

               </div>
                    
            
            

<table style="width:100%">
  <tr style="background-color:gray;">
    <th style="width:27%;">Investigation</th>
    <th>Date:</th>
    <th>Date:</th>
    <th>Date:</th>
    <th>Date:</th>
    <th>Date:</th>

  </tr>

  <tr>

    <td style="background-color:gray;">Hb</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>

  </tr>
  
  
   <tr>

    <td style="background-color:gray;">PCV</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  
    <tr>
    <td style="background-color:gray;">Total WBC Count</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>

  </tr>

    <tr>
    <td style="background-color:gray;">Differential WBC Count</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>

  </tr>

  <tr>

    <td style="background-color:gray;">Band Form/I.T.Ratio</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>

  <tr>

    <td style="background-color:gray;">Platelet Count</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>

  <tr>
    <td style="background-color:gray;">Peripheral Smear</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>

  <tr>

    <td style="background-color:gray;">PT/PTTK/FPD</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>

  </tr>

  <tr>

    <td style="background-color:gray;">CRP</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>

  </tr>

  <tr>

    <td style="background-color:gray;">Random Blood Glucose</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>

  </tr>

  <tr>

    <td style="background-color:gray;">Blood Urea Nitrogen</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>

  <tr>

    <td style="background-color:gray;">Serum Creatioine</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>

  <tr>

    <td style="background-color:gray;">Serum Calcium</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>

  <tr>

    <td style="background-color:gray;">Serum Sodium</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>

  </tr>

  <tr>

    <td style="background-color:gray;">Serum Potassium</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>

  </tr>

  <tr>

    <td style="background-color:gray;">Serum Bilirubin:<br/>Total / Indirect / Direct</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>

  </tr>

  <tr>

    <td style="background-color:gray;">SGPT</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>

  </tr>

  <tr>

      <td style="background-color:gray;">Total Protein/Ser.Albumin</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>

  </tr>

  <tr>
        <td style="background-color:gray;">Urine R&M</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
  </tr>

    <tr>
        <td style="background-color:gray;">Stool for Occult Blood</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>

    </tr>


    <tr>

      <td  style="background-color:gray;">Blood Gas:<br/>Artial / Venous</td>
      <td style="font-size:11px;">Date:<br/> Time:<br/>FIO2:<br/>PH:<br/>PCO2:<br/>PO2:<br/>HCO3:<br/>Sath:</td>
      <td style="font-size:11px;">Date:<br/> Time:<br/>FIO2:<br/>PH:<br/>PCO2:<br/>PO2:<br/>HCO3:<br/>Sath:</td>
      <td style="font-size:11x;">Date:<br/> Time:<br/>FIO2:<br/>PH:<br/>PCO2:<br/>PO2:<br/>HCO3:<br/>Sath:</td>
      <td style="font-size:11px;">Date:<br/> Time:<br/>FIO2:<br/>PH:<br/>PCO2:<br/>PO2:<br/>HCO3:<br/>Sath:</td>
      <td style="font-size:11px;">Date:<br/> Time:<br/>FIO2:<br/>PH:<br/>PCO2:<br/>PO2:<br/>HCO3:<br/>Sath:</td>

  </tr>


  <tr>


      <td  style="background-color:gray;">C.S.F.</td>
      <td style="font-size:11px;" colspan="3">Date:<br/> Cells:<br/>Sugar:<br/>Protein:<br/>Culture:</td>
      <td style="font-size:11px;" colspan="2"></td>

  </tr>

  <tr>

    <td  style="background-color:gray;">Urine Culture</td>
      <td style="font-size:11px;" colspan="3">Date:</td>
      <td style="font-size:11px;" colspan="2">Date;</td>

  </tr>

  <tr>

    <td  style="background-color:gray;">Blood Culture</td>
      <td style="font-size:11px;" colspan="3">Date:</td>
      <td style="font-size:11px;" colspan="2">Date;</td>

  </tr>
  <tr>

    <td  style="background-color:gray;">X-Ray</td>
      <td style="font-size:11px;" colspan="3">Date:</td>
      <td style="font-size:11px;" colspan="2">Date;</td>

  </tr>
  <tr>

    <td  style="background-color:gray;">USG</td>
      <td style="font-size:11px;" colspan="3">Date:</td>
      <td style="font-size:11px;" colspan="2">Date;</td>

  </tr>
  <tr>

    <td  style="background-color:gray;">CT / MRI</td>
      <td style="font-size:11px;" colspan="3">Date:</td>
      <td style="font-size:11px;" colspan="2">Date;</td>

  </tr>
  <tr>

    <td  style="background-color:gray;">Any Orher</td>
      <td style="font-size:11px;" colspan="3">Date:</td>
      <td style="font-size:11px;" colspan="2">Date;</td>

  </tr>  

  
  </table>

        <p style="text-align:center; font-weight:bold">This is Sheet has to be filled by Nurse on Duty</p>

</body>


      


  </html>'; 
         
          

         //echo $html;
        /*  $mpdf->autoScriptToLang = true;
          $mpdf->baseScript = 1;
          $mpdf->autoVietnamese = true;
          $mpdf->autoArabic = true;
          $mpdf->autoLangToFont = true; 

          $mpdf->WriteHTML($html);
          $filename = 'Receipt'.'['.date('d-m-Y').'].pdf';

          $mpdf->Output('pdf/'.$filename,'F');

          $getfilepath = base_url().'pdf/'.$filename;
        
          return $filename; */

        $pdfFilePath =  INVOICE_DIRECTORY."investigationPdf.pdf";
        $mpdf =  new mPDF('utf-8', 'A4-R');
        $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

        $mpdf->WriteHTML($PDFContent);

        $mpdf->Output($pdfFilePath, "F"); 
        return "b_".$getBabyFileId['id']."_weigth.pdf";
    }




}