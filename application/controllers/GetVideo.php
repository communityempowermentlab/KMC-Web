<?php if (!defined('BASEPATH'))exit('No direct script access allowed');
class GetVideo extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/api_model');
      
    }
    public function index()
    {
    	$videos = $this->db->get_where('counsellingMaster', array('status' =>'1'))->result_array();
        $arrayName = array();
        foreach ($videos as $key => $value) {
            $Hold['video_id']      = $value['ID'];
            $Hold['video_type']	   = $value['VideoType'];
            $Hold['video_title']   = $value['VideoTitle'];
            $Hold['video_name']    = VIDEO_URL.$value['VideoName'];
            $arrayName[] = $Hold;
        }
            $response['videos'] = $arrayName;
        if(count($response['videos']) > 0)
        {
           generateServerResponse('1','S', $response);
        }else{
            generateServerResponse('0','W');
        }
    }
}       