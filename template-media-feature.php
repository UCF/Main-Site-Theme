<?php
/**
 * Template Name: Media Feature
 **/
?>
<?php
get_header(); the_post();

$header_img = wp_get_attachment_url( get_post_meta( $post->ID, 'page_media_img', true ) );
$header_video_mp4 = wp_get_attachment_url( get_post_meta( $post->ID, 'page_media_mp4', true ) );
$header_video_webm = wp_get_attachment_url( get_post_meta( $post->ID, 'page_media_webm', true ) );
$header_video_ogg = wp_get_attachment_url( get_post_meta( $post->ID, 'page_media_ogg', true ) );
$header_content = wptexturize( do_shortcode( get_post_meta( $post->ID, 'page_media_header_content', true ) ) );

$use_video = $header_video_mp4 || $header_video_webm || $header_video_ogg;
$placeholder_attrs = '';

if ( $use_video ) {
	$placeholder_attrs .= $header_video_mp4 ? 'data-mp4="'. $header_video_mp4 .'" ' : '';
	$placeholder_attrs .= $header_video_webm ? 'data-webm="'. $header_video_webm .'" ' : '';
	$placeholder_attrs .= $header_video_ogg ? 'data-ogg="'. $header_video_ogg .'" ' : '';
}
?>

</div> <!-- close .container -->

<div class="container-fullwidth page-media" id="<?php echo $post->post_name; ?>">
	<div class="page-media-header" style="background-image: url('<?php echo $header_img; ?>');">

	<?php if ( $use_video ): ?>
	<div id="header-video-placeholder" <?php echo $placeholder_attrs; ?>></div>
	<?php endif; ?>

	<div class="page-media-container">
		<?php echo $header_content; ?>
	</div>

	</div>
</div>
<div class="page-content" id="contentcol">
	<article role="main">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</article>
</div>

</div>
<div class="container">
	<?php get_footer( 'gray' );?>
