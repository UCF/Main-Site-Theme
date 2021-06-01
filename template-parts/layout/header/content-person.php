<?php
/**
 * Markup for single Person header content.
 */

$obj      = get_queried_object();
$title    = get_header_title( $obj );
$subtitle = 'TODO'; // TODO modify to use person's title instead

if ( $title ):
?>
<div class="header-content-inner">
	<div class="container d-flex flex-column h-100">
		<div class="row header-person-img-row">
			<div class="col-6 offset-3 col-lg-4 offset-lg-0 px-0 px-md-5 px-lg-3 text-center text-lg-left">
				<img src="https://via.placeholder.com/320x320/" width="320" height="320" class="img-fluid rounded-circle" alt="">
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
