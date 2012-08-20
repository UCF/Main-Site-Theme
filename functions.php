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
			print get_post_meta( $post->ID, 'ss_slider_slidecount', true );
			break;
		case 'shortcode':
			print '<span class="shortcode-field">[centerpiece id="'. $post->post_name . '"]</span>';
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



/**
 * Adds a subheader to a page (if one is set for the page.)
 **/
function get_page_subheader($post) {
	if (get_post_meta($post->ID, 'page_subheader', TRUE) !== '') {
		$subheader = get_post(get_post_meta($post->ID, 'page_subheader', TRUE));			
		?>
		<div class="span12" id="subheader">
			<?php
			$subimg = get_post_meta($subheader->ID, 'subheader_sub_image', TRUE);
			$imgatts = array(
				'class'	=> "subheader_subimg span2",
				'alt'   => $post->post_title,
				'title' => $post->post_title,
			);
			print wp_get_attachment_image($subimg, 'subpage-subimg', 0, $imgatts);
			?>
			<blockquote class="subhead_quote span8">
				<?=$subheader->post_content?>
				<p class="subhead_author"><?=get_post_meta($subheader->ID, 'subheader_student_name', TRUE)?></p>
				<p class="subhead_quotelink"><a href="<?=get_permalink(get_page_by_title( 'Submit a Quote About UCF', OBJECT, 'page' )->ID)?>">Submit a quote &raquo;</a></p>
			</blockquote>
			
			<?php
			$studentimg = get_post_meta($subheader->ID, 'subheader_student_image', TRUE);
			$imgatts = array(
				'class'	=> "subheader_studentimg",
				'alt'   => get_post_meta($subheader->ID, 'subheader_student_name', TRUE),
				'title' => get_post_meta($subheader->ID, 'subheader_student_name', TRUE),
			);
			print wp_get_attachment_image($studentimg, 'subpage-studentimg', 0, $imgatts);
			?>
		</div>
	<?php
	}
}

?>