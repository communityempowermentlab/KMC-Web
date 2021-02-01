<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Welcome.php');
class MotherManagenent extends Welcome {
  public function __construct() {
      parent::__construct();
      $this->load->model('mother_model');  
      $this->load->model('facility_model');  
      $this->load->model('baby_model'); 
      $this->load->model('DashboardDataModel');
      $this->load->library('pagination');
    }
    /*Registred Mother Listing */
  public function registeredMother(){      
    $loungeId = $this->uri->segment(3);  
    $data['index']         = 'Mother';      
    $data['index2']        = '';      
    $data['fileName']      = 'Mother_List';
    $data['title']         = 'Manage Mothers | '.PROJECT_NAME;      
    //$data['GetMother']   = $this->MotherModel->Mother($loungeId); 
    $this->load->view('admin/include/header',$data);      
    $this->load->view('admin/mother/MotherList',$data);      
    $this->load->view('admin/include/footer');
    //$this->load->view('admin/include/dataTable');   
  }

/*Registred Single Mother List BY ID */
public function viewMother(){
      $lastAdmitId = $this->uri->segment(3);
      $data['index']         = 'Mother';
      $data['index2']        = '';
      $data['title']         = 'View Mother Detail | The Kangaroo Care';
      $data['motherAdmitData']   = $this->db->get_where('mother_admission',array('id'=>$lastAdmitId))->row_array();
      $mother_id    = $this->db->get_where('mother_admission',array('id'=>$lastAdmitId))->row_array();
      $data['motherData']    = $this->MotherModel->getMotherDataById('mother_registration',$mother_id['MotherID']);
      $this->load->view('admin/include/header',$data);
      $this->load->view('admin/mother/view_mother');
      $this->load->view('admin/include/footer');
 }
 /* Mother Assesment Data Listing Page call*/   
 public function motherAssessment(){
      $loungeId = $this->uri->segment(3); 
      $data['index']               = 'MotherAssessment';
      $data['index2']              = '';
      $data['fileName']            = 'Mother_Assessment_List';
      $data['title']               = 'Mother Assessment | '.PROJECT_NAME; 
      $data['MotherA']             = $this->FacilityModel->MotherAssessment($loungeId);
      $this->load->view('admin/include/header',$data);
      $this->load->view('admin/mother/MotherAssement');
      $this->load->view('admin/include/footer');
      $this->load->view('admin/include/dataTable'); 
    }
 /* All Baby Of Single Mother*/
  public function singleMotherBabies(){   
        $id = $this->uri->segment(3);
        $data['index']         = 'Mother';      
        $data['index2']        = '';      
        $data['title']         = 'Manage Mothers | '.PROJECT_NAME;      
        $data['GetBaby']       = $this->MotherModel->getBabyOfMotherId('babyRegistration',$id); 
        $this->load->view('admin/include/header',$data);      
        $this->load->view('admin/mother/singleMotherBabies');      
        $this->load->view('admin/include/footer');    
    }
public function mothersViaLounge(){      
  $data['index']         = 'Mother';      
  $data['index2']        = '';      
  $data['title']         = 'Manage Mothers | '.PROJECT_NAME;      
  $data['totalLounges']  = $this->DashboardDataModel->getAllLonges();
  $this->load->view('admin/include/header1',$data);      
  $this->load->view('admin/mother/MothersViaLounge');      
  $this->load->view('admin/include/footer');    
  }

public function mothersAssessmentViaLounge(){      
  $data['index']         = 'Mother';      
  $data['index2']        = '';      
  $data['title']         = 'Mother Assessment | '.PROJECT_NAME;      
  $data['totalLounges']  = $this->DashboardDataModel->getAllLonges();
  $this->load->view('admin/include/header1',$data);      
  $this->load->view('admin/mother/mothersAssessmentViaLounge');      
  $this->load->view('admin/include/footer');    
}  

public function motherListViaAjax(){
 // $loungeId = $this->uri->segment('4');

  $loungeId = 1;
  $getMotherAdmissionData = $this->MotherModel->get_datatables($loungeId);
  $data = array();
  $no   = $_POST['start'];
 
  foreach ($getMotherAdmissionData as $val) 
   { 
    $getRegMotherData     = $this->MotherModel->GetMotherType($val['MotherID']);
    $get_last_assessment  = $this->MotherModel->GetLastAsessmentBabyOrMother('mother_monitoring','MotherID',$val['MotherID'],$val['id']);
    $GetAllBaby           = $this->MotherModel->GetAllBabiesViaMother('babyRegistration',$val['MotherID']);
    $GetAllBabies         = $this->MotherModel->getMotherDataById('babyRegistration',$val['MotherID']);
      $status1 = 0;
      $status2 = 0;
      $status3 = 0;
      $status4 = 0;
      $status5 = 0;
      $status6 = 0;
      $status7 = 0;
      $status8 = 0;
        if($get_last_assessment['MotherPulse'] < 50 || $get_last_assessment['MotherPulse'] > 120){
         $status1 = '1';
        }

        if($get_last_assessment['MotherTemperature'] < 95.9 || $get_last_assessment['MotherTemperature'] > 99.5){
         $status2 = '1';
        }


       if($get_last_assessment['MotherSystolicBP'] >= 140 || $get_last_assessment['MotherSystolicBP'] <= 90){
         $status3 = '1';
        }

        if($get_last_assessment['MotherDiastolicBP'] <= 60 || $get_last_assessment['MotherDiastolicBP'] >= 90){
         $status4 = '1';
        }

        if($get_last_assessment['MotherUterineTone'] == 'Hard/Collapsed (Contracted)'){
         $status5 = '1';
        }

        if(!empty($get_last_assessment['EpisitomyCondition']) && $get_last_assessment['EpisitomyCondition'] == 'Infected'){
         $status6 = '1';
        }                                   

        if(!empty($get_last_assessment['SanitoryPadStatus']) && $get_last_assessment['SanitoryPadStatus'] == "It's FULL"){
         $status7 = '1';
        }   

        if(!empty($get_last_assessment['MotherBleedingStatus']) && $get_last_assessment['MotherBleedingStatus'] == "Yes"){
         $status8 = '1';
        } 
        if($status1 == 1 || $status2 == 1 || $status3 == 1 || $status4 == 1 || $status5 == 1 || $status6 == 1 || $status7 == 1 || $status8 == 1) {
        $icon = "<img src='".base_url()."assets/images/sad-face.png' class='iconSet'>";
        }else{
          $icon = "<img src='".base_url()."assets/images/happy-face.png' class='iconSet'>";
        }
      // set mother name
      if($getRegMotherData['Type'] == '1' || $getRegMotherData['Type'] == '3'){
          $bday = new DateTime($getRegMotherData['MotherDOB']);
          $date  = date("Y-m-d H:i:s");
          $today = new DateTime($date); // for testing purposes
          $diff = $today->diff($bday);

        if(!empty($getRegMotherData['MotherAge'])) {
         $motherAge = $getRegMotherData['MotherAge'];
        }else{
        // $motherAge = printf('%d years, %d month', $diff->y, $diff->m);
          $motherAge = "N/A";
        }
        $motherName = "<a href='".base_url()."motherM/viewMother/".$val['id']."'>".$getRegMotherData['MotherName']."</a>";
        $MotherMoblieNo = $getRegMotherData['MotherMoblieNo'];
      }else{
        $motherName     = "<a href='".base_url()."motherM/viewMother/".$val['id']."'>UNKNOWN</a>";
        $MotherMoblieNo = "--";
      }

    // set mother picture
     $motherPicture = empty($getRegMotherData['MotherPicture']) ? "<img  src='".base_url()."assets/images/user.png' class='img-responsive motherImage'>" : "<img  src='".base_url()."assets/images/".$getRegMotherData['MotherPicture']."' class='img-responsive motherImage'>";

    // set total babies of mother
      if($GetAllBaby == 0){
        $totalBabies = 0;
      }else{
        $totalBabies = "<a href='".base_url()."BabyManagenent/registeredBaby/".$val['MotherID']."'>".$GetAllBaby."</a>";
      }
    // set Hospital reg no  
      if(!empty($val['HospitalRegistrationNumber'])) {
        $HospitalNo = $val['HospitalRegistrationNumber'];
      }  else{ 
        $HospitalNo = '--';
       }
    // Last monitoring date
       $lastAssessment = ($get_last_assessment['add_date'] !='') ? date('d-m-Y g:i A',$get_last_assessment['add_date']) :'N/A';
    // set nurse data

       if($val['status'] == '2') {
         $getStaffName = $this->db->get_where('staff_master',array('StaffID'=>$val['DischargeByNurse']))->row_array();
         $nurseName = "<a href='".base_url()."staffM/updateStaff/".$val['DischargeByNurse']."'>".$getStaffName['Name']."</a>";
       }
        else if($val['status'] == '1'){
          $getCheckListData = $this->db->get_where('checklistmaster',array('mother_admissionID'=>$val['id']))->row_array();
          $getStaffName1 = $this->db->get_where('staff_master',array('StaffID'=>$getCheckListData['NurseId']))->row_array();
          $nurseName = "<a href='".base_url()."staffM/updateStaff/".$getCheckListData['NurseId']."'>".$getStaffName1['Name']."</a>";
        } 
// set mother status
         if($getRegMotherData['Type'] == '1') { 
             $status = '<span class="label label-success">Live</span>';
         } else if($getRegMotherData['Type'] == '2') { 
            $status =  '<span class="label label-warning">Unknown</span>';
           } else if($getRegMotherData['Type'] == '3') {
            $status =  '<span class="label label-danger">Died</span>';
         } 

     $getTotalBabys = '';
     foreach ($GetAllBabies as $key => $vals) {
            $this->db->order_by('id','desc');
            $getbabyAdmisionId = $this->db->get_where('baby_admission',array('BabyID'=>$vals['BabyID']))->row_array();
          $getTotalBabys = "<a href='".base_url()."babyM/viewBaby/".$getbabyAdmisionId['id']."/".$vals['status']."'><img src='".base_url()."assets/images/baby_images/".$vals['BabyPhoto']."' width='45' height='45' style='margin-bottom: 2px;'></a>";
    }

   // 
    $no++;
    $row    = array();
    $row[]  = $no;
    $row[]  = $motherPicture;
    $row[]  = $icon.' '.$motherName.' ('.$motherAge.')';
    $row[]  = "Total: ".$totalBabies."<br>".$getTotalBabys;
    $row[]  = $HospitalNo;
    $row[]  = $MotherMoblieNo;
    $row[]  = date('d-m-Y g:i A',$val['add_date']);
    $row[]  = $lastAssessment;
    $row[]  = $nurseName;
    $row[]  = $status;
    $data[] = $row;
   }
  $output  = array(
                  "draw"            => $_POST['draw'],
                  "recordsTotal"    => $this->MotherModel->count_all($loungeId),
                  "recordsFiltered" => $this->MotherModel->count_filtered($loungeId),
                  "data"            => $data,
                 );
    //output to json format
    echo json_encode($output);
}






    public function motherListViaAjax1() { 
      // $loungeId = $this->uri->segment('4');
      $loungeId = 1;
      ini_set("memory_limit",-1);
      $data = array();
      $output = array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $this->MotherModel->countPagingListWithMother($loungeId),//$iTotal,
        "iTotalDisplayRecords" => $this->search_mother_json(true,$loungeId),//$iFilteredTotal,
        "aData" => $this->search_mother_json(false,$loungeId)
      );
        
      echo json_encode($output);die;
      }

      public function search_mother_json($count,$loungeId){
      $data = array();
      $this->MotherModel->pagingWithMerchantList($loungeId);
      $aColumns = array(
        'ma.id', 
        'mr.MotherName',
        'mr.MotherDOB',
        'mr.MotherMoblieNo'
      );
      /* 
       * Paging
       */
      $sLimit = "";
      if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' && !$count)
      {
        $this->db->limit($_GET['iDisplayLength'],$_GET['iDisplayStart']);
      }

  
      /* 
       * Filtering
       * NOTE this does not match the built-in DataTables filtering which does it
       * word by word on any field. It's possible to do here, but concerned about efficiency
       * on very large tables, and MySQL's regex functionality is very limited
       */
      $sWhere = "";
      if ( $_GET['sSearch'] != "" )
      {
        // $sWhere = "WHERE (";
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
          // $this->db->where();
          $sWhere .= $aColumns[$i]." LIKE '%".$_GET['sSearch']."%' OR ";
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        // $sWhere .= ')';

        $this->db->where($sWhere);
      }
    

          if($count)
            return $this->MotherModel->countPagingListWithMother($loungeId);
        else 
        {
          $list = $this->MotherModel->pagingWithMerchantList($loungeId);
          
          $table = '';
          $status_div = "";
          $i = 0;
          $j = 1;
          $return_data = array();
          foreach($list as $row) {  

              $getRegMotherData     = $this->MotherModel->GetMotherType($row['MotherID']);
              $get_last_assessment  = $this->MotherModel->GetLastAsessmentBabyOrMother('mother_monitoring','MotherID',$row['MotherID'],$row['id']);
              $GetAllBaby           = $this->MotherModel->GetAllBabiesViaMother('babyRegistration',$row['MotherID']);
              $GetAllBabies         = $this->MotherModel->getMotherDataById('babyRegistration',$row['MotherID']);
                $status1 = 0;
                $status2 = 0;
                $status3 = 0;
                $status4 = 0;
                $status5 = 0;
                $status6 = 0;
                $status7 = 0;
                $status8 = 0;
                  if($get_last_assessment['MotherPulse'] < 50 || $get_last_assessment['MotherPulse'] > 120){
                   $status1 = '1';
                  }

                  if($get_last_assessment['MotherTemperature'] < 95.9 || $get_last_assessment['MotherTemperature'] > 99.5){
                   $status2 = '1';
                  }


                 if($get_last_assessment['MotherSystolicBP'] >= 140 || $get_last_assessment['MotherSystolicBP'] <= 90){
                   $status3 = '1';
                  }

                  if($get_last_assessment['MotherDiastolicBP'] <= 60 || $get_last_assessment['MotherDiastolicBP'] >= 90){
                   $status4 = '1';
                  }

                  if($get_last_assessment['MotherUterineTone'] == 'Hard/Collapsed (Contracted)'){
                   $status5 = '1';
                  }

                  if(!empty($get_last_assessment['EpisitomyCondition']) && $get_last_assessment['EpisitomyCondition'] == 'Infected'){
                   $status6 = '1';
                  }                                   

                  if(!empty($get_last_assessment['SanitoryPadStatus']) && $get_last_assessment['SanitoryPadStatus'] == "It's FULL"){
                   $status7 = '1';
                  }   

                  if(!empty($get_last_assessment['MotherBleedingStatus']) && $get_last_assessment['MotherBleedingStatus'] == "Yes"){
                   $status8 = '1';
                  } 
                  if($status1 == 1 || $status2 == 1 || $status3 == 1 || $status4 == 1 || $status5 == 1 || $status6 == 1 || $status7 == 1 || $status8 == 1) {
                  $icon = "<img src='".base_url()."assets/images/sad-face.png' class='iconSet'>";
                  }else{
                    $icon = "<img src='".base_url()."assets/images/happy-face.png' class='iconSet'>";
                  }
                // set mother name
                if($getRegMotherData['Type'] == '1' || $getRegMotherData['Type'] == '3'){
                    $bday = new DateTime($getRegMotherData['MotherDOB']);
                    $date  = date("Y-m-d H:i:s");
                    $today = new DateTime($date); // for testing purposes
                    $diff = $today->diff($bday);

                  if(!empty($getRegMotherData['MotherAge'])) {
                   $motherAge = $getRegMotherData['MotherAge'];
                  }else{
                  // $motherAge = printf('%d years, %d month', $diff->y, $diff->m);
                    $motherAge = "N/A";
                  }
                  $motherName = "<a href='".base_url()."motherM/viewMother/".$row['id']."'>".$getRegMotherData['MotherName']."</a>";
                  $MotherMoblieNo = $getRegMotherData['MotherMoblieNo'];
                }else{
                  $motherName     = "<a href='".base_url()."motherM/viewMother/".$row['id']."'>UNKNOWN</a>";
                  $MotherMoblieNo = "--";
                }

              // set mother picture
               $motherPicture = empty($getRegMotherData['MotherPicture']) ? "<img  src='".base_url()."assets/images/user.png' class='img-responsive motherImage'>" : "<img  src='".base_url()."assets/images/".$getRegMotherData['MotherPicture']."' class='img-responsive motherImage'>";

              // set total babies of mother
                if($GetAllBaby == 0){
                  $totalBabies = 0;
                }else{
                  $totalBabies = "<a href='".base_url()."BabyManagenent/registeredBaby/".$row['MotherID']."'>".$GetAllBaby."</a>";
                }
              // set Hospital reg no  
                if(!empty($val['HospitalRegistrationNumber'])) {
                  $HospitalNo = $val['HospitalRegistrationNumber'];
                }  else{ 
                  $HospitalNo = '--';
                 }
              // Last monitoring date
                 $lastAssessment = ($get_last_assessment['add_date'] !='') ? date('d-m-Y g:i A',$get_last_assessment['add_date']) :'N/A';
              // set nurse data

                 if($val['status'] == '2') {
                   $getStaffName = $this->db->get_where('staff_master',array('StaffID'=>$row['DischargeByNurse']))->row_array();
                   $nurseName = "<a href='".base_url()."staffM/updateStaff/".$row['DischargeByNurse']."'>".$getStaffName['Name']."</a>";
                 }
                  else if($val['status'] == '1'){
                    $getCheckListData = $this->db->get_where('checklistmaster',array('mother_admissionID'=>$val['id']))->row_array();
                    $getStaffName1 = $this->db->get_where('staff_master',array('StaffID'=>$getCheckListData['NurseId']))->row_array();
                    $nurseName = "<a href='".base_url()."staffM/updateStaff/".$getCheckListData['NurseId']."'>".$getStaffName1['Name']."</a>";
                  } 
          // set mother status
                   if($getRegMotherData['Type'] == '1') { 
                       $status = '<span class="label label-success">Live</span>';
                   } else if($getRegMotherData['Type'] == '2') { 
                      $status =  '<span class="label label-warning">Unknown</span>';
                     } else if($getRegMotherData['Type'] == '3') {
                      $status =  '<span class="label label-danger">Died</span>';
                   } 

               $getTotalBabys = '';
               foreach ($GetAllBabies as $key => $vals) {
                      $this->db->order_by('id','desc');
                      $getbabyAdmisionId = $this->db->get_where('baby_admission',array('BabyID'=>$vals['BabyID']))->row_array();
                    $getTotalBabys = "<a href='".base_url()."babyM/viewBaby/".$getbabyAdmisionId['id']."/".$vals['status']."'><img src='".base_url()."assets/images/baby_images/".$vals['BabyPhoto']."' width='45' height='45' style='margin-bottom: 2px;'></a>";
              }








          $return_data[$i]['id']                  = $j;
          $return_data[$i]['motherPhoto']         = $motherPicture;
/*          $return_data[$i]['motherName']          = $icon.' '.$motherName.' ('.$motherAge.')';
          $return_data[$i]['totalBaby']           = "Total: ".$totalBabies."<br>".$getTotalBabys;
          $return_data[$i]['regNumber']           = $HospitalNo;
          $return_data[$i]['mobileNumber']        = $MotherMoblieNo;
          $return_data[$i]['regTime']             = date('d-m-Y g:i A',$row['add_date']);
          $return_data[$i]['lastAssessmentTime']  = $lastAssessment;
          $return_data[$i]['nurseName']           = $nurseName;
          $return_data[$i]['status']              = $status;*/
          $i++;
          $j++;
        }
        //$return_data = $this->db->last_query();
        return $return_data;
        }
    }




}

                    {"mDataProp": "id", "sTitle": "S No."},
                {"mDataProp": "motherPhoto", "sTitle": "Mother Photo"},
                {"mDataProp": "motherName", "sTitle": "Mother Name(Age)"},
                {"mDataProp": "totalBaby", "sTitle": "Baby Info"},
                {"mDataProp": "regNumber", "sTitle": "Registration No."},
                {"mDataProp": "mobileNumber", "sTitle": "Mother Mobile No."},
                {"mDataProp": "regTime", "sTitle": "Reg. Date & Time"},
                {"mDataProp": "lastAssessmentTime", "sTitle": "Last Assessment"},
                {"mDataProp": "nurseName", "sTitle": "Nurse Name"},
                {"mDataProp": "status", "sTitle": "Status"},