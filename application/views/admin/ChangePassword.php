<style>
style type="text/css">
   .ratingpoint{
    color: red;
    }
  i.fa.fa-fw.fa-trash { 
    font-size: 30px;
    color: darkred;
    top: 5px;
    position: relative;
  }
   #example_filter label, .paging_simple_numbers .pagination {float: right;}
</style>
<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>
 <div class="content-wrapper">
    <section class="content-header">
    <h1>Change Password</h1>
    </section>
    <section class="content">
        <div class="row">
          <div class="col-md-12">
           <div class="box box-info">
            <div  id="hiddenSms"> <?php echo $this->session->flashdata('activate'); ?></div>
             <form class="form-horizontal" name='Lounge'  action="<?php echo site_url();?>Admin/ChangePass/" method="POST" enctype="multipart/form-data">
               <div class="box-body">
                 <div class="nav-tabs-custom">
                        <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label" >Old Password:</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control"  name="OldPassword" id="OldPassword" placeholder="Old Password" required>                 
                                </div>
                          </div>
  
                         <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label" > New Password:</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control"  name="NewPassword" id="NewPassword" placeholder="New Password" required>                 
                                </div>
                          </div>                     

                        <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label" >Confirm Password:</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control"  name="confirmPassword" id="confirmPassword" placeholder="Confirm  Password" required>                 
                                </div>
                          </div>

                        <div class="box-footer">               
                         <button type="submit" class="btn btn-info pull-right">Submit</button>
                </div>

                  </div>
                </div>
                 </div>
             </form>
           </div>
          </div>
        </div>
    </section>
 </div>

