<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Welcome.php');
class FeedbackManagement extends Welcome {
    public function __construct() {
      parent::__construct();
      $this->load->model('UserModel');
      $this->load->model('FeedbackManagementModel');
      $this->load->model('MotherModel');  
      $this->load->model('FacilityModel');  
      $this->load->model('LoungeModel'); 
      $this->load->model('BabyModel'); 
      $this->load->model('DashboardDataModel');
      $this->load->model('DangerSignModel');
      $this->load->library('pagination');    
      $this->is_not_logged_in(); 
      //$this->restrictPageAccess(array('49','50','51'));
    }
    
    public function dischargeMother(){      
    $loungeId      = $this->uri->segment(3);  
    $type          = $this->uri->segment(4); 
    $limit         = DATA_PER_PAGE;
    $pageNo        = '1';

    if($this->input->get()) { 
      
      if(!empty($this->input->get('fromDate'))){ 
        $startDate = explode('-',$this->input->get('fromDate'));  
        $explodeStartDate = explode(" ",trim($startDate[0]));
        $explodeDate =  explode("/",$explodeStartDate[0]);
        $fromDate = date("Y-m-d H:i:s", strtotime($explodeDate[1]."-".$explodeDate[0]."-".$explodeDate[2]." ".$explodeStartDate[1]." ".$explodeStartDate[2])); 
      } else {
        $fromDate = date('Y-m-d H:i:s', strtotime('1970-01-01 00:00:00')); 
      }
      if(!empty($this->input->get('fromDate'))){
        $endDate = explode('-',$this->input->get('fromDate'));  
        $explodeEndDate = explode(" ",trim($endDate[1]));
        $explodeDate =  explode("/",$explodeEndDate[0]);
        $toDate = date("Y-m-d H:i:s", strtotime($explodeDate[1]."-".$explodeDate[0]."-".$explodeDate[2]." ".$explodeEndDate[1]." ".$explodeEndDate[2]));
      } else {
        $toDate = date('Y-m-d H:i:s', strtotime(date('Y-m-d').' 23:59:59')); 
      }
      //echo $fromDate."****".$toDate;exit;
      $district = $this->input->get('district');
      $loungeid = $this->input->get('loungeid');
      $facilityname = $this->input->get('facilityname');
      $nurseid = $this->input->get('nurseid');
      $keyword  = $this->input->get('keyword'); 
      $motherStatus  = "dischargedMother"; 
      $dischargeTypeFilterValue = $this->input->get('dischargeTypeFilterValue');
      $admissionTypeFilterValue = $this->input->get('admissionTypeFilterValue'); 
      $admitTypeFilterValue = $this->input->get('admitTypeFilterValue');   
      $totalRecords = $this->FeedbackManagementModel->totalMotherRecordsSearch($loungeid,$fromDate,$toDate,$district,$keyword,$facilityname,$nurseid,$motherStatus,$dischargeTypeFilterValue,$admissionTypeFilterValue,$admitTypeFilterValue);

      $config["base_url"] = base_url('FeedbackManagement/dischargeMother/'.$loungeid.'?fromDate='.$this->input->get('fromDate').'&toDate='.$this->input->get('toDate').'&district='.$district.'&facilityname='.$facilityname.'&loungeid='.$loungeid.'&nurseid='.$nurseid.'&motherStatus='.$motherStatus.'&admissionTypeFilterValue='.$admissionTypeFilterValue.'&dischargeTypeFilterValue='.$dischargeTypeFilterValue.'&keyword='.$keyword.'&admitTypeFilterValue='.$admitTypeFilterValue);

    } else {
      if($type != ''){ 
        $totalRecords = $this->FeedbackManagementModel->getAllMotherCount($loungeId, $type);
        $config["base_url"] = base_url('FeedbackManagement/dischargeMother/'.$loungeId.'/'.$type);
      } else {  
        $totalRecords = $this->feedbackManagementModel->countAllMothers($loungeId);
        $config["base_url"] = base_url('FeedbackManagement/dischargeMother/'.$loungeId);
      }
    }

    $config["total_rows"] = $totalRecords;
    $config["per_page"] = $limit;
    $config['use_page_numbers'] = TRUE;
    $config['page_query_string'] = TRUE;
    $config['enable_query_strings'] = TRUE;
    $config['num_links'] = 2;
    $config['cur_tag_open'] = '&nbsp;<li class="active"><a>';
    $config['cur_tag_close'] = '</a></li>';
    $config['next_link'] = 'Next';
    $config['prev_link'] = 'Previous';
    $this->pagination->initialize($config);
    $str_links           = $this->pagination->create_links();
    $links               = explode('&nbsp;', $str_links);  
    $offset              = 0;
    if (!empty($_GET['per_page'])) {
        $pageNo = $_GET['per_page'];
        $offset = ($pageNo - 1) * $limit;
    }
        
    if($this->input->get()) {
      $AllRecord = $this->FeedbackManagementModel->getMotherRecordSearch($loungeid,$limit,$offset,$fromDate,$toDate,$district,$keyword,$facilityname,$nurseid,$motherStatus,$dischargeTypeFilterValue,$admissionTypeFilterValue,$admitTypeFilterValue);
    } else {
      if($type != ''){
        $AllRecord = $this->FeedbackManagementModel->getAllMotherList($limit,$offset);
      } else {
        $AllRecord = $this->FeedbackManagementModel->getAllMothers($loungeId,$limit,$offset);
      }
    }  

    $GetDistrict = $this->FacilityModel->selectquery(); 
    
    $data = array(
                'totalResult' => $totalRecords,
                'results'     => $AllRecord,
                'links'       => $links,
                'index2'      => 'reg_mother',
                'v_id'        => '',
                'GetDistrict' => $GetDistrict,
                'pageNo'      => $pageNo,
                'index'       => 'dischargeMother',
                'title'       => 'Mothers | '.PROJECT_NAME
               ); 
    
    $this->load->view('admin/include/header-new',$data);
       
    $this->load->view('admin/feedback/discharge-mother-list');      
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }

  public function viewMotherFeedback(){
        $motherId = $this->uri->segment(3);
        $data['index']         = 'dischargeMother';
        $data['index2']        = 'reg_mother';
        $data['fileName']      = 'Mother_Assessments';
        $data['title']         = 'View Mother Detail | '.PROJECT_NAME;
        $data['motherDischargeData']    = $this->FeedbackManagementModel->getMotherDetailsById($motherId);
        $data['employeeList']    = $this->FeedbackManagementModel->getEmployeeList();
        $data['motherId'] = $motherId;
        
        $data['lastFeedbackData'] = $this->FeedbackManagementModel->getMotherLastFeedback($motherId);
        
        $this->load->view('admin/include/header-new',$data);
        $this->load->view('admin/feedback/view-mother-feedback');
        $this->load->view('admin/include/footer-new');
        $this->load->view('admin/include/datatable-new');
   }

   public function saveMotherFeedbacks(){
      $sessionData = $this->session->userdata('adminData');

      $childMotherId = $this->input->post('childMotherId');
      $dateOfCall = $this->input->post('dateOfCall');
      $timeOfCall = $this->input->post('timeOfCall');
      if($sessionData['Type'] == "4"){
        $dataCollectorID = $sessionData['Id'];
      }else{
        $dataCollectorID = $this->input->post('dataCollectorID');
      }
      
      $callStatus = $this->input->post('callStatus');
      if($callStatus == "refusal"){
        $refusalReason = $this->input->post('refusalReason');
      }else{
        $refusalReason = "";
      }
      
      if($callStatus == "call_connected"){
        $babyCurrStatus = $this->input->post('babyCurrStatus');
        $motherCurrStatus = $this->input->post('motherCurrStatus');
      }else{
        $babyCurrStatus = "";
        $motherCurrStatus = "";
      }

      if($babyCurrStatus == "dead"){
        $babyDeathDate = $this->input->post('babyDeathDate');
      }else{
        $babyDeathDate = "";
      }
      
      if($motherCurrStatus == "dead"){
        $motherDeathDate = $this->input->post('motherDeathDate');
      }else{
        $motherDeathDate = "";
      }
      
      if($callStatus == "call_connected" && $motherCurrStatus != "dead"){
        $likedInHosp = $this->input->post('likedInHosp');
        $notLikedInHosp = $this->input->post('notLikedInHosp');
        $staffBehaviour = $this->input->post('staffBehaviour');
        $whatLearnt = $this->input->post('whatLearnt');
        $kMCKnowledge = $this->input->post('kMCKnowledge');
        $suggestions = $this->input->post('suggestions');
      }else{
        $likedInHosp = "";
        $notLikedInHosp = "";
        $staffBehaviour = "";
        $whatLearnt = "";
        $kMCKnowledge = "";
        $suggestions = "";
      }

      $remarks = $this->input->post('remarks');

      $lastFeedbackData = $this->FeedbackManagementModel->getMotherLastFeedback($childMotherId);

      if(empty($lastFeedbackData)){
        $insertData = array('employeeId'          => $dataCollectorID,
                            'motherId'            => $childMotherId,
                            'dateOfCall'          => date('Y-m-d',strtotime($dateOfCall)),
                            'timeOfCall'          => date('H:i:s',strtotime($timeOfCall)),
                            'callStatus'          => $callStatus,
                            'refusalReason'       => $refusalReason,
                            'babyCurrStatus'      => $babyCurrStatus,
                            'babyDeathDate'       => ($babyDeathDate != "") ? date('Y-m-d',strtotime($babyDeathDate)) : "",
                            'motherCurrStatus'    => $motherCurrStatus,
                            'motherDeathDate'     => ($motherDeathDate != "") ? date('Y-m-d',strtotime($motherDeathDate)) : "",
                            'likedInHosp'         => $likedInHosp,
                            'notLikedInHosp'      => $notLikedInHosp,
                            'staffBehaviour'      => $staffBehaviour,
                            'whatLearnt'          => $whatLearnt,
                            'kMCKnowledge'        => $kMCKnowledge,
                            'suggestions'         => $suggestions,
                            'remarks'             => $remarks,
                            'status'              => 1,
                            'addDate'             => date('Y-m-d H:i:s'),
                            'modifyDate'          => date('Y-m-d H:i:s')
                           );

        
        $this->db->insert('motherFeedbackMaster', $insertData);
      }else{
        $updateData = array('dateOfCall'          => date('Y-m-d',strtotime($dateOfCall)),
                            'timeOfCall'          => date('H:i:s',strtotime($timeOfCall)),
                            'callStatus'          => $callStatus,
                            'refusalReason'       => $refusalReason,
                            'babyCurrStatus'      => $babyCurrStatus,
                            'babyDeathDate'       => ($babyDeathDate != "") ? date('Y-m-d',strtotime($babyDeathDate)) : "",
                            'motherCurrStatus'    => $motherCurrStatus,
                            'motherDeathDate'     => ($motherDeathDate != "") ? date('Y-m-d',strtotime($motherDeathDate)) : "",
                            'likedInHosp'         => $likedInHosp,
                            'notLikedInHosp'      => $notLikedInHosp,
                            'staffBehaviour'      => $staffBehaviour,
                            'whatLearnt'          => $whatLearnt,
                            'kMCKnowledge'        => $kMCKnowledge,
                            'suggestions'         => $suggestions,
                            'remarks'             => $remarks,
                            'modifyDate'          => date('Y-m-d H:i:s')
                           );

        $this->db->where('motherId',$childMotherId);
        $this->db->update('motherFeedbackMaster', $updateData);

        // save logs
        $type = $this->session->userdata('adminData')['Type'];
        $ip = $this->input->ip_address(); 

        $logData = array();

        $logData['tableReference']        = 11;
        $logData['tableReferenceId']      = $lastFeedbackData['id'];
        $logData['updatedBy']             = $dataCollectorID;
        $logData['type']                  = $type;
        $logData['deviceInfo']            = $ip;
        
        $logData['addDate']               = date('Y-m-d H:i:s');
        $logData['lastSyncedTime']        = date('Y-m-d H:i:s');

        if($lastFeedbackData['dateOfCall'] != date('Y-m-d',strtotime($dateOfCall))) {
          $logData['columnName']           = 'जानकारी लेने की दिनांक';
          $logData['oldValue']             = $lastFeedbackData['dateOfCall'];
          $logData['newValue']             = date('Y-m-d',strtotime($dateOfCall));

          $this->db->insert('logData',$logData);
        }

        if($lastFeedbackData['timeOfCall'] != date('H:i:s',strtotime($timeOfCall))) {
          $logData['columnName']           = 'जानकारी लेने का समय';
          $logData['oldValue']             = $lastFeedbackData['timeOfCall'];
          $logData['newValue']             = date('H:i:s',strtotime($timeOfCall));

          $this->db->insert('logData',$logData);
        }

        if($lastFeedbackData['callStatus'] != $callStatus) {
          $logData['columnName']           = 'कॉल की स्थिति';
          $logData['oldValue']             = $lastFeedbackData['callStatus'];
          $logData['newValue']             = $callStatus;

          $this->db->insert('logData',$logData);
        }

        if($lastFeedbackData['refusalReason'] != $refusalReason) {
          $logData['columnName']           = 'बात करने से मना करने का कारण';
          $logData['oldValue']             = $lastFeedbackData['refusalReason'];
          $logData['newValue']             = $refusalReason;

          $this->db->insert('logData',$logData);
        }

        if($lastFeedbackData['babyCurrStatus'] != $babyCurrStatus) {
          $logData['columnName']           = 'बच्चे की वर्तमान स्थिति';
          $logData['oldValue']             = $lastFeedbackData['babyCurrStatus'];
          $logData['newValue']             = $babyCurrStatus;

          $this->db->insert('logData',$logData);
        }

        $currentBabyDeathDate = ($babyDeathDate != "") ? date('Y-m-d',strtotime($babyDeathDate)) : "0000-00-00";
        if($lastFeedbackData['babyDeathDate'] != $currentBabyDeathDate) {
          $logData['columnName']           = 'बच्चे की मृत्यु की दिनांक';
          $logData['oldValue']             = $lastFeedbackData['babyDeathDate'];
          $logData['newValue']             = $currentBabyDeathDate;

          $this->db->insert('logData',$logData);
        }

        if($lastFeedbackData['motherCurrStatus'] != $motherCurrStatus) {
          $logData['columnName']           = 'माँ की वर्तमान स्थिति';
          $logData['oldValue']             = $lastFeedbackData['motherCurrStatus'];
          $logData['newValue']             = $motherCurrStatus;

          $this->db->insert('logData',$logData);
        }

        $currentMotherDeathDate = ($motherDeathDate != "") ? date('Y-m-d',strtotime($motherDeathDate)) : "0000-00-00";
        if($lastFeedbackData['motherDeathDate'] != $currentMotherDeathDate) {
          $logData['columnName']           = 'माँ की मृत्यु की दिनांक';
          $logData['oldValue']             = $lastFeedbackData['motherDeathDate'];
          $logData['newValue']             = $currentMotherDeathDate;

          $this->db->insert('logData',$logData);
        }

        if($lastFeedbackData['likedInHosp'] != $likedInHosp) {
          $logData['columnName']           = 'आपको अस्पताल में रुकने के दौरान क्या-क्या अच्छा लगा';
          $logData['oldValue']             = $lastFeedbackData['likedInHosp'];
          $logData['newValue']             = $likedInHosp;

          $this->db->insert('logData',$logData);
        }

        if($lastFeedbackData['notLikedInHosp'] != $notLikedInHosp) {
          $logData['columnName']           = 'आपको अस्पताल में रुकने के दौरान क्या अच्छा नहीं लगा';
          $logData['oldValue']             = $lastFeedbackData['notLikedInHosp'];
          $logData['newValue']             = $notLikedInHosp;

          $this->db->insert('logData',$logData);
        }

        if($lastFeedbackData['staffBehaviour'] != $staffBehaviour) {
          $logData['columnName']           = 'आपको अस्पताल में रुकने के दौरान वहां के स्वास्थ्यकर्मियों का व्यवहार कैसा लगा';
          $logData['oldValue']             = $lastFeedbackData['staffBehaviour'];
          $logData['newValue']             = $staffBehaviour;

          $this->db->insert('logData',$logData);
        }

        if($lastFeedbackData['whatLearnt'] != $whatLearnt) {
          $logData['columnName']           = 'आपने अस्पताल में रुकने के दौरान क्या-क्या सीखा';
          $logData['oldValue']             = $lastFeedbackData['whatLearnt'];
          $logData['newValue']             = $whatLearnt;

          $this->db->insert('logData',$logData);
        }

        if($lastFeedbackData['kMCKnowledge'] != $kMCKnowledge) {
          $logData['columnName']           = 'आपको KMC के बारे में क्या पता है';
          $logData['oldValue']             = $lastFeedbackData['kMCKnowledge'];
          $logData['newValue']             = $kMCKnowledge;

          $this->db->insert('logData',$logData);
        }

        if($lastFeedbackData['suggestions'] != $suggestions) {
          $logData['columnName']           = 'आपको क्या लगता है कि अस्पताल में किन चीज़ों में सुधार किया जाना चाहिये';
          $logData['oldValue']             = $lastFeedbackData['suggestions'];
          $logData['newValue']             = $suggestions;

          $this->db->insert('logData',$logData);
        }

        if($lastFeedbackData['remarks'] != $remarks) {
          $logData['columnName']           = 'यदि कोई टिप्पणी हो';
          $logData['oldValue']             = $lastFeedbackData['remarks'];
          $logData['newValue']             = $remarks;

          $this->db->insert('logData',$logData);
        }
      }

      $this->session->set_flashdata('activate', getCustomAlert('S','Feedback added successfully'));
      redirect('FeedbackManagement/dischargeMother/all/all');
   }

   public function viewFeedbackLog(){
      $id = $this->uri->segment('3');
      $data['index']               = 'dischargeMother';
      $data['index2']              = '';
      $data['fileName']            = 'History';
      $data['feedback_id']         = $id;
      $data['title']               = 'Feedback Log History | '.PROJECT_NAME; 
      $feedbackData = $this->FacilityModel->GetDataById('motherFeedbackMaster',$id);
      $data['GetMotherData']    = $this->db->query("select * from motherRegistration where motherId=".$feedbackData['motherId'])->row_array();
      $data['GetLogHistory']    = $this->FeedbackManagementModel->getFeedbackLastUpdate($id, 2);
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/feedback/feedback-log-history');
      $this->load->view('admin/include/footer-new');
      $this->load->view('admin/include/datatable-new',$data);
    }

    public function getFacility(){
      if($this->input->post()){
        $district = $this->input->post('districtId');
        $facility = $this->input->post('facility');
        $getDistrict = $this->LoungeModel->GetFacilityByDistrict($district); 
        $html = ''; 
        if(!empty($getDistrict)){
          $html.='<option value="">Select Facility</option>';
          foreach ($getDistrict as $key => $value) {
            $Select = ($facility==$value['FacilityID'])?'SELECTED':'' ;
            $html.='<option value="'.$value['FacilityID'].'" '.$Select.'>'.$value['FacilityName'].'</option>';
          }
        } else {
          $html.='<option value="">No Records Found</option>';
        }
        echo $html;die;
      }
    }

    public function getLounge(){
      if($this->input->post()){
        $facility = $this->input->post('facility');
        $loungeid = $this->input->post('loungeid');
        $getLounge = $this->LoungeModel->GetLoungeByFAcility($facility); 
        $html = ''; 
        if(!empty($getLounge)){
          $html.='<option value="">Select Lounge</option>';
          foreach ($getLounge as $key => $value) {
            $Select = ($loungeid==$value['loungeId'])?'SELECTED':'' ;
            $html.='<option value="'.$value['loungeId'].'" '.$Select.'>'.$value['loungeName'].'</option>';
          }
        } else {
          $html.='<option value="">No Records Found</option>';
        }
        echo $html;die;
      }
    }


    public function getNurse(){
      if($this->input->post()){
        $facility = $this->input->post('facility');
        $nurseid = $this->input->post('nurseid');
        $getNurse = $this->LoungeModel->GetNurseByFacility($facility); 
        $html = ''; 
        if(!empty($getNurse)){
          $html.='<option value="">Select Nurse</option>';
          foreach ($getNurse as $key => $value) {
            $Select = ($nurseid==$value['staffId'])?'SELECTED':'' ;
            $html.='<option value="'.$value['staffId'].'" '.$Select.'>'.$value['name'].'</option>';
          }
        } else {
          $html.='<option value="">No Records Found</option>';
        }
        echo $html;die;
      }
    }


}
 