<?php
/**
 * Markup for completely custom page header contents.
 */

$obj     = get_queried_object();
$video   = get_field( 'video_embed_url', $obj->ID );
?>
<div class="header-content-inner">
	<div class="container">
		<h1 class="text-center font-condensed text-inverse mb-md-4"><?php echo $obj->post_title; ?></h1>
		<div class="embed-responsive embed-responsive-16by9 header-video-embed">
			<?php echo $video; ?>
		</div>
	</div>
</div>
