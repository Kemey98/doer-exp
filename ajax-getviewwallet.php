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
	
//	if($resultresult->company_id && $resultresult->dept_id ){
  	$data1 = $Walletsetupobject->searchwallet($company_id ,$dept_id);
    $data2  =  $Walletsetupobject->searchwalletcompanyzz($company_id);
    
	if($data2){
	$walletchoose = $data2->wallet_id;
$view = 
" 
<div class='float-right' style=''>

 <div class='dropdown'>
              
			  <button type='button' data-toggle='dropdown' class='btn btn-primary'>More Action</button>
                <div class='dropdown-menu dropdown-menu-right'>
                   
			
                  
				  <a class='dropdown-item viewdeptlog' data-toggle='modal' data-target='#viewdepartmentlogg' id='viewdepartmentlog' data-id='".$dept_id."' > &nbsp;<i class='fas fa-history'> &nbsp; Wallet History</i></a>
					 
				  <a class='dropdown-item' id='addwalletbutton' data-toggle='modal' data-target='#addwallet'>&nbsp;<i class='fas fa-plus'>&nbsp; Add Wallet</i></a>
				  
				   <a class='dropdown-item viewweightageallocatedept' data-toggle='modal' data-target='#viewweightageallocationmodaldepartment' data-id='".$dept_id."'>&nbsp;<i class='fa fa-tasks' aria-hidden='true'>&nbsp; Weightage Allocation</i></a>
				   
				  
                
				</div>
              </div>
</div>
<br>
<br>
<br>
<br>
<div class='table-responsive text-nowrap'>
	<table style='width:100%;' class='table table-bordered'>
		<thead-dark>
		
		<tr style='text-align: center;'>
		
		<th class='th-sm' style='width: 5%;'>Wallet</th>
		<th class='th-sm' style='width:5%; text-align: center'>Weightage (%)</th>
			<th class='th-sm' style='width:40%; text-align: center'>Description</th>
			<th class='th-sm' style='width:5% ;'>Action</th> </tr></thead-dark>
 
";
if($data1){
	  foreach ($data1 as $row) {
		
		if($row->wallet_type2 === '2'){
		$jobid = $row->job_ID;
		
			
			
		$view .= 
		"
		<tbody>
		<tr style='text-align: center;'>
			
			<td>".$row->wallet."</td>	
			<td>".$row->weightage."</td>	
			<td width=''>". $row->wallt_type."</td>
			
			<td class='editDelBtn' style='width: 1px;'>
              <div class='dropdown'>
              
			  <button type='button' data-toggle='dropdown' class='dots'><i class='fas fa-ellipsis-v'></i></button>
                <div class='dropdown-menu dropdown-menu-right'>
                   
				  <a class='dropdown-item updatewallet' data-toggle='modal' data-target='#walletupdate' data-id='".$row->wallet_id."'><i class='fas fa-chart-line'></i>  Update</a>
                  
				  <a class='dropdown-item deletewallet' data-toggle='modal' data-target='#walletformbuang' data-choose='".$walletchoose."' data-id='".$row->wallet_id."'><i class='far fa-trash-alt'></i>  Delete</a>
                
				</div>
              </div>
            </td>
			
			
				
		</tr>			
		</tbody>
		
		";	}}
}

else{
	$view .= 
	"
</table></div>
	 No data 
	";
}
$view .= 
"
</ul>
";
	}
		
	else{
		
	$view ="";
	$view .= 
	"
</table>
	    No Wallet Setup in Company
	";
}

echo $view;}


?>
