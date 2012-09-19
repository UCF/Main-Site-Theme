<?php
require_once('../../../../wp-blog-header.php');

if(isset($_GET['statement']) && in_array($_GET['statement'], Config::$esi_whitelist)) {
	eval($_GET['statement']);
}

?>