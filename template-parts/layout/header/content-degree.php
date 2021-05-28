<?php
/**
 * Markup for single Degree header content.
 */

$obj                          = get_queried_object();
$title                        = get_header_title( $obj );
$subtitle                     = get_header_subtitle( $obj );
$h1                           = get_header_h1_option( $obj );
$title_elem                   = ( $h1 === 'title' ) ? 'h1' : 'span';
$subtitle_elem                = ( $h1 === 'subtitle' ) ? 'h1' : 'span';
$content_position             = get_field( 'page_header_content_position', $obj ) ?: 'left';
$header_content_col_classes   = 'header-degree-content-col col-sm-auto d-sm-flex align-items-sm-center';

if ( $content_position === 'right' ) {
	$header_content_col_classes .= ' ml-sm-auto';
}

if ( $title ):
?>
<div class="header-content-inner">
	<div class="container px-0 h-100">
		<div class="row no-gutters h-100">
			<div class="<?php echo $header_content_col_classes; ?>">
				<div class="header-degree-content-bg bg-primary-t-2 p-3 p-sm-4 mb-sm-5">
					<<?php echo $title_elem; ?> class="header-title header-title-degree"><?php echo $title; ?></<?php echo $title_elem; ?>>

					<?php if ( $subtitle ) : ?>
						<<?php echo $subtitle_elem; ?> class="header-subtitle header-subtitle-degree"><?php echo $subtitle; ?></<?php echo $subtitle_elem; ?>>
					<?php endif; ?>

					<?php
					echo get_degree_request_info_button(
						$obj,
						'header-degree-cta btn btn-secondary text-primary hover-text-white d-flex align-items-center my-2 mx-auto mx-sm-2 px-5 py-3',
						'mr-3 fa fa-info-circle fa-2x',
						'Request Info'
					);
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
