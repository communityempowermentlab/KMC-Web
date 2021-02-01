<?php
class FacilityModel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();	
		date_default_timezone_set("Asia/KolKata");
	}

	public function getFacility($request)
	{
		$where = ($request['districtId'] !='' ) ? 'and FL.`PRIDistrictCode` = '.$request['districtId'].'' : '' ;
		$timestamp = ($request['timestamp'] !='' ) ? 'and FL.`ModifyDate` >= '.$request['timestamp'].'' : '' ;

		/*echo $where; exit;*/

		return $this->db->query("SELECT FL.`FacilityID`, FL.`FacilityType`, FT.`Priority`, FL.`FacilityTypeID`, FL.`FacilityName`, FL.`PRIDistrictCode` FROM facilitylist as FL Left Join facilityType as FT on FL.`FacilityTypeID` = FT.`id` where FL.`Status`=1 ".$where." ".$timestamp."  Order By FL.FacilityName Asc")->result_array();
	}

	public function GetDistrictName($District_Id='')
	{
		$query = $this->db->query("SELECT DISTINCT PRIDistrictCode, DistrictNameProperCase FROM revenuevillagewithblcoksandsubdistandgs  Where PRIDistrictCode = '".$District_Id."'")->row_array();
		return $query['DistrictNameProperCase'];
	}
	

}