<?php
class MotherModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this
            ->load
            ->database();
            date_default_timezone_set("Asia/KolKata");
    }

    public function GetMotherDetail($request)
    {
        $coachId    = $request['coachId'];
        $loungeId   = $request['loungeId'];

        $coachData = $this
            ->db
            ->get_where('coachDistrictFacilityLounge', array(
            'masterId' => $coachId,
            'loungeId' => $loungeId,
            'status' => '1'
        ));

        if ($coachData->num_rows() != 0)
        {

            $this
            ->db
            ->order_by('id', 'desc');
            $motherAdmisionLastId = $this
            ->db
            ->get_where('motherAdmission', array(
                'motherId' => $request['motherId']
            ))->row_array();

            return $this
            ->db
            ->query("SELECT MM.*, `staffMaster`.name as staffName FROM motherMonitoring as MM INNER join motherAdmission as MA  on MA.`id` = MM.`motherAdmissionId` INNER Join `staffMaster` on `staffMaster`.staffId = `MM`.staffId  where   MA.`motherId` ='" . $request['motherId'] . "' AND MM.`motherAdmissionId` ='" . $motherAdmisionLastId['id'] . "' Order By MM.`id` DESC limit 0,1 ")->result_array();
            // print_r($get);exit();
            //echo $this->db->last_query();exit;
        } else 
        {
            generateServerResponse('0','L');
        }
        
    }

    public function CheckExistRegInMotherAdmision($HospitalReg, $loungeId)
    {

        return $this
            ->db
            ->get_where('motherAdmission', array(
            'hospitalRegistrationNumber' => $HospitalReg,
            'loungeId' => $loungeId
        ))->num_rows();
    }

    public function checkHospitalRegistrationNumber($HospitalReg, $loungeId = '', $id = '')
    {
        if ($id != '')
        {
            return $this
                ->db
                ->get_where('babyAdmission', array(
                'babyFileId' => $HospitalReg,
                'motherId !=' => $id,
                'loungeId' => $loungeId
            ))->num_rows();
        }
        else
        {
            return $this
                ->db
                ->get_where('babyAdmission', array(
                'babyFileId' => $HospitalReg,
                'loungeId' => $loungeId
            ))->num_rows();
        }
    }

    public function CheckHospitalNumUnik($HospitalRegNo, $motherId = '', $loungeId)
    {

        $res = $this
            ->db
            ->query("select BA.*,BR.* from babyAdmission as BA inner join babyRegistration as BR on BA.`babyId` = BR.`babyId` where BR.`motherId` = '" . $motherId . "' and BA.`loungeId` ='" . $loungeId . "' and BA.`babyFileId` = '" . $HospitalRegNo . "'")->num_rows();
        if ($res > 0)
        {
            return 0;
        }
        else
        {
            $res1 = $this
                ->db
                ->query("select BA.*,BR.* from babyAdmission as BA inner join babyRegistration as BR on BA.`babyId` = BR.`babyId` where BR.`motherId` = '" . $motherId . "' and BA.`loungeId` ='" . $loungeId . "'")->num_rows();
            if ($res1 > 0)
            {
                $res2 = $this
                    ->db
                    ->query("select BA.*,BR.* from babyAdmission as BA inner join babyRegistration as BR on BA.`babyId` = BR.`babyId` where BA.`babyFileId` = '" . $HospitalRegNo . "' and BA.`loungeId` ='" . $loungeId . "'")->num_rows();
                if ($res2 > 0)
                {
                    return 1;
                }
                else
                {
                    return 0;
                }
            }
            else
            {
                return 0;
            }
        }
    }

    public function deliveryType($motherId)
    {
        $GetData = $this
            ->db
            ->query(" SELECT BR.`babyId`, BR.`deliveryType`,BA.`status` FROM motherRegistration AS MR LEFT JOIN babyRegistration AS BR on MR.`motherId` = BR.`motherId` LEFT JOIN babyAdmission AS BA on BR.`babyId` = BA.`babyId` where MR.`motherId` = '" . $motherId . "'  AND BA.`status` = '1' ")->result_array();

        /*echo $this->db->last_query(); exit;*/

        $i = '0';

        foreach ($GetData as $key => $value)
        {

            if ($value['deliveryType'] == 'Assisted - Forceps' || $value['deliveryType'] == 'Normal with Episiotomy')
            {
                $i = '1';
                break;
            }
            else
            {
                $i = '0';
            }
            //$
            
        }
        return $i;
    }

    public function motherRegistration($request)
    {
        // check duplicateData
        $existData = $this
            ->db
            ->get_where('motherRegistration', array(
            'androidUuid' => $request['localId']
        ))->num_rows();

        if ($existData > 0)
        {
            generateServerResponse('0', '213');
        }

        $arrayName = array();
        $deliveryPlace = '';
        $arrayName['motherName'] = ($request['motherName'] != '') ? $request['motherName'] : NULL;
        $arrayName['isMotherAdmitted'] = ($request['isMotherAdmitted'] != '') ? $request['isMotherAdmitted'] : NULL;
        $arrayName['loungeId'] = ($request['loungeId'] != '') ? $request['loungeId'] : NULL;

        if ($request['isMotherAdmitted'] == 'Yes' || $request['isMotherAdmitted'] == 'yes')
        {
            $arrayName['motherPicture'] = ($request['motherPicture']) ? saveDynamicImage($request['motherPicture'], motherDirectory) : NULL;
        }
        else
        {
            $arrayName['notAdmittedreason'] = ($request['notAdmittedreason'] != '') ? $request['notAdmittedreason'] : NULL;
        }

        if ($request['facilityId'] != NULL && $request['facilityId'] != 0)
        {

            $deliveryPlace = getSingleRowFromTable('FacilityName', 'facilityId', $request['facilityId'], 'facilitylist');
        }
        else
        {
            $deliveryPlace = ucwords($request['deliveryPlace']);
        }

        $arrayName['androidUuid'] = ($request['localId'] != '') ? $request['localId'] : NULL;
        $arrayName['sameAddress'] = ($request['sameAddress'] != '') ? $request['sameAddress'] : NULL;
        $arrayName['motherMCTSNumber'] = ($request['motherMCTSNumber'] != '') ? $request['motherMCTSNumber'] : NULL;
        $arrayName['motherAadharNumber'] = ($request['motherAadharNumber'] != '') ? $request['motherAadharNumber'] : NULL;
        $arrayName['motherDOB'] = ($request['motherDOB'] != '') ? $request['motherDOB'] : NULL;
        $arrayName['motherEducation'] = ($request['motherEducation'] != '') ? $request['motherEducation'] : NUll;
        $arrayName['motherAge'] = ($request['motherAge'] != '') ? $request['motherAge'] : NULL;
        $arrayName['motherMobileNumber'] = ($request['motherMobileNumber'] != '') ? $request['motherMobileNumber'] : NULL;
        $arrayName['motherCaste'] = ($request['motherCaste'] != '') ? $request['motherCaste'] : NULL;
        $arrayName['fatherName'] = ($request['fatherName'] != '') ? $request['fatherName'] : NULL;
        $arrayName['fatherAadharNumber'] = ($request['fatherAadharNumber'] != '') ? $request['fatherAadharNumber'] : NULL;
        $arrayName['fatherMobileNumber'] = ($request['fatherMobileNumber'] != '') ? $request['fatherMobileNumber'] : NULL;
        $arrayName['rationCardType'] = ($request['rationCardType'] != '') ? $request['rationCardType'] : NULL;
        $arrayName['guardianName'] = ($request['guardianName'] != '') ? $request['guardianName'] : NULL;
        $arrayName['guardianNumber'] = ($request['guardianNumber'] != '') ? $request['guardianNumber'] : NULL;
        $arrayName['presentResidenceType'] = ($request['presentResidenceType'] != '') ? $request['presentResidenceType'] : NULL;
        $arrayName['presentAddress'] = ($request['presentAddress'] != '') ? $request['presentAddress'] : NULL;

        $arrayName['presentVillageName'] = ($request['presentVillageName'] != '') ? $request['presentVillageName'] : NULL;
        $arrayName['presentBlockName'] = ($request['presentBlockName'] != '') ? $request['presentBlockName'] : NULL;
        $arrayName['presentDistrictName'] = ($request['presentDistrictName'] != '') ? $request['presentDistrictName'] : NULL;

        $arrayName['permanentResidenceType'] = ($request['permanentResidenceType'] != '') ? $request['permanentResidenceType'] : NULL;

        $arrayName['permanentAddress'] = ($request['permanentAddress'] != '') ? $request['permanentAddress'] : NULL;

        $arrayName['permanentVillageName'] = ($request['permanentVillageName'] != '') ? $request['permanentVillageName'] : NULL;
        $arrayName['permanentBlockName'] = ($request['permanentBlockName'] != '') ? $request['permanentBlockName'] : NULL;
        $arrayName['permanentDistrictName'] = ($request['permanentDistrictName'] != '') ? $request['permanentDistrictName'] : NULL;

        $arrayName['presentAddNearByLocation'] = ($request['presentAddNearByLocation'] != '') ? $request['presentAddNearByLocation'] : NULL;
        $arrayName['permanentAddNearByLocation'] = ($request['permanentAddNearByLocation'] != '') ? $request['permanentAddNearByLocation'] : NULL;

        $arrayName['presentCountry'] = ($request['presentCountry'] != '') ? $request['presentCountry'] : NULL;
        $arrayName['presentState'] = ($request['presentState'] != '') ? $request['presentState'] : NULL;
        $arrayName['permanentCountry'] = ($request['permanentCountry'] != '') ? $request['permanentCountry'] : NULL;
        $arrayName['permanentState'] = ($request['permanentState'] != '') ? $request['permanentState'] : NULL;

        $arrayName['permanentPinCode'] = ($request['permanentPinCode'] != '') ? $request['permanentPinCode'] : NULL;
        $arrayName['presentPinCode'] = ($request['presentPinCode'] != '') ? $request['presentPinCode'] : NULL;

        $arrayName['staffId'] = ($request['staffId'] != '') ? $request['staffId'] : NULL;

        $arrayName['para'] = ($request['para'] != '') ? $request['para'] : NULL;
        $arrayName['live'] = ($request['live'] != '') ? $request['live'] : NULL;
        $arrayName['abortion'] = ($request['abortion'] != '') ? $request['abortion'] : NULL;
        $arrayName['gravida'] = ($request['gravida'] != '') ? $request['gravida'] : NULL;

        $arrayName['multipleBirth'] = ($request['multipleBirth'] != '') ? $request['multipleBirth'] : NULL;

        $arrayName['ashaId'] = ($request['ashaId'] != '') ? $request['ashaId'] : NULL;

        if (($arrayName['ashaId'] != '') && ($arrayName['ashaId'] != '0'))
        {
            $ashaNumber = getSingleRowFromTable('ashaMobileNumber1', 'ashaId', $arrayName['ashaId'], 'ashaProfiling');
            $ashaName = getSingleRowFromTable('ashaName', 'ashaId', $arrayName['ashaId'], 'ashaProfiling');
            $arrayName['ashaName'] = ($ashaName != '') ? $ashaName : NULL;
            $arrayName['ashaNumber'] = ($ashaNumber != '') ? $ashaNumber : NULL;
        }
        else
        {

            $arrayName['ashaName'] = ($request['ashaName'] != '') ? $request['ashaName'] : NULL;
            $arrayName['ashaNumber'] = ($request['ashaNumber'] != '') ? $request['ashaNumber'] : NULL;
        }

        $arrayName['motherReligion'] = ($request['motherReligion'] != '') ? $request['motherReligion'] : NULL;

        $arrayName['motherLmpDate'] = ($request['motherLmpDate'] != '') ? $request['motherLmpDate'] : NULL;
        $arrayName['deliveryPlace'] = ($deliveryPlace != '') ? $deliveryPlace : NULL;
        $arrayName['deliveryDistrict'] = ($request['deliveryDistrict'] != '' && $request['deliveryDistrict'] != 0) ? $request['deliveryDistrict'] : NULL;
        $arrayName['guardianRelation'] = ($request['guardianRelation'] != '') ? $request['guardianRelation'] : NULL;
        $arrayName['deliveryFacilityId'] = ($request['facilityId'] != '') ? $request['facilityId'] : NULL;
        $arrayName['type'] = ($request['type'] != '') ? $request['type'] : NULL;
        $arrayName['motherWeight'] = ($request['motherWeight'] != '') ? $request['motherWeight'] : NULL;
        $arrayName['ageAtMarriage'] = ($request['ageAtMarriage'] != '') ? $request['ageAtMarriage'] : NULL;
        $arrayName['birthSpacing'] = ($request['birthSpacing'] != '') ? $request['birthSpacing'] : NULL;
        $arrayName['consanguinity'] = ($request['consanguinity'] != '') ? $request['consanguinity'] : NULL;
        $arrayName['estimatedDateOfDelivery'] = ($request['estimatedDateOfDelivery'] != '') ? $request['estimatedDateOfDelivery'] : NULL;

        if ($arrayName['type'] == '3')
        {
            $arrayName['isMotherAdmitted'] = NULL;
            $arrayName['notAdmittedreason'] = NULL;
        }

        $arrayName['status'] = '1';
        $arrayName['addDate'] = date('Y-m-d H:i:s');
        $arrayName['modifyDate'] = date('Y-m-d H:i:s');

        $resultArray = isBlankOrNull($arrayName);
        $inserted = $this
            ->db
            ->insert('motherRegistration', $resultArray);
        $motherId = $this
            ->db
            ->insert_id();
        $array = array();
        $array['motherId'] = $motherId;

        $mother = array();
        $mother['motherId'] = $motherId;
        $mother['loungeId'] = ($request['loungeId'] != '') ? $request['loungeId'] : NULL;
        $mother['loungeId'] = ($request['loungeId'] != '') ? $request['loungeId'] : NULL;
        $loungeData = $this
            ->db
            ->get_where('loungeMaster', array(
            'loungeId' => $request['loungeId']
        ))->row_array();

        // type 1= SNCU, 2= Lounges
        if ($loungeData['type'] == 1)
        {
            $mother['hospitalRegistrationNumber'] = NULL ;
            $mother['temporaryFileId'] = ($request['temporaryFileId'] != '') ? $request['temporaryFileId'] : NULL;
        }
        else
        {
            $mother['temporaryFileId'] =  NULL ;
            $mother['hospitalRegistrationNumber'] = ($request['hospitalRegistrationNumber'] != '') ? $request['hospitalRegistrationNumber'] : NULL;
        }

        $mother['addDate'] = date('Y-m-d H:i:s');
        $mother['modifyDate'] = date('Y-m-d H:i:s');

        $mother_addmission = $this
            ->db
            ->insert('motherAdmission', $mother);

        $array['motherAdmissionId'] = $this
            ->db
            ->insert_id();

        return $array;
    }

    //Update Mother Details
    public function updateMotherRecord($request)
    {   

        $registrationData = $this
            ->db
            ->get_where('motherRegistration', array(
            'motherId' => $request['motherId']
        ))->row_array();

        $arrayName = array();
        $deliveryPlace = '';
        $arrayName['motherName'] = ($request['motherName'] != '') ? $request['motherName'] : NULL;
        $arrayName['isMotherAdmitted'] = ($request['isMotherAdmitted'] != '') ? $request['isMotherAdmitted'] : NULL;

        if ($request['isMotherAdmitted'] == 'Yes' || $request['isMotherAdmitted'] == 'yes')
        {   
            if($request['motherPicture'] != '') {
                if ((strrchr($request['motherPicture'], '.png') != True) && (strrchr($request['motherPicture'], '.jpg') != True))
                {
                    $arrayName['motherPicture'] = ($request['motherPicture'] != '') ? saveDynamicImage($request['motherPicture'], motherDirectory, 'm_' . $request['motherId']) : '';
                }
            }
        }
        else
        {
            $arrayName['notAdmittedreason'] = ($request['notAdmittedreason'] != '') ? $request['notAdmittedreason'] : NULL;
        }

        if ($request['facilityId'] != NULL && $request['facilityId'] != 0)
        {

            $deliveryPlace = getSingleRowFromTable('FacilityName', 'facilityId', $request['facilityId'], 'facilitylist');
        }
        else
        {
            $deliveryPlace = ucwords($request['deliveryPlace']);
        }

        $arrayName['androidUuid'] = ($request['localId'] != '') ? $request['localId'] : NULL;
        $arrayName['sameAddress'] = ($request['sameAddress'] != '') ? $request['sameAddress'] : NULL;
        $arrayName['motherMCTSNumber'] = ($request['motherMCTSNumber'] != '') ? $request['motherMCTSNumber'] : NULL;
        $arrayName['motherAadharNumber'] = ($request['motherAadharNumber'] != '') ? $request['motherAadharNumber'] : NULL;
        $arrayName['motherDOB'] = ($request['motherDOB'] != '') ? $request['motherDOB'] : NULL;
        $arrayName['motherEducation'] = ($request['motherEducation'] != '') ? $request['motherEducation'] : NUll;
        $arrayName['motherAge'] = ($request['motherAge'] != '') ? $request['motherAge'] : NULL;
        $arrayName['motherMobileNumber'] = ($request['motherMobileNumber'] != '') ? $request['motherMobileNumber'] : NULL;
        $arrayName['motherCaste'] = ($request['motherCaste'] != '') ? $request['motherCaste'] : NULL;
        $arrayName['fatherName'] = ($request['fatherName'] != '') ? $request['fatherName'] : NULL;
        $arrayName['fatherAadharNumber'] = ($request['fatherAadharNumber'] != '') ? $request['fatherAadharNumber'] : NULL;
        $arrayName['fatherMobileNumber'] = ($request['fatherMobileNumber'] != '') ? $request['fatherMobileNumber'] : NULL;
        $arrayName['rationCardType'] = ($request['rationCardType'] != '') ? $request['rationCardType'] : NULL;
        $arrayName['guardianName'] = ($request['guardianName'] != '') ? $request['guardianName'] : NULL;
        $arrayName['guardianNumber'] = ($request['guardianNumber'] != '') ? $request['guardianNumber'] : NULL;
        $arrayName['presentResidenceType'] = ($request['presentResidenceType'] != '') ? $request['presentResidenceType'] : NULL;
        $arrayName['presentAddress'] = ($request['presentAddress'] != '') ? $request['presentAddress'] : NULL;

        $arrayName['presentVillageName'] = ($request['presentVillageName'] != '') ? $request['presentVillageName'] : NULL;
        $arrayName['presentBlockName'] = ($request['presentBlockName'] != '') ? $request['presentBlockName'] : NULL;
        $arrayName['presentDistrictName'] = ($request['presentDistrictName'] != '') ? $request['presentDistrictName'] : NULL;

        $arrayName['permanentResidenceType'] = ($request['permanentResidenceType'] != '') ? $request['permanentResidenceType'] : NULL;

        $arrayName['permanentAddress'] = ($request['permanentAddress'] != '') ? $request['permanentAddress'] : NULL;

        $arrayName['permanentVillageName'] = ($request['permanentVillageName'] != '') ? $request['permanentVillageName'] : NULL;
        $arrayName['permanentBlockName'] = ($request['permanentBlockName'] != '') ? $request['permanentBlockName'] : NULL;
        $arrayName['permanentDistrictName'] = ($request['permanentDistrictName'] != '') ? $request['permanentDistrictName'] : NULL;

        $arrayName['presentAddNearByLocation'] = ($request['presentAddNearByLocation'] != '') ? $request['presentAddNearByLocation'] : NULL;
        $arrayName['permanentAddNearByLocation'] = ($request['permanentAddNearByLocation'] != '') ? $request['permanentAddNearByLocation'] : NULL;

        $arrayName['presentCountry'] = ($request['presentCountry'] != '') ? $request['presentCountry'] : NULL;
        $arrayName['presentState'] = ($request['presentState'] != '') ? $request['presentState'] : NULL;
        $arrayName['permanentCountry'] = ($request['permanentCountry'] != '') ? $request['permanentCountry'] : NULL;
        $arrayName['permanentState'] = ($request['permanentState'] != '') ? $request['permanentState'] : NULL;

        $arrayName['permanentPinCode'] = ($request['permanentPinCode'] != '') ? $request['permanentPinCode'] : NULL;
        $arrayName['presentPinCode'] = ($request['presentPinCode'] != '') ? $request['presentPinCode'] : NULL;

        $arrayName['profileUpdateNurseId'] = ($request['staffId'] != '') ? $request['staffId'] : NULL;

        $arrayName['para'] = ($request['para'] != '') ? $request['para'] : NULL;
        $arrayName['live'] = ($request['live'] != '') ? $request['live'] : NULL;
        $arrayName['abortion'] = ($request['abortion'] != '') ? $request['abortion'] : NULL;
        $arrayName['gravida'] = ($request['gravida'] != '') ? $request['gravida'] : NULL;

        $arrayName['multipleBirth'] = ($request['multipleBirth'] != '') ? $request['multipleBirth'] : NULL;

        $arrayName['ashaId'] = ($request['ashaId'] != '') ? $request['ashaId'] : NULL;

        if (($arrayName['ashaId'] != '') && ($arrayName['ashaId'] != '0'))
        {
            $ashaNumber = getSingleRowFromTable('ashaMobileNumber1', 'ashaId', $arrayName['ashaId'], 'ashaProfiling');
            $ashaName = getSingleRowFromTable('ashaName', 'ashaId', $arrayName['ashaId'], 'ashaProfiling');
            $arrayName['ashaName'] = ($ashaName != '') ? $ashaName : NULL;
            $arrayName['ashaNumber'] = ($ashaNumber != '') ? $ashaNumber : NULL;
        }
        else
        {

            $arrayName['ashaName'] = ($request['ashaName'] != '') ? $request['ashaName'] : NULL;
            $arrayName['ashaNumber'] = ($request['ashaNumber'] != '') ? $request['ashaNumber'] : NULL;
        }

        $arrayName['motherReligion'] = ($request['motherReligion'] != '') ? $request['motherReligion'] : NULL;

        $arrayName['motherLmpDate'] = ($request['motherLmpDate'] != '') ? $request['motherLmpDate'] : NULL;
        $arrayName['deliveryPlace'] = ($deliveryPlace != '') ? $deliveryPlace : NULL;
        $arrayName['deliveryDistrict'] = ($request['deliveryDistrict'] != '' && $request['deliveryDistrict'] != 0) ? $request['deliveryDistrict'] : NULL;
        $arrayName['guardianRelation'] = ($request['guardianRelation'] != '') ? $request['guardianRelation'] : NULL;
        $arrayName['deliveryFacilityId  '] = ($request['facilityId'] != '') ? $request['facilityId'] : NULL;
        $arrayName['type'] = ($request['type'] != '') ? $request['type'] : NULL;
        $arrayName['motherWeight'] = ($request['motherWeight'] != '') ? $request['motherWeight'] : NULL;
        $arrayName['ageAtMarriage'] = ($request['ageAtMarriage'] != '') ? $request['ageAtMarriage'] : NULL;
        $arrayName['birthSpacing'] = ($request['birthSpacing'] != '') ? $request['birthSpacing'] : NULL;
        $arrayName['consanguinity'] = ($request['consanguinity'] != '') ? $request['consanguinity'] : NULL;
        $arrayName['estimatedDateOfDelivery'] = ($request['estimatedDateOfDelivery'] != '') ? $request['estimatedDateOfDelivery'] : NULL;

        
        if ($arrayName['type'] == '3')
        {
            $arrayName['isMotherAdmitted'] = NULL;
            $arrayName['notAdmittedreason'] = NULL;
        }

        $arrayName['modifyDate'] = date('Y-m-d H:i:s');
        $resultArray = isBlankOrNull($arrayName);
        $this
            ->db
            ->where('motherId', $request['motherId']);
        $Update = $this
            ->db
            ->Update('motherRegistration', $resultArray);


        // generate log history
            $getNurseName = $this->db->get_where('staffMaster',array('staffId'=>$request['staffId']))->row_array();

            $paramArray                         = array();
            $paramArray['tableReference']       = '6';
            $paramArray['tableReferenceId']     = $request['motherId'];
            $paramArray['type']                 = '3';
            $paramArray['updatedBy']            = $request['staffId'];
            $paramArray['remark']               = $getNurseName['name']." has update the mother profile ".date('d M Y, g:i A',strtotime($request['localDateTime'])).".";
            
            $paramArray['latitude']             = $request['latitude'];
            $paramArray['longitude']            = $request['longitude'];
            $paramArray['addDate']              = $request['localDateTime'];
            $paramArray['lastSyncedTime']       = date('Y-m-d H:i:s');
            
            if($request['sameAddress'] != $registrationData['sameAddress']) {
                $paramArray['columnName']       = 'Same Address'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['sameAddress']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['motherMCTSNumber'] != $registrationData['motherMCTSNumber']) {
                $paramArray['columnName']       = 'Mother MCTS Number'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['motherMCTSNumber']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['motherAadharNumber'] != $registrationData['motherAadharNumber']) {
                $paramArray['columnName']       = 'Mother Aadhar Number'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['motherAadharNumber']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['motherDOB'] != $registrationData['motherDOB']) {
                $paramArray['columnName']       = 'Mother DOB'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['motherDOB']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['motherEducation'] != $registrationData['motherEducation']) {
                $paramArray['columnName']       = 'Mother Education'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['motherEducation']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['motherAge'] != $registrationData['motherAge']) {
                $paramArray['columnName']       = 'Mother Age'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['motherAge']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['motherMobileNumber'] != $registrationData['motherMobileNumber']) {
                $paramArray['columnName']       = 'Mother Mobile Number'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['motherMobileNumber']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['motherCaste'] != $registrationData['motherCaste']) {
                $paramArray['columnName']       = 'Mother Caste'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['motherCaste']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['fatherName'] != $registrationData['fatherName']) {
                $paramArray['columnName']       = 'Father Name'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['fatherName']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['fatherAadharNumber'] != $registrationData['fatherAadharNumber']) {
                $paramArray['columnName']       = 'Father Aadhar Number'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['fatherAadharNumber']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['fatherMobileNumber'] != $registrationData['fatherMobileNumber']) {
                $paramArray['columnName']       = 'Father Mobile Number'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['fatherMobileNumber']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['rationCardType'] != $registrationData['rationCardType']) {
                $paramArray['columnName']       = 'Ration Card Type'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['rationCardType']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['guardianName'] != $registrationData['guardianName']) {
                $paramArray['columnName']       = 'Guardian Name'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['guardianName']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['guardianNumber'] != $registrationData['guardianNumber']) {
                $paramArray['columnName']       = 'Guardian Number'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['guardianNumber']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['presentResidenceType'] != $registrationData['presentResidenceType']) {
                $paramArray['columnName']       = 'Present Residence Type'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['presentResidenceType']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['presentAddress'] != $registrationData['presentAddress']) {
                $paramArray['columnName']       = 'Present Address'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['presentAddress']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['presentVillageName'] != $registrationData['presentVillageName']) {
                $paramArray['columnName']       = 'Present Village Name'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['presentVillageName']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['presentBlockName'] != $registrationData['presentBlockName']) {
                $paramArray['columnName']       = 'Present Block Name'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['presentBlockName']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['presentDistrictName'] != $registrationData['presentDistrictName']) {
                $paramArray['columnName']       = 'Present District Name'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['presentDistrictName']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['permanentResidenceType'] != $registrationData['permanentResidenceType']) {
                $paramArray['columnName']       = 'Permanent Residence Type'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['permanentResidenceType']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['permanentAddress'] != $registrationData['permanentAddress']) {
                $paramArray['columnName']       = 'Permanent Address'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['permanentAddress']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['permanentVillageName'] != $registrationData['permanentVillageName']) {
                $paramArray['columnName']       = 'Permanent Village Name'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['permanentVillageName']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['permanentBlockName'] != $registrationData['permanentBlockName']) {
                $paramArray['columnName']       = 'Permanent Block Name'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['permanentBlockName']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['permanentDistrictName'] != $registrationData['permanentDistrictName']) {
                $paramArray['columnName']       = 'Permanent District Name'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['permanentDistrictName']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['presentAddNearByLocation'] != $registrationData['presentAddNearByLocation']) {
                $paramArray['columnName']       = 'Present Near By Location'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['presentAddNearByLocation']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['permanentAddNearByLocation'] != $registrationData['permanentAddNearByLocation']) {
                $paramArray['columnName']       = 'Permanent Near By Location'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['permanentAddNearByLocation']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['presentCountry'] != $registrationData['presentCountry']) {
                $paramArray['columnName']       = 'Present Country'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['presentCountry']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['presentState'] != $registrationData['presentState']) {
                $paramArray['columnName']       = 'Present State'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['presentState']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['permanentCountry'] != $registrationData['permanentCountry']) {
                $paramArray['columnName']       = 'Permanent Country'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['permanentCountry']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['permanentState'] != $registrationData['permanentState']) {
                $paramArray['columnName']       = 'Permanent State'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['permanentState']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['permanentPinCode'] != $registrationData['permanentPinCode']) {
                $paramArray['columnName']       = 'Permanent PinCode'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['permanentPinCode']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['presentPinCode'] != $registrationData['presentPinCode']) {
                $paramArray['columnName']       = 'Present PinCode'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['presentPinCode']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['para'] != $registrationData['para']) {
                $paramArray['columnName']       = 'Para'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['para']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['live'] != $registrationData['live']) {
                $paramArray['columnName']       = 'Live'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['live']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['abortion'] != $registrationData['abortion']) {
                $paramArray['columnName']       = 'Abortion'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['abortion']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['gravida'] != $registrationData['gravida']) {
                $paramArray['columnName']       = 'Gravida'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['gravida']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['multipleBirth'] != $registrationData['multipleBirth']) {
                $paramArray['columnName']       = 'Multiple Birth'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['multipleBirth']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['motherReligion'] != $registrationData['motherReligion']) {
                $paramArray['columnName']       = 'Multiple Religion'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['motherReligion']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['motherLmpDate'] != $registrationData['motherLmpDate']) {
                $paramArray['columnName']       = 'Multiple LMP Date'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['motherLmpDate']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['deliveryPlace'] != $registrationData['deliveryPlace']) {
                $paramArray['columnName']       = 'Delivery Place'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['deliveryPlace']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['deliveryDistrict'] != $registrationData['deliveryDistrict']) {
                $paramArray['columnName']       = 'Delivery District'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['deliveryDistrict']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['guardianRelation'] != $registrationData['guardianRelation']) {
                $paramArray['columnName']       = 'Guardian Relation'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['guardianRelation']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['facilityId'] != $registrationData['deliveryFacilityId']) {
                $paramArray['columnName']       = 'Delivery Facility'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['facilityId']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['type'] != $registrationData['type']) {
                $paramArray['columnName']       = 'Type'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['type']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['motherWeight'] != $registrationData['motherWeight']) {
                $paramArray['columnName']       = 'Mother Weight'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['motherWeight']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['ageAtMarriage'] != $registrationData['ageAtMarriage']) {
                $paramArray['columnName']       = 'Age At Marriage'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['ageAtMarriage']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['birthSpacing'] != $registrationData['birthSpacing']) {
                $paramArray['columnName']       = 'Birth Spacing'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['birthSpacing']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['consanguinity'] != $registrationData['consanguinity']) {
                $paramArray['columnName']       = 'Consanguinity'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['consanguinity']; 
                $this->db->insert('logData', $paramArray);
            }

            if($request['estimatedDateOfDelivery'] != $registrationData['estimatedDateOfDelivery']) {
                $paramArray['columnName']       = 'Estimated Date Of Delivery'; 
                $paramArray['oldValue']             = ''; 
                $paramArray['newValue']         = $request['estimatedDateOfDelivery']; 
                $this->db->insert('logData', $paramArray);
            }

            


        $this
            ->db
            ->order_by('id', 'desc');
        $motherAdmisionLastId = $this
            ->db
            ->get_where('motherAdmission', array(
            'motherId' => $request['motherId'],
            'loungeId' => $request['loungeId']
        ))->row_array();

        // $this
        //     ->db
        //     ->where('id', $motherAdmisionLastId['id']);
        // $this
        //     ->db
        //     ->update('motherAdmission', array(
        //     'hospitalRegistrationNumber' => $request['hospitalRegistrationNumber']
        // ));

        if ($Update > 0)
        {
            $getAllbabyByMotherId = $this
                ->db
                ->query("select BA.*,BR.* from babyAdmission as BA inner join babyRegistration as BR on BA.`babyId` = BR.`babyId` where BR.`motherId` = '" . $request['motherId'] . "' and BA.`loungeId` ='" . $request['loungeId'] . "'")->result_array();
            //  echo $this->db->last_query();die();
            foreach ($getAllbabyByMotherId as $key => $value)
            {
                $fileName = "b_" . $value['id'] . ".pdf";
                $PdfFile = $this
                    ->MotherBabyAdmissionModel
                    ->pdfconventer($fileName, $value['id']);
                $this
                    ->db
                    ->where('id', $value['id']);
                $this
                    ->db
                    ->update('babyAdmission', array(
                    'babyPdfFileName' => $fileName
                ));
            }
            return 1;
        }

    }

    public function MotherMonitoring($request)
    {
        $countData = count($request['monitoringData']);
        //get last mother AdmissionId
        if ($countData > 0)
        {
            $param = array();
            $checkDataForAllUpdate = 1; // check for all data synced or not
            foreach ($request['monitoringData'] as $key => $value)
            {
                $validateMotherId = $this->db->get_where('motherRegistration', array('motherId' => trim($value['motherId'])))->row_array();
                $validateStaffId = $this->db->get_where('staffMaster', array('staffId' => trim($value['staffId'])))->row_array();
                
                if((!empty($validateMotherId)) && (!empty($validateStaffId)) && (trim($value['staffId']) != "0") && (trim($value['staffId']) != "")){
                    $checkDuplicateData = $this
                        ->db
                        ->get_where('motherMonitoring', array(
                        'androidUuid' => $value['localId']
                    ))->num_rows();

                    if ($checkDuplicateData == 0)
                    {
                        $checkDataForAllUpdate = 2;
                        $this
                            ->db
                            ->order_by('id', 'desc');
                        $motherAdmisionLastId = $this
                            ->db
                            ->get_where('motherAdmission', array(
                            'motherId' => $value['motherId']
                        ))->row_array();

                        $getCount = $this
                            ->db
                            ->query("SELECT * FROM motherMonitoring where motherAdmissionId ='" . $motherAdmisionLastId['id'] . "' ")->num_rows();
                        $ImageOfadmittedPersonSign = ($value['admittedSign'] != '') ? saveImage($value['admittedSign'], signDirectory) : '';

                        $padPicture = ($value['padPicture'] != '') ? saveDynamicImage($value['padPicture'], padDirectory) : '';
                        $request = array();
                        $request['motherAdmissionId'] = $motherAdmisionLastId['id'];
                        //$request['loungeId'] = $value['loungeId'];
                        $request['androidUuid'] = ($value['localId'] != '') ? $value['localId'] : NULL;
                        $request['motherTemperature'] = $value['motherTemperature'];
                        $request['temperatureUnit'] = $value['temperatureUnit'];
                        $request['padNotChangeReason'] = $value['padNotChangeReason'];

                        $request['motherSystolicBP'] = $value['motherSystolicBP'];
                        $request['motherDiastolicBP'] = $value['motherDiastolicBP'];
                        $request['motherPulse'] = $value['motherPulse'];
                        $request['episitomyCondition'] = $value['episitomyCondition'];
                        $request['sanitoryPadStatus'] = $value['sanitoryPadStatus'];
                        $request['isSanitoryPadStink'] = $value['isSanitoryPadStink'];
                        $request['other'] = $value['other'];
                        $request['motherUterineTone'] = $value['motherUterineTone'];
                        $request['motherUrinationAfterDelivery'] = $value['motherUrinationAfterDelivery'];
                        $request['staffId'] = $value['staffId'];

                        $request['padPicture'] = $padPicture;
                        $request['admittedSign'] = $ImageOfadmittedPersonSign;
                        $request['motherAdmissionId'] = ($motherAdmisionLastId['id'] != '') ? $motherAdmisionLastId['id'] : NULL;
                        $request['assesmentDate'] = date('Y-m-d');
                        $request['assesmentTime'] = date('H:i');
                        $request['assesmentNumber'] = $getCount + 1;
                        $request['status'] = 1;
                        $request['addDate'] = $value['localDateTime'];
                        $request['lastSyncedTime'] = date('Y-m-d H:i:s');
                        $request['modifyDate'] = date('Y-m-d H:i:s');

                        $resultArray = isBlankOrNull($request);
                        $insert = $this
                            ->db
                            ->insert('motherMonitoring', $resultArray);
                        $lastAssessmentId = $this
                            ->db
                            ->insert_id();
                        $listID['id'] = $lastAssessmentId;
                        $listID['localId'] = $value['localId'];
                        $param[] = $listID;
                        ######### manage points ##########
                        

                        $GetNoticfictaionEntry = $this
                            ->db
                            ->query("SELECT * From notification where  loungeId = '" . $value['loungeId'] . "'  AND  motherId = '" . $value['motherId'] . "' AND status = '1' AND typeOfNotification='1' order by id desc limit 0, 1")->result_array();
                        $GetNoticfictaionEntry1 = $this
                            ->db
                            ->query("SELECT * From notification where  loungeId = '" . $value['loungeId'] . "'  AND  motherId = '" . $value['motherId'] . "' AND status = '1' AND typeOfNotification='1' order by id desc limit 0, 1")->row_array();

                        $settingDetail = getAllData('settings', 'id', '1');

                        $secondMonitoring = $settingDetail['motherMonitoringSecondTime'];
                        $secondTiming = date('Y-m-d ' . $secondMonitoring . ':00:00');
                        $secondMonitoringTime = strtotime($secondTiming);

                        $secondEnddate = date('Y-m-d H:i:s', strtotime('+ 3 hours' . date('Y-m-d H:i:s', $secondMonitoringTime)));
                        $secondEndTiming = strtotime($secondEnddate);

                        $thirdMonitoing = $settingDetail['motherMonitoringThirdTime'];
                        $thirdTiming = date('Y-m-d ' . $thirdMonitoing . ':00:00');
                        $thirdMonitoringTime = strtotime($thirdTiming);

                        $thirdEndDate = date('Y-m-d H:i:s', strtotime('+ 3 hours' . date('Y-m-d H:i:s', $thirdMonitoringTime)));
                        $thirdEndTiming = strtotime($thirdEndDate);

                        $fourthMonitoring = $settingDetail['motherMonitoringFourthTime'];
                        $fourthTiming = date('Y-m-d ' . $fourthMonitoring . ':00:00');
                        $fourthMonitoringTime = strtotime($fourthTiming);

                        $fourthEndDate = date('Y-m-d H:i:s', strtotime('+ 3 hours' . date('Y-m-d H:i:s', $fourthMonitoringTime)));
                        $fourthEndTime = strtotime($fourthEndDate);

                        $curDateTime = time();

                        if ($settingDetail > 0)
                        {
                            $firstMonitoring = $settingDetail['motherMonitoringFirstTime'];
                            $firstTiming = date('Y-m-d ' . $firstMonitoring . ':00:00');
                            $firstMonitoringTime = strtotime($firstTiming);

                            $firstEnddate = date('Y-m-d H:i:s', strtotime('+ 3 hours' . date('Y-m-d H:i:s', $firstMonitoringTime)));
                            $firstEndTiming = strtotime($firstEnddate);

                            if ($firstMonitoringTime <= $curDateTime && $firstEndTiming > $curDateTime)
                            {
                                if (count($GetNoticfictaionEntry) == 1)
                                {
                                    $this
                                        ->db
                                        ->where('id', $GetNoticfictaionEntry1['id']);
                                    $this
                                        ->db
                                        ->update('notification', array(
                                        'status' => '2',
                                        'modifyDate' => $curDateTime
                                    ));
                                    $this->givenPointsAtMonitoring($request, $lastAssessmentId);
                                }

                            }
                            else if ($secondMonitoringTime <= $curDateTime && $secondEndTiming > $curDateTime)
                            {
                                if (count($GetNoticfictaionEntry) == 1)
                                {
                                    $this
                                        ->db
                                        ->where('id', $GetNoticfictaionEntry1['id']);
                                    $this
                                        ->db
                                        ->update('notification', array(
                                        'status' => '2',
                                        'modifyDate' => $curDateTime
                                    ));
                                    $this->givenPointsAtMonitoring($request, $lastAssessmentId);
                                }
                            }
                            else if ($thirdMonitoringTime <= $curDateTime && $thirdEndTiming > $curDateTime)
                            {
                                if (count($GetNoticfictaionEntry) == 1)
                                {
                                    $this
                                        ->db
                                        ->where('id', $GetNoticfictaionEntry1['id']);
                                    $this
                                        ->db
                                        ->update('notification', array(
                                        'status' => '2',
                                        'modifyDate' => $curDateTime
                                    ));
                                    $this->givenPointsAtMonitoring($request, $lastAssessmentId);
                                }
                            }
                            else if ($fourthMonitoringTime <= $curDateTime && $fourthEndTime > $curDateTime)
                            {
                                if (count($GetNoticfictaionEntry) == 1)
                                {
                                    $this
                                        ->db
                                        ->where('id', $GetNoticfictaionEntry1['id']);
                                    $this
                                        ->db
                                        ->update('notification', array(
                                        'status' => '2',
                                        'modifyDate' => $curDateTime
                                    ));
                                    $this->givenPointsAtMonitoring($request, $lastAssessmentId);
                                }
                            }

                        }
                    }
                    else
                    {
                        // all update data
                        $this
                            ->db
                            ->order_by('id', 'desc');
                        $motherAdmisionLastId = $this
                            ->db
                            ->get_where('motherAdmission', array(
                            'motherId' => $value['motherId']
                        ))->row_array();

                        $getCount = $this
                            ->db
                            ->query("SELECT * FROM motherMonitoring where motherAdmissionId ='" .  $motherAdmisionLastId['id'] . "' ")->num_rows();
                        
                        $ImageOfadmittedPersonSign = ($value['admittedSign'] != '') ? saveImage($value['admittedSign'], signDirectory) : '';

                        $padPicture = ($value['padPicture'] != '') ? saveDynamicImage($value['padPicture'], padDirectory) : '';
                        $request = array();
                        $request['motherAdmissionId'] =  $motherAdmisionLastId['id'];
                        //$request['loungeId'] = $value['loungeId'];
                        $request['androidUuid'] = ($value['localId'] != '') ? $value['localId'] : NULL;
                        $request['motherTemperature'] = $value['motherTemperature'];
                        $request['temperatureUnit'] = $value['temperatureUnit'];
                        $request['padNotChangeReason'] = ($value['padNotChangeReason'] != '') ? $value['padNotChangeReason'] : NULL;

                        $request['motherSystolicBP'] = $value['motherSystolicBP']; 
                        $request['motherDiastolicBP'] = $value['motherDiastolicBP'];
                        $request['motherPulse'] = $value['motherPulse'];
                        $request['episitomyCondition'] = ($value['episitomyCondition'] != '') ? $value['episitomyCondition'] : NULL;
                        $request['sanitoryPadStatus'] =  ($value['sanitoryPadStatus'] != '') ? $value['sanitoryPadStatus'] : NULL;
                        $request['isSanitoryPadStink'] = ($value['isSanitoryPadStink'] != '') ? $value['isSanitoryPadStink'] : NULL;
                        $request['otherComment'] = ($value['other'] != '') ? $value['other'] : NULL;
                        $request['motherUterineTone'] = ($value['motherUterineTone'] != '') ? $value['motherUterineTone'] : NULL;
                        $request['motherUrinationAfterDelivery'] = ($value['motherUrinationAfterDelivery'] != '') ? $value['motherUrinationAfterDelivery'] : NULL;
                        $request['staffId'] = $value['staffId'];

                        $request['padPicture'] = $padPicture;
                        $request['admittedSign'] = $ImageOfadmittedPersonSign;
                        $request['motherAdmissionId'] = ($motherAdmisionLastId['id'] != '') ? $motherAdmisionLastId['id'] : NULL;
                        $request['assesmentDate'] = date('Y-m-d');
                        $request['assesmentTime'] = date('H:i');
                        $request['assesmentNumber'] = $getCount + 1;
                        $request['status'] = 1;
                        $request['addDate'] = $value['localDateTime'];
                        $request['lastSyncedTime'] = date('Y-m-d H:i:s');
                        $request['modifyDate'] = date('Y-m-d H:i:s');

                        $resultArray = isBlankOrNull($request);
                        $this
                            ->db
                            ->where('androidUuid', $value['localId']);
                        $this
                            ->db
                            ->update('motherMonitoring', $resultArray);
                        $lastAssessmentId = $this
                            ->db
                            ->get_where('motherMonitoring', array(
                            'androidUuid' => $value['localId']
                        ))->row_array();
                        $listID['id'] = $lastAssessmentId['id'];
                        $listID['localId'] = $value['localId'];
                        $param[] = $listID;

                    }
                }
            }
        }

        $date['id'] = $param;
        generateServerResponse('1', 'S', $date);
        
        //return 1 ;
        
    }

    // mother daily monitoring
    public function motherDailyMonitering($request)
    {
        $countData = count($request['monitoringData']);
        //get last mother AdmissionId
        if ($countData > 0)
        {
            $param = array();
            $checkDataForAllUpdate = 1; // check for all data synced or not
            foreach ($request['monitoringData'] as $key => $value)
            {
                #+++++++++   check Hospipal Reg No. Existing value  +++++++++++++++
                $this
                    ->db
                    ->order_by('id', 'desc');

                $checkMotherAdmitSameLounge = $this
                    ->db
                    ->get_where('motherAdmission', array(
                    'status' => 2,
                    'motherId' => $value['motherId']
                ))->num_rows();

                if ($checkMotherAdmitSameLounge == '0' && $value['type'] == '3')
                {
                    $hospitalRegistrationNumber = $this->checkHospitalRegistrationNumber($value['hospitalRegistrationNumber'], $value['loungeId']);
                    if ($hospitalRegistrationNumber == 1 && $value['type'] == '3')
                    {
                        generateServerResponse('0', '136');
                    }
                }

                $mother = array();

                $mother['androidUuid'] = ($value['localId'] != '') ? $value['localId'] : NULL;
                //$mother['doctorIncharge']   = ($request['doctorIncharge']!='')? $request['doctorIncharge'] : NULL;
                $mother['motherId'] = ($value['motherId'] != '') ? $value['motherId'] : NULL;
                $mother['loungeId'] = ($value['loungeId'] != '') ? $value['loungeId'] : NULL;
                $mother['hospitalRegistrationNumber'] = ($value['hospitalRegistrationNumber'] != '') ? $value['hospitalRegistrationNumber'] : NULL;
                $mother['addDate'] = date('Y-m-d H:i:s');
                $mother['modifyDate'] = date('Y-m-d H:i:s');

                if ($value['type'] == '1')
                {
                    $mother_addmission = $this
                        ->db
                        ->insert('motherAdmission', $mother);
                    $MotherInsertedId = $this
                        ->db
                        ->insert_id();
                }

                $checkDataForAllUpdate = 2;
                $this
                    ->db
                    ->order_by('id', 'desc');

                $motherAdmisionLastId = $this
                    ->db
                    ->get_where('motherAdmission', array(
                    'motherId' => $value['motherId']
                ))->row_array();

                $tempPic = ($value['temperaturePhoto'] != '') ? saveImage($value['temperaturePhoto'], imageDirectory) : '';

                $request = array();
                $request['motherId'] = $value['motherId'];
                $request['loungeId'] = $value['loungeId'];
                $request['staffId'] = $value['staffId'];
                $request['androidUuid'] = ($value['localId'] != '') ? $value['localId'] : NULL;
                //$request['isMotherTemperatureAvailable'] = $value['isMotherTemperatureAvailable'];
                $request['motherTemperature'] = $value['motherTemperature'];
                $request['temperatureUnit'] = $value['temperatureUnit'];
                //$request['temperaturePhoto'] = $tempPic;
                $request['motherSystolicBP'] = $value['motherSystolicBP'];
                $request['motherDiastolicBP'] = $value['motherDiastolicBP'];
                $request['motherPulse'] = $value['motherPulse'];

                $request['eddValue'] = ($value['eddValue'] != '') ? $value['eddValue'] : NULL;
                $request['antenatalVisits'] = ($value['antenatalVisits'] != '') ? $value['antenatalVisits'] : NULL;
                $request['ttDoses'] = ($value['ttDoses'] != '') ? $value['ttDoses'] : NULL;
                $request['hbValue'] = ($value['hbValue'] != '') ? $value['hbValue'] : NULL;
                $request['bloodGroup'] = ($value['bloodGroup'] != '') ? $value['bloodGroup'] : NULL;
                $request['isPihAvail'] = ($value['isPihAvail'] != '') ? $value['isPihAvail'] : NULL;
                $request['pihValue'] = ($value['pihValue'] != '') ? $value['pihValue'] : NULL;
                $request['isDrugAvail'] = ($value['isDrugAvail'] != '') ? $value['isDrugAvail'] : NULL;
                $request['drugValue'] = ($value['drugValue'] != '') ? $value['drugValue'] : NULL;
                $request['radiation'] = ($value['radiation'] != '') ? $value['radiation'] : NULL;
                $request['isIllnessAvail'] = ($value['isIllnessAvail'] != '') ? $value['isIllnessAvail'] : NULL;
                $request['illnessValue'] = ($value['illnessValue'] != '') ? $value['illnessValue'] : NULL;
                $request['aphValue'] = ($value['aphValue'] != '') ? $value['aphValue'] : NULL;
                $request['gdmValue'] = ($value['gdmValue'] != '') ? $value['gdmValue'] : NULL;
                $request['thyroid'] = ($value['thyroid'] != '') ? $value['thyroid'] : NULL;
                $request['vdrlValue'] = ($value['vdrlValue'] != '') ? $value['vdrlValue'] : NULL;
                $request['hbsAgValue'] = ($value['hbsAgValue'] != '') ? $value['hbsAgValue'] : NULL;
                $request['hivTesting'] = ($value['hivTesting'] != '') ? $value['hivTesting'] : NULL;
                $request['amnioticFluidVolume'] = ($value['amnioticFluidVolume'] != '') ? $value['amnioticFluidVolume'] : NULL;
                $request['otherSignificantInfo'] = ($value['otherSignificantInfo'] != '') ? $value['otherSignificantInfo'] : NULL;

                $request['isAntenatalSteroids'] = ($value['isAntenatalSteroids'] != '') ? $value['isAntenatalSteroids'] : NULL;
                $request['antenatalSteroidsValue'] = ($value['antenatalSteroidsValue'] != '') ? $value['antenatalSteroidsValue'] : NULL;
                $request['numberOfDoses'] = ($value['numberOfDoses'] != '') ? $value['numberOfDoses'] : NULL;
                $request['timeBetweenLastDoseDelivery'] = ($value['timeBetweenLastDoseDelivery'] != '') ? $value['timeBetweenLastDoseDelivery'] : NULL;
                $request['hoFever'] = ($value['hoFever'] != '') ? $value['hoFever'] : NULL;
                $request['foulSmellingDischarge'] = ($value['foulSmellingDischarge'] != '') ? $value['foulSmellingDischarge'] : NULL;
                $request['leakingPv'] = ($value['leakingPv'] != '') ? $value['leakingPv'] : NULL;
                $request['uterineTenderness'] = ($value['uterineTenderness'] != '') ? $value['uterineTenderness'] : NULL;
                $request['pihLabour'] = ($value['pihLabour'] != '') ? $value['pihLabour'] : NULL;
                $request['amnioticFluid'] = ($value['amnioticFluid'] != '') ? $value['amnioticFluid'] : NULL;
                $request['presentation'] = ($value['presentation'] != '') ? $value['presentation'] : NULL;
                $request['labour'] = ($value['labour'] != '') ? $value['labour'] : NULL;
                $request['courseOfLabour'] = ($value['courseOfLabour'] != '') ? $value['courseOfLabour'] : NULL;
                $request['eoFeotalDistress'] = ($value['eoFeotalDistress'] != '') ? $value['eoFeotalDistress'] : NULL;
                $request['typeOfDelivery'] = ($value['typeOfDelivery'] != '') ? $value['typeOfDelivery'] : NULL;
                $request['indicationForCaesarean'] = ($value['indicationForCaesarean'] != '') ? $value['indicationForCaesarean'] : NULL;
                $request['indicationApplicableValue'] = ($value['indicationApplicableValue'] != '') ? $value['indicationApplicableValue'] : NULL;
                $request['deliveryAttendedBy'] = ($value['deliveryAttendedBy'] != '') ? $value['deliveryAttendedBy'] : NULL;
                $request['otherSignificantValueForLabour'] = ($value['otherSignificantValueForLabour'] != '') ? $value['otherSignificantValueForLabour'] : NULL;

                $request['motherAdmissionId'] = ($motherAdmisionLastId['id'] != '') ? $motherAdmisionLastId['id'] : NULL;
                $request['assesmentDate'] = date('Y-m-d');
                $request['assesmentTime'] = date('H:i');
                $request['assesmentNumber'] = 1;
                $request['status'] = 1;
                $request['addDate'] = $value['localDateTime'];
                $request['lastSyncedTime'] = date('Y-m-d H:i:s');
                $request['modifyDate'] = date('Y-m-d H:i:s');

                //$resultArray = isBlankOrNull($request);
                $checkDuplicateData = $this
                    ->db
                    ->get_where('motherMonitoring', array(
                    'androidUuid' => $value['localId']
                ))->num_rows();

                if ($checkDuplicateData == 0)
                {
                    $insert = $this
                        ->db
                        ->insert('motherMonitoring', $request);

                    $lastAssessmentId = $this
                        ->db
                        ->insert_id();

                    $listID['id'] = $lastAssessmentId;
                    $listID['localId'] = $value['localId'];
                    $param[] = $listID;
                }
                else
                {
                    $this
                        ->db
                        ->where('androidUuid', $value['localId']);
                    $this
                        ->db
                        ->update('motherMonitoring', $request);

                    $lastAssessmentId = $this
                        ->db
                        ->get_where('motherMonitoring', array(
                        'androidUuid' => $value['localId']
                    ))->row_array();

                    $listID['id'] = $lastAssessmentId['id'];
                    $listID['localId'] = $value['localId'];
                    $param[] = $listID;
                }
            }
        }

        $date['motherAdmissionId'] = $motherAdmisionLastId['id'];
        $date['id'] = $param;
        generateServerResponse('1', 'S', $date);
    }

    // update mother monitoring data
    public function updateMotherData($request)
    {
        $countData = count($request['monitoringData']);
        //get last mother AdmissionId
        if ($countData > 0)
        {
            $param = array();
            $checkDataForAllUpdate = 1; // check for all data synced or not
            foreach ($request['monitoringData'] as $key => $value)
            {
                #+++++++++   check Hospipal Reg No. Existing value  +++++++++++++++
                $this
                    ->db
                    ->order_by('id', 'desc');
                $checkMotherAdmitSameLounge = $this
                    ->db
                    ->get_where('motherAdmission', array(
                    'status' => 2,
                    'motherId' => $value['motherId']
                ))->num_rows();

                $mother = array();

                $mother['androidUuid'] = ($value['localId'] != '') ? $value['localId'] : NULL;
                //$mother['doctorIncharge']   = ($request['doctorIncharge']!='')? $request['doctorIncharge'] : NULL;
                $mother['motherId'] = ($value['motherId'] != '') ? $value['motherId'] : NULL;
                $mother['loungeId'] = ($value['loungeId'] != '') ? $value['loungeId'] : NULL;
                
                $mother['addDate'] = date('Y-m-d H:i:s');
                $mother['modifyDate'] = date('Y-m-d H:i:s');

                $this
                    ->db
                    ->order_by('id', 'desc');
                    $motherAdmisionLastId = $this
                        ->db
                        ->get_where('motherAdmission', array(
                        'motherId' => $value['motherId']
                    ))->row_array();

                $checkDuplicateData = $this
                    ->db
                    ->get_where('motherPastInformation', array(
                    'androidUuid' => $value['localId']
                ))->num_rows();

                $checkDuplicateDataByMId = $this
                    ->db
                    ->get_where('motherPastInformation', array(
                    'motherAdmissionId' => $motherAdmisionLastId['id']
                ))->num_rows();


                $request = array();
                // $request['motherAdmissionId'] = $value['motherId'];
                // $request['loungeId'] = $value['loungeId'];
                $request['staffId'] = $value['staffId'];
                $request['androidUuid'] = ($value['localId'] != '') ? $value['localId'] : NULL;

                $request['eddValue'] = ($value['eddValue'] != '') ? $value['eddValue'] : NULL;
                $request['antenatalVisits'] = ($value['antenatalVisits'] != '') ? $value['antenatalVisits'] : NULL;
                $request['ttDoses'] = ($value['ttDoses'] != '') ? $value['ttDoses'] : NULL;
                $request['hbValue'] = ($value['hbValue'] != '') ? $value['hbValue'] : NULL;
                $request['bloodGroup'] = ($value['bloodGroup'] != '') ? $value['bloodGroup'] : NULL;
                $request['isPihAvail'] = ($value['isPihAvail'] != '') ? $value['isPihAvail'] : NULL;
                $request['pihValue'] = ($value['pihValue'] != '') ? $value['pihValue'] : NULL;
                $request['isDrugAvail'] = ($value['isDrugAvail'] != '') ? $value['isDrugAvail'] : NULL;
                $request['drugValue'] = ($value['drugValue'] != '') ? $value['drugValue'] : NULL;
                $request['radiation'] = ($value['radiation'] != '') ? $value['radiation'] : NULL;
                $request['isIllnessAvail'] = ($value['isIllnessAvail'] != '') ? $value['isIllnessAvail'] : NULL;
                $request['illnessValue'] = ($value['illnessValue'] != '') ? $value['illnessValue'] : NULL;
                $request['aphValue'] = ($value['aphValue'] != '') ? $value['aphValue'] : NULL;
                $request['gdmValue'] = ($value['gdmValue'] != '') ? $value['gdmValue'] : NULL;
                $request['thyroid'] = ($value['thyroid'] != '') ? $value['thyroid'] : NULL;
                $request['vdrlValue'] = ($value['vdrlValue'] != '') ? $value['vdrlValue'] : NULL;
                $request['hbsAgValue'] = ($value['hbsAgValue'] != '') ? $value['hbsAgValue'] : NULL;
                $request['hivTesting'] = ($value['hivTesting'] != '') ? $value['hivTesting'] : NULL;
                $request['amnioticFluidVolume'] = ($value['amnioticFluidVolume'] != '') ? $value['amnioticFluidVolume'] : NULL;
                $request['otherSignificantInfo'] = ($value['otherSignificantInfo'] != '') ? $value['otherSignificantInfo'] : NULL;

                $request['isAntenatalSteroids'] = ($value['isAntenatalSteroids'] != '') ? $value['isAntenatalSteroids'] : NULL;
                $request['antenatalSteroidsValue'] = ($value['antenatalSteroidsValue'] != '') ? $value['antenatalSteroidsValue'] : NULL;
                $request['numberOfDoses'] = ($value['numberOfDoses'] != '') ? $value['numberOfDoses'] : NULL;
                $request['timeBetweenLastDoseDelivery'] = ($value['timeBetweenLastDoseDelivery'] != '') ? $value['timeBetweenLastDoseDelivery'] : NULL;
                $request['hoFever'] = ($value['hoFever'] != '') ? $value['hoFever'] : NULL;
                $request['foulSmellingDischarge'] = ($value['foulSmellingDischarge'] != '') ? $value['foulSmellingDischarge'] : NULL;
                $request['leakingPv'] = ($value['leakingPv'] != '') ? $value['leakingPv'] : NULL;
                $request['uterineTenderness'] = ($value['uterineTenderness'] != '') ? $value['uterineTenderness'] : NULL;
                $request['pihLabour'] = ($value['pihLabour'] != '') ? $value['pihLabour'] : NULL;
                $request['amnioticFluid'] = ($value['amnioticFluid'] != '') ? $value['amnioticFluid'] : NULL;
                $request['presentation'] = ($value['presentation'] != '') ? $value['presentation'] : NULL;
                $request['labour'] = ($value['labour'] != '') ? $value['labour'] : NULL;
                $request['courseOfLabour'] = ($value['courseOfLabour'] != '') ? $value['courseOfLabour'] : NULL;
                $request['eoFeotalDistress'] = ($value['eoFeotalDistress'] != '') ? $value['eoFeotalDistress'] : NULL;
                $request['typeOfDelivery'] = ($value['typeOfDelivery'] != '') ? $value['typeOfDelivery'] : NULL;
                $request['indicationForCaesarean'] = ($value['indicationForCaesarean'] != '') ? $value['indicationForCaesarean'] : NULL;
                $request['indicationApplicableValue'] = ($value['indicationApplicableValue'] != '') ? $value['indicationApplicableValue'] : NULL;
                $request['deliveryAttendedBy'] = ($value['deliveryAttendedBy'] != '') ? $value['deliveryAttendedBy'] : NULL;
                $request['otherSignificantValueForLabour'] = ($value['otherSignificantValueForLabour'] != '') ? $value['otherSignificantValueForLabour'] : NULL;

                $request['motherAdmissionId'] = ($motherAdmisionLastId['id'] != '') ? $motherAdmisionLastId['id'] : NULL;
                // $request['assesmentDate'] = date('Y-m-d ');
                // $request['assesmentTime'] = date('H:i');
                // $request['assesmentNumber'] = $getCount + 1;
                $request['status'] = 1;
                $request['addDate'] = $value['localDateTime'];
                $request['lastSyncedTime'] = date('Y-m-d H:i:s');
                $request['modifyDate'] = date('Y-m-d H:i:s');

                $request['nurseSign'] = ($value['nurseSign'] != '') ? saveImage($value['nurseSign'], signDirectory) : '';

                if ($checkDuplicateData == 0 && $checkDuplicateDataByMId == 0)
                {
                    $checkDataForAllUpdate = 2;

                    $resultArray = isBlankOrNull($request);
                    $insert = $this
                        ->db
                        ->insert('motherPastInformation', $resultArray);
                    $lastAssessmentId = $this
                        ->db
                        ->insert_id();
                    $listID['id'] = $lastAssessmentId;
                    $listID['localId'] = $value['localId'];
                    $param[] = $listID;
                    ######### manage points ##########
                }
                else
                {

                    $resultArray = isBlankOrNull($request);
                    $this
                        ->db
                        ->where('motherAdmissionId', $motherAdmisionLastId['id']);
                    $this
                        ->db
                        ->update('motherPastInformation', $resultArray);
                    $lastAssessmentId = $this
                        ->db
                        ->get_where('motherPastInformation', array(
                        'androidUuid' => $value['localId']
                    ))->row_array();
                    $listID['id'] = $lastAssessmentId['id'];
                    $listID['localId'] = $value['localId'];
                    $param[] = $listID;

                }
            }
        }
        if ($checkDataForAllUpdate == 1 || $checkDataForAllUpdate == 2)
        {
            $date['motherAdmissionId'] = $motherAdmisionLastId['id'];
            $date['id'] = $param;
            generateServerResponse('1', 'S', $date);
        }
        else
        {
            generateServerResponse('0', '213');
        }
        //return 1 ;
        
    }

    public function GetMothers($request)
    {
        $coachId    = $request['coachId'];
        $loungeId   = $request['loungeId'];

        $coachData = $this
            ->db
            ->get_where('coachDistrictFacilityLounge', array(
            'masterId' => $coachId,
            'loungeId' => $loungeId,
            'status' => '1'
        ));

        if ($coachData->num_rows() != 0)
        {

            return $this
            ->db
            ->query("SELECT * FROM motherAdmission Where   `loungeId` = '" . $request['loungeId'] . " ' AND `status` = '1' Order by id desc ")->result_array();
        } else {
             generateServerResponse('0','L');
        }
    }

    public function MotherSearch($request)
    {

        $searchResult = $this
            ->db
            ->query("SELECT * FROM `motherRegistration` as MR Left Join motherAdmission as MA on MA.`motherId`  = MR.`motherId`  where 
            MR.`motherName` LIKE '" . $request['search_data'] . "%'  OR 
            MR.`fatherName`  LIKE '" . $request['search_data'] . "%' OR
            MR.`motherMCTSNumber`= '" . $request['search_data'] . "'  OR 
            MR.`motherAadharNumber`= '" . $request['search_data'] . "' OR
            MR.`motherMobileNumber`= '" . $request['search_data'] . "' OR
            MR.`fatherMobileNumber`= '" . $request['search_data'] . "' OR
            MR.`fatherAadharNumber`= '" . $request['search_data'] . "' And MA.`status`!= 2  Order By MR.`motherId` Desc  ")->result_array();

        return $searchResult;
    }

    //unknowMotherRegistration USED
    public function unknowMotherRegistration($request)
    {
        // check duplicateData
        $existData = $this
            ->db
            ->get_where('motherRegistration', array(
            'androidUuid' => $request['localId']
        ))->num_rows();
        if ($existData > 0)
        {
            generateServerResponse('0', '213');
        }

        $arrayName = array();

        $arrayName['androidUuid'] = ($request['localId'] != '') ? $request['localId'] : NULL;
        $arrayName['motherAdmission'] = NULL;
        $arrayName['notAdmittedreason'] = NULL;
        $arrayName['guardianName'] = $request['guardianName'];
        $arrayName['guardianNumber'] = $request['guardianNumber'];
        $arrayName['loungeId']      = $request['loungeId'];

        $arrayName['type'] = $request['type'];
        $arrayName['organisationName'] = $request['organisationName'];
        $arrayName['organisationNumber'] = $request['organisationNumber'];
        $arrayName['organisationAddress'] = $request['organisationAddress'];
        //$arrayName['hospitalRegistrationNumber'] = $request['hospitalRegistrationNumber'];
        

        $arrayName['status'] = '1';
        $arrayName['addDate']  = date('Y-m-d H:i:s');
        $arrayName['modifyDate']  = date('Y-m-d H:i:s');
        $resultArray = isBlankOrNull($arrayName);

        $inserted = $this
            ->db
            ->insert('motherRegistration', $resultArray);
        $motherId = $this
            ->db
            ->insert_id();
        $array = array();
        $array['motherId'] = $motherId;
        return $array;
    }

    public function UpdateunknowMotherRegistration($request)
    {
        $arrayName = array();
        $arrayName['guardianName'] = $request['guardianName'];
        $arrayName['guardianNumber'] = $request['guardianNumber'];
        $arrayName['type'] = $request['type'];
        $arrayName['organisationName'] = $request['organisationName'];
        $arrayName['organisationNumber'] = $request['organisationNumber'];
        $arrayName['organisationAddress'] = $request['organisationAddress'];
        $arrayName['loungeId'] = $request['loungeId'];
        $arrayName['status'] = '1';
        $arrayName['addDate'] = date('Y-m-d H:i:s');
        $arrayName['modifyDate'] = date('Y-m-d H:i:s');

        $resultArray = isBlankOrNull($arrayName);

        $this
            ->db
            ->where('motherId', $request['motherId']);
        $update = $this
            ->db
            ->update('motherRegistration', $resultArray);
        return $update;
    }

    public function DistrictVillageBlock($id, $type = '')
    {

        if ($type == '1')
        {
            $query = $this
                ->db
                ->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs` where `revenuevillagewithblcoksandsubdistandgs`.`GPPRICode`= '" . $id . "' limit 0,1")->row_array();
            return $query['GPNameProperCase'];
        }
        elseif ($type == '2')
        {
            $query = $this
                ->db
                ->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs`  
                    where `revenuevillagewithblcoksandsubdistandgs`.`BlockPRICode`= '" . $id . "' limit 0,1")->row_array();
            return $query['BlockPRINameProperCase'];
        }
        elseif ($type == '3')
        {
            $query = $this
                ->db
                ->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs`  
                    where `revenuevillagewithblcoksandsubdistandgs`.`PRIDistrictCode`= '" . $id . "' limit 0,1")->row_array();
            return $query['DistrictNameProperCase'];
        }

    }

    public function givenPointsAtMonitoring($request, $lastAssessmentId)
    {
        /*type = 7 for MotherMonitering*/
        $getpoints = $this
            ->db
            ->get_where('pointmaster', array(
            'type' => '7',
            'status' => '1'
        ))
            ->row_array();
        if ($getpoints > 0)
        {
            $field = array();
            $field['nurseId'] = $request['staffId'];
            $field['Points'] = $getpoints['Point'];
            $field['loungeId'] = $request['loungeId'];
            $field['grantedForId'] = $lastAssessmentId;
            $field['type'] = $getpoints['type'];
            $field['TransactionStatus'] = 'Credit';
            $field['addDate'] = time();
            $field['modifyDate'] = time();
            $this
                ->db
                ->insert('pointstransactions', $field);
        }
        return 1;
    }

    //mother danger or non-danger icon code
    public function getMotherIcon($getLastAssessment)
    {
        $status1 = 0;
        $status2 = 0;
        $status3 = 0;
        $status4 = 0;
        $status5 = 0;
        $status6 = 0;
        $status7 = 0;
        $status8 = 0;
        if (!empty($getLastAssessment['id']))
        {
            if ($getLastAssessment['motherPulse'] < 50 || $getLastAssessment['motherPulse'] > 120)
            {
                $status1 = '1';
            }

            if ($getLastAssessment['motherTemperature'] < 95.9 || $getLastAssessment['motherTemperature'] > 99.5)
            {
                $status2 = '1';
            }

            if ($getLastAssessment['motherSystolicBP'] >= 140 || $getLastAssessment['motherSystolicBP'] <= 90)
            {
                $status3 = '1';
            }

            if ($getLastAssessment['motherDiastolicBP'] <= 60 || $getLastAssessment['motherDiastolicBP'] >= 90)
            {
                $status4 = '1';
            }

            if ($getLastAssessment['motherUterineTone'] == 'Hard/Collapsed (Contracted)')
            {
                $status5 = '1';
            }

            if (!empty($getLastAssessment['episitomycondition']) && $getLastAssessment['episitomycondition'] == 'Infected')
            {
                $status6 = '1';
            }

            if (!empty($getLastAssessment['sanitoryPadStatus']) && $getLastAssessment['sanitoryPadStatus'] == "It's FULL")
            {
                $status7 = '1';
            }

            if (!empty($getLastAssessment['motherBleedingStatus']) && $getLastAssessment['motherBleedingStatus'] == "Yes")
            {
                $status8 = '1';
            }

            if ($status1 == 1 || $status2 == 1 || $status3 == 1 || $status4 == 1 || $status5 == 1 || $status6 == 1 || $status7 == 1 || $status8 == 1)
            {
                return '0'; // for sad mother
                
            }
            else
            {
                return '1'; // for happy mother
                
            }
        }

    }

}

