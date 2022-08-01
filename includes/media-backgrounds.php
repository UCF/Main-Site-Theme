<?php
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

		// Try to get a fallback -xs image if needed
		if ( !$attachment_xs_id ) {
			$bg_images = array_merge(
				$bg_images,
				array( 'xs' => get_attachment_src_by_size( $attachment_sm_id, $img_size_prefix ) )
			);
		}

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
 * Returns markup for a media background <picture>.
 *
 * @param array $srcs Array of image urls that correspond to <source> src vals. Expects output from get_media_background_picture_srcs()
 * @return string
 **/
function get_media_background_picture( $srcs ) {
	ob_start();

	if ( isset( $srcs['fallback'] ) ) :
?>
	<picture class="media-background-picture">
		<?php if ( isset( $srcs['xl'] ) ) : ?>
		<source srcset="<?php echo $srcs['xl']; ?>" media="(min-width: 1200px)">
		<?php endif; ?>

		<?php if ( isset( $srcs['lg'] ) ) : ?>
		<source srcset="<?php echo $srcs['lg']; ?>" media="(min-width: 992px)">
		<?php endif; ?>

		<?php if ( isset( $srcs['md'] ) ) : ?>
		<source srcset="<?php echo $srcs['md']; ?>" media="(min-width: 768px)">
		<?php endif; ?>

		<?php if ( isset( $srcs['sm'] ) ) : ?>
		<source srcset="<?php echo $srcs['sm']; ?>" media="(min-width: 576px)">
		<?php endif; ?>

		<?php if ( isset( $srcs['xs'] ) ) : ?>
		<source srcset="<?php echo $srcs['xs']; ?>" media="(max-width: 575px)">
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
	<video class="hidden-xs-down media-background media-background-video object-fit-cover" aria-hidden="true" preload="none" muted <?php if ( $loop ) { ?>loop<?php } ?>>
		<?php if ( isset( $videos['webm'] ) ) : ?>
		<source src="<?php echo $videos['webm']; ?>" type="video/webm">
		<?php endif; ?>

		<?php if ( isset( $videos['mp4'] ) ) : ?>
		<source src="<?php echo $videos['mp4']; ?>" type="video/mp4">
		<?php endif; ?>
		<?php if ( function_exists( 'UCF\Video_Vtt\Tools\get_track_markup' ) ) : ?>
		<?php echo UCF\Video_Vtt\Tools\get_track_markup( $videos['mp4'] ); ?>
		<?php endif; ?>
	</video>
	<button class="media-background-video-toggle btn play-enabled hidden-xs-up" type="button" data-toggle="button" aria-pressed="false" aria-label="Play or pause background videos">
		<span class="fa fa-pause media-background-video-pause" aria-hidden="true"></span>
		<span class="fa fa-play media-background-video-play" aria-hidden="true"></span>
	</button>
<?php
	return ob_get_clean();
}
