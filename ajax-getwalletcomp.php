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
      
      $wallet_id = escape(Input::get('wallet_ids'));

	  $Walletobject = new Walletsetup();
	  $data = $Walletobject->searchWalletID($wallet_id);
	
	  $comobject = new Company();
	  $data2     = $comobject->searchCompany($data->company_id);
	
	  $posobject = new Jobposition();
	  $data3     = $posobject->searchjob($data->job_ID);

	  $deptobject = new Group();
	  $data4      = $deptobject->searchGroupnew($data->dept_id);
//	print_r($data2);
$array = 
	
[
   "wallet_id"=>$data->wallet_id,
   "weightage"=>$data->weightage,
   "wallt_type"=>$data->wallt_type,
   "dept_id"=>$data->dept_id,
   "company_id"=>$data->company_id,
   "wallet"=>$data->wallet,
   "job_ID" =>$data->job_ID,
   "company_name" =>$data2->company,

   "condition"=>"Passed",
];
echo json_encode($array); 
}
?>
