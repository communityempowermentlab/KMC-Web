 <script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script> 
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       <?php echo 'Add Lounge';  ?>
       
      </h1>
     
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
       
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div  id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
            <form class="form-horizontal" name='Lounge'  action="<?php echo site_url('loungeM/addLounge/');?>" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
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
                    <label for="inputEmail3" class="control-label" >Facility <span style="color:red">  *</span></label>
                    
                    <select class="form-control select2" name = "facility_id" id="facilityname"  style="width: 100%;">
                       <option value="">Select Facility</option>
                       
                    </select>
                    <span class="errorMessage" id="err_facilityname"></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputEmail3" class="control-label" >Select MNCU Unit Type
                     <span style="color:red">  *</span>
                    </label>
                    <select class="form-control select2" name = "loungeType" id="loungeType"  style="width: 100%;">
                       <option value="">Select Type</option>
                       <option value="2">Lounge</option>
                       <option value="1">SNCU</option>
                    </select>
                    <span class="errorMessage" id="err_loungeType"></span>
                  </div>

                  

                </div>

                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Lounge Name
                     <span style="color:red">  *</span>
                    </label>
                    <input type="text" class="form-control" name="lounge_name" id='lounge_name' placeholder="Lounge Name">
                    <span class="errorMessage" id="err_lounge_name"><?php echo form_error('lounge_name');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> TAB Unique Number
                       <!-- <span style="color:red">  *</span> -->
                    </label>
                    <input type="number" class="form-control" name="imeiNumber" id="imei" placeholder="TAB Unique Number" onblur="checkTabUniqueness(this.value)">
                    <span class="errorMessage" id="err_imei"></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                     <label for="inputEmail3" class="control-label">Lounge Mobile Number
                      <!-- <span style="color:red"> *</span> -->
                      </label>
                      <span class="errorMessage" style="color:red;" id="msg"></span>
                       <input type="text" class="form-control" name="lounge_contact_number" minlength="10" maxlength="10" id='lounge_contact_number' placeholder="Lounge Mobile Number" onchange="checkmobile(this)">
                       
                      
                       <span class="errorMessage" id="err_lounge_contact_number"></span>
                  </div>

                  
                  
                </div>


                

                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                     <label for="inputEmail3" class="control-label">Lounge Password
                      <span style="color:red"> *</span></label>
                      <input type="password" class="form-control" name="lounge_password" required="" placeholder="Lounge Password" id='lounge_password'>

                      
                      <span id="err_lounge_password" class="errorMessage"></span>
                  </div>


                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Lounge Address
                     <span style="color:red">  *</span>
                    </label>
                    <textarea class="form-control" rows="3" id="addr" name="address"></textarea>
                    <span class="errorMessage" id="err_addr"></span>
                  </div>
                </div>

                

            </div>
              <!-- /.box-body -->
              <div class="box-footer">
                
                <button type="submit" class="btn btn-info pull-right" id="add">Submit</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
         
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

  <script type="text/javascript">
    
    function validateForm(){ 
      
        var addr    = $('#addr').val();
        if (addr =='') {
          $('#err_addr').text('This field is required.').show();
          return false;
        }else{
          $('#err_addr').text('').hide();
        } 
        
    }

  
function checkmobile(data){
  var lounge_contact_number=data.value;
  if(lounge_contact_number != ''){
    if(lounge_contact_number.length > 10 || lounge_contact_number.length < 10) {
      $('#err_lounge_contact_number').css('color', 'red').text('Enter the valid Lounge Mobile Number').show();
      return false;
    } else if((lounge_contact_number.charAt(0) != 9) && (lounge_contact_number.charAt(0) != 8) && (lounge_contact_number.charAt(0) != 7) && (lounge_contact_number.charAt(0) != 6)){
        $('#err_lounge_contact_number').css('color', 'red').text('Lounge Mobile Number is wrong.').show();
        return false;
    } else {
       $("#err_lounge_contact_number").load('<?php echo base_url('Admin/checkLogInMobile');?>', {"mobile_number": lounge_contact_number, "column_name": "loungeContactNumber", "table_name": "loungeMaster", "id": "", "id_column": "loungeId"});
    }
  }
}

  setTimeout(function() { $(".alert-success").hide(); }, 2000);
</script>

<script type="text/javascript">
    setTimeout(function(){
        $('#err_pass').hide();
    },3000);

    $("#lounge_contact_number").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $("#err_lounge_contact_number").html("Digits Only").show();
            setTimeout(function() { $("#err_lounge_contact_number").hide(); }, 2000);
            return false;
        }
    });

    $('#err_pass').hide();

    $('#add').click(function(){

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

        var loungeType    = $('#loungeType').val();
        if (loungeType=='') {
          $('#err_loungeType').text('This field is required.').show();
          return false;
        }else{
          $('#err_loungeType').text('').hide();
        } 

        var lounge_name    = $('#lounge_name').val();
        if (lounge_name=='') {
          $('#err_lounge_name').text('This field is required.').show();
          return false;
        }else{
          $('#err_lounge_name').text('').hide();
        } 

        

        var chkImei    = $('#err_imei').html(); 
        if (chkImei.length > 5) {
          return false;
        }

        
        

        var lounge_contact_number    = $('#lounge_contact_number').val();
        var chk_mob2 = $('#err_lounge_contact_number').html();
        var Mob_filter = /^[0-9-+]+$/;
        if (lounge_contact_number !='') {
          if (!Mob_filter.test(lounge_contact_number) || lounge_contact_number.length != 10) {
            $('#err_lounge_contact_number').text('Invalid Contact Number.').show();
            return false;
          } else {
            if(chk_mob2.length >= 5){
              return false;
            }
          }
          
        } 


        var lounge_password = $('#lounge_password').val();

        var paswd = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,25}$/;
        if (lounge_password=='') {
          $('#err_lounge_password').css('color', 'red').html('This field is required.').show();
          return false;
        }else{
          if(lounge_password.match(paswd)) { 
            $('#err_lounge_password').html('').hide();
            return true;  
          } else {   
              $('#err_lounge_password').css('color', 'red').html('Invalid Password! Passwords must contain at least six characters, including letters, symbols and numbers.').show();
              return false;  
          }  
        } 
        
    });

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

  // check imei number at the time of submit

  function checkTabUniqueness(imeiVal){ 
    var loungeMasterId = $("#loungeMasterId").val();
    var pageType = "add";
    $.ajax({
      type:"POST",
      url: "<?php echo site_url('loungeM/checkExistImei')?>",
      data: {"imeiVal":imeiVal,"pageType":pageType},
      success: function(html){
        if(html > 0){
          $("#err_imei").css('color', 'red').html("Tab Number is not unique!!");
        }else{
          $("#err_imei").html("");
        }
      }
    });
  }


</script>


  