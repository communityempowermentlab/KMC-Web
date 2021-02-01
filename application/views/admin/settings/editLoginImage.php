 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Edit Index Page Image</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">  
            <form class="form-horizontal" name='Lounge'  action="<?php echo site_url('admin/editImage/');?>" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
              <div class="box-body">

               
                    
                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label">Edit Background Image  <span style="color:red">  *</span></label>
                    <input type="file" id="fileupload" class="form-control" name="image" style="margin-bottom: 5px;">
                    <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                    <input type="hidden" name="oldImage" value="<?php echo $result['image']; ?>">
                    <div id="dvPreview">
                      <?php if(!empty($result['image'])) { ?>
                        <img src="<?php echo base_url(); ?>assets/loginPage/<?php echo $result['image']; ?>">
                      <?php } ?>
                    </div>
                    <span class="errorMessage" id="err_fileupload" style="color: red; font-style: italic;"></span>
                  </div>
                </div>

                 

              </div>
              <div class="box-footer">
                 <button type="submit" class="btn btn-info pull-right">Submit</button>
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
 <style type="text/css">
   #dvPreview img{
    width: 315px;
    height: 200px;
    border: 1px solid #a69494;
   }
 </style>
  <script type="text/javascript">
    function validateForm(){ 

        
    }

  setTimeout(function() { $(".alert-success").hide(); }, 2000);
</script>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
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
</script>


  