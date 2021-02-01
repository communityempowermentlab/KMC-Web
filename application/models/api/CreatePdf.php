<?php
class CreatePdf extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		include_once APPPATH.'/third_party/mpdf/mpdf.php';  
    date_default_timezone_set("Asia/KolKata");
	}

// create treatment OR prescription Pdf
    public function generateTreatmentPrescriptionPdf($babyId,$doctorId)
    {
        error_reporting(0); 
        $getBabyData   = $this->getBabyAdmissionData($babyId);
        $getMotherData = $this->getMotherData($babyId);
        $getDoctorData = $this->getDoctorData($doctorId);

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
              background-color: #D3D3D3;
              padding: 11px 4px 11px 4px !important;
              width:200px;
              text-align:center;
            }.tdClinicalSheetCss{
              padding : 5px 2px 5px 50px;
            }.fontWeightSize{
              font-weight:bold;
            }.tdJustify{
              margin:left: 50px;
            }.investgationMargin{
              margin-left: 10px;
            }.subHeadingFont{
              margin-left: 10px;
              font-size: 13px;
              text-align: justify;
            }
        </style>
    </head>
      <body>';
     $getResult = $this->db->query("select distinct FROM_UNIXTIME(addDate,'%d%-%m%-%Y') as addDate from doctorBabyPrescription where babyAdmissionId=".$getBabyData['id']."");
     $getDateWiseCounting = $getResult->num_rows();
     $dateWiseRecord      = $getResult->result_array();

     foreach ($dateWiseRecord as $key => $val) {
      $getdeliveryDate = $this->getBabyAdmissionData($babyId);
      // calculate days
      $getDaysOfBaby   = $this->calculateDays($getdeliveryDate['deliveryDate'],$val['addDate']);

      $investigateDate = date('Y-m-d',strtotime($val['addDate']));
     	$getweightDate   = $this->db->query("select * from babyDailyWeight where babyAdmissionId=".$getBabyData['id']." and weightDate='".$investigateDate."'")->row_array();

     	$feild['babyWeight'] = !empty($getweightDate['babyWeight']) ? $getweightDate['babyWeight'].' gm' : 'Not Taken';
     	$feild['pndVal']     = $getDaysOfBaby;
      $feild['addDate']    = $val['addDate'];
     	$date[] = $feild;
     }

      $i = $getDateWiseCounting;
      $a = 0;
      while ($i > 0) {
          $html .=' <div style="width:100%;height:1122px;">
              <!-- set heading of pdf form -->
              <h2 style="text-align: center;margin: auto;">CLINICAL CONDITION RECORD</h2>

              <table width="100%" border="1" style="margin-top:8px;">
                <tr>
                  <td class="clinicalTDPadding">
                    <span class="tdContentCss"><b>Clinical Findinds<br/>on Round and<br/>Advise</b></span> 
                  </td>
                  <td class="tdClinicalSheetCss tdJustify">
                   <b class="">Date: </b>'.$date[$a]['addDate'].'<br/>
                   <b class="">Wt: </b>'.$date[$a]['babyWeight'].'<br/>
                   <b class="">PND: </b>'.$date[$a]['pndVal'].'<br/>';
                        $n = $a++; 
                  $date1   = !empty($date[$a]['addDate']) ? $date[$a]['addDate'] : '...............';
                  $weight1 = !empty($date[$a]['babyWeight']) ? $date[$a]['babyWeight'] : '..................';
                  $pnsVal1 = !empty($date[$a]['pndVal']) ? $date[$a]['pndVal'] : '...............';
                  $html .='</td>
                  <td class="tdClinicalSheetCss tdJustify">
                   <b class="">Date: </b>'.$date1.'<br/>
                   <b class="">Wt: </b>'.$weight1.'<br/>
                   <b class="">PND: </b>'.$pnsVal1.'<br/>';
                        $m = $a++; 
                  $html .='</td></tr>';
                  $getInvestigationResult1 = $this->db->query("select * from doctorBabyPrescription where babyAdmissionId=".$getBabyData['id']." and FROM_UNIXTIME(addDate,'%d%-%m%-%Y') = '".$date[$n]['addDate']."'")->result_array();
                  $getInvestigationResult2 = $this->db->query("select * from doctorBabyPrescription where babyAdmissionId=".$getBabyData['id']." and FROM_UNIXTIME(addDate,'%d%-%m%-%Y') = '".$date[$m]['addDate']."'")->result_array();
          
            for ($x=0; $x < 4; $x++) { 
              $investigation1Result = @$getInvestigationResult1[$x]['doctorId'];
              $investigation2Result = @$getInvestigationResult2[$x]['doctorId'];
              $prescriptionData1    = @$getInvestigationResult1[$x]['prescriptionName'];
              $prescriptionData2    = @$getInvestigationResult2[$x]['prescriptionName'];
              $prescriptionComment1 = @$getInvestigationResult1[$x]['comment'];
              $prescriptionComment2 = @$getInvestigationResult2[$x]['comment'];
              $signImgPrescription1 = @$getInvestigationResult1[$x]['roundID'];
              $signImgPrescription2 = @$getInvestigationResult2[$x]['roundID'];
              $times1               = @$getInvestigationResult1[$x]['addDate'];
              $times2               = @$getInvestigationResult2[$x]['addDate'];

              // get doctor name
              $doctor1 = !empty($investigation1Result) ? $this->getDoctorData($investigation1Result) : '';
              $doctor2 = !empty($investigation2Result) ? $this->getDoctorData($investigation2Result) : '';
              
              // set timing
              $time1 = !empty($times1) ? date('g:i A',$times1) : '';
              $time2 = !empty($times2) ? date('g:i A',$times2) : '';



              // get doctor sign
              $signImg1    = !empty($signImgPrescription1) ? $this->getSignImageViaRoundId($signImgPrescription1) : '';
              $signImg2    = !empty($signImgPrescription2) ? $this->getSignImageViaRoundId($signImgPrescription2) : '';
             
              $doctorSign1 = !empty($signImg1['staffSignature']) ? '<img src="'.signDirectoryUrl.$signImg1['staffSignature'].'" style="width:80px;height:60px;margin-top:3px;">' : '';
              $doctorSign2 = !empty($signImg2['staffSignature']) ? '<img src="'.signDirectoryUrl.$signImg2['staffSignature'].'" style="width:80px;height:60px;margin-top:3px;">' : '';
               


              if(!empty($doctor1) && empty($doctor2)){
                $namingOfDoctor = $doctor1['name'];
              }else if(empty($doctor1) && !empty($doctor2)){
                $namingOfDoctor = $doctor2['name'];
              }else if(!empty($doctor1) && !empty($doctor2)){
                $namingOfDoctor = $doctor1['name'].'<br/>'.$doctor2['name'];
              }else if(empty($doctor1) && empty($doctor2)){
                $namingOfDoctor = '';
              }

            // get timing of prescr..
              if(!empty($time1) && empty($time2)) {
                $timingOfPrescription = $time1;
              }else if(empty($time1) && !empty($time2)){
                $timingOfPrescription = $time2;
              }else if(!empty($time1) && !empty($time2)){
                $timingOfPrescription = $time1.' | '.$time2;
              }else if(empty($time1) && empty($time2)){
                $timingOfPrescription = '';
              }

            // get sign of prescr..
              if(!empty($doctorSign1) && empty($doctorSign2)) {
                $signofDoctor = $doctorSign1;
              }else if(empty($doctorSign1) && !empty($doctorSign2)){
                $signofDoctor = $doctorSign2;
              }else if(!empty($doctorSign1) && !empty($doctorSign2)){
                $signofDoctor = $doctorSign1.' '.$doctorSign2;
              }else if(empty($doctorSign1) && empty($doctorSign2)){
                $signofDoctor = '';
              }



             // set prescription data content
              $prescriptionRecord1 = !empty($prescriptionData1) ? '-'.$prescriptionData1 : '';
              $prescriptionRecord2 = !empty($prescriptionData2) ? '-'.$prescriptionData2 : '';


             // set prescription comment
              if(!empty($prescriptionComment1)){
                $presCommentRecord1 = '-'.(strlen($prescriptionComment1) > 100) ? substr($prescriptionComment1,0,100).'...' : $prescriptionComment1;
              }else{
                $presCommentRecord1 = '';
              }

              if(!empty($prescriptionComment2)){
                $presCommentRecord2 = '-'.(strlen($prescriptionComment2) > 100) ? substr($prescriptionComment2,0,100).'...' : $prescriptionComment2;
              }else{
                $presCommentRecord2 = '';
              }

                $html .='<tr>
                  <td class="clinicalTDPadding" style="width:25%;">
                     <b>Doctors Name</b><br/>
                    '.$namingOfDoctor.'<br/>
                    <b>Time</b><br/>
                    '.$timingOfPrescription.'<br/>
                    <b>Signature</b><br/>
                    '.$signofDoctor.'
                  </td>

                  <td class="investgationMargin" valign="top" style="width:35%;">'.' '.$prescriptionRecord1.'<br>
                     <p class="subHeadingFont">'.$presCommentRecord1.'</p></td>
                  <td class="investgationMargin" valign="top" style="width:35%;">'.' '.$prescriptionRecord2.'<br>
                     <p class="subHeadingFont">'.$presCommentRecord2.'</p></td>

                  </tr>'; 
              }  
                                         
              $html .='</table>
              <div style="text-align:center;margin-top:10px;font-weight:bold;font-size:12px;">This Sheet has to be filled by Doctor on Duty</div>
            </div>';
        $i = $i-2;
     } 
     $html .='</body>
    </html>'; 

        $pdfFilePath = pdfDirectory.$getBabyData['id']."prescriptionSheet.pdf";
        $mpdf        = new mPDF('utf-8', 'A4-R');
        $PDFContent  = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $mpdf->WriteHTML($PDFContent);
        $mpdf->Output($pdfFilePath, "F"); 
        return $getBabyData['id']."prescriptionSheet.pdf";
    }


// +++++++++++########################################################
// +++++++++++########################################################
// +++++++++++########################################################
     #create Investigation Pdf
// +++++++++++########################################################
// +++++++++++########################################################
// +++++++++++########################################################


    public function generateTreatmentInvestigationPdf($babyId,$doctorId)
    {
        error_reporting(0); 
        $getBabyData   = $this->getBabyAdmissionData($babyId);
        $getMotherData = $this->getMotherData($babyId);
        $getDoctorData = $this->getDoctorData($doctorId);


        $html.= '<html>
       <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style type="text/css">
            .treatmentHeadingFont{
              font-size:15px;
              padding: 4px 0px 4px 0px !important;
            }table {
                border-collapse: collapse;
              }
            .clinicalTDPadding{
              background-color: #D3D3D3;
              padding: 11px 4px 11px 4px !important;
              width:200px;
              text-align:center;
            }.tdClinicalSheetCss{
              padding : 5px 2px 5px 50px;
            }.fontWeightSize{
              font-weight:bold;
            }.tdJustify{
              margin:left: 50px;
            }.investgationMargin{
              margin-left: 10px;
            }.headingFont{
              font-size: 14px;
            }.subHeadingFont{
              margin-left: 10px;
              font-size: 13px;
              text-align: justify;
            }
        </style>
    </head>
      <body>';
     $getResult = $this->db->query("select distinct FROM_UNIXTIME(addDate,'%d%-%m%-%Y') as addDate from investigation where babyAdmissionId=".$getBabyData['id']."");
     $getDateWiseCounting = $getResult->num_rows();
     $dateWiseRecord      = $getResult->result_array();

     foreach ($dateWiseRecord as $key => $val) {
      $getdeliveryDate = $this->getBabyAdmissionData($babyId);
      // calculate days
      $getDaysOfBaby   = $this->calculateDays($getdeliveryDate['deliveryDate'],$val['addDate']);

      $investigateDate = date('Y-m-d',strtotime($val['addDate']));
      $getweightDate   = $this->db->query("select * from babyDailyWeight where babyAdmissionId=".$getBabyData['id']." and weightDate='".$investigateDate."' order by id desc")->row_array();

      $feild['babyWeight'] = !empty($getweightDate['babyWeight']) ? $getweightDate['babyWeight'].' gm' : 'N/A';
      $feild['pndVal']    = $getDaysOfBaby;
      $feild['addDate']    = $val['addDate'];
      $date[] = $feild;
     }

      $i = $getDateWiseCounting;
      $a = 0;
      while ($i > 0){
         // $weightDate = !empty($date[$a]['babyWeight']) ? $date[$a]['babyWeight'].' gm' : 'N/A';
            $html .='<div style="width:100%;height:1122px;">
                <!-- set heading of pdf form -->
                <h2 style="text-align: center;margin: auto;">TREATMENT CONTINUATION SHEET</h2>
                  <table width="100%" style="margin-top:8px;">
                    <tr>
                      <td style="width: 60%;" class="treatmentHeadingFont">
                        <span class="fontWeightSize">SNCU Reg. No: </span>'.$getBabyData['temporaryFileId'].'
                      </td>
                      <td style="width: 40%;" class="treatmentHeadingFont">
                        <span class="fontWeightSize">Date of Admission: </span>'.date("d-m-Y",$getBabyData['admissionDate']).'
                      </td>
                    </tr>

                      <tr>
                        <td style="width: 60%;" class="treatmentHeadingFont">
                          <span class="fontWeightSize">Baby of (Mother'."'".'s name): </span>'.$getMotherData['motherName'].'
                        <td style="width: 40%;" class="treatmentHeadingFont">
                          <span class="fontWeightSize">Sex: </span>'.$getBabyData['babyGender'].'
                        </td>
                      </tr>

                    <tr>
                      <td style="width: 60%;" class="treatmentHeadingFont">
                        <span class="fontWeightSize">Birth Weight: </span>'.$getBabyData['babyWeight'].' gm
                      </td>
                      <td style="width: 40%;" class="treatmentHeadingFont">
                        <span class="fontWeightSize">Doctor Incharge: </span>'.$getDoctorData['Name'].'
                      </td>
                    </tr>
                  </table>

                <table width="100%" border="1" style="margin-top:8px;">
                  <tr>
                    <td class="clinicalTDPadding">
                      <span class="tdContentCss"></span> 
                    </td>
                    <td class="tdClinicalSheetCss tdJustify">
                     <b class="">Date: </b>'.$date[$a]['addDate'].'<br/>
                     <b class="">Wt: </b>'.$date[$a]['babyWeight'].'<br/>
                     <b class="">PND: </b>'.$date[$a]['pndVal'].'<br/>';

                    $n       = $a++; 
                    $date1   = !empty($date[$a]['addDate']) ? $date[$a]['addDate'] : '...............';
                    $weight1 = !empty($date[$a]['babyWeight']) ? $date[$a]['babyWeight'] : '..................';
                    $pnsVal1 = !empty($date[$a]['pndVal']) ? $date[$a]['pndVal'] : '...............';
                   
                    $html .='</td>
                    <td class="tdClinicalSheetCss tdJustify">
                     <b class="">Date: </b>'.$date1.'<br/>
                     <b class="">Wt: </b>'.$weight1.'<br/>
                     <b class="">PND: </b>'.$pnsVal1.'<br/>';
                          $m = $a++; 
                    $html .='</td>
                  </tr>

                  <tr>
                    <td class="clinicalTDPadding">
                    <br/><b>Oxygen and Other</b><br/>
                    <b>Supportive Care</b><br/>

                    </td>
                    <td></td>
                    <td></td>
                  </tr>  

                  <tr>
                    <td class="clinicalTDPadding">
                       <br/><b>I/V Drugs</b><br/><br/>
                    </td>
                    <td></td>
                    <td></td>
                  </tr> 

                  <tr>
                    <td class="clinicalTDPadding">
                       <br/><b>I/V Fluids</b><br/><br/>
                    </td>
                    <td></td>
                    <td></td>
                  </tr> 

                  <tr>
                    <td class="clinicalTDPadding">
                    <br/><b>Oral Drugs</b><br/>
                    <b>and Feeding</b><br/>

                    </td>
                    <td></td>
                    <td></td>
                  </tr> 

                  <tr>
                    <td class="clinicalTDPadding" style="width:30%">
                    <br/><b>Investigations</b><br/>
                    <b>Advised</b><br/>

                    </td>
                    <td class="investgationMargin" style="width:35%" valign="top"><ol>';
                    $getInvestigationResult = $this->db->query("select * from investigation where babyAdmissionId=".$getBabyData['id']." and FROM_UNIXTIME(addDate,'%d%-%m%-%Y') = '".$date[$n]['addDate']."'")->result_array();
                    
                     foreach ($getInvestigationResult as $key => $value) {
                      if(!empty($value['doctorComment'])){
                        $comment  = (strlen($value['doctorComment']) > 100) ? substr($value['doctorComment'],0,100).'...' : $value['doctorComment'];
                      }else{
                        $comment = 'N/A';
                      }
                       $html .='<li>'.$value['investigationName'].'<br>
                       <p class="subHeadingFont">- '.$comment.'</p>
                       </li>';
                     }
                    $html .='</ol></td><td class="investgationMargin" style="width:35%" valign="top"><ol>';


                     $getInvestigationResult = $this->db->query("select * from investigation where babyAdmissionId=".$getBabyData['id']." and FROM_UNIXTIME(addDate,'%d%-%m%-%Y') = '".$date[$m]['addDate']."'")->result_array();
                     foreach ($getInvestigationResult as $key => $value) {
                      if(!empty($value['doctorComment'])){
                        $comment  = (strlen($value['doctorComment']) > 100) ? substr($value['doctorComment'],0,100).'...' : $value['doctorComment'];
                      }else{
                        $comment = '';
                      }
                       $html .='<li>'.$value['investigationName'].'<br>
                       <p class="subHeadingFont">- '.$comment.'</p>
                       </li>';
                     }
                    $html .='</ol></td>
                  </tr> 

                  <tr>
                    <td class="clinicalTDPadding">
                    <br/><b>Planning for</b><br/>
                    <b>Next Day</b><br/>

                    </td>
                    <td></td>
                    <td></td>
                  </tr> 
                                     
                </table>
                <div style="text-align:center;margin-top:10px;font-weight:bold;font-size:12px;">This Sheet has to be filled by Doctor Incharge of Patient</div>
              </div>';
        $i = $i-2;
     } 
     $html .='</body>
    </html>'; 

        $pdfFilePath = pdfDirectory.$getBabyData['id']."investigationSheet.pdf";
        $mpdf        = new mPDF('utf-8', 'A4-R');
        $PDFContent  = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $mpdf->WriteHTML($PDFContent);
        $mpdf->Output($pdfFilePath, "F"); 
        return $getBabyData['id']."investigationSheet.pdf";
    }

 //baby Data receive here
	public function getBabyAdmissionData($babyId){
		return $this->db->query("SELECT *,ba.`addDate` as admissionDate FROM babyRegistration as br INNER JOIN babyAdmission as ba on ba.`babyId`=br.`babyId` where br.`babyId`=".$babyId." order by ba.`id` desc")->row_array();
	}

 //mother Data receive here
	public function getMotherData($babyId){
		return $this->db->query("SELECT * FROM motherRegistration as mr INNER JOIN babyRegistration as br on mr.`motherId`=br.`motherId` where br.`babyId`=".$babyId."")->row_array();
	}

 //Staff Data receive here
	public function getDoctorData($doctorId){
		return $this->db->query("SELECT * FROM staffMaster where staffId=".$doctorId."")->row_array();
	}

   //Prescription Data via id
  public function getSignImageViaRoundId($id){
    return $this->db->query("SELECT * FROM doctorRound where id=".$id."")->row_array();
  }

  //calculate Days receive here
  public function calculateDays($startDate,$endDate){
    $date1 = date_create($startDate);
    $date2 = date_create($endDate);
    $diff  = date_diff($date1,$date2);
    return $diff->format("%a days");
  } 

}