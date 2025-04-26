<?php
require_once 'core/init.php';
if(Input::exists()){
	$deletegroupid = escape(Input::get('deletegroupid'));

	$group = new Group();
	$deleteresult = $group->deleteGroup($deletegroupid);
	if($deleteresult == true){
		$condition = "Passed";
	}else{
		$condition = "Failed";
	}

    $array = [
    	"condition" => $condition
	];

	echo json_encode($array);
}
?>