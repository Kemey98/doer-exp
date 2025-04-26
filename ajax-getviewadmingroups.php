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

$groupobject = new Group();
if($resultresult->corporateID){
$groupresult = $groupobject->searchGroupWithCorporate($resultresult->corporateID);
}else{
$groupresult = $groupobject->searchCompany($resultresult->companyID);
}

$view = "";
if($groupresult){
	$view .= 
	"
	<ul class='list-group list-group-flush' id='showgroupslist'>
		<li class='list-group-item px-0'>
			<div class='row'>
				<div class='col'>
					<b>".$array['groups']."</b>
				</div>
				<div class='col'>
					<b>".$array['leader']."</b>
				</div>
				<div class='col'>
					<b>".$array['type']."</b>
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
	foreach ($groupresult as $row) {
		if(isset($_GET['lang'])){
	      if($_GET['lang'] == "en"){
	        if($row->type === "Department"){
	          $type = $array['department'];
	        }elseif($row->type === "Team"){
	          $type = $array['team'];
	        }elseif($row->type === "Project"){
	          $type = $array['project'];
	        }elseif($row->type === "Campaign"){
	          $type = $array['campaign'];
	        }
	      }elseif ($_GET['lang'] == "zh") {
	        if($row->type === "Department"){
	          $type = $array['department'];
	        }elseif($row->type === "Team"){
	          $type = $array['team'];
	        }elseif($row->type === "Project"){
	          $type = $array['project'];
	        }elseif($row->type === "Campaign"){
	          $type = $array['campaign'];
	        }
	      }elseif($_GET['lang'] == "bm"){
	        if($row->type === "Department"){
	          $type = $array['department'];
	        }elseif($row->type === "Team"){
	          $type = $array['team'];
	        }elseif($row->type === "Project"){
	          $type = $array['project'];
	        }elseif($row->type === "Campaign"){
	          $type = $array['campaign'];
	        }
	      }else{
	        if($row->type === "Department"){
	          $type = $array['department'];
	        }elseif($row->type === "Team"){
	          $type = $array['team'];
	        }elseif($row->type === "Project"){
	          $type = $array['project'];
	        }elseif($row->type === "Campaign"){
	          $type = $array['campaign'];
	        }
	      }
	    }

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



		$user = new User();
	    $userresult = $user->searchOnly($row->leaderID);
	    if($userresult){
	        if($userresult->profilepic){
	        	$pic = "data:image/jpeg;base64,".base64_encode($userresult->profilepic);
	        }else{
	        	$pic = "img/userprofile.png";
	        }
	        $name = $userresult->firstname." ".$userresult->lastname;
	    }else{
	    	$pic = "img/userprofile.png";
	        $name = "--";
	    }
		$view .= 
		"
		<li class='list-group-item px-0 searchgroups all ".$type." ".$status."'>
			<div class='row'>
				<div class='col'>
					".$row->groups."
				</div>
				<div class='col'>
					<img src='".$pic."' class='rounded-circle' width='30' height='30' style='object-fit: cover;''> ".$name."
				</div>
				<div class='col'>
					".$type."
				</div>
				<div class='col-1'>
					".$status."
				</div>
				<div class='col-2 text-center'>
					<a href='#' class='editGroup' data-id='".$row->groupID."' data-toggle='modal' data-target='#admineditgroup'>Edit</a> | 
                	<a href='#' class='deleteGroup' data-id='".$row->groupID."' data-toggle='modal' data-target='#admindeletegroup'>Delete</a>
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
          <i class='fas fa-users my-3' style='font-size:40px;'></i>
          <h5>".$array['nogroupfound']."</h5>
          <p> ".$array['nogroupfoundexplain']."</p>
        </div>
      </div>
    </div>
	";
}


echo $view;
?>