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
 * Post search
 *
 * @return string
 * @author Chris Conover
 **/
function sc_post_type_search($params=array(), $content='') {
	$defaults = array(
		'post_type_name'         => 'post',
		'taxonomy'               => 'category',
		'show_empty_sections'    => false,
		'non_alpha_section_name' => 'Other',
		'column_width'           => 'span4',
		'column_count'           => '3',
		'order_by'               => 'post_title',
		'order'                  => 'ASC'
	);

	$params = ($params === '') ? $defaults : array_merge($defaults, $params);

	$params['show_empty_sections'] = (bool)$params['show_empty_sections'];
	$params['column_count']        = is_numeric($params['column_count']) ? (int)$params['column_count'] : $defaults['column_count'];
	
	// Resolve the post type class
	if(is_null($post_type_class = get_custom_post_type($params['post_type_name']))) {
		return '<p>Invalid post type.</p>';
	}
	$post_type = new $post_type_class;

	// Set default search text if the user didn't
	if(!isset($params['default_search_text'])) {
		$params['default_search_text'] = 'Find a '.$post_type->singular_name;
	}

	// Register if the search data with the JS PostTypeSearchDataManager
	// Format is array(post->ID=>terms) where terms include the post title
	// as well as all associated tag names
	$search_data = array();
	foreach(get_posts(array('numberposts' => -1, 'post_type' => $params['post_type_name'])) as $post) {
		$search_data[$post->ID] = array($post->post_title);
		foreach(wp_get_object_terms($post->ID, 'post_tag') as $term) {
			$search_data[$post->ID][] = $term->name;
		}
	}
	?>
	<script type="text/javascript">
		if(typeof PostTypeSearchDataManager != 'undefined') {
			PostTypeSearchDataManager.register(new PostTypeSearchData(
				<?=json_encode($params['column_count'])?>,
				<?=json_encode($params['column_width'])?>,
				<?=json_encode($search_data)?>
			));
		}
	</script>
	<?

	// Split up this post type's posts by term
	$by_term = array();
	foreach(get_terms($params['taxonomy']) as $term) {
		$posts = get_posts(array(
			'numberposts' => -1,
			'post_type'   => $params['post_type_name'],
			'tax_query'   => array(
				array(
					'taxonomy' => $params['taxonomy'],
					'field'    => 'id',
					'terms'    => $term->term_id
				)
			),
			'orderby'     => $params['order_by'],
			'order'       => $params['order']
		));

		if(count($posts) == 0 && $params['show_empty_sections']) {
			$by_term[$term->name] = array();
		} else {
			$by_term[$term->name] = $posts;
		}
	}

	// Split up this post type's posts by the first alpha character
	$by_alpha = array();
	$by_alpha_posts = get_posts(array(
		'numberposts' => -1,
		'post_type'   => $params['post_type_name'],
		'orderby'     => 'post_title',
		'order'       => 'alpha'
	));
	foreach($by_alpha_posts as $post) {
		if(preg_match('/([a-zA-Z])/', $post->post_title, $matches) == 1) {
			$by_alpha[strtoupper($matches[1])][] = $post;
		} else {
			$by_alpha[$params['non_alpha_section_name']][] = $post;
		}
	}
	ksort($by_alpha);

	if($params['show_empty_sections']) {
		foreach(range('a', 'z') as $letter) {
			if(!isset($by_alpha[strtoupper($letter)])) {
				$by_alpha[strtoupper($letter)] = array();
			}
		}
	}

	$sections = array(
		'post-type-search-term'  => $by_term,
		'post-type-search-alpha' => $by_alpha,
	);

	ob_start();
	?>
	<div class="post-type-search">
		<div class="post-type-search-header">
			<form class="post-type-search-form" action="." method="get">
				<input type="text" class="span3" placeholder="<?=$params['default_search_text']?>" />
			</form>
		</div>
		<div class="post-type-search-results "></div>
		<div class="btn-group post-type-search-sorting">
			<button class="btn active"><i class="icon-list-alt"></i></button>
			<button class="btn"><i class="icon-font"></i></button>
		</div>
	<?

	foreach($sections as $id => $section) {
		?>
		<div class="<?=$id?>"<? if($id == 'post-type-search-alpha') echo ' style="display:none;"'; ?>>
			<? foreach($section as $section_title => $section_posts) { ?>
				<? if(count($section_posts) > 0 || $params['show_empty_sections']) { ?>
					<div>
						<h3><?=esc_html($section_title)?></h3>
						<div class="row">
							<div class="<?=$params['column_width']?>">
								<? if(count($section_posts) > 0) { ?>
									<ul>
									<? $posts_per_column = ceil(count($section_posts) / $params['column_count']); ?>
									<? foreach(range(0, $params['column_count'] - 1) as $column_index) { ?>
										<? $start = $column_index * $posts_per_column; ?>
										<? $end   = $start + $posts_per_column; ?>
										<? if(count($section_posts) > $start) { ?>
											<? foreach(array_slice($section_posts, $start, $end) as $post) { ?>
												<li data-post-id="<?=$post->ID?>"><?=$post_type->toHTML($post)?></li>
											<? } ?>
										<? } ?>
									<? } ?>
									</ul>
								<? } ?>
							</div>
						</div>
					</div>
				<? } ?>
			<? } ?>
		</div>
		<?
	}
	?> </div> <?
	return ob_get_clean();
}
add_shortcode('post-type-search', 'sc_post_type_search');
?>