<?php 

	require ("include/head.php");
	$url = base64_decode($_GET['to']);
 
	
	$db = Database :: Connect();

	
	$aizhansql = "select id,keyword,hotlevel from kw_task where type=1 order by rand() limit 9";	 
	$aizhanresult = $db->GetResultSet($aizhansql);
?>
<?php include "header.php"?>
 <link type="text/css" rel="stylesheet" href="css/jump.css">
</head>

<body>

<div class="wt_box">
    <div class="wt_t"><img src="img/waitbox_t.gif"></div>
    <div class="wt_m">
        
         

  <span>
    <a href="http://so.story-ing.com"><img src="img/logo_big.png"/></a><img width="30px" height="30px" src="img/jumpping.gif">
  </span>
  <div class="m_out_mid">您将从故事搜离开<a href=<?php echo $url?>></a></div>
  <div class="m_out_mid_b">如果没有自动跳转，请<a href=<?php echo $url?>>点击这里</a></div>
  <div class="m_out_bottom"><strong>温馨提示</strong><br>
    故事搜仅为您提供搜索等服务<br>
    您得到结果属于你主动搜寻的结果不代表本网站赞成的内容<br>
	 			
					<dl class="related-search">
						<dt>
							故事搜今日搜索：
						</dt>
						 <?php while($aizhanrow = mysql_fetch_array($aizhanresult)){
					?>
				 
						<a href="s<?php echo $aizhanrow['id']?>.html"><?php echo $aizhanrow['keyword']?></a>
				 
				<?php
				}
				?>
						 
					</dl>
    
  </div>

        
    </div>
 <div class="wt_b"></div>
    <script language="JavaScript" src="" id="my"></script>
<script>
setTimeout("location.href='<?php echo $url?>'; ",3000);//延时3秒
</script> 



</div>
      

</body>