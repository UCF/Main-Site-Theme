<?php

if (is_login()){
	add_action('login_head', 'login_scripts', 0);
}

if (is_admin()){
	add_action('admin_menu', 'create_utility_pages');
	add_action('admin_init', 'init_theme_options');
}


function shortcode_interface_html(){
	global $shortcode_tags;
	$shortcodes = $shortcode_tags;
	$ignore     = array(
		"wp_caption" => null,
		"caption"    => null,
		"gallery"    => null,
		"embed"      => null,
	);
	$shortcodes = array_diff_key($shortcodes, $ignore);
	ksort($shortcodes);
	?>
	<input type="text" name="shortcode-search" id="shortcode-search" />
	<button type="button">Search</button>
		
	<ul id="shortcode-results" class="empty">
	</ul>
		
	<p>Or select:</p>
	<select name="shortcode-select" id="shortcode-select">
		<option value="">--Choose Shortcode--</option>
		<?php foreach($shortcodes as $name=>$callback):?>
		<option class="shortcode" value="<?=$name?>"><?=$name?></option>
		<?php endforeach;?>
	</select>
	<?php
}


function shortcode_interface(){
	add_meta_box('shortcodes-metabox', __('Shortcodes'), 'shortcode_interface_html', 'page', 'side', 'low');
	#foreach(Config::$custom_post_types as $type){
	#	add_meta_box('', __(), '', $type);
	#}
}
add_action('add_meta_boxes', 'shortcode_interface');


/**
 * Prints out additional login scripts, called by the login_head action
 *
 * @return void
 * @author Jared Lang
 **/
function login_scripts(){
	ob_start();?>
	<link rel="stylesheet" href="<?=THEME_CSS_URL?>/admin.css" type="text/css" media="screen" charset="utf-8" />
	<?php 
	$out = ob_get_clean();
	print $out;
}


/**
 * Called on admin init, initialize admin theme here.
 *
 * @return void
 * @author Jared Lang
 **/
function init_theme_options(){
	register_setting(THEME_OPTIONS_GROUP, THEME_OPTIONS_NAME, 'theme_options_sanitize');
}


/**
 * Registers the theme options page with wordpress' admin.
 *
 * @return void
 * @author Jared Lang
 **/
function create_utility_pages() {
	add_utility_page(
		__(THEME_OPTIONS_PAGE_TITLE),
		__(THEME_OPTIONS_PAGE_TITLE),
		'edit_theme_options',
		'theme-options',
		'theme_options_page',
		THEME_IMG_URL.'/pegasus.png'
	);
	add_utility_page(
		__('Help'),
		__('Help'),
		'',
		'theme-help',
		'theme_help_page',
		THEME_IMG_URL.'/help.png'
	);
}


/**
 * Outputs theme help page
 *
 * @return void
 * @author Jared Lang
 **/
function theme_help_page(){
	include(THEME_INCLUDES_DIR.'/theme-help.php');
}


/**
 * Outputs the theme options page html
 *
 * @return void
 * @author Jared Lang
 **/
function theme_options_page(){
	include(THEME_INCLUDES_DIR.'/theme-options.php');
}


/**
 * Stub, processing on theme options input
 *
 * @return void
 * @author Jared Lang
 **/
function theme_options_sanitize($input){
	return $input;
}