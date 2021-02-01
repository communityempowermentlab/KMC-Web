<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ClinicalConditionRecord extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        include_once APPPATH.'/third_party/mpdf/mpdf.php';    
    }

    public function generatePdf()
    {
        error_reporting(0); 
        $html.= '<html>
       <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style type="text/css">
            .monitoringHeadingFont{
              font-size:15px;
              padding: 4px 0px 4px 0px !important;
            }table {
                border-collapse: collapse;
              }
            .clinicalTDPadding{
              background-color: #77773c;
              padding: 11px 4px 11px 4px !important;
              width:200px;
              text-align:center;
            }.tdClinicalSheetCss{
              padding : 5px 2px 5px 2px;
              text-align:center;
            }
        </style>
    </head>
      <body>
        <div style="width:100%;height:1122px;">
          <!-- set heading of pdf form -->
          <h2 style="text-align: center;margin: auto;">CLINICAL CONDITION RECORD</h2>

          <table width="100%" border="1" style="margin-top:8px;">
            <tr>
              <td class="clinicalTDPadding">
                <span class="tdContentCss"><b>Clinical Findinds<br/>on Round and<br/>Advise</b></span> 
              </td>
              <td class="tdClinicalSheetCss">
              <b>Date.............<br/><br/>
                 Wt...............<br/><br/>
                 PND..............<br/><b/>
              </td>
              <td class="tdClinicalSheetCss">
                 <b>Date.............<br/><br/>
                 Wt...............<br/><br/>
                 PND..............<br/><b/>
              </td>
            </tr>

            <tr>
              <td class="clinicalTDPadding">
                 <b>Morning Round</b><br/><br/>
                 Doctors Name<br/><br/>
                ____________________<br/><br/>
                ____________________<br/><br/>
                Signature<br/><br/>
                ____________________<br/><br/>
              </td>
              <td></td>
              <td></td>
            </tr>  


            <tr>
              <td class="clinicalTDPadding">
                 <b>Evening Round</b><br/><br/>
                 Doctors Name<br/><br/>
                ____________________<br/><br/>
                ____________________<br/><br/>
                Signature<br/><br/>
                ____________________<br/><br/>
              </td>
              <td></td>
              <td></td>
            </tr> 



            <tr>
              <td class="clinicalTDPadding">
                <span class="tdContentCss">
                 <u>Oral Feeds</u><br/><br/>
                   Feeding Tube (ml) <br/><br/>
                   Spoon & Cup (ml) <br/><br/>
                   Breast Feed (adlib) 
                </span> 
              </td>
              <td></td>
              <td></td>
            </tr> 


            <tr>
              <td class="clinicalTDPadding">
                 <b>Night Round</b><br/><br/>
                 Doctors Name<br/><br/>
                ____________________<br/><br/>
                ____________________<br/><br/>
                Signature<br/><br/>
                ____________________<br/><br/>
              </td>
              <td></td>
              <td></td>
            </tr>                                      
          </table>
          <div style="text-align:center;margin-top:10px;font-weight:bold;font-size:12px;">This Sheet has to be filled by Doctor on Duty</div>
        </div>
      </body>
  </html>'; 

        $pdfFilePath =  INVOICE_DIRECTORY."clinicalConditionRecord.pdf";
        $mpdf =  new mPDF('utf-8', 'A4-R');
        $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

        $mpdf->WriteHTML($PDFContent);

        $mpdf->Output($pdfFilePath, "F"); 
        return "b_".$getBabyFileId['id']."_weigth.pdf";
    }


}