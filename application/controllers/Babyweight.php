<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Babyweight extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/baby_model');  
        $this->load->library('m_pdf');    
    }
    public function WeightpdfGenerate($id)
    {
      $babyAdmisionLastId = $this->db->get_where('baby_admission',array('id'=>$id))->row_array();

            $PdfName = $this->BabyWeightPdfFile($babyAdmisionLastId['LoungeID'],$babyAdmisionLastId['BabyID'],$id);
            $this->db->where('id',$babyAdmisionLastId['id']);
           $res = $this->db->update('baby_admission',array('BabyWeightPdfName'=>$PdfName));
           if($res > 0){
           $this->session->set_flashdata('activate', getCustomAlert('S','Weight PDF Generate Successfully'));
            redirect('BabyManagenent/registeredBaby/1/'.$babyAdmisionLastId['LoungeID']);
           }
    }

  public function BabyWeightPdfFile($LoungeID, $BabyID,$id)
    {

        error_reporting(0);

        $getBabyFileId = $this->db->get_where('baby_admission',array('id'=>$id))->row_array();

        /*echo $LoungeID ."   ". $BabyID; exit;*/
        $MotherDetail =  $this->db->query("SELECT MR.`MotherName`, BR.`DeliveryDate`, BR.`BabyWeight` FROM mother_registration as MR LEFT JOIN babyRegistration as BR  on BR.`MotherID` =  MR.`MotherID`  WHERE BR.`BabyID` = '".$BabyID."'")->row_array();

         $GetBabyWeigth = $this->db->get_where('baby_weight_master', array('LoungeID'=>$LoungeID,'BabyID'=>$BabyID,'baby_admissionID'=>$id))->result_array();

        /* echo "<pre>"; print_r($GetBabyWeigth); exit;*/

               
        $html ='';
        $html.= '
                <!DOCTYPE html>
                <html>
                <head>
                <title>
                  FORM D: DAILY WEIGHT MONITORING FORM
                </title>
                <style>

                  table,th,td,tr{
                    border-collapse:collapse;
                    }

                </style>
                </head>
                <body>
                <table >
                <tr><th style="text-align: center;font-family: sans-serif;"><u><h3>FORM D: DAILY WEIGHT MONITORING FORM</h3></u></th></tr>
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


    $dischargeTime    = ($getBabyFileId['DateOfDicharge'] != '') ? date('d/m/Y',strtotime($getBabyFileId['DateOfDicharge'])) : 'N/A';
    $dischargeWeightsGainOrLoss = ($getBabyFileId['BabyDischargeWeigth'] != '') ? $getBabyFileId['WeightGainOrLoseAfterAdmission'] : 'N/A';
                $html.=  '</table>
                <table style="width: 100%;margin-top: 10px" >
                <tr>
                  <th style="text-align: left;font-family: sans-serif;">Date of discharge(dd/mm/yy):'.$dischargeTime.'
                    <span style="padding-left: 20px">Weight of discharge(in grams):</span><input type="text" value="'.$getBabyFileId['BabyDischargeWeigth'].'" id="fname" name="firstname" style="border-top: none;border-bottom-width: 2px;border-left: none;border-right: none;border-bottom-color: black"></th>
                </tr>
                <tr>
                  <th style="text-align: left;font-family: sans-serif">Net gain/loss since admission(in grams)(+/-):<input type="text"  id="fname" value="'.$dischargeWeightsGainOrLoss.'"  name="firstname" style="border-top: none;border-bottom-width: 2px;border-left: none;border-right: none;border-bottom-color: black"></th>
                </tr>

                </table>
                </body>
                </html>'; 

        $pdfFilePath =  INVOICE_DIRECTORY."b_".$getBabyFileId['id']."_weigth.pdf";

        //include_once APPPATH.'/third_party/mpdf/mpdf.php';
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