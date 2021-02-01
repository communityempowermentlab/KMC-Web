<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class MotherDischarge extends CI_Controller {
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
        $allEncrypt = createMd5OfString($requestJson[APP_NAME]);
        $encryptData = trim($requestJson['md5Data']);
        // echo $allEncrypt.'||'.$encryptData;exit();
        $data['motherId'] = trim($requestJson[APP_NAME]['motherId']);
        $data['loungeId'] = trim($requestJson[APP_NAME]['loungeId']);
        
        $data['trainForKMCAtHome'] = trim($requestJson[APP_NAME]['trainForKMCAtHome']);
        
        $data['dischargeNotes'] = trim($requestJson[APP_NAME]['dischargeNotes']);
        $data['attendantName'] = trim($requestJson[APP_NAME]['attendantName']);
        $data['relationWithMother'] = trim($requestJson[APP_NAME]['relationWithMother']);
        $data['otherRelation'] = trim($requestJson[APP_NAME]['otherRelation']);

        $data['dischargeByDoctor'] = trim($requestJson[APP_NAME]['dischargeByDoctor']);
        $data['dischargeByNurse'] = trim($requestJson[APP_NAME]['dischargeByNurse']);
        $data['transportation'] = trim($requestJson[APP_NAME]['transportation']);
        
        $data['signOfNurse'] = trim($requestJson[APP_NAME]['signOfNurse']);
        
        $data['typeOfDischarge'] = trim($requestJson[APP_NAME]['typeOfDischarge']);
        $data['bodyHandover'] = trim($requestJson[APP_NAME]['bodyHandover']);
        
        $data['guardianName'] = trim($requestJson[APP_NAME]['guardianName']);
        
        
        $data['referredDistrict'] = trim($requestJson[APP_NAME]['referredDistrict']);
        $data['referredFacility'] = trim($requestJson[APP_NAME]['referredFacility']);
        $data['referredUnit'] = trim($requestJson[APP_NAME]['referredUnit']);
        $data['referredReason'] = trim($requestJson[APP_NAME]['referredReason']);
        $data['referralNotes'] = trim($requestJson[APP_NAME]['referralNotes']);
        
        $data['earlyDishargeReason'] = trim($requestJson[APP_NAME]['earlyDishargeReason']);
        $data['isAbsconded'] = trim($requestJson[APP_NAME]['isAbsconded']);
        $data['sehmatiPatr'] = trim($requestJson[APP_NAME]['sehmatiPatr']);
        
        // $data['dateOfDischarge'] = trim($requestJson[APP_NAME]['dateOfDischarge']);

        $checkRequestKeys = array(
            '0' => 'motherId', 
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
                            $DischargeFromPost = $this->DischargeModel->SaveMotherDischarge($data);
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
    
}
