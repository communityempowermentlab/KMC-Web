<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Welcome.php');
class Forbiden extends Welcome {
  public function __construct() {
    parent::__construct();
    $this->load->model('ReportSettingModel');  
    $this->load->model('FacilityModel'); 
    $this->load->model('UserModel'); 
    $this->load->model('SmsModel'); 
    $this->load->model('LoungeModel');  
    $this->load->library('pagination'); 
    //$this->is_not_logged_in(); 
  }

  /* Report Setting Listing page call */
  public function index(){
    
        //$this->load->view('admin/include/header-new',$data);
        $this->load->view('errors/forbiden');
  }




}

    