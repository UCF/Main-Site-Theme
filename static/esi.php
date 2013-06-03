<?php
require_once('../../../../wp-blog-header.php');

if(isset($_GET['statement'])) {
	$statementkey = (int)$_GET['statement']; // force int
	if(array_key_exists($statementkey, Config::$esi_whitelist)) {
		$argset 		= $_GET['args'] ? base64_decode($_GET['args']) : null; // args passed here are not serialized
		$statementname 	= Config::$esi_whitelist[$statementkey]['name'];
		$statementargs	= Config::$esi_whitelist[$statementkey]['safe_args'];

		if (!is_array($statementargs) || $argset == null) {
			return call_user_func($statementname);
		}
		else {
			// Convert argset arrays to strings for easy comparison with our whitelist
			$argset = is_array($argset) ? serialize($argset) : $argset;
			if (is_array($statementargs) && in_array($argset, $statementargs)) { 
				// Unserialize if necessary
				$argset = (unserialize($argset) !== false) ? unserialize($argset) : array($argset);
				return call_user_func_array($statementname, $argset); 
			}
		}
	}
}

?>