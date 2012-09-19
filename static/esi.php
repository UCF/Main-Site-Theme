<?php
require_once('../../../../wp-blog-header.php');

if(isset($_GET['statement'])) {
	$statement = base64_decode($_GET['statement']);
	if(in_array($statement, Config::$esi_whitelist)) {
		eval($statement);
	}
}

?>