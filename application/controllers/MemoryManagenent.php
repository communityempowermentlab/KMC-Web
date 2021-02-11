<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Welcome.php');
class MemoryManagenent extends Welcome {
  public function __construct() {
    parent::__construct();
    $this->load->model('UserModel');
    $this->load->model('FacilityModel');
    $this->load->model('StaffModel');
    $this->load->model('LoungeModel');  
    date_default_timezone_set('Asia/Kolkata');     
    $this->is_not_logged_in(); 
       
  }

  /*  Facility Login page call
      LogIn based on Facility Mobile Number
      view file name & path : /admin/facilityLogin
  */
  public function index(){
    $this->load->view('/admin/facilityLogin');
  }

public function getFolderSize($directory){
        $totalSize = 0;
        $directoryArray = scandir($directory);
        $num_files = count($directoryArray) - 2; 
        //$totalFile = $num_files + $nm;
  
//return $num_files . " files"; 

        foreach($directoryArray as $key => $fileName){
            if($fileName != ".." && $fileName != "."){
                if(is_dir($directory . "/" . $fileName)){
                    $totalSize = $totalSize + $this->getFolderSize($directory . "/" . $fileName);
                } else if(is_file($directory . "/". $fileName)){
                    $totalSize = $totalSize + filesize($directory. "/". $fileName);
                }
            }
        }
        //$results = $totalSize."|".$totalFile.$nm;
        return $totalSize;
    }


    public function getFormattedSize($sizeInBytes) {

        if($sizeInBytes < 1024) {
            return $sizeInBytes . " bytes";
        } else if($sizeInBytes < 1024*1024) {
            return $sizeInBytes/1024 . " KB";
        } else if($sizeInBytes < 1024*1024*1024) {
            return round($sizeInBytes/(1024*1024), '2') . " MB";
        } else if($sizeInBytes < 1024*1024*1024*1024) {
            return $sizeInBytes/(1024*1024*1024) . " GB";
        } else if($sizeInBytes < 1024*1024*1024*1024*1024) {
            return $sizeInBytes/(1024*1024*1024*1024) . " TB";
        } else {
            return "Greater than 1024 TB";
        }

    }

  public function countFiles($path) {
  $size = 0;
  $ignore = array('.','..');
  $files = scandir($path);
  foreach($files as $t) {
    if(in_array($t, $ignore)) continue;
    if (is_dir(rtrim($path, '/') . '/' . $t)) {
      $size += $this->countFiles(rtrim($path, '/') . '/' . $t);
    } else {
      $size++;
    }   
  }
  return $size;
}


  public function detail(){
    $data['index']         = 'memoryDetail';
    $data['index2']        = '';
    $data['title']         = 'Memory Detail | '.PROJECT_NAME; 
    $data['fileName']      = 'memoryDetail';
    $data['contro']      = $this;

    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/memory/memoryDetail');
    $this->load->view('admin/include/footer-new');
  }


  



}
?>
