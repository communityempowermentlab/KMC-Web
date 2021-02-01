<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class BabyPDF extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/baby_model');      
        $this->load->library('m_pdf');
    }
    public function pdfGenerate($id)
    {
      $babyAdmisionLastId = $this->db->get_where('baby_admission',array('id'=>$id))->row_array();
      $getMotherId = $this->db->get_where('babyRegistration',array('BabyID'=>$babyAdmisionLastId['BabyID']))->row_array();

            $fileName = "b_".$babyAdmisionLastId['id'].".pdf";
            $GetMotherAllData = $this->GetMotherAllData($getMotherId['MotherID']);
            $GetBabyAllData   = $this->GetBabyAllData($babyAdmisionLastId['BabyID']);
            $PdfFile = $this->pdfconventer($GetMotherAllData,$GetBabyAllData,$fileName,$babyAdmisionLastId['id']);

            $this->db->where('id',$babyAdmisionLastId['id']);
            $this->db->update('baby_admission', array('BabyPDFFileName'=>$PdfFile));


            $PdfName = $this->BabyWeightPdfFile($babyAdmisionLastId['LoungeID'],$babyAdmisionLastId['BabyID'],$babyAdmisionLastId['id']);
            $this->db->where('id',$babyAdmisionLastId['id']);
           $res = $this->db->update('baby_admission',array('BabyWeightPdfName'=>$PdfName));
           if($res > 0){
           $this->session->set_flashdata('activate', getCustomAlert('S','Admission PDF Generate Successfully'));
            redirect('BabyManagenent/registeredBaby/type/'.$babyAdmisionLastId['LoungeID']);
           }

    }

    public function GetMotherAllData($MotherID)
    {
        return $this->db->query("SELECT * FROM mother_registration AS MR LEFT JOIN mother_admission AS MA ON MR.`MotherID` = MA.`MotherID`  WHERE MR.`MotherID` = '".$MotherID."'")->row_array();
    }

    public function GetBabyAllData($BabyID)
    {   
        return $this->db->query("SELECT *,BA.`add_date` as AddDate FROM  babyRegistration AS BR LEFT JOIN baby_admission AS BA ON BR.`BabyID` = BA.`BabyID`  WHERE BR.`BabyID` = '".$BabyID."' order by BA.`id` desc")->row_array();
        //echo $this->db->last_query();
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

public function pdfconventer($MotherData, $BabyData,$filename ='',$id)
    {
        error_reporting(0);
         $gestationAge = GetDateCorrectDiff2(strtotime($BabyData['DeliveryDate']),strtotime($MotherData['MotherLmpDate']));
         $GestationalAge = $gestationAge;   

        $getFirstbabyData = $this->db->get_where('baby_admission',array('id'=>$id))->row_array();
        $getFirstAseessmentbabyData = $this->db->get_where('checklistmaster',array('MotherAdminID'=>$MotherData['MotherID']))->row_array();

        //$getHospitalInMA=$this->db->get_where('mother_admission',array('MotherID'=>$MotherData['MotherID']))->row_array();
        $GR_NAME=  ($MotherData['GuardianName']!='') ?  $MotherData['GuardianName'] :'  ____________________________________________________';
        $GR_Relation=  ($MotherData['GuardianRelation']!='') ?  $MotherData['GuardianRelation'] :'___________________';
        $MCTS = ($MotherData['MotherMCTSNumber']!=NULL)?  ' '.$MotherData['MotherMCTSNumber']: ' --';
        
        $District_Name =  $this->DistrictVillageBlock($MotherData['PresentDistrictName'], 3) ;
        $Dname = ($District_Name!='') ? $District_Name : '';
        $State = ($MotherData['PresentState']!='') ? $MotherData['PresentState'] : '';
        $Country = ($MotherData['PresentCountry']!='') ? $MotherData['PresentCountry'] : '';
        

        $Block_Name =  $this->DistrictVillageBlock($MotherData['PresentBlockName'], 2) ;
        $Bname = ($MotherData['PresentBlockName']!='') ? $MotherData['PresentBlockName'] : '';

        $Village_Name =  $this->DistrictVillageBlock($MotherData['PresentVillageName'], 1) ;
        $Vname = ($Village_Name!='') ? $Village_Name: '_________________________________';

        $date = date('d/m/Y',$BabyData['AddDate']); 
        $time = date('h:i A',$BabyData['AddDate']);
        $BirthWeigth= ($BabyData['BabyWeight']!='') ? $BabyData['BabyWeight'].' grams' :'';

        $AdmissionBirthWeigth = ($getFirstbabyData['BabyAdmissionWeight']!='') ? $getFirstbabyData['BabyAdmissionWeight'].' grams' :'';


        $MotherDeliveryPlace = (($MotherData['FacilityID']=='0') || ($MotherData['FacilityID']=='')) ? ucwords($MotherData['MotherDeliveryPlace']) : 'Hospital';


        $FacilityName = ($MotherData['FacilityID']!='0' && $MotherData['FacilityID']!=NULL) ? singlerowparameter2('FacilityName','FacilityID',$MotherData['FacilityID'],'facilitylist') : 'Other';


        $RuralUrban = ($MotherData['PresentResidenceType']!='') ? " ". $MotherData['PresentResidenceType'] :  '  _______________  ';
        $Pincode    = ($MotherData['PresentPinCode']!='') ? " ".$MotherData['PresentPinCode'] :  '  _______________  ';

        $NearBy     = ($MotherData['PresentAddressNearBy']!='') ? " ".$MotherData['PresentAddressNearBy'] :  '  _______________  ';
        $Address    = ($MotherData['PresentAddress']!='') ? " ".$MotherData['PresentAddress'] :  '  _______________  ';
        $AshaName   = ($MotherData['AshaName']!='') ? " ".$MotherData['AshaName'] :  '  _______________  ';
        $AshaNumber = ($MotherData['AshaNumber']!='') ? " ".$MotherData['AshaNumber'] :  '  _______________  ';

         $Signatures = base_url().'assets/images/sign/'.$getFirstAseessmentbabyData['NurseDigitalSign'];

        $NurseSign = ($MotherData['StaffId']!='') ? singlerowparameter2('Name','StaffID',$MotherData['StaffId'],'staff_master').'<br> '. date('d/m/Y h:i A').'<br>' : ' __________________________________________________';


        $MotherNo = ($MotherData['MotherMoblieNo']!='') ? $MotherData['MotherMoblieNo'] : '____________________________________________________';

        $FatherNo = ($MotherData['FatherMoblieNo']!='') ? $MotherData['FatherMoblieNo'] : '____________________________________________________';

        $Father = ($MotherData['FatherMoblieNo']!='') ? 'Father' : ' __________________';
        $Mother = ($MotherData['MotherMoblieNo']!='') ? 'Mother' : ' __________________';

        if($MotherData['MotherName']!=''){

        $MotherName = ($MotherData['MotherName']!='') ? ucwords($MotherData['MotherName']) :'__________________';
        }elseif($MotherData['MotherName']==NULL && $MotherData['GuardianName']==NULL ){
            $MotherName  = '__________________';
            
        }elseif($MotherData['Type']=='2'){
            $MotherName   =  'Unknown';
            $MotherName2  =  ($MotherData['MotherName']==NULL) ? '__________________': $MotherData['MotherName'];
            $GR_Relation  =  'Unknown'; 
        }

         if($MotherData['Type']=='3' || $MotherData['Type']=='1' ){
                    $MotherName   =  $MotherData['MotherName'];
                    $MotherName2   =  ($MotherName!='Unknown') ? $MotherName :'';
         }else{
                $MotherName    =  'Unknown';
                $MotherName2   =  ($MotherName=='Unknown') ? '__________________':'';
         }

        //$Mname = ($MotherData['Type']=='2')? $MotherData['MotherName'] : $MotherName;

        $FatherName = ($MotherData['FatherName']!='') ? ucwords($MotherData['FatherName']) :'__________________';

        if($MotherData['GuardianName']==NULL  && $MotherData['GuardianNumber']==NULL){
            if($GR_Relation=='Father'){

                $GR_NAME = $FatherName;
            }else{
                $GR_NAME = $MotherData['MotherName'];   
            }


        }else{

            $GR_NAME = ($MotherData['GuardianName']!='') ?  $MotherData['GuardianName'] :'  _________________________________________________';

        }
         $motherName00=  ($MotherData['MotherName']!='') ? ucwords($MotherData['MotherName']) :'_____________________';

         $fatherName00=  ($MotherData['FatherName']!='') ? ucwords($MotherData['FatherName']) :'_____________________';  


        $OrganisationName = ($MotherData['OrganizationName']!='') ? $MotherData['OrganizationName'] :"_____________________";
        $OrganisationAddress = ($MotherData['OrganizationAddress']!='') ? $MotherData['OrganizationAddress'] :"______________________";

        $OrganisationNumber = ($MotherData['OrganizationNumber']!='') ? $MotherData['OrganizationNumber'] :"______________________";

        $LMPDate = ($MotherData['MotherLmpDate']!=NULL) ? date('d/m/Y', strtotime($MotherData['MotherLmpDate'])) : '_____________________';

        //echo $this->db->last_query();
         $weekPlural = ($GestationalAge > 1) ? 'Weeks' : 'Week';
        //echo $FacilityName;exit;
        /*echo $GestationalAge; exit;*/


        $html ='';
        $html.= '<!DOCTYPE html>
        <html>
        <head>
          <title>FORM A: KMC UNIT ADMISSION FORM</title>

          <style>
            table, th, td {

                border-collapse: collapse;
            }
        </style>

        </head>
        <body>
          <div style="">
       
            <h3 style ="text-align: center; margin-top:-5px !important"><u> FORM A: KMC UNIT ADMISSION FORM</u> </h3>
            <p style="font-size: 14px"> <b>Objective:</b> To be filled at the time of admission to the KMC unit, before starting long-duration KMC. The form contains information on eligibility of the baby of KMC and detail required for follow-up. </p>
            <p style=" font-size: 14px ; padding-bottom:-5px !important ;"><b><u><i> Information to be collect by nurse on duty in KMC unit from the case sheet, health officials, mother and caregivers. </i></u></b></p>
            <span style="margin-top:-10px">--------------------------------------------------------------------------------------------------------------------------------------------------------</span>
        

         <div>
            <div style=" padding-bottom: 5px; padding-top: 5px">
                <label> <b>Hospital Reg. No.:</b>  '.$getFirstbabyData['BabyFileID'].'</label> <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>  MCTS No.:</b> '.$MCTS.'</label>
            </div>
            
            <div style=" padding-bottom: 7px">
              <label><b> Baby of:</b> '.$MotherName.'<label> 
            </div>  
            
            <div>
             <label><b>Date of admission to KMC unit</b> (dd/mm/yyyy): '.$date.'</label>&nbsp;<label><b>Time of admission</b> (am/pm): '.$time.'</label>
            </div>
            <br> 
          <div>
            <b>1- </b> <label>BACKGROUND INFORMATION </label>
            <br>
              <div style="margin-top: 15px; margin-left:20px">
                <b> 1.1 Date of Birth</b> (dd/mm/yyyy): '.date('d/m/Y', strtotime($BabyData['DeliveryDate'])).' 
              </div>
                <br>
               <div style="margin-top: 2px; margin-left:20px">
                <b> 1.2 Sex: </b> '.$BabyData['BabyGender'].'
              </div>  
              <br>
          
            <div style="margin-top: 3px; margin-left:20px">
              <b> 1.3 Time of Birth </b>(am/pm): '.$BabyData['DeliveryTime'].'
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
                <br>
              <div style="margin-top: 3px; margin-left:20px">    
              <b> 1.4 Type of admission: </b> Inborn/ Outborn
              
            </div>
            <br>
            <div style="margin-top: 3px; margin-left:20px">
              <b> 1.5 Weight at birth</b> (in grams): '.$BirthWeigth.'
            </div>
            <br>
            <div style="margin-top: 3px; margin-left:20px">    
              <b> 1.6 Place of birth: </b>'.$MotherDeliveryPlace.' 
            </div>  
            <br> 

            <div style="margin-top: 3px; margin-left:35px">
              <b> 1.6.1 Name and address of birth facility: </b>'.$FacilityName.'         
            </div>   
            <br>
            <div style="margin-top: 3px; margin-left:20px">    
              <b> 1.7 Type of birth: </b> '.ucwords($BabyData['DeliveryType']).'              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

               </div>   
            <br>
            <div style="margin-top: 3px; margin-left:20px">    
            
                <b> 1.8  Term of birth:</b> Full Term/ Preterm  
            </div>  

            <br>
            <div style="margin-top: 3px; margin-left:20px">
              <b> 1.9 LMP </b> (first day of last menstrual period - dd/mm/yyyy): '.date("d/m/Y",strtotime($MotherData['MotherLmpDate'])).'
              
            </div>
            <br>   
            <div style="margin-top: 3px; margin-left:20px">
              <b> 1.10  Gestational age  </b>(in weeks): '.$GestationalAge.' '.$weekPlural.' 
            </div>
            <br>

             <div style="margin-top: 3px; margin-left:20px">
              <b> 1.11 Weigth of baby at admission to KMC unit</b> (in grams): '.$AdmissionBirthWeigth.'

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
                            <td>'.$MotherData['Gravida'].'</td>
                            <td>'.$MotherData['Para'].'</td>
                            <td>'.$MotherData['Abortion'].'</td>
                            <td>'.$MotherData['Live'].'</td>
                        </tr>
                    </table>
                </div>  
              
            </div><br>

            <div style="margin-top: 3px; margin-left:20px">
              <b> 1.13   Is the Baby stable? </b>  &nbsp;&nbsp; Yes&nbsp; /&nbsp; No
              <br>
              Is the baby on medication at time of admission? (Specify name and dosage)
              <br>
              <span style="margin-left:20px">1. ______________________________________________</span><br>
              <span style="margin-left:20px">2. ______________________________________________</span><br>
              <span style="margin-left:20px">3. ______________________________________________</span><br>
            </div>   
            <br>


          <div>

          <br>
            <b>2- </b> <label>FAMILY DETAIL (For Follow Up)</label>
            <br>
              <div style="margin-top: 15px; margin-left:20px">
                <b> 2.1 Name of the mother: </b> '.$motherName00.'
              </div>
                <br>
              <div style="margin-top: 3px; margin-left:20px">
                <b> 2.2 Name of the father: </b> '.$fatherName00.'
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
              <b> 2.4 Contact detail (At least 2 close contact numbers)</b> 
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
              <b> 2.4.1 Name and Number of ASHA: </b> '. ucwords($AshaName) ."&nbsp;&nbsp;&nbsp; ".$AshaNumber.'
            </div>
            <br>
            <div style="margin-top: 3px; margin-left:20px">    
              <b> 2.5 Religion:</b> ' .$MotherData['MotherReligion'].'
            </div>  
            <br> 

            <div style="margin-top: 3px; margin-left:20px">
              <b> 2.6 Caste: </b> '.$MotherData['MotherCaste'].'         
            </div>   
             <br>';
        
       
        

        if($MotherData['MotherAdmission']==NULL && $MotherData['reason_for_not_admitted']==NULL && $MotherData['Type']=='2'){
            $html.='<div style="margin-top: 3px; margin-left:20px">    
              <b> 2.7 Address: </b>
              <br><br>
              <b> Rural/Urban: </b> ' .$RuralUrban.  '<br>
              <b> State/Country: </b> ' .$State.', '.$Country.'<br>
              <b> District: </b> ' .$Dname.'<br>
              <b> Block/ Area/ Muhalla:</b> '.$Bname.'<br>
              <b> Gram Sabha-Hamlet/ House NO.:</b> '.$Vname.'<br>
              <b> Address:</b>' . $Address. '<br>
              <b> Pin Code:</b>' . $Pincode. '<br>
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

            }else{

            $html.='<div style="margin-top: 3px; margin-left:20px">    
              <b> 2.7 Address: </b>
              <br><br>
              <b> Rural/Urban: </b> ' .$RuralUrban.  '<br>
              <b> State/Country: </b> ' .$State.', '.$Country.'<br>
              <b> District: </b> ' .$Dname.'<br>
              <b> Block/ Area/ Muhalla:</b> '.$Bname.'<br>
              <b> Gram Sabha-Hamlet/ House NO.:</b> '.$Vname.'<br>
              <b> Address:</b>' . $Address. '<br>
              <b> Pin Code:</b>' . $Pincode. '<br>
              <b> Near:</b>' . $NearBy. '<br>

            </div>         
            <br>';

            }


           $html.='<div style="margin-top: 15px; margin-left:20px"> 

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
          
      </div>

    </body>
    </html>'; 

        /*$fileName = "b_".$BabyData['BabyID'].".pdf";*/
        $pdfFilePath =  INVOICE_DIRECTORY.$filename;
        //echo $pdfFilePath;

        $this->m_pdf->pdf->autoScriptToLang = true;
        $this->m_pdf->pdf->baseScript = 1;
        $this->m_pdf->pdf->autoVietnamese = true;
        $this->m_pdf->pdf->autoArabic = true;
        $this->m_pdf->pdf->autoLangToFont = true;
        $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $this->m_pdf->pdf->WriteHTML($PDFContent);
        $this->m_pdf->pdf->Output($pdfFilePath, "F"); 

        return  $filename;
    }

    public function BabyWeightPdfFile($LoungeID, $BabyID,$id)
    {

        error_reporting(0);
        $getBabyFileId = $this->db->get_where('baby_admission',array('id'=>$id))->row_array();

        /*echo $LoungeID ."   ". $BabyID; exit;*/
        $MotherDetail =  $this->db->query("SELECT MR.`MotherName`, BR.`DeliveryDate`, BR.`BabyWeight` FROM mother_registration as MR LEFT JOIN babyRegistration as BR  on BR.`MotherID` =  MR.`MotherID`  WHERE BR.`BabyID` = '".$BabyID."'")->row_array();

         $GetBabyWeigth = $this->db->get_where('baby_weight_master', array('LoungeID'=>$LoungeID,'BabyID'=>$BabyID))->result_array();

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
                    <td style="width: 50%;text-align: left; padding:5px "><b> Hospital Registration Number: </b> '.$getBabyFileId['BabyFileID'].' </td>
                <th style="width: 50%;text-align: left"></th></tr>
                <tr>
                  <td style="width: 50%;text-align: left; padding:5px "> <b> Mother Name:</b> '.$MotherDetail['MotherName'].'</td>
                  <td style="width: 50%;text-align: right; padding:5px; float:right !important;  "><b>Date of Birth(dd/mm/yyyy):</b> '.date("d/m/Y",strtotime($MotherDetail['DeliveryDate'])).'</td></tr>
                <tr>
                  <td style="width: 50%;text-align: left; padding:5px "><b>Birth Weight(in grams): </b>'.$MotherDetail['BabyWeight'].'</td>
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
                    $nurseName = singlerowparameter2('Name','StaffID',$value['NurseId'],'staff_master');
                  // print_r(date('g:i A',$value['AddDate']));exit;
                    ######## Conditions Baby weigth gain loss #########  
                    if($i >= 2){
                        $prev_baby_weigth = $GetBabyWeigth[$i-2]['BabyWeight'];

                        $curr_baby_weigth = $value['BabyWeight'];
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
                        
                    if($GetBabyWeigth[0]['BabyWeight'] > $value['BabyWeight'] )
                        {
                            $differ =  $GetBabyWeigth[0]['BabyWeight'] -  $value['BabyWeight'];
                            $gainLose = $differ.' loss';
                            
                        }else{
                            $differ = $value['BabyWeight'] -  $GetBabyWeigth[0]['BabyWeight'];
                            $gainLose = $differ.' gain';
                            
                        }
                    }
                ##### Conditions FOR Net Baby weigth gain loss since admission #########


                $html.=  '<tr style="border:1px solid" >
                    <td style="width: 11%;text-align: center ;border:1px solid;padding: 11px ; padding: 7px">'.$i.'</td>
                    <td style="width: 12%;text-align: center;border:1px solid ">'.date('d/m/Y',strtotime($value['WeightDate'])).'</td>
                    <td style="width: 12%;text-align: center;border:1px solid ">'.date('g:i A',$value['AddDate']).'</td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ">'.$value['BabyWeight'].'</td>
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

        $pdfFilePath =  INVOICE_DIRECTORY."b_".$getBabyFileId['id']."_weigth.pdf";

        include_once APPPATH.'/third_party/mpdf/mpdf.php';
        $this->m_pdf->pdf->autoScriptToLang = true;
        $this->m_pdf->pdf->baseScript = 1;
        $this->m_pdf->pdf->autoVietnamese = true;
        $this->m_pdf->pdf->autoArabic = true;
        $this->m_pdf->pdf->autoLangToFont = true;
        $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $this->m_pdf->pdf->WriteHTML($PDFContent);
        $this->m_pdf->pdf->Output($pdfFilePath, "F"); 
        return "b_".$getBabyFileId['id']."_weigth.pdf";
    }


}