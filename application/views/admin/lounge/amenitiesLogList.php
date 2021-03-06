<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?= $GetLoungeData['loungeName'] ?> Lounge Amenities Information Update History
        
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
      <div class="col-xs-12">
         <div class="box">
           <div  id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
           <div id="MDG"></div>

                    
          <div class="box-body">
            
            <div class="col-sm-12" style="overflow: auto;">
              <table cellpadding="0" cellspacing="0" border="0"
                class="table-striped table table-bordered editable-datatable example " id="example" >
                 <tbody>
                    <tr>  
                        <td><b>Reclining Beds (Total Numbers)</b></td>
                        <?php if(!empty($GetLounge)) { foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['totalRecliningBeds']; ?></td>
                        <?php } } else { echo '<td rowspan="69" style="text-align:center;">No Record Found.</td>'; } ?>
                    </tr>
                    <tr> 
                        <td><b>Reclining Beds (Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['functionalRecliningBeds']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Reclining Beds (Non Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['nonFunctionalRecliningBeds']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Bedside Table (Total Numbers)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['totalBedsideTable']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Bedside Table (Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['functionalBedsideTable']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Bedside Table (Non Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['nonFunctionalBedsideTable']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Colored Bedsheet & Pillow Cover</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo ($value['coloredBedsheetAvailability'] =='1') ? 'Yes':'No'; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Total Numbers</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['totalColoredBedsheet']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Functional</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['functionalColoredBedsheet']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Non Functional</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['nonFunctionalColoredBedsheet']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Reason (If No)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['coloredBedsheetReason']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Reclining Chair (Total Numbers)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['totalRecliningChair']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Reclining Chair (Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['functionalRecliningChair']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Reclining Chair (Non Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['nonFunctionalRecliningChair']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Chair & Table for Nurse</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo ($value['nursingStationAvailability'] =='1') ? 'Yes':'No'; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Total Numbers</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['totalNursingStation']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Functional</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['functionalNursingStation']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Non Functional</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['nonFunctionalNursingStation']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Reason (If No)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['nursingStationReason']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>High Stool for Weighing Scale</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo ($value['highStoolAvailability'] =='1') ? 'Yes':'No'; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Total Numbers</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['totalHighStool']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Functional</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['functionalHighStool']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Non Functional</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['nonFunctionalHighStool']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Reason (If No)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['highStoolReason']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Cubord (Total Numbers)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['totalCubord']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Cubord (Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['functionalCubord']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Cubord (Non Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['nonFunctionalCubord']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Air Conditioner (Total Numbers)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['totalAC']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Air Conditioner (Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['functionalAC']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Air Conditioner (Non Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['nonFunctionalAC']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Room Heater (Total Numbers)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['totalRoomHeater']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Room Heater (Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['functionalRoomHeater']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Room Heater (Non Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['nonFunctionalRoomHeater']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Digital Weighing Scale (Total Numbers)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['totalDigitalWeigh']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Digital Weighing Scale (Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['functionalDigitalWeigh']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Digital Weighing Scale (Non Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['nonFunctionalDigitalWeigh']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Fans (Total Numbers)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['totalFans']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Fans (Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['functionalFans']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Fans (Non Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['nonFunctionalFans']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Room Thermometer With Digital Clocks</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo ($value['roomThermometerAvailability'] =='1') ? 'Yes':'No'; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Total Numbers</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['totalRoomThermometer']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Functional</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['functionalRoomThermometer']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Non Functional</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['nonFunctionalRoomThermometer']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Reason (If No)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['roomThermometerReason']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Regular Supply Of Masks, Shoe Covers & Slippers</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo ($value['maskSupplyAvailability'] =='1') ? 'Yes':'No'; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Power Backup Facility - Invertor</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo ($value['powerBackupInverter'] =='1') ? 'Yes':'No'; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Power Backup Facility - Generator</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo ($value['powerBackupGenerator'] =='1') ? 'Yes':'No'; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Power Backup Facility - Solar</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo ($value['powerBackupSolar'] =='1') ? 'Yes':'No'; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Regular Supply Of Baby Kit</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo ($value['babyKitSupply'] =='1') ? 'Yes':'No'; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Regular Supply Of Adult Blankets</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo ($value['adultBlanketSupply'] =='1') ? 'Yes':'No'; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Digital Thermometer (Total Numbers)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['totalDigitalThermometer']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Digital Thermometer (Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['functionalDigitalThermometer']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Digital Thermometer (Non Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['nonFunctionalDigitalThermometer']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Pulse Oximeter (Total Numbers)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['totalPulseOximeter']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Pulse Oximeter (Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['functionalPulseOximeter']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Pulse Oximeter (Non Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['nonFunctionalPulseOximeter']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Blood Pressure Monitor (Total Numbers)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['totalBPMonitor']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Blood Pressure Monitor (Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['functionalBPMonitor']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Blood Pressure Monitor (Non Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['nonFunctionalBPMonitor']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Television (Total Numbers)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['totalTV']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Television (Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['functionalTV']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Television (Non Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['nonFunctionalTV']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Wall Clock (Total Numbers)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['totalWallClock']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Wall Clock (Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['functionalWallClock']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Wall Clock (Non Functional)</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['nonFunctionalWallClock']; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Availability Of KMC Register</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo ($value['kmcRegisterAvailabilty'] =='1') ? 'Yes':'No'; ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Date&nbsp;&&nbsp;Time</b></td>
                        <?php foreach ($GetLounge as $value) { 
                            $generated_on =     $this->load->FacilityModel->time_ago_in_php($value['addDate']);
                        ?>
                            <td><a href="javascript:void(0);" class="tooltip"><?php echo $generated_on; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['addDate'])) ?></span></a></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>Added&nbsp;By</b></td>
                        <?php foreach ($GetLounge as $value) {
                            $addedBy = $this->load->FacilityModel->GetDataById('adminMaster',$value['addedBy']);
                        ?>
                            <td><?php echo ucwords($addedBy['name']); ?></td>
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td><b>IP&nbsp;Address</b></td>
                        <?php foreach ($GetLounge as $value) { ?>
                            <td><?php echo $value['ipAddress']; ?></td>
                        <?php } ?>
                    </tr>
                  </tbody>
                 
              </table>
          </div>
            <!-- /.box-body -->
         </div>
          <!-- /.box -->
      </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
</div>


  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Lounges Functional Diagram</h4>
        </div>
        <div class="modal-body">
          <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/ManageLounge.png') ;?>" style="height:450px;width:100%;">
        </div>
      </div>
      
    </div>
  </div>

  <div class="modal fade" id="dfdModal" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Lounge DataFlow Diagram (DFD)</h4>
        </div>
        <div class="modal-body">
          <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/manageLoungeDFD.png') ;?>" style="height:600px;width:100%;">
        </div>
      </div>
    </div>
  </div>

