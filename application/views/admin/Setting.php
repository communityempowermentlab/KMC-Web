 <script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Manage Settings
       </h1>
     
      
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
      <div class="row">
        <div class="col-md-8">   
          <div class="box box-info">
            
           
            <form class="form-horizontal"  action="<?php echo site_url('admin/Dashboard/Settings');?>" method="POST" enctype="multipart/form-data">
            
            <h3  style="text-align: center; ">Google Console Setting </h3>
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">App Version</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control"  name="app_verison" id="app_verison" placeholder="App Version" required value = "<?php  echo $getData['app_verison']?>">
                  </div>
                  <span style="color: red;"><?php echo form_error('app_verison');?></span>
                </div>
                
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Application Type</label>

                  <div class="col-sm-10">
                    <Select class="form-control"  name="type" id="type" placeholder="Application Type">
                    <option value= "Soft" <?php  echo ($getData['type']=='Soft') ? 'Selected' :''  ?> >Soft</option>
                    <option value= "Hard" <?php  echo ($getData['type']=='Hard') ? 'Selected' :''  ?> >Hard</option>
                    </Select>
                  </div>
                  <span style="color: red;"><?php echo form_error('type');?></span>
                </div>
                
                <hr>
                
                <h3  style="text-align: center; ">Order Setting </h3>
                
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Min Order</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control"  name="min_order_bal" id="min_order_bal" placeholder="Min Order" required value = "<?php  echo $getData['min_order_bal']?>">
                    <span style="color: red;"><?php echo form_error('min_order_bal');?></span>
                  </div>
                </div>
                
                  <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label">Shipping Amount </label>
                  <div class="col-sm-10">
                    
                    <input type="text" class="form-control" required id="shipping_amount" placeholder="Shipping Amount" name="shipping_amount" value ="<?php echo $getData['shipping_amount'] ?>">
                    <span style="color: red;"><?php echo form_error('shipping_amount');?></span>
                     
                  </div>
                </div>
                
                
                 <hr>
                
                <h3  style="text-align: center; ">Referel Setting </h3>
                
                
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Referel Amount 1</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control"  name="referel_to_pay" id="referel_to_pay" placeholder="Referel Amount 1" required value = "<?php  echo $getData['referel_to_pay']?>">

                    <span style="color: red;"><?php echo form_error('referel_to_pay');?></span>
                  </div>

                  </div>
                <div class="form-group">
               
                  <label for="inputEmail3" class="col-sm-2 control-label">Referel Amount 2</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" required  name="referel_to_get" id="referel_to_get" placeholder="Referel Amount 2" value = "<?php  echo $getData['referel_to_get']?>">
                  </div>
                   <span style="color: red;"><?php echo form_error('referel_to_get');?></span>
                </div>
                 
              
            
              <div class="box-footer">
                
                <button type="submit" class="btn btn-info pull-right">Submit</button>
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