<?php
require_once('third-party/truncate-html.php');  # Includes truncateHtml function
require_once('functions/base.php');   			# Base theme functions
require_once('functions/feeds.php');			# Where functions related to feed data live
require_once('custom-taxonomies.php');  		# Where per theme taxonomies are defined
require_once('custom-post-types.php');  		# Where per theme post types are defined
require_once('functions/admin.php');  			# Admin/login functions
require_once('functions/config.php');			# Where per theme settings are registered
require_once('shortcodes.php');         		# Per theme shortcodes


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
function get_page_subheader( $post ) {
	ob_start();

	$subheader = get_post_meta( $post->ID, 'page_subheader', true );

	if ( $subheader ) {
		$subheader_post = get_post( $subheader );
		$sub_img = get_post_meta( $subheader, 'subheader_sub_image', true );
		$sub_img_atts = array(
			'class'	=> 'subheader-subimg',
			'alt'   => $post->post_title,
			'title' => $post->post_title,
		);
		$student_name = get_post_meta( $subheader, 'subheader_student_name', true );
		$student_img = get_post_meta( $subheader, 'subheader_student_image', true );
		$student_img_atts = array(
			'class'	=> 'subheader-studentimg',
			'alt'   => get_post_meta( $subheader, 'subheader_student_name', true ),
			'title' => get_post_meta( $subheader, 'subheader_student_name', true ),
		);
	?>
		<div class="col-md-12 col-sm-12">
			<div id="subheader" role="complementary">
				<div class="row">
					<div class="col-md-2 col-sm-2">
						<?php echo wp_get_attachment_image( $sub_img, 'subpage-subimg', 0, $sub_img_atts ); ?>
					</div>
					<div class="col-md-8 col-sm-8">
						<blockquote class="subheader-quote">
							<?php echo $subheader_post->post_content; ?>
							<p class="subheader-author text-right"><?php echo $student_name; ?></p>
						</blockquote>
					</div>
				</div>
				<?php echo wp_get_attachment_image( $student_img, 'subpage-studentimg', 0, $student_img_atts ); ?>
			</div>
		</div>
	<?php
	}

	return ob_get_clean();
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
function print_announcements($announcements, $liststyle='thumbtacks', $spantype='col-md-4 col-sm-4', $perrow=3) {
	switch ($liststyle) {
		case 'list':
			print '<ul class="announcement_list list-unstyled">';
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
			$output .= '<title>'.htmlentities($announcement->post_title, ENT_COMPAT, 'UTF-8', false).'</title>';
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
						$keywords .= htmlentities($keyword, ENT_COMPAT, 'UTF-8', false) .', ';
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
 * Query the undergraduate catalog feed
 * @return array
 * @author Jo Dickson
 **/
function query_undergraduate_catalog() {
	$results = array();
	try {
		$context = stream_context_create(array(
			'http' => array(
				'method'  => 'GET',
				'timeout' => UNDERGRADUATE_CATALOG_FEED_HTTP_TIMEOUT
		)));
		$feed_url = UNDERGRADUATE_CATALOG_FEED_URL;
		$response   = file_get_contents($feed_url, false, $context);
		$json       = json_decode($response);
		if(isset($json->programs)) $results = $json->programs;
	} catch (Exception $e) {
		#pass
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
 * Prints the Cloud.Typography font stylesheet <link> tag.
 **/
function webfont_stylesheet() {
	$css_key = get_theme_option( 'cloud_font_key' );
	if ( $css_key ) {
		echo '<link rel="stylesheet" href="'. $css_key .'" type="text/css" media="all" />';
	}
}


/**
 * Output the CSS key for Cloud.Typography web fonts if a CSS key is set in
 * Theme Options.
 * Is included conditionally per-page to prevent excessive hits on our Cloud.Typography
 * page view limit per month.
 **/
function page_specific_webfonts( $pageid ) {
	if ( get_post_meta( $pageid, 'page_use_webfonts', True ) == 'on' ) {
		webfont_stylesheet();
	}
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
 *
 * Used by degree-list shortcode (Degree::objectsToHTML)
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
 * Returns a sorted array of grouped degrees by program (grouped by group_posts_by_tax_terms().)
 * Uses the order defined by DEGREE_PROGRAM_ORDER in functions/config.php.
 *
 * Used by degree-list shortcode (Degree::objectsToHTML)
 **/
function sort_grouped_degree_programs($posts) {
	$slugs = unserialize(DEGREE_PROGRAM_ORDER);
	$ids = array();
	foreach ($slugs as $slug) {
		$term = get_term_by('slug', $slug, 'program_types');
		if ($term) {
			$ids[] = intval($term->term_id);
		}
	}

	uksort($posts, function($a, $b) use ($ids) {
		return array_search($a, $ids) < array_search($b, $ids) ? -1 : 1;
	});
	return $posts;
}


/**
 * Generates page <title> tag for Degree Program post type.
 **/
function wp_title_degree_programs($title, $separator) {
	global $post;

	if ($post->post_type == 'degree') {
		$title = 'Degree Program '.$separator.' '.single_post_title('', FALSE);
	}

	return $title;
}
add_filter('wp_title', 'wp_title_degree_programs', 11, 2); // Allow overriding by SEO plugins


/**
 * Generates text used in page <title> for Degree Search based on current filters/search val.
 **/
function get_degree_search_title( $separator='|', $params=null ) {
	$title = 'Degree Search';

	$params = degree_search_params_or_fallback( $params );

	if ( !empty( $params ) ) {
		if ( isset( $params['search-query'] ) ) {
			$title = htmlspecialchars( urldecode( $params['search-query'] ) ) . ' ' . $title;
		}

		$title .= ' '. $separator . ' Top ';

		if ( isset( $params['program-type'] ) ) {
			$count = count( $params['program-type'] );
			foreach ( $params['program-type'] as $index=>$program_slug ) {
				$program = get_term_by( 'slug', $program_slug, 'program_types' );
				$program_name = str_replace( ' Degree', '', $program->name );
				if ( $count == 1 ) {
					$title .= $program_name;
				} else if ( $index == ( $count - 1 ) ) {
					$title = substr_replace( $title, '', -1 );
					$title .= ' and ' . $program_name;
				} else {
					$title .= $program_name . ', ';
				}
			}
		}

		if ( isset( $params['college'] ) ) {
			$title .= ', ';
			$count = count( $params['college'] );
			foreach ( $params['college'] as $index=>$college_slug ) {
				$college = get_term_by( 'slug', $college_slug, 'colleges' );
				$college_name = str_replace( 'College of ', '', $college->name );
				if ( $count == 1 ) {
					$title .= $college_name . ' ';
				} else if ( $index == ( $count - 1 ) ) {
					$title = substr_replace( $title, '', -2 );
					$title .= ' and ' . $college_name;
				} else {
					$title .= $college_name . ', ';
				}
			}
		}

		$title .= ' Degrees';

		if ( isset( $params['sort-by'] ) && $params['sort-by'] == 'degree_hours' ) {
			$title .= ', sorted by total credit hours';
		}

		if ( substr( $title, -2 ) == ', ' ) {
			$title = substr_replace( $title, '', -2 );
		}
	}

	return $title;
}


/**
 * Generates text used in page meta description for Degree Search based on
 * current filters/search val.
 **/
function get_degree_search_meta_description( $params=null ) {
	// Opening
	$retval  = 'The University of Central Florida offers';

	$params = degree_search_params_or_fallback( $params );

	if ( isset( $params['search-query'] ) ) {
		$retval .= ' ' . html_entity_decode( $params['search-query'] ) . ' Degrees';
	}

	if ( isset( $params['program-type'] ) ) {
		$retval .= ' and many other';
		$programs = array_intersect( $params['program-type'], array( 'undergraduate-degree', 'graduate-degree' ) );
		$count = count( $programs );
		foreach( $programs as $index=>$program_slug ) {
			$program = get_term_by( 'slug', $program_slug, 'program_types' );
			$program = str_replace( ' Degree', '', $program->name );
			if ( $count == 1 ) {
				$retval .= ' ' . $program;
			} else if ( $index == ( $count - 1 ) ) {
				$retval = substr_replace( $retval, '', -1 );
				$retval .= ' and ' . $program;
			} else {
				$retval .= ' ' . $program . ',';
			}
		}
	}

	if ( isset( $params['college'] ) ) {
		$count = count ( $params['college'] );
		foreach( $params['college'] as $index=>$college_slug ) {
			$college = get_term_by( 'slug', $college_slug, 'colleges' );
			$college = str_replace( 'College of ', '', $college->name );
			if ( $count == 1 ) {
				$retval .= ' ' . $college;
			} else if ( $index == ( $count - 1 ) ) {
				$retval = substr_replace( $retval, '', -1 );
				$retval .= ' and ' . $college;
			} else {
				$retval .= ' ' . $college . ',';
			}
		}
	}

	$retval .= ' Degrees';

	$retval .= ' | Major, Minor, Masters, Certificate and PhD Programs | Campuses Located in Orlando, Florida Universities and Colleges';

	return $retval;
}


/**
 * Generates <title> tag for Degree Search page.
 **/
function wp_title_degree_search( $title, $separator ) {
	global $post;
	if ( $post->ID == get_page_by_title( 'Degree Search' )->ID ) {
		$custom_title = get_degree_search_title( $separator );
		return $custom_title;
	}
	return $title;
}
add_filter( 'wp_title', 'wp_title_degree_search', 99, 2 ); // Force these page titles (SEO plugins can't overwrite them.)


/**
 * Generates page <meta name="description"> tag for Degree Search Views. Hooks into Yoast SEO api.
 **/
function header_meta_degree_search($str) {
	global $post;

	if ( $post->ID == get_page_by_title('Degree Search')->ID ) {
		$custom_meta = get_degree_search_meta_description();
		return $custom_meta;
	}
	return $str;
}
add_filter('wpseo_metadesc', 'header_meta_degree_search', 10, 1);


/**
 * Helper function that returns the first item in a numeric array.
 **/
function get_first_result( $array_result ) {
	if ( is_array( $array_result ) && count( $array_result ) > 0 ) {
		return $array_result[0];
	}
	return $array_result;
}


/**
 * Appends degree metadata to a post object.
 **/
function append_degree_metadata( $post, $tuition_data ) {
	$theme_options = get_option(THEME_OPTIONS_NAME);
	if ( $post && $post->post_type == 'degree' ) {
		$post->degree_hours                = get_post_meta( $post->ID, 'degree_hours', TRUE );
		$post->degree_description          = get_post_meta( $post->ID, 'degree_description', TRUE );
		$post->degree_phone                = get_post_meta( $post->ID, 'degree_phone', TRUE );
		$post->degree_email                = get_post_meta( $post->ID, 'degree_email', TRUE );
		$post->degree_website              = get_post_meta( $post->ID, 'degree_website', TRUE );
		$post->degree_pdf                  = get_post_meta( $post->ID, 'degree_pdf', TRUE );
		$post->degree_hide_tuition         = get_post_meta( $post->ID, 'degree_hide_tuition', TRUE );
		$post->degree_contacts             = Degree::get_degree_contacts( $post );
		$post->tax_college                 = get_first_result( wp_get_post_terms( $post->ID, 'colleges' ) );
		$post->tax_department              = get_first_result( wp_get_post_terms( $post->ID, 'departments' ) );
		$post->tax_program_type            = get_first_result( wp_get_post_terms( $post->ID, 'program_types' ) );

		if ( $tuition_data ) {
			$post->tuition_estimates = get_tuition_estimate( $post->tax_program_type, $post->degree_hours );
			$post->tuition_value_message = $theme_options['tuition_value_message'];
			$post->financial_aid_message = $theme_options['financial_aid_message'];

			switch( $post->tax_program_type->slug ) {
				case 'undergraduate-degree':
				case 'articulated-program':
				case 'minor':
					$post->tuition_credit_hours = intval( get_theme_option( 'tuition_undergrad_hours', TRUE ) );
					break;
				case 'graduate-degree':
					$post->tuition_credit_hours = intval( get_theme_option( 'tuition_grad_hours', TRUE ) );
					break;
				default:
					$post->tuition_credit_hours = intval( get_theme_option( 'tuition_undergrad_hours', TRUE ) );
					break;
			}
		}

		if ( empty( $post->degree_pdf ) ) {
			if ( Degree::is_graduate_program( $post ) ) {
				$post->degree_pdf = GRAD_CATALOG_URL;
			}
			else {
				$post->degree_pdf = UNDERGRAD_CATALOG_URL;
			}
		}

		// Append taxonomy term "meta"
		if ( isset( $post->tax_college ) && !empty( $post->tax_college ) && !is_wp_error( $post->tax_college ) ) {
			$post->tax_college->alias = get_term_custom_meta( $post->tax_college->term_id, 'colleges', 'college_alias' );
		}

		if ( isset( $post->tax_program_type ) ) {
			$post->tax_program_type->alias = get_term_custom_meta( $post->tax_program_type->term_id, 'program_types', 'program_type_alias' );
			$post->tax_program_type->color = get_term_custom_meta( $post->tax_program_type->term_id, 'program_types', 'program_type_color' );
		}
	}

	return $post;
}



function get_tuition_estimate( $program_type, $credit_hours ) {
	$theme_options = get_option(THEME_OPTIONS_NAME);
	// Documentation for this feed can be found at http://tuitionfees.ikm.ucf.edu/feed/
	$feed_url = $theme_options['tuition_fee_url'];
	$national_average = 0;

	if ( $program_type && $credit_hours ) {
		$program = '';
		switch( $program_type->slug ) {
			case 'undergraduate-degree':
			case 'minor':
			case 'articulated-program':
				$program = 'UnderGrad';
				break;
			case 'graduate-degree':
				$program = 'Grad';
				break;
			default:
				return null;
		}

		$query_string = http_build_query(
			array(
				'format' => 'json',
				'schoolYear' => 'current',
				'feeType' => 'SCH',
				'program' => $program
			)
		);

		$feed_url .= '/?' . $query_string;

		$opts = array(
			'http' => array(
				'method' => 'GET',
				'timeout' => 5
			)
		);

		$context = stream_context_create( $opts );

		$json = file_get_contents( $feed_url, false, $context );

		if ( $json ) {
			$fees = json_decode( $json );

			if ( !empty( $fees ) ) {
				$in_state_estimated_fees = 0;
				$out_of_state_estimated_fees = 0;

				foreach ( $fees as $fee ) {
					if ( strpos($fee->FeeName, '(Per Hour)' ) == false ) {
						$in_state_estimated_fees += $fee->ResidentFee;
						$out_of_state_estimated_fees += $fee->NonResidentFee;
					}
				}

				return array(
					'in_state_rate' => $in_state_estimated_fees,
					'out_of_state_rate' => $out_of_state_estimated_fees
				);
			}
		} else {
			return null;
		}
	}
}


function degree_search_with_keywords( $search, &$wp_query ) {
	if (
		isset( $wp_query->query_vars['s'] )
		&& !empty( $wp_query->query_vars['s'] )
		&& isset( $wp_query->query_vars['post_type'] )
		&& $wp_query->query_vars['post_type'] == 'degree'
	) {
		global $wpdb;

		if ( empty( $search ) ) {
			return $search;
		}

		$search_term = '%'.$wpdb->esc_like( $wp_query->query_vars[ 's' ] ).'%';

		$search = $wpdb->prepare( " AND (
			($wpdb->posts.post_title LIKE %s)
			OR ($wpdb->posts.post_content LIKE %s)
			OR EXISTS
			(
				SELECT * FROM $wpdb->terms
				INNER JOIN $wpdb->term_taxonomy
					ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id
				INNER JOIN $wpdb->term_relationships
					ON $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id
				WHERE taxonomy = 'degree_keywords'
					AND object_id = $wpdb->posts.ID
					AND $wpdb->terms.name LIKE %s
			)
		)", $search_term, $search_term, $search_term);
	}

	return $search;
}

add_filter( 'posts_search', 'degree_search_with_keywords', 500, 2 );


/**
 * Helper udiff function for returning the difference between two arrays of
 * post objects
 **/
function posts_array_diff( $post_1, $post_2 ) {
	return $post_1->ID - $post_2->ID;
}


/**
 * Handles the retrieval of Degree posts from WordPress for the Degree Search.
 **/
function fetch_degree_data( $params ) {
	$use_suggestions = false;
	$posts_all = $posts_suggested = array();
	$args = array(
		'numberposts' => -1,
		'offset' => 0,
		'post_type' => 'degree',
		'orderby' => 'title', // default sort by title
		'order' => 'ASC',
		'tax_query' => array(),
		's' => ''
	);

	if ( $params ) {
		if ( isset( $params['search-query'] ) ) {
			$args['s'] = htmlspecialchars( urldecode( $params['search-query'] ) );
			$use_suggestions = true;
		}

		if ( isset( $params['sort-by'] ) && $params['sort-by'] == 'degree_hours' ) {
			$args['meta_key'] = 'degree_hours';
			$args['orderby'] = 'meta_value_num title';
		}
	}

	// Fetch all posts to compare and create diff for suggested posts later
	if ( $use_suggestions ) {
		$posts_all = get_posts( $args );
	}

	if ( $params ) {
		if ( isset( $params['college'] ) ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'colleges',
				'field' => 'slug',
				'terms' => $params['college'],
				'include_children' => false
			);
		}

		if ( isset( $params['program-type'] ) ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'program_types',
				'field' => 'slug',
				'terms' => $params['program-type'],
				'include_children' => false
			);
		}

		if ( isset( $params['tax_query'] ) && count( $params['tax_query'] ) > 1 ) {
			$args['tax_query']['relation'] = 'AND';
		}

	}

	$posts = get_posts( $args );
	if ( $use_suggestions ) {
		$posts_suggested = array_udiff( $posts_all, $posts, 'posts_array_diff' );
	}

	$result_count_total = count( $posts );
	$suggestion_count_total = count( $posts_suggested );

	$posts_grouped = $suggestions_grouped = array();

	// Get array of IDs of groupable program types
	$groupable_types_slugs = unserialize( DEGREE_PROGRAM_ORDER );
	$groupable_types = array();
	if ( $groupable_types_slugs ) {
		foreach ( $groupable_types_slugs as $slug ) {
			$term = get_term_by( 'slug', $slug, 'program_types' );
			$groupable_types[] = $term->term_id;
		}
	}
	else {
		$groupable_types = null;
	}

	// Group posts
	if ( $posts ) {
		foreach ( $posts as $post ) {
			$degree = append_degree_metadata( $post, false );
		}

		$posts_grouped = sort_grouped_degree_programs( group_posts_by_tax_terms( 'program_types', $posts, $groupable_types ) );
	}

	// Group suggested
	if ( $posts_suggested ) {
		foreach ( $posts_suggested as $post ) {
			$degree = append_degree_metadata( $post, false );
		}

		$suggestions_grouped = sort_grouped_degree_programs( group_posts_by_tax_terms( 'program_types', $posts_suggested, $groupable_types ) );
	}


	return array(
		'results' => $posts_grouped,
		'suggestions' => $suggestions_grouped,
		'result_count_total' => $result_count_total,
		'suggestion_count_total' => $suggestion_count_total
	);
}


/**
 * Returns markup for "x results found" at top of Degree Search results.
 **/
function get_degree_search_result_phrase( $result_count_total, $params ) {
	ob_start();
?>
	<span class="degree-result-count-num"><?php echo $result_count_total; ?></span>

	<?php
	// Search query phrasing
	if ( isset( $params['search-query'] ) ): ?>
	<span class="search-result">&ldquo;<?php echo htmlspecialchars( urldecode( $params['search-query'] ) ); ?>&rdquo;</span>
	<?php endif; ?>

	<span class="degree-result-phrase-desktop">degree program<?php if ( $result_count_total !== 1 ): ?>s<?php endif; ?> found</span>
	<span class="degree-result-phrase-phone">result<?php if ( $result_count_total !== 1 ): ?>s<?php endif; ?>:</span>

	<?php
	// Program Type phrasing
	if ( isset( $params['program-type'] ) ):
	?>
	<span class="for">in </span>
		<?php
		$count = 1;
		foreach ( $params['program-type'] as $program_slug ):
			$program = get_term_by( 'slug', $program_slug, 'program_types' );
			$program_name = $program->name;
		?>
			<span class="result <?php echo $program_slug; ?>">
				<span class="close" data-filter-class="program-type" data-filter-value="<?php echo $program_slug; ?>"></span>
				<?php echo $program_name; ?>s
			</span>
			<?php if ( $count < count( $params['program-type'] ) ): ?>
				<span class="for"> | </span>
			<?php
			endif;
			$count++;
			?>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php
	// Colleges phrasing
	if ( isset( $params['college'] ) ):
	?>
	<span class="for">at the </span>
		<?php
		$count = 1;
		foreach ( $params['college'] as $college_slug ):
		?>
			<span class="result">
				<span class="close" data-filter-class="college" data-filter-value="<?php echo $college_slug; ?>"></span>
				<?php
					echo get_term_by( 'slug', $college_slug, 'colleges' )->name;
				?>
			</span>
			<?php if ( $count < count( $params['college'] ) ): ?>
				<span class="for"> | </span>
			<?php
			endif;
			$count++;
			?>
		<?php endforeach; ?>
		<a href="<?php echo get_permalink( get_page_by_title( 'Degree Search' ) ); ?>" class="reset-search">Clear All</a>
	<?php else: ?>
		<span class="for">at UCF</span>
	<?php endif; ?>
<?php
	return ob_get_clean();
}


/**
 * Returns markup for "search again" at the bottom of Degree Search results.
 **/
function get_degree_search_search_again( $filters, $params ) {
	ob_start();
	if ( isset( $params['search-query'] ) ): ?>
		<div class="degree-search-again-container">
			<p class="degree-search-similar">
				Try your search again for <strong>&ldquo;<?php echo htmlspecialchars( urldecode( $params['search-query'] ) ); ?>&rdquo;</strong> filtered by degree type:
			</p>
			<?php foreach ( $filters as $key=>$filter ): ?>
				<?php if ( $filter['name'] == 'Degrees'): ?>
					<?php foreach ( $filter['terms'] as $term ): ?>
						<?php
						if ( $term->count > 0 ):
							$query = http_build_query( array(
								$key . '[]' => $term->slug,
								'search-query' => $params['search-query']
							) );
						?>
							<a class="search-again-link <?php echo $term->slug; ?>" href="<?php echo get_permalink( get_page_by_title( 'Degree Search' ) ); ?>?<?php echo $query; ?>" data-<?php echo $key; ?>="<?php echo $term->slug; ?>" data-search-term="<?php echo htmlspecialchars( urldecode( $params['search-query'] ) ); ?>">
								<?php echo $term->name; ?>s
							</a>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	<?php endif;
	return ob_get_clean();
}


/**
 * Returns relevant params passed in, or available relevant $_GET params.
 * Initial backend requests should pass in $params; ajax requests for
 * degree search data will not (use $_GET instead).
 *
 * Removes empty parameters.
 **/
function degree_search_params_or_fallback( $params ) {
	if ( empty( $params ) ) {
		// Force default view params
		if ( empty( $_GET ) ) {
			$params = unserialize( DEGREE_SEARCH_DEFAULT_PARAMS );
		}
		// Force default search view params (search results triggered immediately from the default view)
		else if ( isset( $_GET['search-default'] ) && intval( $_GET['search-default'] ) === 1 ) {
			$params = unserialize( DEGREE_SEARCH_S_DEFAULT_PARAMS );
			$params['search-query'] = $_GET['search-query'];
		}
		else {
			$params = $_GET;
		}
	}

	$valid_params = unserialize( DEGREE_SEARCH_PARAMS );
	$filtered_params = array();

	// Eliminate any parameters not listed in the set of valid params.
	// Set defaults if some passed param value isn't set.
	foreach ( $valid_params as $key => $val ) {
		if ( isset( $params[$key] ) ) {
			$filtered_params[$key] = $params[$key];
		}
		else {
			$filtered_params[$key] = $valid_params[$key];
		}
	}

	// Return params with any empty values removed (maintain 0).
	return array_filter( $filtered_params, function( $val ) {
		return ( $val || is_numeric( $val ) );
	} );
}

function get_hiearchical_degree_search_data_json() {
	// Define which of our Program types are valid.  (These are highest-level parent terms
	// of the Program Type taxonomy.)
	$all_program_type_parents = array('undergraduate-program', 'graduate-program');
	// Define which of our Degree types are valid.  (These are the 2nd level terms of
	// the Program Type taxonomy.)
	$all_degree_types = array('undergraduate-degree', 'minor', 'graduate-degree', 'certificate');
	// Determine some variables based on query args.  Set defaults if no values are set.
	$program_type	     = in_array($_GET['program_type'], $all_program_type_parents) ? $_GET['program_type'] : 'undergraduate-program';
	$degree_type	     = in_array($_GET['degree_type'], $all_degree_types) ? $_GET['degree_type'] : 'undergraduate-degree';
	$orderby		     = $_GET['orderby'] ? $_GET['orderby'] : 'title';
	$order			     = ($_GET['order'] == 'ASC' || $_GET['order'] == 'DESC') ? $_GET['order'] : 'ASC';
	$flip_order		     = ($order == 'ASC') ? 'DESC' : 'ASC'; // opposite of $order
	$get_child_programs  = $_GET['get_child_programs'] ? (boolean)$_GET['get_child_programs'] : true;
	/*
	 * Get Taxonomy term(s) based on get_child_programs
	*/
	$to_json = array();
	$default_args = array(
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
				'include_children' => false // Make sure we get Undergraduate Degree children (Articulated/Accelerated)
			),
		),
	);
	$degree = get_term_by('slug', $degree_type, 'program_types');
	$posts = get_posts($default_args);
	$to_json[$degree_type] = array(
		'program_type_id' => $degree->term_id,
		'program_type_name' => $degree->name,
		'program_type_slug' => $degree->slug
	);
	foreach($posts as $post) {
		$to_json[$degree_type]['posts'][] = array(
			'degree_name' => $post->post_title,
			'degree_description' => get_post_meta($post->ID, 'degree_description', true),
			'degree_content' => $post->post_content,
			'degree_required_hours' => get_post_meta($post->ID, 'degree_hours', true),
			'degree_website' => get_post_meta($post->ID, 'degree_website', true),
			'degree_pdf' => get_post_meta($post->ID, 'degree_pdf', true),
			'degree_phone' => get_post_meta($post->ID, 'degree_phone', true),
			'degree_email' => get_post_meta($post->ID, 'degree_email', true),
			'degree_content' => $post->post_content,
			'degree_permalink' => get_permalink($post->ID)
		);
	}
	if ($get_child_programs) {
		$children = get_term_children($degree->term_id, 'program_types');
		foreach($children as $child) {
			$args = array(
				'tax_query' => array(
					array(
						'taxonomy' => 'program_types',
						'field' => 'id',
						'terms' => $child,
						'include_children' => false
					)
				)
			);
			$args = array_merge($default_args, $args);
			$child_posts = get_posts($args);
			$child_obj = get_term($child, 'program_types');
			$to_json[$degree_type]['children'][$child_obj->slug] = array(
				'program_type_id' => $child_obj->term_id,
				'program_type_name' => $child_obj->name,
				'program_type_slug' => $child_obj->slug
			);
			foreach($child_posts as $post) {
				$to_json[$degree_type]['children'][$child_obj->slug]['posts'][] = array(
					'degree_name' => $post->post_title,
					'degree_description' => get_post_meta($post->ID, 'degree_description', true),
					'degree_content' => $post->post_content,
					'degree_required_hours' => get_post_meta($post->ID, 'degree_hours', true),
					'degree_website' => get_post_meta($post->ID, 'degree_website', true),
					'degree_pdf' => get_post_meta($post->ID, 'degree_pdf', true),
					'degree_phone' => get_post_meta($post->ID, 'degree_phone', true),
					'degree_email' => get_post_meta($post->ID, 'degree_email', true),
					'degree_content' => $post->post_content,
					'degree_permalink' => get_permalink($post->ID)
				);
			}
		}
	}
	return $to_json;
}

/**
 * Returns markup for a degree list item in Degree Search results.
 * Assumes $degree objects have already been passed through append_degree_metadata()
 * (via fetch_degree_data()).
 * Intended for use in get_degree_search_contents().
 **/
function get_degree_search_listitem_markup( $degree, $program_alias, $program_name ) {
	ob_start();
?>
	<li class="degree-search-result">
		<h3 class="degree-title-heading">
			<a class="ga-event clearfix degree-title-wrap" data-ga-category="Degree Search" data-ga-action="Search Result Clicked" data-ga-label="<?php echo $degree->post_title; ?>" href="<?php echo get_permalink( $degree ); ?>">
				<span class="degree-title">
					<?php echo $degree->post_title; ?>
				</span>
				<span class="degree-details">
					<span class="degree-program-type visible-xs">
						<?php echo ( !empty( $program_alias ) ) ? $program_alias : $program_name; ?>
					</span>
					<span class="visible-xs degree-details-separator">&verbar;</span>
					<span class="degree-credits-count">
					<?php if ( $degree->degree_hours ): ?>
						<span class="number <?php echo $program_slug; ?>"><?php echo $degree->degree_hours; ?></span> credit hours
					<?php else: ?>
						See catalog for credit hours
					<?php endif; ?>
					</span>
				</span>
			</a>
		</h3>
	</li>
<?php
	return ob_get_clean();
}


/**
 * Returns all data and markup necessary for the Degree Search.  Used via
 * both ajax requests and on initial page load in page-degree-search.php.
 **/
function get_degree_search_contents( $return=false, $params=null ) {
	if ( !defined( 'WP_USE_THEMES' ) ) {
		define( 'WP_USE_THEMES', false );
	}

	$params = degree_search_params_or_fallback( $params );
	$query_params = http_build_query( $params );

	$data = fetch_degree_data( $params );
	extract( $data ); // import $results, $suggestions, $result_count_total and $suggestion_count_total

	$college_name = null;
	if ( isset( $params['college'] ) && count( $params['college'] ) == 1 ) {
		$college_name = get_term_by( 'slug', $params['college'][0], 'colleges' )->name;
	}

	$no_results = '';
	$offset_start = intval( $params['offset'] ); // Pagination offset start
	$offset_end = $offset_start + DEGREE_SEARCH_PAGE_COUNT; // Pagination offset end
	$result_count_start = $offset_start + 1; // Results per page start
	$result_count_end = $offset_start; // Results per page end (will increment when results are looped through.)
	$count_all = $result_count_total + $suggestion_count_total; // Totals of results and suggestions combined. Used for showing pagination
	$count = 0; // Internal counter used in degree result loops and for handling display of suggestions

	if ( $results ) {
		$markup = '';

		$degree_list_markup = '';

		// This loop will always loop through *all* results.  $count is NOT
		// representative of the result count per page.
		foreach ( $results as $program_type_id => $degrees ) {
			$program_name = get_term( $program_type_id, 'program_types' )->name;
			$program_slug = get_term( $program_type_id, 'program_types' )->slug;
			$program_alias = get_term_custom_meta( $program_type_id, 'program_types', 'program_type_alias' );

			$degree_markup = '';

			foreach ( $degrees as $degree ) {
				if( $count >= $offset_start && $count < $offset_end ) {
					$degree_markup .= get_degree_search_listitem_markup( $degree, $program_alias, $program_name );
					$result_count_end++;
				}
				$count++;
			}

			if ( !empty( $degree_markup ) ) {
				$group_name = !empty( $program_alias ) ? $program_alias . 's' : $program_name . 's';
				if ( $college_name ) {
					$group_name = $group_name . ' <small>at the ' . $college_name .'</small>';
				}
				$degree_list_markup .= '<h2 class="degree-search-group-title">' . $group_name . '</h2>';
				$degree_list_markup .= '<ul class="degree-search-results">'.$degree_markup.'</ul>';
			}
		}

		if ( !empty( $degree_list_markup ) ) {
			$markup .= $degree_list_markup;
			$markup .= '<p class="degree-search-result-showing">Showing ' . $result_count_start . '&mdash;' . $result_count_end . ' of ' . $result_count_total . ' results.</p>';
		}
	} else {
		$no_results = 'No results found';
		if ( isset( $params['search-query'] ) ) {
			$no_results .= ' for <strong>&ldquo;'. htmlspecialchars( urldecode( $params['search-query'] ) ) .'&rdquo;</strong>';
		}
		$no_results .= '.';
	}

	// Add suggestions
	if ( $suggestions && $count < $offset_end ) {

		$suggestion_markup = '';

		foreach ( $suggestions as $program_type_id => $degrees ) {
			$program_name = get_term( $program_type_id, 'program_types' )->name;
			$program_slug = get_term( $program_type_id, 'program_types' )->slug;
			$program_alias = get_term_custom_meta( $program_type_id, 'program_types', 'program_type_alias' );

			$degree_markup = '';
			foreach ( $degrees as $degree ) {
				if( $count >= $offset_start && $count < $offset_end ) {
					$degree_markup .= get_degree_search_listitem_markup( $degree, $program_alias, $program_name );
				}
				$count++;
			}

			if ( !empty( $degree_markup ) ) {
				$group_name = !empty( $program_alias ) ? $program_alias . 's' : $program_name . 's';
				$suggestion_markup .= '<h2 class="degree-search-group-title">' . $group_name . '</h2>';
				$suggestion_markup .= '<ul class="degree-search-results">'.$degree_markup.'</ul>';
			}
		}

		if ( !empty( $suggestion_markup ) ) {
			$plural = '';
			if( $suggestion_count_total > 1 ) {
				$plural = 's';
			}
			$markup .= '<div class="degree-search-suggestions">';
			$markup .= '<p class="degree-search-suggestions-phrase">'. $no_results . '&nbsp;&nbsp;' . $suggestion_count_total .' similar result' . $plural . ' found:</p>';
			$markup .= $suggestion_markup;
			$markup .= '</div>';
		}
	} elseif ( !empty( $no_results ) ) {
			$markup .= '<div class="degree-search-no-results">';
			$markup .= '<p class="degree-search-suggestions-phrase">'. $no_results . '</p>';
			$markup .= '</div>';
	}

	// Add Pagination
	if( $count_all > DEGREE_SEARCH_PAGE_COUNT ) {

		$markup .= '<ul class="pager">';

		$prev_link = '';
		if( $offset_start > 0 ) {
			$prev_params = $params;
			$prev_params['offset'] = $prev_params['offset'] - DEGREE_SEARCH_PAGE_COUNT;
			$prev_link = '?'.http_build_query( $prev_params );
			$markup .= '<li class="previous"><a href="'.$prev_link.'">&larr; Previous</a></li>';
		}
		else {
			$markup .= '<li class="previous disabled"><span>&larr; Previous</span></li>';
		}

		$next_link = '';
		if( $offset_end < $count_all && $count <= $count_all ) {
			$next_params = $params;
			$next_params['offset'] = $next_params['offset'] + DEGREE_SEARCH_PAGE_COUNT;
			$next_link = '?'.http_build_query( $next_params );
			$markup .= '<li class="next"><a href="'.$next_link.'">Next &rarr;</a></li>';
		}
		else {
			$markup .= '<li class="next disabled"><span>Next &rarr;</span></li>';
		}

		$markup .= '</ul>';

	}

	$markup = preg_replace( "@[\\r|\\n|\\t]+@", "", $markup );

	// Print results
	if ( $return ) {
		return array (
			'count' => $result_count_total,
			'markup' => $markup
		);
	} else {
		$result_title = get_degree_search_title( '|', $params );
		$result_meta = get_degree_search_meta_description( $params );
		$result_phrase_markup = get_degree_search_result_phrase( $result_count_total, $params );
		$result_search_again_markup = get_degree_search_search_again( get_degree_search_filters(), $params );

		wp_send_json(
			array(
				'querystring' => $query_params,
				'count' => $result_phrase_markup,
				'searchagain' => $result_search_again_markup,
				'markup' => $markup,
				'title' => $result_title,
				'description' => $result_meta,
			)
		);
	}
}

add_action( 'wp_ajax_degree_search', 'get_degree_search_contents' );
add_action( 'wp_ajax_nopriv_degree_search', 'get_degree_search_contents' );


/**
 * Orders program_types based on the DEGREE_PROGRAM_ORDER
 * setting found in functions/config.php.
 * NOTE: For this filter to be applied, get_terms must
 * include the taxonomy 'program_types' and an orderby
 * of degree_program_order.
 * @return array
 * @author Jim Barnes
 **/
function order_program_types( $clauses, $taxonomies, $args ) {
	if ( in_array('program_types', $taxonomies )
		&& $args['orderby'] == 'degree_program_order' ) {
		$slugs = implode('", "', unserialize(DEGREE_PROGRAM_ORDER));
		$clauses['orderby'] = 'ORDER BY FIELD (t.slug,' . '"' . $slugs . '")';
	}
	return $clauses;
}

add_filter( 'terms_clauses', 'order_program_types', 1, 3 );


/**
 * Returns an array of degree titles, for use by the degree search
 * autocomplete field.
 **/
function get_degree_search_suggestions() {
	$suggestions = array();
	$posts = get_posts( array(
		'numberposts' => -1,
		'post_type' => 'degree'
	) );

	if ( $posts ) {
		foreach ( $posts as $post ) {
			$suggestions[] = $post->post_title;
		}
	}

	return array_values( array_unique( $suggestions ) );
}


/**
 * Returns an array containing arrays of term objects, for use in
 * Degree Search filter lists.
 **/
function get_degree_search_filters() {
	$filters = array();

	$filters['program-type']['name'] = 'Degrees';
	$filters['college']['name'] = 'Sort by College';

	$colleges = get_terms( 'colleges', array( 'orderby' => 'name', 'order' => 'desc' ) );
	if ( $colleges ) {
		foreach ( $colleges as $college ) {
			$alias = get_term_custom_meta( $college->term_id, 'colleges', 'college_alias' );
			if ( $alias ) {
				$college->alias = $alias;
			}
			$college->field_type = 'radio';
		}
		// If aliases are available, alphabetize by them
		usort( $colleges, function( $a, $b ) {
			$a_name = isset( $a->alias ) ? $a->alias : $a->name;
			$b_name = isset( $b->alias ) ? $b->alias : $b->name;
			return strcmp( $a_name, $b_name );
		} );
	}

	$program_types = get_terms( 'program_types', array( 'orderby' => 'degree_program_order' ) );
	foreach ( $program_types as $program ) {
		$program->field_type = 'checkbox';
	}

	// Pass orderby degree_program_order to ensure our custom filter is used.
	$filters['program-type']['terms'] = $program_types;
	$filters['college']['terms'] = $colleges;

	return $filters;
}


/**
 * Return's a term's custom meta value by key name.
 * Assumes that term data are saved as options using the naming schema
 * 'tax_<taxonomy slug>_<term id>'
 **/
function get_term_custom_meta( $term_id, $taxonomy, $key ) {
	if ( empty( $term_id ) || empty( $taxonomy ) || empty( $key ) ) {
		return false;
	}

	$term_meta = get_option( 'tax_' . $taxonomy . '_' . $term_id );
	if ( $term_meta && isset( $term_meta[$key] ) ) {
		$val = $term_meta[$key];
	}
	else {
		$val = false;
	}
	return stripslashes( $val );
}


/**
 * Saves a term's custom meta data.
 *
 * Assumes that term data are saved as options using the naming schema
 * 'tax_<taxonomy slug>_<term id>', and that term data is included in
 * Add New/Update <taxonomy> forms with inputs that have a name and ID
 * of 'term_meta[]'; e.g. '<input name="term_meta[my_custom_meta]" ..>'
 *
 * This function should be called on edited_<taxonomy> and create_<taxonomy>.
 * It saves all metadata following the term_meta[...] naming structure, so it
 * should only be hooked into edited_<taxonomy> and create_<taxonomy> once per
 * taxonomy.
 **/
function save_term_custom_meta( $term_id, $taxonomy ) {
	if ( isset( $_POST['term_meta'] ) ) {
		$option_name = 'tax_' . $taxonomy . '_' . strval( $term_id );
		$term_meta = get_option( $option_name );
		$term_keys = array_keys( $_POST['term_meta'] );
		foreach ( $term_keys as $key ) {
			if ( isset( $_POST['term_meta'][$key] ) ) {
				$term_meta[$key] = stripslashes( wp_filter_post_kses( addslashes( $_POST['term_meta'][$key] ) ) );
			}
		}
		// Save the option array.
		update_option( $option_name, $term_meta );
	}
}


/**
 * Adds custom "meta fields" for College taxonomy terms.
 **/

// Prints label for college alias field.
function colleges_alias_label() {
	ob_start();
?>
	<label for="term_meta[college_alias]"><?php echo __( 'Alias' ); ?></label>
<?php
	return ob_get_clean();
}

// Prints field for college alias.
function colleges_alias_field( $value=null ) {
	ob_start();
?>
	<input type="text" name="term_meta[college_alias]" id="term_meta[college_alias]" <?php if ( $value ) { ?>value="<?php echo $value; ?>"<?php } ?>>
	<p class="description"><?php echo __( 'Specify a shorter name for this college; used in Degree Search filters.' ); ?></p>
<?php
	return ob_get_clean();
}

// Adds alias field to Add College form.
function colleges_add_alias_field() {
?>
	<div class="form-field">
		<?php echo colleges_alias_label(); ?>
		<?php echo colleges_alias_field(); ?>
	</div>
<?php
}
add_action( 'colleges_add_form_fields', 'colleges_add_alias_field', 10, 2 );

// Adds alias field to Edit College form.
function colleges_edit_alias_field( $term ) {
	$term_id = $term->term_id;
	$alias = get_term_custom_meta( $term_id, 'colleges', 'college_alias' );
?>
	<tr class="form-field">
		<th scope="row" valign="top">
			<?php echo colleges_alias_label(); ?>
		</th>
		<td>
			<?php echo colleges_alias_field( $alias ); ?>
		</td>
	</tr>
<?php
}
add_action( 'colleges_edit_form_fields', 'colleges_edit_alias_field', 10, 2 );

// Prints label for college url field.
function colleges_url_label() {
	ob_start();
?>
	<label for="term_meta[college_url]"><?php echo __( 'URL' ); ?></label>
<?php
	return ob_get_clean();
}

// Prints field for college url.
function colleges_url_field( $value=null ) {
	ob_start();
?>
	<input type="text" name="term_meta[college_url]" id="term_meta[college_url]" <?php if ( $value ) { ?>value="<?php echo $value; ?>"<?php } ?>>
	<p class="description"><?php echo __( 'Specify where this college should link out to.' ); ?></p>
<?php
	return ob_get_clean();
}

// Adds url field to Add College form.
function colleges_add_url_field() {
?>
	<div class="form-field">
		<?php echo colleges_url_label(); ?>
		<?php echo colleges_url_field(); ?>
	</div>
<?php
}
add_action( 'colleges_add_form_fields', 'colleges_add_url_field', 10, 2 );

// Adds url field to Edit College form.
function colleges_edit_url_field( $term ) {
	$term_id = $term->term_id;
	$url = get_term_custom_meta( $term_id, 'colleges', 'college_url' );
?>
	<tr class="form-field">
		<th scope="row" valign="top">
			<?php echo colleges_url_label(); ?>
		</th>
		<td>
			<?php echo colleges_url_field( $url ); ?>
		</td>
	</tr>
<?php
}
add_action( 'colleges_edit_form_fields', 'colleges_edit_url_field', 10, 2 );

// Saves College url field value.
function save_colleges_custom_meta( $term_id ) {
	save_term_custom_meta( $term_id, 'colleges' );
}
add_action( 'edited_colleges', 'save_colleges_custom_meta', 10, 2 );
add_action( 'create_colleges', 'save_colleges_custom_meta', 10, 2 );

// Adds columns to existing Colleges term list.
function colleges_add_columns( $columns ) {
	$new_columns = array(
		'cb' => '<input type="checkbox" />',
		'name' => __('Name'),
		'alias' => __('Alias'),
		// 'description' => __('Description'),
		'slug' => __('Slug'),
		'url' => __('URL'),
		'posts' => __('Posts')
	);
	return $new_columns;
}
add_filter( 'manage_edit-colleges_columns', 'colleges_add_columns' );

// Adds content to Colleges columns
function colleges_render_columns( $out, $name, $term_id ) {
	switch ( $name ) {
		case 'alias':
			$alias = get_term_custom_meta( $term_id, 'colleges', 'college_alias' );
			if ( $alias ) {
				$out .= $alias;
			}
			else {
				$out .= '&mdash;';
			}
			break;
		case 'url':
			$url = get_term_custom_meta( $term_id, 'colleges', 'college_url' );
			if ( $url ) {
				$out .= '<a target="_blank" href="'. $url .'">'. $url .'</a>';
			}
			else {
				$out .= '&mdash;';
			}
			break;
		default:
			break;
	}
	return $out;
}
add_filter( 'manage_colleges_custom_column', 'colleges_render_columns', 10, 3);


/**
 * Adds custom "meta fields" for Program Types terms.
 **/

// Prints label for program type CTA field.
function program_types_cta_label() {
	ob_start();
?>
	<label for="term_meta[program_type_cta]"><?php echo __( 'Call to Action box content' ); ?></label>
<?php
	return ob_get_clean();
}

// Prints field for program type CTA.
function program_types_cta_field( $value=null ) {
	ob_start();
?>
	<textarea name="term_meta[program_type_cta]" class="large-text" cols="50" rows="5" id="term_meta[program_type_cta]"><?php if ( $value ) { echo esc_textarea( $value ); } ?></textarea>
	<p class="description"><?php echo __( 'Content that should be displayed in the Call to Action box, at the bottom of a program\'s description on its profile page.  HTML and shortcodes are permitted.' ); ?></p>
<?php
	return ob_get_clean();
}

// Adds CTA field to Add Program Type form.
function program_types_add_cta_field() {
?>
	<div class="form-field">
		<?php echo program_types_cta_label(); ?>
		<?php echo program_types_cta_field(); ?>
	</div>
<?php
}
add_action( 'program_types_add_form_fields', 'program_types_add_cta_field', 10, 2 );

// Adds CTA field to Edit Program Type form.
function program_types_edit_cta_field( $term ) {
	$term_id = $term->term_id;
	$cta = get_term_custom_meta( $term_id, 'program_types', 'program_type_cta' );
?>
	<tr class="form-field">
		<th scope="row" valign="top">
			<?php echo program_types_cta_label(); ?>
		</th>
		<td>
			<?php echo program_types_cta_field( $cta ); ?>
		</td>
	</tr>
<?php
}
add_action( 'program_types_edit_form_fields', 'program_types_edit_cta_field', 10, 2 );


// Prints label for program type color field.
function program_types_color_label() {
	ob_start();
?>
	<label for="term_meta[program_type_color]"><?php echo __( 'Color' ); ?></label>
<?php
	return ob_get_clean();
}

// Prints field for program type color.
function program_types_color_field( $value=null ) {
	ob_start();
?>
	<input type="text" name="term_meta[program_type_color]" id="term_meta[program_type_color]"<?php if ( $value ) { ?> value="<?php echo $value; ?>"<?php } ?>>
	<p class="description"><?php echo __( 'Specify a color that should represent this program type.  Avoid shades of blue, which is used in primary links in the Degree Search.' ); ?></p>
<?php
	return ob_get_clean();
}

// Adds color field to Add Program Type form.
function program_types_add_color_field() {
?>
	<div class="form-field">
		<?php echo program_types_color_label(); ?>
		<?php echo program_types_color_field(); ?>
	</div>
<?php
}
add_action( 'program_types_add_form_fields', 'program_types_add_color_field', 10, 2 );

// Adds color field to Edit Program Type form.
function program_types_edit_color_field( $term ) {
	$term_id = $term->term_id;
	$color = get_term_custom_meta( $term_id, 'program_types', 'program_type_color' );
?>
	<tr class="form-field">
		<th scope="row" valign="top">
			<?php echo program_types_color_label(); ?>
		</th>
		<td>
			<?php echo program_types_color_field( $color ); ?>
		</td>
	</tr>
<?php
}
add_action( 'program_types_edit_form_fields', 'program_types_edit_color_field', 10, 2 );


// Prints label for program type alias field.
function program_types_alias_label() {
	ob_start();
?>
	<label for="term_meta[program_type_alias]"><?php echo __( 'Alias' ); ?></label>
<?php
	return ob_get_clean();
}

// Prints field for program type alias.
function program_types_alias_field( $value=null ) {
	ob_start();
?>
	<input type="text" name="term_meta[program_type_alias]" id="term_meta[program_type_alias]"<?php if ( $value ) { ?> value="<?php echo $value; ?>"<?php } ?>>
	<p class="description"><?php echo __( 'Specify an alternate name for this program type.  Used in Degree Search result list items.' ); ?></p>
<?php
	return ob_get_clean();
}

// Adds alias field to Add Program Type form.
function program_types_add_alias_field() {
?>
	<div class="form-field">
		<?php echo program_types_alias_label(); ?>
		<?php echo program_types_alias_field(); ?>
	</div>
<?php
}
add_action( 'program_types_add_form_fields', 'program_types_add_alias_field', 10, 2 );

// Adds alias field to Edit Program Type form.
function program_types_edit_alias_field( $term ) {
	$term_id = $term->term_id;
	$alias = get_term_custom_meta( $term_id, 'program_types', 'program_type_alias' );
?>
	<tr class="form-field">
		<th scope="row" valign="top">
			<?php echo program_types_alias_label(); ?>
		</th>
		<td>
			<?php echo program_types_alias_field( $alias ); ?>
		</td>
	</tr>
<?php
}
add_action( 'program_types_edit_form_fields', 'program_types_edit_alias_field', 10, 2 );


// Saves Program Type custom field values.
function save_program_types_custom_meta( $term_id ) {
	save_term_custom_meta( $term_id, 'program_types' );
}
add_action( 'edited_program_types', 'save_program_types_custom_meta', 10, 2 );
add_action( 'create_program_types', 'save_program_types_custom_meta', 10, 2 );

// Adds columns to existing Program Type term list.
function program_types_add_columns( $columns ) {
	$new_columns = array(
		'cb' => '<input type="checkbox" />',
		'name' => __( 'Name' ),
		'alias' => __( 'Alias' ),
		'color' => __( 'Color' ),
		'cta' => __( 'Call to Action box' ),
		// 'description' => __( 'Description' ),
		'slug' => __( 'Slug' ),
		// 'url' => __( 'URL' ),
		'posts' => __( 'Posts' )
	);
	return $new_columns;
}
add_filter( 'manage_edit-program_types_columns', 'program_types_add_columns' );

// Adds content to Program Type columns
function program_types_render_columns( $out, $name, $term_id ) {
	switch ( $name ) {
		case 'alias':
			$alias = get_term_custom_meta( $term_id, 'program_types', 'program_type_alias' );
			if ( $alias ) {
				$out .= $alias;
			}
			else {
				$out .= '&mdash;';
			}
			break;
		case 'color':
			$color = get_term_custom_meta( $term_id, 'program_types', 'program_type_color' );
			if ( $color ) {
				$out .= '<span style="color: ' . $color . ';">' . $color . '</span>';
			}
			else {
				$out .= '&mdash;';
			}
			break;
		case 'cta':
			$cta = get_term_custom_meta( $term_id, 'program_types', 'program_type_cta' );
			if ( $cta ) {
				$out .= '<textarea disabled>' . esc_textarea( $cta ) . '</textarea>';
			}
			else {
				$out .= '&mdash;';
			}
			break;
	}
	return $out;
}
add_filter( 'manage_program_types_custom_column', 'program_types_render_columns', 10, 3);


/**
* Displays social buttons (Facebook, Twitter, G+) for a post.
* Accepts a post URL and title as arguments.
*
* @return string
* @author Jo Dickson
**/
function display_social( $url, $title, $subject_line='', $email_body='' ) {
	if ( !$subject_line ) {
		$subject_line = 'ucf.edu: ' . $title;
	}
	if ( !$email_body ) {
		$email_body = 'Check out this page on ucf.edu.';
	}

	ob_start();
?>
	<aside class="social clearfix">
		<a class="share-facebook" target="_blank" data-button-target="<?php echo $url; ?>" href="http://www.facebook.com/sharer.php?u=<?php echo $url; ?>" title="Like this on Facebook">
			Like "<?php echo $title; ?>" on Facebook
		</a>
		<a class="share-twitter" target="_blank" data-button-target="<?php echo $url; ?>" href="https://twitter.com/intent/tweet?text=<?php echo $subject_line; ?>&url=<?php echo $url; ?>" title="Tweet this">
			Tweet "<?php echo $title; ?>" on Twitter
		</a>
		<a class="share-googleplus" target="_blank" data-button-target="<?php echo $url; ?>" href="https://plus.google.com/share?url=<?php echo $url; ?>" title="Share this on Google+">
			Share "<?php echo $title; ?>" on Google+
		</a>
		<a class="share-linkedin" target="_blank" data-button-target="<?php echo $url; ?>" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url; ?>&title=<?php echo $subject_line; ?>" title="Share this on Linkedin">
			Share "<?php echo $title; ?>" on Linkedin
		</a>
		<a class="share-email" target="_blank" data-button-target="<?php echo $url; ?>" href="mailto:?subject=<?php echo $subject_line; ?>&amp;body=<?php echo $email_body; ?>%0A%0A<?php echo $url; ?>" title="Share this in an email">
			Share "<?php echo $title; ?>" in an email
		</a>
	</aside>
<?php
	return ob_get_clean();
}


/**
 * Recursively looks for a Program Type term's Call to Action text value.
 * If the provided term doesn't have one assigned, its parents are checked
 * until either a CTA value is found, or no more parents exist.
 **/
function get_program_type_cta( $term_id ) {
	$term = get_term( $term_id, 'program_types' );
	$cta_content = get_term_custom_meta( $term_id, 'program_types', 'program_type_cta' );
	if ( empty( $cta_content ) && $term->parent !== 0 ) {
		return get_program_type_cta( $term->parent );
	}
	return stripslashes( $cta_content );
}


/**
 * Displays a "Apply to <Degree Name>" Call to Action box.  For use at the
 * bottom of single Degree profiles.  Uses CTA box contents from the degree's
 * assigned Program Type, or that Program Type's parent(s) if one isn't
 * available.
 **/
function display_degree_callout( $degree_id ) {
	$program_type = get_first_result( wp_get_post_terms( $degree_id, 'program_types' ) );
	$cta_content = get_program_type_cta( $program_type->term_id );

	if ( empty( $cta_content ) ) {
		return;
	}

	ob_start();
?>
	<div class="cta-wrap well">
		<?php echo apply_filters( 'the_content', $cta_content ); ?>
	</div>
<?php
	return ob_get_clean();
}


/**
 * Redirect invalid requests related to Degree Search.
 * This redirect should only ever get hit if the user manually entered an
 * invalid URL, since all custom search views are generated via query params.
 **/
function degree_search_404_redirect() {
	$path = $_SERVER['REQUEST_URI'];
	$degree_search_page = get_page_by_title( 'Degree Search' );
	$degree_search_path = wp_make_link_relative( get_permalink( $degree_search_page ) );

	// Remove trailing slash
	if ( substr( $degree_search_path, -1 ) == '/' ) {
		$degree_search_path = substr( $degree_search_path, 0, -1 );
	}

	if ( is_404() && substr( $path, 0, strlen( $degree_search_path ) ) == $degree_search_path ) {
		wp_redirect( get_permalink( $degree_search_page ), 301 );
		exit();
	}
}
add_action( 'template_redirect', 'degree_search_404_redirect' );


/**
 * Creates an Announcement when a new Post An Announcement form entry is
 * submitted.
 *
 * This function assumes a form with ID of 4 already exists and has all form
 * fields/values configured already.
 **/
function announcement_post_save( $post_data, $form, $entry ) {
	if ( intval( $form['id'] ) == 4 ) {
		$post_data['post_type'] = 'announcement';
	}

	return $post_data;
}
add_action( 'gform_post_data', 'announcement_post_save', 10, 3 );


/**
 * Adds keywords and audience roles to a newly-created Announcement from the
 * Post an Announcement forn.
 *
 * This function assumes a form with ID of 4 already exists and has all form
 * fields/values configured already, and that desired Audience Role term values
 * have already been created.
 **/
function announcement_post_tax_save( $entry, $form ) {
	if( isset( $entry['post_id'] ) ) {
		$post = get_post( $entry['post_id'] );

		if ( $post ) {
			$keywords = $audience_roles = $entry_keywords = $entry_audience_roles = array();

			foreach ( $entry as $key => $val ) {
				if ( substr( $key, 0, 1 ) == '8.' && !empty( $val ) ) {
					$entry_audience_roles[] = trim( $val );
				}
				else if ( $key == '9' ) {
					$entry_keywords = explode( ',', $val );
				}
			}

			if ( !empty( $entry_audience_roles ) ) {
				foreach ( $entry_audience_roles as $role ) {
					// Check for an existing term.  If it doesn't already
					// exist, don't create a new one
					$role_term = get_term_by( 'name', $role, 'audienceroles', 'ARRAY_A' );
					if ( is_array( $role_term ) ) { // make sure we get a successful return
						$audience_roles[] = intval( $role_term['term_id'] );
					}
				}
			}
			if ( !empty( $entry_keywords ) ) {
				foreach ( $entry_keywords as $keyword ) {
					// Check for an existing term
					$keyword_term = get_term_by( 'name', $keyword, 'keywords', 'ARRAY_A' );
					if ( !$keyword_term ) {
						$keyword_term = wp_insert_term( $keyword, 'keywords' );
					}
					if ( is_array( $keyword_term ) ) { // make sure we get a successful return (not WP Error obj)
						$keywords[] = intval( $keyword_term['term_id'] );
					}
				}
			}

			if ( !empty( $audience_roles ) ) {
				wp_set_object_terms( $post->ID, $audience_roles, 'audienceroles' );
			}
			if ( !empty( $keywords ) ) {
				wp_set_object_terms( $post->ID, $keywords, 'keywords' );
			}
		}
	}
}
add_action( 'gform_after_submission_4', 'announcement_post_tax_save', 10, 2 );


/**
 * Allow json files to be uploaded to the media library.
 **/
function uploads_allow_json( $mimes ) {
	$mimes['json'] = 'application/json';
	return $mimes;
}
add_filter( 'upload_mimes', 'uploads_allow_json' );


/**
 * Conditional body class modifications.
 **/
function custom_body_classes( $classes ) {
	if ( !is_front_page() ) {
		$classes[] = 'subpage';
	}
	return $classes;
}
add_filter( 'body_class', 'custom_body_classes' );


/**
 * Enqueues page-specific javascript files.
 **/
function enqueue_page_js() {
	global $post;
	if ( $post && $post->post_type == 'page' && $js = get_post_meta( $post->ID, 'page_javascript', true ) ) {
		Config::add_script( wp_get_attachment_url( $js ) );
	}
}
add_action( 'wp_enqueue_scripts', 'enqueue_page_js' );


/**
 * Prints the Google Tag Manager snippet using the GTM ID in Theme Options.
 **/
function google_tag_manager() {
	ob_start();
	$gtm_id = get_theme_option( 'gtm_id' );
	if ( $gtm_id ) :
?>
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=<?php echo $gtm_id; ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?php echo $gtm_id; ?>');</script>
<!-- End Google Tag Manager -->
<?php
	endif;
	return ob_get_clean();
}


/**
 * Prints the Google Tag Manager data layer snippet.
 **/
function google_tag_manager_dl() {
	ob_start();
	$gtm_id = get_theme_option( 'gtm_id' );
	if ( $gtm_id ) :
?>
	<script>
	  dataLayer = [];
	</script>
<?php
	endif;
	return ob_get_clean();
}


function get_image_url( $filename ) {
	global $wpdb, $post;

	$post_id = wp_is_post_revision( $post->ID );
	if( $post_id === False ) {
		$post_id = $post->ID;
	}

	$url = '';
	if ( $filename ) {
		$sql = sprintf( 'SELECT * FROM %s WHERE post_title="%s" AND post_parent=%d ORDER BY post_date DESC', $wpdb->posts, $wpdb->escape( $filename ), $post_id );

		$rows = $wpdb->get_results( $sql );
		if ( count( $rows ) > 0 ) {
			$obj = $rows[0];
			if( $obj->post_type == 'attachment' && stripos( $obj->post_mime_type, 'image/' ) == 0 ) {
				$url = wp_get_attachment_url( $obj->ID );
			}
		}
	}
	return $url;
}

function display_social_menu() {
	$items = wp_get_nav_menu_items( 'social-links' );

	ob_start();
?>
	<div class="social-menu">
<?php
	foreach( $items as $item ):
		$href = $item->url;
		$icon = get_social_icon( $item->url );
?>
		<a href="<?php echo $href; ?>" class="social-menu-link ga-event-link">
			<span class="social-menu-icon <?php echo $icon; ?>"></span>
		</a>

<?php
	endforeach;
?>
	</div>
<?php
	return ob_get_clean();
}

function get_social_icon( $item_slug ) {
	switch( true ) {
		case stristr( $item_slug, 'facebook' ):
			return 'fa fa-facebook';
		case stristr( $item_slug, 'twitter' ):
			return 'fa fa-twitter';
		case stristr( $item_slug, 'google' ):
			return 'fa fa-google-plus';
		case stristr( $item_slug, 'linkedin' ):
			return 'fa fa-linkedin';
		case stristr( $item_slug, 'instagram' ):
			return 'fa fa-instagram';
		case stristr( $item_slug, 'pinterest' ):
			return 'fa fa-pinterest-p';
		case stristr( $item_slug, 'youtube' ):
			return 'fa fa-youtube';
		case stristr( $item_slug, 'flickr' ):
			return 'fa fa-flickr';
		case stristr( $item_slug, 'vine' ):
			return 'fa fa-vine';
		case stristr( $item_slug, 'social' ):
			return 'fa fa-share-alt';
		default:
			return 'fa fa-pencil';
	}
}

?>
