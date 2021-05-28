<?php
/**
 * Markup for single Degree header content.
 */

$obj      = get_queried_object();
$title    = get_header_title( $obj );
$subtitle = 'TODO'; // TODO modify to use person's title instead

if ( $title ):
?>
<div class="header-content-inner">
	<div class="container h-100 px-0">
		<div class="row w-100" style="position: absolute; bottom: -30%;">
			<div class="col-6 offset-3 col-md-4 offset-md-0 text-center text-md-left">
				<img src="https://via.placeholder.com/300x300/" width="300" height="300" class="img-fluid rounded-circle" alt="">
			</div>
		</div>
		<div class="row h-100">
			<div class="col-md-8 offset-md-4 hidden-sm-down">
				<h1 class="mt-5 mb-3">
					<?php echo $title; ?>
				</h1>

				<?php if ( $subtitle ) : ?>
				<span class="lead d-block">
					<?php echo $subtitle; ?>
				</span>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
