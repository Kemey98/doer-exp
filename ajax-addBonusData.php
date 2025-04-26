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

 $dataz = count($_POST["totalafterpayment"]);
// print_r($wallet);

  $company_ids=escape(Input::get('company_id')); 
  $year=escape(Input::get('year'));
  
  $dept_id=escape(Input::get('dept_id'));
 
  $payment=escape(Input::get('payment'));
 
	
    function checkData($dataz) {
    $check = "";


 
   for($j=0; $j<$dataz; $j++) {
     if(trim($_POST["totalafterpayment"][$j] == '') || trim($_POST["staffid"][$j] == '') || trim($_POST["jobid"][$j] == '')|| trim($_POST["kpi"][$j] == '')) {
          $check = "Required"; 
          break; 
        }
	      else{
          $check =  "Valid";
        }
 
 }
 return $check;
  }
	
	 
  function exists($data){
   if(empty($data)){
     return "Required";
   }else{
     return "Valid";
   }
 }
//
 function condition($data1){
  if($data1 === "Valid" ){
   return "Passed";
 }else{
  return "Failed";
	  
}
}
$condition = "Passed";
 
$walleterror = checkData($dataz);	                      

$condition = condition($walleterror);

	
if($condition === "Passed"){
$s=0;
for($i=0; $i<$dataz; $i++) {
  $int1[$i] = (round($_POST["totalafterpayment"][$i],2));
  $int2[$i] = (round($_POST["totalvalue"][$i],2));
  	
    $CalcObject = new Calculation();
    $CalcObject->addCalculationInBonus(array( 
    'staff_ID'=>$_POST["staffid"][$i],
    'job_ID'=>$_POST["jobid"][$i],
    'KPI'=>$_POST["kpi"][$i],
    'Bonus_Payout' =>  $int1[$i],
    'Bonus_Increment' => $_POST["bonusbasedonkpi"][$i],
    'Total_Bonus'  => $int2[$i],
    'company_id'  => $company_ids,
    'dept_id' => $dept_id, 
    'year'=> $year,
	'payment' => $payment,
	'date'  =>$_POST["date"][$i],
	)); 


     $Walletsetupobject = new Walletsetup();

     $data2 = $Walletsetupobject->searchwalletpositionnew($company_ids, $_POST["jobid"][$i]);
     $balmoney = $data2->money - $_POST["totalvalue"][$i];
	 $int3 = (round($balmoney,2));
	 
  // print_r($data2);
   $Walletsetupobject->addwalletlog(array(
    "wallet_id"  => $data2->wallet_id,
   'job_ID'=>$_POST["jobid"][$i],
   'dept_id' => $dept_id, 
   "weightage"  => $data2->weightage,
   "wallet_type2" => $data2->wallet_type2,
   "wallt_type" => $data2->wallt_type,
   "company_id" =>$company_ids,
   "wallet" =>$data2->wallet,
   "tarikh"     => $_POST["date"][$i],
   "action"     =>"Update",
   "moneyaction"=>"money out",
   "money"      =>  $int2[$i],     
//   "corporate_id" => $corporate    
)); 

    $Walletsetupobject->updatewallet(array(
   
"money" => $int3
     ),  $data2->wallet_id,"wallet_id");  


$data3 = $Walletsetupobject->searchwalletpositionOther($company_ids, $_POST["jobid"][$i]);
if($data3){
	if($_POST["bonusbasedonkpi"][$i] === 0.00 ){
		$int4[$i] = 0.00;
		
	}
	
	else
	{
		$int4[$i] = (round($_POST["bonusbasedonkpi"][$i],2));
		
	}
		
	 $balmoney2 = $data3->money - $_POST["bonusbasedonkpi"][$i];
	$int5 = (round($balmoney2,2));
  // print_r($data2);
   $Walletsetupobject->addwalletlog(array(
    "wallet_id"  => $data3->wallet_id,
   'job_ID'=>$_POST["jobid"][$i],
   'dept_id' => $dept_id, 
   "weightage"  => $data3->weightage,
   "wallet_type2" => $data3->wallet_type2,
   "wallt_type" => $data3->wallt_type,
   "company_id" =>$company_ids,
   "wallet" =>$data3->wallet,
   "tarikh"     => $_POST["date"][$i],
   "action"     =>"Update",
   "moneyaction"=>"money out",
   "money"      => $int4[$i],     
//   "corporate_id" => $corporate    
));   
   $Walletsetupobject->updatewallet(array(
   
"money" => $int5
     ),  $data3->wallet_id,"wallet_id");	
	
}

}


 $array = 
 [
   "condition" => $condition, 
   "w" => $walleterror,
   "company_id"	   =>$company_ids ,
  "dept_id"	       =>$dept_id, 
  "year"	       =>$year,
  "totalvalue"     =>	$_POST["totalvalue"][0] 
 ];
}
	
else{
 $array = 
 [
  "w"              => $walleterror,
 	 
];
}
echo json_encode($array);
}
?>
