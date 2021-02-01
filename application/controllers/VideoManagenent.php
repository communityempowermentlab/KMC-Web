<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Welcome.php');
class VideoManagenent extends Welcome {
  public function __construct() {
      parent::__construct();
      $this->load->model('VideoModel');  
      $this->load->model('FacilityModel');  
    }
    /* Call Video Listing Page*/
 public function manageVideo(){
      $data['index']         = 'manageVideo';
      $data['index2']        = '';
      $data['title']         = 'Videos | '.PROJECT_NAME; 
      $data['fileName']      = 'VideoList'; 
      $data['GetVideo']      = $this->VideoModel->GetVideo();
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/video/video-list');
      $this->load->view('admin/include/footer-new');
      $this->load->view('admin/include/datatable-new');
    }
    /* Call Video Type Listing Page*/
    public function videoType(){
      $data['index']         = 'videoType';
      $data['index2']        = 'Video Type';
      $data['title']         = 'Video Type | '.PROJECT_NAME; 
      $data['fileName']      = 'VideoTypeList';
      $data['videoType']     = $this->VideoModel->GetVideoList();
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/video/video-type-list');
      $this->load->view('admin/include/footer-new');
      $this->load->view('admin/include/datatable-new');
    }   

    public function videoTypeLog(){
      $id = $this->uri->segment(3);
      $data['index']         = 'videoType';
      $data['index2']        = 'Video Type Log';
      $data['title']         = 'Video Type Log | '.PROJECT_NAME; 
      $data['fileName']      = 'VideoTypeList';
      $data['videoType']     = $this->VideoModel->GetVideoLog($id);
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/video/video-type-log');
      $this->load->view('admin/include/footer-new');
      $this->load->view('admin/include/datatable-new');
    }

  /* Add Video Page Call*/
    public function addVideo(){
      $data['index']         = 'manageVideo';
      $data['index2']        = '';
      $data['title']         = 'Add Video | '.PROJECT_NAME; 
      $data['videoType'] = $this->FacilityModel->GetVideoType();
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/video/video-add');
      $this->load->view('admin/include/footer-new');
    }
     /* Update Video Page Call*/
    public function editVideo(){
      $id = $this->uri->segment(3);
      $data['index']         = 'manageVideo';
      $data['index2']        = '';
      $data['title']         = 'Edit Video | '.PROJECT_NAME; 
      $data['VideoData']     = $this->db->query(" select * from counsellingMaster where ID='$id'")->row_array();
      $data['videoType'] = $this->FacilityModel->GetVideoType();
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/video/video-edit');
      $this->load->view('admin/include/footer-new');
    } 
    /* Add Video Data By this*/
    public function AddVideoData(){
       $table='counsellingMaster';
       $data = $this->input->post(); 
       $fileName   = $_FILES['image']['name'];
       $extension  = explode('.',$fileName);
       $extension  = strtolower(end($extension));
       $videoName = time();
       $uniqueName = time().'.'.$extension;
       $tmp_name   = $_FILES['image']['tmp_name'];
       $targetlocation= $_SERVER['DOCUMENT_ROOT']."/".folderName."/assets/images/video/".$uniqueName; 
       $InsertImg = utf8_encode(trim($uniqueName));
       move_uploaded_file($tmp_name,$targetlocation);
       $fields                      = array();
       $fields['videoName']         = $InsertImg;
       $fields['videoType']         = $data['VideoType'];
       $fields['videoTitle']        = $data['VideoTitle'];  

      
             
       $fields['status']                  = 1;      
       $fields['addDate']                 = date('Y-m-d H:i:s');
       $fields['modifyDate']              = date('Y-m-d H:i:s');
       $result = $this->VideoModel->AddData($table,$fields);

      if ($result >0) {
         $this->session->set_flashdata('activate', getCustomAlert('S','Video Uploaded successfully.'));      
         redirect('videoM/manageVideo');
      }
    }

    /* Update Video Data By this*/
  public function UpdateVideoData(){
       $id = $this->uri->segment(3);
       $table='counsellingMaster';
       $data = $this->input->post();
       $fileName   = $_FILES['image']['name'];
       if (!empty($fileName)) {   
         $extension  = explode('.',$fileName);
         $extension  = strtolower(end($extension));
         $uniqueName = time().'.'.$extension;
         $time = time();
         $tmp_name   = $_FILES['image']['tmp_name'];
         $targetlocation= $_SERVER['DOCUMENT_ROOT']."/".folderName."/assets/images/video/".$uniqueName; 
         $InsertImg = utf8_encode(trim($uniqueName));
          move_uploaded_file($tmp_name,$targetlocation);

          unlink($_SERVER['DOCUMENT_ROOT']."/".folderName."/assets/images/video/".$data['imageOld']);
         
          $videoName = $InsertImg;


       } else {

            $videoName = $data['imageOld'];
          
       }
       

       $fields                     = array();
       $fields['videoName']        = $videoName;
       $fields['videoType']        = $data['VideoType'];
       $fields['videoTitle']       = $data['VideoTitle']; 
       $fields['modifyDate']       = date('Y-m-d H:i:s');       
       $fields['status']           = $data['status']; 

       $result = $this->db->where('id',$id);
                 $this->db->update('counsellingMaster',$fields);   
       if ($result >0) {
           $this->session->set_flashdata('activate', getCustomAlert('S','Video Uploaded successfully.'));      
           redirect('videoM/manageVideo');
      }
    }

  /* Add  Video type Data*/
public function VideoTypeData(){
        $data                              = $this->input->post();
        $fields                            = array();
        $fields['VideoTypeName']           = $data['video_name'];
        $fields['Add_Date']                = date('Y-m-d H:i:s');
        $insert = $this->db->insert('videoType',$fields);
        if ($insert > 0) {
              $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Added successfully'));
              redirect('videoM/videoType');
          } else {
              $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
              redirect('videoM/videoType');
          }
    }

/* Update Video type Data*/
  public function UpdateVideoTypeData(){
        $id = $this->uri->segment(3);
        $table ='videoType';
        $data                              = $this->input->post();
        $fields                            = array();
        $fields['videoTypeName']           = $data['video_name'];
        $fields['modifyDate']             = date('Y-m-d H:i:s');
                     $this->db->where('id',$id);
           $update = $this->db->update($table,$fields);
        if ($update > 0) {
               $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Updated successfully'));
               redirect('videoM/videoType/');
          } else {
               $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
               redirect('videoM/videoType/');
          }
    }   


  public function addVideoType(){
      $data['index']         = 'videoType';
      $data['index2']        = 'Manage Video Type';
      $data['title']         = 'Manage Video Type | '.PROJECT_NAME; 
      $data['fileName']      = 'VideoTypeList';

      if($this->input->post()){
        $data                              = $this->input->post();
        $fields                            = array();
        $fields['videoTypeName']           = $data['video_type'];
        $fields['addDate']                 = date('Y-m-d H:i:s');
        $fields['modifyDate']              = date('Y-m-d H:i:s');
        $insert = $this->db->insert('videoType',$fields);
        $videoTypeId = $this->db->insert_id();

        $loginId = $this->session->userdata('adminData')['Id'];
        $ip = $this->input->ip_address();

        $logArray                           = array();
        $logArray['videoTypeId']            = $videoTypeId;
        $logArray['videoTypeName']          = $data['video_type'];
        $logArray['status']                 = 1;
        $logArray['addDate']                = date('Y-m-d H:i:s');
        $logArray['addedBy']                = $loginId;
        $logArray['ipAddress']              = $ip;
        $insert = $this->db->insert('videoTypeLog',$logArray);

        if ($insert > 0) {
              $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Added successfully'));
              redirect('videoM/videoType');
          } else {
              $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
              redirect('videoM/videoType');
          }

      }
      
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/video/video-type-add');
      $this->load->view('admin/include/footer-new');

  }


  public function editVideoType(){
      $id = $this->uri->segment(3);
      $data['index']         = 'videoType';
      $data['index2']        = 'Manage Video Type';
      $data['title']         = 'Manage Video Type | '.PROJECT_NAME; 
      $data['fileName']      = 'VideoTypeList';
      $data['video_data']     = $this->db->query(" select * from videoType where ID='$id'")->row_array();

      if($this->input->post()){
        
        $data                               = $this->input->post();
        $fields                             = array();
        $fields['videoTypeName']            = $data['video_type'];
        $fields['status']                   = $data['status'];
        $fields['modifyDate']               = date('Y-m-d H:i:s');
        $this->db->where('id',$data['video_id']);
        $update = $this->db->update('videoType',$fields); 

        $loginId = $this->session->userdata('adminData')['Id'];
        $ip = $this->input->ip_address();

        $logArray                           = array();
        $logArray['videoTypeId']            = $data['video_id'];
        $logArray['videoTypeName']          = $data['video_type'];
        $logArray['status']                 = $data['status'];
        $logArray['addDate']                = date('Y-m-d H:i:s');
        $logArray['addedBy']                = $loginId;
        $logArray['ipAddress']              = $ip;
        $insert = $this->db->insert('videoTypeLog',$logArray);

        if ($update > 0) {
              $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Updated successfully'));
              redirect('videoM/videoType');
          } else {
              $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
              redirect('videoM/videoType');
          }

      }

      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/video/video-type-edit');
      $this->load->view('admin/include/footer-new');
  }


}
 