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
	$Walletsetupobject = new Walletsetup();
	
//	if($resultresult->company_id && $resultresult->dept_id ){
  	$dataexis = $Walletsetupobject->searchwalletcompanyz($company_id);


$view = 
"
<div class='float-right' style=''>

 <div class='dropdown'>
              
			  <button type='button' data-toggle='dropdown' class='btn btn-primary'>More Action</button>
                <div class='dropdown-menu dropdown-menu-right'>
                   
                  
				  <a class='dropdown-item viewcomlog' data-toggle='modal' data-target='#viewlogcompany' id='viewcompanylog' data-id='".$company_id."' > &nbsp;<i class='fas fa-history'> &nbsp; Wallet History</i></a>
					 
				  <a class='dropdown-item' data-toggle='modal' data-target='#addwalletcompany' id='addwalletcompanybutton'>&nbsp;<i class='fas fa-plus'>&nbsp; Add Wallet</i></a>
				  
				   <a class='dropdown-item viewweightageallocated' data-toggle='modal' data-target='#viewweightageallocationmodal' id='viewweightageallocation' data-id='".$company_id."'>&nbsp;<i class='fa fa-tasks' aria-hidden='true'>&nbsp; Weightage Allocation</i></a>
				   
				  
                
				</div>
              </div>
</div>
<br>
<br>
<br><br>
<div class='table-responsive text-nowrap'>
	<table style='width:100%;' class='table table-bordered'>
		<thead-dark>
		
		<tr style='text-align: center;'>
		
		<th class='th-sm' style='width: 5%;'>Wallet</th>
		<th class='th-sm' style='width:5%; text-align: center'>Weightage (%)</th>
			<th class='th-sm' style='width:40%; text-align: center'>Description</th>
			<th class='th-sm' style='width:5% ;'>Action</th> </tr></thead-dark>
 
";
if($dataexis){
	  foreach ($dataexis as $rowz) {
		if($rowz->wallet_type2 === "1" )
		{
		  $view .= 
		"
		<tbody>
		<tr style='text-align: center;'>
			
			<td>".$rowz->wallet."</td>	
			<td>".$rowz->weightage."</td>	
			<td width=''>". $rowz->wallt_type."</td>
			
			<td class='editDelBtn' style='width: 1px;'>
              <div class='dropdown'>
              
			  <button type='button' data-toggle='dropdown' class='dots'><i class='fas fa-ellipsis-v'></i></button>
                <div class='dropdown-menu dropdown-menu-right'>
				  <a class='dropdown-item updatewalletcom' data-toggle='modal' data-target='#walletcompanyupdate' data-id='".$rowz->wallet_id."'><i class='fas fa-chart-line'></i>  Update</a>
                  
				  <a class='dropdown-item delwalletcompany' data-toggle='modal' data-target='#walletcompanybuang' data-id='".$rowz->wallet_id."'><i class='far fa-trash-alt'></i>  Delete</a>
                
				</div>
              </div>
            </td>
			
			
		
				
		</tr>		
		</tbody>
		
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
"
";

echo $view;}
?>
