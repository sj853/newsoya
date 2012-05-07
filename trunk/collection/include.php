<?php
function match_all($preg,$con,$num=1){
	preg_match_all($preg,$con,$arr);
	if($arr){
		return $arr[$num];
	}
	return "";
}
function match($preg,$con,$num=1){
	preg_match($preg,$con,$arr);
	if($arr){
		return $arr[$num];
	}
	return "";
}
function gettext($bid,$cid){
	$dir = dirname(__DIR__);
	$text = file_get_contents($dir.'/'.$bid.'/'.$cid.'.txt');
	return $text;
}
function settxt($bid,$cid,$content){
	$dir = dirname(__DIR__);
	return write_file($dir.'/'.$bid.'/',$cid.'.txt',$content);
}
function write_file($path,$name,$content){
	$filename=$path.$name;
	if (!file_exists($filename)){
		if (!file_exists($path)){
			mkdir($path,0777);
		}
		touch($name);
		rename($name,$filename);
	}
	if (is_writable($filename)) {
		$handle=fopen($filename,'w');
		if (!$handle) {
			return 0;
		}
		$result=fwrite($handle,$content);
		fclose($handle);
		return $result;
	}else{
		return 0;
	}
}

function del_file($path,$name){  
	$filename=$path.$name;
	if (!file_exists($filename)) {
		return 1;
	}else {
		if (unlink($filename)){
			return 1;
		}else {
			return 0;
		}
	}
}
?>
