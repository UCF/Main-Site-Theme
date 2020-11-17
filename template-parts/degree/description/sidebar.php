<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' ) :
	$catalog_desc_full = trim( get_field( 'degree_description_full', $post ) );
	$catalog_cta_intro = get_theme_mod_or_default( 'catalog_desc_cta_intro' );
	$subplans          = get_children( array(
		'post_parent' => $post->ID,
		'post_type'   => 'degree',
		'numberposts' => -1,
		'post_status' => 'publish'
	) );
	$promo             = get_degree_promo( $post );

	$has_content = ( $catalog_desc_full || $subplans || $promo );

	if ( $has_content ) :
?>
	<div class="col-lg-5 col-xl-4 offset-xl-1 pl-lg-5 pl-xl-3 pb-lg-3 mb-5 mt-lg-5">
		<div class="degree-catalog-sidebar pt-lg-3">

			<hr class="mb-4 mb-sm-5 hidden-lg-up" role="presentation">

			<div class="row">

				<?php if ( $catalog_desc_full ) : ?>
				<div class="col-12">
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
							<button class="btn btn-block btn-outline-info rounded py-3"
								data-toggle="modal"
								data-target="#catalogModal">
								View Full Description
							</button>
						</div>

					</div>
				</div>
				<?php endif; ?>

				<?php if ( $catalog_desc_full && $subplans ) : ?>
				<div class="col-12">
					<hr class="my-4 my-sm-5" role="presentation">
				</div>
				<?php endif; ?>

				<?php if ( $subplans ) : ?>
				<div class="col-12">
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
				</div>
				<?php endif; ?>

				<?php if ( $promo ) : ?>
				<div class="col-12 text-center flex-lg-first">

					<?php if ( $catalog_desc_full || $subplans ) : ?>
					<hr class="hidden-lg-up my-4 my-sm-5 pb-2 pb-sm-0" role="presentation">
					<?php endif; ?>

					<?php if ( $promo['link_url'] ) : ?>
					<a class="d-inline-block"
						href="<?php echo $promo['link_url']; ?>"
						<?php if ( $promo['link_rel'] ) { ?>rel="<?php echo $promo['link_rel']; ?>"<?php } ?>
						<?php if ( $promo['new_window'] ) { ?>target="_blank"<?php } ?>>
					<?php endif; ?>
						<img class="img-fluid" src="<?php echo $promo['img']; ?>" alt="<?php echo $promo['alt']; ?>">
					<?php if ( $promo['link_url'] ) : ?>
					</a>
					<?php endif; ?>

					<?php if ( $catalog_desc_full || $subplans ) : ?>
					<hr class="hidden-md-down my-5" role="presentation">
					<?php endif; ?>

				</div>
				<?php endif; ?>

			</div>

		</div>
	</div>
<?php
	endif;
endif;
