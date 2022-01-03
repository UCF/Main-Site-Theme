<?php
/**
 * Markup for a header's media background image/video(s).
 */

$obj                 = get_queried_object();
$videos              = get_query_var( 'header_videos' );
$images              = get_query_var( 'header_images' );
$header_height       = get_query_var( 'header_height' );
?>
<div class="header-media-background-wrap">
	<div class="header-media-background media-background-container">
		<?php
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
