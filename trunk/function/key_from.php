<?php
//��ȡ��������������վʱ�Ĺؼ���
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
 
 $url=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';//��ȡ��վurl��

 $search_1="google.com"; //q= utf8
 $search_2="baidu.com"; //wd= gbk
 $search_3="yahoo.cn"; //q= utf8
 $search_4="sogou.com"; //query= gbk
 $search_5="soso.com"; //w= gbk
 $search_6="bing.com"; //q= utf8
 $search_7="youdao.com"; //q= utf8
 
 $google=preg_match("/\b{$search_1}\b/",$url);//��¼ƥ�������������վ�жϡ�
 $baidu=preg_match("/\b{$search_2}\b/",$url);
 $yahoo=preg_match("/\b{$search_3}\b/",$url);
 $sogou=preg_match("/\b{$search_4}\b/",$url);
 $soso=preg_match("/\b{$search_5}\b/",$url);
 $bing=preg_match("/\b{$search_6}\b/",$url);
 $youdao=preg_match("/\b{$search_7}\b/",$url);
 $s_s_keyword="";

   if ($google)
  {//����google
   $s_s_keyword=get_keyword($url,'q=');//�ؼ���ǰ���ַ�Ϊ"q="��
   $s_s_keyword=urldecode($s_s_keyword);
   //$s_s_keyword=iconv("GBK","UTF-8",$s_s_keyword);//����Ϊgbk
  }
  else if($baidu)
  {//���԰ٶ�
   $s_s_keyword=get_keyword($url,'wd=');//�ؼ���ǰ���ַ�Ϊ"wd="��
   $s_s_keyword=urldecode($s_s_keyword);
   $s_s_keyword=iconv("GBK","UTF-8",$s_s_keyword);//����Ϊgbk
  }
  else if($yahoo)
  {//�����Ż�
   $s_s_keyword=get_keyword($url,'q=');//�ؼ���ǰ���ַ�Ϊ"q="��
   $s_s_keyword=urldecode($s_s_keyword);
   //$s_s_keyword=iconv("GBK","UTF-8",$s_s_keyword);//����Ϊgbk
  }
  else if($sogou)
  {//�����ѹ�
   $s_s_keyword=get_keyword($url,'query=');//�ؼ���ǰ���ַ�Ϊ"query="��
   $s_s_keyword=urldecode($s_s_keyword);
  // $s_s_keyword=iconv("GBK","UTF-8",$s_s_keyword);//����Ϊgbk
  }
  else if($soso)
  {//��������
   $s_s_keyword=get_keyword($url,'w=');//�ؼ���ǰ���ַ�Ϊ"w="��
   $s_s_keyword=urldecode($s_s_keyword);
   //$s_s_keyword=iconv("GBK","UTF-8",$s_s_keyword);//����Ϊgbk
  }
  else if($bing)
  {//���Ա�Ӧ
   $s_s_keyword=get_keyword($url,'q=');//�ؼ���ǰ���ַ�Ϊ"q="��
   $s_s_keyword=urldecode($s_s_keyword);
   //$s_s_keyword=iconv("GBK","UTF-8",$s_s_keyword);//����Ϊgbk
  }
  else if($youdao)
  {//�����е�
   $s_s_keyword=get_keyword($url,'q=');//�ؼ���ǰ���ַ�Ϊ"q="��
   $s_s_keyword=urldecode($s_s_keyword);
   //$s_s_keyword=iconv("GBK","UTF-8",$s_s_keyword);//����Ϊgbk
  }

  echo $s_s_keyword;
  //file_put_contents(microtime().".txt",$s_s_keyword);
?>