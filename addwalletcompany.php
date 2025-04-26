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
	$wallettype = escape(Input::get('wallettype2'));
	$wallett = escape(Input::get('walletcom'));
	$weight = escape(Input::get('weightagecom'));
	$desc = escape(Input::get('descriptioncom'));
	
    $company_id = escape(Input::get('addcom'));
	$dateforcompany = escape(Input::get('dateforcompany'));

	function exists ($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}

	function weightagecalc($company_id,$weight){
        $compobjcal = new Walletsetup();
         $datatrue = $compobjcal->searchweightagecomp($company_id);

        $sum=0;
             if ($datatrue){
                 foreach ($datatrue as $row ) {
					 if($row->wallet_type2==="1"){
                     // echo $row->weightage;
                     $sum += $row->weightage;}
				 }
             }

         $total = $weight+$sum;

        if(($total) > 100){
            return "Weightage exceed 100%. Current weightage: ".$total."%";
        }else{
            return "Valid" ;
        }
    }
	
	
      function condition($data1,$data2,$data3,$data4,$data5,$data6 )
	  { //depends how many parameter you pass
        if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid"  && $data4 === "Valid" && $data5 === "Valid" && $data6 === "Valid" ){ //depends how many parameter you pass
           return "Passed";
       }
		 else{
    return "Failed";
       }
       }

$walleterror = exists($wallett);
$weighterror = exists($weight);
$descerror   = exists($desc);
$wallettypeerror = 	exists($wallettype);
$datecompanyerror = exists($dateforcompany);

if($weighterror === "Valid" ){
	
$percentterrorz = weightagecalc($company_id,$weight); }
	
else 
{
	$percentterrorz ="Required";
}

	$Mainallocationobj = new Mainallocation();
		$com = $Mainallocationobj->searchFund2($company_id);
		$budget = $com->budgetAllocated; 
		
		$total = $budget * ($weight/100);
	
$condition = condition($walleterror,$weighterror,$descerror,$wallettypeerror,$percentterrorz,$datecompanyerror);
if($condition === "Passed"){

   $Walletsetupobject = new Walletsetup();
   $Walletsetupobject->addwalletz(array(
   "wallet"     => $wallett,
   "weightage"  => $weight,
   "wallt_type" => $desc,
   "company_id" =>$company_id,
	"wallet_type2" => $wallettype,
	 "tarikh" => $dateforcompany,
	  "money" => $total 
//   "corporate_id" => $corporate	   
)); $id=$Walletsetupobject->lastinsertId();

		{

   $Walletsetupobject = new Walletsetup();
   $Walletsetupobject->addwalletlog(array(
   "wallet_id"  => $id,
   "wallet"     => $wallett,
   "weightage"  => $weight,
   "wallt_type" => $desc,
   
   "company_id" =>$company_id,
   "wallet_type2" =>$wallettype,
   "tarikh" => $dateforcompany,
   "action"=>"Add",
   "moneyaction"=>"money in",
     "money"    => $total	   
   	   
//   "corporate_id" => $corporate	   
));
	
	
	
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
  "weight11" => $weighterror,
  "desc" => $descerror,
  "wallettype" => $wallettypeerror,
  "weight2" => $percentterrorz,
  "dates"	 => $datecompanyerror  
];
}

	echo json_encode($array);
	
}
?>
