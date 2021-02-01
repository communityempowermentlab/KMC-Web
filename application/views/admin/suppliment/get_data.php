<?php
if(isset($_REQUEST['suppliment_name']))
{
   $name=$_REQUEST['suppliment_name']; 

?>

<?php
$data = $this->load->facility_model->checkSupplimentName($name);

if($data['Name']==$name){
  echo"Suppliment Already Exits";	
 }
?>
<?php 
}?>
