<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('content-type:application/json;charset=utf-8');
  class UpdateMotherProfile extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/MotherModel');
        $this->load->model('api/MotherBabyAdmissionModel');   
    }
    public function index()
    {
        $requestData       = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true);
        //New lines for MD5
        $allEncrypt               = createMd5OfString($requestJson[APP_NAME]);
        $encryptData              = trim($requestJson['md5Data']);
        //echo $allEncrypt.'||'.$encryptData;exit;

        $data['localId'] = trim($requestJson[APP_NAME]['localId']);
        $data['motherName'] = trim($requestJson[APP_NAME]['motherName']);
        $data['isMotherAdmitted'] = trim($requestJson[APP_NAME]['isMotherAdmitted']);
        $data['motherPicture'] = trim($requestJson[APP_NAME]['motherPicture']);
        // $data['hospitalRegistrationNumber'] = trim($requestJson[APP_NAME]['hospitalRegistrationNumber']);
        $data['motherMCTSNumber'] = trim($requestJson[APP_NAME]['motherMCTSNumber']);
        $data['motherAadharNumber'] = trim($requestJson[APP_NAME]['motherAadharNumber']);
        $data['motherEducation'] = trim($requestJson[APP_NAME]['motherEducation']);
        $data['motherAge'] = trim($requestJson[APP_NAME]['motherAge']);
        $data['motherDOB'] = trim($requestJson[APP_NAME]['motherDOB']);
        $data['motherCaste'] = trim($requestJson[APP_NAME]['motherCaste']);
        $data['motherReligion'] = trim($requestJson[APP_NAME]['motherReligion']);
        $data['motherMobileNumber'] = trim($requestJson[APP_NAME]['motherMobileNumber']);
        $data['fatherName'] = trim($requestJson[APP_NAME]['fatherName']);
        $data['fatherAadharNumber'] = trim($requestJson[APP_NAME]['fatherAadharNumber']);
        $data['fatherMobileNumber'] = trim($requestJson[APP_NAME]['fatherMobileNumber']);
        $data['rationCardType'] = trim($requestJson[APP_NAME]['rationCardType']);
        $data['guardianName'] = trim($requestJson[APP_NAME]['guardianName']);
        $data['guardianNumber'] = trim($requestJson[APP_NAME]['guardianNumber']);
        $data['presentResidenceType'] = trim($requestJson[APP_NAME]['presentResidenceType']);
        $data['presentAddress'] = trim($requestJson[APP_NAME]['presentAddress']);
        $data['presentVillageName'] = trim($requestJson[APP_NAME]['presentVillageName']);
        $data['presentBlockName'] = trim($requestJson[APP_NAME]['presentBlockName']);
        $data['presentDistrictName'] = trim($requestJson[APP_NAME]['presentDistrictName']);
        $data['permanentAddNearByLocation'] = trim($requestJson[APP_NAME]['permanentAddNearByLocation']);
        $data['permanentResidenceType'] = trim($requestJson[APP_NAME]['permanentResidenceType']);
        $data['permanentAddress'] = trim($requestJson[APP_NAME]['permanentAddress']);
        $data['permanentVillageName'] = trim($requestJson[APP_NAME]['permanentVillageName']);
        $data['permanentBlockName'] = trim($requestJson[APP_NAME]['permanentBlockName']);
        $data['permanentDistrictName'] = trim($requestJson[APP_NAME]['permanentDistrictName']);
        $data['presentAddNearByLocation'] = trim($requestJson[APP_NAME]['presentAddNearByLocation']);
        $data['notAdmittedReason'] = trim($requestJson[APP_NAME]['notAdmittedReason']);
        $data['staffId'] = trim($requestJson[APP_NAME]['staffId']);
        $data['ashaId'] = trim($requestJson[APP_NAME]['ashaId']);
        $data['ashaNumber'] = trim($requestJson[APP_NAME]['ashaNumber']);
        $data['ashaName'] = trim($requestJson[APP_NAME]['ashaName']);
        $data['motherLmpDate'] = trim($requestJson[APP_NAME]['motherLmpDate']);
        $data['deliveryPlace'] = trim($requestJson[APP_NAME]['deliveryPlace']);
        $data['facilityId'] = trim($requestJson[APP_NAME]['facilityId']);
        $data['presentCountry'] = trim($requestJson[APP_NAME]['presentCountry']);
        $data['presentState'] = trim($requestJson[APP_NAME]['presentState']);
        $data['permanentCountry'] = trim($requestJson[APP_NAME]['permanentCountry']);
        $data['permanentState'] = trim($requestJson[APP_NAME]['permanentState']);
        $data['para'] = trim($requestJson[APP_NAME]['para']);
        $data['live'] = trim($requestJson[APP_NAME]['live']);
        $data['abortion'] = trim($requestJson[APP_NAME]['abortion']);
        $data['gravida'] = trim($requestJson[APP_NAME]['gravida']);
        $data['permanentPinCode'] = trim($requestJson[APP_NAME]['permanentPinCode']);
        $data['presentPinCode'] = trim($requestJson[APP_NAME]['presentPinCode']);
        $data['type'] = trim($requestJson[APP_NAME]['type']);
        $data['multipleBirth'] = trim($requestJson[APP_NAME]['multipleBirth']);
        $data['deliveryDistrict'] = trim($requestJson[APP_NAME]['deliveryDistrict']);
        $data['guardianRelation'] = trim($requestJson[APP_NAME]['guardianRelation']);
        $data['loungeId'] = trim($requestJson[APP_NAME]['loungeId']);
        $data['sameAddress'] = trim($requestJson[APP_NAME]['sameAddress']);
        $data['motherWeight'] = trim($requestJson[APP_NAME]['motherWeight']);
        $data['ageAtMarriage'] = trim($requestJson[APP_NAME]['ageAtMarriage']);
        $data['birthSpacing'] = trim($requestJson[APP_NAME]['birthSpacing']);
        $data['consanguinity'] = trim($requestJson[APP_NAME]['consanguinity']);
        $data['temporaryFileId'] = trim($requestJson[APP_NAME]['temporaryFileId']);
        $data['estimatedDateOfDelivery'] = trim($requestJson[APP_NAME]['estimatedDateOfDelivery']);
        $data['motherId']         = trim($requestJson[APP_NAME]['motherId']);
        $data['localDateTime']         = trim($requestJson[APP_NAME]['localDateTime']);
        $data['latitude']         = trim($requestJson[APP_NAME]['latitude']);
        $data['longitude']         = trim($requestJson[APP_NAME]['longitude']);
        
        $checkRequestKeys = array(
            '0' => 'motherName',
            '1' => 'isMotherAdmitted',
            '2' => 'motherPicture',
            '3' => 'motherMCTSNumber',
            '4' => 'motherAadharNumber',
            '5' => 'motherDOB',
            '6' => 'motherAge',
            '7' => 'motherEducation',
            '8' => 'motherMobileNumber',
            '9' => 'fatherName',
            '10' => 'fatherAadharNumber',
            '11' => 'fatherMobileNumber',
            '12' => 'rationCardType',
            '13' => 'guardianName',
            '14' => 'guardianNumber',
            '15' => 'presentResidenceType',
            '16' => 'presentAddress',
            '17' => 'motherCaste',
            '18' => 'presentVillageName',
            '19' => 'presentBlockName',
            '20' => 'presentDistrictName',
            '21' => 'permanentResidenceType',
            '22' => 'permanentAddress',
            '23' => 'estimatedDateOfDelivery',
            '24' => 'permanentVillageName',
            '25' => 'permanentBlockName',
            '26' => 'permanentDistrictName',
            '27' => 'notAdmittedReason',
            '28' => 'ashaId',
            '29' => 'ashaNumber',
            '30' => 'ashaName',
            '31' => 'permanentAddNearByLocation',
            '32' => 'presentAddNearByLocation',
            '33' => 'staffId',
            '34' => 'motherReligion',
            '35' => 'motherLmpDate',
            '36' => 'deliveryPlace',
            '37' => 'facilityId',
            '38' => 'presentCountry',
            '39' => 'permanentCountry',
            '40' => 'permanentCountry',
            '41' => 'permanentState',
            '42' => 'para',
            '43' => 'gravida',
            '44' => 'live',
            '45' => 'abortion',
            '46' => 'permanentPinCode',
            '47' => 'presentPinCode',
            '48' => 'type',
            '49' => 'multipleBirth',
            '50' => 'deliveryDistrict',
            '51' => 'guardianRelation',
            '52' => 'loungeId',
            '53' => 'motherWeight',
            '54' => 'ageAtMarriage',
            '55' => 'birthSpacing',
            '56' => 'consanguinity',
            '57' => 'motherId',
            '58' => 'temporaryFileId',
            '59' => 'sameAddress',
            '60' => 'localId',
            '61' => 'localDateTime',
            '62' => 'latitude',
            '63' => 'longitude'
        );
        
        $resultJson = validateJson($requestJson, $checkRequestKeys);

       //New lines for MD5
        $checkRequestKeys2 = array(                                              
                                    '0' => APP_NAME,
                                    '1' => 'md5Data'
                                    );
        $resultJson2 = validateJsonMd5($requestJson, $checkRequestKeys2);
        // for headers security   
        $headers    = apache_request_headers();
        $loungeData = $this->db->get_where('loungeMaster', array('loungeId'=>$requestJson[APP_NAME]['loungeId'],'status'=>'1'));
        $getLoungeData = $loungeData->row_array();

        // mother id validation
        $validateMotherData = $this->db->get_where('motherRegistration', array('motherId' => $requestJson[APP_NAME]['motherId'],'status'=>1))->row_array();
        if(empty($validateMotherData)){
            generateServerResponse('0', '229');
        }

        // nurse id validation
        $validateNurseData = $this->db->get_where('staffMaster', array('staffId' => $requestJson[APP_NAME]['staffId'],'status' => '1'))->row_array();
        if(empty($validateNurseData)){
            generateServerResponse('0', '227');
        }
        

        if($allEncrypt == $encryptData)
        {         
            if($loungeData->num_rows() != 0)
            {
              if(!empty($headers['token']) && !empty($headers['package']))
              {
                if(($headers['token'] == $getLoungeData['token']) && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
                {  
                    if ($resultJson == 1) {
                         
                        $mother_reg = $this->MotherModel->updateMotherRecord($data);
                        if($mother_reg != 0){
                            generateServerResponse('1','142');
                        }else{
                            generateServerResponse('0','W');
                        }
                          
                    }else{
                        generateServerResponse('0','101');              
                    }
                }else{
                   generateServerResponse('0','210');
                }  
              }else{
                generateServerResponse('0','W');
              }  
            }else{
                generateServerResponse('0','211');        
              } 
         }else{
                generateServerResponse('0','212');        
            }  
    }
}