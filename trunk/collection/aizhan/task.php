<?php
	
	require_once("aizhan.php");
	
	ignore_user_abort(); // run script in background
	set_time_limit(0); // run script forever
	$min = isset($_GET['min'])?$_GET['min']:1;
	$interval=6; // do every 5 sec...
	$fileName="state.php";
	$handle = fopen($fileName,"w");
		fwrite($handle,"<?php return 1;?>");
		fclose($handle);	
	do{
	$run = include 'state.php';
	if(!$run) {
	die('已停止');
	}
	insertKeyWords();
	sleep($interval); // wait 15 minutes
	}while(true);
?>