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


/**
 * Gets the header video sources for pages.
 **/
function get_header_videos( $post ) {
    $retval = array(
        'webm' => get_field( 'page_header_webm', $post->ID ),
        'mp4'  => get_field( 'page_header_mp4', $post->ID )
    );

    $retval = array_filter( $retval );

    // MP4 must be available to display video successfully cross-browser
	if ( isset( $retval['mp4'] ) ) {
		return $retval;
	}

	return false;
}


function get_nav_markup( $image=true ) {
	ob_start();
?>
	<nav class="navbar navbar-toggleable-md<?php echo $image ? ' navbar-inverse navbar-custom header-gradient' : ' navbar-light navbar-custom'; ?> py-4" role="navigation">
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
function get_header_media_markup( $post ) {
	$page_title = get_post_meta( $post->ID, 'page_header_title', true );
	$title = ( ! empty( $page_title ) ) ? $page_title : $post->post_title;
	$subtitle = get_post_meta( $post->ID, 'page_header_subtitle', true );
	$videos = get_header_videos( $post );
	$images = get_header_images( $post );
	$video_loop = get_field( 'page_header_video_loop', $post->ID );

	ob_start();

	if ( $images || $videos ) :
		$header_height = get_field( 'page_header_height', $post->ID );
?>
		<div class="header-media <?php echo $header_height; ?> media-background-container mb-0">
			<?php
			if ( $videos ) {
				echo get_media_background_video( $videos, $video_loop );
			}
			if ( $images ) {
				$bg_image_srcs = array();
				switch ( $header_height ) {
					case 'header-media-fullscreen':
						$bg_image_src_xs = get_media_background_picture_srcs( $images['header_image_xs'], null, 'header-img' );
						$bg_image_srcs_sm = get_media_background_picture_srcs( null, $images['header_image'], 'bg-img' );
						$bg_image_srcs = array_merge( $bg_image_src_xs, $bg_image_srcs_sm );
						break;
					default:
						$bg_image_srcs = get_media_background_picture_srcs( $images['header_image_xs'], $images['header_image'], 'header-img' );
						break;
				}
				echo get_media_background_picture( $bg_image_srcs );
			}
			?>
			<?php echo get_nav_markup(); ?>
			<div class="container">
				<div class="row align-items-center title-wrapper">
					<div class="col">
						<div class="d-inline-block bg-primary-t-1">
							<h1 class="header-title"><?php echo $title ?></h1>
						</div>
						<?php if ( $subtitle ) : ?>
						<div class="clearfix"></div>
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
<?php
	endif;
	return ob_get_clean();
}


function get_header_markup() {
	global $post;
	echo get_header_media_markup( $post );
}

?>
