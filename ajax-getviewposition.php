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
	
	$posid = escape(Input::get('posid'));

	$walletObject = new Walletsetup();
	
//	if($resultresult->company_id && $resultresult->dept_id ){
  	$data1 = $walletObject->searchposition($company_id,$posid);
	 $data3 = $walletObject->searchAllocationBYjobID($company_id,$posid);
	if($data3){
	$dept_id = $data3->dept_id;
	$data4 = $walletObject->searchwalletDepartForDelete($company_id,$dept_id);
	if($data4){
		$walletchoose = $data4->wallet_id;
	
//  print_r($data1);
$view = 
" 
<div class='float-right' style='padding-left:20px;'>
 <div class='dropdown'>
              
			  <button type='button' data-toggle='dropdown' class='btn btn-primary'>More Action</button>
                <div class='dropdown-menu dropdown-menu-right'>
                   
			
                  
				  <a class='dropdown-item viewpositionlog' data-toggle='modal' data-target='#viewpositionlogg' id='viewpositionlog' data-id='".$posid."' > &nbsp;<i class='fas fa-history'> &nbsp; Wallet History</i></a>
					 
				  <a class='dropdown-item' data-toggle='modal' data-target='#addpositionmodal' id='addwalletposition'>&nbsp;<i class='fas fa-plus'>&nbsp; Add Wallet</i></a>
                
				</div>
              </div>
</div>

</div>
<br>
<br>
<br>
<div class='table-responsive-sm text-nowrap'>
	<table style='width:100%;' class='table table-bordered'>
		<thead-dark>
		<tr style='text-align: center;'>
		
			
		<th class='th-sm' style='width:5%; min-width:inherit; '>Wallet</th>
		<th class='th-sm' style='width:5%;'>Weightage (%)</th>
			<th class='th-sm' style='width:20%; text-align: center'>Description</th>
		<th class='th-sm' style='width:5%'>Action</th>
		
	</tr>
		</thead>
 
";
if($data1){
	  foreach ($data1 as $row) {
		 if($row->wallet_type2=== "3" ){
		 
			 
		$view .= 
		"
		<tbody>
		<tr style='text-align: center;'>
				
			<td>".$row->wallet."</td>	
			<td>".$row->weightage."</th>	
			<td width=''>". $row->wallt_type."</td>	
			
			<td class='editDelBtn' style='width: 1px;'>
              <div class='dropdown'>
              
			  <button type='button' data-toggle='dropdown' class='dots'><i class='fas fa-ellipsis-v'></i></button>
                <div class='dropdown-menu dropdown-menu-right'>
				   
				  <a class='dropdown-item updatewalletposition' data-toggle='modal' data-target='#walletupdateposition' data-id='".$row->wallet_id."'><i class='fas fa-chart-line'></i> &nbsp;Update</a>
                  
				  <a class='dropdown-item delwalletposition' data-toggle='modal' data-target='#positiondeletemodal' data-choose='".$walletchoose."' data-id='".$row->wallet_id."'><i class='far fa-trash-alt'></i>&nbsp;Delete</a>
                
				</div>
              </div>
            </td>
			
			
				
		</tr>
				
		</tbody>
		
		
		";	} }
}

else{
	$view .= 
	"
</table>
	    No data 

	";
}
	}
		else{
	$view .= 
	"
</table>
	    No data 

	";
}
	}
	else{
		$view ="";
	$view .= 
	"
</table>
	    No Wallet Setup in Department

	";
}
$view .= 
"

";

echo $view;}


	
?>
