<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
header('content-type:application/json;charset=utf-8');

class MotherRegistration extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this
            ->load
            ->model('api/MotherModel');
    }

    public function index()
    {
        $requestData = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson = json_decode($requestData, true);

        //New lines for MD5
        $allEncrypt = createMd5OfString($requestJson[APP_NAME]);
        $encryptData = trim($requestJson['md5Data']);

        //  echo $allEncrypt.'||'.$encryptData;exit;
        $data['motherName'] = trim($requestJson[APP_NAME]['motherName']);
        $data['isMotherAdmitted'] = trim($requestJson[APP_NAME]['isMotherAdmitted']);
        $data['motherPicture'] = trim($requestJson[APP_NAME]['motherPicture']);
        $data['hospitalRegistrationNumber'] = trim($requestJson[APP_NAME]['hospitalRegistrationNumber']);
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
        $data['localId'] = trim($requestJson[APP_NAME]['localId']);

        $checkRequestKeys = array(
            '0' => 'motherName',
            '1' => 'isMotherAdmitted',
            '2' => 'motherPicture',
            '3' => 'hospitalRegistrationNumber',
            '4' => 'motherMCTSNumber',
            '5' => 'motherAadharNumber',
            '6' => 'motherDOB',
            '7' => 'motherAge',
            '8' => 'motherEducation',
            '9' => 'motherMobileNumber',
            '10' => 'fatherName',
            '11' => 'fatherAadharNumber',
            '12' => 'fatherMobileNumber',
            '13' => 'rationCardType',
            '14' => 'guardianName',
            '15' => 'guardianNumber',
            '16' => 'presentResidenceType',
            '17' => 'presentAddress',
            '18' => 'motherCaste',
            '19' => 'presentVillageName',
            '20' => 'presentBlockName',
            '21' => 'presentDistrictName',
            '22' => 'permanentResidenceType',
            '23' => 'permanentAddress',
            '24' => 'estimatedDateOfDelivery',
            '25' => 'permanentVillageName',
            '26' => 'permanentBlockName',
            '27' => 'permanentDistrictName',
            '28' => 'notAdmittedReason',
            '29' => 'ashaId',
            '30' => 'ashaNumber',
            '31' => 'ashaName',
            '32' => 'permanentAddNearByLocation',
            '33' => 'presentAddNearByLocation',
            '34' => 'staffId',
            '35' => 'motherReligion',
            '36' => 'motherLmpDate',
            '37' => 'deliveryPlace',
            '38' => 'facilityId',
            '39' => 'presentCountry',
            '40' => 'permanentCountry',
            '41' => 'permanentCountry',
            '42' => 'permanentState',
            '43' => 'para',
            '44' => 'gravida',
            '45' => 'live',
            '46' => 'abortion',
            '47' => 'permanentPinCode',
            '48' => 'presentPinCode',
            '49' => 'type',
            '50' => 'multipleBirth',
            '51' => 'deliveryDistrict',
            '52' => 'guardianRelation',
            '53' => 'loungeId',
            '54' => 'motherWeight',
            '55' => 'ageAtMarriage',
            '56' => 'birthSpacing',
            '57' => 'consanguinity',
            '58' => 'localId',
            '59' => 'temporaryFileId',
            '60' => 'sameAddress'
        );

        $resultJson = validateJson($requestJson, $checkRequestKeys);

        //New lines for MD5
        $checkRequestKeys2 = array(

            '0' => APP_NAME,
            '1' => 'md5Data'
        );

        $resultJson2 = validateJsonMd5($requestJson, $checkRequestKeys2);

        // for headers security
        $headers = apache_request_headers();
        $loungeData = $this
            ->db
            ->get_where('loungeMaster', array(
            'loungeId' => $requestJson[APP_NAME]['loungeId'],
            'status' => '1'
        ));

        $getLoungeData = $loungeData->row_array();

        if ($allEncrypt == $encryptData)
        {
            if ($loungeData->num_rows() != 0)
            {
                if (!empty($headers['token']) && !empty($headers['package']))
                {
                    if (($headers['token'] == $getLoungeData['token']) && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
                    {
                        if ($resultJson == 1 && $resultJson2 == 1)
                        {
                            $post = array();
                            $response = array();
                            // type = 1=>SNCU and 2 is Lounges
                            if ($getLoungeData['type'] == 1)
                            {
                                $isBabyExistInAdmission = checkUniqueValue('babyAdmission', 'temporaryFileId', $data['temporaryFileId'], 'loungeId', $data['loungeId']);
                                $isMotherExistInAdmission = checkUniqueValue('motherAdmission', 'temporaryFileId', $data['temporaryFileId'], 'loungeId', $data['loungeId']);
                            }
                            else
                            {
                                $isBabyExistInAdmission = checkUniqueValue('babyAdmission', 'babyFileId', $data['hospitalRegistrationNumber'], 'loungeId', $data['loungeId']);
                                $isMotherExistInAdmission = checkUniqueValue('motherAdmission', 'hospitalRegistrationNumber', $data['hospitalRegistrationNumber'], 'loungeId', $data['loungeId']);
                            }

                            if ($isMotherExistInAdmission == 0 && $isBabyExistInAdmission == 0)
                            {
                                $motherRegistration = $this
                                    ->MotherModel
                                    ->motherRegistration($data);
                                if ($motherRegistration != 0)
                                {
                                    $response['ids'] = $motherRegistration;
                                    generateServerResponse('1', '128', $response);
                                }
                                else
                                {
                                    generateServerResponse('0', 'W');
                                }
                            }
                            else
                            {
                                generateServerResponse('0', '136');
                            }
                        }
                        else
                        {
                            generateServerResponse('0', '101');
                        }
                    }
                    else
                    {
                        generateServerResponse('0', '210');
                    }
                }
                else
                {
                    generateServerResponse('0', 'W');
                }
            }
            else
            {
                generateServerResponse('0', '211');
            }
        }
        else
        {
            generateServerResponse('0', '212');
        }
    }
}

