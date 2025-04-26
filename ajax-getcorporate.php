<?php
require_once 'core/init.php';
if(Input::exists()){
	$corporateID = escape(Input::get('corporateID'));

	$corporate = new Corporate();
	$data = $corporate->searchCorporate($corporateID);




    $array = [
    	"id" => $data->corporateID,
		"corporate" => revertescape($data->corporate),
		"scale" => $data->scale,
		"type" => "Corporate",
		"status" => $data->status,
		"leader" => $data->leaderID,
		"package" => $data->package
	];


	echo json_encode($array);
}
?>