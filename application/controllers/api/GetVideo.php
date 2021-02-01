<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//header("Content-type: application/json");
class GetVideo extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this
            ->load
            ->model('api/ApiModel');

    }
    public function index()
    {
        $headers = apache_request_headers();
        if (!empty($headers['package']))
        {
            if ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE)))
            {
                $videos = $this
                    ->db
                    ->get_where('counsellingMaster', array(
                    'status' => '1'
                ))
                    ->result_array();
                $arrayName = array();
                foreach ($videos as $key => $value)
                {
                    $Hold['id'] = $value['id'];
                    $Hold['videoType'] = $value['videoType'];
                    $Hold['videoTitle'] = $value['videoTitle'];
                    $Hold['videoName'] = videoDirectoryUrl . $value['videoName'];
                    $Hold['modifyDate'] = $value['modifyDate'];
                    $arrayName[] = $Hold;
                }
                $response['videos'] = $arrayName;
                if (count($response['videos']) > 0)
                {
                    $response['md5Data'] = md5(json_encode($response['videos']));
                    generateServerResponse('1', 'S', $response);
                }
                else
                {
                    generateServerResponse('0', 'W');
                }
            }
            else
            {
                generateServerResponse('0', '210');
            }
        }
        else
        {
            generateServerResponse('0', 'W');
        }
    }
}

