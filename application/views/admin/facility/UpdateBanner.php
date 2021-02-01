 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> Update Banner </h1>
     
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            
            <form class="form-horizontal" name='banner'  action="<?php echo site_url('admin/Dashboard/UpdateBannerDataPost').'/'.$getData['id'];?>" method="POST" enctype="multipart/form-data" autocomplete="off">
              <div class="box-body">

              <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Banner On</label>
                <div class="col-sm-10">
                    <input type="radio" name="Banner_On"  value="2" style="margin-left:15px" <?php echo  ($getData['banner_on'] =='2')? 'checked': '' ; ?>>&nbsp;&nbsp;  Product
                    <input type="radio" name="Banner_On" value="1" style="margin-left:15px" <?php echo  ($getData['banner_on'] =='1')? 'checked': '' ; ?>>&nbsp;&nbsp;  Sub Category
                    <input type="hidden"  id="sub_product_list2" name="sub_product_list2" value="<?php echo $getData['sub_category_product_master_id'] ?>"> 
                </div>
              </div>
                
              <div class="form-group">
                <label for="inputEmail2" class="col-sm-2 control-label" >Choose</label>
                  <div class="col-sm-10">
                    <select class="form-control select2 aaaaaa" name="sub_product_list" id="sub_product_list" style="width: 100%;"  data-placeholder ="Choose Sub Category/Product">
                    
                     </select>
                  </div>
                </div>

               
          
              <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Feature</label>
                  <div class="col-sm-10">
                     <input type="radio" name="bannerfeature"  value="2" style="margin-left:15px" <?php echo  ($getData['featured_banner'] =='2')? 'checked': '' ; ?> > &nbsp;&nbsp;  Yes
                      <input type="radio" name="bannerfeature"  value="1" style="margin-left:15px" <?php echo  ($getData['featured_banner'] =='1')? 'checked': '' ; ?>  > &nbsp;&nbsp;  No
                  </div>
                </div>

              
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Banner Image</label>
                     <div class="col-sm-10">
                       
                      <input type="file" id="exampleInputFile" name="uploadBanner">

                      <img src="<?php echo base_url()."assets/banner_images/".$getData['banner_image']; ?>" style="max-width: 500px;"> 
                     </div>
                </div>
              <!-- /.input group -->
            </div>
              <!-- /.box-body -->
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

  <script type="text/javascript">

   window.onload = function () {
    var id =  $('[name="sub_product_list2"]').val();

    var BanneType = $('[name="Banner_On"]:checked').val();
    var Url = "<?php  echo base_url('admin/Dashboard/Get_SubCat_Product_list2')?>/"+BanneType+"/"+id;
    if(BanneType!=''){
    $("#sub_product_list").removeClass("select2-hidden-accessible");
    $(".select2-container").hide();
    /*alert(Url);*/
    $.ajax({
        type: "POST",
        url: Url,
               
        success: function(result){
          console.log(result)
        if(result!='')
          { 
            $('#sub_product_list').html(result);
          } else
          {
            $('#Show').html('');
          }
         
        }
      });
      }
        };

    
   $(document).on("change","input[name=Banner_On]",function(){
    var BanneType = $('[name="Banner_On"]:checked').val();
    var Url = "<?php  echo base_url('admin/Dashboard/Get_SubCat_Product_list')?>/"+BanneType;
     $("#sub_product_list").addClass("select2-hidden-accessible");
     $(".select2-container").show();
    /*alert(Url);*/
    $.ajax({
        type: "POST",
        url: Url,
               
        success: function(result){
          console.log(result)
        if(result!='')
          {
            $('#sub_product_list').html(result);
          } else
          {
            $('#sub_product_list').html('');
          }
         
        }
      });
  });

  </script>


  