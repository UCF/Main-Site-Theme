<?php
require_once('functions/base.php');   			# Base theme functions
require_once('functions/feeds.php');			# Where functions related to feed data live
require_once('custom-taxonomies.php');  		# Where per theme taxonomies are defined
require_once('custom-post-types.php');  		# Where per theme post types are defined
require_once('functions/admin.php');  			# Admin/login functions
require_once('functions/config.php');			# Where per theme settings are registered
require_once('shortcodes.php');         		# Per theme shortcodes

//Add theme-specific functions here.


/** 
 * Slider post type customizations 
 * Stolen from SmartStart theme
 **/

// Custom columns for 'Slider' post type
function ss_framework_edit_slider_columns() {
	$columns = array(
		'cb'          => '<input type="checkbox" />',
		'title'       => __( 'Name' ),
		'slide_count' => __( 'Slide Count' ),
		'shortcode'   => __( 'Shortcode' )
	);
	return $columns;
}
add_action('manage_edit-slider_columns', 'ss_framework_edit_slider_columns');

// Custom columns content for 'Slider'
function ss_framework_manage_slider_columns( $column, $post_id ) {
	global $post;
	switch ( $column ) {
		case 'slide_count':
			$slider_slides = get_post_meta( $post->ID, $id, true ) ? get_post_meta( $post->ID, $id, true ) : false;
			$slide_count = count( unserialize( $slider_slides['ss_slider_slides'][0] ) );
			echo $slide_count;
			break;
		case 'shortcode':
			echo '<span class="shortcode-field">[slider id="'. $post->post_name . '"]</span>';
			break;
		default:
			break;
	}
}
add_action('manage_slider_posts_custom_column', 'ss_framework_manage_slider_columns', 10, 2);

// Sortable custom columns for 'Slider'
function ss_framework_sortable_slider_columns( $columns ) {
	$columns['slide_count'] = 'slide_count';
	return $columns;
}
add_action('manage_edit-slider_sortable_columns', 'ss_framework_sortable_slider_columns');

// Change default title for 'Slider'
function ss_framework_change_slider_title( $title ){
	$screen = get_current_screen();
	if ( $screen->post_type == 'slider' )
		$title = __('Enter slider name here');
	return $title;
}
add_filter('enter_title_here', 'ss_framework_change_slider_title');



// enqueue scripts and styles, but only if is_admin
if(is_admin()) {
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_script('custom-js', get_template_directory_uri().'/static/js/custom-js.js');
	wp_enqueue_style('jquery-ui-custom', get_template_directory_uri().'/static/css/jquery-ui-custom.css');
}

?>