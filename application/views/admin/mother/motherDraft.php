
<style type="text/css">
  .dt-buttons, .cg_filter{ display: inline !important; width: 50% !important; float: left; }
</style>
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1><?php echo 'Manage Draft Mothers'; ?></h1> 
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">

                <div class="box-body">
                  <div class="col-sm-12" style="overflow: auto;">
                      <table id="example" class="table-striped table-bordered table example" style="width: 100% !important;">
                          <thead>
                            <tr>
                              <th>S&nbsp;No.</th>
                              <th>Lounge Name</th>
                          
                              <th>Mother&nbsp;Name</th>
                             
                              <th>Reg.&nbsp;Date&nbsp;&&nbsp;Time</th>  
                           
                            </tr>
                          </thead>
                          <tbody>
                          <?php 
                         $counter = 1;
                              foreach ($list as $val) {
                                 $checkMonitoringOrNot = $this->db->get_where('mother_monitoring',array('MotherID'=>$val['MotherID']))->num_rows();
                                 if($checkMonitoringOrNot > 0){

                                ?>
                                <tr>
                                  <td><?php echo $counter; ?></td>
                                  <td><?php echo $val['LoungeName']; ?></td>
                         
                                  <td><?php echo "<a href='".base_url()."motherM/viewMother/".$val['id']."'>".$val['MotherName']."</a>"; ?></td>
                           
                                  <td><?php echo date('d-m-Y g:i A',$val['add_date']); ?></td>
            
                                </tr>
                              
                                <?php  $counter ++ ; } } ?>
                              </tbody>
                      </table>  
<!--                     <ul class="pagination pull-right">
                      <?php
                        foreach ($links as $link) {
                            echo "<li>" . $link . "</li>";
                        }
                       ?>
                   </ul>  -->
                  </div>
                </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /.content -->
  </div>

    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Manage Mothers Functional Diagram</h4>
          </div>
          <div class="modal-body" >
           <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/MotherRegistrationProcess.png') ;?>" style="height:620px;width:100%;"> 
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
          <h4 class="modal-title">Manage Mothers DataFlow Diagram (DFD)</h4>
        </div>
        <div class="modal-body" style="padding:0px !important;">
          <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/ManageMotherDFD.png') ;?>" style="height:850px;width:100%;">
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript">
  $(document).ready(function(){
  $("#selectValue").change(function(){
   var status11 = $(this).val();
     if(status11 == 1){
       window.location.href = "<?php echo base_url().'motherM/registeredMother/'.$loungeId; ?>";
     }else if(status11 == 2){
       window.location.href = "<?php echo base_url().'motherM/registeredMother/'.$loungeId.'/admitted'; ?>";
     }else if(status11 == 3){
       window.location.href = "<?php echo base_url().'motherM/registeredMother/'.$loungeId.'/currentlyAvail'; ?>";
     }else if(status11 == 4){
       window.location.href = "<?php echo base_url().'motherM/registeredMother/'.$loungeId.'/dischargedMother'; ?>";
     }
  });
});
</script>