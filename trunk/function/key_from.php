<?php
//获取来自搜索引擎入站时的关键词
function get_keyword($url,$kw_start){
  $start=stripos($url,$kw_start);
  $url=substr($url,$start+strlen($kw_start));
  $start=stripos($url,'&');
   if ($start>0)
   {
    $start=stripos($url,'&');
    $s_s_keyword=substr($url,0,$start);
   }
   else
   {
   $s_s_keyword=substr($url,0);
   }
  return $s_s_keyword;
}
 
 $url=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';//获取入站url。

 $search_1="google.com"; //q= utf8
 $search_2="baidu.com"; //wd= gbk
 $search_3="yahoo.cn"; //q= utf8
 $search_4="sogou.com"; //query= gbk
 $search_5="soso.com"; //w= gbk
 $search_6="bing.com"; //q= utf8
 $search_7="youdao.com"; //q= utf8
 
 $google=preg_match("/\b{$search_1}\b/",$url);//记录匹配情况，用于入站判断。
 $baidu=preg_match("/\b{$search_2}\b/",$url);
 $yahoo=preg_match("/\b{$search_3}\b/",$url);
 $sogou=preg_match("/\b{$search_4}\b/",$url);
 $soso=preg_match("/\b{$search_5}\b/",$url);
 $bing=preg_match("/\b{$search_6}\b/",$url);
 $youdao=preg_match("/\b{$search_7}\b/",$url);
 $s_s_keyword="";

   if ($google)
  {//来自google
   $s_s_keyword=get_keyword($url,'q=');//关键词前的字符为"q="。
   $s_s_keyword=urldecode($s_s_keyword);
   //$s_s_keyword=iconv("GBK","UTF-8",$s_s_keyword);//引擎为gbk
  }
  else if($baidu)
  {//来自百度
   $s_s_keyword=get_keyword($url,'wd=');//关键词前的字符为"wd="。
   $s_s_keyword=urldecode($s_s_keyword);
   $s_s_keyword=iconv("GBK","UTF-8",$s_s_keyword);//引擎为gbk
  }
  else if($yahoo)
  {//来自雅虎
   $s_s_keyword=get_keyword($url,'q=');//关键词前的字符为"q="。
   $s_s_keyword=urldecode($s_s_keyword);
   //$s_s_keyword=iconv("GBK","UTF-8",$s_s_keyword);//引擎为gbk
  }
  else if($sogou)
  {//来自搜狗
   $s_s_keyword=get_keyword($url,'query=');//关键词前的字符为"query="。
   $s_s_keyword=urldecode($s_s_keyword);
  // $s_s_keyword=iconv("GBK","UTF-8",$s_s_keyword);//引擎为gbk
  }
  else if($soso)
  {//来自搜搜
   $s_s_keyword=get_keyword($url,'w=');//关键词前的字符为"w="。
   $s_s_keyword=urldecode($s_s_keyword);
   //$s_s_keyword=iconv("GBK","UTF-8",$s_s_keyword);//引擎为gbk
  }
  else if($bing)
  {//来自必应
   $s_s_keyword=get_keyword($url,'q=');//关键词前的字符为"q="。
   $s_s_keyword=urldecode($s_s_keyword);
   //$s_s_keyword=iconv("GBK","UTF-8",$s_s_keyword);//引擎为gbk
  }
  else if($youdao)
  {//来自有道
   $s_s_keyword=get_keyword($url,'q=');//关键词前的字符为"q="。
   $s_s_keyword=urldecode($s_s_keyword);
   //$s_s_keyword=iconv("GBK","UTF-8",$s_s_keyword);//引擎为gbk
  }

  echo $s_s_keyword;
  //file_put_contents(microtime().".txt",$s_s_keyword);
?>