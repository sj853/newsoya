<?php
	 
	require('/class/static_head.php');  
	define("_htmlPath_","html/cache/"); 
	define("_htmlEnable_", true);

	if($_SERVER["SCRIPT_NAME"]=='/jump.php'||$_SERVER["SCRIPT_NAME"]=='/total.php' ){
		define("_RehtmlTime_","43200");
		//unit :seconds
		//�ð��Сʱ,��Ϊ���ܻ��и��µĶ�������Ҫ��������֪��
		//��ҳ��soҳ�滺��ʱ�����43200
	}elseif($_SERVER["SCRIPT_NAME"]=='/index.php' || $_SERVER["SCRIPT_NAME"]=='/search.php'  ){
		define("_RehtmlTime_","3600");
		//unit :seconds
		//�ð��Сʱ,��Ϊ���ܻ��и��µĶ�������Ҫ��������֪��
		//�б�ҳ����ʱ��2����120
	}else{
		//����Ĭ�ϰ���
		define("_RehtmlTime_","43200");
	}
	
	//define("_RehtmlTime_","1800");//unit :seconds �ð��Сʱ,��Ϊ���ܻ��и��µĶ�������Ҫ��������֪��
	//define("_RehtmlTime_","43200");//unit :seconds ��12��Сʱ,��Ϊ���ܻ��и��µĶ�������Ҫ��������֪��
	$html=new html();
	
	//��������12��,�����һ�»���
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