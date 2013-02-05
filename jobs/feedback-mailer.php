<?php 
if (preg_match('/wget/i', $_SERVER['HTTP_USER_AGENT']) && isset($_GET['secret'])) {
	require('../../../../wp-blog-header.php');
	require_once(ABSPATH . 'wp-admin/includes/plugin.php');
	
	if ($_GET['secret'] == get_theme_option('feedback_email_key')) {
		$recipients = explode(',', get_theme_option('feedback_email_recipients'));
		if ($recipients) {
			foreach ($recipients as $r) {
				trim($r);
			}
			// get_feedback_entries($formid=1, $duration=7, $to=array('emailaddress@mailclient.com'))
			print get_feedback_entries(1, 7, $recipients);
		}
		else { die('No recipients specified.'); }
	}
	else { die('Incorrect Key.'); }
}
else {
	header('HTTP/1.0 404 Not Found');
}
?>