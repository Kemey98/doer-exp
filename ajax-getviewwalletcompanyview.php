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
    $company_id = escape(Input::get('companyID'));
//	 $dept_id = escape(Input::get('department'));
	$Walletsetupobject = new Walletsetup();
	
	
	
	
//	if($resultresult->company_id && $resultresult->dept_id ){
  	$dataexis = $Walletsetupobject->searchwalletcompanyz($company_id);


$view = 
" 

<div class='table-responsive text-nowrap'>
<table style='width:99%;' class='table table-bordered'>
		<thead-dark>
		
		<tr style='text-align: center;'>
		
		<th class='th-sm' style='width: 5%;'>Wallet</th>
		<th class='th-sm' style='width:5%; text-align: center'>Weightage (%)</th>
		<th class='th-sm' style='width:40%; text-align: center'>Description</th>
		<th class='th-sm' style='width:40%; text-align: center'>Total Value (RM)</th>
		<th>Action</th>
		
		</tr>
		</thead-dark>
 
";
if($dataexis){
	  foreach ($dataexis as $rowz) {
		if($rowz->wallet_type2 === "1" ){
		$Mainallocationobj = new Mainallocation();
		$com = $Mainallocationobj->searchFund2($rowz->company_id);
		$budget = $com->budgetAllocated; 
		$we     = $rowz->weightage;
		$total = $budget * ($we/100); 
		
		  $view .= 
		"
		<tbody>
		<tr style='text-align: center;'>
			
			<td>".$rowz->wallet."</td>	
			<td>".$rowz->weightage."</td>	
			<td width=''>". $rowz->wallt_type."</td>
			<td width=''>". $rowz->money."</td>	
			<td><button class='btn btn-primary viewdetailcompany' style='height:40px; font-size:14px; width:90px;' type='button' data-toggle='modal' data-target='#viewdetailcompanymodal' data-id='".$rowz->wallet_id."'>&nbsp;<span><i class='fas fa-info'></i>&nbsp;&nbsp;  Details </span></button></td>
		
		</tr>		
		</tbody>
		
		";	} 
		  
		} 
}  


else{
	$view .= 
	"
</table>
	    No data 
	
	";
}
$view .= 
"
";

echo $view;}
?>
