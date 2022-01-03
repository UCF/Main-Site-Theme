<?php
/**
 * Default header contents to use when a header
 * background is *not* set
 */

$obj                 = get_queried_object();
$title               = get_header_title( $obj );
$subtitle            = get_header_subtitle( $obj );
$h1                  = get_header_h1_option( $obj );
$title_elem          = ( $h1 === 'title' ) ? 'h1' : 'span';
$subtitle_elem       = ( $h1 === 'subtitle' ) ? 'h1' : 'p';

$title_classes = 'mt-3 mt-sm-4 mt-md-5 mb-3';
if ( $h1 !== 'title' ) {
	$title_classes .= ' h1 d-block';
}
$subtitle_classes = 'lead mb-4 mb-md-5';
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
