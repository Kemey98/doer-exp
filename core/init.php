<?php
session_start();
date_default_timezone_set("Asia/Kuala_Lumpur");
$GLOBALS['config'] = array(
	'database' => array(
		'host' => 'localhost',
		'username' => 'root',
		'password' => '',
		'db' => 'calendar'
	),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 604800
	),
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'
	)
);

spl_autoload_register(function($class){
	require_once 'class/'.$class.'.php';
});

require_once('functions/cleaner.php');

if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashCheck = Database::getInstance()->get('user_session', array('hash', '=', $hash));
	
	if($hashCheck->count()){
		$user = new User($hashCheck->first()->user_id);
		$user->login();
	}
}

if(isset($_GET['lang'])){
	if($_GET['lang'] == "en"){
		require_once 'lg/en.php'; 
	}elseif ($_GET['lang'] == "zh") {
		require_once 'lg/zh.php'; 
	}elseif($_GET['lang'] == "bm"){
		require_once 'lg/bm.php'; 
	}else{
		require_once 'lg/en.php'; 
	}
}else{
	require_once 'lg/en.php'; 
}
$userlevel = "";
?>