<?php
require_once 'core/init.php';
if(Input::exists()){
  $companyID = escape(Input::get('companyID'));


  $groupObject = new Jobposition();
  $joblist = $groupObject->searchcompanyjob($companyID);

    
  echo json_encode($joblist);
}

//  $groupObject = new Group();
//  $datamember = $groupObject->searchGroupMember($dept_id);
//  $userObject = new User();
//	$az = array();
////	print_r($datamember);
//  foreach($datamember as $row){
//	  
//	  $memberid = $row->member_id;
////	  print_r($memberid);
//	  
//	  $datanew  = $userObject->searchuserlist($memberid);
//	  
//	  //print_r($datanew);
//	  foreach($datanew as $row2){
//		  
//	 $userlist = $row2->jobposition;
//  //print_r($userlist);
//		array_push($az,$userlist);
//		  
//	  } 
//  }
//echo json_encode($az);
 ?>