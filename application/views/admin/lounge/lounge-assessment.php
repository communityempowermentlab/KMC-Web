<style type="text/css">
  .heading_tooltip{ font-weight: bold;font-size: 0.75rem;letter-spacing:1px; }
  .tooltip .tooltiptext{ padding: 4px; }

  .assessment_pic {
    border-radius: 50%;
    width: 60px;
    height: 60px;
    cursor: pointer;
  }
</style>

    <!-- BEGIN: Content-->
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        
      <div class="content-body">


<?php
  $ID      = $this->uri->segment(3);
  $Lounge  = $this->FacilityModel->GetLoungeById($ID);
?>



<!-- Column selectors with Export Options and print table -->
<section id="column-selectors">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-12 ">
                      <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $Lounge['loungeName'];?>&nbsp;<?php echo 'Lounge Assessment'; ?></h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>loungeM/manageLounge">Lounges</a>
                          </li>
                          <li class="breadcrumb-item active">Lounge Assessment
                          </li>
                        </ol>
                      </div>
                    </div>
                    
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        
                        <div id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>

                        <div class="table-responsive">
                            <table class="table table-striped dataex-html5-selectors-log">
                                <thead>
                                    <tr>
                                      <th>Sr.&nbsp;No.</th>
                                      <th>Nurse</th>
                                      <th>Permission</th>
                                      <th>Photo</th>
                                      <th>Temperature</th>
                                      
                                      <th>Lounge</th>
                                      <th><a class="tooltip nonclick_link heading_tooltip">LOUNGE Q1 <span class="tooltiptext">No pads/ filth is lying around</span></a></th>
                                      <th><a class="tooltip nonclick_link heading_tooltip">LOUNGE Q2 <span class="tooltiptext">Outside shoes are not being worn inside the lounge</span></a></th>
                                      <th><a class="tooltip nonclick_link heading_tooltip">LOUNGE Q3 <span class="tooltiptext">There is no one inside the lounge who has visible signs of infection</span></a></th>
                                      <th><a class="tooltip nonclick_link heading_tooltip">LOUNGE Q4 <span class="tooltiptext">Hand sanitizers are available and accessible to everyone</span></a></th>
                                      <th><a class="tooltip nonclick_link heading_tooltip">LOUNGE Q5 <span class="tooltiptext">General cleanliness and hygiene is maintained inside the lounge</span></a></th>
                                      <th><a class="tooltip nonclick_link heading_tooltip">LOUNGE Q6 <span class="tooltiptext">PPE Kit Available</span></a></th>

                                      <th>Toilet</th>
                                      <th><a class="tooltip nonclick_link heading_tooltip">TOILET Q1 <span class="tooltiptext">Toilet seat is clean & toilet is flushed</span></a></th>
                                      <th><a class="tooltip nonclick_link heading_tooltip">TOILET Q2 <span class="tooltiptext">Toilet tap & washbasin have running water</span></a></th>
                                      <th><a class="tooltip nonclick_link heading_tooltip">TOILET Q3 <span class="tooltiptext">Toilet floor is clean & dry</span></a></th>
                                      <th><a class="tooltip nonclick_link heading_tooltip">TOILET Q4 <span class="tooltiptext">Handwashing soap is available</span></a></th>
                                      <th><a class="tooltip nonclick_link heading_tooltip">TOILET Q5 <span class="tooltiptext">Dustbin is present</span></a></th>

                                      <th>Washroom</th>
                                      <th><a class="tooltip nonclick_link heading_tooltip">WASHROOM Q1 <span class="tooltiptext">Washroom is clean & floor is wiped</span></a></th>
                                      <th><a class="tooltip nonclick_link heading_tooltip">WASHROOM Q2 <span class="tooltiptext">Clean bucket & mug are present</span></a></th>
                                      <th><a class="tooltip nonclick_link heading_tooltip">WASHROOM Q3 <span class="tooltiptext">There is running water in the tap</span></a></th>
                                      <th><a class="tooltip nonclick_link heading_tooltip">WASHROOM Q4 <span class="tooltiptext">Soap is available</span></a></th>
                                      <th><a class="tooltip nonclick_link heading_tooltip">WASHROOM Q5 <span class="tooltiptext">Dustbin is present</span></a></th>

                                      <th>Common Area</th>
                                      <th><a class="tooltip nonclick_link heading_tooltip">COMMON AREA Q1 <span class="tooltiptext">Common area is clean with no filth lying around</span></a></th>
                                      <th><a class="tooltip nonclick_link heading_tooltip">COMMON AREA Q2 <span class="tooltiptext">Area for washing utensils is clean</span></a></th>
                                      <th><a class="tooltip nonclick_link heading_tooltip">COMMON AREA Q3 <span class="tooltiptext">Dustbins are present in appropriate locations</span></a></th>

                                      <th>Date&nbsp;&&nbsp;Time</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php 
                                  $counter ="1";
                                  foreach ($GetAssessment as $value ) {
                                    $url = loungeDirectoryUrl.$value['loungePicture'];
                                    $getStaffDetails = $this->db->query("SELECT * from staffMaster where staffId=".$value['nurseId']."")->row_array();
                                    $generated_on =     $this->load->FacilityModel->time_ago_in_php($value['addDate']);

                                    
                                ?>
                                  <tr>
                                     <td><?php echo $counter; ?></td>
                                     <td><?php echo ucwords($getStaffDetails['name']); ?></td>
                                     
                                     <td><?php if($value['motherPermission'] == 1) { ?> Taken <!-- <span onclick="showPermissionImage('<?= $url ?>')" class="hover-image"><i class="bx bx-paperclip cursor-pointer mr-50"></i></span> --><?php } else { echo 'Not Taken'; } ?></td>

                                     <td><?php if($value['motherPermission'] == 1) { ?> <span onclick="showPermissionImage('<?= $url ?>')" class="hover-image"><img src="<?= $url ?>" class="assessment_pic"></span><?php } else { echo 'N/A'; } ?></td>
                                     
                                     <td><?php if(!empty($value['loungeTemperature'])) { echo $value['loungeTemperature']; } else { echo 'Not Working'; } ?></td>
                                     
                                     <td><span class="cursor-pointer" onclick="showDetailText('<h4>Lounge Safety</h4>', '<?= $value['noFilthLyingAround'] ?>', '<?= $value['noOutsideShoesWornInside'] ?>', '<?= $value['noOneWithInfection'] ?>', '<?= $value['sanitizerAvailability'] ?>', '<?= $value['cleanlinessMaintained'] ?>', '<?= $value['ppeAvailable'] ?>')"><?php if($value['loungeSafety'] == 1) { echo 'Safe'; } else { echo 'Unsafe'; } ?>
                                     </span></td>

                                     <td><?= $value['noFilthLyingAround']; ?></td>
                                     <td><?= $value['noOutsideShoesWornInside']; ?></td>
                                     <td><?= $value['noOneWithInfection']; ?></td>
                                     <td><?= $value['sanitizerAvailability']; ?></td>
                                     <td><?= $value['cleanlinessMaintained']; ?></td>
                                     <td><?= $value['ppeAvailable']; ?></td>

                                     <td><span class="cursor-pointer" onclick="showDetailToilet('<h4>Toilet Condition</h4>', '<?= $value['toiletClean'] ?>', '<?= $value['runningWaterToilet'] ?>', '<?= $value['toiletFloorClean'] ?>', '<?= $value['handwashAvailability'] ?>', '<?= $value['dustinPresenceToilet'] ?>')"><?php if($value['toiletCondition'] == 1) { echo 'Good'; } else { echo 'Not Good'; } ?></span></td>

                                     <td><?= $value['toiletClean']; ?></td>
                                     <td><?= $value['runningWaterToilet']; ?></td>
                                     <td><?= $value['toiletFloorClean']; ?></td>
                                     <td><?= $value['handwashAvailability']; ?></td>
                                     <td><?= $value['dustinPresenceToilet']; ?></td>

                                     <td><span class="cursor-pointer" onclick="showDetailWashroom('<h4>Washroom Condition</h4>', '<?= $value['washroomClean'] ?>', '<?= $value['cleanBucketPresent'] ?>', '<?= $value['runningWaterWashroom'] ?>', '<?= $value['soapAvailability'] ?>', '<?= $value['dustinPresenceWashroom'] ?>')"><?php if($value['washroomCondition'] == 1) { echo 'Maintained'; } else { echo 'Not Maintained'; } ?></span></td>

                                     <td><?= $value['washroomClean']; ?></td>
                                     <td><?= $value['cleanBucketPresent']; ?></td>
                                     <td><?= $value['runningWaterWashroom']; ?></td>
                                     <td><?= $value['soapAvailability']; ?></td>
                                     <td><?= $value['dustinPresenceWashroom']; ?></td>

                                     <td><span class="cursor-pointer" onclick="showDetailCommonArea('<h4>Common Area Condition</h4>', '<?= $value['commonAreaClean'] ?>', '<?= $value['washingAreaClean'] ?>', '<?= $value['dustinPresenceCommonArea'] ?>')"><?php if($value['commonAreaCondition'] == 1) { echo 'Maintained'; } else { echo 'Not Maintained'; } ?></span></td>

                                     <td><?= $value['commonAreaClean']; ?></td>
                                     <td><?= $value['washingAreaClean']; ?></td>
                                     <td><?= $value['dustinPresenceCommonArea']; ?></td>
                                     
                                     <td><a class="tooltip nonclick_link"><?php echo $generated_on; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['addDate'])) ?></span></a></td>
                                  </tr>  
                                  <?php $counter ++ ; } ?>
                                    
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Column selectors with Export Options and print table -->

<style>
  .swal2-popup {
    width: auto!important;
  }
</style>