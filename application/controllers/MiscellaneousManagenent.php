<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Welcome.php');
class MiscellaneousManagenent extends Welcome {
  public function __construct() {
    parent::__construct();
    $this->load->model('UserModel');
    $this->load->model('FacilityModel');
    $this->load->model('MiscellaneousModel');
    date_default_timezone_set('Asia/Kolkata');
       
  }

  

  /* 
    view Facility listing page when click on sidemenu Facilities
    view file name & path : admin/facility/facilityList
    facility table : facilitylist
  */ 
  public function manageNBCU(){
    $data['index']         = 'manageNBCU';
    $data['index2']        = '';
    $data['fileName']      = 'NBCUList';
    $data['title']         = 'Newborn Care Unit | '.PROJECT_NAME; 
    $data['GetList'] = $this->UserModel->GetNBCU(); 
     /*echo $this->db->last_query(); exit;*/
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/miscellaneous/nbcu-list');
    $this->load->view('admin/include/datatable-new');
    $this->load->view('admin/include/footer-new');
  }


  /* 
    view Facility log page when click on last updated link
    view file name & path : admin/facility/facilityLogList
    facility table : facilitylist
  */ 
  public function viewNBCULog(){
    $id=$this->uri->segment(3);
    $data['index']         = 'manageNBCU';
    $data['index2']        = '';
    $data['fileName']      = 'NBCUList';
    $data['title']         = 'Newborn Care Unit Log | '.PROJECT_NAME; 
    
    $data['GetNBCULog'] = $this->UserModel->GetMasterDataLog($id); 
     /*echo $this->db->last_query(); exit;*/
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/miscellaneous/nbcu-log-list');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }



  /* 
    view add Facility Type page when click on Add Facility Type button of Facility Type Listing page
    view file name & path : admin/facility/addFacilityType
    facility type table : facilityType
    when post : insert data in facilityType table
    when not post : get data and redirect to view file 
  */ 
  public function addNBCU(){
    $data['index']         = 'manageNBCU';
    $data['index2']        = '';
    $data['title']         = 'Add Newborn Care Unit | '.PROJECT_NAME; 
    $data['fileName']      = 'FacilityList';

    if($this->input->post()){
      $nbcu_name = $this->input->post('nbcu_name');

      $InsertData = array('name'    => $nbcu_name,
                          'type'    => 1,
                          'status'  => 1,
                          'addDate' => date('Y-m-d H:i:s'),
                          'modifyDate' => date('Y-m-d H:i:s')
                         );

      $masterId = $this->UserModel->insertData('masterData', $InsertData);

      $loginId = $this->session->userdata('adminData')['Id'];
      $ip = $this->input->ip_address();

      $InsertData2 = array('name'           => $nbcu_name,
                          'masterDataId'    => $masterId,
                          'type'          => 1,
                          'status'        => 1,
                          'addDate'       => date('Y-m-d H:i:s'),
                          'addedBy'       => $loginId,
                          'ipAddress'     => $ip
                          
                         );

      $check = $this->UserModel->insertData('masterDataLog', $InsertData2);

      if ($masterId) {
        $this->session->set_flashdata('activate', getCustomAlert('S','NBCU Data has been Added successfully'));
        redirect('Miscellaneous/manageNBCU');
      }
    }
      
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/include/tableScript');
    $this->load->view('admin/miscellaneous/nbcu-add');
    $this->load->view('admin/include/footer-new');
  }


  /* 
    view edit Facility type page when click on View/Edit button on Facility Type Listing page
    view file name & path : admin/facility/editFacilityType
    facility table : facilityType
    
  */  
  public function editNBCU(){
    $id=$this->uri->segment(3); 
    $data['index']         = 'manageNBCU';
    $data['index2']        = '';
    $data['title']         = 'Edit Newborn Care Unit | '.PROJECT_NAME; 
    $data['fileName']      = 'FacilityTypeList';

    $data['GetNBCUData'] = $this->UserModel->GetDataById('masterData', $id); 

    if($this->input->post()){
      $nbcu_name  = $this->input->post('nbcu_name');
      $status     = $this->input->post('status');

      $UpdateData = array('name'      => $nbcu_name,
                          'type'      => 1,
                          'status'    => $status,
                          'modifyDate' => date('Y-m-d H:i:s')
                         );

      $cond = array('id' => $id );

      $check = $this->UserModel->updateData('masterData', $UpdateData, $cond);

      $loginId = $this->session->userdata('adminData')['Id'];
      $ip = $this->input->ip_address();

      $InsertData2 = array('name'           => $nbcu_name,
                          'masterDataId'    => $id,
                          'type'          => 1,
                          'status'        => $status,
                          'addDate'       => date('Y-m-d H:i:s'),
                          'addedBy'       => $loginId,
                          'ipAddress'     => $ip
                          
                         );

      $this->UserModel->insertData('masterDataLog', $InsertData2);

      if ($check == 1) {
        $this->session->set_flashdata('activate', getCustomAlert('S','NBCU Data has been Updated successfully'));
        redirect('Miscellaneous/manageNBCU');
      }
    }

    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/miscellaneous/nbcu-edit');
    $this->load->view('admin/include/footer-new');

  }


  /* 
    view Facility listing page when click on sidemenu Facilities
    view file name & path : admin/facility/facilityList
    facility table : facilitylist
  */ 
  public function managementType(){
    $data['index']         = 'managementType';
    $data['index2']        = '';
    $data['fileName']      = 'managementTypeList';
    $data['title']         = 'Management Type | '.PROJECT_NAME; 
    $data['GetList'] = $this->UserModel->GetManagementType(); 
     /*echo $this->db->last_query(); exit;*/
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/miscellaneous/management-type-list');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }


  /* 
    view add Facility Type page when click on Add Facility Type button of Facility Type Listing page
    view file name & path : admin/facility/addFacilityType
    facility type table : facilityType
    when post : insert data in facilityType table
    when not post : get data and redirect to view file 
  */ 
  public function addManagementType(){
    $data['index']         = 'managementType';
    $data['index2']        = '';
    $data['title']         = 'Add Management Type | '.PROJECT_NAME; 
    $data['fileName']      = 'managementTypeList';

    if($this->input->post()){
      $managemnet_type_name = $this->input->post('managemnet_type_name');

      $InsertData = array('name'    => $managemnet_type_name,
                          'type'    => 2,
                          'status'  => 1,
                          'addDate' => date('Y-m-d H:i:s'),
                          'modifyDate' => date('Y-m-d H:i:s')
                         );

      $masterId = $this->UserModel->insertData('masterData', $InsertData);

      $loginId = $this->session->userdata('adminData')['Id'];
      $ip = $this->input->ip_address();

      $InsertData2 = array('name'           => $managemnet_type_name,
                          'masterDataId'    => $masterId,
                          'type'          => 2,
                          'status'        => 1,
                          'addDate'       => date('Y-m-d H:i:s'),
                          'addedBy'       => $loginId,
                          'ipAddress'     => $ip
                          
                         );

      $check = $this->UserModel->insertData('masterDataLog', $InsertData2);

      if ($masterId) {
        $this->session->set_flashdata('activate', getCustomAlert('S','NBCU Data has been Added successfully'));
        redirect('Miscellaneous/managementType');
      }
    }
      
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/miscellaneous/add-management-type');
    $this->load->view('admin/include/footer-new');
  }


  /* 
    view edit Facility type page when click on View/Edit button on Facility Type Listing page
    view file name & path : admin/facility/editFacilityType
    facility table : facilityType
    
  */  
  public function editManagementType(){
    $id=$this->uri->segment(3); 
    $data['index']         = 'managementType';
    $data['index2']        = '';
    $data['title']         = 'Edit Management Type | '.PROJECT_NAME; 
    $data['fileName']      = 'managementTypeList';

    $data['GetData'] = $this->UserModel->GetDataById('masterData', $id); 

    if($this->input->post()){
      $managemnet_type_name = $this->input->post('managemnet_type_name');
      $status = $this->input->post('status');

      $UpdateData = array('name'        => $managemnet_type_name,
                          'type'        => 2,
                          'status'      => $status,
                          'modifyDate'  => date('Y-m-d H:i:s')
                         );

      $cond = array('id' => $id );

      $check = $this->UserModel->updateData('masterData', $UpdateData, $cond);

      $loginId = $this->session->userdata('adminData')['Id'];
      $ip = $this->input->ip_address();

      $InsertData2 = array('name'           => $managemnet_type_name,
                          'masterDataId'    => $id,
                          'type'          => 2,
                          'status'        => $status,
                          'addDate'       => date('Y-m-d H:i:s'),
                          'addedBy'       => $loginId,
                          'ipAddress'     => $ip
                          
                         );

      $this->UserModel->insertData('masterDataLog', $InsertData2);

      if ($check == 1) {
        $this->session->set_flashdata('activate', getCustomAlert('S','NBCU Data has been Updated successfully'));
        redirect('Miscellaneous/managementType');
      }
    }

    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/miscellaneous/edit-management-type');
    $this->load->view('admin/include/footer-new');

  }


  /* 
    view Facility log page when click on last updated link
    view file name & path : admin/facility/facilityLogList
    facility table : facilitylist
  */ 
  public function viewManagementTypeLog(){
    $id=$this->uri->segment(3);
    $data['index']         = 'managementType';
    $data['index2']        = '';
    $data['fileName']      = 'managementTypeList';
    $data['title']         = 'Management Type Log | '.PROJECT_NAME; 
    
    $data['GetLog'] = $this->UserModel->GetMasterDataLog($id); 
     /*echo $this->db->last_query(); exit;*/
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/miscellaneous/management-type-log');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }


  public function manageSitemap(){
    
      $table_name1 = 'manageSitemap';
      $con1 = array(
            // 'type'
            'parentId' => 0
          );
      $get_heading = $this->MiscellaneousModel->getMenuByPos($table_name1, $con1);
      $data['heading_menu'] = $get_heading;

      $table_name = 'manageSitemap';
      $con = array(
              'status!='  => 3,
              'parentId'  => 0
            );
      $result = $this->MiscellaneousModel->getMenuByPos($table_name, $con);
      $data['heading']  = $result;
      $data['index'] = 'Sitemap';
      $data['index2'] = 'Sitemap';
      $data['title'] = 'Site Map | '.PROJECT_NAME; 
      $this->load->view('admin/include/header-new', $data);
      $this->load->view('admin/manage_menu/sitemap-new', $data);
      $this->load->view('admin/include/footer-new');
    
  }


  public function manageSetting(){
    $page_type = $this->uri->segment(3,0);

    // if($this->input->post()) {
    //   $lounge     = $this->input->post('lounge');
    //   $staff      = $this->input->post('staff');
    //   $cel_employees      = $this->input->post('cel_employees');
    //   $low_bed_occupancy  = $this->input->post('low_bed_occupancy');
    //   $amenities_info     = $this->input->post('amenities_info');
    //   $amenities_value_updation     = $this->input->post('amenities_value_updation');
    //   $amenities_register_sms_notification     = $this->input->post('amenities_register_sms_notification');
    //   $staff_register_sms_notification     = $this->input->post('staff_register_sms_notification');
    //   $admin_lounge_notification     = $this->input->post('admin_lounge_notification');
    //   $admin_lounge_notification_mobiles     = $this->input->post('admin_lounge_notification_mobiles');

    //   $updateArray = array( 'dashboardLounge' => $lounge,
    //                         'dashboardStaff'  => $staff,
    //                         'dashboardCelEmp' => $cel_employees,
    //                         'dashboardLowBed' => $low_bed_occupancy,
    //                         'dashboardAmenitiesInfo' => $amenities_info,
    //                         'amenitiesValueUpdation' => $amenities_value_updation,
    //                         'amenitiesRegisterOtpVerification' => $amenities_register_sms_notification,
    //                         'staffRegisterOtpVerification' => $staff_register_sms_notification,
    //                         'adminLoungeNotification' => $admin_lounge_notification,
    //                         'adminLoungeNotificationMobiles' => $admin_lounge_notification_mobiles
    //                        );

    //   $this->db->where('id', 1)->update('settings', $updateArray);

    //   $message = '<div class="alert border-success alert-dismissible mb-2" role="alert">
    //                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    //                           <span aria-hidden="true">×</span>
    //                         </button>
    //                         <div class="d-flex align-items-center">
    //                           <i class="bx bx-like"></i>
    //                           <span>
    //                             Settings data updated successfully.
    //                           </span>
    //                         </div>
    //                       </div>';

        
    //   $this->session->set_flashdata('message', $message);
    //   redirect(site_url('Miscellaneous/manageSetting/'), 'refresh');

    // }

    $result = $this->MiscellaneousModel->getSettingData();
    $data['result'] = $result;
    $data['index'] = 'Setting';
    $data['index2'] = 'Setting';
    $data['title'] = 'Settings | '.PROJECT_NAME; 
    $data['page_type'] = $page_type;
    $this->load->view('admin/include/header-new', $data);
    $this->load->view('admin/settings/setting-new', $data);
    $this->load->view('admin/include/footer-new');
  }

  // Save general settings
  public function updateGeneralSettings(){
    $page_type = $this->uri->segment(3,0);
    if($this->input->post()) {
      $lounge     = $this->input->post('lounge');
      $staff      = $this->input->post('staff');
      $cel_employees      = $this->input->post('cel_employees');
      $low_bed_occupancy  = $this->input->post('low_bed_occupancy');
      $amenities_info     = $this->input->post('amenities_info');

      $updateArray = array( 'dashboardLounge' => $lounge,
                            'dashboardStaff'  => $staff,
                            'dashboardCelEmp' => $cel_employees,
                            'dashboardLowBed' => $low_bed_occupancy,
                            'dashboardAmenitiesInfo' => $amenities_info
                           );

      $this->db->where('id', 1)->update('settings', $updateArray);

      $message = '<div class="alert border-success alert-dismissible mb-2" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                            <div class="d-flex align-items-center">
                              <i class="bx bx-like"></i>
                              <span>
                                Settings data updated successfully.
                              </span>
                            </div>
                          </div>';

        
      $this->session->set_flashdata('message', $message);
      redirect(site_url('Miscellaneous/manageSetting/'.$page_type), 'refresh');

    }
  }

  // Save enquiry settings
  public function updateEnquirySettings(){
    $page_type = $this->uri->segment(3,0);
    if($this->input->post()) {
      $newEnquiryNotification     = $this->input->post('newEnquiryNotification');
      if($newEnquiryNotification == "1"){
        $newEnquiryNotificationMobiles      = $this->input->post('newEnquiryNotificationMobiles');
      }else{
        $newEnquiryNotificationMobiles      = "";
      }
      

      $updateArray = array( 'newEnquiryNotification' => $newEnquiryNotification,
                            'newEnquiryNotificationMobiles'  => $newEnquiryNotificationMobiles
                           );

      $this->db->where('id', 1)->update('settings', $updateArray);

      $message = '<div class="alert border-success alert-dismissible mb-2" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                            <div class="d-flex align-items-center">
                              <i class="bx bx-like"></i>
                              <span>
                                Settings data updated successfully.
                              </span>
                            </div>
                          </div>';

        
      $this->session->set_flashdata('message', $message);
      redirect(site_url('Miscellaneous/manageSetting/'.$page_type), 'refresh');

    }
  }

  // Save danger notification settings
  public function updateDangerNotificationSettings(){
    $page_type = $this->uri->segment(3,0);
    if($this->input->post()) {
      $admin_lounge_notification     = $this->input->post('admin_lounge_notification');
      $admin_lounge_notification_mobiles     = $this->input->post('admin_lounge_notification_mobiles');

      $updateArray = array( 'adminLoungeNotification' => $admin_lounge_notification,
                            'adminLoungeNotificationMobiles' => $admin_lounge_notification_mobiles
                           );

      $this->db->where('id', 1)->update('settings', $updateArray);

      $message = '<div class="alert border-success alert-dismissible mb-2" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                            <div class="d-flex align-items-center">
                              <i class="bx bx-like"></i>
                              <span>
                                Settings data updated successfully.
                              </span>
                            </div>
                          </div>';

        
      $this->session->set_flashdata('message', $message);
      redirect(site_url('Miscellaneous/manageSetting/'.$page_type), 'refresh');

    }
  }

  // Save baseline settings
  public function updateBaselineSettings(){
    $page_type = $this->uri->segment(3,0);
    if($this->input->post()) {
      $amenities_value_updation     = $this->input->post('amenities_value_updation');
      $amenities_register_sms_notification     = $this->input->post('amenities_register_sms_notification');
      $warRoomAlertAmenities     = $this->input->post('warRoomAlertAmenities');
      if($warRoomAlertAmenities == "1"){
        $warRoomAlertAmenitiesMobiles     = $this->input->post('warRoomAlertAmenitiesMobiles');
      }else{
        $warRoomAlertAmenitiesMobiles = "";
      }
      $staff_register_sms_notification     = $this->input->post('staff_register_sms_notification');
      $warRoomAlertStaff     = $this->input->post('warRoomAlertStaff');
      if($warRoomAlertStaff == "1"){
        $warRoomAlertStaffMobiles     = $this->input->post('warRoomAlertStaffMobiles');
      }else{
        $warRoomAlertStaffMobiles     = "";
      }

      $updateArray = array( 'amenitiesValueUpdation' => $amenities_value_updation,
                            'amenitiesRegisterOtpVerification' => $amenities_register_sms_notification,
                            'warRoomAlertAmenities' => $warRoomAlertAmenities,
                            'warRoomAlertAmenitiesMobiles' => $warRoomAlertAmenitiesMobiles,
                            'staffRegisterOtpVerification' => $staff_register_sms_notification,
                            'warRoomAlertStaff' => $warRoomAlertStaff,
                            'warRoomAlertStaffMobiles' => $warRoomAlertStaffMobiles
                           );

      $this->db->where('id', 1)->update('settings', $updateArray);

      $message = '<div class="alert border-success alert-dismissible mb-2" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                            <div class="d-flex align-items-center">
                              <i class="bx bx-like"></i>
                              <span>
                                Settings data updated successfully.
                              </span>
                            </div>
                          </div>';

        
      $this->session->set_flashdata('message', $message);
      redirect(site_url('Miscellaneous/manageSetting/'.$page_type), 'refresh');

    }
  }

   public function addMenuHeading()
    {
      $menu_type  = $this->input->post('menu_type');
      $label_name = $this->input->post('label_name');
      $date_time  = date('Y-m-d H:i:s');

      if($menu_type=="1")
      {
        $type = "heading";
      }
      elseif($menu_type=="2")
      {
        $type = "menu";
      }

      $save_data = array(
            'levelName'   => $label_name,
            'type'        => $type,
            'parentId'    => 0,
            'status'      => 1,
            'addDate'     => $date_time,
            'modifyDate'  => $date_time
          );

      $save_data = $this->MiscellaneousModel->addMenuHeading($save_data);
      $message = '<div class="alert border-success alert-dismissible mb-2" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                            <div class="d-flex align-items-center">
                              <i class="bx bx-like"></i>
                              <span>
                                Menu data added successfully.
                              </span>
                            </div>
                          </div>';


      
      $this->session->set_flashdata('message', $message);
      redirect(site_url('Miscellaneous/manageSitemap'), 'refresh');
    }


    public function editNode()
    {
      $menu_id = $this->input->post('id');

      $table    = "manageSitemap";
      $con = array(
              'id'  => $menu_id
            );
      $get_node_data = $this->MiscellaneousModel->getData($table, $con, $menu_id);

      $addChildHtml = "";

      $addChildHtml .='<script> $(document).ready(function(){ $("#editMenuLabelForm").validate(); });</script>';
      $addChildHtml .='<form method="post" action="'.base_url('Miscellaneous/editMenuLabel').'" onsubmit="return updateLabel()" id="editMenuLabelForm">';
      $addChildHtml .='<div class="col-xs-12 col-sm-12 divPadding">';

          $addChildHtml .='<div class="form-group col-12 row pr-0">';
                              $addChildHtml .='<div  class="col-sm-3">';
                                  $addChildHtml .='<label for="exampleInputEmail1">Label <span class="red">*</span></label>';
                              $addChildHtml .='</div>';
                              $addChildHtml .='<div  class="col-sm-9 pr-0"><div class="controls">';
                                  $addChildHtml .='<input type="text" class="form-control" id="level_name" name="level_name" value="'.$get_node_data['levelName'].'" >'; 
                                  $addChildHtml .='<input type="hidden" name="menu_id" value="'.$get_node_data['id'].'">';
                                  $addChildHtml .='<span class="custom-error" id="err_level_name"></span>';
                              $addChildHtml .='</div></div>';
          $addChildHtml .='</div>';

          $addChildHtml .='<input type="submit" class="btn btn-sm pull-right btn-primary mr-1" value="Update">';

      $addChildHtml .='</div>';
      
      $addChildHtml .='</form>';

      echo $addChildHtml;
    }


    public function editMenuLabel()
    {
      $menu_id  = $this->input->post('menu_id');
      $label_name = $this->input->post('level_name');

      $date_time  = date('Y-m-d H:i:s');          

        $update_data = array(
              'levelName'   => $label_name,
              'modifyDate'  => $date_time
            );

        $data = $this->MiscellaneousModel->editMenuLabel($update_data,$menu_id);

        $message = '<div class="alert border-success alert-dismissible mb-2" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                            <div class="d-flex align-items-center">
                              <i class="bx bx-like"></i>
                              <span>
                                Menu data updated successfully.
                              </span>
                            </div>
                          </div>';

        
      $this->session->set_flashdata('message', $message);
      redirect(site_url('Miscellaneous/manageSitemap'), 'refresh');
    }


    public function addNewChild()
    {
      $parent_id = $this->input->post('id');

      $table    = "manageSitemap";
      $con = array(
              'id'  => $parent_id
            );
      $get_node_data = $this->MiscellaneousModel->getData($table, $con, $parent_id);

      if($get_node_data['type']=="heading")
      {
        $label = "Heading";
        $child_label = "Menu";
      }
      elseif($get_node_data['type']=="menu")
      {
        $label = "Menu";
        $child_label = "Button / Tab";
      }
      else
      {
        $label = "Label";
        $child_label = "Child Label";
      }

      $addChildHtml = "";
      // $addChildHtml .='<script> $(document).ready(function(){ $("#saveNewChildForm").validate(); });</script>';
      $addChildHtml .='<form method="post" action="'.base_url('Miscellaneous/saveNewChild').'" onsubmit="return validateNewChild()" id="saveNewChildForm">';
      $addChildHtml .='<div class="col-xs-12 col-sm-12 divPadding">';

      $addChildHtml .='<div class="form-group col-12 row pr-0">';
                              $addChildHtml .='<div  class="col-sm-4">';
                                  $addChildHtml .='<label for="exampleInputEmail1">'.$label.' <span class="red">*</span></label>';
                              $addChildHtml .='</div>';
                              $addChildHtml .='<div  class="col-sm-8 pr-0">';
                                  $addChildHtml .='<input type="text" class="form-control" name="parent_name" value="'.$get_node_data['levelName'].'" readonly>'; 
                                  $addChildHtml .='<input type="hidden" name="parent_id" value="'.$get_node_data['id'].'">';
                                  $addChildHtml .='<input type="hidden" name="parent_type" value="'.$get_node_data['type'].'">';
                              $addChildHtml .='</div>';
          $addChildHtml .='</div>';

          $addChildHtml .='<div class="form-group col-12 row pr-0">';
                              $addChildHtml .='<div  class="col-sm-4">';
                                  $addChildHtml .='<label for="exampleInputEmail1">'.$child_label.' <span class="red">*</span></label>';
                              $addChildHtml .='</div>';
                              $addChildHtml .='<div  class="col-sm-8 pr-0">';
                                $addChildHtml .='<input type="text" class="form-control" id="level_name" name="level_name" required>'; 
                                $addChildHtml .='<span class="custom-error" id="err_level_name"></span>'; 
                                  
                              $addChildHtml .='</div>';
          $addChildHtml .='</div>';

          $addChildHtml .='<center><input type="submit" class="btn btn-sm btn-primary pull-right mr-1" value="Submit"></center>';

      $addChildHtml .='</div>';
      
      $addChildHtml .='</form>';

      echo $addChildHtml;
    }


    public function saveNewChild()
    {
      $parent_id  = $this->input->post('parent_id');
      $label_name = $this->input->post('level_name');
      $parent_type = $this->input->post('parent_type');

      $date_time  = date('Y-m-d H:i:s');

      if($parent_type=="heading")
      {
        $type = "menu";
      }
      elseif($parent_type=="menu")
      {
        $type = "button";
      }
      else
      {
        $type = "button";
      }         

        $save_data = array(
              'levelName'   => $label_name,
              'type'        => $type,
              'parentId'    => $parent_id,
              'status'      => 1,
              'addDate'     => $date_time,
              'modifyDate'  => $date_time
            );

        $save_data = $this->MiscellaneousModel->addMenuHeading($save_data);

        $message = '<div class="alert border-success alert-dismissible mb-2" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                            <div class="d-flex align-items-center">
                              <i class="bx bx-like"></i>
                              <span>
                                Menu data added successfully.
                              </span>
                            </div>
                          </div>';
        $this->session->set_flashdata('message', $message);
        redirect(site_url('Miscellaneous/manageSitemap'), 'refresh');
    }


    public function changeStatus() {
      $table = $this->input->post('table'); 
      $id = $this->input->post('id');
      $update_status = $this->MiscellaneousModel->changeStatus($id, $table);
      echo $update_status;
      die();
    }


    /* view all menu */
    public function viewMenuGroup() {

      # get menu data in manage menu group setting 
      $table_name = 'manageMenuGroupSetting';
      $con = array(
              'status !=' => 3
            );
      $get_grp_list = $this->MiscellaneousModel->getData($table_name, $con);
      $data['res']  = $get_grp_list;
      $data['index']  = 'MenuGroup'; 
      $data['index2'] = ''; 
      $data['title']  = 'Menu Group | '.PROJECT_NAME; 
      $this->load->view('admin/include/header-new', $data);
      $this->load->view('admin/manage_group/group-list', $data);
      $this->load->view('admin/include/footer-new');
      $this->load->view('admin/include/datatable-new');
    } /* view all menu / */


    /* add menu group data */
      public function addMenuGroup() 
      {
        if ($this->input->post()) 
        { 
          $name     = trim($this->input->post('name'));
          $view_head  = $this->input->post('view_head');
          //print_r($view_head);exit;
          $date_time  = date('Y-m-d H:i:s');

          /* insert group name */
                $group_table_name = 'manageMenuGroupSetting';
                $group_data_array = array(
                          'groupName'    => $name,
                          'status'      => 1,
                          'modifyDate'  => $date_time,
                          'addDate'  => $date_time
                        );  
                
                $menu_group_id = $this->MiscellaneousModel->insertGroup($group_table_name, $group_data_array); 
                /* insert group name / */

                /*insert group heading or menu or buttons*/
                //$delete_group_heading = $this->MiscellaneousModel->deleteMenuGroupHeading($menu_group_id);

                $heading_table_name = 'headingControlSystem';
                foreach($view_head as $view_head_data)
                {
                  $group_heading_array = array(
                      'menuGroupId'     => $menu_group_id,
                      'headingId'        => $view_head_data,
                      'headingName'      => "",
                      'status'        => 1,
                      'modifyDate'    => $date_time,
                      'addDate'    => $date_time
                    );
                    

                    $insertData = $this->MiscellaneousModel->insertGroup($heading_table_name, $group_heading_array); 
                }               
                /*end*/

                $message = '<div class="alert border-success alert-dismissible mb-2" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                            <div class="d-flex align-items-center">
                              <i class="bx bx-like"></i>
                              <span>
                                '.ucwords($name).' menu group submitted successfully.
                              </span>
                            </div>
                          </div>';

                
          $this->session->set_flashdata('message', $message);
          redirect(site_url('Miscellaneous/viewMenuGroup'), 'refresh');
        }
        else
        {
          // get menu data in manage menu system 
          $table_name = 'manageSitemap';
          $con = array(
                  'status'  => 1,
                  'parentId' => 0
                );
          $get_menu_list = $this->MiscellaneousModel->getMenu($table_name, $con);
          $data['get_menu_list'] = $get_menu_list;
          $data['index']  = 'MenuGroup'; 
          $data['index2'] = ''; 
          $data['title'] = 'Add Menu Group | '.PROJECT_NAME; 
          $this->load->view('admin/include/header-new', $data);
          $this->load->view('admin/manage_group/group-add', $data);
          $this->load->view('admin/include/footer-new');
        }

      }


      public function getMenuChild()
      {
        $id       = $this->input->post('id');
        $checked_menu   = $this->input->post('checked_menu');
        $childHtml = "";

        $explode_menu = explode(",",$checked_menu);
        //print_r($explode_menu);exit;
        $table_name = 'manageSitemap';
        $condition = array(
                'status'  => 1,
                'parentId' => $id
              );

        $get_child_list = $this->MiscellaneousModel->getMenu($table_name, $condition);
        $url = base_url('Miscellaneous/getMenuChild');
        
        if(!empty($get_child_list))
        {
          $checked = "";
          foreach($get_child_list as $get_child_data)
          {
                        
            $childHtml .='<div class="col-sm-11 divPadding mn panel">';

              $childHtml .='<div class="col-sm-4 mb-1">';
                $childHtml .= '<fieldset>';
                $childHtml .= '<div class="checkbox">';
                            
                                $childHtml .='<input type="checkbox" name="view_head[]" id="view_head_'.$get_child_data['id'].'" value="'.$get_child_data['id'].'" title="Permission" class="checkbox-input set_heads" onclick="getMenuChild('.$get_child_data['id'].', '.'\''.$url.'\');">';
                                $childHtml .='<input type="hidden" name="head_id[]" class="id_heads">';
                                $childHtml .= '<label for="view_head_'.$get_child_data['id'].'">'.$get_child_data['levelName'].'</label>';
                            $childHtml .='</div>';
                          $childHtml .='</fieldset>';  
                        $childHtml .='</div>';
                    $childHtml .='</div>';

                    if(in_array($get_child_data['id'], $explode_menu))
            {
              $childHtml .='<script type="text/javascript">$(document).ready(function(){ $("#view_head_'.$get_child_data['id'].'").prop("checked", true); getMenuChild('.$get_child_data['id'].', '.'\''.$url.'\'); });</script>';
            }
            else
            {
              $childHtml .= "";
            }

                      $childHtml .='<div style="margin-left:20px;"><div class="hide" id="child_div_'.$get_child_data['id'].'"></div></div>';
                      
          }

        }

        echo $childHtml;
      }

      public function editMenuGroup() {
        $id = $this->uri->segment(3, 0);

          /*********Menu Group Post data************/

          if ($this->input->post()) 
        {
          $name     = trim($this->input->post('name'));
          $view_head  = $this->input->post('view_head');
          $status   = $this->input->post('status');
          
          $date_time  = date('Y-m-d H:i:s');

          /* update group name */
                $group_table_name = 'manageMenuGroupSetting';
                $group_data_array = array(  
                          'groupName'   => $name,
                          'status'      => $status,
                          'modifyDate'  => $date_time
                          );  
                
                $updateMenuDetails = $this->MiscellaneousModel->updateManageMenuGroup($group_table_name, $group_data_array, $id);; 
                /* update group name / */

                /*insert group heading or menu or buttons*/
                $delete_group_heading = $this->MiscellaneousModel->deleteMenuGroupHeading($id);

                $heading_table_name = 'headingControlSystem';
                foreach($view_head as $view_head_data)
                {
                  $group_heading_array = array(
                      'menuGroupId'       => $id,
                      'headingId'        => $view_head_data,
                      'headingName'      => "",
                      'status'        => 1,
                      'modifyDate'    => $date_time,
                      'addDate'    => $date_time
                    );
                    
                    $insertData = $this->MiscellaneousModel->insertGroup($heading_table_name, $group_heading_array); 
                }               
                /*end*/

                $string_version = implode(',', $view_head);

                $loginId = $this->session->userdata('adminData')['Id'];
                $ip = $this->input->ip_address(); 

                // $group_heading_array = array(
                //   'manageMenuGroupId'       => $insertData,
                //   'groupName'               => $name,
                //   'menuIds'                 => $string_version,
                //   'status'                  => $status,
                //   'addedBy'                 => $loginId,
                //   'ipAddress'               => $ip,
                //   'addDate'                 => $date_time
                // );
                    
                // $this->MiscellaneousModel->insertGroup('manageMenuGroupSettingLog', $group_heading_array); 

                $message = '<div class="alert border-success alert-dismissible mb-2" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                            <div class="d-flex align-items-center">
                              <i class="bx bx-like"></i>
                              <span>
                                '.ucwords($name).' menu group updated successfully.
                              </span>
                            </div>
                          </div>';

                
          $this->session->set_flashdata('message', $message);
          redirect(site_url('Miscellaneous/viewMenuGroup'), 'refresh');
        }

          /**********Post data end***********/

        $data['id'] = $id;
        /* get menu item list */
        $table_name = 'manageSitemap';
        $con = array(
                  'status'  => 1,
                  'parentId' => 0
              );
        $get_menu_list = $this->MiscellaneousModel->getMenu($table_name, $con);
        $data['get_menu_list'] = $get_menu_list; 
        /* get menu item list / */

        /* get group name */
        $table_name1 = 'manageMenuGroupSetting';
        $con1 = array(
                  'id'  => $id
                );
        $get_group = $this->MiscellaneousModel->getData($table_name1, $con1, $id);
        $data['get_group']  = $get_group; 

        /*get selected heading or menus*/
        $group_table_name = 'headingControlSystem';
        $con_group = array(
                  'menuGroupId' => $id,
                  'status'    => 1
                );
        $get_group_permission = $this->MiscellaneousModel->getData($group_table_name, $con_group);

        $permission_array = array();
        $permission_string = "";
        foreach($get_group_permission as $get_group_permission_data)
        {
          array_push($permission_array, $get_group_permission_data['headingId']);
          $permission_string .= $get_group_permission_data['headingId'].",";
        } 
        $data['menu_permission_array'] = $permission_array;
        $data['menu_permission_string'] = $permission_string;
        /*******************************/

        
        $data['index']  = 'MenuGroup'; 
        $data['index2'] = ''; 
        $data['title'] = 'Edit Menu Group | '.PROJECT_NAME; 
        $this->load->view('admin/include/header-new', $data);
        $this->load->view('admin/manage_group/group-edit', $data);
        $this->load->view('admin/include/footer-new');
        }

}
?>
