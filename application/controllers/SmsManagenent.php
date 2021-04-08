<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Welcome.php');
class SmsManagenent extends Welcome {
  public function __construct() {
    parent::__construct();
    $this->load->model('SmsModel');  
    $this->load->model('FacilityModel'); 
    $this->load->model('FeedModel'); 
    $this->load->model('DashboardDataModel'); 
    $this->load->model('BabyModel');
    $this->load->library('pagination'); 
  }

  public function loungeWiseSMS(){
    $data['index']         = 'SentSms';
    $data['index2']        = '';
    $data['title']         = 'Sent SMS | '.PROJECT_NAME; 
    $data['totalLounges']  = $this->DashboardDataModel->getAllLonges();
    $time = time();
    $this->db->query("update adminMaster set SmsTime='$time' where id='1'");
    $this->load->view('admin/include/headerChartJS',$data);
    $this->load->view('admin/sms/smsViaLounge');
    $this->load->view('admin/include/footer');
  }   
// sms listing function here   
 public function sentSms(){
  $loungeId      = $this->uri->segment(3);  
  $limit         = 100;
  $pageNo        = '1';
    if(empty($_GET['keyword'])) {
      $totalRecords = $this->SmsModel->getSmsData('1',$loungeId); 
    } else if(!empty($_GET['keyword'])) {
      $totalRecords = $this->SmsModel->getSmsDataWhereSearching('1',$loungeId,trim($_GET['keyword']));
    }
    // set url for seaching and without searching
    !empty($_GET['keyword']) ? $config["base_url"] = base_url('smsM/sentSms/'.$loungeId.'?keyword='.$_GET['keyword']) : $config["base_url"] = base_url('smsM/sentSms/'.$loungeId);
      $config["total_rows"]   = $totalRecords;
      $config["per_page"]     = $limit;
      $config['use_page_numbers']  = TRUE;
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
        if(empty($_GET['keyword'])) {
          $AllRecord = $this->SmsModel->getSmsData('2',$loungeId,$limit,$offset); 
        }else if(!empty($_GET['keyword']))
        {
           $AllRecord = $this->SmsModel->getSmsDataWhereSearching('2',$loungeId,trim($_GET['keyword']),$limit,$offset);
        } 
       $data = array(
                'totalResult' => $totalRecords,
                'results'     => $AllRecord,
                'links'       => $links,
                'index2'      => '',
                'v_id'        => '',
                'pageNo'      => $pageNo,
                'index'       => 'SentSms',
                'title'       => 'Sent SMS | '.PROJECT_NAME
               );
       $data['fileName'] = '';
      $this->load->view('admin/include/header',$data);
      $this->load->view('admin/sms/SmsList');
       $this->load->view('admin/include/dataTable');
      $this->load->view('admin/include/tableScript');  
      $this->load->view('admin/include/footer');
}   


  public function loungeWiseNotification(){
    $data['index']         = 'NotificationCenter';
    $data['index2']        = '';
    $data['title']         = 'NotificationCenter | '.PROJECT_NAME; 
    $data['totalLounges']  = $this->DashboardDataModel->getAllLonges();
    $time = time();
    $this->db->query("update adminMaster set NotificationTime=".$time." where id='1'");
    $this->load->view('admin/include/headerChartJS',$data);
    $this->load->view('admin/sms/notificationViaLounge');
    $this->load->view('admin/include/footer');
  }  

//notification listing function here   
 public function notificationCenter(){
  $loungeId      = $this->uri->segment(3);  
  $limit         = 100;
  $pageNo        = '1';
    if(empty($_GET['keyword'])) {
      $totalRecords = $this->SmsModel->getNotificationData('1',$loungeId); 
    } else if(!empty($_GET['keyword'])) {
      $totalRecords = $this->SmsModel->getNotificationDataWhereSearching('1',$loungeId,trim($_GET['keyword']));
    }
    // set url for seaching and without searching
    !empty($_GET['keyword']) ? $config["base_url"] = base_url('smsM/notificationCenter/'.$loungeId.'?keyword='.$_GET['keyword']) : $config["base_url"] = base_url('smsM/notificationCenter/'.$loungeId);
      $config["total_rows"]   = $totalRecords;
      $config["per_page"]     = $limit;
      $config['use_page_numbers']  = TRUE;
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
        if(empty($_GET['keyword'])) {
          $AllRecord = $this->SmsModel->getNotificationData('2',$loungeId,$limit,$offset); 
        }else if(!empty($_GET['keyword']))
        {
           $AllRecord = $this->SmsModel->getNotificationDataWhereSearching('2',$loungeId,trim($_GET['keyword']),$limit,$offset);
        } 
       $data = array(
                'totalResult' => $totalRecords,
                'results'     => $AllRecord,
                'links'       => $links,
                'index2'      => '',
                'v_id'        => '',
                'pageNo'      => $pageNo,
                'index'       => 'NotificationCenter',
                'title'       => 'Lounge Via Notification | '.PROJECT_NAME
               );
      $this->load->view('admin/include/header',$data);
      $this->load->view('admin/sms/NotificationList');
      $this->load->view('admin/include/tableScript');  
      $this->load->view('admin/include/footer');
}   



  public function timeLine(){
    $data['index']         = 'timeline';
    $data['index2']        = '';
    $data['title']         = 'TimeLines | '.PROJECT_NAME; 
    $data['fileName']      = 'TimeLineList'; 
    $this->db->order_by('id','desc');
    $data['timelineData']  = $this->db->get_where('timeline',array('status'=>1))->result_array();
    $this->load->view('admin/include/header',$data);
    $this->load->view('admin/timeline');
    $this->load->view('admin/include/dataTable');
    $this->load->view('admin/include/footer');
  } 

  public function commentList(){
    $timelineId = $this->uri->segment(3);
    $data['index']         = 'timeline';
    $data['index2']        = '';
    $data['title']         = 'Comments | '.PROJECT_NAME; 
    $data['fileName']      = 'commentList'; 
    $data['commentData']  = $this->db->get_where('timelineComment',array('timelineId'=>$timelineId))->result_array();
    $this->load->view('admin/include/header',$data);
    $this->load->view('admin/commentList');
    $this->load->view('admin/include/dataTable');
    $this->load->view('admin/include/footer');
  } 

  public function likeList(){
    $timelineId = $this->uri->segment(3);
    $data['index']         = 'timeline';
    $data['index2']        = '';
    $data['title']         = 'Likes | '.PROJECT_NAME; 
    $data['fileName']      = 'LikeList'; 
    $data['likeData']  = $this->db->get_where('likeDislikeMaster',array('timelineId'=>$timelineId))->result_array();
    $this->load->view('admin/include/header',$data);
    $this->load->view('admin/likeList');
    $this->load->view('admin/include/dataTable');
    $this->load->view('admin/include/footer');
  }

  public function smsPanel(){
    $data['index']         = 'timeline';
    $data['index2']        = '';
    $data['title']         = 'Comments | '.PROJECT_NAME; 
    $data['fileName']      = 'commentList'; 

    $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/sms/smsPanel');
      $this->load->view('admin/include/footer-new');
    
    // $this->load->view('admin/include/header',$data);
    // $this->load->view('admin/commentList');
    // $this->load->view('admin/include/smsPanel');
    // $this->load->view('admin/include/footer');
  } 

}

 