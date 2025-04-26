<?php
require_once 'core/init.php';

if(Input::exists()){
	$plan = escape(Input::get('addplannamedaily'));
	$startdate = escape(Input::get('addplanstartdate'));
	$enddate = escape(Input::get('addplanenddate'));
	$userID = escape(Input::get('userID'));


	function exists($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}

	function condition($data1, $data2, $data3){
		if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid"){
			return "Passed";
		}else{
			return "Failed";
		}
	}

	$planerror = exists($plan);
	$startdateerror = exists($startdate);
	$enddateerror = exists($enddate);


	if($startdateerror === "Valid" && $enddateerror === "Valid"){
		$startdate1 = strtotime($startdate);
		$enddate1 = strtotime($enddate);
		if($startdate1 <= $enddate1){
			$enddateerror = "Valid";
		}else{
			$enddateerror = "End date must after start date";
		}
	}else{
		$enddateerror = "Required";
	}

	$condition = condition($planerror, $startdateerror, $enddateerror);

	if($condition === "Passed"){
		try{
			$planobject = new Plan();
			$planobject->addPlan(array(
				'plan' => $plan,
				'startdate' => $startdate,
				'enddate' => $enddate,
				'week' => date('W'),
				'year' => date('Y'),
				'userID' => $userID,
				'status' => "In Progress"
			));
			$array = [
				"condition" => $condition,
			];
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
	}else{
		$array = [
			"plan" => $planerror,
			"startdate" => $startdateerror,
			"enddate" => $enddateerror,
			"condition" => $condition
		];
	}
	
	echo json_encode($array);
}
?>