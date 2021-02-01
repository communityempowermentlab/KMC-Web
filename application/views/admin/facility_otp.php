<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>The Kangaroo Care Project | Facility Panel Login</title>
  <!-- Tell the browser to be responsive to screen width -->
<link rel="shortcut icon" href="<?php echo site_url();?>assets/favicon_1.ico" type="image/x-icon"> 
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="<?php echo site_url(); ?>assets/admin/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo site_url('assets/images/android-icon-36x36.png'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo site_url(); ?>assets/admin/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo site_url(); ?>assets/admin/dist/css/skins/_all-skins.min.css">
   <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo site_url(); ?>assets/admin/plugins/iCheck/square/blue.css">
  
 
  <script src="<?php echo site_url(); ?>assets/admin/plugins/jQuery/jQuery-2.2.0.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <!-- <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script> -->
  <script src="<?php echo site_url(); ?>assets/admin/js/jquery-ui.min.js"></script>

  <script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms2").fadeOut(5000);
  }



  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
  

  <style type="text/css">
  /* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 9999; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;

    /*padding: 23px;*/
    border: 1px solid #888;
    width: 37%;
}

/* The Close Button */
.close {
    color: #820505;
    float: right;
    font-size: 28px;
    font-weight: bold;
    padding-right: 13px;
}

.login-page2{
  background-image: url(<?php  echo base_url('/assets/kmc2.png');?>) !important;



}

@media screen and (min-width: 480px ) {
    body {
        background-size:  1500px;
    }
}
@media screen and (max-width: 1500px) {
    body {
        background-size:  100%;

    }
}
/*@media screen and (min-width: 480px) {
    body {
        background-size:  1500px;
    }
}*/
.login-page1{

  background-image: url(<?php  echo base_url('/assets/bg1.png');?>) !important;

}
.login-page3{
  background-image: url(<?php  echo base_url('/assets/vendor.png');?>) !important;

}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
   </style>
</head>

<body class="hold-transition login-page2" >
<div class="login-box">
  <!-- /.login-logo -->
  <div class="login-box-body">
  <div class="login-logo">
   <a href="<?php echo base_url();?>Admin/"><img src="<?php echo site_url().'assets/logo_white.png' ?>" style="max-width:320px;"></a> <br/> <?php  echo  'Facility Panel' ;?>
  </div>
    <?php  $id = $this->uri->segment(3); 
     $admin   = $this->load->FacilityModel->FindMobileForResend($id);

    ?>
    <p class="login-box-msg">Please enter the verification code send to your mobile number:&nbsp;<?php echo $admin['AdministrativeMoblieNo'];?></p>
    <?php echo $this->session->flashdata('login_message');
    
     ?>
   <script>
    setTimeout(function() { $(".alert-success").hide(); }, 2000);
  </script>
   <form method="post" action="<?php echo site_url().'facility/doLogin'; ?>">
      <div class="form-group has-feedback">
                
        <input oninput="maxLengthCheck(this)" type = "number" maxlength = "6"  min = "0" max = "999999" name="otp" class="form-control" placeholder="Enter OTP" required >
        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             <span style="color:red;" id="countdown" class="timer"></span>
            </label>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">

          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
     



       



  <div id="myModal" class="modal" style="">
  <!-- Modal content -->


  <div class="modal-content">
    <span class="close">&times;</span>
    <div class="panel panel-warning">
      <div class="panel-heading" id="heading"></div><br>
     
    <form name="registration" id ="registration" class="form-horizontal" >
    <div   class="col-md-12" id="hiddenSms2"> </div>
    <span id="ErrorState" style=""></span>
    <input type="hidden" class="form-control pull-right" id="offerDetail" name="infodetail">
   
    <div class="form-group">
      <label for="password" class="col-sm-3 control-label" >Email-id</label>
        <div class="input-group col-sm-8">
          <!-- <i class="fa fa-calendar"></i> -->
          <input type="text" class="form-control pull-right" name="Femail" id="Femail"  placeholder= "Enter Email-id">
      </div>
    </div>
    <div class="box-footer">
       <button type="button" onclick="ForgetPassword()" class="btn btn-info pull-right" id="updateBtn"> </button>
      
    </div>
    </form>
    </div>
  </div>

</div>
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo base_url('assets/admin/dist/jquery.min.js')?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/admin/dist/js/bootstrap.min.js')?>"></script>
<!-- iCheck -->
<script src="<?php echo base_url('assets/admin/plugins/iCheck/icheck.min.js')?>"></script>
<script>


function ForgetPassword(){
  var email   =  $("input[name='Femail']").val();
  //alert(email);
  
  var type = "<?php echo $this->uri->segment(1); ?>";
  
  if(type=='school'){
  
  var Url = "<?php echo site_url('admin/School/ForgetPassword');?>";
  }
  if(type=='vendor'){
  
  var Url = "<?php echo site_url('admin/Vendor/ForgetPassword');?>";
  }
  //alert(Url);

  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  var check =    emailReg.test(email);
   if(check==true){

      //alert(start);alert(end);alert(offerType);alert(amount);alert(id);
      $.ajax({ 
          type: "POST", 
          url:  Url,
          data: "email="+email, 
          success:function(response){
              console.log(response);
                  if(response > 0)
                  {
                    $("#hiddenSms2").html("<b style='color:green; text-align:center;'>Password is sent to your Email id</b>");

                    setTimeout(function() {
                        window.location.reload();
                        }, 3000);
                  }
        } 
       });

   }else{

    $("#hiddenSms2").html("<b style='color:red; text-align:center;'>Invalid email id</b>");

   }

  
}

function AddDeal(){
    
  $('#myModal').css("display","block"); 
  $('#heading').text('Forget Password');
  $('#updateBtn').text('submit');

} 


var modal = document.getElementById('myModal');
// Get the button that opens the modal
var btn = document.getElementById("myBtn");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
// When the user clicks the button, open the modal 

span.onclick = function() {
    modal.style.display = "none";
  }
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
  }
 


  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
           <script>
              var seconds = 60;
              function secondPassed() {
              var minutes = Math.round((seconds - 30)/60);
              var remainingSeconds = seconds % 60;
              var href = '<a href="<?php echo base_url();?>Facility/ResendOtp/<?php echo $id; ?>">Resend OTP</a>';
              if (remainingSeconds < 10) {
               remainingSeconds = "0" + remainingSeconds;  
               }
              document.getElementById('countdown').innerHTML = minutes + ":" + remainingSeconds;
              if (seconds == 0) {
               clearInterval(countdownTimer);
              document.getElementById('countdown').innerHTML = href;
              } else {
              seconds--;
              }
              }
              var countdownTimer = setInterval('secondPassed()', 1000);
            </script>
             
             <script>
             function maxLengthCheck(object) {
            if (object.value.length > object.maxLength)
            object.value = object.value.slice(0, object.maxLength)
             }
</script>
</body>
</html>
