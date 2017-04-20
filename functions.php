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

function get_header_image_markup( $post ) {
	ob_start();
	$images = get_header_images( $post );
?>
	<div class="header-image jumbotron jumbotron-fluid media-background-container">
		<picture>
			<source srcset="<?php echo $images['header_image']; ?>" media="(min-width: 768px)">
			<img class="media-background object-fit-cover" src="<?php echo $images['header_image_xs']; ?>" alt="">
		</picture>
		<div class="container">
			<h1><?php the_title(); ?></h1>
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

?>
