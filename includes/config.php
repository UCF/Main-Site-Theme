<?php
/**
 * Handle all theme configuration here
 **/

define( 'THEME_URL', get_stylesheet_directory_uri() );
define( 'THEME_STATIC_URL', THEME_URL . '/static' );
define( 'THEME_CSS_URL', THEME_STATIC_URL . '/css' );
define( 'THEME_JS_URL', THEME_STATIC_URL . '/js' );

function __init__() {
	add_theme_support( 'menus' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );

	add_theme_support( 'custom-header', array(
		'width'  => 1600,
		'height' => 400
	) );

	register_nav_menu( 'header-menu', __( 'Header Menu' ) );
	register_nav_menu( 'footer-menu', __( 'Footer Menu' ) );
}

add_action( 'after_setup_theme', '__init__' );

function enqueue_frontend_assets() {
	wp_enqueue_style( 'style', THEME_CSS_URL . '/style.min.css' );

	// Deregister jquery and re-register newer version.
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', '//code.jquery.com/jquery-3.2.1.min.js', null, null, true );
	wp_enqueue_script( 'jquery' );

	wp_enqueue_script( 'tether', 'https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js', null, null, true );
	wp_enqueue_script( 'script', THEME_JS_URL . '/framework.min.js', array( 'jquery', 'tether' ), null, true );
}

add_action( 'wp_enqueue_scripts', 'enqueue_frontend_assets' );
