<?php
include_once 'includes/config.php';

/**
 * Gets the header image for pages.
 **/
function get_header_images( $post ) {
    return array(
        'header_image'    => get_field( 'page_header_image', $post->ID ),
        'header_image_xs' => get_field( 'page_header_image_xs', $post->ID )
    );
}

/**
 * Returns the markup for page headers.
 **/
function get_header_image_markup( $post ) {
	ob_start();
	$images = get_header_images( $post );
?>
	<div class="header-image jumbotron jumbotron-fluid media-background-container mb-0">
		<picture>
			<source srcset="<?php echo $images['header_image']; ?>" media="(min-width: 768px)">
			<img class="media-background object-fit-cover" src="<?php echo $images['header_image_xs']; ?>" alt="">
		</picture>
		<div class="container">
			<div class="d-inline-block bg-primary-faded mt-4 p-4">
				<h1><?php the_title(); ?></h1>
			</div>
		</div>
	</div>
<?php
	return ob_get_clean();
}

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
 * Section markup override
 **/
function add_section_markup( $content, $post_id ) {

	$bg_color = get_field( 'section_background_color', $post_id );
	$bg_image = get_field( 'section_background_image', $post_id );
	$bg_image_xs = get_field( 'section_background_image_xs', $post_id );
	$container = get_field( 'section_add_content_conatiner', $post_id );

	ob_start();
?>
	<section class="jumbotron jumbotron-fluid" style="background-color: <?php echo $bg_color; ?>;">
		<?php if ( $bg_image ) : ?>
			<picture>
				<?php if ( $bg_image ) : ?>
				<source srcset="<?php echo $bg_image; ?>" media="(min-width: 767px)">
				<?php endif; ?>
				<?php if ( $bg_image_xs ) : ?>
				<img class="media-background object-fit-cover" src="<?php echo bg_image_xs; ?>" alt="">
				<?php endif; ?>
			</picture>
		<?php endif; ?>
		<?php if ( $container ) : ?>
		<div class="container"><?php echo $content; ?></div>
		<?php else : ?>
			<?php echo $content; ?>
		<?php endif; ?>
	</section>
<?php
	return ob_get_clean();
}

add_filter( 'ucf_section_display', 'add_section_markup', 10, 2 );

?>
