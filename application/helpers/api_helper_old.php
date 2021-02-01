<?php   
/**
 * @param type $msg_code
 * @param type $res_code
 * @param type $message
 * Thsi Function is responsible for all type of messages 
 */    
   function singlerowparameter($select,$matchWith,$matchingId,$table)
   {
        $tableRecord = & get_instance();
        $tableRecord->load->database();     
        $tableRecord->db->select($select);  
        $query = $tableRecord->db->get_where($table,array($matchWith => $matchingId,'status' => 1))->row_array();   
        return $query[$select];       
   }


   function singlerowparameter2($select,$matchWith,$matchingId,$table)
   {
        $tableRecord = & get_instance();
        $tableRecord->load->database();     
        $tableRecord->db->select($select);  
        $query = $tableRecord->db->get_where($table,array($matchWith => $matchingId))->row_array();   
        return $query[$select];       
   }

   function allData($table,$matchWith,$matchingId)
   {
        $tableRecord = & get_instance();
        $tableRecord->load->database();  
        $tableRecord->db->order_by('id','DESC');
        return $tableRecord->db->get_where($table,array($matchWith => $matchingId, 'status' => 1))->result_array();
   }

    function allData2($table,$matchWith,$matchingId)
   {
        $tableRecord = & get_instance();
        $tableRecord->load->database();  
        $tableRecord->db->order_by('id','DESC');
        return $tableRecord->db->get_where($table,array($matchWith => $matchingId))->row_array();
   }


    function allData1($table)
   {
        $tableRecord = & get_instance();
        $tableRecord->load->database();  
        $tableRecord->db->order_by('id','DESC');
        return $tableRecord->db->get($table)->row_array();
   }

   function getCount($table,$type)
   {
        $tableRecord = & get_instance();
        $tableRecord->load->database();  
        return $tableRecord->db->get_where($table,array('user_type' => $type,'status' => 1))->num_rows();
   }

   function getCount12($table,$type)
   {
        $tableRecord = & get_instance();
        $tableRecord->load->database();  
        return $tableRecord->db->get_where($table,array('phone_no' => $type,'status' => 1))->num_rows();
   }


   function singleRowData($table,$matchWith,$matchingId)
   {
        $tableRecord = & get_instance();
        $tableRecord->load->database();  
        return $tableRecord->db->get_where($table,array($matchWith => $matchingId,'status' => 1))->row_array();
   }

    function user_last_seen_format($request_time){
        $time_middle = new DateTime($request_time, new DateTimeZone(date_default_timezone_get()));
        $time_middle->setTimeZone(new DateTimeZone($_COOKIE['og_timezone']));
        return $time_middle->format('Y-m-d H:i:s');
    }

    function generate_unique_code(){
        return 'usr_'.substr(str_shuffle("1234567890"),'0','9');    
    }



    function saveProfilesImage($base64)
    {

        $img = imagecreatefromstring(base64_decode($base64)); 
        if($img != false) 
        { 
            $imageName = time().'.jpg';
            $path = $_SERVER['DOCUMENT_ROOT'];        
            $path = $path.'/assets/profile_images/'.$imageName;
            if(imagejpeg($img, $path)) 
                return $imageName;                       
            else
                return 'default.png';
        } 
    }    

    function saveProfilesImage2($base64,$PROFILE_DIRECTORY)
    {

        $img = imagecreatefromstring(base64_decode($base64)); 
        if($img != false) 
        { 
            $imageName = time().'.jpg';
            $path = $_SERVER['DOCUMENT_ROOT'];        
            $path = $PROFILE_DIRECTORY.$imageName;
            if(imagejpeg($img, $path)) 
                return $imageName;                       
            else
                return 'default.png';
        } 
    }    

  
   function getaddress($lat,$lng)
      {
         $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&sensor=false';
         $json = @file_get_contents($url);
         $data=json_decode($json);
         $status = $data->status;
         if($status=="OK")
         {
           return $data->results[0]->formatted_address;
         }
         else
         {
           return false;
         }
      }
       
    function getLatLong($address)
    {
        //$address = "350 5th Ave, New York, NY 10118, United States";       
        $address = str_replace(" ", "+", $address);      
        $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=$address";         
        $response = file_get_contents($url);         
        $json = json_decode($response,TRUE);         
        return ($json['results'][0]['geometry']['location']['lat'].",".$json['results'][0]['geometry']['location']['lng']);
    }

    function distance($lat1, $lon1, $lat2, $lon2, $unit) {
        
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

   
function generateServerResponse($msg_code, $res_msg, $data='',$dynamicValue=''){
        
        $getDateTime = getDateAndIp();
        $array[APP_NAME] = array();
        $resultMsg = Messages($res_msg,$dynamicValue);
        $array[APP_NAME]["res_code"] = $msg_code;
        $array[APP_NAME]["res_msg"]  = $resultMsg;
        $array[APP_NAME]["sync_time"]= $getDateTime['date'];
         
             
        if(!empty($data)){
            foreach($data as $key=>$val){
                $array[APP_NAME][$key]  = $val;
            }
        }
        $str = json_encode($array, true);
        echo str_replace("null",'""', $str);
        exit;
    }

     
    function getDateAndIp(){
        $result = array();  
        $result['ip'] = $_SERVER['REMOTE_ADDR'];
        $result['date'] = time();
        $result['datetime'] = date('Y-m-d h:i:s');
        return $result ; 
    }
    
    
    function validateJson($requestJson, $check_request_keys){
        if($requestJson){
            $validate_keys      = array();
            
            foreach($requestJson[APP_NAME] as $key=>$val){
                $validate_keys[] = $key;
            }
            
            $result = array_diff($validate_keys,$check_request_keys);

            if($result){ 
                return "0";
            }else{
                return  "1";
            } 
        }else{
            return  "0";
        }          
    }
    
    
    function validateEmail($email,$msgCode, $msgType){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            generateServerResponse($msgCode,$msgType);
        }
    }
     
    
    function isBlank($fieldName, $msgCode, $msgType){
        if($fieldName == ''){
            generateServerResponse($msgCode, $msgType);
        }
    }
    function CheckStdCode($fieldName, $msgCode, $msgType){
        if($fieldName == ''){
            generateServerResponse($msgCode, $msgType);
        }
    }
    
    function checkLength($fieldName, $fieldLength,$msgCode, $msgType){
        $length =  strlen($fieldName);
        if($length > $fieldLength){
           generateServerResponse($msgCode, $msgType);
        }
    } 

    function CheckAmount($fieldName, $msgCode, $msgType){
        $length =  $fieldName;

        if($length < 10){
            generateServerResponse($msgCode, $msgType);
        }
        elseif($length > 1000){
            generateServerResponse($msgCode, $msgType);
        }
    } 
    
    function isAdhar($fieldName, $msgCode, $msgType){
        if(!ctype_digit($fieldName)){
          generateServerResponse($msgCode, $msgType);
        } 
    }
    function isAdharLength($adhar,$msgCode, $msgType)
    {
        if(strlen($adhar) != 12)
        {
            generateServerResponse($msgCode,$msgType);
        }
    }

    function isPhone($fieldName, $msgCode, $msgType){
        if(!ctype_digit($fieldName)){
          generateServerResponse($msgCode, $msgType);
        } 
    }

    function isCheckLength($variableLenght,$msgCode,$lenght,$msgType)
    {
        if(strlen($variableLenght) != $lenght)
        {
            generateServerResponse($msgCode,$msgType);
        }
    }


    
    function isDobBlank($fieldName, $msgCode, $msgType){
        if($fieldName == '' || $fieldName == '0000-00-00'){
            generateServerResponse($msgCode, $msgType);
        }
    }
    function isDobFormat($fieldName, $msgCode, $msgType){
        if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$fieldName)){
            generateServerResponse($msgCode, $msgType);
        }
    }
    
    function isFutureDate($fieldName, $msgCode, $msgType){
        if($fieldName < mktime()){
            generateServerResponse($msgCode, $msgType);
        }
    }
    
    function phoneLength($fieldName, $msgCode, $msgType){
        if(strlen($fieldName) != 10){
             generateServerResponse($msgCode, $msgType);
        }
    }

    function validStrLen($str, $min, $max){
        $len = strlen($str);
        if($len < $min){
            return "Field Name is too short";
        }
        elseif($len > $max){
            return "Field Name is too long";
        }
        return TRUE;
    }
    
    function phoneMinLength($fieldName, $msgCode, $msgType){
        if(strlen($fieldName) < 9){
             generateServerResponse($msgCode, $msgType);
        }
    }
    function phoneMaxLength($fieldName, $msgCode, $msgType){
        if(strlen($fieldName) >= 15){
             generateServerResponse($msgCode, $msgType);
        }
    }   
    function phoneMaxLength2($fieldName, $msgCode, $msgType){
        if(strlen($fieldName) > 10){
             generateServerResponse($msgCode, $msgType);
        }
    }   
    
    function Messages($res_msg='',$dynamicValue=''){
        $codes = Array(
                        '101' => 'Invalid Json.',                    
                        '102' => 'No data available',                       
                        '103' => 'Lounge List', 
                        '104' => 'Please enter user id',                  
                        '105' => 'Please enter phone number',
                        '106' => 'Invalid phone number',
                        '107' => 'Invalid phone number lenght',                   
                        '108' => 'Invalid email id',
                        '109' => 'Please enter password',
                        '110' => 'No banner available',
                        '111' => 'Banner available',
                        '112' => 'No deal of the day available',
                        '113' => 'Data available',
                        '114' => 'Please enter sub category id',
                        '115' => 'No more data available',
                        '116' => 'Please enter product id',
                        '117' => 'Product not available',
                        '118' => 'Product available',
                        '119' => 'Please enter product quantity',
                        '120' => 'This Product already added to cart',
                        '121' => 'Product successfully add to cart',
                        '122' => 'Oops something went wrong please try again later',
                        '123' => 'Your cart is empty',
                        '124' => 'Product not added in cart',
                        '125' => 'Product successfully deleted from cart',
                        '126' => 'Please enter cart id',
                        '127' => 'Otp sent on your mobile no',
                        '128' => 'Your number has been blocked. Please contact to customer care soon',
                        '129' => 'Please enter otp',
                        '130' => 'Invalid otp',
                        '131' => 'Please enter device id',
                        '132' => 'Please enter fcm id',
                        '133' => 'Invalid coupon code',
                        '134' => 'Coupon code expired',
                        '135' => 'Please enter coupon code',
                        '136' => 'Please enter final price',
                        '137' => 'Coupon code applied successfully',
                        '138' => 'Please enter user name',                  
                        '139' => 'Please enter phone number',                  
                        '140' => 'Please enter pincode',                  
                        '141' => 'Please enter locality',                  
                        '142' => 'Please enter area streat address',                  
                        '143' => 'Please enter district city town',                  
                        '144' => 'Please enter state master id',                  
                        '145' => 'Please enter address type',                  
                        '146' => 'Address added successfully',                  
                        '147' => 'Please enter address master id',                  
                        '148' => 'Please enter discount type',                  
                        '149' => 'Please enter final price',                  
                        '150' => 'Please enter quantity',                  
                        '151' => 'Your order booked successfully',                  
                        '152' => 'Product quantity should be less than available quantity ('.$dynamicValue.')',                  
                        '153' => 'Address update successfully',                  
                        '154' => 'Address deleted successfully',                  
                        '155' => 'Product quantity available',
                        '156' => 'Please enter quantity',
                        '157' => 'Product quantity update successfully',
                        '158' => 'No address available',
                        '159' => 'Address available',
                        '160' => 'Please enter payment type',
                        '161' => 'Coupon not applicable',           
                        '162' => 'Wishlist update successfully',
                        '163' => 'Your account has been blocked. Please contact customer care soon',
                        '164' => 'Order history available',
                        '165' => 'Please enter order id',
                        '166' => 'Invalid order id',
                        '167' => 'No product available',
                        '168' => 'Product Canceled',
                        '169' => 'Order Already Cancel',
                        '170' => 'Setting Details',
                        '171' => 'User Profile Updated Successfully',
                        '172' => 'Email-id cannot be empty',
                        '173' => 'Mobile number cannot be empty',
                        '174' => 'Invalid Email-id',
                        '175' => 'Phone number already exist',
                        '176' => 'Mobile/DTH number cannot be empty',
                        '177' => 'Please enter recharge amount',
                        '178' => 'Please select recharge type',
                        '179' => 'Transaction Detail',
                        '180' => 'Transaction history',
                        '181' => 'Please select Prepaid or Postpaid Type',
                        '182' => 'Transaction Status',
                        '183' => 'Transaction Id does not exist',
                        '184' => 'Phone number Must be 10 digit only',
                        '185' => 'Please Enter Number Only.',
                        '186' => 'Recharge amount must between 10 to 1000.',
                        '187' => 'Invalid Transaction Id',
                        '189' => 'Wallet cannot be empty',
                        '190' => 'Payment-Status successfully changed',
                        '191' => 'Please Enter Insurance Amount',
                        '192' => 'Please Enter Insurance Policy Number',
                        '193' => 'Please Enter Your Date Of Birth',
                        '194' => 'School cannot be empty',
                        '195' => 'School branch cannot be empty',
                        '196' => 'Student name cannot be empty',
                        '197' => 'Student roll no. cannot be empty',    
                        '198' => 'Student batch cannot be empty',
                        '199' => 'Fee start date cannot be empty',
                        '200' => 'Fee end date cannot be empty',
                        '201' => 'Student class cannot be empty',
                        '202' => 'Fees cannot be empty',
                        '203' => 'School Detail',
                        '204' => 'Referel Paid',
                        '205' => 'Referel Already Paid',        
                        '206' => 'Normal Registeration',
                        '207' => 'Fcm Update',
                        '208' => 'School & Branch',      
                        '209' => 'Payment Failed ',      

                        
                        'E' =>   'Data Not Found',
                        'W' =>   'Something Went Wrong',
                        'S' =>    'Success',
                        'F' =>    'Fail',
                        'P' =>    'Pending',
                        'R' =>    'Refund'


                        


                      );

        return (isset($codes[$res_msg])) ? $codes[$res_msg] : '';        
    }


    

    function GetAllData($table,$orderBy_id,$orderBy_AscDesc)
    {
        $tableRecord = & get_instance();
        $tableRecord->load->database();  
        $tableRecord->db->order_by($orderBy_id,$orderBy_AscDesc);
        return $tableRecord->db->get_where($table, array('status' => 1))->result_array();
    }
/* Sign up for an account.*/