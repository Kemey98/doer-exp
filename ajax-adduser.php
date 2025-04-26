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
	$firstname = escape(Input::get('adduserfirstname'));
	$lastname = escape(Input::get('adduserlastname'));
	$email = escape(Input::get('adduseremail'));
	$jobposition = escape(Input::get('adduserjobposition'));
	if($resultresult->corporateID){
		$company = escape(Input::get('addusercompany'));
	}else{
		$company = $resultresult->companyID;
	}
	$group = escape(Input::get('addusergroup'));
	$role = escape(Input::get('adduserrole'));
	$asadmin = escape(Input::get('asadmin'));
	$assupervisor = escape(Input::get('assupervisor'));
	$corporateID = $resultresult->corporateID;
	$createthemselve = escape(Input::get('createthemselve'));
	$str = "";
		
	function exists($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}

	function condition($data1, $data2, $data3, $data4, $data5){
		if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 === "Valid" && $data5 === "Valid"){
			return "Passed";
		}else{
			return "Failed";
		}
	}

	$firstnameerror = exists($firstname);
	if($firstnameerror === "Valid"){
		if (!preg_match("/^[a-zA-Z ]*$/", $firstname)) {
		  $firstnameerror = "Only letters and white space allowed";
		}else{
			$firstnameerror = "Valid";
		}
	}
	$lastnameerror = exists($lastname);
	if($lastnameerror === "Valid"){
		if (!preg_match("/^[a-zA-Z ]*$/", $lastname)) {
		  $lastnameerror = "Only letters and white space allowed";
		}else{
			$lastnameerror = "Valid";
		}
	}
	$jobpositionerror = exists($jobposition);
	if($jobpositionerror === "Valid"){
		if (!preg_match("/^[a-zA-Z ]*$/", $jobposition)) {
		  $jobpositionerror = "Only letters and white space allowed";
		}else{
			$jobpositionerror = "Valid";
		}
	}

	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	$emailerror = exists($email);
	if($emailerror === "Valid"){
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  $emailerror = "Invalid email";
		}else{
			$emailerror = "Valid";
			$checkuser = new User();
			$userdata = $checkuser->find($email);
			if($userdata == true){
				$emailerror = "This Email is taken";
			}else{
				$emailerror = "Valid";
			}
		}
	}
	$roles = array("Chief", "Superior", "Manager", "Personal");
	$roleerror = exists($role);
	if($roleerror === "Valid"){
		if (in_array($role, $roles)){
			$roleerror = "Valid";
		}else{
			$roleerror = "Invalid";
		}
	}
	

	$condition = condition($firstnameerror, $lastnameerror, $emailerror, $roleerror, $jobpositionerror);

	if($condition === "Passed"){
		if($corporateID){
			$corporateobject = new Corporate();
			$corporateresult = $corporateobject->searchCorporate($corporateID);
			if($corporateresult){
				$corporatenum = $corporateresult->scale;
			}
			$userobject = new User();
			$userresult = $userobject->searchWithCorporate($corporateID);
			if($userresult){
				$usernum = count($userresult);
			}

			if($usernum >= $corporatenum){
				$exceederror = "You have exceed max number of user.";
			}else{
				$exceederror = "Valid";
			}
		}else{
			$corporateID = null;
			$companyobject = new Company();
			$companyresult = $companyobject->searchCompany($company);
			if($companyresult){
				$companynum = $companyresult->scale;
			}
			$userobject = new User();
			$userresult = $userobject->searchWithCompany($company);
			if($userresult){
				$usernum = count($userresult);
			}

			if($usernum >= $companynum){
				$exceederror = "You have exceed max number of user.";
			}else{
				$exceederror = "Valid";
			}
		}

		if($createthemselve === "true"){
			$salt = "";
			$password = "";
			$status = "Not Active";
			$verified = 0;
		}else{
			$randompassword = uniqid();
			$salt = Hash::salt(32);
			$password = Hash::make($randompassword, $salt);
			$status = "Active";
			$verified = 1;
		}

		if($company){
			$company = $company;
		}else{
			$company = null;
		}

		if($asadmin === "true"){
			$asadmin = 1;
		}else{
			$asadmin = 0;
		}

		if($assupervisor === "true"){
			$assupervisor = 1;
		}else{
			$assupervisor = 0;
		}

		$vkey = uniqid();
		if($exceederror === "Valid"){
			try {

				$userobject = new User();
				$userobject->create(array(
					"firstname" => $firstname,
					"lastname" => $lastname,
					"jobposition" => $jobposition,
					"password" => $password,
					"salt" => $salt,
					"email" => $email,
					"corporateID" => $corporateID,
					"companyID" => $company,
					"role" => $role,
					"admin" => $asadmin,
					"becomesupervisor" => $assupervisor,
					"status" => $status,
					"vkey" => $vkey,
		  			"verified" => $verified,
		  			"time" => date("Y-m-d H:i:s"),
		  			"superadmin" => 0
				));
				$id = $userobject->lastinsertid();

				$usernum = $usernum+1;
				$userobject->insertChangeofUserLog(array(
					"corporateID" => $corporateID,
					"companyID" => $company,
					"totalnumber" => $usernum,
					"time" => date("Y-m-d H:i:s")
				));

				if($createthemselve === "true"){
					$send = "Send email to register account";
				}else{
					$send = "Send email to login";
				}	

				if(empty($group)){
					
					//$userobject->verify($email, $vkey);
					$array = [
						"condition" => $condition
					];
				}else{

					$newgroup = explode(",",$group);
					if($newgroup)
					{	
						for ($i=0; $i < count($newgroup); $i++) { 
							$userobject2 = new User();
							$userobject2->insertmembership(array(
								"group_id" => $newgroup[$i],
								"member_id" => $id,
								"create_by" => date('Y-m-d H:i:s')
							));
						}
					}
					//$userobject->verify($email, $vkey);
					$array = [
						"condition" => $condition
					];
				}
			
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}else{
			$array = [
			"email" => $emailerror,
			"role" => $roleerror,
			"condition" => "Failed",
			"exceed" => $exceederror,
			"usernum" => $usernum,
			"firstname" => $firstnameerror,
			"lastname" => $lastnameerror,
			"jobposition" => $jobpositionerror
		];
		}

		
	}else{
		$array = [
			"email" => $emailerror,
			"role" => $roleerror,
			"condition" => $condition,
			"test" => $email,
			"firstname" => $firstnameerror,
			"lastname" => $lastnameerror,
			"jobposition" => $jobpositionerror
		];
	}
	echo json_encode($array);
}
?>