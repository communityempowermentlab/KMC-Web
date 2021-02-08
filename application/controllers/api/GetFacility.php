<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class GetFacility extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this
            ->load
            ->model('api/FacilityModel');
    }

    public function index()
    {
        $requestData = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson = json_decode($requestData, true);

        $data['districtId'] = trim($requestJson[APP_NAME]['districtId']);
        $data['timestamp'] = (isset($requestJson[APP_NAME]['timestamp'])) ? trim($requestJson[APP_NAME]['timestamp']):"";

        if(isset($requestJson[APP_NAME]['timestamp'])){
            $checkRequestKeys = array('districtId','timestamp');
        }else{
            $checkRequestKeys = array('districtId');
        }
        
        $resultJson = validateJson($requestJson, $checkRequestKeys);
        $headers = apache_request_headers();

        if (!empty($headers['package']))
        {
            if ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE)))
            {
                if ($resultJson == 1)
                {
                    $post = array();
                    $response = array();
                    $synctime = date('Y-m-d H:i:s');
                    $getFacility = $this
                        ->FacilityModel
                        ->getFacility($data);
                    if ($getFacility != 0)
                    {
                        foreach ($getFacility as $key => $value)
                        {
                            $arrayname['facilityId'] = $value['FacilityID'];
                            $arrayname['facilityType'] = $value['FacilityType'];
                            $arrayname['facilityTypeId'] = $value['FacilityTypeID'];
                            $arrayname['facilityName'] = $value['FacilityName'];
                            $arrayname['districtName'] = ($value['PRIDistrictCode'] != '') ? $this
                                ->FacilityModel
                                ->GetDistrictName($value['PRIDistrictCode']) : '';
                            $arrayname['proiority'] = $value['Priority'];
                            $arrayname['priCodeDistrict'] = $value['PRIDistrictCode'];
                            $post[] = $arrayname;
                        }

                        $response['facilityList'] = $post;

                        generateServerResponse('1', '132', $response, $synctime);
                    }
                    else
                    {
                        generateServerResponse('0', 'W');
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
}

