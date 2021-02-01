<?php
function getAlertMessage($code){
    $codes = Array(
                '1' => 'Invalid Username/Email or Password.',
                '2' => 'A password reset link is sent to your email address.',
                '3' => 'This email address is not registered.',
                '4' => 'Please enter a valid email address.',
                '5' => 'Please fill up all fields.',
                '6' => 'Password doesn\'t match.',
                '7' => 'Password is same as previous one.',
                '8' => 'Logout successfully.',
                '9' => 'Select captcha.',
                '10' => 'Invalid captcha.',
                //Image Upload Alerts
                '101' => 'Please upload image only.',
                '102' => 'Please upload image with extensions .png, .jpg, .jpeg only.',
                '103' => 'Banner image is not uploaded.',
                '104' => 'Please upload image with desired dimesions.',
                '105' => 'Image Size must be less than 5MB.',
                '106' => 'Image is not uploaded.',
                '107' => 'Please enter a valid image name.',
                //Blabber Alerts
                '111' => 'Blabber has been uploaded successfully.',
                '112' => 'Blabber details have been updated successfully.',
                '113' => 'Your comment has been posted successfully.',
                '114' => 'Your comment has been posted for admin review. It will be displayed once approved.',
                //Video Upload
                '121' => 'Video has been uploaded successfully.',
                '122' => 'Video has been uploaded successfully.It will display once approved.',
                '123' => 'Video size is large.',
                '124' => 'Please enter a valid video file name.',
                '125' => 'Video is not uploaded.',
                '126' => 'Invalid YouTube Video Url.',
                '127' => 'Please upload video with extensions mp4, webm, ogg/ogv only.',
                '128' => 'Video details have been updated successfully.',
                '129' => 'Video size is large.',
                //Other Success Alerts
                '131' => 'All changes have been saved successfully.',
                //Event Alerts
                '132' => 'Event has been created successfully.',
                '133' => 'Event details have been updated successfully.',
                //CSV Upload
                '134' => 'Please upload a valid CSV File.',
                 //Category Message
                '135' => 'Category saved successfully.',
                //Superadmin Change Password
                '136' => 'Old password is not correct.',
                '137' => 'Confirm password is not mactch.',
                '138' => 'Change password successfully.',
                //Add/Manage Vendor
                '139' => 'Vendor added successfully and email sent to vendor with verification link.',
                '140' => 'Vendor not added.',
                '141' => 'Vendor email id already exists.',
                '142' => 'Vendor updated successfully.',
                 //Add/Manage Agent
                '143' => 'Agent added successfully and mail sent to agent with verification link.',
                '144' => 'Agent not added.',
                '145' => 'Agent email id already exists.',
                '146' => 'Agent updated successfully.',
                //Add/Message From Superadmin
                '147' => 'Message sent successfully.',
                '148' => 'Message not sent.',
                //Add activity
                '149' => 'Activity added successfully.',
                '150' => 'Activity updated successfully.',
                '151' => 'Operation head email id already exists.',
                '152' => 'operator added successfully and mail sent to agent with verification link.',
                '153' => 'operator updated successfully.',

            );

    return (isset($codes[$code])) ? $codes[$code] : '';
}

function getAlertBody($class, $message, $icon){
    $alert  =   '<div class="alert '.$class.' alert-dismissible mb-2" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
              <div class="d-flex align-items-center">
                <i class="bx '.$icon.'" aria-hidden="true"></i>
                <span>'.$message.'
                </span>
              </div>
            </div>';

    return $alert;
}

function generateAdminAlert($type, $messageCode){
    if($type == 'S'){
        $flash_msg = getAlertBody("border-success", getAlertMessage($messageCode), "bx-like");
    }elseif($type == 'I'){
        $flash_msg = getAlertBody("border-info", getAlertMessage($messageCode), "bx-error-circle");
    }elseif($type == 'W'){
        $flash_msg = getAlertBody("border-warning", getAlertMessage($messageCode), "bx-error-circle");
    }elseif($type == 'D'){
        $flash_msg = getAlertBody("border-danger", getAlertMessage($messageCode), "bx-error");
    }

    return $flash_msg;
}

function getCustomAlert($type, $message){
    if($type == 'S'){
        $flash_msg = getAlertBody("border-success", $message, "bx-like");
    }elseif($type == 'I'){
        $flash_msg = getAlertBody("border-info", $message, "bx-error-circle");
    }elseif($type == 'W'){
        $flash_msg = getAlertBody("border-warning", $message, "bx-error-circle");
    }elseif($type == 'D'){
        $flash_msg = getAlertBody("border-danger", $message, "bx-error");
    }

    return $flash_msg;
}
/* login/session methods */

// Check login status if already login redirect it to dashboard
function is_logged_in() {
    $obj =& get_instance();
    $adminData = $obj->session->userdata('adminData');
    if (!empty($adminData)) {
        redirect('admin/Dashboard/index');
    }
}
// Check login status if not login redirect it to login page
function is_not_logged_in() {
    $obj = & get_instance();
    $adminData = $obj->session->userdata('adminData');
   // print_r($adminData); exit;
    if (empty($adminData)) {
        redirect('admin/welcome');
    }
}
// GET the table data ,
function get_table_data($table='',$status='',$coulmn='',$id=''){
        $tableRecord =& get_instance();
        $tableRecord->load->database(); 
        $arr  = array();
        $data = "";
        if ($status == OK) {        
        $arr[STATUS] = $status; }
        if (!empty($id)) {
        $arr[$coulmn] = $id; 
        }
        $query = $tableRecord->db->get_where($table,$arr);
        if (!empty($result)) {
        return $query->row_array();
        }else{
        return $query->result_array();
        }
    }
    // INSER DATA IN DATABASE AFTER THAT GET DATA FROM THE TABLE
function update_data($table='',$array='',$column='',$columnValue=''){
         $tableRecord =& get_instance();
         $tableRecord->load->database();
         $tableRecord->db->where($column, $columnValue);
         $tableRecord->db->update($table ,$array);
         return $tableRecord->db->affected_rows();
}
//  Upload image code here
function upload_images($fileName='',$imageName=''){
    $image = '';
    $extension=explode('.',$fileName);
    $extension=strtolower(end($extension));
    $uniqueName= time().uniqid().$fileName.'.'.$extension;
    $type=$_FILES[$imageName]["type"];
    $size=$_FILES[$imageName]["size"];
    $tmp_name=$_FILES[$imageName]['tmp_name'];
    $targetlocation= IMAGE_DIRECTORY."/manage_theme/theme/".$uniqueName;
    if(!empty($fileName)){
    move_uploaded_file($tmp_name,$targetlocation);
    $image = utf8_encode(trim($uniqueName));
    }else{
    $image = null;
    }
    return $image;
}
 function generate_unique_transactionID(){
        return substr(str_shuffle("0123456789".time()),'0','14');   
    }
function sentEmailInfo($email,$smsmessage){
            // ++++++++++++++
          $to      = $email;
          $subject = "Freetads";
          $message ="Welcome to Nuw Nuk\r\n";
          $message.="\r\n";
          $message.="&nbsp;".$smsmessage."\r\n";
          $message .="Note - This is a System Generated Mail, please do not reply.\r\n";
          $headers = "From:"."noreply@gmail.com"."\r\n";
          $headers .= "MIME-Version: 1.0\r\n";
          $headers .= "Content-type: text/html; charset=utf-8\r\n";
          mail($to,$subject,'<pre style="font-size:14px;">'.$message.'</pre>',$headers);
         return 1;
  }
  function SendOtpSMS($requestMobile,$message){
    // echo $requestMobile;exit;
    $url = "http://www.wiztechsms.com/http-api.php?username=vishal&password=123@vishal&senderid=FRETAD&route=2&number=".$requestMobile."&message=".urlencode($message);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_exec($ch);
            return 1;
} 