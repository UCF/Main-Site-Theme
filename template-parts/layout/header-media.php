<?php
/**
 * Markup for page headers with media background(s).
 */

$obj                 = get_queried_object();
$videos              = get_query_var( 'header_videos' );
$header_content_type = get_query_var( 'header_content_type' );
$header_height       = get_query_var( 'header_height' );
?>
<div class="header-media <?php echo $header_height; ?> mb-0 d-flex flex-column">
	<?php get_template_part( 'template-parts/layout/header/media_background' ); ?>
	<?php get_template_part( 'template-parts/layout/header/nav' ); ?>

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
