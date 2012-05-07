 <?php	

 

	include_once ('include.php');	 
	include_once ("data_cache.php");
	
	
 
	 
	 function insertKeyResults() {

			$db = Database :: Connect();

			$sql = "select id,keyword from kw_task where isok=0 order by time desc,hotval desc";

			$rs = $db->GetResultSet($sql);
			
			while ($row = mysql_fetch_array($rs)) {

				$keys = $row['keyword'];
				$kid = $row['id'];

				if(shuffleResult($keys)>0){
					$sql = "update kw_task set isok=1 where id=".$rs['id'];
					$db->Execute($sql);
					 
				}
				 
			}
			
			$db->Close();

		}
	
	function shuffleResult($keys){
		 $rs = getResultByBaiDu($keys,1);
		 $rs2 = getResultByBaiDu($keys,2);
		 $result['title'] = array_merge($rs[3],$rs2[3]);
		 $result['content'] = array_merge($rs[2],$rs2[2]);
		 $result['url'] = array_merge($rs[1],$rs2[1]);
		 $result['likes'] = getRelatedResultByBaiDu($keys);
		 shuffle($result);
		 return setCache($keys,$result);
	}
	
	function getRelatedResultByBaiDu($keys){
		$con = getBaiduHtml($keys);
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