<?php
require_once 'core/init.php';
$user = new User();
if(!$user->isLoggedIn()){
  Redirect::to("login.php");
}else{
  $resultresult = $user->data();
  $userlevel = $resultresult->role;
  if($resultresult->verified == false || $resultresult->superadmin == true){
    $user->logout();
    Redirect::to("login.php?error=error");
  }
}
if(Input::exists()){
	$groupid = escape(Input::get('editgroupid'));
	$group = escape(Input::get('editgroupname'));
	$type = escape(Input::get('editgrouptype'));
	$groupstatus = escape(Input::get('editgroupstatus'));
	$leader = escape(Input::get('editgroupleader'));
	$grouptypegroupname = escape(Input::get('editgrouptypegroupname'));
	$corporateID = $resultresult->corporateID;
	$companyID = escape(Input::get('companyID'));

	function exists($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}

	function condition($data1, $data2, $data3, $data4){
		if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 === "Valid"){
			return "Passed";
		}else{
			return "Failed";
		}
	}

	if($leader){
		$leader = $leader;
	}else{
		$leader = null;
	}
	
	$grouperror = exists($group);
	$alltype = array("Department", "Team", "Project", "Campaign");
	$typeerror = exists($type);
	if($typeerror === "Valid"){
		if (in_array($type, $alltype)){
			$typeerror = "Valid";
		}else{
			$typeerror = "Invalid";
		}
	}
	$allstatus = array("Active", "Not Active");
	$groupstatuserror = exists($groupstatus);
	if($groupstatuserror === "Valid"){
		if (in_array($groupstatus, $allstatus)){
			$groupstatuserror = "Valid";
		}else{
			$groupstatuserror = "Invalid";
		}
	}

	if($corporateID){
		if($grouptypegroupname === "Company"){
			$companyunder = escape(Input::get('editcompanyunder'));
			$companyundererror = exists($companyunder);
			$condition = condition($grouperror, $typeerror, $groupstatuserror, $companyundererror);

			if($condition === "Passed"){
				try {
					$groupobject = new Group();
					$groupobject->updateGroup(array(
						"groups" => $group,
						"type" => $type,
						"status" => $groupstatus,
						"leaderID" => $leader,
						"companyID" => $companyunder,
						"corporateID" => $corporateID,
						"parentID" => null
					), $groupid, "groupID");
					$array = [
						"condition" => $condition
					];
				} catch (Exception $e) {
					echo $e->getMessage();
				}
			}elseif ($condition === "Failed") {
				$array = [
					"group" => $grouperror,
					"type" => $typeerror,
					"status" => $groupstatuserror,
					"companyunder" => $companyundererror,
					"grouptype" => "Valid",
					"grouptypename" => $grouptypegroupname,
					"condition" => $condition,
					"corporateID" => $corporateID
				];
			}

		}elseif ($grouptypegroupname === "Group") {
			$groupunder = escape(Input::get('editgroupunder'));
			$groupundererror = exists($groupunder);
			$condition = condition($grouperror, $typeerror, $groupstatuserror, $groupundererror);

			if($condition === "Passed"){
				try {
					$groupobject = new Group();
					$groupobject->updateGroup(array(
						"groups" => $group,
						"type" => $type,
						"status" => $groupstatus,
						"leaderID" => $leader,
						"parentID" => $groupunder,
						"companyID" => null,
						"corporateID" => $corporateID
					), $groupid, "groupID");
					$array = [
						"condition" => $condition
					];
				} catch (Exception $e) {
					echo $e->getMessage();
				}
			}elseif ($condition === "Failed") {
				$array = [
					"group" => $grouperror,
					"type" => $typeerror,
					"status" => $groupstatuserror,
					"groupunder" => $groupundererror,
					"grouptype" => "Valid",
					"grouptypename" => $grouptypegroupname,
					"condition" => $condition,
					"corporateID" => $corporateID
				];
			}

		}else{
			$condition = "Failed";
			$array = [
				"group" => $grouperror,
				"type" => $typeerror,
				"status" => $groupstatuserror,
				"grouptype" => "Required",
				"condition" => $condition,
				"corporateID" => $corporateID
			];
		}
	}else{
		if($grouptypegroupname === "Company"){
			$companyunder = escape(Input::get('editcompanyunder'));
			$companyundererror = exists($companyunder);
			$condition = condition($grouperror, $typeerror, $groupstatuserror, $companyundererror);

			if($condition === "Passed"){
				try {
					$groupobject = new Group();
					$groupobject->updateGroup(array(
						"groups" => $group,
						"type" => $type,
						"status" => $groupstatus,
						"leaderID" => $leader,
						"companyID" => $companyunder,
						"corporateID" => null,
						"parentID" => null
					), $groupid, "groupID");
					$array = [
						"condition" => $condition
					];
				} catch (Exception $e) {
					echo $e->getMessage();
				}
			}elseif ($condition === "Failed") {
				$array = [
					"group" => $grouperror,
					"type" => $typeerror,
					"status" => $groupstatuserror,
					"companyunder" => $companyundererror,
					"grouptype" => "Valid",
					"grouptypename" => $grouptypegroupname,
					"condition" => $condition
				];
			}

		}elseif ($grouptypegroupname === "Group") {
			$groupunder = escape(Input::get('editgroupunder'));
			$groupundererror = exists($groupunder);
			$condition = condition($grouperror, $typeerror, $groupstatuserror, $groupundererror);

			if($condition === "Passed"){
				try {
					$groupobject = new Group();
					$groupobject->updateGroup(array(
						"groups" => $group,
						"type" => $type,
						"status" => $groupstatus,
						"leaderID" => $leader,
						"companyID" => $companyID,
						"parentID" => $groupunder,
						"corporateID" => null
					), $groupid, "groupID");
					$array = [
						"condition" => $condition
					];
				} catch (Exception $e) {
					echo $e->getMessage();
				}
			}elseif ($condition === "Failed") {
				$array = [
					"group" => $grouperror,
					"type" => $typeerror,
					"status" => $groupstatuserror,
					"groupunder" => $groupundererror,
					"grouptype" => "Valid",
					"grouptypename" => $grouptypegroupname,
					"condition" => $condition
				];
			}

		}else{
			$condition = "Failed";
			$array = [
				"group" => $grouperror,
				"type" => $typeerror,
				"status" => $groupstatuserror,
				"grouptype" => "Required",
				"condition" => $condition
			];
		}
	}

	
	echo json_encode($array);
}
?>