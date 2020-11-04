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
	$has_duration          = ( $program_length_image && $program_length_number && $program_length_text );

	$tuition             = get_degree_tuition_markup( $post_meta );

	$badges              = get_degree_badges( $post );
	$badge_1             = $badges[0] ?? null;
	$badge_2             = $badges[1] ?? null;

	$details_col_classes = 'pr-lg-4 pr-xl-5 mb-4 mb-lg-0 col';
	if ( $tuition ) {
		// Set a fixed column size at -lg+ when tuition is available.
		// (Otherwise, this column will effectively calculate out to
		// a col-lg-6)
		$details_col_classes .= ' col-lg-5';

		if ( $has_duration ) {
			// If program duration info is present, make even more room at -xl+
			$details_col_classes .= ' col-xl-6';
		} else if ( $badge_2 ) {
			// If there's no program duration info, but there are two badges,
			// shrink this column at -xl to allow badges to sit on one line
			$details_col_classes .= ' col-xl-4';
		}
	}
?>
<section id="program-at-a-glance" aria-labelledby="program-at-a-glance-heading">
	<div class="jumbotron jumbotron-fluid bg-faded pb-4 pb-md-5 mb-0">
		<div class="container">
			<div class="row">

				<div class="<?php echo $details_col_classes; ?>">
					<h2 id="program-at-a-glance-heading" class="h4 font-condensed text-uppercase mb-4 pb-sm-2">
						Program at a Glance
					</h2>
					<div class="row">
						<div class="col">
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
						<?php if ( $has_duration ): ?>
						<div class="col-auto mb-4 mb-lg-0 px-lg-4">
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
				<div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
					<?php echo $tuition; ?>
				</div>
				<?php endif; ?>

				<?php if ( $badges ): ?>
				<div class="col-md d-flex flex-row mb-4 mb-lg-0 pl-lg-4">
					<div class="degree-badges">
						<?php if ( $badge_1 ) : ?>
						<div class="degree-badge-col">
							<img src="<?php echo $badge_1['url']; ?>" alt="<?php echo $badge_1['alt']; ?>" class="degree-badge">
						</div>
						<?php endif; ?>

						<?php if ( $badge_2 ) : ?>
						<div class="degree-badge-col">
							<img src="<?php echo $badge_2['url']; ?>" alt="<?php echo $badge_2['alt']; ?>" class="degree-badge">
						</div>
						<?php endif; ?>
					</div>
				</div>
				<?php endif; ?>

			</div>
		</div>
	</div>
</section>
<?php endif; ?>
