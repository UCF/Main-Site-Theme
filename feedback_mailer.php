<?php
require('../../../wp-blog-header.php');
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (function_exists('disallow_direct_load')):
disallow_direct_load('feedback_mailer.php');

/** 
 * Pull recent Gravity Forms entries from a given form.
 * If no formid argument is provided, the function will pick the form
 * with ID of 1 by default
 **/
function get_feedback_entries($formid=1, $duration=7) {
	
	// Check that GF is actually installed
	if (is_plugin_inactive('gravityforms/gravityforms.php')) {
		die('Error: Gravity Forms is not activated. Please install/activate Gravity Forms and try again.');
	}
	
	// Define how far back to search for old entries
	$dur_end_date 	= date('Y-m-d');
	$dur_start_date = date('Y-m-d', strtotime($dur_end_date.' -'.$duration.' days'));
	
	// WPDB stuff
	global $wpdb;
	global $blog_id;
	define( 'DIEONDBERROR', true );
	$wpdb->show_errors();
	
	// Get all entry IDs
	$entry_ids = $wpdb->get_results( 
		"
		SELECT 		id
		FROM 		wp_".$blog_id."_rg_lead
		WHERE		form_id = ".$formid."
		AND			date_created >= '".$dur_start_date." 00:00:00' 
		AND			date_created <= '".$dur_end_date." 23:59:59'
		ORDER BY	date_created ASC
		"
	);
	
	// Begin $output
	$output .= '<h3>Feedback Submissions for '.date('M. j, Y', strtotime($dur_start_date)).' to '.date('M. j, Y', strtotime($dur_end_date)).'</h3><br />';
	
	if ($entry_ids == NULL) {
		$output .= 'No submissions found.';
	}
	else {
		// Get field data for the entry IDs we got
		foreach ($entry_ids as $obj) {
			$entry = RGFormsModel::get_lead($obj->id);
			
			$output .= '<ul>';
			
			$entry_output 	= array();
			$about_array 	= array();
			$routes_array 	= array();
			
			foreach ($entry as $field=>$val) {
				// Our form fields names are stored as numbers. The naming schema is as follows:
				// 1 			- Name
				// 2 			- E-mail
				// 3.1 to 3.7 	- 'Tell Us About Yourself' values
				// 4.1 to 4.7	- 'Routes to' values
				// 5			- Comment
				
				// Entry ID
				$entry_output['id'] = $obj->id;
				
				// Date
				if ($field == 'date_created') {
					// Trim off seconds from date_created
					$val = date('M. j, Y', strtotime($val));
					$entry_output['date'] .= $val;
				}
				
				// Name
				if ($field == 1) {
					if ($val) {
						$entry_output['name'] .= $val;
					}
				}
				// E-mail
				if ($field == 2) {
					if ($val) {
						$entry_output['email'] .= $val;
					}
				}
				// Tell Us About Yourself
				if ($field >=3 && $field < 4) {
					if ($val) {
						$about_array[] .= $val;
					}
				}
				// Route To
				if ($field >= 4 && $field < 5) {
					if ($val) {
						$routes_array[] .= $val;
					}
				}
				// Comments
				if ($field == 5) {
					if ($val) {
						$entry_output['comment'] .= $val;
					}
				}
			}
			
			$output .= '<li><strong>Entry ID: </strong>'.$entry_output['id'].'</li>';
			$output .= '<li><strong>Date Submitted: </strong>'.$entry_output['date'].'</li>';
			$output .= '<li><strong>Name: </strong>'.$entry_output['name'].'</li>';
			$output .= '<li><strong>E-mail: </strong>'.$entry_output['email'].'</li>';
			$output .= '<li><strong>Tell Us About Yourself: </strong><br/><ul>';
			foreach ($about_array as $about) {
				$output .= '<li>'.$about.'</li>';
			}
			$output .= '</ul></li>';
			
			$output .= '<li><strong>Route To: </strong><br/><ul>';
			foreach ($routes_array as $routes) {
				$output .= '<li>'.$routes.'</li>';
			}
			$output .= '</ul></li>';
			
			$output .= '<li><strong>Comments: </strong><br/>'.$entry_output['comment'].'</li>';
			
			$output .= '</ul><hr />';
		}
		
		// E-mail setup
		$to = array('carolyn.greybill@ucf.edu');
		$subject = 'UCF Comments and Feedback for '.date('M. j, Y', strtotime($dur_start_date)).' to '.date('M. j, Y', strtotime($dur_end_date));
		$message = $output;
		
		// Change e-mail content type to HTML
		add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));

		// Send e-mail; return success or error
		$results = wp_mail( $to, $subject, $message );
		
		if ($results == true) {
			return 'Mail successfully sent at '.date('r');
		}
		else {
			return 'wp_mail returned false; mail did not send.';
		}
		
	}
	
}

get_feedback_entries(1, 7);
endif;
?>