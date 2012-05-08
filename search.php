<?php
 
	require ("include/head.php");
	
	$start = microtime(true);


	
	$db = Database :: Connect();
	 
	
	$aizhansql = "select id,keyword,hotlevel from kw_task where type=1 and hotlevel=1  order by rand() limit 9";	 
	$aizhanresult = $db->GetResultSet($aizhansql);
	
	$basesql = "select isok from kw_task where id=";
	
    if(isset($_GET['id'])){
	  $sql = $basesql.$_GET['id'];
	  $keys = $db->GetSingleValOrDefault("select keyword from kw_task where id={$_GET['id']}","");
	}else{
	$keys = trim($_GET['q']);
	if($keys == ""){
		header("Location: index.php"); 
		 
		exit;
		 
	}
		$sql = $basesql."(select id from kw_task where keyword='$keys' limit 1)";
	}
	
  
	  
	 include_once ("./function/keywordresult.php");
	 
	if($db->GetCount($sql)<1){

	$sql = "insert into kw_task(keyword,type,type_desc,hotlevel,time,isok) values('$keys',0,'用户查询',1,now(),1)";
	   
		 if(shuffleResult($keys)>0){
		 
					
					$db->Execute($sql);
					 
				}
		}else if($db->GetSingleValOrDefault($sql,0)==0){
		$sql = "update kw_task  set isok=1 where keyword='$keys'";
		 if(shuffleResult($keys)>0){
		 
					
					$db->Execute($sql);
					 
				}
		}
		
		
	  
		 
		$result = getCache($keys);
	 
	 
 
		$db->Close();
?>

<?php include "header.php"?>
 <script type="text/javascript" src="js/jquery-1.js"></script>
<link type="text/css" rel="stylesheet" href="css/search.css">
</head>
<script type="text/javascript">
<!--//--><![CDATA[//><!--
//ipad不需要背景变色
if( !(/\((iPhone|iPad|iPod)/i.test(navigator.userAgent)) ){
	$(document).ready(function () {
	$('.box-result').hover(
	function () {
	$(this).addClass("hover");
	},
	function () {
	$(this).removeClass("hover");
	}
	);
});
}
//--><!]]>
</script> 
<body>
<div class="wrap" id="wrap">
<div style="position:relative;z-index:10000" id="top_column">
	<div class="top clearfix" style="margin-top:5px;">
		<div class="l">
				<a   href="javascript:void(0)" class="selected" id="tab02">网页</a>	 
				</div>
		<div class="r">
			<a href="index.php" target="_blank">故事搜</a><a href="javascript:void(0)" onclick="addFavorite()">收藏本页</a>
		</div>
	</div>
	 
</div>
 
	<div class="top2">
		<h1 class="l"><a href="index.php"><img src="img/logo_big.png" alt="故事搜"></a></h1>
		<div class="search-form l">
		<form method="get" action="/" onsubmit="return submit_form(this)">
			<input autocomplete="off" name="q" maxlength="100" value="<?php echo $keys?>" class="ipt-02"   id="keyword" type="text"><input value="搜索" class="ipt-03" hidefocus="true" type="submit"> 
			  
					</form>
		</div>
	</div>
	<div class="nav clearfix">
		<div class="l">
				</div>
		<div class="r">
					 用时 <strong><?php
			$end= microtime(true);

			echo  $end-$start; 
 ?> </strong> 秒
				</div>
	</div>
	<div class="main clearfix">
						<div style="border-right: medium none; display: block;" class="l" id="sidebar">
			<div class="sidebar">
			
			<dl>
				 <dt>相关搜索</dt>
				 <dd>
					<ul id="normal_time_list">
                    
                                      
                                      <?php foreach($result['likes'] as $like) {?> 
                    					                   	
                                                <li><a href="search.php?q=<?php echo iconv('gb2312','utf-8',$like)?>"><?php echo iconv('gb2312','utf-8',$like)?></a> </li>
                                                                  					                   	
                                         
                                              <?php }?>                   					 
                    		 				                     					                     		
			                     					 </ul>
				 
					  
					 
				 
				 </dd>
				</dl>
			
					 <dl>
				 <dt>今日热门</dt>
				 <dd>
					<ul>
                     <?php while($aizhan=mysql_fetch_array($aizhanresult)){?>               
                   <li><a href="q_<?php echo $aizhan['id']?>.html"><?php echo $aizhan['keyword']?></a> </li>
                        <?php } ?>                                                  
                  	</ul>
				 </dd>
				</dl>
				
				
             
 
								 
			</div>
		</div>
				<div style="border-left: 1px solid rgb(200, 213, 240);" class="result" id="result">

											<a href="javascript:void(0)" class="sideopen" id="sidebtn" hidefocus="true" title="关闭侧边栏">关闭侧边栏</a>
					
		<div class="mod_bar">
												 
		 				
						<span id="correct_box"></span>
 
						
		</div>
						<div id="nav_result_container"></div>
		
 
			<div class="wbret-wrap">
		<span class="wbret-tt">
			<h1 class="fred"><?php echo iconv('gb2312','UTF-8//IGNORE',$result['rs'][0]['title'])?></h1>
		</span>
				<span class="wbret-p1">
			<span style="color: rgb(38, 162, 218);" class="wblink" s-role="wblink"><strong><h2 style="color:red;"><?php echo iconv('gb2312','UTF-8//IGNORE',$result['rs'][0]['content'])?> </h2></strong>
		</span>
					 
			</div>
	
 
		 
			<?php foreach($result['rs'] as $rs) {?>
		 
			<div class="box-result clearfix">
				<div class="r-info r-info2">
					<h2><a _order="1" _log="result" href="<?php echo 'jump.php?to='.base64_encode(iconv('gb2312','utf-8',$rs['url']))?>" target="_blank"><?php echo iconv('gb2312','UTF-8//IGNORE',$rs['title'])?></a>  </h2>
					<p class="content"><?php echo iconv('gb2312','UTF-8//IGNORE',$rs['content'])?></p>
					<p class="fgray"><?php echo iconv('gb2312','UTF-8//IGNORE',$rs['url'])?></p>
												</div>
			</div>
			<?php }?>
		 
						
 
							 
									<p class="from">以上结果为<strong>故事搜</strong>搜集，结果属于你主动搜寻的结果不代表本网站赞成的内容。</p>
					
		</div>
	
	</div>


	
		 <script type="text/javascript">
	//<![CDATA[
	(function(){
		//打开关闭边栏
		var sidebar = $("#sidebar");
		var sidebtn = $("#sidebtn");
		var result = $("#result");
		var sideMore = $("#amore");
		var cm = $("#cmore");
		 

		function toggleSidebar() {
			var sidebarHeight = sidebar[0].style.display=='none' ? 0 : sidebar.outerHeight()
			if (result.outerHeight() < sidebarHeight){
				result.css("border-left", "none");
				sidebar.css("border-right", "1px solid #C8D5F0");
			} else {
				result.css("border-left", "1px solid #C8D5F0");
				sidebar.css("border-right", "none");
			}
		}

		function openfilter(){
			sidebar.animate({width:"show"},"fast",function(){
				sideMore.css("visibility","visible");
				sidebtn[0].className = "sideopen";
				sidebtn.html("关闭侧边栏");
				sidebtn[0].title = "关闭侧边栏";
				
				cm.width(cm.parent().width());
			});
									
						toggleSidebar();
			 
		 
		}
		
		function closefilter(){
			sideMore.css("visibility","hidden");
			sidebar.animate({width:"hide"},"slow",function(){
				sidebtn[0].className = "sideclose";
				sidebtn.html("打开侧边栏");
				sidebtn[0].title = "打开侧边栏";

												
								toggleSidebar();
			});
 
		}

		toggleSidebar();
		
			   	sidebtn.toggle(closefilter,openfilter);
		
	 
	  })();		
	//]]>
	</script>

		 
<div class="search-form search-form-bot">
 
    <form method="get" action="/" onsubmit="return submit_form(this)">
        <input value="ttt" name="q" type="hidden">
	 
        <input name="si_q" maxlength="100" value="<?php echo $keys?>" class="ipt-02" onfocus="if(this.value=='请输入关键词'){this.value='';this.style.color='#333'}" onblur="if(this.value==''){this.value='请输入关键词';this.style.color='#999'};"   type="text"><input value="搜索" class="ipt-03 ipt-03b" hidefocus="true" type="submit">
                                        <input value="news" name="c" type="hidden">
                                <input value="index" name="from" type="hidden">
                                <input value="" name="a" type="hidden">
                    </form>
  
</div>
 
	<?php include('footer.php')?>
 
<!-- ie6 下按钮hover状态改变 -->    
<!--[if lte IE 6]>
<script type="text/javascript">
	(function(){
		var inps = document.getElementsByTagName("input");
		for(i=0,len=inps.length;i<len;i++){
				if(inps[i].className.match("ipt-03")){
						inps[i].onmouseover = function(){
								this.className += " hover";
							}
						inps[i].onmouseout = function(){
								this.className =this.className.replace(/ hover/g,"");
							}	
					}
			}			
	})();
</script>
<![endif]--></div>


 
 



<ul style="top: 93px; left: 421.5px; display: none;" class="ac_results"></ul></body></html>