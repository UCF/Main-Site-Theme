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
 * Section markup override
 **/
function add_section_markup_before( $content, $section ) {

	$bg_color = get_field( 'section_background_color', $section->ID );
	$bg_image = get_field( 'section_background_image', $section->ID );
	$bg_image_xs = get_field( 'section_background_image_xs', $section->ID );

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
<?php
	return ob_get_clean();
}

add_filter( 'ucf_section_display_before', 'add_section_markup_before', 10, 2 );

function add_section_markup( $output, $section ) {
	$container = get_field( 'section_add_content_conatiner', $section->ID );

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
