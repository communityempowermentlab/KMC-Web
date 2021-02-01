<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class UpdateFileId extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/ApiModel');
    }
    public function index()
    {
        $requestData      = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson       = json_decode($requestData, true);

        $data['loungeId']         = trim($requestJson[APP_NAME]['loungeId']);
        $data['babyFileId']       = trim($requestJson[APP_NAME]['babyFileId']);   
        $data['babyAdmissionId']  = trim($requestJson[APP_NAME]['babyAdmissionId']);   
        $checkRequestKeys = array(             
                                '0' => 'loungeId',
                                '1' => 'babyFileId',
                                '2' => 'babyAdmissionId'
                                );
        $resultJson = validateJson($requestJson, $checkRequestKeys);

// for header security 
        $headers    = apache_request_headers();
        $loungeData = $this->db->get_where('loungeMaster', array('loungeId'=>$requestJson[APP_NAME]['loungeId'],'status'=>'1'));
        $getLoungeData = $loungeData->row_array(); 
            if($loungeData->num_rows() != 0)
            {
              if(!empty($headers['token']) && !empty($headers['package']))
              {
                if(($headers['token'] == $getLoungeData['token']) && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
                {
                  if ($resultJson == 1) {
                      $babyFileId = checkUniqueValue('babyAdmission','babyFileId',$data['babyFileId'],'loungeId',$data['loungeId']);
                      if($babyFileId == '1'){
                        generateServerResponse('0','137');
                      }else{
                         $this->db->where(array('loungeId'=>$data['loungeId'],'id'=>$data['babyAdmissionId']));
                         $this->db->update('babyAdmission',array('babyFileId'=>$data['babyFileId']));
                         generateServerResponse('1','S');
                      }
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
