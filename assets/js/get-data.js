/*=========================================================================================
  File Name: get-data.js
  Description: external custom js file 
==========================================================================================*/

/* for facility module */

function getDistrict(state_id, url) { 
  
  district = $('#district_name').val();
  
  $.ajax({
      url: url,
      type: 'POST',
      data: {'id': state_id, 'district': district},
      success: function(result) {
          $("#district_name").html(result);
      }
  });
}


function getBlock(district_id, url) {
  block = $('#block_name').val();
  $.ajax({
      url: url,
      type: 'POST',
      data: {'id': district_id, 'block_id': block},
      success: function(result) {
          $("#block_name").html(result);
      }
  });
}


function getVillage(block_id, url){
  GP_code = $('#vill_town_city').val();
  $.ajax({
      url: url,
      type: 'POST',
      data: {'id': block_id, 'GP_code': GP_code},
      success: function(result) {
          $("#vill_town_city").html(result);
      }
  });
}

/* for facility module */


/* for lounge module */

function getFacility(district_id, url){
  var facility = $('#facilityname').val();
  if(facility == ""){
    var facility = $('#searched_facilityname').val();
  }
  $.ajax({
      url: url,
      type: 'POST',
      data: {'districtId': district_id, 'facility': facility},
      success: function(result) {
        $("#facilityname").html(result);
      }
  });
}

function checkTabUniqueness(imeiVal, url, pageType){
  var $helpBlock = $('#tabDiv').find(".help-block").first(); 
  
  $.ajax({
      type:"POST",
      url: url,
      data: {"imeiVal":imeiVal,"pageType":pageType},
      success: function(html){
        if(html > 0){
          $helpBlock.html("<ul role=\"alert\"><li>Not a unique TAB number</li></ul>");
          $('#tabDiv').removeClass('validate');
          $('#tabDiv').addClass('issue');
        }else{
          $helpBlock.html("");
          $('#tabDiv').addClass('validate');
          $('#tabDiv').removeClass('issue');
        }
      }
    });
}

function validatePassword(password){ 
  var chkPassword = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,25}$/;
  var $helpBlock = $('#passwordDiv').find(".help-block").first(); 
  if (password!='') {
    if(password.match(chkPassword)) {
      $helpBlock.html("");
      $('#passwordDiv').addClass('validate');
      $('#passwordDiv').removeClass('issue');
    } else {    
      $helpBlock.html("<ul role=\"alert\"><li>Not a valid password</li></ul>");
      $('#passwordDiv').removeClass('validate');
      $('#passwordDiv').addClass('issue');
    }  
  } 
}

/* for lounge module */


/* for lounge amenities module */

function showDataDiv(id, val) { 
  $('.custom-error').html('').hide();
  if(val == 1){
    $('#div_'+id+'_2').hide();
    $('#div_'+id+'_1').show();
  } else {
    $('#div_'+id+'_1').hide();
    $('#div_'+id+'_2').show();
  }
}


function validateAmenities(){
    var bed_total_number = $('#bed_total_number').val(); 
    if(bed_total_number == ''){
      $('#err_bed_total_number').text('This field is required.').show();
      $('#bed_total_number').focus();
      return false;
    } else {
      $('#err_bed_total_number').html('').hide();
      
    }


    var bed_functional = $('#bed_functional').val();
    if(bed_functional == ''){
      $('#err_bed_functional').html('This field is required.').show();
      $('#bed_functional').focus();
      return false;
    } else {
      $('#err_bed_functional').html('').hide();
    }

    var bed_non_functional = $('#bed_non_functional').val();
    if(bed_non_functional == ''){
      $('#err_bed_non_functional').html('This field is required.').show();
      $('#bed_non_functional').focus();
      return false;
    } else {
      $('#err_bed_non_functional').html('').hide();
    }

    if(parseInt(bed_total_number) != parseInt(bed_functional)+parseInt(bed_non_functional)){
      $('#err_bed_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#bed_total_number').focus();
      return false;
    } else {
      $('#err_bed_total_number').html('').hide();
    }

    var table_total_number = $('#table_total_number').val();
    if(table_total_number == ''){
      $('#err_table_total_number').html('This field is required.').show();
      $('#table_total_number').focus();
      return false;
    } else {
      $('#err_table_total_number').html('').hide();
    }


    var table_functional = $('#table_functional').val();
    if(table_functional == ''){
      $('#err_table_functional').html('This field is required.').show();
      $('#table_functional').focus();
      return false;
    } else {
      $('#err_table_functional').html('').hide();
    }

    var table_non_functional = $('#table_non_functional').val();
    if(table_non_functional == ''){
      $('#err_table_non_functional').html('This field is required.').show();
      $('#table_non_functional').focus();
      return false;
    } else {
      $('#err_table_non_functional').html('').hide();
    }

    if(parseInt(table_total_number) != parseInt(table_functional)+parseInt(table_non_functional)){
      $('#err_table_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#table_total_number').focus();
      return false;
    } else {
      $('#err_table_total_number').html('').hide();
    }

    if($('.bedsheet_option').is(':checked')){
      $('#err_bedsheet_option').html('').hide();
      var bedsheet_option = $('input[name="bedsheet_option"]:checked').val(); 
      if(bedsheet_option == 1){
        var bedsheet_total_number = $('#bedsheet_total_number').val();
        if(bedsheet_total_number == ''){
          $('#err_bedsheet_total_number').html('This field is required.').show();
          $('#bedsheet_total_number').focus();
          return false;
        } else {
          $('#err_bedsheet_total_number').html('').hide();
        }


        var bedsheet_functional = $('#bedsheet_functional').val();
        if(bedsheet_functional == ''){
          $('#err_bedsheet_functional').html('This field is required.').show();
          $('#bedsheet_functional').focus();
          return false;
        } else {
          $('#err_bedsheet_functional').html('').hide();
        }

        var bedsheet_non_functional = $('#bedsheet_non_functional').val();
        if(bedsheet_non_functional == ''){
          $('#err_bedsheet_non_functional').html('This field is required.').show();
          $('#bedsheet_non_functional').focus();
          return false;
        } else {
          $('#err_bedsheet_non_functional').html('').hide();
        }

        if(parseInt(bedsheet_total_number) != parseInt(bedsheet_functional)+parseInt(bedsheet_non_functional)){
          $('#err_bedsheet_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
          $('#bedsheet_total_number').focus();
          return false;
        } else {
          $('#err_bedsheet_total_number').html('').hide();
        }

      } else {
        var bedsheet_reason = $('#bedsheet_reason').val();
        if(bedsheet_reason == ''){
          $('#err_bedsheet_reason').html('This field is required.').show();
          $('#bedsheet_reason').focus();
          return false;
        } else {
          $('#err_bedsheet_reason').html('').hide();
        }
      }
    } else {
      $('#err_bedsheet_option').html('This field is required.').show();
      $('.bedsheet_option').focus();
      return false;
    }

    var chair_total_number = $('#chair_total_number').val();
    if(chair_total_number == ''){
      $('#err_chair_total_number').html('This field is required.').show();
      $('#chair_total_number').focus();
      return false;
    } else {
      $('#err_chair_total_number').html('').hide();
    }


    var chair_functional = $('#chair_functional').val();
    if(chair_functional == ''){
      $('#err_chair_functional').html('This field is required.').show();
      $('#chair_functional').focus();
      return false;
    } else {
      $('#err_chair_functional').html('').hide();
    }

    var chair_non_functional = $('#chair_non_functional').val();
    if(chair_non_functional == ''){
      $('#err_chair_non_functional').html('This field is required.').show();
      $('#chair_non_functional').focus();
      return false;
    } else {
      $('#err_chair_non_functional').html('').hide();
    }

    if(parseInt(chair_total_number) != parseInt(chair_functional)+parseInt(chair_non_functional)){
      $('#err_chair_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#chair_total_number').focus();
      return false;
    } else {
      $('#err_chair_total_number').html('').hide();
    }

    if($('.nurse_table_option').is(':checked')){
      $('#err_nurse_table_option').html('').hide();
      var nurse_table_option = $('input[name="nurse_table_option"]:checked').val(); 
      if(nurse_table_option == 1){
        var nurse_table_total_number = $('#nurse_table_total_number').val();
        if(nurse_table_total_number == ''){
          $('#err_nurse_table_total_number').html('This field is required.').show();
          $('#nurse_table_total_number').focus();
          return false;
        } else {
          $('#err_nurse_table_total_number').html('').hide();
        }


        var nurse_table_functional = $('#nurse_table_functional').val();
        if(nurse_table_functional == ''){
          $('#err_nurse_table_functional').html('This field is required.').show();
          $('#nurse_table_functional').focus();
          return false;
        } else {
          $('#err_nurse_table_functional').html('').hide();
        }

        var nurse_table_non_functional = $('#nurse_table_non_functional').val();
        if(nurse_table_non_functional == ''){
          $('#err_nurse_table_non_functional').html('This field is required.').show();
          $('#nurse_table_non_functional').focus();
          return false;
        } else {
          $('#err_nurse_table_non_functional').html('').hide();
        }

        if(parseInt(nurse_table_total_number) != parseInt(nurse_table_functional)+parseInt(nurse_table_non_functional)){
          $('#err_nurse_table_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
          $('#nurse_table_total_number').focus();
          return false;
        } else {
          $('#err_nurse_table_total_number').html('').hide();
        }

      } else {
        var nurse_table_reason = $('#nurse_table_reason').val();
        if(nurse_table_reason == ''){
          $('#err_nurse_table_reason').html('This field is required.').show();
          $('#nurse_table_reason').focus();
          return false;
        } else {
          $('#err_nurse_table_reason').html('').hide();
        }
      }
    } else {
      $('#err_nurse_table_option').html('This field is required.').show();
      $('.nurse_table_option').focus();
      return false;
    }

    if($('.highstool_option').is(':checked')){
      $('#err_highstool_option').html('').hide();
      var highstool_option = $('input[name="highstool_option"]:checked').val(); 
      if(highstool_option == 1){
        var highstool_total_number = $('#highstool_total_number').val();
        if(highstool_total_number == ''){
          $('#err_highstool_total_number').html('This field is required.').show();
          $('#highstool_total_number').focus();
          return false;
        } else {
          $('#err_highstool_total_number').html('').hide();
        }


        var highstool_functional = $('#highstool_functional').val();
        if(highstool_functional == ''){
          $('#err_highstool_functional').html('This field is required.').show();
          $('#highstool_functional').focus();
          return false;
        } else {
          $('#err_highstool_functional').html('').hide();
        }

        var highstool_non_functional = $('#highstool_non_functional').val();
        if(highstool_non_functional == ''){
          $('#err_highstool_non_functional').html('This field is required.').show();
          $('#highstool_non_functional').focus();
          return false;
        } else {
          $('#err_highstool_non_functional').html('').hide();
        }

        if(parseInt(highstool_total_number) != parseInt(highstool_functional)+parseInt(highstool_non_functional)){
          $('#err_highstool_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
          $('#highstool_total_number').focus();
          return false;
        } else {
          $('#err_highstool_total_number').html('').hide();
        }

      } else {
        var highstool_reason = $('#highstool_reason').val();
        if(highstool_reason == ''){
          $('#err_highstool_reason').html('This field is required.').show();
          $('#highstool_reason').focus();
          return false;
        } else {
          $('#err_highstool_reason').html('').hide();
        }
      }
    } else {
      $('#err_highstool_option').html('This field is required.').show();
      $('.highstool_option').focus();
      return false;
    }

    var cubord_total_number = $('#cubord_total_number').val();
    if(cubord_total_number == ''){
      $('#err_cubord_total_number').html('This field is required.').show();
      $('#cubord_total_number').focus();
      return false;
    } else {
      $('#err_cubord_total_number').html('').hide();
    }


    var cubord_functional = $('#cubord_functional').val();
    if(cubord_functional == ''){
      $('#err_cubord_functional').html('This field is required.').show();
      $('#cubord_functional').focus();
      return false;
    } else {
      $('#err_cubord_functional').html('').hide();
    }

    var cubord_non_functional = $('#cubord_non_functional').val();
    if(cubord_non_functional == ''){
      $('#err_cubord_non_functional').html('This field is required.').show();
      $('#cubord_non_functional').focus();
      return false;
    } else {
      $('#err_cubord_non_functional').html('').hide();
    }

    if(parseInt(cubord_total_number) != parseInt(cubord_functional)+parseInt(cubord_non_functional)){
      $('#err_cubord_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#cubord_total_number').focus();
      return false;
    } else {
      $('#err_cubord_total_number').html('').hide();
    }

    var ac_total_number = $('#ac_total_number').val();
    if(ac_total_number == ''){
      $('#err_ac_total_number').html('This field is required.').show();
      $('#ac_total_number').focus();
      return false;
    } else {
      $('#err_ac_total_number').html('').hide();
    }


    var ac_functional = $('#ac_functional').val();
    if(ac_functional == ''){
      $('#err_ac_functional').html('This field is required.').show();
      $('#ac_functional').focus();
      return false;
    } else {
      $('#err_ac_functional').html('').hide();
    }

    var ac_non_functional = $('#ac_non_functional').val();
    if(ac_non_functional == ''){
      $('#err_ac_non_functional').html('This field is required.').show();
      $('#ac_non_functional').focus();
      return false;
    } else {
      $('#err_ac_non_functional').html('').hide();
    }

    if(parseInt(ac_total_number) != parseInt(ac_functional)+parseInt(ac_non_functional)){
      $('#err_ac_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#ac_total_number').focus();
      return false;
    } else {
      $('#err_ac_total_number').html('').hide();
    }

    var room_heater_total_number = $('#room_heater_total_number').val();
    if(room_heater_total_number == ''){
      $('#err_room_heater_total_number').html('This field is required.').show();
      $('#room_heater_total_number').focus();
      return false;
    } else {
      $('#err_room_heater_total_number').html('').hide();
    }


    var room_heater_functional = $('#room_heater_functional').val();
    if(room_heater_functional == ''){
      $('#err_room_heater_functional').html('This field is required.').show();
      $('#room_heater_functional').focus();
      return false;
    } else {
      $('#err_room_heater_functional').html('').hide();
    }

    var room_heater_non_functional = $('#room_heater_non_functional').val();
    if(room_heater_non_functional == ''){
      $('#err_room_heater_non_functional').html('This field is required.').show();
      $('#room_heater_non_functional').focus();
      return false;
    } else {
      $('#err_room_heater_non_functional').html('').hide();
    }

    if(parseInt(room_heater_total_number) != parseInt(room_heater_functional)+parseInt(room_heater_non_functional)){
      $('#err_room_heater_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#room_heater_total_number').focus();
      return false;
    } else {
      $('#err_room_heater_total_number').html('').hide();
    }

    var weighing_scale_total_number = $('#weighing_scale_total_number').val();
    if(weighing_scale_total_number == ''){
      $('#err_weighing_scale_total_number').html('This field is required.').show();
      $('#weighing_scale_total_number').focus();
      return false;
    } else {
      $('#err_weighing_scale_total_number').html('').hide();
    }


    var weighing_scale_functional = $('#weighing_scale_functional').val();
    if(weighing_scale_functional == ''){
      $('#err_weighing_scale_functional').html('This field is required.').show();
      $('#weighing_scale_functional').focus();
      return false;
    } else {
      $('#err_weighing_scale_functional').html('').hide();
    }

    var weighing_scale_non_functional = $('#weighing_scale_non_functional').val();
    if(weighing_scale_non_functional == ''){
      $('#err_weighing_scale_non_functional').html('This field is required.').show();
      $('#weighing_scale_non_functional').focus();
      return false;
    } else {
      $('#err_weighing_scale_non_functional').html('').hide();
    }

    if(parseInt(weighing_scale_total_number) != parseInt(weighing_scale_functional)+parseInt(weighing_scale_non_functional)){
      $('#err_weighing_scale_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#weighing_scale_total_number').focus();
      return false;
    } else {
      $('#err_weighing_scale_total_number').html('').hide();
    }

    var fan_total_number = $('#fan_total_number').val();
    if(fan_total_number == ''){
      $('#err_fan_total_number').html('This field is required.').show();
      $('#fan_total_number').focus();
      return false;
    } else {
      $('#err_fan_total_number').html('').hide();
    }


    var fan_functional = $('#fan_functional').val();
    if(fan_functional == ''){
      $('#err_fan_functional').html('This field is required.').show();
      $('#fan_functional').focus();
      return false;
    } else {
      $('#err_fan_functional').html('').hide();
    }

    var fan_non_functional = $('#fan_non_functional').val();
    if(fan_non_functional == ''){
      $('#err_fan_non_functional').html('This field is required.').show();
      $('#fan_non_functional').focus();
      return false;
    } else {
      $('#err_fan_non_functional').html('').hide();
    }

    if(parseInt(fan_total_number) != parseInt(fan_functional)+parseInt(fan_non_functional)){
      $('#err_fan_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#fan_total_number').focus();
      return false;
    } else {
      $('#err_fan_total_number').html('').hide();
    }

    if($('.thermometer_option').is(':checked')){
      $('#err_thermometer_option').html('').hide();
      var thermometer_option = $('input[name="thermometer_option"]:checked').val(); 
      if(thermometer_option == 1){
        var thermometer_total_number = $('#thermometer_total_number').val();
        if(thermometer_total_number == ''){
          $('#err_thermometer_total_number').html('This field is required.').show();
          $('#thermometer_total_number').focus();
          return false;
        } else {
          $('#err_thermometer_total_number').html('').hide();
        }


        var thermometer_functional = $('#thermometer_functional').val();
        if(thermometer_functional == ''){
          $('#err_thermometer_functional').html('This field is required.').show();
          $('#thermometer_functional').focus();
          return false;
        } else {
          $('#err_thermometer_functional').html('').hide();
        }

        var thermometer_non_functional = $('#thermometer_non_functional').val();
        if(thermometer_non_functional == ''){
          $('#err_thermometer_non_functional').html('This field is required.').show();
          $('#thermometer_non_functional').focus();
          return false;
        } else {
          $('#err_thermometer_non_functional').html('').hide();
        }

        if(parseInt(thermometer_total_number) != parseInt(thermometer_functional)+parseInt(thermometer_non_functional)){
          $('#err_thermometer_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
          $('#thermometer_total_number').focus();
          return false;
        } else {
          $('#err_thermometer_total_number').html('').hide();
        }

      } else {
        var thermometer_reason = $('#thermometer_reason').val();
        if(thermometer_reason == ''){
          $('#err_thermometer_reason').html('This field is required.').show();
          $('#thermometer_reason').focus();
          return false;
        } else {
          $('#err_thermometer_reason').html('').hide();
        }
      }
    } else {
      $('#err_thermometer_option').html('This field is required.').show();
      $('.thermometer_option').focus();
      return false;
    }

    if($('.mask_supply_option').is(':checked')){
      $('#err_mask_supply_option').html('').hide();
    } else {
      $('#err_mask_supply_option').html('This field is required.').show();
      $('.mask_supply_option').focus();
      return false;
    }

    if ($(".checkbox-input:checked").length > 0){
      $('#err_power_backup_option').html('').hide();
    } else {
      $('#err_power_backup_option').html('This field is required.').show();
      $('.checkbox-input').focus();
      return false;
    }

    if($('.babykit_supply_option').is(':checked')){
      $('#err_babykit_supply_option').html('').hide();
    } else {
      $('#err_babykit_supply_option').html('This field is required.').show();
      $('.babykit_supply_option').focus();
      return false;
    }

    if($('.blanket_supply_option').is(':checked')){
      $('#err_blanket_supply_option').html('').hide();
    } else {
      $('#err_blanket_supply_option').html('This field is required.').show();
      $('.blanket_supply_option').focus();
      return false;
    }

    var digital_thermo_total_number = $('#digital_thermo_total_number').val();
    if(digital_thermo_total_number == ''){
      $('#err_digital_thermo_total_number').html('This field is required.').show();
      $('#digital_thermo_total_number').focus();
      return false;
    } else {
      $('#err_digital_thermo_total_number').html('').hide();
    }


    var digital_thermo_functional = $('#digital_thermo_functional').val();
    if(digital_thermo_functional == ''){
      $('#err_digital_thermo_functional').html('This field is required.').show();
      $('#digital_thermo_functional').focus();
      return false;
    } else {
      $('#err_digital_thermo_functional').html('').hide();
    }

    var digital_thermo_non_functional = $('#digital_thermo_non_functional').val();
    if(digital_thermo_non_functional == ''){
      $('#err_digital_thermo_non_functional').html('This field is required.').show();
      $('#digital_thermo_non_functional').focus();
      return false;
    } else {
      $('#err_digital_thermo_non_functional').html('').hide();
    }

    if(parseInt(digital_thermo_total_number) != parseInt(digital_thermo_functional)+parseInt(digital_thermo_non_functional)){
      $('#err_digital_thermo_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#digital_thermo_total_number').focus();
      return false;
    } else {
      $('#err_digital_thermo_total_number').html('').hide();
    }


    var oximeter_total_number = $('#oximeter_total_number').val();
    if(oximeter_total_number == ''){
      $('#err_oximeter_total_number').html('This field is required.').show();
      $('#oximeter_total_number').focus();
      return false;
    } else {
      $('#err_oximeter_total_number').html('').hide();
    }


    var oximeter_functional = $('#oximeter_functional').val();
    if(oximeter_functional == ''){
      $('#err_oximeter_functional').html('This field is required.').show();
      $('#oximeter_functional').focus();
      return false;
    } else {
      $('#err_oximeter_functional').html('').hide();
    }

    var oximeter_non_functional = $('#oximeter_non_functional').val();
    if(oximeter_non_functional == ''){
      $('#err_oximeter_non_functional').html('This field is required.').show();
      $('#oximeter_non_functional').focus();
      return false;
    } else {
      $('#err_oximeter_non_functional').html('').hide();
    }

    if(parseInt(oximeter_total_number) != parseInt(oximeter_functional)+parseInt(oximeter_non_functional)){
      $('#err_oximeter_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#oximeter_total_number').focus();
      return false;
    } else {
      $('#err_oximeter_total_number').html('').hide();
    }

    var bp_total_number = $('#bp_total_number').val();
    if(bp_total_number == ''){
      $('#err_bp_total_number').html('This field is required.').show();
      $('#bp_total_number').focus();
      return false;
    } else {
      $('#err_bp_total_number').html('').hide();
    }


    var bp_functional = $('#bp_functional').val();
    if(bp_functional == ''){
      $('#err_bp_functional').html('This field is required.').show();
      $('#bp_functional').focus();
      return false;
    } else {
      $('#err_bp_functional').html('').hide();
    }

    var bp_non_functional = $('#bp_non_functional').val();
    if(bp_non_functional == ''){
      $('#err_bp_non_functional').html('This field is required.').show();
      $('#bp_non_functional').focus();
      return false;
    } else {
      $('#err_bp_non_functional').html('').hide();
    }

    if(parseInt(bp_total_number) != parseInt(bp_functional)+parseInt(bp_non_functional)){
      $('#err_bp_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#bp_total_number').focus();
      return false;
    } else {
      $('#err_bp_total_number').html('').hide();
    }


    var tv_total_number = $('#tv_total_number').val();
    if(tv_total_number == ''){
      $('#err_tv_total_number').html('This field is required.').show();
      $('#tv_total_number').focus();
      return false;
    } else {
      $('#err_tv_total_number').html('').hide();
    }


    var tv_functional = $('#tv_functional').val();
    if(tv_functional == ''){
      $('#err_tv_functional').html('This field is required.').show();
      $('#tv_functional').focus();
      return false;
    } else {
      $('#err_tv_functional').html('').hide();
    }

    var tv_non_functional = $('#tv_non_functional').val();
    if(tv_non_functional == ''){
      $('#err_tv_non_functional').html('This field is required.').show();
      $('#tv_non_functional').focus();
      return false;
    } else {
      $('#err_tv_non_functional').html('').hide();
    }

    if(parseInt(tv_total_number) != parseInt(tv_functional)+parseInt(tv_non_functional)){
      $('#err_tv_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#tv_total_number').focus();
      return false;
    } else {
      $('#err_tv_total_number').html('').hide();
    }
    
    var clock_total_number = $('#clock_total_number').val();
    if(clock_total_number == ''){
      $('#err_clock_total_number').html('This field is required.').show();
      $('#clock_total_number').focus();
      return false;
    } else {
      $('#err_clock_total_number').html('').hide();
    }


    var clock_functional = $('#clock_functional').val();
    if(clock_functional == ''){
      $('#err_clock_functional').html('This field is required.').show();
      $('#clock_functional').focus();
      return false;
    } else {
      $('#err_clock_functional').html('').hide();
    }

    var clock_non_functional = $('#clock_non_functional').val();
    if(clock_non_functional == ''){
      $('#err_clock_non_functional').html('This field is required.').show();
      $('#clock_non_functional').focus();
      return false;
    } else {
      $('#err_clock_non_functional').html('').hide();
    }

    if(parseInt(clock_total_number) != parseInt(clock_functional)+parseInt(clock_non_functional)){
      $('#err_clock_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#clock_total_number').focus();
      return false;
    } else {
      $('#err_clock_total_number').html('').hide();
    }

    if($('.kmc_register').is(':checked')){
      $('#err_kmc_register').html('').hide();
    } else {
      $('#err_kmc_register').html('This field is required.').show();
      $('.kmc_register').focus();
      return false;
    }

    
  }


/* for lounge amenities module */


  function facilityDfd(url, text) 
    { Swal.fire({ 
      text: text, 
      imageUrl: url, 
      showConfirmButton: !1,
      showCloseButton: !0
    }) 
  }


  function showPermissionImage(url){
      Swal.fire({ 
      text: "Lounge Picture", 
      imageUrl: url, 
      imageHeight: 500,
      showConfirmButton: !1,
      showCloseButton: !0
    }) 
  }


  function showNurseSelfie(url){
      Swal.fire({ 
      text: "Nurse Selfie", 
      imageUrl: url, 
      imageHeight: 500,
      showConfirmButton: !1,
      showCloseButton: !0
    }) 
  }


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


  function getStaffSubType(s_url, get_id){
      var table = 'staffType';
      var sub_staff_type = $('#sub_staff_type').val();
      $.ajax({
          data: {'table': table, 'id': get_id, 'sub_staff_type': sub_staff_type},
          url: s_url,
          type: 'post',
          success: function(data) {
              $('#sub_staff_type').html(data);
          }
      });
  }



  // function checkCelEmpMobile(employee_mobile_number, url){ 
    
  //   if(employee_mobile_number != ''){
  //     if(employee_mobile_number.length == 10) { 
  //       if((employee_mobile_number.charAt(0) != 9) && (employee_mobile_number.charAt(0) != 8) && (employee_mobile_number.charAt(0) != 7) && (employee_mobile_number.charAt(0) != 6)){
  //         $('#err_employee_mobile_number').html("Not a valid mobile number").show();
  //         return false;
  //       } else {
  //          $.ajax({
  //           type:"POST",
  //           url: url,
  //           data: {"mobile_number":employee_mobile_number, "column_name":'contactNumber', "table_name": 'employeesData', "id": '', "id_column":'id'},
  //           success: function(html){
  //             if(html > 0){
  //               $('#err_employee_mobile_number').html("Not a unique mobile number").show();
  //               return false;
  //             }else{
  //               $('#err_employee_mobile_number').html("").hide();
                
  //             }
  //           }
  //         });
  //       }
  //     } else {
  //       $('#err_employee_mobile_number').html("Not a valid mobile number").show();
  //       return false;
  //     }
  //   }
  // }


  function checkCelEmpMobile(employee_mobile_number){ 
    
    if(employee_mobile_number != ''){
      if(employee_mobile_number.length == 10) { 
        if((employee_mobile_number.charAt(0) != 9) && (employee_mobile_number.charAt(0) != 8) && (employee_mobile_number.charAt(0) != 7) && (employee_mobile_number.charAt(0) != 6)){
          $('#err_employee_mobile_number').html("Not a valid mobile number").show();
          return false;
        } else {
          $('#err_employee_mobile_number').html("").hide();
        }
      } else {
        $('#err_employee_mobile_number').html("Not a valid mobile number").show();
        return false;
      }
    }
  }


  function isValidEmailAddress(email01) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(email01);
  }


  function checkCelEmpEmail(employee_email, url, id=false){ 
    
    if(employee_email != ''){
      var email2 = isValidEmailAddress(employee_email);
      if(email2) {
        $.ajax({
            type:"POST",
            url: url,
            data: {"email":employee_email, "column_name":'email', "table_name": 'employeesData', "id": id, "id_column":'id'},
            success: function(html){
              if(html > 0){
                $('#err_employee_email').html("Not a unique email id").show();
              }else{
                $('#err_employee_email').html("").hide();
              }
            }
          });
        
      } 
    }
  }





  function checkCelEmpCode(code, url, id=false){
    if(code != ''){
      $.ajax({
          type:"POST",
          url: url,
          data: {"code":code, "column_name":'employeeCode', "table_name": 'employeesData', "id": id, "id_column":'id'},
          success: function(html){
            if(html > 0){
              $('#err_employee_code').html("Not a unique employee code").show();
            }else{
              $('#err_employee_code').html("").hide();
            }
          }
      });
    }
  }


  function celEmpValidate(type){
    var employee_name = $('#employee_name').val();
    if(employee_name == ''){
      $('#err_employee_name').html("This field is required").show();
      return false;
    } else {
      $('#err_employee_name').html("").hide();
    }

    var employee_mobile_number = $('#employee_mobile_number').val();
    if(employee_mobile_number == ''){
      $('#err_employee_mobile_number').html("This field is required").show();
      return false;
    } else {
      var chk_err = $('#err_employee_mobile_number').text().length; 
      if(chk_err > 5) {
        return false;
      }
    }
    
    var employee_email = $('#employee_email').val();
    if(employee_email == ''){
      $('#err_employee_email').html("This field is required").show();
      return false;
    } else {
      var chk_err = $('#err_employee_email').text().length; 
      if(chk_err > 5) {
        return false;
      }
    }


    var employee_code = $('#employee_code').val();
    if(employee_code == ''){
      $('#err_employee_code').html("This field is required").show();
      return false;
    } else {
      var chk_err = $('#err_employee_code').text().length; 
      if(chk_err > 5) {
        return false;
      }
    }

    if(type == 1) {   
      var password = $('#password').val();
      if(password == ''){
        $('#err_password').html("This field is required").show();
        return false;
      } else {
        $('#err_password').html("").hide();
      }
    }

    var menu_group = $('#menu_group').val();
    if(menu_group == '' || menu_group == null){
      $('#err_menu_group').html("This field is required").show();
      return false;
    } else {
      $('#err_menu_group').html("").hide();
    }
     
  }


  function checkNum(e) { 
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $('#err_cContact').css('color', 'red').text('Please enter Digits Only.').show();
            setTimeout(function() { $('#err_cContact').hide(); }, 50000000);
            e.preventDefault();
        } else {
            $('#err_cContact').css('color', 'red').text('').hide();
        }
    
    }


  function showMotherImage(url){
      Swal.fire({ 
      text: "Mother Picture", 
      imageUrl: url, 
      imageHeight: 500,
      showConfirmButton: !1,
      showCloseButton: !0
    }) 
  }


  function showBabyImage(url){
    Swal.fire({ 
      text: "Baby Picture", 
      imageUrl: url, 
      imageHeight: 500,
      showConfirmButton: !1,
      showCloseButton: !0
    }) 
  }

  function showZoomImage(url, text){
      Swal.fire({ 
      text: text, 
      imageUrl: url, 
      imageHeight: 500,
      showConfirmButton: !1,
      showCloseButton: !0
    }) 
  }


  function showEmployeeImage(url, text){
      Swal.fire({ 
      text: text, 
      imageUrl: url, 
      imageHeight: 500,
      showConfirmButton: !1,
      showCloseButton: !0
    }) 
  }


  function getLounge(facility, url){
    loungeid = $('#loungeid').val(); 
    $.ajax({
        url: url,
        type: 'POST',
        data: {'facility': facility, 'loungeid': loungeid},
        success: function(result) {
          $("#loungeid").html(result);
        }
    });
  }


  function getNurse(facility, url){
    nurseid = $('#nurseid').val(); 
    $.ajax({
        url: url,
        type: 'POST',
        data: {'nurseid': nurseid, 'facility': facility},
        success: function(result) {
          $("#nurseid").html(result);
        }
    });
  }


  function hideBlock($facilityType){
    if($facilityType == 9) {
      $('#blockDiv').hide();
      // $("#block_name").prop('required',false);
    } else {
      $('#blockDiv').show();
      // $("#block_name").prop('required',true);
    }
  }

  function getBlockList(dis_id, url, url2) {

      if($('#block_name').is(":visible")) {
       block = $('#block_name').val();
        $.ajax({
            url: url,
            type: 'POST',
            data: {'id': dis_id, 'block_id':block},
            success: function(result) {
                //alert(result);
                $("#block_name").html(result);
            }
        });
      } else {
        vill_town_city = $('#vill_town_city').val();
        $.ajax({
            url: url2,
            type: 'POST',
            data: {'id': dis_id, 'vill_town_city': vill_town_city},
            success: function(result) {
                // alert(result);
                $("#vill_town_city").html(result);
            }
        });
      }
  }


  function getVillageIfBlock(block_id, url){
    if($('#block_name').is(":visible")) {
      GP_code = $('#vill_town_city').val();
      $.ajax({
          url: url,
          type: 'POST',
          data: {'id': block_id, 'GP_code': GP_code},
          success: function(result) {
              $("#vill_town_city").html(result);
          }
      });
    }
  }


  function addFacilityValidation(){
    var bed_total_number = $('#bed_total_number').val(); 
    if(bed_total_number == ''){
      $('#err_bed_total_number').text('This field is required.').show();
      $('#bed_total_number').focus();
      return false;
    } else {
      $('#err_bed_total_number').html('').hide();
      
    }
  }


  function showPassword(id){
    var x = document.getElementById(id);
    if (x.type === "password") {
      $('#basic-addon2-password').html('<i class="bx bxs-hide"></i>');
      x.type = "text";
    } else {
      $('#basic-addon2-password').html('<i class="bx bxs-show"></i>');
      x.type = "password";
    }
  }


  function getAreaTypeBlock(area_type, url){
    district = $('#district').val();
    block = $('#block').val();
    $.ajax({
        url: url,
        type: 'POST',
        data: {'area_type': area_type, 'district':district, 'block':block},
        success: function(result) {
            //alert(result);
            $("#block").html(result);
        }
    });
  }


  function showNewDistrict(val){
    if(val == 'new'){
      $("#newDistrictDiv").show();
    } else {
      $("#newDistrictDiv").hide();
    }
  }

  function  showBlockDiv(val) {
    if(val == 'new'){
      $("#blockDiv").show();
    } else {
      $("#blockDiv").hide();
    }
  }


  function checkUniqueName(val, url, column, id, prevVal){
    $.ajax({
        url: url,
        type: 'POST',
        data: {'value': val, 'column':column, 'prevVal':prevVal},
        success: function(result) {
          if(result != 1){
            $('#err_'+id).html(result).show();
          } else {
            $('#err_'+id).html('').hide();
          }
        }
    });
  }


  function checkBlockUniqueName(val, url, column, id, prevVal){
    var district = $('#district').val();
    $.ajax({
        url: url,
        type: 'POST',
        data: {'value': val, 'column':column, 'district':district, 'prevVal':prevVal},
        success: function(result) {
          if(result != 1){
            $('#err_'+id).html(result).show();
          } else {
            $('#err_'+id).html('').hide();
          }
        }
    });
  }


  function checkVillageUniqueName(val, url, column, id, prevVal){
    var block = $('#block').val(); 
    $.ajax({
        url: url,
        type: 'POST',
        data: {'value': val, 'column':column, 'block':block, 'prevVal':prevVal},
        success: function(result) {
          if(result != 1){
            $('#err_'+id).html(result).show();
          } else {
            $('#err_'+id).html('').hide();
          }
        }
    });
  }


  function validateAddLocation(){
    var district = $('#district').val();
    if(district == ''){
      $('#err_district').html("This field is required").show();
      return false;
    } else if(district == 'new') {
      $('#err_district').html("").hide();
      var district_name = $('#district_name').val();
      if(district_name == ''){
        $('#err_district_name').html("This field is required").show();
        return false;
      } else {
        var chk_err = $('#err_district_name').text().length; 
        if(chk_err > 5) {
          return false;
        }
      }

      var district_code = $('#district_code').val();
      if(district_code == ''){
        $('#err_district_code').html("This field is required").show();
        return false;
      } else {
        var chk_err = $('#err_district_code').text().length; 
        if(chk_err > 5) {
          return false;
        }
      }
    } else {
      $('#err_district').html("").hide();
    }


    var area_type = $('#area_type').val();
    if(area_type == ''){
      $('#err_area_type').html("This field is required").show();
      return false;
    } else {
      $('#err_area_type').html("").hide();
    }

    var block = $('#block').val();
    if(block == ''){
      $('#err_block').html("This field is required").show();
      return false;
    } else if(block == 'new') {
      $('#err_block').html("").hide();
      var block_name = $('#block_name').val();
      if(block_name == ''){
        $('#err_block_name').html("This field is required").show();
        return false;
      } else {
        var chk_err = $('#err_block_name').text().length; 
        if(chk_err > 5) {
          return false;
        }
      }

      var block_code = $('#block_code').val();
      if(block_code == ''){
        $('#err_block_code').html("This field is required").show();
        return false;
      } else {
        var chk_err = $('#err_block_code').text().length; 
        if(chk_err > 5) {
          return false;
        }
      }
    } else {
      $('#err_block').html("").hide();
    }

    var village = $('#village').val();
    if(village == ''){
      $('#err_village').html("This field is required").show();
      return false;
    } else {
      var chk_err = $('#err_village').text().length; 
      if(chk_err > 5) {
        return false;
      }
    }

    var village_code = $('#village_code').val();
    if(village_code == ''){
      $('#err_village_code').html("This field is required").show();
      return false;
    } else {
      var chk_err = $('#err_village_code').text().length; 
      if(chk_err > 5) {
        return false;
      }
    }
  }


  function validateEditDistrict(){
    var district_name = $('#district_name').val();
    if(district_name == ''){
      $('#err_district_name').html("This field is required").show();
      return false;
    } else {
      var chk_err = $('#err_district_name').text().length; 
      if(chk_err > 5) {
        return false;
      }
    }

    var district_code = $('#district_code').val();
    if(district_code == ''){
      $('#err_district_code').html("This field is required").show();
      return false;
    } else {
      var chk_err = $('#err_district_code').text().length; 
      if(chk_err > 5) {
        return false;
      }
    }

    var status = $('#status').val();
    if(status == ''){
      $('#err_status').html("This field is required").show();
      return false;
    } else {
      $('#err_status').html("").hide();
    }
  }


  


  function getMultipleFacility(url){
    var district_id = $('#district').val();  
    var facility = $('#facility').val();  
    $.ajax({
        url: url,
        type: 'POST',
        data: {'districtId': district_id, 'facility': facility},
        success: function(result) {
          $("#facility").html(result);
        }
    });
  }


  function getMultipleLounge(url){
    var facility = $('#facility').val();  
    $.ajax({
        url: url,
        type: 'POST',
        data: {'facility': facility},
        success: function(result) {
          $("#lounge").html(result);
        }
    });
  }

  function getFacilityMultipleLounge(district,url,id){
    var facility = $('#facility'+district).val();  
    $.ajax({
        url: url,
        type: 'POST',
        data: {'district': district,'facility': facility,'id': id},
        success: function(result) {
          $("#lounge"+district).html(result);
        }
    });
  }

  function coachValidate(type){
    var coach_name = $('#coach_name').val();
    if(coach_name == ''){
      $('#err_coach_name').html("This field is required").show();
      return false;
    } else {
      $('#err_coach_name').html("").hide();
    }

    var coach_mobile_number = $('#coach_mobile_number').val();
    if(coach_mobile_number == ''){
      $('#err_coach_mobile_number').html("This field is required").show();
      return false;
    }else if(coach_mobile_number.length != 10){
      $('#err_coach_mobile_number').html("Enter valid mobile number").show();
      return false;
    } else {
      var chk_err = $('#err_coach_mobile_number').text().length; 
      if(chk_err > 5) {
        return false;
      }
    }

    if(type == 1) {   
      var password = $('#password').val();
      if(password == ''){
        $('#err_password').html("This field is required").show();
        return false;
      } else {
        $('#err_password').html("").hide();
      }
    }
    
    var district = $('#district').val();
    
    if(district == '' || district == null){
      $('#err_district').html("This field is required").show();
      return false;
    } else {
      $('#err_district').html("").hide();
    }

    
    var facility = $('#facility').val();
    
    if(facility == '' || facility == null){
      $('#err_facility').html("This field is required").show();
      return false;
    } else {
      $('#err_facility').html("").hide();
    }


    var lounge = $('#lounge').val();
    
    if(lounge == '' || lounge == null){
      $('#err_lounge').html("This field is required").show();
      return false;
    } else {
      $('#err_lounge').html("").hide();
    }
    
     
  }


  function checkCoachMobile(mobile, url, id=false){
    if(mobile != ''){
      
      if(mobile.length == 10) {
        $('#err_coach_mobile_number').html("").hide();
        $.ajax({
            type:"POST",
            url: url,
            data: {"mobile":mobile, "column_name":'mobile', "table_name": 'coachMaster', "id": id, "id_column":'id'},
            success: function(html){
              if(html > 0){
                $('#err_coach_mobile_number').html("Not a unique mobile number").show();
              }else{
                $('#err_coach_mobile_number').html("").hide();
              }
            }
          });
        
      } 
    }
  }


  function showDetailText (heading, val1, val2, val3, val4, val5, val6) { 
    Swal.fire({ 
      title: heading, 
      type: "", 
      html: "<ul><li>No pads/ filth is lying around - "+val1+" </li><li>Outside shoes are not being worn inside the lounge - "+val2+" </li> <li>There is no one inside the lounge who has visible signs of infection - "+val3+" </li> <li>Hand sanitizers are available and accessible to everyone - "+val4+" </li> <li>General cleanliness and hygiene is maintained inside the lounge - "+val5+" </li><li>PPE Kit Available - "+val6+" </li></ul>", 
      showCloseButton: !1, 
      showCancelButton: !1, 
      focusConfirm: !1
    }) 
  }


  function showDetailToilet (heading, val1, val2, val3, val4, val5) { 
    Swal.fire({ 
      title: heading, 
      type: "", 
      html: "<ul><li>Toilet seat is clean & toilet is flushed - "+val1+" </li><li>Toilet tap & washbasin have running water - "+val2+" </li> <li>Toilet floor is clean & dry - "+val3+" </li> <li>Handwashing soap is available - "+val4+" </li> <li>Dustbin is present - "+val5+" </li></ul>", 
      showCloseButton: !1, 
      showCancelButton: !1, 
      focusConfirm: !1
    }) 
  }


  function showDetailWashroom (heading, val1, val2, val3, val4, val5) { 
    Swal.fire({ 
      title: heading, 
      type: "", 
      html: "<ul><li>Washroom is clean & floor is wiped - "+val1+" </li><li>Clean bucket & mug are present - "+val2+" </li> <li>There is running water in the tap - "+val3+" </li> <li>Soap is available - "+val4+" </li> <li>Dustbin is present - "+val5+" </li></ul>", 
      showCloseButton: !1, 
      showCancelButton: !1, 
      focusConfirm: !1
    }) 
  }


  function showDetailCommonArea (heading, val1, val2, val3) { 
    Swal.fire({ 
      title: heading, 
      type: "", 
      html: "<ul><li>Common area is clean with no filth lying around - "+val1+" </li><li>Area for washing utensils is clean - "+val2+" </li> <li>Dustbins are present in appropriate locations - "+val3+" </li> </ul>", 
      showCloseButton: !1, 
      showCancelButton: !1, 
      focusConfirm: !1
    }) 
  }

  function checkVideoName(name, url, id=false){ 
    
    if(name != ''){
      $.ajax({
            type:"POST",
            url: url,
            data: {"name":name, "column_name":'videoName', "table_name": 'counsellingMaster', "id": id, "id_column":'id',"type":'2'},
            success: function(html){ //alert(html);
              if(html > 0){
                $('#err_video_name').html("Not a unique Video Name").show();
                $('#image').val("").focus();
              }else{
                $('#err_video_name').html("").hide();
              }
            }
          });
    }
    
  }

  function checkVideoName1(name, url, id=false){ 
    
    if(name != ''){
      $.ajax({
            type:"POST",
            url: url,
            data: {"name":name, "column_name":'videoName', "table_name": 'counsellingMaster', "id": id, "id_column":'id',"type":'1'},
            success: function(html){ //alert(html);
              if(html > 0){
                $('#err_video_name').html("Not a unique Video Name").show();
                $('#image').val("").focus();
              }else{
                $('#err_video_name').html("").hide();
              }
            }
          });
    }
    
  }