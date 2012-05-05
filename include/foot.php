
<?php
	if(hascache){
	$template = ob_get_contents();  
	$html->write($template);
	}
?>