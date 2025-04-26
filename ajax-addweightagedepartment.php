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
	
    $weightage   = count ($_POST["weightagevalue"]);
	$company_id  = $_POST["companyID"];
	$type        = $_POST["type"];
	$chosewallet = escape(Input::get("chosewallet"));
	$dept_id     = $_POST["dept_id"];
    $jobid       = count ($_POST["jobid"]);
	
	
	function checkData($weightage) {
    $check = "";
	
	for($i=0; $i<$weightage; $i++) {
 
     if(trim($_POST["weightagevalue"][$i] == '') || trim($_POST["jobid"][$i]=='')) 
	 {
          $check = "Required"; 
          break; 
        }
	  else
	   {
          $check =  "Valid";
        }
        
   } return $check;
}
 
	
	function exists ($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}
	
//function weightagecalc($company_id, $dept_id, $weight){
//        $deptobject = new Walletsetup();
//         $datatrue = $deptobject->searchweightagepos($company_id, $dept_id);
//
//        $sum=0;
//             if ($datatrue){
//                 foreach ($datatrue as $row ) {
////                     if($row->wallet_type2==="3"){
//                     $sum += $row->weightage;
//                 }
//             }
//
//         $total = $weight+$sum;
//
//        if(($total) > 100){
//            return "Weightage exceed 100%. Current weightage: ".$total."%";
//        }else{
//            return "Valid" ;
//        }
//    }
    
function condition($data1){
  if($data1 === "Valid" ){
   return "Passed";
 }else{
  return "Failed";
	  
}
}

 
$walleterror = checkData($weightage);	                      

$condition = condition($walleterror);
	
if($condition === "Passed"){

for($i=0; $i<$weightage; $i++) {
    
 if(trim($_POST["weightagevalue"][$i] != '') || trim($_POST["jobid"][$i] != ''))  {
     
    $walletObject = new Walletsetup();
    $walletObject->addWeightage(array( 
    'company_id'  => $company_id,
	'dept_id'=>$dept_id,
    'percentage_allocation'=>$_POST["weightagevalue"][$i],
    'jobpositionid' =>$_POST["jobid"][$i],
    'jobID' =>$_POST["jobpositionID"][$i],
	'choosewallet'=>$chosewallet,
    'type' => $type)); 

         }
	  }
    
	 // }
   
  
	


 $array = 
 [
   "condition" =>$condition, 
   "w" => $walleterror,
   "company_id" => $company_id,
	"dept_id" => $dept_id 
 ];
}
	
else{
 $array = 
 [
  "w" => $walleterror,
  "t"=>"1"
];
}
echo json_encode($array);
}
?>