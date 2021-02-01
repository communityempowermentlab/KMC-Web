<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class BabyMotherDischarge extends CI_Controller {
    public function __construct() {
        parent::__construct();
        //$this->load->model('api/AllMixPdf');
        $this->load->model('api/BabyDischargePdf');
        $this->load->model('api/DischargeModel');
        $this->load->model('api/BabyWeightPDF');
        $this->load->model('api/MotherBabyAdmissionModel');
    }
    public function index() {
        $requestData = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson = json_decode($requestData, true);
        //New lines for MD5
        $allEncrypt = md5(json_encode($requestJson[APP_NAME]));
        $encryptData = trim($requestJson['md5Data']);
        // echo $allEncrypt.'||'.$encryptData;exit();
        $data['babyId'] = trim($requestJson[APP_NAME]['babyId']);
        $data['loungeId'] = trim($requestJson[APP_NAME]['loungeId']);
        $data['trainForKMCAtHome'] = trim($requestJson[APP_NAME]['trainForKMCAtHome']);
        $data['infantometerAvailability'] = trim($requestJson[APP_NAME]['infantometerAvailability']);
        $data['babyLength'] = trim($requestJson[APP_NAME]['babyLength']);
        $data['measuringTapeAvailability'] = trim($requestJson[APP_NAME]['measuringTapeAvailability']);
        
        $data['headCircumference'] = trim($requestJson[APP_NAME]['headCircumference']);
        $data['isMotherDischarge'] = trim($requestJson[APP_NAME]['isMotherDischarge']);
        $data['dischargeNotes'] = trim($requestJson[APP_NAME]['dischargeNotes']);
        $data['attendantName'] = trim($requestJson[APP_NAME]['attendantName']);
        $data['relationWithInfant'] = trim($requestJson[APP_NAME]['relationWithInfant']);
        $data['otherRelation'] = trim($requestJson[APP_NAME]['otherRelation']);

        $data['dischargeByDoctor'] = trim($requestJson[APP_NAME]['dischargeByDoctor']);
        $data['dischargeByNurse'] = trim($requestJson[APP_NAME]['dischargeByNurse']);
        $data['transportation'] = trim($requestJson[APP_NAME]['transportation']);
        
        $data['signOfNurse'] = trim($requestJson[APP_NAME]['signOfNurse']);
        
        $data['typeOfDischarge'] = trim($requestJson[APP_NAME]['typeOfDischarge']);
        
        
        $data['guardianName'] = trim($requestJson[APP_NAME]['guardianName']);
        $data['babyHandoverImage'] = trim($requestJson[APP_NAME]['babyHandoverImage']);
        $data['guardianIdImage'] = trim($requestJson[APP_NAME]['guardianIdImage']);
        $data['referredDistrict'] = trim($requestJson[APP_NAME]['referredDistrict']);
        $data['referredFacility'] = trim($requestJson[APP_NAME]['referredFacility']);
        $data['referredUnit'] = trim($requestJson[APP_NAME]['referredUnit']);
        $data['referredReason'] = trim($requestJson[APP_NAME]['referredReason']);
        $data['referralNotes'] = trim($requestJson[APP_NAME]['referralNotes']);
        $data['sehmatiPatr'] = trim($requestJson[APP_NAME]['sehmatiPatr']);
        $data['earlyDishargeReason'] = trim($requestJson[APP_NAME]['earlyDishargeReason']);
        $data['isAbsconded'] = trim($requestJson[APP_NAME]['isAbsconded']);
        
        // $data['dateOfDischarge'] = trim($requestJson[APP_NAME]['dateOfDischarge']);

        $checkRequestKeys = array(
            '0' => 'babyId', 
            '1' => 'loungeId',
            '2' => 'typeOfDischarge'
        );
        

        // $checkRequestKeys = array(
        //     '0' => 'babyId', 
        //     '1' => 'loungeId', 
        //     '2' => 'trainForKMCAtHome',
        //     '3' => 'infantometerAvailability', 
        //     '4' => 'babyLength',
        //     '5' => 'MeasuringTapeAvailability', 
        //     '6' => 'headCircumference', 
        //     '7' => 'isMotherDischarge', 
        //     '8' => 'dischargeNotes', 
        //     '9' => 'attendantName', 
        //     '10' => 'relationWithInfant', 
        //     '11' => 'otherRelation', 
        //     '12' => 'dischargeByDoctor', 
        //     '13' => 'dischargeByNurse', 
        //     '14' => 'transportation',
        //     '15' => 'signOfNurse', 
        //     '16' => 'typeOfDischarge',
        //     '17' => 'guardianName', 
        //     '18' => 'babyHandoverImage',
        //     '19' => 'guardianIdImage', 
        //     '20' => 'referredDistrict',
        //     '21' => 'referredFacilityName', 
        //     '22' => 'referredUnit',
        //     '23' => 'referredReason', 
        //     '24' => 'referralNotes', 
        //     '25' => 'sehmatiPatr', 
        //     '26' => 'earlyDishargeReason',
        //     '27' => 'isAbsconded', 
        //     '28' => 'dateOfDischarge');
       
        $resultJson = validateJson($requestJson, $checkRequestKeys);
        //New lines for MD5
        $checkRequestKeys2 = array('0' => APP_NAME, '1' => 'md5Data');
        $resultJson2 = validateJsonMd5($requestJson, $checkRequestKeys2);
        // for headers security
        $headers = apache_request_headers();
        $loungeData = $this->db->get_where('loungeMaster', array('loungeId' => $requestJson[APP_NAME]['loungeId'], 'status' => '1'));
        $getLoungeData = $loungeData->row_array();
        if ($allEncrypt == $encryptData) {
            if ($loungeData->num_rows() != 0) {
                if (!empty($headers['token']) && !empty($headers['package'])) {
                    if (($headers['token'] == $getLoungeData['token']) && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE)))) {
                        if ($resultJson == 1 && $resultJson2 == 1) {
                            $DischargeFromPost = $this->DischargeModel->SaveDischarge($data);
                            if ($DischargeFromPost == '1') {
                                generateServerResponse('1', 'S');
                            } elseif ($DischargeFromPost == '2') {
                                generateServerResponse('0', '134');
                            } else {
                                generateServerResponse('0', 'E');
                            }
                        } else {
                            generateServerResponse('0', '101');
                        }
                    } else {
                        generateServerResponse('0', '210');
                    }
                } else {
                    generateServerResponse('0', 'W');
                }
            } else {
                generateServerResponse('0', '211');
            }
        } else {
            generateServerResponse('0', '212');
        }
    }
    public function babyWeightPdfFile($loungeId, $babyId) {
        error_reporting(0);
        $this->db->order_by('id', 'desc');
        $getBabyFileId = $this->db->get_where('babyAdmission', array('babyId' => $babyId))->row_array();
        /*echo $loungeId ."   ". $babyId; exit;*/
        $MotherDetail = $this->db->query("SELECT MR.`motherName`, BR.`deliveryDate`, BR.`babyWeight` FROM motherRegistration as MR LEFT JOIN babyRegistration as BR  on BR.`motherId` =  MR.`motherId`  WHERE BR.`babyId` = '" . $babyId . "'")->row_array();
        $GetBabyWeigth = $this->db->get_where('babyDailyWeight', array('loungeId' => $loungeId, 'babyId' => $babyId))->result_array();
        /* echo "<pre>"; print_r($GetBabyWeigth); exit;*/
        $html = '';
        $html.= '
                <!DOCtype html>
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
                    <td style="width: 50%;text-align: left; padding:5px "><b> Hospital Registration Number: </b> ' . $getBabyFileId['babyFileId'] . ' </td>
                <th style="width: 50%;text-align: left"></th></tr>
                <tr>
                  <td style="width: 50%;text-align: left; padding:5px "> <b> Mother Name:</b> ' . $MotherDetail['motherName'] . '</td>
                  <td style="width: 50%;text-align: right; padding:5px; float:right !important;  "><b>Date of Birth(dd/mm/yyyy):</b> ' . date("d/m/Y", strtotime($MotherDetail['deliveryDate'])) . '</td></tr>
                <tr>
                  <td style="width: 50%;text-align: left; padding:5px "><b>Birth Weight(in grams): </b>' . $MotherDetail['babyWeight'] . '</td>
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
        $i = 1;
        foreach ($GetBabyWeigth as $key => $value) {
            $nurseName = getSingleRowFromTable('name', 'staffId', $value['nurseId'], 'staffMaster');
            // print_r(date('g:i A',$value['addDate']));exit;
            ######## conditions Baby weigth gain loss #########
            if ($i >= 2) {
                $prev_baby_weigth = $GetBabyWeigth[$i - 2]['babyWeight'];
                $curr_baby_weigth = $value['babyWeight'];
                $Weigthdiffer = '';
                if ($prev_baby_weigth > $curr_baby_weigth) {
                    $differ = $prev_baby_weigth - $curr_baby_weigth;
                    $Weigthdiffer = '-' . $differ;
                } else {
                    $differ = $curr_baby_weigth - $prev_baby_weigth;
                    $Weigthdiffer = '+' . $differ;
                }
            }
            ######## conditions Baby weigth gain loss #########
            ##### conditions FOR Net Baby weigth gain loss since admission #########
            if ($i > 1) {
                if ($GetBabyWeigth[0]['babyWeight'] > $value['babyWeight']) {
                    $differ = $GetBabyWeigth[0]['babyWeight'] - $value['babyWeight'];
                    $gainLose = $differ . ' loss';
                } else {
                    $differ = $value['babyWeight'] - $GetBabyWeigth[0]['babyWeight'];
                    $gainLose = $differ . ' gain';
                }
            }
            ##### conditions FOR Net Baby weigth gain loss since admission #########
            $html.= '<tr style="border:1px solid" >
                    <td style="width: 11%;text-align: center ;border:1px solid;padding: 11px ; padding: 7px">' . $i . '</td>
                    <td style="width: 12%;text-align: center;border:1px solid ">' . date('d/m/Y', strtotime($value['weightDate'])) . '</td>
                    <td style="width: 12%;text-align: center;border:1px solid ">' . date('g:i A', $value['addDate']) . '</td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ">' . $value['babyWeight'] . '</td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ">' . $Weigthdiffer . '</td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ">' . $gainLose . '</td>
                    <td style="width: 13.5%;text-align: center;border:1px solid "></td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ">' . $nurseName . '</td>
                    <td style="width: 11%;text-align: center;border:1px solid "></td>
                  </tr>';
            $i++;
        }
        $html.= '</table>
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
        $pdfFilePath = pdfDirectory . "b_" . $getBabyFileId['id'] . "_weigth.pdf";
        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF('utf-8', 'A4-L');
        $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $mpdf->WriteHTML($PDFContent);
        $mpdf->Output($pdfFilePath, "F");
        return "b_" . $getBabyFileId['id'] . "_weigth.pdf";
    }
}
