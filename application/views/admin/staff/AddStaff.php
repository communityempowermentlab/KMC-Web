 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'Add Staff';  ?></h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">  
            <form class="form-horizontal" name='Lounge'  action="<?php echo site_url('staffM/AddstaffPost/');?>" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
              <div class="box-body">

                <div class="col-sm-12 col-xs-12 form-group">

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputEmail3" class="control-label" >District <span style="color:red">  *</span></label>
                    
                    <select class="form-control selectpicker" name="district_name" id="district_name" data-live-search="true" data-live-search-style="startsWith" aria-required="true" onchange="getFacility(this.value)">
                      <option value="">--Select District--</option>
                      <?php
                        foreach ($GetDistrict as $key => $value) {?>
                          <option value="<?php echo $value['PRIDistrictCode']; ?>"><?php echo $value['DistrictNameProperCase']; ?></option>
                      <?php } ?>
                    </select>
                    <span class="errorMessage" id="err_district_name"></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputEmail3" class="control-label" >Facility
                      <span style="color:red">  *</span>
                    </label>
                    <select class="form-control select2" name = "facilityname" id="facilityname"  style="width: 100%;">
                       <option value="">Select Facility</option>
                       
                    </select>
                    <span class="errorMessage" id="err_facilityname"></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Staff Name
                         <span style="color:red">  *</span>
                    </label>
                    <input type="text" class="form-control" name="Name" placeholder="Staff Name" id='staff_name'>
                    <span class="errorMessage" id="err_staff_name"></span>
                  </div>

                </div>

                  
                <div class="col-sm-12 col-xs-12 form-group">

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Select Staff Type
                      <span style="color:red">  *</span>
                    </label>
                    <select class="form-control" name="type" id="staff_type" >
                      <option value="">--Select Staff Type--</option>
                      <?php foreach ($GetStaffType as $key => $value) { ?>
                      <option value="<?php echo $value['staffTypeId'] ?>"><?php echo $value['staffTypeNameEnglish'] ?></option>
                      <?php } ?>
                    </select>
                    <span class="errorMessage" id="err_staff_type"></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Select Staff Sub Type</label>
                    <select class="form-control" name="sub_type" id="sub_staff_type" onchange="showfield(this.options[this.selectedIndex].value)"> 
                      <option value="">--Select Staff Sub Type--</option>
                    </select>
                    <div id="otherdiv">If Other: <input type="text" name="whatever" /></div>
                    <span class="errorMessage" id="err_sub_staff_type"></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Job Type
                    </label>
                    <select class="form-control" name="job_type" id="job_type">
                         <option value="">--Select Job Type--</option>
                          <?php foreach ($GetJobType as $key => $value) { ?>
                            <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                          <?php } ?>
                    </select>
                    <span class="errorMessage" id="err_job_type"></span>
                  </div>

                </div>


                <div class="col-sm-12 col-xs-12 form-group">

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Staff Mobile Number<span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" name="staff_contact_number"  minlength="10" maxlength="10" id='staff_contact_number' onchange="checkmobile(this)">
                    <span class="errorMessage" id="err_staff_contact_number"></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Emergency Contact Number</label>
                    <input type="text" class="form-control m_b_n" name="emergency_contact_number" id="emergency_contact_number"  minlength="10" maxlength="10" onchange="checkEmergencyMobile(this)">
                    <span class="errorMessage" id="err_emergency_contact_number"></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Staff Photo</label>
                    <input type="file" id="fileupload" class="form-control" name="image" style="margin-bottom: 5px;">
                    <div id="dvPreview"></div>
                    <span class="errorMessage" id="err_fileupload"></span>
                  </div>

                </div>
                  
                    
                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Staff Address</label>
                    <textarea class="form-control" rows="3" cols="3" name="address" id="address"></textarea>
                    <span class="errorMessage" id="err_address"></span>
                  </div>
                </div>

                 

              </div>
              <div class="box-footer">
                 <button type="submit" class="btn btn-info pull-right">Submit</button>
              </div>
            </form>
          </div>
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
 </div>
 <style type="text/css">
   #dvPreview img{
    width: 200px;
    height: 200px;
    border: 1px solid #a69494;
   }
 </style>
  <script type="text/javascript">
    function validateForm(){ 

        var district_name    = $('#district_name').val();
        if (district_name=='') {
          $('#err_district_name').text('This field is required.').show();
          return false;
        }else{
          $('#err_district_name').text('').hide();
        } 

        var facilityname    = $('#facilityname').val();
        if (facilityname=='') {
          $('#err_facilityname').text('This field is required.').show();
          return false;
        }else{
          $('#err_facilityname').text('').hide();
        } 

        var staff_name    = $('#staff_name').val();
        if (staff_name=='') {
          $('#err_staff_name').text('This field is required.').show();
          return false;
        }else{
          $('#err_staff_name').text('').hide();
        } 


        var staff_type    = $('#staff_type').val();
        if (staff_type=='') {
          $('#err_staff_type').text('This field is required.').show();
          return false;
        }else{
          $('#err_staff_type').text('').hide();
        } 

        // var sub_staff_type    = $('#sub_staff_type').val();
        // if (sub_staff_type=='') {
        //   $('#err_sub_staff_type').text('This field is required.').show();
        //   return false;
        // }else{
        //   $('#err_sub_staff_type').text('').hide();
        // } 


        var staff_contact_number    = $('#staff_contact_number').val();
        var chk_mob2 = $('#err_staff_contact_number').html();
        if (staff_contact_number=='') {
          $('#err_staff_contact_number').text('This field is required.').show();
          return false;
        }else{
          var Mob_filter = /^[0-9-+]+$/;
          
          if (!Mob_filter.test(staff_contact_number) || staff_contact_number.length != 10) {
            $('#err_staff_contact_number').text('Invalid Phone Number').show();
            return false;
          }else{
            if(chk_mob2.length >= 5){
              return false;
            }
          } 
        } 

        // var password    = $('#password').val();
        // if (password=='') {
        //   $('#err_password').text('This field is required.').show();
        //   return false;
        // }else{
        //   $('#err_password').text('').hide();
        // } 

        var emergency_contact_number    = $('#emergency_contact_number').val();
        if(emergency_contact_number != ''){
          var chk_mob3 = $('#err_emergency_contact_number').html();
          if(chk_mob3.length >= 5){
            return false;
          }
        }
    }


    function getFacility(districtId){
      var url = '<?php echo base_url('loungeM/getFacility/')?>';
        $.ajax({
            url: url,
            type: 'POST',
            data: {'districtId': districtId},
            success: function(result) {
                //alert(result);
                $("#facilityname").html(result);
                $('.selectpicker').selectpicker('refresh');
            }
        });
    }


  function checkmobile(data){
    var staff_contact_number=data.value;
    if(staff_contact_number != ''){
      if(staff_contact_number.length > 10 || staff_contact_number.length < 10) {
        $('#err_staff_contact_number').css('color', 'red').text('Enter the valid Staff Mobile Number').show();
        return false;
      } else if((staff_contact_number.charAt(0) != 9) && (staff_contact_number.charAt(0) != 8) && (staff_contact_number.charAt(0) != 7) && (staff_contact_number.charAt(0) != 6)){
          $('#err_staff_contact_number').css('color', 'red').text('Staff Mobile Number is wrong.').show();
          return false;
      } else {
         $("#err_staff_contact_number").load('<?php echo base_url('Admin/checkLogInMobile');?>', {"mobile_number": staff_contact_number, "column_name": "staffMobileNumber", "table_name": "staffMaster", "id": "", "id_column": "staffId"});
      }
    }
  }


  function checkEmergencyMobile(data){
    var emergency_contact_number=data.value; 
    if(emergency_contact_number != ''){
      if(emergency_contact_number.length > 10 || emergency_contact_number.length < 10) {
        $('#err_emergency_contact_number').css('color', 'red').text('Enter the valid Emergency Contact Number').show();
        return false;
      } else if((emergency_contact_number.charAt(0) != 9) && (emergency_contact_number.charAt(0) != 8) && (emergency_contact_number.charAt(0) != 7) && (emergency_contact_number.charAt(0) != 6)){
          $('#err_emergency_contact_number').css('color', 'red').text('Emergency Contact Number is wrong.').show();
          return false;
      } 
    } else {
      $('#err_emergency_contact_number').text('').hide();
    }
  }

</script>

<script>
  $(".m_b_n").keypress(function (e) {
        var id = $(this).attr('id');
        var value = $('#'+id).val();
        
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $('#err_'+id).html('<p style="color:#D2691E">Please enter Digits Only!</p>').show();
            setTimeout(function() { $('#err_'+id).hide(); }, 2000);
            return false;
        }
    });


  $("#staff_type").change(function(){
      var get_id = $(this).val();
      var table = 'staffType';
      //alert(get_id);
       var s_url = '<?php echo base_url('Admin/getStaffTypeList')?>';
            $.ajax({
                data: {'table': table, 'id': get_id},
                url: s_url,
                type: 'post',
                success: function(data) {
                    $('#sub_staff_type').html(data);
                }
            });
    });
setTimeout(function() { $(".alert-success").hide(); }, 2000);
</script>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
  $(function () {
    $("#fileupload").change(function () {
        $("#dvPreview").html("");
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
        if (regex.test($(this).val().toLowerCase())) {
            if ($.browser.msie && parseFloat(jQuery.browser.version) <= 9.0) {
                $("#dvPreview").show();
                $("#dvPreview")[0].filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = $(this).val();
            }
            else {
                if (typeof (FileReader) != "undefined") {
                    $("#dvPreview").show();
                    $("#dvPreview").append("<img />");
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("#dvPreview img").attr("src", e.target.result);
                    }
                    reader.readAsDataURL($(this)[0].files[0]);
                } else {
                    alert("This browser does not support FileReader.");
                }
            }
        } else {
            alert("Please upload a valid image file.");
        }
    });
});
</script>


  <script type="text/javascript">
function showfield(sub_type){
  if(staffType=='34')document.getElementById('otherdiv').innerHTML='Other: <input type="text" name="other" />';
  else document.getElementById('otherdiv').innerHTML='';
}
</script>