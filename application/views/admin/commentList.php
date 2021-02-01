<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'Manage Comments'; ?>
      </h1>
      
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
           <div  id="hiddenSms"><?php echo $this->FeedModel->session->flashdata('activate'); ?></div>
           <div class="" id="MDG"></div>
            <div class="box-body" >
              <div class="col-sm-12" style="overflow: auto;">
                  <table  cellpadding="0" cellspacing="0" border="0" class="table-striped table table-bordered editable-datatable example " id="example">
                    <thead>
                      <tr>
                        <th style="width:70px;">S&nbsp;No.</th>
                        <th>Comments&nbsp;By</th>
                        <th>Comment</th>
                        <th>Timing&nbsp;Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $counter=1;
                            function time_elapsed_string($datetime, $full = false) {
                              $now = new DateTime;
                              $ago = new DateTime($datetime);
                              $diff = $now->diff($ago);

                              $diff->w = floor($diff->d / 7);
                              $diff->d -= $diff->w * 7;

                              $string = array(
                                  'y' => 'year',
                                  'm' => 'month',
                                  'w' => 'week',
                                  'd' => 'day',
                                  'h' => 'hour',
                                  'i' => 'minute',
                                  's' => 'second',
                              );
                              foreach ($string as $k => &$v) {
                                  if ($diff->$k) {
                                      $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                                  } else {
                                      unset($string[$k]);
                                  }
                              }

                              if (!$full) $string = array_slice($string, 0, 1);
                              return $string ? implode(', ', $string) . ' ago' : 'just now';
                            }
                      foreach($commentData as $key => $value) { 
                        if($value['userType'] == '0'){
                            $nurseName = singlerowparameter2('loungeName','loungeId',$value['loungeId'],'loungeMaster');
                        }else if($value['userType'] == '1'){
                             $nurseName = singlerowparameter2('name','staffId',$value['loungeId'],'staffMaster');
                        }
                        
                      ?>
                        <tr>
                          <td><?php echo $counter++;?></td>
                          <td><?php echo $nurseName;?></td>
                          <td><?php echo $value['comment']; ?></td>
                          <td><?php echo $value['addDate']; ?></td>         
                        </tr>
                      <?php }?>
                    </tbody>
                  </table>
          
             </div>
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

