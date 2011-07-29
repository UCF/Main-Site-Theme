<?php 

/**
 * Empty shortcode
 **/
function sc_empty_shortcode(){
	return 'shortcode';
}
add_shortcode('empty-shortcode', 'sc_empty_shortcode');


/**
 * Create a javascript slideshow of each top level element in the
 * shortcode.  All attributes are optional, but may default to less than ideal
 * values.  Available attributes:
 * 
 * height     => css height of the outputted slideshow, ex. height="100px"
 * width      => css width of the outputted slideshow, ex. width="100%"
 * transition => length of transition in milliseconds, ex. transition="1000"
 * cycle      => length of each cycle in milliseconds, ex cycle="5000"
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
	
	$height    = ($attr['height']) ? $attr['height'] : '100px';
	$width     = ($attr['width']) ? $attr['width'] : '100%';
	$tran_len  = ($attr['transition']) ? $attr['transition_length'] : 1000;
	$cycle_len = ($attr['cycle']) ? $attr['cycle_length'] : 5000;
	
	ob_start();
	?>
	<div 
		class="slideshow"
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


/**
 * Fetches objects defined by arguments passed, outputs the objects according
 * to the toHTML method located on the object.
 **/
function sc_object($attr){
	if (!is_array($attr)){return '';}
	
	$defaults = array(
		'tags'       => '',
		'categories' => '',
		'type'       => '',
		'limit'      => -1,
	);
	$options = array_merge($defaults, $attr);
	
	$tax_query = array(
		'relation' => 'OR',
	);
	
	if ($options['tags']){
		$tax_query[] = array(
			'taxonomy' => 'post_tag',
			'field'    => 'slug',
			'terms'    => explode(' ', $options['tags']),
		);
	}
	
	if ($options['categories']){
		$tax_query[] = array(
			'taxonomy' => 'category',
			'field'    => 'slug',
			'terms'    => explode(' ', $options['categories']),
		);
	}
	
	$query_array = array(
		'tax_query'      => $tax_query,
		'post_status'    => 'publish',
		'post_type'      => $options['type'],
		'posts_per_page' => $options['limit'],
	);
	$query = new WP_Query($query_array);
	
	global $post;
	ob_start();
	?>
	
	<ul class="object-list <?=$options['type']?>">
		<?php while($query->have_posts()): $query->the_post();
		$class = get_custom_post_type($post->post_type);
		$class = new $class;?>
		<li>
			<?=$class->toHTML($post->ID)?>
		</li>
		<?php endwhile;?>
	</ul>
	
	<?php
	$results = ob_get_clean();
	wp_reset_postdata();
	return $results;
}
add_shortcode('sc-object', 'sc_object');
?>