<?php
require_once 'core/init.php';
$userlevel = "";
$user = new User();
if(!$user->isLoggedIn()){
  Redirect::to("login.php");
}else{
  $resultresult = $user->data();
  $userlevel = $resultresult->role;
  if($resultresult->verified == false || $resultresult->superadmin == true){
    $user->logout();
    Redirect::to("login.php?error=error");
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin Dashboard - DoerHRM</title> 
  <?php
  include 'includes/header.php';
  ?>
</head>
<body>
  <?php include 'includes/topbar.php';?>
  <div class="d-flex" id="wrapper">
    <?php include 'includes/navbar.php';?>
    <div id="page-content-wrapper">
      <div class="container-fluid" id="content"> 
        <h3 class="my-5 font-weight-light"><?php echo $array['admindashboard']?></h3>
        <script>
          $(document).ready(function(){
            $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
              localStorage.setItem('activeTab', $(e.target).attr('href'));
            });

            var activeTab = localStorage.getItem('activeTab');
            if(activeTab){
              $('#adminalltab a[href="'+activeTab+'"]').tab('show');
              if(activeTab === "#corporatemanage"){
                getcorporateinfo();
              }else if(activeTab === "#companymanage"){
                <?php
                if($resultresult->corporateID){
                  ?>getcompaniesinfo();<?php
                }else{
                  ?>getcompanyinfo();<?php
                }
                ?>
              }else if(activeTab === "#groupmanage"){
                getgroupsinfo();
              }else if(activeTab === "#usermanage"){
                getusersinfo();
              }else if(activeTab === "#timeframe"){
                gettimeframeinfo();
              }

            }else{
              <?php
              if($resultresult->corporateID){
                ?>
                  $('#adminalltab a[href="corporatemanage"]').tab('show');
                  getcorporateinfo();
                <?php
              }else{
                ?>
                  $('#adminalltab a[href="companymanage"]').tab('show');
                  getcompanyinfo();
                <?php
              }
              ?>
            }
          });
        </script>
        <ul class="nav nav-tabs row px-2" id="adminalltab">
          <?php
          if($resultresult->corporateID){
            $companyobject = new Company();
            $companyresult = $companyobject->searchCompanyCorporate($resultresult->corporateID);
            if($companyresult){
              $companynum = count($companyresult);
            }else{
              $companynum = 0;
            }
            $groupobject = new Group();
            $groupresult = $groupobject->searchGroupWithCorporate($resultresult->corporateID);
            if($groupresult){
              $groupnum = count($groupresult);
            }else{
              $groupnum = 0;
            }
            $userobject = new User();
            $userresult = $userobject->searchWithCorporate($resultresult->corporateID);
            if($userresult){
              $usernum = count($userresult);
            }else{
              $usernum = 0;
            }
          ?>
          <li class='nav-item col-12 col-xl-2 p-0'>
            <a class='nav-link rounded-0 text-center' data-toggle='tab' href='#corporatemanage'><span class="font-weight-bold">CORPORATE</span></a>
          </li>
          <li class='nav-item col-12 col-xl-2 p-0'>
            <a class='nav-link rounded-0 text-center' data-toggle='tab' href='#companymanage'><span class="font-weight-bold">COMPANIES (<?php echo $companynum;?>)</span></a>
          </li>
          <li class='nav-item col-12 col-xl-2 p-0'>
            <a class='nav-link rounded-0 text-center' data-toggle='tab' href='#groupmanage'><span class="font-weight-bold">GROUPS (<?php echo $groupnum;?>)</span></a>
          </li>
          <li class='nav-item col-12 col-xl-2 p-0'>
            <a class='nav-link rounded-0 text-center' data-toggle='tab' href='#usermanage'><span class="font-weight-bold">USERS (<?php echo $usernum;?>)</span></a>
          </li>
          <li class='nav-item col-12 col-xl-2 p-0'>
            <a class='nav-link rounded-0 text-center' data-toggle='tab' href='#timeframe'><span class="font-weight-bold">TIMEFRAME</span></a>
          </li>
          <?php
          }else{
            $groupobject = new Group();
            $groupresult = $groupobject->searchCompany($resultresult->companyID);
            if($groupresult){
              $groupnum = count($groupresult);
            }else{
              $groupnum = 0;
            }
            $userobject = new User();
            $userresult = $userobject->searchWithCompany($resultresult->companyID);
            if($userresult){
              $usernum = count($userresult);
            }else{
              $usernum = 0;
            }
            $objectiveobject = new Objective();
            $objectresult = $objectiveobject->searchObjectiveBasedOnCompany($resultresult->companyID);
            if($objectresult){
              $objectivenum = count($objectresult);
            }else{
              $objectivenum = 0;
            }
          ?>

          <li class='nav-item col-12 col-xl-2 p-0'>
            <a class='nav-link rounded-0 text-center' data-toggle='tab' href='#companymanage'><span class="font-weight-bold"><?php echo $array['company']?></span></a>
          </li>
          <li class='nav-item col-12 col-xl-2 p-0'>
            <a class='nav-link rounded-0 text-center' data-toggle='tab' href='#groupmanage'><span class="font-weight-bold"><?php echo $array['groups']?> (<?php echo $groupnum;?>)</span></a>
          </li>
          <li class='nav-item col-12 col-xl-2 p-0'>
            <a class='nav-link rounded-0 text-center' data-toggle='tab' href='#usermanage'><span class="font-weight-bold"><?php echo $array['users']?> (<?php echo $usernum;?>)</span></a>
          </li>
          <li class='nav-item col-12 col-xl-2 p-0'>
            <a class='nav-link rounded-0 text-center' data-toggle='tab' href='#timeframe'><span class="font-weight-bold"><?php echo $array['timeframe']?></span></a>
          </li>
          <?php
          }
          ?>
        </ul>
        <div class="tab-content">
          <?php
          if($resultresult->corporateID){
            include 'dashboard-corporate.php';
            include 'dashboard-companies.php';
          }else{
            include 'dashboard-company.php';
          }
          include 'dashboard-group.php';
          include 'dashboard-users.php';
          include 'dashboard-timeframe.php';
          ?>
        </div>
      </div>
    </div>
    <!-- /#page-content-wrapper -->
  </div>
  <!-- /#wrapper -->

  <script type="text/javascript">
    $(document).ready(function(){
       $("#sidebar-wrapper .active").removeClass("active");
       $("#admindashboardtab").addClass("active");
       document.getElementById("admindashboardtab").style.backgroundColor = "DeepSkyBlue";
    });
  </script>
  <?php
  include 'includes/footer.php';
  ?>
</body>
</html>
