<?php
/**
 * Markup for page header title + subtitles within headers that
 * have a header background set.
 */

$obj              = get_queried_object();
$title            = get_header_title( $obj );
$subtitle         = get_header_subtitle( $obj );
$h1               = get_header_h1_option( $obj );
$title_elem       = ( $h1 === 'title' ) ? 'h1' : 'span';
$subtitle_elem    = ( $h1 === 'subtitle' ) ? 'h1' : 'span';
$content_position = get_field( 'page_header_content_position', $obj ) ?: 'left';
$position_class   = 'text-' . $content_position;

if ( $title ):
?>
<div class="header-content-inner align-self-start pt-4 pt-sm-0 align-self-sm-center">
	<div class="container <?php echo $position_class; ?>">
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
<?php endif; ?>
