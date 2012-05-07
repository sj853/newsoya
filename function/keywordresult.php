 <?php	

	//require_once ("configure.php");
	
	//require_once ("database.php");

include_once ('include.php');
	include_once ("data_cache.php");
	
	 $rs = getResultByBaiDu('AA制生活',3);
	 setCache('AA制生活',$rs,3);
	print_r(getCache('AA制生活',3));
	
	
	function insertKeyResults() {
			   

		$db = Database :: Connect();

		$sql = "select id,keyword from kw_task where id in (select kid from kw_result where content='') order by time desc,hotval desc limit 1";

		$rs = $db->GetResultSet($sql);
		 
		while ($row = mysql_fetch_array($rs)) {

			$keys = $row['keyword'];
			$kid = $row['id'];

			$content = getResultByBaiDu($keys);
			
			$desc = match('#<font size=-1>([^$]+)<br>#U',$content[3]);
			
			$content = implode($content);
			
			$likes = getOtherKeys();
			
			//$db->insert_keywords_result($kid, addslashes(htmlspecialchars($content)),addslashes(htmlspecialchars($likes)),strip_tags($desc));
			 

		}
		$db->Close();

	}
	
	function getRelatedResultByBaiDu($keys){
		$con = getBaiduHtml($keys,$page);
		$kwLike = match('#<div id="rs">([^$]+)</div>#U',$con);
		$likes = match_all('#<a[^$]+>([^$]+)</a>#U',$kwLike);
		return $likes;
	}

	function getResultByBaiDu($keys,$page=1) {
		 
		$con = getBaiduHtml($keys,$page);
		 
		$resultHtml = match('#<div id="container">([^$]+)<br clear=all>#U', $con);
		 
		$pattern = '#<table width="30%" cellpadding="0" cellspacing="0" align="right">[^$]+</table>#U';
		$replacement = " ";
		$result = preg_replace($pattern, $replacement, $resultHtml);
		$pattern = '#<p class="to_zhidao">[^$]+</p>#U';
		$resultHtml = preg_replace($pattern, $replacement, $result);

		$keywordresult = "";
		 
		preg_match_all('#<td class=f><h3 class="t"><a[^$]+href="([^$]+)"[^$]+>([^$]+)</a>[^$]+</h3>[^$]*<font size=-1>([^$]+)<span class="g">[^$]+</font>[^$]*</td>#U',$resultHtml,$result);
	 
		return $result;

	}
 
	
	function getBaiduHtml($keys,$page=1){
 
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
		return $html;
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
	
 
?>	