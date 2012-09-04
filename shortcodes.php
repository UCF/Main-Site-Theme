<?php


/**
 * Create a javascript slideshow of each top level element in the
 * shortcode.  All attributes are optional, but may default to less than ideal
 * values.  Available attributes:
 * 
 * height     => css height of the outputted slideshow, ex. height="100px"
 * width      => css width of the outputted slideshow, ex. width="100%"
 * transition => length of transition in milliseconds, ex. transition="1000"
 * cycle      => length of each cycle in milliseconds, ex cycle="5000"
 * animation  => The animation type, one of: 'slide' or 'fade'
 *
 * Example:
 * [slideshow height="500px" transition="500" cycle="2000"]
 * <img src="http://some.image.com" .../>
 * <div class="robots">Robots are coming!</div>
 * <p>I'm a slide!</p>
 * [/slideshow]
 **/
function sc_slideshow($attr, $content=null){
	$content = cleanup(str_replace('<br />', '', $content));
	$content = DOMDocument::loadHTML($content);
	$html    = $content->childNodes->item(1);
	$body    = $html->childNodes->item(0);
	$content = $body->childNodes;
	
	# Find top level elements and add appropriate class
	$items = array();
	foreach($content as $item){
		if ($item->nodeName != '#text'){
			$classes   = explode(' ', $item->getAttribute('class'));
			$classes[] = 'slide';
			$item->setAttribute('class', implode(' ', $classes));
			$items[] = $item->ownerDocument->saveXML($item);
		}
	}
	
	$animation = ($attr['animation']) ? $attr['animation'] : 'slide';
	$height    = ($attr['height']) ? $attr['height'] : '100px';
	$width     = ($attr['width']) ? $attr['width'] : '100%';
	$tran_len  = ($attr['transition']) ? $attr['transition'] : 1000;
	$cycle_len = ($attr['cycle']) ? $attr['cycle'] : 5000;
	
	ob_start();
	?>
	<div 
		class="slideshow <?=$animation?>"
		data-tranlen="<?=$tran_len?>"
		data-cyclelen="<?=$cycle_len?>"
		style="height: <?=$height?>; width: <?=$width?>;"
	>
		<?php foreach($items as $item):?>
		<?=$item?>
		<?php endforeach;?>
	</div>
	<?php
	$html = ob_get_clean();
	
	return $html;
}
add_shortcode('slideshow', 'sc_slideshow');


function sc_search_form() {
	ob_start();
	?>
	<div class="search">
		<?get_search_form()?>
	</div>
	<?
	return ob_get_clean();
}
add_shortcode('search_form', 'sc_search_form');


function sc_person_picture_list($atts) {
	$atts['type']	= ($atts['type']) ? $atts['type'] : null;
	$row_size 		= ($atts['row_size']) ? (intval($atts['row_size'])) : 5;
	$categories		= ($atts['categories']) ? $atts['categories'] : null;
	$org_groups		= ($atts['org_groups']) ? $atts['org_groups'] : null;
	$limit			= ($atts['limit']) ? (intval($atts['limit'])) : -1;
	$join			= ($atts['join']) ? $atts['join'] : 'or';
	$people 		= sc_object_list(
						array(
							'type' => 'person', 
							'limit' => $limit,
							'join' => $join,
							'categories' => $categories, 
							'org_groups' => $org_groups
						), 
						array(
							'objects_only' => True,
						));
	
	ob_start();
	
	?><div class="person-picture-list"><?
	$count = 0;
	foreach($people as $person) {
		
		$image_url = get_featured_image_url($person->ID);
		
		$link = ($person->post_content != '') ? True : False;
		if( ($count % $row_size) == 0) {
			if($count > 0) {
				?></div><?
			}
			?><div class="row"><?
		}
		
		?>
		<div class="span2 person-picture-wrap">
			<? if($link) {?><a href="<?=get_permalink($person->ID)?>"><? } ?>
				<img src="<?=$image_url ? $image_url : get_bloginfo('stylesheet_directory').'/static/img/no-photo.jpg'?>" />
				<div class="name"><?=Person::get_name($person)?></div>
				<div class="title"><?=get_post_meta($person->ID, 'person_jobtitle', True)?></div>
				<? if($link) {?></a><?}?>
		</div>
		<?
		$count++;
	}
	?>	</div>
	</div>
	<?
	return ob_get_clean();
}
add_shortcode('person-picture-list', 'sc_person_picture_list');




/**
 * Centerpiece Slider
 **/

	function sc_centerpiece_slider( $atts, $content = null ) {
		
		extract( shortcode_atts( array(
			'id' => '',
		), $atts ) );

		global $post;

		$args = array('p'              => esc_attr( $id ),
					  'post_type'      => 'centerpiece',
					  'posts_per_page' => '1'
				  );

		query_posts( $args );

		if( have_posts() ) while ( have_posts() ) : the_post();
		
			$slide_order 			= get_post_meta($post->ID, 'ss_slider_slideorder', TRUE);
			$slide_order			= explode(",",$slide_order);
			$slide_title			= get_post_meta($post->ID, 'ss_slide_title', TRUE);
			$slide_content_type 	= get_post_meta($post->ID, 'ss_type_of_content', TRUE);
			$slide_image			= get_post_meta($post->ID, 'ss_slide_image', TRUE);
			$slide_video			= get_post_meta($post->ID, 'ss_slide_video', TRUE);
			$slide_video_thumb		= get_post_meta($post->ID, 'ss_slide_video_thumb', TRUE);
			$slide_content			= get_post_meta($post->ID, 'ss_slide_content', TRUE);
			$slide_links_to			= get_post_meta($post->ID, 'ss_slide_links_to', TRUE);
			$slide_newtab			= get_post_meta($post->ID, 'ss_slide_link_newtab', TRUE);
			$slide_duration			= get_post_meta($post->ID, 'ss_slide_duration', TRUE);
			$rounded_corners		= get_post_meta($post->ID, 'ss_slider_rounded_corners', TRUE);
			
			// #centerpiece_slider must contain an image placeholder set to the max
			// slide width in order to trigger responsive styles properly--
			// http://www.bluebit.co.uk/blog/Using_jQuery_Cycle_in_a_Responsive_Layout
			$output .= '<div id="centerpiece_slider">
						  <ul>
						  	<img src="'.get_bloginfo('stylesheet_directory').'/static/img/centerpiece_placeholder.gif" width="940" style="max-width: 100%; height: auto;">';
			
			foreach ($slide_order as $s) {
				if ($s !== '') {
					
					$slide_image_url = wp_get_attachment_image_src($slide_image[$s], 'centerpiece-image');
					$slide_video_thumb_url = wp_get_attachment_image_src($slide_video_thumb[$s], 'centerpiece-image');
					$slide_duration  = ($slide_duration[$s] !== '' ? $slide_duration[$s] : 6);
					
					// Start <li>
					$output .= '<li class="centerpiece_single" id="centerpiece_single_'.$s.'" data-duration="'.$slide_duration.'">';
					
					// Add <a> tag and target="_blank" if applicable:
					if ($slide_links_to[$s] !== '' && $slide_content_type[$s] == 'image') {
						$output .= '<a href="'.$slide_links_to[$s];
						if ($slide_newtab == 'on') {
							$output .= ' target="_blank"';
						}
						$output .= '">';
					}
					
					// Image output:
					if ($slide_content_type[$s] == 'image') {
						$output .= '<img class="centerpiece_single_img" src="'.$slide_image_url[0].'" title="'.$slide_title[$s].'" alt="'.$slide_title[$s].'"';
						$output .= '/>';
						
						if ($slide_links_to[$s] !== '' && $slide_content_type[$s] == 'image') {
							$output .= '</a>';
						}
						
						if ($slide_content[$s] !== '') {
							$output .= '<div class="slide_contents">'.apply_filters('the_content', $slide_content[$s]).'</div>';
						}
					}
										
					
					// Video output:
					if ($slide_content_type[$s] == 'video') {
						if ($slide_video_thumb[$s]) {
							$output .= '<img class="centerpiece_single_vid_thumb" src="'.$slide_video_thumb_url[0].'" alt="Click to Watch" title="Click to Watch" />';
							$output .= '<div class="centerpiece_single_vid_hidden">'.$slide_video[$s].'</div>';
						}
						else {
							$output .= $slide_video[$s];
						}
					}
					
					// End <li>
					$output .= '</li>';
				}
			}
						  
						  
			$output .= '</ul>';
			
			// Apply rounded corners:
			if ($rounded_corners == 'on') {
				$output .= '<div class="thumb_corner_tl"></div><div class="thumb_corner_tr"></div><div class="thumb_corner_bl"></div><div class="thumb_corner_br"></div>';
			}
			
			$output .= '
						<div id="centerpiece_control"></div>
					</div>';

		endwhile;

		wp_reset_query();

		return $output;

	}
	add_shortcode('centerpiece', 'sc_centerpiece_slider');


/**
 * Output Upcoming Events via shortcode.
 **/
function sc_events_widget() {
	display_events();
	print '<p class="events_icons"><a class="icsbtn" href="http://events.ucf.edu/?upcoming=upcoming&format=ics">ICS Format for upcoming events</a><a class="rssbtn" href="http://events.ucf.edu/?upcoming=upcoming&format=rss">RSS Format for upcoming events</a></p>
	<p><a href="http://events.ucf.edu/?upcoming=upcoming" class="events_morelink">More Events</a></p>';
}
add_shortcode('events-widget', 'sc_events_widget');






/** 
 * TESTING -- pull recent GF entries from a given form
 * Query assumes that feedback form has a hidden current date field
 * in the 6th form position and that the site's multisite ID is 54.
 * If no formid argument is provided, the function will pick the form
 * with ID of 1 by default
 **/
function get_feedback_entries($atts) {
	extract( shortcode_atts( array(
		'formid' => 1,
		'duration' => '7',
	), $atts ) );
	
	// Define how far back to search for old entries
	$dur_start_date = date('Y-m-d');
	$dur_end_date 	= date('Y-m-d', strtotime($dur_start_date.' +'.$duration.' days'));
	
	// WPDB stuff
	global $wpdb;
	define( 'DIEONDBERROR', true );
	$wpdb->show_errors();
	
	// Get all entry IDs
	$entry_ids = $wpdb->get_results( 
		"
		SELECT 		id
		FROM 		wp_54_rg_lead
		WHERE		form_id = ".$formid."
		AND			date_created >= '".$dur_start_date." 00:00:00' 
		AND			date_created <= '".$dur_end_date." 23:59:59'
		ORDER BY	id ASC
		"
	);
	
	$output = var_dump($entry_ids);
	
	// Eliminate any duplicate IDs
	$unique_ids = array();
	foreach ($entry_ids as $obj) {
		foreach ($obj as $key=>$val) {			
			if (!(in_array($val, $unique_ids))) {
				$unique_ids[] .= $val;
			}
		}
	}
	
	// Begin $output
	$output .= '<h3>Feedback Submissions for '.$dur_start_date.' to '.$dur_end_date.'</h3><br />';
	
	// Get field data for the IDs we filtered out
	foreach ($unique_ids as $id) {
		$entry = RGFormsModel::get_lead($id);
		
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
			
			
			$entry_output['id'] = $id;
			
			// Trim off seconds from date_created
			if ($field == 'date_created') {
				$val = date('Y-m-d', strtotime($val));
				$entry_output['date'] .= $val;
			}
			
			if ($field == 1) {
				if ($val) {
					$entry_output['name'] .= $val;
				}
			}
			if ($field == 2) {
				if ($val) {
					$entry_output['email'] .= $val;
				}
			}
			if ($field >=3 && $field < 4) {
				if ($val) {
					$about_array[] .= $val;
				}
			}
			if ($field >= 4 && $field < 5) {
				if ($val) {
					$routes_array[] .= $val;
				}
			}
			if ($field == 5) {
				if ($val) {
					$entry_output['comment'] .= $val;
				}
			}
			//$entry_output['about'] .= $about_array;
			//$entry_output['routing'] .= $routes_array;
			
			//$output .= "Field ID: ".$id."; Field Name: ".$field."; Value: ".$val."<br/>";
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
	
	return $output;
	
}
add_shortcode('feedback', 'get_feedback_entries');


?>