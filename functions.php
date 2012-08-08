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
 * Slider post type meta field additions.
 * Easier to add it here than custom-post-types.php due to its advanced UI customizations.
 * Stolen from SmartStart theme
**/

// Set up the metabox fields:
$slider_prefix = 'ss_';
$slider_metabox = array(
	'id' => 'slider-slides-settings',
	'title' => 'Slides',
	'page' => 'slider',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('The Slides', 'ss_framework'),
			'id'   => $prefix . 'slider_slides',
			'type' => 'slider_slides',
			'std'  => '',
			'desc' => ''
		),
		/*
		array(
			'name' => 'Text box',
			'desc' => 'Enter something here',
			'id' => $slider_prefix . 'text',
			'type' => 'text',
			'std' => 'Default value 1'
		),
		array(
			'name' => 'Textarea',
			'desc' => 'Enter big text here',
			'id' => $slider_prefix . 'textarea',
			'type' => 'textarea',
			'std' => 'Default value 2'
		),
		array(
			'name' => 'Select box',
			'id' => $slider_prefix . 'select',
			'type' => 'select',
			'options' => array('Option 1', 'Option 2', 'Option 3')
		),
		array(
			'name' => 'Radio',
			'id' => $slider_prefix . 'radio',
			'type' => 'radio',
			'options' => array(
				array('name' => 'Name 1', 'value' => 'Value 1'),
				array('name' => 'Name 2', 'value' => 'Value 2')
			)
		),
		array(
			'name' => 'Checkbox',
			'id' => $slider_prefix . 'checkbox',
			'type' => 'checkbox'
		)
		*/
	)
);

// Add the box:
function add_slider_content_metabox() {
	global $slider_metabox;
	add_meta_box($slider_metabox['id'], $slider_metabox['title'], 'show_slider_content_metabox', $slider_metabox['page'], $slider_metabox['context'], $slider_metabox['priority']);
}
add_action('add_meta_boxes', 'add_slider_content_metabox');

// Show the box's content:
function show_slider_content_metabox() {
	global $slider_metabox, $post;
	
	 // Use nonce for verification
	echo '<input type="hidden" name="slider_metabox_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	echo '<table class="form-table">';
	foreach ($slider_metabox['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		echo '<tr>',
		'<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
		'<td>';
		switch ($field['type']) {
			case 'text':
				echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br />', $field['desc'];
				break;
			case 'textarea':
				echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '<br />', $field['desc'];
				break;
			case 'select':
				echo '<select name="', $field['id'], '" id="', $field['id'], '">';
				foreach ($field['options'] as $option) {
					echo '<option ', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
				}
				echo '</select>';
				break;
			case 'radio':
				foreach ($field['options'] as $option) {
					echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
				}
				break;
			case 'checkbox':
				echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
				break;
		}
		echo '</td><td>',
		'</td></tr>';
	}
	echo '</table>';
}


// Save data from the meta box content:
function save_slider_content_data($post_id) {
	global $slider_metabox;
	// verify nonce
	if (!wp_verify_nonce($_POST['slider_metabox_nonce'], basename(__FILE__))) {
		return $post_id;
	}
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
	// check permissions
	if (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
	foreach ($slider_metabox['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
}
add_action('save_post', 'save_slider_content_data');




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

?>