<?php 
	 
	$fileName="state.php";
	if(isset($_POST['run'])){
		$handle = fopen($fileName,"w");
		fwrite($handle,"<?php return 0;?>");
		fclose($handle);
		$state = 0;
	}else{
		
		$handle=fopen($fileName,"r");
		$fileContent=fread($handle,fileSize($fileName));
		fclose($handle);
		 
		if(preg_match('#<?php[^@]+return([^@]+);[^@]+?>#U',$fileContent,$state)){
			$state = $state[1];
			}
	
	}
	
	    
	 
	 
	if($state!=0){
		echo "运行中....";
		echo "<form method='post'><input type='hidden' name='run' value='0'/><input type='submit' value='停止'/></form>";
	}
	else{
		echo "已停止!";
		echo "<a href='bd_search_task.php'>启动</a>";
	}
	
	 
?>

