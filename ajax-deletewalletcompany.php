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

  $wallet_id = escape(Input::get('deletewalletinput'));
 // $walletfrom = escape(Input::get('deletewalletchoose'));	
  //print_r($wallet_id);
 
	
  $Walletobject = new Walletsetup();
  //$aa = $Walletobject-> searchWalletID($walletfrom);
  $az = $Walletobject-> searchWalletID($wallet_id);

  $Walletobject->deletewallet($wallet_id);

  $array = 
  [
   "condition" => "Passed",
//   "wallet_id" => $wallet_id,
//   "balance" => $balance_money,
//	"walletfrom" => $walletfrom  
 ];
 echo json_encode($array); 
}
?>