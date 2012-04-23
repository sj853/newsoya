
<?php
if(define('cache')){
$template = ob_get_contents();  
	$html->write($template);
	}
?>