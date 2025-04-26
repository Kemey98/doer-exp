<?php
require_once 'core/init.php';
if(Input::exists()){
	$deletePlanID = escape(Input::get('deletePlanID'));

	$condition = "Failed";
	if($deletePlanID){
		$plan = new Plan();
		$result = $plan->deletePlan($deletePlanID);
		$condition = "Passed";
	}
	


    $array = [
    	"condition" => $condition
	];

	echo json_encode($array);
}
?>