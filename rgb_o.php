<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style>
em {
    font-style: normal;
    color: #C00;
}
</style>
</head>

<body>

<?php
set_time_limit(0);
 
include_once('./func.php');

gather("http://www.baidu.com/s?wd=".urlencode("爱上巧克力"),1);
//gather("http://www.baidu.com/s?wd=".urlencode("电视剧2"),1);





function gather($url_str_str,$level){
	global $db;
    if($level>3){return;}//递归两级
    $getstr = openfile($url_str_str);

    $baidu_paten = "/(<table\scellpadding=\"0\"\scellspacing=\"0\"\sclass=\"result\"\sid=\"\d+\"\s>(.*?)<\/table>)/ism";
    preg_match_all($baidu_paten, $getstr, $bc);

    //相关词语
    $ralated_keyword_str=cut('<div id="rs">','</div>',$getstr);
    $link_paten = '/<a(.*?)href="(.*?)"(.*?)>(.*?)<\/a>/i';
    preg_match_all($link_paten, $ralated_keyword_str, $r_k);
    //print_r($r_k[4]);
    
    foreach ($r_k[4] as $rk) {
        //echo $level.'&nbsp;&nbsp;&nbsp;';
        /*
		for($index_temp = 0; $index_temp < $level ;$index_temp++) {
            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        }
		*/
        echo ' ++++++&nbsp;&nbsp;&nbsp;  '.iconv("gbk","UTF-8",$rk).' &nbsp;&nbsp;&nbsp; 010 <br/>';
		echo $rk.'<br/>';
		/*
		$sql = "insert into temp
					(`temp`) values('".$db->Encode($rk)."')";
		//echo $sql.'<br/>';		
		$db->ExecuteNoWarning($sql);
        //递归
		*/
        gather("http://www.baidu.com/s?wd=".urlencode($rk),$level+1);
        
    }
}


?>
ok
</body>
</html>