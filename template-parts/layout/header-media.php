<?php
/**
 * Markup for page headers with media background(s).
 */

$obj                 = get_queried_object();
$videos              = get_query_var( 'header_videos' );
$images              = get_query_var( 'header_images' );
$header_content_type = get_query_var( 'header_content_type' );
$header_height       = get_header_media_height( $obj );
?>
<div class="header-media <?php echo $header_height; ?> mb-0 d-flex flex-column">
	<div class="header-media-background-wrap">
		<div class="header-media-background media-background-container">
			<?php
			// Display the media background (video + picture)

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
			if ( $videos ) {
				$video_loop = get_field( 'page_header_video_loop', $obj );
				echo get_media_background_video( $videos, $video_loop );
			}
			?>
		</div>
	</div>

	<?php
	// Display the site nav
	get_template_part( 'template-parts/layout/header/nav' );
	?>

	<?php
	// Display the inner header contents
	?>
	<div class="header-content">
		<div class="header-content-flexfix">
			<?php get_template_part( 'template-parts/layout/header/content', $header_content_type ); ?>
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
