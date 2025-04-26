<?php
require_once 'core/init.php';
if(Input::exists()){
	$edituserid = escape(Input::get('edituserid'));
	$email = escape(Input::get('edituseremail'));
	$firstname = escape(Input::get('edituserfirstname'));
	$lastname = escape(Input::get('edituserlastname'));
	$jobposition = escape(Input::get('edituserjobposition'));
	$company = escape(Input::get('editusercompany'));
	$group = escape(Input::get('editusergroup'));
	$role = escape(Input::get('edituserrole'));
	$asadmin = escape(Input::get('editasadmin'));
	$assupervisor = escape(Input::get('editassupervisor'));
	$corporateID = escape(Input::get('corporateID'));
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

	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	$emailerror = exists($email);
	if($emailerror === "Valid"){
		$userobject = new User();
		$userresult = $userobject->searchOnly($edituserid);
		if($userresult->email == $email){
			$emailerror = "Valid";
		}else{
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


		try {
			$userobject = new User();
			$userobject->update(array(
				"email" => $email,
				"firstname" => $firstname,
				"lastname" => $lastname,
				"jobposition" => $jobposition,
				"companyID" => $company,
				"role" => $role,
				"admin" => $asadmin,
				"becomesupervisor" => $assupervisor
			), $edituserid, "userID");
			$userobject->deletemembership($edituserid);

			if(empty($group)){
				
				$array = [
					"condition" => $condition
				];
			}else{

				$newgroup = explode(",",$group);
				if($newgroup){	
					for ($i=0; $i < count($newgroup); $i++) { 
						$userobject = new User();
						$userobject->insertmembership(array(
							"group_id" => $newgroup[$i],
							"member_id" => $edituserid,
							"create_by" => date('Y-m-d H:i:s')
						));
					}
				}


				$array = [
					"condition" => $condition
				];


			}
			
			
			
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
	}elseif($condition === "Failed"){
		$newgroup = explode(",",$group);
		if($newgroup[0] === ""){
			$connection = 0;
		}else{
			$connection = count($newgroup);
		}

		$array = [
			"firstname" => $firstnameerror,
			"lastname" => $lastnameerror,
			"email" => $emailerror,
			"role" => $roleerror,
			"condition" => $condition,
			"id" => $edituserid,
			"newgroup" => $connection,
			"firstname" => $firstnameerror,
			"lastname" => $lastnameerror,
			"jobposition" => $jobpositionerror
		];
	}
	echo json_encode($array);
}
?>