<?php
require_once 'core/init.php';
if(Input::exists()){
	$corporatename = escape(Input::get('corporatename'));
	$corporateleader = escape(Input::get('corporateleader'));
	$corporateID = escape(Input::get('corporateID'));

	function exists($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}

	function condition($data1, $data2){
		if($data1 === "Valid" && $data2 === "Valid"){
			return "Passed";
		}else{
			return "Failed";
		}
	}

	$corporatenameerror = exists($corporatename);
	$corporateleadererror = exists($corporateleader);

	$condition = condition($corporatenameerror, $corporateleadererror);

	if($condition === "Passed"){
		$corporateobject = new Corporate();
		$corporateobject->updateCorporate(array(
			"corporate" => $corporatename,
			"leaderID" => $corporateleader
		), $corporateID, "corporateID");
		$array = [
			"condition" => $condition
		];
	}else{
		$array = [
	    	"corporate" => $corporatenameerror,
			"leader" => $corporateleadererror,
			"condition" => $condition
		];
	}

	echo json_encode($array);
}
?>