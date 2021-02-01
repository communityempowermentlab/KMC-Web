<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MncuPdf extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/baby_model');  
        include_once APPPATH.'/third_party/mpdf/mpdf.php';    
    }

    public function BabyWeightPdfFile()
    {
        error_reporting(0); 
        $html.= '  <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style type="text/css">
           span.dotted{
              border-bottom: 1px dashed #000;
              text-decoration: none; 
            }
            .headingFont{
              font-size:15px;

            }
            .contentPadding{
               padding:5px;
               border: 1px solid black;
            }table {
                border-collapse: collapse;
              }
              .tableSecContent{
                font-size: 13px;
                padding:5px;
              }
        </style>
    </head>
      <body>
          <div style="width:100%;">
            <table width="100%">
              <tr>
                <td style="text-align: left;"><img src="'.base_url().'assets/helth.png" style="width: 110px;height: 110px;"></td>
                <td style="text-align: center;"><img src="'.base_url().'assets/born.png" style="width: 120px;height: 110px;"></td>
                <td style="text-align: right;"><img src="'.base_url().'assets/uplogo.png" style="width: 100px;height: 100px;"></td>
              </tr>
            </table>
                <!-- set heading of pdf form -->
                <h3 style="text-align: center;margin: auto;">SICK NEW BORN CARE UNIT</h3>
                <h4 style="text-align: center;margin: auto;"><span class="dotted">Veerangna Avanti Bai Mahila Hospital, Lucknow</span></h4>
                <h3 style="text-align: center;margin-top: 5px;margin-bottom: -15px !important;">NEONATAL CASE RECORD SHEET</h3>
                <p style="font-size: 14px; font-weight: bold;text-align: center;margin:auto;">(Developed by UNICEF for NHM)</p>
               
              <table width="100%" style="margin-left: 15px;margin-right: 15px !important;">
                <tr>
                  <td style="width: 50%;"><b class="headingFont">SNCU Reg. No.</b> ........................</td>
                  <td style="width: 50%;text-align:right;"><b class="headingFont">MCTS No.</b> [][][][][][][][][][][] </td>
                </tr>
                <tr margin-bottom: 5px;>
                  <td style="width: 100%;" colspan="2"><b class="headingFont">Doctor In Charge</b> ........................</td> 
                </tr>
              </table>

                  <table width="100%" style="margin-top:5px;">
                    <tr>
                      <td class="contentPadding">Baby Of (Mothers Name)</td>
                      <td class="contentPadding" colspan="2"></td>
                      <td class="contentPadding"></td>
                    </tr>
                 
                    <tr>
                      <td class="contentPadding">Fathers Name</td>
                      <td class="contentPadding" colspan="2"></td>
                      <td class="contentPadding"></td>
                    </tr>


                    <tr>
                      <td class="contentPadding">Complete Address with<br>Village Name / Ward No.</td>
                      <td class="contentPadding" colspan="3"></td>
                    </tr>

                    <tr>
                      <td class="contentPadding">Contact No. & Relation</td>
                      <td class="contentPadding" colspan="3"></td>
                    </tr>

                    <tr>
                      <td class="contentPadding">Date and Time of Birth</td>
                      <td class="contentPadding">20/12/2019</td>
                      <td class="contentPadding" colspan="2"> Birth Weight (Kg):</td>
                    </tr>

                    <tr>
                      <td class="contentPadding">Date and Time of Admission</td>
                      <td class="contentPadding">20/12/2019</td>
                      <td class="contentPadding">Age on Admission (Kg):</td>
                      <td class="contentPadding">Wt. on Admission (Kg):</td>
                    </tr>

                    <tr>
                      <td class="contentPadding">Date and Time of Discharge</td>
                      <td class="contentPadding">20/12/2019</td>
                      <td class="contentPadding">Age on Discharge (Kg):</td>
                      <td class="contentPadding">Wt. on Discharge (Kg):</td>
                    </tr>

                    <tr>
                      <td class="contentPadding">Type of Admission</td>
                      <td class="contentPadding" colspan="3">Inborn/Outborn</td>
                    </tr>

                    <tr>
                      <td class="contentPadding">Place of Delivery</td>
                      <td class="contentPadding" colspan="3">Home/Ambulance/Hospital</td>
                    </tr>

                    <tr>
                      <td class="contentPadding">Reffered From</td>
                      <td class="contentPadding"></td>
                      <td class="contentPadding" colspan="2">Mode of Transport: Self Arranged/Govt. Provided</td>
                    </tr>

                  </table>


                                <table width="100%" border="1" style="margin-top:5px;">
                                  <tr>
                                    <td colspan="3">Indication for Admission<span style="font-size:12px;">(Encircle the most relevant single indication, If multiple indication also mention all relevant numbers in the end as per priority)</span></td>
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
                                    <td colspan="3"><b>Provisional Diagnosis</b></td>
                                  </tr>                   
                                </table>
       <!-- last table data -->
                                <table width="100%" border="1" style="margin-top:5px;">
                                  <tr>
                                    <td colspan="3">*Final Diagnosis<span style="font-size:12px;">(Encircle the most relevant single diagnosis, If multiple causes also mention all relevant numbers in the end as per sequence)</span></td>
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

                                </table><br/>

          </div>
      </body>
  </html>'; 

        $pdfFilePath =  INVOICE_DIRECTORY."Test_weigth.pdf";
        $mpdf =  new mPDF('utf-8', 'A4-R');
        $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

        $mpdf->WriteHTML($PDFContent);

        $mpdf->Output($pdfFilePath, "F"); 
        return "b_".$getBabyFileId['id']."_weigth.pdf";
    }


}