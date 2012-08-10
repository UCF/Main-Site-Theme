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
/*	Slider
/*  stolen/modified from SmartStart theme
/* -------------------------------------------------- */

	function ss_framework_slider_sc( $atts, $content = null ) {
		
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
		
			$post_custom_fields = get_post_custom($post->ID);
			
			// Set defaults for slider options, even if they're published blank, to prevent front-end weirdness:
			
			// Basic display options:
			$slider_transition = 			($post_custom_fields['ss_slider_transition'][0] !== NULL)			? $post_custom_fields['ss_slider_transition'][0] 			: 'fade';
			$slider_speed = 				($post_custom_fields['ss_slider_speed'][0] !== NULL)				? $post_custom_fields['ss_slider_speed'][0] 				: 400;
			$slider_autoplay = 				($post_custom_fields['ss_slider_autoplay'][0] !== NULL)				? $post_custom_fields['ss_slider_autoplay'][0] 				: 3000;
			$slider_seq_factor = 			($post_custom_fields['ss_slider_seq_factor'][0] !== NULL) 			? $post_custom_fields['ss_slider_seq_factor'][0]			: 100;
			//$slider_first_slide = 			$post_custom_fields['ss_slider_first_slide'][0];
			
			// Advanced display options:
			$slider_easing = 				($post_custom_fields['ss_slider_easing'][0] !== '') 				? $post_custom_fields['ss_slider_easing'][0] 				: 'linear';
			$slider_pause_on_hover = 		($post_custom_fields['ss_slider_pause_on_hover'][0] !== NULL) 		? $post_custom_fields['ss_slider_pause_on_hover'][0] 		: 0;
			$slider_stop_on_click = 		($post_custom_fields['ss_slider_stop_on_click'][0] !== NULL)		? $post_custom_fields['ss_slider_stop_on_click'][0] 		: 0;
			$slider_content_position = 		($post_custom_fields['ss_slider_content_position'][0] !== '') 		? $post_custom_fields['ss_slider_content_position'][0] 		: 'default';
			$slider_content_speed = 		($post_custom_fields['ss_slider_content_speed'][0] !== NULL)		? $post_custom_fields['ss_slider_content_speed'][0] 		: 450;
			$slider_show_content_onhover = 	($post_custom_fields['ss_slider_show_content_onhover'][0] !== NULL) ? $post_custom_fields['ss_slider_show_content_onhover'][0]	: 0;
			$slider_hide_content = 			($post_custom_fields['ss_slider_hide_content'][0] !== NULL)			? $post_custom_fields['ss_slider_hide_content'][0] 			: 0;
			$slider_hide_bottom_buttons = 	($post_custom_fields['ss_slider_hide_bottom_buttons'][0] !== NULL) 	? $post_custom_fields['ss_slider_hide_bottom_buttons'][0] 	: 0;
			$slider_height = 				($post_custom_fields['ss_slider_height'][0] !== NULL)				? $post_custom_fields['ss_slider_height'][0] 				: 380;
			$slider_width = 				($post_custom_fields['ss_slider_width'][0] !== NULL)				? $post_custom_fields['ss_slider_width'][0] 				: 940;
				
		
			$output = '<section id="ss-' . $post->post_name . '" class="ss-slider"';
			
				$output .= ' data-slider_mode="'.$slider_transition.'"';
				$output .= ' data-slider_speed="'.$slider_speed.'"';
				$output .= ' data-slider_autoplay="'.$slider_autoplay.'"';
				$output .= ' data-slider_seqfactor="'.$slider_seq_factor.'"';
				
				$output .= ' data-slider_easing="'.$slider_easing.'"';
				$output .= ' data-slider_pauseonhover="'.$slider_pause_on_hover.'"';
				$output .= ' data-slider_pause="'.$slider_stop_on_click.'"';
				$output .= ' data-slider_contentposition="'.$slider_content_position.'"';
				$output .= ' data-slider_contentspeed="'.$slider_content_speed.'"';
				$output .= ' data-slider_showcontentonhover="'.$slider_show_content_onhover.'"';
				$output .= ' data-slider_hidecontent="'.$slider_hide_content.'"';
				$output .= ' data-slider_hidebottombuttons="'.$slider_hide_bottom_buttons.'"';
				$output .= ' data-slider_height="'.$slider_height.'"';
				$output .= ' data-slider_width="'.$slider_width.'"';
			
			$output .= '>';

			$slidecount = get_post_meta( $post->ID, 'ss_slider_slidecount' );
			$slidecount = $slidecount[0];

			if( !$slidecount ) {
				//print "No slides found";
				return;
			}

			for ( $i = 1; $i < $slidecount + 1; $i++ ){
					
				//$output .= "<strong>SLIDE ".$i." CONTENTS:</strong><br/><br/>";
					
				// Get meta field values per each numbered meta box:
				$type_of_content = 			$post_custom_fields['ss_type_of_content-'.$i][0];
				$slide_image_id = 			$post_custom_fields['ss_slide_image-'.$i][0];
				$slide_image_id = 			(int)$slide_image_id;
				$slide_image = 				wp_get_attachment_image($slide_image_id);
				$slide_video = 				$post_custom_fields['ss_slide_video-'.$i][0];
				$button_type = 				$post_custom_fields['ss_button_type-'.$i][0];
				$button_dropcap = 			$post_custom_fields['ss_button_dropcap-'.$i][0];
				$button_title = 			$post_custom_fields['ss_button_title-'.$i][0];
				$button_desc = 				$post_custom_fields['ss_button_desc-'.$i][0];
				$slide_content = 			$post_custom_fields['ss_slide_content-'.$i][0];
				$slide_links_to = 			$post_custom_fields['ss_slide_links_to-'.$i][0];
				
				//$output .= "Type of content: ".$type_of_content.", Slide image id: ".$slide_image_id.", Slide image: ".$slide_image.", Button type: ".$button_type.", Button Dropcap: ".$button_dropcap.", Button Title: ".$button_title.", Button Desc: ".$button_desc.", Slide Content: ".$slide_content.", Slide Links To: ".$slide_links_to;
									
					$output .= '<article class="slide">';

						if( $slide_links_to ) {
							$output .= '<a target="_blank" href="' . $slide_links_to . '">';
						}

						$output .= '<img src="' . $slide_image . '" alt="' . $post->post_title . '" class="slide-bg-image" />';
						
						$output .= '<div class="slide-button ' . ( $button_type ? $button_type : null ) . '">';

							if( $button_dropcap && $button_type != 'image' )
								$output .= '<span class="dropcap">' . $button_dropcap . '</span>';

							if( $button_title && $button_type != 'image' )
								$output .= '<h5>' . $button_title . '</h5>';

							if( $button_desc && $button_type != 'image' )
								$output .= '<span class="description">' . $button_desc . '</span>';
							
							if( $slide_links_to && $button_type == 'image' )
								$output .= '<img src="Print $ slide_image thumbnail here" alt="' . $post->post_title . '" />';

						$output .= '</div>';

						if( $slide_links_to )
							$output .= '</a>';

						if( isset( $slide_content ) )
							$output .= '<div class="slide-content">' . do_shortcode( $slide_content ) . '</div>';

					$output .= '</article><!-- end .slide -->';
					

				}

			$output .= '</section><!-- end .ss-slider -->';

		endwhile;

		wp_reset_query();

		return $output;

	}
	add_shortcode('slider', 'ss_framework_slider_sc');

?>