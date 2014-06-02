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
			<a href="<?=get_permalink($spotlight->ID)?>" class="ga-event" data-ga-action="Spotlight Link" data-ga-label="<?=$spotlight->post_title?>">
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
			<h3 class="home_spotlight_title"><a href="<?=get_permalink($spotlight->ID)?>" class="ga-event" data-ga-action="Spotlight Link" data-ga-label="<?=$spotlight->post_title?>"><?=$spotlight->post_title?></a></h3>
			<?=truncateHtml($spotlight->post_content, 200)?>
			<p><a class="home_spotlight_readmore ga-event" href="<?=get_permalink($spotlight->ID)?>" target="_blank" data-ga-action="Spotlight Link" data-ga-label="<?=$spotlight->post_title?>">Read More…</a></p>
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
								'timeout' => WEATHER_FETCH_TIMEOUT,
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
function output_weather_data($cssclass=null) {
	$cssclass	= is_string($cssclass) ? strip_tags($cssclass) : (string)strip_tags($cssclass);
	$weather 	= get_weather_data();
	$condition 	= $weather['condition'];
	$temp 		= $weather['temp'];
	$img 		= $weather['img']; ?>
	<div id="weather_bug" class="<?=$cssclass?> screen-only" role="complementary">
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
			's' => $keyword,
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
				if (CURRENT_MONTH >= SPRING_MONTH_START && CURRENT_MONTH <= SPRING_MONTH_END) {
					$time_args = array(
						'meta_query' => array(
							array(
								'key' => 'announcement_start_date',
								'value' => date('Y-m-t', strtotime('May')),
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
				elseif (CURRENT_MONTH >= SUMMER_MONTH_START && CURRENT_MONTH <= SUMMER_MONTH_END) {
					$time_args = array(
						'meta_query' => array(
							array(
								'key' => 'announcement_start_date',
								'value' => date('Y-m-t', strtotime('July')),
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
								'value' => date('Y-m-t', strtotime('December')),
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

			// Fallback for bad date ranges--force the start date to equal
			// the end date if the start date is later than the end date
			if ( date('Ymd', strtotime($announcement->announcementStartDate)) > date('Ymd', strtotime($announcement->announcementEndDate)) ) {
				$announcement->announcementStartDate = $announcement->announcementEndDate;
			}
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
						<p class="date">
							<?php if ($announcement->announcementStartDate == $announcement->announcementEndDate) {
								print date('M d', strtotime($announcement->announcementEndDate));
							} else {
								print date('M d', strtotime($announcement->announcementStartDate)) .' - '. date('M d', strtotime($announcement->announcementEndDate));
							}
							?>
						</p>
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
	print '<ttl>1</ttl>'; // Time to live (in minutes); force a cache refresh after this time
	print '<description>Feed for UCF Announcements.</description>';

	function print_item($announcement) {
		$output = '';
		$output .= '<item>';
			// Generic RSS story elements
			$output .= '<title>'.$announcement->post_title.'</title>';
			$output .= '<description><![CDATA['.htmlentities(strip_tags($announcement->post_content)).']]></description>';
			$output .= '<link>'.get_permalink($announcement->ID).'</link>';
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
			$output .= '<announcement:url>'.htmlentities($announcement->announcementURL).'</announcement:url>';
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
 * Wrap a statement in a ESI include tag with a specified duration if the
 * enable_esi theme option is enabled.
 */
function esi_include($statementname, $argset=null) {
	if (!$statementname) { return null; }

	// Get the statement key
	$statementkey = null;
	foreach (Config::$esi_whitelist as $key=>$function) {
		if ($function['name'] == $statementname) { $statementkey = $key;}
	}
	if (!$statementkey) { return null; }

	// Never include ESI over HTTPS
	$enable_esi = get_theme_option('enable_esi');
	if(!is_null($enable_esi) && $enable_esi === '1' && is_ssl() == false) {
		$argset = ($argset !== null) ? $argset = '&args='.urlencode(base64_encode($argset)) : '';
		?>
		<esi:include src="<?php echo ESI_INCLUDE_URL?>?statement=<?=$statementkey?><?=$argset?>" />
		<?php
	} elseif (array_key_exists($statementkey, Config::$esi_whitelist)) {
		$statementname = Config::$esi_whitelist[$statementkey]['name'];
		$statementargs = Config::$esi_whitelist[$statementkey]['safe_args'];
		// If no safe arguments are defined in the whitelist for this statement,
		// run call_user_func(); otherwise check arguments and run call_user_func_array()
		if (!is_array($statementargs) || $argset == null) {
			return call_user_func($statementname);
		}
		else {
			// Convert argset arrays to strings for easy comparison with our whitelist
			$argset = is_array($argset) ? serialize($argset) : $argset;
			if ($argset !== null && in_array($argset, $statementargs)) {
				$argset = (unserialize($argset) !== false) ? unserialize($argset) : array($argset);
				return call_user_func_array($statementname, $argset);
			}
		}
	}
	else {
		return NULL;
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
	$blog_id == 1 ? $gf_table = 'wp_rg_lead' : $gf_table = 'wp_'.$blog_id.'_rg_lead'; # Y U NO USE CONSISTENT NAMING SCHEMA??
	define( 'DIEONDBERROR', true );
	$wpdb->show_errors();

	// Get all entry IDs
	$entry_ids = $wpdb->get_results(
			"
			SELECT          id
			FROM            ".$gf_table."
			WHERE           form_id = ".$formid."
			AND                     date_created >= '".$dur_start_date." 00:00:00'
			AND                     date_created <= '".$dur_end_date." 23:59:59'
			ORDER BY        date_created ASC
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

			// Only setup email for active entries (not trash/spam)
			if ($entry['status'] == 'active') {
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

				$output .= '<li><strong>Entry: </strong>#'.$entry_output['id'].'</li>';
				$output .= '<li><strong>From: </strong>'.$entry_output['name'].' < '.$entry_output['email'].' ></li>';
				$output .= '<li><strong>Date Submitted: </strong>'.$entry_output['date'].'</li>';
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


/**
 * Output a page-specific stylesheet, if one exists.
 * Intended for use in header.php (in edge-side include)
 **/
function page_specific_stylesheet($pageid) {
	if(($stylesheet_id = get_post_meta($pageid, 'page_stylesheet', True)) !== False
		&& ($stylesheet_url = wp_get_attachment_url($stylesheet_id)) !== False) {
		print '<link rel="stylesheet" href="'.$stylesheet_url.'" type="text/css" media="all" />';
	}
	else { return NULL; }
}


/**
 * Kill attachment, author, and daily archive pages.
 *
 * http://betterwp.net/wordpress-tips/disable-some-wordpress-pages/
 **/
function kill_unused_templates() {
	global $wp_query, $post;

	if (is_author() || is_attachment() || is_day() || is_search()) {
		wp_redirect(home_url());
	}

	if (is_feed()) {
		$author     = get_query_var('author_name');
		$attachment = get_query_var('attachment');
		$attachment = (empty($attachment)) ? get_query_var('attachment_id') : $attachment;
		$day        = get_query_var('day');
		$search     = get_query_var('s');

		if (!empty($author) || !empty($attachment) || !empty($day) || !empty($search)) {
			wp_redirect(home_url());
			$wp_query->is_feed = false;
		}
	}
}
add_action('template_redirect', 'kill_unused_templates');


/**
* Add ID attribute to registered University Header script.
**/
function add_id_to_ucfhb($url) {
    if ( (false !== strpos($url, 'bar/js/university-header.js')) || (false !== strpos($url, 'bar/js/university-header-full.js')) ) {
      remove_filter('clean_url', 'add_id_to_ucfhb', 10, 3);
      return "$url' id='ucfhb-script";
    }
    return $url;
}
add_filter('clean_url', 'add_id_to_ucfhb', 10, 3);


/**
 * Returns an array of post groups, grouped by a specified taxonomy's terms.
 * Each key is a taxonomy term ID; each value is an array of post objects.
 **/
function group_posts_by_tax_terms($tax, $posts, $specific_terms=null) {
	$groups = array();

	// Get all taxonomy terms.
	$args = array('fields' => 'ids');
	$terms = get_terms($tax, $args);

	if ($terms) {
		// 'include' get_terms arg is not working. Filter here instead:
		foreach ($terms as $term) {
			$term = intval($term);
			if (is_array($specific_terms)) {
				if (in_array($term, $specific_terms)) {
					$groups[intval($term)] = array();
				}
			}
			else {
				$groups[intval($term)] = array();
			}
		}

		// Loop through each returned post and get its term(s).
		// Group the post in the $groups array.
		if ($posts) {
			foreach ($posts as $post) {
				$post_terms = wp_get_post_terms($post->ID, $tax, array('fields' => 'ids'));
				if ($post_terms) {
					foreach ($post_terms as $t) {
						$t = intval($t);
						if (isset($groups[$t])) {
							array_push($groups[$t], $post);
						}
						else {
							$groups[$t] = array($post);
						}
					}
				}
			}

			// Remove any terms with no posts.
			foreach ($groups as $term=>$posts) {
				if (empty($groups[$term])) { unset($groups[$term]); }
			}

			return $groups;
		}
		else { return null; }
	}
	else { return null; }
}


/**
 * Fetch a set of Degree Programs.
 **/
function get_degrees() {
	// Set the view.  The view determines what set of data needs to be returned
	// and how that data should be grouped/ordered.
	// Available views are defined in $all_views.
	$view = $_GET['view'] ? $_GET['view'] : 'browse_by_name';

	// Define which of our Program types are valid.  (These are highest-level parent terms
	// of the Program Type taxonomy.)
	$all_program_type_parents = array('undergraduate-program', 'graduate-program');

	// Define which of our Degree types are valid.  (These are the 2nd level terms of
	// the Program Type taxonomy.)
	$all_degree_types = array('undergraduate-degree', 'minor', 'graduate-degree', 'certificate');


	// Determine some variables based on query args.  Set defaults if no values are set.
	$program_type	     = in_array($_GET['program_type'], $all_program_type_parents) ? $_GET['program_type'] : null;
	$degree_type	     = in_array($_GET['degree_type'], $all_degree_types) ? $_GET['degree_type'] : 'undergraduate-degree';
	$orderby		     = $_GET['orderby'] ? $_GET['orderby'] : 'title';
	$order			     = ($_GET['order'] == 'ASC' || $_GET['order'] == 'DESC') ? $_GET['order'] : 'ASC';
	$flip_order		     = ($order == 'ASC') ? 'DESC' : 'ASC'; // opposite of $order

	$s                   = $_GET['search']       ? $_GET['search']        : null;
	$search_query_pretty = !empty($s)            ? htmlentities($s)       : null;

	// Define a default list of get_posts() args.
	$default_view_params = array(
		'post_type' => 'degree',
		'post_status' => 'publish',
		'numberposts' => -1,
		'orderby' => $orderby,
		'order' => $order,
		'tax_query' => array(
			array(
				'taxonomy' => 'program_types',
				'field' => 'slug',
				'terms' => $degree_type,
				'include_children' => true // Make sure we get Undergraduate Degree children (Articulated/Accelerated)
			),
		),
	);

	// Search-specific variable overrides
	if (!empty($s)) {
		$program_type = empty($program_type) ? $all_program_type_parents : $program_type;
	}

	// Define per-view get_posts() args.
	$all_views = array(
		'browse_by_name' => $default_view_params,
		'browse_by_college' => $default_view_params, // Needs to be sorted later
		'browse_by_hours' => array_merge($default_view_params, array(
			'meta_key' => 'degree_hours',
			'orderby' => 'meta_value'
		)),
	);

	// Get the posts.  Override any set view with search-specific args, if this is a
	// set of search results.
	if (isset($all_views[$view])) {
		if ($s) {
			$all_views[$view] = array_merge($all_views[$view], array(
				's' => $s,
				'tax_query' => array(
					// Overrides existing tax_query.
					array(
						'taxonomy' => 'program_types',
						'field' => 'slug',
						'terms' => $program_type,
						'include_children' => true,
					)
				),
			));
		}
		$posts = get_posts($all_views[$view]);
	}
	else { return 'Invalid view type.'; }


	// Process the returned posts.
	$data = array(
		'view-info' => array(
			'view' => $view,
			'all-program_type-parents' => $all_program_type_parents,
			'all-degree-types' => $all_degree_types,
			'program_type' => $program_type,
			'degree_type' => $degree_type,
			'orderby' => $orderby,
			'order' => $order,
			'flip-order' => $flip_order,
			's' => $s,
			'search-query-pretty' => $search_query_pretty,
			'grouping-tax' => null,
		),
		'posts' => null,
	);

	if ($posts) {
		// Assign post meta data we need as properties of each post object for easy access later.
		foreach ($posts as $post) {
			$post->degree_hours = get_post_meta($post->ID, 'degree_hours', TRUE);
			$post->degree_description = get_post_meta($post->ID, 'degree_description', TRUE);
			$post->degree_website = get_post_meta($post->ID, 'degree_website', TRUE);
			$post->tax_college = wp_get_post_terms($post->ID, 'colleges', array('fields' => 'names'));
			$post->tax_department = wp_get_post_terms($post->ID, 'departments', array('fields' => 'names'));
			$post->tax_program_type = wp_get_post_terms($post->ID, 'program_types', array('fields' => 'names'));
		}

		// Further group our returned posts.
		$grouped_posts = null;
		$grouping_tax = null; // The type of taxonomy by which posts are grouped.
		switch ($view) {
			case 'browse_by_college':
				$grouping_tax = 'colleges';
				$grouped_posts = group_posts_by_tax_terms($grouping_tax, $posts);
				break;
			default:
				$grouping_tax = 'program_types';
				$include_terms = (empty($s)) ? $degree_type : $program_type;

				// Get Program Type term ID(s) to pass to group_posts_by_tax_terms()
				$term_ids = array();
				if (is_array($include_terms)) {
					foreach ($include_terms as $slug) {
						$term_ids[] = intval(get_term_by('slug', $slug, $grouping_tax)->term_id);
					}
				}
				else {
					$term_ids[] = intval(get_term_by('slug', $include_terms, $grouping_tax)->term_id);
				}

				$grouped_posts = group_posts_by_tax_terms($grouping_tax, $posts, $term_ids);
				break;
		}
		$data['view-info']['grouping-tax'] = $grouping_tax;
		$data['posts'] = $grouped_posts;
	}

	// Return the grouped posts and view-related variables.
	return $data;
}


/**
 * Display a list of degrees with posts returned from get_degrees().
 **/
function display_degrees($data) {
	// Add selected state to Search form program type dropdown
	$search_program_undergrad_sel = $search_program_all_sel = $search_program_grad_sel = '';
	$search_program_active_sel = 'selected="selected"';

	if (isset($data['view-info']['program_type'])) {
		if (is_array($data['view-info']['program_type'])) {
			$search_program_all_sel = $search_program_active_sel;
		}
		else {
			switch ($data['view-info']['program_type']) {
				case 'undergraduate-program':
					$search_program_undergrad_sel = $search_program_active_sel;
					break;
				case 'graduate-program':
					$search_program_grad_sel = $search_program_active_sel;
					break;
				default:
					break;
			}
		}
	}
	else {
		$search_program_all_sel = $search_program_active_sel;
	}

	// Add active state class to Browse All degree type navigation links.
	// Do not apply class if search results are returned.
	$browse_majors_class = $browse_minors_class = $browse_grad_class = $browse_cert_class = '';
	$browse_active_class = 'active';
	if (empty($data['view-info']['s'])) {
		if (isset($data['view-info']['degree_type'])) {
			switch ($data['view-info']['degree_type']) {
				case 'minor':
					$browse_minors_class = $browse_active_class;
					break;
				case 'graduate-degree':
					$browse_grad_class = $browse_active_class;
					break;
				case 'certificate':
					$browse_cert_class = $browse_active_class;
					break;
				default:
					$browse_majors_class = $browse_active_class;
					break;
			}
		}
	}

	// Generate $results_title string based on current view for <h2> ("Results For:" heading)
	$results_title = '';
	if (empty($data['view-info']['s'])) {
		$degree_type = get_term_by('slug', $data['view-info']['degree_type'], 'program_types')->name;
		$results_title = 'All '.$degree_type.'s';
	}
	else {
		$results_title = '&ldquo;'.$data['view-info']['search-query-pretty'].'&rdquo;';
	}

	if (is_array($data)) {
		// Create links per sort option (Name/College/Hours)
		$permalink = $_SERVER[REQUEST_URI];
		if (strpos($permalink, 'order=').count < 1) {
			add_query_arg(array('order' => $data['view-info']['order']), $permalink);
		}
		$reverse_order_url = add_query_arg(array('order' => $data['view-info']['flip-order']), $permalink);

		$sort_name_url    = ($data['view-info']['view'] == 'browse_by_name') ? $reverse_order_url : add_query_arg(array('view' => 'browse_by_name'), $permalink);
		$sort_college_url = add_query_arg(array('view' => 'browse_by_college'), $permalink);
		$sort_hours_url   = ($data['view-info']['view'] == 'browse_by_hours') ? $reverse_order_url : add_query_arg(array('view' => 'browse_by_hours'), $permalink);

		$sort_name_classes = $sort_college_classes = $sort_hours_classes = '';

		if ($data['view-info']['view'] == 'browse_by_college') {
			$sort_college_classes .= 'active';
		}
		else if ($data['view-info']['view'] == 'browse_by_hours') {
			$sort_hours_classes .= 'active';
			if ($data['view-info']['flip-order'] == 'ASC') {
				$sort_hours_classes .= ' dropup';
			}
		}
		else { // 'search' AND 'browse_by_name'
			$sort_name_classes .= 'active';
			if ($data['view-info']['flip-order'] == 'ASC') {
				$sort_name_classes .= ' dropup';
			}
		}
	}

	ob_start(); ?>

	<div id="filters">
		<span class="degree-search-label">Search:</span>
		<div class="controls controls-row">
			<form id="course_search_form" action="<?=get_permalink()?>" class="form-search">
				<select name="program_type" class="span4">
					<option <?=$search_program_undergrad_sel?> value="undergraduate-program">Undergraduate Programs Only</option>
					<option <?=$search_program_all_sel?> value="">Undergraduate and Graduate Programs</option>
					<option <?=$search_program_grad_sel?> value="graduate-program">Graduate Programs Only</option>
				</select>
				<div class="input-append span3">
					<?php $search_query = isset($data['view-info']['search-query-pretty']) ? $data['view-info']['search-query-pretty'] : ''; ?>
					<input type="text" class="search-query" name="search" value="<?=$search_query?>" />
					<button type="submit" class="btn"><i class="icon-search"></i><span class="hidden-phone"> Search</span></button>
				</div>
			</form>
		</div>
	</div>

	<div id="browse">
		<div class="row">
			<div class="span10">
				<span class="degree-search-label">Browse All:</span>
				<ul class="nav nav-pills" role="navigation" id="degree-type-list">
					<li class="<?=$browse_majors_class?>">
						<a class="print-noexpand" href="<?=get_permalink()?>?degree_type=undergraduate-degree">Undergraduate Degrees</a>
					</li>
					<li class="<?=$browse_minors_class?>">
						<a class="print-noexpand" href="<?=get_permalink()?>?degree_type=minor">Minors</a>
					</li>
					<li class="<?=$browse_grad_class?>">
						<a class="print-noexpand" href="<?=get_permalink()?>?degree_type=graduate-degree">Graduate Degrees</a>
					</li>
					<li class="<?=$browse_cert_class?>">
						<a class="print-noexpand" href="<?=get_permalink()?>?degree_type=certificate">Certificates</a>
					</li>
				</ul>
			</div>
		</div>
	</div>

		<?php
		if (is_array($data)) {
			// Get total number of posts.
			$results_count = 0;
			if ($data['posts']) {
				foreach ($data['posts'] as $group) {
					foreach ($group as $post) {
						$results_count++;
					}
				}
			} ?>

		<div id="results">
			<div class="row">
				<h2 id="results-header" class="span10">
					<?=$results_count?> Result<?php if ($results_count == 0 || $results_count > 1) { ?>s<?php } ?> For:
					<span class="results-header-alt">
						<?=$results_title?>
					</span>
				</h2>

				<div class="span10">
					<ul class="nav nav-tabs" id="degree-type-sort">
						<li id="degree-type-sort-header">Sort by:</li>
						<li class="dropdown <?=$sort_name_classes?>">
							<a class="print-noexpand" href="<?=$sort_name_url?>">Name <b class="caret"></b></a>
						</li>
						<li class="dropdown <?=$sort_college_classes?>">
							<a class="print-noexpand" href="<?=$sort_college_url?>">College</a>
						</li>
						<li class="dropdown <?=$sort_hours_classes?>">
							<a class="print-noexpand" href="<?=$sort_hours_url?>">Hours <b class="caret"></b></a>
						</li>
					</ul>
				</div>
			</div>
		</div>

			<?php
			if (!empty($data['posts'])) {
				foreach ($data['posts'] as $group=>$posts) {
					$term = get_term($group, $data['view-info']['grouping-tax']);

					// Pluralize term if the grouping taxonomy is not by College
					if ($data['view-info']['grouping-tax'] !== 'colleges') {
						$term = $term->name.'s';
					}
					else { $term = $term->name; }
					?>

					<h3 class="program-type"><?=$term?></h3>
					<ul class="row results-list">
					<?php
					foreach ($posts as $post) {
						// Get permalink to landing page for a single degree program.
						// Graduate programs should link to the degree_website meta value.
						$single_url = null;
						if (get_permalink($post->ID) && $post->tax_program_type[0] !== 'Graduate Degree' && $post->tax_program_type[0] !== 'Certificate') {
							$single_url = get_permalink($post->ID);
						}
						else {
							$single_url = $post->degree_website;
						}
						?>
						<li class="program span10">
							<div class="row">
								<div class="span7">
									<?php if ($single_url) { ?>
									<a href="<?=$single_url?>" <?php if ($single_url == $post->degree_website) { ?> class="ga-event" data-ga-action="Graduate Catalog link" data-ga-label="Degree List Item: <?=addslashes($post->post_title)?> (<?=addslashes($post->tax_program_type[0])?>)"<?php } ?>>
									<?php } ?>
										<h4 class="name"><?=$post->post_title?></h4>
									<?php if ($single_url) { ?>
									</a>
									<?php } ?>

								<?php if ($post->tax_college[0]) { ?>
									<span class="name_label">College</span>
									<span class="college"><?=$post->tax_college[0]?></span>
								<?php } ?>

								<?php if ($post->tax_department[0]) { ?>
									<span class="name_label">Department</span>
									<span class="department">
										<?php if ($post->degree_website) { ?><a href="<?=$post->degree_website?>"><?php } ?>
										<?=$post->tax_department[0]?>
										<?php if ($post->degree_website) { ?></a><?php } ?>
									</span>
								<?php } ?>

								</div>

								<div class="credits-wrap">
									<span class="program-type-alt"><?=$post->tax_program_type[0]?></span>

									<?php if (!empty($post->degree_hours)) {
										if (!empty($post->degree_website) && ($post->tax_program_type[0] == 'Graduate Degree') || !is_numeric(substr($post->degree_hours, 0, 1))) { ?>
										<a href="<?=$post->degree_website?>" <?php if ($single_url == $post->degree_website) { ?>class="ga-event" data-ga-action="Graduate Catalog link" data-ga-label="Degree List Item: <?=addslashes($post->post_title)?> (<?=addslashes($post->tax_program_type[0])?>)"<?php } ?>>
											<span class="credits label label-warning">Click for credit hours</span>
										</a>
										<?php } elseif (intval($post->degree_hours) >= 100) { ?>
										<span class="credits label label-info"><?=intval($post->degree_hours)?> credit hours</span>
										<?php } elseif (intval($post->degree_hours) > 1 && intval($post->degree_hours) < 100) { ?>
										<span class="credits label label-success"><?=intval($post->degree_hours)?> credit hours</span>
									<?php }
									} else { ?>
										<span class="credits label">Credit hours n/a</span>
									<?php } ?>
								</div>

							</div>
						</li>
					<?php
					}
					?>
					</ul>
					<hr />
				<?php
				}
			} else { ?>
			<p class="error">No results found.</p>
			<?php
			}
			?>

		<?php
		}
		else { ?>
		<p class="error">
			<strong>ERROR:</strong> <?=$data?>
		</p>
		<?php
		} ?>

	<?php
	print ob_get_clean();
}


/**
 * Generates a title based on context page is viewed.  Stolen from Thematic
 **/
function header_title($title, $separator){
	global $post;
	$site_name = get_bloginfo('name');

	if ( is_single() ) {
		$content = single_post_title('', FALSE);
	}
	elseif ( is_home() || is_front_page() ) {
		$content = get_bloginfo('description');
	}
	elseif ( is_page() ) {
		$substitute_title = get_post_meta(get_the_ID(), 'page_title', true);
		if (!empty($substitute_title)) {
			$content = $substitute_title;
		}
		else {
			$content = single_post_title('', FALSE);
		}
	}
	elseif ( is_search() ) {
		$content = __('Search Results for:');
		$content .= ' ' . esc_html(stripslashes(get_search_query()));
	}
	elseif ( is_category() ) {
		$content = __('Category Archives:');
		$content .= ' ' . single_cat_title("", false);;
	}
	elseif ( is_404() ) {
		$content = __('Not Found');
	}
	else {
		$content = get_bloginfo('description');
	}

	if (get_query_var('paged')) {
		$content .= ' ' .$separator. ' ';
		$content .= 'Page';
		$content .= ' ';
		$content .= get_query_var('paged');
	}

	if($content) {
		if (is_home() || is_front_page()) {
			$elements = array(
				'site_name' => $site_name,
				'separator' => $separator,
				'content' => $content,
			);
		} else {
			$elements = array(
				'content' => $content,
			);
		}
	} else {
		$elements = array(
			'site_name' => $site_name,
		);
	}

	// But if they don't, it won't try to implode
	if(is_array($elements)) {
		$doctitle = implode(' ', $elements);
	}
	else {
		$doctitle = $elements;
	}

	$doctitle = '<title>'.$doctitle.'</title>';

	return $doctitle;
}
add_filter('wp_title', 'header_title', 10, 2); // Allow overriding by SEO plugins


/**
 * Generates page <title> tag for Degree Program post type.
 **/
function header_title_degree_programs($title, $separator) {
	global $post;

	if ($post->post_type == 'degree') {
		$title = 'Degree Program '.$separator.' '.single_post_title('', FALSE);
	}

	return '<title>'.$title.'</title>';
}
add_filter('wp_title', 'header_title_degree_programs', 11, 2); // Allow overriding by SEO plugins


/**
 * Generates page <title> tag for Degree Search views.
 **/
function header_title_degree_search($title, $separator) {
	global $post;

	// Custom page overrides here (necessary for Degree Search)
	if ($post->ID == get_page_by_title('Degree Search')->ID) {
		$content = 'Degree Search';
		$degree_type = $_GET['degree_type'];
		$browse_by = $_GET['view'];
		$degree_title = null;
		$degree_subtitle = null;

		if ($degree_type) {
			switch ($degree_type) {
				case 'undergraduate-degree':
					$degree_title = 'All Majors';
					break;
				case 'minor':
					$degree_title = 'All Minors';
					break;
				case 'graduate-degree':
					$degree_title = 'All Graduate Degrees';
					break;
				case 'certificate':
					$degree_title = 'All Certificates';
					break;
				default:
					break;
			}
			if ($degree_title) {
				$content .= ' '.$separator.' '.$degree_title;
			}
		}
		if ($browse_by) {
			switch ($browse_by) {
				case 'browse_by_college':
					$degree_subtitle = 'by College';
					break;
				case 'browse_by_hours':
					$degree_subtitle = 'by Hours';
					break;
				default:
					break;
			}
			if ($degree_subtitle) {
				$content .= ' '.$degree_subtitle;
			}
		}

		$title = $content;
	}
	return '<title>'.$title.'</title>';
}
add_filter('wp_title', 'header_title_degree_search', 99, 2); // Force these page titles (SEO plugins can't overwrite them.)

?>
