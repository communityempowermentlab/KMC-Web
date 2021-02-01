<?php $dutyId = $this->uri->segment(3); 
    $getDoctorDetails = $this->db->query("SELECT * from doctor_round where id=".$dutyId." order by id desc")->row_array();
    $getStaffDetails = $this->db->query("SELECT * from staff_master where StaffID=".$getDoctorDetails['StaffID']."")->row_array();
    $loungeName = $this->db->query("SELECT * from lounge_master where LoungeID=".$getDoctorDetails['LoungeID']."")->row_array();
?>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       <?php echo 'Doctor Visit Details In Lounge '.$loungeName['LoungeName'];  ?>
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
              <div class="box-body">
             <br>
                <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Doctor Name<span style="color:red">  *</span></label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" value="<?php echo $getStaffDetails['Name'];?>" style="width: 500px;" readonly>
                  </div>
                </div><br><br>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Doctor Signature<span style="color:red">  *</span></label>
                  <div class="col-sm-10">
                   <img src="<?php echo base_url('assets/images/'); ?><?php echo $getDoctorDetails['staffSignature']; ?>" width="300" height="250" style="border: 1px solid #e3dfdf;">
                  </div>
                </div><br><br><br><br><br><br><br><br><br><br><br><br><br>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Visit Date & Time
                     <span style="color:red">  *</span>
                  </label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A",$getDoctorDetails['AddDate']); ?>" style="width: 500px;" readonly><br>
                    
                  </div>
                </div>
            </div>

          </div>
          <!-- /.box -->
         
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
<script>
function checkmobile(data){
   var lounge_contact_number=data.value;
   $("#msg").load('<?php echo base_url('Admin/checkLogInMobile');?>', {"mobile_number": lounge_contact_number});
   }
  setTimeout(function() { $(".alert-success").hide(); }, 2000);
</script>
<script type="text/javascript"> 
    function validateForm(){ 
      var Mob_filter = /^[0-9-+]+$/;
      var lounge_contact_number   = $('input[name="lounge_contact_number"]').val();
      var lounge_name             = $('input[name="lounge_name"]').val();

        if (!Mob_filter.test(lounge_contact_number)) {
          $('#Err_lounge_contact_number').text('Invalide Phone Number');
          return false;
        }else{
          return true;
        } 

        if (lounge_name=='') {
          $('#Err_lounge_name').text('Please Enter Laounge Name');
          return false;
        }else{
          return true;
        } 
    }
</script>
  <script type="text/javascript">
    setTimeout(function(){
        $('#err_pass').hide();
    },3000);

    $("#m_no1").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $("#err_mobile").addClass('alert alert-danger').html("Digits Only").show();
            setTimeout(function() { $("#err_mobile").hide(); }, 2000);
            return false;
        }
    });

    $('#err_pass').hide();

    $('#add').click(function(){

        var pass = $('#lounge_password').val();

        var paswd = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,25}$/;
        
        if(pass.match(paswd)) { 
            $('#err_pass').html('&nbsp;').show();
            return true;  
        } else {   
            $('#err_pass').css('color', 'red').html('Wrong Password! Please Try again.').show();
            return false;  
        }  
    });
</script>


  