<?php

/*
 * Created on Jan 31, 2012
 *
 * 常用函数文件
 */


//php采集:参考资料http://blog.csdn.net/binger819623/article/details/3985592
//获取目标页面文件流并转换成字符串形式
function openfile($url) {
	//if (file($url)) {
		$str = file($url);
		$count = count($str);
		$file = null;
		for ($i = 0; $i < $count; $i++) {
			$file .= $str[$i];
		}
		return $file;
	//} else {
	//	die("文件打开失败!");
	//}
}

/*
	$getstr=file_get_contents("http://weibo.com/");
*/

// 切分文件流
function cut($start, $end, $file) {
	$content = explode($start, $file);
	$content = explode($end, $content[1]);
	return $content[0];
}
// 清除垃圾代码
function del($start, $end, $content) {
	$del = cut($start, $end, $content);
	$content = str_replace($del, "", $content);
	$content = str_replace($start . $end, "", $content);
	return $content;
}

//删除url中重复的变量,变量值保留后面那个
function deleteRepeatVar($url,$del_var){
	$two_part = explode("?",$url);
	$A = explode("&",$two_part[1]);
	$result_key = array();
	for($i=0;$i<count($A);$i++){
		$B = explode("=",$A[$i]);
		if($del_var==$B[0]){
			continue;
		}else{
			$result_key[$B[0]] = $A[$i];
		}
	}
	return $two_part[0].'?'.implode("&",$result_key);
}

//隐藏电话号码中间四位数
function hidePhoneNum($phoneNum){
	if(strlen($phoneNum)>=11){
		return substr($phoneNum,0,3).'****'.substr($phoneNum,7);
	}else{
		return $phoneNum;
	}
}

//格式化时间输出,注意检查时区
function time_tran($the_time){
   date_default_timezone_set('PRC');
   $now_time = date("Y-m-d H:i:s");
   $now_time = strtotime($now_time);
   $show_time = strtotime($the_time);
   $dur = $now_time - $show_time;
   if($dur < 60){
    return $dur.'秒前';
   }else{
    if($dur < 3600){
     return floor($dur/60).'分钟前';
    }else{
     if($dur < 86400){
      return floor($dur/3600).'小时前';
     }else{
      if($dur < 259200){//3天内
       return floor($dur/86400).'天前';
      }else{
       //return $the_time;
	   return date('Y-m-d', $show_time);
      }
     }
    }
   }
}

//格式化时间输出
function time_tran_time_zone($the_time){
   $now_time = date("Y-m-d H:i:s",time()+8*60*60);
   $now_time = strtotime($now_time);
   $show_time = strtotime($the_time);
   $dur = $now_time - $show_time;
   if($dur < 0){
    return $the_time;
   }else{
    if($dur < 60){
     return $dur.'秒前';
    }else{
     if($dur < 3600){
      return floor($dur/60).'分钟前';
     }else{
      if($dur < 86400){
       return floor($dur/3600).'小时前';
      }else{
       if($dur < 259200){//3天内
        return floor($dur/86400).'天前';
       }else{
        return $the_time;
       }
      }
     }
	}
   }
}
?>
