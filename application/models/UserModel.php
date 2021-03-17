<?php
class UserModel extends CI_Model {
  public function __construct(){
    parent::__construct();
    $this->load->database();
  }
 
 // get admin data when login
  public function login($username,$password) {
      
    $this->db->select("id, name,email,profileImage");
    $query = $this->db->get_where('adminMaster', array(EMAIL => $username,PASSWORD=>base64_encode($password)))->row_array();
    $query['type'] = 1;
    if(empty($query['id'])){
      $this->db->select("id, name,email,mobile,profileImage");
      $query = $this->db->get_where('coachMaster', array('mobile' => $username,'password'=>md5($password)))->row_array();
      $query['type'] = 2;
    }
    return $query;

  }

  // get lounge data when login
  public function loungeLogin($data) {
      
    $this->db->select("loungeId as id,loungeName as name, status");
    $query = $this->db->get_where('loungeMaster', array('loungeId' => $data['lounge_id'],'loungePassword'=>md5($data['password'])))->row_array();
    return $query;
  }

  // get facility list by district id
  public function getDistrictFacility($district_id){
    $this->db->order_by('FacilityName','asc');
    return $this->db->get_where('facilitylist',array('PRIDistrictCode'=>$district_id,'Status'=>1))->result_array(); 
  }

  // get lounge list by facility id
  public function getFacilityLounge($facility_id){
    $this->db->order_by('loungeName','asc');
    return $this->db->get_where('loungeMaster',array('facilityId'=>$facility_id,'status'=>1))->result_array(); 
  }

  public function EmployeeLogin($username,$password) {
      
    $this->db->select("id, name,email,contactNumber");
    $query = $this->db->get_where('employeesData', array('email' => $username,'password'=>$password, 'status' =>  '1'));
    return $query->row_array();

  }

  // get staffType data via parentId
  public function getStaffTypeList($table ,$Id){
    $this->db->order_by('staffTypeNameEnglish ','ASC');
    return $this->db->get_where($table,array('parentId'=>$Id,'status'=>1))->result_array();
  }


  // get babies data
  public function GetBabies($lounge_id='') {
    if($_SESSION['adminData']['Type']==1)
    {
      return $this->db->query("SELECT BR.`babyPhoto`,BM.`babyTemperature`, BM.`babyRespiratoryRate` , BM.`babyPulseSpO2`, BR.`motherId`,MR.`motherName`, BA.`loungeId`, BA.`babyId`, BA.`id` as baby_admission_table_id , BM.`assesmentDate`, BM.`assesmentTime` FROM babyAdmission as BA LEFT JOIN babyRegistration as BR on BA.`babyId` = BR.`babyId` LEFT JOIN motherRegistration as MR on BR.`motherId` = MR.`motherId` LEFT JOIN  as BM on BM.`babyId` = BA.`babyId` GROUP BY BA.`babyId` order by BA.`babyId`")->result_array();
       
    } else {

      return $this->db->query(" SELECT BR.`babyPhoto`,BM.`babyTemperature`, BM.`babyRespiratoryRate` , BM.`babyPulseSpO2`,  BR.`motherId`,MR.`motherName`,
      BA.`babyId`, BA.`id` as baby_admission_table_id , BM.`assesmentDate`, BM.`assesmentTime` FROM 
      babyAdmission as BA LEFT JOIN babyRegistration as BR on BA.`babyId` = BA.`babyId` 
      LEFT JOIN motherRegistration as MR on BR.`motherId` = MR.`motherId` 
      LEFT JOIN babyDailyMonitoring as BM on BM.`babyId` = BA.`babyId` where  BA.`loungeId` = '".$lounge_id."' GROUP BY BA.`babyId` order by BA.`babyId`")->result_array();
    }
  }

  // get data from loungeMaster for status != '2'
  public function lounge(){
    return $this->db->query("SELECT * From loungeMaster where status != '2' ORDER BY loungeId desc")->result_array();
  }

  // get data from loungeMaster via loungeContactNumber
  public function checkMobile($mobile){
    return $this->db->get_where('loungeMaster',array('loungeContactNumber'=>$mobile))->row_array(); 
  }

  // get data from masterData for type = 1 
  public function NewBornCareUnit(){
    return $this->db->get_where('masterData',array('type'=>'1'))->result_array(); 
  }

  // get data from masterData for type = 2 
  public function ManagementType(){
    return $this->db->get_where('masterData',array('type'=>'2'))->result_array(); 
  }

  // get data from masterData for type = 3 
  public function GovtORNot(){
    return $this->db->get_where('masterData',array('type'=>'3'))->result_array(); 
  }

  // get data from loungeMaster join facilitylist
  public function GetFacilitiesName($Lounge_id){
    $LoungeFacility =  $this->db->query(" select * from loungeMaster,facilitylist where facilitylist.FacilityID=loungeMaster.facilityId and loungeMaster.loungeId='$Lounge_id'")->result_array();
    if(count($LoungeFacility)>0)
      foreach ($LoungeFacility as $key => $value){
        return $value;
      }
  }

  // get data from masterData join facilitylist
  public function GetFacilityManagement($FacilityManagement){
    $FacilityManagement =  $this->db->query(" select * from masterData,facilitylist where facilitylist.FacilityManagement=masterData.id and masterData.id='$FacilityManagement'")->result_array();
    if(count($FacilityManagement)>0)
      foreach ($FacilityManagement as $key => $value){
        return $value;
      }
  }

  // get data from staffMaster and facilitylist
  public function GetFacilitiesName2($staff_id){
    $LoungeFacility =  $this->db->query(" select * from staffMaster,facilitylist where facilitylist.FacilityID=staffMaster.facilityId and staffMaster.staffId='$staff_id'")->result_array();
    if(count($LoungeFacility)>0)
      foreach ($LoungeFacility as $key => $value){
        return $value;
      }
  }

  // get data from staffMaster and staffType where staffType.staffTypeId=staffMaster.staffType
  public function GetStaffName($staffType_id){
    $StaffType =  $this->db->query(" select * from staffMaster,staffType where staffType.staffTypeId=staffMaster.staffType and staffMaster.staffType='$staffType_id'")->result_array();
    if(count($StaffType)>0)
      foreach ($StaffType as $key => $value){
        return $value;
      }
  }

  // get data from staffMaster and staffType where staffType.staffTypeId=staffMaster.staffSubType 
  public function GetStaffSubName($staffSubType_id){
    $StaffSubType =  $this->db->query(" select * from staffMaster,staffType where staffType.staffTypeId=staffMaster.staffSubType and staffMaster.staffSubType='$staffSubType_id'")->result_array();
    if(count($StaffSubType)>0)
      foreach ($StaffSubType as $key => $value){
        return $value;
      }
  }

  // get facility data where FacilityName is not blank
  public function GetFacilities()
  {
    return $this->db->query("SELECT * FROM `facilitylist` where FacilityName!='' ORDER BY `FacilityName` ASC")->result_array();
  }

  // get data from loungeMaster and facilitylist
  public function GetFacilitiesById($FacilityID)
  {
    return $this->db->query(" select * from loungeMaster,facilitylist where facilitylist.FacilityID=loungeMaster.FacilityID and loungeMaster.FacilityID='$FacilityID'")->row_array();
  }  

  // get staffType data via parentId
  public function GetStaffSubType($id){
    $this->db->order_by("staffTypeNameEnglish", "asc");
    return $this->db->get_where('staffType',array('parentId'=>$id))->result_array();
  }
  
  // get motherMonitoring data via motherId
  public function GetMotherAssessmentData($Id){
    return $this->db->get_where('motherMonitoring',array('motherId'=>$Id))->row_array();
  }
  
  // get data from staffMaster via staffId
  public function getStaffNameBYID($Id){
    return $this->db->get_where('staffMaster',array('staffId'=>$Id))->row_array();
  }

  // get data from motherMonitoring via motherId
  public function GetMotherAssessmentDataBYID($Id){
    return $this->db->get_where('motherMonitoring',array('motherId'=>$Id))->result_array();
  }

  // get data from facilitylist via FacilityID
  public function getFacilityNameBYID($Id){
    return  $this->db->get_where('facilitylist',array('FacilityID'=>$Id))->row_array();
  }

  // get count from various tables
  public function getCount() {
    $adminData = $this->session->userdata('adminData'); 
        $query1 = $this->db
                  ->select('*')
                  ->from('facilitylist')
                  ->get()
                  ->num_rows();
    $query2 = $this->db
                  ->select('*')
                  ->from('loungeMaster')
                  ->where(array('status ='=>1))
                  ->get()
                  ->num_rows();

    $query3 = $this->db
                  ->select('*')
                  ->from('staffMaster')
                  ->get()
                  ->num_rows();

    $query4 = $this->db
                  ->select('*')
                  ->from('babyRegistration')
                  ->get()
                  ->num_rows();

    $query5 = $this->db
                  ->select('*')
                  ->from('motherRegistration')
                  ->get()
                  ->num_rows(); 


    $data['facility']                        = $query1;
    $data['lounge']                          = $query2;
    $data['staff']                           = $query3;
    $data['baby']                            = $query4;
    $data['mother']                          = $query5;
    return $data;

  }

  // get NBCU List
  public function GetNBCU(){
    return $this->db->get_where('masterData',array('type'=>1))->result_array();
  }
  public function GetMedicine(){
    return $this->db->get_where('masterData',array('type'=>5))->result_array();
  }

  public function GetMasterDataLog($id){
    $this->db->order_by('id ','desc');
    return $this->db->get_where('masterDataLog',array('masterDataId'=>$id))->result_array();
  }

  public function insertData($table, $data){
    $this->db->insert($table,$data);
    return $this->db->insert_id();
  }

  /* get data from table by id  */
  public function GetDataById($table,$id) {  
    return $this->db->get_where($table,array('id'=>$id))->row_array();
  }

  public function updateData($table,$data,$cond){
    $this->db->where($cond);
    $this->db->update($table,$data); 
    return 1;
  }

  // get Management Type List
  public function GetManagementType(){
    return $this->db->get_where('masterData',array('type'=>2))->result_array();
  }


  public function getEmployeeMenu($empId,$userType = false){
    if(!empty($userType)){
      $userType = $userType;
    }else{
      $userType = "1";
    }
    $getGroupId = $this->db->get_where('employeeMenuGroup',array('employeeId'=>$empId, 'userType'=>$userType, 'status' => 1))->result_array(); 
    $get_menu_data = array();
    foreach ($getGroupId  as $key => $value) {
      $getMenuId = $this->db->get_where('headingControlSystem',array('menuGroupId'=>$value['groupId'], 'status' => 1))->result_array();
      
      foreach ($getMenuId as $getMenuIdKey => $getMenuIdValue) {
        if(!in_array($getMenuIdValue['headingId'], $get_menu_data))
        {
          array_push($get_menu_data,$getMenuIdValue['headingId']);
        }
      }
    }
    return $get_menu_data;
  }

  public function getCoachFacilities(){
    $adminData = $this->session->userdata('adminData'); 
    $coachFacilityArray = array();
    $coachLoungeArray = array();
    $coachDistrictArray = array();
    if($adminData['Type'] == 2){
      $getCoachFacilityLoungeList = $this->db->get_where('coachDistrictFacilityLounge',array('masterId'=>$adminData['Id'],'status'=>1))->result_array();
      $coachDistrictArray  = array_unique(array_column($getCoachFacilityLoungeList, 'districtId'));
      $coachFacilityArray  = array_unique(array_column($getCoachFacilityLoungeList, 'facilityId'));
      $coachLoungeArray  = array_column($getCoachFacilityLoungeList, 'loungeId');
    }elseif($adminData['Type'] == 3){

      $this->db->select('loungeMaster.loungeId,facilitylist.FacilityID,facilitylist.PRIDistrictCode');
      $this->db->join('facilitylist','facilitylist.FacilityID=loungeMaster.facilityId');
      $getFacilityLoungeList = $this->db->get_where('loungeMaster',array('loungeMaster.loungeId'=>$adminData['Id'],'loungeMaster.status'=>1))->row_array();
      
      $coachDistrictArray  = array('0'=>$getFacilityLoungeList['PRIDistrictCode']);
      $coachFacilityArray  = array('0'=>$getFacilityLoungeList['FacilityID']);
      $coachLoungeArray  = array('0'=>$getFacilityLoungeList['loungeId']);
    }
    //print_r($coachLoungeArray);exit;
    $response['coachDistrictArray'] = $coachDistrictArray;
    $response['coachDistrictArrayString'] = "(".implode(",", $coachDistrictArray).")";
    $response['coachFacilityArray'] = $coachFacilityArray;
    $response['coachFacilityArrayString'] = "(".implode(",", $coachFacilityArray).")";
    $response['coachLoungeArray'] = $coachLoungeArray;
    $response['coachLoungeArrayString'] = "(".implode(",", $coachLoungeArray).")";
    return $response;
  }

  public function getDashboardData(){
    $adminData = $this->session->userdata('adminData'); 
    $coachFacilityArray = array();
    $coachLoungeArray = array();
    if($adminData['Type'] == 2){
      $getCoachFacilityLoungeList = $this->db->get_where('coachDistrictFacilityLounge',array('masterId'=>$adminData['Id'],'status'=>1))->result_array();
      $coachFacilityArray  = array_column($getCoachFacilityLoungeList, 'facilityId');
      $coachLoungeArray  = array_column($getCoachFacilityLoungeList, 'loungeId');
    }

    // facility count
    if(!empty($coachFacilityArray)){
      $this->db->where_in('facilitylist.FacilityID',$coachFacilityArray);
    }
    $facility = $this->db->get_where('facilitylist',array('status!='=>3))->num_rows();

    // lounge count
    if(!empty($coachLoungeArray)){
      $this->db->where_in('loungeMaster.loungeId',$coachLoungeArray);
    }
    $lounge = $this->db->get_where('loungeMaster',array('status!='=>3))->num_rows();

    // staff count
    if(!empty($coachFacilityArray)){
      $this->db->where_in('staffMaster.facilityId',$coachFacilityArray);
    }
    $staff = $this->db->get_where('staffMaster',array('status!='=>3))->num_rows();
    
    // employee count
    $cel_emp = $this->db->get_where('employeesData',array('status!='=>3))->num_rows();

    // enquiry count
    if(!empty($coachLoungeArray)){
      $this->db->where_in('stuckData.loungeId',$coachLoungeArray);
    }
    $total_enquiry = $this->db->get_where('stuckData',array('status!='=>3))->num_rows();

    // video count
    $total_video = $this->db->get_where('counsellingMaster',array('status!='=>3))->num_rows();

    $date = date('Y-m-d H:i:s', strtotime('-10 days'));

    $setting = $this->db->get_where('settings',array('id'=>1))->row_array();
    
    $lounge_list = $this->db
                  ->query("SELECT loginMaster.id, loginMaster.loginTime, loginMaster.logoutTime, loginMaster.loungeMasterId, `loungeMaster`.`loungeName` FROM `loginMaster` JOIN `loungeMaster` ON `loginMaster`.`loungeMasterId`=`loungeMaster`.`loungeId` WHERE `loginMaster`.`loginTime` < '".$date."' GROUP By loginMaster.loungeMasterId LIMIT ".$setting['dashboardLounge'])
                  ->result_array();

    $staff_list = $this->db
                  ->query("SELECT staffMaster.staffId, staffMaster.name, nurseDutyChange.addDate, nurseDutyChange.modifyDate FROM `staffMaster` JOIN `nurseDutyChange` ON `staffMaster`.`staffId`=`nurseDutyChange`.`nurseId` WHERE `nurseDutyChange`.`addDate` < '".$date."' OR `nurseDutyChange`.`addDate` < '".$date."' GROUP By staffMaster.staffId LIMIT ".$setting['dashboardStaff'])
                  ->result_array(); 

    $cel_emp_list = $this->db->get_where('employeesData',array('status'=>1))->result_array();
    $res_arr_values = array();
    foreach ($cel_emp_list  as $key => $value) {
      $get_last_login = $this->db->get_where('employeeLoginMaster',array('employeeId'=>$value['id']))->row_array();
      if(empty($get_last_login)) {
        $value['loginTime'] = '';
        array_push($res_arr_values, $value);
      } else{
        if($get_last_login['loginTime'] < $date){
          $value['loginTime'] = $get_last_login['loginTime'];
          array_push($res_arr_values, $value);
        }
      }
    } 

    $total_mothers = $this->db->get('motherRegistration')->num_rows();
    $total_baby = $this->db->get('babyRegistration')->num_rows();
                  
    $result = array();
    $result['facility_count'] = $facility;
    $result['lounge_count']   = $lounge;
    $result['staff_count']    = $staff;
    $result['cel_emp_count']  = $cel_emp;
    $result['lounge_list']  = $lounge_list;
    $result['staff_list']   = $staff_list;
    $result['cel_emp_list']   = $res_arr_values;
    $result['total_enquiry']   = $total_enquiry;
    $result['total_video']   = $total_video;
    $result['total_mothers']   = $total_mothers;
    $result['total_baby']   = $total_baby;

    return $result;
  }

  public function getAmenitiesLastUpdate($loungeId){
    return $this->db->get_where('loungeAmenities',array('loungeId'=> $loungeId))->row_array();
  }

}
 ?>