<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Welcome.php');
class CounsellingManagenent extends Welcome {
  public function __construct() {
      parent::__construct();
      $this->load->model('CounsellingModel');  
      $this->load->model('FacilityModel');  
      $this->is_not_logged_in(); 
      $this->restrictPageAccess(array('49','50','51'));
    }
    /* Call Video Listing Page*/
    public function manageCounsellingVideos(){
      $data['index']         = 'manageCounsellingVideos';
      $data['index2']        = '';
      $data['title']         = 'Counselling Videos | '.PROJECT_NAME; 
      $data['fileName']      = 'VideoList'; 
      $data['GetVideo']      = $this->CounsellingModel->GetVideo(1);
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/counselling/counselling-video-list');
      $this->load->view('admin/include/footer-new');
      $this->load->view('admin/include/datatable-new');
    }

    public function ApplicationVideoClickList(){
      $id = $this->uri->segment(3);
      $data['index']         = 'Application Training Videos';
      $data['index2']        = '';
      $data['title']         = 'Counselling Videos | '.PROJECT_NAME; 
      $data['fileName']      = 'VideoList'; 
      $data['GetVideo']      = $this->CounsellingModel->GetVideoWatchlist($id);

      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/counselling/application-video-watch-list');
      $this->load->view('admin/include/footer-new');
      $this->load->view('admin/include/datatable-new');
    } 

    public function counsellingVideoClickList(){
      $id = $this->uri->segment(3);
      $data['index']         = 'Counselling Videos';
      $data['index2']        = '';
      $data['title']         = 'Counselling Videos | '.PROJECT_NAME; 
      $data['fileName']      = 'VideoList'; 
      $data['GetVideo']      = $this->CounsellingModel->GetVideoWatchlist($id);
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/counselling/application-video-watch-list');
      $this->load->view('admin/include/footer-new');
      $this->load->view('admin/include/datatable-new');
    }     

  /* Add Video Page Call*/
    public function addCounsellingVideos(){
      $data['index']         = 'manageCounsellingVideos';
      $data['index2']        = '';
      $data['title']         = 'Add Counselling Videos | '.PROJECT_NAME; 

      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/counselling/counselling-video-add');
      $this->load->view('admin/include/footer-new');
    }
     /* Update Video Page Call*/
    public function editCounsellingVideo(){
      $id = $this->uri->segment(3);
      $data['index']         = 'manageCounsellingVideos';
      $data['index2']        = '';
      $data['title']         = 'Counselling Videos | '.PROJECT_NAME; 
      $data['VideoData']     = $this->db->query(" select * from counsellingMaster where ID='$id'")->row_array();
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/counselling/counselling-video-edit');
      $this->load->view('admin/include/footer-new');
    } 
    /* Add Video Data By this*/
    public function AddCounsellingVideoData(){
       $table='counsellingMaster';
       $data = $this->input->post(); 
       $chk = $this->db->get_where("counsellingMaster",array("videoName" => $data['image'], "videoType"=> 1))->row_array();
       if(!empty($chk))
       {
         //echo "hoooo";
         $this->session->set_flashdata('activate', getCustomAlert('W','Video Name Already Exist.'));      
         redirect('counsellingM/addCounsellingVideos');
         
       }

       // $fileName   = $_FILES['image']['name'];
       // $extension  = explode('.',$fileName);
       // $extension  = strtolower(end($extension));
       // $videoName = time();
       // $uniqueName = time().'.'.$extension;
       // $tmp_name   = $_FILES['image']['tmp_name'];
       // $targetlocation= $_SERVER['DOCUMENT_ROOT']."/".folderName."/assets/images/video/".$uniqueName; 
       // $InsertImg = utf8_encode(trim($uniqueName));
       // move_uploaded_file($tmp_name,$targetlocation);
       $fields                      = array();
       $fields['videoName']         = $data['image'];
       $fields['videoType']         = 1;
       $fields['videoTitle']        = $data['VideoTitle'].'|'.$data['videoTitleHindi'];        
       $fields['status']            = 1;      
       $fields['addDate']           = date('Y-m-d H:i:s');
       $fields['modifyDate']        = date('Y-m-d H:i:s');
       $result = $this->CounsellingModel->AddData($table,$fields);

      if ($result >0) {
         $this->session->set_flashdata('activate', getCustomAlert('S','Video Uploaded successfully.'));      
         redirect('counsellingM/manageCounsellingVideos');
      }
    }

    /* Update Video Data By this*/
  public function UpdateCounsellingVideoData(){
       $id = $this->uri->segment(3);
       $table='counsellingMaster';

       $data = $this->input->post();
       $chk = $this->db->get_where("counsellingMaster",array("videoName" => $data['image'], "videoType"=> 1,'id!=' => $id))->row_array();
       if(!empty($chk))
       {
         //echo "hoooo";
         $this->session->set_flashdata('activate', getCustomAlert('W','Video Name Already Exist.'));      
         redirect('counsellingM/editCounsellingVideo/'.$id);
         
       }
       // $fileName   = $_FILES['image']['name'];
       // if (!empty($fileName)) {   
       //   $extension  = explode('.',$fileName);
       //   $extension  = strtolower(end($extension));
       //   $uniqueName = time().'.'.$extension;
       //   $time = time();
       //   $tmp_name   = $_FILES['image']['tmp_name'];
       //   $targetlocation= $_SERVER['DOCUMENT_ROOT']."/".folderName."/assets/images/video/".$uniqueName; 
       //   $InsertImg = utf8_encode(trim($uniqueName));
       //    move_uploaded_file($tmp_name,$targetlocation);

       //    unlink($_SERVER['DOCUMENT_ROOT']."/".folderName."/assets/images/video/".$data['imageOld']);
         
       //    $videoName = $InsertImg;

       // } else {
       //      $videoName = $data['imageOld'];
       // }
       
       $fields                     = array();
       $fields['videoName']        = $data['image'];
       $fields['videoTitle']        = $data['VideoTitle'].'|'.$data['videoTitleHindi']; 
       $fields['modifyDate']       = date('Y-m-d H:i:s');       
       $fields['status']           = $data['status']; 

       $result = $this->db->where('id',$id);
                 $this->db->update('counsellingMaster',$fields);   
       if ($result >0) {
           $this->session->set_flashdata('activate', getCustomAlert('S','Video Uploaded successfully.'));      
           redirect('counsellingM/manageCounsellingVideos');
      }
    }

    /*******************************************Application Videos Start**********************************/
    /* Call Video Listing Page*/
    public function manageApplicationVideos(){
      $data['index']         = 'manageApplicationVideos';
      $data['index2']        = '';
      $data['title']         = 'Application Training Videos | '.PROJECT_NAME; 
      $data['fileName']      = 'VideoList'; 
      $data['GetVideo']      = $this->CounsellingModel->GetVideo(2);
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/counselling/application-video-list');
      $this->load->view('admin/include/footer-new');
      $this->load->view('admin/include/datatable-new');
    }  

  /* Add Video Page Call*/
    public function addApplicationVideos(){
      $data['index']         = 'manageApplicationVideos';
      $data['index2']        = '';
      $data['title']         = 'Add Application Videos | '.PROJECT_NAME; 

      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/counselling/application-video-add');
      $this->load->view('admin/include/footer-new');
    }
     /* Update Video Page Call*/
    public function editApplicationVideo(){
      $id = $this->uri->segment(3);
      $data['index']         = 'manageApplicationVideos';
      $data['index2']        = '';
      $data['title']         = 'Application Videos | '.PROJECT_NAME; 
      $data['VideoData']     = $this->db->query(" select * from counsellingMaster where ID='$id'")->row_array();
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/counselling/application-video-edit');
      $this->load->view('admin/include/footer-new');
    } 
    /* Add Video Data By this*/
    public function AddApplicationVideoData(){
       $table='counsellingMaster';
       $data = $this->input->post(); 

       $chk = $this->db->get_where("counsellingMaster",array("videoName" => $data['image'], "videoType"=> 2))->row_array();
       if(!empty($chk))
       {
         //echo "hoooo";
         $this->session->set_flashdata('activate', getCustomAlert('W','Video Name Already Exist.'));      
         redirect('counsellingM/addApplicationVideos');
         
       }

       // $fileName   = $_FILES['image']['name'];
       // $extension  = explode('.',$fileName);
       // $extension  = strtolower(end($extension));
       // $videoName = time();
       // $uniqueName = time().'.'.$extension;
       // $tmp_name   = $_FILES['image']['tmp_name'];
       // $targetlocation= $_SERVER['DOCUMENT_ROOT']."/".folderName."/assets/images/video/".$uniqueName; 
       // $InsertImg = utf8_encode(trim($uniqueName));
       // move_uploaded_file($tmp_name,$targetlocation);
       $fields                      = array();
       //$fields['videoName']         = $InsertImg;
       $fields['videoName']         = $data['image'];
       $fields['videoType']         = 2;
       $fields['videoTitle']        = $data['VideoTitle'].'|'.$data['videoTitleHindi'];         
       $fields['status']            = 1;      
       $fields['addDate']           = date('Y-m-d H:i:s');
       $fields['modifyDate']        = date('Y-m-d H:i:s');
       $result = $this->CounsellingModel->AddData($table,$fields);

      if ($result >0) {
         $this->session->set_flashdata('activate', getCustomAlert('S','Video Uploaded successfully.'));      
         redirect('counsellingM/manageApplicationVideos');
      }
    }

    /* Update Video Data By this*/
  public function UpdateApplicationVideoData(){
       $id = $this->uri->segment(3);
       $table='counsellingMaster';
       $data = $this->input->post();

       $chk = $this->db->get_where("counsellingMaster",array("videoName" => $data['image'], "videoType"=> 2,'id!=' => $id))->row_array();
       if(!empty($chk))
       {
         //echo "hoooo";
         $this->session->set_flashdata('activate', getCustomAlert('W','Video Name Already Exist.'));      
         redirect('counsellingM/editApplicationVideo/'.$id);
         
       }
       // $fileName   = $_FILES['image']['name'];
       // if (!empty($fileName)) {   
       //   $extension  = explode('.',$fileName);
       //   $extension  = strtolower(end($extension));
       //   $uniqueName = time().'.'.$extension;
       //   $time = time();
       //   $tmp_name   = $_FILES['image']['tmp_name'];
       //   $targetlocation= $_SERVER['DOCUMENT_ROOT']."/".folderName."/assets/images/video/".$uniqueName; 
       //   $InsertImg = utf8_encode(trim($uniqueName));
       //    move_uploaded_file($tmp_name,$targetlocation);

       //    unlink($_SERVER['DOCUMENT_ROOT']."/".folderName."/assets/images/video/".$data['imageOld']);
         
       //    $videoName = $InsertImg;

       // } else {
       //      $videoName = $data['imageOld'];
       // }
       
       $fields                     = array();
       // $fields['videoName']        = $videoName;
       $fields['videoName']         = $data['image'];
       $fields['videoTitle']        = $data['VideoTitle'].'|'.$data['videoTitleHindi']; 
       $fields['modifyDate']       = date('Y-m-d H:i:s');       
       $fields['status']           = $data['status']; 

       $result = $this->db->where('id',$id);
                 $this->db->update('counsellingMaster',$fields);   
       if ($result >0) {
           $this->session->set_flashdata('activate', getCustomAlert('S','Video Uploaded successfully.'));      
           redirect('counsellingM/manageApplicationVideos');
      }
    }

    /*******************************************Counselling Poster Start**********************************/
    /* Call Video Listing Page*/
    public function manageCounsellingPoster(){
      $data['index']         = 'manageCounsellingPoster';
      $data['index2']        = '';
      $data['title']         = 'Counselling Poster | '.PROJECT_NAME; 
      $data['fileName']      = 'VideoList'; 
      $data['GetVideo']      = $this->CounsellingModel->GetVideo(3);
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/counselling/counselling-poster-list');
      $this->load->view('admin/include/footer-new');
      $this->load->view('admin/include/datatable-new');
    }  

  /* Add Video Page Call*/
    public function addCounsellingPoster(){
      $data['index']         = 'manageCounsellingPoster';
      $data['index2']        = '';
      $data['title']         = 'Add Counselling Poster | '.PROJECT_NAME; 

      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/counselling/counselling-poster-add');
      $this->load->view('admin/include/footer-new');
    }
     /* Update Video Page Call*/
    public function editCounsellingPoster(){
      $id = $this->uri->segment(3);
      $data['index']         = 'manageCounsellingPoster';
      $data['index2']        = '';
      $data['title']         = 'Counselling Poster | '.PROJECT_NAME; 
      $data['VideoData']     = $this->db->query(" select * from counsellingMaster where ID='$id'")->row_array();
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/counselling/counselling-poster-edit');
      $this->load->view('admin/include/footer-new');
    } 
    /* Add Video Data By this*/
    public function AddCounsellingPosterData(){
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
       $fields['videoType']         = 3;
       $fields['videoTitle']        = $data['VideoTitle'];
       $fields['posterType']        = $data['posterType'];        
       $fields['status']            = 1;      
       $fields['addDate']           = date('Y-m-d H:i:s');
       $fields['modifyDate']        = date('Y-m-d H:i:s');
       $result = $this->CounsellingModel->AddData($table,$fields);

      if ($result >0) {
         $this->session->set_flashdata('activate', getCustomAlert('S','Poster Uploaded successfully.'));      
         redirect('counsellingM/manageCounsellingPoster');
      }
    }

    /* Update Video Data By this*/
  public function UpdateCounsellingPosterData(){
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
       $fields['posterType']       = $data['posterType'];        
       $fields['videoTitle']       = $data['VideoTitle']; 
       $fields['modifyDate']       = date('Y-m-d H:i:s');       
       $fields['status']           = $data['status']; 

       $result = $this->db->where('id',$id);
                 $this->db->update('counsellingMaster',$fields);   
       if ($result >0) {
           $this->session->set_flashdata('activate', getCustomAlert('S','Poster Uploaded successfully.'));      
           redirect('counsellingM/manageCounsellingPoster');
      }
    }

    /*************************************Video Type*****************************************************/

    public function videoTypeLog(){
      $id = $this->uri->segment(3);
      $data['index']         = 'videoType';
      $data['index2']        = 'Video Type Log';
      $data['title']         = 'Video Type Log | '.PROJECT_NAME; 
      $data['fileName']      = 'VideoTypeList';
      $data['videoType']     = $this->CounsellingModel->GetVideoLog($id);
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/counselling/video-type-log');
      $this->load->view('admin/include/footer-new');
      $this->load->view('admin/include/datatable-new');
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


  public function checkVideoName(){ 
    if(isset($_REQUEST['name']))
    {
      $name = $_REQUEST['name']; 
      $table = $_REQUEST['table_name']; 
      $column = $_REQUEST['column_name']; 
      $id = $_REQUEST['id']; 
      $id_column = $_REQUEST['id_column'];
      $type = $_REQUEST['type'];
      $data = $this->CounsellingModel->checkVideoName($name, $table, $column, $id, $id_column, $type); 

      if($data[$column]==$name){
        echo 1;  
      }
    }
  }


  public function ajaxVideowatchlist()
  {
    //print_r($_REQUEST);
    $this->db->order_by("id","desc");
    $query = $this->db->get_where('counsellingVideoLog', array('loungeId' => $_REQUEST['loungeId'], 'counsellingMasterId' => $_REQUEST['id']))->result_array();
    ?>

    <div class="table-responsive">
                            <table class="table table-striped dataex-html5-selectors-log">
                                <thead>
                                    <tr>
                                        <th>S&nbsp;No.</th>
                                        <th>views</th>  
                                         
                                    </tr>
                                </thead>
                                <tbody>

                                  <?php 
                                    $counter ="1";
                                    foreach ($query as $value) {
                                       $last_updated          = $this->FacilityModel->time_ago_in_php($value['addDate']);
                                      // $timewatch = $this->CounsellingModel->videoWatchlasttime( $value['loungeId']);
                                      //   $last_updated          = $this->FacilityModel->time_ago_in_php($timewatch['addDate']);
                                  ?>

                                    <tr>
                                      <td><?php  echo $counter; ?></td>
                                      
                                       <td><a class="tooltip nonclick_link"><?php echo $last_updated; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['addDate'])) ?></span></a></td>
                                    </tr>
                                      <?php $counter ++ ; } ?>
                                    
                                </tbody>
                                
                            </table>
                        </div>
    <?php
  }


}
 