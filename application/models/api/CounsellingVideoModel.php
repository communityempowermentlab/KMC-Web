<?php
class CounsellingVideoModel extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();	
		date_default_timezone_set("Asia/KolKata");
	}
	
	

// View counselling Video post
   public function postCounsellingVideo($request)
	{	
		$requestData       = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
		$requestJson        = json_decode($requestData, true);
	   	$countData = count($request['videoId']);
       	if($countData > 0){
	       	$param1 = array();
	       	$param  = array();
	       	$checkDataForAllUpdate = 1;  // check for all data synced or not
	       	foreach ($request['videoId'] as $key => $request) {

	       		$validateVideoId = $this->db->get_where('counsellingMaster', array('id' => trim($request['videoId'])))->row_array();
	       		

	       		if((!empty($validateVideoId)) && (trim($request['videoId']) != "")){
					

		       		

		       		    $checkDataForAllUpdate = 2;			
						$arrayName = array();
				         
						$arrayName['counsellingMasterId'] 	  = $request['videoId'];
						$arrayName['loungeId'] 		      = $request['loungeId'];

								

						$arrayName['addDate']                      = $request['localDateTime'];
						$arrayName['lastSyncedTime']                = date('Y-m-d H:i:s');
				      	//get last Baby AdmissionId
				        $inserted = $this->db->insert('counsellingVideoLog', $arrayName);
						$lastID   = $this->db->insert_id();

					$param1[] = $request['videoId'];	

	                    
		            
		        }
	   		} 
	   		if($checkDataForAllUpdate == 1 || $checkDataForAllUpdate == 2){
		       $data['id'] = $param1;
	           generateServerResponse('1','S', $data);
			}
			else{ 
				generateServerResponse('0','213');
			} 	        
        } else{
			 generateServerResponse('0','213');
		} 	
    }

	

}