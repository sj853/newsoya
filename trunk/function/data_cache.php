<?php

function mb_unserialize ($serial_str) {
$out = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str );
return  unserialize ($out); 
}
function getCache($key,$p=0){
	
	$md5 = md5($key);
	$dir1 = substr($md5, 0, 2);
	$dir2 = substr($md5, 2, 2);
	$dir4 = substr($md5, 4, 28);
	
	$dir4 = $p>0?$dir4.'_'.$p:$dir4;
	
	$dir = dirname(__FILE__)."/cachehash/$dir1/$dir2/$dir4.txt";
	
	if (file_exists($dir)==FALSE || filemtime($dir)<time()-15*86400)
	{
		return '';
	}
 
  
	$dataStr = file_get_contents($dir);
 
	return unserialize($dataStr);
}
function setCache($key,$arr,$p=0){
 
	$md5 = md5($key);
	$dir1 = substr($md5, 0, 2);
	$dir2 = substr($md5, 2, 2);
	$dir4 = substr($md5, 4, 28);
	
	$dir4 = $p>0?$dir4.'_'.$p:$dir4;
	
	$dir = dirname(__FILE__)."/cachehash/$dir1/$dir2/";
 
	$content = serialize($arr);
	return write_data($dir,$dir4.'.txt',$content);
}

function write_data($path,$name,$content){
	$filename=$path.$name;
	if (!file_exists($path)){
		mkdir($path, 0777, true);
	}
	return  file_put_contents($filename,$content);
}