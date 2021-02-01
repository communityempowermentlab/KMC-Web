 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?php echo 'Add Facility';  ?></h1>
        <ol class="breadcrumb"> 
            <li><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>

            <li class=""><a href="<?php echo base_url(); ?>facility/manageFacility">Facilities</a></li>
            <li class="active">AddFacility</li>   
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">

                  <!-- 3 column form desig done by neha -->
            
                    <form class="form-horizontal" name='Lounge'  action="<?php echo site_url('facility/AddFacility/insert');?>" method="POST" enctype="multipart/form-data" onsubmit="return checkValidation()">
                        <div class="box-body">
          <!--   Facility Information ++++++++++++++++++++++ -->
                            <div class="col-md-12" style="margin-top:-17px;"><h3>Facility Information</h3></div>

                            <div class="col-sm-12 col-xs-12 form-group">
                              <div class="col-sm-4 col-xs-4">
                                <label for="inputEmail3" class="control-label" > Facility Name<span style="color:red">  *</span> </label>
                                <input type="text" class="form-control"  name="facility_name" id="facility_name" placeholder="Facility Name">
                                <span style="color: red; font-style: italic;" id="err_facility_name"><?php echo form_error('facility_name');?></span>
                              </div>

                              <div class="col-sm-4 col-xs-4">
                                <label for="inputEmail3" class="control-label"><?php echo 'Facility Type'#TYPE_OF_FACILITIES  ?> <span style="color:red">  *</span></label>
                                <select class="form-control"  name="facility_type" id="facility_type" placeholder ="<?php echo 'Facility Type'#TYPE_OF_FACILITIES  ?>" aria-required="true">
                                  <option value="">--Select Facility Type--</option>
                                  <?php foreach ($GetFacilities2 as $key => $value) {?>
                                  <option value ="<?php echo $value['id']?>" ><?php echo $value['facilityTypeName']#DH ?></option>
                                 <?php } ?>
                                </select>
                                <span style="color: red; font-style: italic;" id="err_facility_type"></span>
                              </div>

                              <div class="col-sm-4 col-xs-4">
                                <label for="inputEmail3" class="control-label"><?php echo 'Newborn Care Unit Type';?><span style="color:red">*</span></label>
                                <select class="form-control"  name="newborn_caring_type" id="newborn_caring_type" placeholder ="<?php echo 'Newborn Care Unit Type' ?>" aria-required="true">
                                  <option value="">--Newborn Care Unit Type--</option>
                                   <?php foreach ($NewBorn as $key => $value) {?>
                                    <option value ="<?php echo $value['id']?>" ><?php echo $value['name']#DH ?></option>
                                  <?php } ?>
                                 </select>
                                 <span style="color: red; font-style: italic;" id="err_newborn_caring_type"></span>
                              </div>

                            </div>
                
                            <div class="col-sm-12 col-xs-12 form-group">
                              <div class="col-sm-4 col-xs-4">
                                <label for="inputPassword3" class="control-label">  Management Type</label>
                                <select class="form-control"  name="facility_mange_type" id="facility_mange_type" placeholder ="<?php echo 'Management Type '#FACILITY_MANGEMENT_TYPE ?>">
                                 <option value=''>--Select Management Type--</option>
                                 <?php foreach ($Management as $key => $value) {?>
                                    <option value ="<?php echo $value['id']?>" ><?php echo $value['name']#DH ?></option>
                                  <?php } ?>
                               </select>
                               <span style="color: red; font-style: italic;" id="err_facility_mange_type"></span>
                              </div>

                              <div class="col-sm-4 col-xs-4">
                                <label for="inputPassword3" class="control-label">Govt OR Non Govt</label>
                                 <select class="form-control"  name="governmentOrNot" id="governmentOrNot" placeholder ="<?php echo 'government ord(string) Not '#FACILITY_MANGEMENT_TYPE ?>">
                                  <option>--Select Govt OR Non Govt--</option>
                                   <?php foreach ($GovtORNot as $key => $value) {?>
                                      <option value ="<?php echo $value['id']; ?>" ><?php echo $value['name']; ?></option>
                                    <?php } ?>
                                 </select>
                                 <span style="color: red; font-style: italic;" id="err_governmentOrNot"></span> 
                              </div>

                              <!-- <div class="col-sm-4 col-xs-4">
                                <label for="inputEmail3" class="control-label" ><?php echo ' KMC Lounge Status'#KMC_LOUNGE_PRESENT ?> </label>
                                 <select class="form-control"  name="kmc_present" id="kmc_present" placeholder ="<?php echo  ' KMC Lounge Status'#KMC_LOUNGE_PRESENT ?>">
                                    <option value=''>--Select KMC Lounge Status--</option>
                                    <option value ="2" ><?php echo 'NO' ?></option>
                                    <option value ="1" ><?php echo 'YES' ?></option>
                                 </select>
                                 <span style="color: red; font-style: italic;" id="err_kmc_present"></span> 
                              </div> -->

                              <div class="col-sm-4 col-xs-4">
                                <label for="inputEmail3" class="control-label"><?php echo 'KMC Unit Start' ?></label>
                                <input type ="date" class="form-control" name="kmcunitstart" id="kmcunitstart">
                                <span style="color: red; font-style: italic;" id="err_kmcunitstart"></span> 
                              </div>

                            </div>


                            <div class="col-sm-12 col-xs-12 form-group">

                              <div class="col-sm-4 col-xs-4">
                                <label for="inputEmail3" class="control-label"><?php echo 'KMC Unit Close' ?>  </label> 
                                <input type ="date" class="form-control" name="kmcunitclose" id="kmcunitclose">
                                <span style="color: red; font-style: italic;" id="err_kmcunitclose"></span> 
                              </div>

                            </div>
                        
              
               <!--   Admin Information ++++++++++++++++++++++ -->
                <div class="col-md-12" style="margin-top:-17px;"><h3>Address Information</h3></div>

                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                    <label for="inputEmail3" class="control-label"><?php echo 'District Name' ?> <span style="color:red">  *</span></label>
                    <select class="form-control selectpicker" name="district_name" id="district_name" data-live-search="true" data-live-search-style="startsWith" aria-required="true">
                      <option value="">--Select District--</option>
                      <?php
                        foreach ($selectquery as $key => $value) {?>
                          <option value="<?php echo $value['PRIDistrictCode']; ?>"><?php echo $value['DistrictNameProperCase']; ?></option>
                      <?php } ?>
                    </select>
                    <span style="color: red; font-style: italic;" id="err_district_name"></span> 
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputEmail3" class="control-label"><?php echo 'Block Name'#BLOCK_NAME ?> <span style="color:red">  *</span></label>
                    <select class="form-control selectpicker" name="block_name" id="block_name" data-live-search="true" data-live-search-style="startsWith" aria-required="true">
                      <option value="">--Select Block--</option>
                      
                    </select>
                    <span style="color: red; font-style: italic;" id="err_block_name"></span> 
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputEmail3" class="control-label"><?php echo 'Village/Town/City Name' ?> <span style="color:red">  *</span></label>
                    <select class="form-control selectpicker" name="vill_town_city" id="vill_town_city" data-live-search="true" data-live-search-style="startsWith" aria-required="true">
                            <option value="">--Select Village/Town/City--</option>
                        
                    </select>
                    <span style="color: red; font-style: italic;" id="err_vill_town_city"></span>
                  </div>
                </div>

                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                    <label for="inputEmail3" class="control-label"><?php echo "Facility Address" ?> 
                        <span style="color:red">  * </span>
                    </label>
                    <textarea class="form-control"  rows="3" name="facility_address" id="facility_address" style= "resize: none;" placeholder="<?php echo "Facility Address" ?>" ></textarea>
                    <span style="color: red; font-style: italic;" id="err_facility_address"></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputEmail3" class="control-label"><?php echo 'Country Name' ?>    <span style="color:red">  *</span></label>
                    <select class="form-control selectpicker" name="country_name" id="country_name" data-live-search="true" data-live-search-style="startsWith" aria-required="true">
                      <option value="">--Select Country--</option>
                      <?php
                        foreach ($selectCountry as $key => $value) {?>
                          <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?>   </option>
                      <?php } ?>
                    </select>
                    <span style="color: red; font-style: italic;" id="err_country_name"></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputEmail3" class="control-label"><?php echo 'State Name' ?> <span style="color:red">  *</span></label>
                    <select class="form-control selectpicker" name="state_name" id="state_name" data-live-search="true" data-live-search-style="startsWith" aria-required="true">
                      <option value="">--Select State--</option>
                    </select>
                    <span style="color: red; font-style: italic;" id="err_state_name"></span>
                  </div>
                </div>



               <!--   Admin Information ++++++++++++++++++++++ -->
                <div class="col-md-12" style="margin-top:-17px;"><h3>Admin Information</h3></div>


                <div class="col-sm-12 col-xs-12 form-group">
                  <!-- <div class="col-sm-4 col-xs-4">
                    <label for="inputEmail3" class="control-label"><?php echo 'Administration Phone Number' ?> <span style="color:red">  *</span></label>
                    <input type ="text" class="form-control" maxlength="10" name="contact_number" id="mob2" placeholder ="<?php echo 'Administration Phone Number' ?>" onchange="checkmobile(this)">
                    <span>This Number is also used as facility login on dashboard</span><br>
                    <span style="color: red; font-style: italic;" id="err_mob2"></span>
                  </div>
 -->
                  <div class="col-sm-4 col-xs-4">
                    <label for="inputEmail3" class="control-label"><?php echo 'CMS/MOIC Name' ?> </label>
                    <input type ="text" class="form-control" name="cms_moic_name" id="cms_moic_name" placeholder ="<?php echo 'CMS/MOIC Name' ?>">
                    <span style="color: red; font-style: italic;" id="err_cms_moic_name"></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputEmail3" class="control-label"><?php echo 'CMS/MOIC Phone Number' ?></label>
                    <input type ="text" class="form-control" maxlength="10" name="phone_cms_moic_name" id="mob3" placeholder ="<?php echo 'CMS/MOIC Phone Number' ?>" onchange="checkCMSMobile(this)">
                    <span style="color: red; font-style: italic;" id="err_mob3"></span>
                  </div>
                </div>
  
                <div class="box-footer">               
                  <button type="submit" class="btn btn-info pull-right">Submit</button>
                </div>
            </div>
            </form>
          </div>
         </div>
      </div>
    </section>
</div>

<script type="text/javascript">
    $(document).on("change","input[name=Banner_On]",function(){
        var BanneType = $('[name="Banner_On"]:checked').val();
        var Url = "<?php  echo base_url('admin/Dashboard/Get_SubCat_Product_list')?>/"+BanneType;
        
        $.ajax({
            type: "POST",
            url: Url,
            success: function(result){
                alert(result);
                if(result!='') {
                    $('#sub_product_list').html(result);
                } else {
                    $('#sub_product_list').html('');
                }
            }
        });
    });

    $("#mob2").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            $("#err_mob2").css('color', 'red').html("Digits Only").show();
            setTimeout(function() { $("#err_mob2").hide(); }, 2000);
            return false;
        }
    });

    $("#mob3").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            $("#err_mob3").css('color', 'red').html("Digits Only").show();
            setTimeout(function() { $("#err_mob3").hide(); }, 2000);
            return false;
        }
    });

    $('#district_name').on('change', function() {
        var dis_id = $(this).val();
        var url = '<?php echo base_url('Admin/getBlock/')?>';
        $.ajax({
            url: url,
            type: 'POST',
            data: {'id': dis_id},
            success: function(result) {
                //alert(result);
                $("#block_name").html(result);
                $('.selectpicker').selectpicker('refresh');
            }
        });
    });

    $('#block_name').on('change', function() {
        var dis_id = $(this).val();
        //alert(dis_id);
        var url = '<?php echo base_url('Admin/getVillage/')?>';
        $.ajax({
            url: url,
            type: 'POST',
            data: {'id': dis_id},
            success: function(result) {
                //console.log(result);
                $("#vill_town_city").html(result);
                $('.selectpicker').selectpicker('refresh');
            }
        });
    });

    $('#country_name').on('change', function() {
        var dis_id = $(this).val();
        var url = '<?php echo base_url('Admin/getState/')?>';
        $.ajax({
            url: url,
            type: 'POST',
            data: {'id': dis_id},
            success: function(result) {
                //console.log(result);
                $("#state_name").html(result);
                $('.selectpicker').selectpicker('refresh');

            }
        });
    });

     // validation code added by neha

    function checkValidation(){
      var facility_name = $('#facility_name').val();
      if(facility_name == ''){
        $('#err_facility_name').html('This field is required.').show();
        return false;
      } else {
        $('#err_facility_name').html('').hide();
      }

      var facility_type = $('#facility_type').val();
      if(facility_type == ''){
        $('#err_facility_type').html('This field is required.').show();
        return false;
      } else {
        $('#err_facility_type').html('').hide();
      }

      var newborn_caring_type = $('#newborn_caring_type').val();
      if(newborn_caring_type == ''){
        $('#err_newborn_caring_type').html('This field is required.').show();
        return false;
      } else {
        $('#err_newborn_caring_type').html('').hide();
      }

      var district_name = $('#district_name').val();
      if(district_name == ''){
        $('#err_district_name').html('This field is required.').show();
        return false;
      } else {
        $('#err_district_name').html('').hide();
      }

      var block_name = $('#block_name').val();
      if(block_name == ''){
        $('#err_block_name').html('This field is required.').show();
        return false;
      } else {
        $('#err_block_name').html('').hide();
      }

      var vill_town_city = $('#vill_town_city').val();
      if(vill_town_city == ''){
        $('#err_vill_town_city').html('This field is required.').show();
        return false;
      } else {
        $('#err_vill_town_city').html('').hide();
      }

      var facility_address = $('#facility_address').val();
      if(facility_address == ''){
        $('#err_facility_address').html('This field is required.').show();
        return false;
      } else {
        $('#err_facility_address').html('').hide();
      }

      var country_name = $('#country_name').val();
      if(country_name == ''){
        $('#err_country_name').html('This field is required.').show();
        return false;
      } else {
        $('#err_country_name').html('').hide();
      }
      
      var state_name = $('#state_name').val();
      if(state_name == ''){
        $('#err_state_name').html('This field is required.').show();
        return false;
      } else {
        $('#err_state_name').html('').hide();
      }

      // var mob2 = $('#mob2').val();
      // var chk_mob2 = $('#err_mob2').html();
      // if(mob2 == ''){
      //   $('#err_mob2').html('This field is required.').show();
      //   return false;
      // } else {
      //   if(chk_mob2.length >= 5){
      //     return false;
      //   }
        
      // }


      
    }

</script>
<script>
  function checkmobile(data){ 
    var contact_number=data.value; 
    if(contact_number != ''){
      if(contact_number.length > 10 || contact_number.length < 10) {
        $('#err_mob2').css('color', 'red').text('Enter the valid Administration Phone Number').show();
        return false;
      } else if((contact_number.charAt(0) != 9) && (contact_number.charAt(0) != 8) && (contact_number.charAt(0) != 7) && (contact_number.charAt(0) != 6)){
          $('#err_mob2').css('color', 'red').text('Administration Phone Number is wrong.').show();
          return false;
        } else {
          $("#err_mob2").load('<?php echo base_url('Admin/checkLogInMobile');?>', {"mobile_number": contact_number, "column_name": "AdministrativeMoblieNo", "table_name": "facilitylist", "id": "", "id_column": "FacilityID"});
        }
    }
  }

  function checkCMSMobile(data){
    var contact_number=data.value; 
    if(contact_number != ''){
      if(contact_number.length > 10 || contact_number.length < 10) {
        $('#err_mob3').css('color', 'red').text('Enter the valid CMS/MOIC Phone Number').show();
        return false;
      } else if((contact_number.charAt(0) != 9) && (contact_number.charAt(0) != 8) && (contact_number.charAt(0) != 7) && (contact_number.charAt(0) != 6)){
          $('#err_mob3').css('color', 'red').text('CMS/MOIC Phone Number is wrong.').show();
          return false;
        } else {
          $('#err_mob3').text('').hide();
        }
    }
  }

  setTimeout(function() { $(".alert-success").hide(); }, 2000);
</script>