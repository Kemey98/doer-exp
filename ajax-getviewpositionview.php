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
	$dept_id = escape(Input::get('dept'));

	$Walletsetupobject = new Walletsetup();
	$userObject = new User();
    $calcObject = new Calculation();
	$dataInCalculationExist =	$calcObject->searchDataInBonusCalc($company_id,$dept_id);
	//print_r($dataInCalculationExist);
	
	
//	if($resultresult->company_id && $resultresult->dept_id ){
//  	$data1 =$Walletsetupobject->searchwalletposition($company_id);
		
		
//		searchCalcGroup3($company_id); 
		
if($dataInCalculationExist)
{

$view ="";
$aa = count ($dataInCalculationExist);
	//print_r($aa);

$data1 =$Walletsetupobject->searchGroupBonus($company_id,$dept_id);
		
			// print_r($data1);	


			foreach ($data1 as $key) {
$num=0;
				


					$view .= " 
 	    
		
		<div class='table-responsive text-nowrap'>
	    <table style='width:99%;' class='table table-bordered'>
		<thead-dark>
		
		<tr style='text-align: center;'>
		
		<th class='th-sm' style='width: 5%;'>Number</th>
		<th class='th-sm' style='width: 5%;'>Wallet</th>
		<th class='th-sm' style='width:40%; text-align: center'>Staff Name</th>
		<th>Job Position </td>
		<th class='th-sm' style='width:5% ;'>Total Value (RM)</th>
		<th class='th-sm' style='width:5% ;'>Total<br>After Kpi (RM)</th>
		<th>Action</th>
		
		</tr></thead-dark><tbody>
";

$data2 =$calcObject->searchBonusByJobID($company_id,$dept_id, $key->Job_ID);
$positionresult =$Walletsetupobject->searchposition($company_id,$key->Job_ID);
// print_r($data2);
				
				
foreach ($positionresult as $key1) {
	$totalvalue = 0;
	$totalvalkpi = 0;
	 $num = $num+1;
	  	if($key1->wallt_type==="Bonus"){
	    foreach($data2 as $rowz){
	   
			
		$datanew  = $userObject->searchuserlist3($rowz->Staff_ID);	
		//print_r($datanew);	
		$job = $rowz->Job_ID;
		$totakkpi = ($rowz->KPI/100);	
			
		
		$staffid=$rowz->Staff_ID;
		$jobposid = $rowz->Job_ID;	
		$totalkpi = $rowz->KPI;	

		
// print_r($positionresult);
		
		//data1 = wallet position
		

//		$azz = count($data1);
//		print_r($azz);	
		// foreach($data1 as $row2){
		// $num = $num+1;	
		// $wallet = $row2->wallet;
		$name = $datanew->firstname.' '.$datanew->lastname;
		
		$jobObject = new Jobposition();
		$jobname = $jobObject->searchjob($job);
		$jobnamez = $jobname->jobname;		
		
		// $Mainallocationobj = new Mainallocation();
		// $com = $Mainallocationobj->searchFund2($company_id);//3600
		
		// $aaa= $Walletsetupobject->searchBasedOnCompanyID($company_id);
		// $weightagecompany = $aaa->weightage;//0.9
			
		// $allocation = $Walletsetupobject->searchAllocation($company_id,$dept_id);	
		// $percentallocationcompany = $allocation->percentage_allocation;//0.5
			
		// $az = $Walletsetupobject->searchwalletinposview($company_id,$dept_id);	
		// $weightagedept = $az->weightage;//0.8
		
		// $az = $Walletsetupobject-> searchAllocationPosition($company_id,$staffid);	
		// $allocatepos = $az->percentage_allocation;//0.4
		
		// $weightageposition = $row2->weightage;	
	
		// $budget = $com->budgetAllocated;
		// $totalcompany = $budget * ($weightagecompany/100);	
		// $totalallocationcompany = $totalcompany * ($percentallocationcompany/100);	
		
		// $totalweightagedepartment = $totalallocationcompany   * ($weightagedept/100);
		// $totalallocationdept      = $totalweightagedepartment * ($allocatepos/100);
		
		// $realtotal = $totalallocationdept * ($weightageposition/100);	
		// $realtotalafterkpi = $realtotal * ($totalkpi/100);
			
			
		// }

		$totalvalue =$key1->money;
	    $totalvalkpi+= $rowz->Total_Bonus;
		//$totalvaluewallet2 += $rowz->Bonus_Increment;
			
		}

			$view.="<tr style='text-align: center;'>
			
			<td>".$num."</td>
			<td width=''>".$key1->wallet."</td>
			<td width=''>$name</td>
			<td>$jobnamez</td>
			<td width=''>".$totalvalue."</td>
			<td width=''>".$totalvalkpi."</td>";
			$view .="
			<td><button class='btn btn-primary viewdetailposition' style='height:40px; font-size:14px; width:90px;' type='button' data-toggle='modal' data-target='#viewdetailpositionmodal' data-id='".$key1->wallet_id."'>&nbsp;<span><i class='fas fa-info'></i>&nbsp;&nbsp;  Details </span></button></td> 
			
			</tr></tbody>
				
			"	;
     } 
	else if ($key1->wallt_type==="Other"){
		
		 foreach($data2 as $rowz){
	   
			
		$datanew  = $userObject->searchuserlist3($rowz->Staff_ID);	
		//print_r($datanew);	
		$job = $rowz->Job_ID;
		$totakkpi = ($rowz->KPI/100);	
			
		
		$staffid=$rowz->Staff_ID;
		$jobposid = $rowz->Job_ID;	
		$totalkpi = $rowz->KPI;	

		
// print_r($positionresult);
		
		//data1 = wallet position
		

//		$azz = count($data1);
//		print_r($azz);	
		// foreach($data1 as $row2){
		// $num = $num+1;	
		// $wallet = $row2->wallet;
		$name = $datanew->firstname.' '.$datanew->lastname;
		
		$jobObject = new Jobposition();
		$jobname = $jobObject->searchjob($job);
		$jobnamez = $jobname->jobname;		

		
	    $totalvalkpi += $rowz->Bonus_Increment;
		$totalvalue = $key1->money;	
		//$totalvaluewallet2 += $rowz->Bonus_Increment;
			
		} 

			$view.="<tr style='text-align: center;'>
			
			<td>".$num."</td>
			<td width=''>".$key1->wallet."</td>
			<td width=''>$name</td>
			<td>$jobnamez</td>
			<td width=''>".$totalvalue."</td>
			<td width=''>".$totalvalkpi."</td>";
			$view .="
			<td><button class='btn btn-primary viewdetailposition' style='height:40px; font-size:14px; width:90px;' type='button' data-toggle='modal' data-target='#viewdetailpositionmodal' data-id='".$key1->wallet_id."'>&nbsp;<span><i class='fas fa-info'></i>&nbsp;&nbsp;  Details </span></button></td> 
			
			</tr></tbody>
				
			"	;
     } 
	}
}

				
		$view.="</table></div>";
}
	else{
		
		$view ="";
		$view.="No Data";
	}


echo $view;}
?>
