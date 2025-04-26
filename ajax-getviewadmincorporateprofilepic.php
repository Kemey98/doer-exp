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
$corporateobjectresult = $corporateobject->searchCorporate($resultresult->corporateID);
if($corporateobjectresult->profilepic){
  $pic = "data:image/jpeg;base64,".base64_encode($corporateobjectresult->profilepic);
}else{
  $pic = "img/userprofile.png";
}

$view = 
"
<img src='".$pic."' class='rounded-circle' width='100' height='100' style='object-fit: cover;'>
";
echo $view;
?>