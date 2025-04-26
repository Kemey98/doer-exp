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
	
	$wallett = escape(Input::get('walletz'));
	$weight = escape(Input::get('weightage'));
	$desc = escape(Input::get('description'));
	
    $company_id = escape(Input::get('addcategorycompany'));
	$dept_id = escape(Input::get('addcategorydept'));

	function exists ($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}

      function condition($data1,$data2,$data3)
	  { //depends how many parameter you pass
        if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid"  ){ //depends how many parameter you pass
           return "Passed";
       }
		 else{
    return "Failed";
       }
       }

$walleterror = exists($wallett);
$weighterror = exists($weight);
$descerror   = exists($desc);
	
$condition = condition($walleterror,$weighterror,$descerror);
if($condition === "Passed"){

   $Walletsetupobject = new Walletsetup();
   $Walletsetupobject->addwallet(array(
   "wallet"     => $wallett,
   "weightage"  => $weight,
   "wallt_type" => $desc,
   "dept_id"  => $dept_id,
   "company_id" =>$company_id,
//   "corporate_id" => $corporate	   
));

   $array = 
[
   "condition" => $condition,
];
}else{
   $array = 
[
  "condition"=> $condition,
  "wallett" => $walleterror,
  "weight" => $weighterror,
  "desc" => $descerror	   
];
}

	echo json_encode($array);
	
}
?>
