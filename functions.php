<?php
# Custom Child Theme Functions
# http://themeshaper.com/thematic-for-wordpress/guide-customizing-thematic-theme-framework/
require_once('custom-post-types.php');
require_once('shortcodes.php');

define('ADMISSIONS_THEME_URL', get_bloginfo('stylesheet_directory'));
define('ADMISSIONS_STATIC_URL', ADMISSIONS_THEME_URL.'/static');
define('ADMISSIONS_IMG_URL', ADMISSIONS_STATIC_URL.'/img');
define('ADMISSIONS_JS_URL', ADMISSIONS_STATIC_URL.'/js');
define('ADMISSIONS_CSS_URL', ADMISSIONS_STATIC_URL.'/css');

// Parent theme overrides and theme setttings
// ------------------------------------------

#Sets link to be included in head
$LINKS = array(
	"<link rel='stylesheet' type='text/css' href='http://universityheader.ucf.edu/bar/css/bar.css' media='all' />",
	"\n\t<!-- jQuery UI CSS -->",
	"<link rel='stylesheet' type='text/css' href='".ADMISSIONS_CSS_URL."/jquery-ui.css' media='screen, projection' />",
	"<link rel='stylesheet' type='text/css' href='".ADMISSIONS_CSS_URL."/jquery-uniform.css' media='screen, projection' />",
	"\n\t<!-- Blueprint CSS -->",
	"<link rel='stylesheet' type='text/css' href='".ADMISSIONS_CSS_URL."/blueprint-screen.css' media='screen, projection' />",
	"<link rel='stylesheet' type='text/css' href='".ADMISSIONS_CSS_URL."/blueprint-print.css' media='print' />",
	"<!--[if lt IE 8]><link rel='stylesheet' type='text/css' href='".ADMISSIONS_CSS_URL."/blueprint-ie.css' media='screen, projection' /><![endif]-->",
	"\n\t<!-- Template CSS -->",
	"<link rel='stylesheet' type='text/css' href='".ADMISSIONS_CSS_URL."/webcom-template.css' media='screen, projection' />",
);

#Sets scripts to be loaded at bottom of page
$SCRIPTS = array(
	"<script src='http://universityheader.ucf.edu/bar/js/university-header.js' type='text/javascript' ></script>",
	"\n\t<!-- jQuery UI Scripts -->",
	"<script src='".ADMISSIONS_JS_URL."/jquery-ui.js' type='text/javascript' ></script>",
	"<script src='".ADMISSIONS_JS_URL."/jquery-browser.js' type='text/javascript' ></script>",
	"<script src='".ADMISSIONS_JS_URL."/jquery-uniform.js' type='text/javascript' ></script>",
	"<script src='http://events.ucf.edu/tools/script.js' type='text/javascript'></script>",
	"<script type='text/javascript'>
		var ADMISSIONS_MISC_URL = '".ADMISSIONS_MISC_URL."';
		var GA_ACCOUNT       = 'UA-7506281-3';
	</script>",
	"<script src='".ADMISSIONS_JS_URL."/script.js' type='text/javascript'></script>",
);


function remove_widgitized_areas($content){
	$widgets_to_remove = array(
		'Index Top',
		'Index Insert',
		'Index Bottom',
		'Single Top',
		'Single Insert',
		'Single Bottom',
		'Page Top',
		'Page Bottom',
	);
	foreach($widgets_to_remove as $widget){
		unset($content[$widget]);
	}
	return $content;
}
add_action('thematic_widgetized_areas', 'remove_widgitized_areas');

function admissions_head_profile($profile){
	return "<head>";
}
add_filter('thematic_head_profile', 'admissions_head_profile');

function childtheme_doctitle($title){
	if ( is_home() || is_front_page() ) {
		return get_bloginfo('name');
	}
	return $title;
}
add_filter('thematic_doctitle', 'childtheme_doctitle');

function admissions_template_redirect(){
	global $post;
	$type  = $post->post_type;
	$title = get_the_title();
	switch($type){}
}
add_filter('template_redirect', 'admissions_template_redirect');


#Set html 5
function admissions_create_doctype() {
	$content  = "<!DOCTYPE html>\n";
	$content .= "<html";
    return $content;
} // end thematic_create_doctype
add_filter('thematic_create_doctype', 'admissions_create_doctype');


#Set utf-8 meta charset
function admissions_create_contenttype(){
	$content  = "\t<meta charset='utf-8'>\n";
	$content .= "\t<meta http-equiv='X-UA-COMPATIBLE' content='IE=IE8'>\n";
	ob_start();
	?>
	<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<style>article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section {display: block;}</style>
	<![endif]-->
<?php
	$content .= ob_get_clean();
	return $content;
}
add_filter('thematic_create_contenttype', 'admissions_create_contenttype');


#Override default stylesheets
function admissions_create_stylesheet($links){
	global $LINKS;
	$new_links = $LINKS;
	
	$links = explode("\n", $links);
	$links = array_map(create_function('$l', '
		return trim($l);
	'), $links);
	$links = array_filter($links, create_function('$l', '
		return (bool)trim($l);
	'));
	$links = array_merge($new_links, $links);
	
	return "\t".implode("\n\t", $links)."\n";
}
add_filter('thematic_create_stylesheet', 'admissions_create_stylesheet');


#Override default scripts
function admissions_head_scripts($scripts){}
add_filter('thematic_head_scripts', 'admissions_head_scripts');


#Append scripts to bottom of page
function admissions_after(){
	global $SCRIPTS;
	print "\t".implode("\n\t", $SCRIPTS);
}
add_filter('thematic_after', 'admissions_after');


#Add custom javascript to admin
function admissions_admin_scripts(){
	wp_enqueue_script('custom-admin', ADMISSIONS_JS_URL.'/admin.js', array('jquery'), False, True);
}
add_action('admin_enqueue_scripts', 'admissions_admin_scripts');

// Theme custom functions
// ----------------------
/**
 * Returns the name of the custom post type defined by $class
 *
 * @return string
 * @author Jared Lang
 **/
function get_custom_post_type($class){
	$installed = installed_custom_post_types();
	foreach($installed as $object){
		if (get_class($object) == $class){
			return $object->options('name');
		}
	}
	return null;
}


/**
 * Returns pages associated with the menu defined by $c;
 *
 * @return array
 * @author Jared Lang
 **/
function get_menu_pages($c){
	return get_posts(array(
		'numberposts' => -1,
		'orderby'     => 'menu_order',
		'order'       => 'ASC',
		'post_type'   => 'page',
		'category'    => get_category_by_slug($c)->term_id,
	));
}

function disallow_direct_load($page){
	if ( $page == basename($_SERVER['SCRIPT_FILENAME'])){
		die ( 'Please do not load this page directly. Thanks!' );
	}
}
?>