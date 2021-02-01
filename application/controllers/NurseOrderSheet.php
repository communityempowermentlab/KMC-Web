<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class NurseOrderSheet extends CI_Controller {
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
              width:200px;
              text-align:center;
            }.tdOrderSheetCss{
              text-align:center;
            }
        </style>
    </head>
      <body>
        <div style="width:100%;height:1122px;">
          <!-- set heading of pdf form -->
          <h2 style="text-align: center;margin: auto;">NURSES ORDER SHEET</h2>

          <table width="100%" border="1" style="margin-top:8px;">
            <tr>
              <td class="monitoringTDPadding">
                <span class="tdContentCss">Treatment<br/>Administered</span> 
              </td>
              <td class="tdOrderSheetCss">Time<br/>....</td>
              <td class="tdOrderSheetCss">Time<br/>....</td>
              <td class="tdOrderSheetCss">Time<br/>....</td>
              <td class="tdOrderSheetCss">Time<br/>....</td>
              <td class="tdOrderSheetCss">Time<br/>....</td>
              <td class="tdOrderSheetCss">Time<br/>....</td>
              <td class="tdOrderSheetCss">Time<br/>....</td>
              <td class="tdOrderSheetCss">Time<br/>....</td>
              <td class="tdOrderSheetCss">Time<br/>....</td>
              <td class="tdOrderSheetCss">Time<br/>....</td>
              <td class="tdOrderSheetCss">Time<br/>....</td>
              <td class="tdOrderSheetCss">Time<br/>....</td>
              <td class="tdOrderSheetCss">Total<br/>(ml)</td>

            </tr>

            <tr>
              <td class="monitoringTDPadding">
                <span class="tdContentCss">
                 <u>Oral Feeds</u><br/><br/>
                   Feeding Tube (ml) <br/><br/>
                   Spoon & Cup (ml) <br/><br/>
                   Breast Feed (adlib) 
                </span> 
              </td>
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
            </tr>

            <tr>
              <td class="monitoringTDPadding">
                <span class="tdContentCss"> 
                  <u>Oral Drugs</u><br/><br/>
                  <ol>
                   <li>............</li>
                   <li>............</li>
                  </ol>
                </span> 
              </td>
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
            </tr>

            <tr>
              <td class="monitoringTDPadding">
                <span class="tdContentCss">
                 <u>IV Drugs</u><br/>
                   (Also Record Fluid Volume) <br/><br/>
                  <ol>
                   <li>............</li>
                   <li>............</li>
                   <li>............</li>
                  </ol>
                </span> 
              </td>
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
            </tr>

             <tr>
              <td class="monitoringTDPadding">
                <span class="tdContentCss">
                 <u>IV Fluids</u> <br/><br/>
                  <ol>
                   <li>
                      ............<br/>
                      (Enter Tate & fluid given between each time slot)<br/>
                   </li>
                   <li>
                      ............<br/>
                      (Enter Tate & fluid given between each time slot)<br/>
                   </li>
                  </ol>
                </span> 
              </td>
              <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td> 
              <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td> 
              <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td> 
              <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td> 
              <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td>
               <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td> 
              <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td> 
              <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td> 
              <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td> 
              <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td> 
              <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td> 
              <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td> 
              <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td>

            </tr>
            
             <tr>
              <td class="monitoringTDPadding">
                <span class="tdContentCss">
                 <u>IV Infusions</u> <br/><br/>
                  <ol>
                   <li>
                      ............<br/>
                      (Enter Tate & fluid given between each time slot)<br/>
                   </li>
                   <li>
                      ............<br/>
                      (Enter Tate & fluid given between each time slot)<br/>
                   </li>
                  </ol>
                </span> 
              </td>
              <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td> 
              <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td> 
              <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td> 
              <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td> 
              <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td>
               <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td> 
              <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td> 
              <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td> 
              <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td> 
              <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td> 
              <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td> 
              <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td> 
              <td>
                 ....ml/hr<br/>
                 (....ml)<br/><br/>
                 ....ml/hr<br/>
                 (....ml)
              </td>

            </tr>

            <tr>
              <td class="monitoringTDPadding">
                <span class="tdContentCss">
                  IV Bolus<br/><br/>
                  ............ml<br/>
                </span> 
              </td>
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
            </tr>

            <tr>
              <td class="monitoringTDPadding">
                <span class="tdContentCss">
                  <u>Blood/Packed/Cell/</u><br/>
                  <u>FFP/Platelet</u>(...ml)<br/><br/>
                  Rate..........ml/hr<br/>
                </span> 
              </td>
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
            </tr>

            <tr>
              <td class="monitoringTDPadding">
                <span class="tdContentCss">
                  </u>Any Other Treatment</u><br/><br/>
                 ...............<br/><br/>
                 ...............<br/><br/>
        
                </span> 
              </td>
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
            </tr>

            <tr>
              <td class="monitoringTDPadding" colspan="13" style="text-align:right;">
              Total Input in 24 Hours(ml)
              </td>
              <td class="tdOrderSheetCss">....</td>
            </tr>

                                           
          </table>
        </div>
      </body>
  </html>'; 

        $pdfFilePath =  INVOICE_DIRECTORY."nurseOrderSheet.pdf";
        $mpdf =  new mPDF('utf-8', 'A4-R');
        $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

        $mpdf->WriteHTML($PDFContent);

        $mpdf->Output($pdfFilePath, "F"); 
        return "b_".$getBabyFileId['id']."_weigth.pdf";
    }


}