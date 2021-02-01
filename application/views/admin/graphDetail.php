<!--  Registerd baby and mother bar chart  -->

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header btn-primary" style="padding:7px;">
          <h4 class="modal-title text-center" style="color:#fff;">Registered Mothers And Babies <?php echo ($getLoungeName['LoungeName'] != "") ? '('.$getLoungeName['LoungeName'].')' : ''; ?></h4>
        </div>
        <div class="modal-body">
          <b>Specification:</b>
          <ul class="listitem">
            Number of Mothers and Babies registered in last 6 months.
          </ul>

          <b>Color:</b>
          <ul class="listitem">
              <li><a class="" href="#" style="font-size:15px;color:#f390bd;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Number of Monther Registered.</span></li> 
              <li><a class="" href="#" style="font-size:15px;color:#0073b7;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Number of Baby Registered.</span></li> 
          </ul>

          <b>X-Axis:</b>
          <ul class="listitem">
            Last 6 Months in MMM YYYY format.
          </ul>

          <b>Y-Axis:</b>
          <ul class="listitem">
            Number of Mothers and Babies registered.
          </ul>

          <b>Database query:</b>
          <ul class="listitem">
            <li><span style="color:#000;font-weight:bold">1. </span>select distinct br.`BabyID` from babyRegistration as br inner join baby_admission as ba on ba.`BabyID`=br.`BabyID` and LoungeId='11'
             </li>
            <li><span style="color:#000;font-weight:bold">2. </span>select distinct mr.`MotherID` from mother_registration as mr inner join babyRegistration as br on br.`MotherID`=mr.`MotherID` inner join baby_admission as ba on ba.`BabyID`=br.`BabyID` and LoungeId='11'
           </li>
            <li><span style="color:#000;font-weight:bold">3. </span>select * from mother_registration WHERE AddDate BETWEEN (month start date time) AND (month end date time) and LoungeId='11'</li>
            <li><span style="color:#000;font-weight:bold">4. </span>select * from babyRegistration WHERE add_date BETWEEN (month start date time) AND (month end date time) and LoungeId='11'</li>
          </ul>
        </div>
        <div class="modal-footer" style="padding:7px;">
          <a href="" class="btn btn-primary btn-md" data-dismiss="modal">Close</a>
        </div>
      </div>
      
    </div>
  </div>

<!--  Baby KMC Timing bar chart -->

  <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header btn-primary" style="padding:7px;">
          <h4 class="modal-title text-center" style="color:#fff;">Baby KMC Timing <?php echo ($getLoungeName['LoungeName'] != "") ? '('.$getLoungeName['LoungeName'].')' : ''; ?></h4>
        </div>
        <div class="modal-body">
          <b>Specification:</b>
          <ul class="listitem">
           Number of Hours KMC given,month wise for last 6 months.
          </ul>

          <b>Color:</b>
          <ul class="listitem">
              <li><a class="" href="#" style="font-size:15px;color:#fdc80f;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Number of Hours KMC given.</span></li> 
          </ul>

          <b>X-Axis:</b>
          <ul class="listitem">
            Last 6 Months in MMM YYYY format.
          </ul>

          <b>Y-Axis:</b>
          <ul class="listitem">
            Number of Hours.
          </ul>

          <b>Database query:</b>
          <ul class="listitem">
            <li><span style="color:#000;font-weight:bold">1. </span>select @totsec:=sum(TIME_TO_SEC(subtime(EndTime,StartTime))) as totalseconds, floor(@totsec/3600) as Hours, (@totsec%3600)/60 as Minutes, (@totsec%60) as seconds from `babyDailyKMC` where StartTime < EndTime and (AddDate BETWEEN 1538332200 AND 1541010599) and LoungeId='11'</li>
            <li><span style="color:#000;font-weight:bold">2. </span>select @totsec:=sum(TIME_TO_SEC(subtime(EndTime,StartTime))) as kmcTime, floor(@totsec/3600) as Hours, (@totsec%3600)/60 as Minutes, (@totsec%60) as seconds from `babyDailyKMC` where StartTime < EndTime and LoungeId='11'</li>
          </ul>
        </div>
        <div class="modal-footer" style="padding:7px;">
          <a href="" class="btn btn-primary btn-md" data-dismiss="modal">Close</a>
        </div>
      </div>
      
    </div>
  </div>

 <!--  Baby Feeding Status bar chart -->

   <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header btn-primary" style="padding:7px;">
          <h4 class="modal-title text-center" style="color:#fff;">Baby Feeding Status <?php echo ($getLoungeName['LoungeName'] != "") ? '('.$getLoungeName['LoungeName'].')' : ''; ?></h4>
        </div>
        <div class="modal-body">
          <b>Specification:</b>
          <ul class="listitem">
            Total milk provided to Babies,month wise for last 6 months.(in Lts)
          </ul>

          <b>Color:</b>
          <ul class="listitem">
              <li><a class="" href="#" style="font-size:15px;color:#A3CC23;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Total milk provided to Babies.</span></li> 
          </ul>

          <b>X-Axis:</b>
          <ul class="listitem">
            Last 6 Months in MMM YYYY format.
          </ul>

          <b>Y-Axis:</b>
          <ul class="listitem">
            Total milk in lts.
          </ul>

          <b>Database query:</b>
          <ul class="listitem">
            <li><span style="color:#000;font-weight:bold">1. </span>select baby_admissionID,sum(MilkQuantity) as quantityOFMilk FROM `babyDailyNutrition` where AddDate BETWEEN 1538332200 AND 1541010599 and LoungeId='11'</li>
            <li><span style="color:#000;font-weight:bold">2. </span>select sum(MilkQuantity) as quantityOFMilk FROM `babyDailyNutrition` and LoungeId='11'</li>
          </ul>
        </div>
        <div class="modal-footer" style="padding:7px;">
          <a href="" class="btn btn-primary btn-md" data-dismiss="modal">Close</a>
        </div>
      </div>
      
    </div>
  </div>


   <!--  Baby Feeding Status bar chart -->

   <div class="modal fade" id="myModal3" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header btn-primary" style="padding:7px;">
          <h4 class="modal-title text-center" style="color:#fff;">Current SSC Babies(Skin To Skin) <?php echo ($getLoungeName['LoungeName'] != "") ? '('.$getLoungeName['LoungeName'].')' : ''; ?></h4>
        </div>
        <div class="modal-body">
          <b>Specification:</b>
          <ul class="listitem">
           Total KMC Duration provided to Babies till now. (in Hrs)
          </ul>

          <b>Color:</b>
          <ul class="listitem">
              <li><a class="" href="#" style="font-size:15px;color:#4FBDBB ;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Total KMC Duration provided to Babies.</span></li> 
          </ul>

          <b>X-Axis:</b>
          <ul class="listitem">
            Total SSC Given in Hrs.
          </ul>

          <b>Y-Axis:</b>
          <ul class="listitem">
            Total Babies who Recevied SSC till now.
          </ul>

          <b>Database query:</b>
          <ul class="listitem">
            <li><span style="color:#000;font-weight:bold">1. </span>select baby_admissionID,@totsec:=sum(TIME_TO_SEC(subtime(EndTime,StartTime))) as totalseconds, floor(@totsec/3600) as Hours, (@totsec%3600)/60 as Minutes, (@totsec%60) as seconds from `babyDailyKMC` where StartTime < EndTime  and LoungeId='11' group by baby_admissionID</li>
          </ul>
        </div>
        <div class="modal-footer" style="padding:7px;">
          <a href="" class="btn btn-primary btn-md" data-dismiss="modal">Close</a>
        </div>
      </div>
      
    </div>
  </div>


     <!-- Baby Breast Feeding In (24 hrs) pie chart -->

   <div class="modal fade" id="myModal4" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header btn-primary" style="padding:7px;">
          <h4 class="modal-title text-center" style="color:#fff;">Baby Breast Feeding In (24 hrs) <?php echo ($getLoungeName['LoungeName'] != "") ? '('.$getLoungeName['LoungeName'].')' : ''; ?></h4>
        </div>
        <div class="modal-body">
          <b>Specification:</b>
          <ul class="listitem">
           % of Feeding provided to Babies in last 24 Hrs as per Total number of Babies.

          <b>Color:</b>
          <ul class="listitem">
              <li><a class="" href="#" style="font-size:15px;color:#E87031;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;This color is used to total babies.</span></li> 
              <li><a class="" href="#" style="font-size:15px;color:#F6BE28;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;This color is used to not received babies.</span></li> 
              <li><a class="" href="#" style="font-size:15px;color:#4CAC6E;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;This color is used to received babies.</span></li> 
              <li><a class="" href="#" style="font-size:15px;color:#A3CC23;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;This color is used to Exclusive type babies.</span></li> 
              <li><a class="" href="#" style="font-size:15px;color:#08c108;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;This color is used to Non-Exclusive type babies.</span></li> 
          </ul>

          <b>Mouse over on graph:</b>
          <ul class="listitem">
            When you mouse over the graph then display babies details with percent value.
          </ul>

          <b>Database query:</b>
          <ul class="listitem">
            <li><span style="color:#000;font-weight:bold">1. </span>select bm.`BabyID` from baby_admission as ba inner join baby_monitoring as bm on ba.`BabyID`=bm.`BabyID` where ba.`status`='1' group by bm.`BabyID` and LoungeId='11'</li>
            <li><span style="color:#000;font-weight:bold">2. </span>select BabyID from babyDailyNutrition where FeedingType='1' and (AddDate BETWEEN 1539699236 AND 1539785636) group by BabyID and LoungeId='11'</li>
            <li><span style="color:#000;font-weight:bold">3. </span>select BabyID from babyDailyNutrition where FeedingType != '1' and (AddDate BETWEEN 1539699292 AND 1539785692) group by BabyID and LoungeId='11'</li>
            <li><span style="color:#000;font-weight:bold">4. </span>select BabyID from babyDailyNutrition where AddDate BETWEEN 1539699342 AND 1539785742 group by BabyID and LoungeId='11'</li>
          </ul>
        </div>
        <div class="modal-footer" style="padding:7px;">
          <a href="" class="btn btn-primary btn-md" data-dismiss="modal">Close</a>
        </div>
      </div>
      
    </div>
  </div>


       <!-- KMC Given Or Not Given In (24 hrs) pie chart -->

   <div class="modal fade" id="myModal5" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header btn-primary" style="padding:7px;">
          <h4 class="modal-title text-center" style="color:#fff;">KMC Given Or Not Given In (24 hrs) <?php echo ($getLoungeName['LoungeName'] != "") ? '('.$getLoungeName['LoungeName'].')' : ''; ?></h4>
        </div>
        <div class="modal-body">
          <b>Specification:</b>
          <ul class="listitem">
            % of SSC provided to Babies in last 24 Hrs as per Total number of Babies.
          </ul>

          <b>Color:</b>
          <ul class="listitem">
              <li><a class="" href="#" style="font-size:15px;color:#E87031;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Registered babies.</span></li> 
              <li><a class="" href="#" style="font-size:15px;color:#F6BE28;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Not given KMC.</span></li> 
              <li><a class="" href="#" style="font-size:15px;color:#A3CC23;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Given KMC.</span></li> 
         </ul>

          <b>Mouse over on graph:</b>
          <ul class="listitem">
            When you mouse over the graph then display babies details with percent value.
          </ul>

          <b>Database query:</b>
          <ul class="listitem">
            <li><span style="color:#000;font-weight:bold">1. </span>select bm.`BabyID` from baby_admission as ba inner join baby_monitoring as bm on ba.`BabyID`=bm.`BabyID` where ba.`status`='1' group by bm.`BabyID` and LoungeId='11'</li>
            <li><span style="color:#000;font-weight:bold">2. </span>select BabyID from babyDailyKMC where StartTime < EndTime and (AddDate BETWEEN 1539700699 AND 1539787099) group by BabyID and LoungeId='11'</li>
          </ul>
        </div>
        <div class="modal-footer" style="padding:7px;">
          <a href="" class="btn btn-primary btn-md" data-dismiss="modal">Close</a>
        </div>
      </div>
      
    </div>
  </div>