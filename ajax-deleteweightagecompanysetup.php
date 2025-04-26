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
 $dept_id = count($_POST["deptID"]);
 $percent = count($_POST["percent_allocation"]);	
//print_r($wallet);
//print_r($dept_id);
//print_r($percent);	
//print_r($company_id);	
$WalletObj = new Walletsetup();
	
for($i=0; $i<$dept_id; $i++){	
 $aa =$WalletObj->searchWeightageSetup($company_id,$_POST["deptID"][$i],$_POST["percent_allocation"][$i],$wallet);

foreach($aa as $row){
 $id = $row->allocation_id;	
 $WalletObj->deleteWeightage($id);
  }
}
  $array = 
  [
   "condition" => "Passed",
   "allocation_id" => $dept_id,
   "company_id"	   =>$company_id  

 ];
 echo json_encode($array); 
}
?>