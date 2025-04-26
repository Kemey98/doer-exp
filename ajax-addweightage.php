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
	
    $weightage   = count ($_POST["weightagevalue"]);
	$company_id  = $_POST["companyID"];
	$type        = $_POST["type"];
	$chosewallet = escape(Input::get("chosewallet"));
	$dept_id     = count ($_POST["dept_id"]);

	function checkData($weightage) {
    $check = "";
	
	for($i=0; $i<$weightage; $i++) {
 
     if(trim($_POST["weightagevalue"][$i] == '') || trim($_POST["dept_id"][$i] == '')) 
	 {
          $check = "Required"; 
          break; 
        }
	  else
	   {
          $check =  "Valid";
        }
        
   } return $check;
}
 
	
	function exists ($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}
	
//function weightagecalc($company_id, $dept_id, $weight){
//        $deptobject = new Walletsetup();
//         $datatrue = $deptobject->searchweightagepos($company_id, $dept_id);
//
//        $sum=0;
//             if ($datatrue){
//                 foreach ($datatrue as $row ) {
////                     if($row->wallet_type2==="3"){
//                     $sum += $row->weightage;
//                 }
//             }
//
//         $total = $weight+$sum;
//
//        if(($total) > 100){
//            return "Weightage exceed 100%. Current weightage: ".$total."%";
//        }else{
//            return "Valid" ;
//        }
//    }
    
function condition($data1){
  if($data1 === "Valid" ){
   return "Passed";
 }else{
  return "Failed";
	  
}
}

 
$walleterror = checkData($weightage);	                      

$condition = condition($walleterror);
	
$Mainallocationobj = new Mainallocation();
		$com = $Mainallocationobj->searchFund2($company_id);
		$budget = $com->budgetAllocated; //3600
        $Walletsetupobject1 = new Walletsetup();
		$data2 = $Walletsetupobject1->searchWalletID($chosewallet);  	
//		print_r($data2);
		$aaa   = $data2->weightage;
	
		$total = $budget * ($aaa/100);	//3240
	    
	
	
if($condition === "Passed"){

for($i=0; $i<$weightage; $i++) {
    
	
	
 if(trim($_POST["weightagevalue"][$i] != '') || trim($_POST["dept_id"][$i] != ''))  {
     
	 $totalnew = $total * ($_POST["weightagevalue"][$i]/100);//3240/100;
	 
    $walletObject = new Walletsetup();
    $walletObject->addWeightage(array( 
    'company_id'  => $company_id,
	'dept_id'=>$_POST["dept_id"][$i],
    'percentage_allocation'=>$_POST["weightagevalue"][$i],
    'choosewallet'=>$chosewallet,
    'type' => $type)); 
	 $id=$walletObject->lastinsertId();

//   {
//
//   $WalletObject = new Walletsetup();
//   $WalletObject->addwalletlog(array(
//   "wallet_id"  => $id,
//   
//   "weightage"  => $_POST["weightagevalue"][$i],
//   "wallet_type2" => $type,
//   "company_id" =>$company_id,
//   "dept_id"=>$_POST["dept_id"][$i],   
//   "tarikh" => date("Y-m-d H:i:s"),
//   "action"=>"Add",
//   "moneyaction"=>"money in",
//   "money"    => $totalnew 	   
//   	   
////   "corporate_id" => $corporate	   
//));
//	     
// 
// }
	 
// {
//   
//   $WalletObject = new Walletsetup();
//   $WalletObject->addwalletlog(array(
//   "wallet_id"  => $chosewallet,
//   
//   "weightage"  => $aaa,
//   "wallet_type2" => $data2->wallet_type2,
//   "wallt_type" => $data2->wallt_type,
//   "company_id" =>$company_id,
//   "wallet" =>$data2->wallet,
//   "tarikh"     => date("Y-m-d H:i:s"),
//   "action"     =>"Update",
//   "moneyaction"=>"money out",
//   "money"      => $totalnew	   
// 	   
//));
//	 }
	 
	  }
}

	
    
	 // }
   
  
	


 $array = 
 [
   "condition" =>$condition, 
   "w" => $walleterror,
	"company_id" => $company_id 
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