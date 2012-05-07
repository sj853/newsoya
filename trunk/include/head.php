<?php
	
	require_once "setting.php";
	require_once "./function/key_from.php";
	require_once "./class/configure.php";
	require_once "./class/database.php";
	
	define('hascache',false);
	if(hascache){
		include_once "cache.php";
	}
	 
	$siteTitle = isset($tempTitle)?$tempTitle."-".$config['site_name']:$config['site_name']; 
	
	$siteContent = isset($siteContent)?$siteContent:$config['site_content']; 
	
	
	
?>