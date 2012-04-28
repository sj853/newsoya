<?php 
	
	require_once ("../configure.php");
	require_once ("../database.php");
	set_time_limit(0);
	
 
	
	 
	function insertKeyWords(){
	
	
	 
	$url = "http://ci.aizhan.com/";
	
	$html = file_get_contents($url);
	
	$html = str_replace("$",'',$html);
	
	if(preg_match('#<div class="gg01">([^$]+)</div>#U',$html,$content)){
		$html = $content[1];
		
	}
	 
	
	if(preg_match_all('#<a[^$]+>([^$]+)</a>#U',$html,$contents)){
		$keywords = $contents[1];
		   
	}
	$keywords_array = array();
	
	foreach($keywords as $keyword){
		$keyword = trim($keyword);
		$keywords_array[$keyword] = 1 ;
	}
	
			$db = Database::Connect();
			 
		$db->insert_keywords($keywords_array,4,'爱站关键字');
		
		$db->Close();
	 
	}
	
	
?>
