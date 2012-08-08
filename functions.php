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
 * Stolen from SmartStart theme
**/

// Set up the metabox fields:
$slider_prefix = 'ss_';
$slider_metabox_basic = array(
	'id' => 'slider-slides-settings-basic',
	'title' => 'Basic Slider Display Options',
	'page' => 'slider',
	'context' => 'side',
	'priority' => 'default',
	'fields' => array(
		// Basic:
			array(
				'name'    => __('Transition type for the animation'),
				'id'      => $prefix . 'slider_transition',
				'type'    => 'select',
				'std'     => 'random',
				'desc'    => '',
				'options' => array(
					'def'                 => 'def',
					'fade'                => 'fade',
					'seqFade'             => 'seqFade',
					'horizontalSlide'     => 'horizontalSlide',
					'seqHorizontalSlide'  => 'seqHorizontalSlide',
					'verticalSlide'       => 'verticalSlide',
					'seqVerticalSlide'    => 'seqVerticalSlide',
					'verticalSlideAlt'    => 'verticalSlideAlt',
					'seqVerticalSlideAlt' => 'seqVerticalSlideAlt',
					'random'              => 'random'
				)
			),	
			array(
				'name' => __('Speed of the animation transition'),
				'id'   => $prefix . 'slider_speed',
				'type' => 'text',
				'std'  => '400',
				'desc' => ''
			),
			array(
				'name' => __('Time between slide transitions'),
				'id'   => $prefix . 'slider_autoplay',
				'type' => 'text',
				'std'  => '3000',
				'desc' => __('0 to disable autoplay.')
			),
			array(
				'name' => __('Interval between each slide\'s animation'),
				'id'   => $prefix . 'slider_seq_factor',
				'type' => 'text',
				'std'  => '100',
				'desc' => __('Used for seqFade, seqHorizontalSlide, seqVerticalSlide &amp; seqVerticalSlideAlt.')
			),
			array(
				'name' => __('First slide to be displayed'),
				'id'   => $prefix . 'slider_first_slide',
				'type' => 'text',
				'std'  => '0',
				'desc' => __('Zero-based index.')
			),		
	)
);
$slider_metabox_advanced = array(
	'id' => 'slider-slides-settings-advanced',
	'title' => 'Advanced Slider Display Options',
	'page' => 'slider',
	'context' => 'side',
	'priority' => 'default',
	'fields' => array(
		// Advanced:
			array(
				'name'    => __('Easing type for the animation'),
				'id'      => $prefix . 'slider_easing',
				'type'    => 'select',
				'std'     => 'easeInOutExpo',
				'desc'    => '',
				'options' => array(
					'linear'           => 'linear',
					'swing'            => 'swing',
					'jswing'           => 'jswing',
					'easeInQuad'       => 'easeInQuad',
					'easeOutQuad'      => 'easeOutQuad',
					'easeInOutQuad'    => 'easeInOutQuad',
					'easeInCubic'      => 'easeInCubic',
					'easeOutCubic'     => 'easeOutCubic',
					'easeInOutCubic'   => 'easeInOutCubic',
					'easeInQuart'      => 'easeInQuart',
					'easeOutQuart'     => 'easeOutQuart',
					'easeInOutQuart'   => 'easeInOutQuart',
					'easeInQuint'      => 'easeInQuint',
					'easeOutQuint'     => 'easeOutQuint',
					'easeInOutQuint'   => 'easeInOutQuint',
					'easeInSine'       => 'easeInSine',
					'easeOutSine'      => 'easeOutSine',
					'easeInOutSine'    => 'easeInOutSine',
					'easeInExpo'       => 'easeInExpo',
					'easeOutExpo'      => 'easeOutExpo',
					'easeInOutExpo'    => 'easeInOutExpo',
					'easeInCirc'       => 'easeInCirc',
					'easeOutCirc'      => 'easeOutCirc',
					'easeInOutCirc'    => 'easeInOutCirc',
					'easeInElastic'    => 'easeInElastic',
					'easeOutElastic'   => 'easeOutElastic',
					'easeInOutElastic' => 'easeInOutElastic',
					'easeInBack'       => 'easeInBack',
					'easeOutBack'      => 'easeOutBack',
					'easeInOutBack'    => 'easeInOutBack',
					'easeInBounce'     => 'easeInBounce',
					'easeOutBounce'    => 'easeOutBounce',
					'easeInOutBounce'  => 'easeInOutBounce'
				)
			),
			array(
				'name' => __('Pause autoplay on mouseover'),
				'id'   => $prefix . 'slider_pause_on_hover',
				'type' => 'checkbox',
				'std'  => '1',
				'desc' => ''
			),
			array(
				'name' => __('Stop autoplay on click'),
				'id'   => $prefix . 'slider_stop_on_click',
				'type' => 'checkbox',
				'std'  => '0',
				'desc' => ''
			),
			array(
				'name'    => __('Content box position'),
				'id'      => $prefix . 'slider_content_position',
				'type'    => 'select',
				'std'     => 'def',
				'desc'    => '',
				'options' => array(
					''     => 'default',
					'center' => 'center',
					'bottom' => 'bottom'
				)
			),
			array(
				'name' => __('Speed of the content box transition'),
				'id'   => $prefix . 'slider_content_speed',
				'type' => 'text',
				'std'  => '450',
				'desc' => ''
			),
			array(
				'name' => __('Show content box only on mouseover'),
				'id'   => $prefix . 'slider_show_content_onhover',
				'type' => 'checkbox',
				'std'  => '1',
				'desc' => ''
			),
			array(
				'name' => __('Hide content box'),
				'id'   => $prefix . 'slider_hide_content',
				'type' => 'checkbox',
				'std'  => '0',
				'desc' => ''
			),
			array(
				'name' => __('Hide bottom navigation buttons'),
				'id'   => $prefix . 'slider_hide_bottom_buttons',
				'type' => 'checkbox',
				'std'  => '0',
				'desc' => ''
			),
			array(
				'name' => __('Slider container height'),
				'id'   => $prefix . 'slider_height',
				'type' => 'text',
				'std'  => '380',
				'desc' => ''
			),
			array(
				'name' => __('Slider container width'),
				'id'   => $prefix . 'slider_width',
				'type' => 'text',
				'std'  => '940',
				'desc' => ''
			)
	)
);


// Add the box:
function add_slider_extra_metaboxes() {
	global $slider_metabox_basic, $slider_metabox_advanced;
	add_meta_box(
		$slider_metabox_basic['id'],
		$slider_metabox_basic['title'], 
		'show_slider_basic_metabox', 
		$slider_metabox_basic['page'], 
		$slider_metabox_basic['context'], 
		$slider_metabox_basic['priority']
	);
	add_meta_box(
		$slider_metabox_advanced['id'],
		$slider_metabox_advanced['title'], 
		'show_slider_advanced_metabox', 
		$slider_metabox_advanced['page'], 
		$slider_metabox_advanced['context'], 
		$slider_metabox_advanced['priority']
	);
}
add_action('add_meta_boxes', 'add_slider_extra_metaboxes');




// Show the basic options box's content:
function show_slider_basic_metabox() {
	global $slider_metabox_basic, $post;
	
	 // Use nonce for verification
	echo '<input type="hidden" name="slider_metabox_basic_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	echo '<table class="form-table">';
	foreach ($slider_metabox_basic['fields'] as $field) {
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

// Show the advanced options box's content:
function show_slider_advanced_metabox() {
	global $slider_metabox_advanced, $post;
	
	 // Use nonce for verification
	echo '<input type="hidden" name="slider_metabox_advanced_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	echo '<table class="form-table">';
	foreach ($slider_metabox_advanced['fields'] as $field) {
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
	global $slider_metabox_basic, $slider_metabox_advanced;
	// verify nonce
	if (!wp_verify_nonce($_POST['slider_metabox_basic_nonce'], basename(__FILE__))) {
		return $post_id;
	}
	if (!wp_verify_nonce($_POST['slider_metabox_advanced_nonce'], basename(__FILE__))) {
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
	foreach ($slider_metabox_basic['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
	foreach ($slider_metabox_advanced['fields'] as $field) {
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