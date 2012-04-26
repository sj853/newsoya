 <?php	

	//require_once ("configure.php");
	
	//require_once ("database.php");


	//include_once ("include.php");
	
 
	

	function insertKeyResults() {

		$db = Database :: Connect();

		$sql = "select id,keyword from keyword_task where id in (select kid from keyword_result where content='') order by time desc,hotval desc";

		$rs = $db->GetResultSet($sql);
		 
		while ($row = mysql_fetch_array($rs)) {

			$keys = $row['keyword'];
			$kid = $row['id'];

			$content = getResultByBaiDu($keys);
			
			$desc = match('#<font size=-1>([^$]+)<br>#U',$content[3]);
			
			$content = implode($content);
			
			$likes = getOtherKeys();
			
			$db->insert_keywords_result($kid, addslashes(htmlspecialchars($content)),addslashes(htmlspecialchars($likes)),strip_tags($desc));
			 

		}
		$db->Close();

	}

	function getResultByBaiDu($keys,$page=1) {
		 
		include_once ('include.php');		 
		set_time_limit(0);
		
		$url = "http://www.baidu.com/s?wd=" . urlencode($keys) . "&pn=".(($page-1)*10);

		$html = file_get_contents($url);
	 
		$html = filter($html);
		 
		if (settxt("temp", "baidutemp", $html)) {
			$con = gettext("temp", "baidutemp");
		 
		} else {
			echo "fail";
			exit;
		}

		$con = match('#<div id="container">([^$]+)<br clear=all>#U', $con);
		
	 
		$pattern = '#<table width="30%" cellpadding="0" cellspacing="0" align="right">[^$]+</table>#U';
		$replacement = " ";
		$result = preg_replace($pattern, $replacement, $con);
		$pattern = '#<p class="to_zhidao">[^$]+</p>#U';
		$con = preg_replace($pattern, $replacement, $result);

		$keywordresult = "";
		
		
		
		
		 preg_match_all('#<td class=f><h3 class="t"><a[^$]+href="([^$]+)"[^$]+>([^$]+)</a>[^$]+</h3>[^$]*<font size=-1>([^$]+)<span class="g">[^$]+</font>[^$]*</td>#U',$con,$result);
	  
		  
	 
		return  $result;

	}

	function getOtherKeys() {
	
		include_once "include.php";
		 
		 $con = gettext("temp", "baidutemp");
		 
		  
		 $result = match('#<div id="rs">([^$]+)</div>#U',$con);
		 
		 $likewords = match_all('#<a[^$]+>([^$]+)</a>#U',$result);
		 
		 $likes = "";
		 shuffle($likewords);
		 foreach($likewords as $word){
			  
		     $likes .= '<dd><a href="search.php?keys='.urldecode($word).'">'.$word.'</a></dd>';
		      
		 }
		 
		 
	      
		return $likes;
	}
	
	 function filter($html){
		$html = str_replace("$",'',$html);
		 
		$html = str_replace("百度快照","查看快照",$html);
		//$html = preg_replace('#(onmousedown=[^$]+)"#U','rel="nofollow"',$html);
		return $html;
	   }

	function encodeurl($matches) {
		$jumpUrl = "jump.php";

		return $jumpUrl . "?to=" . base64_encode($matches[0]);
	}
	
	function compress_html($string) { 
		$string = str_replace("\r\n", '', $string); //清除换行符 
		$string = str_replace("\n", '', $string); //清除换行符 
		$string = str_replace("\t", '', $string); //清除制表符 
		$pattern = array ( 
		"/> *([^ ]*) *</", //去掉注释标记 
		"/[\s]+/", 
		"/<!--[^!]*-->/", 
		"/\" /", 
		"/ \"/", 
		"'/\*[^*]*\*/'" 
		); 
		$replace = array ( 
		">\\1<", 
		" ", 
		"", 
		"\"", 
		"\"", 
		"" 
		); 
		return preg_replace($pattern, $replace, $string); 
} 
?>	