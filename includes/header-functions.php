<?php
/**
 * Header Related Functions
 **/

/**
 * Gets the header image for pages.
 **/
function get_header_images( $post ) {
    $retval = array(
        'header_image'    => get_field( 'page_header_image', $post->ID ),
        'header_image_xs' => get_field( 'page_header_image_xs', $post->ID )
    );

	if ( $retval['header_image'] ) {
		return $retval;
	}

	return false;
}

function get_nav_markup( $image=true ) {
	ob_start();
?>
	<nav class="navbar navbar-toggleable-md<?php echo $image ? ' navbar-custom header-gradient' : ' navbar-light'; ?> py-4" role="navigation">
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#header-menu" aria-controls="header-menu" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="container">
		<?php
			wp_nav_menu( array(
				'theme_location'  => 'header-menu',
				'depth'           => 1,
				'container'       => 'div',
				'container_class' => 'collapse navbar-collapse',
				'container_id'    => 'header-menu',
				'menu_class'      => 'nav navbar-nav nav-fill w-100',
				'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
				'walker'          => new WP_Bootstrap_Navwalker()
			) );
		?>
		</div>
	</nav>
<?php
	return ob_get_clean();
}

/**
 * Returns the markup for page headers.
 **/
function get_header_image_markup( $post ) {
	ob_start();
	$page_title = get_post_meta( $post->ID, 'page_header_title', true );
	$title = ( ! empty( $page_title ) ) ? $page_title : $post->post_title;
	$subtitle = get_post_meta( $post->ID, 'page_header_subtitle', true );

	if ( $images = get_header_images( $post ) ) : 
?>
	<div class="header-image media-background-container mb-0">
		<picture>
			<source srcset="<?php echo $images['header_image']; ?>" media="(min-width: 768px)">
			<img class="media-background object-fit-cover" src="<?php echo $images['header_image_xs']; ?>" alt="">
		</picture>
		<?php echo get_nav_markup(); ?>
			<div class="container">
				<div class="row align-items-center title-wrapper">
					<div class="col">
						<div class="d-inline-block bg-primary-faded">
							<h1 class="header-title"><?php echo $title ?></h1>
						</div>
						<?php if ( $subtitle ) : ?>
						<div class="clear"></div>
						<div class="d-inline-block bg-inverse">
							<div class="header-subtitle"><?php echo do_shortcode( $subtitle ); ?></div>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
<?php else : ?>
	<?php echo get_nav_markup( false ); ?>
	<div class="container">
		<h1><?php the_title(); ?></h1>
	</div>
<?php endif;
	return ob_get_clean();
}

function get_header_markup() {
	global $post;
	echo get_header_image_markup( $post );
}

?>
