<?php
function escape($string){
	return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

//revertescape()
function revertescape($string){
	return htmlspecialchars_decode($string, ENT_QUOTES);
}

function makeuniqueid($int){
	$int = $int*12;
	$int = base64_encode($int);
	return $int;
}

function unmakeuniqueid($string){
	$int = base64_decode($string);
	$int = $int/12;
	return $int;
}
?>