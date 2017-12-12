<?php
/**
 * Header Related Functions
 **/

/**
 * Gets the header image for pages.
 **/
function get_header_images( $obj ) {
	$obj_id = get_object_id( $obj );
	$field_id = get_object_field_id( $obj );

	$retval = array(
		'header_image'    => '',
		'header_image_xs' => ''
	);

	if ( $obj instanceof WP_Post && $obj->post_type === 'degree' ) {
		$retval = degree_backup_headers( $obj );
	}

	if ( $obj_header_image = get_field( 'page_header_image', $field_id ) ) {
		$retval['header_image'] = $obj_header_image;
	}
	if ( $obj_header_image_xs = get_field( 'page_header_image_xs', $field_id ) ) {
		$retval['header_image_xs'] = $obj_header_image_xs;
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
function get_header_videos( $obj ) {
	$obj_id = get_object_id( $obj );
	$field_id = get_object_field_id( $obj );

	$retval = array(
		'webm' => get_field( 'page_header_webm', $field_id ),
		'mp4'  => get_field( 'page_header_mp4', $field_id )
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
 function get_header_title( $obj ) {
	$field_id = get_object_field_id( $obj );
	$title = '';

	if ( is_tax() || is_category() || is_tag() ) {
		$title = $obj->name;
	}
	else if ( $obj instanceof WP_Post ) {
		$title = $obj->post_title;
	}

	// Apply custom header title override, if available
	if ( $custom_header_title = get_field( 'page_header_title', $field_id ) ) {
		$title = do_shortcode( $custom_header_title );
	}

	return wptexturize( $title );
}


/**
 * Returns subtitle text for use in the page header.
 **/
function get_header_subtitle( $obj ) {
	$field_id = get_object_field_id( $obj );
	return wptexturize( do_shortcode( get_field( 'page_header_subtitle', $field_id ) ) );
}


/**
 * Returns whether the page title or subtitle was designated as the page's h1.
 * Defaults to 'title' if the option isn't set.
 * Will force return a different value if the user screwed up (e.g. specified
 * "subtitle" but didn't provide a subtitle value).
 **/
function get_header_h1_option( $obj ) {
	$field_id = get_object_field_id( $obj );
	$subtitle = get_field( 'page_header_subtitle', $field_id ) ?: '';
	$h1       = get_field( 'page_header_h1', $field_id ) ?: 'title';

	if ( $h1 === 'subtitle' && trim( $subtitle ) === '' ) {
		$h1 = 'title';
	}

	return $h1;
}


function get_nav_markup( $image=true ) {
	ob_start();
?>
	<nav class="navbar navbar-toggleable-md navbar-custom py-2<?php echo $image ? ' py-sm-4 navbar-inverse header-gradient' : ' navbar-inverse bg-inverse-t-3 py-lg-4'; ?>" role="navigation">
		<div class="container">
			<button class="navbar-toggler ml-auto mr-0 collapsed" type="button" data-toggle="collapse" data-target="#header-menu" aria-controls="header-menu" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-text">Navigation</span>
				<span class="navbar-toggler-icon"></span>
			</button>
			<?php
				wp_nav_menu( array(
					'theme_location'  => 'header-menu',
					'depth'           => 1,
					'container'       => 'div',
					'container_class' => 'collapse navbar-collapse',
					'container_id'    => 'header-menu',
					'menu_class'      => 'nav navbar-nav nav-fill',
					'fallback_cb'     => 'bs4Navwalker::fallback',
					'walker'          => new bs4Navwalker()
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
function get_header_content_title_subtitle( $obj ) {
	$title         = get_header_title( $obj );
	$subtitle      = get_header_subtitle( $obj );
	$h1            = get_header_h1_option( $obj );
	$title_elem    = ( $h1 === 'title' ) ? 'h1' : 'span';
	$subtitle_elem = ( $h1 === 'subtitle' ) ? 'h1' : 'span';

	ob_start();

	if ( $title ):
?>
	<div class="header-content-inner align-self-start pt-4 pt-sm-0 align-self-sm-center">
		<div class="container">
			<div class="d-inline-block bg-primary-t-1">
				<<?php echo $title_elem; ?> class="header-title"><?php echo $title; ?></<?php echo $title_elem; ?>>
			</div>
			<?php if ( $subtitle ) : ?>
			<div class="clearfix"></div>
			<div class="d-inline-block bg-inverse">
				<<?php echo $subtitle_elem; ?> class="header-subtitle"><?php echo $subtitle; ?></<?php echo $subtitle_elem; ?>>
			</div>
			<?php endif; ?>
		</div>
	</div>
<?php
	endif;

	return ob_get_clean();
}


/**
 * Returns markup for page header custom content.
 **/
function get_header_content_custom( $obj ) {
	$field_id = get_object_field_id( $obj );
	$content = get_field( 'page_header_content', $field_id );

	ob_start();
?>
	<div class="header-content-inner">
<?php
	if ( $content ) {
		echo $content;
	}
?>
	</div>
<?php
	return ob_get_clean();
}


/**
 * Returns the markup for page headers with media backgrounds.
 **/
function get_header_media_markup( $obj, $videos, $images ) {
	$field_id   = get_object_field_id( $obj );
	$videos     = $videos ?: get_header_videos( $obj );
	$images     = $images ?: get_header_images( $obj );
	$video_loop = get_field( 'page_header_video_loop', $field_id );
	$header_content_type = get_field( 'page_header_content_type', $field_id );
	$header_height       = get_field( 'page_header_height', $field_id );
	$exclude_nav         = get_field( 'page_header_exclude_nav', $field_id );

	ob_start();
?>
	<div class="header-media <?php echo $header_height; ?> mb-0 d-flex flex-column">
		<div class="header-media-background-wrap">
			<div class="header-media-background media-background-container">
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
			</div>
		</div>

		<?php
		// Display the site nav
		if ( !$exclude_nav ) { echo get_nav_markup(); }
		?>

		<?php
		// Display the inner header contents
		?>
		<div class="header-content">
			<div class="header-content-flexfix">
				<?php
				if ( $header_content_type === 'custom' ) {
					echo get_header_content_custom( $obj );
				}
				else {
					echo get_header_content_title_subtitle( $obj );
				}
				?>
			</div>
		</div>

		<?php
		// Print a spacer div for headers with background videos (to make
		// control buttons accessible), and for headers showing a standard
		// title/subtitle to push them up a bit
		if ( $videos || $header_content_type === 'title_subtitle' ):
		?>
		<div class="header-media-controlfix"></div>
		<?php endif; ?>
	</div>
<?php
	return ob_get_clean();
}


/**
 * Returns the default markup for page headers without a media background.
 **/
 function get_header_default_markup( $obj ) {
	$title               = get_header_title( $obj );
	$subtitle            = get_header_subtitle( $obj );
	$field_id            = get_object_field_id( $obj );
	$header_content_type = get_field( 'page_header_content_type', $field_id );
	$exclude_nav         = get_field( 'page_header_exclude_nav', $field_id );
	$h1                  = get_header_h1_option( $obj );
	$title_elem          = ( $h1 === 'title' ) ? 'h1' : 'span';
	$subtitle_elem       = ( $h1 === 'subtitle' ) ? 'h1' : 'p';

	$title_classes = 'mt-3 mt-sm-4 mt-md-5 mb-3';
	if ( $h1 !== 'title' ) {
		$title_classes .= ' h1 d-block';
	}
	$subtitle_classes = 'lead mb-4 mb-md-5';

	ob_start();
?>
	<?php if ( !$exclude_nav ) { echo get_nav_markup( false ); } ?>

	<?php
	if ( $header_content_type === 'custom' ):
		echo get_header_content_custom( $obj );
	elseif ( $title ):
	?>
	<div class="container">
		<<?php echo $title_elem; ?> class="<?php echo $title_classes; ?>">
			<?php echo $title; ?>
		</<?php echo $title_elem; ?>>

		<?php if ( $subtitle ): ?>
			<<?php echo $subtitle_elem; ?> class="<?php echo $subtitle_classes; ?>">
				<?php echo $subtitle; ?>
			</<?php echo $subtitle_elem; ?>>
		<?php endif; ?>
	</div>
	<?php endif; ?>
<?php
	return ob_get_clean();
}


function get_header_markup() {
	$obj = get_queried_object();

	$videos = get_header_videos( $obj );
	$images = get_header_images( $obj );

	if ( $videos || $images ) {
		echo get_header_media_markup( $obj, $videos, $images );
	}
	else {
		echo get_header_default_markup( $obj );
	}
}

?>
