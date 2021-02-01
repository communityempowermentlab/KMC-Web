<style>
.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 28px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 20px;
  width: 20px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(20px);
  -ms-transform: translateX(20px);
  transform: translateX(20px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 24px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
 <div class="content-wrapper">
   <script type="text/javascript">
    window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
    }
    </script>
    <section class="content-header">
      <h1>SMS Template</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">  
               <div  id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
             <!--         //     SMS  setting section        -->
         <div class="box box-info"> 
          <form class="form-horizontal" action="<?php echo site_url('staffM/SmsSettingData/');?>" method="POST">
           <div class="box-body">
                   <div class="col-sm-12" style="padding:0px;"><span style="font-size: 18px;">This Template is used for sending staff login credentials:</h3></div>
               <div class="form-group" >
                     <div class="col-sm-8">
                      <textarea name="smsFormatThird" class="form-control" rows="6"><?php echo $Settings['smsFormatThird']; ?></textarea> 
                     </div>
                    
                </div>


           </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-info pull-left">Submit</button>
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

 

  