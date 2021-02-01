<?php
class GeneratePdfSNCU extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();	
		include_once APPPATH.'/third_party/mpdf/mpdf.php';  
    date_default_timezone_set("Asia/KolKata");
	}
	
    public function createFinalSNCUPdf($babyAdmissionId,$staffId)
    {
    	$getBabyData = $this->db->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`=br.`babyId` where ba.id=".$babyAdmissionId."")->row_array();

        $this->db->order_by('id','desc');
        $getBabyMonitoring = $this->db->get_where('babyDailyMonitoring',array('babyAdmissionId'=>$getBabyData['id']))->row_array();

    	 $getMotherData = $this->db->query("select * from motherRegistration as mr inner join motherAdmission as ma on mr.`motherId`=ma.`motherId` where mr.motherId=".$getBabyData['motherId']."")->row_array();

        $this->db->order_by('id','desc');
        $getMotherMonitoring = $this->db->get_where('motherMonitoring',array('motherAdmissionId'=>$getMotherData['id']))->row_array();

        $getStaffData = $this->db->get_where('staffMaster',array('staffId'=>$staffId))->row_array();
          

          // set mother Age
        $motherAgeData = !empty($getMotherData['motherAge']) ? $getMotherData['motherAge'].' Yrs' : '--';

        $motherWeightData = !empty($getMotherData['motherWeight']) ? round($getMotherData['motherWeight'],2).' Kgs' : '--';

        $ageAtMarriage = !empty($getMotherData['ageAtMarriage']) ? round($getMotherData['ageAtMarriage'],2).' Yrs' : '--';
        error_reporting(0); 
        $html.= '<html>
       <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style type="text/css">
           span.dotted{
              border-bottom: 1px dashed #000;
              text-decoration: none; 
            }
            .headingFont{
              font-size:14px;
            }
            .contentPadding{
               padding:3px;
               border: 1px solid black;
                font-size:12px;
            }table {
                border-collapse: collapse;
              }
              .tableSecContent{
                font-size: 10px;
                padding:3px;
              }
        </style>
    </head>
      <body>
          <div style="width:100%;height:1122px;">
            <table width="100%">
              <tr>
                <td style="text-align: left;"><img src="'.base_url().'assets/helth.png" style="width: 75px;height: 75px;"></td>
                <td style="text-align: center;"><img src="'.base_url().'assets/born.png" style="width: 80px;height: 75px;"></td>
                <td style="text-align: right;"><img src="'.base_url().'assets/uplogo.png" style="width: 75px;height: 75px;"></td>
              </tr>
            </table>
                <!-- set heading of pdf form -->
                <h3 style="text-align: center;margin: auto;">SICK NEW BORN CARE UNIT</h3>
                <h4 style="text-align: center;margin: auto;"><span class="dotted">Veerangna Avanti Bai Mahila Hospital, Lucknow</span></h4>
                <h3 style="text-align: center;margin-top: 5px;margin-bottom: -15px !important;">NEONATAL CASE RECORD SHEET</h3>
                <p style="font-size: 13px; font-weight: bold;text-align: center;margin:auto;">(Developed by UNICEF for NHM)</p>
               
              <table width="100%" style="margin-left: 15px;margin-right: 15px !important;">
                <tr>
                  <td style="width: 50%;"><b class="headingFont">SNCU Reg. No.</b> '.$getBabyData['babyFileId'].'</td>
                  <td style="width: 50%;text-align:right;"><b class="headingFont">MCTS No.</b> '.$getMotherData['motherMCTSNumber'].' </td>
                </tr>
                <tr margin-bottom: 5px;>
                  <td style="width: 100%;" colspan="2"><b class="headingFont">Doctor In Charge:</b> '.ucwords($getStaffData['name']).'</td> 
                </tr>
              </table>

                  <table width="100%" style="margin-top:8px;">
                    <tr>
                      <td class="contentPadding">Baby Of (Mothers Name)</td>
                      <td class="contentPadding" colspan="2"> '.ucwords($getMotherData['motherName']).'</td>
                      <td class="contentPadding"></td>
                    </tr>
                 
                    <tr>
                      <td class="contentPadding">Fathers Name</td>
                      <td class="contentPadding" colspan="2"> '.ucwords($getMotherData['fatherName']).'</td>
                      <td class="contentPadding"></td>
                    </tr>


                    <tr>
                      <td class="contentPadding">Complete Address with<br>Village Name / Ward No.</td>
                      <td class="contentPadding" colspan="3"> '.ucwords($getMotherData['presentAddNearByLocation']).'</td>
                    </tr>

                    <tr>
                      <td class="contentPadding">Contact No. & Relation</td>
                      <td class="contentPadding" colspan="3"> '.$getMotherData['motherMoblieNumber'].'</td>
                    </tr>

                    <tr>
                      <td class="contentPadding">Date and Time of Birth</td>
                      <td class="contentPadding"> '.date("d-m-Y g:i A",$getMotherData['addDate']).'</td>
                      <td class="contentPadding" colspan="2"> Birth Weight (Kg): '.round($getBabyData['babyWeight']/1000,2).'</td>
                    </tr>

                    <tr>
                      <td class="contentPadding">Date and Time of Admission</td>
                      <td class="contentPadding"> '.date("d-m-Y g:i A",$getBabyData['addDate']).'</td>
                      <td class="contentPadding">Age on Admission (Days): 1</td>
                      <td class="contentPadding">Wt. on Admission (Kg): '.round($getBabyData['babyWeight']/1000,2).'</td>
                    </tr>

                    <tr>
                      <td class="contentPadding">Date and Time of Discharge</td>
                      <td class="contentPadding"> N/A</td>
                      <td class="contentPadding">Age on Discharge (Kg): N/A</td>
                      <td class="contentPadding">Wt. on Discharge (Kg): N/A</td>
                    </tr>

                    <tr>
                      <td class="contentPadding">Type of Admission</td>
                      <td class="contentPadding" colspan="3"> '.$getBabyData['typeOfBorn'].'</td>
                    </tr>

                    <tr>
                      <td class="contentPadding">Place of Delivery</td>
                      <td class="contentPadding" colspan="3"> '.$getMotherData['deliveryPlace'].'</td>
                    </tr>

                    <tr>
                      <td class="contentPadding">Reffered From</td>
                      <td class="contentPadding"> N/A</td>
                      <td class="contentPadding" colspan="2">Mode of Transport: Self Arranged/Govt. Provided</td>
                    </tr>

                  </table>


                                <table width="100%" border="1" style="margin-top:10px;">
                                  <tr>
                                    <td colspan="3"><b>Indication for Admission</b><span style="font-size:12px;">(Encircle the most relevant single indication, If multiple indication also mention all relevant numbers in the end as per priority)</span></td>
                                  </tr>

                                  <tr>
                                    <td style="border-right-style:hidden !important;" class="tableSecContent" valign="top">
                                      <ol>
                                        <li>Prematurity <34 weeks</li>
                                        <li>Low Birth Weight <1800 gm.</li>
                                        <li>Perinatal Asphyxia</li>
                                        <li>Neonatal jaundice</li>
                                        <li>Resp. Distress (Rate>60 or Grunt/Retractions)</li>
                                        <li>Large Baby(>4 Kg. at 40 weeks)</li>
                                        <li>Refusal to Feed</li>
                                        <li>Central Cyanosis</li>
                                        <li>Apnea / Gasping</li>
                                      </ol> 
                                    </td>
                                    <td style="border:0 !important;" class="tableSecContent" valign="top">
                                      <ol>
                                        <li>Neonatal Convulsions</li>
                                        <li>Baby of Diabetic mother</li>
                                        <li>Oliguria</li>
                                        <li>Abdominal Distension</li>
                                        <li>Hypothermia <35.4 &deg;C</li>
                                        <li>Hypothermia >37.5 &deg;C</li>
                                        <li>Hypoglycemia <45 mg%</li>
                                        <li>Shock : cold Periphery with<br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;CFT >3 sec & Week Fast Pulse
                                        </li>
                              
                                      </ol> 
                                    </td>
                                    <td style="border-left-style:hidden !important;" class="tableSecContent" valign="top">
                                      <ol>
                                        <li>Meconium Aspiration</li>
                                        <li>Bleeding</li>
                                        <li>Diarrhoea</li>
                                        <li>Major Congenital Malformation</li>
                                        <li>Unconsciousness</li>
                                        <li>Any Other (......................)</li>
                                        <li><b>Multiple Indication-</b><br>
                                         &nbsp;&nbsp;&nbsp;&nbsp;Mention All Relevant Numbers:
                                         <br> &nbsp;&nbsp;&nbsp;&nbsp;a.....b.....c......d.....
                                         </li>
                                        
                              
                                      </ol> 
                                    </td>
                                  </tr>

                                  <tr>
                                    <td colspan="3" style="Padding:5px;"><b>Provisional Diagnosis</b></td>
                                  </tr>                   
                                </table>
                          <!-- last table data -->
                                <table width="100%" border="1" style="margin-top:10px;">
                                  <tr>
                                    <td colspan="3"><b>*Final Diagnosis</b><span style="font-size:12px;">(Encircle the most relevant single diagnosis, If multiple causes also mention all relevant numbers in the end as per sequence)</span></td>
                                  </tr>

                                  <tr>
                                    <td style="border-right-style:hidden !important;" class="tableSecContent" valign="top">
                                      <ul>
                                        <li>ELBW(999 gm or less) :P 07.0</li>
                                        <li>Other LBW(1000 gm - 2499 gm):P 07.1</li>
                                        <li>Extrene Immaturity(<28 Weeks):P 07.2</li>
                                        <li>Prematurity(28-<37 Weeeks):P 07.3</li>
                                        <li>Small for Gestational Age(IUGR):P 05.1</li>
                                        <li>Neonatal Aspiration of Meconium:P 24.0</li>
                                        <li>RDS of Newborn(HMD):P 22.0</li>
                                        <li>Transient Tachypnoea of newborn::P 22.1</li>
                                        <li>Pneomothorax ::P 25.1</li>
                                        <li>Congenital Pneomonia:P 22</li>
                                        <li>Aquired Pneomonia:J 15</li>
                                        <li>Primary Sleep Apnoea of Newborn:P 28.3</li>
                                        <li>Birth Asphyxia:P 21.0</li>
                                        <li>HIE of Newborn:P 91.6</li>
                                        <li>Neonatal Sepsis:P 36.9</li>
                                        <li>Meningitis:G 00</li>
                                      </ul> 
                                    </td>
                                    <td style="border-left-style:hidden; border-right-style:hidden !important;" class="tableSecContent" valign="top">
                                      <ul>
                                        <li>
                                           Convulsions of Newborn:P 90<br>
                                           &nbsp;&nbsp;&nbsp;&nbsp;(Hypoxic, Hypoglycaemic, Hypocalcaemic,<br>
                                           &nbsp;&nbsp;&nbsp;&nbsp;CNS Infections, Birth Trauma, Metabolic,<br>
                                           &nbsp;&nbsp;&nbsp;&nbsp;Other, Unknown Cause)
                                        </li>
                                        <li>Hemolytic disease of Newborn:P 55</li>
                                        <li>Neonatal jaundice:P 59</li>
                                        <li>Acute Renal Failure:N 17</li>
                                        <li>Neonatal Cardiac Failure:P 29.0</li>
                                        <li>Shock:R 57</li>
                                        <li>DIC:P 60</li>
                                        <li>Intraventricular Hemorrhage:P 52.3</li>
                                        <li>Neonatal Diarrhoea:A 09</li>
                                        <li>Tetanus Neonatorum:A 33</li>
                                        <li>Hypothermia of Newborn:P 80</li>
                                        <li>Enviromental Hypothermia of Newborn:P 81.0</li>
                                        <li>Neonatal Hypoglycaemia:P 70.4</li>
                              
                                      </ul> 
                                    </td>
                                    <td style="border-left-style:hidden !important;" class="tableSecContent" valign="top">
                                      <ul>
                                        <li>Congenital Malformation:
                                           <br>&nbsp;&nbsp;&nbsp;&nbsp;(a)Cong. Diaphragmatic Hernia:Q 79.0
                                           <br>&nbsp;&nbsp;&nbsp;&nbsp;(b)Cong. Hydrocephalus:Q 03
                                           <br>&nbsp;&nbsp;&nbsp;&nbsp;(c)Meningomyelocele:Q 0.5
                                           <br>&nbsp;&nbsp;&nbsp;&nbsp;(d)Imperforate anus:Q 42.3
                                           <br>&nbsp;&nbsp;&nbsp;&nbsp;(e)T.O. Fistula:Q 39.2
                                           <br>&nbsp;&nbsp;&nbsp;&nbsp;(f)Congenital Heart Disease:Q 21
                                           <br>&nbsp;&nbsp;&nbsp;&nbsp;(g)Cleft Palate:Q 35
                                           <br>&nbsp;&nbsp;&nbsp;&nbsp;(h)Cleft lip:Q 36
                                           <br>&nbsp;&nbsp;&nbsp;&nbsp;(i)Cleft Palate with Cleft Lip:Q 37
                                           <br>&nbsp;&nbsp;&nbsp;&nbsp;(j)Congenital Deformities of Hip:Q 65
                                           <br>&nbsp;&nbsp;&nbsp;&nbsp;(k)Congenital Deformities of Feet:Q 66
                                           <br>&nbsp;&nbsp;&nbsp;&nbsp;(l)Other Malformation(...............)
                                        </li>
                                        <li>Any Other Dignosis(.............)</li>
                                        <li><b>Multiple Dignosis-</b><br>
                                         &nbsp;&nbsp;&nbsp;&nbsp;Mention All Relevant Codes:
                                         <br> &nbsp;&nbsp;&nbsp;&nbsp;a.....b.....c......d.....
                                         </li>
                                        
                              
                                      </ul> 
                                    </td>
                                  </tr>

                                </table>
                    </div><br/>


<!-- new pdf generate -->


        <style type="text/css">
           span.dotted{
              border-bottom: 1px dashed #000;
              text-decoration: none; 
            }
            .paddingContent{
               padding:5px;
               border: 1px solid black;
            }
              .contentSecTables{
                font-size: 11px;
                padding-left:5px;
                height: 30px !important;
              }/*td{
                height: 30px !important;
              }td {
                padding: 5px;
              }*/
        </style>
              <div style="height:1122px;">

                <h3 style="text-align: center;margin: auto;">MOTHER'."'".'S INFORMATION : Past History and ANC Period</h3><br>
                  <div style="border:1px solid;padding:8px !important;">
                  <table width="100%" >
                    <tr>
                      <td style="border-right-style:hidden !important;" class="contentSecTables" valign="top">
                          Mother'."'".'s Age '.$motherAgeData.'
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSecTables" valign="top">
                         Mother'."'".'s Wt '.$motherWeightData.'
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSecTables" valign="top">
                        Age at Marriage '.$ageAtMarriage.'
                      </td>
                    </tr>


                    <tr>
                      <td style="border-right-style:hidden; !important;" colspan="2" class="contentSecTables" valign="top">
                        Consaguinity: Yes/No
                      </td>
                      <td style="border-left-style:hidden; !important;" colspan="2" class="contentSecTables" valign="top">
                        Birth Spacing: < 1Yr/1-2Yr/>2-3Yr/>3Yr/Not Applicable
                      </td>
                    </tr>


                    <tr>
                      <td style="border-right-style:hidden !important;" class="contentSecTables" valign="top">
                        gravida:........
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSecTables" valign="top">
                         para:.......
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSecTables" valign="top">
                       live Birth:....
                      </td>
                      <td style="border-left-style:hidden !important;" class="contentSecTables" valign="top">
                      abortion:.......
                      </td>
                    </tr>

                    <tr>
                      <td style="border-right-style:hidden !important;" class="contentSecTables" valign="top">
                         LMP:../../..
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSecTables" valign="top">
                         EDD:../../..
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSecTables" valign="top">
                        Gestation Weeks:........
                      </td>
                    </tr>



                    <tr>
                      <td style="border-right-style:hidden !important;" class="contentSecTables" valign="top">
                         Antenatal Visits
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSecTables" valign="top">
                         :None / 1 / 2 / 3 / 4
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSecTables" valign="top">
                        T.T Doses: None / 1 / 2
                      </td>
                    </tr>


                    <tr>
                      <td style="border-right-style:hidden !important;" class="contentSecTables" valign="top">
                         Hb
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSecTables" valign="top">
                        :........
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSecTables" valign="top">
                        Blood Group:........
                      </td>
                    </tr>


                    <tr>
                      <td style="border-right-style:hidden; !important;" class="contentSecTables" valign="top">
                       PIH
                      </td>
                      <td style="border-left-style:hidden; !important;" colspan="3" class="contentSecTables" valign="top">
                        :No Yes [Hypertension/Pre Eclampsia/Eclampsia]
                      </td>
                    </tr>


                    <tr>
                      <td style="border-right-style:hidden; !important;" class="contentSecTables" valign="top">
                       Drug
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSecTables" valign="top">
                        :No [ ] Yes [ ] (...................)
                      </td>
                      <td style="border-left-style:hidden; !important;" colspan="3" class="contentSecTables" valign="top">
                        Radiation: Yes [ ] No [ ]
                      </td>
                    </tr>



                    <tr>
                      <td style="border-right-style:hidden; !important;" class="contentSecTables" valign="top">
                       Illness
                      </td>
                      <td style="border-left-style:hidden; !important;" colspan="3" class="contentSecTables" valign="top">
                        :Malaria/TB/jaundice/Rash with fever/U.T.I/Syphills/Other(...................)
                      </td>
                    </tr>

                    <tr>
                      <td style="border-right-style:hidden !important;" class="contentSecTables" valign="top">
                         APH
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSecTables" valign="top">
                         : Yes [ ] No [ ]
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSecTables" valign="top">
                        GDM: Yes [ ] No [ ]
                      </td>
                    </tr>

                    <tr>
                      <td style="border-right-style:hidden; !important;" class="contentSecTables" valign="top">
                       Thyroid
                      </td>
                      <td style="border-left-style:hidden; !important;" colspan="3" class="contentSecTables" valign="top">
                        :Euthyroid(N)/Hypothyroid/Hyperthyroid/Not Known
                      </td>
                    </tr>


                    <tr>
                      <td style="border-right-style:hidden !important;" class="contentSecTables" valign="top">
                         VDRL
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSecTables" valign="top">
                         :Not Done / +Ve / -Ve 
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSecTables" valign="top">
                        HbsAg:Not Done / +Ve / -Ve 
                      </td>
                    </tr>

                    <tr>
                      <td style="border-right-style:hidden !important;" class="contentSecTables" valign="top">
                         HIV Testing
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSecTables" valign="top">
                         :Done/Not Done 
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSecTables" valign="top">
                       Amniotic Fluid Volume:Adequate/Polihydraminos/Olygohyd. 
                      </td>
                    </tr>

                    <tr>
                      <td  class="contentSecTables" colspan="4" valign="top">
                         Other Significant Information:
                      </td>
                    </tr>

                  </table>
                  </div>

        <!-- set heading of pdf form --><br>

                <h3 style="text-align: center;margin: auto;">MOTHER'."'".'S INFORMATION : During Labour</h3><br>
                  <div style="border:1px solid;padding:8px !important;">
                    <table width="100%" >

                      <tr>
                        <td style="border-right-style:hidden !important;" class="contentSecTables" valign="top">
                           Antenatal Steroids
                        </td>
                        <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSecTables" valign="top">
                           : Yes [ ] No [ ]
                       </td>
                        <td style="border-left-style:hidden;border-right-style:hidden;margin-right:50px; !important;" colspan="2" class="contentSecTables" valign="top">
                           If Yes, Betamethasone [ ] / Dexamethasone [ ]
                        </td>
                      </tr>

                      <tr>
                        <td style="border-right-style:hidden !important;" class="contentSecTables" valign="top">
                           No. of doses
                        </td>
                        <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSecTables" valign="top">
                           : [1] [2] [3] [4]
                       </td>

                        <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSecTables" valign="top">
                           Time Between Last Dose & Delivery.....hrs./.... Days
                        </td>
                      </tr>

                      <tr>
                        <td style="border-right-style:hidden; !important;" class="contentSecTables" valign="top">
                         H/O fever
                        </td>
                        <td style="border-left-style:hidden; !important;" colspan="3" class="contentSecTables" valign="top">
                          : In 1st Trimester/in 2nd Trimester/in 3rd Trimester/During Labor only if >100.4F
                        </td>
                      </tr>

                      <tr>
                        <td style="border-right-style:hidden !important;" class="contentSecTables" valign="top">
                           Foul Smelling Discharge
                        </td>
                        <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSecTables" valign="top">
                           : Yes [ ] No [ ]
                       </td>
                        <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSecTables" valign="top">
                           Uterine Tenderness: Yes [ ] No [ ] 
                        </td>
                      </tr>

                      <tr>
                        <td style="border-right-style:hidden !important;" class="contentSecTables" valign="top">
                           Leaking P.V > 24 Hours
                        </td>
                        <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSecTables" valign="top">
                           : Yes [ ] No [ ]
                       </td>
                        <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSecTables" valign="top">
                           PIH: Hypertension/Pre Eclampsia/Eclampsia
                        </td>
                      </tr>

                      <tr>
                        <td style="border-right-style:hidden; !important;" class="contentSecTables" valign="top">
                         PPH
                        </td>
                        <td style="border-left-style:hidden; !important;" colspan="3" class="contentSecTables" valign="top">
                          : Yes [ ] No [ ]
                        </td>
                      </tr>

                      <tr>
                        <td style="border-right-style:hidden; !important;" class="contentSecTables" valign="top">
                         Amniotic Fluid
                        </td>
                        <td style="border-left-style:hidden; !important;" colspan="3" class="contentSecTables" valign="top">
                          : Clear/Blood Stained/Meconium Stained/Foul Smelling
                        </td>
                      </tr>

                      <tr>
                        <td style="border-right-style:hidden !important;" class="contentSecTables" valign="top">
                           Presentation
                        </td>
                        <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSecTables" valign="top">
                           : Vertex/Breech/Transverse
                       </td>
                        <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSecTables" valign="top">
                           Labour: Spontaneous/Induced
                        </td>
                      </tr>

                      <tr>
                        <td style="border-right-style:hidden; !important;" class="contentSecTables" valign="top">
                         Course of Labour
                        </td>
                        <td style="border-left-style:hidden; !important;" colspan="3" class="contentSecTables" valign="top">
                          : Uneventful/Prolonged 1st stage/Prolonged 2nd stage/Obstructed
                        </td>
                      </tr>

                      <tr>
                        <td style="border-right-style:hidden !important;" class="contentSecTables" valign="top">
                           E/O Feotal Distress
                        </td>
                        <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSecTables" valign="top">
                           : Yes [ ] No [ ]
                       </td>
                        <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSecTables" valign="top">
                           type of Delivery: LSCS/AVD/NVD
                        </td>
                      </tr>


                      <tr>
                        <td style="border-right-style:hidden; !important;" class="contentSecTables" valign="top">
                         Indication for Caesarean,<br>
                         if Applicable
                        </td>
                        <td style="border-left-style:hidden; !important;" colspan="3" class="contentSecTables" valign="top">
                          : [Cephalo Pelvic Disproportion][Malpresentation][Placenta Previa][Obstructed Labor][Feotal Distress]<br>
                          &nbsp;&nbsp;[Prolonged Labour][Cord Prolabse][Failed Induction (Dystocia)][Previous LSCS][Other....]
                        </td>
                      </tr>

                      <tr>
                        <td style="border-right-style:hidden; !important;" class="contentSecTables" valign="top">
                         Delivery Attended by
                        </td>
                        <td style="border-left-style:hidden; !important;" colspan="3" class="contentSecTables" valign="top">
                          : [Doctor] [Nurse] [ANM] [Dai] [relative] [Any Other]...............
                        </td>
                      </tr>
                      <tr>
                        <td  class="contentSecTables" colspan="4" valign="top">
                           Other Significant Information:
                        </td>
                      </tr>

                    </table>
                  </div>
                 </div> <br/><br/>
<!-- new pdf generate -->
    <style type="text/css">

            .paddingOfContent{
               border: 1px solid black;
               padding: 5px;
            }table {
                border-collapse: collapse;
              }
              .contentSizeSetting{
                font-size: 12px;
                padding-left:5px;
                height: 30px !important;
              }
        </style>
              <div style="height:1122px;">
   <h3 style="text-align: center;margin: auto;">BABY'."'".'S INFORMATION :At Birth</h3><br>
                  <div style="border:1px solid;" >
                      <table width="100%">
                          <tr>
                            <td style="border-right-style:hidden !important;" class="contentSizeSetting" valign="top">
                               Cried Immed. after Birth
                            </td>
                            <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSizeSetting" valign="top">
                               : Yes [ ] No [ ]
                           </td>

                            <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSizeSetting" valign="top">
                              Wt at Birth:........Kgs.
                            </td>
                          </tr>


                          <tr>
                            <td style="border-right-style:hidden !important;" class="contentSizeSetting" valign="top">
                               Gestational age
                            </td>
                            <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSizeSetting" valign="top">
                               : .......... in completed weeks
                           </td>

                            <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSizeSetting" valign="top">
                              Maturity: Preterm(<37 Wk)/Full term/Post term(>=42 Wk)
                            </td>
                          </tr>


                          <tr>
                            <td style="border-right-style:hidden !important;" class="contentSizeSetting" valign="top">
                               Was APGAR Score Recordered
                            </td>
                            <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSizeSetting" valign="top">
                               : Yes [ ] No [ ]
                           </td>

                            <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSizeSetting" valign="top">
                              APGAR value: ..........
                            </td>
                          </tr>

                          <tr>
                            <td style="border-right-style:hidden; !important;" class="contentSizeSetting" valign="top">
                             Resuscitation Required
                            </td>
                            <td style="border-left-style:hidden; !important;" colspan="3" class="contentSizeSetting" valign="top">
                              : Yes [ ] No [ ] Tactile Simulation/Only Oxygen/Bag & Mak [duration...min.]/<br/>
                              Intubation/Chest compression/Adrenaline
                            </td>
                          </tr>


                          <tr>
                            <td style="border-right-style:hidden !important;" class="contentSizeSetting" valign="top">
                               Vitamin K Given
                            </td>
                            <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSizeSetting" valign="top">
                               : Yes [ ] No [ ]
                           </td>

                            <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSizeSetting" valign="top">
                              Breast Fed within 1 Hour: Yes [ ] No [ ]
                            </td>
                          </tr>
                      </table>
                  </div>



                <!-- set heading of pdf form --><br>
                <h3 style="text-align: center;margin: auto;">BABY'."'".'S INFORMATION : On Admission</h3><br>
                  <div style="border:1px solid;" >
                  <table width="100%" style="height:100px;">
                    <tr>
                      <td class="contentSizeSetting" style="height:100px;" valign="top">
                         PRESENTINGS COMPLAINTS:
                      </td>
                    </tr>
                  </table>
                  </div>







                <!-- set heading of pdf form --><br>
                <h3 style="text-align: center;margin: auto;">GENERAL EXAMINATION</h3><br>
                  <div style="border:1px solid;" >
                  <table width="100%" >

                    <tr>
                      <td style="border-right-style:hidden !important;" class="contentSizeSetting" valign="top">
                        General condition
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSizeSetting" valign="top">
                         [Alert] [Lethargic] [Comatose]
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSizeSetting" valign="top">
                       Temperature ....&deg;C
                      </td>
                      <td style="border-left-style:hidden !important;" class="contentSizeSetting" valign="top">
                      Heart Rate...../min
                      </td>
                    </tr>

                    <tr>
                      <td style="border-right-style:hidden !important;" class="contentSizeSetting" valign="top">
                        Apnea
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSizeSetting" valign="top">
                        : Yes [ ] No [ ]
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSizeSetting" valign="top">
                       RR....../min
                      </td>
                      <td style="border-left-style:hidden !important;" class="contentSizeSetting" valign="top">
                       B.P......
                      </td>
                    </tr>

                    <tr>
                      <td style="border-right-style:hidden !important;" class="contentSizeSetting" valign="top">
                         Grunting
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSizeSetting" valign="top">
                         : Yes [ ] No [ ]
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSizeSetting" valign="top">
                        Chest Indrawing: Yes [ ] No [ ]
                      </td>
                    </tr>

                    <tr>
                      <td style="border-right-style:hidden !important;" class="contentSizeSetting" valign="top">
                         Head Circumference
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSizeSetting" valign="top">
                         : ......c.m.
                     </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSizeSetting" valign="top">
                        Length: ......c.m.
                      </td>
                    </tr>

                      <tr>
                        <td style="border-right-style:hidden; !important;" class="contentSizeSetting" valign="top">
                         Color
                        </td>
                        <td style="border-left-style:hidden; !important;" colspan="3" class="contentSizeSetting" valign="top">
                          : Pink/Pale/Central Cyanosis/Peripheral Cyanosis
                        </td>
                      </tr>

                    <tr>
                      <td style="border-right-style:hidden !important;" class="contentSizeSetting" valign="top">
                         CRT >3 secs
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSizeSetting" valign="top">
                         : Yes [ ] No [ ]
                     </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSizeSetting" valign="top">
                        Skin pinch > 2 secs: Yes [ ] No [ ]
                      </td>
                    </tr>

                    <tr>
                      <td style="border-right-style:hidden !important;" class="contentSizeSetting" valign="top">
                        Meconium Stained Cord
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSizeSetting" valign="top">
                        : Yes [ ] No [ ]
                     </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSizeSetting" valign="top">
                        Cry: Absent/Feeble/Normal/High Pitch
                      </td>
                    </tr>

                    <tr>
                      <td style="border-right-style:hidden !important;" class="contentSizeSetting" valign="top">
                        Tone
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSizeSetting" valign="top">
                        : Limp/Active/Increase Tone
                     </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSizeSetting" valign="top">
                        Convulsions: Present on Admission/Past History/No
                      </td>
                    </tr>

                      <tr>
                        <td style="border-right-style:hidden; !important;" class="contentSizeSetting" valign="top">
                         Jaundice
                        </td>
                        <td style="border-left-style:hidden; !important;" colspan="3" class="contentSizeSetting" valign="top">
                          : Yes [ ] No [ ] if Yes, extent [Face][Chest][Abdomen][Legs][Palms/Soles]
                        </td>
                      </tr>

                      <tr>
                        <td style="border-right-style:hidden; !important;" class="contentSizeSetting" valign="top">
                         Bleeding
                        </td>
                        <td style="border-left-style:hidden; !important;" colspan="3" class="contentSizeSetting" valign="top">
                          : Yes [ ] No [ ] if Yes, specify site [Skin][Mouth][Rectal][Umbilicus]
                        </td>
                      </tr>

                    <tr>
                      <td style="border-right-style:hidden !important;" class="contentSizeSetting" valign="top">
                         Bulging Anterior Fontanel
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSizeSetting" valign="top">
                         : Yes [ ] No [ ]
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSizeSetting" valign="top">
                        Taking Breast Feeds: Yes [ ] No [ ]
                      </td>
                    </tr>


                    <tr>
                      <td style="border-right-style:hidden !important;" class="contentSizeSetting" valign="top">
                         Sucking
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSizeSetting" valign="top">
                         : [Good] [Poor] [No Sucking]
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSizeSetting" valign="top">
                        Attachment: [Well attached] [Poorly attached] [Not attached]
                      </td>
                    </tr>

                    <tr>
                      <td style="border-right-style:hidden !important;" class="contentSizeSetting" valign="top">
                         Umbilicus
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSizeSetting" valign="top">
                         : [Red] [Discharge] [Normal]
                     </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSizeSetting" valign="top">
                        Skin Pustales: [No] [Yes <10] [Yes >=10] [Abscess]
                      </td>
                    </tr>

                      <tr>
                        <td style="border-right-style:hidden; !important;" class="contentSizeSetting" valign="top">
                         Congenital Malformation
                        </td>
                        <td style="border-left-style:hidden; !important;" colspan="3" class="contentSizeSetting" valign="top">
                          : [No] [Yes] Diaphragmatic Hernia/Hydrocephalus/M.M.C./imperforate Anus/T.O Fistula/<br>
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          Cong. Heart Disease/Cleft palate/Cleft Lip/Cleft Palate width Cleft Lip/<br>
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          Cong. Deformity of Hip/Cong. Deformity of Feet/Other...............    

                        </td>
                      </tr>

                    <tr>
                      <td style="border-right-style:hidden !important;" class="contentSizeSetting" valign="top">
                         Blood
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="contentSizeSetting" valign="top">
                         : ...............
                     </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="contentSizeSetting" valign="top">
                        Oxygen Saturation: ...............
                      </td>
                    </tr>


                    <tr>
                      <td  class="contentSizeSetting" colspan="4" valign="top">
                         Other Significant Information:
                      </td>
                    </tr>

                  </table>
                  </div>
              </div>

<!-- new pdf generate -->
    <style type="text/css">
      .paddingOfContentWithTd{
        font-size: 12px;
        padding-left:5px;
        height: 30px !important;
        padding: 5px;
      }
    </style>
              <div style="height:1122px;">
                <h3 style="text-align: center;">SYSTEMIC EXAMINATION</h3>
                    <div style="border:1px solid;padding:8px !important;">
                      <table width="100%">
                        <tr>
                          <td style="border-right-style:hidden;width:30%; !important;" class="paddingOfContentWithTd" valign="top">
                              CVS 
                          </td>
                          <td style="border-left-style:hidden;border-right-style:hidden;width:70%; !important;" class="paddingOfContentWithTd" colspan="2" valign="top">
                            :...............................................................................................................................
                         </td>
                        </tr>

                                  <tr>
                                    <td style="border-right-style:hidden;width:30%; !important;" class="paddingOfContentWithTd" valign="top">
                                        RESPIRATORY 
                                    </td>
                                    <td style="border-left-style:hidden;border-right-style:hidden;width:70%; !important;" class="paddingOfContentWithTd" colspan="2" valign="top">
                                        :...............................................................................................................................
                                   </td>
                                  </tr>

                        <tr>
                          <td style="border-right-style:hidden;width:30%; !important;" class="paddingOfContentWithTd" valign="top">
                              PER ABDOMEN 
                          </td>
                          <td style="border-left-style:hidden;border-right-style:hidden;width:70%; !important;" class="paddingOfContentWithTd" colspan="2" valign="top">
                            :...............................................................................................................................
                         </td>
                        </tr>

                                  <tr>
                                    <td style="border-right-style:hidden;width:30%; !important;" class="paddingOfContentWithTd" valign="top">
                                        CNS 
                                    </td>
                                    <td style="border-left-style:hidden;border-right-style:hidden;width:70%; !important;" class="paddingOfContentWithTd" colspan="2" valign="top">
                                        :...............................................................................................................................
                                   </td>
                                  </tr>

                        <tr>
                          <td style="border-right-style:hidden;width:30%; !important;" class="paddingOfContentWithTd" valign="top">
                              OTHER SIGNIFICANT FINDING 
                          </td>
                          <td style="border-left-style:hidden;border-right-style:hidden;width:70%; !important;" class="paddingOfContentWithTd" colspan="2" valign="top">
                            :...............................................................................................................................
                         </td>
                        </tr>
                      </table>
                  </div>


            <!-- second section heading of pdf form -->

                <h3 style="text-align: center;">TREATMENT ADVISED : On Admission</h3>
                  <div style="border:1px solid;padding:8px !important;">
                    <table width="100%" >
                      <tr>
                        <td style="height:120px; !important;" class="paddingOfContentWithTd" valign="top">
                        </td>
                      </tr>
                    </table>
                  </div>

        <!-- Third section heading of pdf form -->

                <h3 style="text-align: center;">INVESTIGATIONS ADVISED : On Admission</h3>
                  <div style="border:1px solid;padding:8px !important;">
                    <table width="100%" >
                      <tr>
                        <td style="height:60px; !important;" class="paddingOfContentWithTd" valign="top">
                        </td>
                      </tr>
                    </table>
                  </div>

                    <div width="100%" style="" >

                    <div width="30%" style="float:left;" >
                      <br>
                      <img src="'.base_url().'assets/helth.png" style="width: 80px;height: 100px;"><br/>
                          <span style=""> Foot Print of Newborn<br/>
                          (Left Foot) </span>
                    </div>
                    <div width="70%" style="float:right;">
                    <p style="text-align:right;margin-top:14px;">Doctor'."'".'s Name and Signature</p>
                    <b align="center" style="text-align:center;">सहमति पत्र</b><br/>
                    हमें डॉक्टर द्वारा बता दिया गया है कि शिशु गंभीर रूप से बीमार है एवं उपचार के दौरान होने वाली जटिलताओं से हमें अवगत करा दिया गया है तथा हमें पूर्ण रूप से विदित है कि उपचार के दौरान समस्याए उत्पन्न हो सकती हैं| इन सभी खतरों से अवगत होने के बाद भी हम हमारे बच्चे को एस. एन. सी. यू. जिला चिकित्सालय में उपचार हेतु भर्ती कराने के लिए सहमत हैं|
                     <p style="text-align:right;margin-top: -8px;">अभिभावक के हस्ताक्षर</p>
                    </div>
                           

                    </div>


        <!-- Fourth section heading of pdf form -->

                <h3 style="text-align: center;">FINAL OUTCOME</h3>
                  <div style="border:1px solid;padding:8px;text-align:center; !important;">
                    <span class="paddingOfContentWithTd">Successfully Discharged/Left Against medical Advice/Referred/Expired</span>
                  </div>

                <h3 style="text-align: center;">In Case of Death : Mention Cause of Death<span style="font-size:12px;">(The most Relevent Single Indication)<span></h3>
                  <div style="border:1px solid;padding:8px !important;">
                    <table width="100%" >
                      <tr>
                                    <td style="border-right-style:hidden !important;" class="paddingOfContentWithTd" valign="top">
                                      <ol>
                                        <li>Respiratory Distress Syndrome</li>
                                        <li>Meconium Aspiration Syndrome</li>
                                        <li>HIE/Moderate-Severe Birth Asphyxia</li>
                                        <li>Sepsis</li>
                                        <li>Pneomonia</li>
                                      </ol> 
                                    </td>
                                    <td style="border:0 !important;" class="paddingOfContentWithTd" valign="top">
                                      <ol>
                                        <li>Meningitis</li>
                                        <li>Major Congenital Malformation</li>
                                        <li>E.L.B.W.(Wt. less than 1000g)</li>
                                        <li>Prematurity(<28 weeks of Gestation)</li>
                                        <li>Neonatal Tetanus</li>
                                      </ol> 
                                    </td>
                                    <td style="border-left-style:hidden !important;" class="paddingOfContentWithTd" valign="top">
                                      <ol>
                                        <li>Cause not established</li>
                                        <li>Any Other :............<br/>
                                            .............................<br/>
                                            .............................
                                        </li>
                                  

                                      </ol> 
                                    </td>
                      </tr>
                    </table>
                  </div>
              </div>
      </body>
  </html>'; 

        $pdfFilePath =  pdfDirectory."finalSNCU".$babyAdmissionId.".pdf";
        $mpdf =  new mPDF('utf-8', 'A4-R');
        $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        // for hindi content
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        // end form 
        $mpdf->WriteHTML($PDFContent);

        $mpdf->Output($pdfFilePath, "F"); 
        return "finalSNCU".$babyAdmissionId.".pdf";
    }

}