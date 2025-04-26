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
    $walletlogobject = new Walletsetup();
	$walletlog = $walletlogobject->searchWalletLog($company_id);
   
$view = 
" <div class='table-responsive text-nowrap'>
			<table style='width:65%;' class='table'>
				<thead >
					<tr style='text-align: center'>
					
					<th style='min-width:150px;'>Name </th>
					<th style='min-width:50px;'>Wallet Log Description</th>
					
					
					
					
					</tr>	</thead>
	
 
";
 if($walletlog){
	  foreach ($walletlog as $rowz) {
		  
			
		{ 
			$companyobject = new Company();
		    $com = $companyobject->searchCompany($rowz->company_id);
		    
			$orgDate = "$rowz->tarikh";  
            $newDate = date("d-m-Y", strtotime($orgDate)); 
			  
//			$az = $AllocatedObject->searchFund2($rowz->company_id);
//            $weight = $rowz->weightage;   
//		    $budgetAllocated = $az->budgetAllocated;
//			  
//			  
//			
//			 $total = 0;
//			 $total = ($budgetAllocated/100) * $weight; 
		   
		  
//		  $total =$az->budgetAllocated;
//		  $total2= ($rowz->weightage); 	  
//		  $total3 = $total * $total2;
//			 
			  $view .= 
		"
		<tbody>
					<tr style='text-align: center'>
						<td style='text-align: center; width: 50px;'>".$com->company."</td>	
							
						<td style='text-align: center;'>Wallet successfully"." ".'<i style="color:red">'.$rowz->action." ".'</i>' ." on ".$newDate."  by ".'<i style="color:red;">'.$resultresult->firstname." ".$resultresult->lastname."'</i>'  </td>
						
					
						
			</tr> </tbody>
		
		";	} 
		  
		  
} }

else{
	$view .= 
	"
	</table>

	    No data 
	
	";
}
$view .= 
"";

echo $view;}
?>

	
					
		