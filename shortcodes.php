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



/* -------------------------------------------------- */
/*	Centerpiece Slider
/* -------------------------------------------------- */

	function centerpiece_slider( $atts, $content = null ) {
		
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
					
					$output .= '<li class="centerpiece_single" data-duration="'.$slide_duration.'">';
					
					if ($slide_content_type[$s] == 'image') {
						$output .= '<img src="'.$slide_image_url[0].'" title="'.$slide_title[$s].'" alt="'.$slide_title[$s].'" />';
					}
					else {
						$output .= $slide_video[$s];
					}
					
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
	add_shortcode('centerpiece', 'centerpiece_slider');

?>