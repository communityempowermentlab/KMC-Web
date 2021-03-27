<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BabyDischargePdf extends CI_Model {
  public function __construct()
    {
        parent::__construct();         
        $this->load->library('m_pdf');  
        $this->load->model('api/BabyAdmissionPDF'); 
        $this->load->model('api/BabyWeightPDF');
        $this->load->model('api/BabyKmcPDF'); 
        $this->load->model('api/BabyFeedingPDF');
        $this->load->model('api/BabyDischargePdf');  
    }
    public function FinalpdfGenerate($id)
    { 
          $babyAdmisionLastId = $this->db->get_where('babyAdmission',array('id'=>$id))->row_array();
          $LoungeID = $babyAdmisionLastId['loungeId'];
          $PdfName = $this->finalPdfDischargeTime($LoungeID,$id);
          $this->db->where('id',$id);     
          $res = $this->db->update('babyAdmission',array('babyDischargePdfName'=>$PdfName));
          return $res;
           
    }


    public function GetMotherAllData($MotherID)
    {
      return $this->db->query("SELECT *,MR.guardianName as guardianNameAdmission FROM motherRegistration AS MR LEFT JOIN motherAdmission AS MA ON MR.`motherId` = MA.`motherId`  WHERE MR.`motherId` = '".$MotherID."'")->row_array();
    }


    public function GetBabyAllData($BabyAdmissionID)
    {   
      return $this->db->query("SELECT *,BA.`addDate` as AddDate FROM  babyRegistration AS BR LEFT JOIN babyAdmission AS BA ON BR.`babyId` = BA.`babyId`  WHERE BA.`id` = '".$BabyAdmissionID."'")->row_array();
    }

     public function DistrictVillageBlock($id, $type='')
     {

      if($type=='1'){
      $query= $this->db->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs`     where `revenuevillagewithblcoksandsubdistandgs`.`GPPRICode`= '".$id."' limit 0,1")->row_array();
      return $query['GPNameProperCase'];
      }elseif($type=='2'){
        $query= $this->db->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs`  
          where `revenuevillagewithblcoksandsubdistandgs`.`BlockPRICode`= '".$id."' limit 0,1")->row_array();
      return $query['BlockPRINameProperCase'];
      }elseif($type=='3'){
        $query= $this->db->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs`  
          where `revenuevillagewithblcoksandsubdistandgs`.`PRIDistrictCode`= '".$id."' limit 0,1")->row_array();
      return $query['DistrictNameProperCase'];
      }
       
     }


    public function TestDate($date1)
    {
      $now = time(); 
      $your_date = strtotime($date1);
      $datediff = $now - $your_date;
      return round($datediff / (60 * 60 * 24));
    }


    function GetDateDiff($deliveryDate,$lmpDate)
    {

        $datediff = $deliveryDate - $lmpDate;
        return  round(($datediff / (60 * 60 * 24))/7);
    }
       

    public function finalPdfDischargeTime($LoungeID,$lastID,$Type=''){
      error_reporting(0);
      $filename = "b_".$lastID."_final-Discharge.pdf";

      $getlastAdmissiondata = $this->db->get_where('babyAdmission',array('id'=>$lastID))->row_array();
      // get baby reg data
      $getMotherId = $this->db->get_where('babyRegistration',array('babyId'=>$getlastAdmissiondata['babyId']))->row_array();      
      $MotherData  = $this->GetMotherAllData($getMotherId['motherId']);
      $BabyData    = $this->GetBabyAllData($getlastAdmissiondata['id']);


      if($MotherData['motherLmpDate']!=NULL){
        $gestationAge = $this->GetDateDifference(strtotime($BabyData['deliveryDate']),strtotime($MotherData['motherLmpDate']));
        $weekPlural = ($gestationAge > 1) ? 'Weeks' : 'Week';
        if($gestationAge == '0'){
          $GestationalAge = 'UNKNOWN';
          $birthTerm = 'N/A';
        } else {
          $GestationalAge = $gestationAge.' '.$weekPlural; 
          if($GestationalAge < 38.6){
            $birthTerm = 'Preterm';
          } else {
            $birthTerm = 'Full Term';
          }
        }
      } else {
        $GestationalAge = 'UNKNOWN';
        $birthTerm = 'N/A'; 
      }

      
      
         
      $getFirstAseessmentbabyData = $this->db->get_where('admissionCheckList',array('motherAdmissionId'=>$MotherData['motherId']))->row_array();
      //$getHospitalInMA=$this->db->get_where('mother_admission',array('MotherID'=>$MotherData['MotherID']))->row_array();
      $GR_NAME=  ($MotherData['guardianName']!='') ?  $MotherData['guardianName'] :'  ____________________________________________________';
      $GR_Relation=  ($MotherData['guardianRelation']!='') ?  $MotherData['guardianRelation'] :'___________________';
      $MCTS = ($MotherData['motherMCTSNumber']!=NULL)?  ' '.$MotherData['motherMCTSNumber']: ' --';

      $District_Name =  $this->DistrictVillageBlock($MotherData['presentDistrictName'], 3) ;
      $Dname   = ($District_Name!='') ? $District_Name : '';
      $State   = ($MotherData['presentState']!='') ? $MotherData['presentState'] : '';
      $Country = ($MotherData['presentCountry']!='') ? $MotherData['presentCountry'] : '';


      $Block_Name =  $this->DistrictVillageBlock($MotherData['presentBlockName'], 2) ;
      $Bname = ($MotherData['presentBlockName']!='') ? $MotherData['presentBlockName'] : '';

      $Village_Name =  $this->DistrictVillageBlock($MotherData['presentVillageName'], 1) ;
      $Vname = ($Village_Name!='') ? $Village_Name: '_________________________________';

      $date = date('d/m/Y', strtotime($BabyData['addDate'])); 
      $time = date('h:i A', strtotime($BabyData['addDate']));
      $BirthWeigth= ($BabyData['babyWeight']!='') ? $BabyData['babyWeight'].' grams' :'';

        $AdmissionBirthWeigth = ($getlastAdmissiondata['babyAdmissionWeight']!='') ? $getlastAdmissiondata['babyAdmissionWeight'].' grams' :'';
        $MotherDeliveryPlace = (($MotherData['facilityId']=='0') || ($MotherData['facilityId']=='')) ? ucwords($MotherData['deliveryPlace']) : 'Hospital';
        $FacilityName = ($MotherData['facilityId']!='0' && $MotherData['facilityId']!=NULL) ? $this->singlerowparameter('FacilityName','facilityId',$MotherData['facilityId'],'facilitylist') : 'Other';

      $RuralUrban = ($MotherData['presentResidenceType']!='') ? " ". $MotherData['presentResidenceType'] :  '  _______________  ';
      $Pincode  = ($MotherData['presentPinCode']!='') ? " ".$MotherData['presentPinCode'] :  '  _______________  ';

      $NearBy   = ($MotherData['presentAddNearByLocation']!='') ? " ".$MotherData['presentAddNearByLocation'] :  '  _______________  ';
      $Address  = ($MotherData['presentAddress']!='') ? " ".$MotherData['presentAddress'] :  '  _______________  ';
      $AshaName = ($MotherData['ashaName']!='') ? " ".$MotherData['ashaName'] :  '  _______________  ';
      $AshaNumber = ($MotherData['ashaNumber']!='') ? " ".$MotherData['ashaNumber'] :  '  _______________  ';
      $Signatures = signDirectoryUrl.$getFirstAseessmentbabyData['nurseDigitalSign'];
      $NurseSign  = ($MotherData['staffId']!='') ? $this->singlerowparameter('name','staffId',$MotherData['staffId'],'staffMaster').'<br> '. date('d/m/Y h:i A').'<br>' : ' __________________________________________________';
      $MotherNo   = ($MotherData['motherMobileNumber']!='') ? $MotherData['motherMobileNumber'] : '____________________________________________________';

      $FatherNo = ($MotherData['fatherMobileNumber']!='') ? $MotherData['fatherMobileNumber'] : '____________________________________________________';
      $Father = ($MotherData['fatherMobileNumber']!='') ? 'Father' : ' __________________';
      $Mother = ($MotherData['motherMobileNumber']!='') ? 'Mother' : ' __________________';

      if($MotherData['motherName']!=''){
          $MotherName = ($MotherData['motherName']!='') ? ucwords($MotherData['motherName']) :'__________________';
      }elseif($MotherData['motherName']==NULL && $MotherData['guardianName']==NULL ){
        $MotherName  = '__________________';
        
      }elseif($MotherData['type']=='2'){
        $MotherName   =  'Unknown';
        $MotherName2  =  ($MotherData['motherName']==NULL) ? '__________________': $MotherData['MotherName'];
        $GR_Relation  =  'Unknown'; 
      }

       if($MotherData['type']=='3' || $MotherData['type']=='1' ){
          $MotherName   =  $MotherData['motherName'];
          $MotherName2   =  ($MotherName!='Unknown') ? $MotherName :'';
       }else{
          $MotherName    =  'Unknown';
          $MotherName2   =  ($MotherName=='Unknown') ? '__________________':'';
       }

      $FatherName = ($MotherData['fatherName']!='') ? ucwords($MotherData['fatherName']) :'__________________';

        if($MotherData['guardianName']==NULL  && $MotherData['guardianName']==NULL){
          if($GR_Relation=='Father'){

            $GR_NAME = $FatherName;
          }else{
            $GR_NAME = $MotherData['motherName']; 
          }


        }else{

          $GR_NAME = ($MotherData['guardianName']!='') ?  $MotherData['guardianName'] :'  _________________________________________________';

        }
      $motherName00  =  ($MotherData['motherName']!='') ? ucwords($MotherData['motherName']) :'_____________________';
      $fatherName00  =  ($MotherData['fatherName']!='') ? ucwords($MotherData['fatherName']) :'_____________________';  
      $OrganisationName = ($MotherData['organisationName']!='') ? $MotherData['organisationName'] :"_____________________";
      $OrganisationAddress = ($MotherData['organisationAddress']!='') ? $MotherData['organisationAddress'] :"______________________";
      $OrganisationNumber = ($MotherData['organisationNumber']!='') ? $MotherData['organisationNumber'] :"______________________";
      $LMPDate = ($MotherData['motherLmpDate']!=NULL) ? date('d/m/Y', strtotime($MotherData['motherLmpDate'])) : '_____________________';
      
        //echo $this->db->last_query();

      // get baby weight html
      $admissionHtmlData = $this->BabyAdmissionPDF->pdfconventer($MotherData,$BabyData,'',$lastID);
      $nutritionHtmlData = $this->BabyFeedingPDF->BabyDailyFeedPDFFile($getlastAdmissiondata['loungeId'],$getlastAdmissiondata['babyId'],$lastID);
      $kmcHtmlData = $this->BabyKmcPDF->BabySkinToSkinPdfFile($getlastAdmissiondata['loungeId'],$getlastAdmissiondata['babyId'],$lastID);
      $weightHtmlData = $this->BabyWeightPDF->BabyWeightPdfFile($getlastAdmissiondata['loungeId'],$getlastAdmissiondata['babyId'],$lastID);
      
      
      $html.= '<!DOCTYPE html>
      <html>
      <head>
        <style>
        table,th,td,tr{
          border-collapse:collapse;
        }
        td{
          padding: 13px;
        }
      </style>
      </head>
      <body>';
    
    // ******************* Start Admission pdf *****************//
    $html.= $admissionHtmlData['content'];
    $html.='<div style="height:3%;"></div>';
    $html.= "<pagebreak />";
    // ******************* End Admission pdf *******************//

    // ******************* Start Nutrition pdf *****************//
    $html.= $nutritionHtmlData['content'];
    $html.='<div style="height:3%;"></div>';
    $html.= "<pagebreak />";
    // ******************* End Nutrition pdf *******************//

    // ******************* Start KMC pdf ***********************//
    $html.= $kmcHtmlData['content'];
    $html.='<div style="height:3%;"></div>';
    $html.= "<pagebreak />";
    // ******************* End KMC pdf *************************//

    // ******************* Start weight pdf ********************//
    $html.= $weightHtmlData['content'];
    $html.='<div style="height:3%;"></div>';
    $html.= "<pagebreak />";
    // ******************* End weight pdf **********************//
    
// ******************* Start Daily Discharge time pdf *******************//

        if($Type == 1)
        {
             $GetData = $this->db->query("SELECT * from  motherRegistration as MR LEFT JOIN motherAdmission as MA On BA.`motherId` = MR.`motherId`  Where Mr.`motherId` = '".$getMotherId['motherId']."' order by MA.`id` Desc ")->row_array();
             $Hospitalreg = $GetData['hospitalRegistrationNumber'];
             $MCTSNo = $GetData['hospitalRegistrationNumber'];
             $DischargeDate = ($GetData['dateOfDischarge'] != '') ? date('d/m/Y',strtotime($GetData['dateOfDischarge'])) : 'N/A';
             $Day = '________';
             $WeigthOnDischarge = '_______________________';
        }else{
            $GetData = $this->db->query("SELECT * from motherRegistration as MR LEFT JOIN babyRegistration as BR On BR.`motherId` = MR.`motherId` LEFT JOIN babyAdmission as BA On BR.`babyId` = BA.`babyId` Where BA.`babyId` = '".$getlastAdmissiondata['babyId']."' order by BA.`id` Desc ")->row_array(); 
            $Hospitalreg = $GetData['babyFileId'];
            $MCTSNo      = $GetData['babyMCTSNumber'];

            $Day = $this->GetDateDiffFromNow($GetData['addDate']);
            $WeigthOnDischarge = ($GetData['babyDischargeWeight'] != '') ? $GetData['babyDischargeWeight'].' grams' : 'N/A';

            $NetGain = $WeigthOnDischarge - $GetData['babyWeight'];  
            $reffered = $GetData['referredFacilityName']." ".$GetData['referredFacilityAddress'];
            $refferedReson = ($GetData['referredReason']!='') ? $GetData['referredReason'] :'_________________________';

            $DischargeDate    = ($GetData['dateOfDischarge'] != '') ? date('d/m/Y',strtotime($GetData['dateOfDischarge'])) : 'N/A';
            $dischargeWeightsGainOrLoss = ($GetData['babyDischargeWeight'] != '') ? $GetData['weightGainLosePostAdmission'] : 'N/A';

            $discharge = json_decode($GetData['dischargeChecklist'],true);
            foreach ($discharge as $key => $value) {
           
              }
        }
        
        $html.='<div>
                <h3 style= "text-align:  center"> <u>DISCHARGE CHECKLIST FOR KMC UNIT</u> </h3>
                </div>

                <div  style="padding-bottom: 2px; padding-top: 2px">
                  
                  <label style="padding-right: 10%"> <b>Hospital Reg. No.:</b>  '. $Hospitalreg.'</label> 
                  <label style=" padding-left: 10%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>MCTS NO.</b>: '.$MCTS.'</label>
                  </div>
                  <br> 

                <div  style="padding-bottom: 2px; padding-top: 2px">
                  <label style="width: 40%; padding-right: 10%"> <b>Name of Mother:</b> '. $GetData['motherName'].'</label> 
                  <label style="width: 40%; padding-left: 10%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Date of Discharge :</b>'.$DischargeDate.'</label>
                </div>
                  <br> 

                <div>
                <div  style="padding-bottom: 2px; padding-top: 2px">
                  
                  <label><b>Number of days spend in KMC room (excluding days spent in SNCU/ NBSU):</b>  '.$Day.' days</label> 
                  <br>
                  <label> <b>Weight on Discharge(in grams):</b>  '.$WeigthOnDischarge.'</label>
                  </div>
                  <br> 
                </div>

                <div>
                <div  style="padding-bottom: 2px; padding-top: 2px"> 
                  <label ><b>Net weight gain/loss since admission(in grams):</b>  '.$dischargeWeightsGainOrLoss.' </label> 
                </div>
             <br> 
                </div>

                 <div  style="padding-bottom: 2px; padding-top: 2px">
                  
                  <label ><b>Type of Discharge :</b>  '.$GetData['typeOfDischarge'].'</label> 
                 
                  </div>
                  <br> 

                <div  style="padding-bottom: 2px; padding-top: 2px">
                  <h4><u>In case of referral</u> </h4>             
                  <label ><b>Name and address of facility reffered to:</b> '.$reffered.'</label> 
                </div>
                  <br> 
                <label ><b>Reason for Referral:</b> '.$refferedReson.'</label> 
                  <br> 
            
             <div>



               <div>

                  <div style="padding-bottom: 2px; padding-top: 2px">';
                        $discharge = json_decode($GetData['dischargeChecklist'],true);
                        $count = 1;
                        foreach ($discharge as $key => $value) {
                          $html.='</span><p><b>'.$count++.'.</b> '.$value['name'].'</p>';
                        }
                  $html.=' </div>
                  <div style="width:100%;">
                             <div style="float:left;width:50%;">
                               <p>________________________</p>
                                <p style="">Signature of Nurse/Doctor</p>
                              </div>

                             <div style="width:50%;">
                               <p style="margin-left:125px;">________________________</p>
                                <p style="margin-left:125px;">Signature of Family Member</p>
                              </div>                   
                      </div>
                    </div>
                   <div>';
          $html.= '</div></body></html>';

          $pdfFilePath =  pdfDirectory.$filename;

          $this->m_pdf->pdf->autoScriptToLang = true;
          $this->m_pdf->pdf->baseScript = 1;
          $this->m_pdf->pdf->autoVietnamese = true;
          $this->m_pdf->pdf->autoArabic = true;
          $this->m_pdf->pdf->autoLangToFont = true;
          $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
          $this->m_pdf->pdf->WriteHTML($PDFContent);
          $this->m_pdf->pdf->Output($pdfFilePath, "F");
 
          return $filename;     
    }

    function singlerowparameter($select,$matchWith,$matchingId,$table)
   {
        $tableRecord = & get_instance();
        $tableRecord->load->database();     
        $tableRecord->db->select($select);  
        $query = $tableRecord->db->get_where($table,array($matchWith => $matchingId))->row_array();   
        return $query[$select];       
   }

   function GetDateDiffFromNow($Date)
    {  
        $now = date('Y-m-d H:i:s'); 
        $datediff = strtotime($now) - strtotime($Date); 
        return round($datediff/(60 * 60 * 24));
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

    function GetDateDifference($deliveryDate,$lmpDate)
    {

      $datediff = $deliveryDate - $lmpDate;
      return  round(($datediff / (60 * 60 * 24))/7);
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