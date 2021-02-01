<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class GetMotherDetail extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/MotherModel');
      
    }
    public function index()
    {
    	$requestData       = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true);

      
        $data['motherId'] 		= trim($requestJson[APP_NAME]['motherId']);
        $data['loungeId'] 		= trim($requestJson[APP_NAME]['loungeId']);
        $data['coachId'] 		= trim($requestJson[APP_NAME]['coachId']);
       
        $checkRequestKeys = array(                
                                    '0' => 'motherId',
                                    '1' => 'loungeId',
                                    '2' => 'coachId'
                                    );
        $resultJson = validateJson($requestJson, $checkRequestKeys);

// for header security 
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
						$response = array();
						$GetMotherDetail  = $this->MotherModel->GetMotherDetail($data);
						$MotherInfomation = $this->db->get_where('motherRegistration',array('motherId'=>$data['motherId']))->row_array();

			            $this->db->order_by('id','desc');
					    $MotherInfomation1 = $this->db->get_where('motherAdmission',array('motherId'=>$data['motherId']))->row_array();

			            $this->db->order_by('babyId','desc');
					    $GetBabyID = $this->db->get_where('babyRegistration',array('motherId'=>$data['motherId']))->row_array();

			            $this->db->order_by('id','desc');
					    $GetPDF = $this->db->get_where('babyAdmission',array('babyId'=>$GetBabyID['babyId']))->row_array();
					
						$this->db->select('deliveryDate');
						//$this->db->select('babyPdfFileName');
						$this->db->order_by('babyId','Desc');
						$getMotherDOD = $this->db->get_where('babyRegistration', array('motherId'=>$data['motherId'], 'status !='=>'2'))->row_array();
						$dayCount = getDateDifference(strtotime($getMotherDOD['deliveryDate']));
						$getdeliveryType = $this->MotherModel->deliveryType($data['motherId']);
						
						$this->db->order_by('id','Desc');
						$getCommentData = $this->db->get_where('comments', array('admissionId'=>$MotherInfomation1['id'], 'type'=>'1'))->row_array();

						//print_r($GetMotherDetail); exit;

							
						
							$response['registrationData'] 	= $MotherInfomation;

							$response['admissionData'] 	= $MotherInfomation1;

					

							$response['pdf'] = ($GetPDF['babyPdfFileName']!='')? pdfDirectoryUrl.$GetPDF['babyPdfFileName'] :'';
							$response['monitoringData'] = $GetMotherDetail;
							if(!empty($getCommentData)){
								$detDoctorName = $this->db->get_where('staffMaster', array('staffId'=>$getCommentData['doctorId']))->row_array();
								$getCommentData['doctorName'] = $detDoctorName['name'];

							} 
							$response['commentData'] = $getCommentData;

							
							$response['md5Data'] = md5(json_encode($response));

							if(count($response)>0)
							{
								generateServerResponse('1','S',$response);
							}else{
								generateServerResponse('1','E');
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


      public function DistrictVillageBlock($id, $type='')
     {

     	if($type=='1'){
			$query= $this->db->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs` 		where `revenuevillagewithblcoksandsubdistandgs`.`GPPRICode`= '".$id."' limit 0,1")->row_array();
			return $query['GPNameProperCase'];
     	}elseif($type=='2'){
     		$query= $this->db->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs`  
					where `revenuevillagewithblcoksandsubdistandgs`.`BlockPRICode`= '".$id."' limit 0,1")->row_array();
			return $query['BlockPRINameProperCase'];
     	}elseif($type=='3'){
     		$query= $this->db->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs`  
					where `revenuevillagewithblcoksandsubdistandgs`.`PRIDistrictCode`= '".$id."' limit 0,1")->row_array();
			return $query['DistrictNameProperCase'];
     	}
     	 
     }
}