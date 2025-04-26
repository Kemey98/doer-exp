<?php
require_once 'core/init.php';
if(Input::exists()){
	$editcompanyname = escape(Input::get('editcompanyname'));
	$editcompanyleader = escape(Input::get('editcompanyleader'));
	$editcompanyid = escape(Input::get('editcompanyid'));
	$editcompanystatus = escape(Input::get('editcompanystatus'));

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

	$editcompanynameerror = exists($editcompanyname);

	$allstatus = array("Active", "Not Active");
	$editcompanystatuserror = exists($editcompanystatus);
	if($editcompanystatuserror === "Valid"){
		if (in_array($editcompanystatus, $allstatus)){
			$editcompanystatuserror = "Valid";
		}else{
			$editcompanystatuserror = "Invalid";
		}
	}

	if($editcompanyleader){
		$editcompanyleader = $editcompanyleader;
	}else{
		$editcompanyleader = null;
	}
	$condition = condition($editcompanynameerror, $editcompanystatuserror);

	if($condition === "Passed"){
		$companyobject = new Company();
		$companyobject->updateCompany(array(
			"company" => $editcompanyname,
			"leaderID" => $editcompanyleader,
			"status" => $editcompanystatus
		), $editcompanyid, "companyID");
		$array = [
			"condition" => $condition
		];
	}else{
		$array = [
	    	"company" => $editcompanynameerror,
			"leader" => $editcompanyleadererror,
			"status" => $editcompanystatuserror,
			"condition" => $condition
		];
	}

	echo json_encode($array);
}
?>