<?php
require_once 'core/init.php';
if(Input::exists()){
	$deleteuserid = escape(Input::get('deleteuserid'));

	$condition = "Failed";

	$userobject = new User();
	$userresult = $userobject->searchOnly($deleteuserid);
	if($userresult){
		if($userresult->corporateID){
			$userresult1 = $userobject->searchWithCorporate($userresult->corporateID);
			if($userresult1){
				$usernum = count($userresult1);
			}
			$usernum = $usernum-1;
			$userobject->insertChangeofUserLog(array(
				"corporateID" => $userresult->corporateID,
				"companyID" => null,
				"totalnumber" => $usernum,
				"time" => date("Y-m-d H:i:s")
			));
		}else{
			$userresult1 = $userobject->searchWithCompany($userresult->companyID);
			if($userresult1){
				$usernum = count($userresult1);
			}
			$usernum = $usernum-1;
			$userobject->insertChangeofUserLog(array(
				"corporateID" => null,
				"companyID" => $userresult->companyID,
				"totalnumber" => $usernum,
				"time" => date("Y-m-d H:i:s")
			));
		}
		$userobject->deleteUser($deleteuserid);
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