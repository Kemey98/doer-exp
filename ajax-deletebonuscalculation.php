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

 $company_id = escape(Input::get('company_id'));
 $dept_id    = escape(Input::get('dept_id'));
 $year       = escape(Input::get('year'));
 $totalbonus = count($_POST["totalbonus"]);
//print_r($totalbonus);
$CalcObj = new Calculation();
	
 $aa =$CalcObj->searchtodelete($company_id,$dept_id,$year);  
//$az = count($aa); 
//print_r($az);
foreach($aa as $row){
 $id = $row->bonus_id;	
 $CalcObj->deleteBonus($id);
  }

  $array = 
  [
   "condition" => "Passed",
   "company_id"=>$company_id,
"dept_id" => $dept_id,
"year" => $year	  

 ];
 echo json_encode($array); 
}
?>