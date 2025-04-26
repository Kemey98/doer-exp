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
    $wallet_id = escape(Input::get('company_id'));
//	print_r($wallet_id);
//	 $dept_id = escape(Input::get('department'));
    $Walletobject = new Walletsetup();
	$data = $Walletobject->searchWallet_LogID($wallet_id);
//	print_r($data); 
	

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
//	 $a = count($data);
//	 print_r($a);
//	 		foreach($data as $row){
		   $company_id = $data[0]->company_id;
		   $companyObj = new Company();
		   $companyname = $companyObj->searchCompany($company_id);
		   // $weightage = $data->weightage;
			
		// 		$orgDate = "$data->tarikh";  
  //           $date = date("d-m-Y h:m a ", strtotime($orgDate)); 
		// //{ 
			
		    
//			$orgDate = "$row->tarikh";  
//            $newDate = date("d-m-Y", strtotime($orgDate)); 
$mainallocateObject = new Mainallocation();  
$funds = $mainallocateObject->searchFundwithoutYear($company_id);				
if($data){
	foreach($data as $row2) {
   $num = $num +1;
	$date = $row2->tarikh; 
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
else{
	$view .= "NO DATA
	</table> </div>
	";
}

echo $view;}
?>
