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
//	 $dept_id = escape(Input::get('department'));
    $Walletobject = new Walletsetup();
	$data = $Walletobject->searchWalletIDLog($wallet_id);
//	print_r($data);
	

$view = 
" <div class='table-responsive text-nowrap'>
			<table style='width:100%;' class='table'>
				<thead >
					<tr style='text-align: center'>
				
			
					<th style='width:20%;'>Money In (RM)</th>
					<th style='width:20%;'>Money Out (RM)</th>
					<th> Date Out </th>
					
					
					</tr>	</thead>
	
 
";
 if($data){
	 
	 foreach($data as $row){
	     $num = 0;
		 
		 if ($row->moneyaction === "Money In") {
		$value = $row->money;
		$moneyout = "";	
	}else{
		$moneyout = $row->money;
		$value = "";	
	}
//		   $company_id = $data->company_id;
//		   $companyObj = new Company();
//		   $companyname = $companyObj->searchCompany($company_id);
//		   $Walletsetupobject = new Walletsetup();
//	       $companywallet=$Walletsetupobject->searchwalletcompanyzfordetail($company_id);
//	       $weightagecompany = $companywallet->weightage;
//	       print_r($weightagecompany);
//	       $weightage = $data->weightage;
//	       
//	       $dept_id  = $data->dept_id;
//	      $deptobject = new Group();
//		    $deptt = $deptobject->searchGroupz($dept_id);
//	      		
//	        $allocation = $Walletsetupobject->searchAllocation($company_id,$dept_id);
//			if($allocation)
//		{ //print_r($allocation);
//			$percentageallocation = $allocation->percentage_allocation;
//		    
////			$orgDate = "$row->tarikh";  
////            $newDate = date("d-m-Y", strtotime($orgDate)); 
//$mainallocateObject = new Mainallocation();  
//$funds = $mainallocateObject->searchFundwithoutYear($company_id);
					 
           	$orgDate = "$row->tarikh";  
            $date = date("d-m-Y h:m a ", strtotime($orgDate)); 

   $num = $num +1;
//	$value = $row2 -> budgetAllocated;
//	$year  = $row2 ->year;	
//	$moneyincompany = $value * ($weightagecompany/100);
//	$moneyindept1 = $moneyincompany * ($percentageallocation/100);	
//	$moneyoutdept = $moneyindept1 * ($weightage/100);	
		
		
			  $view .= 
		"
		<tbody>
					<tr style='text-align: center'>
						
						<td>$value</td>
						<td>$moneyout</td>
					    <td>$date</td>
						
			</tr> </tbody>
		
		";	}
		
		  
} 

 
else{
	$view .= "NO DATA
	</table> </div>
	";
}

echo $view;}
?>
