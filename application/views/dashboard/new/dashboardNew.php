<?php defined('BASEPATH') OR exit('No direct script access allowed');
       $adminData = $this->session->userdata('adminData');  
       if(!isset($adminData['is_logged_in']) && $adminData['is_logged_in']!=true)
          {   redirect('admin/');    }  
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $title; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <style type="text/css">
    p {
      margin: -36px 0px 0px !important;
    }
  </style>
</head>
<body>
 
<div class="container">
 <!--  <h2>Panels with Contextual Classes</h2> -->
 <br/><br/><br/>
  <div class="panel-group">
    <div class="row">
      <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="panel panel-primary">
              <div id="message" style="margin-bottom: -25px !important;"><?php echo $this->session->flashdata('login_message'); ?></div>
              <div class="panel-heading">
                <h4 class="text-center">Welcome to MNCU Pannel</h4>
                <p class="text-right"><a href="<?php echo  base_url('Welcome/logout') ?>" class="btn btn-danger">Logout</a></p>
              </div>
              <div class="panel-body"><br>
                <div class="row">
                  <div class="col-md-3"></div>
                  <div class="col-md-6">
                    <table class="table">
                      <tbody>
                        <tr>
                          <td>New Dashboard:</td><td><a href="<?php echo base_url('Admin/wecomeDashboard'); ?>">Click Here</a></td>
                        </tr>
                        <tr>
                          <td>Old Dashboard:</td><td><a href="<?php echo base_url('Admin/dashboard'); ?>">Click Here</a></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-3"></div>
                </div>
              </div>
              <div class="panel-footer">
                <footer class="main-footer text-center">
                  Copyright &copy; <?php echo date('Y'); ?>-<?php echo (date('Y')+1); ?> <a href="#"><?php echo PROJECT_NAME; ?> Project </a>. All rights
                  reserved &reg.
                </footer>
              </div>
            </div>
          </div>  
        <div class="col-md-3"></div>
      </div>    
  </div>
</div>
<script>
  $(document).ready(function(){
   $('#message').delay(4000).fadeOut();
  });
</script>
</body>
</html>
