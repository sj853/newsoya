<?php
	require ("include/head.php");
	
		$db = Database :: Connect();
	$db ->setNamesGB2312();
	
	$aizhansql = "select id,keyword,hotval from keyword_task where type=4 and hotval=0 order by rand() limit 9";	 
	$aizhanresult = $db->GetResultSet($aizhansql);
	
	$basesql = "select * from keyword_result where kid=";
	
    if(isset($_GET['id'])){
	  $sql = $basesql.$_GET['id'];
	  $keys = $db->GetSingleValOrDefault("select keyword from keyword_task where id={$_GET['id']}","");
	}else{
	$keys = trim($_GET['keys']);
	if($keys == ""){
		header("Location: index.php"); 
		 
		exit;
		 
	}
		$sql = $basesql."(select id from keyword_task where keyword='$keys' limit 1)";
	}
	
  
	 
	
	 
	if($db->GetCount($sql)<1){
	 
		
		include_once ("./function/keywordresult.php");
		
		$content = getResultByBaiDu($keys);
		
		 $rs = getResultByBaiDu($keys,1);
	 setCache('AA制生活',$rs,3);
	print_r(getCache('AA制生活',3));
			
		 
		 
		}
	else{
		 
		 
		$result = $db->GetResultSet($sql);
	
		$row = mysql_fetch_array($result);
	}
	
	
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
			<a href="http://so.story-ing.com/" target="_blank">故事搜</a><a href="javascript:void(0)" onclick="addFavorite()">收藏本页</a>
		</div>
	</div>
	 
</div>
 
	<div class="top2">
		<h1 class="l"><a href="so.story-ing.com"><img src="img/logo_big.png" alt="故事搜"></a></h1>
		<div class="search-form l">
		<form method="get" action="/" onsubmit="return submit_form(this)">
			<input autocomplete="off" name="q" maxlength="100" value="ttt" class="ipt-02"   id="keyword" type="text"><input value="搜索" class="ipt-03" hidefocus="true" type="submit"> 
			  
					</form>
		</div>
	</div>
	<div class="nav clearfix">
		<div class="l">
				</div>
		<div class="r">
					 搜索结果 <strong>500</strong> 条
				</div>
	</div>
	<div class="main clearfix">
						<div style="border-right: medium none; display: block;" class="l" id="sidebar">
			<div class="sidebar">
																<dl>
				 <dt>其他热门</dt>
				 <dd>
					<ul>
                                     
                   <li><a href="http://search.sina.com.cn/?q=ttt&amp;c=news&amp;from=index&amp;a=&amp;filter=1&amp;range=all&amp;sort=time&amp;t=3_5_6&amp;_lid=89c553543d41245f48702d53558d387f">test1</a> </li>
                                                                           
                    	                 	
                      <li><a href="http://search.sina.com.cn/?q=ttt&amp;c=news&amp;from=index&amp;a=&amp;filter=1&amp;range=all&amp;sort=time&amp;t=2&amp;_lid=89c553543d41245f48702d53558d387f">test2</a> </li>
                                                                           
                    	                      
                    	                       
                    	                     					</ul>
				 </dd>
				</dl>
				
				<dl>
				 <dt>相关搜索</dt>
				 <dd>
					<ul id="normal_time_list">
                    
                                      
                                        
                    					                   	
                                                <li><a href="http://search.sina.com.cn/?q=ttt&amp;c=news&amp;from=index&amp;a=&amp;filter=1&amp;range=all&amp;sort=time&amp;time=h&amp;stime=&amp;etime=&amp;_lid=89c553543d41245f48702d53558d387f">aaa</a> </li>
                                                                  					                   	
                                                <li><a href="http://search.sina.com.cn/?q=ttt&amp;c=news&amp;from=index&amp;a=&amp;filter=1&amp;range=all&amp;sort=time&amp;time=d&amp;stime=&amp;etime=&amp;_lid=89c553543d41245f48702d53558d387f">bbbb</a> </li>
                                                                  					                   	
                                                <li><a href="http://search.sina.com.cn/?q=ttt&amp;c=news&amp;from=index&amp;a=&amp;filter=1&amp;range=all&amp;sort=time&amp;time=w&amp;stime=&amp;etime=&amp;_lid=89c553543d41245f48702d53558d387f">cccc</a> </li>
                                                                  					                   	
                                                <li><a href="http://search.sina.com.cn/?q=ttt&amp;c=news&amp;from=index&amp;a=&amp;filter=1&amp;range=all&amp;sort=time&amp;time=m&amp;stime=&amp;etime=&amp;_lid=89c553543d41245f48702d53558d387f">dddd</a> </li>
                                                                  					 
                    		 				                     					                     		
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
			<h1 class="fred">ttt的相关微博</h1>
		</span>
				<span class="wbret-p1">
			<span style="color: rgb(38, 162, 218);" class="wblink" s-role="wblink" url="http://weibo.com/1660844663/profile?&amp;Refer=sina_newsearch">温情梦呓</span><strong>: </strong>[放假啦]//@挚爱李珍基: 果然乔巴珍魅力无边啊TTT @流昔真名是吴杰超吴夏羡 //@Ring花椰菜: 哥啊~哥啊~看我怎么样? ^~^唔唔~ 
		</span>
					 
			</div>
	
						
					<!-- 文字新闻spider begin -->
			<div class="box-result clearfix">
				<div class="r-info r-info2">
					<h2><a _order="1" _log="result" href="http://news.sina.com.cn/o/p/2012-04-18/102524290754.shtml" target="_blank">图文：视物模糊变形 当心老年黄斑变性</a> <span class="fgreen time">2012-04-18 10:25:31</span></h2>
					<p class="content">首届湖北省医学会激光医学分会委员。从事眼底病诊疗工作10余年，擅长眼底血管性疾病的诊断和治疗。在眼科激光领域也有丰富独到的经验，擅长用多波长激光、<span style="color:#C03">TTT</span>激光、PDT激光仪及YAG激光治疗多种眼病。</p>
					<p class="fgray">频道：<a _order="1" _log="result" href="http://news.sina.com.cn/" target="_blank" class="fblue">新闻</a>&nbsp;&nbsp;来源：荆楚网-楚天金报</p>
												</div>
			</div>
			<!-- 文字新闻spider end -->
						
 
							 
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

				<!-- 在结果中搜索 begin -->
<div class="search-form search-form-bot">
	 <!-- 2010/11/3 begin -->
    <form method="get" action="/" onsubmit="return submit_form(this)">
        <input value="ttt" name="q" type="hidden">
	 
        <input name="si_q" maxlength="100" value="ttt" class="ipt-02" onfocus="if(this.value=='请输入关键词'){this.value='';this.style.color='#333'}" onblur="if(this.value==''){this.value='请输入关键词';this.style.color='#999'};"   type="text"><input value="搜索" class="ipt-03 ipt-03b" hidefocus="true" type="submit">
                                        <input value="news" name="c" type="hidden">
                                <input value="index" name="from" type="hidden">
                                <input value="" name="a" type="hidden">
                    </form>
    <!-- 2010/11/3 end -->
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