<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' ) :
	$catalog_url       = get_field( 'degree_pdf', $post );
	$catalog_cta_intro = get_theme_mod_or_default( 'catalog_desc_cta_intro' );
	$subplans          = get_children( array(
		'post_parent' => $post->ID,
		'post_type'   => 'degree',
		'numberposts' => -1,
		'post_status' => 'publish'
	) );

	if ( $catalog_url || $subplans ) :
?>
	<div class="col-lg-5 col-xl-4 offset-xl-1 pl-lg-5 pl-xl-3 pb-lg-3 mb-5 mt-lg-5">
		<div class="degree-catalog-sidebar pt-lg-3">

			<hr class="mb-4 mb-sm-5 hidden-lg-up" role="presentation">

			<?php if ( $catalog_url ) : ?>
			<div class="row py-3 py-sm-0">

				<?php if ( $catalog_cta_intro ) : ?>
				<div class="col-auto pr-0">
					<span class="fa fa-info-circle text-info fa-3x" aria-hidden="true"></span>
				</div>
				<div class="col d-flex align-self-center">
					<p class="degree-catalog-cta-info mb-0">
						<?php echo $catalog_cta_intro; ?>
					</p>
				</div>
				<div class="w-100 mb-4"></div>
				<?php endif; ?>

				<div class="col col-sm-8 col-md-6 col-lg">
					<a href="<?php echo $catalog_url; ?>" target="_blank" class="btn btn-block btn-outline-info rounded py-3">View in Catalog</a>
				</div>

			</div>
			<?php endif; ?>

			<?php if ( $catalog_url && $subplans ) : ?>
			<hr class="my-4 my-sm-5" role="presentation">
			<?php endif; ?>

			<?php if ( $subplans ) : ?>
			<h2 class="h6 text-uppercase text-default pt-3 pt-sm-0 mb-4 pb-md-2">Program Tracks/Options</h2>
			<ul class="list-unstyled">
				<?php foreach ( $subplans as $subplan ) : ?>
				<li class="d-block degree-title mb-3 mb-md-4">
					<a href="<?php echo get_permalink( $subplan ); ?>">
						<?php echo get_field( 'degree_name_short', $subplan ) ?: $subplan->post_title; ?>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>

		</div>
	</div>
<?php
	endif;
endif;
