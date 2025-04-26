<?php
require_once 'core/init.php';
if(Input::exists()){
	$email = escape(Input::get('email'));
	function exists($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}

	function condition($data1){
		if($data1 === "Valid"){
			return "Passed";
		}else{
			return "Failed";
		}
	}
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	$emailerror = exists($email);
	if($emailerror === "Valid"){
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  $emailerror = "Invalid email";
		}else{
			$emailerror = "Valid";
		}
	}

	$condition = condition($emailerror);

	if($condition === "Passed"){
		try {
			$user = new User();
			$result = $user->searchOnly($email);
			if($result){
				foreach($result as $row){
					$userID = $row->userID;
					$email = $row->email;
				}

				$password = uniqid();
				$salt = Hash::salt(32);
				$newpassword = Hash::make($password, $salt);

				$user->update(array(
		  			"password" => $newpassword,
		  			"salt" => $salt

		  		), $userID, "userID");

		  		$user->forgetpassword($email, $password);

				$array = [
					"condition" => $condition,
					"email" => $email
				];
			}else{
				$array = [
					"emailerror" => true,
					"condition" => $condition
				];
			}


		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}elseif($condition === "Failed"){
		$array = [
			"email" => $emailerror,
			"condition" => $condition
		];
	}
	echo json_encode($array);
}
?>