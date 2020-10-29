<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' ) :
	// TODO display nothing when no catalog desc. or custom desc. are available
	// TODO make `degree_disable_catalog_desc` meta functional again
	// TODO implement catalog desc. as fallback
	$hide_catalog_desc = ( isset( $post_meta['degree_disable_catalog_desc'] ) && filter_var( $post_meta['degree_disable_catalog_desc'], FILTER_VALIDATE_BOOLEAN ) === true );

	$modern_description_heading = get_field( 'modern_description_heading', $post );
	$modern_description_copy = get_field( 'modern_description_copy', $post );
	$modern_description_image = get_field( 'modern_description_image', $post );
	$modern_description_image_alt = get_field( 'modern_description_image_alt', $post );

	if ( ! empty( $modern_description_heading ) && ! empty( $modern_description_copy ) ):
?>
	<section aria-label="Program description and highlights">
		<div class="container py-lg-3 my-lg-5">
			<div class="row">
				<div class="col">
					<?php if( $modern_description_heading ) : ?>
						<h2 class="font-weight-light mb-4">
							<?php echo $modern_description_heading; ?>
						</h2>
					<?php endif; ?>

					<?php if( $modern_description_copy ) : ?>
						<?php echo $modern_description_copy; ?>
					<?php endif; ?>

					<?php
					echo get_degree_request_info_button(
						$post,
						'btn btn-complementary mt-3',
						'',
						'Request Information'
					);
					?>
				</div>

				<?php if ( $modern_description_image || ( have_rows( 'highlights', $post ) ) ): ?>
				<div class="col-lg-6 pl-lg-5 mt-5 mt-lg-0">
					<?php if ( $modern_description_image ) : ?>
						<div class="px-5 px-lg-0 text-center">
							<img src="<?php echo $modern_description_image; ?>" class="img-fluid mb-5" alt="<?php echo $modern_description_image_alt; ?>">
						</div>
					<?php endif; ?>

					<?php if ( have_rows( 'highlights', $post ) ) : ?>
						<h3 class="heading-underline mb-4 pb-2">Highlights</h3>
						<?php while( have_rows( 'highlights', $post ) ): the_row(); ?>
							<div class="row mb-4">
								<div class="col-3 text-center">
									<img src="<?php the_sub_field( 'highlight_image' ); ?>" class="img-fluid" alt="">
								</div>
								<div class="col-9 align-self-center">
									<?php the_sub_field( 'highlight_copy' ); ?>
								</div>
							</div>
						<?php endwhile; ?>
					<?php endif; ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php
	endif;
endif;
