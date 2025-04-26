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
    $company_id = escape(Input::get('company_id'));
	 $dept_id = escape(Input::get('dept_id'));
    $Walletobject = new Walletsetup();
	$data = $Walletobject->searchWalletLog2($company_id,$dept_id);

$view = 
" <div class='table-responsive text-nowrap'>
			<table style='width:65%;' class='table'>
				<thead >
					<tr style='text-align: center'>
					<th>Number </th>
					<th style='min-width:150px;'>Company Name </th>
					<th>Department Name </th>
					<th style='min-width:50px;'>Wallet Log Description</th>
					
					
					
					
					</tr>	</thead>
	
 
";
 if($data){
	 $num=0;
	   foreach($data as $row){
		   
		   $num=$num+1;
		   $companyObj = new Company();
		   $companyname = $companyObj->searchCompany($company_id);
		   
		   $groupObj = new Group();
		   $deptname = $groupObj->searchGroupz($dept_id);
			
		{ 
			
		    
			$orgDate = "$row->tarikh";  
            $newDate = date("d-m-Y", strtotime($orgDate)); 
		
			  $view .= 
		"
		<tbody>
					<tr style='text-align: center'>
					    <td style='text-align: center; width: 50px;'>".$num."</td>	
						<td style='text-align: center; width: 50px;'>".$companyname->company."</td>	
						<td style='text-align: center; width: 50px;'>".$deptname->groups."</td>	
						<td style='text-align: center;'>Wallet successfully"." ".'<i style="color:red">'.$row->action." ".'</i>' ." on ".$newDate."  by ".'<i style="color:red;">'.$resultresult->firstname." ".$resultresult->lastname."'</i>'  </td>
						
					
						
			</tr> </tbody>
		
		";	} 
		  
		  
   } 
 
 }
else{
	$view .= "NO DATA
	</table> </div>
	";
}

echo $view;}
?>
