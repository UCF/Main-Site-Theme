<?php
include_once 'includes/utilities.php';
include_once 'includes/config.php';
include_once 'includes/meta.php';
include_once 'includes/wp-bs-navwalker.php';
include_once 'includes/header-functions.php';

include_once 'includes/degree-functions.php';
include_once 'includes/ucf-alert-functions.php';
include_once 'includes/phonebook-functions.php';


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
 * Returns an array of src's for a media background <picture>'s <source>s by
 * breakpoint.
 *
 * $img_size_prefix is expected to be a prefix for a set of registered image
 * sizes, which has dimensions defined for each of Athena's responsive
 * breakpoints.  For example, if given a prefix 'bg-img', it is expected that
 * bg-img, bg-img-sm, bg-img-md, bg-img-lg, and bg-img-xl are valid registered
 * image sizes.
 *
 * @param int $attachment_xs_id Attachment ID for the image to be used at the -xs breakpoint
 * @param int $attachment_sm_id Attachment ID for the image to be used at the -sm breakpoint and up
 * @param string $img_size_prefix Prefix for a set of image sizes
 * @return array
 **/
function get_media_background_picture_srcs( $attachment_xs_id, $attachment_sm_id, $img_size_prefix ) {
	$bg_images = array();

	if ( $attachment_sm_id ) {
		$bg_images = array_merge(
			$bg_images,
			array(
				'xl' => get_attachment_src_by_size( $attachment_sm_id, $img_size_prefix . '-xl' ),
				'lg' => get_attachment_src_by_size( $attachment_sm_id, $img_size_prefix . '-lg' ),
				'md' => get_attachment_src_by_size( $attachment_sm_id, $img_size_prefix . '-md' ),
				'sm' => get_attachment_src_by_size( $attachment_sm_id, $img_size_prefix . '-sm' )
			)
		);

		// Remove duplicate image sizes, in case an old image isn't pre-cropped
		$bg_images = array_unique( $bg_images );

		// Use the largest-available image as the fallback <img>
		$bg_images['fallback'] = reset( $bg_images );
	}
	if ( $attachment_xs_id ) {
		$bg_images = array_merge(
			$bg_images,
			array( 'xs' => get_attachment_src_by_size( $attachment_xs_id, $img_size_prefix ) )
		);
	}

	// Strip out false-y values (in case an attachment failed to return somewhere)
	$bg_images = array_filter( $bg_images );

	return $bg_images;
}


/**
 * Returns markup for a media background <picture>, given an array of media
 * background picture <source> src's from get_media_background_picture_srcs().
 *
 * @param array $srcs Array of image urls that correspond to <source> src vals
 * @return string
 **/
function get_media_background_picture( $srcs ) {
	ob_start();

	if ( isset( $srcs['fallback'] ) ) :
?>
	<?php
	// Define classes for the <picture> element
	$picture_classes = 'media-background-picture ';
	if ( !isset( $srcs['xs'] ) ) {
		// Hide the <picture> element at -xs breakpoint when no mobile image
		// is available
		$picture_classes .= 'hidden-xs-down';
	}
	?>
	<picture class="<?php echo $picture_classes; ?>">
		<?php if ( isset( $srcs['xl'] ) ) : ?>
		<source class="media-background object-fit-cover" srcset="<?php echo $srcs['xl']; ?>" media="(min-width: 1200px)">
		<?php endif; ?>

		<?php if ( isset( $srcs['lg'] ) ) : ?>
		<source class="media-background object-fit-cover" srcset="<?php echo $srcs['lg']; ?>" media="(min-width: 992px)">
		<?php endif; ?>

		<?php if ( isset( $srcs['md'] ) ) : ?>
		<source class="media-background object-fit-cover" srcset="<?php echo $srcs['md']; ?>" media="(min-width: 768px)">
		<?php endif; ?>

		<?php if ( isset( $srcs['sm'] ) ) : ?>
		<source class="media-background object-fit-cover" srcset="<?php echo $srcs['sm']; ?>" media="(min-width: 576px)">
		<?php endif; ?>

		<?php if ( isset( $srcs['xs'] ) ) : ?>
		<source class="media-background object-fit-cover" srcset="<?php echo $srcs['xs']; ?>" media="(max-width: 575px)">
		<?php endif; ?>

		<img class="media-background object-fit-cover" src="<?php echo $srcs['fallback']; ?>" alt="">
	</picture>
<?php
	endif;

	return ob_get_clean();
}


/**
 * Returns markup for a media background <video> element.
 *
 * $videos is expected to be an array whose keys correspond to supported
 * <source> filetypes; e.g. $videos = array( 'webm' => '...', 'mp4' => '...' ).
 * Values should be video urls.
 *
 * Note: we never display autoplay videos at the -xs breakpoint.
 *
 * @param array $videos Array of video urls that correspond to <source> src vals
 * @return string
 **/
function get_media_background_video( $videos, $loop=false ) {
	ob_start();
?>
	<video class="hidden-xs-down media-background media-background-video object-fit-cover" autoplay muted <?php if ( $loop ) { ?>loop<?php } ?>>
		<?php if ( isset( $videos['webm'] ) ) : ?>
		<source src="<?php echo $videos['webm']; ?>" type="video/webm">
		<?php endif; ?>

		<?php if ( isset( $videos['mp4'] ) ) : ?>
		<source src="<?php echo $videos['mp4']; ?>" type="video/mp4">
		<?php endif; ?>
	</video>
	<button class="media-background-video-toggle btn play-enabled hidden-xs-up" type="button" data-toggle="button" aria-pressed="false" aria-label="Play or pause background videos">
		<span class="fa fa-pause media-background-video-pause"></span>
		<span class="fa fa-play media-background-video-play"></span>
	</button>
<?php
	return ob_get_clean();
}


/**
 * Section markup override
 **/
function add_section_markup_before( $content, $section, $class, $title, $section_id ) {
	// Retrieve background image sizes
	$bg_image_sm_id = get_field( 'section_background_image', $section->ID );    // -sm+
	$bg_image_xs_id = get_field( 'section_background_image_xs', $section->ID ); // -xs only
	$bg_images = get_media_background_picture_srcs( $bg_image_xs_id, $bg_image_sm_id, 'bg-img' );

	// Retrieve color classes/custom definitions
	$bg_color = get_field( 'section_background_color', $section->ID );
	$bg_color_custom = get_field( 'section_background_color_custom', $section->ID );

	$text_color = get_field( 'section_text_color', $section->ID );
	$text_color_custom = get_field( 'section_text_color_custom', $section->ID );

	// Define classes for the section
	$section_classes = '';
	if ( $class ) {
		$section_classes = $class;
	}

	if ( isset( $bg_images['fallback'] ) ) {
		$section_classes .= ' media-background-container';
	}
	if ( $bg_color && !empty( $bg_color ) && $bg_color !== 'custom' ) {
		$section_classes .= ' ' . $bg_color;
	}
	if ( $text_color && !empty( $text_color ) && $text_color !== 'custom' ) {
		$section_classes .= ' ' . $text_color;
	}

	// Define custom style attribute values for the section
	$style_attrs = '';
	if ( $bg_color === 'custom' && $bg_color_custom ) {
		$style_attrs .= 'background-color: '. $bg_color_custom .'; ';
	}
	if ( $text_color === 'custom' && $text_color_custom ) {
		$style_attrs .= 'color: '. $text_color_custom .'; ';
	}

	$title = ! empty( $title ) ? ' data-section-link-title="' . $title . '"' : '';

	$section_id = ! empty( $section_id ) ? ' id="' . $section_id . '"' : '';

	ob_start();
?>
	<section <?php echo $section_id; ?>class="<?php echo $section_classes; ?>" style="<?php echo $style_attrs; ?>"<?php echo $title; ?>>
	<?php echo get_media_background_picture( $bg_images ); ?>
<?php
	return ob_get_clean();
}

add_filter( 'ucf_section_display_before', 'add_section_markup_before', 10, 5 );


function add_section_markup( $output, $section ) {
	$container = get_field( 'section_add_content_container', $section->ID );

	ob_start();
?>
	<?php if ( $container ) : ?>
		<div class="container"><?php echo apply_filters( 'the_content', $section->post_content ); ?></div>
	<?php else : ?>
		<?php echo apply_filters( 'the_content', $section->post_content ); ?>
	<?php endif; ?>
<?php
	return ob_get_clean();
}

add_filter( 'ucf_section_display', 'add_section_markup', 10, 2 );
