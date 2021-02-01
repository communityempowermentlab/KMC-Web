 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       <?php echo 'Edit Suppliment';  ?>
       
      </h1>
     
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
       
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            
            <form class="form-horizontal" name='Lounge'  action="<?php echo site_url('supplimentM/EditSuppliment/'.$SupplimentData['id']);?>" method="POST" enctype="multipart/form-data" onsubmit="return checkValidation()">
              <div class="box-body">

                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Suppliment Name
                     <span style="color:red">  *</span></label>
                     <input type="hidden" name="suppliment_id" value="<?= $SupplimentData['id']; ?>" id="suppliment_id">
                     <input type="text" class="form-control" name="suppliment_name" id="suppliment_name" placeholder="Suppliment Name" value="<?= $SupplimentData['name'] ?>" onblur="checkSuppliment(this.value)">
                     <span style="color: red; font-style: italic;" id="err_suppliment_name"></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Number Of Days
                     <span style="color:red">  *</span></label>
                     <input type="number" class="form-control" name="number_days" id="number_days" placeholder="Number Of Days" value="<?= $SupplimentData['duration'] ?>">
                     <span style="color: red; font-style: italic;" id="err_number_days"></span>
                  </div>

                </div>
                 
            </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-sm-12 col-xs-12 form-group">
                  <button type="submit" class="btn btn-info pull-left" style="margin-left: 15px;">Submit</button>
                </div>
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

 

<script type="text/javascript">
    
     // validation code added by neha

    function checkValidation(){
      var suppliment_name = $('#suppliment_name').val();
      if(suppliment_name == ''){
        $('#err_suppliment_name').html('This field is required.').show();
        return false;
      } else {
        var chk = $('#err_suppliment_name').html();
        if(chk.length > 0){
          return false;
        } else {
          $('#err_suppliment_name').html('').hide();
        }
      }

      var number_days = $('#number_days').val();
      if(number_days == ''){
        $('#err_number_days').html('This field is required.').show();
        return false;
      } else {
        $('#err_number_days').html('').hide();
      }
    }

    function checkSuppliment(name){
      if(name != ''){
        var get_id = $('#suppliment_id').val(); 
        var s_url = '<?php echo base_url('supplimentM/checkSuppliment')?>';
            $.ajax({
                data: {'name': name, 'id': get_id},
                url: s_url,
                type: 'post',
                success: function(data) {
                  if(data == 1){
                    $('#err_suppliment_name').html('This suppliment name already exists.').show();
                  } else {
                    $('#err_suppliment_name').html('').hide();
                  }
                }
            });
      }

    }

</script>