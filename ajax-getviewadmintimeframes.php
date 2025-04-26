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
    Redirect::to("login.php?error=error");
  }
}

$timeframelist = new Timeframe();
if($resultresult->corporateID){
	$timeframeresult = $timeframelist->searchCorporateTimeframe($resultresult->corporateID);
}else{
	$timeframeresult = $timeframelist->searchCompanyTimeframe($resultresult->companyID);
}

$view = "";
if($timeframeresult){
	$view .= 
	"
	<ul class='list-group list-group-flush' id='showtimeframeslist'>
		<li class='list-group-item px-0'>
			<div class='row'>
				<div class='col'>
					<b>".$array['timeframe']."</b>
				</div>
				<div class='col'>
					<b>".$array['startdate']."</b>
				</div>
				<div class='col'>
					<b>".$array['enddate']."</b>
				</div>
				<div class='col-1'>
					<b>".$array['status']."</b>
				</div>
				<div class='col-2 text-center'>
					<b>".$array['action']."</b>
				</div>
			</div>
		</li>
	";
	foreach ($timeframeresult as $row) {

		if(isset($_GET['lang'])){
	      if($_GET['lang'] == "en"){
	        if($row->status === "Active"){
	          $status = $array['active'];
	        }else{
	          $status = $array['notactive'];
	        }
	      }elseif ($_GET['lang'] == "zh") {
	        if($row->status === "Active"){
	          $status = $array['active'];
	        }else{
	          $status = $array['notactive'];
	        }
	      }elseif($_GET['lang'] == "bm"){
	        if($row->status === "Active"){
	          $status = $array['active'];
	        }else{
	          $status = $array['notactive'];
	        }
	      }else{
	        if($row->status === "Active"){
	          $status = $array['active'];
	        }else{
	          $status = $array['notactive'];
	        }
	      }
	    }

		$view .= 
		"
		<li class='list-group-item px-0 searchtimeframes all ".$status."'>
			<div class='row'>
				<div class='col'>
					".$row->timeframe."
				</div>
				<div class='col'>
					".date("d M Y", strtotime($row->startdate))."
				</div>
				<div class='col'>
					".date("d M Y", strtotime($row->enddate))."
				</div>
				<div class='col-1'>
					".$status."
				</div>
				<div class='col-2 text-center'>
					<a href='#' class='editTimeframe' data-toggle='modal' data-id='".$row->timeframeid."' data-target='#edittimeframemodal'>Edit</a> | 
                  	<a href='#' class='deleteTimeframe' data-toggle='modal' data-id='".$row->timeframeid."' data-target='#admindeletetimeframe'>Delete</a>
				</div>
			</div>
		</li>
		";
	}
	$view .= 
	"
	</ul>
	";
}else{
	$view .= 
	"
	<div class='row'>
      <div class='col'>
        <div class='card shadow-sm p-2 text-center'>
          <i class='fa fa-clock-o my-3' style='font-size:40px;'></i>
          <h5>".$array['notimeframefound']."</h5>
          <p> ".$array['notimeframefoundexplain']."</p>
        </div>
      </div>
    </div>
	";
}


echo $view;
?>