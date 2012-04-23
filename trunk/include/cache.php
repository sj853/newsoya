<?php
	 
	require('/class/static_head.php');  
	define("_htmlPath_","html/cache/"); 
	define("_htmlEnable_", true);

	if($_SERVER["SCRIPT_NAME"]=='/jump.php'||$_SERVER["SCRIPT_NAME"]=='/total.php' ){
		define("_RehtmlTime_","43200");
		//unit :seconds
		//用半个小时,因为可能会有更新的东西，需要搜索引擎知道
		//首页，so页面缓存时间半天43200
	}elseif($_SERVER["SCRIPT_NAME"]=='/index.php' || $_SERVER["SCRIPT_NAME"]=='/search.php'  ){
		define("_RehtmlTime_","3600");
		//unit :seconds
		//用半个小时,因为可能会有更新的东西，需要搜索引擎知道
		//列表页缓存时间2分钟120
	}else{
		//其他默认半天
		define("_RehtmlTime_","43200");
	}
	
	//define("_RehtmlTime_","1800");//unit :seconds 用半个小时,因为可能会有更新的东西，需要搜索引擎知道
	//define("_RehtmlTime_","43200");//unit :seconds 用12个小时,因为可能会有更新的东西，需要搜索引擎知道
	$html=new html();
	
	//过了晚上12点,就清空一下缓存
	if($_GET['cc']=='yes'){//date("G")=='0'||
		$html->delete();
		$html->ischage=true;
	}
	
	if ($html->check()) { 
		$template=$html->read();
		echo $template;
		
		
		exit;
		}
		ob_start();  
	ob_implicit_flush(0);
?>