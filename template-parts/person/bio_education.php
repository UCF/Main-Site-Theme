<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'person' ) :
	$biography = trim( apply_filters( 'the_content', $post->post_content ) );
	$education = get_field( 'person_degrees', $post );

	if ( $biography || $education ) :
		$aria_labelledby = '';
		if ( $biography ) $aria_labelledby .= 'biography-heading ';
		if ( $education ) $aria_labelledby .= 'education-heading ';
		$aria_labelledby = trim( $aria_labelledby );

		$left_col_class  = 'col-lg-4 pr-lg-5 pull-lg-8 mt-5 mt-lg-0';
		$right_col_class = 'col-lg-8 push-lg-4';
?>
	<section id="person-description" aria-labelledby="<?php echo $aria_labelledby; ?>">
		<div class="jumbotron jumbotron-fluid bg-secondary mb-0">
			<div class="container">
				<div class="row">
					<?php if ( $biography ) : ?>
					<div class="<?php echo $right_col_class; ?>">
						<h2 id="biography-heading" class="sr-only">Biography</h2>
						<?php
						// TODO add "view more" button for -xs-sm
						echo $biography;
						?>
					</div>
					<?php endif; ?>

					<?php
					if ( $education ) :
						$education_col = $biography ? $left_col_class : $right_col_class;
					?>
					<div class="<?php echo $education_col; ?>">
						<h2 class="h6 text-uppercase text-default mb-4" id="education-heading">Education</h2>
						<ul class="list-unstyled">
						<?php
						foreach ( $education as $degree ) :
							$degree_title = $degree['role_name'];

							// Require base degree title before displaying anything else:
							if ( $degree_title ) :
								$institution = $degree['institution_name'];
								$start_date  = $degree['start_date'];
								$end_date    = $degree['end_date'];
								$department  = $degree['department_name'];

								if ( $department ) $degree_title .= ', ' . $department;
								if ( $start_date ) $start_date = date( 'Y', strtotime( $start_date ) );
								if ( $end_date ) $end_date = date( 'Y', strtotime( $end_date ) );

								$date_range = implode( '-', array_filter( array_unique( array( $start_date, $end_date ) ) ) );
								$degree_subtitle = implode( ', ', array_filter( array( $institution, $date_range ) ) );
						?>
							<li class="mb-3">
								<strong class="d-block"><?php echo $degree_title; ?></strong>
								<?php echo $degree_subtitle; ?>
							</li>
						<?php
							endif;
						endforeach;
						?>
						</ul>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
<?php
	endif;
endif;
