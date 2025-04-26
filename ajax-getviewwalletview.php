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
	$dept_id = escape(Input::get('department'));

	$Walletsetupobject = new Walletsetup();
	
//	if($resultresult->company_id && $resultresult->dept_id ){
  	$data1 = $Walletsetupobject->searchwallet($company_id ,$dept_id);
	
	
	
//print_r($data1);

$view = 
" <div class='table-responsive text-nowrap'>
	<table style='width:99%;' class='table table-bordered'>
		<thead-dark>
		
		<tr style='text-align: center;'>
		
		<th class='th-sm' style='width: 5%;'>Wallet</th>
		
		<th class='th-sm' style='width:5%; text-align: center'>Weightage (%)</th>
			<th class='th-sm' style='width:40%; text-align: center'>Description</th>
			<th class='th-sm' style='width:40% ;'>Total Value (RM)</th>
			<th>Action</th></tr></thead-dark>
 			
";
if($data1){
	  foreach ($data1 as $row) {
		if($row->wallet_type2=="2"){
		  
		  //searchwallet
//		  $Mainallocationobj = new Mainallocation();
//		  $com = $Mainallocationobj->searchFund2($row->company_id);//totalbudget
//		 	
//		  $Walletsetupobject1 = new Walletsetup();	
//		  $allocation = $Walletsetupobject->searchAllocation($row->company_id, $row->dept_id);
//		  	
////		print_r($allocation);
//		$walletchoose = $allocation->choosewallet;//tkr yang allocation
//		$data2 = $Walletsetupobject1->searchWalletID($walletchoose);  	
////		print_r($data2);
//		$aaa   = $data2->weightage;
////		$aaa   = 50;
//		$budget = $com->budgetAllocated; 
//		$we     = $row->weightage;
//		$total = $budget * ($aaa/100);
//		
//		$allocationpercent = $allocation->percentage_allocation;
//		
//		$totalafterpercent = $total * ($allocationpercent/100);	
//			
//	    $totalnew = $totalafterpercent * ($we/100);	
			
		  $view .= 
		"
		<tbody>
		<tr style='text-align: center;'>
			
			<td>".$row->wallet."</td>
			
			<td>".$row->weightage."</td>	
			<td width=''>". $row->wallt_type."</td>
			<td width=''>". $row->money."</td>
			<td> <button class='btn btn-primary viewdeptdetaildept' style='height:40px; font-size:14px; width:90px;' type='button' data-toggle='modal' data-target='#viewdetaildepartment' data-id='".$row->wallet_id."'>&nbsp;<i class='fas fa-info'></i>&nbsp;&nbsp;  Details </button></td>
		</tr>			
		</tbody>
		
		";
}}}

else{
	$view .= 
	"
</table></div>
	    No data 
	
	";
}
$view .= 
"

";

echo $view;}
?>
