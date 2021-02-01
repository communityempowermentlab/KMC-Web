<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetMother extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/mother_model');
    }
    public function index()
    {
      $request_data      = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson       = json_decode($request_data, true);
        $data['lounge_id'] = trim($requestJson[APP_NAME]['lounge_id']);   
        $data['userType']  = trim($requestJson[APP_NAME]['userType']);   
        $check_request_keys = array(             
                                    '0' => 'lounge_id',
                                    '1' => 'userType'
                                    );
        $resultJson = validateJson($requestJson, $check_request_keys);
        $headers    = apache_request_headers();
         
        if($data['userType'] == '0'){ // for lounge
           $loungeData = tokenVerificationHere($data['userType'],$data['lounge_id']);
        }else if($data['userType'] == '1'){ // for staff
           $loungeData = tokenVerificationHere($data['userType'],$data['lounge_id']);
        }else{
            generateServerResponse('0','218');  
        }
        $getLoungeData = $loungeData->row_array(); 
            if($loungeData->num_rows() != 0)
            {
              if(!empty($headers['token']) && !empty($headers['package']))
              {
                if(($headers['token'] == $getLoungeData['token']) && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
                {   
                     if ($resultJson == 1) {
                       
                      $arrayName = array();
                      $response  = array();
                      $synctime  = '';
                       
                  $GetMothers = $this->MotherModel->GetMothers($data);  
                  
                      if(count($GetMothers) > 0){
                              $x=1;
                          foreach ($GetMothers as $key => $mother){
                            $checkMonitoringOrNot = $this->db->get_where('mother_monitoring',array('MotherID'=>$mother['MotherID']))->num_rows();
                            if($checkMonitoringOrNot > 0){

                                $status1=0;
                                $status2=0;
                                $status3=0;
                                $status4=0;
                                $status5=0;
                                $status6=0;
                                $status7=0;
                                $status8=0;

                                $get_last_assessment = $this->db->order_by('id','Desc')->limit(1)->select('*')->get_where('mother_monitoring', array('MotherID'=>$mother['MotherID'], 'LoungeID'=>$data['lounge_id']))->row_array();
                                // echo $this->db->last_query(); exit;
                                print_r($get_last_assessment);
                                $image=singlerowparameter2('MotherPicture','MotherID',$mother['MotherID'],'mother_registration');
                                $arrayName['mother_admission_id']= $mother['id'];
                                $arrayName['mother_id'] = $mother['MotherID']; 
                                $arrayName['mother_name']= singlerowparameter2('MotherName','MotherID',$mother['MotherID'],'mother_registration');
                                $arrayName['mother_temp'] = $get_last_assessment['MotherTemperature'];
                                $arrayName['mother_photo'] = ($image!='') ?MOTHER_IMAGE.singlerowparameter2('MotherPicture','MotherID',$mother['MotherID'],'mother_registration') : '';
                                $arrayName['systolic'] =  $get_last_assessment['MotherSystolicBP'] ;
                                $arrayName['diastolic'] =  $get_last_assessment['MotherDiastolicBP'] ;
                                $arrayName['motherPulse'] =  $get_last_assessment['MotherPulse'] ;
                                $arrayName['last_assement_time'] =  $get_last_assessment['add_date'];

                              if($get_last_assessment['MotherPulse'] < 50 || $get_last_assessment['MotherPulse'] > 120){
                               $status1 = '1';
                              }

                              if($get_last_assessment['MotherTemperature'] < 95.9 || $get_last_assessment['MotherTemperature'] > 99.5){
                               $status2 = '1';
                              }


                             if($get_last_assessment['MotherSystolicBP'] >= 140 || $get_last_assessment['MotherSystolicBP'] <= 90){
                               $status3 = '1';
                              }

                              if($get_last_assessment['MotherDiastolicBP'] <= 60 || $get_last_assessment['MotherDiastolicBP'] >= 90){
                               $status4 = '1';
                              }

                              if($get_last_assessment['MotherUterineTone'] == 'Hard/Collapsed (Contracted)'){
                               $status5 = '1';
                              }

                              if(!empty($get_last_assessment['EpisitomyCondition']) && $get_last_assessment['EpisitomyCondition'] == 'Infected'){
                               $status6 = '1';
                              }                                   

                              if(!empty($get_last_assessment['SanitoryPadStatus']) && $get_last_assessment['SanitoryPadStatus'] == "It's FULL"){
                               $status7 = '1';
                              }   

                              if(!empty($get_last_assessment['MotherBleedingStatus']) && $get_last_assessment['MotherBleedingStatus'] == "Yes"){
                               $status8 = '1';
                              }                      

                              if($status1 ==1 || $status2 ==1 || $status3 ==1 || $status4 ==1 || $status5 ==1 || $status6 ==1 || $status7 ==1 || $status8 ==1)
                              { 
                              $arrayName['status'] = 1;
                              }else{
                              $arrayName['status'] = 0;
                              }

                              $response['mother_list'][] = $arrayName;
                              }
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

    public function GetMotherMonitorLastData($MotherID, $LoungeID)
    {
      return $this->db->query("SELECT `MotherTemperature`, `add_date`   FROM ,mother_monitoring Where `MotherID` = '".$MotherID."' And `LoungeID` = '".$LoungeID."' And status != 2  order by MotherID desc limit 0, 1 ")->row_array(); 
    }

}