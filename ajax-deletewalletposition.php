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
  $walletfrom = escape(Input::get('deletewalletchoose'));	
  //print_r($wallet_id);
 
	
  $Walletobject = new Walletsetup();
  $aa = $Walletobject-> searchWalletID($walletfrom);
  $az = $Walletobject-> searchWalletID($wallet_id);
  
  $cid = $az->company_id;
  $jobid = $az->job_ID;	
	
  $ab = $Walletobject->searchBonusIncrement($cid,$jobid);
  if($ab){	
  $bonus_inc = $ab->Bonus_Increment;	
  $balance_money=$aa->money+$az->money + $bonus_inc;	
  }
else
{
	$balance_money=$aa->money+$az->money;
}
	
$Walletobject->updatewallet(array(
   
     "money" =>	$balance_money
	 ), $walletfrom,"wallet_id");

$Walletobject->deletewallet($wallet_id);
//$Walletobject->deletewalletlog($wallet_id);
  $array = 
  [
   "condition" => "Passed"
 
 ];
 echo json_encode($array); 
}
?>