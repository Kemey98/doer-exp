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

$corporateobject = new Corporate();
$user = new User();
$corporateobjectresult = $corporateobject->searchCorporate($resultresult->corporateID);
$userresult = $user->searchOnly($corporateobjectresult->leaderID);
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
$view = 
"
<div class='form-group'>
	<div class='row'>
	  <div class='col'>
	    <label><h6 class='m-0'>CORPORATE NAME</h6></label>
	    <input type='text' class='form-control rounded-0' id='corporatename' name='corporatename' value='".$corporateobjectresult->corporate."' readonly>
	  </div>
	</div>
</div>
<div class='form-group'>
	<div class='row'>
	  <div class='col'>
	  	<label><h6 class='m-0'>LEADER</h6></label>
	    <br><img src='".$pic."' class='rounded-circle' width='30' height='30' style='object-fit: cover;'> ".$name."
	  </div>
	</div>
</div>
";
echo $view;
?>