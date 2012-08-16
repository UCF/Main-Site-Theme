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
 * Output Spotlights for front page.
 *
 * Note: this function assumes at least 2 spotlights already exist
 * and that only 2 spotlights at a time should ever be displayed.
 **/
function sc_frontpage_spotlights() {
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
			<a href="<?=get_permalink($spotlight->ID)?>"><?=get_the_post_thumbnail($spotlight->ID, 'thumbnail')?></a>
			<h3 class="home_spotlight_title"><a href="<?=get_permalink($spotlight->ID)?>"><?=$spotlight->post_title?></a></h3>
			<?=$spotlight->post_content?>
			<p><a class="home_spotlight_readmore" href="" target="_blank">Read More…</a></p>
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
add_shortcode('spotlights', 'sc_frontpage_spotlights');


/**
 * Centerpiece Slider
 **/

	function sc_centerpiece_slider( $atts, $content = null ) {
		
		extract( shortcode_atts( array(
			'id' => ''
			), $atts ) );

		global $post;

		$args = array('name'           => esc_attr( $id ),
					  'post_type'      => 'slider',
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
			$slide_content			= get_post_meta($post->ID, 'ss_slide_content', TRUE);
			$slide_links_to			= get_post_meta($post->ID, 'ss_slide_links_to', TRUE);
			$slide_newtab			= get_post_meta($post->ID, 'ss_slide_link_newtab', TRUE);
			$slide_duration			= get_post_meta($post->ID, 'ss_slide_duration', TRUE);
			$rounded_corners		= get_post_meta($post->ID, 'ss_slider_rounded_corners', TRUE);
			
			$output .= '<div id="centerpiece_slider">
						  <ul>';
			
			foreach ($slide_order as $s) {
				if ($s !== '') {
					
					$slide_image_url = wp_get_attachment_image_src($slide_image[$s], 'centerpiece-image');
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
						if ($rounded_corners == 'on') {
							$output .= 'style="border-radius: 10px;"';
						}
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
						$output .= $slide_video[$s];
					}
					
					// End <li>
					$output .= '</li>';
				}
			}
						  
						  
			$output .= '</ul>
						<div id="centerpiece_control"></div>
					</div>';

		endwhile;

		wp_reset_query();

		return $output;

	}
	add_shortcode('centerpiece', 'sc_centerpiece_slider');

?>