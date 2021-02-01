<?php
class AllMixPdf extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();	
	    $this->load->model('api/DischargeModel');
	    date_default_timezone_set("Asia/KolKata");
	   // $this->load->library('m_pdf');
	}

    public function finalPdfDischargeTime($loungeId,$lastID,$type=''){
   		 error_reporting(0);
         $filename = "b_".$lastID."_final-Discharge.pdf";

			$getlastAdmissiondata = $this->db->get_where('babyAdmission',array('id'=>$lastID))->row_array();
			// get baby reg data
			$getMotherId = $this->db->get_where('babyRegistration',array('babyId'=>$getlastAdmissiondata['babyId']))->row_array();  		 
			$MotherData  = $this->GetMotherAllData($getMotherId['motherId']);
			$BabyData    = $this->GetBabyAllData($getlastAdmissiondata['babyId']);
			$gestationAge   = getLmpDeliveryDifference(strtotime($BabyData['deliveryDate']),strtotime($MotherData['motherLmpDate']));
			$GestationalAge = ($gestationAge == '0') ? 'UNKNOWN' : $gestationAge; 	

			$getFirstAseessmentbabyData = $this->db->get_where('admissionCheckList',array('motherAdmissionId'=>$MotherData['motherId']))->row_array();
			//$getHospitalInMA=$this->db->get_where('motherAdmission',array('motherId'=>$MotherData['motherId']))->row_array();
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

			$date = date('d/m/Y',$BabyData['addDate']); 
			$time = date('h:i A',$BabyData['addDate']);
			$BirthWeigth= ($BabyData['babyWeight']!='') ? $BabyData['babyWeight'].' grams' :'';

		   	$AdmissionBirthWeigth = ($getlastAdmissiondata['babyAdmissionWeight']!='') ? $getlastAdmissiondata['babyAdmissionWeight'].' grams' :'';
		   	$deliveryPlace = (($MotherData['facilityId']=='0') || ($MotherData['facilityId']=='')) ? ucwords($MotherData['deliveryPlace']) : 'Hospital';
		   	$FacilityName = ($MotherData['facilityId']!='0' && $MotherData['facilityId']!=NULL) ? getSingleRowFromTable('FacilityName','facilityId',$MotherData['facilityId'],'facilitylist') : 'Other';


			$RuralUrban = ($MotherData['presentResidenceType']!='') ? " ". $MotherData['presentResidenceType'] :  '  _______________  ';
			$Pincode 	= ($MotherData['presentPinCode']!='') ? " ".$MotherData['presentPinCode'] :  '  _______________  ';

			$NearBy 	= ($MotherData['presentAddNearByLocation']!='') ? " ".$MotherData['presentAddNearByLocation'] :  '  _______________  ';
			$Address 	= ($MotherData['presentAddress']!='') ? " ".$MotherData['presentAddress'] :  '  _______________  ';
			$ashaName	= ($MotherData['ashaName']!='') ? " ".$MotherData['ashaName'] :  '  _______________  ';
			$ashaNumber = ($MotherData['ashaNumber']!='') ? " ".$MotherData['ashaNumber'] :  '  _______________  ';
			$Signatures = base_url().'assets/images/sign/'.$getFirstAseessmentbabyData['nurseDigitalSign'];
			$NurseSign  = ($MotherData['staffId']!='') ? getSingleRowFromTable('name','staffId',$MotherData['staffId'],'staffMaster').'<br> '. date('d/m/Y h:i A').'<br>' : ' __________________________________________________';
			$MotherNo   = ($MotherData['motherMoblieNumber']!='') ? $MotherData['motherMoblieNumber'] : '____________________________________________________';

			$FatherNo = ($MotherData['fatherMoblieNumber']!='') ? $MotherData['fatherMoblieNumber'] : '____________________________________________________';
			$Father = ($MotherData['fatherMoblieNumber']!='') ? 'Father' : ' __________________';
			$Mother = ($MotherData['motherMoblieNumber']!='') ? 'Mother' : ' __________________';

			if($MotherData['motherName']!=''){
			    $motherName = ($MotherData['motherName']!='') ? ucwords($MotherData['motherName']) :'__________________';
			}elseif($MotherData['motherName']==NULL && $MotherData['guardianName']==NULL ){
				$motherName  = '__________________';
				
			}elseif($MotherData['type']=='2'){
				$motherName   =  'Unknown';
				$MotherName2  =  ($MotherData['motherName']==NULL) ? '__________________': $MotherData['motherName'];
				$GR_Relation  =  'Unknown';	
			}

			 if($MotherData['type']=='3' || $MotherData['type']=='1' ){
		 			$motherName   =  $MotherData['motherName'];
		 			$MotherName2   =  ($motherName!='Unknown') ? $motherName :'';
			 }else{
			 		$motherName    =  'Unknown';
			 		$MotherName2   =  ($motherName=='Unknown') ? '__________________':'';
			 }

			$fatherName = ($MotherData['fatherName']!='') ? ucwords($MotherData['fatherName']) :'__________________';

		   	if($MotherData['guardianName']==NULL  && $MotherData['guardianNumber']==NULL){
	  			if($GR_Relation=='Father'){

	  				$GR_NAME = $fatherName;
	  			}else{
	  				$GR_NAME = $MotherData['motherName'];	
	  			}


	  		}else{

	  			$GR_NAME = ($MotherData['guardianName']!='') ?  $MotherData['guardianName'] :'  _________________________________________________';

	  		}
			$motherName00  =  ($MotherData['motherName']!='') ? ucwords($MotherData['motherName']) :'_____________________';
			$fatherName00  =  ($MotherData['fatherName']!='') ? ucwords($MotherData['fatherName']) :'_____________________';  
			$OrganisationName = ($MotherData['OrganisationName']!='') ? $MotherData['organisationName'] :"_____________________";
			$OrganisationAddress = ($MotherData['OrganisationAddress']!='') ? $MotherData['organisationAddress'] :"______________________";
			$OrganisationNumber = ($MotherData['OrganisationNumber']!='') ? $MotherData['organisationNumber'] :"______________________";
			$LMPDate = ($MotherData['motherLmpDate']!=NULL) ? date('d/m/Y', strtotime($MotherData['motherLmpDate'])) : '_____________________';

		   	//echo $this->db->last_query();
		   	if($GestationalAge != 'UNKNOWN'){
	         $weekPlural = ($GestationalAge > 1) ? 'Weeks' : 'Week';
	         }
			$html.= '<!DOCtype html>
			<html>
			<head>
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
		            <label> <b>Hospital Reg. No.: </b>'.$getlastAdmissiondata['babyFileId'].'</label> <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>  MCTS No.:</b> '.$MCTS.'</label>
		        </div> 
		        <div style=" padding-bottom: 7px">
		          <label><b> Baby of:</b> '.$motherName.'</label> 
		        </div>  
		        
		        <div>
		         <label><b>Date of admission to KMC unit</b> (dd/mm/yyyy): '.$date.'</label>&nbsp;<label><b>Time of admission</b> (am/pm): '.$time.'</label>
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
		          <b> 1.3 Time of Birth </b>(am/pm): '.$BabyData['deliveryTime'].'
		            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		        </div>
		            <br>
		          <div style="margin-top: 3px; margin-left:20px">    
		          <b> 1.4 type of admission: </b> Inborn/ Outborn
		          
		        </div>
		        <br>
		        <div style="margin-top: 3px; margin-left:20px">
		          <b> 1.5 Weight at birth</b> (in grams): '.$BirthWeigth.'
		        </div>
		        <br>
		        <div style="margin-top: 3px; margin-left:20px">    
		          <b> 1.6 Place of birth: </b>'.$deliveryPlace.' 
		        </div>  
		        <br> 

		        <div style="margin-top: 3px; margin-left:35px">
		          <b> 1.6.1 Name and address of birth facility: </b>'.$FacilityName.'         
		        </div>   
		        <br>
		        <div style="margin-top: 3px; margin-left:20px">    
		          <b> 1.7 type of birth: </b> '.ucwords($BabyData['deliveryType']).'	          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

		           </div>   
		        <br>
		        <div style="margin-top: 3px; margin-left:20px">    
		        
		            <b> 1.8  Term of birth:</b> Full Term/ Preterm  
		        </div>  

		        <br>
		        <div style="margin-top: 3px; margin-left:20px">
		          <b> 1.9 LMP </b> (first day of last menstrual period - dd/mm/yyyy): '.date("d/m/Y",strtotime($MotherData['motherLmpDate'])).'
		          
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
			        			<td>'.$MotherData['gravida'].'</td>
			        			<td>'.$MotherData['para'].'</td>
			        			<td>'.$MotherData['abortion'].'</td>
			        			<td>'.$MotherData['live'].'</td>
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
						 '.$fatherName.'					</div> 
						<br>   
		        </div>
		        <br>
		        <div style="margin-top: 3px; margin-left:35px">
		          <b> 2.4.1 Name and Number of ASHA: </b> '. ucwords($ashaName) ."&nbsp;&nbsp;&nbsp; ".$ashaNumber.'
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
		    
		    if($MotherData['motherAdmission']==NULL && $MotherData['notAdmittedreason']==NULL && $MotherData['type']=='2'){
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
		  </div>'; 

		$html.='<div style="height:3%;"></div>';

// ******************* End Admission time pdf *******************//
// ******************* Start Daily weight time pdf *******************//



        $MotherDetail =  $this->db->query("SELECT MR.`motherName`, BR.`deliveryDate`, BR.`babyWeight` FROM motherRegistration as MR LEFT JOIN babyRegistration as BR  on BR.`motherId` =  MR.`motherId`  WHERE BR.`babyId` = '".$getlastAdmissiondata['babyId']."'")->row_array();
        $GetBabyWeigth = $this->db->get_where('babyDailyWeight', array('babyAdmissionId'=>$getlastAdmissiondata['id']))->result_array();
        $html.= '<div style="height:10%;"></div><table>
                <tr><th style="text-align: center;font-family: sans-serif;"><u><h3>FORM D : DAILY WEIGHT MONITORING FORM</h3></u></th></tr>
                <tr><td style="text-align: left;"><strong ><i>Objective:</i></strong><i style="font-family: serif;"> To record the pre-feed weight of the baby admitted in the KMC unit,and compare it with the weight of the previous day and admission weight.To be filled by nurse on duty in the KMC room after weighing.</i> </td></tr>
                </table>

                <table style="margin-top:10px;width: 100%" >
                <tr>
                    <td style="width: 50%;text-align: left; padding:5px "><b> Hospital Registration Number: </b> '.$getlastAdmissiondata['babyFileId'].' </td>
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
                    
                    $nurseName = getSingleRowFromTable('name','staffId',$value['nurseId'],'staffMaster');
                  // print_r(date('g:i A',$value['addDate']));exit;
                  
                    ######## conditions Baby weigth gain loss #########  
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
                    
                    ######## conditions Baby weigth gain loss #########
                    ##### conditions FOR Net Baby weigth gain loss since admission #########
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
                ##### conditions FOR Net Baby weigth gain loss since admission #########

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

               


                $dischargeTime    = ($getlastAdmissiondata['dateOfDischarge'] != '') ? date('d/m/Y',strtotime($getlastAdmissiondata['dateOfDischarge'])) : 'N/A';
                $dischargeWeightsGainOrLoss = ($getlastAdmissiondata['babyDischargeWeight'] != '') ? $getlastAdmissiondata['weightGainLosePostAdmission'] : 'N/A';
                $html.=  '</table>
                <table style="width: 100%;margin-top: 10px" >
                <tr>
                  <th style="text-align: left;font-family: sans-serif;">Date of Discharge(dd/mm/yy):'.$dischargeTime.'
                    <span style="padding-left: 20px">Weight of discharge(in grams):</span><input type="text" value="'.$getlastAdmissiondata['babyDischargeWeight'].'" id="fname" name="firstname" style="border-top: none;border-bottom-width: 2px;border-left: none;border-right: none;border-bottom-color: black"></th>
                </tr>
                <tr>
                  <th style="text-align: left;font-family: sans-serif">Net gain/loss since admission(in grams)(+/-):<input type="text"  id="fname" value="'.$dischargeWeightsGainOrLoss.'"  name="firstname" style="border-top: none;border-bottom-width: 2px;border-left: none;border-right: none;border-bottom-color: black"></th>
                </tr>
                </table>';
		$html.='<div style="height:3%;"></div>';
		

// ******************* End Daily weight time pdf *******************//
// ******************* Start KMC pdf *******************//

    $babyId        = $getlastAdmissiondata['babyId'];
    $MotherDetail  =  $this->db->query("SELECT MR.`motherName`, BR.`deliveryDate`, BR.`babyWeight` FROM motherRegistration as MR LEFT JOIN babyRegistration as BR  on BR.`motherId` =  MR.`motherId`  WHERE BR.`babyId` = '".$babyId."'")->row_array();
    $GetDay        = $this->db->query("SELECT Distinct startDate FROM `babyDailyKMC` where  loungeId = '".$loungeId."' AND babyId = '".$babyId."' AND babyAdmissionId = '".$getlastAdmissiondata['id']."'")->result_array(); 
    
        $y = '0';       
        foreach ($GetDay as $key => $value) {
          $html.= '<table style="width: 100%;border-bottom:none;" >
                        <tr><th style="text-align: center;font-family: sans-serif;" colspan= "7"><u><h3>FORM C: DAILY KMC COMPLIANCE FORM</h3></u></th></tr>
                        <tr><td style="text-align: left; " colspan= "8"><strong ><i>Objective:</i></strong><i style="font-family: serif;"> To record the number of hour of KMC given to the baby admitted in the KMC unit in 24 hours (8AM - 8AM ), the duration of each session and the reason for not giving continuous KMC. To be collected by nurse on duty in KMC room via direct observation or from mother/caregiver</i> </td></tr>
                              <tr>
                                <td style="width: 100%;text-align: left; padding:5px ;font-family: sans-serif"  >
                                <b style="margin-right: 40px" >Day:</b> '.date('l',strtotime($value['startDate'])).'
                                <b style="margin-left: 30px" >Hospital Reg. No.:</b> '.$getlastAdmissiondata['babyFileId'].'  
                                </td>
                             </tr>
                            <tr>
                              <td style="width: 50%;text-align: left; padding:5px ;font-family: sans-serif" colspan= "3"><b>Date of Birth(dd/mm/yy) :</b>  '.date("d/m/Y",strtotime($MotherDetail['deliveryDate'])).'
                            <b style="padding-left: 50px" >Mothers Name:</b> '.$MotherDetail['motherName'].' </td>
                          </tr>
                    </table>

                    <table style="margin-top:10px;border:1px solid;width: 100% " >
                        
                        <tr style="border:1px solid" >
                            <td style="width: 5%;text-align: center;border:1px solid; padding: 11px;border-bottom:none;"><b>S.No</b></td>
                            <td style="width: 13%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>Starting time<br>of KMC</b></td>
                            <td style="width: 13%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>Stopping time<br>of KMC</b></td>
                            <td style="width: 20%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>duration of KMC per<br>episode</b><br><span>(if KMC duration>=1hour<br>then record in hours if <1<br>hour please record in<br> minutes)</span>
                            </td>
                           <td style="width: 25%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>reason for pausing KMC</b><br><span>(Breast feeding,doctorcheckup,mothers<br>mealtime,mothers personal care,family<br>visit,discomfort,complications,etc.)</span></td>
                            <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>KMC<br>Provider</b></td>
                            <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>Nurse<br>Name</b></td>
                            <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>Nurse<br>Signature</b></td>
                        </tr>';

                        $GetKMCDayDetail = $this->db->query("SELECT * FROM `babyDailyKMC`  where  loungeId = '".$loungeId."' AND babyId = '".$babyId."' And startDate = '".$value['startDate']."' AND babyAdmissionId = '".$getlastAdmissiondata['id']."'")->result_array();
                        
                        $i           = 1;
                        $Time        = array();
                        $rowCount    = count($GetKMCDayDetail)+1;
                        $getRowCount = 7 - $rowCount;

                            foreach ($GetKMCDayDetail as $key => $value2) {

                        $nurseName = getSingleRowFromTable('name','staffId',$value2['nurseId'],'staffMaster');
                                $differ = getTimeDiff($value2['startTime'],$value2['endTime']);
                                $html.= '<tr style="border:1px solid" >
                                    <td style="width: 5%;text-align: center;border:1px solid; padding: 11px;border-bottom:none;">'.$i.'</td>
                                    <td style="width: 13%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;">'.date('g:i A',strtotime($value2['startTime'])).'</td>
                                    <td style="width: 13%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;">'.date('g:i A',strtotime($value2['endTime'])).'</td>
                                    <td style="width: 20%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;">'.$differ.'</td>
                                    <td style="width: 25%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                                    <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;">'.$value2['ByWhom'].'</td>
                                    <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;">'.$nurseName.'</td>
                                    <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                                 </tr>';

                                $Time[] = $differ ;
                                $i++;
                            }
                         
                            if(($getRowCount<7) && ($getRowCount>0))
                            {
                                for($z = $rowCount; $z <= 8 ; $z++) { 
                                $html.= '<tr style="border:1px solid" >  
                                <td style="width: 5%;text-align: center;border:1px solid; padding: 11px;border-bottom:none;">'.$z.'</td>
                                        <td style="width: 13%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                                        <td style="width: 13%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                                        <td style="width: 20%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                                        <td style="width: 25%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                                        <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                                        <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                                        <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                                    </tr>';
                                }

                            }

                        $GetTotalTime = totalTime($Time);
                        $html.= '<tr>
                              <td style="text-align: left;width: 5.4%;border:1px solid "></td>
                              <td style="text-align: left;padding:5px" colspan = "6" >
                                Total KMC duration in 24 hours (8 am to 8 am):<br><br>
                                '.$GetTotalTime.'
                             </td>
                            <td style="text-align: left;width: 8.7%;border:1px solid "></td>
                        </tr>
                    </table><br><br>';
                $y++;
            }
	$html.='<div style="height:3%;"></div>';


// ******************* End KMC  time pdf *******************//
// ******************* Start Feefing pdf *******************//
        $babyId = $getlastAdmissiondata['babyId'];
        $MotherDetail =  $this->db->query("SELECT MR.`motherName`, BR.`deliveryDate`, BR.`babyWeight` FROM motherRegistration as MR LEFT JOIN babyRegistration as BR  on BR.`motherId` =  MR.`motherId`  WHERE BR.`babyId` = '".$babyId."'")->row_array();
        $Age = $this->TestDate($MotherDetail['deliveryDate']);
        $BabyAge = ($Age>0) ?  $Age.' days' :'_______________________';
            foreach ($GetDay as $key => $value) {
            $html.='<div style="width:100%;">
                        <div>
                          <h2 style= "text-align:center"> <u>FORM B: DAILY INTAKE MONITORING RECORD </u></h2>
                          <p style="font-size: 14px"> <b>Objective:</b> To record the quantity and frequency of feeding of the baby admitted in the KMC unit in 24 hours (8 AM - 8 Am), so as to compare the total quantity to the total feeding requirement. To be filled by nurse on duty in the KMC </p>
                        </div>

                        <div style=" padding-bottom: 5px; padding-top: 5px">
                          <label> <b>Day :</b> '.date('l',time()).'</label> 
                          <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Hospital Reg. No.:</b>  '.$getlastAdmissiondata['babyFileId'].'</label> 
                          <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Date (dd/mm/yyyy)</b>: '.date('d/m/Y',strtotime($value['feedDate'])). '</label>
                        </div>
                  
                
                         <div style=" padding-bottom: 5px; padding-top: 5px">
                          <label> <b>Mother Name :</b>  '.ucwords($MotherDetail['motherName']).'</label> 
                          <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Baby age(in days):</b> '.$BabyAge.' </label> 
                          <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total feeding requirement for the day</b>: _________________________________</label>
                        </div>

                  <table width="100%" border="1" style="text-align: center">
                      <tr>
                        <th rowspan="3" style="width: 10px">S.No.</th>
                        <th rowspan="3" style="width: 100px">Time of feeding<br>( From, to)</th>
                        <th colspan="8" style="width: 650px">Feeding method and measurement <br>(fill in where applicable) </th>
                        <th colspan="5" rowspan="2">Supplements Received<br>(name and dose)</th>
                        <th rowspan="2" style="width: 80px">Nurse Signature</th>
                      </tr>

                      <tr>
                       
                        <th rowspan="2" style="width: 100px">Direct breast feeding (in min)  </th>
                        <th rowspan="2" style="width: 100px">Expressed breast feed (EBF) (in ml)  </th>
                        <th colspan="4">Mixed Feeding (in ml)</th>
                        <th colspan="2">Other:* IV type</th>
                      </tr>

                      <tr>
                        <th>EBF</th>
                        <th>Formula</th>
                        <th>Other</th>
                        <th>Net</th>
                        <th>In ml/hr</th>
                        <th>In drop/min</th>
                        <th>Vit D3</th>
                        <th>Calcium</th>
                        <th>HMF</th>
                        <th>Iron</th>
                        <th>Other</th>
                        <th></th>
                      </tr>';

                        $GetKMCDayDetail = $this->db->query("SELECT * FROM `babyDailyNutrition`  where  loungeId = '".$loungeId."' AND babyId = '".$babyId."' And feedDate = '".$value['feedDate']."' AND babyAdmissionId = '".$getBabyFileId['id']."'")->result_array();
                        $i = 1;
                        $Time = array();
                        $rowCount = count($GetKMCDayDetail)+1;
                        $getRowCount = 11 - $rowCount;
                        foreach ($GetKMCDayDetail as $key => $value2) {

                      $html.= '<tr>
                                <td>'.$i.'</td>
                                <td>'.date('g:i A',strtotime($value2['FeedTime'])).'</td>
                                <td>'.$value2['breastFeedDuration'].'</td>
                                <td>'.$value2['milkQuantity'].'</td>
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
                              </tr>';
                      $i++;
                    }

                    if(($getRowCount < 11) && ($getRowCount > 0))
                        {
                            for($z = $rowCount; $z <= 11 ; $z++) { 
                            $html.= '<tr style="border:1px solid" >  
                                        <td style="width: 5%;text-align: center;border:1px solid; padding: 11px;border-bottom:none;">'.$z.'</td>
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
                                        <td></td>
                                        <td></td>
                                         </tr>';
                            }
                        }   
                    $html.='</table></div>';                    
                }
	$html.='<div style="height:3%;"></div>';
              

// ******************* End feeding time pdf *******************//
// ******************* Start Daily Discharge time pdf *******************//

        if($type == 1)
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

            $Day = getDateDifferenceWithCurrent($GetData['addDate']);
            $WeigthOnDischarge = ($GetData['babyDischargeWeight'] != '') ? $GetData['babyDischargeWeight'].' grams' : 'N/A';

            $NetGain = $WeigthOnDischarge - $GetData['babyWeight'];  
            $reffered = $GetData['referredFacilityName']." ".$GetData['referredFacilityAddress'];
            $refferedReson = ($GetData['referredReason']!='') ? $GetData['referredReason'] :'_________________________';

            $DischargeDate    = ($GetData['dateOfDischarge'] != '') ? date('d/m/Y',strtotime($GetData['dateOfDischarge'])) : 'N/A';
            $dischargeWeightsGainOrLoss = ($GetData['babyDischargeWeight'] != '') ? $GetData['weightGainLosePostAdmission'] : 'N/A';

            $discharge = json_decode($GetData['DischargeChecklist'],true);
            foreach ($discharge as $key => $value) {
           
              }
        }
        
        $html.='<div>
                <h3 style= "text-align:  center"> <u>DISCHARGE CHECKLIST FOR KMC UNIT</u> </h3>
                </div>

                <div  style="padding-bottom: 2px; padding-top: 2px">
                  
                  <label style="padding-right: 10%"> <b>Hospital Reg. No.:</b>  '. $Hospitalreg.'</label> 
                  <label style=" padding-left: 10%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>MCTS NO.</b>: '.$MCTSNo.'</label>
                  </div>
                  <br> 

                <div  style="padding-bottom: 2px; padding-top: 2px">
                  <label style="width: 40%; padding-right: 10%"> <b>Name of mother:</b> '. $GetData['motherName'].'</label> 
                  <label style="width: 40%; padding-left: 10%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Date of discharge :</b>'.$DischargeDate.'</label>
                </div>
                  <br> 

                <div>
                <div  style="padding-bottom: 2px; padding-top: 2px">
                  
                  <label><b>Number of days spend in KMC room (excluding days spent in SNCU/ NBSU):</b>  '.$Day.' days</label> 
                  <br>
                  <label> <b>weight on discharge(in grams):</b>  '.$WeigthOnDischarge.'</label>
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
                  
                  <label ><b>type of discharge :</b>  '.$GetData['typeOfDischarge'].'</label> 
                 
                  </div>
                  <br> 

                <div  style="padding-bottom: 2px; padding-top: 2px">
                  <h4><u>In case of referral</u> </h4>             
                  <label ><b>Name and address of facility reffered to:</b> '.$reffered.'</label> 
                </div>
                  <br> 
                <label ><b>reason for referral:</b> '.$refferedReson.'</label> 
                  <br> 
            
             <div>

                <div>
                  <h3 style= "text-align:  center"> DISCHARGE CHECKLIST FOR KMC UNIT </h3>
                </div>


               <div>

                  <div style="padding-bottom: 2px; padding-top: 2px">';
                        $discharge = json_decode($GetData['DischargeChecklist'],true);
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
        $mpdf        = new mPDF('utf-8', 'A4-R');
		$PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		$mpdf->WriteHTML($PDFContent);
		$mpdf->Output($pdfFilePath, "F"); 
		
		return $filename;   	
    }


//for use in admission pdf 

	public function GetMotherAllData($motherId)
	{
		return $this->db->query("SELECT * FROM motherRegistration AS MR LEFT JOIN motherAdmission AS MA ON MR.`motherId` = MA.`motherId`  WHERE MR.`motherId` = '".$motherId."'")->row_array();
	}

	public function GetBabyAllData($babyId)
	{   
		return $this->db->query("SELECT *,BA.`addDate` as addDate FROM  babyRegistration AS BR LEFT JOIN babyAdmission AS BA ON BR.`babyId` = BA.`babyId`  WHERE BR.`babyId` = '".$babyId."' order by BA.`id` desc")->row_array();
	      // echo $this->db->last_query();exit;
	}
    public function DistrictVillageBlock($id, $type='')
     {

     	if($type=='1'){
			$query= $this->db->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs` 		where `revenuevillagewithblcoksandsubdistandgs`.`GPPRICode`= '".$id."' limit 0,1")->row_array();
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

  //use in feeding pdf
	public function TestDate($date1)
	{
		$now = time(); 
		$your_date = strtotime($date1);
		$datediff = $now - $your_date;
		return round($datediff / (60 * 60 * 24));
	}   
}
