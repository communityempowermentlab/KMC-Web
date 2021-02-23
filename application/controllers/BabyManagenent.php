<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Welcome.php');
class BabyManagenent extends Welcome {
  public function __construct() {
      parent::__construct();
      $this->load->model('UserModel');
      $this->load->model('BabyModel');  
      $this->load->model('FacilityModel');  
      $this->load->model('MotherModel'); 
      $this->load->model('LoungeModel'); 
      $this->load->model('DashboardDataModel'); 
      $this->load->model('DangerSignModel'); 
      $this->load->model('api/BabyAdmissionPDF'); 
      $this->load->model('api/BabyWeightPDF');
      $this->load->model('api/BabyKmcPDF'); 
      $this->load->model('api/BabyFeedingPDF');
      $this->load->model('api/BabyDischargePdf');  
      $this->load->library('pagination');
      $this->is_not_logged_in(); 
      $this->restrictPageAccess(array('24'));

    }
    /*Registred Baby Listing */

      public function registeredBaby(){ 
        $type          = $this->uri->segment(3);  //type 1=>All Babies, 2=>Admitted, 3=>discharged
        $loungeId      = $this->uri->segment(4); 
        $motherRegID   = $this->uri->segment(5); 
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
            $district     = $this->input->get('district');
            $facilityname = $this->input->get('facilityname'); 
            $loungeid     = $this->input->get('loungeid');
            $nurseid      = $this->input->get('nurseid'); 
            $babyStatus   = $this->input->get('babyStatus');
            $keyword      = $this->input->get('keyword'); 

           
            $totalRecords = $this->BabyModel->countBabyWhereSearching($loungeid,$keyword,$babyStatus,$fromDate,$toDate,$facilityname,$nurseid,$district);
            
            $config["base_url"] = base_url('babyM/registeredBaby/'.$this->uri->segment(3).'/all?fromDate='.$this->input->get('fromDate').'&toDate='.$this->input->get('toDate').'&district='.$district.'&keyword='.$keyword.'&facilityname='.$facilityname.'&loungeid='.$loungeid.'&nurseid='.$nurseid.'&babyStatus='.$babyStatus);
            
          } else { 
            $fromDate = date('Y-m-d H:i:s', strtotime('1970-01-01 00:00:00')); 
            $toDate   = date('Y-m-d H:i:s', strtotime(date('Y-m-d').' 23:59:59')); 
              if($type == 'particularMother'){ 
                $totalRecords = $this->MotherModel->GetAllBabiesViaMother('babyRegistration',$motherRegID);
              } else if($type == '1') { 
                $totalRecords = $this->BabyModel->countAllBabies($loungeId,'current');
              } else if($type == '2') { 
                $totalRecords = $this->BabyModel->countBabiesWhereStatus($loungeId,1,1,$fromDate,$toDate);
              } else if($type == '3') { 
                $totalRecords = $this->BabyModel->countBabiesWhereStatus($loungeId,2,1,$fromDate,$toDate);
              } else if($type == '4') { 
                $totalRecords = $this->BabyModel->countAllBabies($loungeId,'all');
              }
              $config["base_url"] = base_url('babyM/registeredBaby/'.$type.'/'.$loungeId);
          }


          $config["total_rows"]           = $totalRecords;
          $config["per_page"]             = $limit;
          $config['use_page_numbers']     = TRUE;
          $config['page_query_string']    = TRUE;
          $config['enable_query_strings'] = TRUE;
          $config['num_links']            = 2;
          $config['cur_tag_open']         = '&nbsp;<li class="active"><a>';
          $config['cur_tag_close']        = '</a></li>';
          $config['next_link']            = 'Next';
          $config['prev_link']            = 'Previous';
          $this->pagination->initialize($config);
          $str_links           = $this->pagination->create_links();
          $links               = explode('&nbsp;', $str_links);
          $offset              = 0;
          if (!empty($_GET['per_page'])) {
              $pageNo = $_GET['per_page'];
              $offset = ($pageNo - 1) * $limit;
          }

          if($this->input->get()) { 
            $AllRecord = $this->BabyModel->getBabyWhereSearching($loungeid,$keyword,$babyStatus,$fromDate,$toDate,$facilityname,$nurseid,$district,$limit,$offset); 
          } else {
            if($type == 'particularMother'){ 
              $AllRecord = $this->MotherModel->GetBabiesViaMotherID($motherRegID);
            } else if($type == '1') { 
              $AllRecord = $this->BabyModel->getAllBabies($loungeId,$limit,$offset);
            } else if($type == '2') { 
              $AllRecord = $this->BabyModel->getAllBabies($loungeId,$limit,$offset,1);
            } else if($type == '3') { 
              $AllRecord = $this->BabyModel->getAllBabies($loungeId,$limit,$offset,2);
            } else if($type == '4') { 
              $AllRecord = $this->BabyModel->getAllBabies($loungeId,$limit,$offset,'','all'); 
            }
          } 


          $GetDistrict = $this->FacilityModel->selectquery(); 

          $data = array(
                'totalResult' => $totalRecords,
                'results'     => $AllRecord,
                'links'       => $links,
                'index2'      => '',
                'pageNo'      => $pageNo,
                'GetDistrict' => $GetDistrict,
                'index'       => 'Baby',
                'title'       => 'Infants | '.PROJECT_NAME
                ); 

        $this->load->view('admin/include/header-new',$data);      
        $this->load->view('admin/baby/baby-list');      
        $this->load->view('admin/include/footer-new');  
        $this->load->view('admin/include/datatable-new');  
      }


      public function registeredBabyBKUP(){ 
        $type          = $this->uri->segment(3);  //type 1=>All Babies, 2=>Admitted, 3=>discharged
        $loungeId      = $this->uri->segment(4); 
        $motherRegID   = $this->uri->segment(5); 
        $limit         = 100;
        $pageNo        = '1';
       

        if(!empty($_GET['keyword']))
        {
         $keyword = trim($_GET['keyword']);
        }

        if($type == '1'){
          if (empty($_GET['keyword'])) {
            $totalRecords = $this->BabyModel->countAllBabies($loungeId);
          } else if(!empty($keyword)) {
            $totalRecords = $this->BabyModel->countBabyWhereSearching($loungeId,$keyword);
          }
        }else if($type == '2'){
          if (empty($_GET['keyword'])) {
            $totalRecords = $this->BabyModel->countBabiesWhereStatus($loungeId,1,1);
          } else if(!empty($keyword)) {
            $totalRecords = $this->BabyModel->countBabyWhereSearching($loungeId,$keyword,1);
          }
        }else if($type == '3'){
          if (empty($_GET['keyword'])) {
            $totalRecords = $this->BabyModel->countBabiesWhereStatus($loungeId,2,1);
          } else if(!empty($keyword)) {
            $totalRecords = $this->BabyModel->countBabyWhereSearching($loungeId,$keyword,2);
          }
        }else if($type == 'particularMother'){ 

          if (empty($_GET['keyword'])) {
            $totalRecords = $this->MotherModel->GetAllBabiesViaMother('babyRegistration',$motherRegID);
          } else if(!empty($keyword)) {
            $totalRecords = $this->BabyModel->countBabyWhereSearching($loungeId,$keyword);
          }
        }

      // set url for seaching and without searching
        if (!empty($keyword)) {
            $config["base_url"] = base_url('babyM/registeredBaby/'.$type.'/'.$loungeId.'?keyword=' . $keyword);
        } else {
            $config["base_url"] = base_url('babyM/registeredBaby/'.$type.'/'.$loungeId.'?keyword=');
        }


        $config["total_rows"]           = $totalRecords;
        $config["per_page"]             = $limit;
        $config['use_page_numbers']     = TRUE;
        $config['page_query_string']    = TRUE;
        $config['enable_query_strings'] = TRUE;
        $config['num_links']            = 2;
        $config['cur_tag_open']         = '&nbsp;<li class="active"><a>';
        $config['cur_tag_close']        = '</a></li>';
        $config['next_link']            = 'Next';
        $config['prev_link']            = 'Previous';
        $this->pagination->initialize($config);
        $str_links           = $this->pagination->create_links();
        $links               = explode('&nbsp;', $str_links);
        $offset              = 0;
        if (!empty($_GET['per_page'])) {
            $pageNo = $_GET['per_page'];
            $offset = ($pageNo - 1) * $limit;
        }

        if($type == 1){
          if (empty($_GET['keyword'])) {
            $AllRecord = $this->BabyModel->getAllBabies($loungeId,$limit,$offset);
          }else if(!empty($keyword))
          {
            $AllRecord = $this->BabyModel->getBabyWhereSearching($keyword,$loungeId,$limit,$offset);
          }
        }else if($type == 2){
          if (empty($_GET['keyword'])) {
            $AllRecord = $this->BabyModel->getAllBabies($loungeId,$limit,$offset,1);
          }else if(!empty($keyword))
          {
            $AllRecord = $this->BabyModel->getBabyWhereSearching($keyword,$loungeId,$limit,$offset,1);
          }
        }else if($type == 3){
          if (empty($_GET['keyword'])) {
            $AllRecord = $this->BabyModel->getAllBabies($loungeId,$limit,$offset,2);
          }else if(!empty($keyword))
          {
            $AllRecord = $this->BabyModel->getBabyWhereSearching($keyword,$loungeId,$limit,$offset,2);
          }
        }else{
          if (empty($_GET['keyword'])) {
            // here type variable store motherRegID
            $AllRecord = $this->MotherModel->GetBabiesViaMotherID($motherRegID,$loungeId);
          }else if(!empty($keyword))
          {
            $AllRecord = $this->BabyModel->getBabyWhereSearching($keyword,$loungeId,$limit,$offset,2);
          }
        }

        $data = array(
                'totalResult' => $totalRecords,
                'results'     => $AllRecord,
                'links'       => $links,
                'index2'      => '',
                'pageNo'      => $pageNo,
                'index'       => 'Baby',
                'title'       => 'Manage Baby | '.PROJECT_NAME
                ); 

        $this->load->view('admin/include/header',$data);     
        $this->load->view('admin/include/tableScript');      
        $this->load->view('admin/baby/BabyList');      
        $this->load->view('admin/include/footer');  
      }

    /*Registred Single Baby  Data */
    public function viewBaby(){
      $id = $this->uri->segment(3);
      $data['index']         = 'Baby';
      $data['index2']        = '';
      $data['title']         = 'Manage Infant | '.PROJECT_NAME; 

      $admissionData = $this->db->get_where('babyAdmission',array('id'=>$id))->row_array(); 
      $data['babyAdmissionData'] = $admissionData;
      $data['babyData']      = $this->BabyModel->getBabyDataById('babyRegistration',$admissionData['babyId']); 
      $data['fileName']      = 'List';
      $this->load->view('admin/include/header-new',$data); 
      $this->load->view('admin/baby/view-baby');
      $this->load->view('admin/include/footer-new');
      $this->load->view('admin/include/datatable-new');
    }

  public function babyAssismentPDF() {
      $baby_id      = $this->uri->segment(3);
      $link         = time()."-BabyAssisment.pdf";
      $this->BabyModel->BabypdfGenrate($baby_id,$link);
   }
   /*Call baby Assessment Page */
/*  public function babyAssessment(){
    $loungeid = $this->uri->segment(3);
    $data['index']               = 'BabyAssessment';
    $data['index2']              = '';
    $data['title']               = 'Baby Assessment | '.PROJECT_NAME; 
    $data['getBabyAss']          = $this->FacilityModel->BabyAssessment($loungeid);
    $data['fileName']            = 'Baby_Assessment_List';  
    $this->load->view('admin/include/header',$data);
    $this->load->view('admin/baby/BabyAssement1');
    $this->load->view('admin/include/footer');
    //$this->load->view('admin/include/dataTable'); 
  } */ 

   /*Call baby Assessment Page */
  public function babyAssessment(){
        $loungeId      = $this->uri->segment(3); 
        $limit         = 100;
        $pageNo        = '1';

        if(!empty($_GET['keyword']))
        {
         $keyword = trim($_GET['keyword']);
        }
          if (empty($_GET['keyword'])) {
            $totalRecords = $this->DashboardDataModel->totollyBabyAssessmnts($loungeId);
          } else if(!empty($keyword)) {
            $totalRecords = $this->BabyModel->babyMonitoringCountWithSearching($loungeId,$keyword);
          }

      // set url for seaching and without searching
        if (!empty($keyword)) {
            $config["base_url"] = base_url('babyM/babyAssessment/'.$loungeId.'?keyword=' . $keyword);
        } else {
            $config["base_url"] = base_url('babyM/babyAssessment/'.$loungeId.'?keyword=');
        }


        $config["total_rows"]           = $totalRecords;
        $config["per_page"]             = $limit;
        $config['use_page_numbers']     = TRUE;
        $config['page_query_string']    = TRUE;
        $config['enable_query_strings'] = TRUE;
        $config['num_links']            = 2;
        $config['cur_tag_open']         = '&nbsp;<li class="active"><a>';
        $config['cur_tag_close']        = '</a></li>';
        $config['next_link']            = 'Next';
        $config['prev_link']            = 'Previous';
        $this->pagination->initialize($config);
        $str_links           = $this->pagination->create_links();
        $links               = explode('&nbsp;', $str_links);
        $offset              = 0;
        if (!empty($_GET['per_page'])) {
            $pageNo = $_GET['per_page'];
            $offset = ($pageNo - 1) * $limit;
        }

        if (empty($_GET['keyword'])) {
          $AllRecord = $this->BabyModel->getAllAssessments($loungeId,$limit,$offset);
        }else if(!empty($keyword))
        {
          $AllRecord = $this->BabyModel->getAllAssessmentWhereSearching($keyword,$loungeId,$limit,$offset);
        }


        $data = array(
                'totalResult' => $totalRecords,
                'results'     => $AllRecord,
                'links'       => $links,
                'index2'      => '',
                'pageNo'      => $pageNo,
                'index'       => 'BabyAssessment',
                'title'       => 'Baby Assessment | '.PROJECT_NAME
                ); 

        $this->load->view('admin/include/header',$data);     
        $this->load->view('admin/include/tableScript');      
        $this->load->view('admin/baby/BabyAssement1');      
        $this->load->view('admin/include/footer');  

  } 

  public function babysViaLounge(){ 
      $data['index']         = 'Baby';      
      $data['index2']        = '';      
      $data['title']         = 'Manage Baby | '.PROJECT_NAME;   
      $data['totalLounges']  = $this->DashboardDataModel->getAllLonges();   
      $this->load->view('admin/include/headerChartJS',$data);     
      $this->load->view('admin/baby/BabysViaLounge');      
      $this->load->view('admin/include/footer');    
  }

  public function babysAssessmentViaLounge(){ 
      $data['index']         = 'BabyAssessment';      
      $data['index2']        = '';      
      $data['title']         = 'Baby Assessment | '.PROJECT_NAME;   
      $data['totalLounges']  = $this->DashboardDataModel->getAllLonges();   
      $this->load->view('admin/include/headerChartJS',$data);     
      $this->load->view('admin/baby/babysAssessmentViaLounge');      
      $this->load->view('admin/include/footer');    
  }

  public function BabyAdmissionPDF(){ 
    $babyId      = $this->uri->segment(3); 
    $res = $this->BabyAdmissionPDF->pdfGenerate($babyId);  
    $babyAdmisionLastId = $this->db->get_where('babyAdmission',array('id'=>$babyId))->row_array(); 
    if($res > 0){
      $this->session->set_flashdata('activate', getCustomAlert('S','PDF Generate Successfully'));
      // redirect('babyM/registeredBaby/1/'.$babyAdmisionLastId['loungeId']);
      redirect('babyM/registeredBaby/1/all');
    }

  }

  public function BabyWeightPDF(){
    $babyId      = $this->uri->segment(3); 
    $res = $this->BabyWeightPDF->WeightpdfGenerate($babyId);
    $babyAdmisionLastId = $this->db->get_where('babyAdmission',array('id'=>$babyId))->row_array();
    if($res > 0){
      $this->session->set_flashdata('activate', getCustomAlert('S','Weight PDF Generate Successfully'));
      // redirect('babyM/registeredBaby/1/'.$babyAdmisionLastId['loungeId']);
      redirect('babyM/registeredBaby/1/all');
    }
  }


  public function BabyKmcPDF(){
    $babyId      = $this->uri->segment(3); 
    $res = $this->BabyKmcPDF->KMCpdfGenerate($babyId);
    $babyAdmisionLastId = $this->db->get_where('babyAdmission',array('id'=>$babyId))->row_array();
    if($res > 0){
      $this->session->set_flashdata('activate', getCustomAlert('S','KMC PDF Generate Successfully'));
      // redirect('babyM/registeredBaby/1/'.$babyAdmisionLastId['loungeId']);
      redirect('babyM/registeredBaby/1/all');
    }
  }

  public function BabyFeedingPDF(){
    $babyId      = $this->uri->segment(3); 
    $res = $this->BabyFeedingPDF->FeedingpdfGenerate($babyId);
    $babyAdmisionLastId = $this->db->get_where('babyAdmission',array('id'=>$babyId))->row_array();
    if($res > 0){
      $this->session->set_flashdata('activate', getCustomAlert('S','Feeding PDF Generate Successfully'));
      // redirect('BabyManagenent/registeredBaby/1/'.$babyAdmisionLastId['loungeId']);
      redirect('babyM/registeredBaby/1/all');
    }
  }


  public function BabyDischargePdf(){
    $babyId      = $this->uri->segment(3); 
    $res = $this->BabyDischargePdf->FinalpdfGenerate($babyId);
    $babyAdmisionLastId = $this->db->get_where('babyAdmission',array('id'=>$babyId))->row_array();
    if($res > 0){
      $this->session->set_flashdata('activate', getCustomAlert('S','Discharge PDF Generate Successfully'));
      // redirect('BabyManagenent/registeredBaby/1/'.$babyAdmisionLastId['loungeId']);
      redirect('babyM/registeredBaby/1/all');
    }

  }


  public function generateAllAdmissionPDF($startDate,$endDate,$LoungeID)
  {

    $query = $this->db->query("select ba.*,ba.`status` as StatusDis from babyAdmission as ba inner join babyRegistration as br on ba.`babyId`= br.`babyId` where ba.`loungeId`=".$LoungeID." and  ba.`addDate` between ".$startDate." and ".$endDate."")->result_array();
    foreach ($query as $key => $value) {

     
      $fileName = "b_".$value['id'].".pdf";
      $GetMotherAllData = $this->GetMotherAllData($value['motherId']);
      $GetBabyAllData   = $this->GetBabyAllData($value['babyId']);
      $PdfFile = $this->pdfconventer($GetMotherAllData,$GetBabyAllData,$fileName,$value['id']);

      $this->db->where('id',$value['id']);
      $this->db->update('babyAdmission', array('babyPdfFileName'=>$PdfFile));


      $PdfName = $this->BabyWeightPdfFile($value['loungeId'],$value['babyId'],$value['id']);
      $this->db->where('id',$value['id']);
      $res = $this->db->update('babyAdmission',array('babyWeightPdfName'=>$PdfName));

    }

    $this->session->set_flashdata('activate', getCustomAlert('S','PDF Generate Successfully'));
    redirect('Admin/downloadReports');
  }


}

    