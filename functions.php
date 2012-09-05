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
 * Adds a subheader to a page (if one is set for the page.)
 **/
function get_page_subheader($post) {
	if (get_post_meta($post->ID, 'page_subheader', TRUE) !== '') {
		$subheader = get_post(get_post_meta($post->ID, 'page_subheader', TRUE));			
		?>
		<div class="span12" id="subheader">
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
				<p class="subhead_quotelink"><a href="<?=get_permalink(get_page_by_title( 'Submit a Quote About UCF', OBJECT, 'page' )->ID)?>">Submit a quote &raquo;</a></p>
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
				<div class="spotlight_thumb" style="background-image:url('<?=$thumb_src?>');"><?=$spotlight->post_title?></div>
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
 * @author Chris Conover
 **/
function get_weather_data()
{
	$cache_key = 'weather';
	
	if(($weather = get_transient($cache_key)) !== False) {
		return $weather;
	} else {
		$weather = Array('condition' => 'Fair', 'temp' => '80&#186;', 'img' => '34');
		
		// Cookies are needed for the service to work properly
		$opts = Array('http' => Array(	'method'=>"GET",
										'header'=>"Accept-language: en\r\n" .
										"Cookie: P1=01||,USFL0372|1||WESH|||||||;\r\n",
										'timeout' => 1
									)
					);
		
		$context = stream_context_create($opts);
		
		try {
			$raw_weather = file_get_contents(WEATHER_URL, false, $context);
			$json_weather = json_decode(str_replace("\'", "'", $raw_weather));

			@$weather['condition']	= $json_weather->weather->conditions->text;
			@$weather['temp']		= substr($json_weather->weather->conditions->temp, 0, strlen($json_weather->weather->conditions->temp) - 1);
			@$weather['img']		= $json_weather->weather->conditions->cid;
			
			# Catch missing cid
			if (!isset($weather['img']) or !intval($weather['img'])){
				$weather['img'] = '34';
			}
			
			# Catch missing condition
			if (!is_string($weather['condition']) or !$weather['condition']){
				$weather['condition'] = 'fair';
			}
			
			# Catch missing temp
			if (!isset($weather['temp']) or !$weather['temp']){
				$weather['temp'] = '80';
			}
		} catch (Exception $e) {
			# pass
		}

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
	<div id="weather_bug" class="<?=$class?>">
		<img src="<?php bloginfo('stylesheet_directory'); ?>/static/img/weather/<?=$img?>.gif" alt="<?=$condition?>" />
		<p id="wb_status_txt"><?=$temp?>F, <?=$condition?></p>
	</div>
	<?php
}


/**
 * Hide unused admin tools (Links, Comments, etc)
 **/
 
function hide_admin_links() {
	remove_menu_page('link-manager.php');
	remove_menu_page('edit-comments.php');
}
add_action( 'admin_menu', 'hide_admin_links' );


/**
 * Get and display announcements.
 * Note that, like the old Announcements advanced search, only one
 * search parameter (role, keyword, or time) can be set at a time.
 * Default (no args) returns all roles within the past week 
 * (starting from Monday).
 **/
function get_announcements($role='all', $keyword=NULL, $time='thisweek') {
	// Set up query args based on GET params:
	if ($role !== 'all') {
		$args = array(
			'numberposts' => -1,
			'post_type' => 'announcement',
			'orderby' => 'modified',
			'order' => 'DESC',
			'meta_key' => 'announcement_start_date',
			'tax_query' => array(
				array(
					'taxonomy' => 'audienceroles',
					'field' => 'slug',
					'terms' => $role,
				)
			),
		);
		
		// Create a new filtering function that will add our where clause to the query
		function filter_where( $where = '' ) {
			$thismonday = date('Y-m-d', strtotime('monday this week'));
			// posts with a start date ranging from this Monday to this Sunday
			$where .= " AND meta_value >= '".$thismonday."' AND meta_value <= '".date('Y-m-d', strtotime($thismonday.' +6 days'))."'";
			return $where;
		}
		add_filter( 'posts_where', 'filter_where' );
	}
	elseif ($keyword !== NULL) {
		$args = array(
			'numberposts' => -1,
			'post_type' => 'announcement',
			'orderby' => 'modified',
			'order' => 'DESC',
			'meta_key' => 'announcement_start_date',
			'tax_query' => array(
				array(
					'taxonomy' => 'keywords',
					'field' => 'slug',
					'terms' => $keyword,
				)
			),
		);
		
		function filter_where( $where = '' ) {
			$thismonday = date('Y-m-d', strtotime('monday this week'));
			// posts with a start date ranging from this Monday to this Sunday
			$where .= " AND meta_value >= '".$thismonday."' AND meta_value <= '".date('Y-m-d', strtotime($thismonday.' +6 days'))."'";
			return $where;
		}
		add_filter( 'posts_where', 'filter_where' );
	}
	elseif ($time !== 'thisweek') {
		$args = array(
			'numberposts' => -1,
			'post_type' => 'announcement',
			'orderby' => 'modified',
			'order' => 'DESC',
			'meta_key' => 'announcement_start_date',
		);
		
		// Assign $timequery for use in filter_where based on $time value
		switch ($time) {
			case 'nextweek':
				$nextmonday = date('Y-m-d', strtotime('monday next week'));
				// posts with a start date ranging from next Monday to next Sunday
				$timequery = " AND meta_value >= '".$nextmonday."' AND meta_value <= '".date('Y-m-d', strtotime($nextmonday.' +6 days'))."'";
				break;
			case 'thismonth':
				$firstday = date('Y-m-d', strtotime('first day of this month'));
				$lastday = date('Y-m-d', strtotime('last day of this month'));
				// posts with a start date within the first and last day of the current month
				$timequery = " AND meta_value >= '".$firstday."' AND meta_value <= '".$lastday."'";
				break;
			case 'nextmonth':
				$firstday = date('Y-m-d', strtotime('first day of next month'));
				$lastday = date('Y-m-d', strtotime('last day of next month'));
				// posts with a start date within the first and last day of next month
				$timequery = " AND meta_value >= '".$firstday."' AND meta_value <= '".$lastday."'";
				break;
			case 'thissemester': // TODO: figure out how to handle this
				break;
			default: // fallback
				$thismonday = date('Y-m-d', strtotime('monday this week'));
				// posts with a start date ranging from this Monday to this Sunday
				$timequery = " AND meta_value >= '".$thismonday."' AND meta_value <= '".date('Y-m-d', strtotime($thismonday.' +6 days'))."'";
				break;
		}
		
		function filter_where( $where = '' ) {
			// posts in the last 7 days
			$where .= $timequery;
			return $where;
		}
		add_filter( 'posts_where', 'filter_where' );
	}
	else { // default retrieval args
		$args = array(
			'numberposts' => -1,
			'post_type' => 'announcement',
			'orderby' => 'modified',
			'order' => 'DESC',
			'meta_key' => 'announcement_start_date',
		);
	
		function filter_where( $where = '' ) {
			global $wpdb;
			
			$thismonday = date('Y-m-d', strtotime('monday this week'));
			
			// posts with a start date ranging from this Monday to this Sunday
			$where .= " AND $wpdb->postmeta.meta_key = 'announcement_start_date' AND $wpdb->postmeta.meta_value >= '".$thismonday."' AND $wpdb->postmeta.meta_value <= '".date('Y-m-d', strtotime($thismonday.' +6 days'))."'";
			return $where;
		}
		add_filter( 'posts_where', 'filter_where' );
	}
	
	
	// Fetch all announcements based on args given above:
	$announcements = get_posts($args);
	remove_filter( 'posts_where', 'filter_where' );
	
	
	if (!($announcements)) {
		return NULL;
	}
	else {
		// Set up an array that will contain the necessary output values
		// (basically a combination of post data and metadata):
		$output = array();
		
		foreach ($announcements as $announcement) {
			$output[$announcement->ID] = array(
				'post_id'			=> $announcement->ID,
				'post_status' 		=> $announcement->post_status,
				'post_modified' 	=> $announcement->post_modified,
				'post_published' 	=> $announcement->post_date,
				'post_title' 		=> $announcement->post_title,
				'post_name' 		=> $announcement->post_name,
				'post_permalink'	=> get_permalink($announcement->ID),
				'post_content' 		=> $announcement->post_content,
				'start_date'		=> get_post_meta($announcement->ID, 'announcement_start_date', TRUE),
				'end_date' 			=> get_post_meta($announcement->ID, 'announcement_end_date', TRUE),
				'url' 				=> get_post_meta($announcement->ID, 'announcement_url', TRUE),
				'contact_person'	=> get_post_meta($announcement->ID, 'announcement_contact', TRUE),
				'phone'				=> get_post_meta($announcement->ID, 'announcement_phone', TRUE),
				'email'				=> get_post_meta($announcement->ID, 'announcement_email', TRUE),
				'posted_by'			=> get_post_meta($announcement->ID, 'announcement_posted_by', TRUE),
				'roles' 			=> wp_get_post_terms($announcement->ID, 'audienceroles', array("fields" => "names")),
				'keywords'			=> wp_get_post_terms($announcement->ID, 'keywords', array("fields" => "names")),
			);
		}
		
		return $output;
	}
	
}


/**
 * Takes an announcements array and outputs an RSS feed.
 **/
function announcements_to_rss($announcements) {
	if (!($announcements)) { die('Error: no announcements feed provided.'); }
	
	header('Content-Type: application/rss+xml; charset=ISO-8859-1');
	print '<?xml version="1.0" encoding="ISO-8859-1"?>';
	print '<rss version="2.0">';
	print '<channel>';
	print '<title>University of Central Florida Announcements</title>';
	print '<link>http://www.ucf.edu/</link>';
	print '<language>en-us</language>';
	print '<copyright>ucf.edu</copyright>';
			
	if ($announcements !== NULL) {
		foreach ($announcements as $announcement) {
			print '<item id="'.$announcement['id'].'">';
				print '<title>'.$announcement['post_title'].'</title>';
				print '<description>'.$announcement['post_content'].'</description>';
				print '<link>'.$announcement['post_permalink'].'</link>';
						
				print '<post_status>'.$announcement['post_status'].'</post_status>';
				print '<post_modified>'.$announcement['post_modified'].'</post_modified>';
				print '<post_published>'.$announcement['post_published'].'</post_published>';
				print '<post_title>'.$announcement['post_title'].'</post_title>';
				print '<post_name>'.$announcement['post_name'].'</post_name>';
				print '<post_content>'.$announcement['post_content'].'</post_content>';
				print '<start_date>'.$announcement['start_date'].'</start_date>';
				print '<end_date>'.$announcement['end_date'].'</end_date>';
				print '<url>'.$announcement['url'].'</url>';
				print '<contact_person>'.$announcement['contact_person'].'</contact_person>';
				print '<phone>'.$announcement['phone'].'</phone>';
				print '<email>'.$announcement['email'].'</email>';
				print '<posted_by>'.$announcement['posted_by'].'</posted_by>';
				print '<roles>';
					foreach ($announcement['roles'] as $role) {
						print '<role>'.$role.'</role>';
					}
				print '</roles>';
				print '<keywords>';
					foreach ($announcement['keywords'] as $keyword) {
						print '<keyword>'.$keyword.'</keyword>';
					}
				print '</keywords>';

			print '</item>';
		}
	}
	print '</channel></rss>';
}


?>