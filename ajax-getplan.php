<?php
require_once 'core/init.php';
if(Input::exists()){
	$planID = escape(Input::get('planID'));

	$planobject = new Plan();
	$data = $planobject->searchOnlyPlan($planID);

    $userobject = new User();
    $result = $userobject->searchOnly($data->userID);

    $array = [
    	"id" => $data->planID,
        "plan" => revertescape($data->plan),
        "startdate" => $data->startdate,
        "enddate" => $data->enddate,
        "status" => $data->status,
        "userID" => $result->firstname." ".$result->lastname." - ".$result->email
	];


	echo json_encode($array);
}
?>