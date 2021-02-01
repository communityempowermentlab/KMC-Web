<?php
if(isset($_REQUEST['mobile_number']))
{
   $mobile=$_REQUEST['mobile_number'];

?>

<?php
$data = $this->load->facility_model->checkMobile($mobile);

if($data['AdministrativeMoblieNo']==$mobile){
echo"Mobile Number Already Exits";	
 }
?>
<?php 
}?>

