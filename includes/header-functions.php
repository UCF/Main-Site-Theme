<?php
/**
 * Header Related Functions
 **/

/**
 * Gets the header image for pages.
 **/
function get_header_images( $post ) {
	$retval = array(
		'header_image'    => '',
		'header_image_xs' => ''
	);

	if ( $post->post_type === 'degree' ) {
		$retval = degree_backup_headers( $post );
	}

	if ( $post_header_image = get_field( 'page_header_image', $post->ID ) ) {
		$retval['header_image'] = $post_header_image;
	}
	if ( $post_header_image_xs = get_field( 'page_header_image_xs', $post->ID ) ) {
		$retval['header_image_xs'] = $post_header_image_xs;
	}

	if ( $retval['header_image'] ) {
		return $retval;
	}
	return false;
}

function degree_backup_headers( $post ) {
	$college = wp_get_post_terms( $post->ID, 'colleges' );

	if ( is_array( $college ) ) {
		$college = $college[0];
	}

	return array(
		'header_image'    => get_field( 'page_header_image', 'colleges_' . $college->term_id ),
		'header_image_xs' => get_field( 'page_header_image_xs', 'colleges_' . $college->term_id )
	);
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


/**
 * Returns title text for use in the page header.
 **/
 function get_header_title( $post ) {
	$title = '';

	if ( is_404() ) {
		$title = '404 Not Found';
	}
	else {
		$title = do_shortcode( get_field( 'page_header_title', $post->ID ) );
	}

	if ( !$title ) {
		// Fall back to the post title
		$title = $post->post_title;
	}

	return wptexturize( $title );
}


/**
 * Returns subtitle text for use in the page header.
 **/
 function get_header_subtitle( $post ) {
	return wptexturize( do_shortcode( get_field( 'page_header_subtitle', $post->ID ) ) );
}


function get_nav_markup( $image=true ) {
	ob_start();
?>
	<nav class="navbar navbar-toggleable-md<?php echo $image ? ' navbar-inverse navbar-custom header-gradient' : ' navbar-light navbar-custom'; ?> py-2 py-sm-4" role="navigation">
		<div class="container">
			<button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#header-menu" aria-controls="header-menu" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
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
 * Returns markup for page header title + subtitles within headers that use a
 * media background.
 **/
function get_header_content_title_subtitle( $post ) {
	$title = get_header_title( $post );
	$subtitle = get_header_subtitle( $post );

	ob_start();
?>
	<div class="header-content-inner d-flex h-75 align-items-center">
		<div class="container">
			<div class="d-inline-block bg-primary-t-1">
				<h1 class="header-title"><?php echo $title; ?></h1>
			</div>
			<?php if ( $subtitle ) : ?>
			<div class="clearfix"></div>
			<div class="d-inline-block bg-inverse">
				<div class="header-subtitle"><?php echo $subtitle; ?></div>
			</div>
			<?php endif; ?>
		</div>
	</div>
<?php
	return ob_get_clean();
}


/**
 * Returns markup for page header custom content within headers that use a
 * media background.
 **/
function get_header_content_custom( $post ) {
	$content = get_field( 'page_header_content', $post->ID );

	ob_start();

	if ( $content ) {
		echo $content;
	}

	return ob_get_clean();
}


/**
 * Returns the markup for page headers with media backgrounds.
 **/
function get_header_media_markup( $post, $videos, $images ) {
	$videos     = $videos ?: get_header_videos( $post );
	$images     = $images ?: get_header_images( $post );
	$video_loop = get_field( 'page_header_video_loop', $post->ID );

	ob_start();

	$header_height = get_field( 'page_header_height', $post->ID );
?>
	<div class="header-media <?php echo $header_height; ?> media-background-container mb-0 d-flex flex-column">
		<?php
		// Display the media background (video + picture)

		if ( $videos ) {
			echo get_media_background_video( $videos, $video_loop );
		}
		if ( $images ) {
			$bg_image_srcs = array();
			switch ( $header_height ) {
				case 'header-media-fullscreen':
					$bg_image_srcs = get_media_background_picture_srcs( null, $images['header_image'], 'bg-img' );
					$bg_image_src_xs = get_media_background_picture_srcs( $images['header_image_xs'], null, 'header-img' );

					if ( isset( $bg_image_src_xs['xs'] ) ) {
						$bg_image_srcs['xs'] = $bg_image_src_xs['xs'];
					}

					break;
				default:
					$bg_image_srcs = get_media_background_picture_srcs( $images['header_image_xs'], $images['header_image'], 'header-img' );
					break;
			}
			echo get_media_background_picture( $bg_image_srcs );
		}
		?>

		<?php
		// Display the site nav
		echo get_nav_markup();
		?>

		<?php
		// Display the inner header contents
		?>
		<div class="header-content">
			<div class="header-content-flexfix">
				<?php
				if ( get_field( 'page_header_content_type', $post->ID ) === 'custom' ) {
					echo get_header_content_custom( $post );
				}
				else {
					echo get_header_content_title_subtitle( $post );
				}
				?>
			</div>
		</div>
	</div>
<?php
	return ob_get_clean();
}


/**
 * Returns the default markup for page headers without a media background.
 **/
 function get_header_default_markup( $post ) {
	$title    = get_header_title( $post );
	$subtitle = get_header_subtitle( $post );

	ob_start();
?>
	<?php echo get_nav_markup(); ?>

	<div class="container">
		<h1 class="mt-3 mt-sm-4 mt-md-5 mb-3"><?php echo $title; ?></h1>

		<?php if ( $subtitle ): ?>
		<p class="lead mb-4 mb-md-5"><?php echo $subtitle; ?></p>
		<?php endif; ?>
	</div>
<?php
	return ob_get_clean();
}


function get_header_markup() {
	global $post;

	$videos = get_header_videos( $post );
	$images = get_header_images( $post );

	if ( $videos || $images ) {
		echo get_header_media_markup( $post, $videos, $images );
	}
	else {
		echo get_header_default_markup( $post );
	}
}

?>
