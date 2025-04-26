<?php
require_once 'core/init.php';
if(Input::exists()){
	$id = escape(Input::get('id'));
	$oldpassword = escape(Input::get('password'));
	$newconfirmpassword = escape(Input::get('newconfirmpassword'));

	function exists($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}

	function condition($data1, $data2){
		if($data1 === "Valid" && $data2 === "Valid"){
			return "Passed";
		}else{
			return "Failed";
		}
	}

	$passworderror = exists($oldpassword);
	if($passworderror === "Valid"){
		if ((strlen($oldpassword) < 8 || strlen($oldpassword) > 16) || preg_match("/\s/", $oldpassword) || !preg_match("/\d/", $oldpassword) || !preg_match("/[A-Z]/", $oldpassword) || !preg_match("/[a-z]/", $oldpassword) || !preg_match("/\W/", $oldpassword)) {
		    $passworderror = "Password must contain [8-16] length, no space, [0-9] digit, [A-Z], [a-z] and special character";
		}
	}
	
	$confirmpassworderror = exists($newconfirmpassword);
	if($confirmpassworderror === "Valid"){
		if ((strlen($newconfirmpassword) < 8 || strlen($newconfirmpassword) > 16) || preg_match("/\s/", $newconfirmpassword) || !preg_match("/\d/", $newconfirmpassword) || !preg_match("/[A-Z]/", $newconfirmpassword) || !preg_match("/[a-z]/", $newconfirmpassword) || !preg_match("/\W/", $newconfirmpassword)) {
		    $confirmpassworderror = "Password must contain [8-16] length, no space, [0-9] digit, [A-Z], [a-z] and special character";
		}
	}

	if($passworderror === "Valid" && $confirmpassworderror === "Valid"){
		if($oldpassword != $newconfirmpassword){
			$confirmpassworderror = "Password not match!";
		}else{
			$confirmpassworderror = "Valid";
		}
	}

	$condition = condition($passworderror, $confirmpassworderror);

	if($condition === "Passed"){
		$user = new User();
		$salt = Hash::salt(32);
		$user->update(array(
			"password" => Hash::make($oldpassword, $salt),
		  	"salt" => $salt
		), $id, "userID");
		$array = [
			"password" => $passworderror,
			"newpassword" => $confirmpassworderror,
			"condition" => $condition
		];
	}elseif($condition === "Failed"){
		$array = [
			"password" => $passworderror,
			"newpassword" => $confirmpassworderror,
			"id" => $id,
			"condition" => $condition
		];
	}

	echo json_encode($array);
}
?>