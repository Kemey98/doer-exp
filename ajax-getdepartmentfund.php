<?php
require_once 'core/init.php';
if(Input::exists()){
	
     $company_id = escape(Input::get('companyID'));
	 $department = escape(Input::get('department'));
     $year = escape(Input::get('year'));
   
	
  $walletsetupObj = new Walletsetup();
//  $calculationObject = new Calculation();
//  $exist = $calculationObject->searchTrue($companyID,$year);	
	
  $departfund = $walletsetupObj->searchFundDepart($company_id, $department);

	 $mainallocateObject = new Mainallocation();	
     $funds = $mainallocateObject->searchFund3($company_id, $year);
//     $rowz = $walletsetupObj->searchwalletcompanyzz($company_id);
	
	$Walletsetupobject1 = new Walletsetup();	
	$Walletsetupobject = new Walletsetup();		  
	 
	  if($departfund){
		  foreach ($departfund as $row){
			  $a = $funds ->budgetAllocated;
			  $allocation = $Walletsetupobject->searchAllocation($row->company_id, $row->dept_id);
			  $walletchoose = $allocation->choosewallet;//tkr yang allocation
		      $data2 = $Walletsetupobject1->searchWalletID($walletchoose);  	
		      $weightagecompany   = $data2->weightage;
			  $total = $a * ($weightagecompany/100);
			  
			  $allocationpercent = $allocation->percentage_allocation;
	          $totalafterpercent = $total * ($allocationpercent/100);
			  
			  $b = $row ->weightage/100;
			
			  $total2 = $totalafterpercent * $b;
			  
			  
		  }	
		  
		
		  
	  }
	else{
		$total2 = 0;
		
	}
   
  echo json_encode($totalafterpercent);
}
?>