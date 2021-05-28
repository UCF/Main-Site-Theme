<?php
/**
 * Markup for single Person profiles' headers.
 */

$obj                 = get_queried_object();
$videos              = get_query_var( 'header_videos' );
$images              = get_query_var( 'header_images' );
$header_content_type = get_query_var( 'header_content_type' );
?>
<div class="header-media header-media-person mb-0 d-flex flex-column">
	<?php get_template_part( 'template-parts/layouts/header/media-background' ); ?>
	<?php get_template_part( 'template-parts/layout/header/nav' ); ?>

	<div class="header-content">
		<div class="header-content-flexfix">
			<?php get_template_part( 'template-parts/layout/header/content', $header_content_type ); ?>
		</div>
	</div>
</div>
