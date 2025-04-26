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
 $date = count($_POST["datecalc"]);
//  echo $date;
$CalcObj = new Calculation();
for($i=0; $i<$date; $i++){	
 $aa =$CalcObj->searchCalcByDate($company_id,$dept_id,$_POST["datecalc"][$i]);
 foreach($aa as $row){
 $id = $row->calc_id;	
 $CalcObj->deleteCalc($id);
  }
}
  $array = 
  [
   "condition" => "Passed",
   "wallet_id" => $date,

 ];
 echo json_encode($array); 
}
?>