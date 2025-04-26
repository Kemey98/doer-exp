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
	
	$wallett = escape(Input::get('walletz'));
	$weight = escape(Input::get('weightage'));
	$desc = escape(Input::get('description'));
	
    $company_id = escape(Input::get('addcategorycompany'));
	$dept_id = escape(Input::get('addcategorydept'));
	$wallet2 = escape(Input::get('wallet2'));
	$tarikhh = escape(Input::get('tarikh'));
   
	function exists ($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}

   
	 function weightagecalc($company_id,$dept_id,$weight){
        $deptobject = new Walletsetup();
         $datatrue = $deptobject->searchweightage($company_id,$dept_id);

        $sum=0;
             if ($datatrue){
                 foreach ($datatrue as $row ) {
                     // echo $row->weightage;
                     $sum += $row->weightage;
                 }
             }

         $total = $weight+$sum;

        if(($total) > 100){
            return "Weightage exceed 100%. Current weightage: ".$total."%";
        }else{
            return "Valid" ;
        }
    }
	
   function condition($data1,$data2,$data3,$data4,$data5,$data6)
	  { //depends how many parameter you pass
        if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 === "Valid" && $data5 === "Valid" && $data6 === "Valid" ){ //depends how many parameter you pass
           return "Passed";
       }
		 else{
    return "Failed";
       }
       }
		
	
$walleterror = exists($wallett);
$weighterror = exists($weight);
$descerror   = exists($desc);
$walleterror2   = exists($wallet2);
$dateerrors   = exists($tarikhh);	
	

if($weighterror === "Valid" ){
	
$weightageerror= weightagecalc($company_id,$dept_id,$weight); }
else 
{
	$weightageerror ="Required";
}
	
$condition = condition($walleterror,$weighterror,$descerror,$walleterror2, $weightageerror,$dateerrors);
        
	     $Walletsetupobject1 = new Walletsetup();	
		 $allocation = $Walletsetupobject1->searchAllocation($company_id, $dept_id);
	     $percent_allocation = $allocation->percentage_allocation;
	     $choosewallet = $allocation->choosewallet;
	
	
	     $Mainallocationobj = new Mainallocation();
		 $com = $Mainallocationobj->searchFund2($company_id);
		 $budget = $com->budgetAllocated; //3600
          $Walletsetupobject1 = new Walletsetup();
		  $data2 = $Walletsetupobject1->searchWalletID($choosewallet);   
	      $money = $data2->money;
//	      print_r($money);
	      
		$aaa   = $data2->weightage;
	
		$total = $budget * ($aaa/100);//3240
	
	    $totalnew = $total *($percent_allocation/100);//1620
	    $totalafterweightage = $totalnew *($weight/100);
	    
	    $balance_money = $money-$totalafterweightage;
	    
if($condition === "Passed"){

   $Walletsetupobject = new Walletsetup();
   $Walletsetupobject->addwallet(array(
   "wallet"     => $wallett,
   "weightage"  => $weight,
   "wallt_type" => $desc,
   "dept_id"  => $dept_id,
   "company_id" =>$company_id,
   "wallet_type2" =>$wallet2,
   "tarikh" => $tarikhh,
   "money"  => $totalafterweightage  
//   "corporate_id" => $corporate	   
)); $id=$Walletsetupobject->lastinsertId();

	{

   $Walletsetupobject = new Walletsetup();
   $Walletsetupobject->addwalletlog(array(
   "wallet_id"  => $id,
   "wallet"     => $wallett,
   "weightage"  => $weight,
   "wallt_type" => $desc,
   "dept_id"  => $dept_id,
   "company_id" =>$company_id,
   "wallet_type2" =>$wallet2,
   "tarikh" => $tarikhh,
   "action"=>"Add", 
"moneyaction"=>"Money In",
"money" =>	$totalafterweightage   
//   "corporate_id" => $corporate	   
));

   $Walletsetupobject = new Walletsetup();
   $Walletsetupobject->addwalletlog(array(
    "wallet_id"  => $choosewallet,
   
   "weightage"  => $aaa,
   "wallet_type2" => $data2->wallet_type2,
   "wallt_type" => $data2->wallt_type,
   "company_id" =>$company_id,
   "wallet" =>$data2->wallet,
   "tarikh"     => date("Y-m-d H:i:s"),
   "action"     =>"Update",
   "moneyaction"=>"money out",
   "money"      => $totalafterweightage,	   
//   "corporate_id" => $corporate	   
));	

{	

$Walletsetupobject = new Walletsetup();
   $Walletsetupobject->updatewallet(array(
   
"money" =>	$balance_money
	 ), $choosewallet,"wallet_id");  
}
		
   $array = 
	   [
   			"condition" => $condition,
   		];

	}
  }
	else{
   $array = 
[
  "condition"=> $condition,
  "wallett" => $walleterror,
  "weight1" => $weighterror,
  "desc" => $descerror,
  "wallet2" => $walleterror2,
  "weight"  => $weightageerror,
  "tarikhh"  => $dateerrors,	   
   	   
];
}

	echo json_encode($array);
	
}
?>
