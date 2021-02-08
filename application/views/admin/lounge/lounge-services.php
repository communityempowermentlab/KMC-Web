

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
                      <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $Lounge['loungeName'];?>&nbsp;<?php echo 'Lounge Services'; ?></h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>loungeM/manageLounge">Lounges</a>
                          </li>
                          <li class="breadcrumb-item active">Lounge Services
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
                                      <th>Sr. No.</th>
                                      <th>Date</th>
                                      <th>Bedsheet</th>
                                      <th>Lounge<br/>(1st)</th>
                                      <th>Lounge<br/>(2nd)</th>
                                      <th>Lounge<br/>(3rd)</th>
                                      <th>Toilet/Washroom<br/>(1st)</th>
                                      <th>Toilet/Washroom<br/>(2nd)</th>
                                      <th>Toilet/Washroom<br/>(3rd)</th>
                                      <th>Dining & Common Area(1st)</th>
                                      <th>Dining & Common Area(2nd)</th>
                                      <th>Dining & Common Area(3rd)</th>
                                      <th>Meals Breakfast</th>
                                      <th>Meals Lunch</th>
                                      <th>Meals Dinner</th>
                                      <th>Drinking Water<br/>(1st)</th>
                                      <th>Drinking Water<br/>(2nd)</th>
                                      <th>Drinking Water<br/>(3rd)</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php

                                $begin = new DateTime(date('Y-m-d',strtotime($GetLounge['addDate'])));
                                $end = new DateTime(date('Y-m-d'));
                                $end = $end->modify('+1 day'); 

                                $interval = DateInterval::createFromDateString('1 day');
                                $period = new DatePeriod($begin, $interval, $end);
                                $reverse = array_reverse(iterator_to_array($period));

                                $count = 1;
                                foreach ($reverse as $dt) { 
                                  $serviceDate = $dt->format("Y-m-d");
                                  $GetFirstShiftServices = $this->LoungeModel->GetLoungeServicesByDate($serviceDate,'1',$GetLounge['loungeId']); 
                                  $GetSecondShiftServices = $this->LoungeModel->GetLoungeServicesByDate($serviceDate,'2',$GetLounge['loungeId']);
                                  $GetThirdShiftServices = $this->LoungeModel->GetLoungeServicesByDate($serviceDate,'3',$GetLounge['loungeId']);

                                  $dailyBedsheetChange = "-";
                                  if(!empty($GetFirstShiftServices['dailyBedsheetChange'])){
                                    $dailyBedsheetChange = $GetFirstShiftServices['dailyBedsheetChange'];
                                    if(empty($dailyBedsheetChange)){
                                      $dailyBedsheetChange = $GetSecondShiftServices['dailyBedsheetChange'];
                                      if(empty($dailyBedsheetChange)){
                                        $dailyBedsheetChange = $GetThirdShiftServices['dailyBedsheetChange'];
                                      }
                                    }
                                  }

                                ?>
                                    
                                    <tr>
                                        <td><?php echo $count; ?></td>
                                        <td style="min-width: 100px;"><?php echo $dt->format("d-m-Y"); ?></td>
                                        <td><?php echo $dailyBedsheetChange; ?></td>
                                        <td><?php echo ($GetFirstShiftServices['loungeSanitation'] != "")?$GetFirstShiftServices['loungeSanitation']:"-"; ?></td>
                                        <td><?php echo ($GetSecondShiftServices['loungeSanitation'] != "")?$GetSecondShiftServices['loungeSanitation']:"-"; ?></td>
                                        <td><?php echo ($GetThirdShiftServices['loungeSanitation'] != "")?$GetThirdShiftServices['loungeSanitation']:"-"; ?></td>
                                        <td><?php echo ($GetFirstShiftServices['toiletSanitation'] != "")?$GetFirstShiftServices['toiletSanitation']:"-"; ?></td>
                                        <td><?php echo ($GetSecondShiftServices['toiletSanitation'] != "")?$GetSecondShiftServices['toiletSanitation']:"-"; ?></td>
                                        <td><?php echo ($GetThirdShiftServices['toiletSanitation'] != "")?$GetThirdShiftServices['toiletSanitation']:"-"; ?></td>
                                        <td><?php echo ($GetFirstShiftServices['commonAreaSanitation'] != "")?$GetFirstShiftServices['commonAreaSanitation']:"-"; ?></td>
                                        <td><?php echo ($GetSecondShiftServices['commonAreaSanitation'] != "")?$GetSecondShiftServices['commonAreaSanitation']:"-"; ?></td>
                                        <td><?php echo ($GetThirdShiftServices['commonAreaSanitation'] != "")?$GetThirdShiftServices['commonAreaSanitation']:"-"; ?></td>
                                        <td><?php echo ($GetFirstShiftServices['mealsProvision'] != "")?$GetFirstShiftServices['mealsProvision']:"-"; ?></td>
                                        <td><?php echo ($GetSecondShiftServices['mealsProvision'] != "")?$GetSecondShiftServices['mealsProvision']:"-"; ?></td>
                                        <td><?php echo ($GetThirdShiftServices['mealsProvision'] != "")?$GetThirdShiftServices['mealsProvision']:"-"; ?></td>
                                        <td><?php echo ($GetFirstShiftServices['cleanWaterAvailability'] != "")?$GetFirstShiftServices['cleanWaterAvailability']:"-"; ?></td>
                                        <td><?php echo ($GetSecondShiftServices['cleanWaterAvailability'] != "")?$GetSecondShiftServices['cleanWaterAvailability']:"-"; ?></td>
                                        <td><?php echo ($GetThirdShiftServices['cleanWaterAvailability'] != "")?$GetThirdShiftServices['cleanWaterAvailability']:"-"; ?></td>
                                    </tr>

                                <?php $count++; } ?>
                                    
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

