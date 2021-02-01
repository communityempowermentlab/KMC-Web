<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Welcome.php');
class MotherManagenent extends Welcome {
  public function __construct() {
      parent::__construct();
      $this->load->model('MotherModel');  
      $this->load->model('FacilityModel');  
      $this->load->model('LoungeModel'); 
      $this->load->model('BabyModel'); 
      $this->load->model('DashboardDataModel');
      $this->load->model('DangerSignModel');
      $this->load->library('pagination');
      $this->is_not_logged_in(); 
    }
// Get Mother list


  public function registeredMother(){      
    $loungeId      = $this->uri->segment(3);  
    $type          = $this->uri->segment(4); 
    $limit         = DATA_PER_PAGE;
    $pageNo        = '1';

    if($this->input->get()) { 
      if(!empty($this->input->get('fromDate'))){ 
        $startDate = explode(',',$this->input->get('fromDate')); 
        $fromDate = $startDate[0].$startDate[1];
        $fromDate = date("Y-m-d H:i:s", strtotime($fromDate)); 
      } else {
        $fromDate = date('Y-m-d H:i:s', strtotime('1970-01-01 00:00:00')); 
      }
      if(!empty($this->input->get('toDate'))){
        $endDate = explode(',',$this->input->get('toDate')); 
        $toDate = $endDate[0].$endDate[1];
        $toDate = date("Y-m-d H:i:s", strtotime($toDate.' 23:59:59')); 
      } else {
        $toDate = date('Y-m-d H:i:s', strtotime(date('Y-m-d').' 23:59:59')); 
      }
      
      $district = $this->input->get('district');
      $loungeid = $this->input->get('loungeid');
      $facilityname = $this->input->get('facilityname');
      $nurseid = $this->input->get('nurseid');
      $keyword  = $this->input->get('keyword'); 
      $motherStatus  = $this->input->get('motherStatus'); 
      $totalRecords = $this->MotherModel->totalMotherRecordsSearch($loungeid,$fromDate,$toDate,$district,$keyword,$facilityname,$nurseid,$motherStatus);
      $config["base_url"] = base_url('motherM/registeredMother/'.$loungeid.'?fromDate='.$this->input->get('fromDate').'&toDate='.$this->input->get('toDate').'&district='.$district.'&keyword='.$keyword);

    } else {
      if($type != ''){ 
        $totalRecords = $this->MotherModel->getAllMotherCount($loungeId, $type);
        $config["base_url"] = base_url('motherM/registeredMother/'.$loungeId.'/'.$type);
      } else {  
        $totalRecords = $this->MotherModel->countAllMothers($loungeId);
        $config["base_url"] = base_url('motherM/registeredMother/'.$loungeId);
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
      $AllRecord = $this->MotherModel->getMotherRecordSearch($loungeid,$limit,$offset,$fromDate,$toDate,$district,$keyword,$facilityname,$nurseid,$motherStatus);
    } else {
      if($type != ''){
        $AllRecord = $this->MotherModel->getAllMotherList($limit,$offset);
      } else { 
        $AllRecord = $this->MotherModel->getAllMothers($loungeId,$limit,$offset);
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
                'index'       => 'Mother',
                'title'       => 'Mothers | '.PROJECT_NAME
               ); 
    
    $this->load->view('admin/include/header-new',$data);
       
    $this->load->view('admin/mother/mother-list');      
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }


  public function registeredMotherBKUP(){      
   $loungeId     = $this->uri->segment(3);  
   $motherStatus = $this->uri->segment(4); 
   $limit         = 100;
   $pageNo        = '1';
   if(!empty($motherStatus) && $motherStatus == 'admitted'){ 
      if (empty($_GET['keyword'])) { 
        $totalRecords = $this->DashboardDataModel->totallyAdmittedMothers($loungeId);
      } else if(!empty($_GET['keyword'])) { 
        $totalRecords = $this->MotherModel->mothersListWhereSearching($loungeId,$_GET['keyword'],$motherStatus);
      } 
    // set url for seaching and without searching
      if (!empty($_GET['keyword'])) {
          $config["base_url"] = base_url('motherM/registeredMother/'.$loungeId.'/'.$motherStatus.'?keyword=' . $_GET['keyword']);
      } else {
          $config["base_url"] = base_url('motherM/registeredMother/'.$loungeId.'/'.$motherStatus.'?keyword=');
      }
   }elseif(!empty($motherStatus) && $motherStatus == 'currentlyAvail'){
      if (empty($_GET['keyword'])) {
        $totalRecords = $this->DashboardDataModel->getAllAdmittedMothersViaLounge($loungeId,1);
      } else if(!empty($_GET['keyword'])) {
        $totalRecords = $this->MotherModel->mothersListWhereSearching($loungeId,$_GET['keyword'],$motherStatus);
      }
    // set url for seaching and without searching
      if (!empty($_GET['keyword'])) {
          $config["base_url"] = base_url('motherM/registeredMother/'.$loungeId.'/'.$motherStatus.'?keyword=' . $_GET['keyword']);
      } else {
          $config["base_url"] = base_url('motherM/registeredMother/'.$loungeId.'/'.$motherStatus.'?keyword=');
      }
   }elseif(!empty($motherStatus) && $motherStatus == 'dischargedMother'){
      if (empty($_GET['keyword'])) {
        $totalRecords = $this->DashboardDataModel->getAllAdmittedMothersViaLounge($loungeId,2);
      } else if(!empty($_GET['keyword'])) {
        $totalRecords = $this->MotherModel->mothersListWhereSearching($loungeId,$_GET['keyword'],$motherStatus);
      }
    // set url for seaching and without searching
      if (!empty($_GET['keyword'])) {
          $config["base_url"] = base_url('motherM/registeredMother/'.$loungeId.'/'.$motherStatus.'?keyword=' . $_GET['keyword']);
      } else {
          $config["base_url"] = base_url('motherM/registeredMother/'.$loungeId.'/'.$motherStatus.'?keyword=');
      }
   }else{
      if (empty($_GET['keyword'])) {
        $totalRecords = $this->MotherModel->countAllMothers($loungeId,$motherStatus);
      } else if(!empty($_GET['keyword'])) {
        $totalRecords = $this->MotherModel->mothersListWhereSearching($loungeId,$_GET['keyword']);
      }
    // set url for seaching and without searching
        if (!empty($_GET['keyword'])) {
            $config["base_url"] = base_url('motherM/registeredMother/'.$loungeId.'?keyword=' . $_GET['keyword']);
        } else {
            $config["base_url"] = base_url('motherM/registeredMother/'.$loungeId.'?keyword=');
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
        
      if(!empty($motherStatus) && $motherStatus == 'admitted'){
        if (empty($_GET['keyword'])) {
          $AllRecord = $this->MotherModel->getAllMothers($loungeId,$limit,$offset,$motherStatus);
        }else if(!empty($_GET['keyword']))
        {
           $AllRecord = $this->MotherModel->getAllMothersWhereSearching($_GET['keyword'],$loungeId,$limit,$offset,$motherStatus);
        }
      }elseif(!empty($motherStatus) && $motherStatus == 'currentlyAvail'){
        if (empty($_GET['keyword'])) {
          $AllRecord = $this->MotherModel->getAllMothers($loungeId,$limit,$offset,$motherStatus);
        }else if(!empty($_GET['keyword']))
        {
           $AllRecord = $this->MotherModel->getAllMothersWhereSearching($_GET['keyword'],$loungeId,$limit,$offset,$motherStatus);
        }
      }elseif(!empty($motherStatus) && $motherStatus == 'dischargedMother'){
        if (empty($_GET['keyword'])) {
          $AllRecord = $this->MotherModel->getAllMothers($loungeId,$limit,$offset,$motherStatus);
        }else if(!empty($_GET['keyword']))
        {
           $AllRecord = $this->MotherModel->getAllMothersWhereSearching($_GET['keyword'],$loungeId,$limit,$offset,$motherStatus);
        }
      }else{
        if (empty($_GET['keyword'])) {
          $AllRecord = $this->MotherModel->getAllMothers($loungeId,$limit,$offset);
        }else if(!empty($_GET['keyword']))
        {
           $AllRecord = $this->MotherModel->getAllMothersWhereSearching($_GET['keyword'],$loungeId,$limit,$offset);
        }
      }  

       $data = array(
                'totalResult' => $totalRecords,
                'results'     => $AllRecord,
                'links'       => $links,
                'index2'      => 'reg_mother',
                'v_id'        => '',
                'pageNo'      => $pageNo,
                'index'       => 'Mother',
                'title'       => 'Manage Mothers | '.PROJECT_NAME
               );
        $this->load->view('admin/include/header',$data);
        $this->load->view('admin/include/tableScript');      
        $this->load->view('admin/mother/MotherList');      
        $this->load->view('admin/include/footer');
  }
/*Registred Single Mother List BY ID */
public function viewMother(){
      $motherId = $this->uri->segment(3);
      $data['index']         = 'Mother';
      $data['index2']        = 'reg_mother';
      $data['fileName']      = 'Mother_Assessments';
      $data['title']         = 'View Mother Detail | The Kangaroo Care';
      $data['motherData']    = $this->MotherModel->getMotherDataById('motherRegistration',$motherId);
      $data['motherAdmitData']    = $this->db->get_where('motherAdmission',array('motherId'=>$motherId))->row_array();

      $GetAllBabiesList      = $this->MotherModel->getMotherData('babyRegistration',$motherId);
      $babyIds = array_column($GetAllBabiesList, 'babyId');
      $data['babyIds'] = $babyIds;

      $data['GetAllCounsellingList']      = $this->MotherModel->getPosterCounsellingLogs($babyIds);
      $data['motherId'] = $motherId;
      //print_r($GetAllCounsellingList);exit;
      
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/mother/view-mother');
      $this->load->view('admin/include/footer-new');
      $this->load->view('admin/include/datatable-new');
 }

 public function posterLogDetails(){
    $motherId = $this->input->post('motherId');
    $posterId = $this->input->post('posterId');

    $GetAllBabiesList      = $this->MotherModel->getMotherData('babyRegistration',$motherId);
    $babyIds = array_column($GetAllBabiesList, 'babyId');

    $GetAllCounsellingPosterList      = $this->MotherModel->getPosterCounsellingPosterLogs($babyIds,$posterId);

    $html = "";

    $html .='<table class="table table-striped dataex-html5-selectors-log">';

          $html .='<thead>
              <tr>
                <th style="width:70px;">S&nbsp;No.</th>
                <th>Date & Time</th>
                <th>Seen&nbsp;Time</th>
              </tr>
          </thead>
          <tbody>';

 
                $counter=1;
                foreach($GetAllCounsellingPosterList as $key => $counsellingValue) { 
                $totalSeenTime = $counsellingValue['duration'];

                $hours = floor($totalSeenTime / 3600);
                $mins = floor($totalSeenTime / 60 % 60);
                $secs = floor($totalSeenTime % 60);
                $timeFormat = $hours."h"." ".$mins."m"." ".$secs."s";
              
              $html .='<tr>';
                $html .='<td>'.$counter.'</td>';
                $html .='<td>'.date("d-m-Y g:i A", strtotime($counsellingValue['addDate'])).'</td>';         
                $html .='<td>'.$timeFormat.'</td>';
              $html .='</tr>';

              $counter++;
              }
                  
          $html .='</tbody>';

    $html .='</table>';

    echo json_encode($html);

 }

 /* Mother Assesment Data Listing Page call*/   
public function motherAssessment(){
   $loungeId     = $this->uri->segment(3);  
   $limit        = 100;
   $pageNo       = '1';
    if (empty($_GET['keyword'])) {
      $totalRecords = $this->FacilityModel->countAllMonitorings($loungeId);
    } else if(!empty($_GET['keyword'])) {
      $totalRecords = $this->FacilityModel->motherMonitoringCountWithSearching($loungeId,$_GET['keyword']);
    }
    // set url for seaching and without searching
        if (!empty($_GET['keyword'])) {
            $config["base_url"] = base_url('motherM/motherAssessment/'.$loungeId.'?keyword=' . $_GET['keyword']);
        } else {
            $config["base_url"] = base_url('motherM/motherAssessment/'.$loungeId.'?keyword=');
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
        $str_links = $this->pagination->create_links();
        $links = explode('&nbsp;', $str_links);
        $offset = 0;
        if (!empty($_GET['per_page'])) {
            $pageNo = $_GET['per_page'];
            $offset = ($pageNo - 1) * $limit;
        }
        
 
        if (empty($_GET['keyword'])) {
          $AllRecord = $this->FacilityModel->getAllAssessments($loungeId,$limit,$offset);
        }else if(!empty($_GET['keyword']))
        {
           $AllRecord = $this->FacilityModel->getAllAssessmentWhereSearching($_GET['keyword'],$loungeId,$limit,$offset);
        }
         $data = array(
                  'totalResult' => $totalRecords,
                  'results'     => $AllRecord,
                  'links'       => $links,
                  'index2'      => 'motherMonitoring',
                  'v_id'        => '',
                  'pageNo'      => $pageNo,
                  'index'       => 'MotherAssessment',
                  'title'       => 'Mother Assessment | '.PROJECT_NAME
                 );
      $this->load->view('admin/include/header',$data);
      $this->load->view('admin/include/tableScript');      
      $this->load->view('admin/mother/MotherAssement');      
      $this->load->view('admin/include/footer');
   }
    /* All Baby Of Single Mother*/
    public function singleMotherBabies(){   
        $id = $this->uri->segment(3);
        $data['index']         = 'Mother';      
        $data['index2']        = '';      
        $data['title']         = 'Manage Mothers | '.PROJECT_NAME;      
        $data['GetBaby']       = $this->MotherModel->getBabyOfMotherId('babyRegistration',$id); 
        $this->load->view('admin/include/header',$data);      
        $this->load->view('admin/mother/singleMotherBabies');      
        $this->load->view('admin/include/footer');    
    }

    public function mothersViaLounge(){      
        $data['index']         = 'Mother';      
        $data['index2']        = 'reg_mother';      
        $data['title']         = 'Manage Mothers | '.PROJECT_NAME;      
        $data['totalLounges']  = $this->DashboardDataModel->getAllLonges();
        $this->load->view('admin/include/headerChartJS',$data);      
        $this->load->view('admin/mother/MothersViaLounge');      
        $this->load->view('admin/include/footer');    
    }

    public function mothersAssessmentViaLounge(){      
        $data['index']         = 'Mother';      
        $data['index2']        = 'motherMonitoring';      
        $data['title']         = 'Mother Assessment | '.PROJECT_NAME;      
        $data['totalLounges']  = $this->DashboardDataModel->getAllLonges();
        $this->load->view('admin/include/headerChartJS',$data);      
        $this->load->view('admin/mother/mothersAssessmentViaLounge');      
        $this->load->view('admin/include/footer');    
    }   


   public function manageDraft(){      
        $data['index']         = 'draft';      
        $data['index2']        = '';      
        $data['title']         = 'Manage Draft | '.PROJECT_NAME;      
        $data['list']  = $this->db->query("select * from motherRegistration as mr inner join motherAdmission as ma on ma.`motherId`= mr.`motherId` inner join loungeMaster as lm on lm.`loungeId`=ma.`loungeId` order by lm.`loungeId` asc")->result_array();
        $this->load->view('admin/include/headerChartJS',$data);      
        $this->load->view('admin/mother/motherDraft');      
        $this->load->view('admin/include/footer');    
    } 


    public function currentMotherGridView(){
      $loungeId     = $this->uri->segment(3);
      $data['loungeId']   = $loungeId;
      $noOfBeds   = $this->MotherModel->getBedOfLounge($loungeId); 
      $AllRecord = $this->MotherModel->getAllAdmittedMother($loungeId); 
      $data = array(
                'loungeId'    => $loungeId,
                'index'       => 'Mother',
                'index2'      => 'reg_mother',
                'noOfBeds'    => $noOfBeds,
                'results'     => $AllRecord,
                'title'       => 'Manage Mothers | '.PROJECT_NAME
               );
      $this->load->view('admin/include/header',$data);
      $this->load->view('admin/mother/MotherListGridView',$data);      
      $this->load->view('admin/include/footer');
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

    