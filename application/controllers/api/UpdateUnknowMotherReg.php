<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UpdateUnknowMotherReg extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/MotherModel');
      
    }
    public function index()
    {
        $requestData       = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true);

        $data['guardianName']     = trim($requestJson[APP_NAME]['guardianName']);
        $data['guardianNumber'] = trim($requestJson[APP_NAME]['guardianNumber']);
        $data['organisationName']          = trim($requestJson[APP_NAME]['organisationName']);
        $data['organisationNumber']        = trim($requestJson[APP_NAME]['organisationNumber']);
        $data['organisationAddress']       = trim($requestJson[APP_NAME]['organisationAddress']);
        $data['hospitalRegistrationNumber']   = trim($requestJson[APP_NAME]['hospitalRegistrationNumber']);
        $data['type']              = trim($requestJson[APP_NAME]['type']);
        $data['motherId']         = trim($requestJson[APP_NAME]['motherId']);

        $checkRequestKeys = array(                                        
                                    '0' => 'type',
                                    '1' => 'organisationName',
                                    '2' => 'organisationNumber',
                                    '3' => 'organisationAddress',
                                    '4' => 'guardianName',
                                    '5' => 'guardianNumber',
                                    '6' => 'hospitalRegistrationNumber',
                                    '7' => 'motherId'
                                );
        $resultJson = validateJson($requestJson, $checkRequestKeys);

        /*print_r($requestJson);exit;*/

        if ($resultJson == 1) {
            $post = array();
            $response = array();

            $checkHospitalRegistrationNumber = $this->MotherModel->checkHospitalRegistrationNumber($data['hospitalRegistrationNumber'], $data['motherId']);
                if($checkHospitalRegistrationNumber == 0)
                {
                    $mother_reg = $this->MotherModel->UpdateunknowMotherRegistration($data);
                    if($mother_reg != 0){
                       
                        generateServerResponse('1','151');
                    }else{
                        generateServerResponse('0','W');

                    }
                }else{
                    generateServerResponse('0','136');
                }
        }else{
            
            generateServerResponse('0','101');              
        }

         
    }
}