<?php
require_once 'core/init.php';
if(Input::exists()){
	$upgradecompanyid = escape(Input::get('upgradecompanyid'));
	$upgradecorporatepackage = escape(Input::get('upgradecorporatepackage'));
	$upgradecorporatescale = escape(Input::get('upgradecorporatescale'));
	$upgradecorporatename = escape(Input::get('upgradecorporatename'));

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

	$upgradecorporatenameerror = exists($upgradecorporatename);
	if($upgradecorporatenameerror === "Valid"){
		$checkcorporate = new Corporate();
		$corporatedata = $checkcorporate->searchCorporate($upgradecorporatename);
		if($corporatedata == true){
			$upgradecorporatenameerror = "Corporate Name duplicated";
		}else{
			$upgradecorporatenameerror = "Valid";
		}
	}
	$upgradecorporatescaleerror = exists($upgradecorporatescale);
	$upgradecorporatepackageerror = exists($upgradecorporatepackage);

	

	$condition = condition($upgradecorporatenameerror, $upgradecorporatescaleerror, $upgradecorporatepackageerror);

	if($condition === "Passed"){
		$companyobject = new Company();
		$companyresult = $companyobject->searchCompany($upgradecompanyid);
		if($companyresult){
			if($companyresult->package === "Trial"){
				$effectiveDate = strtotime("+1 years +3 months", strtotime(date("Y-m-d H:i:s")));
				$expiredate = date("Y-m-d H:i:s", $effectiveDate);
			}else{
				$expiredate = $companyresult->expiredate;
			}
			$corporateobject = new Corporate();
			$corporateobject->addCorporate(array(
				"corporate" => $upgradecorporatename,
				"status" => "Active",
				"create_at" => date('Y-m-d H:i:s'),
				"scale" => $upgradecorporatescale,
				"expiredate" => $expiredate,
				"package" => $upgradecorporatepackage,
				"upgrade" => 1
			));
			$id = $corporateobject->lastinsertid();

			$companyobject->updateCompany(array(
				"corporateID" => $id,
				"scale" => null,
				"package" => null,
				"expiredate" => null
			), $upgradecompanyid, "companyID");

			$userobject = new User();
			$userobject->upgradeSetup(array(
				"corporateID" => $id,
			), $upgradecompanyid ,"companyID");

			$groupobject = new Group();
			$groupobject->updateGroup(array(
				"corporateID" => $id,
			), $upgradecompanyid, "companyID");

			$userobject->upgradelog(array(
				"corporateID" => $id,
			), $upgradecompanyid ,"companyID");

			$userobject->upgradeuserchangelog(array(
				"corporateID" => $id,
			), $upgradecompanyid ,"companyID");

			$objectiveobject = new Objective();
			$objectiveobject->updateObjective(array(
				"corporateID" => $id,
			), $upgradecompanyid ,"companyID");

			$timeframeobject = new Timeframe();
			$timeframeobject->editTimeframe(array(
				"corporateID" => $id,
			), $upgradecompanyid ,"companyID");

			$userobject->upgradeupdatelog(array(
				"corporateID" => $id,
			), $upgradecompanyid ,"companyID");

		}


		$array = [
			"condition" => $condition
		];
	}else{
		$array = [
			"corporate" => $upgradecorporatenameerror,
			"scale" => $upgradecorporatescaleerror,
			"package" => $upgradecorporatepackageerror,
			"condition" => $condition
		];
	}

	echo json_encode($array);
}
?>