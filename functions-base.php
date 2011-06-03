<?php

function __init__(){
	add_theme_support('menus');
	add_theme_support('thumbnails');
	register_nav_menus(array(
		'header-menu' => __('Header Menu'),
		'footer-menu' => __('Footer Menu'),
	));
}
add_action('init', '__init__');

function create_html_element($tag, $attr=array(), $content=null, $self_close=True){
	$attr_str = create_attribute_string($attr);
	if ($content){
		$element = "<{$tag}{$attr_str}>{$content}</{$tag}>";
	}else{
		if ($self_close){
			$element = "<{$tag}{$attr_str}/>";
		}else{
			$element = "<{$tag}{$attr_str}></{$tag}>";
		}
	}
	
	return $element;
}


function create_attribute_string($attr){
	$attr_string = '';
	foreach($attr as $key=>$value){
		$attr_string .= " {$key}='{$value}'";
	}
	return $attr_string;
}


function footer_(){
	ob_start();
	wp_footer();
	return ob_get_clean();
}


function header_(){
	ob_start();
	wp_head();
	print header_title();
	print header_meta();
	print header_links();
	return ob_get_clean();
}


function header_meta(){
	$metas     = Config::$metas;
	$meta_html = array();
	$defaults  = array();
	
	foreach($metas as $meta){
		$meta        = array_merge($defaults, $meta);
		$meta_html[] = create_html_element('meta', $meta);
	}
	$meta_html = implode("\n", $meta_html);
	return $meta_html;
}


function header_links(){
	$links      = Config::$links;
	$links_html = array();
	$defaults   = array();
	
	foreach($links as $link){
		$link         = array_merge($defaults, $link);
		$links_html[] = create_html_element('link', $link, null, False);
	}
	
	$links_html = implode("\n", $links_html);
	return $links_html;
}


function header_title(){
	$site_name = get_bloginfo('name');
	$separator = '|';

	if ( is_single() ) {
		$content = single_post_title('', FALSE);
	}
	elseif ( is_home() || is_front_page() ) { 
		$content = get_bloginfo('description');
	}
	elseif ( is_page() ) { 
		$content = single_post_title('', FALSE); 
	}
	elseif ( is_search() ) { 
		$content = __('Search Results for:', 'thematic'); 
		$content .= ' ' . esc_html(stripslashes(get_search_query()));
	}
	elseif ( is_category() ) {
		$content = __('Category Archives:', 'thematic');
		$content .= ' ' . single_cat_title("", false);;
	}
	elseif ( is_tag() ) { 
		$content = __('Tag Archives:', 'thematic');
		$content .= ' ' . thematic_tag_query();
	}
	elseif ( is_404() ) { 
		$content = __('Not Found', 'thematic'); 
	}
	else { 
		$content = get_bloginfo('description');
	}

	if (get_query_var('paged')) {
		$content .= ' ' .$separator. ' ';
		$content .= 'Page';
		$content .= ' ';
		$content .= get_query_var('paged');
	}

	if($content) {
		if (is_home() || is_front_page()) {
			$elements = array(
				'site_name' => $site_name,
				'separator' => $separator,
				'content' => $content,
			);
		} else {
			$elements = array(
				'content' => $content,
			);
		}  
	} else {
		$elements = array(
			'site_name' => $site_name,
		);
	}

	// Filters should return an array
	$elements = apply_filters('thematic_doctitle', $elements);

	// But if they don't, it won't try to implode
	if(is_array($elements)) {
	$doctitle = implode(' ', $elements);
	}
	else {
	$doctitle = $elements;
	}

	$doctitle = "\t" . "<title>" . $doctitle . "</title>" . "\n\n";

	return $doctitle;
}



/**
 * Returns string to use for value of class attribute on body tag
 **/
function body_classes(){
	$classes = array();
	$classes = array_merge($classes, browser_classes());
	
	return implode(' ', $classes);
}


/**
 * Returns a list of classes to determined by current user agent string, for
 * platform specific purposes.  Pulled from thematic wordpress theme
 * (http://themeshaper.com/)
 **/
function browser_classes() {
	// add 'class-name' to the $classes array
	// $classes[] = 'class-name';
	$browser = $_SERVER[ 'HTTP_USER_AGENT' ];
	
	// Mac, PC ...or Linux
	if ( preg_match( "/Mac/", $browser ) ){
		$classes[] = 'mac';
	} elseif ( preg_match( "/Windows/", $browser ) ){
		$classes[] = 'windows';
	} elseif ( preg_match( "/Linux/", $browser ) ) {
		$classes[] = 'linux';
	} else {
		$classes[] = 'unknown-os';
	}
	
	// Checks browsers in this order: Chrome, Safari, Opera, MSIE, FF
	if ( preg_match( "/Chrome/", $browser ) ) {
		$classes[] = 'chrome';
	
		preg_match( "/Chrome\/(\d.\d)/si", $browser, $matches);
		$ch_version = 'ch' . str_replace( '.', '-', $matches[1] );
		$classes[] = $ch_version;
	} elseif ( preg_match( "/Safari/", $browser ) ) {
		$classes[] = 'safari';
		
		preg_match( "/Version\/(\d.\d)/si", $browser, $matches);
		$sf_version = 'sf' . str_replace( '.', '-', $matches[1] );
		$classes[] = $sf_version;
	} elseif ( preg_match( "/Opera/", $browser ) ) {
		$classes[] = 'opera';
		
		preg_match( "/Opera\/(\d.\d)/si", $browser, $matches);
		$op_version = 'op' . str_replace( '.', '-', $matches[1] );
		$classes[] = $op_version;
	} elseif ( preg_match( "/MSIE/", $browser ) ) {
		$classes[] = 'msie';
		
		if( preg_match( "/MSIE 6.0/", $browser ) ) {
			$classes[] = 'ie6';
		} elseif ( preg_match( "/MSIE 7.0/", $browser ) ){
			$classes[] = 'ie7';
		} elseif ( preg_match( "/MSIE 8.0/", $browser ) ){
			$classes[] = 'ie8';
		}
	} elseif ( preg_match( "/Firefox/", $browser ) && preg_match( "/Gecko/", $browser ) ) {
			$classes[] = 'firefox';
			
			preg_match( "/Firefox\/(\d)/si", $browser, $matches);
			$ff_version = 'ff' . str_replace( '.', '-', $matches[1] );      
			$classes[] = $ff_version;
	} else {
		$classes[] = 'unknown-browser';
	}
	// return the $classes array
	return $classes;
}


function disallow_direct_load($page){
	if ($page == basename($_SERVER['SCRIPT_FILENAME'])){
		die('No');
	}
}


class ArgumentException extends Exception{}


class Config{
	static
		$links   = array(),
		$metas   = array();
	
	static function add_link($attr){
		if (!count($attr)){
			throw new ArgumentException('add_link expects a non-empty array of values to create tags.');
		}
		self::$links[] = $attr;
	}
	
	static function add_css($attr){
		if (!isset($attr['name']) or !isset($attr['src'])){
			throw new ArgumentException('add_css expects argument array to contain keys "name" and "src"');
		}
		$default = array('media' => 'all', 'admin' => False,);
		$attr    = array_merge($default, $attr);
		
		if ($attr['admin'] or !is_admin()){
			wp_deregister_style($attr['name']);
			wp_enqueue_style($attr['name'], $attr['src'], null, null, $attr['media']);
		}
	}
	
	static function add_meta($attr){
		if (!count($attr)){
			throw new ArgumentException('add_meta expects a non-empty array of values to create tags.');
		}
		self::$metas[] = $attr;
	}
	
	static function add_script($attr){
		if (!isset($attr['name']) or !isset($attr['src'])){
			throw new ArgumentException('add_script expects argument array to contain keys "name" and "src"');
		}
		$default = array('admin' => False,);
		$attr    = array_merge($default, $attr);
		
		
		if ($attr['admin'] or !is_admin()){
			# Override previously defined scripts
			wp_deregister_script($attr['name']);
			wp_enqueue_script($attr['name'], $attr['src'], null, null, True);
		}
	}
}

?>