<?php
class CreateMonitoringSheet extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		include_once APPPATH.'/third_party/mpdf/mpdf.php';  
    date_default_timezone_set("Asia/KolKata");
	}

// create Nurse order sheet
    public function generatePdf($admissionId)
    {
      error_reporting(0);
      $getBabyRecord  = $this->getBabyDetails($admissionId);
      $getMotherData  = $this->getMotherData($getBabyRecord['babyId']);

      //set data for specific var
      $sncuNumber = !empty($getBabyRecord['temporaryFileId']) ? $getBabyRecord['temporaryFileId'] : 'N/A';
      $motherName = !empty($getMotherData['motherName']) ? $getMotherData['motherName'] : 'N/A';


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
            }.fontWeightSize{
              font-weight:bold;
            }
        </style>
    </head>
      <body>
        <div style="width:100%;height:1122px;">
          <!-- set heading of pdf form -->
          <h2 style="text-align: center;margin: auto;">MONITORING SHEET</h2>

          <table width="100%" style="margin-top:8px;">
            <tr>
              <td style="width: 60%;" class="monitoringHeadingFont">
                <span class="fontWeightSize">SNCU Reg. No:</span> 
                  '.$sncuNumber.'
              </td>
              <td style="width: 40%;" class="monitoringHeadingFont">
                <span class="fontWeightSize">Date of Admission:</span>
                  '.date('d-m-Y',$getBabyRecord['admissionDate']).'
              </td>
            </tr>

              <tr>
                <td style="width: 60%;" class="monitoringHeadingFont">
                  <span class="fontWeightSize">Baby of (Mother'."'".'s name):</span> 
                    '.$motherName.'
                </td>
                <td style="width: 40%;" class="monitoringHeadingFont">
                  <span class="fontWeightSize">Sex:</span>
                    '.$getBabyRecord['babyGender'].'
                </td>
              </tr>

            <tr>
              <td style="width: 60%;" class="monitoringHeadingFont">
                <span class="fontWeightSize">Weight:</span> 
                  '.$getBabyRecord['babyWeight'].'
              </td>
              <td style="width: 40%;" class="monitoringHeadingFont">
                <span class="fontWeightSize">Date:</span>
                  '.date('d-m-Y',$getBabyRecord['admissionDate']).'
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

        $pdfFilePath = pdfDirectory.$admissionId."MonitoringSheet.pdf";
        $mpdf        = new mPDF('utf-8', 'A4-R');
        $PDFContent  = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $mpdf->WriteHTML($PDFContent);
        $mpdf->Output($pdfFilePath, "F"); 
        return $admissionId."MonitoringSheet.pdf";
    }

// get baby details
  public function getBabyDetails($admissionId){
    return $this->db->query("select *,ba.`addDate` as admissionDate from babyAdmission as ba inner join babyRegistration as br on ba.babyId=br.babyId where ba.id=".$admissionId."")->row_array();
  }
// get mother data
   //mother Data receive here
  public function getMotherData($babyId){
    return $this->db->query("SELECT * FROM motherRegistration as mr INNER JOIN babyRegistration as br on mr.`motherId`=br.`motherId` where br.`babyId`=".$babyId."")->row_array();
  }
}