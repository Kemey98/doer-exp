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
	$walletlog = $Walletsetupobject->searchWalletLog2($company_id,$dept_id);


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
	  foreach ($walletlog as $row) {
		{ 
			$deptobject = new Group();
		    $deptt = $deptobject->searchGroupz($row->dept_id);
		 	$orgDate = "$row->tarikh";  
            $newDate = date("d-m-Y", strtotime($orgDate));  
  
		  $view .= 
		"
			<tbody>
					<tr style='text-align: center'>
						<td style='text-align: center; width: 50px;'>".$deptt->groups."</td>	
						<td style='text-align: center;'>Wallet successfully"." ".'<i style="color:red">'.$row->action." ".'</i>' ." on ".$newDate."  by ".'<i style="color:red;">'.$resultresult->firstname." ".$resultresult->lastname."'</i>'  </td>
									
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
