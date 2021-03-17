<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct(){
    parent::__construct();
    $this->load->model('UserModel');
    $this->load->library('image_lib');
        $this->load->helper(array('captcha'));
  }

  public function restrictPageAccess($validPageArray=false){
    $adminData = $this->session->userdata('adminData');
    $userPermittedMenuData = array();
    $userPermittedMenuData = $this->session->userdata('userPermission');

    $success = 0;
    if(!empty($validPageArray) && ($adminData['Type']!=1)){ 
      foreach($validPageArray as $validPageArrayData){
        if(in_array($validPageArrayData, $userPermittedMenuData)){
          $success = $success+1;
        }
      }
    }

    if(($adminData['Type']!=1) && ($success == 0)){
      redirect('Admin/dashboard');
    }
  }


  public function Rcaptcha(){
        $data = array();
        $data['metaDescription'] = 'Build Captcha in CodeIgniter using Captcha Helper';
        $data['metaKeywords'] = 'Build Captcha in CodeIgniter using Captcha Helper';
        $data['title'] = "Build Captcha in CodeIgniter using Captcha Helper - TechArise";
        $data['breadcrumbs'] = array('Build Captcha in CodeIgniter using Captcha Helper' => '#');
        // If captcha form is submitted
        if($this->input->post('submit')) {
            $inputCaptcha = $this->input->post('captcha');
            $sessCaptcha = $this->session->userdata('captchaCode');
            if($inputCaptcha === $sessCaptcha){
                $data['msg'] = '<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success!</strong> Captcha code matched.
                </div>';
            }else{
                 $data['msg'] = '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Failed!</strong> Captcha does not match, please try again.
                </div>  ';
            }
        }
        // Captcha configuration
        $config = array(
            'img_path'      => BASH_PATH.'assets/uploads/captcha_images/',
            'img_url'       => base_url().'assets/uploads/captcha_images/',
            'font_path'     => BASH_PATH.'system/fonts/texb.ttf',
            'img_width'     => 170,
            'img_height'    => 55,
            'expiration'    => 7200,
            'word_length'   => 6,
            'font_size'     => 25,
            'colors'        => array(
                'background' => array(171, 194, 177),
                'border' => array(10, 51, 11),
                'text' => array(0, 0, 0),
                'grid' => array(185, 234, 237)
            )
        );
        $captcha = create_captcha($config);
        // Unset previous captcha and set new captcha word
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode', $captcha['word']);
        // Pass captcha image to view
        $data['captchaImg'] = $captcha['image'];
        // Load the view
        $this->load->view('admin/auth-login.php', $data);
    }
    // refresh
    public function refresh(){
        // Captcha configuration
         $config = array(
            'img_path'      => BASH_PATH.'assets/uploads/captcha_images/',
            'img_url'       => base_url().'assets/uploads/captcha_images/',
            'font_path'     => BASH_PATH.'system/fonts/texb.ttf',
            'img_width'     => 170,
            'img_height'    => 55,
            'expiration'    => 7200,
            'word_length'   => 6,
            'font_size'     => 25,
            'colors'        => array(
                'background' => array(171, 194, 177 ),
                'border' => array(10, 51, 115),
                'text' => array(0, 0, 0),
                'grid' => array(185, 234, 237)
            )
        );
        $captcha = create_captcha($config);
        // Unset previous captcha and set new captcha word
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode',$captcha['word']);
        // Display captcha image
        echo $captcha['image'];
    }
    

  public function is_logged_in() { 
    $admin_data = $this->session->userdata('adminData'); 
    if (!empty($admin_data)) {
      redirect(site_url('admin/dashboard'));
    }
  }

    // Check login status if not login redirect it to login page
  public function is_not_logged_in() {
    $admin_data = $this->session->userdata('adminData');
    
    if (empty($admin_data)) { 
      redirect(base_url('admin/'));
    }
  }



  public function colvalueUpdate(){
    $getDeliveryTime=$this->db->get_where('babyvaccination')->result_array();
    foreach ($getDeliveryTime as $key => $value) {
    
      $dTime = date('H:i:s', strtotime($value['VaccinationTime']));
      $this->db->where('ID',$value['ID']);
      $this->db->update('babyvaccination',array('VaccinationTime'=>$dTime));

    }
  }  

  // check admin/coach login and redirect to dashboard
	public function doLogin(){
    $login_array    = $this->input->post();
    $email          = $login_array['email'];
    $password       = $login_array['password'];

    $admin          = $this->UserModel->login($email, $password);
    
    if (!empty($admin['id'])){
      $adminData = array(
        'is_logged_in'  => true,
        'Type'      => $admin['type'],
        'Id'        => $admin['id'],
        'Name'      => ucwords($admin['name']),
        'Email'     => $admin['email'],
        'Mobile'    => $admin['mobile']
      );
      $this->session->set_userdata('adminData', $adminData);

      // maintain login history
      if($admin['type'] == 2){
        $updateArr = array( 'employeeId'  => $admin['id'],
                            'userType'    => 2,
                            'ipAddress'   => $this->input->ip_address(),
                            'type'        => 1,
                            'loginTime'   => date('Y-m-d H:i:s'),
                            'status'      => 1
                           );
        $this->db->insert('employeeLoginMaster', $updateArr);
      }

      $message = 'Welcome <strong>'.ucwords($admin['username']).'</strong>.You have successfully logged in.';
      $this->session->set_flashdata('login_message', getCustomAlert('S', $message));

      redirect('Admin/dashboard');
    } else {
      $this->session->set_flashdata('login_message', generateAdminAlert('D', 1));
      redirect('Admin');
    }     
  }

  // check Lounge login and redirect to dashboard
  public function loungeLogin(){
    $login_array    = $this->input->post();
    $data['district_id']    = $login_array['district_id'];
    $data['facility_id']    = $login_array['facility_id'];
    $data['lounge_id']      = $login_array['lounge_id'];
    $data['password']       = $login_array['password'];

    $login = $this->UserModel->loungeLogin($data);
    
    if (!empty($login)){
      if($login['status'] == 1){
        $adminData = array(
          'is_logged_in'  => true,
          'Type'      => 3,
          'Id'        => $login['id'],
          'Name'      => ucwords($login['name']),
          'Email'     => "",
          'Mobile'    => ""
        );
        $this->session->set_userdata('adminData', $adminData);

        // maintain login history
        $updateArr = array( 'employeeId'  => $login['id'],
                            'userType'    => 3,
                            'ipAddress'   => $this->input->ip_address(),
                            'type'        => 1,
                            'loginTime'   => date('Y-m-d H:i:s'),
                            'status'      => 1
                           );
        $this->db->insert('employeeLoginMaster', $updateArr);
        
        $message = 'Welcome <strong>'.ucwords($admin['name']).'</strong>.You have successfully logged in.';
        $this->session->set_flashdata('login_message', getCustomAlert('S', $message));

        redirect('Admin/dashboard');
      }else{
        $this->session->set_flashdata('login_message', generateAdminAlert('D', 11));
        redirect('Admin/loungeLogin'); 
      }
    } else {
      $this->session->set_flashdata('login_message', generateAdminAlert('D', 12));
      redirect('Admin/loungeLogin');
    }     
  }


  public function doCELLogin(){
    $login_array    = $this->input->post();
    $email          = $login_array['email'];
    $password       = $login_array['password'];

    
    $captcha=$_POST['g-recaptcha-response'];
    if(empty($captcha)){
      $this->session->set_flashdata('login_message', generateAdminAlert('D', 9));
      redirect('Admin/Login');
    }
    
    $secretKey = "6LfdpcYUAAAAADRv4qggKBFscozrHLGVfd8SRxGt";
    $ip = $_SERVER['REMOTE_ADDR'];
    // post request to server
    $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
    $response = file_get_contents($url);
    $responseKeys = json_decode($response,true);
    // should return JSON with success as true
    if($responseKeys["success"]) {
      $employee          = $this->UserModel->EmployeeLogin($email, base64_encode($password));
          
      if (!empty($employee)){ 
        // maintain login history
        $updateArr = array( 'employeeId'  => $employee['id'],
                            'ipAddress'   => $this->input->ip_address(),
                            'type'        => 1,
                            'loginTime'   => date('Y-m-d H:i:s'),
                            'status'      => 1
                           );
        $this->db->insert('employeeLoginMaster', $updateArr);
        // maintain login history
        $empData = array(
          'is_logged_in'  => true,
          'Type'      => '2',
          'Id'        => $employee['id'],
          'Name'      => ucwords($employee['name']),
          'Email'     => $employee['email']
           
        );
        $this->session->set_userdata('adminData', $empData);

        $message = 'Welcome <strong>'.ucwords($employee['name']).'</strong>.You have successfully logged in.';
        $this->session->set_flashdata('login_message', getCustomAlert('S', $message));
        

        redirect('Admin/dashboard');
        
      } else { 
        $this->session->set_flashdata('login_message', generateAdminAlert('D', 1));
        redirect('Admin/Login');
      }
    } else {
      $this->session->set_flashdata('login_message', generateAdminAlert('D', 10));
      redirect('Admin/Login');
    }
    
  
  }

  // logout admin and redirect to index page
  public function logout() {
      
    $this->session->unset_userdata('adminData');
    $this->session->set_flashdata('login_message', generateAdminAlert('S', 8));
    redirect(base_url());
    
  } 


  // logout employee and redirect to index page
  public function employeeLogout() {
    $employeeId = $this->session->userdata('adminData')['Id'];

    $updateArr = array(     
                            'type'        => 2,
                            'logoutTime'  => date('Y-m-d H:i:s'),
                            'status'      => 1
                           );  

    $this->db->where(array('employeeId' => $employeeId, 'type' => 1,'userType'=>2));
    $this->db->update('employeeLoginMaster',$updateArr); 

    $this->session->unset_userdata('adminData');
    $this->session->unset_userdata('userPermission');
    $this->session->set_flashdata('login_message', generateAdminAlert('S', 8));
    redirect(base_url());
  }

  // logout lounge and redirect to index page
  public function loungeLogout() {
    $loungeId = $this->session->userdata('adminData')['Id'];

    $updateArr = array(     
                            'type'        => 2,
                            'logoutTime'  => date('Y-m-d H:i:s'),
                            'status'      => 1
                           );  

    $this->db->where(array('employeeId' => $loungeId, 'type' => 1,'userType'=>3));
    $this->db->update('employeeLoginMaster',$updateArr); 

    $this->session->unset_userdata('adminData');
    $this->session->unset_userdata('userPermission');
    $this->session->set_flashdata('login_message', generateAdminAlert('S', 8));
    redirect(base_url('Admin/loungeLogin'));
  }
} 
