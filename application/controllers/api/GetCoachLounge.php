<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-type: application/json");
class GetCoachLounge extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/ApiModel');
      
    }
    public function index()
    {
        $requestData           = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson           = json_decode($requestData, true);
       
        $data['coachId']      = trim($requestJson[APP_NAME]['coachId']);  
        

        $checkRequestKeys = array(                                        
                                    '0' => 'coachId'
                                    );
        $resultJson = validateJson($requestJson, $checkRequestKeys);
        // for header code 
        $headers    = apache_request_headers();
       // check for header 
        $coachData = $this->db->get_where('coachMaster', array('id'=>$data['coachId'],'status'=>'1'));

        /*$loungeData = $this->db->get_where('loungeMaster', array('loungeId'=>$data['loungeId'],'imeiNumber'=>$data['imeiNumber'],'status'=>'1'));*/
       
        if($coachData->num_rows() != 0 )
        {
            $getCoachData = $coachData->row_array();
              if(!empty($headers['token']) && !empty($headers['package'])){
                if($headers['token'] == $getCoachData['token'] && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE)))){
                            if ($resultJson == 1) { 
                                $getData = $this->ApiModel->getCoachLounge($data);
                                    if($getData != 0){
                                         $response['loungeDetails'] = $getData;
                                        generateServerResponse('1','S', $response);

                                    }else{
                                        generateServerResponse('0','P');
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
        }
        else{
           generateServerResponse('0','215');
        }   
         
    }
}