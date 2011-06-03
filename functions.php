<?php

# Custom Child Theme Functions
# http://themeshaper.com/thematic-for-wordpress/guide-customizing-thematic-theme-framework/
define('THEME_URL', get_bloginfo('stylesheet_directory'));
define('THEME_DIR', get_stylesheet_directory());
define('THEME_STATIC_URL', THEME_URL.'/static');
define('THEME_IMG_URL', THEME_STATIC_URL.'/img');
define('THEME_JS_URL', THEME_STATIC_URL.'/js');
define('THEME_CSS_URL', THEME_STATIC_URL.'/css');


require_once('functions-base.php');
require_once('custom-post-types.php');
require_once('shortcodes.php');


# Configure meta

#if (!is_admin()){
	Config::add_meta(array(
		'charset' => 'utf-8',
	));

	Config::add_css(array(
		'name'  => 'university-bar',
		'media' => 'all',
		'src'   => 'http://universityheader.ucf.edu/bar/css/bar.css',
	));
	Config::add_css(array(
		'name'  => 'jquery-ui',
		'media' => 'screen,projection',
		'src'   => THEME_CSS_URL.'/jquery-ui.css',
	));
	Config::add_css(array(
		'name'  => 'jquery-uniform',
		'media' => 'screen,projection',
		'src'   => THEME_CSS_URL.'/jquery-uniform.css',
	));
	Config::add_css(array(
		'name'  => 'blueprint-screen',
		'media' => 'screen,projection',
		'src'   => THEME_CSS_URL.'/blueprint-screen.css',
	));
	Config::add_css(array(
		'name'  => 'blueprint-print',
		'media' => 'print',
		'src'   => THEME_CSS_URL.'/blueprint-print.css',
	));
	Config::add_css(array(
		'name'  => 'yahoo-reset',
		'media' => 'all',
		'src'   => THEME_CSS_URL.'/yahoo-reset.css',
	));
	Config::add_css(array(
		'name'  => 'yahoo-fonts',
		'media' => 'all',
		'src'   => THEME_CSS_URL.'/yahoo-fonts.css',
	));
	Config::add_css(array(
		'name'  => 'webcom-base',
		'media' => 'all',
		'src'   => THEME_CSS_URL.'/webcom-base.css',
	));
	Config::add_css(array(
		'name'  => 'theme',
		'media' => 'all',
		'src'   => get_bloginfo('stylesheet_url'),
	));


	Config::add_script(array(
		'name' => 'university-header',
		'src'  => 'http://universityheader.ucf.edu/bar/js/university-header.js',
	));
	Config::add_script(array(
		'name' => 'jquery',
		'src'  => 'http://code.jquery.com/jquery-1.6.1.min.js',
	));
	Config::add_script(array(
		'name' => 'jquery-ui',
		'src'  => THEME_JS_URL.'/jquery-ui.js',
	));
	Config::add_script(array(
		'name' => 'jquery-browser',
		'src'  => THEME_JS_URL.'/jquery-browser.js',
	));
	Config::add_script(array(
		'name' => 'jquery-uniform',
		'src'  => THEME_JS_URL.'/jquery-uniform.js',
	));
#}