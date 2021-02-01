<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DischargingPdf extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/baby_model'); 
        $this->load->library('m_pdf');     
    }
    public function WeightpdfGenerate($id)
    {
      $babyAdmisionLastId = $this->db->get_where('baby_admission',array('id'=>$id))->row_array();

           $PdfName = $this->DischargePdf($babyAdmisionLastId['BabyID'],$id);
          $this->db->where('id',$babyAdmisionLastId['id']);     
          $res = $this->db->update('baby_admission',array('BabyDischargePdfName'=>$PdfName));
           if($res > 0){
           $this->session->set_flashdata('activate', getCustomAlert('S','Discharge PDF Generate Successfully'));
            redirect('BabyManagenent/registeredBaby/1/'.$babyAdmisionLastId['LoungeID']);
           }

    }

      public function DischargePdf($MotherOrBabyID,$id)
     {
      error_reporting(0);
        $babyAdmisionLastId = $this->db->get_where('baby_admission',array('id'=>$id))->row_array();

        $GetData = $this->db->query("SELECT * from mother_registration as MR LEFT JOIN babyRegistration as BR On BR.`MotherID` = MR.`MotherID` LEFT JOIN baby_admission as BA On BR.`BabyID` = BA.`BabyID` Where BA.`BabyID` = '".$MotherOrBabyID."' order by BA.`id` Desc ")->row_array();
       $LastAdmissionID = $babyAdmisionLastId['id'];
        //$filename = "b_".$LastAdmissionID."_discharge.pdf";
        $Hospitalreg = $babyAdmisionLastId['BabyFileID'];
      $MCTSNo = $GetData['BabyMCTSNumber'];
      $DischargeDate = date('d/m/Y', strtotime($babyAdmisionLastId['DateOfDicharge']));

      $Day = GetDateDiff2($GetData['add_date']);
      $WeigthOnDischarge = $babyAdmisionLastId['BabyDischargeWeigth'];

      $NetGain = $WeigthOnDischarge - $GetData['BabyWeight'];  
      $reffered = $babyAdmisionLastId['ReferredFacilityName']." ".$babyAdmisionLastId['ReferredFacilityAddress'];
      $refferedReson = ($babyAdmisionLastId['ReferredReason']!='') ? $babyAdmisionLastId['ReferredReason'] :'_________________________';

        $discharge = json_decode($babyAdmisionLastId['DischargeChecklist'],true);

      
      $html.='';
      $html.='
      <!DOCTYPE html>
      <html>
      <head>
      <title>DISCHARGE CHECKLIST FOR KMC UNIT</title>
      <style>

      
      </style>
      </head>
      <body>


        <div>
          <h3 style= "text-align:  center"> <u>DISCHARGE CHECKLIST FOR KMC UNIT</u> </h3>
        </div>


         

          <div  style="padding-bottom: 2px; padding-top: 2px">
            
            <label style="padding-right: 10%"> <b>Hospital Reg. No.:</b>  '. $Hospitalreg.'</label> 
            <label style=" padding-left: 10%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>MCTS NO.</b>: '.$MCTSNo.'</label>
            </div>
            <br> 
            </div>
          

          <div  style="padding-bottom: 2px; padding-top: 2px">
            
            <label style="width: 40%; padding-right: 10%"> <b>Name of mother:</b> '. $GetData['MotherName'].'</label> 
            <label style="width: 40%; padding-left: 10%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Date of discharge :</b>'.$DischargeDate.'</label>
            </div>
            <br> 
          </div>


          <div>

          <div  style="padding-bottom: 2px; padding-top: 2px">
            
            <label><b>Number of days spend in KMC room (excluding days spent in SNCU/ NBSU):</b>  '.$Day.' days</label> 
            <br>
            <label> <b>weight on discharge(in grams):</b>  '.$WeigthOnDischarge.' days</label>
            </div>
            <br> 
          </div>

          <div>


          <div  style="padding-bottom: 2px; padding-top: 2px">
            
            <label ><b>Net weight gain/loss since admission(in grams):</b>  '. $NetGain.' </label> 
          
            </div>
            <br> 
          </div>

           <div  style="padding-bottom: 2px; padding-top: 2px">
            
            <label ><b>Type of discharge :</b>  '.$babyAdmisionLastId['TypeOfDischarge'].'</label> 
           
            </div>
            <br> 
          </div>

          <div  style="padding-bottom: 2px; padding-top: 2px">
            <h4><u>In case of referral</u> </h4>
       
            <label ><b>Name and address of facility reffered to:</b> '.$reffered.'</label> 

            </div>
            <br> 
             <label ><b>Reason for referral:</b> '.$refferedReson.'</label> 

            </div>
            <br> 
          </div>

          <div>

          <div>
            <h3 style= "text-align:  center"> DISCHARGE CHECKLIST FOR KMC UNIT </h3>
          </div>


         <div>

            <div  style="padding-bottom: 2px; padding-top: 2px">';
            $discharge = json_decode($babyAdmisionLastId['DischargeChecklist'],true);
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

            <div>

            
        </body>
        </html>';

    /*$fileName = "b_".$BabyData['BabyID'].".pdf";*/
    $pdfFilePath =  INVOICE_DIRECTORY."b_".$LastAdmissionID."discharge.pdf";
    //echo $pdfFilePath;
      $this->m_pdf->pdf->autoScriptToLang = true;
      $this->m_pdf->pdf->baseScript = 1;
      $this->m_pdf->pdf->autoVietnamese = true;
      $this->m_pdf->pdf->autoArabic = true;
      $this->m_pdf->pdf->autoLangToFont = true;
      $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
      $this->m_pdf->pdf->WriteHTML($PDFContent);
      $this->m_pdf->pdf->Output($pdfFilePath, "F"); 

    return  "b_".$LastAdmissionID."discharge.pdf";


    }


}