<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' ) :
	$program_type        = get_degree_program_type( $post );
	$raw_postmeta        = get_post_meta( $post->ID );
	$post_meta           = format_raw_postmeta( $raw_postmeta );

	$colleges_list       = get_colleges_markup( $post->ID );
	$departments_list    = get_departments_markup( $post->ID );

	$program_length_image  = get_field( 'program_length_image', $post );
	$program_length_number = get_field( 'program_length_number', $post );
	$program_length_text   = get_field( 'program_length_text', $post );

	$tuition             = get_degree_tuition_markup( $post_meta );

	$promo_image         = get_field( 'promo_image', $post );
	$promo_image_alt     = get_field( 'promo_image_alt', $post );
?>
<section aria-label="Program at a glance">
	<div class="jumbotron jumbotron-fluid bg-faded pb-4 pb-md-5">
		<div class="container">
			<div class="row d-lg-flex justify-content-lg-between">
				<div class="col col-lg-5 pr-lg-5">
					<h2 class="h4 font-condensed text-uppercase mb-4 pb-lg-2">Program at a Glance</h2>
					<div class="row">
						<div class="col col-sm-9 col-lg mb-4 mb-lg-0">
							<dl>
								<?php if ( $program_type ) : ?>
								<dt class="h6 text-uppercase text-default">Program</dt>
								<dd class="h5 mb-4"><?php echo $program_type->name; ?></dd>
								<?php endif; ?>

								<?php if ( $colleges_list ) : ?>
								<dt class="h6 text-uppercase text-default">College(s)</dt>
								<dd class="h5 mb-4"><?php echo $colleges_list; ?></dd>
								<?php endif; ?>

								<?php if ( $departments_list ) : ?>
								<dt class="h6 text-uppercase text-default">Department(s)</dt>
								<dd class="h5"><?php echo $departments_list; ?></dd>
								<?php endif; ?>
							</dl>
						</div>
						<?php if ( $program_length_image && $program_length_number && $program_length_text ) : ?>
							<div class="col-auto pr-5 pr-sm-3 mb-4 mb-lg-0 text-center align-self-center">
								<div class="text-center mb-3">
									<img class="program-length-image img-fluid" src="<?php echo $program_length_image; ?>" alt="">
								</div>
								<div class="h1 mb-0 text-center"><?php echo $program_length_number; ?></div>
								<div class="h6 text-default text-uppercase text-center"><?php echo $program_length_text; ?></div>
							</div>
						<?php endif; ?>
					</div>
				</div>

				<div class="w-100 hidden-sm-down hidden-lg-up"></div>

				<?php if ( $tuition ): ?>
				<div class="col-md-7 col-lg mb-4 mb-lg-0 pr-lg-4 pr-xl-3">
					<?php echo $tuition; ?>
				</div>
				<?php endif; ?>

				<?php if ( $promo_image ) : ?>
				<div class="col-md-5 col-lg-2 col-xl-3 mb-4 mb-lg-0 text-center d-flex align-items-center">
					<div class="row no-gutters w-100">
						<div class="col-6 offset-3 col-sm-4 offset-sm-4 col-md-8 offset-md-2 col-lg-12 offset-lg-0 col-xl-10 offset-xl-1">
							<img src="<?php echo $promo_image; ?>" class="img-fluid" alt="<?php echo $promo_image_alt; ?>">
						</div>
					</div>
				</div>
				<?php endif; ?>

			</div>
		</div>
	</div>
</section>
<?php endif; ?>
