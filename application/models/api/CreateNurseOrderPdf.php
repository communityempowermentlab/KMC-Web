<?php
class CreateNurseOrderPdf extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		include_once APPPATH.'/third_party/mpdf/mpdf.php';  
    date_default_timezone_set("Asia/KolKata");
	}

// create Nurse order sheet
    public function generateNurseOrderPdf($babyId,$nurseId)
    {
        error_reporting(0); 
        $getBabyData   = $this->CreatePdf->getBabyAdmissionData($babyId);
        $getMotherData = $this->CreatePdf->getMotherData($babyId);
        $getDoctorData = $this->CreatePdf->getDoctorData($nurseId);

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
              background-color: #D3D3D3;
              padding: 11px 4px 11px 4px !important;
              width: 16%;
              font-size: 15px;
              text-align: center;
            }.tdOrderSheetCss{
              padding: 11px 4px 11px 4px !important;
              width: 7%;
              text-align:center;
              font-size: 15px;
            }.sizeofPrescription{
              width : 16%;
              font-size: 15px;
              padding: 11px 0px 11px 1px !important;
              background-color: #D3D3D3;
            }
        </style>
    </head>
      <body>';
     $getResult = $this->db->query("select distinct FROM_UNIXTIME(addDate,'%d%-%m%-%Y') as addDate from prescriptionNurseWise where babyAdmissionId=".$getBabyData['id']."");
     $getDateWiseCounting = $getResult->num_rows();
     $dateWiseRecord      = $getResult->result_array();

     foreach ($dateWiseRecord as $key => $val) {
      $feild['addDate']            = $val['addDate'];
      $date[]                      = $feild;
     }

      $i = $getDateWiseCounting;
      $a = 0;
      while ($i > 0) {
          $html .=' <div style="width:100%;height:1122px;">
          <!-- set heading of pdf form -->
          <h2 style="text-align: center;margin: auto;">NURSES ORDER SHEET</h2>

          <table width="100%" border="1" style="margin-top:8px;">
            <tr>
              <td class="monitoringTDPadding">
                Treatment<br/>Administered 
              </td>';
             $getPrescription     = $this->db->query("select * from prescriptionNurseWise where babyAdmissionId=".$getBabyData['id']." and FROM_UNIXTIME(addDate,'%d%-%m%-%Y') = '".$date[$a]['addDate']."'")->result_array();
             $getPrescriptionName = $this->db->query("select distinct prescriptionName from prescriptionNurseWise where babyAdmissionId=".$babyId." and FROM_UNIXTIME(addDate,'%d%-%m%-%Y') = '".$date[$a]['addDate']."'")->result_array();

             $getDateWiseQuantity = $this->db->query("SELECT * FROM `prescriptionNurseWise` where babyAdmissionId=".$getBabyData['id']." and FROM_UNIXTIME(addDate,'%d%-%m%-%Y') = '".$date[$a]['addDate']."' order by id asc limit 0,4")->result_array();
            

             for ($x=0; $x < 13; $x++) { 

              $ndae = 'Total<br/>(ml)';
              if($x<=11){
               $ndae = ' Date<br/>'.$date[$a]['addDate'];
              }

               $html .= '<td class="tdOrderSheetCss">'.$ndae.' </td>';

            }


            $html .='</tr>';

              foreach ($getPrescriptionName as $key => $value) {

                  $last_qunt = 0;

                   $getPrescriptionDateWise[]  = $this->db->query("select * from prescriptionNurseWise where babyAdmissionId=".$getBabyData['id']." and FROM_UNIXTIME(addDate,'%d%-%m%-%Y') = '".$date[$a]['addDate']."' and prescriptionName='".$value['prescriptionName']."'")->result_array();
                   $presName = !empty($value['prescriptionName']) ? ' &nbsp;&nbsp;- '.$value['prescriptionName'] : '';
                   $html .='<tr>
                            <td class="sizeofPrescription">'.$presName.'</td>';
                          
                            for ($m=0; $m < 13; $m++) {

                              $time  =  @$getPrescriptionDateWise[$key][$m]['addDate'];
                              $qunt  =  @$getPrescriptionDateWise[$key][$m]['quantity'];
                              $Timing= !empty($time) ? $qunt.' ml<br/>'.date('g:i a',$time) : '';
                              
                              

                               if($m<12){
                                   $last_qunt = $last_qunt+$qunt;
                                   $html .='<td class="tdOrderSheetCss">'.$Timing.'</td>';
                                }else{
                                  $html .='<td class="tdOrderSheetCss">'.$last_qunt.'</td>';
                                }


                              $quantity1 = $quantity1+$qunt;
                            }
                    $html .='</tr>';
                    $last_qunt = 0;
                }

              $html .='<tr>
              <td class="monitoringTDPadding" colspan="13" style="text-align:right;">
              Total Input in 24 Hours(ml)
              </td>
              <td class="tdOrderSheetCss">'.$quantity1.'.00'.'</td>
            </tr>

                                           
          </table>
        </div>';
        $i = $i-1;
        $a++;
        $getPrescriptionDateWise = '';
        $quantity1 = '';
      
     } 
     $html .='</body>
    </html>'; 


        $pdfFilePath = pdfDirectory.$getBabyData['id']."NurseOrderSheet.pdf";
        $mpdf        = new mPDF('utf-8', 'A4-R');
        $PDFContent  = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $mpdf->WriteHTML($PDFContent);
        $mpdf->Output($pdfFilePath, "F"); 
        return $getBabyData['id']."NurseOrderSheet.pdf";
    }

}