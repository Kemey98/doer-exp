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
if(Input::exists()){
	$talkingpointID = escape(Input::get('talkingpointID'));
	$marked = escape(Input::get('marked'));

	if($marked === "true"){
		$marked = 1;
	}else{
		$marked = 0;
	}

	$PPPOOOobject = new Pppoooreport();
	$PPPOOOobject->updateOOOTalkingPoint(array(
		"status" => $marked,
	), $talkingpointID, "talkingpointID");

	$array = [
	  "condition" => $marked,
	];
	echo json_encode($array);
}
?>