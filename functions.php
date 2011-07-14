<?php
# Define stuff
define('THEME_URL', get_bloginfo('stylesheet_directory'));
define('THEME_DIR', get_stylesheet_directory());
define('THEME_STATIC_URL', THEME_URL.'/static');
define('THEME_IMG_URL', THEME_STATIC_URL.'/img');
define('THEME_JS_URL', THEME_STATIC_URL.'/js');
define('THEME_CSS_URL', THEME_STATIC_URL.'/css');

require_once('functions-base.php');     # "Base Theme" Functions
require_once('custom-post-types.php');  # Where per theme post types are defined
require_once('shortcodes.php');         # Per theme shortcodes

if (is_admin()){
	require_once('functions-admin.php');
}

if (is_login()){
	require_once('functions-admin.php');
	add_action('login_head', 'login_scripts', 0);
}

/**
 * Set config values including meta tags, registered custom post types, styles,
 * scripts, and any other statically defined assets that belong in the Config
 * object.
 **/
Config::$custom_post_types = array('Example',);

Config::$metas = array(
	array('charset' => 'utf-8',),
);

Config::$styles = array(
	array('admin' => True, 'src' => THEME_CSS_URL.'/admin.css',),
	'http://universityheader.ucf.edu/bar/css/bar.css',
	THEME_CSS_URL.'/jquery-ui.css',
	THEME_CSS_URL.'/jquery-uniform.css',
	THEME_CSS_URL.'/blueprint-screen.css',
	array('media' => 'print', 'src' => THEME_CSS_URL.'/blueprint-print.css',),
	THEME_CSS_URL.'/yahoo-reset.css',
	THEME_CSS_URL.'/yahoo-fonts.css',
	THEME_CSS_URL.'/webcom-base.css',
	get_bloginfo('stylesheet_url'),
);
Config::$scripts = array(
	array('admin' => True, 'src' => THEME_JS_URL.'/admin.js',),
	'http://universityheader.ucf.edu/bar/js/university-header.js',
	array('name' => 'jquery', 'src' => 'http://code.jquery.com/jquery-1.6.1.min.js',),
	THEME_JS_URL.'/jquery-ui.js',
	THEME_JS_URL.'/jquery-browser.js',
	THEME_JS_URL.'/jquery-uniform.js',
	array('name' => 'theme-script', 'src' => THEME_JS_URL.'/script.js',),
);