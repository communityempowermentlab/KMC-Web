<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MonitoringPDF extends CI_Controller {
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
            .monitoringTDPadding{
              background-color: #77773c;
              padding: 11px 4px 11px 4px !important;
              width:150px;
              text-align:center;
            }div.ab {
              border:1px solid black;
              -ms-transform: rotate(150deg);
              -webkit-transform: rotate(150deg); 
             -moz-transform: rotate(150deg);
               -o-transform: rotate(150deg); 
              transform: rotate(150deg);
            }/*div.ab {
              width: 150px;
              height: 80px;
              background-color: yellow;
              -ms-transform: rotate(20deg); /* IE 9 */
              -webkit-transform: rotate(20deg); /* Safari 3-8 */
              transform: rotate(20deg);
            }*/
        </style>
    </head>
      <body>
        <div style="width:100%;height:1122px;">
          <!-- set heading of pdf form -->
          <h2 style="text-align: center;margin: auto;">MONITORING SHEET</h2>

          <table width="100%" style="margin-top:8px;">
            <tr>
              <td style="width: 60%;" class="monitoringHeadingFont">
                <span>SNCU Reg. No.</span> 
                ..............................................................
              </td>
              <td style="width: 40%;" class="monitoringHeadingFont">
                <span>Date of Admission</span>
                  ........................
              </td>
            </tr>

              <tr>
                <td style="width: 60%;" class="monitoringHeadingFont">
                  <span>Baby of (Mother'."'".'s name).</span> 
                    ..............................................
                </td>
                <td style="width: 40%;" class="monitoringHeadingFont">
                  <span>Sex</span>
                     ...............................................
                </td>
              </tr>

            <tr>
              <td style="width: 60%;" class="monitoringHeadingFont">
                <span>Weight</span> 
                   ............................................................................
              </td>
              <td style="width: 40%;" class="monitoringHeadingFont">
                <span>Date</span>
                  .............................................
              </td>
            </tr>
          </table>

  
          <table width="100%" border="1" style="margin-top:8px;">
            <tr>
              <td class="monitoringTDPadding">
                <span class="tdContentCss">Time</span> 
              </td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
            </tr>

            <tr>
              <td class="monitoringTDPadding">
                <span class="tdContentCss">Activity<br/>(Dull/Active)</span> 
              </td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
            </tr>

            <tr>
              <td class="monitoringTDPadding">
                <span class="tdContentCss">Temperature</span> 
              </td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
            </tr>

            <tr>
              <td class="monitoringTDPadding">
                <span class="tdContentCss">Colour</span> 
              </td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
            </tr>

             <tr>
              <td class="monitoringTDPadding">
                <span style="text-align:left;">HR</span>
                  <hr style="-webkit-transform: rotate(150deg);transform: rotate(150deg) !important;">
               <span style="text-align:right;">RR</spa>
              </td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
            </tr>
            
            <tr>
              <td class="monitoringTDPadding">
                <span class="tdContentCss">CRT/B.P.</span> 
              </td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
            </tr>

            <tr>
              <td class="monitoringTDPadding">
                <span class="tdContentCss">O2 Flow Rate/Flo2</span> 
              </td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
            </tr>

            <tr>
              <td class="monitoringTDPadding">
                <span class="tdContentCss">Oxygen<br/>Saturation</span> 
              </td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
            </tr>

            <tr>
              <td class="monitoringTDPadding">
                <span class="tdContentCss">Blood<br/>Glucose</span> 
              </td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
            </tr>

            <tr>
              <td class="monitoringTDPadding">
                <span class="tdContentCss">Urine</span> 
              </td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
            </tr>

            <tr>
              <td class="monitoringTDPadding">
                <span class="tdContentCss">Stool</span> 
              </td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
            </tr>

            <tr>
              <td class="monitoringTDPadding">
                <span class="tdContentCss">Abdominal<br/>Girth</span> 
              </td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
            </tr>

            <tr>
              <td class="monitoringTDPadding">
                <span class="tdContentCss">R.T.<br/>Aspirate</span> 
              </td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
            </tr>

             <tr>
              <td class="monitoringTDPadding">
                <span class="tdContentCss">IV Patency<br/>Yes/No</span> 
              </td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
            </tr>
            
            <tr>
              <td class="monitoringTDPadding">
                <span class="tdContentCss">Blood<br/>Collection</span> 
              </td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
            </tr>

            <tr>
              <td class="monitoringTDPadding">
                <span class="tdContentCss">Other</span> 
              </td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
              <td>....</td>
            </tr>                                            
          </table>
        </div>
      </body>
  </html>'; 

        $pdfFilePath =  INVOICE_DIRECTORY."monitoringPDf.pdf";
        $mpdf =  new mPDF('utf-8', 'A4-R');
        $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

        $mpdf->WriteHTML($PDFContent);

        $mpdf->Output($pdfFilePath, "F"); 
        return "b_".$getBabyFileId['id']."_weigth.pdf";
    }


}