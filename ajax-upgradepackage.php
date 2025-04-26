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
	$companyID = escape(Input::get('companyID'));
  $companyobject = new Company();
  $companyobject->updateCompany(array(
    "package" => "Free"
  ), $companyID, "companyID");

  $array = 
  [
    "companyID" => $companyID
  ];
  echo json_encode($array);
}
?>