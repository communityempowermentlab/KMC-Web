
    <footer class="main-footer">
    
    <strong>Copyright &copy; <?php echo date('Y'); ?>-<?php echo (date('Y')+1); ?> <a href="#"><?php echo PROJECT_NAME; ?> Project </a>.</strong> All rights
    reserved &reg.
  </footer>
  <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

<script src="<?php echo base_url('assets/admin/dist/js/adminlte.min.js');?>"></script>
<script src="<?php echo base_url('assets/admin/plugins/select2/select2.full.min.js');?>"></script>


<!-- page script -->

<script type="text/javascript">
  $("#category").change(function(){
  
    var id = this.value;
    $.ajax({
        type: "POST",
        url: "<?php  echo base_url('admin/Dashboard/getsubCatgy')?>/"+id,
               
        success: function(result){
          console.log(result)
        if(result!='')
          {
            $('#subCategory').html(result);
          } else
          {
            $('#msg').html('');
          }
         
        }
      });
    });

  </script>
<script type="text/javascript">
          //Date picker1
    $('#datepicker').datepicker({
      autoclose: true,
      format:'dd-mm-yyyy'
    });
     $('#datepicker2').datepicker({
      autoclose: true,
      format:'dd-mm-yyyy'
    });

    function checkExsist(){
    var Appid = $("#AppId").val();
    //alert(Appid);
    $.ajax({
            type: "POST",
            url: "<?php  echo base_url('admin/Dashboard/ExsistMsg')?>",
            data:'app_id='+Appid,
           
            success: function(result){
              if(result==1)
              {
                $('#msg').html('<span style="color:red;"> This Application-Id Alresdy Exsist </span>');
              } else
              {
                $('#msg').html('');
              }
             
            }
          });
     }


    </script>

</body>
</html>
