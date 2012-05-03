<?php 

	
	require ("head.php");

	require_once "wb_hot_task/weibohot.php";
	$db = Database :: Connect();
	$db ->setNamesGB2312();
	$sql = "select id,keyword,hotval from keyword_task where type=1 and to_days(time) = to_days(now()) order by hotval desc,time desc limit 9";
	$weiboresult = $db->GetResultSet($sql);
	$sql = "select id,keyword,hotval from keyword_task where type=2 and to_days(time) = to_days(now()) order by hotval desc,time desc limit 9";
	$baiduresult = $db->GetResultSet($sql);
	$sql = "select id,keyword,hotval from keyword_task where type=4 and hotval=1  order by rand() limit 9";
	$aizhanresult = $db->GetResultSet($sql);
	$db->Close();
	
?>
<!doctype html>
<html>
<head>
<meta charset="gbk">
<meta name="keywords" content="搜呀365,365搜,365">

<meta name="description" content="搜呀365 www.soya365.com关注最新网络热点事件、新闻,精心为你盘点身边大事小事资讯。搜呀365提供最新搜索，如最热门的话题，最新的新闻事件。搜呀365为呈现365天，天天搜索，热门排行">

<title>搜呀365 www.soya365.com</title>

<link rel="shortcut icon" href="favicon.ico" />
<link rel="stylesheet" href="css/global.css"/>
<!--[if IE]>
<link rel="stylesheet" href="css/search-ie.css" />
<![endif]-->
<![if !IE]>
<link rel="stylesheet" href="css/search.css" />
<![endif]>
<link rel="stylesheet" href="css/customer.css" />
 <!-- JiaThis Button BEGIN -->


<style type="text/css">
.rank-entry{margin-bottom:88px}
</style>
</head>
<body id="index">

<script type="text/javascript" src="http://v2.jiathis.com/code/jiathis_r.js?move=0&amp;btn=r5.gif" charset="utf-8"></script>
<!-- JiaThis Button END -->

<div id="site-nav">
<div id="site-nav-bd">
    <ul class="quick-menu">
        <li class="home"><a href="index.php">搜呀365首页</a></li>
    
    </ul>
</div>
</div>

<div id="page" class="w950">
<div id="header">

<h1 id="logo">
<a href="index.php" target="_top"><img src="img/logo_big.png" alt="搜呀365"  width="225" height="60" /></a>
</h1>

</div>
<div class="search-form">
<fieldset>
<legend>搜呀365</legend>
<form action="search.php" method="get" id="J_searchForm">
    <ul class="search-tab" id="J_SearchTab" redirect="false">
        <li class="selected first"><a hidefocus="true" href="index.php">网页</a></li>
    </ul>
    <div class="search-auto">
        <div class="input allWidth">
            <input  name="keys" maxlength="60" autocomplete="off" id="title" placeholder="请输入要搜索的内容" autofocus /></div>
        <button type="submit">搜索</button>
    </div>
</form>
</fieldset>
</div>

			 
		<div class="bang bang-index">
		
        	<div class="hot">
	            <h5><i class="icon"></i>大家在微博讨论什么</h5>
	            <ol>		 <?php while($row = mysql_fetch_array($weiboresult)){
					?>
				<li class="first">
		        	<a href="s<?php echo $row['id']?>.html" target="_blank" title="<?php echo $row['keyword']?>"><?php echo $row['keyword']?></a> <i><?php echo $row['hotval']?></i>
				</li>
				<?php
				}
				?></ol>
				
			</div>
			<div class="hot">
	            <h5><i class="icon"></i>时事关注</h5>
	            <ol>		 <?php while($row = mysql_fetch_array($baiduresult)){
					?>
				<li class="first">
		        	<a href="s<?php echo $row['id']?>.html" target="_blank" title="<?php echo $row['keyword']?>"><?php echo $row['keyword']?></a> <i><?php echo $row['hotval']?></i>
				</li>
				<?php
				}
				?></ol>
			</div>
			
			<div class="hot">
	            <h5><i class="icon"></i>搜呀365今日搜索</h5>
	            <ol>		 <?php while($row = mysql_fetch_array($aizhanresult)){
					?>
				<li class="first">
		        	<a href="s<?php echo $row['id']?>.html" target="_blank" title="<?php echo $row['keyword']?>"><?php echo $row['keyword']?></a>  
				</li>
				<?php
				}
				?></ol>
			</div>
			
			<div class="more">
			 
				 
			</div>
		</div>
		 
		
		<div id="footer">
		
	<div class="foot-nav">
        <p class="more"><a href="total.php?date=<?php echo date("Y-m-d"); ?>"><i></i>今日关注</a></p>
		往日关注
		<?php 
				 	
					$date = strtotime(date("Y-m-d"));
					for($i=1;$i<7;$i++)
					{                 
                 
					$newdate = date('Y-m-d',$date - $i*24*60*60);
				     ?>
				<a href="total.php?date=<?php echo $newdate ?>"><?php echo $newdate ?></a>
				
				<?php } ?>
		
    </div>
	<?php require ("foot.php"); ?>
	<hr>
<div class="copyright">
Copyright 2003-2012, 版权所有 soya365.com<script src="http://s9.cnzz.com/stat.php?id=3829850&web_id=3829850&show=pic" language="JavaScript"></script>
<br/>
<!--alivv code start JDtLnzWbMN8=--><!--OWT8X1REM3VuMLBTc+i35A==--><span><a target='_blank' href='http://www.alivv.com'>阿里微微</a></span><!--alivv code end-->
<span><a target='_blank' href='http://www.kabrita.com.cn'>佳贝艾特</a></span>
<span><a target='_blank' href='http://www.2fcc.com'>免费发布信息网</a></span>
 </div>

</div>
</div>
 

</body>
</html>
