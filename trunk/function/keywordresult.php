 <?php	
	require_once ("configure.php");
	require_once ("database.php");
	require_once ("include.php");


	

	function insertKeyResults() {

		$db = Database :: Connect();

		$sql = "select id,keyword from keyword_task  order by time desc,hotval desc";

		$rs = $db->GetResultSet($sql);
		 
		while ($row = mysql_fetch_array($rs)) {

			$keys = $row['keyword'];
			$kid = $row['id'];

			$content = getResultByBaiDu($keys);
			
			$desc = match('#<font size=-1>([^$]+)<br>#U',$content[3]);
			
			$content = implode($content);
			
			$likes = getOtherKeys();
			
			$db->insert_keywords_result($kid, addslashes(htmlspecialchars($content)),addslashes(htmlspecialchars($likes)),strip_tags($descs));
			 

		}
		$db->Close();

	}

	function getResultByBaiDu($keys) {
		 
		include_once "include.php";
		set_time_limit(0);
		$url = "http://www.baidu.com/s?wd=" . urlencode($keys) . "&pn=10";

		$html = file_get_contents($url);
		 $html = filter($html);

		if (settxt("temp", "baidutemp", $html)) {
			$con = gettext("temp", "baidutemp");
			
		} else {
			echo "fail";
			exit;
		}

		$html = match('#<div id="container">([^$]+)<br clear=all>#U', $con);
		
		

		$pattern = '#<table width="30%" cellpadding="0" cellspacing="0" align="right">[^$]+</table>#U';
		$replacement = " ";
		$result = preg_replace($pattern, $replacement, $html);
		$pattern = '#<p class="to_zhidao">[^$]+</p>#U';
		$html = preg_replace($pattern, $replacement, $result);

		$keywordresult = "";
		$results = match_all('#<td[^$]+>([^$]+)</td>#U', $html);

		
		 $pattern = '/(?<=href=")[^"]*/';
		 $callback = "encodeurl";
			    
		
		foreach ($results as $result) {
			$result = "<br><li>" . $result . "</li>";
			$result = preg_replace_callback($pattern,$callback,$result);
			$keywordresult .= $result . "^^^";

		}

		$keywordresultArray = explode("^^^", $keywordresult);

		shuffle($keywordresultArray);
		
		return  $keywordresultArray;

	}

	function getOtherKeys() {
	
		include_once "include.php";
		 
		 $con = gettext("temp", "baidutemp");
		 
		  
		 $result = match('#<div id="rs">([^$]+)</div>#U',$con);
		 
		 $likewords = match_all('#<a[^$]+>([^$]+)</a>#U',$result);
		 
		 $likes = "";
		 foreach($likewords as $word){
			  
		     $likes .= '<dd><a href="search.php?keys='.urldecode($word).'">'.$word.'</a></dd>';
		      
		 }
		 
		 
	      
		return $likes;
	}
	
	 function filter($html){
		$html = str_replace("$",'',$html);
		 
		$html = str_replace("百度快照","查看快照",$html);
		$html = preg_replace('#(onmousedown=[^$]+)"#U','rel="nofollow"',$html);
		return $html;
	   }

	function encodeurl($matches) {
		$jumpUrl = "jump.php";

		return $jumpUrl . "?to=" . base64_encode($matches[0]);
	}
?>	