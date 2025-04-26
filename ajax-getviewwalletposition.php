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
	
	
    $company_id     = escape(Input::get('companyID'));
	$job_id         = escape(Input::get('positions'));
	
	$Walletsetupobject = new Walletsetup();
  	$walletlog = $Walletsetupobject->searchWalletLog3($company_id,$job_id);


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
			$pobject = new Jobposition();
		    $poszz = $pobject->searchposiz($rowz->job_ID);
		    $orgDate = "$rowz->tarikh";  
            $newDate = date("d-m-Y", strtotime($orgDate)); 
			 
			
		 		
				
		    $view .= 
		"
			<tbody>
					<tr style='text-align: center'>
						<td style='text-align: center; width: 50px;'>".$poszz->jobname."</td>	
						<td style='text-align: center;'>Wallet successfully"." ".'<i style="color:red">'.$rowz->action." ".'</i>' ." on ".$newDate."  by ".'<i style="color:red;">'.$resultresult->firstname." ".$resultresult->lastname."'</i>'  </td>
									
			</tr> </tbody>
		
		";	}}
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
