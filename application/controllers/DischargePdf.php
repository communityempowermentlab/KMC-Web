<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class DischargePdf extends CI_Controller {
  public function __construct()
    {
      
      parent::__construct();         
      $this->load->library('M_pdf'); 
      include_once APPPATH.'/third_party/mpdf/mpdf.php';    
    }

    public function listForm(){
       $this->load->view('listForm');
    }
  
   public function BabyWeightPdfFile()
    {
      error_reporting(0); 
      $this->load->library('Mpdf');
      $mpdf=new mPDF('utf-8');

        $html.= '<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">


table, th, td
    {
        border: 1px solid black;
        border-collapse: collapse;
      
    }

th, td 
    {
        padding: 2px;
          
    }

  #this
    {
      
      width:100%;
      border:1px solid black;
      border-top-style:none;
      border-right-style:none;
      border-left-style:none
    }





  </style>


     <body>
      <h2 style="text-align:center;">DISCHARGE NOTES : FOR SNCU RECORD</h2>
        <table style="width:100%">

          <tr>
            <td>SNCU Reg.No.</td>
            <td colspan="2"></td>
             <td>Sex: M/F</td> 
          </tr>

          <tr>
            <td>Baby of(Mothers Name)</td>
            <td colspan="2"></td>
             <td>Fathers Name</td>
          </tr>

          <tr>
            <td>Date & Time of Dishcharge</td>
            <td>....../....../20......</td>
            <td>Age on Discharge:</td>
             <td>Wt. on Discharge(kg):</td>
          </tr>

          <tr>
            <td>Final Outcome</td>
            <td colspan="3"><p style="font-size:14px">Successfully Discharged/Left Against Medical Advice/Referred/Expired</p></td>
           
          </tr>

          <tr>
            <td colspan="4"><h6>*Final Diagnosis </h6><p style="font-size:10px;">(Encircle the most relevant single dignosis,if multiple causes also mention all relevent numbers in the end as per priorty)</p></td>
          </tr>

        <tr>
            <td height:100px;>

                <ul>
                    <li style="font-size:10px;">ELBW(999 gm or less):P 07.0</li>
                    <li style="font-size:10px;">Other LBW(1000 gm-2499 gm):P 07.1</li>
                    <li style="font-size:10x;">Extreme Immaturity(<28 weeks):P 07.2</li>
                    <li style="font-size:10px;">Prematurity(28-<37 Weeks):P 07.3</li>
                    <li style="font-size:10px;">Small for Gestational Age(IUGR):P 05.1  </li>
                    <li style="font-size:10px;">Neonatal Aspiration of Meconium: P 24.0</li>
                    <li style="font-size:10px;">RDS of Newborn(HMD):p 22.0</li>
                    <li style="font-size:10px;">Transient Tachypnoea of Newborn:P 22.1</li>
                    <li style="font-size:10px;">Pneumothorax:P5.1</li>
                    <li style="font-size:10px;">Congenital Pneumonia:p 23</li>
                    <li style="font-size:10px;">Acquired Pneumonia :J 15</li>
                    <li style="font-size:10px;">Primary Sleep Apnoea of Newborn:P 28.3</li>
                    <li style="font-size:10px;">Birth Asphyxia:P 21.0</li>
                    <li style="font-size:10px;">HIE of Newborn:P 91.6</li>
                    <li style="font-size:10px;">Neonatal Sepsis</li>
                    <li style="font-size:10px;">Meningitis:G 00</li>
                </ul>

            </td>

            <td colspan="2">
                <ul>
                    <li style="font-size:10;">Convulsions of Newborn:P 90<br/>(Hypoxic,hypolgycaemic,Hypocalcaemic,<br/>CNS Infections,Birth Trauma,Metabolic,<br/>Other,Unknown Cause)</li>
                    <li style="font-size:10px;">Hemolytic disease of Newborn:P 55</li>
                    <li style="font-size:10px;">Newonatal Jaundice:P 59</li>
                    <li style="font-size:10px;">Acute Renal Failure:N 17</li>
                    <li style="font-size:10px;">Neonatal Cardiac Failure:P 29.0</li>
                    <li style="font-size:10px;">Shock:R 57</li>
                    <li style="font-size:10px;">DIC:P 60</li>
                    <li style="font-size:10px;">Intraventricular Hemorrhage:P 52.3</li>
                    <li style="font-size:10px;">Neonatal Diarrhoea:A 09</li>
                    <li style="font-size:10px;">Tetanus Neonatorum: A 09</li>
                    <li style="font-size:10px;">Hypothermia of Newborn:A 33</li>
                    <li style="font-size:10px;">Tetanus neonatroum:A 33</li>
                    <li style="font-size:10px;">Hypothermia of Newborn:P 80</li>
                    <li style="font-size:10px;">Enviromental Hypothermia of Newborn:P 81.0</li>
                    <li style="font-size:10px;">Neonatal Hypoglycaemia:P 70.4</li>
                    <li style="font-size:10px;">Meningitis:G 00</li>
                  </ul>


            </td>

            <td>
                <ul>
                    <li style="font-size:10px;">Congenital Malformation:</li>
                    <li style="font-size:10px;">Cong.Diaphagmatic Hernia:Q 79.0</li>
                    <li style="font-size:10px;">Cong.Hydrocephalus:Q 03</li>
                    <li style="font-size:10px;">Meningomyelocele:Q 05</li>
                    <li style="font-size:10px;">Imperforate anus:Q 42.3</li>
                    <li style="font-size:10px;">T.O. Fistula:Q 39.2</li>
                    <li style="font-size:10px;">Congential Heart Disease:Q 21</li>
                    <li style="font-size:10px;">Cleft Palate:Q 35</li>
                    <li style="font-size:10px;">Cleft Lip:Q 36</li>
                    <li style="font-size:10px;">Cleft Palate with Cleft Lip:Q 37</li>
                    <li style="font-size:10px;">Congential Deformities of Hip:Q 65</li>
                    <li style="font-size:10px;">Congential Deformities Of Feet:Q 66</li>
                    <li style="font-size:10px;">Other Malformation(...............)</li>
                    <li style="font-size:10px;">Any Other Diagnosi(...............)</li>
                    <li style="font-size:10px;"><p style="font-weight:bold">Multiple Diagnosis-Mention All relevent Codes:</p></li>
                    <li>a.........b........c.......d........</li>
                    

                </ul>


              </td>
          </tr>

        </table>

      <table style="margin-top:5px; width:100%;">
          <tr>
            
             <td>

                <ul>
                    <p style="font-weight:bold; font-size:13px;">TREATMENT GIVEN</p>

                      <li style="font-size:12px;">Oxygen :Yes/No(If yes duration............................................)</li>
                      <li style="font-size:12px;">Phototherapy:Yes/No(If yes Duration...................................)</li>
                      <li style="font-size:12x;">Step-Down:Yes/No(If yes duration........................................)</li>
                      <li style="font-size:12px;">KMC:Yes/No(If yes duration..................................................)</li>
                      <li style="font-size:12px;">Antibiotic:Yes/No(If yes fill the details below .......................)</li>
                        
                      <p style="font-size:12px; font-weight:bold;">Name & Dose</p>
                      <li>...................................................</li>
                      <li>...................................................</li>
                      <li>...................................................</li>
                      <li>...................................................</li>
                </ul>

            </td>

            <td colspan="3">
                <ul>

                  <br/><br/>
                    
                    <li style="font-size:12px;">.......................................................................................<br/><br/><br/></li>
                    <li style="font-size:12px;">.......................................................................................<br/><br/><br/></li>
                    <li style="font-size:12px;">.......................................................................................<br/><br/><br/></li>
                    <li style="font-size:12px;">.......................................................................................<br/><br/><br/></li>
                      <li style="font-size:12px;">.......................................................................................</li>

                </ul>


            </td>  
          </tr>


      </table>
      <table style="width:100%; margin-top:5px;">
        <tr>
            <td height="80x;"><p style="font-weight:bold; text-align:top;">COURSE DURING TREATMENT</p></td>
        </tr>
      </table>

     
      <table style="width:100%; margin-top:5px;">
        <tr>
            <td height="80x;"><p style="font-weight:bold;">CONDITION ON DISCHARGE</p></td>
        </tr>
      </table>




      <table style="margin-top:5px; width:100%;">
          <tr>
            
             <td>

                <ul>

                    <p style="font-weight:bold; font-size:12px;">IMMUNIZATION STATUS</p>

                    <li style="font-size:12px;">RI Card</li>
                    <li style="font-size:12px;">BCG</li>
                    <li style="font-size:12px;">OPV(0 Does)</li>
                    <li style="font-size:12px;">Hepatitis</li>
                    



                </ul>

                      
            </td>

            <td colspan="3">
                <ul>

                      <p style="font-weight:bold; font-size:13px;">TREATMENT ADVISED ON DISCHARGE</p>
                      <br/>
                    <li style="font-size:12px;">...................................................................................................................................<br/><br/><br/></li>
                    <li style="font-size:12px;">...................................................................................................................................<br/><br/><br/></li>
                    <li style="font-size:12px;">...................................................................................................................................<br/><br/><br/></li>
                    

                </ul>


            </td>  
          </tr>


      </table>

      <div id="this"><p style="text-align:right; font-size:10px;">Docters Name and Signature</p></div>

      <p style="text-align:center; font-weight:bold; font-size:10px;">This Sheet has to filled on Dishcharge by Doctor on Duty</p>




     </body>
</html>'; 
         
          

         //echo $html;
        /*  $mpdf->autoScriptToLang = true;
          $mpdf->baseScript = 1;
          $mpdf->autoVietnamese = true;
          $mpdf->autoArabic = true;
          $mpdf->autoLangToFont = true; 

          $mpdf->WriteHTML($html);
          $filename = 'Receipt'.'['.date('d-m-Y').'].pdf';

          $mpdf->Output('pdf/'.$filename,'F');

          $getfilepath = base_url().'pdf/'.$filename;
        
          return $filename; */

        $pdfFilePath =  INVOICE_DIRECTORY."dischargeFinal.pdf";
        $mpdf =  new mPDF('utf-8', 'A4-R');
        $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        // for hindi content
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        // end form 
        $mpdf->WriteHTML($PDFContent);

        $mpdf->Output($pdfFilePath, "F"); 
        return "b_".$getBabyFileId['id']."_weigth.pdf";


 }


}