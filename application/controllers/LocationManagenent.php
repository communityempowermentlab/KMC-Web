
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Welcome.php');
class LocationManagenent extends Welcome {
  public function __construct() {
    parent::__construct();
    $this->load->model('UserModel');
    $this->load->model('FacilityModel');
    $this->load->model('LocationModel');
    date_default_timezone_set('Asia/Kolkata');
    $this->is_not_logged_in(); 
    $this->restrictPageAccess(array('17'));
  }

  

  /* 
    view state listing page when click on sidemenu state inside Location
    view file name & path : admin/location/stateList
    state table : stateMaster
  */ 
  public function manageState(){
    $data['index']         = 'manageState';
    $data['index2']        = '';
    $data['fileName']      = 'StateList';
    $data['title']         = 'State | '.PROJECT_NAME; 
    $data['GetList'] = $this->LocationModel->GetStates(); 
     /*echo $this->db->last_query(); exit;*/
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/location/state-list');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }



  /* 
    view state listing page when click on sidemenu Revenue Location inside Location
    view file name & path : admin/location/districtList
    state table : stateMaster
  */ 
  public function manageRevenue(){
    $data['index']         = 'manageRevenue';
    $data['index2']        = '';
    $data['fileName']      = 'DistrictList';
    $data['title']         = 'Revenue District | '.PROJECT_NAME; 
    $data['GetList'] = $this->LocationModel->GetRevenueDistrict(); 
     /*echo $this->db->last_query(); exit;*/
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/location/district-list');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }

  public function revenueLog(){
    $data['index']         = 'manageRevenue';
    $data['index2']        = '';
    $data['fileName']      = 'revenueLog';
    $data['title']         = 'Revenue Location Log | '.PROJECT_NAME; 
    $data['GetList'] = $this->LocationModel->GetRevenueLog(); 
     /*echo $this->db->last_query(); exit;*/
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/location/log-list');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }

  

  public function urbanBlock(){
    $PRIDistrictCode = $this->uri->segment(3); 
    $data['index']         = 'manageRevenue';
    $data['index2']        = '';
    $data['fileName']      = 'BlockList';
    $data['title']         = 'Revenue Urban Block | '.PROJECT_NAME; 
    $data['GetList'] = $this->LocationModel->getUrbanBlockByDistrict($PRIDistrictCode); 
    $data['districtData'] = $this->LocationModel->getDynamicColData('PRIDistrictCode', $PRIDistrictCode); 
     /*echo $this->db->last_query(); exit;*/
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/location/urban-block-list');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }


  public function ruralBlock(){
    $PRIDistrictCode = $this->uri->segment(3); 
    $data['index']         = 'manageRevenue';
    $data['index2']        = '';
    $data['fileName']      = 'BlockList';
    $data['title']         = 'Revenue Rural Block | '.PROJECT_NAME; 
    $data['GetList'] = $this->LocationModel->getRuralBlockByDistrict($PRIDistrictCode); 
    $data['districtData'] = $this->LocationModel->getDynamicColData('PRIDistrictCode', $PRIDistrictCode); 
     /*echo $this->db->last_query(); exit;*/
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/location/rural-block-list');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }


  public function urbanVillage(){
    $BlockPRICode = $this->uri->segment(3); 
    $BlockPRICodeData = $this->LocationModel->getDynamicColData('BlockPRICode', $BlockPRICode); 
    $data['BlockPRICode']         = $BlockPRICodeData['PRIDistrictCode'];
    $data['index']         = 'manageRevenue';
    $data['index2']        = '';
    $data['fileName']      = 'VillageList';
    $data['title']         = 'Revenue Urban Village | '.PROJECT_NAME; 
    $data['GetList']    = $this->LocationModel->getUrbanVillageByBlock($BlockPRICode); 
    $data['blockData']  = $BlockPRICodeData;
     /*echo $this->db->last_query(); exit;*/
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/location/urban-village-list');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }


  public function ruralVillage(){
    $BlockPRICode = $this->uri->segment(3); 
    $BlockPRICodeData = $this->LocationModel->getDynamicColData('BlockPRICode', $BlockPRICode); 
    $data['BlockPRICode']         = $BlockPRICodeData['PRIDistrictCode'];
    $data['index']         = 'manageRevenue';
    $data['index2']        = '';
    $data['fileName']      = 'VillageList';
    $data['title']         = 'Revenue Rural Village | '.PROJECT_NAME; 
    $data['GetList'] = $this->LocationModel->getRuralVillageByBlock($BlockPRICode); 
    $data['blockData']  = $BlockPRICodeData;
     /*echo $this->db->last_query(); exit;*/
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/location/rural-village-list');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }


  function EditDistrict(){
    $data['index']         = 'manageRevenue';
    $data['index2']        = '';
    $data['fileName']      = 'EditDistrict';
    $data['title']         = 'Edit District | '.PROJECT_NAME; 

    $PRIDistrictCode = $this->uri->segment(3); 
    $data['GetData'] = $this->LocationModel->getDynamicColData('PRIDistrictCode', $PRIDistrictCode); 

    if ($this->input->post()) {
      $PRIDistrictCode = $this->uri->segment(3); 

      $district_name = $this->input->post('district_name');
      $district_code = $this->input->post('district_code');
      $status = $this->input->post('status');

      $updateArr = array( 'PRIDistrictCode' => $district_code,
                          'DistrictNameProperCase' => $district_name,
                          'status' => $status,
                          'modifyDate' => date('Y-m-d H:i:s')
                       );
      $addedBy      = $this->session->userdata('adminData')['Id'];
      $ipAddress    = $this->input->ip_address();
      $addedByType  = $this->session->userdata('adminData')['Type'];

      $actionType   = 'Updated';

      $logArr = array(    'PRIDistrictCode' => $district_code,
                          'DistrictNameProperCase' => $district_name,
                          'status' => $status,
                          'addedBy' => $addedBy,
                          'ipAddress' => $ipAddress,
                          'addedByType' => $addedByType,
                          'actionType' => $actionType,
                          'addDate' => date('Y-m-d H:i:s'),
                          'modifyDate' => date('Y-m-d H:i:s')
                       );

      $this->db->where('PRIDistrictCode', $PRIDistrictCode)->update('revenuevillagewithblcoksandsubdistandgs', $updateArr);

      $this->db->insert('revenueLocationLog',$logArr);

      $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Updated successfully.'));
      redirect('Location/manageRevenue');

    }

    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/location/edit-district');
    $this->load->view('admin/include/footer-new');
  }


  function EditBlock(){
    $data['index']         = 'manageRevenue';
    $data['index2']        = '';
    $data['fileName']      = 'EditDistrict';
    $data['title']         = 'Edit Block | '.PROJECT_NAME; 

    $BlockPRICode = $this->uri->segment(3); 
    $data['GetData'] = $this->LocationModel->getDynamicColData('BlockPRICode', $BlockPRICode); 

    if ($this->input->post()) {
      $BlockPRICode = $this->uri->segment(3); 

      $block_name = $this->input->post('block_name');
      $block_code = $this->input->post('block_code');
      $status = $this->input->post('status');

      $updateArr = array( 'BlockPRICode' => $block_code,
                          'BlockPRINameProperCase' => $block_name,
                          'status' => $status,
                          'modifyDate' => date('Y-m-d H:i:s')
                       );
      $addedBy      = $this->session->userdata('adminData')['Id'];
      $ipAddress    = $this->input->ip_address();
      $addedByType  = $this->session->userdata('adminData')['Type'];

      $actionType   = 'Updated';

      $logArr = array(    'BlockPRICode' => $block_code,
                          'BlockPRINameProperCase' => $block_name,
                          'status' => $status,
                          'addedBy' => $addedBy,
                          'ipAddress' => $ipAddress,
                          'addedByType' => $addedByType,
                          'actionType' => $actionType,
                          'addDate' => date('Y-m-d H:i:s'),
                          'modifyDate' => date('Y-m-d H:i:s')
                       );

      $this->db->where('BlockPRICode', $BlockPRICode)->update('revenuevillagewithblcoksandsubdistandgs', $updateArr);

      $this->db->insert('revenueLocationLog',$logArr);

      $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Updated successfully.'));
      redirect('Location/manageRevenue');

    }

    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/location/edit-block');
    $this->load->view('admin/include/footer-new');
  }


  function EditVillage(){
    $data['index']         = 'manageRevenue';
    $data['index2']        = '';
    $data['fileName']      = 'EditVillage';
    $data['title']         = 'Edit Village | '.PROJECT_NAME; 

    $GPPRICode = $this->uri->segment(3); 
    $data['GetData'] = $this->LocationModel->getDynamicColData('GPPRICode', $GPPRICode); 

    if ($this->input->post()) {
      $GPPRICode = $this->uri->segment(3); 

      $village_name = $this->input->post('village_name');
      $village_code = $this->input->post('village_code');
      $status = $this->input->post('status');

      $updateArr = array( 'GPPRICode' => $village_code,
                          'GPNameProperCase' => $village_name,
                          'status' => $status,
                          'modifyDate' => date('Y-m-d H:i:s')
                       );
      $addedBy      = $this->session->userdata('adminData')['Id'];
      $ipAddress    = $this->input->ip_address();
      $addedByType  = $this->session->userdata('adminData')['Type'];

      $actionType   = 'Updated';

      $logArr = array(    'GPPRICode' => $village_code,
                          'GPNameProperCase' => $village_name,
                          'status' => $status,
                          'addedBy' => $addedBy,
                          'ipAddress' => $ipAddress,
                          'addedByType' => $addedByType,
                          'actionType' => $actionType,
                          'addDate' => date('Y-m-d H:i:s'),
                          'modifyDate' => date('Y-m-d H:i:s')
                       );

      $this->db->where('GPPRICode', $GPPRICode)->update('revenuevillagewithblcoksandsubdistandgs', $updateArr);

      $this->db->insert('revenueLocationLog',$logArr);

      $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Updated successfully.'));
      redirect('Location/manageRevenue');

    }

    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/location/edit-village');
    $this->load->view('admin/include/footer-new');
  }


  public function AddLocation(){
    $data['index']         = 'manageRevenue';
    $data['index2']        = '';
    $data['fileName']      = 'AddLocation';
    $data['title']         = 'Add Location | '.PROJECT_NAME; 

    $data['GetStates'] = $this->LocationModel->GetStates();
    $data['GetDistrict'] = $this->LocationModel->GetRevenueDistrict(); 

    $area_type = $this->uri->segment(3); 

    if ($this->input->post()) { 
      $district   = $this->input->post('district');
      $area_type  = $this->input->post('area_type');
      $district_name = $this->input->post('district_name');
      $district_code = $this->input->post('district_code');
      $block      = $this->input->post('block');
      $block_name = $this->input->post('block_name');
      $block_code = $this->input->post('block_code');
      $village    = $this->input->post('village');
      $village_code = $this->input->post('village_code');

      $insertArr = array();

      $logArr = array();

      $insertArr['StateCode'] = '9';
      $insertArr['StateNameProperCase'] = 'UTTAR PRADESH';

      if($district == 'new') {
        $logArr['PRIDistrictCode'] = $insertArr['PRIDistrictCode'] = $district_code;
        $logArr['DistrictNameProperCase'] = $insertArr['DistrictNameProperCase'] = $district_name;
      } else{
        $DistrictData = $this->LocationModel->getDynamicColData('PRIDistrictCode', $district); 

        $logArr['PRIDistrictCode'] = $insertArr['PRIDistrictCode'] = $DistrictData['PRIDistrictCode'];
        $logArr['DistrictNameProperCase'] = $insertArr['DistrictNameProperCase'] = $DistrictData['DistrictNameProperCase'];
      }


      if($block == 'new') {
        $logArr['BlockPRICode'] = $insertArr['BlockPRICode'] = $block_name;
        $logArr['BlockPRINameProperCase'] = $insertArr['BlockPRINameProperCase'] = $block_code;
      } else{
        $BlockData = $this->LocationModel->getDynamicColData('BlockPRICode', $block); 

        $logArr['BlockPRICode'] = $insertArr['BlockPRICode'] = $BlockData['BlockPRICode'];
        $logArr['BlockPRINameProperCase'] = $insertArr['BlockPRINameProperCase'] = $BlockData['BlockPRINameProperCase'];
      }

      $logArr['UrbanRural'] = $insertArr['UrbanRural']  = $area_type;
      $logArr['GPPRICode']  = $insertArr['GPPRICode']   = $village_code;
      $logArr['GPNameProperCase'] = $insertArr['GPNameProperCase']   = $village;


      $logArr['status']     = $insertArr['status']        = 1;
      $logArr['addDate']    = $insertArr['addDate']       = date('Y-m-d H:i:s');
      $logArr['modifyDate'] = $insertArr['modifyDate']    = date('Y-m-d H:i:s');

      $logArr['addedBy']      = $this->session->userdata('adminData')['Id'];
      $logArr['ipAddress']    = $this->input->ip_address();
      $logArr['addedByType']  = $this->session->userdata('adminData')['Type'];

      $logArr['actionType']   = 'Added';

      $this->db->insert('revenuevillagewithblcoksandsubdistandgs',$insertArr);

      $this->db->insert('revenueLocationLog',$logArr);



      $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Added successfully.'));
      redirect('Location/manageRevenue');

    }
    
     /*echo $this->db->last_query(); exit;*/
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/location/add-location');
    $this->load->view('admin/include/footer-new');
  }


  public function getBlockByArea(){
    if ($this->input->post()) {
      $block = $this->input->post('block');
      $district = $this->input->post('district');
      $area_type = $this->input->post('area_type');

      if($area_type == 'Rural'){
        $getData = $this->LocationModel->getRuralBlockByDistrict($district); 
      } else {
        $getData = $this->LocationModel->getUrbanBlockByDistrict($district); 
      }

      
      
      $set_html_cont = '<option value="">Select Block</option>';       

      foreach ($getData as $value) {

        $Select = ($block==$value['BlockPRICode'])?'SELECTED':'' ;
        $set_html_cont.= '<option value="'.$value['BlockPRICode'].'" '.$Select.' >'.$value['BlockPRINameProperCase'].'</option>'; 
        
      }

      $set_html_cont.= '<option value="new">Add New Block</option>';
      print_r($set_html_cont);
    }
  }


  public function checkUniqueName(){
    if ($this->input->post()) {
      $value = $this->input->post('value');
      $column = $this->input->post('column');

      $prevVal = $this->input->post('prevVal');

      $chkData = $this->LocationModel->getDynamicColData($column, $value); 

      if(!empty($chkData) && $chkData[$column] != $prevVal){
        if($column == 'DistrictNameProperCase'){
          echo 'This district name already exists.';
        } else if($column == 'PRIDistrictCode'){
          echo 'This district code already exists.';
        } else if($column == 'BlockPRINameProperCase'){
          echo 'This block name already exists.';
        } else if($column == 'BlockPRICode'){
          echo 'This block code already exists.';
        } else if($column == 'GPPRICode'){
          echo 'This village code already exists.';
        }
      } else{
        echo 1;
      }
      
    }
  }


  public function checkBlockUniqueName(){
    if ($this->input->post()) {
      $value = $this->input->post('value');
      $column = $this->input->post('column');
      $district = $this->input->post('district');

      $prevVal = $this->input->post('prevVal');

      $chkData = $this->LocationModel->getDynamicColData($column, $value); 

      if(!empty($chkData) && $chkData[$column] != $prevVal){
        if($chkData['PRIDistrictCode'] == $district){
          echo 'This block name already exists in district '.$chkData['DistrictNameProperCase'].'.';
        } else {
          echo 1;
        }
      } else{
        echo 1;
      }
      
    }
  }


  public function checkVillageUniqueName(){
    if ($this->input->post()) {
      $value = $this->input->post('value');
      $column = $this->input->post('column');
      $block = $this->input->post('block');

      $prevVal = $this->input->post('prevVal');

      $chkData = $this->LocationModel->getDynamicColData($column, $value); 

      if(!empty($chkData) && $chkData[$column] != $prevVal){
        if($chkData['BlockPRICode'] == $block){
          echo 'This village name already exists in block '.$chkData['BlockPRINameProperCase'].'.';
        } else {
          echo 1;
        }
      } else{
        echo 1;
      }
      
    }
  }

}
?>
