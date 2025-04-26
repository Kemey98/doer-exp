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
	
    $company_id = escape(Input::get('addcompany'));
	$jobid = escape(Input::get('addposition'));
	$wallet2 = escape(Input::get('wallet2'));
	$dateposition= escape(Input::get('dateposition'));

//print_r($dept);
    
	function exists ($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}
	
function weightagecalc($company_id, $jobid, $weight){
        $deptobject = new Walletsetup();
         $datatrue = $deptobject->searchweightagepos($company_id, $jobid);

        $sum=0;
             if ($datatrue){
                 foreach ($datatrue as $row ) {
//                     if($row->wallet_type2==="3"){
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

$walleterrorpos = exists($wallett);
$weighterrorpos = exists($weight);
$descerrorpos   = exists($desc);
$walleterrorpos2   = exists($wallet2);
	
$datepositionerror = exists($dateposition);	

if($weighterrorpos === "Valid" ){
	
$percenterror = weightagecalc($company_id,$jobid,$weight); }
else 
{
	$percenterror ="Required";
}
	$total=0;
         $Walletsetupobject = new Walletsetup();
         $Mainallocationobj = new Mainallocation();
         $com = $Mainallocationobj->searchFund2($company_id);
         $budget = $com->budgetAllocated; //3600

         $companywallet = $Walletsetupobject->searchwalletcompanyzz($company_id);
         $companymoney = $budget * ($companywallet->weightage/100);//3600 * 0.9

         $allocation = $Walletsetupobject->searchAllocationBYjobID($company_id,$jobid);
         
         $dept=$allocation->dept_id;
	     //print_r($dept);
	     $allocationdept = $Walletsetupobject->searchAllocation($company_id,$dept); //0.5
         $moneydept = $companymoney * ($allocationdept->percentage_allocation/100);//1620
         $deptwalletresult = $Walletsetupobject->searchwalletDepart($company_id,$dept);
         $deptwallet = $moneydept  * ($deptwalletresult->weightage/100);//0.8 1296
         $deptallocation = $deptwallet * ($allocation->percentage_allocation/100);
//		$searchpositionwallet = $Walletsetupobject->searchpositiondept($company_id,$dept,$jobid);
//	   $weightagepos = $searchpositionwallet->weightage;
	   $total = $deptallocation * ($weight/100);
          // print_r($deptallocation);
   $wallet_id = $allocation->choosewallet;
 
   $walletdept = $Walletsetupobject->searchWalletID($wallet_id);
   // $moneydept = $budget * ($walletdept->weightage/100);

   // $allocationmoney = $moneydept * ($allocationpercent/100);
   // $moneyposition = $allocationmoney * ($weight/100);
   $balancemoney = $walletdept->money - $total;
	$int1 = (round($balancemoney,2));
	$int2 = (round($total,2));
		
	// print_r($allocation);

$condition = condition($walleterrorpos,$weighterrorpos,$descerrorpos,$walleterrorpos2,$percenterror,$datepositionerror);
if($condition === "Passed"){

   $Walletsetupobject->addwallet(array(
   "wallet"     => $wallett,
   "weightage"  => $weight,
   "wallt_type" => $desc,
   "job_ID"  => $jobid,
   "company_id" =>$company_id,
   "wallet_type2" =>$wallet2,
   "tarikh" => $dateposition,
   "money" => $int2
	   
//   "corporate_id" => $corporate	   
)); $id=$Walletsetupobject->lastinsertId();
	
	// $Walletsetupobject = new Walletsetup();
   $Walletsetupobject->addwalletlog(array(
   "wallet_id"  => $id,
   "wallet"     => $wallett,
   "weightage"  => $weight,
   "wallt_type" => $desc,
   "job_ID"  => $jobid,
   "company_id" =>$company_id,
   "wallet_type2" =>$wallet2,
   "tarikh" => $dateposition,
   "action"=>"Add",
   "moneyaction"=>"money in",
   "money"      => $int2, 	   
));	

   $Walletsetupobject->addwalletlog(array(
    "wallet_id"  => $allocation->choosewallet,
   
   "weightage"  => $walletdept->weightage,
   "wallet_type2" => $walletdept->wallet_type2,
   "wallt_type" => $walletdept->wallt_type,
   "company_id" =>$company_id,
   "wallet"     =>$walletdept->wallet,
   "tarikh"     => $dateposition,
   "action"     =>"Update",
   "moneyaction"=>"money out",
   "money"      => $int2,     
//   "corporate_id" => $corporate    
));

 $Walletsetupobject->updatewallet(array(
   
"money" =>  $int1
     ), $allocation->choosewallet,"wallet_id");   
		
		
   $array = 
[
   "condition" => $condition,
//    "deptm" => $moneydept,
//    "allom" => $allocationmoney,
//    "posim" => $moneyposition,
//    "bm" => $balancemoney,
//    "job_ID"  => $jobid,
//    // "p_d"  => $jobid,
//    "p_a"  => $allocationpercent,
//    "p_p"  => $weight,
];
}
	else{
   $array = 
[
  "condition"=> $condition,
  "wallett" => $walleterrorpos,
  "weight1" => $weighterrorpos,
  "desc" => $descerrorpos,
  "wallet2" => $walleterrorpos2,
  "weight"  => $percenterror,
  "dateposition"  =>$datepositionerror,	
  "job_ID"  => $jobid,
  "company_id"  => $company_id,
  // "dept"  => $allocationmoney,   	   
];
}

	echo json_encode($array);
	
}
?>
