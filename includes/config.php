<?php
/**
 * Handle all theme configuration here
 **/

define( 'THEME_URL', get_stylesheet_directory_uri() );
define( 'THEME_STATIC_URL', THEME_URL . '/static' );
define( 'THEME_CSS_URL', THEME_STATIC_URL . '/css' );

function __init__() {

}

add_action( 'init', '__init__' );

function enqueue_frontend_assets() {
	wp_enqueue_style( 'style', THEME_CSS_URL . '/style.min.css' );

	// Deregister jquery and re-register newer version.
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', '//code.jquery.com/jquery-3.2.1.min.js', null, null, true );
	wp_enqueue_script( 'jquery' );

	wp_enqueue_script( 'script', THEME_JS_URL . '/framework.min.js', array( 'jquery' ), null, true );
}

add_action( 'wp_enqueue_scripts', 'enqueue_frontend_assets', 99, 0 );
