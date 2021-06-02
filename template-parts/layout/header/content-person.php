<?php
/**
 * Markup for single Person header content.
 */

$obj      = get_queried_object();
$title    = get_header_title( $obj );

if ( $title ):
	$subtitle  = wptexturize( get_field( 'person_title', $obj ) );
	$thumbnail = get_person_thumbnail(
		$obj,
		'medium',
		array(
			'class' => 'media-background object-fit-cover',
			'alt'   => ''
		)
	);
?>
<div class="header-content-inner">
	<div class="container d-flex flex-column h-100">
		<div class="row header-person-img-row">
			<div class="col-6 offset-3 col-lg-4 offset-lg-0 mt-lg-4 mt-xl-0 px-0 px-md-5 pl-lg-3 pr-lg-4 text-center text-lg-left">
				<div class="header-person-img embed-responsive embed-responsive-1by1 media-background-container rounded-circle">
					<?php echo $thumbnail; ?>
				</div>
			</div>
		</div>
		<div class="row mt-lg-auto mb-lg-auto">
			<div class="col-lg-8 offset-lg-4 text-center text-lg-left">
				<h1 class="mt-4 mb-3 pt-sm-2">
					<?php echo $title; ?>
				</h1>

				<?php if ( $subtitle ) : ?>
				<span class="lead d-block mb-4">
					<?php echo $subtitle; ?>
				</span>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
