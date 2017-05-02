<?php
include_once 'includes/config.php';
include_once 'includes/wp-bs-navwalker.php';
include_once 'includes/header-functions.php';

/**
 * Enqueues assets for a particular page
 **/
function enqueue_page_assets() {
	global $post;

	if ( $post ) {

		$stylesheet = get_field( 'page_stylesheet', $post->ID );

		if ( $stylesheet ) {
			wp_enqueue_style( $post->post_name . '-stylesheet', $stylesheet );
		}

		$script = get_field( 'page_script', $post->ID );

		if ( $script ) {
			wp_enqueue_script( $post->post_name - '-script', $script, array( 'jquery' ), null, true );
		}
	}
}

add_action( 'wp_enqueue_scripts', 'enqueue_page_assets' );


/**
 * Utility function that returns an image url by its thumbnail size.
 **/
function get_attachment_src_by_size( $id, $size ) {
	$attachment = wp_get_attachment_image_src( $id, $size, false );
	if ( is_array( $attachment ) ) {
		return $attachment[0];
	}
	return $attachment;
}


/**
 * Section markup override
 **/
function add_section_markup_before( $content, $section ) {

	// Retrieve background image sizes
	$bg_images = array(
		'xs' => false,
		'sm' => false,
		'md' => false,
		'lg' => false,
		'xl' => false
	);
	$bg_image_xs_id = get_field( 'section_background_image_xs', $section->ID ); // -xs only
	$bg_image_sm_id = get_field( 'section_background_image', $section->ID );    // -sm+

	if ( $bg_image_xs_id ) {
		$bg_images['xs'] = get_attachment_src_by_size( $bg_image_xs_id, 'bg-img' );
	}
	if ( $bg_image_sm_id ) {
		$bg_images['sm'] = get_attachment_src_by_size( $bg_image_sm_id, 'bg-img-sm' );
		$bg_images['md'] = get_attachment_src_by_size( $bg_image_sm_id, 'bg-img-md' );
		$bg_images['lg'] = get_attachment_src_by_size( $bg_image_sm_id, 'bg-img-lg' );
		$bg_images['xl'] = get_attachment_src_by_size( $bg_image_sm_id, 'bg-img-xl' );

		$bg_images = array_unique( $bg_images ); // remove duplicate image sizes, in case an old image isn't pre-cropped
		$bg_images['fallback'] = end( $bg_images ); // use the largest-available image as the fallback <img>
		reset( $bg_images ); // reset pointer
	}

	// Retrieve color classes/custom definitions
	$bg_color = get_field( 'section_background_color', $section->ID );
	$bg_color_custom = get_field( 'section_background_color_custom', $section->ID );
	if ( $bg_color == 'custom' ) {
		$bg_color = false;
	}

	$text_color = get_field( 'section_text_color', $section->ID );
	$text_color_custom = get_field( 'section_text_color_custom', $section->ID );
	if ( $text_color == 'custom' ) {
		$text_color = false;
	}

	// Define classes for the section
	$section_classes = '';
	if ( $bg_images['fallback'] ) {
		$section_classes .= ' media-background-container';
	}
	if ( $bg_color ) {
		$section_classes .= ' ' . $bg_color;
	}
	if ( $text_color ) {
		$section_classes .= ' ' . $text_color;
	}

	// Define custom style attribute values for the section
	$style_attrs = '';
	if ( $bg_color_custom ) {
		$style_attrs .= 'background-color: '. $bg_color_custom .'; ';
	}
	if ( $text_color_custom ) {
		$style_attrs .= 'color: '. $text_color_custom .'; ';
	}

	// Define classes for the <picture> element
	$picture_classes = '';
	if ( !$bg_images['xs'] ) {
		// Hide the <picture> element at -xs breakpoint when no mobile image
		// is available
		$picture_classes .= 'hidden-xs-down ';
	}

	ob_start();
?>
	<section class="jumbotron jumbotron-fluid <?php echo $section_classes; ?>" style="<?php echo $style_attrs; ?>">
	<?php if ( $bg_images['fallback'] ) : ?>
		<picture class="<?php echo $picture_classes; ?>">
			<?php if ( $bg_images['xs'] ) : ?>
			<source class="media-background object-fit-cover" srcset="<?php echo $bg_images['xs']; ?>" media="(max-width: 574px)">
			<?php endif; ?>
			<source class="media-background object-fit-cover" srcset="<?php echo $bg_images['sm']; ?>" media="(min-width: 575px)">
			<?php if ( $bg_images['md'] ) : ?>
			<source class="media-background object-fit-cover" srcset="<?php echo $bg_images['md']; ?>" media="(min-width: 768px)">
			<?php endif; ?>
			<?php if ( $bg_images['lg'] ) : ?>
			<source class="media-background object-fit-cover" srcset="<?php echo $bg_images['lg']; ?>" media="(min-width: 992px)">
			<?php endif; ?>
			<?php if ( $bg_images['xl'] ) : ?>
			<source class="media-background object-fit-cover" srcset="<?php echo $bg_images['xl']; ?>" media="(min-width: 1200px)">
			<?php endif; ?>
			<img class="media-background object-fit-cover" src="<?php echo $bg_images['fallback']; ?>" alt="">
		</picture>
	<?php endif; ?>
<?php
	return ob_get_clean();
}

add_filter( 'ucf_section_display_before', 'add_section_markup_before', 10, 2 );


function add_section_markup( $output, $section ) {
	$container = get_field( 'section_add_content_container', $section->ID );

	ob_start();
?>
	<?php if ( $container ) : ?>
		<div class="container"><?php echo $section->post_content; ?></div>
	<?php else : ?>
		<?php echo apply_filters( 'the_content', $section->post_content ); ?>
	<?php endif; ?>
<?php
	return ob_get_clean();
}

add_filter( 'ucf_section_display', 'add_section_markup', 10, 2 );


function add_id_to_ucfhb( $url ) {
	if ( (false !== strpos($url, 'bar/js/university-header.js')) || (false !== strpos($url, 'bar/js/university-header-full.js')) ) {
      remove_filter('clean_url', 'add_id_to_ucfhb', 10, 3);
      return "$url' id='ucfhb-script";
    }
    return $url;
}

add_filter( 'clean_url', 'add_id_to_ucfhb', 10, 1 );

?>
