<?php
require_once('functions/base.php');   			# Base theme functions
require_once('functions/feeds.php');			# Where functions related to feed data live
require_once('custom-taxonomies.php');  		# Where per theme taxonomies are defined
require_once('custom-post-types.php');  		# Where per theme post types are defined
require_once('functions/admin.php');  			# Admin/login functions
require_once('functions/config.php');			# Where per theme settings are registered
require_once('shortcodes.php');         		# Per theme shortcodes
require_once('third-party/truncate-html.php');  # Includes truncateHtml function

//Add theme-specific functions here. 
 
/** 
 * Slider post type customizations 
 * Stolen from SmartStart theme
 **/

// Custom columns for 'Centerpiece' post type
function edit_centerpiece_columns() {
	$columns = array(
		'cb'          => '<input type="checkbox" />',
		'title'       => 'Name',
		'slide_count' => 'Slide Count'
	);
	return $columns;
}
add_action('manage_edit-centerpiece_columns', 'edit_centerpiece_columns');

// Custom columns content for 'Centerpiece'
function manage_centerpiece_columns( $column, $post_id ) {
	global $post;
	switch ( $column ) {
		case 'slide_count':
			print get_post_meta( $post->ID, 'ss_slider_slidecount', true );
			break;
		default:
			break;
	}
}
add_action('manage_centerpiece_posts_custom_column', 'manage_centerpiece_columns', 10, 2);

// Sortable custom columns for 'Centerpiece'
function sortable_centerpiece_columns( $columns ) {
	$columns['slide_count'] = 'slide_count';
	return $columns;
}
add_action('manage_edit-centerpiece_sortable_columns', 'sortable_centerpiece_columns');

// Change default title for 'Centerpiece'
function change_centerpiece_title( $title ){
	$screen = get_current_screen();
	if ( $screen->post_type == 'centerpiece' )
		$title = __('Enter centerpiece name here');
	return $title;
}
add_filter('enter_title_here', 'change_centerpiece_title');



/**
 * Announcement custom columns
 **/
 
// Custom columns for 'Announcement' post type
function edit_announcement_columns() {
	$columns = array(
		'cb'           => '<input type="checkbox" />',
		'title'        => 'Name',
		'start_date'   => 'Start Date',
		'end_date'     => 'End Date',
		'publish_date' => 'Publish Date'
	);
	return $columns;
}
add_action('manage_edit-announcement_columns', 'edit_announcement_columns');

// Custom columns content for 'Announcement'
function manage_announcement_columns( $column, $post_id ) {
	global $post;
	switch ( $column ) {
		case 'start_date':
			$start_date = get_post_meta($post->ID, 'announcement_start_date', TRUE) ? date('Y/m/d', strtotime(get_post_meta($post->ID, 'announcement_start_date', TRUE))) : '<span style="font-weight:bold;color:#cc0000;">N/A</span>';
			print $start_date;
			break;
		case 'end_date':
			$end_date = get_post_meta($post->ID, 'announcement_end_date', TRUE) ? date('Y/m/d', strtotime(get_post_meta($post->ID, 'announcement_end_date', TRUE))) : '<span style="font-weight:bold;color:#cc0000;">N/A</span>';
			print $end_date;
			break;
		case 'publish_date':
			if ($post->post_status == 'publish') {
				print get_post_time('Y/m/d', true, $post->ID);
			}
			break;
		default:
			break;
	}
}
add_action('manage_announcement_posts_custom_column', 'manage_announcement_columns', 10, 2);

// Sortable custom columns for 'Announcement'
function sortable_announcement_columns( $columns ) {
	$columns['start_date'] 		= 'start_date';
	$columns['end_date'] 		= 'end_date';
	$columns['publish_date'] 	= 'publish_date';
	return $columns;
}
add_action('manage_edit-announcement_sortable_columns', 'sortable_announcement_columns'); 


/**
 * Allow special tags in post bodies that would get stripped otherwise for most users.
 * Modifies $allowedposttags defined in wp-includes/kses.php
 *
 * http://wordpress.org/support/topic/div-ids-being-stripped-out
 * http://wpquicktips.wordpress.com/2010/03/12/how-to-change-the-allowed-html-tags-for-wordpress/
 **/
$allowedposttags['input'] = array(
	'type' => array(),
	'value' => array(),
	'id' => array(),
	'name' => array(),
	'class' => array()
);
$allowedposttags['select'] = array(
	'id' => array(),
	'name' => array()
);
$allowedposttags['option'] = array(
	'id' => array(),
	'name' => array(),
	'value' => array()
);
$allowedposttags['iframe'] = array(
	'type' => array(),
	'value' => array(),
	'id' => array(),
	'name' => array(),
	'class' => array(),
	'src' => array(),
	'height' => array(),
	'width' => array(),
	'allowfullscreen' => array(),
	'frameborder' => array()
);
$allowedposttags['object'] = array(
	'height' => array(),
	'width' => array()
);

$allowedposttags['param'] = array(
	'name' => array(),
	'value' => array()
);

$allowedposttags['embed'] = array(
	'src' => array(),
	'type' => array(),
	'allowfullscreen' => array(),
	'allowscriptaccess' => array(),
	'height' => array(),
	'width' => array()
);
// Most of these attributes aren't actually valid for some of 
// the tags they're assigned to, but whatever:
$allowedposttags['div'] =
$allowedposttags['a'] = 
$allowedposttags['button'] = array(
	'id' => array(),
	'class' => array(),
	'style' => array(),
	'width' => array(),
	'height' => array(),
	
	'align' => array(),
	'aria-hidden' => array(),
	'aria-labelledby' => array(),
	'autofocus' => array(),
	'dir' => array(),
	'disabled' => array(),
	'form' => array(),
	'formaction' => array(),
	'formenctype' => array(),
	'formmethod' => array(),
	'formonvalidate' => array(),
	'formtarget' => array(),
	'hidden' => array(),
	'href' => array(),
	'name' => array(),
	'rel' => array(),
	'rev' => array(),
	'role' => array(),
	'target' => array(),
	'type' => array(),
	'title' => array(),
	'value' => array(),
	
	// Bootstrap JS stuff:
	'data-dismiss' => array(),
	'data-toggle' => array(),
	'data-target' => array(),
	'data-backdrop' => array(),
	'data-spy' => array(),
	'data-offset' => array(),
	'data-animation' => array(),
	'data-html' => array(),
	'data-placement' => array(),
	'data-selector' => array(),
	'data-title' => array(),
	'data-trigger' => array(),
	'data-delay' => array(),
	'data-content' => array(),
	'data-offset' => array(),
	'data-offset-top' => array(),
	'data-loading-text' => array(),
	'data-complete-text' => array(),
	'autocomplete' => array(),
	'data-parent' => array(),
);


/**
 * Retrieve a YouTube ID from its URL
 **/
function get_youtube_id($url){
	$shortlink_domain = '/^http\:\/\/(?:www.)?youtu.be/';
	if (preg_match($shortlink_domain, $url)) {
		$parts = parse_url($url);
		return substr($parts['path'], 1, strlen($parts['path']) - 1);
	}
	else {
		$parts = parse_url($url);
		parse_str($parts['query'], $parts);
		return $parts['v'];
	}
}


/** 
 * Allow shortcodes in widgets
 **/
add_filter('widget_text', 'do_shortcode');


/**
 * Hide unused admin tools (Links, Comments, etc)
 **/
function hide_admin_links() {
	remove_menu_page('link-manager.php');
	remove_menu_page('edit-comments.php');
}
add_action( 'admin_menu', 'hide_admin_links' );



/**
 * Adds a subheader to a page (if one is set for the page.)
 **/
function get_page_subheader($post) {
	if (get_post_meta($post->ID, 'page_subheader', TRUE) !== '') {
		$subheader = get_post(get_post_meta($post->ID, 'page_subheader', TRUE));			
		?>
		<div class="span12" id="subheader" role="complementary">
			<?php
			$subimg = get_post_meta($subheader->ID, 'subheader_sub_image', TRUE);
			$imgatts = array(
				'class'	=> "subheader_subimg span2",
				'alt'   => $post->post_title,
				'title' => $post->post_title,
			);
			print wp_get_attachment_image($subimg, 'subpage-subimg', 0, $imgatts);
			?>
			<blockquote class="subhead_quote span8">
				<?=$subheader->post_content?>
				<p class="subhead_author"><?=get_post_meta($subheader->ID, 'subheader_student_name', TRUE)?></p>
				<p class="subhead_quotelink screen-only"><a href="<?=get_permalink(get_page_by_title( 'Submit a Quote About UCF', OBJECT, 'page' )->ID)?>">Submit a quote &raquo;</a></p>
			</blockquote>
			
			<?php
			$studentimg = get_post_meta($subheader->ID, 'subheader_student_image', TRUE);
			$imgatts = array(
				'class'	=> "subheader_studentimg",
				'alt'   => get_post_meta($subheader->ID, 'subheader_student_name', TRUE),
				'title' => get_post_meta($subheader->ID, 'subheader_student_name', TRUE),
			);
			print wp_get_attachment_image($studentimg, 'subpage-studentimg', 0, $imgatts);
			?>
		</div>
	<?php
	} 
}



/**
 * Output Spotlights for front page.
 *
 * Note: this function assumes at least 2 spotlights already exist
 * and that only 2 spotlights at a time should ever be displayed.
 **/
function frontpage_spotlights() {
	$args = array(
		'numberposts' 	=> 2,
		'post_type' 	=> 'spotlight',
		'post_status'   => 'publish',
	);
	$spotlights = get_posts($args);
	
	$spotlight_one = $spotlights[0];
	$spotlight_two = $spotlights[1];
	
	$position_one  = get_post_meta($spotlight_one->ID, 'spotlight_position', TRUE);
	$position_two  = get_post_meta($spotlight_two->ID, 'spotlight_position', TRUE);
	
	function output_spotlight($spotlight) {
		?>
		<div class="home_spotlight_single">
			<a href="<?=get_permalink($spotlight->ID)?>">
				<?php
					$thumb_id = get_post_thumbnail_id($spotlight->ID);
					$thumb_src = wp_get_attachment_image_src( $thumb_id, 'home-thumb' );
					$thumb_src = $thumb_src[0];
				?>
				<?php if ($thumb_src) { ?>
				<img class="print-only spotlight_thumb" src="<?=$thumb_src?>" />
				<div class="screen-only spotlight_thumb" style="background-image:url('<?=$thumb_src?>');"><?=$spotlight->post_title?></div>
				<?php } ?>
			</a>
			<h3 class="home_spotlight_title"><a href="<?=get_permalink($spotlight->ID)?>"><?=$spotlight->post_title?></a></h3>
			<?=truncateHtml($spotlight->post_content, 200)?>
			<p><a class="home_spotlight_readmore" href="<?=get_permalink($spotlight->ID)?>" target="_blank">Read More…</a></p>
		</div>
		<?
	}
	
	// If neither positions are set, or the two positions conflict with each
	// other, just display them in the order they were retrieved:
	if (($position_one == '' && $position_two == '') || ($position_one == $position_two)) {
		output_spotlight($spotlight_one);
		output_spotlight($spotlight_two);
	}
	
	// If one is set but not the other, respect the set spotlight's position
	// and place the other one in the other slot:
	else if ($position_one == '' && $position_two !== '') {
		if ($position_two == 'top') {
			output_spotlight($spotlight_two);
			output_spotlight($spotlight_one);
		}
		else {
			output_spotlight($spotlight_one);
			output_spotlight($spotlight_two);
		}
	}
	else if ($position_one !== '' && $position_two == '') {
		if ($position_one == 'top') {
			output_spotlight($spotlight_one);
			output_spotlight($spotlight_two);
		}
		else {
			output_spotlight($spotlight_two);
			output_spotlight($spotlight_one);
		}
	}
	
	// Otherwise, display them in their designated positions:
	else {
		if ($position_one == 'top') { // we can assume position_two is the opposite
			output_spotlight($spotlight_one);
			output_spotlight($spotlight_two);
		}
		else {
			output_spotlight($spotlight_two);
			output_spotlight($spotlight_one);
		}
	}
}



/**
 * Pulls, parses and caches the weather.
 *
 * @return array
 * @author Chris Conover, Jo Greybill
 **/
function get_weather_data() {
	$cache_key = 'weather';
	
	// Check if cached weather data already exists
	if(($weather = get_transient($cache_key)) !== False) {
		return $weather;
	} else {
		$weather = array('condition' => 'Fair', 'temp' => '80&#186;', 'img' => '34');
		
		// Set a timeout
		$opts = array('http' => array(
								'method'  => 'GET',
								'timeout' => 8
		));
		$context = stream_context_create($opts);
		
		// Grab the weather feed
		$raw_weather = file_get_contents(WEATHER_URL, false, $context);
		if ($raw_weather) {
			$json = json_decode($raw_weather);
			
			$weather['condition'] 	= $json->condition;
			$weather['temp']		= $json->temp;
			$weather['img']			= (string)$json->imgCode;
			
			// The temp, condition and image code should always be set,
			// but in case they're not, we catch them here:
			
			# Catch missing cid
			if (!isset($weather['img']) or !$weather['img']){
				$weather['img'] = '34';
			}
			
			# Catch missing condition
			if (!is_string($weather['condition']) or !$weather['condition']){
				$weather['condition'] = 'Fair';
			}
			
			# Catch missing temp
			if (!isset($weather['temp']) or !$weather['temp']){
				$weather['temp'] = '80&#186;';
			}
		}
		
		// Cache the new weather data
		set_transient($cache_key, $weather, WEATHER_CACHE_DURATION);
		
		return $weather;
	}
}


/**
 * Output weather data. Add an optional class for easy Bootstrap styling.
 **/
function output_weather_data($class=null) {
	$weather 	= get_weather_data(); 
	$condition 	= $weather['condition'];
	$temp 		= $weather['temp'];
	$img 		= $weather['img']; ?>
	<div id="weather_bug" class="<?=$class?> screen-only" role="complementary">
		<div id="wb_status_txt" style="background: url(<?php bloginfo('stylesheet_directory'); ?>/static/img/weather/<?=$img?>.png) left center no-repeat;"><span><?=$temp?>F, <?=$condition?></span></div>
	</div>
	<?php
}


/**
 * Get and display announcements.
 * Note that, like the old Announcements advanced search, only one
 * search parameter (role, keyword, or time) can be set at a time.
 * Default (no args) returns all roles within the past week 
 * (starting from Monday).
 **/
function get_announcements($role='all', $keyword=NULL, $time='thisweek') {	
	// Get some dates for meta_query comparisons:
	$today = date('Y-m-d');
	
	$thismonday = date('Y-m-d', strtotime('monday this week'));
	$thissunday = date('Y-m-d', strtotime($thismonday.' + 6 days'));
		
	$nextmonday = date('Y-m-d', strtotime('monday next week'));
	$nextsunday = date('Y-m-d', strtotime($nextmonday.' + 6 days'));
	
	$firstday_thismonth = date('Y-m-d', strtotime('first day of this month'));
	$lastday_thismonth = date('Y-m-d', strtotime('last day of this month'));
	
	$firstday_nextmonth = date('Y-m-d', strtotime('first day of next month'));
	$lastday_nextmonth = date('Y-m-d', strtotime('last day of next month'));
	
	// Set up query args based on GET params:
	$args = array(
		'numberposts' => -1,
		'post_type' => 'announcement',
		'orderby' => 'meta_value',
		'order' => 'ASC',
		'meta_key' => 'announcement_start_date',
	);
	
	// Announcement time queries should allow posts to fall within the week, even if
	// their start and end dates do not fall immediately within the given time
	// (allow for ongoing events that span during the given time, and then some).
	// Announcements should, however, be excluded if their end date has already passed.
	if ($role !== 'all') {
		$role_args = array(
			'tax_query' => array(
				array(
					'taxonomy' => 'audienceroles',
					'field' => 'slug',
					'terms' => $role,
				)
			),
			'meta_query' => array(
				array(
					'key' => 'announcement_start_date',
					'value' => $thissunday,
					'compare' => '<='
				),
				array(
					'key' => 'announcement_end_date',
					'value' => $today,
					'compare' => '>='
				),
			),
		);
		$args = array_merge($args, $role_args);
	}
	
	elseif ($keyword !== NULL) {
		$keyword_args = array(
			'tax_query' => array(
				array(
					'taxonomy' => 'keywords',
					'field' => 'slug',
					'terms' => $keyword,
				)
			),
			'meta_query' => array(
				array(
					'key' => 'announcement_start_date',
					'value' => $thissunday,
					'compare' => '<='
				),
				array(
					'key' => 'announcement_end_date',
					'value' => $today,
					'compare' => '>='
				),
			),
		);
		$args = array_merge($args, $keyword_args);
	}
	
	elseif ($time !== 'thisweek') {
		switch ($time) {
			case 'nextweek':
				$time_args = array(
					'meta_query' => array(
						array(
							'key' => 'announcement_start_date',
							'value' => $nextsunday,
							'compare' => '<='
						),
						array(
							'key' => 'announcement_end_date',
							'value' => $nextmonday,
							'compare' => '>='
						),
						array(
							'key' => 'announcement_end_date',
							'value' => $today,
							'compare' => '>='
						),
					),
				);
				$args = array_merge($args, $time_args);
				break;
			case 'thismonth':
				$time_args = array(
					'meta_query' => array(
						array(
							'key' => 'announcement_start_date',
							'value' => $lastday_thismonth,
							'compare' => '<='
						),
						array(
							'key' => 'announcement_end_date',
							'value' => $today,
							'compare' => '>='
						),
					),
				);
				$args = array_merge($args, $time_args);
				break;
			case 'nextmonth':
				$time_args = array(
					'meta_query' => array(
						array(
							'key' => 'announcement_start_date',
							'value' => $lastday_nextmonth,
							'compare' => '<='
						),
						array(
							'key' => 'announcement_end_date',
							'value' => $firstday_nextmonth,
							'compare' => '>='
						),
						array(
							'key' => 'announcement_end_date',
							'value' => $today,
							'compare' => '>='
						),
					),
				);
				$args = array_merge($args, $time_args);
				break;
			case 'thissemester':
				// Compare the current month to predefined month values
				// to pull announcements from the current semester
				
				// Check for Spring Semester
				if ($current_month >= SPRING_MONTH_START && $current_month <= SPRING_MONTH_END) {
					$time_args = array(
						'meta_query' => array(
							array(
								'key' => 'announcement_start_date',
								'value' => date('Y-m-d', strtotime('Last day of May this year')),
								'compare' => '<='
							),
							array(
								'key' => 'announcement_end_date',
								'value' => $today,
								'compare' => '>='
							),
						),
					);
					$args = array_merge($args, $time_args);
				}
				// Check for Summer Semester
				elseif ($current_month >= SUMMER_MONTH_START && $current_month <= SUMMER_MONTH_END) {
					$time_args = array(
						'meta_query' => array(
							array(
								'key' => 'announcement_start_date',
								'value' => date('Y-m-d', strtotime('Last day of July this year')),
								'compare' => '<='
							),
							array(
								'key' => 'announcement_end_date',
								'value' => $today,
								'compare' => '>='
							),
						),
					);
					$args = array_merge($args, $time_args);
				}
				// else, it's the Fall Semester
				else {
					$time_args = array(
						'meta_query' => array(
							array(
								'key' => 'announcement_start_date',
								'value' => date('Y-m-d', strtotime('Last day of December this year')),
								'compare' => '<='
							),
							array(
								'key' => 'announcement_end_date',
								'value' => $today,
								'compare' => '>='
							),
						),
					);
					$args = array_merge($args, $time_args);
				}
				break;
			case 'all':
				$time_args = array(
					'meta_query' => array(
						array(
							'key' => 'announcement_end_date',
							'value' => $today,
							'compare' => '>='
						),
					),
				);
				$args = array_merge($args, $time_args);
				break;
			default:
				$time_args = array(
					'meta_query' => array(
						array(
							'key' => 'announcement_start_date',
							'value' => $thissunday,
							'compare' => '<='
						),
						array(
							'key' => 'announcement_end_date',
							'value' => $today,
							'compare' => '>='
						),
					),
				);
				$args = array_merge($args, $time_args);
				break;
		}
		
	}
	
	else { // default retrieval args
		$fallback_args = array(
			'meta_query' => array(
				array(
					'key' => 'announcement_start_date',
					'value' => $thissunday,
					'compare' => '<='
				),
				array(
					'key' => 'announcement_end_date',
					'value' => $today,
					'compare' => '>='
				),
			),
		);
		$args = array_merge($args, $fallback_args);
	}
	

	// Fetch all announcements based on args given above:
	$announcements = get_posts($args);
	
	if (!($announcements)) {
		return NULL;
	}
	else {
		// Add relevant metadata to each post object so they
		// can be more easily accessed:
		foreach ($announcements as $announcement) {	
			$announcement->announcementStartDate 	 = get_post_meta($announcement->ID, 'announcement_start_date', TRUE);	
			$announcement->announcementEndDate		 = get_post_meta($announcement->ID, 'announcement_end_date', TRUE);
			$announcement->announcementURL			 = get_post_meta($announcement->ID, 'announcement_url', TRUE);
			$announcement->announcementContactPerson = get_post_meta($announcement->ID, 'announcement_contact', TRUE);
			$announcement->announcementPhone		 = get_post_meta($announcement->ID, 'announcement_phone', TRUE);
			$announcement->announcementEmail		 = get_post_meta($announcement->ID, 'announcement_email', TRUE);
			$announcement->announcementPostedBy		 = get_post_meta($announcement->ID, 'announcement_posted_by', TRUE);
			$announcement->announcementRoles		 = wp_get_post_terms($announcement->ID, 'audienceroles', array("fields" => "names"));
			$announcement->announcementKeywords		 = wp_get_post_terms($announcement->ID, 'keywords', array("fields" => "names"));
			$announcement->announcementIsNew		 = ( date('Ymd') - date('Ymd', strtotime($announcement->post_date) ) <= 2 ) ? true : false;
		}
		
		return $announcements;
	}
}


/**
 * Prints a set of announcements, given an announcements array
 * returned from get_announcements().
 **/
function print_announcements($announcements, $liststyle='thumbtacks', $spantype='span4', $perrow=3) {
	switch ($liststyle) {
		case 'list':
			print '<ul class="announcement_list unstyled">';
			// Simple list of announcements; no descriptions.
			// $spantype and $perrow are not used here.
			foreach ($announcements as $announcement) {
				ob_start(); ?>
				<li><h3><a href="<?=get_permalink($announcement->ID)?>"><?=$announcement->post_title?></a></h3></li>
			<?php
				print ob_get_clean();
			}
			print '</ul>';
			break;	
				
		case 'thumbtacks':
			// Grid of thumbtack-styled announcements
			print '<div class="row">';
			$count = 0;
			foreach ($announcements as $announcement) {
				if ($count % $perrow == 0 && $count !== 0) {
					print '</div><div class="row">';
				}
				ob_start();
				?>
				<div class="<?=$spantype?>" id="announcement_<?=$announcement->ID?>">
					<div class="announcement_wrap">
						<div class="thumbtack"></div>
						<?php if ($announcement->announcementIsNew == true) { ?><div class="new">New Announcement</div><?php } ?>
						<h3><a href="<?=get_permalink($announcement->ID)?>"><?=$announcement->post_title?></a></h3>
						<p class="date"><?=date('M d', strtotime($announcement->announcementStartDate))?> - <?=date('M d', strtotime($announcement->announcementEndDate))?></p>
						<p><?=truncateHtml(strip_tags($announcement->post_content, 200))?></p>
						<p class="audience"><strong>Audience:</strong> 
						<?php 
							if ($announcement->announcementRoles) {
								$rolelist = '';
								foreach ($announcement->announcementRoles as $role) {
									switch ($role) {
										case 'Alumni':
											$link = '?role=alumni';
											break;
										case 'Faculty':
											$link = '?role=faculty';
											break;
										case 'Prospective Students':
											$link = '?role=prospective-students';
											break;
										case 'Public':
											$link = '?role=public';
											break;
										case 'Staff':
											$link = '?role=staff';
											break;
										case 'Students':
											$link = '?role=students';
											break;
										default:
											$link = '';
											break;
									}
									$rolelist .= '<a class="print-noexpand" href="'.get_permalink().$link.'">'.$role.'</a>, ';
								}
								print substr($rolelist, 0, -2);
							}
							else { print 'n/a'; }
						?>
						</p>
						<p class="keywords"><strong>Keywords:</strong> 
						<?php 
							if ($announcement->announcementKeywords) {
								$keywordlist = '';
								foreach ($announcement->announcementKeywords as $keyword) {
									$keywordlist .= '<a class="print-noexpand" href="'.get_permalink().'?keyword='.$keyword.'">'.$keyword.'</a>, ';
								}
								print substr($keywordlist, 0, -2);
							}
							else { print 'n/a'; }
						?>
						</p>
										
											
					</div>
				</div>	
			<?php
				print ob_get_clean();
				$count++;
			} // endforeach
			print '</div>';
			break;
			
		default:
			break;
	}
}


/**
 * Takes an announcements array from get_announcements() and outputs an RSS feed.
 **/
function announcements_to_rss($announcements) {
	if (!($announcements)) { die('Error: no announcements feed provided, or no results were found.'); }
	header('Content-Type: application/rss+xml; charset=ISO-8859-1');
	print '<?xml version="1.0" encoding="ISO-8859-1"?>';
	print '<rss version="2.0" xmlns:announcement="'.get_site_url().'/announcements/">';
	print '<channel>';
	print '<title>University of Central Florida Announcements</title>';
	print '<link>http://www.ucf.edu/</link>';
	print '<language>en-us</language>';
	print '<copyright>ucf.edu</copyright>';
	print '<ttl>30</ttl>'; // Time to live (in minutes); force a cache refresh after this time
	print '<description>Feed for UCF Announcements.</description>';

	function print_item($announcement) {
		$output = '';
		$output .= '<item>';
			// Generic RSS story elements
			$output .= '<title>'.$announcement->post_title.'</title>';
			$output .= '<description><![CDATA['.htmlentities(strip_tags($announcement->post_content)).']]></description>';
			if ($announcement->announcementURL) { $output .= '<link>'.htmlentities($announcement->announcementURL).'</link>'; }
			$output .= '<guid>'.get_permalink($announcement->ID).'</guid>';
			$output .= '<pubDate>'.date('r', strtotime($announcement->post_date)).'</pubDate>';
			
			// Announcement-specific stuff	
			$output .= '<announcement:id>'.$announcement->ID.'</announcement:id>';	
			$output .= '<announcement:postStatus>'.$announcement->post_status.'</announcement:postStatus>';
			$output .= '<announcement:postModified>'.$announcement->post_modified.'</announcement:postModified>';
			$output .= '<announcement:published>'.$announcement->post_date.'</announcement:published>'; // same as <pubDate>
			$output .= '<announcement:permalink>'.get_permalink($announcement->ID).'</announcement:permalink>'; // same as <guid>
			$output .= '<announcement:postName>'.$announcement->post_name.'</announcement:postName>';
			$output .= '<announcement:startDate>'.$announcement->announcementStartDate.'</announcement:startDate>';
			$output .= '<announcement:endDate>'.$announcement->announcementEndDate.'</announcement:endDate>';
			$output .= '<announcement:url>'.htmlentities($announcement->announcementURL).'</announcement:url>'; // same as <link>
			$output .= '<announcement:contactPerson>'.htmlentities($announcement->announcementContactPerson).'</announcement:contactPerson>';
			$output .= '<announcement:phone>'.$announcement->announcementPhone.'</announcement:phone>';
			$output .= '<announcement:email>'.htmlentities($announcement->announcementEmail).'</announcement:email>'; // need to account for special chars
			$output .= '<announcement:postedBy>'.htmlentities($announcement->announcementPostedBy).'</announcement:postedBy>';
			$output .= '<announcement:roles>';
				if (!empty($announcement->announcementRoles)) {
					foreach ($announcement->announcementRoles as $role) {
						$roles .= $role.', '; 
					}
					$roles = substr($roles, 0, -2);
					$output .= $roles;	
				}
			$output .= '</announcement:roles>';
			$output .= '<announcement:keywords>';
				if (!empty($announcement->announcementKeywords)) {
					foreach ($announcement->announcementKeywords as $keyword) {
						$keywords .= $keyword.', '; 
					}
					$keywords = substr($keywords, 0, -2);
					$output .= $keywords;	
				}
			$output .= '</announcement:keywords>';
			$output .= '<announcement:isNew>';
				$announcement->announcementIsNew == true ? $output .= 'true' : $output .= 'false';
			$output .= '</announcement:isNew>';
	
		$output .= '</item>';
		
		$roles = '';
		$keywords = '';
		
		print $output;
	}
			
	if ($announcements !== NULL) {
		// $announcements will always be an array of objects
		foreach ($announcements as $announcement) {
			print_item($announcement);
		}
	}
	print '</channel></rss>';
}

/*
 * Returns a theme option value or NULL if it doesn't exist
 */
function get_theme_option($key) {
	global $theme_options;
	return isset($theme_options[$key]) ? $theme_options[$key] : NULL;
}

/*
 * Wrap a statement in a ESI include tag with a specified duration in the 
 * enable_esi theme option is enabled
 */
function esi_include($statement) {
	$enable_esi = get_theme_option('enable_esi');

	if(!is_null($enable_esi) && $enable_esi === '1') {
		?>
		<esi:include src="<?php echo ESI_INCLUDE_URL?>?statement=<?php echo urlencode(base64_encode($statement)); ?>" />
		<?php
	} else {
		eval($statement);
	}
}


/** 
 * Pull recent Gravity Forms entries from a given form (intended for Feedback form.)
 * If no formid argument is provided, the function will pick the form
 * with ID of 1 by default.
 * Duration is specified in number of days.
 **/
function get_feedback_entries($formid=1, $duration=7, $to=array('webcom@ucf.edu')) {
	
	// Check that GF is actually installed
	if (is_plugin_inactive('gravityforms/gravityforms.php')) {
		die('Error: Gravity Forms is not activated. Please install/activate Gravity Forms and try again.');
	}
	
	// Make sure a valid email address to send to is set
	if (empty($to)) {
		die('Error: No email address specified to mail to.');
	}
	if (!is_array($to)) {
		die('Error: $to expects an array value.');
	}
	
	// Define how far back to search for old entries
	$dur_end_date 	= date('Y-m-d');
	$dur_start_date = date('Y-m-d', strtotime($dur_end_date.' -'.$duration.' days'));
	
	// WPDB stuff
	global $wpdb;
	global $blog_id;
	define( 'DIEONDBERROR', true );
	//$wpdb->show_errors();
	
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
	
	if (count($entry_ids) == 0) {
		$output .= 'No submissions found for this time period.';
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
		
	}	
	// E-mail setup
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

/** 
 * Query the search service with specified params
 * @return array
 * @author Chris Conover
 **/
function query_search_service($params) {
	$results = array();
	try {
		$context = stream_context_create(array(
			'http' => array(
				'method'  => 'GET',
				'timeout' => SEARCH_SERVICE_HTTP_TIMEOUT
		)));
		$search_url = implode(array(SEARCH_SERVICE_URL, '?', http_build_query($params)));
		$response   = file_get_contents($search_url, false, $context);
		$json       = json_decode($response);
		if(isset($json->results)) $results = $json->results;
	} catch (Exception $e) {
		# pass
	}
	return $results;
}


/**
 * Prevent Wordpress from trying to redirect to a "loose match" post when
 * an invalid URL is requested.  WordPress will redirect to 404.php instead.
 *
 * See http://wordpress.stackexchange.com/questions/3326/301-redirect-instead-of-404-when-url-is-a-prefix-of-a-post-or-page-name
 **/ 
function no_redirect_on_404($redirect_url) {
    if (is_404()) {
        return false;
    }
    return $redirect_url;
}
add_filter('redirect_canonical', 'no_redirect_on_404');


/** 
 * Because autosaving is handled differently than standard post saving,
 * our serialized file metadata for centerpiece images gets totally lost 
 * when trying to preview drafts.  We're going to disable autosaving on 
 * centerpieces only to allow for previews that don't wipe this data.
 **/
function admin_centerpiece_enqueue_scripts() {
    if (get_post_type() == 'centerpiece') {
        wp_dequeue_script('autosave');
	}
}
add_action('admin_enqueue_scripts', 'admin_centerpiece_enqueue_scripts');


/**
 * Disable the Yoast SEO meta box on post types that we don't need it on
 * (non-public-facing posts, i.e. Centerpieces, Subheaders...)
 **/
function remove_yoast_meta_boxes() {
	$post_types = array(
		'centerpiece',
        'subheader',
        'azindexlink',
        'video',
        'document',
        'publication',
	);
    foreach ($post_types as $post_type) {
		remove_meta_box('wpseo_meta', $post_type, 'normal');
    }
}
add_action( 'add_meta_boxes', 'remove_yoast_meta_boxes' );
 
?>