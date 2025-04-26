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

$companyobject = new Company();
$companyresult = $companyobject->searchCompanyCorporate($resultresult->corporateID);

$view = "";
if($companyresult){
	$view .= 
	"
	<ul class='list-group list-group-flush' id='showcompanieslist'>
		<li class='list-group-item px-0'>
			<div class='row'>
				<div class='col'>
					<b>".$array['company']."</b>
				</div>
				<div class='col'>
					<b>".$array['leader']."</b>
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
	foreach ($companyresult as $row) {

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
		<li class='list-group-item px-0 searchcompany all ".$status."'>
			<div class='row'>
				<div class='col'>
					".$row->company."
				</div>
				<div class='col'>
					<img src='".$pic."' class='rounded-circle' width='30' height='30' style='object-fit: cover;''> ".$name."
				</div>
				<div class='col-1'>
					".$status."
				</div>
				<div class='col-2 text-center'>
					<a href='#' class='showcompanymember' data-id='".$row->companyID."' data-toggle='modal' data-target='#adminshowcompanymember'>View</a> | 
					<a href='#' class='editCompany' data-id='".$row->companyID."' data-toggle='modal' data-target='#admineditcompany'>Edit</a> | 
					<a href='#' class='deleteCompany' data-id='".$row->companyID."' data-toggle='modal'  data-target='#admindeletecompany'>Delete</a>
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
          <i class='far fa-building my-3' style='font-size:40px;'></i>
          <h5>".$array['nocompanyfound']."</h5>
          <p> ".$array['nocompanyfoundexplain']."</p>
        </div>
      </div>
    </div>
	";
}


echo $view;
?>