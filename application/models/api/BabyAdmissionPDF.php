<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class BabyAdmissionPDF extends CI_Model {
  public function __construct()
    {
        parent::__construct();         
        include_once APPPATH.'/third_party/mpdf/mpdf.php';    
        $this->load->model('DangerSignModel'); 
    }
    public function pdfGenerate($id)
    { 
      $babyAdmisionLastId = $this->db->get_where('babyAdmission',array('id'=>$id))->row_array();
      $getMotherId = $this->db->get_where('babyRegistration',array('babyId'=>$babyAdmisionLastId['babyId']))->row_array();

      $fileName = "b_".$babyAdmisionLastId['id'].".pdf";
      $GetMotherAllData = $this->GetMotherAllData($getMotherId['motherId']);
      $GetBabyAllData   = $this->GetBabyAllData($babyAdmisionLastId['id']);

      $pdfHtml = $this->pdfconventer($GetMotherAllData,$GetBabyAllData,$fileName,$babyAdmisionLastId['id']);
      // create pdf file
      if(isset($pdfHtml['htmlData']) && !empty($pdfHtml['htmlData'])){
        $PdfName = $this->createBabyAdmissionPdfFile($pdfHtml['htmlData'],$id);
      }

      $this->db->where('id',$babyAdmisionLastId['id']);
      $this->db->update('babyAdmission', array('babyPdfFileName'=>$PdfName));


      // $PdfName = $this->BabyWeightPdfFile($babyAdmisionLastId['loungeId'],$babyAdmisionLastId['babyId'],$babyAdmisionLastId['id']);
      // $this->db->where('id',$babyAdmisionLastId['id']);
      // $res = $this->db->update('babyAdmission',array('babyWeightPdfName'=>$PdfName));
      return $res;

    }

    public function generateAllAdmissionPDF($startDate,$endDate,$LoungeID)
    {

      $query = $this->db->query("select ba.*,ba.`status` as StatusDis from babyAdmission as ba inner join babyRegistration as br on ba.`babyId`= br.`babyId` where ba.`loungeId`=".$LoungeID." and  ba.`addDate` between ".$startDate." and ".$endDate."")->result_array();
      foreach ($query as $key => $value) {

       
        $fileName = "b_".$value['id'].".pdf";
        $GetMotherAllData = $this->GetMotherAllData($value['motherId']);
        $GetBabyAllData   = $this->GetBabyAllData($value['id']);
        $PdfFile = $this->pdfconventer($GetMotherAllData,$GetBabyAllData,$fileName,$value['id']);

        $this->db->where('id',$value['id']);
        $this->db->update('babyAdmission', array('babyPdfFileName'=>$PdfFile));


        $PdfName = $this->BabyWeightPdfFile($value['loungeId'],$value['babyId'],$value['id']);
        $this->db->where('id',$value['id']);
        $res = $this->db->update('babyAdmission',array('babyWeightPdfName'=>$PdfName));

      }

      $this->session->set_flashdata('activate', getCustomAlert('S','PDF Generate Successfully'));
      redirect('Admin/downloadReports');
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
        $query= $this->db->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs` where `revenuevillagewithblcoksandsubdistandgs`.`GPPRICode`= '".$id."' limit 0,1")->row_array();
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

    // create Baby admission pdf file
    public function createBabyAdmissionPdfFile($html,$admissionId){

      $pdfFilePath =  pdfDirectory."b_".$admissionId.".pdf";

      $this->m_pdf->pdf->autoScriptToLang = true;
      $this->m_pdf->pdf->baseScript = 1;
      $this->m_pdf->pdf->autoVietnamese = true;
      $this->m_pdf->pdf->autoArabic = true;
      $this->m_pdf->pdf->autoLangToFont = true;
      $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
      if(!empty($PDFContent)){
        $this->m_pdf->pdf->WriteHTML($PDFContent);
        $this->m_pdf->pdf->Output($pdfFilePath, "F"); 
      }
      
      return "b_".$admissionId.".pdf";
    }

    public function pdfconventer($MotherData, $BabyData,$filename ='',$id)
    {   
        error_reporting(0);
        if($MotherData['motherLmpDate']!=NULL){
        $gestationAge = $this->GetDateDifference(strtotime($BabyData['deliveryDate']),strtotime($MotherData['motherLmpDate']));
        $weekPlural = ($gestationAge > 1) ? 'Weeks' : 'Week';
        if($gestationAge == '0'){
          $birthTerm = 'N/A';
        } else {
          $GestationalAge = $gestationAge; 
          if($GestationalAge < 38.6){
            $birthTerm = 'Preterm';
          } else {
            $birthTerm = 'Full Term';
          }
        }
      } else {
        $birthTerm = 'N/A'; 
      }

        if(!empty($BabyData['gestationalAge'])){
          $GestationalAge = $BabyData['gestationalAge'];
        }else{
          $GestationalAge = '___________________';
        }

        $getFirstbabyData = $this->db->get_where('babyAdmission',array('id'=>$id))->row_array();
        $getFirstAseessmentbabyData = $this->db->get_where('admissionCheckList',array('babyAdmissionId'=>$id))->row_array();

        //$getHospitalInMA=$this->db->get_where('mother_admission',array('MotherID'=>$MotherData['MotherID']))->row_array();
        $GR_NAME=  ($MotherData['guardianName']!='') ?  $MotherData['guardianName'] :'  ____________________________________________________';
        $GR_Relation=  ($MotherData['guardianRelation']!='') ?  $MotherData['guardianRelation'] :'___________________';
        $MCTS = ($MotherData['motherMCTSNumber']!=NULL)?  ' '.$MotherData['motherMCTSNumber']: ' --';
        
        $District_Name =  $this->DistrictVillageBlock($MotherData['permanentDistrictName'], 3) ;
        $Dname = ($District_Name!='') ? $District_Name : '';
        $State = ($MotherData['permanentState']!='') ? $MotherData['permanentState'] : '';
        $Country = ($MotherData['permanentCountry']!='') ? $MotherData['permanentCountry'] : '';
        

        $Block_Name =  $this->DistrictVillageBlock($MotherData['presentBlockName'], 2) ;
        $Bname = ($MotherData['presentBlockName']!='') ? $MotherData['presentBlockName'] : '';

        $Village_Name =  $this->DistrictVillageBlock($MotherData['permanentVillageName'], 1) ;
        $Vname = ($Village_Name!='') ? $Village_Name: '_________________________________';

        $date = date('d/m/Y', strtotime($BabyData['addDate'])); 
        $time = date('h:i A', strtotime($BabyData['addDate']));
        $BirthWeigth= ($BabyData['babyWeight']!='') ? $BabyData['babyWeight'].' grams' :'';

        $AdmissionBirthWeigth = ($getFirstbabyData['babyAdmissionWeight']!='') ? $getFirstbabyData['babyAdmissionWeight'].' grams' :'';


        if(($BabyData['infantComingFrom'] == 'Other') || ($BabyData['infantComingFrom'] == 'अन्य')){ 
          $MotherDeliveryPlace = $BabyData['infantComingFromOther']; 
        }
        else
        { 
          $MotherDeliveryPlace = $BabyData['infantComingFrom']; 
        }

        if($BabyData['typeOfBorn'] == 'Inborn'){ 
          $getBabyLounge = $this->singlerowparameter('facilityId','loungeId',$BabyData['loungeId'],'loungeMaster');
          $FacilityName = $this->singlerowparameter('FacilityName','FacilityID',$getBabyLounge,'facilitylist');
        }
        else
        { 
          $FacilityName = "-";
        }


        $RuralUrban = ($MotherData['permanentResidenceType']!='') ? " ". $MotherData['permanentResidenceType'] :  '  _______________  ';
        $Pincode    = ($MotherData['permanentPinCode']!='') ? " ".$MotherData['permanentPinCode'] :  '  _______________  ';

        $NearBy     = ($MotherData['permanentAddNearByLocation']!='') ? " ".$MotherData['permanentAddNearByLocation'] :  '  _______________  ';
        $Address    = ($MotherData['permanentAddress']!='') ? " ".$MotherData['permanentAddress'] :  '  _______________  ';
        $AshaName   = '  _______________  ';
        $AshaNumber = '  _______________  ';

        $Signatures = signDirectoryUrl.$getFirstAseessmentbabyData['nurseDigitalSign'];

        $NurseSign = ($getFirstbabyData['staffId']!='') ? $this->singlerowparameter('name','staffId',$getFirstbabyData['staffId'],'staffMaster').'<br>' : ' __________________________________________________';


        $MotherNo = ($MotherData['motherMobileNumber']!='') ? $MotherData['motherMobileNumber'] : '____________________________________________________';

        $FatherNo = ($MotherData['fatherMobileNumber']!='') ? $MotherData['fatherMobileNumber'] : '____________________________________________________';

        $Father = ($MotherData['fatherMobileNumber']!='') ? 'Father' : ' __________________';
        $Mother = ($MotherData['motherMobileNumber']!='') ? 'Mother' : ' __________________';

        if($MotherData['motherName']!=''){

          $MotherName = ($MotherData['motherName']!='') ? $MotherData['motherName'] :'__________________';
        }elseif($MotherData['motherName']==NULL && $MotherData['guardianName']==NULL ){
          $MotherName  = '__________________';
            
        }elseif($MotherData['type']=='2'){
          $MotherName   =  'Unknown';
          $MotherName2  =  ($MotherData['motherName']==NULL) ? '__________________': $MotherData['motherName'];
          $GR_Relation  =  'Unknown'; 
        }

        if($MotherData['type']=='3' || $MotherData['type']=='1' ){
            $MotherName   =  $MotherData['motherName'];
            $MotherName2   =  ($MotherName!='Unknown') ? $MotherName :'';
        }else{
            $MotherName    =  'Unknown';
            $MotherName2   =  ($MotherName=='Unknown') ? '__________________':'';
        }

        $FatherName = ($MotherData['fatherName']!='') ? $MotherData['fatherName'] :'__________________';

        if($MotherData['isMotherAdmitted']=="Yes"){
          $GR_NAME = $MotherData['motherName'];  
          $GR_Relation='Mother';
        }elseif($MotherData['type']=="2"){
          $GR_NAME = $MotherData['organisationName'];  
          $GR_Relation = "Organisation";
        }else{
          $GR_NAME = $MotherData['guardianNameAdmission'];  
          $GR_Relation = $MotherData['guardianRelation'];
        }

        $motherName00=  ($MotherData['motherName']!='') ? $MotherData['motherName'] :'_____________________';
        $fatherName00=  ($MotherData['fatherName']!='') ? $MotherData['fatherName'] :'_____________________';  


        $OrganisationName = ($MotherData['organisationName']!='') ? $MotherData['organisationName'] :"_____________________";
        $OrganisationAddress = ($MotherData['organisationAddress']!='') ? $MotherData['organisationAddress'] :"______________________";

        $OrganisationNumber = ($MotherData['organisationNumber']!='') ? $MotherData['organisationNumber'] :"______________________";

        $LMPDate = ($MotherData['motherLmpDate']!=NULL) ? date('d/m/Y', strtotime($MotherData['motherLmpDate'])) : '_____________________';

        // birth complication
        $complicationAtBirthString = "";
        $complicationAtBirthData =json_decode($BabyData['isAnyComplicationAtBirth'], true);
        if(!empty($complicationAtBirthData) && count($complicationAtBirthData) > 0){
          $complicationCount=1;
          foreach ($complicationAtBirthData as $complicationkey => $complicationAtBirthVal) {
            $complicationAtBirthString .='<span style="margin-left:20px">'.$complicationCount.". ".$complicationAtBirthVal['name'].'</span><br>';
            $complicationCount++;
          }
        }else{
          $complicationAtBirthString = "";
        }

        // baby stable
        $get_first_assessment = $this->db->query("select * from babyDailyMonitoring where babyAdmissionId=".$id." order by id ASC limit 0,1")->row_array();
        $babyStableStatus      = $this->DangerSignModel->getBabyIcon($get_first_assessment);
        if($babyStableStatus == 1){
          $babyStableStatusData = "Yes";
        }else{
          $babyStableStatusData = "No";
        }
         

        $header ='';
        $content = '';
        $footer = '';
        $finalHtml = '';

        $header.= '<!DOCTYPE html>
        <html>
        <head>
          <title>FORM A: KMC UNIT ADMISSION FORM</title>

          <style>
            table, th, td {
                border-collapse: collapse;
            }
        </style>

        </head>
        <body>';
          $content .='<div style="">
       
            <h3 style ="text-align: center;font-family: sans-serif; margin-top:-5px !important"><u> FORM A: KMC UNIT ADMISSION FORM</u> </h3>
            <p style="font-size: 14px"> <b>Objective:</b> To be filled at the time of admission to the KMC unit, before starting long-duration KMC. The form contains information on eligibility of the baby of KMC and detail required for follow-up. </p>
            <p style=" font-size: 14px ; padding-bottom:-5px !important ;"><b><u><i> Information to be collect by nurse on duty in KMC unit from the case sheet, health officials, mother and caregivers. </i></u></b></p>
            <span style="margin-top:-10px">----------------------------------------------------------------------------------------------------------------------------------------------------</span>
        

         <div>
            <div style=" padding-bottom: 5px; padding-top: 5px">
                <label> <b>Hospital Reg. No.:</b>  '.$getFirstbabyData['babyFileId'].'</label> <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>  MCTS No.:</b> '.$MCTS.'</label>
            </div>
            
            <div style=" padding-bottom: 7px">
              <label><b> Baby of:</b> '.$MotherName.'<label> 
            </div>  
            
            <div>
             <label><b>Date of Admission to KMC Unit</b> (dd/mm/yyyy): '.$date.'</label>&nbsp;<label><b>Time of Admission</b> (AM/PM): '.$time.'</label>
            </div>
            <br> 
          <div>
            <b>1- </b> <label>BACKGROUND INFORMATION </label>
            <br>
              <div style="margin-top: 15px; margin-left:20px">
                <b> 1.1 Date of Birth</b> (dd/mm/yyyy): '.date('d/m/Y', strtotime($BabyData['deliveryDate'])).' 
              </div>
                <br>
               <div style="margin-top: 2px; margin-left:20px">
                <b> 1.2 Sex: </b> '.$BabyData['babyGender'].'
              </div>  
              <br>
          
            <div style="margin-top: 3px; margin-left:20px">
              <b> 1.3 Time of Birth </b>(AM/PM): '.date('h:i A', strtotime($BabyData['deliveryTime'])).'
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
                <br>
              <div style="margin-top: 3px; margin-left:20px">    
              <b> 1.4 Type of Admission: </b> '.$BabyData['typeOfBorn'].'
              
            </div>
            <br>
            <div style="margin-top: 3px; margin-left:20px">
              <b> 1.5 Weight at Birth</b> (in grams): '.$BirthWeigth.'
            </div>
            <br>
            <div style="margin-top: 3px; margin-left:20px">    
              <b> 1.6 Place of Birth: </b>'.$MotherDeliveryPlace.' 
            </div>  
            <br> 

            <div style="margin-top: 3px; margin-left:35px">
              <b> 1.6.1 Name and Address of Birth Facility: </b>'.$FacilityName.'         
            </div>   
            <br>
            <div style="margin-top: 3px; margin-left:20px">    
              <b> 1.7 Type of Birth: </b> '.$BabyData['deliveryType'].'              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

               </div>   
            <br>
            <div style="margin-top: 3px; margin-left:20px">    
            
                <b> 1.8  Term of Birth:</b> '.$birthTerm.'
            </div>  

            <br>
            <div style="margin-top: 3px; margin-left:20px">
              <b> 1.9 LMP (first day of last menstrual period - dd/mm/yyyy):</b> '.$LMPDate.'
              
            </div>
            <br>   
            <div style="margin-top: 3px; margin-left:20px">
              <b> 1.10  Gestational Age (in weeks) </b>: '.$GestationalAge.' 
            </div>
            <br>

             <div style="margin-top: 3px; margin-left:20px">
              <b> 1.11 Weight of baby at admission to KMC unit</b> (in grams): '.$AdmissionBirthWeigth.'

            </div>  
            <br> 

            
            <div style="margin-top: 3px; margin-left:20px">

                <div style="width: 150px"><b>1.12</b></div>
                <div style="margin-left:50px; width: 300px">
                    <table width="100%" cellpadding="5" style="text-align: center;margin-top: -15px;" border="1">
                        <tr>
                            <th>G</th>
                            <th>P</th>
                            <th>A</th>
                            <th>L</th>
                        </tr>
                        <tr>
                            <td>'.$MotherData['gravida'].'</td>
                            <td>'.$MotherData['para'].'</td>
                            <td>'.$MotherData['abortion'].'</td>
                            <td>'.$MotherData['live'].'</td>
                        </tr>
                    </table>
                </div>  
              
            </div><br>

            <div style="margin-top: 3px; margin-left:20px">
              <b> 1.13   Is the Baby Stable? </b>  &nbsp;&nbsp; '.$babyStableStatusData.'
              <br>
              Is the baby on medication at time of admission? (Specify name and dosage)
              <br>
              '.$complicationAtBirthString.'
            </div>   
            <br>


          <div>

          <br>
            <b>2- <label>FAMILY DETAIL (For Follow Up)</b></label>
            <br>
              <div style="margin-top: 15px; margin-left:20px">
                <b> 2.1 Name of the Mother: </b> '.$motherName00.'
              </div>
                <br>
              <div style="margin-top: 3px; margin-left:20px">
                <b> 2.2 Name of the Father: </b> '.$fatherName00.'
              </div>  
              
              <br>
          
            <div style="margin-top: 3px; margin-left:20px">
              <b> 2.3 Name & relation of accompanying family member(s)</b>
              <br><br>
                    <div style="width:60%; float: left;padding-left:15px">
                    '.$GR_NAME.'
                    </div>   
                    <div style="width:35%; float: right;">
                    '.$GR_Relation.'
                    </div>    

                    <div style="width:60%; float: left;padding-left:15px">
                    
                    </div>   
                    <div style="width:35%; float: right;">
                    
                    </div>    
                    <div style="width:60%; float: left;padding-left:15px">
                    
                    </div>   
                    <div style="width:35%; float: right;">
                    
                    </div>   
                </div>
                <br>
              <div style="margin-top: 10px; margin-left:20px">    
              <b> 2.4 Contact Detail (At least 2 close contact numbers)</b> 
              <br>
              

                    <div style="width:60%; float: left;padding-left:15px">
                     <b> Phone / Mobile Number</b> 
                    </div> 
                    <div style="width:35%; float: right;">
                        <b> Relations</b>   
                    </div> 
                    <br>    
                    <div style="width:60%; float: left;padding-left:15px">
                    '.$MotherNo.'
                    </div>   
                    <div style="width:35%; float: right;">
                    '.$MotherName2.'</div> 
                    

                    <div style="width:60%; float: left;padding-left:15px">
                    '.$FatherNo.'
                    </div>   
                    <div style="width:35%; float: right;">
                     '.$FatherName.'                    </div> 
                    <br>   
            </div>
            <br>
            <div style="margin-top: 3px; margin-left:35px">
              <b> 2.4.1 Name and Number of ASHA: </b> '. $AshaName ."&nbsp;&nbsp;&nbsp; ".$AshaNumber.'
            </div>
            <br>
            <div style="margin-top: 3px; margin-left:20px">    
              <b> 2.5 Religion:</b> ' .$MotherData['motherReligion'].'
            </div>  
            <br> 

            <div style="margin-top: 3px; margin-left:20px">
              <b> 2.6 Caste: </b> '.$MotherData['motherCaste'].'         
            </div>   
             <br>';
        
       
        

        if($MotherData['type']=='2'){
            $content.='<div style="margin-top: 3px; margin-left:20px">    
                      <b> 2.7 Address: </b>
                      <br><br>
                      <b> Rural/Urban: </b> ' .$RuralUrban.  '<br>
                      <b> State/Country: </b> ' .$State.', '.$Country.'<br>
                      <b> District: </b> ' .$Dname.'<br>
                      <b> Gram Sabha-Hamlet/ House No.:</b> '.$Vname.'<br>
                      <b> Address:</b>' . $Address. '<br>
                      <b> Pincode:</b>' . $Pincode. '<br>
                      <b> Near:</b>' . $NearBy. '<br>

                    </div>         
                    <br>
                    <b> 3- </b> <label> ORGANISATION DETAIL </label>
                    <br>  
                    <div style="margin-top: 15px; margin-left:20px">
                        
                        <b>  3.1 Organisation Name: </b> ' .$OrganisationName.  '<br>
                        <b>  3.2 Organisation Number: </b>' . $OrganisationNumber. '<br>
                        <b>  3.3 Organisation Address:</b> '.$OrganisationAddress.'<br>
                        </div>   
                       <br>';

        } else{

            $content.='<div style="margin-top: 3px; margin-left:20px">    
              <b> 2.7 Address: </b>
              <br><br>
              <b> Rural/Urban: </b> ' .$RuralUrban.  '<br>
              <b> State/Country: </b> ' .$State.', '.$Country.'<br>
              <b> District: </b> ' .$Dname.'<br>
              <b> Gram Sabha-Hamlet/ House No.:</b> '.$Vname.'<br>
              <b> Address:</b>' . $Address. '<br>
              <b> Pin Code:</b>' . $Pincode. '<br>
              <b> Near:</b>' . $NearBy. '<br>

            </div>         
            <br>';
        }
          $content.='<div style="margin-top: 15px; margin-left:20px"> 
                    <div style="width:70%; float: left;">
                    <b> Signature of Nurse at the time of admission. </b>
                    </div>   
                    <div style="width:30%; float: right;">
                    <b style="float: right;"> Signature of Doctor </b>
                    </div>   
            
                  </div>  
                  <br> 

                  <div style="margin-top: 3px; margin-left:20px">

                  <div style="width:55%;   float: left; margin-left: 5px">'.$NurseSign.'<br>
                
                 </div>   
                  <div style="width:30%; float: right;"> _______________________  
                 </div>   
                  </div>   
                  <br>
                </div>

              </div>
                
            </div>';

          $footer .='</body></html>';

          $finalHtml .= $header;
          $finalHtml .= $content;
          $finalHtml .= $footer;

          $returnOutput['content'] = $content;
          $returnOutput['htmlData'] = $finalHtml;
          return $returnOutput; 
    }

    public function BabyWeightPdfFile($LoungeID, $BabyID,$id)
    {

        error_reporting(0);
        $getBabyFileId = $this->db->get_where('babyAdmission',array('id'=>$id))->row_array();
        /*echo $LoungeID ."   ". $BabyID; exit;*/
        $MotherDetail =  $this->db->query("SELECT MR.`motherName`, BR.`deliveryDate`, BR.`babyWeight` FROM motherRegistration as MR LEFT JOIN babyRegistration as BR  on BR.`motherId` =  MR.`motherId`  WHERE BR.`babyId` = '".$BabyID."'")->row_array();

         $GetBabyWeigth = $this->db->get_where('babyDailyWeight', array('babyAdmissionId'=>$id))->result_array();

        /* echo "<pre>"; print_r($GetBabyWeigth); exit;*/   
        $html ='';
        $html.= '
                <!DOCTYPE html>
                <html>
                <head>
                <style>

                  table,th,td,tr{
                    border-collapse:collapse;
                    }

                </style>
                </head>
                <body>
                <table >
                <tr><th style="text-align: center;font-family: sans-serif;"><u><h3>FORM D : DAILY WEIGHT MONITORING FORM</h3></u></th></tr>
                <tr><td style="text-align: left;"><strong ><i>Objective:</i></strong><i style="font-family: serif;"> To record the pre-feed weight of the baby admitted in the KMC unit,and compare it with the weight of the previous day and admission weight.To be filled by nurse on duty in the KMC room after weighing.</i> </td></tr>

                </table>

                <table style="margin-top:   10px;width: 100%" >
                <tr>
                    <td style="width: 50%;text-align: left; padding:5px "><b> Hospital Registration Number: </b> '.$getBabyFileId['babyFileId'].' </td>
                <th style="width: 50%;text-align: left"></th></tr>
                <tr>
                  <td style="width: 50%;text-align: left; padding:5px "> <b> Mother Name:</b> '.$MotherDetail['motherName'].'</td>
                  <td style="width: 50%;text-align: right; padding:5px; float:right !important;  "><b>Date of Birth(dd/mm/yyyy):</b> '.date("d/m/Y",strtotime($MotherDetail['deliveryDate'])).'</td></tr>
                <tr>
                  <td style="width: 50%;text-align: left; padding:5px "><b>Birth Weight(in grams): </b>'.$MotherDetail['babyWeight'].'</td>
                  <th style="width: 50%;text-align: left"></th></tr>

                </table>
                <table style="margin-top:10px;border:1px solid;width: 100% " >
                  
                    <tr style="border:1px solid" >
                    <td style="width: 11%;text-align: center;border:1px solid; padding: 8px"><b>Day</b></td>
                    <td style="width: 12%;text-align: center;border:1px solid ; padding: 8px"><b>Date<br>(dd/mm/yy)</b></td>
                    <td style="width: 12%;text-align: center;border:1px solid ; padding: 8px"><b>Time of<br>weighing</b></td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ; padding: 8px"><b>Weight of baby<br>without clothes<br>(in grams)</b></td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ; padding: 8px"><b>Todays weight-<br>yesterdays weight<br><br>(+,- or unchanged)</b></td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ; padding: 8px"><b>Net gain/loss since admission<br>(Todays weight-<br>Admission<br>weight)</b></td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ; padding: 8px"><b>Remarks</b></td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ; padding: 8px"><b>Nurse Name</b></td>
                    <td style="width: 11%;text-align: center;border:1px solid ; padding: 8px"><b>Signature<br>or nurse<br>talking<br>weight</b></td>
                  </tr>';
                  $i =1;

                foreach ($GetBabyWeigth as $key => $value) {
                    $nurseName = $this->singlerowparameter('name','staffId',$value['nurseId'],'staffMaster');
                  // print_r(date('g:i A',$value['AddDate']));exit;
                    ######## Conditions Baby weigth gain loss #########  
                    if($i >= 2){
                        $prev_baby_weigth = $GetBabyWeigth[$i-2]['babyWeight'];

                        $curr_baby_weigth = $value['babyWeight'];
                        $Weigthdiffer = '';
                        if($prev_baby_weigth > $curr_baby_weigth )
                        {
                            $differ =  $prev_baby_weigth -  $curr_baby_weigth;
                            $Weigthdiffer = '-'.$differ;
                        }else{
                            $differ =  $curr_baby_weigth -  $prev_baby_weigth;
                            $Weigthdiffer = '+'.$differ;
                        }
                    }

                    ######## Conditions Baby weigth gain loss #########
            ##### Conditions FOR Net Baby weigth gain loss since admission #########
                    if($i > 1){
                        
                    if($GetBabyWeigth[0]['babyWeight'] > $value['babyWeight'] )
                        {
                            $differ =  $GetBabyWeigth[0]['babyWeight'] -  $value['babyWeight'];
                            $gainLose = $differ.' loss';
                            
                        }else{
                            $differ = $value['babyWeight'] -  $GetBabyWeigth[0]['babyWeight'];
                            $gainLose = $differ.' gain';
                            
                        }
                    }
                ##### Conditions FOR Net Baby weigth gain loss since admission #########


                $html.=  '<tr style="border:1px solid" >
                    <td style="width: 11%;text-align: center ;border:1px solid;padding: 11px ; padding: 7px">'.$i.'</td>
                    <td style="width: 12%;text-align: center;border:1px solid ">'.date('d/m/Y',strtotime($value['weightDate'])).'</td>
                    <td style="width: 12%;text-align: center;border:1px solid ">'.date('g:i A',$value['addDate']).'</td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ">'.$value['babyWeight'].'</td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ">'.$Weigthdiffer.'</td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ">'.$gainLose.'</td>
                    <td style="width: 13.5%;text-align: center;border:1px solid "></td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ">'.$nurseName.'</td>
                    <td style="width: 11%;text-align: center;border:1px solid "></td>
                  </tr>';


                  $i++;
                   
                  }

                $html.=  '</table>
                <table style="width: 100%;margin-top: 10px" >
                <tr>
                  <th style="text-align: left;font-family: sans-serif;">Date of discharge(dd/mm/yy):-----/-----/-----
                    <span style="padding-left: 20px">Weight of discharge(in grams):</span><input type="text"  id="fname" name="firstname" style="border-top: none;border-bottom-width: 2px;border-left: none;border-right: none;border-bottom-color: black"></th>
                </tr>
                <tr>
                  <th style="text-align: left;font-family: sans-serif">Net gain/loss since admission(in grams)(+/-):<input type="text"  id="fname" name="firstname" style="border-top: none;border-bottom-width: 2px;border-left: none;border-right: none;border-bottom-color: black"></th>
                </tr>

                </table>
                </body>
                </html>'; 

        $pdfFilePath =  pdfDirectory."b_".$getBabyFileId['id']."_weigth.pdf";

        $mpdf =  new mPDF('utf-8', 'A4-L');
        $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

        $mpdf->WriteHTML($PDFContent);

        $mpdf->Output($pdfFilePath, "F"); 
        return "b_".$getBabyFileId['id']."_weigth.pdf";
    }


    function GetDateDifference($deliveryDate,$lmpDate)
    {

      $datediff = $deliveryDate - $lmpDate;
      return  round(($datediff / (60 * 60 * 24))/7);
    }


    function singlerowparameter($select,$matchWith,$matchingId,$table)
    {
      $tableRecord = & get_instance();
      $tableRecord->load->database();     
      $tableRecord->db->select($select);  
      $query = $tableRecord->db->get_where($table,array($matchWith => $matchingId))->row_array();   
      return $query[$select];       
    }


}