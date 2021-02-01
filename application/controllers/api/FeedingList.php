<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class FeedingList extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this
            ->load
            ->model('api/BabyModel');

    }

    public function index()
    {
        $requestData = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson = json_decode($requestData, true);

        $data['babyId'] = trim($requestJson[APP_NAME]['babyId']);
        $data['loungeId'] = trim($requestJson[APP_NAME]['loungeId']);
        $data['date'] = trim($requestJson[APP_NAME]['date']);
        $data['userType'] = trim($requestJson[APP_NAME]['userType']);

        $checkRequestKeys = array(
            '0' => 'babyId',
            '1' => 'loungeId',
            '2' => 'date',
            '3' => 'userType'
        );

        $resultJson = validateJson($requestJson, $checkRequestKeys);

        // for header security
        $headers = apache_request_headers();
        $loungeData = tokenVerification($data['userType'], $data['loungeId']);

        $getLoungeData = $loungeData->row_array();
        if ($loungeData->num_rows() != 0)
        {
            if (!empty($headers['token']) && !empty($headers['package']))
            {
                if (($headers['token'] == $getLoungeData['token']) && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
                {
                    if ($resultJson == 1)
                    {
                        $array = array();
                        $response = array();
                        $startDate = ($data['date'] != '') ? strtotime($data['date']) : strtotime(date('d M y 00:00:00'));
                        $endDate = ($data['date'] != '') ? strtotime($data['date'] . ' 23:59:59') : strtotime(date('d M y 23:59:59'));
                        $breastFeedingList = $this
                            ->BabyModel
                            ->breastFeedingList($data, $startDate, $endDate);
                        /* where data not found */

                        /* end when data not found */
                        $totalduration = 0;
                        $breastFeedingList = 0;
                        $getBabyDeliveryDate = getSingleRow('deliveryDate', 'babyId', $data['babyId'], 'babyRegistration');
                        $currentWeigth = getLastEnteredData('babyWeight', 'babyId', $data['babyId'], 'babyDailyWeight');
                        $numberOfdays = getDateDifferenceWithCurrent(strtotime($getBabyDeliveryDate));

                        if (($currentWeigth < 1500) && ($numberOfdays < 6))
                        {
                            $requriedMilk = (($currentWeigth / 1000) * (80 + $numberOfdays * 15)) / 2;
                        }
                        else if (($currentWeigth >= 1500) && ($numberOfdays < 7))
                        {
                            $requriedMilk = (($currentWeigth / 1000) * (60 + $numberOfdays * 15)) / 2;
                        }
                        else
                        {
                            $requriedMilk = (($currentWeigth / 1000) * 150) / 2;
                        }

                        if ($breastFeedingList != 0)
                        {
                            $array = array();
                            //  Feeding Detail of  The Date
                            foreach ($breastFeedingList as $key => $value)
                            {
                                $totalduration = $totalduration + $value['breastFeedDuration'];
                                $milkQuantity = $milkQuantity + $value['milkQuantity'];
                                $Hold['breastFeedMethod'] = $value['breastFeedMethod'];
                                $Hold['breastFeedDuration'] = $value['breastFeedDuration'];
                                $Hold['milkQuantity'] = $value['milkQuantity'];
                                $Hold['feedTime'] = date('h:i A', strtotime($value['feedTime']));
                                $array[] = $Hold;
                            }

                            $response['feedingList'] = $array;
                        }

                        $response['direct'] = $this->checkUniqueValue($data, '1');
                        $response['expressed'] = $this->checkUniqueValue($data, '2');
                        $response['other'] = $this->checkUniqueValue($data, '3');
                        $response['milkQuantityRequired'] = floor($requriedMilk);
                        $response['date'] = date('d M y ', $startDate);
                        $response['totalduration'] = $totalduration;
                        $response['milkQuantity'] = $milkQuantity;
                        $response['feedingList'] = $array;
                        $response['md5Data'] = md5(json_encode($response['feedingList']));

                        if (count($response['feedingList']) > 0)
                        {
                            generateServerResponse('1', 'S', $response);

                        }
                        else
                        {
                            generateServerResponse('0', 'E', $response);
                        }
                    }
                    else
                    {
                        generateServerResponse('0', '101');
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
        else
        {
            generateServerResponse('0', '211');
        }

    }

    public function checkUniqueValue($data = '', $type = '')
    {
        return $this
            ->db
            ->get_where('babyDailyNutrition', array(
            'babyId' => $data['babyId'],
            'loungeId' => $data['loungeId'],
            'feedingType' => $type,
            'feedDate' => date('Y-m-d')
        ))->num_rows();
    }

}

