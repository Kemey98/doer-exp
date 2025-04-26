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

 $wallet = escape(Input::get('wallet'));
 $company_id = escape(Input::get('company_id'));
 $dept_id = escape(Input::get('dept_id'));
 
 $jobID = count($_POST["jobID"]);
 $percent = count($_POST["percent_allocation"]);	
$WalletObj = new Walletsetup();

for($i=0; $i<$percent; $i++){	
 $aazz = $WalletObj->searchWeightageSetupDepartment($company_id,$_POST["jobID"][$i],$_POST["percent_allocation"][$i],$wallet);

foreach($aazz as $row){
 $id = $row->allocation_id;	
 $WalletObj->deleteWeightage($id);
  }
}
  $array = 
  [
   "condition" => "Passed",
   "allocation_id" => $jobID,
   "company_id" => $company_id,
	"dept_id" => $dept_id  
 ];
 echo json_encode($array); 
}
?>