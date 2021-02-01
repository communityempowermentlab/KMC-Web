<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class KMCListing extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/BabyModel');
    }
    public function index()
    {
        $requestData       = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true);

        $data['babyId']     = trim($requestJson[APP_NAME]['babyId']);   
        $data['loungeId']   = trim($requestJson[APP_NAME]['loungeId']);
        $data['date']       = trim($requestJson[APP_NAME]['date']);
        $data['userType']   = trim($requestJson[APP_NAME]['userType']);
        
        $checkRequestKeys = array(                
                                '0' => 'babyId',
                                '1' => 'loungeId',
                                '2' => 'date',
                                '3' => 'userType'
                            );

        $resultJson = validateJson($requestJson, $checkRequestKeys);

        // for header security 
        $headers    = apache_request_headers();
        $loungeData = tokenVerification($data['userType'],$data['loungeId']);

        $getLoungeData = $loungeData->row_array(); 
            if($loungeData->num_rows() != 0)
            {
              if(!empty($headers['token']) && !empty($headers['package']))
              {
                if(($headers['token'] == $getLoungeData['token']) && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
                {
                    if ($resultJson == 1) {
                       $array = array();
                       $startDate = ($data['date']!='') ? date("Y-m-d",strtotime($data['date'])) : date('Y-m-d');
                       $KMCListing = $this->BabyModel->KMCListing($data,$startDate);
                                         
                            if($KMCListing != 0){
                                $array = array();
                                foreach($KMCListing as $key => $value){

                                    $duration[]         = getTimeDiff($value['startTime'],$value['endTime']);
                                    $Hold['id']         = $value['id'];
                                    $Hold['startTime']  = date('h:i A',strtotime($value['startTime']));
                                    $Hold['endTime']    = date('h:i A',strtotime($value['endTime']));
                                    $Hold['provider']   = $value['provider'];
                                    $Hold['startDate']  = $value['startDate'];
                                    $Hold['duration']   = getTimeDiff($value['startTime'],$value['endTime']);
                                    $array[]      = $Hold;
                                }
                                
                                $response['date'] =  $startDate;
                                $response['totalDuartion'] = $this->totalDuration($duration);
                                $response['kmcListing'] = $array; 
                                $response['md5Data'] = md5(json_encode($response['kmcListing']));  
                                if(count($response['kmcListing'])>0)
                                {  
                                    generateServerResponse('1','S', $response);
                                }else{
                                    generateServerResponse('0','E');
                                }
                            }else{
                                generateServerResponse('0','W');
                            }
                    }else{
                        generateServerResponse('0','101');              
                    }
                }else{
                   generateServerResponse('0','210');
                }  
            }else{
                generateServerResponse('0','W');
              }  
        }else{
            generateServerResponse('0','211');        
              }   
         
    }

    public function totalDuration($times) 
    {
        $minutes = 0; //declare minutes either it gives Notice: Undefined variable
        // loop throught all the times
            foreach ($times as $time) {
                list($hour, $minute) = explode(':', $time);
                $minutes += $hour * 60;
                $minutes += $minute;
            }
        $hours = floor($minutes / 60);
        $minutes -= $hours * 60;

        // returns the time already formatted
        return sprintf('%02d:%02d', $hours, $minutes);
    }


    public function getTimeDiff($startTime,$endTime)
    {
            $Hours = floor((strtotime($endTime) - strtotime($startTime))/60); 
            $d = floor ($Hours / 1440);
            $h = floor (($Hours - $d * 1440) / 60);
            $m = $Hours - ($d * 1440) - ($h * 60);
            return  $h.':'.$m;    
    }

     public function datediff( $date1, $date2 )
        {
            $diff   = date_diff( $date1, $date2 );
            return sprintf
            (
                " %d Hours, %d Mins, %d Seconds",
                
                intval( ( $diff % 86400 ) / 3600),
                intval( ( $diff / 60 ) % 60 ),
                intval( $diff % 60 )
            );
        }
}

