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


/**
 * Include the defined publication, referenced by pub title:
 *
 *     [publication name="Where are the robots Magazine"]
 **/
function sc_publication($attr, $content=null){
	$pub      = @$attr['pub'];
	$pub_name = @$attr['name'];
	$pub_id   = @$attr['id'];

	// Get the post data
	if (!$pub and is_numeric($pub_id)){
		$pub = get_post($pub);
	}
	if (!$pub and $pub_name){
		$pub = get_page_by_title($pub_name, OBJECT, 'publication');
	}

	$url = get_post_meta($pub->ID, "publication_url", True);
	$url = str_replace('https:', 'http:', $url); // Force http

	// Get the Issuu DocumentID from the url provided
	$docID = json_decode(file_get_contents($url.'?issuu-data=docID'));
	$docID = $docID->docID;

	// If no docID is found, assume that the publication url is invalid
	if ($docID == NULL) { return 'DocID not found. Is the publication URL valid? Please use URLs from http://publications.ucf.edu.'; }

	// Output for an Issuu thumbnail, based on docID
	$issuu_thumb = "<img src='http://image.issuu.com/".$docID."/jpg/page_1_thumb_large.jpg' alt='".$pub->post_title."' title='".$pub->post_title."' />";

	// If a featured image is set, use it; otherwise, get the thumbnail from issuu
	$thumb = (get_the_post_thumbnail($pub->ID, 'publication_thumb', TRUE) !== '') ? get_the_post_thumbnail($pub->ID, 'publication_thumb', TRUE) : $issuu_thumb;

	ob_start(); ?>

	<div class="pub">
		<a class="track pub-track" title="<?=$pub->post_title?>" data-toggle="modal" href="#pub-modal-<?=$pub->ID?>">

			<?=$thumb?>
		</a>
		<p class="pub-desc"><?=$pub->post_content?></p>
		<div class="modal fade" id="pub-modal-<?php echo $pub->ID; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $pub->post_title; ?>" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body">
						<iframe src="<?php echo $url; ?>" style="width:100% !important; height:100% !important;" scrolling="no"></iframe>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
	return ob_get_clean();
}
add_shortcode('publication', 'sc_publication');


/**
 * Include the defined YouTube video, referenced by video title.
 *
 *     [video name="Where are the robots? (VIDEO!)"]
 **/
function sc_video($attr, $content=null){
	$video_name = @$attr['name'];
	$video_id   = @$attr['id'];
	$display	= $attr['display'] ? $attr['display'] : 'modal';

	if (!$video and is_numeric($video_id)){
		$video = get_post($video_id);
	}
	if (!$video and $video_name){
		$video = get_page_by_title($video_name, 'OBJECT', 'video');
	}

	$video_url   		= get_post_meta($video->ID, "video_url", true);
	$video_yt_id		= get_youtube_id($video_url);
	$video_description  = $video->post_content;
	$video_thumbnail    = wp_get_attachment_image(get_post_thumbnail_id($video->ID, 'medium'));
	$embed_url			= 'http://www.youtube.com/embed/'.$video_yt_id.'?wmode=transparent';

	switch ($display) {
		default:
			ob_start(); ?>

				<div class="video">
					<div class="icon">
						<a title="Watch <?php echo $video->post_title; ?>" alt="Watch <?php echo $video->post_title; ?>" data-toggle="modal" class="video-link" href="#modal-vid<?php echo $video->ID; ?>">
							<?php echo $video_thumbnail; ?>
						</a>
					</div>
					<div class="modal video-modal fade" id="modal-vid<?php echo $video->ID; ?>" tabindex="-1" role="dialog">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<a class="close" data-dismiss="modal">×</a>
									<h3><?php echo $video->post_title; ?></h3>
								</div>
								<div class="modal-body" data-src="<?php echo $embed_url; ?>">
								</div>
							</div>
						</div>
					</div>
					<h4>
						<a title="Watch <?php echo $video->post_title; ?>" alt="Watch <?php echo $video->post_title; ?>" data-toggle="modal" class="video-link" href="#modal-vid<?php echo $video->ID; ?>">
							<?php echo $video->post_title; ?>
						</a>
					</h4>
					<div class="video-desc"><?php echo $video_description; ?></div>
				</div>
			<?php
			return ob_get_clean();
			break;
		case 'embed':
			ob_start(); ?>
				<iframe type="text/html" width="640" height="390" src="<?php echo $embed_url; ?>" frameborder="0"></iframe>
			<?php
			return ob_get_clean();
			break;
	}
}
add_shortcode('video', 'sc_video');


/**
 * Person picture lists
 **/
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
		<div class="col-md-2 col-sm-2 person-picture-wrap">
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

			$slide_order 			= trim(get_post_meta($post->ID, 'ss_slider_slideorder', TRUE), ',');
			$slide_order			= explode("," , $slide_order);
			$slide_count			= count($slide_order);
			$slide_title			= get_post_meta($post->ID, 'ss_slide_title', TRUE);
			$slide_content_type 	= get_post_meta($post->ID, 'ss_type_of_content', TRUE);
			$slide_image			= get_post_meta($post->ID, 'ss_slide_image', TRUE);
			$slide_video			= get_post_meta($post->ID, 'ss_slide_video', TRUE);
			$slide_video_thumb_def	= THEME_IMG_URL.'/video_thumb_default.jpg';
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

				if ( ($s !== '') && ($s !== NULL) ) {
					$s = (int)$s;

					$slide_image_url = wp_get_attachment_image_src($slide_image[$s], 'centerpiece-image');
					$slide_video_thumb_url = wp_get_attachment_image_src($slide_video_thumb[$s], 'centerpiece-image');

					$slide_single_duration = (!empty($slide_duration[$s]) ? $slide_duration[$s] : '6');

					// Start <li>
					$output .= '<li class="centerpiece_single" id="centerpiece_single_'.$s.'" data-duration="'.$slide_single_duration.'">';

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

						// if a video thumbnail is not set and this is not a
						// single slide centerpiece, use the default video thumb
						// (single slide centerpieces w/video should have an
						// optional thumbnail for autoplay purposes)
						if ($slide_count > 1) {
							if (!$slide_video_thumb[$s]) {
								$slide_video_thumb_url[0] = $slide_video_thumb_def;
							}
						}

						$filtered_video_metadata = strip_tags(apply_filters('the_content', $slide_video[$s]), '<iframe><object><embed>');

						if ($slide_video_thumb_url[0] !== NULL) {
							$output .= '<img class="centerpiece_single_vid_thumb" src="'.$slide_video_thumb_url[0].'" alt="Click to Watch" title="Click to Watch" />';
							$output .= '<div class="centerpiece_single_vid_hidden">'.$filtered_video_metadata.'</div>';
						}
						else {
							$output .= $filtered_video_metadata;
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
	print '<p class="events_icons"><a class="icsbtn" href="http://events.ucf.edu/upcoming/feed.ics">ICS Format for upcoming events</a><a class="rssbtn" href="http://events.ucf.edu/upcoming/feed.rss">RSS Format for upcoming events</a></p>
	<p class="screen-only"><a href="http://events.ucf.edu/upcoming/" class="events_morelink">More Events</a></p>';
}
add_shortcode('events-widget', 'sc_events_widget');


/**
 * Post search
 *
 * @return string
 * @author Chris Conover
 * */
function sc_post_type_search( $params=array(), $content='' ) {
	$defaults = array(
		'post_type_name'          => 'post',
		'taxonomy'                => 'category',
		'meta_key'                => '',
		'meta_value'              => '',
		'show_empty_sections'     => false,
		'non_alpha_section_name'  => 'Other',
		'column_width'            => 'col-md-4 col-sm-4',
		'column_count'            => '3',
		'order_by'                => 'title',
		'order'                   => 'ASC',
		'show_sorting'            => true,
		'default_sorting'         => 'term',
		'show_sorting'            => true,
		'show_uncategorized'      => false,
		'uncategorized_term_name' => 'Uncategorized'
	);

	$params = ( $params === '' ) ? $defaults : array_merge( $defaults, $params );

	$params['show_empty_sections'] = filter_var( $params['show_empty_sections'], FILTER_VALIDATE_BOOLEAN );
	$params['column_count']        = is_numeric( $params['column_count'] ) ? (int)$params['column_count'] : $defaults['column_count'];
	$params['show_sorting']        = filter_var( $params['show_sorting'], FILTER_VALIDATE_BOOLEAN );

	if ( !in_array( $params['default_sorting'], array( 'term', 'alpha' ) ) ) {
		$params['default_sorting'] = $default['default_sorting'];
	}

	// Resolve the post type class
	if ( is_null( $post_type_class = get_custom_post_type( $params['post_type_name'] ) ) ) {
		return '<p>Invalid post type.</p>';
	}
	$post_type = new $post_type_class;

	// Set default search text if the user didn't
	if ( !isset( $params['default_search_text'] ) ) {
		$params['default_search_text'] = 'Find a '.$post_type->singular_name;
	}

	// Set default search label if the user didn't
	if ( !isset( $params['default_search_label'] ) ) {
		$params['default_search_label'] = 'Find a '.$post_type->singular_name;
	}

	// Register the search data with the JS PostTypeSearchDataManager.
	// Format is array(post->ID=>terms) where terms include the post title
	// as well as all associated tag names
	$search_data = array();
	foreach ( get_posts( array( 'numberposts' => -1, 'post_type' => $params['post_type_name'] ) ) as $post ) {
		$search_data[$post->ID] = array( $post->post_title );
		foreach ( wp_get_object_terms( $post->ID, 'post_tag' ) as $term ) {
			$search_data[$post->ID][] = $term->name;
		}
	}
?>
	<script type="text/javascript">
		if(typeof PostTypeSearchDataManager != 'undefined') {
			PostTypeSearchDataManager.register(new PostTypeSearchData(
				<?php echo json_encode( $params['column_count'] ); ?>,
				<?php echo json_encode( $params['column_width'] ); ?>,
				<?php echo json_encode( $search_data ); ?>
			));
		}
	</script>
	<?php

	// Set up a post query
	$args = array(
		'numberposts' => -1,
		'post_type'   => $params['post_type_name'],
		'tax_query'   => array(
			array(
				'taxonomy' => $params['taxonomy'],
				'field'    => 'id',
				'terms'    => '',
			)
		),
		'orderby'     => $params['order_by'],
		'order'       => $params['order'],
	);

	// Handle meta key and value query
	if ($params['meta_key'] && $params['meta_value']) {
		$args['meta_key'] = $params['meta_key'];
		$args['meta_value'] = $params['meta_value'];
	}

	// Split up this post type's posts by term
	$by_term = array();
	foreach ( get_terms( $params['taxonomy'] ) as $term ) { // get_terms defaults to an orderby=name, order=asc value
		$args['tax_query'][0]['terms'] = $term->term_id;
		$posts = get_posts( $args );

		if ( count( $posts ) == 0 && $params['show_empty_sections'] ) {
			$by_term[$term->name] = array();
		} else {
			$by_term[$term->name] = $posts;
		}
	}

	// Add uncategorized items to posts by term if parameter is set.
	if ( $params['show_uncategorized'] ) {
		$terms = get_terms( $params['taxonomy'], array( 'fields' => 'ids', 'hide_empty' => false ) );
		$args['tax_query'][0]['terms'] = $terms;
		$args['tax_query'][0]['operator'] = 'NOT IN';
		$uncat_posts = get_posts( $args );
		if ( count( $uncat_posts == 0 ) && $params['show_empty_sections'] ) {
			$by_term[$params['uncategorized_term_name']] = array();
		} else {
			$by_term[$params['uncategorized_term_name']] = $uncat_posts;
		}
	}

	// Split up this post type's posts by the first alpha character
	$args['orderby'] = 'title';
	$args['order'] = 'ASC';
	$args['tax_query'] = '';
	$by_alpha_posts = get_posts( $args );
	foreach( $by_alpha_posts as $post ) {
		if ( preg_match( '/([a-zA-Z])/', $post->post_title, $matches ) == 1 ) {
			$by_alpha[strtoupper($matches[1])][] = $post;
		} else {
			$by_alpha[$params['non_alpha_section_name']][] = $post;
		}
	}
	if( $params['show_empty_sections'] ) {
		foreach( range( 'a', 'z' ) as $letter ) {
			if ( !isset( $by_alpha[strtoupper( $letter )] ) ) {
				$by_alpha[strtoupper( $letter )] = array();
			}
		}
	}
	ksort( $by_alpha );

	$sections = array(
		'post-type-search-term'  => $by_term,
		'post-type-search-alpha' => $by_alpha,
	);

	ob_start();
?>
	<div class="post-type-search">
		<div class="post-type-search-header">
			<form class="post-type-search-form form-inline" action="." method="get">
				<label><?php echo $params['default_search_label']; ?></label>
				<input type="text" class="form-control" placeholder="<?php echo $params['default_search_text']; ?>">
			</form>
		</div>
		<div class="post-type-search-results"></div>
		<?php if ( $params['show_sorting'] ) { ?>
		<div class="btn-group post-type-search-sorting">
			<button class="btn btn-default<?php if ( $params['default_sorting'] == 'term' ) echo ' active'; ?>">
				<span class="glyphicon glyphicon-list-alt"></span>
			</button>
			<button class="btn btn-default<?php if ( $params['default_sorting'] == 'alpha' ) echo ' active'; ?>">
				<span class="glyphicon glyphicon-font"></span>
			</button>
		</div>
		<?php } ?>
	<?php

	foreach ( $sections as $id => $section ):
		$hide = false;
		switch ( $id ) {
			case 'post-type-search-alpha':
				if ( $params['default_sorting'] == 'term' ) {
					$hide = True;
				}
				break;
			case 'post-type-search-term':
				if ( $params['default_sorting'] == 'alpha' ) {
					$hide = True;
				}
				break;
		}
?>
		<div class="<?php echo $id; ?>"<?php if ( $hide ) { echo ' style="display:none;"'; } ?>>
			<div class="row">
			<?php
			$count = 0;
			foreach ( $section as $section_title => $section_posts ):
				if ( count( $section_posts ) > 0 || $params['show_empty_sections'] ):
			?>

				<?php if ( $section_title == $params['uncategorized_term_name'] ): ?>
					</div>
						<div class="row">
							<div class="<?php echo $params['column_width']; ?>">
								<h3><?php echo esc_html( $section_title ); ?></h3>
							</div>
						</div>

						<div class="row">
						<?php
						// $split_size must be at least 1
						$split_size = max( floor( count( $section_posts ) / $params['column_count'] ), 1 );
						$split_posts = array_chunk( $section_posts, $split_size );
						foreach ( $split_posts as $index => $column_posts ):
						?>
							<div class="<?php echo $params['column_width']; ?>">
								<ul>
								<?php foreach( $column_posts as $key => $post ): ?>
									<li data-post-id="<?php echo $post->ID; ?>">
										<?php echo $post_type->toHTML( $post ); ?><span class="search-post-pgsection"><?php echo $section_title; ?></span>
									</li>
								<?php endforeach; ?>
								</ul>
							</div>
						<?php endforeach; ?>

				<?php else: ?>

					<?php if ( $count % $params['column_count'] == 0 && $count !== 0 ): ?>
						</div><div class="row">
					<?php endif; ?>

					<div class="<?php echo $params['column_width']; ?>">
						<h3><?php echo esc_html( $section_title ); ?></h3>
						<ul>
						<?php foreach( $section_posts as $post ):  ?>
							<li data-post-id="<?php echo $post->ID; ?>">
								<?php echo $post_type->toHTML( $post ); ?><span class="search-post-pgsection"><?php echo $section_title; ?></span>
							</li>
						<?php endforeach; ?>
						</ul>
					</div>

			<?php
					endif;

				$count++;
				endif;

			endforeach;
			?>
			</div><!-- .row -->
		</div><!-- term/alpha section -->

	<?php endforeach; ?>

	</div><!-- .post-type-search -->

<?php
	return ob_get_clean();
}
add_shortcode( 'post-type-search', 'sc_post_type_search' );



/**
 * Handles the form output and input for the phonebook search.
 *
 * @return string
 * @author Chris Conover
 **/
function sc_phonebook_search($attrs) {
	$show_label = isset($attrs['show_label']) && (bool)$attrs['show_label'] ? '' : ' hidden';
	$input_size = isset($attrs['input_size']) && $attrs['input_size'] != '' ? $attrs['input_size'] : 'col-md-9 col-sm-9';

	# Looks up search term in the search service
	$phonebook_search_query = '';
	$results                = array();
	if(isset($_GET['phonebook-search-query'])) {
		$phonebook_search_query = $_GET['phonebook-search-query'];
		$results                = query_search_service(array('search'=>$phonebook_search_query));
	}

	# Filter out the result types that we don't understand
	# We only understand organizations, departments, and staff
	$results = array_filter(
		$results,
		create_function('$r', 'return in_array($r->from_table, array(\'organizations\', \'departments\', \'staff\'));')
	);

	foreach ( $results as $result ) {
		$result->email = trim( $result->email );
	}

	# Filter out records with Fax in the name
	$results = array_filter($results, create_function('$r', '
			return (preg_match("/^fax\s/i", $r->name) ||
						preg_match("/\sfax\s/i", $r->name) ||
							preg_match("/\sfax$/i", $r->name)) ? False : True;')
	);

	# Limit results to 300 entries
	$additional_results = (count($results) > 300);
	if($additional_results) {
		$results = array_slice($results, 0, 299);
	}

	$organizations = array();
	$departments   = array();

	# Attach staff to organizations and departments;
	# only use alpha person results to avoid duplicates
	foreach($results as $key => $result) {
		$is_organization = ($result->from_table == 'organizations');
		$is_department   = ($result->from_table == 'departments');
		if($is_organization || $is_department) {
			$result->staff = array();
			$emails = array();
			foreach($results as $_result) {
				if($_result->from_table == 'staff') {
					if(
						( $is_organization ) &&
						( $result->name == $_result->organization ) &&
						( ! in_array( $_result->email, $emails ) ) )
						{
						$emails[] = $_result->email;
						$result->staff[$_result->last_name.'-'.$result->first_name.'-'.$_result->id] = $_result;
					} else if(
						( $is_department ) &&
						( $result->name == $_result->department ) &&
						( ! in_array( $_result->email, $emails ) ) )
						{
						$emails[] = $_result->email;
						$result->staff[$_result->last_name.'-'.$result->first_name.'-'.$_result->id] = $_result;
					}
				}
				# Make sure that $result->staff[] is alphabetized
				ksort($result->staff);
			}
		}
		# Separate organizations and departments so we can
		# reorder them later
		if ($is_organization) {
			$organizations[] = $result;
			unset($results[$key]);
		}
		if ($is_department) {
			$departments[] = $result;
			unset($results[$key]);
		}
	}

	# Lump duplicate person data under that person's alpha info
	foreach($results as $key => $result) {
		$staff = ($result->from_table == 'staff');
		if( $staff ) {
			foreach ($results as $_key=>$_result) {
				# If two email addresses match and are not null,
				# lump the secondary listing under the alpha listing
				# array (generated on the fly)
				if (
					( $result->email !== null ) &&
					( $_result->email !== null ) &&
					( $result != $_result ) &&
					( $_result->email == $result->email ) )
					{
					$_result->secondary[] = $result;
					unset($results[$key]);
				}
			}
		}
	}

	# Reorder results: Organizations, then Departments, then Staff
	$results = array_merge($organizations, $departments, $results);


	# Helper function for naming consistencies
	function fix_name_case($name) {
		$name = ucwords(strtolower($name));
		$name = str_replace('Ucf', 'UCF', $name);
		$name = str_replace('dr.', 'Dr.', $name);
		$name = str_replace('alumni', 'Alumni', $name);
		$name = str_replace(' And ', ' and ', $name);
		$name = str_replace('Cosas ', ' COSAS ', $name);
		$name = str_replace('Creol', 'CREOL', $name);
		$name = str_replace('Lead Scholars', 'LEAD Scholars', $name);
		$name = str_replace('Rotc', 'ROTC', $name);
		$name = preg_replace('/\bSdes\b/', 'SDES', $name);
		$name = str_replace(' Of ', ' of ', $name);
		$name = preg_replace('/\sOf$/', ' of', $name);
		$name = str_replace(' For ', ' for ', $name);
		$name = preg_replace('/\sFor$/', ' for', $name);
		$name = str_replace('&public', '&amp; Public', $name);
		$name = str_replace('Student-athletes', 'Student Athletes', $name);
		$name = str_replace('Wucf', 'WUCF', $name);
		$name = str_replace('WUCF Tv', 'WUCF TV', $name);
		$name = str_replace('WUCF-fm', 'WUCF-FM', $name);
		$name = preg_replace_callback('/\([a-z]+\)/', create_function('$m', 'return strtoupper($m[0]);'), $name);
		$name = preg_replace_callback('/\([a-z]{1}/', create_function('$m', 'return strtoupper($m[0]);'), $name);
		return $name;
	}

	# Display single result name, position, dept, and org
	function display_primary_info($result) {
		ob_start(); ?>

		<span class="name">
			<strong><?php echo ($result->from_table == 'organizations') ? fix_name_case($result->name) : $result->name; ?></strong>
		</span>
		<?php if ($result->from_table == 'staff' && $result->job_position) { ?>
		<span class="job-title">
			<?php echo $result->job_position; ?>
		</span>
		<?php } ?>
		<?php if($result->from_table == 'departments' && $result->organization) { ?>
		<span class="division">
			A division of: <a href="?phonebook-search-query=<?php echo urlencode($result->organization); ?>"><?php echo fix_name_case($result->organization); ?></a>
		</span>
		<?php } ?>
		<?php if($result->from_table == 'staff' && $result->department) { ?>
		<span class="department">
			<a href="?phonebook-search-query=<?php echo urlencode($result->department); ?>"><?php echo $result->department; ?></a>
		</span>
		<?php } ?>
		<?php if($result->from_table == 'staff' && $result->organization) { ?>
		<span class="organization">
			<a href="?phonebook-search-query=<?php echo urlencode($result->organization); ?>"><?php echo fix_name_case($result->organization); ?></a>
		</span>
		<?php }

		return ob_get_clean();
	}

	# Display single result location information
	function display_location_info($result) {
		ob_start(); ?>

		<?php if($result->from_table == 'staff' && $result->email) { ?>
		<span class="email">
			<a href="mailto:<?php echo $result->email; ?>"><?php echo $result->email; ?></a>
		</span>
		<?php } ?>
		<?php if ($result->building) { ?>
		<span class="location">
			<a href="http://map.ucf.edu/?show=<?php echo $result->bldg_id ?>">
				<?php echo fix_name_case($result->building); ?>
				<?php if($result->room) {
					echo ' - '.$result->room;
				} ?>
			</a>
		</span>
		<?php } ?>
		<?php if ($result->postal) { ?>
			<span class="postal">Zip: <?=$result->postal; ?></span>
		<?php }

		return ob_get_clean();
	}

	# Display single result phone/fax information
	function display_contact_info($result) {
		ob_start(); ?>

		<?php if($result->phone) { ?>
		<span class="phone">Phone: <a href="tel:<?= str_replace("-", "", $result->phone); ?>"><?= $result->phone; ?></a></span>
		<?php } ?>
		<?php if($result->from_table !== 'staff' && $result->fax) { ?>
		<span class="fax">Fax: <?=$result->fax; ?></span>
		<?php }

		return ob_get_clean();
	}


	ob_start();?>
	<form id="phonebook-search">
		<div class="row">
			<div class="col-md-6 col-sm-10">
				<label class="<?php echo $show_label ?>" for="phonebook-search-query">Search Term</label>
				<input type="text" id="phonebook-search-query" name="phonebook-search-query" class="search-query form-control"
					value="<?php echo stripslashes(htmlentities($phonebook_search_query)); ?>">
				<span class="help-block">Organization, Department, or Person (Name, Email, Phone)</span>
			</div>
			<div class="col-md-2 col-sm-2">
				<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Search</button>
			</div>
		</div>
	</form>
	<?php
	if($phonebook_search_query != '') {
		?>
		<?php if(count($results) == 0) { ?>
		<p><strong><big>No results were found.</big></strong></p>
		<?php
		} else {
			if($additional_results) { ?>
				<p id="additional_results">First 300 results returned. Try narrowing your search.</p>
			<?php } ?>
		<ul id="phonebook-search-results">
			<?php foreach($results as $i => $result) { ?>
				<li class="result<?php if ($result->from_table == 'departments' || $result->from_table == 'organizations') { ?> group-result<?php } ?>">
					<table class="table">
						<tbody>
							<?php
								switch($result->from_table) {
									case 'staff':
										?>
										<tr>
											<td class="col-md-6 col-sm-6">
												<?=display_primary_info($result);?>
											</td>
											<td class="col-md-3 col-sm-3">
												<?=display_contact_info($result);?>
											</td>
											<td class="col-md-3 col-sm-3">
												<?=display_location_info($result);?>
											</td>
										<?php if (!empty($result->secondary)) { ?>
										</tr>
										<tr class="person-secondary-list">
											<td class="col-md-12 col-sm-12" colspan="3">
												<a class="toggle person-secondary"><span class="glyphicon glyphicon-plus"></span> More Results</a>
												<ul>
													<?php foreach ($result->secondary as $secondary) { ?>
													<li>
														<table class="table">
															<tbody>
																<tr>
																	<td class="col-md-6 col-sm-6">
																		<?=display_primary_info($secondary);?>
																	</td>
																	<td class="col-md-3 col-sm-3">
																		<?=display_contact_info($secondary);?>
																	</td>
																	<td class="col-md-3 col-sm-3">
																		<?=display_location_info($secondary);?>
																	</td>
																</tr>
															</tbody>
														</table>
													</li>
													<?php } ?>
												</ul>
											</td>
										<?php } ?>
										</tr>

							<?php
								break;
								case 'departments':
								case 'organizations':
									?>
									<tr>
										<td class="col-md-6 col-sm-6">
											<?=display_primary_info($result);?>
										</td>
										<td class="col-md-3 col-sm-3">
											<?=display_contact_info($result);?>
										</td>
										<td class="col-md-3 col-sm-3">
											<?=display_location_info($result);?>
										</td>
									<?php if(count($result->staff) > 0) { ?>
									</tr>
									<tr>
										<td colspan="3" class="show_staff col-md-12 col-sm-12">
											<a class="toggle"><span class="glyphicon glyphicon-plus"></span> Show Staff</a>
											<div class="show-staff-wrap">
												<ul class="staff-list">
													<?php
														$staff_per_column = ceil(count($result->staff) / 3);
														$count = 0;
													?>
													<?php foreach($result->staff as $person) { ?>
														<li>
															<?php if($person->email) { ?>
																<span class="email"><a href="mailto:<?php echo $person->email; ?>"><?php echo $person->name; ?></a></span>
															<?php } else { ?>
																<span class="name"><?php echo $person->name; ?></span>
															<?php } ?>
															<?php if($person->phone) { ?>
																<span class="phone"><a href="tel:<?= str_replace("-", "", $person->phone); ?>"><?= $person->phone; ?></a></span>
															<?php } ?>
														</li>
														<?php if( ((($count + 1) % $staff_per_column) == 0) && ($count + 1 !== count($result->staff))) {
															echo '</ul><ul class="staff-list">';
														}
														$count++;
													} ?>
												</ul>
											</div>
										</td>
										<?php } ?>
									</tr>
							<?php
								break;
							}
							?>
							</tbody>
						</table>
				</li>
			<?php } ?>
		<?php } ?>
	</ul>
	<?php }
	return ob_get_clean();
}
add_shortcode('phonebook-search', 'sc_phonebook_search');

/**
 * Authenticates the username/password combination with LDAP.
 *
 * @param string $username The username to authenticate.
 * @param string $password The password to authenticate.
 * @return bool True if username/password was authenticated, otherwise false
 *
 * @author Brandon T. Groves
 */
function ldap_auth($username, $password) {
	$ldapbind = false;
	$ldap = ldap_connect(LDAP_HOST);
	if ($ldap) {
		$ldapbind = ldap_bind($ldap, $username . '@' . LDAP_HOST, $password);
	} else {
		echo "could not connect.";
	}

	return $ldapbind;
}

/**
 * Sets the session data for gravity forms authentication.
 *
 * @author Brandon T. Groves
 */
function gf_set_session_data($user) {
	$timeout = 15 * 60;
	$_SESSION['timeout'] = time() + $timeout;
	$_SESSION['user'] = $user;
	$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
}

/**
 * Destroys the session data for gravity forms authentication.
 *
 * @author Brandon T. Groves
 */
function gf_destroy_session() {
	$_SESSION = array();
	session_destroy();
}

/**
 * Retrieves the login HTML.
 *
 * @error bool display error message
 * @return string html login
 *
 * @author Brandon T. Groves
 */
function gf_login_html($error = false) {
	ob_start();
	gf_destroy_session();
	// Force HTTPS
	$pageURL = "https://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
	?>

	<div id="ann-login-wrapper">
		<h2>Login</h2>
		<p>To post a new announcement, please log in using your NID and NID password below.<br/></p>
		<form method="post" id="auth-form" action="<?=$pageURL; ?>">
			<div class="wrapper">
				<?php if ($error):?>
				<div class="alert alert-danger" id="login_error">
					<strong>Error:</strong>
					<p>Your NID or password is invalid or the authentication service was unavailable.</p>
					<p>To verify your NID, go to <a href="http://my.ucf.edu/">myUCF</a> and select "What are my PID and NID?"<br/>
					To reset your password, go to the <a href="http://mynid.ucf.edu/">Change Your NID Password</a> page.<br/>
					For further help, contact the Service Desk at 407-823-5117, Monday-Friday 8am-5pm.</p>
				</div>
				<?php endif; ?>
				<div id="auth-form-items">
					<div class="form-group">
						<label for="username">NID (Network ID)</label>
						<input name="username" class="form-control" id="username" type="text">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input name="password" id="password" class="form-control" type="password">
					</div>
					<input name="submit-auth" class="btn btn-default" id="submit-auth" type="submit" value="Submit">
				</div>
			</div>
		</form>
	</div>

	<?php
	return ob_get_clean();
}

/**
 * Displays LDAP authentication unless already authenicated,
 * which displays the gravity form.
 *
 * @param array $username .
 * @param string $password The password to authenticate.
 * @return bool True if username/password was authenticated, otherwise false
 *
 * @author Brandon T. Groves
 */
function gravity_ldap($attr, $content = null) {

	if (isset($_SESSION['timeout']) && $_SESSION['timeout'] < time()) {
		gf_destroy_session();
	}

	require_once(WP_CONTENT_DIR . '/plugins/gravityforms/gravityforms.php');

	if (isset($_SESSION['user']) && isset($_SESSION['ip']) && $_SESSION['ip'] == $_SERVER['REMOTE_ADDR']) {
		gf_set_session_data($_SESSION['user']);
		return RGForms::parse_shortcode($attr, $content);
	} elseif (isset($_POST["submit-auth"]) && isset($_POST['username']) && strlen($_POST['username']) != 0 && isset($_POST['password']) && strlen($_POST['password']) != 0) {
		if (ldap_auth($_POST['username'], $_POST['password'])) {
			gf_set_session_data($_POST['username']);
			return RGForms::parse_shortcode($attr, $content);
		} else {
			return gf_login_html(True);
		}
	} else {
		return gf_login_html();
	}
}
add_shortcode('gravity-with-ldap', 'gravity_ldap');


/**
 * Output a list of A-Z Index Links with their Web Administrator
 * information.
 * (This is a separate shortcode only so that we aren't
 * modifying the azindexlink objectsToHtml or toHTML methods.)
 **/
function azindexlink_webadmins($attr) {
	$args = array(
		'post_type' => 'azindexlink',
		'numberposts' => -1,
		'orderby' => 'post_title',
		'order' => 'ASC',
	);
	$links = get_posts($args);

	$output = '<ul id="azindexlink-webadmins">';

	foreach ($links as $link) {
		$url = get_post_meta($link->ID, 'azindexlink_url', true);
		$webadmins = apply_filters('the_content', get_post_meta($link->ID, 'azindexlink_webadmins', true));
		$output .= '<li><a href="'.$url.'">'.$link->post_title.'</a>';
		if ($webadmins) {
			$output .= '<br/><p>'.$webadmins.'</p>';
		}
		$output .= '</li>';
	}

	$output .= '</ul>';
	return $output;
}
add_shortcode('azindexlinks-webadmins', 'azindexlink_webadmins');

function sc_remarketing_tag($attr) {
	$conversion_id = '';
	$img_src = '';

	if ( isset( $attr[ 'conversion_id' ] ) ) {
		$conversion_id = str_replace( array( '"', "'" ), '', $attr[ 'conversion_id' ] );
	} else {
		return '';
	}

	if ( isset( $attr[ 'img_src' ] ) ) {
		$img_src = str_replace( array( '"', "'" ), '', $attr[ 'img_src' ] );
	} else {
		return '';
	}

	ob_start();

	?>
	<script type="text/javascript">
		// <![CDATA[
		var google_conversion_id = <?php echo $conversion_id; ?>;
		var google_custom_params = window.google_tag_params;
		var google_remarketing_only = true;
		// ]]>
	</script>
	<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
	<noscript>
		<div style="display:inline;">
			<img height="1" width="1" style="border-style:none;" alt="" src="<?php echo $img_src; ?>" />
		</div>
	</noscript>
	<?php

	return ob_get_clean();
}

add_shortcode( 'google-remarketing', 'sc_remarketing_tag' );


function sc_undergrad_catalog_url( $attr ) {
	return UNDERGRAD_CATALOG_URL;
}
add_shortcode( 'undergraduate-catalog-url', 'sc_undergrad_catalog_url' );


function sc_grad_catalog_url( $attr ) {
	return GRAD_CATALOG_URL;
}
add_shortcode( 'graduate-catalog-url', 'sc_grad_catalog_url' );


function sc_chart( $attr ) {
	$id = $attr['id'] ? $attr['id'] : 'custom-chart';
	$type = $attr['type'] ? $attr['type'] : 'bar';
	$json = $attr['data'] ? $attr['data'] : '';
	$options = $attr['options'] ? $attr['options'] : '';

	if ( empty( $json ) ) {
		return;
	}

	$class = $attr['class'] ? 'custom-chart ' . $class : 'custom-chart';

	ob_start();

	?>
		<div id="<?php echo $id; ?>" class="<?php echo $class; ?>" data-chart-type="<?php echo $type; ?>" data-chart-data="<?php echo $json; ?>" <?php echo $options ? 'data-chart-options="' . $options . '"' : ''; ?>></div>
	<?php

	return ob_get_clean();
}
add_shortcode( 'chart', 'sc_chart' );


/**
 * Displays affixed navigation for the A-Z Index.
 **/
function sc_azindex_navbar( $attr ) {
	ob_start();
?>
	<div id="top"></div>

	<div id="azIndexList" data-spy="affix" data-offset-top="200">
		<span id="azIndexList-label">Jump To:</span>
		<div class="navbar navbar-default">
			<ul class="nav navbar-nav">
			<?php foreach ( range( 'A', 'Z' ) as $index=>$alpha ): ?>
				<li <?php echo $index === 0 ? 'class="active"' : ''; ?>>
					<a href="#az-<?php echo strtolower( $alpha ); ?>">
						<?php echo $alpha; ?>
					</a>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>
	</div>
<?php
	return ob_get_clean();
}
add_shortcode( 'azindex-navbar', 'sc_azindex_navbar' );


/**
 * Displays social media buttons for sharing a post.
 **/
function sc_social_share_buttons( $atts, $content='' ) {
	global $post;
	$url = get_permalink( $post->ID );
	$title = $post->post_title;

	$atts = shortcode_atts(
		array(
			'subject_line' => '',
			'email_body' => ''
		),
		$atts,
		'social-share-buttons'
	);

	return display_social( $url, $title, $atts['subject_line'], $atts['email_body'] );
}

add_shortcode( 'social-share-buttons', 'sc_social_share_buttons' );

?>
