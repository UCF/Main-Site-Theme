<?php
//$_SERVER = Array();
// Needs to match current host
//$_SERVER['HTTP_HOST'] = 'ucf.edu';

require('../../../wp-blog-header.php');
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// get_feedback_entries($formid=1, $duration=7, $to=array('webcom@ucf.edu'))
print get_feedback_entries(1, 7, array('carolyn.greybill@ucf.edu'));
?>