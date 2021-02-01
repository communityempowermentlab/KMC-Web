<?php
if(isset($_REQUEST['mobile_number']))
{
  $mobile=$_REQUEST['mobile_number'];
?>

<?php
$data = $this->load->UserModel->checkMobile($mobile);

if($data['LoungeContactNo']==$mobile){
echo"Mobile Number Already Exits";	
 }
?>
<?php 
}?>

