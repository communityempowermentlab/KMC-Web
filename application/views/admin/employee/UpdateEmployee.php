 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'Edit CEL Employee';  ?></h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">  
            <form class="form-horizontal" name='Lounge'  action="<?php echo site_url('employeeM/updateEmployee/'.$GetEmployeeData['id']);?>" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
              <div class="box-body">

                <div class="col-sm-12 col-xs-12 form-group">

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Name
                         <span style="color:red">  *</span>
                    </label>
                    <input type="text" class="form-control" name="employee_name" placeholder="Name" id='employee_name' value="<?= $GetEmployeeData['name'] ?>">
                    <span class="errorMessage" id="err_employee_name"></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Mobile Number<span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Mobile Number" name="employee_mobile_number"  minlength="10" maxlength="10" id='employee_mobile_number' onchange="checkmobile(this)" value="<?= $GetEmployeeData['contactNumber'] ?>">
                    <span class="errorMessage" id="err_employee_mobile_number"></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Email Id<span style="color:red">  *</span></label>
                    <input type="text" class="form-control" placeholder="Email Id" name="employee_email" id="employee_email" onblur="checkEmail(this)" value="<?= $GetEmployeeData['email'] ?>">
                    <span class="errorMessage" id="err_employee_email"></span>
                  </div>

                  
                </div>

                
                <div class="col-sm-12 col-xs-12 form-group">

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Employee Code<span style="color:red">  *</span></label>
                    <input type="text" class="form-control" placeholder="Employee Code" name="employee_code" id="employee_code" onblur="checkEmployeeCode(this)" value="<?php echo $GetEmployeeData['employeeCode']; ?>">
                    <span class="errorMessage" id="err_employee_code"></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Password
                      <span style="color:red">  *</span>
                    </label>
                    <input type="password" id="password" class="form-control" name="password" placeholder="Password">
                    <span class="errorMessage" id="err_password"></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Photo</label>
                    <input type="file" id="fileupload" class="form-control" name="image" style="margin-bottom: 5px;">
                    <input type="hidden" name="prevFile" value="<?php echo $GetEmployeeData['profileImage']; ?>">
                    <div id="dvPreview">
                      <?php if(!empty($GetEmployeeData['profileImage'])) { ?>
                        <img src="<?php echo base_url(); ?>assets/employee/<?php echo $GetEmployeeData['profileImage']; ?>">
                      <?php } ?>

                    </div>
                    <span class="errorMessage" id="err_fileupload"></span>
                  </div>

                </div>

                <h4 style="margin-left: 15px; font-weight: 600;">Assign Menu Privilege</h4>
                <div class="col-sm-12 col-xs-12 form-group">

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Menu Group
                      <span style="color:red">  *</span>
                    </label>
                    <select class="form-control selectpicker"  name="menu_group[]" id="menu_group" aria-required="true" multiple="">
                      
                      <?php foreach ($menuGroup as $key => $value) {?>
                      <option value ="<?php echo $value['id']?>" <?php if(in_array($value['id'], $key_arr)) { echo "selected"; } ?>><?php echo $value['groupName'] ?></option>
                     <?php } ?>
                    </select>
                    <span class="errorMessage" id="err_menu_group"></span>
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

        var employee_name    = $('#employee_name').val();
        if (employee_name=='') {
          $('#err_employee_name').text('This field is required.').show();
          return false;
        }else{
          $('#err_employee_name').text('').hide();
        } 

        
        var employee_mobile_number    = $('#employee_mobile_number').val();
        var chk_mob2 = $('#err_employee_mobile_number').html();
        if (employee_mobile_number=='') {
          $('#err_employee_mobile_number').text('This field is required.').show();
          return false;
        }else{
          var Mob_filter = /^[0-9-+]+$/;
          
          if (!Mob_filter.test(employee_mobile_number) || employee_mobile_number.length != 10) {
            $('#err_employee_mobile_number').text('Invalide Phone Number').show();
            return false;
          }else{
            if(chk_mob2.length >= 5){
              return false;
            }
          } 
        } 


        var employee_email    = $('#employee_email').val();
        var chk_email = $('#err_employee_email').html();
        if (employee_email=='') {
          $('#err_employee_email').text('This field is required.').show();
          return false;
        }else{
          if(chk_email.length >= 5){
              return false;
          }
        } 


        var employee_code    = $('#employee_code').val();
        var chk_code = $('#err_employee_code').html();
        if (employee_code=='') {
          $('#err_employee_code').text('This field is required.').show();
          return false;
        }else{
          if(chk_code.length >= 5){
              return false;
          }
        } 



        var password    = $('#password').val();
        if (password=='') {
          $('#err_password').text('This field is required.').show();
          return false;
        }else{
          $('#err_password').text('').hide();
        } 


        var menu_group    = $('#menu_group').val(); 
        if (menu_group==null) {
          $('#err_menu_group').text('This field is required.').show();
          return false;
        }else{
          $('#err_menu_group').text('').hide();
        } 

        
    }


  function checkmobile(data){
    var employee_mobile_number=data.value;
    if(employee_mobile_number != ''){
      if(employee_mobile_number.length > 10 || employee_mobile_number.length < 10) {
        $('#err_employee_mobile_number').css('color', 'red').text('Enter the valid Mobile Number').show();
        return false;
      } else if((employee_mobile_number.charAt(0) != 9) && (employee_mobile_number.charAt(0) != 8) && (employee_mobile_number.charAt(0) != 7) && (employee_mobile_number.charAt(0) != 6)){
          $('#err_employee_mobile_number').css('color', 'red').text('Mobile Number is wrong.').show();
          return false;
      } else {
         $("#err_employee_mobile_number").load('<?php echo base_url('employeeM/checkLogInMobile');?>', {"mobile_number": employee_mobile_number, "column_name": "contactNumber", "table_name": "employeesData", "id": "<?php echo $GetEmployeeData['id']; ?>", "id_column": "id"});
      }
    }
  }

  function checkEmployeeCode(data){
    var employee_code=data.value;
    if(employee_code != ''){
      $("#err_employee_code").load('<?php echo base_url('employeeM/checkEmpCode');?>', {"employee_code": employee_code, "column_name": "employeeCode", "table_name": "employeesData", "id": "<?php echo $GetEmployeeData['id']; ?>", "id_column": "id"});
    }
  }

  function isValidEmailAddress(email01) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(email01);
  }

  function checkEmail(data){
    var employee_email=data.value;
    if(employee_email != ''){
      var email2 = isValidEmailAddress(employee_email);
      if(!email2) {
          $('#err_employee_email').css('color', 'red').text('Please enter valid Email Id ').show();
          return false;
      } else {
        $("#err_employee_email").load('<?php echo base_url('employeeM/checkLogInEmail');?>', {"email": employee_email, "column_name": "email", "table_name": "employeesData", "id": "<?php echo $GetEmployeeData['id']; ?>", "id_column": "id"});
      } 
    }
  }

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


  
setTimeout(function() { $(".alert-success").hide(); }, 2000);
</script>

<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> -->
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


  