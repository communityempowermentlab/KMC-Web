<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetMother extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/MotherModel');
    }

    public function index()
    {
      $requestData      = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson       = json_decode($requestData, true);
        $data['loungeId'] = trim($requestJson[APP_NAME]['loungeId']);   
        $data['coachId']  = trim($requestJson[APP_NAME]['coachId']);   
        $checkRequestKeys = array(             
                                    '0' => 'loungeId',
                                    '1' => 'coachId'
                                    );
        $resultJson = validateJson($requestJson, $checkRequestKeys);
        $headers    = apache_request_headers();
         
        $coachData = $this->db->get_where('coachMaster', array('id'=>$data['coachId'],'status'=>'1'));
        
        $getCoachData = $coachData->row_array();
        
            if($coachData->num_rows() != 0)
            {
              if(!empty($headers['token']) && !empty($headers['package']))
              {
                if(($headers['token'] == $getCoachData['token']) && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
                {   
                     if ($resultJson == 1) {
                       
                      $arrayName = array();
                      $response  = array();
                      $synctime  = '';
                       
                    $GetMothers = $this->MotherModel->GetMothers($data);  
                    
                      if(count($GetMothers) > 0){
                              $x=1;
                          foreach ($GetMothers as $key => $mother){
                            $checkMonitoringOrNot = $this->db->get_where('motherMonitoring',array('motherAdmissionId'=>$mother['id']))->num_rows();
                            

                             
                                $loungeData          = getStaffLoungeId($data['loungeId']);
                                $getLastAssessment = $this->db->order_by('id','Desc')->limit(1)->select('*')->get_where('motherMonitoring', array('motherAdmissionId'=>$mother['id']))->row_array();
                              
                              
                                $image=getSingleRowFromTable('motherPicture','motherId',$mother['motherId'],'motherRegistration');
                                $arrayName['motherAdmissionId']= $mother['id'];
                                $arrayName['motherId'] = $mother['motherId']; 
                                $arrayName['motherName']= getSingleRowFromTable('motherName','motherId',$mother['motherId'],'motherRegistration');

                                $arrayName['motherTemperature'] =  (!empty($getLastAssessment)) ? $getLastAssessment['motherTemperature'] : '';
                                $arrayName['motherPicture'] = ($image!='') ?motherDirectoryUrl.getSingleRowFromTable('motherPicture','motherId',$mother['motherId'],'motherRegistration') : '';
                                $arrayName['motherSystolicBP'] =  (!empty($getLastAssessment)) ? $getLastAssessment['motherSystolicBP'] : ''; 
                                $arrayName['motherDiastolicBP'] = (!empty($getLastAssessment)) ? $getLastAssessment['motherDiastolicBP'] : '';  
                                $arrayName['motherPulse'] = (!empty($getLastAssessment)) ? $getLastAssessment['motherPulse'] : '';   
                                $arrayName['addDate'] = (!empty($getLastAssessment)) ? $getLastAssessment['addDate'] : '';  
                                $motherStatus = $this->MotherModel->getMotherIcon($getLastAssessment); 
                               // $motherStatus value is zero then unstable for it response 1 other wise o
                                if($motherStatus == 0){
                                  $arrayName['status'] = 1;
                                }else{
                                  $arrayName['status'] = 0;
                                }

                                $response['motherList'][] = $arrayName;
                              
                            }
                          generateServerResponse('1','133',$response);
                        }else{
                        generateServerResponse('0','E');
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

    }

}