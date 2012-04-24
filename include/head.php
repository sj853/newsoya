<?php
	
	require_once "setting.php";
	require_once "/function/key_from.php";
	require_once "/class/configure.php";
	require_once "/class/database.php";
	
	define('cache',false);
	if(define('cache')){
		include_once "cache.php";
	}
	
	
?>