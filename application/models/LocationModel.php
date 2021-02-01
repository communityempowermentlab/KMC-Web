<?php
class LocationModel extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

  
  public function GetStates() {
        
      $query = $this->db
                  ->select('*')
                  ->from('stateMaster')
                  ->order_by('stateName', 'asc')
                  ->where(array('status' => 1))
                  ->get()
                  ->result_array();
        
      return $query;
  }


  public function GetRevenueDistrict(){
    $districtData = $this
                ->db
                ->query("SELECT DISTINCT StateCode, StateNameProperCase, PRIDistrictCode , DistrictNameProperCase, STATUS FROM `revenuevillagewithblcoksandsubdistandgs` ORDER BY DistrictNameProperCase ASC")
                ->result_array();

    return $districtData;
  }

  
  public function getUrbanBlockByDistrict($PRIDistrictCode){
    $blockData = $this
                ->db
                ->query("SELECT DISTINCT PRIDistrictCode , DistrictNameProperCase, BlockPRICode , BlockPRINameProperCase, STATUS FROM `revenuevillagewithblcoksandsubdistandgs` where UrbanRural = 'Urban' and PRIDistrictCode = '".$PRIDistrictCode."' ORDER BY BlockPRINameProperCase ASC")
                ->result_array();

    return $blockData;
  }


  public function getRuralBlockByDistrict($PRIDistrictCode){
    $blockData = $this
                ->db
                ->query("SELECT DISTINCT PRIDistrictCode , DistrictNameProperCase, BlockPRICode , BlockPRINameProperCase, STATUS FROM `revenuevillagewithblcoksandsubdistandgs` where UrbanRural = 'Rural' and PRIDistrictCode = '".$PRIDistrictCode."' ORDER BY BlockPRINameProperCase ASC")
                ->result_array();

    return $blockData;
  }


  public function getUrbanVillageByBlock($BlockPRICode){
    $villageData = $this
                ->db
                ->query("SELECT DISTINCT BlockPRICode , BlockPRINameProperCase, GPPRICode, GPNameProperCase, STATUS FROM `revenuevillagewithblcoksandsubdistandgs` where UrbanRural = 'Urban' and BlockPRICode = '".$BlockPRICode."' ORDER BY GPNameProperCase ASC")
                ->result_array();

    return $villageData;
  }


  public function getRuralVillageByBlock($BlockPRICode){
    $villageData = $this
                ->db
                ->query("SELECT DISTINCT BlockPRICode , BlockPRINameProperCase, GPPRICode, GPNameProperCase, STATUS FROM `revenuevillagewithblcoksandsubdistandgs` where UrbanRural = 'Rural' and BlockPRICode = '".$BlockPRICode."' ORDER BY GPNameProperCase ASC")
                ->result_array();

    return $villageData;
  }


  public function getDynamicColData($column, $value){
    $getData = $this
                ->db
                ->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs` where ".$column." = '".$value."'")
                ->row_array();

    return $getData;
  }

  public function GetRevenueLog() {
        
      $query = $this->db
                  ->select('*')
                  ->from('revenueLocationLog')
                  ->order_by('id', 'desc')
                  ->get()
                  ->result_array();
        
      return $query;
  }

}
?>