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

// $number=count($_POST["perc"]);
// $number2=count($_POST["datecalc"]);	
// $number3=count($_POST["wallet_1"]);	

//   $perct=count($_POST["perc"]);
//   $datecalc=count($_POST["datecalc"]);
  $wallet = count($_POST["wallet_0"]);
// $wallet= $_POST["wallet_0"];

  $company_ids=escape(Input::get('company_id')); 
  $year=escape(Input::get('year'));
  $fund=escape(Input::get('fund'));
  $dept_id=escape(Input::get('dept_id'));
  $dept_fund=escape(Input::get('dept_fund'));
  $payment=escape(Input::get('payment'));
 
	
    function checkData($payment,$wallet) {
    $check = "";


    for($i=0; $i<$payment; $i++) {
 
   for($j=0; $j<$wallet; $j++) {
     if(trim($_POST["wallet_".$i][$j] == '') || trim($_POST["perc".$i] == '') || trim($_POST["datecalc".$i] == '')) {
          $check = "Required"; 
          break; 
        }
	      else{
          $check =  "Valid";
        }
        
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

 function condition($data1){
  if($data1 === "Valid" ){
   return "Passed";
 }else{
  return "Failed";
	  
}
}
$condition = "Passed";
 
$walleterror = checkData($payment,$wallet);	                      

$condition = condition($walleterror);

	
if($condition === "Passed"){
$s=0;
for($i=0; $i<$payment; $i++) {
 
	 for($j=0; $j<$wallet; $j++) {
    
     if(trim($_POST["wallet_".$i][$j] != '')) {
     
          $CalcObject = new Calculation();
    $CalcObject->addCalculation(array( 
    'percentage'=>$_POST["perc".$i],
     'date'=>$_POST["datecalc".$i],
    'dept_fund'=>$dept_fund,
    'payment' => $payment,
    'comp_id' => $company_ids,
    'year'  => $year,
    'fund_available'  => $fund,
    'dept_id' => $dept_id, 
     'wallet'=>$_POST["wallet_".$i][$j],)); 

         }
	  }
    
	 // }
   
  
	
}

 $array = 
 [
   "condition" => $condition, 
   "w" => $walleterror,
 ];
}
	
else{
 $array = 
 [
  "w" => $walleterror,
	 
  
];
}
echo json_encode($array);
}
?>
