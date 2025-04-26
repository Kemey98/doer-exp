<?php
require_once 'core/init.php';
$user = new User();
if(!$user->isLoggedIn()){
  Redirect::to("login.php");
}else{
  $resultresult = $user->data();
  $userlevel = $resultresult->role;
  if($resultresult->verified == false || $resultresult->superadmin == true){
    $user->logout();
    Redirect::to("login.php");
  }
}
include 'includes/header.php';
?>
<body>
  <?php include 'includes/topbar.php';?>
  <div class="d-flex" id="wrapper">
    <?php include 'includes/navbar.php';?>
    <div class="card border-0 shadow mb-4">
      <div class="card-body">
        <h5 class="pt-2"><i class='fas fa-chalkboard-teacher'></i> <?php echo $array['supervisordashboard']?></h5>
      </div>
    </div>
      <div class="container-fluid" id="content">
        
        <div class="row my-3">
          <div class="col-xl-3 col-12">
            <div class="card mb-3">
              <div class="card-body">  
                <?php
                $userobject = new User();
                $userresult = $userobject->searchSupervisor($resultresult->userID);
                if($userresult){
                  $usernum = count($userresult);
                }else{
                  $usernum = 0;
                }
                ?>
                <h6 class="text-dark"><?php echo $array['people']?> (<?php echo $usernum;?>)</h6>
                <div class="list-group">
                  <?php
                  if($userresult){
                    foreach ($userresult as $row) {
                    ?>
                    <a href="viewuser.php?id=<?php echo $row->userID;?>" class="list-group-item list-group-item-action"><?php echo $row->firstname." ".$row->lastname;?></a>
                    <?php
                    }
                  }else{
                  ?>
                  <a href="#" class="list-group-item list-group-item-action"><i>No Member</i></a>
                  <?php
                  }
                  
                  ?>
                </div>

              </div>
            </div>

            
          </div>
          <div class="col-xl-9 col-12">
            <?php
            if($resultresult->corporateID){
              $corporateobject = new Corporate();
              $corporateresult = $corporateobject->searchCorporate($resultresult->corporateID);
              if($corporateresult){
                $when = $corporateresult->create_at;
              }
            }else{
              $companyobject = new Company();
              $companyresult = $companyobject->searchCompany($resultresult->companyID);
              if($companyresult){
                $when = $companyresult->create_at;
              }
            }
            ?>
            <input type="hidden" name="weekfilterscale" id="weekfilterscale" value="<?php echo $when;?>">
            <script type="text/javascript">
              $(document).ready(function(){
                var weekfilterscale = document.getElementById("weekfilterscale").value;

                var testdate = moment(weekfilterscale).format("YYYYMMDD");
                var test = moment(testdate).startOf('isoweek').format("d");
                console.log(test);
                var weekchangestartcreated = moment(testdate).startOf('isoweek').format("YYYYMMDD"); //Corporate or Company created Date

                var currenttoend1 = moment().startOf('isoweek').format("YYYYMMDD"); // Fix Date for This week Enddate

                //Current Week  
              var currentdate = moment().format("YYYYMMDD");
              var currentdate = moment(currentdate).startOf('isoweek').format("YYYYMMDD"); // First day of this week

              var currenttostart = moment().startOf('isoweek').format("YYYYMMDD");
              var weekchangestart = moment(currenttostart).subtract(0, 'weeks').format("D MMMM YYYY"); //First day of this week (View)

              var currenttoend = moment().endOf('isoweek').format("YYYYMMDD");
              var weekchangeend = moment(currenttoend).subtract(0, 'weeks').format("D MMMM YYYY"); //Last day of this week (View)

              document.getElementById("selectweek").innerHTML = weekchangestart+" - "+weekchangeend;

              if(currenttoend1 - currentdate == 0){
                $("#nextbutton").addClass("disabled");
              }else{
                $("#nextbutton").removeClass("disabled");
              }

              if(currentdate - weekchangestartcreated == 0){
                $("#previousbutton").addClass("disabled");
              }else{
                $("#previousbutton").removeClass("disabled");
              }
              

              var alldata = "startdate="+moment(currenttostart).subtract(0, 'weeks').format("YYYY-MM-DD")+"&enddate="+moment(currenttoend).subtract(0, 'weeks').format("YYYY-MM-DD")+"&supervisorID="+<?php echo $resultresult->userID?>;
                $.ajax({
                  url: "ajax-getreportbetweendate.php?lang=<?php echo $extlg;?>",
                  type: "POST",
                  data: alldata,
                  dataType:"json",
                  success:function(data){
                    $("#filter").html(data.output);
                  }
                });
              // Previous Week Button
                $(document).on('click', "#previous", function(){
                  $("#nextbutton").removeClass("disabled");
                  if(currentdate - weekchangestartcreated == 7){
                    $("#previousbutton").addClass("disabled");
                  }else{
                    $("#previousbutton").removeClass("disabled");
                  }
                  console.log(currentdate);
                  console.log(weekchangestartcreated);
                  console.log(currentdate - weekchangestartcreated);
                  var currenttostart = moment(currentdate).startOf('isoweek').format("YYYYMMDD");
                var currenttoend = moment(currentdate).endOf('isoweek').format("YYYYMMDD");

                var weekchangestart1 = moment(currenttostart).subtract(1, 'weeks').format("YYYYMMDD");
                var weekchangeend1 = moment(currenttoend).subtract(1, 'weeks').format("YYYYMMDD");

                var weekchangestart = moment(currenttostart).subtract(1, 'weeks').format("D MMMM YYYY");
                var weekchangeend = moment(currenttoend).subtract(1, 'weeks').format("D MMMM YYYY");
                document.getElementById("selectweek").innerHTML = weekchangestart+" - "+weekchangeend;
                currentdate = weekchangestart1;

                var alldata = "startdate="+moment(currenttostart).subtract(1, 'weeks').format("YYYY-MM-DD")+"&enddate="+moment(currenttoend).subtract(1, 'weeks').format("YYYY-MM-DD")+"&supervisorID="+<?php echo $resultresult->userID?>;
                  $.ajax({
                    url: "ajax-getreportbetweendate.php?lang=<?php echo $extlg;?>",
                    type: "POST",
                    data: alldata,
                    dataType:"json",
                    success:function(data){
                      $("#filter").html(data.output);
                    }
                  });
                });


                // Next Week button
                $(document).on('click', "#next", function(){
                  
                
                var currenttostart = moment(currentdate).startOf('isoweek').format("YYYYMMDD");
                var currenttoend = moment(currentdate).endOf('isoweek').format("YYYYMMDD");

                var weekchangestart1 = moment(currenttostart).add(1, 'weeks').format("YYYYMMDD");
                var weekchangeend1 = moment(currenttoend).add(1, 'weeks').format("YYYYMMDD");

                var weekchangestart = moment(currenttostart).add(1, 'weeks').format("D MMMM YYYY");
                var weekchangeend = moment(currenttoend).add(1, 'weeks').format("D MMMM YYYY");
                currentdate = weekchangestart;
                document.getElementById("selectweek").innerHTML = weekchangestart+" - "+weekchangeend;
                currentdate = weekchangestart1;
                $("#previousbutton").removeClass("disabled");
                  if(currenttoend1 - currentdate == 0){
                    $("#nextbutton").addClass("disabled");
                  }else{
                    $("#nextbutton").removeClass("disabled");
                  }
                var alldata = "startdate="+moment(currenttostart).add(1, 'weeks').format("YYYY-MM-DD")+"&enddate="+moment(currenttoend).add(1, 'weeks').format("YYYY-MM-DD")+"&supervisorID="+<?php echo $resultresult->userID?>;
                  $.ajax({
                    url: "ajax-getreportbetweendate.php?lang=<?php echo $extlg;?>",
                    type: "POST",
                    data: alldata,
                    dataType:"json",
                    success:function(data){
                      $("#filter").html(data.output);
                    }
                  });
                });


              });
            </script>
            <ul class="pagination row">
              <li class="page-item col-2 text-center" id="previousbutton"><a class="page-link" href="#" id="previous"><?php echo $array['previous']?></a></li>
              <li class="page-item col text-center disabled"><a class="page-link" href="#" id="selectweek"></a></li>
              <li class="page-item col-2 text-center" id="nextbutton"><a class="page-link" href="#" id="next"><?php echo $array['next']?></a></li>
            </ul> 
            <div id="filter"></div>
          </div>
        </div>
        
      </div>
    </div>
    <!-- /#page-content-wrapper -->
  </div>
  <!-- /#wrapper -->
<script type="text/javascript">
  $(document).ready(function(){
     $("#sidebar-wrapper .active").removeClass("active");
     $("#supervisordashboardtab").addClass("active");
  });
</script>
<?php include 'includes/form.php';?>
<?php include 'includes/footer.php';?>
