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
}if(Input::exists()){
    $wallet_id = escape(Input::get('wallet_id'));
	//print_r($wallet_id);
	
//	 $dept_id = escape(Input::get('department'));
    $Walletobject = new Walletsetup();
	$data = $Walletobject->searchWallet_LogID($wallet_id);
	//print_r($wallet_id);
	

$view = 
" <div class='table-responsive text-nowrap'>
			<table style='width:100%;' class='table'>
				<thead >
					<tr style='text-align: center'>
					<th style='width:20%;'>Money In (RM)</th>
					<th style='width:20%;'>Money Out(RM)</th>
					<th>Date Money Out </th>
					
					
					</tr>	</thead>
	
 
";
 if($data){
	     $num = 0;
		   $company_id = $data[0]->company_id;
		   $companyObj = new Company();
		   $companyname = $companyObj->searchCompany($company_id);
		   $Walletsetupobject = new Walletsetup();
	       $companywallet=$Walletsetupobject->searchwalletcompanyzfordetail($company_id);
	       $weightagecompany = $companywallet->weightage;
	       
	       // $weightageposition = $data->weightage;
	       
//	        $dept_id  = $data->dept_id;
//	        $deptobject = new Group();
//		    $deptt = $deptobject->searchGroupz($dept_id);
	      	
	        $job_ID = $data[0]->job_ID;
	        $userObject = new User();
	        $userDetails = $userObject->searchByJobID($job_ID);
	        $userID = $userDetails->userID;
	        
	        $deptobject = new Group();
//		    $deptt = $deptobject->searchGroupInvolve($userID);
//  			print_r($deptt);	        
	       
 	        $allocationposition = $Walletsetupobject->searchAllocationPosition($company_id,$userID);
	        $wallet_id_department = $allocationposition->choosewallet;
	        $data2 = $Walletobject->searchWalletID($wallet_id_department);
	        $weightage = $data2->weightage;
	        $dept_id = $data2->dept_id;
	        $deptt = $deptobject->searchGroupz($dept_id);
	 
	        $allocationdepartment = $Walletsetupobject->searchAllocation($company_id,$dept_id);
//			print_r($allocation);
//		  $aaa=$Walletsetupobject->searchDetailDepartmentWallet($company_id,$dept_id);
		  //foreach ($aaa as $row4){
		 
	
	if($allocationposition)
	 {
	 if($allocationdepartment)
		{ //print_r($allocation);
			$percentageallocationdept = $allocationdepartment->percentage_allocation;
		    $percentageallocationposition = $allocationposition->percentage_allocation;
//			$orgDate = "$row->tarikh";  
//            $newDate = date("d-m-Y", strtotime($orgDate)); 
            $mainallocateObject = new Mainallocation();  
            $funds = $mainallocateObject->searchFundwithoutYear($company_id);
						// $orgDate = "$data->tarikh";  
                        // $date = date("d-m-Y h:m a ", strtotime($orgDate)); 
if($data){
	foreach($data as $row2) {
   $num = $num +1;
		$orgDate = "$row2->tarikh";  
            $date = date("d-m-Y h:m a ", strtotime($orgDate)); 
		
	if ($row2->moneyaction === "money in") {
		$value = $row2->money;
		$moneyout = "";	
	}else{
		$moneyout = $row2->money;
		$value = "";	
	}
	
	// $moneyout = $value * ($weightage/100);	
			  $view .= 
		"
		<tbody>
					<tr style='text-align: center'>	
						<td>$value</td>
						<td>$moneyout</td>
					    <td>$date</td>
						
			</tr> </tbody>
		
		";	
		
}
}
		
else{
	$view ="";
	$view .="No Data";	
}			

		  
} 
 else {
	$view ="";
	$view .="No Data Allocation";
 
 }
		 
 }
 }
else{
	$view .= "NO DATA
	</table> </div>
	";
}

echo $view;}
?>
