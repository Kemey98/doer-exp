<?php
require_once 'core/init.php';
if(Input::exists()){
	$companyID = escape(Input::get('companyID'));

	$company = new Company();
	$data = $company->searchCompany($companyID);




    $array = [
    	"id" => $data->companyID,
		"company" => revertescape($data->company),
		"scale" => $data->scale,
		"type" => "Company",
		"status" => $data->status,
		"leader" => $data->leaderID,
		"package" => $data->package
	];


	echo json_encode($array);
}
?>