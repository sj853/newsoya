<?php 
	
	require_once ("../configure.php");
	require_once ("../database.php");
	set_time_limit(0);
	

	 


	 
	function insertKeyWords(){
	$db = Database :: Connect();
	 
	   $keyword = $db->GetSingleValOrDefault("select keyword from kw_task where type=1 and hotlevel=1 order by time desc limit 1","");
	
	  
	
		 $url = "http://ci.aizhan.com/".urlencode($keyword)."/";	

	 
			 
		 $html = file_get_contents($url);	
	 
		 $html = str_replace("$",'',$html);
		 
		 
		 preg_match('#<table width="100%" cellspacing="0" class="table">([^$]+)</table>#U',$html,$content);
		 $html = $content[1];
		 
		 preg_match_all('#<a href="[^$]+" target="_blank" rel="nofollow">([^$]+)</a>#U',$html,$kws);
        $kws = $kws[1];
		 preg_match_all('#<td align="right"><img[^$]+/keyword/l([^$]+).png[^$]+></td>#U',$html,$cps);
		$cps = $cps[1];
		 $keywords_array = array();
		 foreach($kws as $i=>$kw){
		
			if($cps[$i]>=1 && $cps[$i]<5){
				$keywords_array[$kw] = 0;
			}
		 }
		  
		  print_r($keywords_array);
	   
		$db->insert_keywords($keywords_array,1,'爱站关键字');
		
		$db->Close();
	  
	}
?>
