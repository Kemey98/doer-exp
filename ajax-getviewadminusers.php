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

$userobject = new User();
if($resultresult->corporateID){
$useresult = $userobject->searchWithCorporate($resultresult->corporateID);
}else{
$useresult = $userobject->searchWithCompany($resultresult->companyID);
}

$view = "";
if($useresult){
	$view .= 
	"
	<ul class='list-group list-group-flush' id='showuserslist'>
		<li class='list-group-item px-0'>
			<div class='row'>
				<div class='col'>
					<b>".$array['name']."</b>
				</div>
				<div class='col'>
					<b>".$array['email']."</b>
				</div>
				<div class='col'>
					<b>".$array['jobposition']."</b>
				</div>
				<div class='col-1'>
					<b>".$array['role']."</b>
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
	foreach ($useresult as $row) {

		if(isset($_GET['lang'])){
	        if($_GET['lang'] == "en"){
	          if($row->role === "Chief"){
	            $role = $array['chief'];
	          }elseif($row->role === "Superior"){
	            $role = $array['superior'];
	          }elseif($row->role === "Manager"){
	            $role = $array['manager'];
	          }elseif($row->role === "Personal"){
	            $role = $array['personal'];
	          }
	        }elseif ($_GET['lang'] == "zh") {
	          if($row->role === "Chief"){
	            $role = $array['chief'];
	          }elseif($row->role === "Superior"){
	            $role = $array['superior'];
	          }elseif($row->role === "Manager"){
	            $role = $array['manager'];
	          }elseif($row->role === "Personal"){
	            $role = $array['personal'];
	          }
	        }elseif($_GET['lang'] == "bm"){
	          if($row->role === "Chief"){
	            $role = $array['chief'];
	          }elseif($row->role === "Superior"){
	            $role = $array['superior'];
	          }elseif($row->role === "Manager"){
	            $role = $array['manager'];
	          }elseif($row->role === "Personal"){
	            $role = $array['personal'];
	          }
	        }else{
	          if($row->role === "Chief"){
	            $role = $array['chief'];
	          }elseif($row->role === "Superior"){
	            $role = $array['superior'];
	          }elseif($row->role === "Manager"){
	            $role = $array['manager'];
	          }elseif($row->role === "Personal"){
	            $role = $array['personal'];
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

		if($row->profilepic){
        	$pic = "data:image/jpeg;base64,".base64_encode($row->profilepic);
        }else{
        	$pic = "img/userprofile.png";
        }

		$view .= 
		"
		<li class='list-group-item px-0 searchusers all ".$role." ".$status."'>
			<div class='row'>
				<div class='col'>
					<img src='".$pic."' class='rounded-circle' width='30' height='30' style='object-fit: cover;''> ".$row->firstname." ".$row->lastname."
				</div>
				<div class='col'>
					".$row->email."
				</div>
				<div class='col'>
					".$row->jobposition."
				</div>
				<div class='col-1'>
					".$role."
				</div>
				<div class='col-1'>
					".$status."
				</div>
				<div class='col-2 text-center'>
					<a href='#' class='editUser' data-toggle='modal' data-id='".$row->userID."' data-target='#adminedituser'>Edit</a> | 
                  	<a href='#' class='deleteUser' data-toggle='modal' data-id='".$row->userID."' data-target='#admindeleteuser'>Delete</a>
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
          <i class='fas fa-user my-3' style='font-size:40px;'></i>
          <h5>".$array['nouserfound']."</h5>
          <p> ".$array['nouserfoundexplain']."</p>
        </div>
      </div>
    </div>
	";
}


echo $view;
?>