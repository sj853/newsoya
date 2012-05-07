<?php 

	require_once ("include/head.php");
	
	 
	$db = Database :: Connect();	 
	$sql = "select id,keyword,hotlevel from kw_task where type=1 and hotlevel=1  order by rand() limit 9";
	$aizhanresult = $db->GetResultSet($sql);
	$db->Close();
	
?>
<?php include "header.php"?>
<link type="text/css" rel="stylesheet" href="css/common.css">
<script src="js/common.js" type="text/javascript"></script>

</head>
<body>
<div class="wrap">
	<div class="top">
		<a href="http://www.soya365.com/" target="_blank">故事搜</a>　<a href="javascript:void(0)" onclick="addFavorite()">收藏本页</a>
	</div>
	<h1 class="tac"><img src="img/logo_big.png" alt="故事搜"></h1>
	<div class="box-search">
		<div class="list-type clearfix">			
						<a class="selected" href="javascript:void(0)" hidefocus="true">网页</a>
			 
		</div>
	 
		<div class="clearit"></div>

		  
		<div  class="search-ipt clearfix">
			<form method="get" action="search.php" onsubmit="return submit_form(this);">
				<div class="box-ipt"><input name="q" maxlength="100" class="ipt-01" autocomplete="off" type="text">			 
				<input value="搜索" class="ipt-submit" hidefocus="true" type="submit"></div>				 
			</form>
			
				<div class="search-ipt2 clearfix">
					<h3>最新搜索：</h3>
					 
					<ul class="latest">
					 <?php
						$i=1;
					 while($row = mysql_fetch_array($aizhanresult)){
					?>
					<li><?php echo $i++?>.<a href="search.php?q=<?php echo $row['keyword']?>"><?php echo $row['keyword']?></a></li>				 
					<?php } ?>
					</ul>
				</div>
			</div>
	  <hr>
		<div id="link">
		</div>
		
		<?php include("footer.php")?>
 
	</div>
</div> 

 </body>
</html>
<?php require ("include/foot.php"); ?>