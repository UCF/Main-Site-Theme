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
/*  stolen from SmartStart theme
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

			$output = '<section id="ss-' . $post->post_name . '" class="ss-slider">';

				$slides = get_post_meta( $post->ID, 'ss_slider_slides' );

				if( !$slides || !$slides[0] )
					return;

				foreach ( $slides[0] as $slide ) :

					$output .= '<article class="slide">';

						if( $slide['slide-link-url'] )
							$output .= '<a href="' . $slide['slide-link-url'] . '" class="' . $slide['slide-link-lightbox'] . '">';

						$output .= '<img src="' . $slide['slide-img-src'] . '" alt="' . $post->post_title . '" class="slide-bg-image" />';
						
						$output .= '<div class="slide-button ' . ( $slide['slide-button-type'] ? $slide['slide-button-type'] : null ) . '">';

							if( $slide['slide-button-dropcap'] && $slide['slide-button-type'] != 'image' )
								$output .= '<span class="dropcap">' . $slide['slide-button-dropcap'] . '</span>';

							if( $slide['slide-button-title'] && $slide['slide-button-type'] != 'image' )
								$output .= '<h5>' . $slide['slide-button-title'] . '</h5>';

							if( $slide['slide-button-description'] && $slide['slide-button-type'] != 'image' )
								$output .= '<span class="description">' . $slide['slide-button-description'] . '</span>';
							
							if( $slide['slide-button-img-src'] && $slide['slide-button-type'] == 'image' )
								$output .= '<img src="' . $slide['slide-button-img-src'] . '" alt="' . $post->post_title . '" />';

						$output .= '</div>';

						if( $slide['slide-link-url'] )
							$output .= '</a>';

						if( isset( $slide['slide-content'] ) )
							$output .= '<div class="slide-content">' . do_shortcode( $slide['slide-content'] ) . '</div>';

					$output .= '</article><!-- end .slide -->';

				endforeach;

			$output .= '</section><!-- end .ss-slider -->';

		endwhile;

		wp_reset_query();

		return $output;

	}
	add_shortcode('slider', 'ss_framework_slider_sc');

?>