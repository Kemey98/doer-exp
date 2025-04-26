<?php
require_once 'core/init.php';
if(Input::exists()){
	$type = escape(Input::get('type'));
	$entity = escape(Input::get('entity'));
	$engagemnetfilter = escape(Input::get('engagemnetfilter'));

	$array1 = array();
	for($i=0; $i<$engagemnetfilter; $i++){
		$date = date('Y-m-d', strtotime('-'.$i.' days'));
		array_push($array1, $date);
	}
	$array1 = array_reverse($array1);

	$loginuser = array();
	$updateuser = array();



	if($type === "Corporate"){


		$userobject = new User();
		$userresult = $userobject->searchWithCorporate($entity);
		if($userresult){
			$totaluser = count($userresult);
		}
		for ($i=0; $i < count($array1); $i++) {

			$userresult = $userobject->getLogCorporate($entity, $array1[$i]);
			if($userresult){
				$count = count($userresult);
				$loginrate = ($count/$totaluser)*100;
				array_push($loginuser, $loginrate);
			}else{
				$count = 0;
				$loginrate = ($count/$totaluser)*100;
				array_push($loginuser, $loginrate);
			}

			$userresult1 = $userobject->getUpdateCorporate($entity, $array1[$i]);
			if($userresult1){
				$count1 = count($userresult1);
				$updaterate = ($count1/$totaluser)*100;
				array_push($updateuser, $updaterate);
			}else{
				$count1 = 0;
				$updaterate = ($count1/$totaluser)*100;
				array_push($updateuser, $updaterate);
			}

		}



	}elseif ($type === "Company") {



		$userobject = new User();
		$userresult = $userobject->searchWithCompany($entity);
		if($userresult){
			$totaluser = count($userresult);
		}
		for ($i=0; $i < count($array1); $i++) {

			$userresult = $userobject->getLogCompany($entity, $array1[$i]);
			if($userresult){
				$count = count($userresult);
				$loginrate = ($count/$totaluser)*100;
				array_push($loginuser, $loginrate);
			}else{
				$count = 0;
				$loginrate = ($count/$totaluser)*100;
				array_push($loginuser, $loginrate);
			}

			$userresult1 = $userobject->getUpdateCompany($entity, $array1[$i]);
			if($userresult1){
				$count1 = count($userresult1);
				$updaterate = ($count1/$totaluser)*100;
				array_push($updateuser, $updaterate);
			}else{
				$count1 = 0;
				$updaterate = ($count1/$totaluser)*100;
				array_push($updateuser, $updaterate);
			}

		}
	}

	$array = [
		"alldate" => $array1,
		"loginuser" => $loginuser,
		"updateuser" => $updateuser
	];

	echo json_encode($array);
}
?>